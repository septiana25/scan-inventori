<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Approvedrak_model $approvedrak
 */
class Checksaldo extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data['title'] = 'Menu Check Saldo';
        $data['nav'] = 'Menu Check Saldo';
        $data['page'] = "pages/saldo/index";
        $this->view($data);
    }
}

/* End of file Approved.php */