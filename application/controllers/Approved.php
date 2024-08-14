<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Approvedrak_model $approvedrak
 */
class Approved extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $content =  new stdClass();
        $content->suratJln = 'Surat Jalan';
        $content->id_msk = '2';

        $this->loadModelApprovedRak();
        $approvedRak = $this->approvedrak->fetchAll();


        $data['title'] = 'Approved';
        $data['nav'] = 'Approved - Manager';
        $data['content'] = $approvedRak;
        $data['page'] = 'pages/approved/index';
        $this->view($data);
    }

    public function upproverak($id)
    {
        $this->updateApprovedRak($id, 'true');
    }

    public function cancelrak($id)
    {
        $this->updateApprovedRak($id, 'cancel');
    }

    /**
     * Update Upproved or cancel Rak
     */
    private function updateApprovedRak($id, $approveValue)
    {
        $this->loadModelApprovedRak();
        $approvedRak = $this->approvedrak->fetchById($id);

        if (!$approvedRak) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('approved'));
        }

        $username = $this->session->userdata('username');

        $data  = [
            'approve' => $approveValue,
            'manager' => $username
        ];

        if ($this->approvedrak->where('id', $id)->update($data)) {
            $this->session->set_flashdata('success', 'Data berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('approved'));
    }

    private function loadModelApprovedRak()
    {
        $this->load->model(ucfirst('approvedrak') . '_model', 'approvedrak', true);
        return $this;
    }
}

/* End of file Approved.php */