<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk extends MY_Controller {

    public function index($page = null)
    {
            $data['title'] = 'Form Masuk';
            $data['nav'] = 'Masuk - Input Surat Jalan';
            $data['input'] = $this->defalutValueMasuk();
            $data['content'] = $this->masuk->fetchAll();
            $data['page'] = 'pages/masuk/index';
            $this->view($data);
            
    }

    public function create(){

        if (!$_POST) {
            $input = $this->defalutValueMasuk();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->masuk->validate()) {
			$data['title']			= 'Tambah Produk';
            $data['content']        = $this->masuk->fetchAll();
			$data['input']			= $input;
			$data['page']			= $data['page'] = 'pages/masuk/index';

			$this->view($data);
			return;
		}

        $masuk = $this->masuk->run($input);
        if ($masuk) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            
            redirect(base_url("detailmasuk/$masuk"));
            
        }else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url('masuk'));
        }
    }

    public function defalutValueMasuk(){
        
        return (object) $this->masuk->getDefaultValues();
    }


}

/* End of file Masuk.php */
