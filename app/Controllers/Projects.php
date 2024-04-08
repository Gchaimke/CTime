<?php

namespace App\Controllers;

class Projects extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
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
        return view("projects/view", $this->data);
    }

    function action_project()
    {
        $project = array(
            "action" => $this->request->getVar('action'),
            "project_name" => $this->request->getVar('project_name'),
            "project_id" => $this->request->getVar('project_id'),
            "user_id" => $this->data['user']['id'],
            "time" => $this->now->toDateTimeString(),
        );

        if ($project["action"] == "new_project") {
        } else {
            $response = $this->projectModel->add_time($project);
            if (!$response) {
                echo "Error: Can't add time to project.";
            }
        }
    }

    public function add_project()
    {
        $project = array(
            "project_name" => $this->request->getVar('project_name'),
            "user_id" => $this->data['user']['id'],
            "time" => $this->now->toDateTimeString(),
        );
        $response = $this->projectModel->add_project($project);
        if (!$response) {
            echo "Error: Can't add new project.";
        } else {
            echo "New project added successfuly.";
        }
    }

    function edit_project()
    {
        $project_name = esc($this->request->getVar('project_name'));
        $project_id = esc($this->request->getVar('project_id'));
        $project = $this->projectModel->find($project_id);
        if ($project != false) {
            $project->project_name = $project_name;
            $response = $this->projectModel->edit_project((array)$project, $project_id);
        }
        if (isset($response)) {
            echo "Project updated!";
        } else {
            echo "Project not updated!" . \print_r($response);
        }
    }

    function delete()
    {
        $id = $this->request->getVar('id');
        $this->projectModel->delete_project($id);
    }
}
