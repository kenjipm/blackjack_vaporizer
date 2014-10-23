<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_Model extends CI_Model {
	var $tabel = 't_user';
	
	public function __construct() {
		parent::__construct();
	}
		
	function get($username, $password){
		$query = "
			SELECT * FROM $this->tabel
			WHERE username = '$username' 
			AND password = '$password' 
		";
		$query = $this->db->query($query);
		return $query->result();
	}
		
	public function get_from_id($id){
		$query = "
			SELECT * FROM $this->tabel
			WHERE id = $id
		";
		$query = $this->db->query($query);
        $result = $query->result();
		return $result[0];
	}
}
?>