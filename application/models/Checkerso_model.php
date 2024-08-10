<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Checkerso_model extends MY_Model
{

    protected $table = 'pickerso';

    public function __construct()
    {
        parent::__construct();
    }

    public function getDefaultValues($idRak, $rak, $id)
    {
        return [
            'id_masuk'  => $id,
            'id_rak'    => $idRak,
            'rak'       => $rak,
            'barcode'   => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'barcode',
                'label' => 'Barcode',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'id_masuk',
                'label' => 'Id Masuk',
                'rules' => 'trim|required|numeric',
            ],
            [
                'field' => 'id_rak',
                'label' => 'Id Rak',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'rak',
                'label' => 'Rak',
                'rules' => 'trim|required',
            ],
        ];

        return $validationRules;
    }

    public function run($input)
    {
        $data = [
            'id_masuk'      => $input->id_masuk,
            'id_rak'        => $input->id_rak,
            'rak'           => $input->rak,
            'user'          => $input->username,
        ];

        return $this->create($data);
    }

    /* public function update($input)
    {

        $data = [
            'id'           => $input->id,
            'approve'      => 'true',
            'manager'      => $input->username,
        ];

        return $this->update($data);
    } */

    public function fetchAll()
    {
        return $this->select(
            [
                'MAX(nopol) as nopol',
                'MAX(supir) as supir',
                'MAX(id_toko) as id_toko'
            ]
        )
            ->where('status', '0')
            ->group_by('nopol')
            ->group_by('id_toko')
            ->get();
    }

    public function fetchByNopol($nopol)
    {
        return $this->select(
            [
                'MAX(nopol) as nopol',
                'MAX(supir) as supir',
                'MAX(id_toko) as id_toko',
                'MAX(toko) as toko'
            ]
        )
            ->where('nopol', $nopol)
            ->where('status', '0')
            ->group_by('id_toko')
            ->get();
    }

    public function fetchByNopolAndIdToko($nopol, $id_toko)
    {
        return $this->select(
            [
                'nopol',
                'supir',
                'id_toko',
                'toko',
                'id',
                'brg',
                'qty',
            ]
        )
            ->where('nopol', $nopol)
            ->where('id_toko', $id_toko)
            ->where('status', '0')
            ->get();
    }

    public function fetchByIdMasukIdRak($id, $idrak)
    {
        return $this->select(
            [
                'id',
                'id_masuk',
                'approve'
            ]
        )
            ->where('id_masuk', $id)
            ->where('id_rak', $idrak)
            ->first();
    }
}

/* End of file Approvedrak_model.php */