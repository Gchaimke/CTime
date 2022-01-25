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
            $new_project->addTimer($project["time"], "in");
            $new_project->setCreatedAt($project["time"]);
            file_put_contents($file, json_encode($new_project, JSON_UNESCAPED_UNICODE));
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }

    function add_time($id, $action, $time)
    {
        if ($id != "") {
            $file = DATAPATH . "projects/$id.json";
            $project = json_decode(file_get_contents($file), true);
            if (file_exists($file)) {
                $project["timers"][$action][] = $time;
                $total = count_total($project['timers']);
                $project["total"] = $total;
                file_put_contents($file, json_encode($project, JSON_UNESCAPED_UNICODE));
                return true;
            }
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
