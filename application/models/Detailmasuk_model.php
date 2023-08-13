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
            'barcode'      => '',
        ];
    }

    public function getValidationRules(){
        $validationRules = [
            [
                'field' => 'barcode',
                'label' => 'Barcode',
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
            'barcode'   => $input->barcode,
            'item'      => $input->item,
            'qty'      => $input->qty,
            'user'      => $this->session->userdata('username')
        ];

        return $this->create($data);
        
    }

    public function fetchAll(){

        return $this->select(
            [
                'barcode',
                'item',
                'qty'
            ]
            )->get();

    }

    public function fetchById($id){

        return $this->select(
            [
                'barcode',
                'item',
                'qty'
            ]
            )->where('id_masuk', $id)
            ->get();

    }
    
}

/* End of file Masuk_model.php */
