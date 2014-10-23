<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Finance_Kas_Tunai_Model extends CI_Model {
	var $tabel = 't_finance_kas_tunai';
        
	public function __construct() {
		parent::__construct();
	}
    
	function get($id){
		$query = "
			SELECT * FROM $this->tabel
			 WHERE id = ".$id."
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result[0];
	}
    
	function get_all(){
		$result = array();
		$query = "
			SELECT * FROM $this->tabel
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
	}
    
	function insert($data){
		$keys = '';
		$values = '';
		$start = true;
		foreach($data as $key => $value){
			if($start){
				$keys .="$key";
				$values .="'$value'";
				$start = false;
			}else{
				$keys .=", $key";
				$values .=", '$value'";
			}
		}
		
		$query = "
			INSERT INTO $this->tabel 
			($keys) VALUES ($values)
		";
		$this->db->query($query);
		return $this->db->insert_id();
	}
	
	function update($id, $data){
		$val = '';
		$start = true;
		foreach($data as $key => $value){
			if($start){
				$val .="$key = '$value'";
				$start = false;
			}else{
				$val .=", $key = '$value'";
			}
		}
		
		$query = "
			UPDATE $this->tabel 
			SET $val
			WHERE id = $id
		";
		$this->db->query($query);
	}
	
	function delete($id){
		$query = "
			DELETE 
			FROM $this->tabel
			WHERE id = $id
		";
		$this->db->query($query);
	}
	
    function get_all_current_month($month, $year){
		$query = "
			SELECT * FROM $this->tabel
			WHERE MONTH(waktu) = ".$month."
			AND YEAR(waktu) = ".$year."
		";
		$query = $this->db->query($query);
		$orders = $query->result();
		$result = $orders;
		
		return $result;
	}
	
    function get_all_current_session_tutup_buku($session_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE session_tutup_buku_no = ".$session_no."
		";
		$query = $this->db->query($query);
		$orders = $query->result();
		$result = $orders;
		
		return $result;
	}
}
?>