<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Units model
*
*
*/
class Units_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->units_table	 		= 'unit';
		$this->areas_table			= 'lokasi_kerja';
		$this->users_table      	= 'users';
		$this->status_table     	= 'status';
		$this->penghunis_table  	= 'penghuni';
		$this->klasifikasis_table	= 'klasifikasi';
		$this->kondisi_rumdins_table= 'kondisi_rumdin';
		$this->loggedinuser     	= $this->ion_auth->user()->row();
	}

	function getlist_unit_by_area($aColumns, $sWhere, $sOrder, $top, $limit, $params)
    {

		$limit = " limit " . $top . ", ".$limit."";

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$klasifikasi_id = $params['klasifikasi_id'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){
		
				$ssql = "select unit.*, lokasi_kerja.nama_lokasi, status.status_detail, klasifikasi.klasifikasi from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id
						$sWhere and lokasi_kerja.id = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and unit.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and unit.status = '$id_status' ";
				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}
				
			} else {
			
				$ssql = "select unit.*, lokasi_kerja.nama_lokasi, status.status_detail, klasifikasi.klasifikasi from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status 
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id
						where lokasi_kerja.id = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and unit.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and unit.status = '$id_status' ";
				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}
	
			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select unit.*, lokasi_kerja.nama_lokasi, status.status_detail, klasifikasi.klasifikasi from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id $sWhere ";

				if ($id_unit != '0'){
					
					$ssql .= " and unit.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and unit.status = '$id_status' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " and unit.status = '$id_status' ";
					}

				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}

			} else {

				$ssql = "select unit.*, lokasi_kerja.nama_lokasi, status.status_detail, klasifikasi.klasifikasi from unit 
					join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
					left join status on status.id = unit.status
					left join klasifikasi on klasifikasi.id = unit.klasifikasi_id ";

				if ($id_unit != '0'){
					
					$ssql .= " where unit.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and unit.status = '$id_status' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " where unit.status = '$id_status' ";
					}

				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}

			}

		}

		if(isset($_POST['order'])) 
        {
            //$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$ssql = $ssql . $sOrder . $limit;
        } 
    	else // if(isset($this->order))
    	{
            //$order = $this->order;
            //$this->db->order_by(key($order), $order[key($order)]);
			$ssql = $ssql . 'order by id_lok asc, id asc, blok asc, no_unit asc' . $limit;
        }
		
		//echo $ssql;
        $query = $this->db->query($ssql);
		return $query;
		
    }

	function getlist_unit_by_area_total($sIndexColumn, $params)
	{

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$klasifikasi_id = $params['klasifikasi_id'];

		if ($id_lok != '0'){
			
			$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.status = lokasi_kerja.id
				left join status on status.id = unit.status 
				left join klasifikasi on klasifikasi.id = unit.klasifikasi_id
				where lokasi_kerja.id = '$id_lok'";

			if ($id_unit != '0'){
				$ssql .= " and unit.id = '$id_unit' ";
			}

			if ($id_status != '0'){
				$ssql .= " and unit.status = '$id_status' ";
			}

			if ($klasifikasi_id != '0'){
				$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
			}

		} else {

			$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.status = lokasi_kerja.id
				left join status on status.id = unit.status
				left join klasifikasi on klasifikasi.id = unit.klasifikasi_id";

			if ($id_unit != '0'){

				$ssql .= " where unit.id = '$id_unit' ";

				if ($id_status != '0'){
					$ssql .= " and unit.status = '$id_status' ";
				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}

			} else {

				if ($id_status != '0'){
					$ssql .= " where unit.status = '$id_status' ";
				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}

			}

		}

		$query = $this->db->query($ssql);
        return $query;
		
    }

	function getlist_unit_by_area_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params)
	{

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$klasifikasi_id = $params['klasifikasi_id'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(unit.id) as total_jml_data from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status 
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id
						$sWhere and lokasi_kerja.id = '$id_lok'";

				if ($id_unit != '0'){
					$ssql .= " and unit.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and unit.status = '$id_status' ";
				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}

			} else {		

				$ssql = "select count(unit.id) as total_jml_data from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id
						where lokasi_kerja.id = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and unit.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and unit.status = '$id_status' ";
				}

				if ($klasifikasi_id != '0'){
					$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
				}

			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(unit.id) as total_jml_data from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id $sWhere ";

				if ($id_unit != '0'){
					
					$ssql .= " and unit.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and unit.status = '$id_status' ";
					}

					if ($klasifikasi_id != '0'){
						$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " and unit.status = '$id_status' ";
					}

					if ($klasifikasi_id != '0'){
						$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
					}

				}

			} else {

				$ssql = "select count(unit.id) as total_jml_data from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status
						left join klasifikasi on klasifikasi.id = unit.klasifikasi_id ";

				if ($id_unit != '0'){
					
					$ssql .= " where unit.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and unit.status = '$id_status' ";
					}

					if ($klasifikasi_id != '0'){
						$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " where unit.status = '$id_status' ";
					}

					if ($klasifikasi_id != '0'){
						$ssql .= " and unit.klasifikasi_id = '$klasifikasi_id' ";
					}

				}

			}

		}

		$query = $this->db->query($ssql);
        return $query;
		
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
	public function get_unit_by_location($id_lok='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->units_table.".*, "
		);
		$this->db->from($this->units_table);

		// if id_lok provided
		if ($id_lok!='') {
			$this->db->where($this->units_table.'.id', $id_lok);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->units_table.'.id', $order_method);
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
	public function get_unit_by_id_unit($id_unit='',$limit='', $start='', $order_method='desc')
	{

		$this->db->select(
			$this->units_table.".*, ".
			$this->areas_table.".nama_lokasi, ".
			$this->status_table.".status_detail, ".
			$this->klasifikasis_table.".klasifikasi, ".
			$this->kondisi_rumdins_table.".kondisi as kondisi_rumdin "
		);

		$this->db->from($this->units_table);

		$this->db->join(
			$this->areas_table, 
			$this->areas_table.'.id = '.$this->units_table.'.id_lok',
			'left'
		);

		$this->db->join(
			$this->penghunis_table, 
			$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
			'left'
		);

		$this->db->join(
			$this->status_table, 
			$this->status_table.'.id = '.$this->units_table.'.status',
			'left'
		);

		$this->db->join(
			$this->klasifikasis_table, 
			$this->units_table.'.klasifikasi_id = '.$this->klasifikasis_table.'.id',
			'left'
		);

		$this->db->join(
			$this->kondisi_rumdins_table, 
			$this->units_table.'.kondisi = '.$this->kondisi_rumdins_table.'.id',
			'left'
		);

		// if id_lok provided
		if ($id_unit!='') {
			$this->db->where($this->units_table.'.id', $id_unit);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->units_table.'.id', $order_method);
		}

		$datas = $this->db->get();

		//echo $this->db->last_query();

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
	*	Update Unit
	*	from unit edit form
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
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('change_date', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->units_table, $datas)) {
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

	function get_status_unit()
	{
		
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('status');
		return $query->result_array();	
		
	}

	function get_nama_unit($id_lok)
	{
		
		$this->db->select(
			$this->units_table.".id, "."CONCAT(nama_lokasi, ', ', blok, ' ', no_unit) AS nama_unit "
		);

		$this->db->from($this->areas_table);
		$this->db->join(
			$this->units_table, 
			$this->areas_table.'.id = '.$this->units_table.'.id_lok',
			'left'
		);
		
		$this->db->where($this->units_table.'.id_lok', $id_lok);
		$this->db->order_by($this->units_table.'.id', 'ASC');
		$query = $this->db->get();
		return $query;	
		
	}

	function load_dropdown_wilayah()
    {
        $this->db->select('A.*');
        $this->db->from('wilayah as A');
        $data = $this->db->get();
        return $data->result_array();
    }

	function load_dropdown_kondisi()
    {
        $this->db->select('A.*');
        $this->db->from('kondisi_rumdin as A');
        $data = $this->db->get();
        return $data->result_array();
    }

	function load_dropdown_klasifikasi()
    {
        $this->db->select('A.*');
        $this->db->from('klasifikasi as A');
        $data = $this->db->get();
        return $data->result_array();
    }

	function getDataPenghuni($penghuni_id)
	{
		$this->db->select(
			$this->penghunis_table.".* "
		);
		$this->db->from($this->penghunis_table);
		$this->db->where($this->penghunis_table.'.id', $penghuni_id);
		$datas = $this->db->get();
		return $datas->result();
	}

	public function insert_data($datas)
	{
		// user and datetime
		//$datas['user_create'] = $this->loggedinuser->username;
		$datas['user_change'] = $this->loggedinuser->username;
		//$this->db->set('create_date', 'NOW()', FALSE);
		$this->db->set('change_date', 'NOW()', FALSE);

		if ($this->db->insert($this->units_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	public function update_aset_by_code($id_auto, $datas)
	{
		// user and datetime
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('change_date', 'NOW()', FALSE);

		$this->db->where('id', $id_auto);
		if($this->db->update($this->units_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	public function hapus_data($id)
	{

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 
	
		// hapus users
		$this->db->where('id', $id);
		$this->db->delete($this->units_table);
		
		$this->db->trans_complete(); # Completing transaction

		/*Optional*/

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.    			
			$this->db->trans_rollback();
    		return FALSE;
		} 
		else {
    		# Everything is Perfect. 
    		# Committing data to the database.
    		$this->db->trans_commit();
    		return TRUE;
		}

	}

}
// End of units model
