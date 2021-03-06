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

    function find($id)
    {
        $file = $this->db_dir . "$id.json";
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file));
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
}
