<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Laporan extends CI_Controller {

	public function __construct()
    {

        parent::__construct();
		// profiler ini untuk menampilkan debug
		// $this->output->enable_profiler(TRUE);
		
		// set error delimeters
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);
			
		//$this->load->model('m_date', '', TRUE);
		
		// model
		$this->load->model(
			array(
				'profile_model',
				'units_model',
				'fasilitas_model',
				'penghunis_model',
				'counter_model',
				'logs_model',
				'laporan_model'
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
			$this->data['user_photo']     = $this->profile_model->get_user_photo($loggedinuser->username)->row();
		}
			  
    }

	public function index($page="")
	{

		// Not logged in, redirect to laporan
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/laporan', 'refresh');
		}
		// Logged in
		else {

			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['nama_faskes'] = $this->session->userdata('nama_faskes');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
			//$data['level'] = $this->session->userdata('level');
				
			$this->data['title'] = "Laporan";
			$this->data['subtitle']=" Laporan / Rekap Ticket Insident";
				
			$data['tabletitle'] = "Laporan Rekap Ticket Insident";

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i>&nbsp;Laporan</a></li>
									<li class=\"active\">Rekap Aset Unit</li>";

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('laporan/laporan_rekap_aset_unit', $this->data);
			$this->load->view('partials/_alte_footer');

			$this->load->view('laporan/js');

		}

	}
	
	function rekap_aset_unit()
	{

		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['user_id'] = $this->session->userdata('user_id');
		$data['level'] = $this->session->userdata('level'); 

		// end passing config and variable data

		if ($_SERVER['REQUEST_METHOD'] === 'GET'){

			$data['id_lok'] = $this->input->get('id_lok');
			$data['id_unit'] = $this->input->get('id_unit');
			$data['jenis_laporan'] = $this->input->get('jenis_laporan');

			// Something get
		  
			if (isset($_GET['btn_print'])){
			  
				// btn_print

				$query_laporan_list = $this->laporan_model->get_rekap_aset_unit($data);

				if (count($query_laporan_list) > 0) {

					$array_column_list = array();
					$index_array = 0;

					foreach($query_laporan_list as $row_data) {
						$array_column_list[$row_data->bagian] = $row_data->bagian;
					}

					$array_column_list_unique = array_unique($array_column_list);

					$data['column_list'] = $array_column_list_unique;
					$data['laporan_list'] = $this->laporan_model->get_rekap_aset_unit($data);

				} else {
					// if data kosong
					$goTo = site_url().'laporan';
					echo $this->fungsi->warning('Data yang Anda cari tidak tersedia !!', $goTo);
				}

				/*
				echo '<pre>';
				print_r($data);
				echo '</pre>';
				exit;
				*/

			} else {
			  
				// btn_excel

				echo 'au ah';

			}
		  
		}

		$this->load->view('laporan/rpt_rekap_aset_unit',$data);
		
	}

	// export file Xlsx, Xls and Csv
	function export()
	{

		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['user_id'] = $this->session->userdata('user_id');
		$data['level'] = $this->session->userdata('level');

		$data['dtfrom'] = htmlspecialchars((isset($_GET['dtfrom'])?$_GET['dtfrom']:'0000-00-00'));
		$data['dtto'] = htmlspecialchars((isset($_GET['dtto'])?$_GET['dtto']:'0000-00-00'));
		$data['jaminan_berobat'] = htmlspecialchars((isset($_GET['jaminan_berobat'])?$_GET['jaminan_berobat']:'0'));
		$data['metode_pembayaran'] = htmlspecialchars((isset($_GET['metode_pembayaran'])?$_GET['metode_pembayaran']:'0'));
		$data['id_faskes'] = htmlspecialchars((isset($_GET['id_faskes'])?$_GET['id_faskes']:'0'));
		$data['id_user'] = htmlspecialchars((isset($_GET['id_user'])?$_GET['id_user']:'0'));
		$data['nama_faskes'] = htmlspecialchars((isset($_GET['nama_faskes'])?$_GET['nama_faskes']:'-'));
		$data['jenis_laporan'] = htmlspecialchars((isset($_GET['jenis_laporan'])?$_GET['jenis_laporan']:'0'));

		$data['sdate_from'] = $this->fungsi->tanggal_indo($data['dtfrom']);
		$data['sdate_to'] = $this->fungsi->tanggal_indo($data['dtto']); 
		$data['ds_alamat'] = $this->config->item('ds_alamat'); 
		$data['ds_email'] = $this->config->item('ds_email');
		$data['ds_site'] = $this->config->item('ds_site'); 
		
		$extension = $this->input->post('export_type');

		if(!empty($extension)){
			$extension = $extension;
		} else {
			$extension = 'xlsx';
		}

		$this->load->helper('download');	
		//$data = array();
		$data['title'] = 'Export Excel Sheet | Coders Mag';

		// get rekap voucher list
		$list_rekap_voucher = $this->mdl_trantarobat->get_rekap_voucher($data);

		$fileName = 'rekap_pemakaian_voucher-'.time(); 

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		$sheet->setCellValue('A1', 'No.');
		$sheet->setCellValue('B1', 'Nama Sponsor');
		$sheet->setCellValue('C1', 'Nama Pasien');
		$sheet->setCellValue('D1', 'Nomor Handphone');
        $sheet->setCellValue('E1', 'Tgl Order');
		$sheet->setCellValue('F1', 'Jarak');
		$sheet->setCellValue('G1', 'Biaya Ongkir');
        $sheet->setCellValue('H1', 'Kode Voucher');
		$sheet->setCellValue('I1', 'Biaya Voucher');
		$sheet->setCellValue('J1', 'Pasien Bayar');
		$sheet->setCellValue('K1', 'Minimum Potongan (20%)');
		$sheet->setCellValue('L1', 'Diskon Sponsor');
		$sheet->setCellValue('M1', 'Jumlah Tagihan');
		$sheet->setCellValue('N1', 'Free Ongkir');

		for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
			$spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
		}

		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(TRUE);

		$from = "A1"; // or any value
		$to = "N1"; // or any value
		$spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

		$sheet->getStyle('A1:N1')->getAlignment()->setHorizontal('center');
		
		/*
		echo '<pre>';
		echo print_r($list_rekap_voucher);
		echo '</pre>';
		*/

		$rowCount = 2;
		$no_urut_data = 1;
        foreach ($list_rekap_voucher as $element) {

			$sheet->setCellValue('A' . $rowCount, $no_urut_data);
			$sheet->getStyle('A' . $rowCount)->getAlignment()->setHorizontal('center');

			$sheet->setCellValue('B' . $rowCount, $element['nama_faskes']);
			$sheet->setCellValue('C' . $rowCount, $element['nama_pasien']);
			
			$sheet->setCellValue('D' . $rowCount, $element['nmr_hp']);
			$sheet->getStyle('D' . $rowCount)->getAlignment()->setHorizontal('center');

			$sheet->setCellValue('E' . $rowCount, tgl_indo_ddmmyyyy(date('Y-m-d', strtotime($element['tgl_order']))));
			$sheet->getStyle('E' . $rowCount)->getAlignment()->setHorizontal('center');
			
			$jarak = $this->fungsi->pecah($element['jarak']);
			//$jarak = str_replace(".",",",$jarak);
			$sheet->setCellValue('F' . $rowCount, $jarak);
			$sheet->getStyle('F' . $rowCount)->getAlignment()->setHorizontal('right');
			
			//$jmlh_pembayaran = $this->fungsi->pecah($element['jmlh_pembayaran']);
			//$jmlh_pembayaran = str_replace(".",",",$jmlh_pembayaran);

			$sheet->setCellValue('G' . $rowCount, $element['jmlh_pembayaran']);
			$spreadsheet->getActiveSheet()->getStyle('G' . $rowCount)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
			//$sheet->getStyle('G' . $rowCount)->getAlignment()->setHorizontal('right');

			$sheet->setCellValue('H' . $rowCount, $element['kode_voucher']);

			$sheet->setCellValue('I' . $rowCount, $element['biaya_voucher']);
			$spreadsheet->getActiveSheet()->getStyle('I' . $rowCount)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
			
			$sheet->setCellValue('J' . $rowCount, $element['pasien_bayar']);
			$spreadsheet->getActiveSheet()->getStyle('J' . $rowCount)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

			$sheet->setCellValue('K' . $rowCount, $element['20_persen_of_ongkir']);
			$spreadsheet->getActiveSheet()->getStyle('K' . $rowCount)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

			$sheet->setCellValue('L' . $rowCount, $element['diskon_sponsor']);
			$spreadsheet->getActiveSheet()->getStyle('L' . $rowCount)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

			$sheet->setCellValue('M' . $rowCount, $element['jml_tagihan']);
			$spreadsheet->getActiveSheet()->getStyle('M' . $rowCount)->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
			
			$sheet->setCellValue('N' . $rowCount, $element['free_ongkir']);
			$sheet->getStyle('N' . $rowCount)->getAlignment()->setHorizontal('center');
			
			$no_urut_data++;
			$rowCount++;
			
        }

        if($extension == 'csv'){    			
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
			$fileName = $fileName.'.csv';
		} elseif($extension == 'xlsx') {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$fileName = $fileName.'.xlsx';
		} else {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
			$fileName = $fileName.'.xls';
		}

		$this->output->set_header('Content-Type: application/vnd.ms-excel');
		$this->output->set_header("Content-type: application/csv");
		$this->output->set_header('Cache-Control: max-age=0');
		$writer->save(ROOT_UPLOAD_PATH.$fileName); 
		//redirect(HTTP_UPLOAD_PATH.$fileName); 
		$filepath = file_get_contents(ROOT_UPLOAD_PATH.$fileName);
		force_download($fileName, $filepath);

	}
		
}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */