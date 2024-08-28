<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Fasilitas Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Inventory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(false);

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
				'categories_model',
				'locations_model',
				'status_model',
				'color_model',
				'logs_model',
				'areas_model',
				'units_model',
				'asets_model',
				'penghunis_model'
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
	*	Showing add new data form and links to another locations.
	*
	*	@return 	void
	*
	*/
	public function index()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// set the flash data error message if there is one
			$this->data['message']    = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['cat_list']   = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list']  = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']   = $this->color_model->get_color('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			// $this->data['last_query'] = $this->db->last_query();

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}
	// Index end

	/**
	*	All inventory data.
	*	Showing all inventory data without any filtering.
	* But still using pagination.
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function all($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list']  = $this->inventory_model->get_inventory();

			// Set pagination
			$config['base_url']         = base_url('inventory/all');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->inventory_model->get_inventory("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/all_data');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			// $this->load->view('js_script');
		}
	}
	// All inventory data end

	/**
	*	Inventory by category.
	*	Showing inventory category name and total inventory per category.
	* Give link to each categorized inventory.
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function by_category($code="", $page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Get category detail
				$category_detail = $this->categories_model->get_categories_by_code($code);
				// If exists, set detailed data. Else redirect back because invalid code
				if (count($category_detail->result())>0) {
					foreach ($category_detail->result() as $cat_data) {
						$this->data['category_name'] = $cat_data->name;
						$this->data['category_desc'] = $cat_data->description;
					}
				}
				else {
					redirect('inventory/by_category', 'refresh');
				}

				// Show all data based on code
				$this->data['data_list']  = $this->inventory_model->get_inventory_by_category_code(
					$code
				);

				// Set pagination
				$config['base_url']         = base_url('inventory/by_category/'.$code);
				$config['use_page_numbers'] = TRUE;
				$config['total_rows']       = count($this->data['data_list']->result());
				$config['per_page']         = 15;
				$this->pagination->initialize($config);

				// Get datas and limit based on pagination settings
				if ($page=="") { $page = 1; }
				$this->data['data_list'] = $this->inventory_model->get_inventory_by_category_code(
					$code,
					$config['per_page'],
					( $page - 1 ) * $config['per_page']
				);
				// $this->data['last_query'] = $this->db->last_query();
				$this->data['pagination'] = $this->pagination->create_links();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_category_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
			// Summary
			else {
				// inventory by category summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_category_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_category_index');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
		}
	}
	// Inventory by category end

	/**
	*	Inventory by location.
	*	Showing inventory location name and total inventory per location.
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function by_location($code="", $page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Get location detail
				$location_detail = $this->locations_model->get_locations_by_code($code);
				// If exists, set detailed data. Else redirect back because invalid code
				if (count($location_detail->result())>0) {
					foreach ($location_detail->result() as $loc_data) {
						$this->data['location_name'] = $loc_data->name;
						$this->data['location_desc'] = $loc_data->detail;
					}
				}
				else {
					redirect('inventory/by_location', 'refresh');
				}

				// Show all data based on code
				$this->data['data_list']  = $this->inventory_model->get_inventory_by_location_code(
					$code
				);

				// Set pagination
				$config['base_url']         = base_url('inventory/by_location/'.$code);
				$config['use_page_numbers'] = TRUE;
				$config['total_rows']       = count($this->data['data_list']->result());
				$config['per_page']         = 15;
				$this->pagination->initialize($config);

				// Get datas and limit based on pagination settings
				if ($page=="") { $page = 1; }
				$this->data['data_list'] = $this->inventory_model->get_inventory_by_location_code(
					$code,
					$config['per_page'],
					( $page - 1 ) * $config['per_page']
				);
				// $this->data['last_query'] = $this->db->last_query();
				$this->data['pagination'] = $this->pagination->create_links();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_location_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
			// Summary
			else {
				// inventory by location summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_location_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_location_index');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
		}
	}
	// Inventory by location end

	/**
	*	Inventory detail.
	*	Showing inventory detailed data
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function detail($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory/detail/'.$code, 'refresh');
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
				$this->load->view('inv_data/detail');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
		}
	}
	// Inventory by category end

	/**
	*	Search
	*	Showing inventory search form.
	*
	* @param 		string
	*	@return 	void
	*
	*/
	public function search($process="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			$this->data['cat_list']   = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list']  = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']   = $this->color_model->get_color('','','','asc');

			// input validation rules
			$this->form_validation->set_rules(
				'keyword',
				'Keyword',
				'alpha_numeric_spaces|trim|required|min_length[3]'
			);

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					// set variables for keyword and filters
					$keyword  = $this->input->post('keyword');

					$category = (!empty($this->input->post('category')))?implode(",", $this->input->post('category')) : "";

					$location = (!empty($this->input->post('location')))?implode(",", $this->input->post('location')) : "";

					$status   = (!empty($this->input->post('status'))) ? implode(",", $this->input->post('status')) : "";
					
					$filters  = array(
						'category_id' => $category,
						'id_area' => $location,
						'status_aset' => $status
					);
					
					$this->data['results'] = $this->inventory_model->get_inventory_by_keyword(
						$keyword,
						$filters
					);

					$this->session->set_flashdata('message',
						$this->config->item('success_start_delimiter', 'ion_auth')
						."Search results with keyword '$keyword'".
						$this->config->item('success_end_delimiter', 'ion_auth')
					);
				}
			}
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/search_form');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
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
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('code', 'Code', 'alpha_numeric|trim|required|callback__code_check');
			$this->form_validation->set_rules('brand', 'Brand', 'trim|required|addslashes');
			$this->form_validation->set_rules('model', 'Model', 'trim|addslashes');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|addslashes|callback__sn_check');
			$this->form_validation->set_rules('color', 'Color', 'trim|addslashes');
			$this->form_validation->set_rules('new_color', 'New Color', 'alpha_numeric_spaces|trim|addslashes');
			$this->form_validation->set_rules('length', 'Length', 'numeric|trim');
			$this->form_validation->set_rules('width', 'Width', 'numeric|trim');
			$this->form_validation->set_rules('height', 'Height', 'numeric|trim');
			$this->form_validation->set_rules('weight', 'Weight', 'numeric|trim');
			$this->form_validation->set_rules('price', 'Price', 'numeric|trim');
			$this->form_validation->set_rules('date_of_purchase', 'Date of Purchase', 'trim');
			$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|addslashes');

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
					// inv data array
					$data = array(
						'code'             => $this->input->post('code'),
						'category_id'      => $this->input->post('category2'),
						'location_id'      => $this->input->post('location'),
						'brand'            => $this->input->post('brand'),
						'model'            => $this->input->post('model'),
						'serial_number'    => $this->input->post('serial_number'),
						'status'           => $this->input->post('status2'),
						'color'            => $color,
						'length'           => $this->input->post('length'),
						'width'            => $this->input->post('width'),
						'height'           => $this->input->post('height'),
						'weight'           => $this->input->post('weight'),
						'price'            => $this->input->post('price'),
						'date_of_purchase' => $this->input->post('date_of_purchase'),
						'description'      => $this->input->post('description'),
						'deleted'          => '0',
					);

					// logging array
					$data_location_log = array(
						'code'        => $this->input->post('code'),
						'location_id' => $this->input->post('location'),
					);
					$data_status_log = array(
						'code'      => $this->input->post('code'),
						'status_id' => $this->input->post('status2'),
					);

					// check to see if we are inserting the data
					if ($this->inventory_model->insert_data($data)) {
						// Insert logs
						$this->logs_model->insert_location_log($data_location_log);
						$this->logs_model->insert_status_log($data_status_log);

						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Data Saved Successfully!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);

						// upload and change inventory photo
						$link_foto      = "";
						$link_thumbnail = "";
						if (!empty($_FILES['photo']['name'])) {
							$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/inventory/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$this->load->library('upload', $config);
							// fail to upload
							if ( ! $this->upload->do_upload('photo')) {
								// Error upload
								$this->session->set_flashdata('message',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Location Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);
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
								$this->inventory_model->update_inventory_by_code($this->input->post('code'), $datas);
							}
						}
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('inventory', 'refresh');
				}

				// validation Failed
				else {
					// set the flash data error message if there is one
					$this->data['message']   = (validation_errors()) ? validation_errors() :
					$this->session->flashdata('message');

					$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
					$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
					$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
					$this->data['col_list']  = $this->color_model->get_color('','','','asc');
					$this->data['brand_list'] = $this->inventory_model->get_brands();

					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('inv_data/add');
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_data/js');
					$this->load->view('js_script');
				}
			}

			else {
				// $this->data['data_list'] = $this->categories_model->get_categories();
				// set the flash data error message if there is one
				$this->data['message']   = (validation_errors()) ? validation_errors() :
				$this->session->flashdata('message');

				$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
				$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
				$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
				$this->data['col_list']  = $this->color_model->get_color('','','','asc');
				$this->data['brand_list'] = $this->inventory_model->get_brands();

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/add');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
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
		$datas = $this->inventory_model->code_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_code_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

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

	/**
	*	Edit Data
	*	If there's data sent, update
	*	Else, show the form
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function edit($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			// $this->form_validation->set_rules('code', 'Code', 'alpha_numeric|trim|required|callback__code_check');
			$this->form_validation->set_rules('brand', 'Brand', 'trim|required|addslashes');
			$this->form_validation->set_rules('model', 'Model', 'trim|addslashes');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|addslashes');
			$this->form_validation->set_rules('color', 'Color', 'trim|addslashes');
			$this->form_validation->set_rules('new_color', 'New Color', 'alpha_numeric_spaces|trim|addslashes');
			$this->form_validation->set_rules('length', 'Length', 'numeric|trim');
			$this->form_validation->set_rules('width', 'Width', 'numeric|trim');
			$this->form_validation->set_rules('height', 'Height', 'numeric|trim');
			$this->form_validation->set_rules('weight', 'Weight', 'numeric|trim');
			$this->form_validation->set_rules('price', 'Price', 'numeric|trim');
			$this->form_validation->set_rules('date_of_purchase', 'Date of Purchase', 'trim');
			$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|addslashes');

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
					// inv data array
					$data = array(
						'category_id'      => $this->input->post('category2'),
						'location_id'      => $this->input->post('location'),
						'brand'            => $this->input->post('brand'),
						'model'            => $this->input->post('model'),
						'serial_number'    => $this->input->post('serial_number'),
						'status'           => $this->input->post('status2'),
						'color'            => $color,
						'length'           => $this->input->post('length'),
						'width'            => $this->input->post('width'),
						'height'           => $this->input->post('height'),
						'weight'           => $this->input->post('weight'),
						'price'            => $this->input->post('price'),
						'date_of_purchase' => $this->input->post('date_of_purchase'),
						'description'      => $this->input->post('description')
					);

					// check to see if we are updating the data
					if ($this->inventory_model->update_inventory_by_code($code, $data)) {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Inventory Updated!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);

						// upload and change inventory photo
						$link_foto      = "";
						$link_thumbnail = "";
						if (!empty($_FILES['photo']['name'])) {
							$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')).rand());
							$config['upload_path']   = './assets/uploads/images/inventory/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$this->load->library('upload', $config);
							// fail to upload
							if ( ! $this->upload->do_upload('photo')) {
								// Error upload
								$this->session->set_flashdata('message',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Location Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);
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
								$this->inventory_model->update_inventory_by_code($code, $datas);

								// delete old Photo (if needed)
								if ($this->input->post('curr_photo')!="") {
									unlink("assets/uploads/images/inventory/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/inventory/".$this->input->post('curr_thumbnail'));
								}
							}
						}

					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Inventory Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('inventory/all', 'refresh');
				}
			}
			// Get data
			$this->data['code']       = $code;
			$this->data['data_list']  = $this->inventory_model->get_inventory_by_code($code);
			$this->data['cat_list']   = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list']  = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']   = $this->color_model->get_color('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to categories
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function delete($code)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/inventory', 'refresh');
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
					if ($this->inventory_model->update_inventory_by_code($code, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Inventory Deleted!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Inventory Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('inventory', 'refresh');
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
			$this->data['summary'] = $this->inventory_model->get_inventory_by_area_summary();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/list_data_area');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}

	public function by_unit($id_lok = "")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory/by_unit', 'refresh');
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
				redirect('inventory/by_area', 'refresh');
			}

			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['nama_faskes'] = $this->session->userdata('nama_faskes');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
			//$data['level'] = $this->session->userdata('level');
				
				
			$this->data['title']="Unit";	
			$this->data['subtitle']=" Area / Unit";
				
			$this->data['tabletitle'] = '<small class="label label-info">' . 'Area : ' . $this->data['nama_lokasi'] . '</small>&nbsp;' .
			'<small class="label label-warning">' . 'Alamat : ' . $this->data['alamat_lengkap'] . '</small>';

			$this->data['navigasi'] = "<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Monitoring</a></li>
									<li><a href=\"" . site_url() . "inventory/by_area\">Area</a></li>
									<li class=\"active\">Unit</li>";

			$this->data['data_list'] = $this->inventory_model->get_unit_by_id_lok($id_lok);
			$this->data['id_lok'] = $id_lok;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/list_data_unit', $this->data);
			$this->load->view('partials/_alte_footer');

			$this->load->view('inv_data/js');
			
		}
	}

	public function by_aset_unit_area($id_lok = '', $id_unit = '')
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{

			// If id_lok is provided, show data based on id_lok
			if ($id_lok!="") {

				// Get area detail
				$unit_detail = $this->units_model->get_unit_by_id_unit($id_unit);

				// If exists, set detailed data. Else redirect back because invalid id_lok
				if (count($unit_detail->result())>0) {
					
					foreach ($unit_detail->result() as $unit_data) {
						$this->data['nama_unit'] = $unit_data->nama_unit;
						$this->data['blok'] = $unit_data->blok;
						$this->data['no_unit'] = $unit_data->no_unit;
					}

				}
				else {
					redirect('inventory/by_area', 'refresh');
				}

				$data['username'] = $this->session->userdata('username');
				$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
				$data['nama_faskes'] = $this->session->userdata('nama_faskes');
				$data['email'] = $this->session->userdata('email');
				$data['address'] = $this->session->userdata('address');
				$data['phone'] = $this->session->userdata('phone');
				//$data['level'] = $this->session->userdata('level');
				
				$this->data['title']="Monitoring Aset Unit";
				$this->data['subtitle']=" Area / Unit / Aset";

				//$data['tabletitle'] = 'Pengirim : ' . $this->session->userdata('nama_lengkap') . ' | ' . 'Sender Phone : ' . $this->session->userdata('phone') . ' | ' . 'Pickup Address : ' . $this->session->userdata('address');
				
				$this->data['tabletitle'] = '<small class="label label-info">' . 'Unit : ' . $this->data['nama_unit'] . '</small>&nbsp;' .
				'<small class="label label-warning">' . 'Blok : ' . $this->data['blok'] . '</small>&nbsp;' . '<small class="label label-success">' . 'No. Unit : ' . $this->data['no_unit'] . '</small>';

				$this->data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Monitoring</a></li>
										<li><a href=\"" . site_url() . "inventory/by_area\">Area</a></li>
										<li><a href=\"" . site_url() . "inventory/by_unit/$id_lok\">Unit</a></li>
										<li class=\"active\">Aset</li>";

				// Show all data based on id_lok
				//$this->data['data_list'] = $this->inventory_model->get_aset_by_unit_area($id_lok, $id_unit);
				$this->data['id_lok'] = $id_lok;
				$this->data['id_unit'] = $id_unit;

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/list_aset_unit_area', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				
				// $this->load->view('js_script');

			}
			else {

				// inventory by category summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_area_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_area_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');

			}
		}
	}

	function datatables_unit_by_area()
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

		$id_unit = (isset($_GET['id_unit']))?($_GET['id_unit']):'0';
		$id_unit = ($id_unit == '') ? '0' : $id_unit;

		$id_status = (isset($_GET['id_status']))?($_GET['id_status']):'0';
		$id_status = ($id_status == '') ? '0' : $id_status;

		$klasifikasi_id = (isset($_GET['klasifikasi_id']))?($_GET['klasifikasi_id']):'0';
		$klasifikasi_id = ($klasifikasi_id == '') ? '0' : $klasifikasi_id;

		$id_lok = $this->uri->segment('3');

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
			$row[] = $aRow->klasifikasi;

			$tombol_list_set = '<i class="ui-tooltip fa fa-home" title="Lihat Aset" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Aset" onclick="list_aset_by_unit_area('."'".$aRow->id_lok."',"."'".$aRow->id."'".')"></i>&nbsp;
			<i class="ui-tooltip fa fa-male" title="Lihat Penghuni" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Penghuni" onclick="detail_penghuni('."'".$aRow->penghuni."',"."'".$aRow->id."',"."'".$aRow->id_lok."'".')"></i>';
	
			$row[] = $aRow->nama_lokasi . ', ' . $aRow->blok . ' ' . $aRow->no_unit;

			$row[] = $aRow->status_detail;

			if ($aRow->thumbnail != ''){

				$row[] = '<a href="' . base_url('assets/uploads/images/unit/') . $aRow->photo . '" data-fancybox data-caption="' . $aRow->nama_unit . '">
				<img src="' . base_url('assets/uploads/images/unit/') . $aRow->thumbnail . '" alt="' . $aRow->nama_unit . '">
				</a>';

			} else {
				$row[] = '';
			}

			$row[] = $aRow->alamat_lengkap;
			$row[] = $tombol_list_set;

			$page++;
			$output['aaData'][] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 
    
		echo json_encode($output);
		
	}

	function datatables_aset_by_unit_area()
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

		$id_lok = $this->uri->segment('3');
		$id_unit = $this->uri->segment('4');

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
			$row[] = $aRow->nama;
			$row[] = $aRow->bagian; 
			$row[] = $aRow->nomor_aset;

			$tombol_timeline = '<i class="ui-tooltip fa fa-book" title="Lihat Detil Aset" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Detil Aset" onclick="detail('."'".$aRow->id."'".')"></i>&nbsp;';
	
			$row[] = $aRow->kategori;
			$row[] = $aRow->merek;
			$row[] = $aRow->bahan; 
			$row[] = $aRow->jumlah;
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

	public function detail_penghuni($kode = '', $id_unit = '', $id_lok = '')
	{

		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
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
				
				$this->data['title']="Monitoring";
				$this->data['subtitle']=" Area / Unit / Penghuni";
				
				$this->data['tabletitle'] = '<small class="label label-info">' . 'Unit : ' . '-' . '</small>&nbsp;' .
				'<small class="label label-warning">' . 'Blok : ' . '-' . '</small>&nbsp;' . '<small class="label label-success">' . 'No. Unit : ' . '-' . '</small>';

				$this->data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Monitoring</a></li>
										<li><a href=\"" . site_url() . "inventory/by_area\">Area</a></li>
										<li><a href=\"" . site_url() . "inventory/by_unit/$id_lok\">Unit</a></li>
										<li class=\"active\">Penghuni</li>";

				$this->data['data_detail'] = $this->penghunis_model->get_penghuni_by_kode($kode);

				if (count($this->penghunis_model->get_penghuni_by_kode($kode)->result()) == 0){
					// if data kosong
					$goTo = site_url().'inventory/by_unit/'.$id_lok;
					echo $this->fungsi->warning('Data yang Anda cari tidak tersedia !!', $goTo);
				}

				$this->data['kode'] = $kode;
				$this->data['id_lok'] = $id_lok;
				$this->data['id_unit'] = $id_unit;

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/detail_penghuni', $this->data);
				$this->load->view('partials/_alte_footer');

				$this->load->view('inv_data/js');

			}
			else {

				// inventory by category summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_area_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_area_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');

			}

		}

	}

	public function detail_area($id = '')
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory/by_area', 'refresh');
		}
		// Logged in
		else{

			// If id_lok is provided, show data based on id_lok
			if ($id!="") {

				$data['username'] = $this->session->userdata('username');
				$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
				$data['nama_faskes'] = $this->session->userdata('nama_faskes');
				$data['email'] = $this->session->userdata('email');
				$data['address'] = $this->session->userdata('address');
				$data['phone'] = $this->session->userdata('phone');
				$data['level'] = $this->session->userdata('level');
				
				$this->data['title']="Area";
				$this->data['subtitle']=" Monitoring / Detail Area";
				
				$this->data['tabletitle'] = '<small class="label label-info">' . 'Unit : ' . '-' . '</small>&nbsp;' .
				'<small class="label label-warning">' . 'Blok : ' . '-' . '</small>&nbsp;' . '<small class="label label-success">' . 'No. Unit : ' . '-' . '</small>';

				$this->data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-map-pin\"></i> Monitoring</a></li>
										<li class=\"active\">Detail Area</li>";

				$this->data['data_detail'] = $this->locations_model->get_locations($id);

				if (count($this->locations_model->get_locations($id)->result()) == 0){
					// if data kosong
					$goTo = site_url().'inventory/by_area';
					echo $this->fungsi->warning('Data yang Anda cari tidak tersedia !!', $goTo);
				}

				$this->data['id'] = $id;

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors(): $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/detail_area', $this->data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				//$this->load->view('js_script');

			} else {
				redirect('inventory/by_area');
			}

		}
	}

	function load_dropdown_status()
	{
		
		$list_data = $this->units_model->get_status_unit();
		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['status_detail'] = $qryget['status_detail'];
			$ddata[] = $row;
		
		}

		$output = array(
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

}

/* End of Inventory.php */