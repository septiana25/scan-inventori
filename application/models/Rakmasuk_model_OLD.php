<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Rakmasuk_model extends MY_Model
{
    protected $table = 'masuk_det';
    protected $perPage = 5;

    public function getDefaultValues()
    {
        return [
            'qty'      => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'qty',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'suratJalan',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

    public function run($input)
    {
        $data = [
            'id_masuk' => $input->id_msk,
            'suratJalan' => $input->suratJln,
        ];

        return $this->create($data);
    }

    public function fetchAll()
    {
        return $this->select(
            [
                'id_masuk',
                'MAX(id_item) AS id_item',
                'MAX(item) AS item',
                'SUM(qty) AS total'
            ]
        )
            ->where_in('id_masuk', [12189, 12192])
            ->group_by('id_masuk')
            ->get();
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

/* End of file Rakmasuk_model.php */
