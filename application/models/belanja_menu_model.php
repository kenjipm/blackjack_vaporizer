<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Belanja_Menu_Model extends CI_Model {
	var $tabel = 't_belanja_menu';
        
	public function __construct() {
		parent::__construct();
	}
    
	function get($id){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id = ".$id.
		"";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result[0];
	}
    
	function get_menu($id_belanja){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id_belanja = ".$id_belanja."
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
    
	function is_ada_nama($nama){
		$result = array();
		$query = "
			SELECT * FROM $this->tabel
			WHERE nama = '".$nama."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return (count($result) > 0);
	}
	
	function count_by_order_id_and_menu_sequence($order_id, $menu_sequence){
		$query = "
			SELECT COUNT(*) AS jml_menu FROM $this->tabel 
			WHERE id_order = $order_id
            AND menu_sequence = $menu_sequence
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result[0]->jml_menu;
	}
	
	function update_by_order_id_and_menu_sequence($order_id, $menu_sequence, $data){
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
			WHERE id_order = $order_id
            AND menu_sequence = $menu_sequence
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
	
	function delete_from_id_order($id_order){
		$query = "
			DELETE 
			FROM $this->tabel
			WHERE id_order = $id_order
		";
		$this->db->query($query);
	}
}
?>