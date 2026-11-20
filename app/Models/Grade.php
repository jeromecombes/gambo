<?php

namespace App\Models;

use App\Models\MyModel;

class Grade extends MyModel
{

    /**
     * @var array
     */
    protected $fillable = ['course', 'course_id', 'semester', 'student', 'lock'];

    /**
     * @var array
     */
    protected $casts = [
        'date1' => 'encrypted',
        'date2' => 'encrypted',
        'grade' => 'encrypted',
        'grade1' => 'encrypted',
        'grade2' => 'encrypted',
        'note' => 'encrypted',
    ];
}
