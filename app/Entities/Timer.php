<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Timer extends Entity
{
    protected $attributes = [
        'in'         => null,
        'out'        => null,
        'total'      => null,
    ];
}
