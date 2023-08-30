<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Detailkeluar extends MY_Controller {

    public function index($id)
    {
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

    /**
     * set defalut input buat function index
     */
    public function defalutValueKeluarDet($id){

        return (object) $this->detailmasuk->getDefaultValues($id);
    }

    /**
     * validasi jika, id_masuk di tabel masuk tidak ada atau lebih dari 1
     */
    public function validateIdMasuk($id){

        $this->load->model(ucfirst('keluar') . '_model', 'keluar', true);

        $keluar = $this->keluar->totalRowsKeluar($id);
        if ($keluar <= 0 || $keluar > 1) {
            return true;
        }
    }

}

/* End of file Detailkeluar.php */
