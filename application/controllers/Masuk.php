<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Masuk_model $masuk
 */
class Masuk extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $is_login    = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        /* Begin Curl */
        $this->load->helper('curl');

        try {
            $url = $this->config->item('base_url_api') . "/po";
            $apiKey = $this->config->item('api_key');
            $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            if (!$result || !isset($result->data->po)) {
                throw new Exception('Data PO tidak valid');
            }

            $data['content'] = $result->data->po;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data PO: ' . $e->getMessage());
            $data['content'] = [];
        }

        $data['title'] = 'Form Masuk';
        $data['nav'] = 'Masuk - Daftar PO Masuk';
        $data['page'] = 'pages/masuk/index';
        $this->view($data);
    }

    public function create()
    {

        if (!$_POST) {
            $input = $this->defalutValueMasuk();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->masuk->validate()) {
            $data['title']            = 'Tambah Produk';
            $data['content']        = $this->masuk->fetchAll();
            $data['input']            = $input;
            $data['page']            = $data['page'] = 'pages/masuk/index';

            $this->view($data);
            return;
        }

        $masuk = $this->masuk->run($input);
        if ($masuk) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');

            redirect(base_url("detailmasuk/$masuk"));
        } else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url('masuk'));
        }
    }

    public function defalutValueMasuk()
    {

        return (object) $this->masuk->getDefaultValues();
    }
}

/* End of file Masuk.php */
