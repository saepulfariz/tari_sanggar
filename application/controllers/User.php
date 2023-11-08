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
        $this->load->model('UserModel', 'user');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['user'] = $this->user->select('tb_user.*, nama_role')->join('tb_role', 'tb_role.id = tb_user.id_role')->findAll();
        $this->template->load('template/index', $this->view . '/index', $data);
    }

    public function new()
    {
        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['role'] = $this->user->getRole();
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

            $res = $this->user->save($data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Add Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Add Failed');
            }
            redirect('user', 'refresh');
        }
    }

    public function edit($id)
    {
        $result = $this->user->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect('user', 'refresh');
        }

        $data['title'] = $this->title;
        $data['link'] = $this->link;
        $data['user'] = $result;
        $data['role'] = $this->user->getRole();
        $this->template->load('template/index', $this->view . '/edit', $data);
    }

    public function update($id)
    {

        $dataOld = $this->user->find($id);

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'email' => $this->input->post('email', true),
            'id_role' => $this->input->post('id_role', true),
            'is_active' => 1,
        ];

        if ($this->input->post('password') != '') {
            $data['password'] = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
        }

        if ($data['email'] == $dataOld['email']) {
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
                    if ($dataOld['image'] != 'user.png') {
                        @unlink($config['upload_path'] . $dataOld['image']);
                    }
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect('profile/edit', 'refresh');
                }
            }

            $res = $this->user->update($id, $data);
            if ($res) {
                $this->alert->set('success', 'Success', 'Update Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Update Failed');
            }
            redirect('user', 'refresh');
        }
    }





    public function delete($id)
    {
        $result = $this->user->find($id);

        if (!$result) {
            $this->alert->set('warning', 'Warning', 'Not Valid');
            redirect('user', 'refresh');
        }

        $res = $this->user->delete($id);
        if ($res) {
            $this->alert->set('success', 'Success', 'Delete Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Delete Failed');
        }
        redirect('user', 'refresh');
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
        $res = $this->user->update($id, $data);
        if ($res) {
            $this->alert->set('success', 'Success', 'Status Success');
        } else {
            $this->alert->set('warning', 'Warning', 'Status Failed');
        }
        redirect('user', 'refresh');
    }


    public function prosesGantipass()
    {
        $dataOld = $this->user->find($this->session->userdata('id_user'));


        $password_lama = $this->input->post('password_lama', true);
        $password_baru = $this->input->post('password_baru', true);
        $password_retype = $this->input->post('password_retype', true);
        if (password_verify($password_lama, $dataOld['password'])) {

            if ($password_baru == $password_retype) {
                $data = [
                    'password' => password_hash($password_baru, PASSWORD_DEFAULT)
                ];

                $this->user->update($this->session->userdata('id_role'), $data);
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
        $data['user'] = $this->user->select('tb_user.*, nama_role')->join('tb_role', 'tb_role.id = tb_user.id_role')->find($this->session->userdata('id_user'));
        $this->template->load('template/index', $this->view . '/profile', $data);
    }


    public function editProfile()
    {
        $data['title'] = 'Profile Edit';
        $data['user'] = $this->user->select('tb_user.*, nama_role')->join('tb_role', 'tb_role.id = tb_user.id_role')->find($this->session->userdata('id_user'));
        $this->template->load('template/index', $this->view . '/profile_edit', $data);
    }

    public function prosesProfile()
    {
        $dataOld = $this->user->find($this->session->userdata('id_user'));

        $data = [
            'email' => $this->input->post('email'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
        ];

        if ($data['email'] == $dataOld['email']) {
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
                    if ($dataOld['image'] != 'user.png') {
                        @unlink($config['upload_path'] . $dataOld['image']);
                    }
                } else {
                    $this->alert->set('warning', 'Warning', 'Image Failed');
                    redirect('profile/edit', 'refresh');
                }
            }

            $res = $this->user->update($this->session->userdata('id_user'), $data);

            if ($res) {
                $this->alert->set('success', 'Success', 'Update Success');
            } else {
                $this->alert->set('warning', 'Warning', 'Update Failed');
            }
            redirect('profile', 'refresh');
        }
    }
}
