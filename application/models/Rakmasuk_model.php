<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Rakmasuk_model extends MY_Model
{

    public function getDefaultValues()
    {
        return [
            'rak'      => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'rak',
                'rules' => 'trim|required',
            ],
        ];

        return $validationRules;
    }
}

/* End of file Rakmasuk_model.php */
