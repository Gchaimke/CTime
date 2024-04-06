<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        if (!isset($this->data["user"])) {
            return redirect()->to("/login");
        }
        return view("home", $this->data);
    }

    public function register()
    {
        return view("register", $this->data);
    }
}
