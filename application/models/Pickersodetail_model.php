<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Pickersodetail_model extends MY_Model
{
    protected $table = 'pickerso';

    public function __construct()
    {
        parent::__construct();
        // Memastikan helper curl dimuat
        if (!function_exists('curl_request')) {
            $this->load->helper('curl');
        }
    }

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

    public function getSODetails($nopol)
    {
        $url = $this->config->item('base_url_api') . "/so/" . urlencode($nopol);
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
        return json_decode($response);
    }

    public function updatePickerSOAPI($id, $nopol)
    {
        $url = $this->config->item('base_url_api') . "/so/picker_so";
        $apiKey = $this->config->item('api_key');
        $postData = json_encode(['id' => $id, 'nopol' => $nopol]);
        $headers = [
            "X-API-KEY: $apiKey",
            "Content-Type: application/json"
        ];
        $response = curl_request($url, 'POST', $postData, $headers);
        return json_decode($response, true);
    }
}
