<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Aset Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Aset extends CI_Controller {

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
				'inventory_model',
				'asets_model',
				'categories_model',
				'status_model',
				'locations_model',
				'color_model',
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
	*	Showing list of aset and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/aset', 'refresh');
		}
		// Logged in
		else{

			$params = array();

			$q = $this->input->get('q', TRUE);
			$this->data['q'] = $q;

			$params['id_fasilitas'] = '';
			$params['q'] = $q;

			//$this->data['data_list_area'] = $this->fasilitas_model->get_area();
			//$this->data['data_list'] = $this->fasilitas_model->get_fasilitas($params);
			
			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['nama_faskes'] = $this->session->userdata('nama_faskes');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
			//$data['level'] = $this->session->userdata('level');
			
			$this->data['title']="Aset";	
			$this->data['subtitle']="Master Aset / List Aset";
				
			$this->data['tabletitle'] = 'List Data Aset';

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Master Aset</a></li>
									<li class=\"active\">List Aset</li>";

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_aset/list_data_aset', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_aset/js');
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
			redirect('auth/login/aset', 'refresh');
		}
		// Logged in
		else {
			
			// input validation rules
			$this->form_validation->set_rules('nomor_aset', 'Code / No. Aset', 'trim');
			
			$this->form_validation->set_rules('nama', 'Nama Aset', 'required');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('bagian', 'Bagian Penempatan', 'trim|required');
			$this->form_validation->set_rules('merek', 'Merek / Brand', 'trim');
			$this->form_validation->set_rules('model', 'Model', 'trim');
			$this->form_validation->set_rules('bahan', 'Bahan', 'trim');
			$this->form_validation->set_rules('kategori', 'Jenis Aset', 'trim');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim');
			
			//$this->form_validation->set_rules('color', 'Color', 'trim');
			//$this->form_validation->set_rules('new_color', 'New Color', 'alpha_numeric_spaces|trim');
			//$this->form_validation->set_rules('length', 'Length', 'numeric|trim');
			//$this->form_validation->set_rules('width', 'Width', 'numeric|trim');
			//$this->form_validation->set_rules('height', 'Height', 'numeric|trim');
			//$this->form_validation->set_rules('weight', 'Weight', 'numeric|trim');
			//$this->form_validation->set_rules('kondisi', 'Kondisi', 'numeric|trim');

			//$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'numeric|trim');
			//$this->form_validation->set_rules('tgl_beli', 'Tanggal Perolehan', 'trim');
			//$this->form_validation->set_rules('descriptions', 'Description', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// color
				// if new color is not empty, set color - insert to master table
				$new_color = 0;
				$color     = $this->input->post('color');
				if ($this->input->post('new_color')!="") {
					$new_color = 1;
					$color     = ucwords(strtolower($this->input->post('new_color')));
				}

				// color array
				// insert only if color is not duplicate
				if ($new_color==1 && $this->_color_check($color)) {
					$data_new_color = array('name' => $color, );
					$this->color_model->insert_color($data_new_color);
				}

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$harga_beli = str_replace(".","",$this->input->post('harga_beli'));
					$tgl_beli = $this->fungsi->date2mysql($this->input->post('tgl_beli'));

					// aset data array
					$data = array(
						'nomor_aset'       	=> $this->input->post('nomor_aset'),
						'nama'       		=> $this->input->post('nama'),
						'bagian'			=> $this->input->post('bagian'),
						'merek'				=> $this->input->post('merek'),
						'model'				=> $this->input->post('model'),
						'bahan'				=> $this->input->post('bahan'),
						'kategori'			=> $this->input->post('kategori'),
						'serial_number'		=> $this->input->post('serial_number'),
						'category_id'      	=> $this->input->post('category2'),
						'status_aset'		=> $this->input->post('status2'),
						'id_area'		   	=> $this->input->post('location'),
						'id_unit'		   	=> $this->input->post('id_unit'),
						'color'            	=> $color,
						'length'           	=> $this->input->post('length'),
						'width'            	=> $this->input->post('width'),
						'height'           	=> $this->input->post('height'),
						'weight'           	=> $this->input->post('weight'),
						'kondisi'          	=> $this->input->post('kondisi'),
						'harga_beli'        => $harga_beli,
						'tgl_beli'	 		=> $tgl_beli,
						'deskripsi'      	=> $this->input->post('deskripsi')
					);

					/*
					echo '<pre>';
					print_r($data);
					echo '</pre>';
					exit;
					*/

					// check to see if we are inserting the data
					if ($this->inventory_model->insert_data($data)) {

						$id_auto = $this->db->insert_id();

						// logging array
						$data_location_log = array(
							'aset_id'		=> $id_auto,
							'code'        	=> $this->input->post('nomor_aset'),
							'location_id' 	=> $this->input->post('location'),
							'unit_id' 		=> $this->input->post('id_unit')
						);

						$data_status_log = array(
							'aset_id'	=> $id_auto,
							'code'      => $this->input->post('nomor_aset'),
							'status_id' => $this->input->post('status2'),
						);

						// Insert logs
						$this->logs_model->insert_location_log($data_location_log);
						$this->logs_model->insert_status_log($data_status_log);

						// Set message
						//$this->session->set_flashdata('success',$this->config->item('message_start_delimiter', 'ion_auth')."Data Saved Successfully!".$this->config->item('message_end_delimiter', 'ion_auth'));

						// upload and change inventory photo
						$link_foto      = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/inventory/';
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
								$config['source_image']   = "assets/uploads/images/inventory/".$upload_data['file_name'];
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
								$this->inventory_model->update_inventory_by_code($id_auto, $datas);

							}
						}

						$this->session->set_flashdata('success', 'Tambah' . ' data aset berhasil');
						redirect('aset/add', 'refresh');

					}
					else {

						// Set message
						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

						redirect('aset/add', 'refresh');

					}

				}

				// validation Failed
				else {

					// set the flash data error message if there is one
					$this->data['error']   = (validation_errors()) ? validation_errors() :
					$this->session->flashdata('warning');

					$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
					$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
					$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
					$this->data['col_list']  = $this->color_model->get_color('','','','asc');
					$this->data['brand_list'] = $this->inventory_model->get_brands();

					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('inv_aset/add');
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_aset/js');
					$this->load->view('js_script');

				}
			}
			else {
				// $this->data['data_list'] = $this->categories_model->get_categories();
				// set the flash data error message if there is one
				$this->data['error']   = (validation_errors()) ? validation_errors() :
				$this->session->flashdata('warning');

				$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
				$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
				$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
				$this->data['col_list']  = $this->color_model->get_color('','','','asc');
				$this->data['brand_list'] = $this->inventory_model->get_brands();

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_aset/add');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_aset/js');
				$this->load->view('js_script');
			}
		}
	}

	// Add data end

	/**
	*	Callback to check duplicate nomor_aset
	*
	*	@param 		string 		$nomor_aset
	*	@return 	bool
	*
	*/
	public function _code_check($nomor_aset)
	{
		$datas = $this->asets_model->nomor_aset_check($nomor_aset);
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
			redirect('auth/login/aset', 'refresh');
		}
		// Logged in
		else {
				
			$this->data['error']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('warning');

			$this->data['list_aset']  = $this->asets_model->get_aset_by_id($id);

			$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']  = $this->color_model->get_color('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_aset/edit', $this->data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_aset/js');
			$this->load->view('js_script');

		}

	}
	// Edit data end

	public function save_edit(){

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/aset', 'refresh');
		}
		// Logged in
		else {

			// input validation rules

			$this->form_validation->set_rules('nomor_aset', 'Code / No. Aset', 'trim');
			
			$this->form_validation->set_rules('nama', 'Nama Aset', 'required');
			$this->form_validation->set_message('required', '%s Harus diisi');

			$this->form_validation->set_rules('bagian', 'Bagian Penempatan', 'trim|required');
			$this->form_validation->set_rules('merek', 'Merek / Brand', 'trim');
			$this->form_validation->set_rules('model', 'Model', 'trim');
			$this->form_validation->set_rules('bahan', 'Bahan', 'trim');
			$this->form_validation->set_rules('kategori', 'Jenis Aset', 'trim');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim');
			
			//$this->form_validation->set_rules('color', 'Color', 'trim');
			//$this->form_validation->set_rules('new_color', 'New Color', 'alpha_numeric_spaces|trim');
			//$this->form_validation->set_rules('length', 'Length', 'numeric|trim');
			//$this->form_validation->set_rules('width', 'Width', 'numeric|trim');
			//$this->form_validation->set_rules('height', 'Height', 'numeric|trim');
			//$this->form_validation->set_rules('weight', 'Weight', 'numeric|trim');
			//$this->form_validation->set_rules('kondisi', 'Kondisi', 'numeric|trim');

			//$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'numeric|trim');
			//$this->form_validation->set_rules('tgl_beli', 'Tanggal Perolehan', 'trim');
			//$this->form_validation->set_rules('descriptions', 'Description', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// color
				// if new color is not empty, set color - insert to master table
				$new_color = 0;
				$color     = $this->input->post('color');
				if ($this->input->post('new_color')!="") {
					$new_color = 1;
					$color     = ucwords(strtolower($this->input->post('new_color')));
				}

				// color array
				// insert only if color is not duplicate
				if ($new_color==1 && $this->_color_check($color)) {
					$data_new_color = array('name' => $color, );
					$this->color_model->insert_color($data_new_color);
				}

				// validation run
				if ($this->form_validation->run() === TRUE) {

					$loggedinuser = $this->ion_auth->user()->row();

					$harga_beli = str_replace(".","",$this->input->post('harga_beli'));
					$tgl_beli = $this->fungsi->date2mysql($this->input->post('tgl_beli'));

					// aset data array
					$data = array(
						'nomor_aset'       	=> $this->input->post('nomor_aset'),
						'nama'       		=> $this->input->post('nama'),
						'bagian'			=> $this->input->post('bagian'),
						'merek'				=> $this->input->post('merek'),
						'model'				=> $this->input->post('model'),
						'bahan'				=> $this->input->post('bahan'),
						'kategori'			=> $this->input->post('kategori'),
						'serial_number'		=> $this->input->post('serial_number'),
						'category_id'      	=> $this->input->post('category2'),
						'status_aset'		=> $this->input->post('status2'),
						'id_area'		   	=> $this->input->post('location'),
						'id_unit'		   	=> $this->input->post('id_unit'),
						'color'            	=> $color,
						'length'           	=> $this->input->post('length'),
						'width'            	=> $this->input->post('width'),
						'height'           	=> $this->input->post('height'),
						'weight'           	=> $this->input->post('weight'),
						'kondisi'          	=> $this->input->post('kondisi'),
						'harga_beli'        => $harga_beli,
						'tgl_beli'	 		=> $tgl_beli,
						'deskripsi'      	=> $this->input->post('deskripsi')
					);

					/*
					echo '<pre>';
					print_r($data);
					echo '</pre>';
					exit;
					*/

					// check to see if we are inserting the data
					if ($this->asets_model->update_data($this->input->post('id'), $data)) {

						$id = $this->input->post('id');
						$curr_status_aset	= $this->input->post('curr_status_aset');
						$change_status_aset	= $this->input->post('status2');

						$curr_area_id 		= $this->input->post('curr_area_id');
						$change_area_id 	= $this->input->post('location');

						$curr_unit_id 		= $this->input->post('curr_unit_id');
						$change_unit_id 	= $this->input->post('id_unit');

						if (($curr_area_id != $change_area_id) OR ($curr_unit_id != $change_unit_id)){

							// logging array
							$data_location_log = array(
								'aset_id'		=> $id,
								'code'        	=> $this->input->post('nomor_aset'),
								'location_id' 	=> $this->input->post('location'),
								'unit_id' 		=> $this->input->post('id_unit'),
							);

						}

						if ($curr_status_aset != $change_status_aset){

							$data_status_log = array(
								'aset_id'	=> $id,
								'code'      => $this->input->post('nomor_aset'),
								'status_id' => $this->input->post('status2'),
							);

						}

						// Insert logs
						$this->logs_model->insert_location_log($data_location_log);
						$this->logs_model->insert_status_log($data_status_log);

						// upload and change unit photo
						$link_foto      = "";
						$link_thumbnail = "";

						if (!empty($_FILES['photo']['name'])) {

							//$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/inventory/';
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
								$config['source_image']   = "assets/uploads/images/inventory/".$upload_data['file_name'];
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
									unlink("assets/uploads/images/inventory/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/inventory/".$this->input->post('curr_thumbnail'));
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;

								$this->asets_model->update_aset_by_id($this->input->post('id'), $datas);

							}
						}

						$this->session->set_flashdata('success', 'Ubah' . ' data aset berhasil');
						redirect('aset/edit/'.$this->input->post('id'), 'refresh');

					}
					else {

						// Set message
						$this->session->set_flashdata('error',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);

						redirect('aset/edit/'.$this->input->post('id'), 'refresh');

					}

				}
				// validation Failed
				else {

					$this->data['open_form'] = "open";

					// set the flash data error message if there is one
					$this->data['error'] = (validation_errors()) ? validation_errors() :

					// Set message
					$this->session->set_flashdata('error',
						$this->config->item('error_start_delimiter', 'ion_auth')
						."Validation Errors!".
						$this->config->item('error_end_delimiter', 'ion_auth')
					);

					$this->data['error']   = (validation_errors()) ? validation_errors() :
					//$this->session->flashdata('warning');

					$this->data['list_aset']  = $this->asets_model->get_aset_by_id($id);

					$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
					$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
					$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
					$this->data['col_list']  = $this->color_model->get_color('','','','asc');
					$this->data['brand_list'] = $this->inventory_model->get_brands();

					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('inv_aset/edit', $this->data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_aset/js');
					$this->load->view('js_script');

				}

			}
			else {

				$this->data['error']   = (validation_errors()) ? validation_errors() :
				$this->session->flashdata('warning');

				$this->data['list_aset']  = $this->asets_model->get_aset_by_id($id);

				$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
				$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
				$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
				$this->data['col_list']  = $this->color_model->get_color('','','','asc');
				$this->data['brand_list'] = $this->inventory_model->get_brands();

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_aset/edit', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_aset/js');
				$this->load->view('js_script');

			}

		}

	}

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

	function datatables_aset()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
       
		/* DB table to use */
		$sTable = "aset";
     
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
		
		$aColumns = array('nama', 'nomor_aset');
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
		$id_lok = (isset($_GET['id_lok']))?($_GET['id_lok']):'0';
		$id_lok = ($id_lok == '') ? '0' : $id_lok;

		$id_unit = (isset($_GET['id_unit']))?($_GET['id_unit']):'0';
		$id_unit = ($id_unit == '') ? '0' : $id_unit;

		$id_status = (isset($_GET['id_status']))?($_GET['id_status']):'0';
		$id_status = ($id_status == '') ? '0' : $id_status;

		$id_kategori = (isset($_GET['id_kategori']))?($_GET['id_kategori']):'0';
		$id_kategori = ($id_kategori == '') ? '0' : $id_kategori;

		$params = array();
		$params['id_lok'] = $id_lok;
		$params['id_unit'] = $id_unit;
		$params['id_status'] = $id_status;
		$params['id_kategori'] = $id_kategori;
		
		$rResult = $this->asets_model->getlist_aset_by_unit_area($aColumns, $sWhere, $sOrder, $top, $limit, $params);
       
		$iTotal = 0;
        $rResultTotal = $this->asets_model->getlist_aset_by_unit_area_total($sIndexColumn, $params);
        $iTotal = $rResultTotal->row()->total_jml_data;
	   
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->asets_model->getlist_aset_by_unit_area_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params);
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
			$row[] = $aRow->nama_unit . ', ' . $aRow->blok . ' ' . $aRow->no_unit;
			$row[] = $aRow->nama_status_aset;
			$row[] = $aRow->nama;
			$row[] = $aRow->bagian; 
			$row[] = $aRow->nomor_aset;

			//$row[] = $this->fungsi->yyyymmdd_ddmmyyyy_hhmmss($aRow->tgl_order, $aRow->tgl_order, TRUE);
			$tombol_timeline = '<i class="ui-tooltip fa fa-pencil-square-o" title="Edit Data" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Edit Data" onclick="edit('."'".$aRow->id."',"."'".$aRow->photo."',"."'".$aRow->thumbnail."'".')"></i>&nbsp;
			<i class="ui-tooltip fa fa-book" title="Lihat Detil Aset" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Detil Aset" onclick="detail('."'".$aRow->id."'".')"></i>&nbsp;
			<i class="ui-tooltip fa fa-trash-o" title="Hapus Data" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Hapus Data" onclick="hapus_data('."'".$aRow->id."',"."'".$aRow->photo."',"."'".$aRow->thumbnail."'".')"></i>';
	
			$row[] = $aRow->kategori;
			$row[] = $aRow->merek;
			$row[] = $aRow->bahan; 
			$row[] = $aRow->kategori_aset;
			$row[] = $aRow->kondisi;
			$row[] = tgl_indo_ddmmyyyy($aRow->tgl_beli);
			
			if ($aRow->thumbnail != ''){

				$row[] = '<a href="' . base_url('assets/uploads/images/inventory/') . $aRow->photo . '" data-fancybox data-caption="' . $aRow->nama . '">
				<img src="' . base_url('assets/uploads/images/inventory/') . $aRow->thumbnail . '" alt="' . $aRow->nama . '">
				</a>';

			} else {
				$row[] = '';
			}

			$row[] = $aRow->deskripsi;
			$row[] = $aRow->nomor_seri;
			$row[] = $this->fungsi->pecah($aRow->harga_beli);
			$row[] = $tombol_timeline;

			$page++;
			$output['aaData'][] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 
    
		echo json_encode($output);
		
	}

	/**
	*	Callback to check duplicate sn
	*
	*	@param 		string 		$sn
	*	@return 	bool
	*
	*/
	public function _sn_check($sn)
	{
		if ($sn=="") {
			return TRUE;
		}

		$datas = $this->inventory_model->sn_check($sn);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_sn_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate color name
	*
	*	@param 		string 		$new_color
	*	@return 	bool
	*
	*/
	public function _color_check($new_color)
	{
		$datas = $this->color_model->name_check($new_color);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_color_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	function hapus_data()
	{

		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/aset', 'refresh');
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

			$is_success = $this->asets_model->hapus_data($id);
			//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data user Dengan ID '.$id.' Berhasil Dihapus.</div>');

			if ($is_success){

				// delete old Photo
				if ($photo != "") {
					unlink("assets/uploads/images/inventory/".$photo);
					unlink("assets/uploads/images/inventory/".$thumbnail);
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

	public function detail($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/aset/detail/'.$code, 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Show detailed data based on code
				$this->data['data_detail'] = $this->inventory_model->get_inventory_by_code(
					$code
				);
				// Show logs
				$this->data['location_logs'] = $this->logs_model->get_location_log_by_code(
					$code
				);
				$this->data['status_logs'] = $this->logs_model->get_status_log_by_code(
					$code
				);

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_aset/detail');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_aset/js');
				// $this->load->view('js_script');
			}
		}
	}

}

/* End of Aset.php */
