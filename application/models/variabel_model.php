<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Variabel_Model extends CI_Model {
	var $tabel = 'variabel';
	
	public function __construct() {
		parent::__construct();
	}
		
	public function get_jumlah_pembeli(){
		$query = "
			SELECT jumlah_pembeli FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->jumlah_pembeli:false;
	}
		
	public function set_jumlah_pembeli($value){
		$query = "
			UPDATE $this->tabel 
			SET jumlah_pembeli = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_order_last_session(){
		$query = "
			SELECT id_order_last_session FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_order_last_session:false;
	}
		
	public function set_id_order_last_session($value){
		$query = "
			UPDATE $this->tabel 
			SET id_order_last_session = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_session_no(){
		$query = "
			SELECT session_no FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->session_no:false;
	}
		
	public function set_session_no($value){
		$query = "
			UPDATE $this->tabel 
			SET session_no = '$value'
		";
		$this->db->query($query);
	}
		
	public function session_no_increment(){
		$query = "
			UPDATE $this->tabel 
			SET session_no = session_no + 1
		";
		$this->db->query($query);
	}
		
	public function session_no_decrement(){
		$query = "
			UPDATE $this->tabel 
			SET session_no = session_no - 1
		";
		$this->db->query($query);
	}
		
	public function get_session_belanja_no(){
		$query = "
			SELECT session_belanja_no FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->session_belanja_no:false;
	}
		
	public function set_session_belanja_no($value){
		$query = "
			UPDATE $this->tabel 
			SET session_belanja_no = '$value'
		";
		$this->db->query($query);
	}
		
	public function session_belanja_no_increment(){
		$query = "
			UPDATE $this->tabel 
			SET session_belanja_no = session_belanja_no + 1
		";
		$this->db->query($query);
	}
		
	public function session_belanja_no_decrement(){
		$query = "
			UPDATE $this->tabel 
			SET session_belanja_no = session_belanja_no - 1
		";
		$this->db->query($query);
	}
		
	public function get_session_penyesuaian_stok_no(){
		$query = "
			SELECT session_penyesuaian_stok_no FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->session_penyesuaian_stok_no:false;
	}
		
	public function set_session_penyesuaian_stok_no($value){
		$query = "
			UPDATE $this->tabel 
			SET session_penyesuaian_stok_no = '$value'
		";
		$this->db->query($query);
	}
		
	public function session_penyesuaian_stok_no_increment(){
		$query = "
			UPDATE $this->tabel 
			SET session_penyesuaian_stok_no = session_penyesuaian_stok_no + 1
		";
		$this->db->query($query);
	}
		
	public function session_penyesuaian_stok_no_decrement(){
		$query = "
			UPDATE $this->tabel 
			SET session_penyesuaian_stok_no = session_penyesuaian_stok_no - 1
		";
		$this->db->query($query);
	}
		
	public function get_session_tutup_buku_no(){
		$query = "
			SELECT session_tutup_buku_no FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->session_tutup_buku_no:false;
	}
		
	public function set_session_tutup_buku_no($value){
		$query = "
			UPDATE $this->tabel 
			SET session_tutup_buku_no = '$value'
		";
		$this->db->query($query);
	}
		
	public function session_tutup_buku_no_increment(){
		$query = "
			UPDATE $this->tabel 
			SET session_tutup_buku_no = session_tutup_buku_no + 1
		";
		$this->db->query($query);
	}
		
	public function session_tutup_buku_no_decrement(){
		$query = "
			UPDATE $this->tabel 
			SET session_tutup_buku_no = session_tutup_buku_no - 1
		";
		$this->db->query($query);
	}
		
	public function get_no_pembeli_multiplier(){
		$query = "
			SELECT no_pembeli_multiplier FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->no_pembeli_multiplier:false;
	}
		
	public function set_no_pembeli_multiplier($value){
		$query = "
			UPDATE $this->tabel 
			SET no_pembeli_multiplier = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_tipe_kas_penjualan_default(){
		$query = "
			SELECT tipe_kas_penjualan_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->tipe_kas_penjualan_default:false;
	}
		
	public function set_tipe_kas_penjualan_default($value){
		$query = "
			UPDATE $this->tabel 
			SET tipe_kas_penjualan_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_rekening_penjualan_default(){
		$query = "
			SELECT id_rekening_penjualan_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_rekening_penjualan_default:false;
	}
		
	public function set_id_rekening_penjualan_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_rekening_penjualan_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_rekening_belanja_default(){
		$query = "
			SELECT id_rekening_belanja_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_rekening_belanja_default:false;
	}
		
	public function set_id_rekening_belanja_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_rekening_belanja_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_supplier_default(){
		$query = "
			SELECT id_supplier_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_supplier_default:false;
	}
		
	public function set_id_supplier_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_supplier_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_tunai_penjualan_default(){
		$query = "
			SELECT id_tunai_penjualan_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_tunai_penjualan_default:false;
	}
		
	public function set_id_tunai_penjualan_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_tunai_penjualan_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_alokasi_modal_default(){
		$query = "
			SELECT id_alokasi_modal_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_alokasi_modal_default:false;
	}
		
	public function set_id_alokasi_modal_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_alokasi_modal_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_alokasi_bonus_default(){
		$query = "
			SELECT id_alokasi_bonus_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_alokasi_bonus_default:false;
	}
		
	public function set_id_alokasi_bonus_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_alokasi_bonus_default = '$value'
		";
		$this->db->query($query);
	}
		
	public function get_id_alokasi_incentive_default(){
		$query = "
			SELECT id_alokasi_incentive_default FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->id_alokasi_incentive_default:false;
	}
		
	public function set_id_alokasi_incentive_default($value){
		$query = "
			UPDATE $this->tabel 
			SET id_alokasi_incentive_default = '$value'
		";
		$this->db->query($query);
	}
	
	public function get_poin_kelipatan_rupiah(){
		$query = "
			SELECT poin_kelipatan_rupiah FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->poin_kelipatan_rupiah:false;
	}
		
	public function set_poin_kelipatan_rupiah($value){
		$query = "
			UPDATE $this->tabel 
			SET poin_kelipatan_rupiah = '$value'
		";
		$this->db->query($query);
	}
	
	public function get_poin_ke_rupiah(){
		$query = "
			SELECT poin_ke_rupiah FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->poin_ke_rupiah:false;
	}
		
	public function set_poin_ke_rupiah($value){
		$query = "
			UPDATE $this->tabel 
			SET poin_ke_rupiah = '$value'
		";
		$this->db->query($query);
	}
	
	public function get_poin_multiplier(){
		$query = "
			SELECT poin_multiplier FROM $this->tabel
		";
		$query = $this->db->query($query);
        $result = $query->result();
        
		return (count($result) > 0)?$result[0]->poin_multiplier:false;
	}
		
	public function set_poin_multiplier($value){
		$query = "
			UPDATE $this->tabel 
			SET poin_multiplier = '$value'
		";
		$this->db->query($query);
	}
}
?>