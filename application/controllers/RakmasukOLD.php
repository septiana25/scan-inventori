<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rakmasuk extends MY_Controller
{

    public function index($page = null)
    {
        $ban = [
            [
                'id_masuk' => 12189,
                'id_item' => 3,
                'item' => '100/70-14 M/C 51P NR 82',
                'rak' => 'A1.1',
                'qty' => 35
            ],
            [
                'id_masuk' => 12189,
                'id_item' => 2,
                'item' => '100/70-14 M/C 45P ZN 88 T/L',
                'rak' => 'A2.1',
                'qty' => 10
            ],
            [
                'id_masuk' => 12192,
                'id_item' => 2,
                'item' => '100/70-14 M/C 45P ZN 88 T/L',
                'rak' => 'A2.1',
                'qty' => 5
            ],
            [
                'id_masuk' => 12192,
                'id_item' => 3,
                'item' => '100/70-14 M/C 51P NR 82',
                'rak' => 'A1.1',
                'qty' => 30
            ]
        ];

        $dataMasuk = [];
        $no = 0;
        function groupProductsByEntryId($products)
        {
            $detail = [];
            foreach ($products as $product) {
                $idItem = $product['id_item'];
                if (!array_key_exists($idItem, $detail)) {
                    $detail[$idItem] = [];
                }
                $detail[$idItem][] = $product;
            }
            return $detail;
        }

        foreach ($this->rakmasuk->fetchAll() as $row) {
            $dataItem = new stdClass();
            $dataItem->id_item = $row->id_item;
            $dataItem->item = $row->item;
            $dataItem->total = $row->total;


            $dataDetail = groupProductsByEntryId($ban);
            if ($row->id_item == $dataDetail[$row->id_item][$no]['id_item']) {

                $dataItem->data = $dataDetail[$row->id_item];
            } else {
                $dataItem->data = [];
            }

            $dataMasuk[] = $dataItem;
            $no++;
        }

        //print_r($data);
        //die();
        $suratJalan = array(
            ''              => 'Pilih Surat Jalan',
            2525         => 'B-235325',
            4554          => 'A-35284',
            456456         => 'B-TEST'
        );

        $rak = [
            ''              => 'Pilih Rak',
            1 => 'A1.1',
            2 => 'A2.1'
        ];

        $data['title'] = 'Input Rak Masuk';
        $data['nav'] = 'Masuk - Input Rak Barang';
        $data['input'] = $this->defalutValueMasuk();
        $data['content'] = $dataMasuk;
        $data['suratJalan'] = $suratJalan;
        $data['rak'] = $rak;
        $data['form_action'] = "detailmasuk/create/";
        $data['page'] = 'pages/masuk/inputrak';
        $this->view($data);
    }

    public function defalutValueMasuk()
    {
        return (object) $this->rakmasuk->getDefaultValues();
    }
}

/* End of file Rakmasuk.php */
