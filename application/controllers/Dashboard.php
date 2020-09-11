<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        require_once APPPATH.'third_party/PHPExcel.php';
        
        $this->excel = new PHPExcel(); 
        $this->load->model('model_dashboard');

        if ($_SESSION['data_user']['status'] != "login") {
            $_SESSION['res_'] = 'Silahkan login terlebih dahulu untuk melanjutkan!';
			redirect(base_url("index.php/login"));
        }
        
        error_reporting(0);
    }

    function index()
    {
        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();
        $data['list_mahasiswa'] = $this->model_dashboard->get_data_mahasiswa_by_tahun_limit_5();

        foreach ($data['list_mahasiswa'] as $key => $item) {
            $data['list_mahasiswa'][$key]['total_mahasiswa_by_tahun'] = count($this->model_dashboard->get_mahasiswa_by_tahun($item['angkatan']));
        }

        $data['total_mahasiswa'] = count($this->model_dashboard->get_data_mahasiswa());

        // HEADER
        $this->load->view('template/header', $data);
        // BODY
        $this->load->view('dashboard_index', $data);
        // FOOTER
        $this->load->view('template/footer', $data);
    }

	function manual_count()
	{
        // CONSTRUCT
        if ($_SESSION['type'] == 'auto') {
            redirect(base_url().'index.php/dashboard/auto_count');
        }

        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();

        // HEADER
        $this->load->view('template/header', $data);
        // BODY
        $this->load->view('dashboard_manual', $data);
        // FOOTER
        $this->load->view('template/footer', $data);
    }

	function auto_count()
	{
        // CONSTRUCT
        if ($_SESSION['type'] == 'manual') {
            redirect(base_url().'index.php/dashboard/manual_count');
        }

        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();
        $data['tahun'] = $this->model_dashboard->get_data_mahasiswa_by_tahun();

        // HEADER
        $this->load->view('template/header', $data);
        // BODY
        $this->load->view('dashboard_auto', $data);
        // FOOTER
        $this->load->view('template/footer', $data);
    }    

	function count()
	{
        $validation = !empty($_POST['validation']) ? $_POST['validation'] : '';

        $data = !empty($validation) ? $_SESSION['data'] : $_POST['tahun'];
        $a = !empty($validation) ? $_POST['a'] : 0.1;
        $_1a = 1 - $a;

        // Exponential Smoothing
        foreach ($data as $key => $item) {
            if ($key != $key + 1) {
                $ftkey = $key == 0 ? 0 : $key - 1;

                $_SESSION['data'][$key] = array(
                    'no' => $key + 1,
                    'a' => round($a, 5),
                    'Yt' => !empty($validation) ? $item['Yt'] : $item,
                    '1-a' => $_1a
                );

                if ($key != 0) {
                    $_SESSION['data'][$key]['Ft'] = round($_SESSION['data'][$key]['1-a'] * $_SESSION['data'][$ftkey]['nFt'] , 5);
                } 
                
                else if ($key == 0) {
                    $_SESSION['data'][$key]['Ft'] = round($_SESSION['data'][$key]['Yt'] * $_SESSION['data'][$key]['1-a'], 5);
                }

                $_SESSION['data'][$key]['axYt'] = $_SESSION['data'][$key]['a'] * $_SESSION['data'][$key]['Yt'];
                $_SESSION['data'][$key]['nFt'] = round($_SESSION['data'][$key]['axYt'] + $_SESSION['data'][$key]['Ft'] ,5);
            }
        }

        // TEMP SOLUTIONS
        $__data = $_SESSION['data'];

        foreach ($_SESSION['data'] as $key => $item) {
            $_SESSION['mov_1_temp_1'][$key]['no'] = $__data[$key]['no'] + 3;
            
            if ($key != $key + 1) {
                $_SESSION['mov_1_temp_2'][$key] = array(
                    'rma' => $key == 0 ? round(($__data[0]['Yt'] + $__data[1]['Yt'] + $__data[2]['Yt']) / 3 ,5) : round(($__data[0 + $key]['Yt'] + $__data[1 + $key]['Yt'] + $__data[2 + $key]['Yt']) / 3 ,5),
                    'res' => $__data[2 + $key]['nFt'],
                    'reality' => !empty($__data[3 + $key]['Yt']) ? $__data[3 + $key]['Yt'] : 0
                );

                $_SESSION['mov_1'][$key] = array_merge($_SESSION['mov_1_temp_1'][$key], $_SESSION['mov_1_temp_2'][$key]);

                $_SESSION['mov_2'][$key]['rma_temp'] = ($_SESSION['mov_1'][$key]['rma'] - $_SESSION['mov_1'][$key]['reality']);
                $_SESSION['mov_2'][$key]['res_temp'] = ($_SESSION['mov_1'][$key]['res'] - $_SESSION['mov_1'][$key]['reality']);    

                $_SESSION['mov_2'][$key] = array(
                    'no' => $_SESSION['mov_1'][$key]['no'],
                    'rma' => round($_SESSION['mov_2'][$key]['rma_temp'] * $_SESSION['mov_2'][$key]['rma_temp'] ,5),
                    'res' => round($_SESSION['mov_2'][$key]['res_temp'] * $_SESSION['mov_2'][$key]['res_temp'] ,5)
                );
                
                unset($_SESSION['mov_2'][$key]['res_temp'], $_SESSION['mov_2'][$key]['rma_temp']);
            }
        }

        $last_key = end(array_keys($_SESSION['data']));

        $_SESSION['final_exponential'] = round($_SESSION['data'][$last_key]['nFt'], 5);
        $_SESSION['moving_average'] = round(($_SESSION['data'][$last_key]['Yt'] + $_SESSION['data'][$last_key - 1]['Yt'] + $_SESSION['data'][$last_key - 2]['Yt']) / 3, 5);
        $_SESSION['status'] = 'Y';

        $_SESSION['type'] = 'manual';
        $_SESSION['res'] = 'Data berhasil terhitung!';

        redirect(base_url().'index.php/dashboard/manual_count');
    }

	function res_auto_count()
	{
        $dari_tahun = $_POST['dari_tahun'];
        $sampai_tahun = $_POST['sampai_tahun'];

        $validation = !empty($_POST['validation']) ? $_POST['validation'] : '';
        
        if (empty($validation)) {
            $get_tahun = $this->model_dashboard->get_tahun($dari_tahun, $sampai_tahun);
        }

        $data = !empty($validation) ? $_SESSION['data'] : $get_tahun;
        $a = !empty($validation) ? $_POST['a'] : 0.1;
        $_1a = 1 - $a;

        // Exponential Smoothing
        foreach ($data as $key => $item) {
            if ($key != $key + 1) {
                $ftkey = $key == 0 ? 0 : $key - 1;

                if (empty($validation)) {
                    $item['total_mahasiswa_by_tahun'] = count($this->model_dashboard->get_mahasiswa_by_tahun($item['angkatan']));
                }

                $_SESSION['data'][$key] = array (
                    'tahun_angkatan' => $item['angkatan'],
                    'no' => $key + 1,
                    'a' => round($a, 5),
                    'Yt' => !empty($validation) ? $item['Yt'] : $item['total_mahasiswa_by_tahun'],
                    '1-a' => $_1a
                );

                
                if ($key != 0) {
                    $_SESSION['data'][$key]['Ft'] = round($_SESSION['data'][$key]['1-a'] * $_SESSION['data'][$ftkey]['nFt'] , 5);
                } 
                
                else if ($key == 0) {
                    $_SESSION['data'][$key]['Ft'] = round($_SESSION['data'][$key]['Yt'] * $_SESSION['data'][$key]['1-a'], 5);
                }

                $_SESSION['data'][$key]['axYt'] = $_SESSION['data'][$key]['a'] * $_SESSION['data'][$key]['Yt'];
                $_SESSION['data'][$key]['nFt'] = round($_SESSION['data'][$key]['axYt'] + $_SESSION['data'][$key]['Ft'] ,5);          
            }      
        }

        // TEMP SOLUTIONS
        $__data = $_SESSION['data'];

        foreach ($_SESSION['data'] as $key => $item) {
            $_SESSION['mov_1_temp_1'][$key]['no'] = $__data[$key]['no'] + 3;

            if ($key != $key + 1) {
                $_SESSION['mov_1_temp_2'][$key] = array(
                    'rma' => $key == 0 ? round(($__data[0]['Yt'] + $__data[1]['Yt'] + $__data[2]['Yt']) / 3 ,5) : round(($__data[0 + $key]['Yt'] + $__data[1 + $key]['Yt'] + $__data[2 + $key]['Yt']) / 3 ,5),
                    'res' =>  $__data[2 + $key]['nFt'],
                    'reality' => !empty($__data[3 + $key]['Yt']) ? $__data[3 + $key]['Yt'] : 0
                );

                $_SESSION['mov_1'][$key] = array_merge($_SESSION['mov_1_temp_1'][$key], $_SESSION['mov_1_temp_2'][$key]);

                $_SESSION['mov_2'][$key]['rma_temp'] = ($_SESSION['mov_1'][$key]['rma'] - $_SESSION['mov_1'][$key]['reality']);
                $_SESSION['mov_2'][$key]['res_temp'] = ($_SESSION['mov_1'][$key]['res'] - $_SESSION['mov_1'][$key]['reality']);  

                $_SESSION['mov_2'][$key] = array(
                    'no' => $_SESSION['mov_1'][$key]['no'],
                    'rma' => round($_SESSION['mov_2'][$key]['rma_temp'] * $_SESSION['mov_2'][$key]['rma_temp'] ,5),
                    'res' => round($_SESSION['mov_2'][$key]['res_temp'] * $_SESSION['mov_2'][$key]['res_temp'] ,5)
                );
                
                unset($_SESSION['mov_2'][$key]['res_temp'], $_SESSION['mov_2'][$key]['rma_temp']);
            }
        }

        $last_key = end(array_keys($_SESSION['data']));

        $_SESSION['final_exponential'] = round($_SESSION['data'][$last_key]['nFt'], 5);
        $_SESSION['final_tahun_angkatan'] = $_SESSION['data'][$last_key]['tahun_angkatan'] + 1;
        $_SESSION['moving_average'] = round(($_SESSION['data'][$last_key]['Yt'] + $_SESSION['data'][$last_key - 1]['Yt'] + $_SESSION['data'][$last_key - 2]['Yt']) / 3, 5);
        $_SESSION['status'] = 'Y';

        $_SESSION['type'] = 'auto';
        $_SESSION['res'] = 'Data berhasil terhitung!';

        redirect(base_url().'index.php/dashboard/auto_count');
    }    

	// function reset()
	// {
    //     $tahun_angkatan = !empty($_SESSION['final_tahun_angkatan']) ? $_SESSION['final_tahun_angkatan'] : '';
    //     $fields = !empty($_SESSION['field_total']) ? $_SESSION['field_total'] : '';
    //     unset($_SESSION['data'],  $_SESSION['mov_1'],  $_SESSION['mov_2'], $_SESSION['status'],  $_SESSION['final_exponential'],  $_SESSION['moving_average'], $tahun_angkatan, $fields);
    //     $_SESSION['res'] = 'Penghitungan berhasil direset!';

    //     if ($_SESSION['type'] == 'manual') {
    //         unset($_SESSION['type']);
    //         redirect(base_url().'index.php/dashboard/manual_count');
    //     }
    //     else {
    //         unset($_SESSION['type']);
    //         redirect(base_url().'index.php/dashboard/auto_count');
    //     }
    // }

    function pengaturan()
    {
        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();

        // HEADER
        $this->load->view('template/header', $data);
        // BODY
        $data['pengaturan'] = $this->model_dashboard->get_settings();
        $this->load->view('dashboard_pengaturan', $data);
        // FOOTER
        $this->load->view('template/footer', $data);
    }

    function pengaturan_update()
    {
        $data = $_POST['data'];
        $update = $this->model_dashboard->update_pengaturan($data);

        if ($update) {
            $_SESSION['res'] = 'Pengaturan aplikasi berhasil diperbarui!';
        } else {
            $_SESSION['res'] = 'Terjadi kesalahan, ketika mengupdate data silahkan coba lagi!';
        }

        redirect(base_url().'index.php/dashboard/pengaturan');
    }

    function manajemen_akses()
    {
        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();
        $data['list_ma'] = $this->model_dashboard->get_manajemen_akses();

        // HEADER
        $this->load->view('template/header', $data);
        // BODY
        $data['pengaturan'] = $this->model_dashboard->get_settings();
        $this->load->view('dashboard_manajemen_akses', $data);
        // FOOTER
        $this->load->view('template/footer', $data);
    }

    function manajemen_akses_update()
    {
        $data = !empty($_POST['data']) ? $_POST['data'] : $_POST['_data'];
        $id = $data['id'];

        $req_id = !empty($_REQUEST['del_id']) ? $_REQUEST['del_id'] : '';
        $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '';

        if ($req_id) {
            if ($status != 'UTAMA') {
                $delete = $this->model_dashboard->update_delete_manajemen_akses($req_id);
            }

            else if ($status == 'UTAMA') {
                $delete = 000;
            }

            if ($delete != 000) {
                $_SESSION['res'] = 'User berhasil terhapus!';
            } else if ($delete == 000) {
                $_SESSION['res'] = 'Terjadi kesalahan, ketika menghapus user karena status user tersebut adalah utama!';
            } else {
                $_SESSION['res'] = 'Terjadi kesalahan, ketika menghapus user silahkan coba lagi!';
            }
        }

        else {
            $config['upload_path']          = './profile_imgs/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 500;

            $this->load->library('upload', $config);

            $this->upload->do_upload('foto');

            $res_img = array('upload_data' => $this->upload->data());
            $data['foto'] = !empty($res_img['upload_data']['file_name']) ? $res_img['upload_data']['file_name'] : $data['foto_old'];

            if ($res_img['upload_data']['file_name']) {
                unset($_SESSION['data_user']['foto']);
                $_SESSION['data_user']['foto'] = $res_img['upload_data']['file_name'];
            }

            $unlink = !empty($res_img['upload_data']['file_name']) ? unlink('./profile_imgs/'.$data['foto_old']) : '';

            $update = $this->model_dashboard->update_manajemen_akses($data);

            if ($update) {
                if ($id == 0) {
                    $_SESSION['res'] = 'User berhasil ditambahkan!';
                } else {
                    $_SESSION['res'] = 'User berhasil diperbarui!';
                }
            } else {
                $_SESSION['res'] = 'Terjadi kesalahan, ketika mengupdate/menambahkan user silahkan coba lagi!';
            }
            
        }

        redirect(base_url().'index.php/dashboard/manajemen_akses');
    }

    function data_mahasiswa()
    {
        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();
        $data['list_mahasiswa'] = $this->model_dashboard->get_data_mahasiswa();

        // HEADER
        $this->load->view('template/header', $data);
        // BODY
        $this->load->view('dashboard_data_mahasiswa', $data);
        // FOOTER
        $this->load->view('template/footer', $data);  
        // DATA TABLES
        $this->load->view('template/data_tables', $data);        
    }

    function data_mahasiswa_update()
    {
        $data = !empty($_POST['data']) ? $_POST['data'] : $_POST['_data'];
        $id = $data['id'];

        $req_id = !empty($_REQUEST['del_id']) ? $_REQUEST['del_id'] : '';

        if ($req_id) {
            $delete = $this->model_dashboard->update_delete_data_mahasiswa($req_id);

            if ($delete) {
                $_SESSION['res'] = 'User berhasil terhapus!';
            } else {
                $_SESSION['res'] = 'Terjadi kesalahan, ketika menghapus user silahkan coba lagi!';
            }
        }

        else {

            $update = $this->model_dashboard->update_data_mahasiswa($data);
            
            if ($update == 'nim_sudah_ada') {
                $_SESSION['res'] = 'Data tidak ditambahkan, karena nim sudah ada didatabase';
            }

            else if ($update != 'nim_sudah_ada') {
                if ($id == 0) {
                    $_SESSION['res'] = 'User berhasil ditambahkan!';
                } else {
                    $_SESSION['res'] = 'User berhasil diperbarui!';
                }
            } 
            
            else {
                $_SESSION['res'] = 'Terjadi kesalahan, ketika mengupdate/menambahkan user silahkan coba lagi!';
            }

        }

        redirect(base_url().'index.php/dashboard/data_mahasiswa');
    }

    function import_mahasiswa()
    {
        // MAX UPLOAD SIZE 8MB
        $config['upload_path']          = './import/';
        $config['max_size']             = 8024;

        $this->load->library('upload', $config);
        $this->upload->do_upload('data');

        $res = array('upload_data' => $this->upload->data());

        $validation_xls = substr($_FILES["data"]["name"], -3);

        if ($validation_xls == 'xls') {
            $file_info = pathinfo($_FILES["data"]["name"]);
            $file_directory = "import/";
            $new_file_name = date("d-m-Y ") . rand(000000, 999999) .".". $file_info["extension"];
            
            if (move_uploaded_file($_FILES["data"]["tmp_name"], $file_directory . $new_file_name)) {   
                $file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
                $objReader	= PHPExcel_IOFactory::createReader($file_type);
                $objPHPExcel = $objReader->load($file_directory . $new_file_name);
                $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                
                foreach($sheet_data as $data) {   
                    if ($data["A"] != 'no' && $data["B"] != 'nim') {

                        $get_dm = $this->model_dashboard->get_data_mahasiswa_by_nim($data["B"]); // if nim exists then update it not insert it

                        $result = array(
                            "id" => !empty($get_dm) ? $get_dm["id"] : 0,
                            "nim" => !empty($get_dm) ? $get_dm["nim"] : $data["B"],
                            "nama_lengkap" => $data["C"],
                            "jurusan" => $data["D"],
                            "angkatan" => $data["E"],
                            "status" => $data["F"]
                        );

                        $update = $this->model_dashboard->update_data_mahasiswa($result);

                        if ($update) {
                            $_SESSION['res'] = 'Data mahasiswa berhasil terimport!';
                        } else {
                            $_SESSION['res'] = 'Terjadi kesalahan, ketika mengimport data mahasiswa silahkan coba lagi!';
                        }
                    }
                }
            }

        }

        redirect(base_url().'index.php/dashboard/data_mahasiswa');
    }

    function res_field()
    {
        $tahun_berapa = $_POST['tahun_berapa'];
        $_SESSION['field_total'] = $tahun_berapa;

        $_SESSION['res'] = 'Field berhasil ditambahkan!';

        redirect(base_url().'index.php/dashboard/manual_count');
    }

    function reset_field()
    {
        unset($_SESSION['field_total']);

        $_SESSION['res'] = 'Field berhasil direset!';
        redirect(base_url().'index.php/dashboard/manual_count');
    }

    function logout()
    {
        $this->session->sess_destroy();
		redirect(base_url('index.php/login'));
    }
}
