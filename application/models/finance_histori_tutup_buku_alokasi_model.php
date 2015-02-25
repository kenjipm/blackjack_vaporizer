<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Finance_Histori_Tutup_Buku_Alokasi_Model extends CI_Model {
	var $tabel = 't_finance_histori_tutup_buku_alokasi';
        
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
	
    function get_by_id_alokasi_and_session_tutup_buku_no($id_alokasi, $session_tutup_buku_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id_alokasi = ".$id_alokasi."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]:false;
	}
	
    function get_by_id_alokasi_and_tipe_alokasi_and_session_tutup_buku_no($id_alokasi, $tipe_alokasi, $session_tutup_buku_no){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id_alokasi = ".$id_alokasi."
			AND tipe_alokasi = '".$tipe_alokasi."'
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]:false;
	}
}
?>