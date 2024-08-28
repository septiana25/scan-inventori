<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Returns_model extends MY_Model
{

    protected $table = '';

    public function getDefaultValues()
    {
        return [
            'barcode'        => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'barcode',
                'label' => 'Barcode',
                'rules'    => 'trim|required'
            ]
        ];

        return $validationRules;
    }
}

/* End of file Returns_model.php */