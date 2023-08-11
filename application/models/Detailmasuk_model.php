<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Detailmasuk_model extends MY_Model {

    protected $table = 'masuk_det';

    public function __construct()
    {
        parent::__construct();
        $sess_data = [
            'username'  => 'septiana'
        ];
        
        $this->session->set_userdata($sess_data);
    }
    
    public function getDefaultValues($id){
        return [
            'id_masuk'  => $id,
            'item'      => '',
        ];
    }

    public function getValidationRules(){
        $validationRules = [
            [
                'field' => 'item',
                'label' => 'Item',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'id_masuk',
                'label' => 'Id Masuk',
                'rules' => 'trim|required|numeric',
            ]
        ];

        return $validationRules;
    }

    public function run($input){
        $data = [
            'id_masuk'  => $input->id_masuk,
            'item'      => $input->item,
            'user'      => $this->session->userdata('username')
        ];

        return $this->create($data);
        
    }

    public function fetchAll(){

        return $this->select(
            [
                'item',
                'qty'
            ]
            )->get();

    }

    public function fetchById($id){

        return $this->select(
            [
                'item',
                'qty'
            ]
            )->where('id_masuk', $id)
            ->get();

    }
    
}

/* End of file Masuk_model.php */
