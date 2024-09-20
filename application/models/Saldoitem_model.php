<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Saldoitem_model extends MY_Model
{

    protected $table = '';

    public function getDefaultValues()
    {
        return [
            'barcodeItem'        => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'barcodeItem',
                'label' => 'Barcode Item',
                'rules'    => 'trim|required'
            ]
        ];

        return $validationRules;
    }
}

/* End of file Saldoitem_model */