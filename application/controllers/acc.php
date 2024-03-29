<?php
defined('BASEPATH') or exit('No direct script access allowed');

class acc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('acc_model');
        $this->load->model('data_model');
    }
    public function acc_pengajuan()
    {
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();
        $user =  $this->data_model->sessionpengguna();
        //menampilkan acc pengajuan berdasarkan level
        switch ($user['level_id']) {
            case 1; //kemahasiswaan
                $data['acc'] =  $this->acc_model->accKemahasiswaan();
                break;
            case 2; //biro akademik
                $data['acc'] =  $this->acc_model->accbiro();
                break;
            case 3; // depm
                $data['acc'] =  $this->acc_model->accdpm();
                break;
            case 6; //kaprodi
                $data['acc'] =  $this->acc_model->acckaprodi();
                break;
            default:
                if ($user['level_id'] = 5) { // jika hmj yang mengajukan
                    $data['acc'] =  $this->acc_model->accbemHMJ();
                } else { //jika ukm yang mengajukan
                    $data['acc'] =  $this->acc_model->accbem();
                }
                break;
        }

        $data['title'] = "Acc Pengajuan";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar');
        $this->load->view('acc/acc_pengajuan');
        $this->load->view('template/footer');
    }
    public function detail_pengajuan($id)
    {
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $user =  $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();
        //menampilkan nama untuk judul rak
        $data['nama'] = $this->acc_model->tampilnama($id);
        //menampilkan rak berdasarkan id acc
        $data['detail_rak'] = $this->acc_model->getaccbyid($id);
        // menampilkan id acc
        $data['id'] = $this->acc_model->getidacc($id);
        //menampilkan acc pengajuan berdasarkan level
        switch ($user['level_id']) {
            case 1; //kemahasiswaan
                $data['acc'] =  $this->acc_model->accKemahasiswaan();
                break;
            case 2; //biro akademik
                $data['acc'] =  $this->acc_model->accbiro();
                break;
            case 3; // depm
                $data['acc'] =  $this->acc_model->accdpm();
                break;
            case 6; //kaprodi
                $data['acc'] =  $this->acc_model->acckaprodi();
                break;
            default:
                if ($user['level_id'] = 5) { // jika hmj yang mengajukan
                    $data['acc'] =  $this->acc_model->accbemHMJ();
                } else { //jika ukm yang mengajukan
                    $data['acc'] =  $this->acc_model->accbem();
                }
                break;
        }
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('acc', 'acc', 'trim|required');
        // $this->form_validation->set_rules('status', 'status', 'trim|required');
        // $this->form_validation->set_rules('revisi', 'revisi', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Acc Pengajuan";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('acc/detail');
            $this->load->view('template/footer');
        } else {
            $this->acc_model->detailacc();
            $this->session->set_flashdata('message', '
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Berhasil Terkirim</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');

            redirect('acc/acc_pengajuan');
        }
    }
}
