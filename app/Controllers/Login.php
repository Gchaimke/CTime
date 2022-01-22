<?php

namespace App\Controllers;

class Login extends BaseController
{

    public function index()
    {
        if (isset($this->session->logged_in) && $this->session->logged_in) {
            $this->session->destroy();
        }
        // $this->data['message_text'] = "test";
        return view("login", $this->data);
    }

    public function try_login()
    {
        $username = esc($this->request->getVar('username'));
        $password = esc($this->request->getVar('password'));
        $user = $this->userModel->login(array("username" => $username, "password" => $password));
        if ($user !== false) {
            $session_data = [
                'id'  => $user->id,
                'username'  => $user->username,
                'view_name'  => $user->view_name,
                'role' => $user->role,
                'timezone' => $user->timezone,
                'language' => $user->language,
                'logged_in' => true,
            ];
            $this->session->set($session_data);
            session_write_close();
            return redirect()->to("/user");
        }else{
            $this->data['message_type'] = "danger";
            $this->data['message_text'] = "Username or Password is wrong!";
        }

        return view("login", $this->data);
    }
}
