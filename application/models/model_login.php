<?php 

class model_login extends CI_Model {	

    // LOGIN

	public function cek_login($table, $where) {		
		return $this->db->get_where($table, $where);
    }
    
    public function login_data_get($params)
    { 
        $this->db->select('nama_lengkap, foto');
        $this->db->where('username', $params);
        
        $query = $this->db->get('ci_manajemen_akses');
        return $query->row_array();
    } 

    public function update_last_login($params)
    { 
        date_default_timezone_set("Asia/Jakarta");
        $date_login = date("d/m/Y").'&nbsp;('.date("h:i:sa").')';

        $data = array(
            "last_login" => $date_login
        );
        
        $this->db->where('username', $params);
        return $this->db->update('ci_manajemen_akses', $data);
    }     
}