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
            return redirect()->to("/user/login");
        }
        return view("home", $this->data);
    }
}
