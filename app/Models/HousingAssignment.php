<?php

namespace App\Models;

use App\Models\MyModel;
use Illuminate\Support\Facades\Crypt;

class HousingAssignment extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'housing_affect';
    protected $fillable = ['student', 'semester', 'logement'];

    public function scopeWithStudents($query)
    {
        $query->leftjoin('students', 'students.id', '=', 'housing_affect.student')
            ->addSelect([
                'students.id as id',
                'students.lastname as lastname',
                'students.firstname as firstname',
            ]);
    }

    public function getHostAttribute($value)
    {
        return $this->logement;
    }

    public function getLastnameAttribute($value)
    {
        return $value === null ? $value : Crypt::decryptString($value);
    }

    public function getFirstnameAttribute($value)
    {
        return $value === null ? $value : Crypt::decryptString($value);
    }

    public function getStudentnameAttribute()
    {
        return $this->lastname.' '.$this->firstname;
    }

    public function std()
    {
        return $this->hasOne(Student::class, 'id', 'student');
    }

}
