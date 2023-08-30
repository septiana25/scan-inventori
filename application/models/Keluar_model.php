<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Keluar_Model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $sess_data = [
            'username'  => 'septiana'
        ];
        
        $this->session->set_userdata($sess_data);
    }

    public function getDefaultValues(){
        return [
            'no_plat'  => ''
        ];
    }

    public function getValidationRules(){
        $validationRules = [
            [
                'field' => 'no_plat',
                'label' => 'Plat Nomor',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

}

/* End of file Keluar_Model.php */
