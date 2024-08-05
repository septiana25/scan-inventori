<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pickersodetail extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('curl');
    }

    public function index($nopol = null)
    {
        if (!$nopol) {
            $this->session->set_flashdata('error', 'Ekspedisi tidak valid');
            redirect('pickerso');
        }

        try {
            $url = $this->config->item('base_url_api') . "/so/$nopol";
            $apiKey = $this->config->item('api_key');
            $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            if (!$result || !isset($result->data->so[0])) {
                throw new Exception('Data SO detail tidak valid');
            }

            $data['content'] = $result->data->so[0];
            $data['nopol'] = $nopol;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil detail SO: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Gagal mengambil detail SO');
            redirect('pickerso');
        }

        $data['title'] = 'Detail Picker SO';
        $data['nav'] = 'Keluar - Detail Picker SO';
        $data['page'] = 'pages/pickerso/detail';
        $this->view($data);
    }

    public function save()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        $id = $postData['id'] ?? null;
        $nopol = $postData['nopol'] ?? null;

        if (!$id || !$nopol) {
            $response = ['status' => 'error', 'message' => 'ID atau Nopol tidak valid'];
        } else {
            try {
                $url = $this->config->item('base_url_api') . "/so/picker_so";
                $apiKey = $this->config->item('api_key');
                $postData = json_encode(['id' => $id, 'nopol' => $nopol]);
                $headers = [
                    "X-API-KEY: $apiKey",
                    "Content-Type: application/json"
                ];
                $response = curl_request($url, 'POST', $postData, $headers);
                $result = json_decode($response, true);
                if (isset($result['status']) && $result['status'] === 'success') {
                    $response = [
                        'status' => 'success',
                        'message' => 'Data berhasil disimpan',
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => $result['message'] ?? 'Gagal menyimpan data',
                    ];
                }
            } catch (Exception $e) {
                log_message('error', 'Error saat menyimpan data: ' . $e->getMessage());
                $response = [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan data',
                ];
            }
        }

        echo json_encode($response);
    }

    public function update()
    {
        $post = $this->input->post(null, true);

        if (!$post) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dikirim');
            redirect('pickerso');
        }

        try {
            $url = $this->config->item('base_url_api') . "/so/update";
            $apiKey = $this->config->item('api_key');
            $response = curl_request($url, 'POST', $post, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            if (!$result || !isset($result->status) || $result->status !== 'success') {
                throw new Exception('Gagal memperbarui data SO');
            }

            $this->session->set_flashdata('success', 'Data SO berhasil diperbarui');
        } catch (Exception $e) {
            log_message('error', 'Error saat memperbarui SO: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Gagal memperbarui data SO');
        }

        redirect('pickerso');
    }

    public function print($nopol)
    {
        // Implementasi fungsi print jika diperlukan
        // Misalnya, mengambil data SO berdasarkan nopol dan menampilkan dalam format yang siap cetak
    }
}
