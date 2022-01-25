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
        'timers'       => array("in" => array(), "out" => array()),
        'total'  => 0,
        'created_at'  => 0,
    ];


    public function setCreatedAt($time)
    {
        $this->attributes['created_at'] = $time;
        return $this;
    }

    public function addTimer($time, $action)
    {
        $this->attributes['timers'][$action] = array($time);
        return $this;
    }
}
