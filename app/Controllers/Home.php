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
        $user = array(
            "view_name" => "Chaim",
            "username" => "admin",
            "email" => "admin@email.com",
            "role" => "admin",
            "password" => "Sdrm1415",
        );
        $this->userModel->add_user($user);
        $year = isset($_GET["year"]) ? $_GET["year"] : date("y");
        $month = isset($_GET["month"]) ? $_GET["month"] : date("m");
        $this->data["timers"] = $this->get_timers($year, $month);
        $this->add_time("10", $month, $year, "10:35", "in");
        return view("home", $this->data);
    }

    private function get_timers($year, $month)
    {
        $timers_file =  DATAPATH . "timers/$year/$month/{$this->data['user']['id']}.json";
        if (file_exists($timers_file)) {
            return json_decode(file_get_contents($timers_file), true);
        } else {
            return array();
        }
    }

    private function put_timers($timers_file, $data)
    {
        ksort($data);
        return file_put_contents($timers_file, json_encode($data));
    }

    public function add_time($day, $month, $year, $time, $action)
    {
        $timers_file =  DATAPATH . "timers/$year/$month/{$this->data['user']['id']}.json";
        $timers = $this->get_timers($year, $month);
        $date = "$day/$month/$year";
        $timers[$date][$action][] = $time;
        $this->put_timers($timers_file, $timers);
    }
}
