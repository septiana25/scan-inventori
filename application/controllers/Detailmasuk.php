<?php

use function PHPSTORM_META\type;

defined('BASEPATH') OR exit('No direct script access allowed');

class Detailmasuk extends MY_Controller {
    

    public function index($id){
        
        if ($this->validateIdMasuk($id)) {
            redirect(base_url("masuk"));
        }

        $data['title'] = 'Form Masuk Scan';
        $data['nav'] = 'Masuk - Scan Barang';
        $data['input'] = $this->defalutValueMasukDet($id);
        $data['content'] = $this->detailmasuk->fetchById($id);
        $data['form_action'] = "detailmasuk/create/$id";
        $data['page'] = "pages/masuk/detailmasuk";
        $this->view($data);

    }

    public function create($id){
        
        if (!$_POST) {
            $input = $this->defalutValueMasukDet($id);
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if ($this->validateIdMasuk($id) || $this->validateIdMasuk($input->id_masuk)) { 
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url("masuk"));
        }

        if (!$this->detailmasuk->validate()) {
            $data['title'] = 'Form Masuk Scan';
            $data['nav'] = 'Masuk - Scan Barang';
            $data['input'] = $input;
            $data['content'] = $this->detailmasuk->fetchById($id);
            $data['form_action'] = "detailmasuk/create/$id";
            $data['page'] = "pages/masuk/detailmasuk";
            $this->view($data);
            return;
        }

        /* Begin Curl */
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost/apiinvkus/api/barang/$input->barcode",
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
                redirect(base_url("detailmasuk/$id"));

        } else {

            $res = json_decode($response);

            if (empty($res)) {
                $this->session->set_flashdata('error', 'Barcode Tidak Ada');
                redirect(base_url("detailmasuk/$id"));
            }

            //push data object API 
            $input->id_item = $res->id_brg;
            $input->item = $res->brg;
            $input->qty = $res->qty;

            if ($this->detailmasuk->run($input)) {
                $this->session->set_flashdata('success', 'Berhasil disimpan');
                
                redirect(base_url("detailmasuk/$id"));
                
            }else {
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
                redirect(base_url("detailmasuk/$id"));
            }

        }
        
        

    }

    /**
     * set defalut input buat function index
     */
    public function defalutValueMasukDet($id){

        return (object) $this->detailmasuk->getDefaultValues($id);
    }

    /**
     * validasi jika, id_masuk di tabel masuk tidak ada atau lebih dari 1
     */
    public function validateIdMasuk($id){

        $this->load->model(ucfirst('masuk') . '_model', 'masuk', true);

        $masuk = $this->masuk->totalRowsMasuk($id);
        if ($masuk <= 0 || $masuk > 1) {
            return true;
        }
    }


}

/* End of file Detailmasuk.php */
