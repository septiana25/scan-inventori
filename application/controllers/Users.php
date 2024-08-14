<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Users_model $users
 */
class Users extends MY_Controller
{
    const ALLOWED_ROLES = ['superadmin'];

    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->checkAccess();
    }

    public function index()
    {
        $result = $this->users->fetchAll();
        $data['title'] = 'Data User';
        $data['nav'] = 'Data - User';
        $data['content'] = $result;
        $data['page'] = 'pages/user/index';
        $this->view($data);
    }

    private function checkAccess()
    {
        if (!in_array($this->session->userdata('role'), self::ALLOWED_ROLES)) {
            $this->session->set_flashdata('error', 'Tidak memiliki akses ke halaman User');
            redirect(base_url('home'));
        }
    }

    private function checkLogin()
    {
        if (!$this->session->userdata('is_login')) {
            redirect(base_url('login'));
        }
    }
}

/* End of file Profile.php */
