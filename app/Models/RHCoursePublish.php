<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RHCoursePublish extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'courses_rh2';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['semester', 'student'];
}
