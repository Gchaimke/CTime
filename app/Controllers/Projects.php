<?php

namespace App\Controllers;

class Projects extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        if (isset($this->data['user'])) {
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
        } else {
            return redirect()->to("/login");
        }
        return view("projects", $this->data);
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
            $return = $this->projectModel->add_project($project);
            if (!$return) {
                echo "Error: Can't create new project.";
            }
        } else {
            $return = $this->projectModel->add_time($project);
            if (!$return) {
                echo "Error: Can't add time to project.";
            }
        }
    }

    function edit_project()
    {
        $return = null;
        $project_name = esc($this->request->getVar('project_name'));
        $project_id = esc($this->request->getVar('project_id'));
        $project = $this->projectModel->find($project_id);
        if ($project != false) {
            $project->project_name = $project_name;
            $return = $this->projectModel->update_project($project, $project_id);
        }
        if (isset($return)) {
            if ($return) {
                $this->data['message_type'] = "success";
                $this->data['message_text'] = "Project updated!";
            } else {
                $this->data['message_type'] = "danger";
                $this->data['message_text'] = "Project not updated!";
            }
        }
        return $this->index();
    }

    function delete()
    {
        $id = $this->request->getVar('id');
        $this->projectModel->delete_project($id);
    }
}
