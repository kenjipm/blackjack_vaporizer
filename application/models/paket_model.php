<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Paket_Model extends CI_Model {
	var $tabel = 't_paket';
        
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
    
	function get_from_nama($nama){
		$query = "
			SELECT * FROM $this->tabel
			 WHERE nama = '".$nama."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result[0];
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
	
	function update($data, $id){
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
	
	function update_from_nama($data, $nama){
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
			WHERE nama = $nama
		";
		$this->db->query($query);
	}
    
	function get_all_nama($search_hidden=false){
		$query = "
			SELECT nama FROM $this->tabel
		";
		if (!$search_hidden)
		{
			$query .= "WHERE hidden = 0";
		}
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
	}
    
	function get_id_from_nama($nama){
		$query = "
			SELECT id FROM $this->tabel
			WHERE nama = '".$nama."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return isset($result[0])?$result[0]->id:"";
	}
    
	function is_nama_exist($nama){
		$query = "
			SELECT id FROM $this->tabel
			WHERE nama = '".$nama."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return (count($result) > 0);
	}
}
?>