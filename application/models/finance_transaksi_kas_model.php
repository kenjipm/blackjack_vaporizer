<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Finance_Transaksi_Kas_Model extends CI_Model {
	var $tabel = 't_finance_transaksi_kas';
        
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
	
    function get_all_by_tipe_kas_and_array_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $array_id_tipe_kas, $session_tutup_buku_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE tipe_kas = '".$tipe_kas."'
			";
		$start = true;
		foreach($array_id_tipe_kas as $id_tipe_kas)
		{
			if (!$start)
			{
				$query .= " OR ";
			}
			else
			{
				$query .= " AND ( ";
				$start = false;
			}
			
			$query .= " id_tipe_kas = ".$id_tipe_kas." ";
		}
		if (!$start)
		{
			$query .= ") ";
		}
		$query .= " AND session_tutup_buku_no = ".$session_tutup_buku_no."
		";
		$query = $this->db->query($query);
		return $query->result();
	}
	
    function get_all_current_month($month, $year){
		$query = "
			SELECT * FROM $this->tabel
			WHERE MONTH(waktu) = ".$month."
			AND YEAR(waktu) = ".$year."
		";
		$query = $this->db->query($query);
		return $query->result();
	}
	
    function get_all_current_session_tutup_buku($session_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE session_tutup_buku_no = ".$session_no."
		";
		$query = $this->db->query($query);
		return $query->result();
	}
}
?>