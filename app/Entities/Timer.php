<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Timer extends Entity
{
    protected $attributes = [
        'holiday'      => null,
        'sickday'      => null,
        'in'         => null,
        'out'        => null,
        'total'      => null,
    ];
}
