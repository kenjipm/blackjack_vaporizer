<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Customer_Model extends CI_Model {
	var $tabel = 't_customer';
        
	public function __construct() {
		parent::__construct();
	}
    
	function get($customer_id){
		$query = "
			SELECT * FROM $this->tabel
			WHERE customer_id = '".$customer_id."'
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
    
	function get_all_id($search_hidden=false){
		$query = "
			SELECT id FROM $this->tabel
		";
		if (!$search_hidden)
		{
			$query .= "WHERE hidden = 0";
		}
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
	}
    
	function get_nama_from_id($customer_id){
		$query = "
			SELECT nama FROM $this->tabel
			WHERE customer_id = '".$customer_id."'
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result[0]->nama;
	}
    
	function is_id_exist($customer_id){
		$query = "
			SELECT customer_id, nama FROM $this->tabel
			WHERE customer_id = '".$customer_id."'
			AND hidden = 0
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return (count($result) > 0);
	}
}
?>