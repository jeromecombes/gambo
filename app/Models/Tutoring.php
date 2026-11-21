<?php

namespace App\Models;

use App\Models\MyModel;
use Illuminate\Support\Facades\Crypt;

class Tutoring extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'tutorat';

    /**
     * @var array
     */
    protected $fillable = ['semester', 'student', 'lock'];

    /**
     * @var array
     */
    protected $casts = [
        'day' => 'encrypted',
        'end' => 'encrypted',
        'start' => 'encrypted',
        'tuteur' => 'encrypted',
    ];

    // Get
    public function getNameAttribute()
    {
        return 'Tutoring';
    }

    public function getTypeAttribute()
    {
        return 'Tutoring';
    }

    public function getProfessorAttribute($value)
    {
        return $this->tuteur;
    }

    public function getTutorAttribute($value)
    {
        return $this->tuteur;
    }

    // Set
    public function setTutorAttribute($value)
    {
        $this->attributes['tuteur'] = $value === null ? $value : Crypt::encryptString($value);
    }
}
