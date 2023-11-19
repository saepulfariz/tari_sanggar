<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SanggarGalleri extends CI_Controller
{
    private $title = 'Galleri Sanggar';
    private $view = 'sanggar_galleri';
    private $link = 'sanggar/galleri';
    private $dir = 'assets/uploads/galleri/';
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('SanggarGalleriModel', 'model');
        $this->load->model('SanggarModel', 'sanggar');
    }

    public function index($id = null)
    {
        $result = $this->sanggar->find($id);

        if ($result == null) {
            // $this->alert->set('warning', 'Warning', 'Not Valid Galleri');
            redirect('sanggar', 'refresh');
        }

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['id_sanggar'] = $id;
        $data['data'] = $this->model->select('tb_sanggar_galleri.*, nama_sanggar')->join('tb_sanggar', 'tb_sanggar.id = tb_sanggar_galleri.id_sanggar')->where('id_sanggar', $id)->findAll();
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
        $this->form_validation->set_rules('id_sanggar', 'No Rek', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->new();
        } else {
            $data = [
                'id_sanggar' => $this->input->post('id_sanggar', true),
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
                    $data['gambar'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/' . $data['id_sanggar'], 'refresh');
                }
            }


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
            'id_sanggar' => $this->input->post('id_sanggar', true),
        ];

        $this->form_validation->set_rules('id_sanggar', 'No Rek', 'required');




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
                    $data['gambar'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect($this->link . '/' . $data['id_sanggar'], 'refresh');
                }
            }

            if ($result['gambar'] != 'default.jpg') {
                @unlink($this->dir . '/' . $result['gambar']);
            }

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

        if ($result['gambar'] != 'default.jpg') {
            @unlink($this->dir . '/' . $result['gambar']);
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
