<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 */
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
        $data['title'] = 'Selamat Datang Aplikasi Scan';
        $data['nav'] = 'Scan App';
        $data['page'] = 'pages/home/index';
        $this->view($data);
    }
}

/* End of file Home.php */
