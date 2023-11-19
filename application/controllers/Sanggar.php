<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sanggar extends CI_Controller
{
    private $title = 'Sanggar';
    private $view = 'sanggar';
    private $link = 'sanggar';
    private $dir = 'assets/uploads/galleri/';
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('SanggarModel', 'model');
        $this->load->model('SanggarOrderModel', 'order');
        $this->load->model('SanggarPaketModel', 'paket');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $this->model->findAll();
        $this->template->load('template/index', $this->view . '/index', $data);
    }

    function getCalendar()
    {

        if (!$this->input->get('start') || !$this->input->get('end')) {
            echo 'Please provide a date range.';
            die;
        }

        $start = date('Y-m-d', strtotime($this->input->get('start')));
        $end = date('Y-m-d', strtotime($this->input->get('end')));
        $id_sanggar = $this->input->get('id_sanggar');
        $select_title = "status as title,";
        $data = $this->order->select("tb_sanggar_order.id,( 
            CASE 
                WHEN status = 'DONE' 
                THEN 'green' 
                ELSE 
                    CASE 
                        WHEN status = 'PENDING' 
                        THEN 'grey' 
                        ELSE 
                            CASE 
                                WHEN status = 'BOOKING' 
                                THEN 'yellow' 
                                ELSE 'red'
                            END 
                    END 
            END 
        ) as color,
        " . $select_title . "
          tanggal_acara as start, tanggal_acara as end")->where('id_sanggar', $id_sanggar)->where('tanggal_acara >', $start)->where('tanggal_acara <', $end)->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->join('tb_user', 'tb_user.id = tb_sanggar_order.id_user')->findAll();
        echo json_encode($data);
    }

    public function show($id)
    {
        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid Sanggar');
            redirect($this->link, 'refresh');
        }

        $this->load->model('SanggarPaketModel', 'paket');
        $this->load->model('SanggarGalleriModel', 'galleri');

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $result;
        $data['paket'] = $this->paket->where('id_sanggar', $id)->findAll();
        $data['galleri'] = $this->galleri->where('id_sanggar', $id)->findAll();

        $this->template->load('template/index', $this->view . '/detail', $data);
    }

    public function order()
    {

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
            $this->show($id_sanggar);
        } else {
            $data = [
                'nama_acara' => $this->input->post('nama_acara', true),
                'tanggal_acara' => $this->input->post('tanggal_acara', true),
                'waktu_mulai' => $this->input->post('waktu_mulai', true),
                'id_paket' => $this->input->post('id_paket', true),
                'domisili' => $this->input->post('domisili', true),
                'alamat' => $this->input->post('alamat', true),
                'catatan_patner' => $this->input->post('catatan_patner', true),
                'status' => 'PENDING',
                'bayar1' => 0,
                'bayar2' => 0,
                'id_user' => getProfile('id'),
                'mulai_order' => date('Y-m-d H:i:s')
            ];


            $is_dp = $this->input->post('is_dp', true);
            if ($is_dp) {
                // $data['bayar1'] = $data_paket['harga_paket'] / 2;
                $data['is_dp'] = $is_dp;
            }
            $data['sisa'] = $data_paket['harga_paket'] - ($data['bayar1'] + $data['bayar2']);


            // PENDING (DP)
            // BOOKING(DP)
            // REJECT
            // DONE(LUNAS)


            $cekDate = $this->order->where('id_sanggar', $id_sanggar)->where('status', 'BOOKING')->where('tanggal_acara', $data['tanggal_acara'])->join('tb_sanggar_paket', 'tb_sanggar_paket.id = tb_sanggar_order.id_paket')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->first();

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
                    redirect($this->link . '/' . $id_sanggar, 'refresh');
                }
            }

            $res = $this->order->save($data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Add Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Add Failed');
            }
            redirect($this->link, 'refresh');
        }
    }

    public function new()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $this->template->load('template/index', $this->view . '/new', $data);
    }


    public function create()
    {
        $this->form_validation->set_rules('nama_sanggar', 'Nama Sanggar', 'required');
        $this->form_validation->set_rules('lokasi_sanggar', 'Lokasi Sanggar', 'required');
        $this->form_validation->set_rules('tentang_sanggar', 'Tentang Sanggar', 'required');
        $this->form_validation->set_rules('no_rek', 'No Rek', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->new();
        } else {
            $data = [
                'nama_sanggar' => $this->input->post('nama_sanggar', true),
                'lokasi_sanggar' => $this->input->post('lokasi_sanggar', true),
                'tentang_sanggar' => $this->input->post('tentang_sanggar', true),
                'no_rek' => $this->input->post('no_rek', true),
            ];


            $key_name = 'image';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = $this->dir;
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
                    $data['foto_sanggar'] = $filename;
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
        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid edit');
            redirect($this->link, 'refresh');
        }

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $result;
        $this->template->load('template/index', $this->view . '/edit', $data);
    }

    public function update($id)
    {

        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect($this->link, 'refresh');
        }

        $data = [
            'nama_sanggar' => $this->input->post('nama_sanggar', true),
            'lokasi_sanggar' => $this->input->post('lokasi_sanggar', true),
            'tentang_sanggar' => $this->input->post('tentang_sanggar', true),
            'no_rek' => $this->input->post('no_rek', true),
        ];

        $this->form_validation->set_rules('nama_sanggar', 'Nama Sanggar', 'required');
        $this->form_validation->set_rules('lokasi_sanggar', 'Lokasi Sanggar', 'required');
        $this->form_validation->set_rules('tentang_sanggar', 'Tentang Sanggar', 'required');
        $this->form_validation->set_rules('no_rek', 'No Rek', 'required');




        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {

            $key_name = 'image';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = $this->dir;
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
                    $data['foto_sanggar'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/' . $id . '/edit', 'refresh');
                }
            }

            if ($result['foto_sanggar'] != 'default.jpg') {
                @unlink($this->dir . '/' . $result['foto_sanggar']);
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
            $this->alert->set('warning', 'Warning', 'Not Valid delete');
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
