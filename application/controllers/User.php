<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $title = 'User';
    private $view = 'user';
    private $link = 'user';
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('UserModel', 'model');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $this->model->select('tb_user.*, nama_role')->join('tb_role', 'tb_role.id = tb_user.id_role')->findAll();
        $this->template->load('template/index', $this->view . '/index', $data);
    }

    public function new()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['role'] = $this->model->getRole();
        $this->template->load('template/index', $this->view . '/new', $data);
    }


    public function create()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('id_role', 'Id Role', 'required');
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required',
            array('required' => 'You must provide a %s.')
        );


        if ($this->form_validation->run() == FALSE) {
            $this->new();
        } else {
            $data = [
                'username' => $this->input->post('username', true),
                'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
                'nama_lengkap' => $this->input->post('nama_lengkap', true),
                'email' => $this->input->post('email', true),
                'nip' => $this->input->post('nip', true),
                'id_role' => $this->input->post('id_role', true),
                'is_active' => 1,
            ];

            $key_name = 'image';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/users/';
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
                    $data['image'] = $filename;
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect('profile/new', 'refresh');
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
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect($this->link, 'refresh');
        }

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['data'] = $result;
        $data['role'] = $this->model->getRole();
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
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'email' => $this->input->post('email', true),
            'id_role' => $this->input->post('id_role', true),
            'is_active' => 1,
        ];

        if ($this->input->post('password') != '') {
            $data['password'] = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
        }

        if ($data['email'] == $result['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]');
        }

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('id_role', 'Id Role', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {

            $key_name = 'image';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/users/';
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
                    $data['image'] = $filename;
                    if ($result['image'] != 'user.png') {
                        @unlink($config['upload_path'] . $result['image']);
                    }
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect('profile/edit', 'refresh');
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

        $res = $this->model->delete($id);
        if ($res) {
            $this->alert->set('success', 'Success', 'Delete Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Delete Failed');
        }
        redirect($this->link, 'refresh');
    }

    public function gantipass()
    {
        $data['title'] = 'Ganti Pass';
        $this->template->load('template/index', $this->view . '/gantipass', $data);
    }


    public function active($id, $active)
    {
        $data = [
            'is_active' => $active
        ];
        $res = $this->model->update($id, $data);
        if ($res) {
            $this->alert->set('success', 'Success', 'Status Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Status Failed');
        }
        redirect($this->link, 'refresh');
    }


    public function prosesGantipass()
    {
        $result = $this->model->find($this->session->modeldata('id_user'));


        $password_lama = $this->input->post('password_lama', true);
        $password_baru = $this->input->post('password_baru', true);
        $password_retype = $this->input->post('password_retype', true);
        if (password_verify($password_lama, $result['password'])) {

            if ($password_baru == $password_retype) {
                $data = [
                    'password' => password_hash($password_baru, PASSWORD_DEFAULT)
                ];

                $this->model->update($this->session->modeldata('id_role'), $data);
                $this->alert->set('success', 'Success', 'Password Change');
            } else {
                $this->alert->set('warning', 'Warning', 'Password Baru Beda');
            }
        } else {
            $this->alert->set('warning', 'Warning', 'Password Lama Salah');
        }

        redirect('gantipass', 'refresh');
    }


    public function profile()
    {
        $data['title'] = 'Profile';
        $data['data'] = $this->model->select('tb_user.*, nama_role')->join('tb_role', 'tb_role.id = tb_user.id_role')->find($this->session->modeldata('id_user'));
        $this->template->load('template/index', $this->view . '/profile', $data);
    }


    public function editProfile()
    {
        $data['title'] = 'Profile Edit';
        $data['data'] = $this->model->select('tb_user.*, nama_role')->join('tb_role', 'tb_role.id = tb_user.id_role')->find($this->session->modeldata('id_user'));
        $this->template->load('template/index', $this->view . '/profile_edit', $data);
    }

    public function prosesProfile()
    {
        $result = $this->model->find($this->session->modeldata('id_user'));

        $data = [
            'email' => $this->input->post('email'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
        ];

        if ($data['email'] == $result['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]');
        }

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->editProfile();
        } else {

            $key_name = 'image';

            if (!empty($_FILES[$key_name]['name'])) {
                // Set preference 
                $config['upload_path'] = 'assets/uploads/users/';
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
                    $data['image'] = $filename;
                    if ($result['image'] != 'user.png') {
                        @unlink($config['upload_path'] . $result['image']);
                    }
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect('profile/edit', 'refresh');
                }
            }

            $res = $this->model->update($this->session->modeldata('id_user'), $data);

            if ($res) {
                $this->alert->set('success', 'Success', 'Update Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Update Failed');
            }
            redirect('profile', 'refresh');
        }
    }
}
