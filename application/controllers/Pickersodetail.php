<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Pagination $pagination
 * @property Pickersodetail_model $pickersodetail
 */
class Pickersodetail extends MY_Controller
{
    const ERROR_INVALID_DATA = 'Data tidak valid';
    const ERROR_SAVE_FAILED = 'Gagal menyimpan data';
    const ERROR_UPDATE_FAILED = 'Gagal memperbarui data';
    const ERROR_FETCH_FAILED = 'Gagal mengambil data';
    const ERROR_TRY_CATCH = 'Terjadi kesalahan saat mengambil data';
    const ERROR_FIELD_EMPTY = 'Field tidak boleh kosong';
    const SUCCESS_SAVE = 'Data berhasil disimpan';
    const SUCCESS_UPDATE = 'Data berhasil diperbarui';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('curl');
        $is_login    = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index($nopol = null, $page = 1)
    {
        if (!$nopol || !preg_match('/^[A-Z0-9]+$/', $nopol)) {
            $this->session->set_flashdata('error', self::ERROR_INVALID_DATA . ' Ekspedisi');
            redirect('pickerso');
        }

        try {
            $result = $this->pickersodetail->getSODetails($nopol);

            if (empty($result) || !isset($result->data->so[0])) {
                throw new Exception(self::ERROR_INVALID_DATA);
            }

            $data['content'] = $result->data->so[0]->details;
            $data['nopol'] = $nopol;
            $data['supir'] = $result->data->so[0]->supir;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil detail SO: ' . $e->getMessage());
            $this->session->set_flashdata('error', self::ERROR_FETCH_FAILED);
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
        $requiredFields = ['id', 'nopol', 'supir', 'id_toko', 'toko', 'brg', 'rak', 'qty'];
        $data = [];

        foreach ($requiredFields as $field) {
            if (!isset($postData[$field]) || empty($postData[$field])) {
                $response = ['status' => 'error', 'message' => self::ERROR_FIELD_EMPTY . " $field"];
                echo json_encode($response);
                return;
            }
            $data[$field] = $postData[$field];
        }
        $data['user'] = $this->session->userdata('username');

        try {

            if (!$this->pickersodetail->run($data)) {
                $response = ['status' => 'error', 'message' => self::ERROR_SAVE_FAILED];
                echo json_encode($response);
                return;
            }

            $url = $this->config->item('base_url_api') . "/so/picker_so";
            $apiKey = $this->config->item('api_key');
            $postData = json_encode(['id' => $data['id'], 'nopol' => $data['nopol']]);
            $headers = [
                "X-API-KEY: $apiKey",
                "Content-Type: application/json"
            ];
            $response = curl_request($url, 'POST', $postData, $headers);
            $result = json_decode($response, true);
            if (isset($result['status']) && $result['status'] === 'success') {
                $response = [
                    'status' => 'success',
                    'message' => self::SUCCESS_SAVE,
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => $result['message'] ?? self::ERROR_SAVE_FAILED,
                ];
            }
        } catch (Exception $e) {
            log_message('error', self::ERROR_TRY_CATCH . ' ' . $e->getMessage());
            $response = [
                'status' => 'error',
                'message' => self::ERROR_TRY_CATCH,
            ];
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
