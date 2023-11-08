<?php


function helloAku()
{
    return 'Say Hello';
}

function d($variable)
{
    var_dump($variable);
}

function dd($variable)
{
    var_dump($variable);
    die;
}

function cekLogin()
{
    $CI = &get_instance();
    if (!$CI->session->userdata('id_user')) {
        redirect('auth', 'refresh');
    }


    $segment = $CI->uri->segment(1);
    if ($segment == 'user') {
        if ($CI->session->userdata('id_role') != 1) {
            $CI->alert->set('warning', 'Warning', 'Gak bisa akses');
            redirect('dashboard', 'refresh');
        }
    }
}


function getProfile($field = null)
{
    $CI = &get_instance();

    $CI->db->where('id', $CI->session->userdata('id_user'));
    $data = $CI->db->get('tb_user')->row_array();
    if ($field != null) {
        return $data[$field];
    } else {
        return $data;
    }
}


function copyright($year = null)
{
    $tahun_start = ($year == null) ? '2023' : $year;
    $tahun_now = date('Y');
    if ($tahun_start == $tahun_now) {
        return $tahun_start;
    } else {
        return $tahun_start . '-' . $tahun_now;
    }
}
