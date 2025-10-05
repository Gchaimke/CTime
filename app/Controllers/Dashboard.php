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
        $this->data['projects'] = [];
        $projects = $this->projectModel->whereInArray("users", $this->data['user']['id']);
        foreach ($projects as $project) {
            $this->data['projects'][$project->id] = $project;
            $project->total = count_total((array)$project->timers);
        }
        // debug($this->data, true, true);
        return view("dashboard/view", $this->data);
    }

    public function register()
    {
        return view("register", $this->data);
    }
}
