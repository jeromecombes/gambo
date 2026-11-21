<?php

namespace App\Models;

use App\Models\MyModel;
use Illuminate\Support\Facades\Crypt;

class RHCourse extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'courses';

    /**
     * @var array
     */
    protected $fillable = ['type', 'semester'];

    /**
     * @var array
     */
    protected $casts = [
        'code' => 'encrypted',
        'day' => 'encrypted',
        'debut' => 'encrypted',
        'fin' => 'encrypted',
        'nom' => 'encrypted',
        'professor' => 'encrypted',
        'title' => 'encrypted',
        'univ' => 'encrypted',
    ];

    // Get
    public function getNameAttribute($value)
    {
        return $this->title;
    }

    public function getStartAttribute($value)
    {
        return $this->debut;
    }

    public function getEndAttribute($value)
    {
        return $this->fin;
    }

    // Set
    public function setStartAttribute($value)
    {
        $this->attributes['debut'] = $value === null ? $value : Crypt::encryptString($value);
    }

    public function setEndAttribute($value)
    {
        $this->attributes['fin'] = $value === null ? $value : Crypt::encryptString($value);
    }
}
