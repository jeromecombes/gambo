<?php

namespace App\Models;

use App\Models\MyModel;

class UnivCourse extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'courses_univ4';

    /**
     * @var array
     */
    protected $fillable = [
        'lien',
        'semester',
        'student',
        'lock'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'code' => 'encrypted',
        'debut' => 'encrypted',
        'discipline' => 'encrypted',
        'email' => 'encrypted',
        'day' => 'encrypted',
        'fin' => 'encrypted',
        'institution' => 'encrypted',
        'institutionAutre' => 'encrypted',
        'modalites' => 'encrypted',
        'modalites1' => 'encrypted',
        'modalites2' => 'encrypted',
        'niveau' => 'encrypted',
        'nom' => 'encrypted',
        'prof' => 'encrypted',
        'type' => 'encrypted',
    ];

    // Get
    public function getNameAttribute($value)
    {
        return $this->nom;
    }

    public function getStartAttribute($value)
    {
        return $this->debut;
    }

    public function getEndAttribute($value)
    {
        return $this->fin;
    }

    public function getProfessorAttribute($value)
    {
        return $this->prof;
    }

    public function getNoteAttribute($value)
    {
        if ($value == 0 or $value == 2) {
            return 'No';
        }

        if ($value == 1) {
            return 'Yes';
        }

        return $value;
    }

    // Set
    public function setNoteAttribute($value)
    {
        if ($value == 'Yes') {
            $value = 1;
        } elseif ($value == 'No') {
            $value = 2;
        } else {
            $value = 0;
        }

        $this->attributes['note'] = $value;
    }

    // Links
    public function links()
    {
        return $this->hasMany(UnivCourse::class, 'lien', 'id');
    }

    public function linkedTo()
    {
        return $this->belongsTo(UnivCourse::class, 'lien', 'id');
    }

}
