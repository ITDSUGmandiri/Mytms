<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penghunis_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->areas_table		= 'lokasi_kerja';
		$this->units_table		= 'unit';
		$this->penghunis_table	= 'penghuni';
		$this->users_table      = 'users';
		$this->loggedinuser     = $this->ion_auth->user()->row();
	}

	function getlist_penghuni_byid($id){

		$this->db->select(
			$this->penghunis_table.".*, "
		);

		$this->db->from($this->penghunis_table);
		$this->db->where('id', $id);

		$query = $this->db->get();

		//echo $this->db->last_query();
		//die;

		return $query;

	}

	function getlist_penghuni($aColumns, $sWhere, $sOrder, $top, $limit, $params)
    {

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){
		
				$this->db->select(
					$this->penghunis_table.".*, ".
					$this->areas_table.".nama_lokasi, ".
					"CONCAT(nama_unit, ', ', blok, ' ', no_unit) as nama_unit "
				);

				$this->db->from($this->penghunis_table);

				$this->db->join(
					$this->units_table, 
					$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
					'left'
				);

				$this->db->join(
					$this->areas_table, 
					$this->areas_table.'.id = '.$this->units_table.'.id_lok',
					'left'
				);

				$this->db->where($this->areas_table.'.id', $id_lok);

				if ($id_unit != '0'){
					$this->db->where($this->units_table.'.id', $id_unit);
				}

				$this->db->where($sWhere, NULL, FALSE);

			} else {
			
				/*
				$ssql = "select unit.*, lokasi_kerja.nama_lokasi, status.status_detail from unit 
						join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
						left join status on status.id = unit.status 
						where lokasi_kerja.id = '$id_lok' ";
				*/

				$this->db->select(
					$this->penghunis_table.".*, ".
					$this->areas_table.".nama_lokasi, ".
					"CONCAT(nama_unit, ', ', blok, ' ', no_unit) as nama_unit "
				);

				$this->db->from($this->penghunis_table);

				$this->db->join(
					$this->units_table, 
					$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
					'left'
				);

				$this->db->join(
					$this->areas_table, 
					$this->areas_table.'.id = '.$this->units_table.'.id_lok',
					'left'
				);

				$this->db->where($this->areas_table.'.id', $id_lok);

				if ($id_unit != '0'){
					$this->db->where($this->units_table.'.id', $id_unit);
				}
	
			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$this->db->select(
					$this->penghunis_table.".*, ".
					$this->areas_table.".nama_lokasi, ".
					"CONCAT(nama_unit, ', ', blok, ' ', no_unit) as nama_unit "
				);
	
				$this->db->from($this->penghunis_table);
	
				$this->db->join(
					$this->units_table, 
					$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
					'left'
				);
	
				$this->db->join(
					$this->areas_table, 
					$this->areas_table.'.id = '.$this->units_table.'.id_lok',
					'left'
				);

				//$this->db->where($this->penghunis_table.'.id IS NOT NULL');

				$string_pencarian = trim(substr($sWhere, 6, strpos($sWhere, ')')));
				$this->db->where($string_pencarian, NULL, FALSE);

			} else {

				$this->db->select(
					$this->penghunis_table.".*, ".
					$this->areas_table.".nama_lokasi, ".
					"CONCAT(nama_unit, ', ', blok, ' ', no_unit) as nama_unit "
				);
	
				$this->db->from($this->penghunis_table);
	
				$this->db->join(
					$this->units_table, 
					$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
					'left'
				);
	
				$this->db->join(
					$this->areas_table, 
					$this->areas_table.'.id = '.$this->units_table.'.id_lok',
					'left'
				);

			}

		}

		//$limit = " limit " . $top . ", ".$limit."";
		//$ssql = $ssql . $sOrder . $limit;
		//$this->db->order_by('NULL', '', false);
		//$this->db->order_by($sOrder, '', false);

		$this->db->limit($limit, $top);

        //$query = $this->db->query($ssql);
		$query = $this->db->get();
		//echo $query;

		//echo $this->db->last_query();
		//die;

		return $query;
		
    }

	function getlist_penghuni_total($sIndexColumn, $params)
	{

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];

		if ($id_lok != '0'){
			
			/*
			$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.status = lokasi_kerja.id
				left join status on status.id = unit.status where lokasi_kerja.id = '$id_lok'";
			*/

			//$this->db->select('COUNT(*) as count');

			$this->db->select(
				"COUNT(".$this->penghunis_table.".id) as total_jml_data "
			);

			$this->db->from($this->penghunis_table);

			$this->db->join(
				$this->units_table, 
				$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
				'left'
			);

			$this->db->join(
				$this->areas_table, 
				$this->areas_table.'.id = '.$this->units_table.'.id_lok',
				'left'
			);

			$this->db->where($this->areas_table.'.id', $id_lok);

			if ($id_unit != '0'){
				$this->db->where($this->units_table.'.id', $id_unit);
			}

		} else {

			/*
			$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.status = lokasi_kerja.id
				left join status on status.id = unit.status";
			*/

			$this->db->select(
				"COUNT(".$this->penghunis_table.".id) as total_jml_data "
			);

			$this->db->from($this->penghunis_table);

			$this->db->join(
				$this->units_table, 
				$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
				'left'
			);

			$this->db->join(
				$this->areas_table, 
				$this->areas_table.'.id = '.$this->units_table.'.id_lok',
				'left'
			);

			$this->db->where($this->areas_table.'.id', $id_lok);

		}

		//$query = $this->db->query($ssql);
		$query = $this->db->get();
        return $query;
		
    }

	function getlist_penghuni_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params)
	{

		$id_lok = $params['id_lok'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){

				/*
				$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
				left join status on status.id = unit.status 
				where lokasi_kerja.id = '$id_lok' $sWhere";
				*/

				$this->db->select(
					"COUNT(".$this->penghunis_table.".id) as total_jml_data "
				);

				$this->db->from($this->penghunis_table);

				$this->db->join(
					$this->units_table, 
					$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
					'left'
				);

				$this->db->join(
					$this->areas_table, 
					$this->areas_table.'.id = '.$this->units_table.'.id_lok',
					'left'
				);

				$this->db->where($this->areas_table.'.id', $id_lok);

				if ($id_unit != '0'){
					$this->db->where($this->units_table.'.id', $id_unit);
				}

				$this->db->where($sWhere, NULL, FALSE);

			} else {		

				/*
				$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
				left join status on status.id = unit.status
				where lokasi_kerja.id = '$id_lok' ";
				*/

				$this->db->select(
					"COUNT(".$this->penghunis_table.".id) as total_jml_data "
				);

				$this->db->from($this->penghunis_table);

				$this->db->join(
					$this->units_table, 
					$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
					'left'
				);

				$this->db->join(
					$this->areas_table, 
					$this->areas_table.'.id = '.$this->units_table.'.id_lok',
					'left'
				);

				$this->db->where($this->areas_table.'.id', $id_lok);

				if ($id_unit != '0'){
					$this->db->where($this->units_table.'.id', $id_unit);
				}

			}

		} else {

			/*
			$ssql = "select count(unit.id) as total_jml_data from unit 
				join lokasi_kerja on unit.id_lok = lokasi_kerja.id 
				left join status on status.id = unit.status ";
			*/

			$this->db->select(
				"COUNT(".$this->penghunis_table.".id) as total_jml_data "
			);

			$this->db->from($this->penghunis_table);

			$this->db->join(
				$this->units_table, 
				$this->penghunis_table.'.id = '.$this->units_table.'.penghuni_id',
				'left'
			);

			$this->db->join(
				$this->areas_table, 
				$this->areas_table.'.id = '.$this->units_table.'.id_lok',
				'left'
			);

		}

		//$query = $this->db->query($ssql);
		$query = $this->db->get();
        return $query;
		
    }

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

	public function get_penghuni_by_kode($kode='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->penghunis_table.".*, "
		);

		$this->db->from($this->penghunis_table);

		// if kode provided
		if ($kode!='') {
			$this->db->where($this->penghunis_table.'.kode', $kode);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->penghunis_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	public function code_check($code)
	{
		$this->db->where('code', trim($code));
		$datas = $this->db->get($this->areas_table);

		return $datas;
	}

	public function name_check($name)
	{
		$this->db->where('name', trim($name));
		$datas = $this->db->get($this->areas_table);

		return $datas;
	}

	function load_dropdown_penghuni()
	{
		
		$this->db->order_by('nama', 'ASC');
		$query = $this->db->get('penghuni');
		return $query->result_array();	
		
	}

	public function insert_data($datas)
	{
		// user and datetime
		//$datas['user_create'] = $this->loggedinuser->username;
		$datas['user_change'] = $this->loggedinuser->username;
		//$this->db->set('create_date', 'NOW()', FALSE);
		$this->db->set('change_date', 'NOW()', FALSE);

		if ($this->db->insert($this->penghunis_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	public function update_penghuni_by_code($id_auto, $datas)
	{
		// user and datetime
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('change_date', 'NOW()', FALSE);

		$this->db->where('id', $id_auto);
		if($this->db->update($this->penghunis_table, $datas)) {
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
		$this->db->delete($this->penghunis_table);
		
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

	public function update_data($id, $datas)
	{
		// user and datetime
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('change_date', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->penghunis_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

}
// End of penghunis model
