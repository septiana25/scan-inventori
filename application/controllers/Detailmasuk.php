<?php


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

        if ($this->validateIdMasuk($id)) {
            redirect(base_url("masuk"));
        }
        
        if (!$_POST) {
            $input = $this->defalutValueMasukDet($id);
        } else {
            $input = (object) $this->input->post(null, true);
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

        if ($this->detailmasuk->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            
            redirect(base_url("detailmasuk/$id"));
            
        }else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url("detailmasuk/$id"));
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
