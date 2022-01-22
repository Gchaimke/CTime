<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        if (!isset($this->data["user"]) || $this->data["user"]['role'] != "admin") {
            return redirect()->to("/login");
        }
        $this->data["users"] = $this->userModel->findAll();
        return view("admin", $this->data);
    }
}
