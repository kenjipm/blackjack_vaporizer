<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paket extends CI_Controller {

	public function index()
	{
        $data_header['css_list'] = array('paket');
        $data_header['js_list'] = array('paket');
		$this->load->view('header_view', $data_header);
        
		$this->load->view('paket_view');
        
		$this->load->view('footer_view');
	}
}