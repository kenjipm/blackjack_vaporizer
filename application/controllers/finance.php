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
	
	function tutup_buku_view()
	{
		$data_header['css_list'] = array('finance/tutup_buku');
        $data_header['js_list'] = array('finance/tutup_buku');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_tutup_buku();
        
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
	
	function alokasi_modal_view()
	{
		$data_header['css_list'] = array('finance/alokasi_modal');
        $data_header['js_list'] = array('finance/alokasi_modal');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_alokasi_modal();
        
		$this->load->view('finance/footer_view');
	}
	
	function alokasi_bonus_view()
	{
		$data_header['css_list'] = array('finance/alokasi_bonus');
        $data_header['js_list'] = array('finance/alokasi_bonus');
		$this->load->view('finance/header_view', $data_header);
		
        $this->render_alokasi_bonus();
        
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

	function omzet_view($month="", $year="")
	{
		$data_header['css_list'] = array('finance/omzet');
        $data_header['js_list'] = array('finance/omzet');
		$this->load->view('finance/header_view', $data_header);
        
		if ($month == "")
		{
			$month = date("n");
		}
        if ($year == "")
		{
			$year = date("Y");
		}
		
        $this->render_omzet_current_month($month, $year);
        
		$this->load->view('finance/footer_view');
	}

	private function render_tutup_buku()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/tutup_buku_view', $data);
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
		$this->load->model('finance_transaksi_kas_model');
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
				$finance_kas_tunai->total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
				$finance_kas_tunai->total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
				$finance_kas_tunai->ending_balance = $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
				
				$finance_kas_total->starting_balance += $finance_kas_tunai->starting_balance;
				$finance_kas_total->total_kredit += $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
				$finance_kas_total->total_debit += $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
				$finance_kas_total->ending_balance += $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
				
				// siapin buat total kredit & total debit
				//$finance_kas_tunai->total_kredit = 0;
				//$finance_kas_tunai->total_debit = 0;
			}
			else
			{
				$finance_kas_tunai->selected = false;
			}
			
		}
		
		// ambil2in transaksi dari kas yg terpilih
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_tipe_kas_and_array_id_tipe_kas_and_session_tutup_buku_no("tunai", $array_id_tipe_kas, $session_tutup_buku_no);
		/*
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
		}*/
		
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
		// baca post yg bersangkutan, ada atau ngga
		if ($this->input->post('session_tutup_buku_no'))
		{
			$session_tutup_buku_no = $this->input->post('session_tutup_buku_no');
		}
		else
		{
			$session_tutup_buku_no = -1;
		}
		if ($this->input->post('str_array_kas_rekening_selected'))
		{
			$str_array_kas_rekening_selected = $this->input->post('str_array_kas_rekening_selected');
		}
		else
		{
			$str_array_kas_rekening_selected = "";
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
		
		// ambil semua finance kas rekening yg ada
		$this->load->model('finance_kas_rekening_model');
		$finance_kas_rekenings = $this->finance_kas_rekening_model->get_all();
		$finance_kas_total = new stdClass();
		$finance_kas_total->starting_balance = 0;
		$finance_kas_total->ending_balance = 0;
		$finance_kas_total->total_kredit = 0;
		$finance_kas_total->total_debit = 0;
		
		// ambil2in dulu kas yg terpilih (biar lebih efisien ambil informasinya)
		$array_id_tipe_kas = array();
		$array_kas_rekening_selected = explode("-", $str_array_kas_rekening_selected);
		$this->load->model('finance_transaksi_kas_model');
		foreach ($finance_kas_rekenings as $finance_kas_rekening)
		{
			if ((in_array($finance_kas_rekening->id, $array_kas_rekening_selected)) || ($str_array_kas_rekening_selected == ""))
			{
				$finance_kas_rekening->selected = true;
				
				// bikin array of id, buat ngambil semua transaksi yg ada, apapun itu
				$array_id_tipe_kas[] = $finance_kas_rekening->id;
		
				// ambil starting balancenya, dari session tutup buku sebelumnya
				$this->load->model('finance_histori_tutup_buku_kas_rekening_model');
				$kas_rekening_session_sebelumnya = $this->finance_histori_tutup_buku_kas_rekening_model->get_by_id_kas_rekening_and_session_tutup_buku_no($finance_kas_rekening->id, $session_tutup_buku_no - 1);
				if ($kas_rekening_session_sebelumnya) //kalo ada kas rekening yg diproses, di session sebelumnya
				{
					$finance_kas_rekening->starting_balance = $kas_rekening_session_sebelumnya->jumlah;
				}
				else
				{
					$finance_kas_rekening->starting_balance = 0;
				}
				$finance_kas_rekening->total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
				$finance_kas_rekening->total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
				$finance_kas_rekening->ending_balance = $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
				
				$finance_kas_total->starting_balance += $finance_kas_rekening->starting_balance;
				$finance_kas_total->total_kredit += $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
				$finance_kas_total->total_debit += $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
				$finance_kas_total->ending_balance += $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
				
				// siapin buat total kredit & total debit
				//$finance_kas_rekening->total_kredit = 0;
				//$finance_kas_rekening->total_debit = 0;
			}
			else
			{
				$finance_kas_rekening->selected = false;
			}
			
		}
		
		// ambil2in transaksi dari kas yg terpilih
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_tipe_kas_and_array_id_tipe_kas_and_session_tutup_buku_no("rekening", $array_id_tipe_kas, $session_tutup_buku_no);
		/*
		foreach($finance_transaksi_kass as $finance_transaksi_kas)
		{
			foreach($finance_kas_rekenings as $finance_kas_rekening)
			{
				if ($finance_kas_rekening->id == $finance_transaksi_kas->id_tipe_kas)
				{
					if ($finance_transaksi_kas->jumlah > 0)
					{
						$finance_kas_rekening->total_kredit += $finance_transaksi_kas->jumlah;
						$finance_kas_total->total_kredit += $finance_transaksi_kas->jumlah;
					}
					else
					{
						$finance_kas_rekening->total_debit -= $finance_transaksi_kas->jumlah;
						$finance_kas_total->total_debit -= $finance_transaksi_kas->jumlah;
					}
				}
			}
		}*/
		
		// baru masuk2in ke data buat view
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		$data['kas_rekening_limit'] = count($finance_kas_rekenings);
		// $data['is_prev_session'] = $is_prev_session;
		// $data['is_next_session'] = $is_next_session;
		$data['is_prev_session'] = true;
		$data['is_next_session'] = true;
		$data['str_periode_awal'] = $str_periode_awal;
		$data['str_periode_akhir'] = $str_periode_akhir;
		$data['finance_alokasis'] = $finance_alokasis;
		$data['finance_kas_rekenings'] = $finance_kas_rekenings;
		$data['finance_kas_total'] = $finance_kas_total;
		$data['finance_transaksi_kass'] = $finance_transaksi_kass;
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
		
		// ambil alokasi yg ada
		$this->load->model('finance_alokasi_model');
		$finance_alokasis = $this->finance_alokasi_model->get_all();
		
		// ambil semua finance kas tunai yg ada
		$this->load->model('finance_kas_tunai_model');
		$finance_kas_tunais = $this->finance_kas_tunai_model->get_all();
		$finance_kas_tunai_total = new stdClass();
		$finance_kas_tunai_total->starting_balance = 0;
		$finance_kas_tunai_total->ending_balance = 0;
		$finance_kas_tunai_total->total_kredit = 0;
		$finance_kas_tunai_total->total_debit = 0;
		
		$this->load->model('finance_transaksi_kas_model');
		foreach ($finance_kas_tunais as $finance_kas_tunai)
		{
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
			$finance_kas_tunai->total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai->total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai->ending_balance = $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			
			$finance_kas_tunai_total->starting_balance += $finance_kas_tunai->starting_balance;
			$finance_kas_tunai_total->total_kredit += $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai_total->total_debit += $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai_total->ending_balance += $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
		}
		
		// ambil semua finance kas rekening yg ada
		$this->load->model('finance_kas_rekening_model');
		$finance_kas_rekenings = $this->finance_kas_rekening_model->get_all();
		$finance_kas_rekening_total = new stdClass();
		$finance_kas_rekening_total->starting_balance = 0;
		$finance_kas_rekening_total->ending_balance = 0;
		$finance_kas_rekening_total->total_kredit = 0;
		$finance_kas_rekening_total->total_debit = 0;
		
		// ambil2in dulu kas yg terpilih (biar lebih efisien ambil informasinya)
		$this->load->model('finance_transaksi_kas_model');
		foreach ($finance_kas_rekenings as $finance_kas_rekening)
		{
			// ambil starting balancenya, dari session tutup buku sebelumnya
			$this->load->model('finance_histori_tutup_buku_kas_rekening_model');
			$kas_rekening_session_sebelumnya = $this->finance_histori_tutup_buku_kas_rekening_model->get_by_id_kas_rekening_and_session_tutup_buku_no($finance_kas_rekening->id, $session_tutup_buku_no - 1);
			if ($kas_rekening_session_sebelumnya) //kalo ada kas rekening yg diproses, di session sebelumnya
			{
				$finance_kas_rekening->starting_balance = $kas_rekening_session_sebelumnya->jumlah;
			}
			else
			{
				$finance_kas_rekening->starting_balance = 0;
			}
			$finance_kas_rekening->total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening->total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening->ending_balance = $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			
			$finance_kas_rekening_total->starting_balance += $finance_kas_rekening->starting_balance;
			$finance_kas_rekening_total->total_kredit += $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening_total->total_debit += $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening_total->ending_balance += $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
		}
		
		$finance_kas_total = new stdClass();
		$finance_kas_total->starting_balance = $finance_kas_tunai_total->starting_balance + $finance_kas_rekening_total->starting_balance;
		$finance_kas_total->total_kredit = $finance_kas_tunai_total->total_kredit + $finance_kas_rekening_total->total_kredit;
		$finance_kas_total->total_debit = $finance_kas_tunai_total->total_debit + $finance_kas_rekening_total->total_debit;
		$finance_kas_total->ending_balance = $finance_kas_tunai_total->ending_balance + $finance_kas_rekening_total->ending_balance;
		
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		
		$data['finance_alokasis'] = $finance_alokasis;
		$data['finance_kas_tunais'] = $finance_kas_tunais;
		$data['finance_kas_tunai_total'] = $finance_kas_tunai_total;
		$data['finance_kas_rekenings'] = $finance_kas_rekenings;
		$data['finance_kas_rekening_total'] = $finance_kas_rekening_total;
		$data['finance_kas_total'] = $finance_kas_total;
		
		$this->load->view('finance/kas_migrasi_view', $data);
	}
	
	private function render_kas_penyesuaian()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		// ambil alokasi yg ada
		$this->load->model('finance_alokasi_model');
		$finance_alokasis = $this->finance_alokasi_model->get_all();
		
		// ambil semua finance kas tunai yg ada
		$this->load->model('finance_kas_tunai_model');
		$finance_kas_tunais = $this->finance_kas_tunai_model->get_all();
		$finance_kas_tunai_total = new stdClass();
		$finance_kas_tunai_total->starting_balance = 0;
		$finance_kas_tunai_total->ending_balance = 0;
		$finance_kas_tunai_total->total_kredit = 0;
		$finance_kas_tunai_total->total_debit = 0;
		
		$this->load->model('finance_transaksi_kas_model');
		foreach ($finance_kas_tunais as $finance_kas_tunai)
		{
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
			$finance_kas_tunai->total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai->total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai->ending_balance = $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			
			$finance_kas_tunai_total->starting_balance += $finance_kas_tunai->starting_balance;
			$finance_kas_tunai_total->total_kredit += $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai_total->total_debit += $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$finance_kas_tunai_total->ending_balance += $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
		}
		
		// ambil semua finance kas rekening yg ada
		$this->load->model('finance_kas_rekening_model');
		$finance_kas_rekenings = $this->finance_kas_rekening_model->get_all();
		$finance_kas_rekening_total = new stdClass();
		$finance_kas_rekening_total->starting_balance = 0;
		$finance_kas_rekening_total->ending_balance = 0;
		$finance_kas_rekening_total->total_kredit = 0;
		$finance_kas_rekening_total->total_debit = 0;
		
		// ambil2in dulu kas yg terpilih (biar lebih efisien ambil informasinya)
		$this->load->model('finance_transaksi_kas_model');
		foreach ($finance_kas_rekenings as $finance_kas_rekening)
		{
			// ambil starting balancenya, dari session tutup buku sebelumnya
			$this->load->model('finance_histori_tutup_buku_kas_rekening_model');
			$kas_rekening_session_sebelumnya = $this->finance_histori_tutup_buku_kas_rekening_model->get_by_id_kas_rekening_and_session_tutup_buku_no($finance_kas_rekening->id, $session_tutup_buku_no - 1);
			if ($kas_rekening_session_sebelumnya) //kalo ada kas rekening yg diproses, di session sebelumnya
			{
				$finance_kas_rekening->starting_balance = $kas_rekening_session_sebelumnya->jumlah;
			}
			else
			{
				$finance_kas_rekening->starting_balance = 0;
			}
			$finance_kas_rekening->total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening->total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening->ending_balance = $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			
			$finance_kas_rekening_total->starting_balance += $finance_kas_rekening->starting_balance;
			$finance_kas_rekening_total->total_kredit += $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening_total->total_debit += $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$finance_kas_rekening_total->ending_balance += $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
		}
		
		$finance_kas_total = new stdClass();
		$finance_kas_total->starting_balance = $finance_kas_tunai_total->starting_balance + $finance_kas_rekening_total->starting_balance;
		$finance_kas_total->total_kredit = $finance_kas_tunai_total->total_kredit + $finance_kas_rekening_total->total_kredit;
		$finance_kas_total->total_debit = $finance_kas_tunai_total->total_debit + $finance_kas_rekening_total->total_debit;
		$finance_kas_total->ending_balance = $finance_kas_tunai_total->ending_balance + $finance_kas_rekening_total->ending_balance;
		
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		
		$data['finance_alokasis'] = $finance_alokasis;
		$data['finance_kas_tunais'] = $finance_kas_tunais;
		$data['finance_kas_tunai_total'] = $finance_kas_tunai_total;
		$data['finance_kas_rekenings'] = $finance_kas_rekenings;
		$data['finance_kas_rekening_total'] = $finance_kas_rekening_total;
		$data['finance_kas_total'] = $finance_kas_total;
		
		$this->load->view('finance/kas_penyesuaian_view', $data);
	}
	
	private function render_alokasi_overview()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/alokasi_overview_view', $data);
	}
	
	private function render_alokasi_modal()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		// ambil modal cair
		$this->load->model('finance_kas_tunai_model');
		$finance_kas_tunais = $this->finance_kas_tunai_model->get_all();
		$this->load->model('finance_kas_rekening_model');
		$finance_kas_rekenings = $this->finance_kas_rekening_model->get_all();
		$this->load->model('finance_transaksi_kas_model');
		$modal['tunai'] = 0;
		$modal['rekening'] = 0;
		$modal['total'] = 0;
		foreach ($finance_kas_tunais as $finance_kas_tunai)
		{
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
			$modal['tunai'] += $finance_kas_tunai->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("tunai", $finance_kas_tunai->id, $session_tutup_buku_no);
			$modal['total'] += $modal['tunai'];
		}
		foreach ($finance_kas_rekenings as $finance_kas_rekening)
		{
			// ambil starting balancenya, dari session tutup buku sebelumnya
			$this->load->model('finance_histori_tutup_buku_kas_rekening_model');
			$kas_rekening_session_sebelumnya = $this->finance_histori_tutup_buku_kas_rekening_model->get_by_id_kas_rekening_and_session_tutup_buku_no($finance_kas_rekening->id, $session_tutup_buku_no - 1);
			if ($kas_rekening_session_sebelumnya) //kalo ada kas rekening yg diproses, di session sebelumnya
			{
				$finance_kas_rekening->starting_balance = $kas_rekening_session_sebelumnya->jumlah;
			}
			else
			{
				$finance_kas_rekening->starting_balance = 0;
			}
			$modal['rekening'] += $finance_kas_rekening->starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no("rekening", $finance_kas_rekening->id, $session_tutup_buku_no);
			$modal['total'] += $modal['rekening'];
		}
		
		// ambil modal barang
		$this->load->model('menu_model');
		$barangs = $this->menu_model->get_all();
		$harga_total_semua_barang = 0;
		foreach ($barangs as $barang)
		{
			$barang->harga_total = $barang->stok * $barang->harga_base;
			$harga_total_semua_barang += $barang->harga_total;
		}
		
		$data['modal'] = $modal;
		$data['barangs'] = $barangs;
		$data['harga_total_semua_barang'] = $harga_total_semua_barang;
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		$this->load->view('finance/alokasi_modal_view', $data);
	}
	
	private function render_alokasi_bonus()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		// ambil id alokasi bonusnya dulu
		$this->load->model('finance_alokasi_model');
		$id_alokasi = $this->finance_alokasi_model->get_id_from_nama('Bonus');
		
		// ambil2in transaksi yg ada di session sesuai id alokasi
		$this->load->model('finance_transaksi_kas_model');
		$bonus['revenue'] = 0;
		$bonus['incentive'] = array();
		$bonus['incentive_total'] = 0;
		$bonus['poin_total'] = 0;
		//$bonus['unallocated'] = 0; //yg tidak teralokasi anggep aja revenue company
		
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_id_alokasi_and_session_tutup_buku_no($id_alokasi, $session_tutup_buku_no);
		$this->load->model('customer_model');
		foreach ($finance_transaksi_kass as $finance_transaksi_kas)
		{
			$tipe_alokasi = $finance_transaksi_kas->tipe_alokasi;
			if ($tipe_alokasi == "incentive")
			{
				$customer_id = $finance_transaksi_kas->informasi_alokasi;
				if (isset($bonus['incentive'][$customer_id])) // kalo sebelumnya loop yg sekarang si customer udah pernah ada incentive
				{
					$bonus['incentive'][$customer_id]->jumlah += $finance_transaksi_kas->jumlah;
					$bonus['incentive_total'] += $finance_transaksi_kas->jumlah;
				}
				else
				{
					$bonus['incentive'][$customer_id] = new stdClass();
					$bonus['incentive'][$customer_id]->nama = $this->customer_model->get($customer_id)->nama;
					$bonus['incentive'][$customer_id]->jumlah = $finance_transaksi_kas->jumlah;
					$bonus['incentive_total'] += $finance_transaksi_kas->jumlah;
				}
			}
			else if ($tipe_alokasi == "poin")
			{
				//$bonus['poin_total'] += $finance_transaksi_kas->jumlah;
			}
			else //if ((!$tipe_alokasi) || ($tipe_alokasi == "revenue"))
			{
				$bonus['revenue'] += $finance_transaksi_kas->jumlah;
			}
		}
		
		$customers = $this->customer_model->get_all();
		$poin_ke_rupiah = $this->variabel_model->get_poin_ke_rupiah();
		foreach ($customers as $customer)
		{
			$bonus['poin_total'] += $customer->poin * $poin_ke_rupiah;
		}
		
		$data['bonus'] = $bonus;
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		$this->load->view('finance/alokasi_bonus_view', $data);
	}
	
	private function render_alokasi_migrasi()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		// ambil alokasi yg ada
		$this->load->model('finance_alokasi_model');
		$finance_alokasis = $this->finance_alokasi_model->get_all();
		
		$finance_alokasi_total = new stdClass();
		$this->load->model('finance_transaksi_kas_model');
		$finance_transaksi_kass = $this->finance_transaksi_kas_model->get_all_by_session_tutup_buku_no($session_tutup_buku_no);
		$this->load->model('finance_histori_tutup_buku_alokasi_model');
		$finance_alokasi_tipe = array();
		$finance_alokasi_tipe_total = array();
		$finance_alokasi_total = new stdClass();
		$finance_alokasi_total->starting_balance = 0;
		$finance_alokasi_total->total_kredit = 0;
		$finance_alokasi_total->total_debit = 0;
		$finance_alokasi_total->ending_balance = 0;
		foreach ($finance_transaksi_kass as $finance_transaksi_kas)
		{
			$id_alokasi_cur = $finance_transaksi_kas->id_alokasi;
			$tipe_alokasi_cur = $finance_transaksi_kas->tipe_alokasi?$finance_transaksi_kas->tipe_alokasi:"umum";
			$jumlah_cur = $finance_transaksi_kas->jumlah;
			if (!isset($finance_alokasi_tipe[$id_alokasi_cur])) // kalo array key id alokasinya jg blm keisi
			{
				// inisialisasi semuanya
				$finance_alokasi_tipe[$id_alokasi_cur] = array();
				
				$finance_alokasi_tipe_total[$id_alokasi_cur] = new stdClass();
				$finance_alokasi_tipe_total[$id_alokasi_cur]->starting_balance = 0;
				$finance_alokasi_tipe_total[$id_alokasi_cur]->total_kredit = 0;
				$finance_alokasi_tipe_total[$id_alokasi_cur]->total_debit = 0;
				$finance_alokasi_tipe_total[$id_alokasi_cur]->ending_balance = 0;
				
				$alokasi_cur = $this->finance_alokasi_model->get($id_alokasi_cur);
				$finance_alokasi_tipe_total[$id_alokasi_cur]->nama = $alokasi_cur->nama;
				$finance_alokasi_tipe_total[$id_alokasi_cur]->keterangan = $alokasi_cur->keterangan;
			}
			
			if (!isset($finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]))
			{
				//echo "<br/>alokasi id : ".$id_alokasi_cur;
				//echo "<br/>alokasi tipe : ".$tipe_alokasi_cur;
				$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur] = new stdClass();
				$alokasi_session_sebelumnya = $this->finance_histori_tutup_buku_alokasi_model->get_by_id_alokasi_and_tipe_alokasi_and_session_tutup_buku_no($id_alokasi_cur, $tipe_alokasi_cur, $session_tutup_buku_no - 1);
				if ($alokasi_session_sebelumnya) //kalo ada kas tunai yg diproses, di session sebelumnya
				{
					$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->starting_balance = $alokasi_session_sebelumnya->jumlah;
					$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->ending_balance = $alokasi_session_sebelumnya->jumlah;
					$finance_alokasi_tipe_total[$id_alokasi_cur]->starting_balance += $alokasi_session_sebelumnya->jumlah;
					$finance_alokasi_tipe_total[$id_alokasi_cur]->ending_balance += $alokasi_session_sebelumnya->jumlah;
					$finance_alokasi_total->starting_balance += $alokasi_session_sebelumnya->jumlah;
					$finance_alokasi_total->ending_balance += $alokasi_session_sebelumnya->jumlah;
				}
				else
				{
					$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->starting_balance = 0;
				}
				$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->total_kredit = 0;
				$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->total_debit = 0;
				
				//print_r($finance_alokasi_tipe[$id_alokasi_cur]);echo"<br/>";
			}

			if ($jumlah_cur >= 0)
			{
				$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->total_kredit += $jumlah_cur;
				$finance_alokasi_tipe_total[$id_alokasi_cur]->total_kredit += $jumlah_cur;
				$finance_alokasi_total->total_kredit += $jumlah_cur;
			}
			else //if ($jumlah_cur < 0)
			{
				$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->total_debit += $jumlah_cur;
				$finance_alokasi_tipe_total[$id_alokasi_cur]->total_debit += $jumlah_cur;
				$finance_alokasi_total->total_debit += $jumlah_cur;
			}
			$finance_alokasi_tipe[$id_alokasi_cur][$tipe_alokasi_cur]->ending_balance += $jumlah_cur;
			$finance_alokasi_tipe_total[$id_alokasi_cur]->ending_balance += $jumlah_cur;
			$finance_alokasi_total->ending_balance += $jumlah_cur;
		}
		
		$this->load->library('text_renderer');
		$data['text_renderer'] = $this->text_renderer;
		
		// ambil alokasi yg ada
		$this->load->model('finance_alokasi_model');
		$finance_alokasis = $this->finance_alokasi_model->get_all();
		
		$data['finance_alokasis'] = $finance_alokasis;
		$data['finance_alokasi_tipe'] = $finance_alokasi_tipe;
		$data['finance_alokasi_tipe_total'] = $finance_alokasi_tipe_total;
		$data['finance_alokasi_total'] = $finance_alokasi_total;
		
		$this->load->view('finance/alokasi_migrasi_view', $data);
	}
	
	private function render_transaksi_overview()
	{
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
        $data['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->load->view('finance/transaksi_overview_view', $data);
	}
	
	private function render_omzet_current_month($month, $year)
	{
		//ambil2in penjualan current month
        $this->load->model('variabel_model');
        $this->load->model('order_model');
        $this->load->library('text_renderer');
        
        $orders = $this->get_penjualan_current_month($month, $year);
		
		//proses tampilan tanggal bulan tahun
		//$cur_date = date_parse_from_format("n-Y", $month."-".$year);
		$omzets = array();
		$total_omzet = 0;
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
				$array_identifier = date_format(date_create($order->waktu), "j-n-Y");
				if (!isset($omzets[$array_identifier]))
				{
					$omzets[$array_identifier] = new stdClass();
					$omzets[$array_identifier]->total = $order_menu->harga_akhir;
				}
				else
				{
					$omzets[$array_identifier]->total += $order_menu->harga_akhir;
				}
				//echo $array_identifier." : ".$order_menu->harga_akhir."<br/>";
				$total_omzet += $order_menu->harga_akhir;
			}
        }
		// foreach ($omzets as $tang => omzet)
		// {
			// echo $tang." : ".$omzet->total."<br/>";
		// }
		
		$data['omzets'] = $omzets;
        $data['total_omzet'] = $total_omzet;
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
		$this->load->view('finance/omzet_view', $data);
	}
	
	public function add_finance_transaksi_kas()
	{
		$this->load->model('finance_transaksi_kas_model');
		$finance_transaksi_kas['tipe_kas'] = $this->input->post('tipe_kas');
		$finance_transaksi_kas['id_tipe_kas'] = $this->input->post('id_tipe_kas');
		$finance_transaksi_kas['id_alokasi'] = $this->input->post('id_finance_alokasi');
		$finance_transaksi_kas['jumlah'] = $this->input->post('jumlah');
		$finance_transaksi_kas['keterangan'] = $this->input->post('keterangan');
		
		$this->load->model('variabel_model');
		$finance_transaksi_kas['session_tutup_buku_no'] = $this->variabel_model->get_session_tutup_buku_no();
		
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
	}
	
	public function set_finance_kas()
	{
		// ambil2in dulu informasi yg dipost
		$tipe_kas = $this->input->post('tipe_kas');
		$id_tipe_kas = $this->input->post('id_tipe_kas');
		
		// cek ulang ending balance nya
		// ambil starting balancenya, dari session tutup buku sebelumnya
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
		if ($tipe_kas == "tunai")
		{
			$this->load->model('finance_kas_tunai_model');
			$finance_kas_cur = $this->finance_kas_tunai_model->get($id_tipe_kas);
			$this->load->model('finance_histori_tutup_buku_kas_tunai_model');
			$kas_session_sebelumnya = $this->finance_histori_tutup_buku_kas_tunai_model->get_by_id_kas_tunai_and_session_tutup_buku_no($id_tipe_kas, $session_tutup_buku_no - 1);
		}
		else //if ($tipe_kas == "rekening")
		{
			$this->load->model('finance_kas_rekening_model');
			$finance_kas_cur = $this->finance_kas_rekening_model->get($id_tipe_kas);
			$this->load->model('finance_histori_tutup_buku_kas_rekening_model');
			$kas_session_sebelumnya = $this->finance_histori_tutup_buku_kas_rekening_model->get_by_id_kas_rekening_and_session_tutup_buku_no($id_tipe_kas, $session_tutup_buku_no - 1);
		}
		
		if ($kas_session_sebelumnya) //kalo ada kas tunai yg diproses, di session sebelumnya
		{
			$starting_balance = $kas_session_sebelumnya->jumlah;
		}
		else
		{
			$starting_balance = 0;
		}
		// ambil total kredit, total debit, itung ending balance nya
		$this->load->model('finance_transaksi_kas_model');
		$total_kredit = $this->finance_transaksi_kas_model->get_jumlah_kredit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $id_tipe_kas, $session_tutup_buku_no);
		$total_debit = $this->finance_transaksi_kas_model->get_jumlah_debit_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $id_tipe_kas, $session_tutup_buku_no);
		$ending_balance = $starting_balance + $this->finance_transaksi_kas_model->get_jumlah_total_by_tipe_kas_and_id_tipe_kas_and_session_tutup_buku_no($tipe_kas, $id_tipe_kas, $session_tutup_buku_no);
		
		// itung yg harus dimasukin ke finance transaksi kas
		$jumlah_sesuai = $this->input->post('jumlah_sesuai');
		$jumlah_agar_sesuai = $jumlah_sesuai - $ending_balance;
		// baru masukin ke finance transaksi kas model
		$finance_transaksi_kas['tipe_kas'] = $tipe_kas;
		$finance_transaksi_kas['id_tipe_kas'] = $this->input->post('id_tipe_kas');
		$finance_transaksi_kas['id_alokasi'] = $this->input->post('id_alokasi');
		$finance_transaksi_kas['jumlah'] = $jumlah_agar_sesuai;
		$finance_transaksi_kas['transaksi_terkait'] = "penyesuaian finance";
		$finance_transaksi_kas['keterangan'] = $this->input->post('keterangan');
		$finance_transaksi_kas['session_tutup_buku_no'] = $session_tutup_buku_no;
		
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
	}
	
	public function do_migrasi_kas()
	{
		$id_tipe_kas_sumber = $this->input->post('id_tipe_kas_sumber');
		$id_tipe_kas_sumber = explode("-", $id_tipe_kas_sumber);
		if (count($id_tipe_kas_sumber) < 2) return false;
		$tipe_kas_sumber = $id_tipe_kas_sumber[0];
		$id_kas_sumber   = $id_tipe_kas_sumber[1];
		
		$id_tipe_kas_tujuan = $this->input->post('id_tipe_kas_tujuan');
		$id_tipe_kas_tujuan = explode("-", $id_tipe_kas_tujuan);
		if (count($id_tipe_kas_tujuan) < 2) return false;
		$tipe_kas_tujuan = $id_tipe_kas_tujuan[0];
		$id_kas_tujuan   = $id_tipe_kas_tujuan[1];
		
		$jumlah = $this->input->post('jumlah');
		$keterangan = $this->input->post('keterangan');
		
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
		
		$this->load->model('finance_transaksi_kas_model');
		// kurangin dana sumber
		$finance_transaksi_kas['tipe_kas'] = $tipe_kas_sumber;
		$finance_transaksi_kas['id_tipe_kas'] = $id_kas_sumber;
		$finance_transaksi_kas['jumlah'] = -$jumlah;
		$finance_transaksi_kas['transaksi_terkait'] = "migrasi kas - ".$tipe_kas_tujuan;
		$finance_transaksi_kas['id_transaksi_terkait'] = $id_kas_tujuan;
		$finance_transaksi_kas['keterangan'] = $keterangan;
		$finance_transaksi_kas['session_tutup_buku_no'] = $session_tutup_buku_no;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		// tambahin dana tujuan
		$finance_transaksi_kas['tipe_kas'] = $tipe_kas_tujuan;
		$finance_transaksi_kas['id_tipe_kas'] = $id_kas_tujuan;
		$finance_transaksi_kas['jumlah'] = $jumlah;
		$finance_transaksi_kas['transaksi_terkait'] = "migrasi kas - ".$tipe_kas_sumber;
		$finance_transaksi_kas['id_transaksi_terkait'] = $id_kas_sumber;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		redirect('finance/kas_migrasi_view');
	}
	
	public function do_migrasi_alokasi()
	{
		$id_alokasi_sumber = $this->input->post('id_alokasi_sumber');
		$tipe_alokasi_sumber = $this->input->post('tipe_alokasi_sumber');
		$jumlah = $this->input->post('jumlah');
		$id_alokasi_tujuan = $this->input->post('id_alokasi_tujuan');
		$tipe_alokasi_tujuan = $this->input->post('tipe_alokasi_tujuan');
		$keterangan = $this->input->post('keterangan');
		
		$this->load->model('variabel_model');
		$session_tutup_buku_no = $this->variabel_model->get_session_tutup_buku_no();
		
		$this->load->model('finance_transaksi_kas_model');
		// kurangin dana sumber
		$finance_transaksi_kas['tipe_kas'] = "tunai"; // apa jg boleh
		$finance_transaksi_kas['id_alokasi'] = $id_alokasi_sumber;
		$finance_transaksi_kas['tipe_alokasi'] = $tipe_alokasi_sumber;
		$finance_transaksi_kas['jumlah'] = -$jumlah;
		$finance_transaksi_kas['transaksi_terkait'] = "migrasi alokasi - ".$tipe_alokasi_tujuan;
		$finance_transaksi_kas['id_transaksi_terkait'] = $id_alokasi_tujuan;
		$finance_transaksi_kas['keterangan'] = $keterangan;
		$finance_transaksi_kas['session_tutup_buku_no'] = $session_tutup_buku_no;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		// tambahin dana tujuan
		$finance_transaksi_kas['id_alokasi'] = $id_alokasi_tujuan;
		$finance_transaksi_kas['tipe_alokasi'] = $tipe_alokasi_tujuan;
		$finance_transaksi_kas['jumlah'] = $jumlah;
		$finance_transaksi_kas['transaksi_terkait'] = "migrasi alokasi - ".$tipe_alokasi_sumber;
		$finance_transaksi_kas['id_transaksi_terkait'] = $id_alokasi_sumber;
		$this->finance_transaksi_kas_model->insert($finance_transaksi_kas);
		
		redirect('finance/alokasi_migrasi_view');
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
	
	private function get_order_detail($order)
    {
        $this->load->model('menu_model');
        $this->load->model('order_menu_model');
        $order_menus_temp = $this->order_menu_model->get_menu($order->id);
        $order_menus = array();
        foreach ($order_menus_temp as $order_menu_temp)
        {
            $order_menu_temp->id_order_menu = $order_menu_temp->id;
			$array_identifier = $order->id."#".$order_menu_temp->menu_sequence;
			if (!isset($order_menus[$array_identifier])) //kalau udah di set, tgl diincrement aja jumlahnya
			{
				$order_menus[$array_identifier] = new stdClass();
				$order_menus[$array_identifier]->jumlah = 1;
				$order_menus[$array_identifier]->harga_min = $order_menu_temp->harga_min;
				$order_menus[$array_identifier]->harga_base = $order_menu_temp->harga_base;
				$order_menus[$array_identifier]->harga_akhir = $order_menu_temp->harga;
			}
			else
			{
				$order_menus[$array_identifier]->jumlah++;
				$order_menus[$array_identifier]->harga_min += $order_menu_temp->harga_min;
				$order_menus[$array_identifier]->harga_base += $order_menu_temp->harga_base;
				$order_menus[$array_identifier]->harga_akhir += $order_menu_temp->harga;
			}
        }
        $order->menu = $order_menus;
        return $order;
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