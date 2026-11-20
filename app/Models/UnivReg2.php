<?php

namespace App\Models;

use App\Models\MyModel;

class UnivReg2 extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'univ_reg2';

    /**
     * @var array
     */
    protected $casts = [
        'response' => 'encrypted',
    ];
}
