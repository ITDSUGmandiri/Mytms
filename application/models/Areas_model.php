<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Area model
*
*
*/
class Areas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->areas_table	 	= 'lokasi_kerja';
		$this->users_table      = 'users';
		$this->loggedinuser     = $this->ion_auth->user()->row();
	}

	/**
	*	Get Area
	*	from inv lokasi_kerja table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_areas($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->areas_table.".id, ".
			$this->areas_table.".code, ".
			$this->areas_table.".name, ".
			$this->areas_table.".description, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->areas_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->areas_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->areas_table.'.deleted', '0');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->areas_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->areas_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Categories by Code
	*	from inv categories table
	*	sort by id desc
	*
	*	@param 		string 		$code
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_area_by_id_lok($id_lok='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->areas_table.".*, "
		);
		$this->db->from($this->areas_table);

		// if id_lok provided
		if ($id_lok!='') {
			$this->db->where($this->areas_table.'.id', $id_lok);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->areas_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert category
	*	from category form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_category($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->areas_table, $datas)) {
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
	public function update_category($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->areas_table, $datas)) {
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
		$datas = $this->db->get($this->areas_table);

		return $datas;
	}

	/**
	* Name check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$name
	* @return 	array
	*
	*/
	public function name_check($name)
	{
		$this->db->where('name', trim($name));
		$datas = $this->db->get($this->areas_table);

		return $datas;
	}


}
// End of categories model
