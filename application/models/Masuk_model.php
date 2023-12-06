<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Masuk_model extends MY_Model
{

    protected $perPage = 5;

    public function getDefaultValues()
    {
        return [
            'suratJalan'      => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'suratJalan',
                'label' => 'Surat Jalan',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

    public function run($input)
    {
        $data = [
            'id_masuk' => $input->idMsk,
            'suratJalan' => $input->suratJln,
        ];

        return $this->create($data);
    }

    public function fetchAll()
    {
        return $this->select(
            [
                'id_masuk',
                'suratJalan'
            ]
        )->get();
    }

    public function fetchById($id)
    {
        return $this->select('id_masuk, suratJalan')
            ->where('id_masuk', $id)
            ->first();
    }

    public function totalRows()
    {
        return $this->count();
    }

    public function totalRowsMasuk($id)
    {
        return $this->where(
            'id_masuk',
            $id
        )->count();
    }
}

/* End of file Masuk_model.php */
