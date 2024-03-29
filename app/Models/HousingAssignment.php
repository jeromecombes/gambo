<?php

namespace App\Models;

use App\Models\MyModel;

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
            ->addSelect(array(
                'students.id as id',
                'students.lastname as lastname',
                'students.firstname as firstname',
            ));
    }

    public function getHostAttribute($value)
    {
        return $this->logement;
    }

    public function getLastnameAttribute($value)
    {
        return $this->decrypt($value, false);
    }

    public function getFirstnameAttribute($value)
    {
        return $this->decrypt($value, false);
    }

    public function getStudentnameAttribute()
    {
        return $this->lastname.' '.$this->firstname;
    }

}
