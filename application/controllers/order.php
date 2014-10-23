<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

	public function index()
	{
        $data_header['css_list'] = array('order');
        $data_header['js_list'] = array('order');
		$this->load->view('header_view', $data_header);
        
		$this->load->view('order_view');
        
		$this->load->view('footer_view');
	}
}





