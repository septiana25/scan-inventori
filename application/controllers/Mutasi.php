<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Output $output
 * @property Mutasi_model $mutasi
 */
class Mutasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('curl');
    }

    public function index()
    {
        try {

            $response = $this->mutasi->getBarcodeAPIAllData();
            $this->validateResponse($response, "home");
            if ($response->status == 'fail') {
                throw new Exception($response->message);
            }

            $data['content'] = $response->data->mutasi;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Mutasi: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            $data['content'] = [];
        }

        $data['title'] = 'Data Mutasi';
        $data['nav'] = 'Mutasi - Belum Diproses';
        $data['field'] = 'Rak';
        $data['input'] = $this->defalutValueMutasi();
        $data['form_action'] = "mutasi";
        $data['page'] = 'pages/mutasi/index';
        $this->view($data);
    }


    public function detail($idDetailsaldo)
    {
        try {
            if (!$_POST) {
                $input = $this->defalutValueMutasi();
            } else {
                $input = (object) $this->input->post(null, true);
            }

            $response = $this->handleGetItemDetailSaldo($idDetailsaldo);
            $this->validateResponse($response, "home");
            if ($response->status == 'fail') {
                $this->session->set_flashdata('error', $response->message);
                redirect(base_url("home"));
            }

            if (!empty($input->barcode)) {
                $responseRak = $this->handleGetBarcodeRak($input->barcode);
                $this->validateResponse($responseRak, "home");
                $this->validateDataResult($responseRak->data->shelf, $idDetailsaldo);
                $idRak = $responseRak->data->shelf->idRak;

                if ($idRak == $response->data->id_rak) {
                    throw new Exception('Rak tidak berubah');
                }

                $dataMutasi = [
                    'idRak' => $idRak,
                    'idDetailsaldo' => $idDetailsaldo,
                    'qty' => $response->data->jumlah,
                    'user' => $this->session->userdata('username')
                ];

                $saveBarcode = $this->mutasi->saveBarcodeAPI($dataMutasi);

                if ($saveBarcode->status == 'fail' || $saveBarcode->status == 'error') {
                    throw new Exception($saveBarcode->message);
                }

                $this->session->set_flashdata('success', 'Data Berhasil Di Mutasi');
                redirect(base_url("saldorak"));
            }


            $data['idDetailsaldo'] = $idDetailsaldo;
            $data['content'] = $response->data;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Mutasi: ' . $e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            $data['content'] = $response->data;
        }

        $data['title'] = 'Detail Mutasi';
        $data['field'] = 'Rak';
        $data['input'] = $this->defalutValueMutasi();
        $data['form_action'] = "mutasi/detail/$idDetailsaldo";
        $data['nav'] = 'Mutasi - Detail';
        $data['page'] = 'pages/mutasi/detail';
        $this->view($data);
    }

    private function handleGetBarcodeRak($barcode)
    {
        $url = $this->config->item('base_url_api') . "/shelves/$barcode";
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
        $result = json_decode($response);
        return $result;
    }

    private function handleGetItemDetailSaldo($idDetailsaldo)
    {
        $url = $this->config->item('base_url_api') . "/item/detailSaldo/$idDetailsaldo";
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
        $result = json_decode($response);
        return $result;
    }

    private function defalutValueMutasi()
    {

        return (object) $this->mutasi->getDefaultValues();
    }

    private function validateResponse($response, $url)
    {

        if ($response == NULL || !empty($response->statusCode) || isset($response->statusCode)) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url($url));
        }
    }

    private function validateDataResult($data, $idDetailsaldo)
    {
        if (empty($data)) {
            $this->session->set_flashdata('error', 'Data Tidak Ada');
            redirect(base_url("mutasi/detail/$idDetailsaldo"));
        }
    }

    private function validateInput($data)
    {
        $requiredFields = ['barcode'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Field $field tidak boleh kosong");
            }
        }
    }

    private function sendJsonResponse($response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function handleGetDataMutasiDummy()
    {
        // Data dummy untuk testing
        $dataDummy = [
            "status" => "success",
            "data" => [
                "mutasi" => [
                    [
                        "id_brg" => 12,
                        "id_rak" => 1,
                        "brg" => "100/80-14 M/C 48P ZN 62 T/L",
                        "rak" => "A1.1",
                        "sisa" => "1"
                    ],
                    [
                        "id_brg" => 12,
                        "id_rak" => 29,
                        "brg" => "100/80-14 M/C 48P ZN 62 T/L",
                        "rak" => "A8.1",
                        "sisa" => "1"
                    ],
                    [
                        "id_brg" => 14,
                        "id_rak" => 1,
                        "brg" => "100/80-17 M/C 52P NR 85 T/L",
                        "rak" => "A1.1",
                        "sisa" => "3"
                    ],
                    [
                        "id_brg" => 14,
                        "id_rak" => 29,
                        "brg" => "100/80-17 M/C 52P NR 85 T/L",
                        "rak" => "A8.1",
                        "sisa" => "1"
                    ]
                ]
            ]
        ];

        return (object) $dataDummy;
    }
}
