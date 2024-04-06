<?php

namespace App\Models;

class JsonModel
{
    protected $db_dir;

    public function __construct()
    {
        $this->db_dir = DATAPATH . $this->table . DIRECTORY_SEPARATOR;
    }

    function findAll()
    {
        $dir = glob($this->db_dir . "*.json");
        $all = array();
        foreach ($dir as $file) {
            $data = json_decode(file_get_contents($file));
            $all[] = $data;
        }
        if (count($all) > 0) {
            return $all;
        }
        return false;
    }

    function find($id, $as_array = false)
    {
        $file = $this->db_dir . "$id.json";
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), $as_array);
            return $data;
        }
        return false;
    }

    function where($feild, $search)
    {
        $dir = glob($this->db_dir . "*.json");
        $all = array();
        foreach ($dir as $file) {
            $data = json_decode(file_get_contents($file));
            if (strtolower($data->$feild) == strtolower($search)) {
                $all[] = $data;
            }
        }
        if (count($all) > 0) {
            return $all;
        }
        return false;
    }

    function whereInArray($feild, $search)
    {
        $dir = glob($this->db_dir . "*.json");
        $all = array();
        foreach ($dir as $file) {
            $data = json_decode(file_get_contents($file));
            if ($data == "" || !property_exists($data, $feild)) {
                continue;
            }
            foreach ($data->$feild as $value) {
                if (strtolower($value) == strtolower($search)) {
                    $all[] = $data;
                }
            }
        }
        if (count($all) > 0) {
            return $all;
        }
        return false;
    }

    function first($feild, $search)
    {
        $dir = glob($this->db_dir . "*.json");
        foreach ($dir as $file) {
            $data = json_decode(file_get_contents($file));
            if ($data == "" || !property_exists($data, $feild)) {
                return false;
            }
            if (strtolower($data->$feild) == strtolower($search)) {
                return $data;
            }
        }
        return false;
    }

    function edit($data, $entity, $id)
    {
        $found_data = $this->find($id, true);
        if ($found_data) {
            $found_data = array_merge($found_data, array_intersect_key($data, $found_data));
            $file = DATAPATH . "$entity/$id.json";
            if (file_exists($file)) {
                file_put_contents($file, json_encode($found_data, JSON_UNESCAPED_UNICODE));
                return $data;
            }
        }
        return false;
    }
}
