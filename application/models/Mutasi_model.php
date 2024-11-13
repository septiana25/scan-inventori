<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_model extends MY_Model
{

    protected $table = '';
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
            'barcode'        => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'barcode',
                'label' => 'Barcode',
                'rules'    => 'trim|required'
            ]
        ];

        return $validationRules;
    }

    public function getBarcodeAPIAllData()
    {
        $url = $this->config->item('base_url_api') . "/mutasi";
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', [], ["X-API-KEY: $apiKey"]);
        return json_decode($response);
    }

    public function saveBarcodeAPI($data)
    {

        $url = $this->config->item('base_url_api') . "/mutasi/save";
        $apiKey = $this->config->item('api_key');
        $postData = json_encode(
            [
                'idRak' => $data['idRak'],
                'idDetailSaldo' => $data['idDetailsaldo'],
                'qty' => $data['qty'],
                'user' => $data['user']
            ]
        );

        $headers = [
            "X-API-KEY: $apiKey",
            "Content-Type: application/json"
        ];
        $response = curl_request($url, 'POST', $postData, $headers);
        return json_decode($response);
    }
}

/* End of file Returns_model.php */