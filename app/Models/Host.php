<?php

namespace App\Models;

use App\Models\MyModel;
use App\Models\HostAvailable;

class Host extends MyModel
{
    /**
     * @var string
     */
    protected $table = 'logements';

    /**
     * @var array
     */
    protected $casts = [
        'address' => 'encrypted',
        'cellphone' => 'encrypted',
        'cellphone2' => 'encrypted',
        'city' => 'encrypted',
        'email' => 'encrypted',
        'email2' => 'encrypted',
        'firstname' => 'encrypted',
        'firstname2' => 'encrypted',
        'lastname' => 'encrypted',
        'lastname2' => 'encrypted',
        'phonenumber' => 'encrypted',
        'zipcode' => 'encrypted',
    ];

    // Get
    protected function getHosts($semester = null)
    {
        // Get available hosts
        $semester = $semester ?? session('semester');

        $hosts_available = new HostAvailable();
        $hosts_ids = $hosts_available->getIds($semester);

        return $this->whereIn('id', $hosts_ids)->get();
    }
}
