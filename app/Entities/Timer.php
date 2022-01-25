<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Timer extends Entity
{
    protected $attributes = [
        'holiday'      => null,
        'sickday'      => null,
        'in'         => array(),
        'out'        => array(),
        'total'      => 0,
        'is_started'  => false,
    ];
}
