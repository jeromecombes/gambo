<?php

namespace App\Models;

use App\Models\MyModel;
use Illuminate\Support\Facades\Crypt;

class Student extends MyModel
{
    /**
     * @var array
     */
    protected $casts = [
        'cellphone' => 'encrypted',
        'citizenship1' => 'encrypted',
        'citizenship2' => 'encrypted',
        'city' => 'encrypted',
        'contactemail' => 'encrypted',
        'contactfirst' => 'encrypted',
        'contactlast' => 'encrypted',
        'contactmobile' => 'encrypted',
        'contactphone' => 'encrypted',
        'country' => 'encrypted',
        'countryOB' => 'encrypted',
        'email' => 'encrypted',
        'firstname' => 'encrypted',
        'frenchNumber' => 'encrypted',
        'frenchphone' => 'encrypted',
        'gender' => 'encrypted',
        'home_institution' => 'encrypted',
        'lastname' => 'encrypted',
        'logement' => 'encrypted',
        'placeOB' => 'encrypted',
        'relationship' => 'encrypted',
        'resultatTCF' => 'encrypted',
        'state' => 'encrypted',
        'street' => 'encrypted',
        'university2' => 'encrypted',
        'univreg' => 'encrypted',
        'whatsapp' => 'encrypted',
        'zip' => 'encrypted',
    ];

    // Get

    public function getAddressAttribute($value)
    {
        $tab = [];

        if ($this->street) {
            $tab[] = $this->street;
        }
        if ($this->city) {
            $tab[] = $this->city;
        }
        if ($this->state) {
            $tab[] = $this->state;
        }
        if ($this->country) {
            $tab[] = $this->country;
        }

        $address = join(", ",$tab);

        return $address;
    }

    public function getDobAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        $dob = new \DateTime(Crypt::decryptString($value));

        return $dob->format('M d, Y');
    }

    public function getDayAttribute($value)
    {
        if (!$this->dob) {
            return null;
        }

        $dob = new \DateTime($this->dob);

        return $dob->format('d');
    }

    public function getDisplayNameAttribute($value)
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getMonthAttribute($value)
    {
        if (!$this->dob) {
            return null;
        }

        $dob = new \DateTime($this->dob);

        return $dob->format('n');
    }

    public function getYearAttribute($value)
    {
        if (!$this->dob) {
            return null;
        }

        $dob = new \DateTime($this->dob);

        return $dob->format('Y');
    }

    public function getNewSemesterAttribute($value)
    {
        $year = intval(substr($this->semesters[0], -4));
        $semester = preg_match('/Fall/', $this->semesters[0]) ? 'Spring ' . ($year + 1) : 'Fall ' . $year;
        return $semester;
    }

    public function getNewSemesterCheckedAttribute($value)
    {
        $checked = in_array($this->newSemester, $this->semesters);
        return $checked;
    }

    public function getSemestersAttribute($value)
    {
        $semesters = unserialize($value);
        sort($semesters);
        return $semesters;
    }

    // Set

    public function setDobAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['dob'] = null;
            return;
        }

        $dob = new \DateTime($value);
        $dob = $dob->format('Y-m-d');

        $this->attributes['dob'] = Crypt::encryptString($dob);
    }

    public function setSemestersAttribute($value)
    {
        $this->attributes['semesters'] = serialize($value);
    }

    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = md5($value);
    }

    //

    public function scopeWithUniv_reg($query)
    {
        $query->leftjoin('univ_reg3s', 'univ_reg3s.student', '=', 'students.id')
            ->addSelect('univ_reg3s.university as univreg');
    }

    public static function findMine($fields = null)
    {
        $user = auth()->user();

        $semester = session('semester');

        if ($user->university == 'VWPP') {
            $students = self::where('semesters', 'like', "%$semester%")->get();
        } else {
            $students = self::where('semesters', 'like', "%$semester%")
                ->where('university', $user->university)
                ->get();
        }

        if (is_string($fields)) {
            $tab = [];
            foreach ($students as $student) {
                $tab[] = $student->$fields;
            }
            return $tab;
        }

        return $students;
    }
}
