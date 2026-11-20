<?php

namespace App\Models;

use App\Models\MyModel;

class Housing extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'housing';

    /**
     * @var array
     */
    protected $casts = [
        'response' => 'encrypted',
    ];
}
