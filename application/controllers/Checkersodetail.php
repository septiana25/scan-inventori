<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Checkerso_model $checkerso
 * @property Checkersodetail_model $checkersodetail
 */
class Checkersodetail extends MY_Controller
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

        $is_login    = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index($nopol, $id_toko)
    {
        $this->load->helper('curl');

        try {
            $this->loadModelCheckerSo();
            $result =  $this->checkerso->fetchByNopolAndIdToko($nopol, $id_toko);

            $groupedData = [];
            foreach ($result as $item) {
                if (!isset($groupedData[$item->nopol])) {
                    $groupedData[$item->nopol] = [
                        'nopol' => $item->nopol,
                        'supir' => $item->supir,
                        'id_toko' => $item->id_toko,
                        'toko' => $item->toko,
                        'detail' => []
                    ];
                }
                // Buat salinan item tanpa properti yang tidak diinginkan
                $detailItem = (array) $item;
                unset($detailItem['nopol'], $detailItem['supir'], $detailItem['id_toko'], $detailItem['toko']);

                $groupedData[$item->nopol]['detail'][] = (object) $detailItem;
            }

            $dataGroupNopol = $groupedData[$nopol];

            if (empty($dataGroupNopol)) {
                throw new Exception(self::ERROR_FETCH_FAILED);
            }

            $data['content'] = $dataGroupNopol['detail'];
            $data['supir'] = $dataGroupNopol['supir'];
            $data['toko'] = $dataGroupNopol['toko'];
            $data['nopol'] = $dataGroupNopol['nopol'];
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data SO: ' . $e->getMessage());
            $this->session->set_flashdata('error', self::ERROR_FETCH_FAILED);
            redirect(base_url("checkerso/detail/" . $nopol));
        }

        $data['title'] = 'Form Keluar';
        $data['nav'] = 'Keluar - Scan SO';
        $data['input'] = $this->defalutValueCheckerSoDet();
        $data['form_action'] = "#";
        $data['page'] = 'pages/checkerso/checkersoscan';
        $this->view($data);
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
}
