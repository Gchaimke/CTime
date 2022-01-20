<?php

namespace App\Models;

class UserModel extends JsonModel
{
    protected $table         = 'users';
    protected $allowedFields = [
        'view_name', 'username', 'email', 'role', 'password',
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
            $new_user->name = $user["view_name"];
            $new_user->email = $user["email"];
            $new_user->username = $user["username"];
            $new_user->setPassword($user["password"]);
            $new_user->role = $user["role"];
            $new_user->setCreatedAt(date("Y-m-d H:i:s"));
            file_put_contents($file, json_encode($new_user));
            return true;
        }
        return false;
    }
}
