<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Detailmasuk extends MY_Controller {


    public function index($id){
        
        $data['title'] = 'Form Masuk Scan';
        $data['nav'] = 'Masuk - Scan Barang';
        $data['input'] = $this->defalutValueMasukDet();
        $data['content'] = $this->detailmasuk->fetchAll();
        $data['form_action'] = "detailmasuk/create/$id";
        $data['page'] = "pages/masuk/detailmasuk";
        $this->view($data);

    }

    public function create($id){

        if (!$_POST) {
            $input = $this->defalutValueMasukDet();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->detailmasuk->validate()) {
            $data['title'] = 'Form Masuk Scan';
            $data['nav'] = 'Masuk - Scan Barang';
            $data['input'] = $input;
            $data['content'] = $this->detailmasuk->fetchAll();
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

    public function defalutValueMasukDet(){

        return (object) $this->detailmasuk->getDefaultValues();
    }


}

/* End of file Detailmasuk.php */
