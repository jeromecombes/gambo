<?php

namespace App\Models;

use App\Models\MyModel;

class UnivReg extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'univ_reg';

    /**
     * @var array
     */
    protected $casts = [
        'response' => 'encrypted',
    ];
}
