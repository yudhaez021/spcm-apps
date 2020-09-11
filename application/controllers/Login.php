<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct(){
		parent::__construct();		
		$this->load->model('model_login');
        $this->load->model('model_dashboard');
    }
    
	function index()
	{
        // SET DATA FIRST
        $data['pengaturan'] = $this->model_dashboard->get_settings();

        // VIEW
		$this->load->view('before_dashboard/login', $data);
    }
    
    function send_login()
    {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
        
        $where = array(
			'username' => $username,
			'password' => md5($password)
		);
        
        $cek = $this->model_login->cek_login("ci_manajemen_akses", $where)->num_rows();
        
        if ($cek > 0) {
            $data__ = $this->model_login->login_data_get($username);
            $update_last_login = $this->model_login->update_last_login($username);

			$data_session = array(
                'username' => $username,
                'nama_lengkap' => $data__['nama_lengkap'],
                'foto' => $data__['foto'],
				'status' => "login"
            );
            
            $_SESSION['data_user'] = $data_session;
            
            $_SESSION['res'] = 'Anda berhasil login!';
			redirect(base_url("index.php/dashboard"));
 
		} else {
            $_SESSION['res_'] = 'Username / password anda salah, silahkan coba lagi!';
            redirect(base_url("index.php/login"));
		}
    }
}
