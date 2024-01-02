<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Detailkeluar extends MY_Controller
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

    public function index($id = 0)
    {
        if ($this->detailkeluar->fetchById($id) <= 0) {

            /* Begin Curl */

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $this->config->item('base_url_api') . "/keluarbyid/$id",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY:ian123"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            /* END Curl */

            var_dump($response);
            exit;

            if ($err) {
                //echo "cURL Error #:" . $err;
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan API');
                redirect(base_url("detailkeluar/$id"));
            }
            $input = (object) json_decode($response);
            $this->detailkeluar->run($input);
        }

        $data['title'] = 'Form Keluar Scan';
        $data['nav'] = 'Keluar - Scan Barang';
        $data['input'] = $this->defalutValueKeluarDet($id);
        $data['content'] = $this->detailkeluar->fetchById($id);
        $data['form_action'] = "detailkeluar/create/$id";
        $data['page'] = "pages/keluar/detailkeluar";
        $this->view($data);
    }

    public function create($id)
    {

        if (!$_POST) {
            $input = $this->defalutValueKeluarDet($id);
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->detailkeluar->validate()) {
            $data['title'] = 'Form Keluar Scan';
            $data['nav'] = 'Keluar - Scan Barang';
            $data['input'] = $input;
            $data['content'] = $this->detailkeluar->fetchById($id);
            $data['form_action'] = "detailkeluar/create/$id";
            $data['page'] = "pages/keluar/detailkeluar";
            $this->view($data);
            return;
        }

        /* Begin Curl */

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->config->item('base_url_api') . "/barang/$input->barcode",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-API-KEY:ian123"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        /* END Curl */


        if ($err) {
            //echo "cURL Error #:" . $err;
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan API');
            redirect(base_url("detailkeluar/$id"));
        } else {

            $res = json_decode($response);

            if (empty($res)) {
                $this->session->set_flashdata('error', 'Barcode Tidak Ada');
                redirect(base_url("detailkeluar/$id"));
            }

            //push data object API 
            $input->id_item = $res->id_brg;
            $input->item = $res->brg;
            $input->qty = $res->qty;

            if ($this->detailkeluar->run($input)) {
                $this->session->set_flashdata('success', 'Berhasil disimpan');

                redirect(base_url("detailkeluar/$id"));
            } else {
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
                redirect(base_url("detailkeluar/$id"));
            }
        }
    }

    /**
     * set defalut input buat function index
     */
    public function defalutValueKeluarDet($id)
    {

        return (object) $this->detailkeluar->getDefaultValues($id);
    }

    /**
     * validasi jika, id_masuk di tabel masuk tidak ada atau lebih dari 1
     */
    /* public function validateIdKeluar($id){

        $this->load->model(ucfirst('keluar') . '_model', 'keluar', true);

        $keluar = $this->keluar->totalRowsKeluar($id);
        if ($keluar <= 0 || $keluar > 1) {
            return true;
        }
    } */
}

/* End of file Detailkeluar.php */
