<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Detailkeluar_model extends MY_Model {

    protected $table = 'keluar_det';

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
            'id_keluar'  => $id,
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
                'field' => 'id_keluar',
                'label' => 'Id Keluar',
                'rules' => 'trim|required|numeric',
            ]
        ];

        return $validationRules;
    }

    public function run($input){
        
        $data = [
            'id_keluar'  => $input->id_keluar,
            'id_item'   => $input->id_item,
            'item'      => $input->item,
            'barcode'   => $input->barcode,
            'qty'       => $input->qty,
            'user'      => $this->session->userdata('username'),
            
        ];

        return $this->create($data);
        
    }

    public function fetchById($id){

        return $this->select(
            [
                'MAX(barcode) AS barcode',
                'MAX(item) AS item',
                'SUM(qty) as qty'
            ]
            )->where('id_keluar', $id)
            ->where('at_delete', NULL)
            ->group_by('id_item')
            ->get();

    }

}

/* End of file Detailkeluar_model.php */
