<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Pickersodetail_model extends MY_Model
{
    protected $table = 'pickerso';

    public function run($input)
    {

        $data = [
            'id'        => $input['id'],
            'nopol'     => $input['nopol'],
            'supir'     => $input['supir'],
            'id_toko'   => $input['id_toko'],
            'toko'      => $input['toko'],
            'brg'       => $input['brg'],
            'qty'       => $input['qty'],
            'user'      => $input['user'],
        ];

        return $this->create($data);
    }
}
