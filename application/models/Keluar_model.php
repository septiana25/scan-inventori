<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Keluar_Model extends MY_Model
{
    protected $table = 'checkerso';

    public function __construct()
    {
        parent::__construct();
        $sess_data = [
            'username'  => 'septiana'
        ];

        $this->session->set_userdata($sess_data);
    }

    public function getDefaultValues()
    {
        return [
            'no_plat'  => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'no_plat',
                'label' => 'Plat Nomor',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

    public function fetchAll()
    {
        return $this->select(
            [
                'MAX(nopol) as nopol',
                'MAX(supir) as supir',
                'MAX(checkerso.at_create) as at_create'
            ]
        )
            ->join('pickerso', 'pickerso.id_pic = checkerso.id_pic')
            ->group_by('nopol')
            ->get();
    }

    public function print($nopol)
    {
        return $this->select(
            [
                'supir',
                'toko',
                'brg',
                'qty_scan',
                'checkerso.at_create',
                'checkerso.user'
            ]
        )
            ->where('nopol', $nopol)
            ->join('pickerso', 'pickerso.id_pic = checkerso.id_pic')
            ->get();
    }
}

/* End of file Keluar_Model.php */
