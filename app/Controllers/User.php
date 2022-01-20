<?php

namespace App\Controllers;

class User extends BaseController
{

    public function index()
    {
        if (!isset($this->data["user"])) {
            return redirect()->to("/user/login");
        }
        return view("user", $this->data);
    }

    public function timers()
    {
        $year = isset($_GET["year"]) ? $_GET["year"] : date("y");
        $month = isset($_GET["month"]) ? $_GET["month"] : date("m");

        $this->data["timers"] = $this->timeModel->get_timers($year, $month, $this->data['user']['id']);
        
        if (isset($_GET["in"])) {
            $this->timeModel->add_time(date("d"), $month, $year, date("H:i"), "in", $this->data['user']['id']);
        }
        if (isset($_GET["out"])) {
            $this->timeModel->add_time(date("d"), $month, $year, date("H:i"), "out", $this->data['user']['id']);
        }
        return view("timers", $this->data);
    }

    public function login()
    {
        if (isset($this->session->logged_in) && $this->session->logged_in) {
            $this->session->destroy();
        }
        return view("login");
    }

    public function try_login()
    {
        $username = esc($this->request->getVar('username'));
        $password = esc($this->request->getVar('password'));
        if ($username != "" && $password != "") {
            $user = $this->userModel->login(array("username" => $username, "password" => $password));
            if ($user !== false) {
                $session_data = [
                    'id'  => $user->id,
                    'username'  => $user->username,
                    'view_name'  => $user->view_name,
                    'role' => $user->role,
                    'logged_in' => true,
                ];
                $this->session->set($session_data);
                session_write_close();
            }
        }
        return redirect()->to("/user");
    }
}
