<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Users_model $users
 */
class Profile extends MY_Controller
{
    private $id;

    public function __construct()
    {
        parent::__construct();
        $is_login    = $this->session->userdata('is_login');
        $this->id    = $this->session->userdata('id');
        $this->loadModelUsers();

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
            'id_user' => $this->session->userdata('id_user'),
        ];
        $data['title'] = 'Profile User';
        $data['nav'] = 'Profile';
        $data['content'] = $content;
        $data['page'] = 'pages/profile/index';
        $this->view($data);
    }

    public function reset($id_user)
    {
        $user = $this->users->getUserById($id_user);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan');
            redirect('users');
        }

        if (!$_POST) {
            $input    = (object) $this->users->getDefaultValues();
        } else {
            $input    = (object) $this->input->post(null, true);
        }

        if (!$this->users->validate()) {
            $data['title'] = 'Reset Password';
            $data['nav'] = 'Reset Password';
            $data['input'] = $input;
            $data['content'] = $user;
            $data['page'] = 'pages/profile/resetpassword';
            $this->view($data);
            return;
        }

        if ($this->users->resetPassword($input)) {
            $sess_data = [
                'id',
                'name',
                'username',
                'role',
                'is_login'
            ];
            $this->session->set_flashdata('success', 'Berhasil melakukan Reset Password, Silahkan Login');
            $this->session->unset_userdata($sess_data);
            redirect(base_url('login'));
        }
        $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');

        $data['title'] = 'Reset Password';
        $data['nav'] = 'Reset Password';
        $data['input'] = $input;
        $data['content'] = $user;
        $data['page'] = 'pages/profile/resetpassword';
        $this->view($data);
    }

    private function loadModelUsers()
    {
        $this->load->model(ucfirst('users') . '_model', 'users', true);
        return $this;
    }
}

/* End of file Profile.php */
