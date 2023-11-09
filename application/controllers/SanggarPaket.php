<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SanggarPaket extends CI_Controller
{
    private $title = 'Paket Sanggar';
    private $view = 'sanggar_paket';
    private $link = 'sanggar/paket';
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('SanggarPaketModel', 'model');
        $this->load->model('SanggarModel', 'sanggar');
    }

    public function index($id = null)
    {
        $result = $this->sanggar->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect('sanggar', 'refresh');
        }

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['id_sanggar'] = $id;
        $data['data'] = $this->model->select('tb_sanggar_paket.*, nama_sanggar')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_paket.id_sanggar')->where('id_sanggar', $id)->findAll();
        $this->template->load('template/index', $this->view . '/index', $data);
    }

    public function new($id = null)
    {
        $result = $this->sanggar->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect('sanggar', 'refresh');
        }

        $data['title'] = $this->title;
        $data['id_sanggar'] = $id;
        $data['link'] = $this->link;
        $this->template->load('template/index', $this->view . '/new', $data);
    }


    public function create()
    {
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('keterangan_paket', 'Keterangan Paket', 'required');
        $this->form_validation->set_rules('harga_paket', 'Harga Paket', 'required');
        $this->form_validation->set_rules('id_sanggar', 'No Rek', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->new();
        } else {
            $data = [
                'nama_paket' => $this->input->post('nama_paket', true),
                'keterangan_paket' => $this->input->post('keterangan_paket', true),
                'harga_paket' => $this->input->post('harga_paket', true),
                'id_sanggar' => $this->input->post('id_sanggar', true),
            ];


            $res = $this->model->save($data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Add Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Add Failed');
            }
            redirect($this->link . '/' . $data['id_sanggar'], 'refresh');
        }
    }

    public function edit($id)
    {
        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
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
            'nama_paket' => $this->input->post('nama_paket', true),
            'keterangan_paket' => $this->input->post('keterangan_paket', true),
            'harga_paket' => $this->input->post('harga_paket', true),
            'id_sanggar' => $this->input->post('id_sanggar', true),
        ];

        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('keterangan_paket', 'Keterangan Paket', 'required');
        $this->form_validation->set_rules('harga_paket', 'Harga Paket', 'required');
        $this->form_validation->set_rules('id_sanggar', 'No Rek', 'required');




        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {


            $res = $this->model->update($id, $data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Update Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Update Failed');
            }
            redirect($this->link . '/' . $data['id_sanggar'], 'refresh');
        }
    }





    public function delete($id)
    {
        $result = $this->model->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect($this->link, 'refresh');
        }

        $res = $this->model->delete($id);
        if ($res) {
            $this->alert->set('success', 'Success', 'Delete Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Delete Failed');
        }
        redirect($this->link . '/' . $result['id_sanggar'], 'refresh');
    }
}
