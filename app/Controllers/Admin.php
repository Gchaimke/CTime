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
        $this->data["last_action"] = $this->timeModel->get_last_action($this->data["user"]["id"]);
        return view("admin", $this->data);
    }
}
