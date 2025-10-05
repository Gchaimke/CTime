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
        return array();
    }

    function find($id, $as_array = false)
    {
        $file = $this->db_dir . "$id.json";
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), $as_array);
            return $data;
        }
        return array();
    }

    function where($field, $search)
    {
        $all_entities = $this->findAll();
        $found = [];
        foreach ($all_entities as $entity) {
            if (strtolower($entity->$field) == strtolower($search)) {
                $found[] = $entity;
            }
        }
        return $found;
    }

    function whereInArray($field, $search)
    {
        $all_entities = $this->findAll();
        $found = [];
        foreach ($all_entities as $entity) {
            if ($entity == "" || !property_exists($entity, $field)) {
                continue;
            }
            foreach ($entity->$field as $value) {
                if (strtolower($value) == strtolower($search)) {
                    $found[] = $entity;
                }
            }
        }
        return $found;
    }

    function first($field, $search)
    {
        $all_entities = $this->findAll();
        foreach ($all_entities as $entity) {
            if ($entity == "" || !property_exists($entity, $field)) {
                return array();
            }
            if (strtolower($entity->$field) == strtolower($search)) {
                return $entity;
            }
        }
        return array();
    }

    function edit($data, $id, $intersect = true)
    {
        $found_data = $this->find($id, true);
        if ($found_data) {
            if ($intersect) {
                $found_data = array_merge($found_data, array_intersect_key($data, $found_data));
            } else {
                $found_data = array_merge($found_data, $data);
            }
            $file = $this->db_dir . "$id.json";
            if (file_exists($file)) {
                file_put_contents($file, json_encode($found_data, JSON_UNESCAPED_UNICODE));
                return $data;
            }
        }
        return array();
    }

    function delete($id)
    {
        if ($id == "") {
            return;
        }
        $file = $this->db_dir . "$id.json";
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
