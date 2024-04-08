<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->data['can_delete'] = !file_exists(DATAPATH . 'has_users') || $this->session->get()['role'] == 'admin';
        $this->data["users"] = $this->userModel->findAll();
        return view("admin/view", $this->data);
    }
}
