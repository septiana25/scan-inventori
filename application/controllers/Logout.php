<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 */
class Logout extends MY_Controller
{

    public function index()
    {
        $sess_data = [
            'id',
            'name',
            'username',
            'role',
            'is_login'
        ];

        $this->session->unset_userdata($sess_data);
        $this->session->sess_destroy();
        redirect(base_url());
    }
}

/* End of file Logout.php */