<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Keluar_model $keluar
 */
class Keluar extends MY_Controller
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

    public function index($no_plat = 0)
    {



        $data['title'] = 'Form Keluar Scan';
        $data['nav'] = 'Keluar - Scan Kendaraan';
        $data['input'] = $this->defalutValueKeluar();
        $data['content'] = $this->api($no_plat);
        $data['form_action'] = "keluar/create/$no_plat";
        $data['page'] = "pages/keluar/index";
        $this->view($data);
    }

    public function create($no_plat)
    {

        if (!$_POST) {
            $input = $this->defalutValueKeluar();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        /* if (empty($this->api($no_plat))) {
            $this->session->set_flashdata('error', 'Barcode Tidak Ada');
                redirect(base_url("keluar/$no_plat"));
                exit;
        } */
        //var_dump($input->no_plat);exit;

        if (!$this->keluar->validate()) {

            $data['title'] = 'Form Keluar Scan';
            $data['nav'] = 'Keluar - Scan Kendaraan';
            $data['input'] = $input;
            $data['content'] = $this->api($input->no_plat);
            $data['form_action'] = "keluar/create";
            $data['page'] = "pages/keluar/index";
            $this->view($data);
        }


        redirect(base_url("keluar/$input->no_plat"));
    }

    /**
     * Call API at INVENTORI KUS
     */
    private function api($no_plat)
    {

        /* Begin Curl */

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost/apiinvkus/api/keluar/$no_plat",
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
            redirect(base_url("keluar"));
            exit;
        } else {

            return json_decode($response);
        }
    }

    /**
     * set defalut input buat function index
     */
    public function defalutValueKeluar()
    {

        return (object) $this->keluar->getDefaultValues();
    }
}

/* End of file Keluar.php */
