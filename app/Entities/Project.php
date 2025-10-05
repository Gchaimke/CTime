<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Project extends Entity
{

    protected $attributes = [
        'id'         => null,
        "project_name" => null,
        'users'  => array(),
        'managers'      => array(),
        'password'   => null,
        'timers'       => array(),
        'total'  => 0,
        'is_started'  => false,
        'created_at'  => null,
        'total_payed' => 0,
    ];
}
