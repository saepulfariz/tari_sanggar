<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sanggar extends CI_Controller
{
    private $title = 'Sanggar';
    private $view = 'sanggar';
    private $link = 'sanggar';
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('SanggarModel', 'model');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $this->model->findAll();
        $this->template->load('template/index', $this->view . '/index', $data);
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

        $res = $this->model->delete($id);
        if ($res) {
            $this->alert->set('success', 'Success', 'Delete Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Delete Failed');
        }
        redirect($this->link, 'refresh');
    }
}
