<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Fasilitas Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Fasilitas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//$this->output->enabled_profiler(true);

		$this->locations_table = 'lokasi_kerja';

		// set error delimeters
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);

		// model
		$this->load->model(
			array(
				'profile_model',
				'fasilitas_model',
				'areas_model'
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
	*	Showing list of locations and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/locations', 'refresh');
		}
		// Logged in
		else{

			$params = array();

			$q = $this->input->get('q', TRUE);
			$this->data['q'] = $q;

			$params['id_fasilitas'] = '';
			$params['q'] = $q;

			$this->data['data_list_area'] = $this->fasilitas_model->get_area();
			$this->data['data_list'] = $this->fasilitas_model->get_fasilitas($params);
			//$data['code_fasilitas'] = $this->fasilitas_model->getcode_fasilitas();

			// Set pagination
			$config['base_url']         = base_url('fasilitas/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 5;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			
			$params['q'] = $q;

			$this->data['data_list'] = $this->fasilitas_model->get_fasilitas($params, $config['per_page'], ($page-1) * $config['per_page']);
			$this->data['data_page'] = ($page-1) * $config['per_page'];
			
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_fasilitas/index', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_fasilitas/js');
			$this->load->view('js_script');

		}
	}
	// Index end

	/**
	*	Add New Data
	*	If there's data sent, insert
	*	Else, show the form
	*
	*	@return 	void
	*
	*/
	public function add()
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/fasilitas', 'refresh');
		}
		// Logged in
		else {

			// input validation rules
			
			$this->form_validation->set_rules('area_id', 'Area', 'trim|required');
			//$this->form_validation->set_rules('code', 'Code', 'alpha_numeric|trim|required|callback__code_check');
			$this->form_validation->set_rules('nama_fasilitas', 'Nama Fasilitas', 'trim|required');
			
			$this->form_validation->set_rules('detail', 'Detail', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$data = array(
						//'code'    => $this->input->post('code'),
						'nama_fasilitas' => $this->input->post('nama_fasilitas'),
						'area_id' => $this->input->post('area_id'),
						'detail'  => $this->input->post('detail')
					);

					// check to see if we are inserting the data
					if ($this->fasilitas_model->insert_fasilitas($data)) {

						$id_auto = $this->db->insert_id();

						// Success message
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Fasilitas Saved Successfully!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);

						// upload and change location photo
						$link_foto    = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('name')));
							$config['upload_path']   = './assets/uploads/images/fasilitas/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$config['encrypt_name']  = TRUE;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							//echo '<pre>';
							//print_r($config);
							//echo '</pre>';

							//exit;

							// fail to upload
							if (!$this->upload->do_upload('photo')) {
								
								// Error upload
								/*
								$this->session->set_flashdata('message',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Fasilitas Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);
								*/

								echo $config['upload_path'];
								$this->session->set_flashdata('message', $this->upload->display_errors(''));

							}
							// upload success, get path and filename
							else {

								$upload_data = $this->upload->data();
								//$this->upload->data('file_name');

								/*
								echo '<pre>';
								print_r($upload_data);
								echo '</pre>';
								die;
								*/

								// Proses pembuatan thumbnail
								$config['image_library']  = 'gd2';
								$config['source_image']   = "assets/uploads/images/fasilitas/".$upload_data['file_name'];
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

								//$this->fasilitas_model->update_fasilitas_by_code($this->input->post('code'), $datas);
								$this->fasilitas_model->update_fasilitas_by_code($id_auto, $datas);

							}

						}

					}
					else {

						// Error message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Fasilitas Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

					}

					//redirect('fasilitas', 'refresh');

				}
			}

			$this->data['data_list'] = $this->fasilitas_model->get_fasilitas();
			$this->data['data_list_area'] = $this->fasilitas_model->get_area();
			$this->data['open_form'] = "open";

			// Set pagination
			$config['base_url']         = base_url('fasilitas/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 10;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			$page = 1;
			$this->data['data_list'] = $this->fasilitas_model->get_fasilitas("",$config['per_page'],( $page - 1 ) * $config['per_page']);

			$this->data['data_page'] = ($page-1) * $config['per_page'];

			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_fasilitas/index', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_fasilitas/js');
			$this->load->view('js_script');

		}
	}
	// Add data end

	/**
	*	Callback to check duplicate code
	*
	*	@param 		string 		$code
	*	@return 	bool
	*
	*/
	public function _code_check($code)
	{
		$datas = $this->fasilitas_model->code_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message(
				'_code_check', 'The {field} already exists.'
			);
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate nama_fasilitas
	*
	*	@param 		string 		$nama_fasilitas
	*	@return 	bool
	*
	*/
	public function _nama_fasilitas_check($code)
	{
		$datas = $this->fasilitas_model->nama_fasilitas_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message(
				'_nama_fasilitas_check', 'The {field} already exists.'
			);
			return FALSE;
		}
	}
	// End _nama_fasilitas_check

	/**
	*	Edit Data
	*	If there's data sent, update
	*	Else, show the form
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function edit($id)
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login/fasilitas', 'refresh');
		}
		// Logged in
		else {

			// input validation rules

			$this->form_validation->set_rules('area_id', 'Area', 'trim|required');
			$this->form_validation->set_rules('nama_fasilitas', 'Nama Fasilitas', 'trim|required');
			
			$this->form_validation->set_rules('detail', 'Detail', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {

					$data = array(
						//'code'    => $this->input->post('code'),
						'area_id' => $this->input->post('area_id'),
						'nama_fasilitas' => $this->input->post('nama_fasilitas'),
						'detail'  => $this->input->post('detail')
					);

					// check to see if we are updating the data
					if ($this->fasilitas_model->update_fasilitas($id, $data)) {

						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')."Fasilitas Updated!".$this->config->item('success_end_delimiter', 'ion_auth')
						);

						// upload and change location photo
						$link_foto      = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']   = trim($this->input->post('id').str_replace(" ", "_", $this->input->post('nama_fasilitas')));
							$config['upload_path']   = './assets/uploads/images/fasilitas/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$config['encrypt_name']  = TRUE;
							$this->load->library('upload', $config);

							// fail to upload
							if (!$this->upload->do_upload('photo')) {

								// Error upload
								/*
								$this->session->set_flashdata('message',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Fasilitas Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);
								*/

								echo $config['upload_path'];
								$this->session->set_flashdata('message', $this->upload->display_errors(''));

							}
							// upload success, get path and filename
							else {
								$upload_data = $this->upload->data();

								// Proses pembuatan thumbnail
								$config['image_library']  = 'gd2';
								$config['source_image']   = "assets/uploads/images/fasilitas/".$upload_data['file_name'];
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
									unlink("assets/uploads/images/fasilitas/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/fasilitas/".$this->input->post('curr_thumbnail'));
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;
								$this->fasilitas_model->update_fasilitas_by_code($id, $datas);
							}
						}

					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Fasilitas Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('fasilitas', 'refresh');
				}
			}

			// Get data

			$params = array();
			$params['id_fasilitas'] = $id;
			$params['q'] = '';

			$this->data['data_list_area'] = $this->fasilitas_model->get_area();
			$this->data['data_list'] = $this->fasilitas_model->get_fasilitas($params);
			$this->data['id']        = $id;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_fasilitas/edit', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_fasilitas/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to locations
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function delete($id, $photo, $thumbnail)
	{

		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/fasilitas', 'refresh');
		}
		// Jika login
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// input validation rules
				$this->form_validation->set_rules('id', 'ID', 'trim|numeric|required');

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$data = array(
						'deleted' => '1',
					);

					// check to see if we are updating the data
					if ($this->fasilitas_model->delete_data($id)) {

						// delete old Photo
						if ($photo != "") {
							unlink("assets/uploads/images/fasilitas/".$photo);
							unlink("assets/uploads/images/fasilitas/".$thumbnail);
						}

						$this->session->set_flashdata('message',$this->config->item('success_start_delimiter', 'ion_auth')."Fasilitas Deleted!".$this->config->item('success_end_delimiter', 'ion_auth'));
					
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Fasilitas Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('fasilitas', 'refresh');
		}
	}
	// Delete data end

	public function by_area()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// inventory by category summary
			$this->data['summary'] = $this->fasilitas_model->get_fasilitas_by_area_summary();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_fasilitas/list_data_area');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_fasilitas/js');
			$this->load->view('js_script');
		}
	}

	public function by_jenis($id_lok = "")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/fasilitas', 'refresh');
		}
		// Logged in
		else{

			$area_detail = $this->areas_model->get_area_by_id_lok($id_lok);
	
			// If exists, set detailed data. Else redirect back because invalid id_lok
				
			if (count($area_detail->result())>0) {
					
				foreach ($area_detail->result() as $area_data) {
					$this->data['nama_lokasi'] = $area_data->nama_lokasi;
					$this->data['alamat_lengkap'] = $area_data->alamat_lengkap;
				}

			}
			else {
				redirect('fasilitas/by_area', 'refresh');
			}

			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['nama_faskes'] = $this->session->userdata('nama_faskes');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
			//$data['level'] = $this->session->userdata('level');
				
			$this->data['title']="Fasilitas";	
			$this->data['subtitle']=" Area / Fasilitas";
				
			$this->data['tabletitle'] = '<small class="label label-info">' . 'Area : ' . $this->data['nama_lokasi'] . '</small>&nbsp;' .
			'<small class="label label-warning">' . 'Alamat : ' . $this->data['alamat_lengkap'] . '</small>';

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Monitoring</a></li>
									<li><a href=\"" . site_url() . "fasilitas/by_area\">Area</a></li>
									<li class=\"active\">Fasilitas</li>";

			$params = array();
			$params['id_lok'] = $id_lok;

			$this->data['data_list'] = $this->fasilitas_model->get_fasilitas($params);
			$this->data['id_lok'] = $id_lok;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_fasilitas/list_data_jenis_fasilitas', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_fasilitas/js');
			//$this->load->view('js_script');
			
		}
	}

	function datatables_fasilitas_by_area()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
       
		/* DB table to use */
		$sTable = "inv_fasilitas";
     
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
		
		$aColumns = array('inv_fasilitas.nama_fasilitas');
		//$aColumns = array('no_baris', 'idabsen', 'is_pimpinan_approve', 'nip', 'Nama', 'Tanggal', 'KdAbsen', 'Keterangan', 'Departemen');
  
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
		$jenis_fasilitas = (isset($_GET['jenis_fasilitas']))?($_GET['jenis_fasilitas']):'0';
		$jenis_fasilitas = ($jenis_fasilitas == '') ? '0' : $jenis_fasilitas;

		$id_lok = $this->uri->segment('3');

		$params = array();
		$params['id_lok'] = $id_lok;
		$params['jenis_fasilitas'] = $jenis_fasilitas;
		
		$rResult = $this->fasilitas_model->getlist_fasilitas_by_area($aColumns, $sWhere, $sOrder, $top, $limit, $params);
       
		$iTotal = 0;
        $rResultTotal = $this->fasilitas_model->getlist_fasilitas_by_area_total($sIndexColumn, $params);
        $iTotal = $rResultTotal->row()->total_jml_data;
	   
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->fasilitas_model->getlist_fasilitas_by_area_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params);
		$iFilteredTotal = $rResultTotalFiltered->row()->total_jml_data;
		
		$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
		$output = array(
			"sEcho" => $sEcho,
			//"draw" => intval($draw),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"jenis_fasilitas" => $jenis_fasilitas,
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
			$row[] = $aRow->code;

			$tombol_list_set = '<i class="ui-tooltip fa fa-book" title="Detail Fasilitas" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Detail Fasilitas" onclick="detail_fasilitas('."'".$aRow->id."'".')"></i>';
	
			$row[] = $aRow->nama_fasilitas;
			$row[] = $aRow->jenis_fasilitas;

			$row[] = $aRow->detail;

			if ($aRow->thumbnail != ''){

				$row[] = '<a href="' . base_url('assets/uploads/images/fasilitas/') . $aRow->photo . '" data-fancybox data-caption="' . $aRow->nama_fasilitas . '">
				<img src="' . base_url('assets/uploads/images/fasilitas/') . $aRow->thumbnail . '" alt="' . $aRow->nama_fasilitas . '">
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

}

/* End of fasilitas.php */
