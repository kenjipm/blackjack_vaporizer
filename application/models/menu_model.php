<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Menu_Model extends CI_Model {
	var $tabel = 't_menu';
        
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
        return isset($result[0])?$result[0]:"";
	}
    
	function get_all(){
		$query = "
			SELECT * FROM $this->tabel
			WHERE hidden = 0;
		";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	function get_all_include_hidden_and_order(){
		$query = "
			SELECT * FROM $this->tabel
			WHERE hidden = 0
			ORDER BY hidden, tipe_3, tipe_2, tipe, nama ASC;
		";
		$query = $this->db->query($query);
		return $query->result();
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
		return $this->db->query($query);
	}
    
	function get_all_nama_stok($search_hidden=false){
		$query = "
			SELECT id, tipe, nama, stok FROM $this->tabel
		";
		if (!$search_hidden)
		{
			$query .= " WHERE hidden = 0 ";
		}
		$query .= " ORDER BY tipe, nama ";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
	}
    
	function get_all_nama($search_hidden=false){
		$query = "
			SELECT nama FROM $this->tabel
		";
		if (!$search_hidden)
		{
			$query .= "WHERE hidden = 0 ";
		}
		$query .= " ORDER BY nama";
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
    
	function get_harga_from_nama($nama){
		$query = "
			SELECT harga FROM $this->tabel
			WHERE nama = '".$nama."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result[0]->harga;
	}
	
	function get_default_discounted_from_nama($nama){
		$query = "
			SELECT default_discounted FROM $this->tabel
			WHERE nama = '".$nama."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result[0]->default_discounted;
	}
		
	public function get_stok($id){
		$query = "
			SELECT stok FROM $this->tabel
			WHERE id = $id
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->stok:false;
	}
		
	public function set_stok($id, $value){
		$query = "
			UPDATE $this->tabel 
			SET stok = $value
			WHERE id = $id
		";
		$this->db->query($query);
	}
		
	public function stok_add($id, $value){
		$query = "
			UPDATE $this->tabel 
			SET stok = stok + $value
			WHERE id = $id
		";
		$this->db->query($query);
	}
		
	public function stok_subtract($id, $value){
		$query = "
			UPDATE $this->tabel 
			SET stok = stok - $value
			WHERE id = $id
		";
		$this->db->query($query);
	}
}
?>