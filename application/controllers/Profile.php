<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 */
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
        $content =  (object) [
            'user' => $this->session->userdata('name'),
            'role' => $this->session->userdata('role'),
        ];
        $data['title'] = 'Profile User';
        $data['nav'] = 'Profile';
        $data['content'] = $content;
        $data['page'] = 'pages/profile/index';
        $this->view($data);
    }
}

/* End of file Profile.php */
