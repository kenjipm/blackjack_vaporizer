<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('role') != "stok")
        {
            //redirect('');
        }
	}
    
	public function index()
	{
        $month = date("n");
        $year = date("Y");
		$this->render_current_month($month, $year);
	}
	
	private function render_current_month($month, $year)
    {
        $data_header['css_list'] = array('stok');
        $data_header['js_list'] = array('stok');
		$this->load->view('stok/penjualan/header_view', $data_header);
        
        //ambil2in penjualan current month
        $this->load->model('variabel_model');
        $this->load->model('order_model');
        $this->load->model('menu_model');
        $this->load->library('text_renderer');
        
        $orders = $this->get_current_month($month, $year);
		
		//proses tampilan tanggal bulan tahun
		//$cur_date = date_parse_from_format("n-Y", $month."-".$year);
		$tanggals = array();
		$haris = array();
		for($tgl=1; $tgl<=31; $tgl++)
		{
			$cur_date = date_create($year."-".$month."-".$tgl);
			if ($tgl <= date_format($cur_date, "t")) //kalo tanggal di bulan itu ada
			{
				$tanggals[$tgl] = $tgl;
				$haris[$tgl] = date_format($cur_date, "D");
			}
			else
			{
				$tanggals[$tgl] = "";
				$haris[$tgl] = "";
			}
		}
		
		//proses penjualan biar jadi stok
		foreach ($orders as $order)
        {
			// print_r($order);
			foreach ($order->menu as $order_menu)
			{
				//per item per tanggal
				$array_identifier = date_format(date_create($order->waktu), "j-n-Y")."-".$order_menu->id_menu;
				if (!isset($stoks[$array_identifier]))
				{
					$stoks[$array_identifier] = new stdClass();
					$stoks[$array_identifier]->jumlah = -$order_menu->jumlah;
				}
				else
				{
					$stoks[$array_identifier]->jumlah -= $order_menu->jumlah;
				}
				
				//per item
				$array_identifier_per_item = $order_menu->id_menu;
				if (!isset($stoks[$array_identifier_per_item]))
				{
					$stoks[$array_identifier_per_item] = new stdClass();
					$stoks[$array_identifier_per_item]->jumlah = -$order_menu->jumlah;
				}
				else
				{
					$stoks[$array_identifier_per_item]->jumlah -= $order_menu->jumlah;
				}
			}
        }
		
		//ambil2in list barang
		$items = $this->menu_model->get_all_nama_stok();
		
        $data['stoks'] = $stoks;
		$data['items'] = $items;
        $data['text_renderer'] = $this->text_renderer;
		
		$data['tanggals'] = $tanggals;
		$data['haris'] = $haris;
		$data['cur_month'] = $month;
		$data['cur_year'] = $year;
		$this->load->view('stok/penjualan/index_view', $data);
        
		$this->load->view('stok/penjualan/footer_view');
	}
	
	private function get_current_month($month, $year)
	{
        $result = array();
        $this->load->model('order_model');
        $this->load->model('menu_model');
        $this->load->model('order_menu_model');
        $orders = $this->order_model->get_all_current_month($month, $year);
        
        foreach ($orders as $order)
        {
            $result[] = $this->get_order_detail($order);
        }
		return $result;
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
			}
			else
			{
				$order_menus[$array_identifier]->jumlah++;
			}
        }
        $order->menu = $order_menus;
        $done_all &= $order->paid; // cek yg paid
        $order->done_all = $done_all;
        return $order;
    }
}














