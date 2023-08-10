<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Detailmasuk_model extends MY_Model {

    protected $table = 'masuk_det';

    public function getDefaultValues(){
        return [
            'item'      => '',
        ];
    }

    public function getValidationRules(){
        $validationRules = [
            [
                'field' => 'item',
                'label' => 'Item',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

    public function run($input){
        $data = [
            'item' => $input->item,
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

            //return $this;
    }

}

/* End of file Masuk_model.php */
