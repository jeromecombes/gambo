<?php

namespace App\Models;

use App\Models\MyModel;
use Illuminate\Support\Facades\Crypt;

class Internship extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'stages';

    /**
     * @var array
     */
    protected $fillable = ['internship', 'semester', 'student', 'lock'];

    /**
     * @var array
     */
    protected $casts = [
        'notes' => 'encrypted',
        'stage' => 'encrypted',
    ];

    // Get
    public function getNameAttribute($value)
    {
        return $this->stage;
    }

    // Set
    public function setNameAttribute($value)
    {
        $this->attributes['stage'] = $value === null ? $value : Crypt::encryptString($value);
    }
}
