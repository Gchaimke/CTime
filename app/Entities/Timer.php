<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Timer extends Entity
{
    protected $attributes = [
        'holiday'      => null,
        'sick_day'      => null,
        'in'         => array(),
        'out'        => array(),
        'total'      => 0,
        'is_started'  => false,
    ];
}
