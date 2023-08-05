<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk extends MY_Controller {

    public function index()
    {
            $data['title'] = 'Form Masuk';
            $data['content'] = $this->masuk->fetchAll();
            $data['input'] = $this->ifPost();
            $data['nav'] = 'Masuk - Input Surat Jalan';
            $data['page'] = 'pages/masuk/index';
            $this->view($data);
    }

    public function create(){

        $input = $this->ifPost();

        if (!$this->masuk->validate()) {
			$data['title']			= 'Tambah Produk';
            $data['content'] = $this->masuk->fetchAll();
			$data['input']			= $input;
			$data['page']			= $data['page'] = 'pages/masuk/index';

			$this->view($data);
			return;
		}

        if ($this->masuk->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            
            redirect(base_url('detailmasuk'));
            
        }else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url('masuk'));
        }
    }

    public function ifPost(){
        if (!$_POST) {
            $input = (object) $this->masuk->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        return $input;
    }


}

/* End of file Masuk.php */
