<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk_model extends MY_Model {

    protected $table = '';

    public function getDefaultValues(){
        return [
            'suratJalan'      => '',
        ];
    }

    public function getValidationRules(){
        $validationRules = [
            [
                'field' => 'suratJalan',
                'label' => 'Surat Jalan',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

    public function run($input){
        $data = [
            'suratJalan' => $input->suratJalan,
        ];

        return $this->create($data);

    }

    public function fetchAll(){
        return $this->select(
            [
                'id',
                'suratJalan'
            ]
            )->get();
    }

}

/* End of file Masuk_model.php */
