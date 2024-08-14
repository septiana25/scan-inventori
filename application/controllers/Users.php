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
}

/* End of file Profile.php */
