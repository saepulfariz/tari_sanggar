<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();
    cekLogin();
    $this->load->model('SanggarOrderModel', 'order');
    $this->load->model('SanggarPaketModel', 'paket');
    $this->load->model('SanggarModel', 'sanggar');
    $this->load->model('UserModel', 'user');
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['order_new'] = $this->order->select("COUNT(id) as jumlah")->where('status', 'PENDING')->first()['jumlah'];
    $data['order'] = $this->order->select("COUNT(id) as jumlah")->where('status !=', 'REJECT')->where('status !=', 'PENDING')->first()['jumlah'];
    $data['konsumen'] = $this->user->select("COUNT(id) as jumlah")->where('id_role', 3)->first()['jumlah'];
    $data['sanggar'] = $this->user->select("COUNT(id) as jumlah")->first()['jumlah'];
    $this->template->load('template/index', 'dashboard/index', $data);
  }
}
