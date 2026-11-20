<?php

namespace App\Models;

use App\Models\MyModel;

class UnivReg3 extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'univ_reg3s';
    protected $fillable = ['student', 'semester', 'university'];

    /**
     * @var array
     */
    protected $casts = [
        'university' => 'encrypted',
    ];
}
