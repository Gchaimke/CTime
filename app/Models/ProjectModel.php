<?php

namespace App\Models;

class ProjectModel extends JsonModel
{
    protected $table         = 'projects';
    protected $allowedFields = [
        'project_name', 'users',  'managers', 'password', 'timers', 'total',
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
        if ($project["project_id"] != "") {
            $file = DATAPATH . "projects/{$project['project_id']}.json";
            if (file_exists($file)) {
                $current_project = json_decode(file_get_contents($file), true);
                if ($project['action'] == "in") {
                    $current_project["is_started"] = true;
                    $this->stop_another($project['user_id'], $project['project_id'], $project["time"]);
                } else {
                    $current_project["is_started"] = false;
                }
                $current_project["timers"][$project['action']][] = $project["time"];
                $total = count_total($current_project['timers']);
                $current_project["total"] = $total;
                file_put_contents($file, json_encode($current_project, JSON_UNESCAPED_UNICODE));
                return true;
            }
        }
        return false;
    }

    function stop_another($user_id, $project_id, $time)
    {
        $user_projects = $this->whereInArray("users", $user_id);
        foreach ($user_projects as $project) {
            if ($project->id == $project_id) {
                continue;
            }
            if ($project->is_started) {
                $project->is_started = false;
                $project_timers = (array)$project->timers;
                $project_timers["out"][] = $time;
                $project->timers->out = $project_timers["out"];
                $total = count_total((array)$project->timers);
                $project->total = $total;
                $this->edit_project((array)$project, $project->id);
            }
        }
    }

    function edit_project(array $project, $project_id)
    {
        if ($project_id != "") {
            return $this->edit((array)$project, 'projects', $project_id);
        }
        return false;
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
}
