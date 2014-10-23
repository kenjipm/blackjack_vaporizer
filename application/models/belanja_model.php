<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Belanja_Model extends CI_Model {
	var $tabel = 't_belanja';
	
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
	
    function get_all_current_session_belanja($session_belanja_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE session_no = ".$session_belanja_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		
		return $result;
	}
	
    function get_all_current_session_tutup_buku($session_tutup_buku_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE session_tutup_buku_no = ".$session_tutup_buku_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		
		return $result;
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
	
	function delete($id){
		$query = "
			DELETE 
			FROM $this->tabel
			WHERE id = $id
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