<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Order_Model extends CI_Model {
	var $tabel = 't_order';
	
	public function __construct() {
		parent::__construct();
	}
		
	function get_all(){
		$query = "
			SELECT * FROM $this->tabel
		";
		$query = $this->db->query($query);
		return $query->result();
	}
    
    function get_all_after_id($id){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id > ".$id."
		";
		$query = $this->db->query($query);
		return $query->result();
	}
    
    function get_all_current_session($session_no, $get_detail=false){
		$query = "
			SELECT * FROM $this->tabel
			WHERE session_no = ".$session_no."
		";
		$query = $this->db->query($query);
		$orders = $query->result();
		
		$result = array();
		if ($get_detail)
		{
			foreach ($orders as $order)
			{
				// $result[] = $this->get_order_detail($order);
			}
		}
		else
		{
			$result = $orders;
		}
		
		return $result;
	}
    
    function get_all_current_session_tutup_buku($session_no, $get_detail=false){
		$query = "
			SELECT * FROM $this->tabel
			WHERE session_tutup_buku_no = ".$session_no."
		";
		$query = $this->db->query($query);
		$orders = $query->result();
		
		$result = array();
		if ($get_detail)
		{
			foreach ($orders as $order)
			{
				// $result[] = $this->get_order_detail($order);
			}
		}
		else
		{
			$result = $orders;
		}
		
		return $result;
	}
    
    function get_all_current_month($month, $year, $get_detail=false){
		$query = "
			SELECT * FROM $this->tabel
			WHERE MONTH(waktu) = ".$month."
			AND YEAR(waktu) = ".$year."
		";
		$query = $this->db->query($query);
		$orders = $query->result();
		
		$result = array();
		if ($get_detail)
		{
			foreach ($orders as $order)
			{
				// $result[] = $this->get_order_detail($order);
			}
		}
		else
		{
			$result = $orders;
		}
		
		return $result;
	}
	
	function get_jumlah_pembeli_in_session($session_no)
	{
		$query = "
			SELECT MAX(no_pembeli) AS no_pembeli FROM $this->tabel
			WHERE session_no = ".$session_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result[0]->no_pembeli;
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
    
    function set_paid($id, $value)
    {
		$query = "
			UPDATE $this->tabel
			SET paid = ".$value."
            WHERE id = ".$id."
		";
		$this->db->query($query);
    }
    
    function set_ongkir($id, $value)
    {
		$query = "
			UPDATE $this->tabel
			SET ongkir = ".$value."
            WHERE id = ".$id."
		";
		$this->db->query($query);
    }
    
    function set_default_discount($id, $value)
    {
		$query = "
			UPDATE $this->tabel
			SET default_discount = '".$value."'
            WHERE id = ".$id."
		";
		$this->db->query($query);
    }
}
?>