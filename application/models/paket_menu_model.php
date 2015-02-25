<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Paket_Menu_Model extends CI_Model {
	var $tabel = 't_paket_menu';
        
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
    
	function get_all_from_id_paket($id_paket){
		$query = "
			SELECT * FROM $this->tabel
			 WHERE id_paket = ".$id_paket."
		";
		$query = $this->db->query($query);
		return $query->result();
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
	
	function delete_from_id_paket($id_paket){
		$query = "
			DELETE 
			FROM $this->tabel
			WHERE id_paket = $id_paket
		";
		return $this->db->query($query);
	}
}
?>