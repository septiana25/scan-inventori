<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Users_model $users
 */
class Users extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
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

    public function resetdefault($id_user)
    {
        $data = (object) [
            'id_user' => $id_user,
            'new_password' => '123456',
        ];

        $reset = $this->users->resetPassword($data);

        if ($reset) {
            $this->session->set_flashdata('success', 'Password direset ke default');
        } else {
            $this->session->set_flashdata('error', 'Password gagal direset');
        }
        redirect('users');
    }
}

/* End of file Profile.php */
