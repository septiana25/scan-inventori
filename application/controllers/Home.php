<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $is_login    = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $data['title'] = 'Login Aplikasi Scan';
        $data['nav'] = 'Login';
        $data['page'] = 'pages/home/index';
        $this->view($data);
    }
}

/* End of file Home.php */
