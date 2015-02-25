<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasir extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('role') != "kasir")
        {
            redirect('');
        }
	}
    
	public function index()
	{
        $data_header['css_list'] = array('kasir');
        $data_header['js_list'] = array('kasir');
		$this->load->view('header_view', $data_header);
        
		$data['username'] = $this->session->userdata['username'];
		$this->load->view('kasir/index_view', $data);
        
		$this->load->view('footer_view');
	}
    
	public function order_list_view($new_order_id=0)
	{
        /* ===== Header ===== */
        $data_header['css_list'] = array('kasir/order_list');
        $data_header['js_list'] = array('kasir/order_list');
		$this->load->view('kasir/header_view', $data_header);
        
        /* ===== Body ===== */
        $this->load->model('variabel_model');
        $session_no = $this->variabel_model->get_session_no();
        
        $data['new_order_id'] = $new_order_id;
        $data['orders'] = $this->get_current_session($session_no);
		$this->load->view('kasir/order_list_view', $data);
        
        /* ===== Footer ===== */
		$this->load->view('kasir/footer_view');
	}
    
    public function new_order_view()
	{
        // set menu limit & identifikasi dari order list ato bukan
        $data["menu_limit"] = 30;
        $data["id_order"] = 0;
        
        //ambil no pembeli
        $this->load->model('variabel_model');
        $this->load->model('order_model');
        $data["session_no"] = $this->variabel_model->get_session_no();
        $data["no_pembeli"] = $this->order_model->get_jumlah_pembeli_in_session($data["session_no"]) + 1;
		$data["tipe"] = "default";
        
        /* ===== Header ===== */
        $data_header['css_list'] = array('kasir/tambah_menu', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('kasir/tambah_menu', 'ui/jquery-ui.min');
		$this->load->view('kasir/header_view', $data_header);
        
        /* ===== Body ===== */
		$this->load->view('kasir/menu_tambah_view', $data);
        
        /* ===== Footer ===== */
		$this->load->view('kasir/footer_view');
	}
    
	public function payment_view()
	{
        // === Inisialisasi === //
        $no_pembeli = 0;
        $session_no = 0;
        $jml_menu = 0;
        $customer_id = "";
        $cs_id = "";
        $keterangan = "";
        $id_order = 0;
        $menu_sequence = 0;
        $menu = array();
        
        // === Proses === //
        // kalo hasil post dari menu tambah
        if ($this->input->post('no_pembeli'))
        {
            $no_pembeli = $this->input->post('no_pembeli');
            $session_no = $this->input->post('session_no');
            $customer_id = $this->input->post('customer_id');
            $cs_id = $this->input->post('cs_id');
            $keterangan = $this->input->post('keterangan');
            $menu_limit = $this->input->post('menu_limit');
            $id_order = $this->input->post('id_order');
            
            $menu['nama'] = array();
            $menu['jml'] = array();
            $menu['keterangan'] = array();
            $this->load->model('menu_model');
            for($i=0; $i<$menu_limit; $i++)
            {
                if ($this->input->post('menu_nama-'.$i))
                {
                    $menu_nama = $this->input->post('menu_nama-'.$i);
                    $menu_jml = intval($this->input->post('menu_jml-'.$i))?intval($this->input->post('menu_jml-'.$i)):1;
                    $menu_keterangan = $this->input->post('menu_keterangan-'.$i);
                    $initial_price = $this->menu_model->get_harga_from_nama($this->input->post('menu_nama-'.$i));
                    $default_discounted = $this->menu_model->get_default_discounted_from_nama($this->input->post('menu_nama-'.$i));
                    $menu_sequence = $this->input->post('menu_sequence-'.$i);
                    
                    $menu['nama'][] = $menu_nama;
                    $menu['jml'][] = $menu_jml;
                    $menu['keterangan'][] = $menu_keterangan;
                    $menu['initial_price'][] = $initial_price * $menu_jml;
                    $menu['default_discounted'][] = $default_discounted;
                    $menu['menu_sequence'][] = $menu_sequence;
                    $jml_menu++;
                }
            }
        }
		
		// ambil tipe kas untuk cara pembayaran
		$finance_kas_tunais = array();
		$finance_kas_rekenings = array();
		$this->load->model('finance_kas_tunai_model');
		$finance_kas_tunais = $this->finance_kas_tunai_model->get_all_for_order();
		$this->load->model('finance_kas_rekening_model');
		$finance_kas_rekenings = $this->finance_kas_rekening_model->get_all_for_order();
		$this->load->model('variabel_model');
		$tipe_kas_penjualan_default = $this->variabel_model->get_tipe_kas_penjualan_default();
		$tipe_kas_selected_value = $tipe_kas_penjualan_default;
		if ($tipe_kas_penjualan_default == "tunai")
		{
			$tipe_kas_selected_value .= "-".$this->variabel_model->get_id_tunai_penjualan_default();
		}
		else //if ($tipe_kas_penjualan_default == "rekening")
		{
			$tipe_kas_selected_value .= "-".$this->variabel_model->get_id_rekening_penjualan_default();
		}
        
        // === Masuk2in data === //
        $data["session_no"] = $session_no;
        $data["no_pembeli"] = $no_pembeli;
        $data["jml_menu"] = $jml_menu;
        $data["customer_id"] = $customer_id;
        $data["cs_id"] = $cs_id;
        $data["keterangan"] = $keterangan;
        $data["finance_kas_tunais"] = $finance_kas_tunais;
        $data["finance_kas_rekenings"] = $finance_kas_rekenings;
        $data["tipe_kas_selected_value"] = $tipe_kas_selected_value;
        $data["id_order"] = $id_order;
        $data["menu"] = $menu;
        
        /* ===== Header ===== */
        $data_header['css_list'] = array('kasir/payment', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('kasir/payment', 'ui/jquery-ui.min');
		$this->load->view('kasir/header_view', $data_header);
        
        /* ===== Body ===== */
		$this->load->view('kasir/order_payment_view', $data);
        
        /* ===== Footer ===== */
		$this->load->view('kasir/footer_view');
	}
    
	public function print_nota_view()
	{
        // === Inisialisasi === //
        $no_pembeli = 0;
        $session_no = 0;
        $jml_menu = 0;
        $customer_id = "";
        $keterangan = "";
        $id_order = 0;
        $menu_sequence = 0;
        $menu = array();
        
        // === Proses === //
        // kalo hasil post dari menu tambah
        if ($this->input->post('no_pembeli'))
        {
            $no_pembeli = $this->input->post('no_pembeli');
            $session_no = $this->input->post('session_no');
            $customer_id = $this->input->post('customer_id');
            $keterangan = $this->input->post('keterangan');
            $menu_limit = $this->input->post('menu_limit');
            $id_order = $this->input->post('id_order');
            
            $menu['nama'] = array();
            $menu['jml'] = array();
            $menu['keterangan'] = array();
			
            $this->load->model('menu_model');
            for($i=0; $i<$menu_limit; $i++)
            {
                if ($this->input->post('menu_nama-'.$i))
                {
                    $menu_nama = $this->input->post('menu_nama-'.$i);
                    $menu_jml = intval($this->input->post('menu_jml-'.$i))?intval($this->input->post('menu_jml-'.$i)):1;
                    $menu_keterangan = $this->input->post('menu_keterangan-'.$i);
                    $initial_price = $this->menu_model->get_harga_from_nama($this->input->post('menu_nama-'.$i));
                    $menu_sequence = $this->input->post('menu_sequence-'.$i);
                    
                    $menu['nama'][] = $menu_nama;
                    $menu['jml'][] = $menu_jml;
                    $menu['keterangan'][] = $menu_keterangan;
                    $menu['initial_price'][] = $initial_price * $menu_jml;
                    $menu['menu_sequence'][] = $menu_sequence;
                    $jml_menu++;
                }
            }
        }
        
        // === Masuk2in data === //
        $data["session_no"] = $session_no;
        $data["no_pembeli"] = $no_pembeli;
        $data["jml_menu"] = $jml_menu;
        $data["customer_id"] = $customer_id;
        $data["nama_kasir"] = $this->session->userdata('username');
        $data["keterangan"] = $keterangan;
        $data["id_order"] = $id_order;
        $data["menu"] = $menu;
        
        /* ===== Header, Body, Footer ===== */
		$this->load->view('kasir/print_bon', $data);
	}
    
    public function check_nama_menu()
    {
        $nama_menu = $this->input->post('nama');
        $this->load->model('menu_model');
        $is_nama_exist = $this->menu_model->is_nama_exist($nama_menu);
        echo $is_nama_exist?"":"false";
        return $is_nama_exist;
    }
    
    public function check_nama_paket()
    {
        $nama_paket = $this->input->post('nama');
        $this->load->model('paket_model');
        $is_nama_exist = $this->paket_model->is_nama_exist($nama_paket);
        echo $is_nama_exist?"":"false";
        return $is_nama_exist;
    }
    
    public function add_menu()
    {
        $nama_menu = $this->input->post('nama');
        $harga_menu = $this->input->post('harga');
        $harga_min_menu = $this->input->post('harga_min');
        $this->load->model('menu_model');
    
        $is_nama_exist = $this->check_nama_menu($nama_menu);
        if (!$is_nama_exist)
        {
            $menu['nama'] = $nama_menu;
            $menu['harga'] = $harga_menu;
            $menu['harga_min'] = $harga_min_menu;
            $this->menu_model->insert($menu);
            echo "";
            return true;
        }
        echo "false";
        return false;
    }
    
    public function check_customer_id()
    {
        $customer_id = $this->input->post('id');
        $this->load->model('customer_model');
        $is_id_exist = $this->customer_model->is_id_exist($customer_id);
        echo $is_id_exist?"":"false";
        return $is_id_exist;
    }
    
    public function get_detail_customer()
    {
		$result = "false";
		$detail_customer = "";
		//$detail_reseller_customer = "";
	
        $customer_id = $this->input->post('id');
		
        $this->load->model('customer_model');
        $customer = $this->customer_model->get($customer_id);
		if ($customer != "")
		{
			$detail_customer = $customer->nama;//.", ".$customer->alamat;
		}
		$detail_customer .= ", Poin : ".$customer->poin;
		
		// if ($customer->reseller_customer_id)
        // {
			// $reseller_customer = $this->customer_model->get($customer->reseller_customer_id);
			// //$detail_reseller_customer = $reseller_customer->customer_id.", ".$reseller_customer->nama.", ".$reseller_customer->alamat;
		// }
        
		if ($detail_customer)
		{
			$result = $detail_customer;
		}
		// if ($detail_reseller_customer)
		// {
			// $result .= "<br/>Handler : ".$detail_reseller_customer;
		// }
		
        echo $result;
    }
    
    public function add_customer()
    {
        $customer_id			= $this->input->post('customer_id');
        $nama					= $this->input->post('nama');
        $tgl_lahir				= $this->input->post('tgl_lahir');
        $alamat					= $this->input->post('alamat');
        $no_ktp					= $this->input->post('no_ktp');
        //$customer_tipe			= $this->input->post('customer_tipe');
        //$perc_sharing_service	= $this->input->post('perc_sharing_service');
        //$perc_sharing_service	= 0;
        $reseller_customer_id	= $this->input->post('reseller_customer_id');
        $hidden					= 0;
		
        $this->load->model('menu_model');
        $is_id_exist = $this->check_customer_id($customer_id);
		
        if (!$is_id_exist)
        {
            $customer['customer_id']			= $customer_id;
            $customer['nama']					= $nama;
            $customer['tgl_lahir']				= $tgl_lahir;
            $customer['alamat']					= $alamat;
            $customer['no_ktp']					= $no_ktp;
            //$customer['customer_tipe']			= $customer_tipe;
            //$customer['perc_sharing_service']	= $perc_sharing_service;
            $customer['reseller_customer_id']	= $reseller_customer_id;
            $customer['hidden']					= $hidden;
            $this->customer_model->insert($customer);
            echo "";
            return true;
        }
        echo "false";
        return false;
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
        
        /*$this->load->model('paket_model');
        $pakets = $this->paket_model->get_all_nama();
        
        foreach ($pakets as $paket)
        {
            $result[] = $paket->nama;
        }*/
        
        echo json_encode($result);
    }
    
    public function get_all_nama_customer()
    {
        $result = array();
        
        $this->load->model('customer_model');
        $customers = $this->customer_model->get_all();
        
        foreach ($customers as $customer)
        {
            $result[] = $customer->nama." (".$customer->customer_id.")";
        }
        
        echo json_encode($result);
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
			$order_menu_temp->time_elapsed = $this->get_time_elapsed($order_menu_temp->id_order_menu);
            $order_menus[] = (object) array_merge((array) $order_menu_temp, (array) $menu);
        }
        $order->menu = $order_menus;
		$customer_id = $order->customer_id;
		if ($customer_id)
		{
			$order->customer_nama = "";
			$this->load->model('customer_model');
			$customer_nama = $this->customer_model->get_nama_from_id($customer_id);
			if ($customer_nama)
			{
				$order->customer_nama = $customer_nama;
			}
		}
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
	
	private function get_time_elapsed($id_order_menu)
	{
        $this->load->model('order_menu_model');
		$order_menu = $this->order_menu_model->get($id_order_menu);
		
        $this->load->model('order_model');
		$order = $this->order_model->get($order_menu->id_order);
		
		$waktu_done = strtotime($order_menu->waktu_done) - strtotime($order->waktu);
		if ($waktu_done < 0) //berarti blm done
		{
			return false;
		}
		return $waktu_done;
	}
    
    public function kasir_set_menu_done($id, $value)
    {
        $this->load->model('order_menu_model');
        $this->order_menu_model->set_done($id, $value);
		
		//ambil waktu done nya
		$waktu_done = $this->get_time_elapsed($id);
		echo $waktu_done?"<".$waktu_done." sec>":"";
    }
    
	public function kasir_edit_order()
	{
        //ambil menu limit, no pembeli, & session_no
        $jml_menu = $this->input->post('jml_menu');
        $session_no = $this->input->post('session_no');
        $no_pembeli = $this->input->post('no_pembeli');
        $customer_id = $this->input->post('customer_id');
        $cs_id = $this->input->post('cs_id');
        $keterangan = $this->input->post('keterangan');
        $id_order = $this->input->post('id_order');
        $menus = array();
        
        //ambil menu2nya
        $this->load->model('menu_model');
        for($i=0; $i<$jml_menu; $i++)
        {
            $id_menu = $this->input->post('id_menu-'.$i);
            $cur_menu = $this->menu_model->get($id_menu);
            
            // $array_identifier = $cur_menu->nama."#".$this->input->post('keterangan_order_menu'.$i); //buat ngebedain per menu yg sama, pake nama menu & keterangannya
            $array_identifier = $this->input->post('menu_sequence-'.$i); //buat ngebedain per menu yg sama, pake menu sequence
            $menus[$array_identifier]['id'] = $id_menu;
            $menus[$array_identifier]['nama'] = $cur_menu->nama;
            $menus[$array_identifier]['keterangan'] = $this->input->post('keterangan_order_menu-'.$i);
            $menus[$array_identifier]['jml'] = isset($menus[$array_identifier]['jml'])?$menus[$array_identifier]['jml']+1:1; //kalo udah ada, jumlahnya ditambah satu, kalo blm, set satu
            $menus[$array_identifier]['menu_sequence'] = $this->input->post('menu_sequence-'.$i);
        }
        
        //masuk2in data
        $data["menu_limit"] = max($jml_menu + 5, 20);
        $data["session_no"] = $session_no;
        $data["no_pembeli"] = $no_pembeli;
        $data["customer_id"] = $customer_id;
        $data["cs_id"] = $cs_id;
        $data["keterangan"] = $keterangan;
        $data["menus"] = $menus;
        $data["id_order"] = $id_order;
		$data["tipe"] = "edit";
        
        /* ===== Header ===== */
        $data_header['css_list'] = array('kasir/tambah_menu', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('kasir/tambah_menu', 'ui/jquery-ui.min');
		$this->load->view('kasir/header_view', $data_header);
        
        /* ===== Body ===== */
		$this->load->view('kasir/menu_tambah_view', $data);
        
        /* ===== Footer ===== */
		$this->load->view('kasir/footer_view');
	}
    
	public function kasir_copy_to_new_order()
	{
        //ambil menu limit, no pembeli, & session_no
        $jml_menu = $this->input->post('jml_menu');
        $session_no = $this->input->post('session_no');
        $no_pembeli = $this->input->post('no_pembeli');
        $customer_id = $this->input->post('customer_id');
        $cs_id = $this->input->post('cs_id');
        $keterangan = $this->input->post('keterangan');
        $id_order = $this->input->post('id_order');
        $menus = array();
        
        //ambil menu2nya
        $this->load->model('menu_model');
        for($i=0; $i<$jml_menu; $i++)
        {
            $id_menu = $this->input->post('id_menu-'.$i);
            $cur_menu = $this->menu_model->get($id_menu);
            
            // $array_identifier = $cur_menu->nama."#".$this->input->post('keterangan_order_menu'.$i); //buat ngebedain per menu yg sama, pake nama menu & keterangannya
            $array_identifier = $this->input->post('menu_sequence-'.$i); //buat ngebedain per menu yg sama, pake menu sequence
            $menus[$array_identifier]['id'] = $id_menu;
            $menus[$array_identifier]['nama'] = $cur_menu->nama;
            $menus[$array_identifier]['keterangan'] = $this->input->post('keterangan_order_menu-'.$i);
            $menus[$array_identifier]['jml'] = isset($menus[$array_identifier]['jml'])?$menus[$array_identifier]['jml']+1:1; //kalo udah ada, jumlahnya ditambah satu, kalo blm, set satu
            $menus[$array_identifier]['menu_sequence'] = $this->input->post('menu_sequence-'.$i);
        }
        
        //masuk2in data
        $data["menu_limit"] = $jml_menu;
        $data["session_no"] = $session_no;
        $data["no_pembeli"] = $no_pembeli;
        $data["customer_id"] = $customer_id;
        $data["cs_id"] = $cs_id;
        $data["keterangan"] = $keterangan;
        $data["menus"] = $menus;
        $data["id_order"] = $id_order;
		$data["tipe"] = "count";
        
        /* ===== Header ===== */
        $data_header['css_list'] = array('kasir/tambah_menu', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('kasir/tambah_menu', 'ui/jquery-ui.min');
		$this->load->view('kasir/header_view', $data_header);
        
        /* ===== Body ===== */
		$this->load->view('kasir/menu_tambah_view', $data);
        
        /* ===== Footer ===== */
		$this->load->view('kasir/footer_view');
	}
    
    public function kasir_add_order()
    {
        // === Inisialisasi === //
        $order_id = 0;
        
        // === Proses === //
        // kalo hasil post dari menu tambah
        if ($this->input->post('no_pembeli'))
        {
            $order['no_pembeli'] = $this->input->post('no_pembeli');
            $order['session_no'] = $this->input->post('session_no');
            $order['customer_id'] = $this->input->post('customer_id');
            $order['customer_service_id'] = $this->input->post('cs_id');
            $order['keterangan'] = $this->input->post('keterangan');
			$this->load->model('variabel_model');
			$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
			$order['session_tutup_buku_no'] = $session_tutup_buku_no;
            
            $this->load->model('order_model');
            $order_id = $this->order_model->insert($order);
            
            $menu_limit = $this->input->post('menu_limit');
            $this->load->model('menu_model');
            $this->load->model('order_menu_model');
            $this->load->model('paket_model');
            $this->load->model('paket_menu_model');
            for($i=0; $i<$menu_limit; $i++)
            {
                if ($this->input->post('menu_nama-'.$i))
                {
                    $order_menu['keterangan'] = $this->input->post('menu_keterangan-'.$i);
                    $order_menu['menu_sequence'] = $this->input->post('menu_sequence-'.$i);
                    $menu_jml = intval($this->input->post('menu_jml-'.$i))?intval($this->input->post('menu_jml-'.$i)):1;
                    $menu_id = $this->menu_model->get_id_from_nama($this->input->post('menu_nama-'.$i));
					if ($menu_id != "")
					{
						$menu = $this->menu_model->get($menu_id);
						
						for ($j=0; $j<$menu_jml; $j++)
						{
							$order_menu['id_order'] = $order_id;
							$order_menu['id_menu'] = $menu_id;
							$order_menu['harga_min'] = $menu->harga_min;
							$order_menu['harga_base'] = $menu->harga_base;
							$order_menu['harga_setor'] = $menu->harga_setor;
							$order_menu['nama_setor'] = $menu->nama_setor;
							$this->order_menu_model->insert($order_menu);
						}
						
						// update stok menu
						$this->menu_model->stok_subtract($menu_id, $menu_jml);
					}
					else // kalo ga ada di menu, berarti paket
					{
						$paket_id = $this->paket_model->get_id_from_nama($this->input->post('menu_nama-'.$i));
						if ($paket_id)
						{
							$paket = $this->paket_model->get($paket_id);
							$paket_menus = $this->paket_menu_model->get_all_from_id_paket($paket_id);
							
							foreach ($paket_menus as $paket_menu)
							{
								$menu = $this->menu_model->get($paket_menu->id_menu);
								$menu_id = $menu->id;
								for ($k=0; $k<$paket_menu->jumlah; $k++)
								{
									for ($j=0; $j<$menu_jml; $j++)
									{
										$order_menu['id_order'] = $order_id;
										$order_menu['id_menu'] = $menu_id;
										$order_menu['harga_min'] = $menu->harga_min;
										$order_menu['harga_base'] = $menu->harga_base;
										$order_menu['harga_setor'] = $menu->harga_setor;
										$order_menu['nama_setor'] = $menu->nama_setor;
										$this->order_menu_model->insert($order_menu);
									}
									// update stok menu
									$this->menu_model->stok_subtract($menu_id, $menu_jml);
								}
							}
						}
					}
                }
            }
        }
        
        /* ===== Load View Order List ===== */
        $this->order_list_view($order_id);
    }
    
    public function kasir_delete_order($order_id, $customer_id)
    {
        // === Proses === //
		$this->load->model('menu_model');
        $this->load->model('order_model');
        $this->load->model('order_menu_model');
		
		//hapus order nya dulu
        $this->order_model->delete($order_id);
        //hapus semua menu ordernya
        $payment_total = $this->order_menu_model->count_total_payment_from_id_order($order_id);
        $menu_jmls = $this->order_menu_model->delete_from_id_order($order_id);
		// update stok menu
		foreach ($menu_jmls as $menu_id => $menu_jml)
		{
			$this->menu_model->stok_add($menu_id, $menu_jml);
		}
		$this->delete_order_to_finance($order_id, $customer_id, $payment_total);
        
        /* ===== Load View Order List ===== */
        $this->order_list_view($order_id);
    }
    
    public function pay_order()
    {
        $this->load->model('order_model');
        $this->load->model('order_menu_model');
        $this->load->model('menu_model');
        $this->load->model('variabel_model');
        $this->load->model('user_model');
        $this->load->library('text_renderer');
		$this->load->model('customer_model');
        
        // ===== Proses ===== //
        // 1. ambil2in informasi yg dibutuhin buat database order
        $id_order = $this->input->post('id_order');
        $discount = $this->input->post('discount');
		$ongkir = $this->input->post('ongkir');
		$tipe_kas_id = $this->input->post('tipe_kas_id');
        // set bahwa udah dibayar & set default discountnya
		$order_update['paid'] = 1;
		$order_update['ongkir'] = $ongkir;
		$order_update['default_discount'] = $discount;
		$tipe_kas_id = explode("-", $tipe_kas_id);
		$order_update['tipe_kas'] = $tipe_kas_id[0];
		$order_update['id_tipe_kas'] = $tipe_kas_id[1];
		$this->order_model->update($id_order, $order_update);
        // $this->order_model->set_paid($id_order, 1);
        // $this->order_model->set_ongkir($id_order, $ongkir);
        // $this->order_model->set_default_discount($id_order, $discount);
        
        // 2. ambil2in informasi yg dibutuhin buat database order_menu sekalian print bon
        $jml_menu = $this->input->post('jml_menu');
        $harga_base_total = 0;
		for ($i=0; $i<$jml_menu; $i++)
        {
            $menu_sequence = $this->input->post('menu_sequence-'.$i);
            $payment_initial_price = $this->input->post('payment_initial_price-'.$i);
            $payment_discount = $this->input->post('payment_discount-'.$i);
            $payment_price = $this->input->post('payment_price-'.$i);
            
            // update order_menu sesuai dgn sequencenya dan itung juga harga satuannya
            $jml_menu_sequence = $this->order_menu_model->count_by_order_id_and_menu_sequence($id_order, $menu_sequence);
            $order_menu_cur = $this->order_menu_model->get_by_order_id_and_menu_sequence($id_order, $menu_sequence);
			echo "jml menu : ".$jml_menu_sequence."<br/>";
            $order_menu_update['harga_awal'] = intval($payment_initial_price / $jml_menu_sequence);
            $order_menu_update['discount'] = $payment_discount;
            $order_menu_update['harga'] = intval($payment_price / $jml_menu_sequence);
            $this->order_menu_model->update_by_order_id_and_menu_sequence($id_order, $menu_sequence, $order_menu_update);
			$harga_base_total += $this->menu_model->get($order_menu_cur->id_menu)->harga_base;
			
            //yg buat print bon
            $payment_nama = $this->input->post('payment_nama-'.$i);
            $payment_jml = $this->input->post('payment_jml-'.$i);
            $payment_keterangan = $this->input->post('payment_keterangan-'.$i);
            $order_menu[$i]['nama'] = $payment_nama;
            $order_menu[$i]['jml'] = $payment_jml;
            $order_menu[$i]['keterangan'] = $payment_keterangan;
            $order_menu[$i]['harga_awal'] = $this->text_renderer->to_rupiah($payment_initial_price);
            // $order_menu[$i]['discount'] = $payment_discount;
            // $order_menu[$i]['harga'] = $payment_price;
        }
        
        // 3. ambil2in informasi yg dibutuhin buat bon / nota
        $payment_subtotal = $this->input->post('payment_subtotal');
        $payment_total_discount = $this->input->post('payment_total_discount');
        $payment_total = $this->input->post('payment_total');
        $payment_pay = $this->input->post('payment_pay');
        $payment_change = $this->input->post('payment_change');
        $no_pembeli = $this->input->post('no_pembeli');
        $customer_id = $this->input->post('customer_id');
        $poin_allow = $this->input->post('poin_allow');
        $poin_digunakan = $this->input->post('poin_digunakan');
        $keterangan = $this->input->post('keterangan');
		
		// masukin ke finance rekening yg bersangkutan
		$this->load->model('finance_transaksi_kas_model');
		$this->load->model('finance_alokasi_model');
		$cs_id = $this->input->post('cs_id');
		
		$this->input_order_to_finance($tipe_kas_id, $id_order, $customer_id, $poin_allow, $poin_digunakan, $cs_id, $payment_total, $harga_base_total, $ongkir);
		/*
		// catet ke finance kas tunai / rekening
		if ($tipe_kas == "tunai") // kalo tunai, masukin ke kas tunai
		{
			$finance_transaksi_kas['id_tipe_kas'] = $this->variabel_model->get_id_tunai_penjualan_default();
			$this->load->model('finance_kas_tunai_model');
			$this->finance_kas_tunai_model->jumlah_add($finance_transaksi_kas['id_tipe_kas'], $payment_total);
		}
		else if ($tipe_kas == "rekening") // kalo transfer, masukin ke kas rekening
		{
			$finance_transaksi_kas['id_tipe_kas'] = $this->variabel_model->get_id_rekening_penjualan_default();
			$this->load->model('finance_kas_rekening_model');
			$this->finance_kas_rekening_model->jumlah_add($finance_transaksi_kas['id_tipe_kas'], $payment_total);
		}
		// masukin ke alokasi modal & bonus
		$finance_transaksi_kas['transaksi_terkait'] = "order";
		$finance_transaksi_kas['id_transaksi_terkait'] = $id_order;
		$finance_transaksi_kas['session_tutup_buku_no'] = $this->variabel_model->get_session_tutup_buku_no();
		// masukin ke alokasi modal
		$id_alokasi_modal_default = $this->variabel_model->get_id_alokasi_modal_default();
		$finance_transaksi_kas['id_alokasi'] = $id_alokasi_modal_default;
		$finance_transaksi_kas['jumlah'] = $harga_base_total;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		// masukin ke alokasi bonus
		$id_alokasi_bonus_default = $this->variabel_model->get_id_alokasi_bonus_default();
		$finance_transaksi_kas['id_alokasi'] = $id_alokasi_bonus_default;
		$finance_transaksi_kas['jumlah'] = $payment_total - $harga_base_total;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		
		// catet ke finance alokasi yg bersangkutan (modal)
		$this->finance_alokasi_model->jumlah_add($id_alokasi_modal_default, $harga_base_total);		
		// catet ke finance alokasi yg bersangkutan (modal)
		$this->finance_alokasi_model->jumlah_add($id_alokasi_bonus_default, $payment_total - $harga_base_total);
		*/
        
		$customer_nama = "";
		if ($customer_id)
		{
			$customer_nama_temp = $this->customer_model->get_nama_from_id($customer_id);
			if ($customer_nama_temp)
			{
				$customer_nama = $customer_nama_temp;
			}
		}
		
        // masuk2in data dulu
        $no_pembeli_multiplier = $this->variabel_model->get_no_pembeli_multiplier();
        $data['user'] = $this->user_model->get_from_id($this->session->userdata('id'));
        $data['no_pembeli'] = $no_pembeli_multiplier * $no_pembeli;
        $data['tgl'] = date('d M Y H:i:s');
        $data['customer_id'] = $customer_id;
        $data['keterangan'] = $keterangan;
        $data['jml_menu'] = $jml_menu;
        $data['order_menu'] = $order_menu;
        $data['payment_subtotal'] = $this->text_renderer->to_rupiah($payment_subtotal);
        $data['payment_total_discount'] = $this->text_renderer->to_rupiah($payment_total_discount);
        $data['payment_total_discount_value'] = $payment_total_discount;
        $data['payment_total'] = $this->text_renderer->to_rupiah($payment_total);
        $data['payment_pay'] = $this->text_renderer->to_rupiah($payment_pay);
        $data['payment_change'] = $this->text_renderer->to_rupiah($payment_change);
        
		
			
        $data["customer_nama"] = $customer_nama;
		
        // render print bon
        /* ===== Header, Body, Footer ===== */
		$this->load->view('kasir/print_nota_view', $data);
    }
	
	private function input_order_to_finance($tipe_kas_id, $id_order, $customer_id, $poin_allow, $poin_digunakan, $cs_id, $payment_total, $harga_base_total, $ongkir=0)
	{
		$this->load->model('finance_transaksi_kas_model');
		if ($this->finance_transaksi_kas_model->is_id_transaksi_exist($id_order)) // kalo ordernya udah ada, hapus dulu aja br masukin lg
		{
			$this->delete_order_to_finance($id_order, $customer_id, $payment_total);
		}
		//$tipe_kas_id = explode("-", $tipe_kas_id); // udah di explode di pay_order
		$this->load->model('variabel_model');
		// catet ke finance kas tunai / rekening
		if ($tipe_kas_id[0] == "tunai") // kalo tunai, masukin ke kas tunai
		{
			$this->load->model('finance_kas_tunai_model');
			$this->finance_kas_tunai_model->jumlah_add($tipe_kas_id[1], $payment_total + $ongkir);
		}
		else if ($tipe_kas_id[0] == "rekening") // kalo transfer, masukin ke kas rekening
		{
			$this->load->model('finance_kas_rekening_model');
			$this->finance_kas_rekening_model->jumlah_add($tipe_kas_id[1], $payment_total + $ongkir);
		}
		
		// masukin ke alokasi modal & bonus
		$finance_transaksi_kas['tipe_kas'] = $tipe_kas_id[0];
		$finance_transaksi_kas['id_tipe_kas'] = $tipe_kas_id[1];
		$finance_transaksi_kas['transaksi_terkait'] = "order";
		$finance_transaksi_kas['id_transaksi_terkait'] = $id_order;
		$finance_transaksi_kas['session_tutup_buku_no'] = $this->variabel_model->get_session_tutup_buku_no();
		// masukin ke alokasi modal
		$id_alokasi_modal_default = $this->variabel_model->get_id_alokasi_modal_default();
		$finance_transaksi_kas['id_alokasi'] = $id_alokasi_modal_default;
		$finance_transaksi_kas['tipe_alokasi'] = "umum";
		$finance_transaksi_kas['informasi_alokasi'] = "";
		$finance_transaksi_kas['jumlah'] = $harga_base_total;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		
		// masukin ke alokasi incentive
		$total_incentive = 0;
		$id_alokasi_bonus_default = $this->variabel_model->get_id_alokasi_bonus_default();
		$this->load->model('customer_model');
		if ($cs_id) // kalo ada cs nya
		{
			$finance_transaksi_kas['id_alokasi'] = $id_alokasi_bonus_default;
			$finance_transaksi_kas['tipe_alokasi'] = "incentive";
			$finance_transaksi_kas['informasi_alokasi'] = $cs_id;
			$cs_cur = $this->customer_model->get($cs_id);
			$total_incentive = intval(($cs_cur->perc_incentive / 100) * $payment_total);
			$finance_transaksi_kas['jumlah'] = $total_incentive;
			$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		}
		// cek & masukin ke alokasi poin
		$total_poin_dalam_rupiah = 0;
		if ( ($poin_allow) && (!$this->customer_model->is_reseller($customer_id)) )
		{
			$poin_kelipatan_rupiah = $this->variabel_model->get_poin_kelipatan_rupiah();
			$poin_ke_rupiah = $this->variabel_model->get_poin_ke_rupiah();
			$poin_multiplier = $this->variabel_model->get_poin_multiplier();
			$total_poin = floor($payment_total / $poin_kelipatan_rupiah) * $poin_multiplier;
			$total_poin_dalam_rupiah = $total_poin * $poin_ke_rupiah;
			if ($total_poin_dalam_rupiah)
			{
				$finance_transaksi_kas['id_alokasi'] = $id_alokasi_bonus_default;
				$finance_transaksi_kas['tipe_alokasi'] = "poin";
				$finance_transaksi_kas['informasi_alokasi'] = "";
				$finance_transaksi_kas['jumlah'] = $total_poin_dalam_rupiah;
				$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
				
				$this->customer_model->poin_increment($customer_id, $total_poin);
			}
		}
		// kalau menggunakan poin, masukin ke alokasi poin
		$poin_digunakan_dalam_rupiah = $poin_digunakan * $poin_ke_rupiah;
		if ($poin_digunakan_dalam_rupiah)
		{
			// $finance_transaksi_kas['id_alokasi'] = $id_alokasi_bonus_default;
			// $finance_transaksi_kas['tipe_alokasi'] = "poin";
			// $finance_transaksi_kas['informasi_alokasi'] = "";
			// $finance_transaksi_kas['jumlah'] = $poin_digunakan_dalam_rupiah;
			// $this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
			
			$this->customer_model->poin_decrement($customer_id, $poin_digunakan);
		}
		
		// masukin ke alokasi bonus
		$total_bonus = $payment_total + $poin_digunakan_dalam_rupiah - $harga_base_total - $total_incentive - $total_poin_dalam_rupiah;
		if ($total_bonus)
		{
			$finance_transaksi_kas['id_alokasi'] = $id_alokasi_bonus_default;
			$finance_transaksi_kas['tipe_alokasi'] = "umum";
			$finance_transaksi_kas['informasi_alokasi'] = "";
			$finance_transaksi_kas['jumlah'] = $total_bonus;
			$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		}
		
		// buat ongkir
		if (($ongkir) && ($tipe_kas_id[0] == "rekening"))
		{
			// kurangi kas tunai
			$finance_transaksi_kas['tipe_kas'] = "tunai";
			$finance_transaksi_kas['id_tipe_kas'] = 1;
			$finance_transaksi_kas['id_alokasi'] = $id_alokasi_bonus_default;
			$finance_transaksi_kas['tipe_alokasi'] = "umum";
			$finance_transaksi_kas['informasi_alokasi'] = "";
			$finance_transaksi_kas['keterangan'] = "Ongkir";
			$finance_transaksi_kas['jumlah'] = -$ongkir;
			$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
			
			// tambahin kas rekening
			$finance_transaksi_kas['tipe_kas'] = "rekening";
			$finance_transaksi_kas['id_tipe_kas'] = $tipe_kas_id[1];
			$finance_transaksi_kas['jumlah'] = $ongkir;
			$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		}
		
		$this->load->model('finance_alokasi_model');
		// catet ke finance alokasi yg bersangkutan (modal)
		$this->finance_alokasi_model->jumlah_add($id_alokasi_modal_default, $harga_base_total);
		if ($cs_id) // kalo ada cs nya
		{
			// catet ke finance alokasi yg bersangkutan (incentive)
			$this->finance_alokasi_model->jumlah_add($id_alokasi_bonus_default, $total_incentive);
		}
		// catet ke finance alokasi yg bersangkutan (bonus)
		$this->finance_alokasi_model->jumlah_add($id_alokasi_bonus_default, $total_bonus);
	}
	
	private function delete_order_to_finance($id_order, $customer_id, $payment_total)
	{
		$this->load->model('finance_transaksi_kas_model');
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_transaksi_terkait_and_id_transaksi_terkait("order", $id_order);
		
		$this->load->model('finance_alokasi_model');
		$this->load->model('finance_transaksi_kas_model');
		foreach ($finance_transaksi_kass as $finance_transaksi_kas)
		{
			if ($finance_transaksi_kas->tipe_kas == "tunai") // kalo tunai, masukin ke kas tunai
			{
				$this->load->model('finance_kas_tunai_model');
				$this->finance_kas_tunai_model->jumlah_subtract($finance_transaksi_kas->id_tipe_kas, $finance_transaksi_kas->jumlah);
			}
			else if ($finance_transaksi_kas->tipe_kas == "rekening") // kalo transfer, masukin ke kas rekening
			{
				$this->load->model('finance_kas_rekening_model');
				$this->finance_kas_rekening_model->jumlah_subtract($finance_transaksi_kas->id_tipe_kas, $finance_transaksi_kas->jumlah);
			}
			// catet ke finance alokasi yg bersangkutan (modal)
			$this->finance_alokasi_model->jumlah_subtract($finance_transaksi_kas->id_alokasi, $finance_transaksi_kas->jumlah);
			$this->finance_transaksi_kas_model->delete($finance_transaksi_kas->id);
		}
		// cek & kurangi poin
		$this->load->model('customer_model');
		if (!$this->customer_model->is_reseller($customer_id))
		{
			echo "TOTAL PAYMENT : ".$payment_total;
			$this->load->model('variabel_model');
			$poin_kelipatan_rupiah = $this->variabel_model->get_poin_kelipatan_rupiah();
			$poin_multiplier = $this->variabel_model->get_poin_multiplier();
			$total_poin = floor($payment_total / $poin_kelipatan_rupiah) * $poin_multiplier;
			if ($total_poin)
			{
				$this->customer_model->poin_decrement($customer_id, $total_poin);
			}
		}
	}
    
    public function logout()
    {
        $this->session->sess_destroy();
		redirect('');
    }
}














