<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if ($this->session->userdata('role') != "finance")
        {
            //redirect('');
        }
	}
    
	public function index()
	{
        $data_header['css_list'] = array('finance/default');
        $data_header['js_list'] = array('finance/default');
		
		$this->load->view('finance/header_view', $data_header);
		$this->load->view('finance/index_view');
		$this->load->view('finance/footer_view');
	}
	
	function kas_overview_view()
	{
		$data_header['css_list'] = array('finance/kas_overview');
        $data_header['js_list'] = array('finance/kas_overview');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_kas_overview();
        
		$this->load->view('finance/footer_view');
	}
	
	function kas_tunai_view()
	{
		$data_header['css_list'] = array('finance/kas_tunai');
        $data_header['js_list'] = array('finance/kas_tunai');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_kas_tunai();
        
		$this->load->view('finance/footer_view');
	}
	
	function kas_rekening_view()
	{
		$data_header['css_list'] = array('finance/kas_rekening');
        $data_header['js_list'] = array('finance/kas_rekening');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_kas_rekening();
        
		$this->load->view('finance/footer_view');
	}
	
	function kas_piutang_view()
	{
		$data_header['css_list'] = array('finance/kas_piutang');
        $data_header['js_list'] = array('finance/kas_piutang');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_kas_piutang();
        
		$this->load->view('finance/footer_view');
	}
	
	function kas_migrasi_view()
	{
		$data_header['css_list'] = array('finance/kas_migrasi');
        $data_header['js_list'] = array('finance/kas_migrasi');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_kas_migrasi();
        
		$this->load->view('finance/footer_view');
	}
	
	function kas_penyesuaian_view()
	{
		$data_header['css_list'] = array('finance/kas_penyesuaian');
        $data_header['js_list'] = array('finance/kas_penyesuaian');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_kas_penyesuaian();
        
		$this->load->view('finance/footer_view');
	}
	
	function alokasi_overview_view()
	{
		$data_header['css_list'] = array('finance/alokasi_overview');
        $data_header['js_list'] = array('finance/alokasi_overview');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_alokasi_overview();
        
		$this->load->view('finance/footer_view');
	}
	
	function alokasi_migrasi_view()
	{
		$data_header['css_list'] = array('finance/alokasi_migrasi');
        $data_header['js_list'] = array('finance/alokasi_migrasi');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_alokasi_migrasi();
        
		$this->load->view('finance/footer_view');
	}
	
	function transaksi_overview_view()
	{
		$data_header['css_list'] = array('finance/transaksi_overview');
        $data_header['js_list'] = array('finance/transaksi_overview');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_transaksi_overview();
        
		$this->load->view('finance/footer_view');
	}

	private function render_kas_overview()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/kas_overview_view', $data);
	}
	
	private function render_kas_tunai()
	{
		// baca post yg bersangkutan, ada atau ngga
		if ($this->input->post('session_tutup_buku_no'))
		{
			$session_tutup_buku_no = $this->input->post('session_tutup_buku_no');
		}
		else
		{
			$session_tutup_buku_no = -1;
		}
		if ($this->input->post('str_array_kas_tunai_selected'))
		{
			$str_array_kas_tunai_selected = $this->input->post('str_array_kas_tunai_selected');
		}
		else
		{
			$str_array_kas_tunai_selected = "";
		}
		
		// ambil session tutup buku yg bersangkutan dulu
		$is_session_locked = false;
		$this->load->model('variabel_model');
		if ($session_tutup_buku_no == -1)
		{
			$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
		}
		else if ($session_tutup_buku_no != $this->variabel_model->get_session_tutup_buku_no())
		{
			$is_session_locked = true;
		}
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
        $data['is_session_locked'] = $is_session_locked;
		
		// ambil2in dulu informasi session tutup bukunya
		$this->load->model('finance_histori_tutup_buku_model');
		$prev_session = $this->finance_histori_tutup_buku_model->get_by_id_session_tutup_buku_no($session_tutup_buku_no - 1);
		$next_session = $this->finance_histori_tutup_buku_model->get_by_id_session_tutup_buku_no($session_tutup_buku_no + 1);
		$is_prev_session = ($prev_session !== false);
		$is_next_session = ($next_session !== false);
		$str_periode_awal = $is_prev_session?date_format(date_create($prev_session->waktu), "d M Y"):"Awal";
		$str_periode_akhir = $is_next_session?date_format(date_create($next_session->waktu), "d M Y"):"Sekarang";
		
		// ambil semua alokasi yg ada
		$this->load->model('finance_alokasi_model');
		$finance_alokasis = $this->finance_alokasi_model->get_all();
		
		// ambil semua finance kas tunai yg ada
		$this->load->model('finance_kas_tunai_model');
		$finance_kas_tunais = $this->finance_kas_tunai_model->get_all();
		$finance_kas_total = new stdClass();
		$finance_kas_total->starting_balance = 0;
		$finance_kas_total->ending_balance = 0;
		$finance_kas_total->total_kredit = 0;
		$finance_kas_total->total_debit = 0;
		
		// ambil2in dulu kas yg terpilih (biar lebih efisien ambil informasinya)
		$array_id_tipe_kas = array();
		$array_kas_tunai_selected = explode("-", $str_array_kas_tunai_selected);
		foreach ($finance_kas_tunais as $finance_kas_tunai)
		{
			if ((in_array($finance_kas_tunai->id, $array_kas_tunai_selected)) || ($str_array_kas_tunai_selected == ""))
			{
				$finance_kas_tunai->selected = true;
				
				// bikin array of id, buat ngambil semua transaksi yg ada, apapun itu
				$array_id_tipe_kas[] = $finance_kas_tunai->id;
		
				// ambil starting balancenya, dari session tutup buku sebelumnya
				$this->load->model('finance_histori_tutup_buku_kas_tunai_model');
				$kas_tunai_session_sebelumnya = $this->finance_histori_tutup_buku_kas_tunai_model->get_by_id_kas_tunai_and_session_tutup_buku_no($finance_kas_tunai->id, $session_tutup_buku_no - 1);
				if ($kas_tunai_session_sebelumnya) //kalo ada kas tunai yg diproses, di session sebelumnya
				{
					$finance_kas_tunai->starting_balance = $kas_tunai_session_sebelumnya->jumlah;
				}
				else
				{
					$finance_kas_tunai->starting_balance = 0;
				}
				$finance_kas_total->starting_balance += $finance_kas_tunai->starting_balance;
				$finance_kas_total->ending_balance += $finance_kas_tunai->jumlah;
				
				// siapin buat total kredit & total debit
				$finance_kas_tunai->total_kredit = 0;
				$finance_kas_tunai->total_debit = 0;
			}
			else
			{
				$finance_kas_tunai->selected = false;
			}
			
		}
		
		// ambil2in transaksi dari kas yg terpilih
		$this->load->model('finance_transaksi_kas_model');
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_tipe_kas_and_array_id_tipe_kas_and_session_tutup_buku_no("tunai", $array_id_tipe_kas, $session_tutup_buku_no);
		
		foreach($finance_transaksi_kass as $finance_transaksi_kas)
		{
			foreach($finance_kas_tunais as $finance_kas_tunai)
			{
				if ($finance_kas_tunai->id == $finance_transaksi_kas->id_tipe_kas)
				{
					if ($finance_transaksi_kas->jumlah > 0)
					{
						$finance_kas_tunai->total_kredit += $finance_transaksi_kas->jumlah;
						$finance_kas_total->total_kredit += $finance_transaksi_kas->jumlah;
					}
					else
					{
						$finance_kas_tunai->total_debit -= $finance_transaksi_kas->jumlah;
						$finance_kas_total->total_debit -= $finance_transaksi_kas->jumlah;
					}
				}
			}
		}
		
		// baru masuk2in ke data buat view
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		$data['kas_tunai_limit'] = count($finance_kas_tunais);
		// $data['is_prev_session'] = $is_prev_session;
		// $data['is_next_session'] = $is_next_session;
		$data['is_prev_session'] = true;
		$data['is_next_session'] = true;
		$data['str_periode_awal'] = $str_periode_awal;
		$data['str_periode_akhir'] = $str_periode_akhir;
		$data['finance_alokasis'] = $finance_alokasis;
		$data['finance_kas_tunais'] = $finance_kas_tunais;
		$data['finance_kas_total'] = $finance_kas_total;
		$data['finance_transaksi_kass'] = $finance_transaksi_kass;
		$this->load->view('finance/kas_tunai_view', $data);
	}
	
	private function render_kas_rekening()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/kas_rekening_view', $data);
	}
	
	private function render_kas_piutang()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/kas_piutang_view', $data);
	}
	
	private function render_kas_migrasi()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/kas_migrasi_view', $data);
	}
	
	private function render_kas_penyesuaian()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/kas_penyesuaian_view', $data);
	}
	
	private function render_alokasi_overview()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/alokasi_overview_view', $data);
	}
	
	private function render_alokasi_migrasi()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/alokasi_migrasi_view', $data);
	}
	
	private function render_transaksi_overview()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/transaksi_overview_view', $data);
	}
	
	public function add_finance_transaksi_kas()
	{
		$this->load->model('finance_transaksi_kas_model');
		$finance_transaksi_kas['tipe_kas'] = $this->input->post('tipe_kas');
		$finance_transaksi_kas['id_tipe_kas'] = $this->input->post('id_tipe_kas');
		$finance_transaksi_kas['id_alokasi'] = $this->input->post('id_alokasi');
		$finance_transaksi_kas['jumlah'] = $this->input->post('jumlah');
		$finance_transaksi_kas['keterangan'] = $this->input->post('keterangan');
		
		$this->load->model('variabel_model');
		$finance_transaksi_kas['session_tutup_buku_no'] = $this->variabel_model->get_session_tutup_buku_no();
		
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
	}
	
    public function next_session_tutup_buku()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_tutup_buku_increment();
    }
    
    public function prev_session_tutup_buku()
    {
		$this->load->model('variabel_model');
		$this->variabel_model->session_tutup_buku_no_decrement();
    }
}