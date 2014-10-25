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
        
        // === Masuk2in data === //
        $data["session_no"] = $session_no;
        $data["no_pembeli"] = $no_pembeli;
        $data["jml_menu"] = $jml_menu;
        $data["customer_id"] = $customer_id;
        $data["keterangan"] = $keterangan;
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
		$detail_reseller_customer = "";
	
        $customer_id = $this->input->post('id');
		
        $this->load->model('customer_model');
        $customer = $this->customer_model->get($customer_id);
		$detail_customer = $customer->nama.", ".$customer->alamat;
		
		if ($customer->reseller_customer_id)
        {
			$reseller_customer = $this->customer_model->get($customer->reseller_customer_id);
			$detail_reseller_customer = $reseller_customer->customer_id.", ".$reseller_customer->nama.", ".$reseller_customer->alamat;
		}
        
		if ($detail_customer)
		{
			$result = $detail_customer;
		}
		if ($detail_reseller_customer)
		{
			$result .= "<br/>Handler : ".$detail_reseller_customer;
		}
		
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
        $perc_sharing_service	= 0;
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
            $customer['perc_sharing_service']	= $perc_sharing_service;
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
            $order['keterangan'] = $this->input->post('keterangan');
            
            $this->load->model('order_model');
            $order_id = $this->order_model->insert($order);
            
            $menu_limit = $this->input->post('menu_limit');
            $this->load->model('menu_model');
            $this->load->model('order_menu_model');
            for($i=0; $i<$menu_limit; $i++)
            {
                if ($this->input->post('menu_nama-'.$i))
                {
                    $order_menu['keterangan'] = $this->input->post('menu_keterangan-'.$i);
                    $order_menu['menu_sequence'] = $this->input->post('menu_sequence-'.$i);
                    $menu_jml = intval($this->input->post('menu_jml-'.$i))?intval($this->input->post('menu_jml-'.$i)):1;
                    $menu_id = $this->menu_model->get_id_from_nama($this->input->post('menu_nama-'.$i));
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
            }
        }
        
        /* ===== Load View Order List ===== */
        $this->order_list_view($order_id);
    }
    
    public function kasir_delete_order($order_id)
    {
        // === Proses === //
		$this->load->model('menu_model');
        $this->load->model('order_model');
        $this->load->model('order_menu_model');
		
		//hapus order nya dulu
        $this->order_model->delete($order_id);
        //hapus semua menu ordernya
        $menu_jmls = $this->order_menu_model->delete_from_id_order($order_id);
		// update stok menu
		foreach ($menu_jmls as $menu_id => $menu_jml)
		{
			$this->menu_model->stok_add($menu_id, $menu_jml);
		}
        
        /* ===== Load View Order List ===== */
        $this->order_list_view($order_id);
    }
    
    public function pay_order()
    {
        $this->load->model('order_model');
        $this->load->model('order_menu_model');
        $this->load->model('variabel_model');
        $this->load->model('user_model');
        $this->load->library('text_renderer');
		$this->load->model('customer_model');
        
        // ===== Proses ===== //
        // 1. ambil2in informasi yg dibutuhin buat database order
        $id_order = $this->input->post('id_order');
        $discount = $this->input->post('discount');
        // set bahwa udah dibayar & set default discountnya
        $this->order_model->set_paid($id_order, 1);
        $this->order_model->set_default_discount($id_order, $discount);
        
        // 2. ambil2in informasi yg dibutuhin buat database order_menu sekalian print bon
        $jml_menu = $this->input->post('jml_menu');
        for ($i=0; $i<$jml_menu; $i++)
        {
            $menu_sequence = $this->input->post('menu_sequence-'.$i);
            $payment_initial_price = $this->input->post('payment_initial_price-'.$i);
            $payment_discount = $this->input->post('payment_discount-'.$i);
            $payment_price = $this->input->post('payment_price-'.$i);
            
            // update order_menu sesuai dgn sequencenya dan itung juga harga satuannya
            $jml_menu_sequence = $this->order_menu_model->count_by_order_id_and_menu_sequence($id_order, $menu_sequence);
			echo "jml menu : ".$jml_menu_sequence."<br/>";
            $order_menu_update['harga_awal'] = intval($payment_initial_price / $jml_menu_sequence);
            $order_menu_update['discount'] = $payment_discount;
            $order_menu_update['harga'] = intval($payment_price / $jml_menu_sequence);
            $this->order_menu_model->update_by_order_id_and_menu_sequence($id_order, $menu_sequence, $order_menu_update);
			
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
        $keterangan = $this->input->post('keterangan');
        
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
    
    public function logout()
    {
        $this->session->sess_destroy();
		redirect('');
    }
}














