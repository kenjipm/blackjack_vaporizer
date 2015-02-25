<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stok extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('role') != "stok")
        {
            //redirect('');
        }
	}
    
	public function index()
	{
        $data_header['css_list'] = array('stok/default');
        $data_header['js_list'] = array('stok');
		
		$this->load->view('stok/header_view', $data_header);
		$this->load->view('stok/index_view');
		$this->load->view('stok/footer_view');
	}
	
	function penjualan_view($month="", $year="")
	{
        $data_header['css_list'] = array('stok/penjualan');
        $data_header['js_list'] = array('stok');
		$this->load->view('stok/header_view', $data_header);
        
		if ($month == "")
		{
			$month = date("n");
		}
        if ($year == "")
		{
			$year = date("Y");
		}
		
		$this->render_penjualan_current_month($month, $year);
        
		$this->load->view('stok/footer_view');
	}
	
	function belanja_view($month="", $year="")
	{
        $data_header['css_list'] = array('stok/belanja');
        $data_header['js_list'] = array('stok');
		$this->load->view('stok/header_view', $data_header);
        
		if ($month == "")
		{
			$month = date("n");
		}
        if ($year == "")
		{
			$year = date("Y");
		}
		
		$this->render_belanja_current_month($month, $year);
        
		$this->load->view('stok/footer_view');
	}
	
	function restock_view()
	{
		$data_header['css_list'] = array('stok/restock', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('stok/restock', 'ui/jquery-ui.min');
		$this->load->view('stok/header_view', $data_header);
        
        $this->render_restock();
        
		$this->load->view('stok/footer_view');
	}
	
	function histori_restock_view()
	{
		$data_header['css_list'] = array('stok/histori_restock');
        $data_header['js_list'] = array('stok/histori_restock');
		$this->load->view('stok/header_view', $data_header);
		
        $this->render_histori_restock();
        
		$this->load->view('stok/footer_view');
	}
    
	function review_stok_view()
	{
		$data_header['css_list'] = array('stok/review_stok');
        $data_header['js_list'] = array('stok/review_stok');
		$this->load->view('stok/header_view', $data_header);
		
        $this->render_review_stok();
        
		$this->load->view('stok/footer_view');
	}
	
	function penyesuaian_stok_view()
	{
		$data_header['css_list'] = array('stok/penyesuaian_stok');
        $data_header['js_list'] = array('stok/penyesuaian_stok');
		$this->load->view('stok/header_view', $data_header);
		
        $this->render_penyesuaian_stok();
        
		$this->load->view('stok/footer_view');
	}
	
	private function render_penjualan_current_month($month, $year)
    {
        //ambil2in penjualan current month
        $this->load->model('variabel_model');
        $this->load->model('order_model');
        $this->load->model('menu_model');
        $this->load->library('text_renderer');
        
        $orders = $this->get_penjualan_current_month($month, $year);
		
		//proses tampilan tanggal bulan tahun
		//$cur_date = date_parse_from_format("n-Y", $month."-".$year);
		$stoks = array();
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
		
		$cur_month_year = strtotime($year."-".$month);
		$str_month = date("F", $cur_month_year);
		$str_year = date("Y", $cur_month_year);
		
		$prev_month_year = strtotime($year."-".$month." -1 month");
		$prev_month = date("n", $prev_month_year);
		$prev_year = date("Y", $prev_month_year);
		
		$next_month_year = strtotime($year."-".$month." +1 month");
		$next_month = date("n", $next_month_year);
		$next_year = date("Y", $next_month_year);
		
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
		$data['str_month'] = $str_month;
		$data['str_year'] = $str_year;
		$data['prev_month'] = $prev_month;
		$data['prev_year'] = $prev_year;
		$data['next_month'] = $next_month;
		$data['next_year'] = $next_year;
		$this->load->view('stok/penjualan_view', $data);
	}
	
	private function render_belanja_current_month($month, $year)
    {
        //ambil2in penjualan current month
        $this->load->model('variabel_model');
        $this->load->model('belanja_model');
        $this->load->model('menu_model');
        $this->load->library('text_renderer');
        
        $orders = $this->get_belanja_current_month($month, $year);
		
		//proses tampilan tanggal bulan tahun
		//$cur_date = date_parse_from_format("n-Y", $month."-".$year);
		$stoks = array();
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
		
		$cur_month_year = strtotime($year."-".$month);
		$str_month = date("F", $cur_month_year);
		$str_year = date("Y", $cur_month_year);
		
		$prev_month_year = strtotime($year."-".$month." -1 month");
		$prev_month = date("n", $prev_month_year);
		$prev_year = date("Y", $prev_month_year);
		
		$next_month_year = strtotime($year."-".$month." +1 month");
		$next_month = date("n", $next_month_year);
		$next_year = date("Y", $next_month_year);
		
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
					$stoks[$array_identifier]->jumlah = $order_menu->jumlah;
				}
				else
				{
					$stoks[$array_identifier]->jumlah += $order_menu->jumlah;
				}
				
				//per item
				$array_identifier_per_item = $order_menu->id_menu;
				if (!isset($stoks[$array_identifier_per_item]))
				{
					$stoks[$array_identifier_per_item] = new stdClass();
					$stoks[$array_identifier_per_item]->jumlah = $order_menu->jumlah;
				}
				else
				{
					$stoks[$array_identifier_per_item]->jumlah += $order_menu->jumlah;
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
		$data['str_month'] = $str_month;
		$data['str_year'] = $str_year;
		$data['prev_month'] = $prev_month;
		$data['prev_year'] = $prev_year;
		$data['next_month'] = $next_month;
		$data['next_year'] = $next_year;
		$this->load->view('stok/belanja_view', $data);
	}
	
	private function render_restock()
	{
        $this->load->model('supplier_model');
		$suppliers = $this->supplier_model->get_all();
        $this->load->model('finance_kas_rekening_model');
		$rekenings = $this->finance_kas_rekening_model->get_all();
        $this->load->model('finance_kas_tunai_model');
		$tunais = $this->finance_kas_tunai_model->get_all();
		
        $this->load->model('variabel_model');
		$id_supplier_default = $this->variabel_model->get_id_supplier_default();
		$id_rekening_belanja_default = $this->variabel_model->get_id_rekening_belanja_default();
		
		$supplier_default = $this->supplier_model->get($id_supplier_default);
		
		$data['suppliers'] = $suppliers;
		$data['rekenings'] = $rekenings;
		$data['tunais'] = $tunais;
		$data['jumlah_dana_tersimpan'] = $supplier_default->dana_tersimpan;
		$data['id_supplier_default'] = $id_supplier_default;
		$data['id_rekening_belanja_default'] = $id_rekening_belanja_default;
        $data['menu_limit'] = 50;
		
		$this->load->view('stok/restock_view', $data);
	}
	
	private function render_histori_restock($session_belanja_no="")
	{
        $belanjas = array();
        $this->load->model('variabel_model');
        if ($session_belanja_no == "")
		{
			$session_belanja_no = $this->variabel_model->get_session_belanja_no();
		}
		$belanjas = $this->get_belanja_current_session($session_belanja_no);
		$data['belanjas'] = $belanjas;
		
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		
		$this->load->view('stok/histori_restock_view', $data);
	}
	
	private function render_penyesuaian_stok()
    {
		// inisialisasi
		$keterangan_cur = "";
		
		// cek dulu bisa edit ga? kalo udah pernah sessionnya, ga boleh edit lagi (bisi kacau real stoknya)
        $this->load->model('variabel_model');
		$session_penyesuaian_stok_no = $this->variabel_model->get_session_penyesuaian_stok_no();
		$this->load->model('penyesuaian_stok_model');
		$penyesuaian_stok_current_session = $this->penyesuaian_stok_model->get_all_current_session_penyesuaian_stok($session_penyesuaian_stok_no);
		$is_session_locked = count($penyesuaian_stok_current_session) > 0;
		
		//ambil2in list barang
        $this->load->model('menu_model');
		$items = $this->menu_model->get_all_nama_stok();
		
		if ($is_session_locked) //ganti stok2nya pake histori penyesuaian stok
		{
			$this->load->model('penyesuaian_stok_menu_model');
			$penyesuaian_stok_current_session = $penyesuaian_stok_current_session[0];
			$keterangan_cur = $penyesuaian_stok_current_session->keterangan;
			foreach ($items as $item)
			{
				$penyesuaian_stok_menu_cur = $this->penyesuaian_stok_menu_model->get_from_id_menu_and_id_penyesuaian_stok($item->id,$penyesuaian_stok_current_session->id);
				if (count($penyesuaian_stok_menu_cur) > 0)
				{
					$stok_data_histori = $penyesuaian_stok_menu_cur[0]->stok_data;
					$stok_real_histori = $penyesuaian_stok_menu_cur[0]->stok_real;
					$keterangan_item_cur = $penyesuaian_stok_menu_cur[0]->keterangan;
				}
				else
				{
					$stok_data_histori = "-";
					$stok_real_histori = "-";
					$keterangan_item_cur = "";
				}
				
				$item->stok_data = $stok_data_histori;
				$item->stok_real = $stok_real_histori;
				$item->keterangan = $keterangan_item_cur;
			}
		}
		
        $this->load->library('text_renderer');
		$data['items'] = $items;
		$data['keterangan'] = $keterangan_cur;
		$data['is_session_locked'] = $is_session_locked;
		$data['menu_limit'] = count($items);
        $data['text_renderer'] = $this->text_renderer;
		$this->load->view('stok/penyesuaian_stok_view', $data);
	}
	
	private function render_review_stok()
    {
		// inisialisasi
		$items = array();
		
		//ambil2in list barang
        $this->load->model('menu_model');
		$items = $this->menu_model->get_all_include_hidden_and_order();
		
        $this->load->library('text_renderer');
		$data['items'] = $items;
		$data['menu_limit'] = count($items);
		$this->load->view('stok/review_stok_view', $data);
	}
	
	function do_belanja()
	{
		// === Inisialisasi === //
        $supplier = "";
        $keterangan = "";
        $tipe_pembayaran = array();
        $id_order = 0;
        $session_no = 0;
        $menu_sequence = 0;
			
        $jml_menu = 0;
        $belanja = array();
        $belanja_menu = array();
		$menu_update = array();
		
		$total_belanja = 0;
		$total_dana_disimpan = 0;
		
        // === Proses === //
        if ($this->input->post('supplier'))
        {
			$this->load->model('variabel_model');
			$id_supplier = $this->input->post('supplier');
			$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
			
			// ----- masukin ke tabel belanja dulu ----- //
            $belanja['id_supplier'] = $id_supplier;
			$tipe_pembayaran = explode("-", $this->input->post('tipe_pembayaran'));
            $belanja['tipe_pembayaran'] = $tipe_pembayaran[0];
			if ($tipe_pembayaran[0] == "rekening")
			{
				$belanja['id_rekening'] = $tipe_pembayaran[1];
			}
            $belanja['keterangan'] = $this->input->post('keterangan');
            $belanja['session_no'] = $this->variabel_model->get_session_belanja_no();
            $belanja['session_tutup_buku_no'] = $session_tutup_buku_no;
            
            $this->load->model('belanja_model');
            $id_belanja = $this->belanja_model->insert($belanja);
            // ----- ----------------------------- ----- //
			
            $menu_limit = $this->input->post('menu_limit');
            $this->load->model('menu_model');
            $this->load->model('belanja_menu_model');
			
            for($i=0; $i<$menu_limit; $i++)
            {
				$menu_nama = $this->input->post('menu_nama-'.$i);
                if ($menu_nama)
                {
                    if (!$this->menu_model->is_nama_exist($menu_nama)) // kalo menu belum ada, tambah menunya dulu
					{
						$menu_baru['nama'] = $menu_nama;
						$this->menu_model->insert($menu_baru);
					}
					$menu = $this->menu_model->get_from_nama($menu_nama);
					
					// masukin updatenya ke menu
					$harga_base = $menu->harga_base;
					$jumlah_stok = $menu->stok;
					//$jumlah_stok_bulat = ($menu->stok < 0)?0:$menu->stok;
					$harga_belanja = $this->input->post('menu_harga-'.$i);
					$jumlah_belanja = $this->input->post('menu_jml-'.$i);
					//$jumlah_stok_baru = ($jumlah_stok + $jumlah_belanja != 0)?$jumlah_stok + $jumlah_belanja:1;
					
					if (($jumlah_stok + $jumlah_belanja == 0) || ($jumlah_stok <= 0))
					{
						$harga_base_average = $harga_belanja;
					}
					else
					{
						$harga_base_average = (($harga_base * $jumlah_stok) + ($harga_belanja * $jumlah_belanja)) / ($jumlah_stok + $jumlah_belanja);
					}
					
					$tipe_belanja = $this->input->post('menu_jp_po_tj-'.$i);
					$menu_update['nama'] = $this->input->post('menu_nama-'.$i);
					$menu_update['tipe'] = $this->input->post('menu_tipe-'.$i);
					if (($tipe_belanja == "jp") || ($tipe_belanja == "tj"))
					{
						$menu_update['stok'] = $menu->stok + $this->input->post('menu_jml-'.$i);
					}
					$menu_update['harga'] = $this->input->post('menu_harga_jual-'.$i);
					$menu_update['harga_default'] = $this->input->post('menu_harga_default-'.$i);
					$menu_update['harga_min'] = ceil($harga_base_average);
					$menu_update['harga_base'] = ceil($harga_base_average);
					$this->menu_model->update($menu_update, $menu->id);
					
					// masukin ke belanja_menu
					$belanja_menu['id_belanja'] = $id_belanja;
					$belanja_menu['id_menu'] = $menu->id;
					$belanja_menu['jumlah'] = intval($this->input->post('menu_jml-'.$i))?intval($this->input->post('menu_jml-'.$i)):1;
					$belanja_menu['keterangan'] = $this->input->post('menu_keterangan-'.$i);
					$belanja_menu['harga_awal'] = $this->input->post('menu_harga_default-'.$i);
					$belanja_menu['harga'] = $this->input->post('menu_harga-'.$i);
					$belanja_menu['tipe_belanja'] = $tipe_belanja;
					
					$this->belanja_menu_model->insert($belanja_menu);
					
					// totalin jumlah belanja
					
					if ($tipe_belanja == "po")
					{
						$total_dana_disimpan += $belanja_menu['jumlah'] * $belanja_menu['harga'];
					}
					else if ($tipe_belanja == "tj")
					{
						$total_dana_disimpan -= $belanja_menu['jumlah'] * $belanja_menu['harga'];
					}
					else //if ($tipe_belanja == "jp")
					{
						$total_belanja += $belanja_menu['jumlah'] * $belanja_menu['harga'];
					}
                }
            }
			
			// benerin total belanja, bisi pake dana tersimpan
			$is_dana_tersimpan = $this->input->post('is_dana_tersimpan');
			$dana_terpakai = 0;
			$this->load->model('finance_transaksi_kas_model');
			$this->load->model('finance_alokasi_model');
			$id_alokasi = $this->finance_alokasi_model->get_id_from_nama("Modal");
			if ($is_dana_tersimpan)
			{
				$this->load->model('supplier_model');
				$jumlah_dana_tersimpan = $this->supplier_model->get($id_supplier)->dana_tersimpan;
				$dana_terpakai = ($total_belanja < $jumlah_dana_tersimpan)?$total_belanja:$jumlah_dana_tersimpan;
				$this->supplier_model->dana_tersimpan_subtract($id_supplier, $dana_terpakai);
				
				$finance_transaksi_kas = array();
				$finance_transaksi_kas['tipe_kas'] = $tipe_pembayaran[0];
				$finance_transaksi_kas['id_tipe_kas'] = $tipe_pembayaran[1];
				$finance_transaksi_kas['id_alokasi'] = $id_alokasi;
				$finance_transaksi_kas['tipe_alokasi'] = "supplier";
				$finance_transaksi_kas['informasi_alokasi'] = $id_supplier;
				$finance_transaksi_kas['jumlah'] = $dana_terpakai;
				$finance_transaksi_kas['transaksi_terkait'] = "belanja";
				$finance_transaksi_kas['id_transaksi_terkait'] = $id_belanja;
				$finance_transaksi_kas['session_tutup_buku_no'] = $session_tutup_buku_no;
				$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
			}
			
			// masukin ke finance 
			if ($total_belanja)
			{
				$finance_transaksi_kas = array();
				$finance_transaksi_kas['tipe_kas'] = $tipe_pembayaran[0];
				$finance_transaksi_kas['id_tipe_kas'] = $tipe_pembayaran[1];
				$finance_transaksi_kas['id_alokasi'] = $id_alokasi;
				$finance_transaksi_kas['tipe_alokasi'] = "umum";
				$finance_transaksi_kas['jumlah'] = -$total_belanja;
				$finance_transaksi_kas['transaksi_terkait'] = "belanja";
				$finance_transaksi_kas['id_transaksi_terkait'] = $id_belanja;
				$finance_transaksi_kas['session_tutup_buku_no'] = $session_tutup_buku_no;
				$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
			}
			
			if ($total_dana_disimpan)
			{
				$finance_transaksi_kas = array();
				$finance_transaksi_kas['tipe_kas'] = $tipe_pembayaran[0];
				$finance_transaksi_kas['id_tipe_kas'] = $tipe_pembayaran[1];
				$finance_transaksi_kas['id_alokasi'] = $id_alokasi;
				$finance_transaksi_kas['tipe_alokasi'] = "supplier";
				$finance_transaksi_kas['informasi_alokasi'] = $id_supplier;
				$finance_transaksi_kas['jumlah'] = -$total_dana_disimpan;
				$finance_transaksi_kas['transaksi_terkait'] = "belanja";
				$finance_transaksi_kas['id_transaksi_terkait'] = $id_belanja;
				$finance_transaksi_kas['session_tutup_buku_no'] = $session_tutup_buku_no;
				$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
				
				$this->load->model('supplier_model');
				$this->supplier_model->dana_tersimpan_add($id_supplier, $total_dana_disimpan);
			}
			$belanja_update['penyimpanan_dana'] = $total_dana_disimpan;
			$belanja_update['penggunaan_dana'] = $dana_terpakai;
            $id_belanja = $this->belanja_model->update($belanja_update, $id_belanja);
			
			// catet ke finance alokasi yg bersangkutan (modal)
			$this->finance_alokasi_model->jumlah_subtract($id_alokasi, $total_belanja - $dana_terpakai + $total_dana_disimpan);
			
			// catet ke finance kas tunai / rekening
			if ($tipe_pembayaran[0] == "transfer") // kalo transfer, masukin ke kas rekening
			{
				$this->load->model('finance_kas_rekening_model');
				$this->finance_kas_rekening_model->jumlah_subtract($tipe_pembayaran[1], $total_belanja - $dana_terpakai + $total_dana_disimpan);
			}
			else if ($tipe_pembayaran[0] == "tunai") // kalo tunai, masukin ke kas tunai
			{
				$this->load->model('finance_kas_tunai_model');
				$this->finance_kas_tunai_model->jumlah_subtract($tipe_pembayaran[1], $total_belanja - $dana_terpakai + $total_dana_disimpan);
			}
        }
        // $this->histori_restock_view();
		redirect('stok/histori_restock_view');
	}
	
	public function cancel_belanja()
	{
		$id_belanja = $this->input->post('id_belanja');
		$this->load->model('belanja_model');
		$this->belanja_model->delete($id_belanja);
		
		// ambil menu2nya dulu
        $this->load->model('belanja_menu_model');
		$belanja_menus = $this->belanja_menu_model->get_menu($id_belanja);
		
		// kurang2i stok menunya, sekalian hapus belanja_menu nya
        $this->load->model('menu_model');
		foreach ($belanja_menus as $belanja_menu)
		{
			$menu_cur = $this->menu_model->get($belanja_menu->id_menu);
			$menu_update['stok'] = $menu_cur->stok - $belanja_menu->jumlah;
			$this->menu_model->update($menu_update, $menu_cur->id);
			
			$this->belanja_menu_model->delete($belanja_menu->id);
		}
		
		// udpate finance2 yg bersangkutan
		$this->load->model('finance_transaksi_kas_model');
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_transaksi_terkait_and_id_transaksi_terkait("belanja", $id_belanja);
		$this->load->model('finance_alokasi_model');
		$this->load->model('finance_kas_rekening_model');
		$this->load->model('finance_kas_tunai_model');
		$this->load->model('supplier_model');
		foreach ($finance_transaksi_kass as $finance_transaksi_kas)
		{
			$this->finance_alokasi_model->jumlah_add($finance_transaksi_kas->id_alokasi, -$finance_transaksi_kas->jumlah);
			if ($finance_transaksi_kas->tipe_kas == "transfer") // kalo transfer, masukin ke kas rekening
			{
				$this->finance_kas_rekening_model->jumlah_add($finance_transaksi_kas->id_tipe_kas, -$finance_transaksi_kas->jumlah);
			}
			else if ($finance_transaksi_kas->tipe_kas == "tunai") // kalo tunai, masukin ke kas tunai
			{
				$this->finance_kas_tunai_model->jumlah_add($finance_transaksi_kas->id_tipe_kas, -$finance_transaksi_kas->jumlah);
			}
			if ($finance_transaksi_kas->tipe_alokasi == "supplier") // kalo dana tersimpan supplier, sesuaiin
			{
				$this->supplier_model->dana_tersimpan_subtract($finance_transaksi_kas->informasi_alokasi, -$finance_transaksi_kas->jumlah);
			}
			else if ($finance_transaksi_kas->tipe_kas == "incentive") // kalo incentive, ga ada tabel nyatet incentive, jadi kosong aja
			{
				
			}
			
			$this->finance_transaksi_kas_model->delete($finance_transaksi_kas->id);
		}
		
        // $this->histori_restock_view();
		redirect('stok/histori_restock_view');
	}
	
	function do_penyesuaian_stok()
	{
		if ($this->input->post('menu_limit'))
        {
			// masukin ke tabel penyesuaian_stok dulu
			$this->load->model('variabel_model');
			$this->load->model('penyesuaian_stok_model');
			$penyesuaian_stok['keterangan'] = $this->input->post('keterangan');
			$penyesuaian_stok['session_penyesuaian_stok_no'] = $this->variabel_model->get_session_penyesuaian_stok_no();
			$id_penyesuaian_stok = $this->penyesuaian_stok_model->insert($penyesuaian_stok);
			
			// masukin ke tabel penyesuaian_stok_menu, proses per menu
			$menu_limit = $this->input->post('menu_limit');
            for($i=0; $i<$menu_limit; $i++)
            {
				if (is_numeric($this->input->post('stok_real-'.$i))) // kalau stok realnya dimasukin (berarti user anggap ada perubahan)
				{
					$id_menu = $this->input->post('menu_id-'.$i);
					if ($id_menu)
					{
						if ($this->input->post('stok_real-'.$i) != $this->input->post('stok_data-'.$i)) // cek apa bener stoknya berubah
						{
							// update stok di menu
							$menu_update['stok'] = $this->input->post('stok_real-'.$i);
							$this->load->model('menu_model');
							$this->menu_model->update($menu_update, $id_menu);
							
							// baru masukin ke tabel penyesuaian_stok_menu
							$this->load->model('penyesuaian_stok_menu_model');
							$penyesuaian_stok_menu['id_penyesuaian_stok'] = $id_penyesuaian_stok;
							$penyesuaian_stok_menu['id_menu'] = $id_menu;
							$penyesuaian_stok_menu['stok_data'] = $this->input->post('stok_data-'.$i);
							$penyesuaian_stok_menu['stok_real'] = $this->input->post('stok_real-'.$i);
							$penyesuaian_stok_menu['keterangan'] = $this->input->post('keterangan-'.$i);
							$this->penyesuaian_stok_menu_model->insert($penyesuaian_stok_menu);
						}
					}
				}
            }
		}
        //$this->penyesuaian_stok_view();
		redirect('stok/penyesuaian_stok_view');
	}
	
    public function add_menu_nama_only()
    {
        $nama_menu = $this->input->post('nama');
        $this->load->model('menu_model');
    
        $is_nama_exist = $this->check_nama_menu($nama_menu);
        if (!$is_nama_exist)
        {
            $menu['nama'] = $nama_menu;
            $menu['harga'] = 0;
            $menu['harga_base'] = 0;
            $menu['default_discounted'] = 1;
            $this->menu_model->insert($menu);
            echo "";
            return true;
        }
        echo "false";
        return false;
    }
    
	private function get_penjualan_current_month($month, $year)
	{
        $result = array();
        $this->load->model('order_model');
        $orders = $this->order_model->get_all_current_month($month, $year);
        
        foreach ($orders as $order)
        {
            $result[] = $this->get_order_detail($order);
        }
		return $result;
	}
	
	private function get_belanja_current_month($month, $year)
	{
        $result = array();
        $this->load->model('belanja_model');
        $belanjas = $this->belanja_model->get_all_current_month($month, $year);
        
        foreach ($belanjas as $belanja)
        {
            $result[] = $this->get_belanja_detail($belanja);
        }
		return $result;
	}
	
	private function get_belanja_current_session($session_belanja_no)
	{
		$result = array();
		
        $this->load->model('belanja_model');
		$belanjas = $this->belanja_model->get_all_current_session_belanja($session_belanja_no);
		
		foreach ($belanjas as $belanja)
        {
            $result[] = $this->get_belanja_detail($belanja);
        }
		
		return $result;
	}
	
	private function get_order_detail($order)
    {
        $this->load->model('menu_model');
        $this->load->model('order_menu_model');
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
	
	private function get_belanja_detail($belanja)
    {
        $this->load->model('menu_model');
        $this->load->model('belanja_menu_model');
        $belanja_menus_temp = $this->belanja_menu_model->get_menu($belanja->id);
        $belanja_menus = array();
        foreach ($belanja_menus_temp as $belanja_menu_temp)
        {
            $menu = $this->menu_model->get($belanja_menu_temp->id_menu);
            $belanja_menu_temp->id_belanja_menu = $belanja_menu_temp->id;
            $belanja_menu_temp->harga_beli_supplier = $belanja_menu_temp->harga;
			$array_identifier = $belanja->id."#".$belanja_menu_temp->id_menu;
			if (!isset($belanja_menus[$array_identifier])) //kalau udah di set, tgl diincrement aja jumlahnya
			{
				$belanja_menus[$array_identifier] = (object) array_merge((array) $belanja_menu_temp, (array) $menu);
				$belanja_menus[$array_identifier]->jumlah = $belanja_menu_temp->jumlah;
			}
			else
			{
				$belanja_menus[$array_identifier]->jumlah += $belanja_menu_temp->jumlah;
			}
        }
        $belanja->menu = $belanja_menus;
		
        $this->load->model('supplier_model');
		$belanja->supplier = $this->supplier_model->get($belanja->id_supplier);
		
        $this->load->model('finance_kas_rekening_model');
        $belanja->rekening = $this->finance_kas_rekening_model->get($belanja->id_rekening);
        
        $belanja->str_waktu = date_format(date_create($belanja->waktu), "j F Y, H:i");
		
		return $belanja;
    }
	
	public function get_detail_barang()
    {
        $this->load->model('menu_model');
        $nama_barang = $this->input->post('nama_barang');
		
		$detail_barang = "###";
		if ($this->menu_model->is_nama_exist($nama_barang))
		{
			$barang = $this->menu_model->get_from_nama($nama_barang);
			$detail_barang = $barang->tipe."###".$barang->harga."###".$barang->harga_default."###".$barang->harga_base;
		}
		echo $detail_barang;
    }
	
	public function get_dana_tersimpan()
    {
		$id_supplier = $this->input->post('id_supplier');
        $this->load->model('supplier_model');
        $supplier = $this->supplier_model->get($id_supplier);
		
		echo $supplier->dana_tersimpan;
    }

    public function get_all_nama()
    {
        $result = array();
        
        $this->load->model('menu_model');
        $menus = $this->menu_model->get_all_nama();
        
        foreach ($menus as $menu)
        {
            $result[] = $menu->nama;
        }
        
        echo json_encode($result);
    }
	
	public function update_item()
    {
        $item_id				= $this->input->post('id');
        $item['tipe']			= $this->input->post('tipe');
        $item['tipe_2']			= $this->input->post('tipe_2');
        $item['tipe_3']			= $this->input->post('tipe_3');
        $item['harga']			= $this->input->post('harga');
        $item['harga_default']	= $this->input->post('harga_default');
        $item['harga_min']		= $this->input->post('harga_min');
        $item['harga_base']		= $this->input->post('harga_base');
        $item['stok']			= $this->input->post('stok');
		
        $this->load->model('menu_model');
		$result = $this->menu_model->update($item, $item_id);
		
		if ($result)
		{
			echo "success";
		}
		else
		{
			echo "failure";
		}
    }
	
	public function update_item_hidden()
    {
        $item_id		= $this->input->post('id');
        $item['hidden']	= ($this->input->post('hidden') == "true")?1:0;
		
        $this->load->model('menu_model');
		$result = $this->menu_model->update($item, $item_id);
		
		if ($result)
		{
			echo "success";
		}
		else
		{
			echo "failure";
		}
    }
    
	public function check_nama_menu()
    {
        $nama_menu = $this->input->post('nama');
        $this->load->model('menu_model');
        $is_nama_exist = $this->menu_model->is_nama_exist($nama_menu);
        echo $is_nama_exist?"":"false";
        return $is_nama_exist;
    }
    
    public function next_session_belanja()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_belanja_no_increment();
    }
    
    public function prev_session_belanja()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_belanja_no_decrement();
    }
    
    public function next_session_penyesuaian_stok()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_penyesuaian_stok_no_increment();
    }
    
    public function prev_session_penyesuaian_stok()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_penyesuaian_stok_no_decrement();
    }
}














