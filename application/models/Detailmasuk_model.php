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

        $masuk_det = $this->create($data);
        return true;
    }

}

/* End of file Masuk_model.php */
