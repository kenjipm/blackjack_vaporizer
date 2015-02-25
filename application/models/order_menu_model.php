<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Order_Menu_Model extends CI_Model {
	var $tabel = 't_order_menu';
        
	public function __construct() {
		parent::__construct();
	}
    
	// function get($id_order, $id_menu){
		// $query = "
			// SELECT * FROM $this->tabel
			// WHERE id_order= ".$id_order."
            // AND id_menu = ".$id_menu."
		// ";
		// $query = $this->db->query($query);
		// return $query->result();
	// }
    
	function get($id){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id = ".$id.
		"";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result[0];
	}
    
	function get_menu($id_order){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id_order= ".$id_order."
		";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	function get_by_order_id_and_menu_sequence($order_id, $menu_sequence){
		$query = "
			SELECT * FROM $this->tabel 
			WHERE id_order = $order_id
            AND menu_sequence = $menu_sequence
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result[0];
	}
	
	function count_total_payment_from_id_order($order_id){
		$query = "
			SELECT SUM(harga) AS total_payment FROM $this->tabel 
			WHERE id_order = $order_id
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->total_payment:0;
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
    
	function set_done($id, $value){
		$query = "
			UPDATE $this->tabel
			SET done = $value , waktu_done = ". (($value=='false')?"NULL":"CURRENT_TIMESTAMP") ."
            WHERE id = ".$id."
		";
		$this->db->query($query);
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
		// buat update stok barang
		$query1 = "
			SELECT * FROM $this->tabel
			WHERE id_order = $id_order
		";
		$query1 = $this->db->query($query1);
		$order_menus = $query1->result();
		$result = array();
		foreach ($order_menus as $order_menu)
		{
			if (isset($result[$order_menu->id_menu]))
			{
				$result[$order_menu->id_menu]++;
			}
			else
			{
				$result[$order_menu->id_menu] = 1;
			}
		}
		
		$query = "
			DELETE 
			FROM $this->tabel
			WHERE id_order = $id_order
		";
		$this->db->query($query);
		
		return $result;
	}
}
?>