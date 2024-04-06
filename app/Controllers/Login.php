<?php

namespace App\Controllers;

class Login extends BaseController
{

    public function index()
    {
        if (isset($this->session->logged_in) && $this->session->logged_in) {
            $this->session->destroy();
        }
        # This is fist time login, let's create db folders
        if (!file_exists(DATAPATH . 'users')) {
            $this->init_folders();
        }
        // $this->data['message_text'] = "test";
        return view("login", $this->data);
    }

    public function try_login()
    {
        $username = esc($this->request->getVar('username'));
        $password = esc($this->request->getVar('password'));
        $user = $this->userModel->login(array("username" => $username, "password" => $password));
        if ($user != false) {
            $this->_set_session($user);
            return redirect()->to("/");
        } else {
            $this->data['message_type'] = "danger";
            $this->data['message_text'] = "Username or Password is wrong!";
        }
        return view("login", $this->data);
    }

    private function _set_session($user)
    {
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
    }

    function init_folders()
    {
        $data_folders = array('users', 'timers', 'projects');

        $timers_current_date = 'timers/' . $this->now->getYear() . "/" . $this->now->getMonth() . "/";
        $data_folders[] = $timers_current_date;

        foreach ($data_folders as $folder) {
            if (!file_exists(DATAPATH . $folder)) {
                mkdir(DATAPATH . $folder, 0744, true);
            }
            if (!chmod(DATAPATH . $folder, 0744)) {
                chmod(DATAPATH . $folder, 0744);
            }
        }
    }
}
