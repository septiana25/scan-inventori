<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Checkersodetail_model extends MY_Model
{

    protected $table = 'checkerso';

    public function __construct()
    {
        parent::__construct();
        // Memastikan helper curl dimuat
        if (!function_exists('curl_request')) {
            $this->load->helper('curl');
        }
    }

    public function getDefaultValues()
    {
        return [
            'barcode'   => '',
            'unit'      => 'pack',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'barcode',
                'label' => 'Barcode',
                'rules' => 'trim|required',
            ]
        ];

        return $validationRules;
    }

    public function run($input)
    {
        $data = [
            'id_pic'      => $input->id_pic,
            'qty_scan'        => $input->qty_scan,
            'user'          => $input->username,
        ];

        return $this->create($data);
    }

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

    public function checkBarcodeAPI($barcode)
    {
        $url = $this->config->item('base_url_api') . "/item/" . urlencode($barcode);
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
        return json_decode($response);
    }
}

/* End of file Approvedrak_model.php */
