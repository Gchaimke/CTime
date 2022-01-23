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

    public function timers()
    {
        $year = isset($_GET["year"]) ? $_GET["year"] : $this->now->getYear();
        $month = isset($_GET["month"]) ? $_GET["month"] : $this->now->getMonth();
        if (isset($this->data['user'])) {
            $this->data["timers"] = $this->timerModel->get_timers($year, $month, $this->data['user']['id']);
        } else {
            return redirect()->to("/login");
        }
        return view("timers", $this->data);
    }

    function action()
    {
        $action = $this->request->getVar('action');
        $time = $this->now->toTimeString();
        $this->timerModel->add_time(
            $this->now->getDay(),
            $this->now->getMonth(),
            $this->now->getYear(),
            $time,
            $action,
            $this->data['user']['id']
        );
        echo "$action: $time";
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
