<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    private $title = 'Order';
    private $view = 'order';
    private $link = 'order';
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
        if ($this->session->userdata('id_role') == 3) {
            $order = $this->model->select('tb_sanggar_order.*, nama_lengkap, nama_paket, harga_paket, nama_sanggar')->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->join('tb_user', 'tb_user.id = tb_sanggar_order.id_user')->orderBy('mulai_order', 'DESC')->where('id_user', $this->session->userdata('id_user'))->findAll();
        } else {
            $order = $this->model->select('tb_sanggar_order.*, nama_lengkap, nama_paket, harga_paket, nama_sanggar')->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->join('tb_user', 'tb_user.id = tb_sanggar_order.id_user')->orderBy('mulai_order', 'DESC')->findAll();
        }
        $data['data'] = $order;
        $this->template->load('template/index', $this->view . '/index', $data);
    }

    public function ajax_paket()
    {
        $id = $this->input->get('id', true);
        echo json_encode($this->paket->where('id_sanggar', $id)->findAll());
    }

    public function ajax_paket_detail()
    {
        $id = $this->input->get('id', true);
        echo json_encode($this->paket->find($id));
    }

    public function new()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['status'] = $this->status;
        $data['paket'] = $this->paket->findAll();
        $data['sanggar'] = $this->sanggar->findAll();
        $data['konsumen'] = $this->user->select('id, nama_lengkap')->where('id_role', 3)->findAll();
        $this->template->load('template/index', $this->view . '/new', $data);
    }


    public function create()
    {
        $this->form_validation->set_rules('id_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('id_user', 'Nama Konsumen', 'required');
        $this->form_validation->set_rules('nama_acara', 'Nama Acara', 'required');
        $this->form_validation->set_rules('tanggal_acara', 'Tanggal Acara', 'required');
        $this->form_validation->set_rules('waktu_mulai', 'Mulai Acara', 'required');
        $this->form_validation->set_rules('id_paket', 'id_paket', 'required');
        $this->form_validation->set_rules('domisili', 'domisili', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');

        $id_sanggar = $this->input->post('id_sanggar', true);
        $id_paket = $this->input->post('id_paket', true);
        $data_paket = $this->paket->find($id_paket);
        if ($this->form_validation->run() == FALSE) {
            $this->new();
        } else {
            $data = [
                'nama_acara' => $this->input->post('nama_acara', true),
                'tanggal_acara' => $this->input->post('tanggal_acara', true),
                'waktu_mulai' => $this->input->post('waktu_mulai', true),
                'id_paket' => $this->input->post('id_paket', true),
                'domisili' => $this->input->post('domisili', true),
                'alamat' => $this->input->post('alamat', true),
                'catatan_patner' => $this->input->post('catatan_patner', true),
                'status' => $this->input->post('status', true),
                'id_user' => $this->input->post('id_user', true),
                'bayar1' => $this->input->post('bayar1', true),
                'bayar2' => $this->input->post('bayar2', true),
                'mulai_order' => date('Y-m-d H:i:s')
            ];

            $data['sisa'] = $data_paket['harga_paket'] - ($data['bayar1'] + $data['bayar2']);

            $is_dp = $this->input->post('is_dp', true);
            if ($is_dp) {
                $data['is_dp'] = $is_dp;
            }


            // PENDING (DP)
            // BOOKING(DP)
            // REJECT
            // DONE(LUNAS)


            $cekDate = $this->model->where('id_sanggar', $id_sanggar)->where('status', 'BOOKING')->where('tanggal_acara', $data['tanggal_acara'])->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->first();

            if ($cekDate) {
                $this->alert->set('warning', 'Warning', 'Udah ke booking tanggal ' . $data['tanggal_acara']);
                redirect($this->link . '/' . $id_sanggar, 'refresh');
            }

            $key_name = 'bukti_tf1';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/bukti/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '1000'; // max_size in kb 
                $config['file_name'] = $_FILES[$key_name]['name'];

                // Load upload library 
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload($key_name)) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data['bukti_tf1'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/new', 'refresh');
                }
            }

            $key_name = 'bukti_tf2';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/bukti/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '1000'; // max_size in kb 
                $config['file_name'] = $_FILES[$key_name]['name'];

                // Load upload library 
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload($key_name)) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data['bukti_tf2'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/new', 'refresh');
                }
            }

            $res = $this->model->save($data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Add Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Add Failed');
            }
            redirect($this->link, 'refresh');
        }
    }

    public function edit($id)
    {
        $result = $this->model->select('tb_sanggar_order.*, id_sanggar, nama_lengkap, nama_paket, harga_paket, nama_sanggar')->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->join('tb_user', 'tb_user.id = tb_sanggar_order.id_user')->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect($this->link, 'refresh');
        }

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['status'] = $this->status;
        $data['data'] = $result;
        $data['paket'] = $this->paket->findAll();
        $data['sanggar'] = $this->sanggar->findAll();
        $data['konsumen'] = $this->user->select('id, nama_lengkap')->where('id_role', 3)->findAll();
        $this->template->load('template/index', $this->view . '/edit', $data);
    }

    public function update($id)
    {

        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect($this->link, 'refresh');
        }

        // $this->form_validation->set_rules('id_paket', 'Nama Paket', 'required');
        // $this->form_validation->set_rules('id_user', 'Nama Konsumen', 'required');
        $this->form_validation->set_rules('nama_acara', 'Nama Acara', 'required');
        $this->form_validation->set_rules('tanggal_acara', 'Tanggal Acara', 'required');
        $this->form_validation->set_rules('waktu_mulai', 'Mulai Acara', 'required');
        $this->form_validation->set_rules('domisili', 'domisili', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');

        $id_paket = ($this->input->post('id_paket', true)) ? $this->input->post('id_paket', true) : $result['id_paket'];
        $id_user = ($this->input->post('id_user', true)) ? $this->input->post('id_user', true) : $result['id_user'];
        $status = ($this->input->post('status', true)) ? $this->input->post('status', true) : $result['status'];
        $data_paket = $this->paket->find($id_paket);
        $id_sanggar = ($this->input->post('id_sanggar', true)) ? $this->input->post('id_sanggar', true) : $data_paket['id_sanggar'];
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'nama_acara' => $this->input->post('nama_acara', true),
                'tanggal_acara' => $this->input->post('tanggal_acara', true),
                'waktu_mulai' => $this->input->post('waktu_mulai', true),
                'id_paket' => $id_paket,
                'domisili' => $this->input->post('domisili', true),
                'alamat' => $this->input->post('alamat', true),
                'catatan_patner' => $this->input->post('catatan_patner', true),
                'status' => $status,
                'id_user' => $id_user,
                'bayar1' => $this->input->post('bayar1', true),
                'bayar2' => $this->input->post('bayar2', true),
            ];

            $data['sisa'] = $data_paket['harga_paket'] - ($data['bayar1'] + $data['bayar2']);

            $is_dp = $this->input->post('is_dp', true);
            if ($is_dp) {
                $data['is_dp'] = $is_dp;
            }

            // PENDING (DP)
            // BOOKING(DP)
            // REJECT
            // DONE(LUNAS)

            // jika tanggal lama dengan tanggal input sama maka gak perlu cek date
            if ($result['tanggal_acara'] != $data['tanggal_acara']) {
                $cekDate = $this->model->where('id_sanggar', $id_sanggar)->where('status', 'BOOKING')->where('tanggal_acara', $data['tanggal_acara'])->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->first();

                if ($cekDate) {
                    $this->alert->set('warning', 'Warning', 'Udah ke booking tanggal ' . $data['tanggal_acara']);
                    redirect($this->link . '/' . $id . '/edit', 'refresh');
                }
            }

            $key_name = 'bukti_tf1';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/bukti/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '1000'; // max_size in kb 
                $config['file_name'] = $_FILES[$key_name]['name'];

                // Load upload library 
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload($key_name)) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data['bukti_tf1'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/' . $id . '/edit', 'refresh');
                }
            }

            $key_name = 'bukti_tf2';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/bukti/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '1000'; // max_size in kb 
                $config['file_name'] = $_FILES[$key_name]['name'];

                // Load upload library 
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload($key_name)) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data['bukti_tf2'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/' . $id . '/edit', 'refresh');
                }
            }

            $res = $this->model->update($id, $data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Update Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Update Failed');
            }
            redirect($this->link, 'refresh');
        }
    }





    public function delete($id)
    {
        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect($this->link, 'refresh');
        }

        if ($result['status'] != 'PENDING') {
            $this->alert->set('warning', 'Warning', 'Order bukan status PENDING');
            redirect($this->link, 'refresh');
        }

        $res = $this->model->delete($id);
        if ($res) {
            $this->alert->set('success', 'Success', 'Delete Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Delete Failed');
        }
        redirect($this->link, 'refresh');
    }
}
