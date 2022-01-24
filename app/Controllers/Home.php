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
        $this->data["last_action"] = $this->timerModel->get_last_action($this->data["user"]["id"]);
        return view("home", $this->data);
    }
}
