<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        if (!isset($this->data["user"])) {
            return redirect()->to("/login");
        }
        $this->data["projects"] = $this->projectModel->whereInArray("users", $this->data['user']['id']);
        if ($this->data["projects"]) {
            foreach ($this->data["projects"] as $project) {
                if ($project->is_started) {
                    $project_timers = (array)$project->timers;
                    $project_timers["out"][] = $this->now;
                    $project->timers->out = $project_timers["out"];
                    $total = count_total((array)$project->timers);
                    $this->data["active_project_time"] = $total;
                }
            }
        }
        return view("dashboard/view", $this->data);
    }

    public function register()
    {
        return view("register", $this->data);
    }
}
