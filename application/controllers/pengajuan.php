<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengajuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
    }

    public function index()
    {
        $data['rak'] = $this->data_model->getallrak();
        $data['title'] = "Pengajuan RAK";
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();

        $this->form_validation->set_rules('id_pengguna', 'id_pengguna', 'required|trim');
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required|trim');
        $this->form_validation->set_rules('tujuan', 'Tujuan Kegiatan', 'required|trim');
        $this->form_validation->set_rules('sasaran', 'Sasaran Kegiatan', 'required|trim');
        $this->form_validation->set_rules('waktu', 'Waktu Kegiatan', 'required|trim');
        $this->form_validation->set_rules('anggaran', 'Anggaran Kegiatan', 'required|trim');
        $this->form_validation->set_rules('periode', 'periode', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/rak', $data);
            $this->load->view('template/footer');
        } else {
            $this->data_model->insertRAK();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pengguna Berhasi ditambahkan</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pengajuan');
        }
    }
    public function kirimRAK()
    {
        $data['title'] = "Pengajuan RAK";
        $data['rak'] = $this->data_model->getallrak();
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();

        $this->form_validation->set_rules('ormawa', 'ormawa', 'required|trim');
        $this->form_validation->set_rules('periode', 'periode', 'required|trim');
        $this->form_validation->set_rules('pengajuan', 'pengajuan', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/rak', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'pengajuan' => $this->input->post('pengajuan'),
                'id_ormawa' => $this->input->post('id_ormawa'),
                'periode' => $this->input->post('periode'),
            ];
            $this->db->insert('acc', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>RAK berhasil Terkirim</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pengajuan');
        }
    }
    public function proposal()
    {
        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Proposal";
        $data['coba'] = $this->data_model->getAllpengguna();
        $data['rak'] = $this->data_model->getallrak();
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();

        $this->form_validation->set_rules('id_pengguna', 'id_pengguna', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/proposal', $data);
            $this->load->view('template/footer');
        }
    }
    public function proposal1($id)
    {
        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Pendahuluan";
        $data['coba'] = $this->data_model->getAllpengguna();
        $data['rak'] = $this->data_model->getrakId($id);
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();

        $this->form_validation->set_rules('id_rak', 'id RAK', 'required|trim');
        $this->form_validation->set_rules('latar_belakang', 'Latar Belakang', 'required|trim');
        $this->form_validation->set_rules('tema_kegiatan', 'Tema Kegiatan', 'required|trim');
        $this->form_validation->set_rules('jam_pelaksanaan', 'Jam Pelaksanaan', 'required|trim');
        $this->form_validation->set_rules('waktu_kegiatan', 'Jam Pelaksanaan', 'required|trim');
        $this->form_validation->set_rules('pelaksanaan_selesai', 'Jam selesi Pelaksanaan', 'required|trim');
        $this->form_validation->set_rules('tujuan_pelaksanaan', 'Tujuan Pelaksanaan', 'required|trim');
        $this->form_validation->set_rules('sasaran_peserta', 'Sasaran Peserta', 'required|trim');
        $this->form_validation->set_rules('tempat', 'Tempat Kegiatan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/proposal1', $data);
            $this->load->view('template/footer');
        } else {
            $this->data_model->insertPendahuluan();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pendahuluan berhasil ditambahkan</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pengajuan/proposal2/' . $id);
        }
    }
    public function proposal2($id)
    {
        $data['rak'] = $this->data_model->getrakId($id);
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();
        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Kepanitiaan";
        $data['panitia'] = $this->data_model->selectPanitia();

        $this->form_validation->set_rules('nama_panitia', 'Nama Panitia', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('pengajuan', 'pengajuan', 'required|trim');
        $this->form_validation->set_rules('id_rak', 'id rak', 'required|trim');
        $this->form_validation->set_rules('id_pengguna', 'id penggun', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/proposal2', $data);
            $this->load->view('template/footer');
        } else {
            $this->data_model->insertPanitia();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Kepanitiaan berhasil ditambahkan</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pengajuan/proposal2/' . $id);
        }
    }
    public function proposal3($id)
    {

        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Anggaran";
        $data['rak'] = $this->data_model->getrakId($id);
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();
        $data['anggaran'] = $this->data_model->selectAnggaran();

        $this->form_validation->set_rules('id_rak', 'id_rak', 'trim|required');
        $this->form_validation->set_rules('id_pengguna', 'id_pengguna', 'trim|required');
        $this->form_validation->set_rules('bagian', 'bagian', 'trim|required');
        $this->form_validation->set_rules('barang', 'barang', 'trim|required');
        $this->form_validation->set_rules('harga', 'harga', 'trim|required');
        $this->form_validation->set_rules('quality', 'quality', 'trim|required');
        $this->form_validation->set_rules('pengajuan', 'pengajuan', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/proposal3', $data);
            $this->load->view('template/footer');
        } else {
            $this->data_model->insertAnggaran();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>anggaran berhasil ditambahkan</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pengajuan/proposal3/' . $id);
        }
    }
    public function proposal4($id)
    {

        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Jadwal Kegiatan";
        $data['rak'] = $this->data_model->getrakId($id);
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();
        $data['jadwal'] = $this->data_model->selectjadwal();

        $this->form_validation->set_rules('id_pengguna', 'id pengguna', 'trim|required');
        $this->form_validation->set_rules('id_rak', 'id rak', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
        $this->form_validation->set_rules('mulai', 'mulai', 'trim|required');
        $this->form_validation->set_rules('selesai', 'selesai', 'trim|required');
        $this->form_validation->set_rules('kegiatan', 'kegiatan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
        $this->form_validation->set_rules('pengajuan', 'pengajuan', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar');
            $this->load->view('pengajuan/proposal4', $data);
            $this->load->view('template/footer');
        } else {
            $this->data_model->insertjadwal();
            redirect('pengajuan/proposal4/' . $id);
        }
    }
    public function lpj1()
    {
        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Anggaran";
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar');
        $this->load->view('pengajuan/lpj1', $data);
        $this->load->view('template/footer');
    }
    public function lpj2()
    {
        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Anggaran";
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();


        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar');
        $this->load->view('pengajuan/lpj2', $data);
        $this->load->view('template/footer');
    }
    public function lpj3()
    {
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();


        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Anggaran";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('pengajuan/lpj3', $data);
        $this->load->view('template/footer');
    }
    public function lpj4()
    {
        $data['pengguna'] = $this->data_model->sessionpengguna();
        $data['menu'] = $this->data_model->menu();

        $data['title'] = "Pengajuan Poposal";
        $data['judul'] = "Lembar Anggaran";
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('pengajuan/lpj4', $data);
        $this->load->view('template/footer');
    }
}
