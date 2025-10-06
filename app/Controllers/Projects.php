<?php

namespace App\Controllers;

class Projects extends BaseController
{
    public function __construct() {}

    public function index()
    {
        $this->data['projects'] = [];
        $projects = $this->projectModel->whereInArray("users", $this->data['user']['id']);
        foreach ($projects as $project) {
            $this->data['projects'][$project->id] = $project;
            $this->data['projects'][$project->id]->total = count_total((array)$project->timers);
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

        if (in_array($project["action"], ["in", "out"])) {
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
            echo "New project added successfully.";
        }
    }

    function edit_project()
    {
        $serialized = $this->request->getVar('form');
        $form = [];
        if (!empty($serialized) && is_string($serialized)) {
            parse_str($serialized, $form);
            if (!is_array($form)) {
                $form = [];
            }
        }
        $project_id = esc($form['project_id']);
        $project = array(
            'project_name'   => $form['project_name'],
            'per_hour'  => $form['per_hour'],
            'currency'      => $form['currency'],
        );
        $response = $this->projectModel->edit((array)$project, $project_id, false);
        if (!empty($response)) {
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

    function delete_timer()
    {
        $project_id = $this->request->getVar('project_id');
        $timer_id = $this->request->getVar('timer_id');
        $this->projectModel->delete_project_timer($project_id, $timer_id);
    }

    function change_timer()
    {
        $project_id = $this->request->getVar('project_id');
        $timer_id = $this->request->getVar('timer_id');
        $new_value = $this->request->getVar('new_value');
        $action = $this->request->getVar('action');
        if (!in_array($action, ['in', 'out'])) {
            echo "Error: Invalid action.";
            return;
        }
        $this->projectModel->change_project_timer($project_id, $timer_id, $action, $new_value);
    }

    function update_total_payed()
    {
        $project_id = $this->request->getVar('project_id');
        $new_value = $this->request->getVar('new_value');
        if (is_numeric($new_value)) {
            $this->projectModel->edit(array("total_payed" => intval($new_value)), $project_id, false);
        } else {
            echo "Error: Invalid value.";
        }
    }
}
