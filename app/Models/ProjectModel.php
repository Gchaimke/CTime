<?php

namespace App\Models;

class ProjectModel extends JsonModel
{
    protected $table = 'projects';
    protected $allowedFields = [
        'project_name',
        'users',
        'managers',
        'password',
        'timers',
        'total',
    ];
    protected $returnType    = \App\Entities\Project::class;
    protected $useTimestamps = true;

    function __construct()
    {
        parent::__construct();
        helper("time");
    }

    function add_project(array $project)
    {
        $new_project = new \App\Entities\Project;

        try {
            $new_project->id = $this->generate_new_file();
            $file = $this->db_dir . $new_project->id . ".json";
            $new_project->project_name = $project["project_name"];
            $new_project->users = array($project["user_id"]);
            $new_project->managers = array($project["user_id"]);
            $new_project->created_at = $project["time"];
            file_put_contents($file, json_encode($new_project, JSON_UNESCAPED_UNICODE));
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }

    function add_time(array $project)
    {
        try {
            $current_project = $this->find($project["project_id"], true);
            if (empty($current_project)) {
                return false;
            }
            $timers = $current_project["timers"];
            if ($project['action'] == "in") {
                $current_project["is_started"] = true;
                $current_project["timers"][][$project['action']] = $project["time"];
                $this->stop_another($project['user_id'], $current_project['id']);
            } else {
                $current_project["is_started"] = false;
                $current_project["timers"][count($timers) - 1][$project['action']] = $project["time"];
            }
            $current_project["total"] = count_total($current_project['timers']);
            $this->edit((array)$current_project, $current_project['id']);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function stop_another($user_id, $project_id)
    {
        $user_projects = $this->whereInArray("users", $user_id);
        foreach ($user_projects as $project) {
            if ($project->id == $project_id) {
                continue;
            }
            if ($project->is_started) {
                $project->is_started = false;
                $project_timers = (array)$project->timers;
                $project_timers[count($project_timers) - 1]->out = date("Y-m-d H:i:s");
                $project->timers = $project_timers;
                $project->total = count_total($project->timers);
                $this->edit((array)$project, $project->id);
            }
        }
    }

    function generate_new_file($id = "")
    {
        helper("db");
        $id = $id != "" ? $id : guidv4();
        $file = $this->db_dir . $id . ".json";
        if (file_exists($file)) {
            $id = $this->generate_new_file();
        }
        $file = $this->db_dir . $id . ".json";
        file_put_contents($file, "");
        return $id;
    }

    function delete_project($id)
    {
        $data_files = glob(DATAPATH . "projects/$id.json");
        foreach ($data_files as $file) {
            if (strpos($file, $id) !== false) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    function delete_project_timer($project_id, $timer_id)
    {
        $current_project = $this->find($project_id, true);
        if (isset($current_project["timers"][$timer_id])) {
            unset($current_project["timers"][$timer_id]);
            $current_project["timers"] = array_values($current_project["timers"]);
            $current_project["total"] = count_total($current_project['timers']);
            $this->edit((array)$current_project, $project_id);
        }
    }

    function change_project_timer($project_id, $timer_id, $action, $new_value)
    {
        $current_project = $this->find($project_id, true);
        if (isset($current_project["timers"][$timer_id])) {
            $current_project["timers"][$timer_id][$action] = $new_value;
            $current_project["total"] = count_total($current_project['timers']);
            $this->edit((array)$current_project, $project_id);
        }
    }
}
