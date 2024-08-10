<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Pickerso_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        // Memastikan helper curl dimuat
        if (!function_exists('curl_request')) {
            $this->load->helper('curl');
        }
    }


    public function getAllSO()
    {
        $url = $this->config->item('base_url_api') . "/so";
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
        return json_decode($response);
    }
}
