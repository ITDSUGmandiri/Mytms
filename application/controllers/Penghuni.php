<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Penghuni Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Penghuni extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//$this->output->enabled_profiler(true);

		// set error delimeters
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);

		// model
		$this->load->model(
			array(
				'profile_model',
				'units_model',
				'fasilitas_model',
				'penghunis_model',
				'counter_model',
				'logs_model'
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

	/**
	*	Index Page for this controller.
	*	Showing list of penghuni and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/penghuni', 'refresh');
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
				
			$this->data['title']="Penghuni";	
			$this->data['subtitle']=" Master Data / Penghuni";
				
			$data['tabletitle'] = "List Master Data Penghuni";

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i>&nbsp;&nbsp;Master Data</a></li>
									<li class=\"active\">Penghuni</li>";

			//$this->data['data_list'] = $this->inventory_model->get_unit_by_id_lok($id_lok);

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_penghuni/list_data_penghuni', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_penghuni/js', $this->data);

		}

	}
	// Index end

	public function add()
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/penghuni', 'refresh');
		}

		$this->data['open_form'] = "open";

		// set the flash data error message if there is one
		//$this->data['message'] = (validation_errors()) ? validation_errors() :
		//$this->session->flashdata('message');

		$this->load->view('partials/_alte_header', $this->data);
		$this->load->view('partials/_alte_menu');
		$this->load->view('inv_penghuni/add', $this->data);
		$this->load->view('partials/_alte_footer');
		//$this->load->view('inv_unit/js');

		// ada library datepicker, wyswyg
		$this->load->view('js_script');

	}

	public function save_add(){

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/penghuni', 'refresh');
		}

		// input validation rules
			
		$this->form_validation->set_rules('nama_penghuni', 'Nama Penghuni', 'trim|required');
		$this->form_validation->set_message('required', '%s Harus diisi');

		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'callback__jk_check');
		$this->form_validation->set_rules('hubungan', 'Hubungan', 'callback__hubungan_check');

		// validation run
		if ($this->form_validation->run() === TRUE) {

			$loggedinuser = $this->ion_auth->user()->row();
			$tiket = $this->counter_model->getcodepenghuni();

			$data = array(
				'kode'       	=> $tiket,
				'nama'			=> $this->input->post('nama_penghuni'),
				'jk'			=> $this->input->post('jk'),
				'jabatan'		=> $this->input->post('jabatan'),
				'unit_kerja'	=> $this->input->post('unit_kerja'),
				'pasangan'		=> $this->input->post('pasangan'),
				'hubungan'		=> $this->input->post('hubungan'),
				'telp'       	=> $this->input->post('telp'),
				'anak1'			=> $this->input->post('anak1'),
				'anak2'			=> $this->input->post('anak2'),
				'anak3'			=> $this->input->post('anak3'),
				'anak4'   		=> $this->input->post('anak4'),
				'anak5'       	=> $this->input->post('anak5'),
				'lama_menetap'  => $this->fungsi->date2mysql($this->input->post('lama_menetap')),
				'user_id' 		=> $loggedinuser->id,
				'user_create' 	=> $loggedinuser->username,
				'create_date' 	=> date('Y-m-d H:i:s'),
			);

			if ($this->penghunis_model->insert_data($data)){

				$id_auto = $this->db->insert_id();

				// upload and change unit photo
				$link_foto      = "";
				$link_thumbnail = "";
		
				if (!empty($_FILES['photo']['name'])) {

					//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
					$config['upload_path']   = './assets/uploads/images/penghuni/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size']      = 2048;
					$config['overwrite']     = TRUE;
					$config['encrypt_name']  = TRUE;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					// fail to upload
					if (!$this->upload->do_upload('photo')) {

						// Error upload
						/*
						$this->session->set_flashdata('message',
						$this->config->item('success_start_delimiter', 'ion_auth')
						."Location Saved Successfully!<br>Failed to upload the photo!".
						$this->config->item('success_end_delimiter', 'ion_auth')
						);
						*/

						echo $config['upload_path'];
						$this->session->set_flashdata('error', $this->upload->display_errors(''));

					}
					// upload success, get path and filename
					else {

						$upload_data = $this->upload->data();

						// Proses pembuatan thumbnail
						$config['image_library']  = 'gd2';
						$config['source_image']   = "assets/uploads/images/penghuni/".$upload_data['file_name'];
						$config['create_thumb']   = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width']          = 180;

						$this->load->library('image_lib', $config);

						if ($this->image_lib->resize()){
							$link_foto      = $upload_data['file_name'];
							$link_thumbnail = $upload_data['raw_name'] . "_thumb" . $upload_data['file_ext'];
						}

						// save to database
						$datas['photo']     = $link_foto;
						$datas['thumbnail'] = $link_thumbnail;

						//$this->inventory_model->update_inventory_by_code($this->input->post('code'), $datas);
						$this->penghunis_model->update_penghuni_by_code($id_auto, $datas);

					}
				}

				$this->session->set_flashdata('success', 'Tambah' . ' data penghuni berhasil');
				//$this->session->set_flashdata('success',$this->config->item('message_start_delimiter', 'ion_auth')."Data Saved Successfully!".$this->config->item('message_end_delimiter', 'ion_auth'));

			} // if ($this->penghunis_model->insert_data($data)){
			else {

				// Set message
				$this->session->set_flashdata('error',
					$this->config->item('error_start_delimiter', 'ion_auth')."Data Saving Failed!".$this->config->item('error_end_delimiter', 'ion_auth')
				);

			}

			redirect('penghuni/add', 'refresh');

		} 
		// validation Failed
		else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('auth/login/penghuni', 'refresh');
			}

			$this->data['open_form'] = "open";

			// set the flash data error message if there is one
			//$this->data['message'] = (validation_errors()) ? validation_errors() :
			//$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_penghuni/add', $this->data);
			$this->load->view('partials/_alte_footer');
			//$this->load->view('inv_unit/js');

			// ada library datepicker, wyswyg
			$this->load->view('js_script');

		}

	}

	public function edit($id)
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/penghuni', 'refresh');
		}
		// Logged in
		else {

			$this->data['list_penghuni'] = $this->penghunis_model->getlist_penghuni_byid($id);

			$this->data['open_form'] = "open";
			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_penghuni/edit', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_penghuni/js');

			// ada library datepicker, wyswyg
			$this->load->view('js_script');

		}

	}

	public function save_edit(){

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/penghuni', 'refresh');
		}
		// Logged in
		else {

			// input validation rules
			
			$this->form_validation->set_rules('nama_penghuni', 'Nama Penghuni', 'trim|required');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'callback__jk_check');
			$this->form_validation->set_rules('hubungan', 'Hubungan', 'callback__hubungan_check');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$loggedinuser = $this->ion_auth->user()->row();

					$data = array(
						'nama'			=> $this->input->post('nama_penghuni'),
						'jk'			=> $this->input->post('jk'),
						'jabatan'		=> $this->input->post('jabatan'),
						'unit_kerja'	=> $this->input->post('unit_kerja'),
						'pasangan'		=> $this->input->post('pasangan'),
						'hubungan'		=> $this->input->post('hubungan'),
						'telp'       	=> $this->input->post('telp'),
						'anak1'			=> $this->input->post('anak1'),
						'anak2'			=> $this->input->post('anak2'),
						'anak3'			=> $this->input->post('anak3'),
						'anak4'   		=> $this->input->post('anak4'),
						'anak5'       	=> $this->input->post('anak5'),
						'lama_menetap'  => $this->fungsi->date2mysql($this->input->post('lama_menetap')),
						'user_id' 		=> $loggedinuser->id
					);

					// check to see if we are inserting the data
					if ($this->penghunis_model->update_data($this->input->post('id'), $data)) {

						//$id_auto = $this->db->insert_id();

						// logging array

						$log = array(
							'id_task' => $id_auto,
							'user_id' => $loggedinuser->username,
							'log_status' => 1,
							'keterangan' => 'ubah unit',
							'create_date' => date('Y-m-d H:i:s')
						);

						// Insert logs
						//$this->logs_model->add_log($log);

						// upload and change unit photo
						$link_foto      = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/penghuni/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$config['encrypt_name']  = TRUE;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							// fail to upload
							if (!$this->upload->do_upload('photo')){

								// Error upload
								$this->session->set_flashdata('error',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Penghuni Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);

								// echo $config['upload_path'];
								//$this->session->set_flashdata('error', $this->upload->display_errors(''));
								//die;

							}
							// upload success, get path and filename
							else {

								$upload_data = $this->upload->data();

								// Proses pembuatan thumbnail
								$config['image_library']  = 'gd2';
								$config['source_image']   = "assets/uploads/images/penghuni/".$upload_data['file_name'];
								$config['create_thumb']   = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['width']          = 180;

								$this->load->library('image_lib', $config);

								if ($this->image_lib->resize()){
									$link_foto      = $upload_data['file_name'];
									$link_thumbnail = $upload_data['raw_name'] . "_thumb" . $upload_data['file_ext'];
								}

								// delete old Photo
								if ($this->input->post('curr_photo')!="") {
									unlink("assets/uploads/images/penghuni/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/penghuni/".$this->input->post('curr_thumbnail'));
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;

								$this->penghunis_model->update_penghuni_by_code($this->input->post('id'), $datas);

							}
						}

						if (!$this->upload->do_upload('photo')){

						} else {
							$this->session->set_flashdata('success', 'Ubah' . ' data penghuni berhasil');
						}

					}
					else {

						// Set message
						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

					}

					redirect('penghuni/edit/'.$this->input->post('id'), 'refresh');

				}
				// validation Failed
				else {

					$this->data['list_penghuni'] = $this->penghunis_model->getlist_penghuni_byid($this->input->post('id'));

					$this->data['open_form'] = "open";

					// set the flash data error message if there is one
					$this->data['error'] = (validation_errors()) ? validation_errors() :

					// Set message
					$this->session->set_flashdata('error',
						$this->config->item('error_start_delimiter', 'ion_auth')
						."Validation Errors!".
						$this->config->item('error_end_delimiter', 'ion_auth')
					);

					$this->data['open_form'] = "open";
					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('inv_penghuni/edit', $this->data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_penghuni/js');

					// ada library datepicker, wyswyg
					$this->load->view('js_script');

				}

			}
			else {

				$this->data['list_penghuni'] = $this->penghunis_model->getlist_penghuni_byid($id);

				$this->data['open_form'] = "open";
				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_penghuni/edit', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_penghuni/js');

				// ada library datepicker, wyswyg
				$this->load->view('js_script');

			}

		}

	}

	public function _jk_check($value)
	{
		if ($value == '0'){
			$this->form_validation->set_message('_jk_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	public function _hubungan_check($value)
	{
		if ($value == '0'){
			$this->form_validation->set_message('_hubungan_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

    function datatables_penghuni()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
       
		/* DB table to use */
		$sTable = "penghuni";
     
		/* Database connection information 
		$gaSql['user']       = "";
		$gaSql['password']   = "";
		$gaSql['db']         = "";
		$gaSql['server']     = "";
		*/
     
		/*
		* Columns
		* If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
		* If not this will grab all the columns associated with $sTable
		*/
		
		$aColumns = array('penghuni.kode', 'nama');
  
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
		 * no need to edit below this line
		 */
		 
		/*
		 * ODBC connection
		 */
		//$connectionInfo = array("UID" => $gaSql['user'], "PWD" => $gaSql['password'], "Database"=>$gaSql['db'],"ReturnDatesAsStrings"=>true);
		//$gaSql['link'] = sqlsrv_connect( $gaSql['server'], $connectionInfo);
		$params = array();
		//$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                  
		/* Ordering */
		
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ) 
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".addslashes( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ) 
			{
				$sOrder = "";
			}
			
		}
       
		/* Filtering */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )  {
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				} else {
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
			}
		}
       
		/* Paging */
		$top = (isset($_GET['iDisplayStart']))?((int)$_GET['iDisplayStart']):0;
		$limit = (isset($_GET['iDisplayLength']))?((int)$_GET['iDisplayLength']):10;
	
		$sQuery = "SELECT TOP $limit ".implode(",",$aColumns)."
        FROM $sTable
        $sWhere ".(($sWhere=="")?" WHERE ":" AND ")." $sIndexColumn NOT IN
        (
            SELECT $sIndexColumn FROM
            (
                SELECT TOP $top ".implode(",",$aColumns)."
                FROM $sTable
                $sWhere
                $sOrder
            )
            as [virtTable]
        )
		$sOrder";

		//$draw = $_GET['draw'];
		$id_lok = (isset($_GET['id_lok']))?($_GET['id_lok']):'0';
		$id_lok = ($id_lok == '') ? '0' : $id_lok;

		$id_unit = (isset($_GET['id_unit']))?($_GET['id_unit']):'0';
		$id_unit = ($id_unit == '') ? '0' : $id_unit;

		$id_status = (isset($_GET['id_status']))?($_GET['id_status']):'0';
		$id_status = ($id_status == '') ? '0' : $id_status;

		$klasifikasi_id = (isset($_GET['klasifikasi_id']))?($_GET['klasifikasi_id']):'0';
		$klasifikasi_id = ($klasifikasi_id == '') ? '0' : $klasifikasi_id;

		$params = array();
		$params['id_lok'] = $id_lok;
		$params['id_unit'] = $id_unit;
		
		$rResult = $this->penghunis_model->getlist_penghuni($aColumns, $sWhere, $sOrder, $top, $limit, $params);
       
		$iTotal = 0;
        $rResultTotal = $this->penghunis_model->getlist_penghuni_total($sIndexColumn, $params);
        $iTotal = $rResultTotal->row()->total_jml_data;
	   
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->penghunis_model->getlist_penghuni_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params);
		$iFilteredTotal = $rResultTotalFiltered->row()->total_jml_data;
		
		$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
		$output = array(
			"sEcho" => $sEcho,
			//"draw" => intval($draw),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"id_status" => $id_status,
			"aaData" => array()
		);	

		//date_default_timezone_set('Asia/Jakarta');
		
		$numbering = $top;
		$page = 1;
		$tombol_reset = '';

		foreach ($rResult->result() as $aRow) 
		{
			
			$numbering++;
			$row = array();			
			$row[] = $numbering; 
			$row[] = $aRow->nama_lokasi;

			$tombol_list_set = '<i class="ui-tooltip fa fa-pencil-square-o" title="Edit Data" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Edit Data" onclick="edit('."'".$aRow->id."',"."'".$aRow->photo."',"."'".$aRow->thumbnail."'".')"></i>&nbsp;
			<i class="ui-tooltip fa fa-book" title="Lihat Detil Penghuni" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Detil Aset" onclick="detail_penghuni('."'".$aRow->kode."'".')"></i>&nbsp;
			<i class="ui-tooltip fa fa-trash-o" title="Hapus Data" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Hapus Data" onclick="hapus_data('."'".$aRow->id."',"."'".$aRow->photo."',"."'".$aRow->thumbnail."'".')"></i>';
	
			$row[] = $aRow->nama_unit;
			$row[] = $aRow->nama;

			$row[] = $aRow->jk;
			$row[] = $aRow->telp;
			$row[] = $aRow->jabatan;
            $row[] = $aRow->unit_kerja;

			if ($aRow->thumbnail != ''){

				$row[] = '<a href="' . base_url('assets/uploads/images/penghuni/') . $aRow->photo . '" data-fancybox data-caption="' . $aRow->nama . '">
				<img src="' . base_url('assets/uploads/images/penghuni/') . $aRow->thumbnail . '" alt="' . $aRow->nama . '">
				</a>';

			} else {
				$row[] = '';
			}

			$row[] = $tombol_list_set;

			$page++;
			$output['aaData'][] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 
    
		echo json_encode($output);
		
	}

	function hapus_data()
	{

		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/penghuni', 'refresh');
		}
		// Jika login
		else
		{

			$status = "";
			$msg = "";
			$data_notif = "";
			
			//$id = $this->uri->segment(3);
			$id = $this->input->post('id');
			$photo = $this->input->post('photo');
			$thumbnail = $this->input->post('thumbnail');

			$is_success = $this->penghunis_model->hapus_data($id);
			//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data user Dengan ID '.$id.' Berhasil Dihapus.</div>');

			if ($is_success){

				// delete old Photo
				if ($photo != "") {
					unlink("assets/uploads/images/penghuni/".$photo);
					unlink("assets/uploads/images/penghuni/".$thumbnail);
				}

				//$this->session->set_flashdata('message',$this->config->item('success_start_delimiter', 'ion_auth')."Fasilitas Deleted!".$this->config->item('success_end_delimiter', 'ion_auth'));

				$status = "success";
				$msg = "Data successfully delete !!";
				$data_notif = "Data berhasil dihapus !!";
			}
			else {						
				$status = "error";
				$msg = "Something went wrong when deleted the data, please try again.";
				$data_notif = "Data gagal dihapus !!";
			}	
		
			echo json_encode(array('status' => $status, 'msg' => $msg, 'data_notif' => $data_notif));
				
		}
		
	}

	public function detail_penghuni($kode = '')
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/penghuni', 'refresh');
		}
		// Logged in
		else{

			// If id_lok is provided, show data based on id_lok
			if ($kode!="") {

				$data['username'] = $this->session->userdata('username');
				$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
				$data['nama_faskes'] = $this->session->userdata('nama_faskes');
				$data['email'] = $this->session->userdata('email');
				$data['address'] = $this->session->userdata('address');
				$data['phone'] = $this->session->userdata('phone');
				$data['level'] = $this->session->userdata('level');
				
				$this->data['title']="Detail";
				$this->data['subtitle']=" Master Data / Penghuni";
				
				$this->data['tabletitle'] = '<small class="label label-info">' . 'Unit : ' . '-' . '</small>&nbsp;' .
				'<small class="label label-warning">' . 'Blok : ' . '-' . '</small>&nbsp;' . '<small class="label label-success">' . 'No. Unit : ' . '-' . '</small>';

				$this->data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Master Data</a></li>
										<li class=\"active\">Penghuni</li>";

				$this->data['data_detail'] = $this->penghunis_model->get_penghuni_by_kode($kode);

				if (count($this->penghunis_model->get_penghuni_by_kode($kode)->result()) == 0){
					// if data kosong
					$goTo = site_url().'penghuni';
					echo $this->fungsi->warning('Data yang Anda cari tidak tersedia !!', $goTo);
				}

				$this->data['kode'] = $kode;

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_penghuni/detail_penghuni', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_penghuni/js');
				//$this->load->view('js_script');

			} else {
				redirect('penghuni');
			}

		}
	}

}

/* End of Penghuni.php */