<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk_model extends MY_Model {

    protected $perPage = 5;

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

    public function fetchAll($page){
        return $this->select(
            [
                'id_masuk',
                'suratJalan'
            ]
            )->get();

            //return $this;
    }

    public function totalRows(){
        return $this->count();
    }

}

/* End of file Masuk_model.php */
