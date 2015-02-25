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
    
	function get_all_by_transaksi_terkait_and_id_transaksi_terkait($transaksi_terkait, $id_transaksi_terkait){
		$query = "
			SELECT * FROM $this->tabel
			 WHERE transaksi_terkait = '".$transaksi_terkait."' 
			 AND id_transaksi_terkait = ".$id_transaksi_terkait." 
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
	}
    
	function get_all_by_id_alokasi_and_session_tutup_buku_no($id_alokasi, $session_tutup_buku_no){
		$query = "
			SELECT * FROM $this->tabel
			 WHERE id_alokasi = ".$id_alokasi." 
			 AND session_tutup_buku_no = ".$session_tutup_buku_no." 
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
	}
	
	function get_all_by_session_tutup_buku_no($session_tutup_buku_no){
		$query = "
			SELECT * FROM $this->tabel
			 WHERE session_tutup_buku_no = ".$session_tutup_buku_no." 
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return $result;
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
    
	function is_id_transaksi_exist($id_transaksi_terkait){
		$query = "
			SELECT id FROM $this->tabel
			WHERE id_transaksi_terkait = ".$id_transaksi_terkait."
		";
		$query = $this->db->query($query);
		$result = $query->result();
        return (count($result) > 0);
	}
	
    function get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $id_tipe_kas, $session_tutup_buku_no){
		$query = "
			SELECT SUM(jumlah) AS jumlah_total FROM $this->tabel
			WHERE tipe_kas = '".$tipe_kas."'
			AND id_tipe_kas = ".$id_tipe_kas."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->jumlah_total:false;
	}
	
    function get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $id_tipe_kas, $session_tutup_buku_no){
		$query = "
			SELECT SUM(jumlah) AS jumlah_total FROM $this->tabel
			WHERE tipe_kas = '".$tipe_kas."'
			AND id_tipe_kas = ".$id_tipe_kas."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
			AND jumlah > 0
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->jumlah_total:false;
	}
	
    function get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $id_tipe_kas, $session_tutup_buku_no){
		$query = "
			SELECT SUM(jumlah) AS jumlah_total FROM $this->tabel
			WHERE tipe_kas = '".$tipe_kas."'
			AND id_tipe_kas = ".$id_tipe_kas."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
			AND jumlah < 0
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->jumlah_total:false;
	}
	
    function get_jumlah_total_by_id_alokasi_and_session_tutup_buku_no($id_alokasi, $session_tutup_buku_no){
		$query = "
			SELECT SUM(jumlah) AS jumlah_total FROM $this->tabel
			WHERE id_alokasi = ".$id_alokasi."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->jumlah_total:false;
	}
	
    function get_jumlah_kredit_by_id_alokasi_and_session_tutup_buku_no($id_alokasi, $session_tutup_buku_no){
		$query = "
			SELECT SUM(jumlah) AS jumlah_total FROM $this->tabel
			WHERE id_alokasi = ".$id_alokasi."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
			AND jumlah > 0
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->jumlah_total:false;
	}
	
    function get_jumlah_debit_by_id_alokasi_and_session_tutup_buku_no($id_alokasi, $session_tutup_buku_no){
		$query = "
			SELECT SUM(jumlah) AS jumlah_total FROM $this->tabel
			WHERE id_alokasi = ".$id_alokasi."
			AND session_tutup_buku_no = ".$session_tutup_buku_no."
			AND jumlah < 0
		";
		$query = $this->db->query($query);
		$result = $query->result();
		return isset($result[0])?$result[0]->jumlah_total:false;
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