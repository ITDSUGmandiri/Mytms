<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Inventory model
*
*/
class Inventory_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->areas_table      = 'lokasi_kerja';
		$this->units_table      = 'unit';
		$this->datas_table      = 'aset';
		$this->categories_table = 'inv_categories';
		$this->locations_table  = 'lokasi_kerja';
		$this->status_table     = 'inv_status';
		$this->users_table      = 'users';
		$this->loggedinuser     = $this->ion_auth->user()->row();
	}

	/**
	*	Get Inventory
	*	from inv inv_datas table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory($id='',$limit='', $start='')
	{
		$this->db->select(
			$this->datas_table.".id, ".
			$this->datas_table.".nomor_aset, ".
			$this->datas_table.".merek, ".
			$this->datas_table.".model, ".
			$this->datas_table.".serial_number, ".
			$this->datas_table.".status, ".
			$this->datas_table.".color, ".
			$this->datas_table.".length, ".
			$this->datas_table.".width, ".
			$this->datas_table.".height, ".
			$this->datas_table.".weight, ".
			$this->datas_table.".harga_beli, ".
			$this->datas_table.".tgl_beli, ".
			$this->datas_table.".photo, ".
			$this->datas_table.".thumbnail, ".
			$this->datas_table.".deskripsi, ".
			$this->datas_table.".category_id, ".
			$this->categories_table.".name AS category_name, ".
			$this->datas_table.".id_area, ".
			$this->locations_table.".nama_lokasi, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->categories_table,
			$this->datas_table.'.category_id = '.$this->categories_table.'.id',
			'left');

		// join locations table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.id_area = '.$this->locations_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->datas_table.'.user_create = '.$this->users_table.'.username',
			'left');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->datas_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		$this->db->order_by($this->datas_table.'.id', 'desc');
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by inventory code
	*	from inv inv_datas table
	*
	*	@param 		string 		$code
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_code($code='',$limit='', $start='')
	{
		$this->db->select(
			$this->datas_table.".id, ".
			$this->datas_table.".id_area, ".
			$this->datas_table.".id_unit, ".
			$this->datas_table.".nama as nama_aset, ".
			$this->datas_table.".bagian, ".
			$this->datas_table.".nomor_aset, ".
			$this->datas_table.".merek, ".
			$this->datas_table.".model, ".
			$this->datas_table.".bahan, ".
			$this->datas_table.".serial_number, ".
			$this->datas_table.".status, ".
			$this->status_table.".name AS status_name, ".
			$this->datas_table.".color, ".
			$this->datas_table.".length, ".
			$this->datas_table.".width, ".
			$this->datas_table.".height, ".
			$this->datas_table.".weight, ".
			$this->datas_table.".harga_beli, ".
			$this->datas_table.".tgl_beli, ".
			$this->datas_table.".photo, ".
			$this->datas_table.".thumbnail, ".
			$this->datas_table.".deskripsi, ".
			$this->datas_table.".category_id, ".
			$this->categories_table.".name AS category_name, ".
			$this->datas_table.".id_area, ".
			$this->locations_table.".nama_lokasi, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name, ".
			$this->units_table.".nama_unit"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->categories_table,
			$this->datas_table.'.category_id = '.$this->categories_table.'.id',
			'left');

		// join locations table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.id_area = '.$this->locations_table.'.id',
			'left');

		// join locations table
		$this->db->join(
			$this->units_table,
			$this->units_table.'.id_lok = '.$this->locations_table.'.id',
			'left');

		// join status table
		$this->db->join(
			$this->status_table,
			$this->datas_table.'.status_aset = '.$this->status_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->datas_table.'.user_create = '.$this->users_table.'.username',
			'left');

		// if code provided
		if ($code!='') {
			$this->db->where($this->datas_table.'.id', $code);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		$this->db->order_by($this->datas_table.'.id', 'desc');
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by category code
	*	from inv inv_datas table
	*
	*	@param 		string 		$code
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_category_code($code='',$limit='', $start='')
	{
		$this->db->select(
			$this->datas_table.".id, ".
			$this->datas_table.".no_aset, ".
			$this->datas_table.".brand, ".
			$this->datas_table.".model, ".
			$this->datas_table.".serial_number, ".
			$this->datas_table.".status, ".
			$this->datas_table.".color, ".
			$this->datas_table.".length, ".
			$this->datas_table.".width, ".
			$this->datas_table.".height, ".
			$this->datas_table.".weight, ".
			$this->datas_table.".price, ".
			$this->datas_table.".date_of_purchase, ".
			$this->datas_table.".photo, ".
			$this->datas_table.".thumbnail, ".
			$this->datas_table.".description, ".
			$this->datas_table.".deleted, ".
			$this->datas_table.".category_id, ".
			$this->categories_table.".name AS category_name, ".
			$this->datas_table.".location_id, ".
			$this->locations_table.".name AS location_name, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->categories_table,
			$this->datas_table.'.category_id = '.$this->categories_table.'.id',
			'left');

		// join locations table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.location_id = '.$this->locations_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->datas_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->datas_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->categories_table.'.code', $code);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		$this->db->order_by($this->datas_table.'.id', 'desc');
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by area code
	*	from inv unit table
	*
	*	@param 		string 		$code
	*	@return 	array 		$datas
	*
	*/
	public function get_unit_by_id_lok($id_lok='',$limit='', $start='')
	{
		$this->db->select(
			$this->units_table.".*, ".
			$this->areas_table.".nama_lokasi, "
		);

		$this->db->from($this->units_table);

		// join categories table
		$this->db->join(
			$this->areas_table,
			$this->units_table.'.id_lok = '.$this->areas_table.'.id',
			'left');

		// if code provided
		if ($id_lok!='') {
			$this->db->where($this->areas_table.'.id', $id_lok);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		$this->db->order_by($this->units_table.'.nama_unit', 'asc');
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by location code
	*	from inv inv_datas table
	*
	*	@param 		string 		$code
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_location_code($code='',$limit='', $start='')
	{
		$this->db->select(
			$this->datas_table.".id, ".
			$this->datas_table.".code, ".
			$this->datas_table.".brand, ".
			$this->datas_table.".model, ".
			$this->datas_table.".serial_number, ".
			$this->datas_table.".status, ".
			$this->datas_table.".color, ".
			$this->datas_table.".length, ".
			$this->datas_table.".width, ".
			$this->datas_table.".height, ".
			$this->datas_table.".weight, ".
			$this->datas_table.".price, ".
			$this->datas_table.".date_of_purchase, ".
			$this->datas_table.".photo, ".
			$this->datas_table.".thumbnail, ".
			$this->datas_table.".description, ".
			$this->datas_table.".deleted, ".
			$this->datas_table.".category_id, ".
			$this->categories_table.".name AS category_name, ".
			$this->datas_table.".location_id, ".
			$this->locations_table.".name AS location_name, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->categories_table,
			$this->datas_table.'.category_id = '.$this->categories_table.'.id',
			'left');

		// join locations table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.location_id = '.$this->locations_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->datas_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->datas_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->locations_table.'.code', $code);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		$this->db->order_by($this->datas_table.'.id', 'desc');
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by category summary
	*	from inv inv_datas table
	*
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_category_summary()
	{
		$this->db->select(
			$this->datas_table.".category_id, ".
			$this->categories_table.".code, ".
			$this->categories_table.".name, ".
			"COUNT(".$this->datas_table.".category_id) AS total"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->categories_table,
			$this->datas_table.'.category_id = '.$this->categories_table.'.id',
			'left');

		$this->db->group_by($this->datas_table.'.category_id');

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by location summary
	*	from inv inv_datas table
	*
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_location_summary()
	{
		$this->db->select(
			$this->datas_table.".location_id, ".
			$this->locations_table.".code, ".
			$this->locations_table.".name, ".
			"COUNT(".$this->datas_table.".location_id) AS total"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.location_id = '.$this->locations_table.'.id',
			'left');

		$this->db->where($this->datas_table.'.deleted', '0');

		$this->db->group_by($this->datas_table.'.location_id');

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Inventory by keyword and filters provided via
	* input form. From inv inv_datas table
	*
	*	@param 		string 		$keyword
	*	@param 		array 		$filters
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_keyword($keyword, $filters)
	{
		$this->db->select(
			$this->datas_table.".id, ".
			$this->datas_table.".nomor_aset, ".
			$this->datas_table.".nama, ".
			$this->datas_table.".merek, ".
			$this->datas_table.".model, ".
			$this->datas_table.".serial_number, ".
			//$this->datas_table.".status, ".
			$this->status_table.".name AS status_name, ".
			$this->datas_table.".color, ".
			$this->datas_table.".length, ".
			$this->datas_table.".width, ".
			$this->datas_table.".height, ".
			$this->datas_table.".weight, ".
			$this->datas_table.".harga_beli, ".
			$this->datas_table.".tgl_beli, ".
			$this->datas_table.".photo, ".
			$this->datas_table.".thumbnail, ".
			$this->datas_table.".deskripsi, ".
			$this->datas_table.".category_id, ".
			$this->categories_table.".name AS category_name, ".
			$this->datas_table.".id_area, ".
			$this->locations_table.".nama_lokasi, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->datas_table);

		// join categories table
		$this->db->join(
			$this->categories_table,
			$this->datas_table.'.category_id = '.$this->categories_table.'.id',
			'left');

		// join locations table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.id_area = '.$this->locations_table.'.id',
			'left');

		// join status table
		$this->db->join(
			$this->status_table,
			$this->datas_table.'.status_aset = '.$this->status_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->datas_table.'.user_create = '.$this->users_table.'.username',
			'left');

		// Keyword
		$this->db->like($this->datas_table.'.nomor_aset', $keyword);
		$this->db->or_like('nama', $keyword);
		$this->db->or_like('merek', $keyword);
		$this->db->or_like('model', $keyword);
		$this->db->or_like('serial_number', $keyword);

		// Filters
		foreach ($filters as $key => $value) {
			if ($value!="") {
				$this->db->where_in($key, $value);
			}
		}

		$this->db->order_by($this->datas_table.'.id', 'desc');
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert datas
	*	from datas form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_data($datas)
	{
		// user and datetime
		$datas['user_create'] = $this->loggedinuser->username;
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('create_date', 'NOW()', FALSE);
		$this->db->set('change_date', 'NOW()', FALSE);

		if ($this->db->insert($this->datas_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Category
	*	from categories edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_data($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->categories_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	* Code check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$code
	* @return 	array
	*
	*/
	public function code_check($code)
	{
		$this->db->where('code', trim($code));
		$datas = $this->db->get($this->datas_table);

		return $datas;
	}

	/**
	* SN check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$sn
	* @return 	array
	*
	*/
	public function sn_check($sn)
	{
		$this->db->where('serial_number', trim($sn));
		$datas = $this->db->get($this->datas_table);

		return $datas;
	}


	/**
	*	Get brands
	*	from inv inv_datas table
	*
	*	@return 	array 		$datas
	*
	*/
	public function get_brands()
	{
		$this->db->select(
			"DISTINCT(".$this->datas_table.".merek) "
		);
		$this->db->from($this->datas_table);
		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Update inventory by code
	*	from inventory new form
	*	based on code
	*
	*	@param 		string 		$code
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_inventory_by_code($code, $datas)
	{
		// user and datetime
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('change_date', 'NOW()', FALSE);

		$this->db->where('id', $code);
		if($this->db->update($this->datas_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Get Inventory by area summary
	*	from inv inv_datas table
	*
	*	@return 	array 		$datas
	*
	*/
	public function get_inventory_by_area_summary()
	{
		
		$this->db->select(
			$this->units_table.".id_lok, ".
			$this->areas_table.".kode, ".
			$this->areas_table.".nama_lokasi, ".
			"COUNT(".$this->units_table.".id_lok) AS total"
		);

		$this->db->from($this->units_table);

		// join area table
		$this->db->join(
			$this->areas_table,
			$this->units_table.'.id_lok = '.$this->areas_table.'.id',
			'left');

		$this->db->group_by($this->units_table.'.id_lok');

		$datas = $this->db->get();
		return $datas;
	}

}

// End of inventory model