<?php

namespace App\Controllers;

class User extends BaseController
{

    public function index()
    {
        if (!isset($this->data["user"])) {
            return redirect()->to("/login");
        }
        return view("user", $this->data);
    }

    public function timers()
    {
        $year = isset($_GET["year"]) ? $_GET["year"] : date("y");
        $month = isset($_GET["month"]) ? $_GET["month"] : date("m");
        $this->data["timers"] = $this->timeModel->get_timers($year, $month, $this->data['user']['id']);
        return view("timers", $this->data);
    }

    function action()
    {
        $action = $this->request->getVar('action');
        $time = date("H:i");
        $this->timeModel->add_time(date("d"), date("m"), date("y"), $time, $action, $this->data['user']['id']);
        echo "$action: $time";
    }
}
