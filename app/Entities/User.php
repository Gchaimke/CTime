<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class User extends Entity
{

    protected $attributes = [
        'id'         => null,
        "company" => "CTime",
        'username'   => null,
        'view_name'  => null,
        'email'      => null,
        'password'   => null,
        'role'       => 'user',
        'timezone'  => 'Asia/Jerusalem',
        'language'   => 'en_US',
        'register_string' => null,
        'register_status' => false,
        'created_at' => null,
        'updated_at' => null,
    ];

    public function setPassword(string $pass)
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);
        return $this;
    }

    public function setCreatedAt(string $dateString)
    {
        $this->attributes['created_at'] = new Time($dateString, 'UTC');
        return $this;
    }

    public function setLanguage(string $language)
    {
        $this->attributes['language'] = $language;
        return $this;
    }

    public function setTimezone(string $timezone)
    {
        $this->attributes['timezone'] = $timezone;
        return $this;
    }

    public function setRegisterString()
    {
        $this->attributes['register_string'] = mt_rand(10000, 99999);
        return $this;
    }

    public function getCreatedAt(string $format = 'Y-m-d H:i:s')
    {
        // Convert to CodeIgniter\I18n\Time object
        $this->attributes['created_at'] = $this->mutateDate($this->attributes['created_at']);
        $timezone = $this->attributes['timezone'] ?? app_timezone();
        $this->attributes['created_at']->setTimezone($timezone);
        return $this->attributes['created_at']->format($format);
    }
}
