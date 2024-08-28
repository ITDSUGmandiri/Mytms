<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Fasilitas model
*
*
*/
class Fasilitas_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->fasilitas_table 	= 'inv_fasilitas';
		$this->areas_table     	= 'lokasi_kerja';
		$this->users_table     	= 'users';
		$this->loggedinuser    	= $this->ion_auth->user()->row();
	}

	/**
	*	Get fasilitas
	*	from inv fasilitas table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_fasilitas($params=array(),$limit='', $start='', $order_method='desc')
	{

		$id = (isset($params['id_fasilitas'])?$params['id_fasilitas']:'');
		$q = (isset($params['q'])?$params['q']:'');
		$id_lok = (isset($params['id_lok'])?$params['id_lok']:'');

		$this->db->select(
			$this->areas_table.".nama_lokasi, ".
			$this->fasilitas_table.".*, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);

		$this->db->from($this->fasilitas_table);

		$this->db->join(
			$this->areas_table,
			$this->fasilitas_table.'.area_id = '.$this->areas_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->fasilitas_table.'.created_by = '.$this->users_table.'.username',
			'left');

		// if ID provided
		if ($id != '') {
			$this->db->where($this->fasilitas_table.'.id', $id);
		}

		// if search data
		if ($q != '') {
			$this->db->like($this->fasilitas_table.'.nama_fasilitas', $q);

		}

		// if filter by area_id
		if ($id_lok != '') {
			$this->db->where($this->fasilitas_table.'.area_id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->fasilitas_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;

	}

	public function get_area($order_method='asc')
	{

		$this->db->select(
			$this->areas_table.".* "
		);

		$this->db->from($this->areas_table);

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->areas_table.'.nama_lokasi', $order_method);
		}

		$datas = $this->db->get();
		return $datas;

	}

	/**
	*	Get Locations by Code
	*	from inv locations table
	*	sort by id desc
	*
	*	@param 		string 		$code
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_fasilitas_by_code($code='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->fasilitas_table.".id, ".
			$this->fasilitas_table.".code, ".
			$this->fasilitas_table.".name, ".
			$this->fasilitas_table.".detail, ".
			$this->fasilitas_table.".photo, ".
			$this->fasilitas_table.".thumbnail, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->fasilitas_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->fasilitas_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->fasilitas_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->fasilitas_table.'.code', $code);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->fasilitas_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert location
	*	from location form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_fasilitas($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;

		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->fasilitas_table, $datas)) {
			return TRUE;
		}

		return FALSE;

	}

	/**
	*	Update location
	*	from locations edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_fasilitas($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->fasilitas_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update location by code
	*	from locations edit form
	*	based on code
	*
	*	@param 		string 		$code
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_fasilitas_by_code($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->fasilitas_table, $datas)) {
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
		$datas = $this->db->get($this->fasilitas_table);

		return $datas;
	}

	/**
	* Nama fasilitas check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$name
	* @return 	array
	*
	*/
	public function nama_fasilitas_check($name)
	{
		$this->db->where('nama_fasilitas', trim($name));
		$datas = $this->db->get($this->fasilitas_table);

		return $datas;
	}

	function getcode_fasilitas($kode_area){

		//jangan lupa set region and setting ke asia/jakarta

		$id_faskes = str_pad((string)($kode_area), 4, "0", STR_PAD_LEFT);
		$yymm = date('y') . date('m');
		$str_format = $id_faskes . "-" . $yymm . "-";

		//$ssql = "select count(*) as jumlah from kaio_trx_antar_obat where order_id_ds like '%".date("Y-m")."%' order by id desc limit 1";
		$ssql = "select count(*) as jumlah from inv_fasilitas where code like '" . $str_format . "%' order by id desc limit 1";
		$query = $this->db2->query($ssql);

		if ($query->num_rows() > 0)
		{

			foreach($query->result() as $row) 
			{

				if (!isset($row->jumlah)){
					$str = $str_format . "0001";
				} else {
					$str = $str_format . str_pad((string)($row->jumlah+1), 4, "0", STR_PAD_LEFT);
				}

			}

		}

		return $str;

	}

	public function delete_data($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete($this->fasilitas_table)){
			return TRUE;
		}
			return FALSE;
	}

	public function get_fasilitas_by_area_summary()
	{
		
		$this->db->select(
			$this->fasilitas_table.".area_id, ".
			$this->areas_table.".kode, ".
			$this->areas_table.".nama_lokasi, ".
			"COUNT(".$this->fasilitas_table.".area_id) AS total"
		);

		$this->db->from($this->fasilitas_table);

		// join area table
		$this->db->join(
			$this->areas_table,
			$this->fasilitas_table.'.area_id = '.$this->areas_table.'.id',
			'left');

		$this->db->group_by($this->fasilitas_table.'.area_id');

		$datas = $this->db->get();
		return $datas;
	}

	function getlist_fasilitas_by_area($aColumns, $sWhere, $sOrder, $top, $limit, $params)
    {

		$limit = " limit " . $top . ", ".$limit."";

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = (isset($params['id_lok'])?$params['id_lok']:'0');
		$jenis_fasilitas = (isset($params['jenis_fasilitas'])?$params['jenis_fasilitas']:'0');

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){
		
				$ssql = "select inv_fasilitas.*, lokasi_kerja.nama_lokasi from inv_fasilitas 
						join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id 
						$sWhere and lokasi_kerja.id = '$id_lok' ";

				if ($jenis_fasilitas != '0'){
					$ssql .= " and inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
				}
				
			} else {
			
				$ssql = "select inv_fasilitas.*, lokasi_kerja.nama_lokasi from inv_fasilitas 
						join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id 
						where lokasi_kerja.id = '$id_lok' ";

				if ($jenis_fasilitas != '0'){
					$ssql .= " and inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
				}
	
			}

		} else {

			$ssql = "select inv_fasilitas.*, lokasi_kerja.nama_lokasi from inv_fasilitas 
					join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id";

			if ($jenis_fasilitas != '0'){
				$ssql .= " where inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
			}

		}

		$ssql = $ssql . $sOrder . $limit;
		
		//echo $ssql;
        $query = $this->db->query($ssql);
		return $query;
		
    }

	function getlist_fasilitas_by_area_total($sIndexColumn, $params)
	{

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = (isset($params['id_lok'])?$params['id_lok']:'0');
		$jenis_fasilitas = (isset($params['jenis_fasilitas'])?$params['jenis_fasilitas']:'0');

		if ($id_lok != '0'){
			
			$ssql = "select count(inv_fasilitas.id) as total_jml_data from inv_fasilitas 
				join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id
				where lokasi_kerja.id = '$id_lok'";

			if ($jenis_fasilitas != '0'){
				$ssql .= " and inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
			}

		} else {

			$ssql = "select count(inv_fasilitas.id) as total_jml_data from inv_fasilitas 
					join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id";

			if ($jenis_fasilitas != '0'){
				$ssql .= " where inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
			}

		}

		$query = $this->db->query($ssql);
        return $query;
		
    }

	function getlist_fasilitas_by_area_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params)
	{

		$id_lok = (isset($params['id_lok'])?$params['id_lok']:'0');
		$jenis_fasilitas = (isset($params['jenis_fasilitas'])?$params['jenis_fasilitas']:'0');

		if ($id_lok != ''){

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(inv_fasilitas.id) as total_jml_data from inv_fasilitas 
						join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id 
						$sWhere and lokasi_kerja.id = '$id_lok' ";

				if ($jenis_fasilitas != '0'){
					$ssql .= " and inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
				}

			} else {		

				$ssql = "select count(inv_fasilitas.id) as total_jml_data from inv_fasilitas 
						join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id 
						where lokasi_kerja.id = '$id_lok'";

				if ($jenis_fasilitas != '0'){
					$ssql .= " and inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
				}

			}

		} else {

			$ssql = "select count(inv_fasilitas.id) as total_jml_data from inv_fasilitas 
					join lokasi_kerja on inv_fasilitas.area_id = lokasi_kerja.id";

			if ($jenis_fasilitas != '0'){
				$ssql .= " where inv_fasilitas.jenis_fasilitas = '$jenis_fasilitas' ";
			}

		}

		$query = $this->db->query($ssql);
        return $query;
		
    }

}
// End of fasilitas model