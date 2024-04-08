<?php

namespace App\Controllers;

class User extends BaseController
{

    public function index()
    {
        if (!isset($this->data["user"])) {
            return redirect()->to("/");
        }
        // $this->data['message_type'] = "success";
        // $this->data['message_text'] = "Username or Password is good!";
        return view("user/view", $this->data);
    }

    public function register()
    {
        $posted_role = $this->request->getVar('role');
        $role = isset($posted_role) ? $posted_role : 'user';
        $this->data['can_delete'] = !file_exists(DATAPATH . 'has_users') || $this->session->get()['role'] == 'admin';
        $user = array(
            'username'   => $this->request->getVar('username'),
            'view_name'  => $this->request->getVar('view_name'),
            'email'      => $this->request->getVar('email'),
            'company'      => $this->request->getVar('company'),
            'password'      => $this->request->getVar('password'),
            'role'       => $role,
        );
        if ($this->userModel->add_user($user)) {
            # this will block from register admin user from guset session
            if (!file_exists(DATAPATH . 'has_users')) {
                file_put_contents(DATAPATH . 'has_users', '');
            }
            return redirect()->to("/admin");
        } else {
            $this->data['message_type'] = "danger";
            $this->data['message_text'] = "Username already registered!";
            $this->data = array_merge($this->data, $user);
            return view("user/register", $this->data);
        }
    }

    function edit($id)
    {
        $this->data['user_edit'] = true;
        $this->data['can_delete'] = !file_exists(DATAPATH . 'has_users') || $this->session->get()['role'] == 'admin';
        $user = $this->userModel->get_user($id);
        if (!isset($user) ||  ($this->session->get()['id'] != $id && !$this->data['can_delete'])) {
            return redirect()->to("/");
        }
        if (!$this->request->getVar('username')) {
            # this is get request
            $this->data = array_merge($this->data, $user);
        } else {
            # this is post request
            $post_user = array(
                'view_name'  => $this->request->getVar('view_name'),
                'email'      => $this->request->getVar('email'),
                'company'      => $this->request->getVar('company'),
                'password'      => $this->request->getVar('password')
            );
            if($this->session->get()['role'] == 'admin'){
                $post_user['role'] = $this->request->getVar('role');
            }
            $this->userModel->edit_user($post_user, $id);
            $post_user['password'] = '';
            $this->data = array_merge($this->data, $user, $post_user);
        }
        return view("user/edit", $this->data);
    }

    function delete()
    {
        $id = $this->request->getVar('id');
        $data_files = $this->userModel->delete_user($id);
        die(print_r($data_files));
        return redirect()->to("/admin");
    }
}
