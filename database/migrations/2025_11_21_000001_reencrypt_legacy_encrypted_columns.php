<?php

use App\Helpers\LegacyEncryption;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ReencryptLegacyEncryptedColumns extends Migration
{
    /**
     * Columns of the students table encrypted with the row id as key.
     *
     * @var array
     */
    private $students_keyed_by_id = [
        'cellphone',
        'citizenship1',
        'citizenship2',
        'city',
        'contactemail',
        'contactfirst',
        'contactlast',
        'contactmobile',
        'contactphone',
        'country',
        'countryOB',
        'dob',
        'frenchNumber',
        'frenchphone',
        'gender',
        'home_institution',
        'logement',
        'placeOB',
        'relationship',
        'resultatTCF',
        'state',
        'street',
        'university2',
        'univreg',
        'whatsapp',
        'zip',
    ];

    /**
     * Tables and columns encrypted with a null key.
     *
     * @var array
     */
    private $null_key_columns = [
        'students' => ['email', 'firstname', 'lastname'],
        'users' => ['firstname', 'lastname'],
        'logements' => [
            'lastname',
            'lastname2',
            'firstname',
            'firstname2',
            'address',
            'zipcode',
            'city',
            'cellphone',
            'cellphone2',
            'phonenumber',
            'email',
            'email2',
        ],
        'tutorat' => ['tuteur', 'day', 'start', 'end'],
        'documents' => ['firstname', 'lastname'],
        'courses' => [
            'code',
            'day',
            'debut',
            'fin',
            'nom',
            'professor',
            'title',
            'univ',
        ],
        'courses_univ4' => [
            'code',
            'day',
            'debut',
            'discipline',
            'email',
            'fin',
            'institution',
            'institutionAutre',
            'modalites',
            'modalites1',
            'modalites2',
            'niveau',
            'nom',
            'prof',
            'type',
        ],
    ];

    /**
     * Tables and columns encrypted with the student id as key.
     *
     * @var array
     */
    private $student_keyed_columns = [
        'housing' => ['response'],
        'stages' => ['stage', 'notes'],
        'univ_reg' => ['response'],
        'univ_reg2' => ['response'],
        'univ_reg3s' => ['university'],
        'evaluations' => ['response'],
        'grades' => ['date1', 'date2', 'grade', 'grade1', 'grade2', 'note'],
    ];

    /**
     * Re-encrypt every legacy AES-128-CTR value with Laravel Crypt.
     * Values already encrypted with Crypt contain no "::" separator and are skipped,
     * which makes the migration safe to re-run.
     *
     * @return void
     */
    public function up()
    {
        $this->requireAdequateColumnSizes();

        $this->reencrypt('students', 'id', $this->students_keyed_by_id);

        foreach ($this->null_key_columns as $table => $columns) {
            $this->reencrypt($table, null, $columns);
        }

        foreach ($this->student_keyed_columns as $table => $columns) {
            $this->reencrypt($table, 'student', $columns);
        }
    }

    /**
     * The legacy AES-128-CTR format cannot be restored from Crypt ciphertexts.
     *
     * @return void
     */
    public function down()
    {
    }

    /**
     * Abort when a target column is too small to hold a Crypt ciphertext
     * (~230-260 chars for short values vs ~80 for the legacy format).
     * Widened columns make the re-encryption safe regardless of SQL mode.
     *
     * @return void
     *
     * @throws RuntimeException
     */
    private function requireAdequateColumnSizes()
    {
        if (! in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'])) {
            return;
        }

        $tables = $this->encryptedTableColumns();

        $rows = DB::select(
            'SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH AS max_length
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()'
        );

        $offending = [];

        foreach ($rows as $row) {
            if (! isset($tables[$row->TABLE_NAME]) || ! in_array($row->COLUMN_NAME, $tables[$row->TABLE_NAME])) {
                continue;
            }

            if (in_array($row->DATA_TYPE, ['tinytext', 'tinyblob', 'char'])) {
                $offending[] = "{$row->TABLE_NAME}.{$row->COLUMN_NAME} ({$row->DATA_TYPE})";
            } elseif (in_array($row->DATA_TYPE, ['varchar', 'varbinary']) && (int) $row->max_length < 300) {
                $offending[] = "{$row->TABLE_NAME}.{$row->COLUMN_NAME} ({$row->DATA_TYPE}({$row->max_length}))";
            }
        }

        if ($offending !== []) {
            throw new RuntimeException(
                'Encrypted columns too small to hold Crypt ciphertexts: '
                . implode(', ', $offending)
                . '. Widen them (e.g. ALTER TABLE ... MODIFY column mediumtext) before re-encrypting.'
            );
        }
    }

    /**
     * All target tables with their encrypted columns.
     *
     * @return array
     */
    private function encryptedTableColumns()
    {
        $tables = $this->null_key_columns;

        foreach ($this->student_keyed_columns as $table => $columns) {
            $tables[$table] = array_merge($tables[$table] ?? [], $columns);
        }

        $tables['students'] = array_merge($tables['students'] ?? [], $this->students_keyed_by_id);

        return $tables;
    }

    /**
     * Decrypt legacy values and store them encrypted with Laravel Crypt.
     *
     * @param  string $table
     * @param  string|null $keyColumn
     * @param  array $columns
     * @return void
     */
    private function reencrypt(string $table, ?string $keyColumn, array $columns)
    {
        DB::table($table)->orderBy('id')->chunk(500, function ($rows) use ($table, $keyColumn, $columns) {
            foreach ($rows as $row) {
                $updates = [];

                foreach ($columns as $column) {
                    $value = $row->{$column} ?? null;

                    if ($value === null || $value === '' || ! preg_match("/^(.+)::([0-9a-f]+)$/", $value)) {
                        continue;
                    }

                    $key = $keyColumn === null ? null : $row->{$keyColumn};
                    $plain = LegacyEncryption::decrypt($value, $key);

                    if ($plain === false) {
                        continue;
                    }

                    $updates[$column] = Crypt::encryptString($plain);
                }

                if ($updates !== []) {
                    DB::table($table)->where('id', $row->id)->update($updates);
                }
            }
        });
    }
}
