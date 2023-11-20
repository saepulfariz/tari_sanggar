<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    private $title = 'Laporan';
    private $view = 'laporan';
    private $link = 'laporan';
    private $dir = 'assets/uploads/bukti/';
    private $status = [
        'PENDING',
        'BOOKING',
        'REJECT',
        'DONE',
    ];
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('SanggarOrderModel', 'model');
        $this->load->model('SanggarPaketModel', 'paket');
        $this->load->model('SanggarModel', 'sanggar');
        $this->load->model('UserModel', 'user');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $this->model->select('tb_sanggar_order.*, nama_lengkap, nama_paket, harga_paket, nama_sanggar')->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->join('tb_user', 'tb_user.id = tb_sanggar_order.id_user')->orderBy('mulai_order', 'DESC')->findAll();
        $this->template->load('template/index', $this->view . '/index', $data);
    }
}
