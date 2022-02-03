<?php

namespace App\Controllers;

class Month extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $year = isset($_GET["year"]) ? $_GET["year"] : $this->now->getYear();
        $month = isset($_GET["month"]) ? $_GET["month"] : $this->now->getMonth();
        if (isset($this->data['user'])) {
            $this->data["timers"] = $this->timerModel->get_timers($year, $month, $this->data['user']['id']);
            $this->data["last_action"] = $this->timerModel->get_last_action($this->data["user"]["id"]);
        } else {
            return redirect()->to("/login");
        }
        return view("month", $this->data);
    }

    function action()
    {
        $action = $this->request->getVar('action');
        $time = $this->now->toTimeString();
        $this->timerModel->add_time(
            $this->now->getDay(),
            $this->now->getMonth(),
            $this->now->getYear(),
            $time,
            $action,
            $this->data['user']['id']
        );
        echo "$action: $time";
    }
}
