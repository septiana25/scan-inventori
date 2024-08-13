<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_DB_trans $db
 * @property Checkerso_model $checkerso
 * @property Checkersodetail_model $checkersodetail
 * @property Pickersodetail_model $pickersodetail
 */
class Checkersodetail extends MY_Controller
{
    const ERROR_INVALID_DATA = 'Data tidak valid';
    const ERROR_SAVE_FAILED = 'Gagal menyimpan data';
    const ERROR_UPDATE_FAILED = 'Gagal memperbarui data';
    const ERROR_STOCK_INSUFFICIENT = 'Stok tidak cukup';
    const ERROR_FETCH_FAILED = 'Gagal mengambil data';
    const ERROR_TRY_CATCH = 'Terjadi kesalahan saat mengambil data';
    const ERROR_FIELD_EMPTY = 'Field tidak boleh kosong';
    const ERROR_API_EMPTY = 'Data tidak ditemukan';
    const ERROR_API_FAILED = 'Gagal mengambil data dari API';
    const SUCCESS_SAVE = 'Data berhasil disimpan';
    const SUCCESS_UPDATE = 'Data berhasil diperbarui';
    const ERROR_TRANSACTION_FAILED = 'Transaksi gagal';

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

    public function index($nopol, $id_toko)
    {
        try {
            $this->loadModelCheckerSo();
            $result = $this->checkerso->fetchAllGroupedByNopol($nopol, $id_toko);

            $dataGroupNopol = $result[$nopol];

            if (empty($dataGroupNopol) || empty($result)) {
                throw new Exception(self::ERROR_FETCH_FAILED);
            }

            $data['content'] = $dataGroupNopol['detail'];
            $data['supir'] = $dataGroupNopol['supir'];
            $data['id_toko'] = $dataGroupNopol['id_toko'];
            $data['toko'] = $dataGroupNopol['toko'];
            $data['nopol'] = $dataGroupNopol['nopol'];
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data SO: ' . $e->getMessage());
            $this->session->set_flashdata('error', self::ERROR_FETCH_FAILED);
            redirect(base_url("checkerso/detail/" . $nopol));
        }

        $data['title'] = 'Form Keluar';
        $data['nav'] = 'Keluar - Scan SO';
        $data['page'] = 'pages/checkerso/checkersoscan';
        $this->view($data);
    }

    public function save()
    {
        $this->loadModelPickerSoDetail();
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            // Validasi input
            if (!$this->validateInput($data)) {
                return;
            }

            $checkBarcode = $this->checkersodetail->checkBarcodeAPI($data['barcode']);

            if (!$this->isApiResponseSuccess($checkBarcode)) {
                throw new Exception(self::ERROR_API_FAILED);
            }

            if (empty($checkBarcode->data->item)) {
                throw new Exception(self::ERROR_API_EMPTY . "/Barcode Salah");
            }

            $resultBarcode = $checkBarcode->data->item[0];
            $resultPicker = $this->pickersodetail->fetchByIdBrgByNopol($data['nopol'], $resultBarcode->id_brg);

            if (empty($resultPicker)) {
                throw new Exception(self::ERROR_API_EMPTY . " Di Picker");
            }

            $perUnit = ($data['unit'] == 'pcs') ? 1 : $resultBarcode->qty_pack;

            $this->db->trans_begin();

            $remainingQty = $perUnit;
            foreach ($resultPicker as $value) {
                if ($remainingQty <= 0) {
                    break; // Keluar dari loop jika qty sudah habis
                }

                $qtyToDeduct = min($remainingQty, $value->sisa);
                $remainingQty -= $qtyToDeduct;

                $input = (object) [
                    'id_pic' => $value->id_pic,
                    'qty_scan' => $qtyToDeduct,
                    'username' => $this->session->userdata('username')
                ];

                $addChecker = $this->checkersodetail->run($input);
                if (!$addChecker) {
                    throw new Exception(self::ERROR_SAVE_FAILED);
                }

                $updatePicker = $this->pickersodetail->updatePickerSOSisa($input);
                if (!$updatePicker) {
                    throw new Exception(self::ERROR_UPDATE_FAILED . "/Kelebihan Scan");
                }
            }

            if ($remainingQty > 0) {
                throw new Exception(self::ERROR_STOCK_INSUFFICIENT);
            }


            if ($this->db->trans_status() === FALSE) {
                throw new Exception(self::ERROR_TRANSACTION_FAILED);
            }

            $this->db->trans_commit();

            $response = [
                'status' => 'success',
                'message' => self::SUCCESS_SAVE
            ];
        } catch (\Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', self::ERROR_TRY_CATCH . ' ' . $e->getMessage());
            $response = [
                'status' => 'error',
                'message' => $e->getMessage() ?? self::ERROR_TRY_CATCH,
            ];
        }
        $this->sendJsonResponse($response);
    }

    private function loadModelCheckerSo()
    {
        $this->load->model(ucfirst('checkerso') . '_model', 'checkerso', true);
        return $this;
    }

    private function defalutValueCheckerSoDet()
    {

        return (object) $this->checkersodetail->getDefaultValues();
    }

    private function processApiResponse($result)
    {
        if (isset($result['status']) && $result['status'] === 'success') {
            return ['status' => 'success', 'message' => self::SUCCESS_SAVE];
        }
        return ['status' => 'error', 'message' => $result['message'] ?? self::ERROR_SAVE_FAILED];
    }

    private function isApiResponseSuccess($result)
    {
        return isset($result->status) && $result->status === 'success';
    }

    private function sendJsonResponse($response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function validateInput($data)
    {
        $requiredFields = ['barcode', 'nopol', 'unit'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $this->sendJsonResponse(['status' => 'error', 'message' => self::ERROR_FIELD_EMPTY . " $field"]);
                return false;
            }
        }
        return true;
    }

    private function loadModelPickerSoDetail()
    {
        $this->load->model(ucfirst('pickersodetail') . '_model', 'pickersodetail', true);
        return $this;
    }
}
