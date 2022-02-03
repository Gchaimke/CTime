<?php

namespace App\Controllers;

class User extends BaseController
{

    public function index()
    {
        if (!isset($this->data["user"])) {
            return redirect()->to("/login");
        }
        $this->data['message_type'] = "success";
        $this->data['message_text'] = "Username or Password is good!";
        return view("user", $this->data);
    }

    function register()
    {
        $user = array(
            'username'   => $this->request->getVar('username'),
            'view_name'  => $this->request->getVar('view_name'),
            'email'      => $this->request->getVar('email'),
            'password'   => $this->request->getVar('password'),
            'role'       => $this->request->getVar('role'),
        );
        $this->userModel->add_user($user);
        return redirect()->to("/admin");
    }

    function delete()
    {
        $id = $this->request->getVar('id');
        $data_files = $this->userModel->delete_user($id);
        die(print_r($data_files));
        return redirect()->to("/admin");
    }
}
