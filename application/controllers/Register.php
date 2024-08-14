<?php


defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property Register_model $register
 * @property CI_Input $input
 */
class Register extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!$_POST) {
            $input = (object) $this->register->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->register->validate()) {
            $data['title'] = 'Register';
            $data['input'] = $input;

            $data['nav']   = 'Pendaftaran';
            $data['page']  = 'pages/auth/register';
            $this->view($data);
            return;
        }

        if ($this->register->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil melakukan registrasi, Silahkan Login');

            redirect(base_url('login'));
        } else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url('register'));
        }
    }
}

/* End of file Register.php */
