<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Ticket Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Ticket extends CI_Controller {

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
				'tickets_model',
				'counter_model',
				'logs_model',
				'Model_Helpdesk'
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
	*	Showing list of unit and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/ticket', 'refresh');
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
				
			$this->data['title']="Ticket";	
			$this->data['subtitle']=" Transaksi / Ticket";
				
			$data['tabletitle'] = "List Transaksi Ticket";

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i>&nbsp;Transaksi</a></li>
									<li class=\"active\">Ticket</li>";

			//$this->data['data_list'] = $this->inventory_model->get_unit_by_id_lok($id_lok);

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('ticket/list_data_ticket', $this->data);
			$this->load->view('partials/_alte_footer');

			$this->load->view('ticket/js');

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
			redirect('auth/login/ticket', 'refresh');
		}
		// Logged in
		else {

			$this->form_validation->set_rules('pelapor', 'Pelapor', 'required');
			$this->form_validation->set_message('required', '{field} Harus Di Isi');

			$this->form_validation->set_rules('job_detail', 'Laporan Problem', 'required');
			$this->form_validation->set_message('required', '{field} Harus Di Isi');

			// input validation rules 
			$this->form_validation->set_rules('id_lok', 'Area', 'callback__area_id_check');
			$this->form_validation->set_rules('id_unit', 'Unit', 'callback__unit_id_check');

			$this->form_validation->set_rules('service_family_id', 'Service Family', 'callback__service_family_id_check');
			$this->form_validation->set_rules('type_incident', 'Type Incident', 'callback__type_incident_id_check');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$loggedinuser = $this->ion_auth->user()->row();

					$tiket = $this->counter_model->getcodecm();

					/*
					$data = array(
						'user_id' 		=> $loggedinuser->id,
						'user_create' 	=> $loggedinuser->username,
						'create_date' 	=> date('Y-m-d H:i:s'),
						'status_unit' 	=> 1,
						'type' => 0
					);
					*/

					$nama_unit = '';
					$blok = '';
					$no_unit = '';

					$cek_unit  = $this->db->query("SELECT A.id_lok,A.blok,A.no_unit,A.nama_unit FROM unit A  where A.id='$unit'")->row_array();

					if ($cek_unit) {
						$nama_unit = $cek_unit['nama_unit'];
						$blok = $cek_unit['blok'];
						$no_unit = $cek_unit['no_unit'];
					}

					$data_task = array(
						'tiket' => $tiket,
						'id_area' => $this->input->post('id_lok'),
						'id_unit' => $this->input->post('id_unit'),
						'type' => 'high',
						'job_detail' => strip_tags($this->input->post('job_detail')),
						'pelapor' => strip_tags($this->input->post('pelapor')),
						'status' => 1,
						'value_progres' => 0,

						'pic' => $this->input->post('hidden_username1'),
						'pic1' => $this->input->post('hidden_username2'),

						'petugas1_id' => $this->input->post('petugas1'),
						'petugas2_id' => $this->input->post('petugas2'),

						'user_create' => $loggedinuser->username,
						'create_date' => date("Y-m-d H:i:s"),
						'type_problem' => $this->input->post('type_incident'),
						'ntf' => 0,
						'service_family_id' => $this->input->post('service_family_id')
					);

					$add = $this->db->insert('schedule_job', $data_task);

					$tokenTL = $this->db->query("SELECT * FROM user WHERE user_type = 7");

            		foreach ($tokenTL->result() as $rows) {
                        $pesan = "No Tiket : $tiket\nPelapor :$job_detail ($nama_unit) \nBlok : $blok, Unit : $no_unit";
                        $topic = "7";
                        $fcmtoken = $rows->token_ntf;
                        $this->sendFCM($topic, $pesan, $fcmtoken);
                    }
           
            		$last_id = $this->db->insert_id();

					if ($this->db->affected_rows($add) > 0) {

						$data = array(
							'id_task' => $last_id,
							'user_id' => $loggedinuser->username,
							'log_status' => 1,
							'keterangan' => "Add task : $job_detail",
							'create_date' => date("Y-m-d H:i:s")
						);
		
						$tambah = $this->tickets_model->tambahComment($data);
		
						//$this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Success </div>');	
						$this->session->set_flashdata('success', 'Tambah' . ' data ticket berhasil');
						//redirect('Helpdesk/Update?id= ' . encrypt_url($last_id) . '');

						redirect('ticket/add', 'refresh');

					} else {

						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

						//redirect('ticket/ticket_update?id= ' . encrypt_url($last_id) . '');
						redirect('ticket/add', 'refresh');
		
					}

				}
				// validation Failed
				else {

					$this->data['data_list_area'] = $this->tickets_model->get_area();
					$this->data['data_list_service_family'] = $this->tickets_model->getServiceFamily();
					$this->data['open_form'] = "open";

					// set the flash data error message if there is one
					$this->data['error'] = (validation_errors()) ? validation_errors() :

					// Set message
					$this->session->set_flashdata('error',
						$this->config->item('error_start_delimiter', 'ion_auth')
						."Validation Errors!".
						$this->config->item('error_end_delimiter', 'ion_auth')
					);

					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('ticket/add', $this->data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('ticket/js');
					$this->load->view('js_script');

				}

			}
			else {

				$this->data['data_list_area'] = $this->tickets_model->get_area();
				$this->data['data_list_service_family'] = $this->tickets_model->getServiceFamily();
				$this->data['open_form'] = "open";

				// set the flash data error message if there is one
				//$this->data['message'] = (validation_errors()) ? validation_errors() :
				//$this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('ticket/add', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('ticket/js');

				// ada library datepicker, wyswyg
				$this->load->view('js_script');

			}

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
	public function edit()
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/ticket', 'refresh');
		}
		// Logged in
		else {

			$i = $this->uri->segment(3);
			$dec = decrypt_url($i);

			$this->data['data_list_area'] = $this->tickets_model->get_area();
			$this->data['data_list_service_family'] = $this->tickets_model->getServiceFamily();
			$this->data['list_ticket'] = $this->tickets_model->get_ticket_by_id($dec);

			$this->data['open_form'] = "open";
			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('ticket/edit', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('ticket/js');

			// ada library datepicker, wyswyg
			$this->load->view('js_script');

		}
		
	}
	// Edit data end

	public function save_edit(){

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/ticket', 'refresh');
		}
		// Logged in
		else {

			$this->form_validation->set_rules('pelapor', 'Pelapor', 'required');
			$this->form_validation->set_message('required', '{field} Harus Di Isi');

			$this->form_validation->set_rules('job_detail', 'Laporan Problem', 'required');
			$this->form_validation->set_message('required', '{field} Harus Di Isi');

			// input validation rules 
			$this->form_validation->set_rules('id_lok', 'Area', 'callback__area_id_check');
			$this->form_validation->set_rules('id_unit', 'Unit', 'callback__unit_id_check');

			$this->form_validation->set_rules('service_family_id', 'Service Family', 'callback__service_family_id_check');
			$this->form_validation->set_rules('type_incident', 'Type Incident', 'callback__type_incident_id_check');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				$id_ticket = $this->input->post('id_ticket');
				$dec = decrypt_url($id_ticket);

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$data_task = array(
						'id_area' => $this->input->post('id_lok'),
						'id_unit' => $this->input->post('id_unit'),
						'type' => 'high',
						'job_detail' => strip_tags($this->input->post('job_detail')),
						'pelapor' => strip_tags($this->input->post('pelapor')),
						'note' => $this->input->post('note'),

						'pic' => $this->input->post('hidden_username1'),
						'pic1' => $this->input->post('hidden_username2'),
						'petugas1_id' => $this->input->post('petugas1'),
						'petugas2_id' => $this->input->post('petugas2'),

						'service_family_id' => $this->input->post('service_family_id'),
						'type_problem' => $this->input->post('type_incident'),
					);

					// check to see if we are inserting the data
					if ($this->tickets_model->update_data($dec, $data_task)) {

						// Set message
						/*
						$this->session->set_flashdata('success',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Data Saved!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
						*/

						$this->session->set_flashdata('success', 'Ubah' . ' data ticket berhasil');
						redirect('ticket/edit/'.encrypt_url($dec), 'refresh');

					}
					else {

						// Set message
						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

						redirect('ticket/edit/'.encrypt_url($dec), 'refresh');

					}

				}
				// validation Failed
				else {

					$this->data['data_list_area'] = $this->tickets_model->get_area();
					$this->data['data_list_service_family'] = $this->tickets_model->getServiceFamily();
					$this->data['list_ticket'] = $this->tickets_model->get_ticket_by_id($dec);

					$this->data['open_form'] = "open";
					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('ticket/edit', $this->data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('ticket/js');

					// ada library datepicker, wyswyg
					$this->load->view('js_script');

				}

			}
			else {

				$this->data['data_list_area'] = $this->tickets_model->get_area();
				$this->data['data_list_service_family'] = $this->tickets_model->getServiceFamily();
				$this->data['list_ticket'] = $this->tickets_model->get_ticket_by_id($dec);

				$this->data['open_form'] = "open";
				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('ticket/edit', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('ticket/js');

				// ada library datepicker, wyswyg
				$this->load->view('js_script');

			}

		}

	}

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to unit
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

	function load_dropdown_nama_unit()
	{
		
		$id_lok = $this->input->post('id_lok', true);

		if ($this->units_model->get_nama_unit($id_lok)->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->units_model->get_nama_unit($id_lok)->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['nama_unit'] = $qryget['nama_unit'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function datatables_ticket()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
       
		/* DB table to use */
		$sTable = "schedule_job";
     
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
		
		//$aColumns = array('id_lok', 'nama_unit', 'blok', 'no_unit', 'alamat_lengkap');
		$aColumns = array('tiket', 'pelapor', 'job_detail');
  
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
		//$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                  
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

		$type_incident_id = (isset($_GET['type_incident_id']))?($_GET['type_incident_id']):'0';
		$type_incident_id = ($type_incident_id == '') ? '0' : $type_incident_id;

		$params = array();
		$params['id_lok'] = $id_lok;
		$params['id_unit'] = $id_unit;
		$params['id_status'] = $id_status;
		$params['type_incident_id'] = $type_incident_id;
		
		$rResult = $this->tickets_model->getListTicket($aColumns, $sWhere, $sOrder, $top, $limit, $params);
       
		$iTotal = 0;
        $rResultTotal = $this->tickets_model->getListTicketTotal($sIndexColumn, $params);
        $iTotal = $rResultTotal->row()->total_jml_data;
	   
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->tickets_model->getListTicketFilteredTotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params);
		$iFilteredTotal = $rResultTotalFiltered->row()->total_jml_data;
		
		$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
		$output = array(
			"sEcho" => $sEcho,
			//"draw" => intval($draw),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"id_lok" => $id_lok,
			"id_unit" => $id_unit,
			"id_status" => $id_status,
			"type_incident_id" => $type_incident_id,
			"aaData" => array()
		);	

		//date_default_timezone_set('Asia/Jakarta');
		
		$numbering = $top;
		$page = 1;
		$tombol_reset = '';

		/**
		 * <a  href="javascript:;" data-id ="' . encrypt_url($aRow->id) . '" data-job_detail ="' . $aRow->job_detail . '" data-note ="' . $aRow->note . '" data-name_pic1 ="' . $aRow->name_pic1 . '"
            	data-pic1 ="' . $aRow->pic . '" data-name_pic2 ="' . $aRow->name_pic2 . '" data-pic2 ="' . $aRow->pic1 . '" data-type ="' . $aRow->type . '" data-id_area ="' . $aRow->id_area . '"
                data-id_unit ="' . $aRow->id_unit . '" data-type_problem ="' . $aRow->type_problem . '"
                data-id_arean ="' . $aRow->nama_unit . '" data-id_unitn ="' . $aRow->nama_unit . '" data-typen ="' . $aRow->type_name . '"
                data-toggle="modal" data-target="#update" data-rel="tooltip" title="Edit" ><i style="color:#000060;margin:10px;"  class="fa fa-pencil" ></i></a>
		 */

		foreach ($rResult->result() as $aRow) 
		{
			
			$numbering++;
			$row = array();		

			if ($aRow->status == 1) {
                $label_status = "label label-warning";
            } else if ($aRow->status == 2) {
                $label_status = "label label-info";
            } else if ($aRow->status == 3) {
                $label_status = "label label-success";
            } else if ($aRow->status == 4) {
                $label_status = "label label-danger";
            } else if ($aRow->status == 5) {
                $label_status = "label label-success";
            } else if ($aRow->status == 6) {
                $label_status = "label label-danger";
            } else {
                $label_status = "";
            }
			
			$status = '<span class="' . $label_status . '">' . $aRow->desc_status . '</span>' . '<br>' . $aRow->tiket;

			// report

			$jumlahkarakter = 50;
            $cetak = strip_tags(trim(substr($aRow->job_detail, 0, $jumlahkarakter)));

			$task_name = '<div class="small">
			Unit   	  : ' . $aRow->nama_unit . ' <br>
			Blok / No : ' . $aRow->blok . ' ' . $aRow->no_unit . '<br>
			Keluhan   : ' . $cetak . '<br>
			Petugas 1 : ' . $aRow->name_pic1 . '<br>
			Petugas 2 : ' . $aRow->name_pic2 . '<br>
		
				<i class="fa fa-clock-o"></i> Created ' . $aRow->create_date . '
				</div>';

			$value_progres = '<div class="progress m-b-none full progress-small">
                            <div style="width: ' . $aRow->value_progres . '%" class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <small>' . $aRow->value_progres . '% compleated:</small>';

			// hitung durasi

			$open = strtotime(date($aRow->create_date));

            if (empty($aRow->finish_date) || $aRow->finish_date == 0) {
                $finish = strtotime(date("Y-m-d H:i:s"));
            } else {
                $finish = strtotime(date($aRow->finish_date));
            }

            $diff = $finish - $open;
            $jam   = floor($diff / 3600);
            $menit = floor(($diff - ($jam * 3600)) / 60);
            $hari =  floor($jam / 24);
            $jam1 =  floor(($jam - ($hari * 24)));
            $nilai = "$hari hari,$jam1 jam,$menit menit ";

			$tiket = ' <i class="fa fa-clock-o"></i> Durasi : <br> <small>' . $nilai . '</small>';

			if ($aRow->status != 5 &&  $aRow->status != 6) {

                $edit = '<a href="javascript:;" data-id ="' . encrypt_url($aRow->id) . '" data-toggle="modal" data-target="#cancel" data-rel="tooltip" title="Cancel" ><i class="fa fa-times" style="color:red; margin:10px;"></i></a>
				<i class="ui-tooltip fa fa-pencil-square-o" title="Edit Data" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Edit Data" onclick="edit('. "'" . encrypt_url($aRow->id) . "'" . ')"></i>';
            
			} else {
                $edit = '';
            }

			$encrypt_id_ticket = encrypt_url($aRow->id);

			$row[] = $numbering; 
			$row[] = $aRow->service_family_name;
			$row[] = $aRow->type_name;
			$row[] = $status;
			$row[] = $task_name;
			$row[] = $aRow->pelapor;
			$row[] = $tiket;
			$row[] = $value_progres;
			$row[] = '<div style="float:right;"><a href="' . site_url() . 'ticket/ticket_update?id=' . $encrypt_id_ticket . '"><i class="fa fa-eye" style="color:#000060;margin:10px;"> </i></a><a href="' . '#' . '"><i class="fa fa-print" style="color:#000060;margin:10px;"></i></a>' . $edit . '</div>';

			$page++;
			$output['aaData'][] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 
    
		echo json_encode($output);
		
	}

	function load_dropdown_petugas1()
	{
		
		$list_data = $this->tickets_model->load_dropdown_petugas();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['first_name'] = $qryget['first_name'];
			$row['last_name'] = $qryget['last_name'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function load_dropdown_petugas2()
	{
		
		$list_data = $this->tickets_model->load_dropdown_petugas();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['first_name'] = $qryget['first_name'];
			$row['last_name'] = $qryget['last_name'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function load_dropdown_type_incident()
	{
		
		$service_family_id = $this->input->get('service_family_id');

		if ($this->tickets_model->load_dropdown_type_incident($service_family_id)->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->tickets_model->load_dropdown_type_incident($service_family_id)->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['type'] = $qryget['type'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function load_dropdown_kondisi()
	{
		
		$list_data = $this->units_model->load_dropdown_kondisi();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['kondisi'] = $qryget['kondisi'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function load_dropdown_klasifikasi()
	{
		
		$list_data = $this->tickets_model->load_dropdown_klasifikasi();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['klasifikasi'] = $qryget['klasifikasi'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function getDataPenghuni()
	{
		
		$penghuni_id = $this->uri->segment(3);
		$list = $this->units_model->getDataPenghuni($penghuni_id);
		$ddata = array();

		foreach ($list as $list_data) 
		{

			$row = array();
			$row['kode'] = $list_data->kode;
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
        );
		
		//output to json format
		echo json_encode($output);
		
	}

	public function _area_id_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_area_id_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	public function _unit_id_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_unit_id_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	public function _klasifikasi_id_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_klasifikasi_id_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	public function _kondisi_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_kondisi_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	public function _type_incident_id_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_type_incident_id_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	public function _service_family_id_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_service_family_id_check', '%s Harus Di Isi');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	function hapus_data()
	{

		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/unit', 'refresh');
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

			$is_success = $this->units_model->hapus_data($id);
			//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data user Dengan ID '.$id.' Berhasil Dihapus.</div>');

			if ($is_success){

				// delete old Photo
				if ($photo != "") {
					unlink("assets/uploads/images/unit/".$photo);
					unlink("assets/uploads/images/unit/".$thumbnail);
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

	public function detail_penghuni($kode = '', $id_unit = '', $id_lok = '')
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/unit', 'refresh');
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
				
				$this->data['title']="Master Data";
				$this->data['subtitle']=" Master Data / Penghuni";
				
				$this->data['tabletitle'] = '<small class="label label-info">' . 'Unit : ' . '-' . '</small>&nbsp;' .
				'<small class="label label-warning">' . 'Blok : ' . '-' . '</small>&nbsp;' . '<small class="label label-success">' . 'No. Unit : ' . '-' . '</small>';

				$this->data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Master Data</a></li>
										<li class=\"active\">Penghuni</li>";

				$this->data['data_detail'] = $this->penghunis_model->get_penghuni_by_kode($kode);

				if (count($this->penghunis_model->get_penghuni_by_kode($kode)->result()) == 0){
					// if data kosong
					$goTo = site_url().'unit';
					echo $this->fungsi->warning('Data yang Anda cari tidak tersedia !!', $goTo);
				}

				$this->data['kode'] = $kode;
				$this->data['id_lok'] = $id_lok;
				$this->data['id_unit'] = $id_unit;

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_unit/detail_penghuni', $this->data);
				$this->load->view('partials/_alte_footer');

				$this->load->view('inv_unit/js');

			}
			else {

				// inventory by category summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_area_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_unit/by_area_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_unit/js');
				$this->load->view('js_script');

			}

		}
	}

	public function detail($id_unit)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/unit/detail/'.$id_unit, 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($id_unit!="") {
				// Show detailed data based on code
				$this->data['data_detail'] = $this->units_model->get_unit_by_id_unit(
					$id_unit
				);
				// Show logs
				$this->data['location_logs'] = $this->logs_model->get_location_log_by_code(
					$id_unit
				);
				$this->data['status_logs'] = $this->logs_model->get_status_log_by_code(
					$id_unit
				);

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_unit/detail');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_unit/js');
				// $this->load->view('js_script');
			}
		}
	}

	public function sendFCM($topic, $pesan, $fcmtoken)
    {
     
        $url = 'https://fcm.googleapis.com/fcm/send';
        $apiKey = 'AAAArGsoU8Q:APA91bF9Poi14PZNaLH28V2_TgC0xvxZk7Sf9eVTVoawZ40BRku2f9gBbWKFSMsdr4LvJboPWEeyJF8EEQ85UfKOyiol4LQtilodrYZhFa5yLNYyRCFgS0I-xJpk-4sDw7N7kWph8wKo';
        $headers = array(
            'Authorization:key=' . $apiKey,
            'Content-Type:application/json'
        );

        $notifData = [
            'title' => "Notifikasi Insiden",
            'body' => $pesan,
            // 'image' => 'IMAGE - URL',
            // 'click_action' => 'activities.notifhandler'

        ];

        $dataPayLoad = [
            'to' => $topic,
            'date' => date('l, d-m-Y'),
            'other_data' => $pesan,
            'fcmToken' => $fcmtoken,
        ];

        $notifBody = [
            'notification' => $notifData,
            'data' => $dataPayLoad,
            'time_to_live' => 3600,
            // 'to' => '740532179908',
            'to' => $fcmtoken
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notifBody));
        $result = curl_exec($ch);
        print($result);
        curl_close($ch);
    }

    public function getUsersTableById($id)
    {
        $data = $this->tickets_model->getUsersTableById($id);
        echo json_encode($data);
    }

	function load_dropdown_status()
	{
		
		$list_data = $this->tickets_model->get_status_ticket();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['desc_status'] = $qryget['desc_status'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	public function ticket_update()
    {

        $i = htmlspecialchars($this->input->get('id', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('welcome');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('welcome');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('auth/login/ticket/ticket_update/'.$dec, 'refresh');
			}
			// Logged in
			else{

				$this->$data['data'] = $this->tickets_model->getDetailTicket($dec)->row();
				$this->$data['doc'] = $this->tickets_model->getDocument($dec);
				$this->$data['biaya'] = $this->tickets_model->getBiaya($dec);
				$this->$data['log'] = $this->tickets_model->getLogTicket($dec);

				/*
				echo "<pre>";
				print_r($data['schedule_job']);
				echo "</pre>";
				*/
					
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('ticket/detail', $this->$data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('ticket/js');
				// $this->load->view('js_script');

			}

        }

    }

	public function new_comment()
    {

        $i = htmlspecialchars($this->input->post('id_comment', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				//redirect('auth/login/ticket/new_comment/'.$dec, 'refresh');
				redirect('ticket/ticket_update?id= ' . $i . '');
			}
			// Logged in
			else{

				$loggedinuser = $this->ion_auth->user()->row();

				$data = array(
                    'id_task' => $dec,
                    'user_id' => $loggedinuser->username,
                    'log_status' => 5,
                    'keterangan' => ucfirst(trim(htmlspecialchars($this->input->post('task_comment', true)))),
                    'create_date' => date("Y-m-d H:i:s")
                );

                $tambah = $this->tickets_model->tambahComment($data);

				if ($tambah) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Add Comment Success</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Add Comment Failed</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }

			}

		}
        
    }

	public function document()
    {

        $i = htmlspecialchars($this->input->post('id_file', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} 
			// Logged in
			else {	

				$loggedinuser = $this->ion_auth->user()->row();

				$path = "doc/incident/";

                if (!is_dir($path)) //create the folder if it's not exists
                {
                    mkdir($path, 0755, TRUE);
                }

                $dok_desc = ucfirst(trim(htmlspecialchars($this->input->post('dok_desc', true))));
                $kd = date('YmdHis');
                $old_name = $_FILES["file"]["name"];
                $file_ext = pathinfo($old_name, PATHINFO_EXTENSION);
                $fileName = "Pengelola-$kd.$file_ext";

                if (!empty($_FILES["file"]["name"])) {

                    $config['upload_path']          = $path;
                    $config['allowed_types']        = '*';
                    $config['file_name']            = $fileName;
                    $config['max_size']             = 1000;
                    $config['overwrite']            = true;
                    $config['remove_space'] = TRUE;

                    $this->load->library('upload', $config);
                    $up = $this->upload->do_upload('file');
                    $time = date("Y-m-d H:i:s");

                    $data = array(
                        'id_task' => $dec,
                        'user_id' => $loggedinuser->username,
                        'log_status' => 8,
                        'keterangan' => "Upload file: $dok_desc",
                        'create_date' => $time
                    );

                    $data_foto = [
                        'incident_id' => $dec,
                        'foto' => $fileName,
                        'deskripsi' => 'pengelola ' . $dok_desc . '',
                        'user_create' => $loggedinuser->username,
                        'create_date' => date("Y-m-d H:i:s"),
                        'lat' => '',
                        'lon' => ''
                    ];

                    if ($up) {
                        $update =  $this->db->insert('incident_foto', $data_foto);
                        $tambah =  $this->db->insert('log_task', $data);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil</div>');
                        redirect('ticket/ticket_update?id= ' . $i . '');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal </div>');
                        redirect('ticket/ticket_update?id= ' . $i . '');
                    }
					
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal tambah foto </div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }

			}

		}

	}
	
	function delete_file()
    {

        $i = htmlspecialchars($this->input->post('id_delete', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} 
			// Logged in
			else {		

				$loggedinuser = $this->ion_auth->user()->row();

				$id = htmlspecialchars($this->input->post('id_file_delete', true));
				$name = htmlspecialchars($this->input->post('name_file_delete', true));
				$dok_desc = htmlspecialchars($this->input->post('desc_file_delete', true));
				
				//$user_id = $this->session->userdata('user_id');
				//$divisi = $this->session->userdata('divisi_id');
		
				$hapus = $this->tickets_model->deleteFile($id);
		
				if ($hapus) {

					unlink("doc/incident/" . $name);
					$time = date("Y-m-d H:i:s");
				
					$data = array(
						'id_task' => $dec,
						'user_id' => $loggedinuser->username,
						'log_status' => 8,
						'keterangan' => "Delete file: $dok_desc",
						'create_date' => $time
					);

					$input = $this->db->insert('log_task', $data);

					if ($input) {
						$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil hapus data</div>');
						redirect('ticket/ticket_update?id= ' . $i . '');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal hapus data</div>');
						redirect('ticket/ticket_update?id= ' . $i . '');
					}

				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal hapus data </div>');
					redirect('ticket/ticket_update?id= ' . $i . '');
				}

			}         

        }
    }

	public function approve()
    {

        $i = htmlspecialchars($this->input->post('id_approve', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} else {

				$loggedinuser = $this->ion_auth->user()->row();	

				$time = date("Y-m-d H:i:s");
                $data = array(
                    'id_task' => $dec,
                    'user_id' => $loggedinuser->username,
                    'log_status' => 9,
                    'keterangan' => "Approve ticket",
                    'create_date' => $time
                );

				// check if user is a manager
                if ($this->ion_auth->in_group('manager', $loggedinuser->id)) {
                    $update = $this->tickets_model->approve($dec, $loggedinuser->username);

                    if ($update) {
                        $tambah = $this->tickets_model->tambahComment($data);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Approval Berhasil</div>');
                        redirect('ticket/ticket_update?id= ' . $i . '');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Approval Gagal</div>');
                        redirect('ticket/ticket_update?id= ' . $i . '');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User level tidak cukup untuk melakukan approve</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }
				
			}
            
        }

    }

	public function progres()
    {
        $i = htmlspecialchars($this->input->post('id_update', true));
        $dec = decrypt_url($i);
        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }
        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {
			
			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} else {
				
				$loggedinuser = $this->ion_auth->user()->row();

				$value_progres = ucfirst(trim(htmlspecialchars($this->input->post('value_progres', true))));
                $task_progres = ucfirst(trim(htmlspecialchars($this->input->post('task_progres', true))));
                $time = date("Y-m-d H:i:s");

                $data = array(
                    'id_task' => $dec,
                    'user_id' => $loggedinuser->username,
                    'log_status' => 3,
                    'keterangan' => "Update task : $task_progres",
                    'create_date' => $time
                );

                $update = $this->tickets_model->update_progress_ticket($dec, $value_progres, $task_progres);
                
				if ($update) {
                    $tambah = $this->tickets_model->tambahComment($data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Progress Ticket Berhasil</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update Progress Ticket Gagal</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }

			}

        }
    }

	public function complete()
    {
        $res = ucfirst(trim(htmlspecialchars($this->input->post('task_result', true))));
        $sol = ucfirst(trim(htmlspecialchars($this->input->post('task_solusi', true))));
        $i = htmlspecialchars($this->input->post('id_complete', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} else {
				
				$loggedinuser = $this->ion_auth->user()->row();

				$time = date("Y-m-d H:i:s");

                $data = array(
                    'id_task' => $dec,
                    'user_id' => $loggedinuser->username,
                    'log_status' => 5,
                    'keterangan' => "Completed task : $res",
                    'create_date' => $time
                );

                $update = $this->tickets_model->complete($dec, $res, $time, $sol);

                if ($update) {
                    $tambah = $this->tickets_model->tambahComment($data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update progress ticket complete berhasil</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update progress ticket complete gagal</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }
			
			}
			
        }
    }

	public function cancel()
    {
        $res = ucfirst(trim(htmlspecialchars($this->input->post('task_cancel', true))));
        $i = htmlspecialchars($this->input->post('id_cancel', true));
        $dec = decrypt_url($i);

		/*
		echo '<pre>';
		print_r($dec);
		echo '</pre>';
		exit;
		*/

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }
        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {
			
			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} else {
				
				$loggedinuser = $this->ion_auth->user()->row();

				$time = date("Y-m-d H:i:s");

                $data = array(
                    'id_task' => $dec,
                    'user_id' => $loggedinuser->username,
                    'log_status' => 6,
                    'keterangan' => "Cancel task : $res",
                    'create_date' => $time
                );

				/*
				echo '<pre>';
				print_r($data);
				echo '</pre>';
				exit;
				*/

				$update = $this->tickets_model->cancel($dec, $time, $res);

                if ($update) {
                    $tambah = $this->tickets_model->tambahComment($data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update progress ticket cancel berhasil</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update progress ticket cancel gagal</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }

			}
            
        }
    }

	public function surat_tugas()
    {
        date_default_timezone_set("Asia/Bangkok");
        $a1 = htmlspecialchars($this->input->get('id', true));
        //$nopol = htmlspecialchars($this->input->get('nopol', true));

        if (empty($a1)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Membuat Surat Tugas</div>');
            redirect('ticket');
        }

        $id = decrypt_url($a1);

        if ($id == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Membuat Surat Tugas</div>');
            redirect('ticket');
        }

        $this->db->select("A.*,B.username as name_pic,B.jabatan,B1.username as name_pic1, C.blok,C.no_unit,nama_unit,F.nama_lokasi");
        $this->db->from('schedule_job as A');
        $this->db->join('user as B', 'B.user_id = A.pic ', 'LEFT');
        $this->db->join('user as B1', 'B1.user_id = A.pic1 ', 'LEFT');
        $this->db->join('unit as C', 'C.id = A.id_unit ', 'LEFT');
        $this->db->join('lokasi_kerja as F', 'F.id = A.id_area ', 'LEFT');
        $this->db->where('A.id', $id);
        $this->db->limit(1);
        
		$surat_tugas = $this->db->get()->result();
        $data['detail'] = $surat_tugas;

        $this->load->library('pdf');
        $path = 'images/logo/Logo_biru11.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dt = file_get_contents($path);
        $data['img'] = 'data:image/' . $type . ';base64,' . base64_encode($dt);
        //$data['hari'] =$this->hari();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Surat Tugas.pdf";
        $this->pdf->load_view('ticket/surat_tugas', $data);
        // $this->load->view('Report/surat_tugas',$data);
    }

	public function new_biaya()
    {

        $i = htmlspecialchars($this->input->post('id_biaya', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }

        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()){
				redirect('ticket/ticket_update?id= ' . $i . '');
			} else {
				
				$loggedinuser = $this->ion_auth->user()->row();
				$user_id = $loggedinuser->username;

                $qty = $this->input->post('qty_biaya', true);
                $biaya = $this->input->post('biaya', true);
                $subtotal = $qty * $biaya;

                $data = array(
                    'incident_id' => $dec,
                    'desk' => ucfirst(trim(htmlspecialchars($this->input->post('desk_biaya', true)))),
                    'qty' => trim(htmlspecialchars($this->input->post('qty_biaya', true))),
                    'biaya' => trim(htmlspecialchars($this->input->post('biaya', true))),
                    'user_create' => $user_id,
                    'create_date' => date("Y-m-d H:i:s")
                );

                $this->db->trans_start(); # Starting Transaction
                $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

                // insert table detail
                $this->db->insert('biaya_perbaikan', $data);

                /* update kolom total biaya perbaikan */

                $this->db->set('total_biaya_perbaikan', 'total_biaya_perbaikan+'.$subtotal, FALSE);
                $this->db->where('id', $dec);
                $this->db->update('schedule_job');

                $this->db->trans_complete(); # Completing transaction

                /*Optional*/

                if ($this->db->trans_status() === FALSE) {

                    # Something went wrong.    			

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal </div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');

                    $this->db->trans_rollback();
                    return FALSE;
                } else {
                    # Everything is Perfect. 
                    # Committing data to the database.

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');

                    $this->db->trans_commit();
                    return TRUE;
                }

			}
              
        }
    }

	public function delete_biaya()
    {

        $i = htmlspecialchars($this->input->post('id_delete_biaya', true));
        $dec = decrypt_url($i);

        if (empty($i)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        }
        if ($dec == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
            redirect('ticket');
        } else {

			// Not logged in, redirect to home
			if (!$this->ion_auth->logged_in()) {
				redirect('ticket/ticket_update?id= ' . $i . '');
			} else {

				$loggedinuser = $this->ion_auth->user()->row();
				$user_id = $loggedinuser->username;

                $id = htmlspecialchars($this->input->post('id_biaya_delete', true));

				/* get subtotal biaya yang akan di delete */

				$query = $this->db->query("SELECT qty * biaya as subtotal FROM biaya_perbaikan WHERE id = $id");
				$row = $query->row();
				$subtotal = $row->subtotal;

				//echo $subtotal;
				//exit;

				//echo $dec;
				//exit;

				$ssql = "update schedule_job set total_biaya_perbaikan = total_biaya_perbaikan - $subtotal where id = $dec";
				$this->db->query($ssql);

				echo $this->db->last_query();


				// delete item

				$this->db->where('id', $id);
                $this->db->delete('biaya_perbaikan');

                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal</div>');
                    redirect('ticket/ticket_update?id= ' . $i . '');
                }

			}

        }
    }

}

/* End of Ticket.php */