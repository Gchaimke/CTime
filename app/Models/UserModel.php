<?php

namespace App\Models;

use CodeIgniter\I18n\Time;

class UserModel extends JsonModel
{
    protected $table         = 'users';
    protected $allowedFields = [
        'view_name', 'username', 'email', 'role', 'company', 'password', 'timezone', 'language',
    ];
    protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = true;

    function add_user(array $user)
    {
        helper("db");
        $new_user = new \App\Entities\User;
        $new_user->id = guidv4();
        $file = $this->db_dir . $new_user->id . ".json";
        if (file_exists($file)) {
            $new_user->id = guidv4();
            $file = $this->db_dir . $new_user->id . ".json";
        }
        if (!$this->first("username", $user["username"])) {
            $new_user->username = $user["username"];
            $new_user->view_name = $user["view_name"];
            $new_user->email = $user["email"];
            $new_user->role = $user["role"];
            $new_user->company = $user["company"];
            $new_user->setPassword($user["password"]);
            $new_user->setCreatedAt(date("Y-m-d H:i:s"));
            $new_user->setCreatedAt(date("Y-m-d H:i:s"));
            file_put_contents($file, json_encode($new_user, JSON_UNESCAPED_UNICODE));
            return true;
        }
        return false;
    }

    function edit_user(array $user, $id)
    {
        if ($this->find($id)) {
            if($user['password'] == ''){
                unset($user['password']); 
            }else{
                $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
            }
            $user['updated_at'] = new Time(date("Y-m-d H:i:s"), 'UTC');
            return $this->edit($user, 'users', $id);
        }
        return false;
    }

    function login(array $user)
    {
        $f_user = $this->first("username", $user['username']);
        if ($f_user !== false) {
            if (password_verify($user['password'], $f_user->password)) {
                return $f_user;
            }
        } else {
            if ($this->findAll() == false) {
                $new_user = array(
                    "company" => "CTime",
                    "username" => "admin",
                    "view_name" => "Chaim",
                    "email" => "admin@email.com",
                    "role" => "admin",
                    "password" => "admin",
                    'timezone'  => 'Asia/Jerusalem',
                    'language'   => 'he_IL',
                );
                $this->add_user($new_user);
                # this will block from register admin user from guset session
                if (!file_exists(DATAPATH . 'has_users')) {
                    file_put_contents(DATAPATH . 'has_users', '');
                }
            }
        }
        return false;
    }

    function get_user($id)
    {
        return $this->find($id, true);
    }

    function delete_user($id)
    {
        $data_files = glob(DATAPATH . "{timers/*/*/,users/}$id*.json", GLOB_BRACE);
        foreach ($data_files as $file) {
            if (strpos($file, $id) !== false) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }
}
