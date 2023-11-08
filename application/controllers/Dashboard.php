<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();
    cekLogin();
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $this->template->load('template/index', 'dashboard/index', $data);
  }
}
