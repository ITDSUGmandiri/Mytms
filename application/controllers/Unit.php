<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Unit Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Unit extends CI_Controller {

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
			redirect('auth/login/unit', 'refresh');
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
				
			$this->data['title']="Unit";	
			$this->data['subtitle']=" Master Data / Unit";
				
			$data['tabletitle'] = "List Master Data Unit";

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i>&nbsp;Master Data</a></li>
									<li class=\"active\">Unit</li>";

			//$this->data['data_list'] = $this->inventory_model->get_unit_by_id_lok($id_lok);

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_unit/list_data_unit', $this->data);
			$this->load->view('partials/_alte_footer');

			$this->load->view('inv_unit/js');

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
			redirect('auth/login/unit', 'refresh');
		}
		// Logged in
		else {

			// input validation rules
			$this->form_validation->set_rules('id_lok', 'Area', 'callback__area_id_check');
			
			$this->form_validation->set_rules('nama_unit', 'Nama Unit', 'trim|required');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('blok', 'Blok', 'trim|required');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('no_unit', 'No. Unit', 'trim|required');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('lantai', 'Lantai', 'trim|numeric|required');
			$this->form_validation->set_message('numeric', '%s Harus diisi angka');
			$this->form_validation->set_message('required', '%s Harus diisi');

			// status unit belum di set set_value nya
			$this->form_validation->set_rules('status_unit', 'Status Unit', 'callback__status_unit_check');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('penghuni_id', 'Penghuni', 'trim');

			$this->form_validation->set_rules('dok', 'No. SPRD', 'trim');
			$this->form_validation->set_rules('tgl_sprd', 'Tanggal SPRD', 'trim|addslashes');
			$this->form_validation->set_rules('no_bast', 'No. BAST Masuk', 'trim|addslashes');
			$this->form_validation->set_rules('tgl_bast', 'Tanggal BAST Masuk', 'trim|addslashes');
			
			// wilayah belum di set set_value nya
			$this->form_validation->set_rules('wilayah', 'Wilayah', 'trim|addslashes');

			// kondisi belum di set set_value nya
			$this->form_validation->set_rules('kondisi', 'Kondisi Rumah Dinas', 'callback__kondisi_check');

			$this->form_validation->set_rules('masuk', 'Tanggal Masuk', 'trim|addslashes');
			$this->form_validation->set_rules('keluar', 'Tanggal Keluar', 'trim|addslashes');
			$this->form_validation->set_rules('tgl_perbaikan', 'Tanggal Perbaikan', 'trim|addslashes');

			$this->form_validation->set_rules('nominal_rab', 'Nominal RAB', 'trim');
			$this->form_validation->set_rules('nominal_spk', 'Nominal SPK', 'trim');
			$this->form_validation->set_rules('kontraktor', 'Kontraktor', 'trim|addslashes');

			$this->form_validation->set_rules('id_listrik', 'ID Listrik', 'trim|addslashes');
			$this->form_validation->set_rules('id_pam', 'ID PAM', 'trim|addslashes');
			$this->form_validation->set_rules('id_telp', 'ID Telp', 'trim|addslashes');

			$this->form_validation->set_rules('id_internet1', 'ID Internet 1', 'trim|addslashes');
			$this->form_validation->set_rules('id_internet2', 'ID Internet 2', 'trim|addslashes');
			$this->form_validation->set_rules('id_internet3', 'ID Internet 3', 'trim|addslashes');
			$this->form_validation->set_rules('id_internet4', 'ID Internet 4', 'trim|addslashes');
			$this->form_validation->set_rules('daya_listrik', 'Daya Listrik', 'trim|addslashes');

			$this->form_validation->set_rules('hak_menempati', 'Hak Menempati', 'callback__hak_menempati_check');
			$this->form_validation->set_rules('klasifikasi_id', 'Klasifikasi', 'callback__klasifikasi_id_check');

			$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|addslashes');
			$this->form_validation->set_rules('alamat_lengkap', 'Alamat Lengkap', 'trim|addslashes');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$loggedinuser = $this->ion_auth->user()->row();

					$tiket = $this->counter_model->getcodeunit();

					$nominal_rab = str_replace(".","",$this->input->post('nominal_rab'));
					$nominal_spk = str_replace(".","",$this->input->post('nominal_spk'));

					// aset data array
					$data = array(
						'kode'       	=> $tiket,
						'id_lok'       	=> $this->input->post('id_lok'),
						'nama_unit'		=> $this->input->post('nama_unit'),
						'blok'			=> $this->input->post('blok'),
						'no_unit'		=> $this->input->post('no_unit'),
						'lantai'		=> $this->input->post('lantai'),
						'status'		=> $this->input->post('status_unit'),
						'penghuni_id'	=> $this->input->post('penghuni_id'),
						'penghuni'		=> $this->input->post('penghuni'),
						'dok'			=> $this->input->post('dok'),
						'tgl_dok'      	=> $this->fungsi->date2mysql($this->input->post('tgl_sprd')),
						'no_bast'		=> $this->input->post('no_bast'),
						'tgl_bast'		=> $this->fungsi->date2mysql($this->input->post('tgl_bast')),
						'wilayah'   	=> $this->input->post('wilayah'),
						'kondisi'       => $this->input->post('kondisi'),
						'masuk'         => $this->fungsi->date2mysql($this->input->post('masuk')),
						'keluar'        => $this->fungsi->date2mysql($this->input->post('keluar')),
						'tgl_perbaikan' => $this->fungsi->date2mysql($this->input->post('tgl_perbaikan')),
						'nominal_rab'   => $nominal_rab,
						'nominal_spk'   => $nominal_spk,
						'kontraktor'	=> $this->input->post('kontraktor'),
						'id_listrik'    => $this->input->post('id_listrik'),
						'id_pam'    	=> $this->input->post('id_pam'),
						'id_telp'    	=> $this->input->post('id_telp'),
						'id_internet1'  => $this->input->post('id_internet1'),
						'id_internet2'  => $this->input->post('id_internet2'),
						'id_internet3'  => $this->input->post('id_internet3'),
						'id_internet4'  => $this->input->post('id_internet4'),
						'daya_listrik'  => $this->input->post('daya_listrik'),
						'hak_menempati' => $this->input->post('hak_menempati'),
						'klasifikasi_id'=> $this->input->post('klasifikasi_id'),
						'klasifikasi'  	=> $this->input->post('klasifikasi'),
						'keterangan'  	=> $this->input->post('keterangan'),
						'alamat_lengkap'=> $this->input->post('alamat_lengkap'),
						'user_id' 		=> $loggedinuser->id,
						'user_create' 	=> $loggedinuser->username,
						'create_date' 	=> date('Y-m-d H:i:s'),
						'status_unit' 	=> 1,
						'type' => 0
					);

					// check to see if we are inserting the data
					if ($this->units_model->insert_data($data)) {

						$id_auto = $this->db->insert_id();

						// logging array

						$log = array(
							'id_task' => $id_auto,
							'user_id' => $loggedinuser->username,
							'log_status' => 1,
							'keterangan' => 'tambah unit',
							'create_date' => date('Y-m-d H:i:s')
						);

						// Insert logs
						$this->logs_model->add_log($log);

						// Set message
						$this->session->set_flashdata('success', 'Tambah' . ' data unit berhasil');
						//$this->session->set_flashdata('success',$this->config->item('message_start_delimiter', 'ion_auth')."Data Saved Successfully!".$this->config->item('message_end_delimiter', 'ion_auth'));

						// upload and change unit photo
						$link_foto      = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/unit/';
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
								$config['source_image']   = "assets/uploads/images/unit/".$upload_data['file_name'];
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
								$this->units_model->update_aset_by_code($id_auto, $datas);

							}
						}

						$this->session->set_flashdata('success', 'Tambah' . ' data unit berhasil');
						redirect('unit/add', 'refresh');

					}
					else {

						// Set message
						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

						redirect('unit/add', 'refresh');

					}

				}
				// validation Failed
				else {

					//$this->data['data_list'] = $this->fasilitas_model->get_fasilitas();
					$this->data['data_list_area'] = $this->fasilitas_model->get_area();
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
					$this->load->view('inv_unit/add', $this->data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_unit/js');
					$this->load->view('js_script');

				}

			}
			else {

				//$this->data['data_list'] = $this->fasilitas_model->get_fasilitas();
				$this->data['data_list_area'] = $this->fasilitas_model->get_area();
				$this->data['open_form'] = "open";

				// set the flash data error message if there is one
				//$this->data['message'] = (validation_errors()) ? validation_errors() :
				//$this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_unit/add', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_unit/js');

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
	public function edit($id)
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/unit', 'refresh');
		}
		// Logged in
		else {

			$this->data['data_list_area'] = $this->fasilitas_model->get_area();
			$this->data['list_unit'] = $this->units_model->get_unit_by_id_unit($id);

			$this->data['open_form'] = "open";
			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_unit/edit', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_unit/js');

			// ada library datepicker, wyswyg
			$this->load->view('js_script');

		}
		
	}
	// Edit data end

	public function save_edit(){

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/unit', 'refresh');
		}
		// Logged in
		else {

			// input validation rules
			//$this->form_validation->set_rules('id_lok', 'Area', 'callback__area_id_check');
			
			//$this->form_validation->set_rules('nama_unit', 'Nama Unit', 'trim|required');
			//$this->form_validation->set_message('required', '%s Harus diisi');

			//$this->form_validation->set_rules('blok', 'Blok', 'trim|required');
			//$this->form_validation->set_message('required', '%s Harus diisi');

			//$this->form_validation->set_rules('no_unit', 'No. Unit', 'trim|required');
			//$this->form_validation->set_message('required', '%s Harus diisi');

			//$this->form_validation->set_rules('lantai', 'Lantai', 'trim|numeric|required');
			//$this->form_validation->set_message('numeric', '%s Harus diisi angka');
			//$this->form_validation->set_message('required', '%s Harus diisi');

			// status unit belum di set set_value nya
			//$this->form_validation->set_rules('status_unit', 'Status Unit', 'callback__status_unit_check');
			//$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('penghuni_id', 'Penghuni', 'trim');

			//$this->form_validation->set_rules('dok', 'No. SPRD', 'trim');
			//$this->form_validation->set_rules('tgl_sprd', 'Tanggal SPRD', 'trim|addslashes');
			//$this->form_validation->set_rules('no_bast', 'No. BAST Masuk', 'trim|addslashes');
			//$this->form_validation->set_rules('tgl_bast', 'Tanggal BAST Masuk', 'trim|addslashes');
			
			// wilayah belum di set set_value nya
			//$this->form_validation->set_rules('wilayah', 'Wilayah', 'trim|addslashes');

			// kondisi belum di set set_value nya
			//$this->form_validation->set_rules('kondisi', 'Kondisi Rumah Dinas', 'callback__kondisi_check');

			//$this->form_validation->set_rules('masuk', 'Tanggal Masuk', 'trim|addslashes');
			//$this->form_validation->set_rules('keluar', 'Tanggal Keluar', 'trim|addslashes');
			//$this->form_validation->set_rules('tgl_perbaikan', 'Tanggal Perbaikan', 'trim|addslashes');

			//$this->form_validation->set_rules('nominal_rab', 'Nominal RAB', 'trim');
			//$this->form_validation->set_rules('nominal_spk', 'Nominal SPK', 'trim');
			//$this->form_validation->set_rules('kontraktor', 'Kontraktor', 'trim|addslashes');

			//$this->form_validation->set_rules('id_listrik', 'ID Listrik', 'trim|addslashes');
			//$this->form_validation->set_rules('id_pam', 'ID PAM', 'trim|addslashes');
			//$this->form_validation->set_rules('id_telp', 'ID Telp', 'trim|addslashes');

			//$this->form_validation->set_rules('id_internet1', 'ID Internet 1', 'trim|addslashes');
			//$this->form_validation->set_rules('id_internet2', 'ID Internet 2', 'trim|addslashes');
			//$this->form_validation->set_rules('id_internet3', 'ID Internet 3', 'trim|addslashes');
			//$this->form_validation->set_rules('id_internet4', 'ID Internet 4', 'trim|addslashes');
			//$this->form_validation->set_rules('daya_listrik', 'Daya Listrik', 'trim|addslashes');

			//$this->form_validation->set_rules('hak_menempati', 'Hak Menempati', 'callback__hak_menempati_check');
			$this->form_validation->set_rules('klasifikasi_id', 'Klasifikasi', 'callback__klasifikasi_id_check');

			//$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|addslashes');
			//$this->form_validation->set_rules('alamat_lengkap', 'Alamat Lengkap', 'trim|addslashes');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$loggedinuser = $this->ion_auth->user()->row();

					//$tiket = $this->counter_model->getcodeunit();

					//$nominal_rab = str_replace(".","",$this->input->post('nominal_rab'));
					//$nominal_spk = str_replace(".","",$this->input->post('nominal_spk'));

					$data = array(
						//'kode'       	=> $tiket,
						//'id_lok'       	=> $this->input->post('id_lok'),
						//'nama_unit'		=> $this->input->post('nama_unit'),
						//'blok'			=> $this->input->post('blok'),
						//'no_unit'		=> $this->input->post('no_unit'),
						'lantai'			=> $this->input->post('lantai'),
						'status'			=> $this->input->post('status_unit'),
						
						'penghuni_id'		=> $this->input->post('penghuni_id'),
						'penghuni'			=> $this->input->post('kode_penghuni'),

						'dok'				=> $this->input->post('dok'),
						'tgl_dok'      		=> $this->fungsi->date2mysql($this->input->post('tgl_sprd')),
						'no_bast'			=> $this->input->post('no_bast'),
						'tgl_bast'			=> $this->fungsi->date2mysql($this->input->post('tgl_bast')),
						'wilayah'   		=> $this->input->post('wilayah'),
						'kondisi'       	=> $this->input->post('kondisi'),
						'masuk'         	=> $this->fungsi->date2mysql($this->input->post('masuk')),
						'keluar'        	=> $this->fungsi->date2mysql($this->input->post('keluar')),
						'tgl_perbaikan' 	=> $this->fungsi->date2mysql($this->input->post('tgl_perbaikan')),
						'nominal_rab'   	=> $nominal_rab,
						'nominal_spk'   	=> $nominal_spk,
						'kontraktor'		=> $this->input->post('kontraktor'),
						'id_listrik'    	=> $this->input->post('id_listrik'),
						'id_pam'    		=> $this->input->post('id_pam'),
						'id_telp'    		=> $this->input->post('id_telp'),
						'id_internet1'  	=> $this->input->post('id_internet1'),
						'id_internet2'  	=> $this->input->post('id_internet2'),
						'id_internet3'  	=> $this->input->post('id_internet3'),
						'id_internet4'  	=> $this->input->post('id_internet4'),
						'daya_listrik'  	=> $this->input->post('daya_listrik'),
						'hak_menempati' 	=> $this->input->post('hak_menempati'),
						'klasifikasi_id'	=> $this->input->post('klasifikasi_id'),
						'klasifikasi'  		=> $this->input->post('klasifikasi'),
						'keterangan'  	=> $this->input->post('keterangan'),
						'alamat_lengkap'	=> $this->input->post('alamat_lengkap'),
						'user_id' 			=> $loggedinuser->id,
						//'user_create' 	=> $loggedinuser->username,
						//'create_date' 	=> date('Y-m-d H:i:s'),
						//'status_unit' 	=> 1,
						//'type' => 0
					);

					// check to see if we are inserting the data
					if ($this->units_model->update_data($this->input->post('id'), $data)) {

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
						$this->logs_model->add_log($log);

						// upload and change unit photo
						$link_foto      = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/unit/';
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
								$config['source_image']   = "assets/uploads/images/unit/".$upload_data['file_name'];
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
									unlink("assets/uploads/images/unit/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/unit/".$this->input->post('curr_thumbnail'));
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;

								//$this->inventory_model->update_inventory_by_code($this->input->post('code'), $datas);
								$this->units_model->update_aset_by_code($this->input->post('id'), $datas);

							}
						}

						$this->session->set_flashdata('success', 'Ubah' . ' data unit berhasil');
						redirect('unit/edit/'.$this->input->post('id'), 'refresh');

					}
					else {

						// Set message
						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

						redirect('unit/edit/'.$this->input->post('id'), 'refresh');

					}

				}
				// validation Failed
				else {

					//$this->data['data_list'] = $this->fasilitas_model->get_fasilitas();
					$this->data['data_list_area'] = $this->fasilitas_model->get_area();
					$this->data['list_unit'] = $this->units_model->get_unit_by_id_unit($this->input->post('id'));
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
					$this->load->view('inv_unit/edit', $this->data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_unit/js');
					$this->load->view('js_script');

				}

			}
			else {

				//$this->data['data_list'] = $this->fasilitas_model->get_fasilitas();
				$this->data['data_list_area'] = $this->fasilitas_model->get_area();
				$this->data['list_unit'] = $this->units_model->get_unit_by_id_unit($this->input->post('id'));
				$this->data['open_form'] = "open";

				// set the flash data error message if there is one
				//$this->data['message'] = (validation_errors()) ? validation_errors() :
				//$this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_unit/edit', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_unit/js');

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

	function datatables_unit()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
       
		/* DB table to use */
		$sTable = "unit";
     
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
		$aColumns = array('nama_unit', 'blok', 'no_unit', 'unit.alamat_lengkap');
  
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

		$klasifikasi_id = (isset($_GET['klasifikasi_id']))?($_GET['klasifikasi_id']):'0';
		$klasifikasi_id = ($klasifikasi_id == '') ? '0' : $klasifikasi_id;

		$params = array();
		$params['id_lok'] = $id_lok;
		$params['id_unit'] = $id_unit;
		$params['id_status'] = $id_status;
		$params['klasifikasi_id'] = $klasifikasi_id;
		
		$rResult = $this->units_model->getlist_unit_by_area($aColumns, $sWhere, $sOrder, $top, $limit, $params);
       
		$iTotal = 0;
        $rResultTotal = $this->units_model->getlist_unit_by_area_total($sIndexColumn, $params);
        $iTotal = $rResultTotal->row()->total_jml_data;
	   
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->units_model->getlist_unit_by_area_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params);
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
			$row[] = $aRow->no_unit;

			$tombol_detail = '<i class="ui-tooltip fa fa-book" title="Lihat Detil Unit" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Detil Unit" onclick="detail('."'".$aRow->id."'".')"></i>&nbsp;';
			$tombol_hapus = $tombol_detail.'<i class="ui-tooltip fa fa-trash-o" title="Hapus Data" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Hapus Data" onclick="hapus_data('."'".$aRow->id."',"."'".$aRow->photo."',"."'".$aRow->thumbnail."'".')"></i>';
			$tombol_list_set = '<i class="ui-tooltip fa fa-male" title="Lihat Penghuni" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Penghuni" onclick="detail_penghuni('."'".$aRow->penghuni."',"."'".$aRow->id."',"."'".$aRow->id_lok."'".')"></i>&nbsp;
			<i class="ui-tooltip fa fa-pencil-square-o" title="Edit Data" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Edit Data" onclick="edit('."'".$aRow->id."',"."'".$aRow->photo."',"."'".$aRow->thumbnail."'".')"></i>&nbsp;'.$tombol_hapus;

			$row[] = $aRow->nama_lokasi . ', ' . $aRow->nama_unit . ', ' . 'lantai ' . $aRow->lantai;

			$row[] = $aRow->keterangan;

			if ($aRow->thumbnail != ''){

				$row[] = '<a href="' . base_url('assets/uploads/images/unit/') . $aRow->photo . '" data-fancybox data-caption="' . $aRow->nama_unit . '">
				<img src="' . base_url('assets/uploads/images/unit/') . $aRow->thumbnail . '" alt="' . $aRow->nama_unit . '">
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

	function load_dropdown_penghuni()
	{
		
		$list_data = $this->penghunis_model->load_dropdown_penghuni();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['nama'] = $qryget['nama'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

	function load_dropdown_wilayah()
	{
		
		$list_data = $this->units_model->load_dropdown_wilayah();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['wilayah'] = $qryget['wilayah'];
			$ddata[] = $row;
		
		}

		$output = array(
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
		
		$list_data = $this->units_model->load_dropdown_klasifikasi();
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

	public function _hak_menempati_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_hak_menempati_check', '%s Harus Di Isi');
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

	public function _status_unit_check($value)
	{
		if ($value == '0') {
			$this->form_validation->set_message('_status_unit_check', '%s Harus Di Isi');
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

}

/* End of Unit.php */
