<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function index()
	{
        $data_header['css_list'] = array('menu');
        $data_header['js_list'] = array('menu');
		$this->load->view('header_view', $data_header);
        
		$this->load->view('menu_view');
        
		$this->load->view('footer_view');
	}
    

}