<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_DB_trans $db
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
    const ERROR_API_FAILED = 'Gagal memperbarui data di API';
    const SUCCESS_SAVE = 'Data berhasil disimpan';
    const SUCCESS_UPDATE = 'Data berhasil diperbarui';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('curl');
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
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateSaveData($data)) {
            return;
        }

        $data['user'] = $this->session->userdata('username');

        try {
            $this->db->trans_begin();

            $apiResultNopolId = $this->pickersodetail->getSOPickerByNopolByIdTokoAPI($data['nopol'], $data['id']);

            if (!$this->isApiResponseSuccess($apiResultNopolId)) {
                throw new Exception(self::ERROR_API_FAILED);
            }

            if (empty($apiResultNopolId->data->so)) {
                throw new Exception(self::ERROR_FETCH_FAILED);
            }

            $baseDataObject = [
                'id' => $data['id'],
                'nopol' => $data['nopol'],
                'supir' => $data['supir'],
                'brg' => $data['brg'],
                'id_brg' => $data['id_brg'],
                'user' => $data['user'],
            ];

            foreach ($apiResultNopolId->data->so as $so) {
                $dataObject = array_merge($baseDataObject, [
                    'id_toko' => $so->id_toko,
                    'toko' => $so->toko,
                    'qty' => $so->qty_pro
                ]);

                $insertResult = $this->pickersodetail->run($dataObject);
                if (!$insertResult) {
                    throw new Exception(self::ERROR_SAVE_FAILED);
                }
            }

            $apiResult = $this->pickersodetail->updatePickerSOAPI($data['id'], $data['nopol']);
            if (!$this->isApiResponseSuccess($apiResult)) {
                throw new Exception(self::ERROR_API_FAILED);
            }
            $this->db->trans_commit();
            $response = $this->processApiResponse($apiResult);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => $e->getMessage() ?? self::ERROR_TRY_CATCH,
            ];
        }

        $this->sendJsonResponse($response);
    }

    public function update()
    {
        $post = $this->input->post(null, true);

        if (!$post) {
            $this->session->set_flashdata('error', 'Tidak ada data yang dikirim');
            redirect('pickerso');
        }

        $this->db->trans_begin();

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

    private function validateSaveData($data)
    {
        $requiredFields = ['id', 'nopol', 'supir', 'id_toko', 'toko', 'brg', 'rak', 'qty'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $this->sendJsonResponse(['status' => 'error', 'message' => self::ERROR_FIELD_EMPTY . " $field"]);
                return false;
            }
        }
        return true;
    }

    private function processApiResponse($result)
    {
        if (isset($result['status']) && $result['status'] === 'success') {
            return ['status' => 'success', 'message' => self::SUCCESS_SAVE];
        }
        return ['status' => 'error', 'message' => $result['message'] ?? self::ERROR_SAVE_FAILED];
    }

    private function sendJsonResponse($response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function isApiResponseSuccess($result)
    {
        if (is_object($result)) {
            return isset($result->status) && $result->status === 'success';
        } elseif (is_array($result)) {
            return isset($result['status']) && $result['status'] === 'success';
        } else {
            return false;
        }
    }
}
