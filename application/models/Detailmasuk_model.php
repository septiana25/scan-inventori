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
            'id_item'   => $input->id_item,
            'item'      => $input->item,
            'barcode'   => $input->barcode,
            'qty'      => $input->qty,
            'user'      => $this->session->userdata('username'),
            'at_update' => date("Y-m-d H:i:s")
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
            )->where('at_delete', NULL)
            ->get();

    }

    public function fetchById($id){

        return $this->select(
            [
                'MAX(barcode) AS barcode',
                'MAX(item) AS item',
                'SUM(qty) as qty'
            ]
            )->where('id_masuk', $id)
            ->where('at_delete', NULL)
            ->group_by('id_item')
            ->get();
    }

    public function getTotalById($id, $barcode){
        return $this->select('SUM(qty) AS total')
            ->where('id_masuk', $id)
            ->where('barcode', $barcode)
            ->group_by('id_item')
            ->first();
    }
    
}

/* End of file Masuk_model.php */
