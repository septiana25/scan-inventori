<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Barangkerak_model extends MY_Model
{
    protected $table = 'masuk_det';

    public function fetchByIdMasukIdItem($id_item, $result = [])
    {
        $id_masuk = [];
        foreach ($result as $row) {
            $id_masuk[] = $row->id_msk;
        }

        return $this->select(
            [
                'id_item',
                'MAX(masuk_det.id_masuk) AS id_masuk',
                'MAX(suratJalan) AS suratJalan',
                'MAX(item) AS item',
                'SUM(qty) AS total'
            ]
        )
            ->join('masuk', 'masuk.id_masuk = masuk_det.id_masuk')
            ->where_in('masuk_det.id_masuk', $id_masuk)
            ->where('id_item', $id_item)
            ->group_by('id_item')
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

/* End of file Barangkerak_model.php */
