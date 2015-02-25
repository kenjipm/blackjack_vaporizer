<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('role') != "admin")
        {
            //redirect('');
        }
	}

	public function index()
	{
        $data_header['css_list'] = array('admin/default');
        $data_header['js_list'] = array('admin');
		$this->load->view('header_view', $data_header);
        
		$this->load->view('admin/index_view');
        
		$this->load->view('footer_view');
	}

	public function tambah_paket_view()
	{
        $data_header['css_list'] = array('admin/tambah_paket', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('admin/paket_barang', 'ui/jquery-ui.min');
		$this->load->view('header_view', $data_header);
        
		$this->render_tambah_paket();
		
		$this->load->view('footer_view');
	}

	public function lihat_paket_view()
	{
        $data_header['css_list'] = array('admin/tambah_paket', 'ui/jquery-ui.min');
        $data_header['js_list'] = array('admin/paket_barang', 'ui/jquery-ui.min');
		$this->load->view('header_view', $data_header);
        
		$this->render_lihat_paket();
		
		$this->load->view('footer_view');
	}
	
	private function render_tambah_paket()
	{
		$menu_limit = 10;
		
		$data['menu_limit'] = $menu_limit;
		$this->load->view('admin/tambah_paket_view', $data);
	}
	
	private function render_lihat_paket()
	{
		$menu_limit = 10;
		
		$data['menu_limit'] = $menu_limit;
		$this->load->view('admin/lihat_paket_view', $data);
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
	
	public function check_nama_menu()
    {
        $nama_menu = $this->input->post('nama');
        $this->load->model('menu_model');
        $is_nama_exist = $this->menu_model->is_nama_exist($nama_menu);
        echo $is_nama_exist?"":"false";
        return $is_nama_exist;
    }

	public function get_detail_barang()
    {
        $this->load->model('menu_model');
        $nama_barang = $this->input->post('nama_barang');
		
		$detail_barang = "###";
		if ($this->menu_model->is_nama_exist($nama_barang))
		{
			$barang = $this->menu_model->get_from_nama($nama_barang);
			$detail_barang = $barang->tipe."###".$barang->harga;
		}
		echo $detail_barang;
    }
	
    public function get_all_paket()
    {
        $result = array();
        
        $this->load->model('paket_model');
        $pakets = $this->paket_model->get_all_nama();
        
        foreach ($pakets as $paket)
        {
            $result[] = $paket->nama;
        }
        
        echo json_encode($result);
    }
	
	public function check_nama_paket()
    {
        $nama_paket = $this->input->post('nama_paket');
        $this->load->model('paket_model');
        $is_nama_exist = $this->paket_model->is_nama_exist($nama_paket);
        echo $is_nama_exist?"":"false";
        return $is_nama_exist;
    }
    
    public function add_paket_nama_only()
    {
        $nama_paket = $this->input->post('nama');
        $this->load->model('paket_model');
    
        $is_nama_exist = $this->check_nama_paket($nama_paket);
        if (!$is_nama_exist)
        {
            $paket['nama'] = $nama_paket;
            $this->paket_model->insert($paket);
            echo "";
            return true;
        }
        echo "false";
        return false;
    }

	public function get_detail_paket()
    {
        $this->load->model('paket_model');
        $nama_paket = $this->input->post('nama_paket');
		
		$detail_paket = "###";
		if ($this->paket_model->is_nama_exist($nama_paket))
		{
			$paket = $this->paket_model->get_from_nama($nama_paket);
			$detail_paket = $paket->id."###".$paket->keterangan."###";
			
			// ambil2in menu dari paket yg dimaksud
			$this->load->model('paket_menu_model');
			$paket_menus = $this->paket_menu_model->get_all_from_id_paket($paket->id);
			$this->load->model('menu_model');
			$detail_paket_temp = "";
			$jumlah_menu_valid = 0;
			foreach($paket_menus as $paket_menu)
			{
				$barang = $this->menu_model->get($paket_menu->id_menu);
				if (count($barang) > 0)
				{
					$detail_paket_temp .= $barang->nama."###".$barang->tipe."###".$paket_menu->keterangan."###".$barang->harga."###".$paket_menu->harga_akhir."###";
					$jumlah_menu_valid++;
				}
			}
			$detail_paket .= $jumlah_menu_valid."###";
			$detail_paket .= $detail_paket_temp;
		}
		echo $detail_paket;
    }
	
	public function add_paket_menu()
	{
		// update paketnya dulu
		$this->load->model('paket_model');
		$id_paket = $this->input->post('id_paket');
		$paket['keterangan'] = $this->input->post('keterangan');
		$this->paket_model->update($paket, $id_paket);
		
		// masuk2in per paket menu
		if ($id_paket)
		{
			$paket_menu['id_paket'] = $id_paket;
			$menu_limit = $this->input->post('menu_limit');
			$this->load->model('menu_model');
			$this->load->model('paket_menu_model');
			for ($i=0; $i<$menu_limit; $i++)
			{
				$nama_menu_cur = $this->input->post('menu_nama-'.$i);
				if ($nama_menu_cur)
				{
					$menu_id_cur = $this->menu_model->get_id_from_nama($nama_menu_cur);
					$paket_menu['id_menu'] = $menu_id_cur;
					$paket_menu['jumlah'] = $this->input->post('menu_jumlah-'.$i);
					$paket_menu['harga_akhir'] = $this->input->post('menu_harga-'.$i);
					$paket_menu['keterangan'] = $this->input->post('menu_keterangan-'.$i);
					
					$this->paket_menu_model->insert($paket_menu);
				}
			}
		}
		$this->tambah_paket_view();
	}
	
	public function delete_paket_menu_from_id_paket()
	{
		$id_paket = $this->input->post('id_paket');
		$this->load->model('paket_menu_model');
		return $this->paket_menu_model->delete_from_id_paket($id_paket);
	}
}