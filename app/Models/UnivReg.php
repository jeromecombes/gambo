<?php

namespace App\Models;

use App\Models\MyModel;

class UnivReg extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'univ_reg';

    // Get
    public function getResponseAttribute($value)
    {
        return $this->decrypt($value, $this->student);
    }

    // Set
    public function setResponseAttribute($value)
    {
        $this->attributes['response'] = $this->encrypt($value, $this->student);
    }

}
