<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EncryptUsersLastnameFirstname extends Migration
{
    /**
     * Encrypt a value with the legacy AES-128-CTR scheme (kept for fresh installs).
     *
     * @param  string|null $string
     * @param  mixed $key
     * @return string|null
     */
    private function legacyEncrypt($string, $key = null)
    {
        if ($string === null) {
            return null;
        }

        $enc_method = 'AES-128-CTR';
        $enc_key = openssl_digest($key . getenv('APP_KEY2'), 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($enc_method));

        return openssl_encrypt($string, $enc_method, $enc_key, 0, $enc_iv) . '::' . bin2hex($enc_iv);
    }

    /**
     * Decrypt a value encrypted with the legacy AES-128-CTR scheme.
     *
     * @param  string|null $crypted_token
     * @param  mixed $key
     * @return string|false|null
     */
    private function legacyDecrypt($crypted_token, $key = null)
    {
        if ($crypted_token === null) {
            return null;
        }

        $decrypted_token = false;

        if (preg_match("/^(.+)::([0-9a-f]+)$/", $crypted_token, $regs)) {
            $enc_method = 'AES-128-CTR';
            $enc_key = openssl_digest($key . getenv('APP_KEY2'), 'SHA256', TRUE);
            $decrypted_token = openssl_decrypt($regs[1], $enc_method, $enc_key, 0, hex2bin($regs[2]));
        }

        return $decrypted_token;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->mediumtext('firstname')->change();
            $table->mediumtext('lastname')->change();
        });

        DB::table('users')->orderBy('id')->chunk(100, function($users) {
            foreach ($users as $user) {

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'firstname' => $this->legacyEncrypt($user->firstname),
                        'lastname' => $this->legacyEncrypt($user->lastname),
                        'name' => null,
                    ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname', 50)->change();
            $table->string('lastname', 50)->change();
        });

        DB::table('users')->orderBy('id')->chunk(100, function($users) {
            foreach ($users as $user) {

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'firstname' => $this->legacyDecrypt($user->firstname),
                        'lastname' => $this->legacyDecrypt($user->lastname),
                    ]);
            }
        });
    }
}
