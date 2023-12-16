<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Detailmasuk_model extends MY_Model
{

    protected $table = 'masuk_det';

    public function __construct()
    {
        parent::__construct();
        $sess_data = [
            'username'  => 'septiana'
        ];

        $this->session->set_userdata($sess_data);
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
            'id_item'       => $input->id_item,
            'item'          => $input->item,
            'barcode'       => $input->barcode,
            'id_rak'        => $input->id_rak,
            'rak'           => $input->rak,
            'qty'           => $input->qty,
            'user'          => $this->session->userdata('username'),
        ];

        return $this->create($data);
    }

    public function fetchAll()
    {

        return $this->select(
            [
                'barcode',
                'item',
                'qty'
            ]
        )->where('at_delete', NULL)
            ->get();
    }

    public function fetchById($id, $rak)
    {

        /* 'MAX(suratJalan) AS suratJalan', */
        return $this->select(
            [
                'MAX(masuk.id_masuk) AS id_masuk',
                'MAX(masuk.suratJalan) AS suratJalan',
                'MAX(barcode) AS barcode',
                'MAX(id_item) AS id_item',
                'MAX(item) AS item',
                'SUM(qty) as qty'
            ]
        )
            ->join('masuk', 'masuk.id_masuk = masuk_det.id_masuk')
            ->where('masuk.id_masuk', $id)
            ->where('rak', $rak)
            ->group_by('id_item')
            ->get();
    }

    public function fetchByIdMasuk($id)
    {
        return $this->select('suratJalan')
            ->where('masuk.id_masuk', $id)
            ->join('masuk', 'masuk.id_masuk = masuk_det.id_masuk')
            ->first();
    }

    public function getTotalById($id, $barcode)
    {
        return $this->select('SUM(qty) AS total')
            ->where('id_masuk', $id)
            ->where('barcode', $barcode)
            ->group_by('id_item')
            ->first();
    }
}

/* End of file Masuk_model.php */
