<?php
class model_dashboard extends CI_Model {
    
    //  CONSTRUCT

    public function __construct()
    {
        $this->load->database();
    }

    // GET
    
    public function get_settings()
    { 
        $query = $this->db->get_where('ci_pengaturan', array('id' => 1));
        return $query->row_array();
    }

    public function get_manajemen_akses()
    { 
        $query = $this->db->get('ci_manajemen_akses');
        return $query->result_array();
    }

    public function get_data_mahasiswa()
    { 
        $query = $this->db->get('ci_data_mahasiswa');
        return $query->result_array();
    }    

    public function get_data_mahasiswa_by_tahun()
    { 
        $this->db->distinct();
        $this->db->select('angkatan');
        $this->db->order_by("angkatan", "asc");

        $query = $this->db->get('ci_data_mahasiswa');
        return $query->result_array();
    } 

    public function get_data_mahasiswa_by_tahun_limit_5()
    { 
        $this->db->distinct();
        $this->db->select('angkatan');
        $this->db->order_by("angkatan", "desc");

        $query = $this->db->get('ci_data_mahasiswa', 5);
        return $query->result_array();
    }    

    public function get_tahun($dari_tahun, $sampai_tahun)
    { 
        $this->db->distinct();
        $this->db->select('angkatan');
        $this->db->where('angkatan >=', $dari_tahun);
        $this->db->where('angkatan <=', $sampai_tahun);
        $this->db->order_by("angkatan", "asc");

        $query = $this->db->get('ci_data_mahasiswa');
        return $query->result_array();
    }

    public function get_mahasiswa_by_tahun($params) {
        $this->db->where('angkatan', $params);
        
        $query = $this->db->get('ci_data_mahasiswa');
        return $query->result_array();
    }

    public function get_data_mahasiswa_by_nim($params)
    { 
        $this->db->select('id, nim');

        $this->db->where('nim', $params);
        $query = $this->db->get('ci_data_mahasiswa');
        return $query->row_array();
    } 

    // UPDATE

    public function update_pengaturan($params)
    {
        $data = array(
            'nama_aplikasi' => $params['nama_aplikasi'],
            'deskripsi_aplikasi' => $params['deskripsi_aplikasi'],
            'intro_aplikasi' => $params['intro_aplikasi'],
            'pembuat_aplikasi' => $params['pembuat_aplikasi']
        );

        $this->db->where('id', 1);
        return $this->db->update('ci_pengaturan', $data);
    }

    public function update_manajemen_akses($params)
    {
        $data = array(
            'username' => $params['username'],
            'nama_lengkap' => $params['nama_lengkap'],
            'foto' => !empty($params['foto']) ? $params['foto'] : '',
            'primary' => !empty($params['primary']) ? $params['primary'] : 0
        );

        if ($params['password'] != 123456) {
            $data___ = array(
                'password' => md5($params['password'])
            );

            $data_s = array_merge($data___, $data);
            $data = $data_s;
        }

        if ($params['id'] == 0) {
            date_default_timezone_set("Asia/Jakarta");
            $date_added = date("d/m/Y").'&nbsp;('.date("h:i:sa").')';
            $data_ = array(
                'password' => md5($params['password']),
                'added' => $date_added,
                'last_login' => ''
            );

            $_data = array_merge($data, $data_);
            return $this->db->insert('ci_manajemen_akses', $_data);
        } else {
            if ($data['primary'] == 1) {
                $update_first = $this->db->where('primary', '1');
                $last_update = $this->db->update('ci_manajemen_akses', array('primary' => 0));
                
                $where_for_last_update = $this->db->where('id', $params['id']);
                $last_update = $this->db->update('ci_manajemen_akses', $data);

                return true;
            } else {
                $this->db->where('id', $params['id']);
                return $this->db->update('ci_manajemen_akses', $data);
            }
        }
    }
    
    public function update_delete_manajemen_akses($id)
    {
        $query_get = $this->db->get_where('ci_manajemen_akses', array('id' => $id));
        $res = $query_get->row_array();

        $unlink = unlink('./profile_imgs/'.$res['foto']);
        
        $this->db->where('id', $id);
        return $this->db->delete('ci_manajemen_akses');
    }

    public function update_data_mahasiswa($params)
    {
        $data = array(
            'nim' => $params['nim'],
            'nama_lengkap' => $params['nama_lengkap'],
            'jurusan' => $params['jurusan'],
            'angkatan' => $params['angkatan'],
            'status' => $params['status'],
        );

        if ($params['id'] == 0) {
            $query_get = $this->db->get_where('ci_data_mahasiswa', array('nim' => $data['nim']));
            $res = $query_get->row_array();

            if ($res) {
                return 'nim_sudah_ada';
            }

            else {
                return $this->db->insert('ci_data_mahasiswa', $data);
            }

        } else {
            $this->db->where('id', $params['id']);
            return $this->db->update('ci_data_mahasiswa', $data);
        }
    }

    public function update_delete_data_mahasiswa($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('ci_data_mahasiswa');
    }
}