<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Users_model $users
 */
class Users extends MY_Controller
{
    const ERROR_TRY_CATCH = 'Terjadi kesalahan saat mengubah peran.';
    const SUCCESS_CHANGE_ROLE = 'Role berhasil diubah';
    const ERROR_CHANGE_ROLE = 'Role gagal diubah';

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

    public function changerole()
    {
        try {
            $data = (object) [
                'id_user' => $this->input->post('id_user'),
                'role' => $this->input->post('role'),
            ];

            $result = $this->users->changeRole($data);

            if (!$result) {
                throw new Exception(self::ERROR_CHANGE_ROLE);
            }

            $this->session->set_flashdata('success', self::SUCCESS_CHANGE_ROLE);
        } catch (\Throwable $e) {
            $this->session->set_flashdata('error', $e->getMessage() ?? self::ERROR_TRY_CATCH);
        }
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
