<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Detailmasuk extends MY_Controller {


    public function index(){
        if (!$_POST) {
            $input = (object) $this->detailmasuk->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->detailmasuk->validate()) {
            $data['title'] = 'Form Masuk';
            $data['input'] = $input;
            $data['nav'] = 'Masuk - Scan Barang';
            $data['page'] = 'pages/masuk/detailmasuk';
            $this->view($data);
            return;
        }

        if ($this->detailmasuk->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            
            redirect(base_url('detailmasuk'));
            
        }else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url('masuk'));
        }
    }

    public function getAll()
    {

        $data['title'] = 'Form Masuk';
        $data['nav'] = 'Masuk - Scan Barang';
        $data['content'] = $this->detailmasuk->get();
        $data['page'] = 'pages/masuk/detailmasuk';
            $this->view($data);    
    }

}

/* End of file Detailmasuk.php */
