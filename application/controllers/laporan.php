<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('role') != "laporan")
        {
            redirect('');
        }
	}
    
	public function index()
	{
        $data_header['css_list'] = array('laporan');
        $data_header['js_list'] = array('laporan');
		$this->load->view('laporan/header_view', $data_header);
        
        //ambil2in penjualan current session
        $this->load->model('variabel_model');
        $this->load->model('order_model');
        $this->load->library('text_renderer');
        
        $session_no = $this->variabel_model->get_session_no();
        $orders = $this->get_current_session($session_no);
        $data['orders'] = $orders;
        $data['text_renderer'] = $this->text_renderer;
		$this->load->view('laporan/index_view', $data);
        
		$this->load->view('laporan/footer_view');
	}
    
    public function next_session()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_no_increment();
		$session_no = $this->variabel_model->get_session_no();
		
		//cari jumlah pembeli di session selanjutnya (siapatau udah ada)
		$this->load->model('order_model');
		$jumlah_pembeli = $this->order_model->get_jumlah_pembeli_in_session($session_no);
		$this->variabel_model->set_jumlah_pembeli($jumlah_pembeli);
    }
    
    public function prev_session()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_no_decrement();
		$session_no = $this->variabel_model->get_session_no();
		
		//cari jumlah pembeli di session sebelumnya
		$this->load->model('order_model');
		$jumlah_pembeli = $this->order_model->get_jumlah_pembeli_in_session($session_no);
		$this->variabel_model->set_jumlah_pembeli($jumlah_pembeli);
    }
	
	private function get_order_detail($order)
    {
        $done_all = true; // buat ngecek apa order ini udah done semua & udah paid? buat anchor
        $order_menus_temp = $this->order_menu_model->get_menu($order->id);
        $order_menus = array();
        foreach ($order_menus_temp as $order_menu_temp)
        {
            $menu = $this->menu_model->get($order_menu_temp->id_menu);
            $order_menu_temp->id_order_menu = $order_menu_temp->id;
            $done_all &= $order_menu_temp->done; // cek yg done
			$array_identifier = $order->id."#".$order_menu_temp->menu_sequence;
			if (!isset($order_menus[$array_identifier])) //kalau udah di set, tgl diincrement aja jumlahnya
			{
				$order_menus[$array_identifier] = (object) array_merge((array) $order_menu_temp, (array) $menu);
				$order_menus[$array_identifier]->jumlah = 1;
				$order_menus[$array_identifier]->harga_min = $order_menu_temp->harga_min;
				$order_menus[$array_identifier]->harga_base = $order_menu_temp->harga_base;
				$order_menus[$array_identifier]->harga_setor = $order_menu_temp->harga_setor;
				$order_menus[$array_identifier]->nama_setor = $order_menu_temp->nama_setor;
				$order_menus[$array_identifier]->harga_akhir = $order_menu_temp->harga;
			}
			else
			{
				$order_menus[$array_identifier]->jumlah++;
			}
			// echo "array_identifier : ".$array_identifier.", tes isset : ".(isset($order_menus[$array_identifier]->jumlah)?"set":"not set");
            // $order_menus[$array_identifier]->jumlah = isset($order_menus[$array_identifier]->jumlah)?$order_menus[$array_identifier]->jumlah+1:1;
			// echo ", jumlah : ".$order_menus[$array_identifier]->jumlah."<br/>";
        }
        $order->menu = $order_menus;
        $done_all &= $order->paid; // cek yg paid
        $order->done_all = $done_all;
        return $order;
    }
    
	private function get_current_session($session_no)
    {
        $result = array();
        $this->load->model('order_model');
        $this->load->model('menu_model');
        $this->load->model('order_menu_model');
        $orders = $this->order_model->get_all_current_session($session_no);
        
        foreach ($orders as $order)
        {
            $result[] = $this->get_order_detail($order);
        }
		return $result;
	}
}














