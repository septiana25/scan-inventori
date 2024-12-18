<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Saldorak_model extends MY_Model
{

    protected $table = '';

    public function getDefaultValues()
    {
        return [
            'barcodeRak'        => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'barcodeRak',
                'label' => 'Barcode Rak',
                'rules'    => 'trim|required'
            ]
        ];

        return $validationRules;
    }
}

/* End of file Saldorak_model */