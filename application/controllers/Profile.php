<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
    private $id;

    public function __construct()
    {
        parent::__construct();
        $is_login    = $this->session->userdata('is_login');
        $this->id    = $this->session->userdata('id');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $data['title'] = 'Profile User';
        $data['nav'] = 'Profile';
        $data['data'] = $this->session->userdata('name');
        $data['page'] = 'pages/profile/index';
        $this->view($data);
    }
}

/* End of file Profile.php */
