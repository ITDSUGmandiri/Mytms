<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Units model
*
*
*/
class Tickets_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->units_table	 		= 'unit';
		$this->areas_table			= 'lokasi_kerja';
		$this->users_table      	= 'users';
		$this->old_user_table		= 'user';
		$this->status_table     	= 'status';
		$this->penghunis_table  	= 'penghuni';
		$this->klasifikasis_table	= 'klasifikasi';
		$this->kondisi_rumdins_table= 'kondisi_rumdin';
		$this->loggedinuser     	= $this->ion_auth->user()->row();
		$this->schedule_job_table 	= 'schedule_job';
		$this->type_incident_table 	= 'type_incident';
		$this->divisi_table 		= 'divisi';
		$this->status_progres_table = 'status_progres';
		$this->users_groups_table 	= 'users_groups';
		$this->serviceFamilyTable	= 'service_family';
	}

	
	/**
	*	Get username by new user id
	*
	*	@param 		string 		$new_user_id
	*	@return 	string 		$username
	*
	*/

	function getUsersTableById($id)
	{
		$this->db->select(
			$this->users_table.".* "
		);

		$this->db->from($this->users_table);

		$this->db->where('id', $id);

		return $this->db->get()->row();
	}

	function getOldUserTable($username)
	{
		$this->db->select(
			$this->old_user_table.".* "
		);

		$this->db->from($this->old_user_table);

		$this->db->where('user_id', $username);

		$q = $this->db->get();

		return $q;
	}

	function get_area($order_method='asc')
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

	function getServiceFamily($order_method='asc')
	{

		$this->db->select(
			$this->serviceFamilyTable.".* "
		);

		$this->db->from($this->serviceFamilyTable);

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->serviceFamilyTable.'.service_family_name', $order_method);
		}

		$datas = $this->db->get();
		return $datas;

	}

	function load_dropdown_type_incident($service_family_id)
	{
		$this->db->order_by('type', 'ASC');
		$this->db->where('service_family_id', $service_family_id);
		$query = $this->db->get('type_incident');
		return $query;	
	}

	function load_dropdown_petugas()
	{
		$this->db->order_by('first_name', 'ASC');
		$this->db->where('user_type_id', 6);
		$query = $this->db->get('users');
		return $query->result_array();	
	}

	function getListTicket($aColumns, $sWhere, $sOrder, $top, $limit, $params)
    {

		$limit = " limit " . $top . ", ".$limit."";

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$type_incident_id = $params['type_incident_id'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select A.*,B.username as name_pic, C.divisi,D.desc_status,F.username as name_pic1,G.username as name_pic2,E.nama_unit,E.blok,E.no_unit,H.type as type_name,I.service_family_name
						from schedule_job as A
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						left join type_incident as H on H.id = A.type_problem 
						left join service_family as I on I.id_service_family = A.service_family_id
						$sWhere and A.id_area = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and E.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and A.status = '$id_status' ";
				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}
				
			} else {
			
				$ssql = "select A.*,B.username as name_pic, C.divisi,D.desc_status,F.username as name_pic1,G.username as name_pic2,E.nama_unit,E.blok,E.no_unit,H.type as type_name,I.service_family_name
						from schedule_job as A
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						left join type_incident as H on H.id = A.type_problem 
						left join service_family as I on I.id_service_family = A.service_family_id
						where A.id_area = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and E.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and A.status = '$id_status' ";
				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}
	
			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select A.*,B.username as name_pic, C.divisi,D.desc_status,F.username as name_pic1,G.username as name_pic2,E.nama_unit,E.blok,E.no_unit,H.type as type_name,I.service_family_name
						from schedule_job as A
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						left join type_incident as H on H.id = A.type_problem 
						left join service_family as I on I.id_service_family = A.service_family_id
						$sWhere ";

				if ($id_unit != '0'){
					
					$ssql .= " and E.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and A.status = '$id_status' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " and A.status = '$id_status' ";
					}

				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}

			} else {

				$ssql = "select A.*,B.username as name_pic, C.divisi,D.desc_status,F.username as name_pic1,G.username as name_pic2,E.nama_unit,E.blok,E.no_unit,H.type as type_name,I.service_family_name
						from schedule_job as A
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						left join type_incident as H on H.id = A.type_problem
						left join service_family as I on I.id_service_family = A.service_family_id ";

				if ($id_unit != '0'){
					
					$ssql .= " where E.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and A.status = '$id_status' ";
					}

					if ($type_incident_id != '0'){
						$ssql .= " and A.type_problem = '$type_incident_id' ";
					}

				} else {

					if ($id_status != '0'){

						$ssql .= " where A.status = '$id_status' ";

						if ($type_incident_id != '0'){
							$ssql .= " and A.type_problem = '$type_incident_id' ";
						}

					}

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

	function getListTicketTotal($sIndexColumn, $params)
	{

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$type_incident_id = $params['type_incident_id'];

		if ($id_lok != '0'){

			$ssql = "select count(A.id) as total_jml_data 
					from schedule_job as A 
					join user as B on B.user_id = A.user_create
					left join divisi as C on A.divisi_id = C.id
					left join status_progres as D on D.id = A.status
					left join unit as E on E.id = A.id_unit
					left join user as F on F.user_id = A.pic
					left join user as G on G.user_id = A.pic1
					join type_incident as H on H.id = A.type_problem
					left join service_family as I on I.id_service_family = A.service_family_id
					where A.id_area = '$id_lok' ";

			if ($id_unit != '0'){
				$ssql .= " and E.id = '$id_unit' ";
			}

			if ($id_status != '0'){
				$ssql .= " and A.status = '$id_status' ";
			}

			if ($type_incident_id != '0'){
				$ssql .= " and A.type_problem = '$type_incident_id' ";
			}

		} else {

			$ssql = "select count(A.id) as total_jml_data 
					from schedule_job as A 
					join user as B on B.user_id = A.user_create
					left join divisi as C on A.divisi_id = C.id
					left join status_progres as D on D.id = A.status
					left join unit as E on E.id = A.id_unit
					left join user as F on F.user_id = A.pic
					left join user as G on G.user_id = A.pic1
					join type_incident as H on H.id = A.type_problem
					left join service_family as I on I.id_service_family = A.service_family_id";

			if ($id_unit != '0'){

				$ssql .= " where E.id = '$id_unit' ";

				if ($id_status != '0'){
					$ssql .= " and A.status = '$id_status' ";
				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}

			} else {

				if ($id_status != '0'){
					$ssql .= " where A.status = '$id_status' ";
				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}

			}

		}

		$query = $this->db->query($ssql);
        return $query;
		
    }

	function getListTicketFilteredTotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params)
	{

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$type_incident_id = $params['type_incident_id'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(A.id) as total_jml_data 
						from schedule_job as A 
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						join type_incident as H on H.id = A.type_problem
						left join service_family as I on I.id_service_family = A.service_family_id
						$sWhere and A.id_area = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and E.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and A.status = '$id_status' ";
				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}

			} else {		

				$ssql = "select count(A.id) as total_jml_data 
						from schedule_job as A 
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						join type_incident as H on H.id = A.type_problem
						left join service_family as I on I.id_service_family = A.service_family_id
						where A.id_area = '$id_lok' ";

				if ($id_unit != '0'){
					$ssql .= " and E.id = '$id_unit' ";
				}

				if ($id_status != '0'){
					$ssql .= " and A.status = '$id_status' ";
				}

				if ($type_incident_id != '0'){
					$ssql .= " and A.type_problem = '$type_incident_id' ";
				}

			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(A.id) as total_jml_data 
						from schedule_job as A 
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						join type_incident as H on H.id = A.type_problem
						left join service_family as I on I.id_service_family = A.service_family_id
						$sWhere ";

				if ($id_unit != '0'){
					
					$ssql .= " and E.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and A.status = '$id_status' ";
					}

					if ($type_incident_id != '0'){
						$ssql .= " and A.type_problem = '$type_incident_id' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " and A.status = '$id_status' ";
					}

					if ($type_incident_id != '0'){
						$ssql .= " and A.type_problem = '$type_incident_id' ";
					}

				}

			} else {

				$ssql = "select count(A.id) as total_jml_data 
						from schedule_job as A 
						join user as B on B.user_id = A.user_create
						left join divisi as C on A.divisi_id = C.id
						left join status_progres as D on D.id = A.status
						left join unit as E on E.id = A.id_unit
						left join user as F on F.user_id = A.pic
						left join user as G on G.user_id = A.pic1
						join type_incident as H on H.id = A.type_problem
						left join service_family as I on I.id_service_family = A.service_family_id ";

				if ($id_unit != '0'){
					
					$ssql .= " where E.id = '$id_unit' ";

					if ($id_status != '0'){
						$ssql .= " and A.status = '$id_status' ";
					}

					if ($type_incident_id != '0'){
						$ssql .= " and A.type_problem = '$type_incident_id' ";
					}

				} else {

					if ($id_status != '0'){
						$ssql .= " where A.status = '$id_status' ";
					}	

					if ($type_incident_id != '0'){
						$ssql .= " and A.type_problem = '$type_incident_id' ";
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
	function get_areas($id='',$limit='', $start='', $order_method='desc')
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
	function get_unit_by_location($id_lok='',$limit='', $start='', $order_method='desc')
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
	*	Get Tickets by id
	*	from schedule_job table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	function get_ticket_by_id($id='',$limit='', $start='', $order_method='desc')
	{

		$this->db->select('
			A.*,
			B.username as name_pic,
			C.divisi,
			D.desc_status,
			F.username as name_pic1,
			G.username as name_pic2,
			E.nama_unit,
			E.blok,
			E.no_unit,
			H.type as type_name
		', false);
		
		$this->db->from($this->schedule_job_table.' as A');
		$this->db->join($this->old_user_table.' as B', 'B.user_id = A.user_create', 'left');
		$this->db->join($this->divisi_table.' as C', 'A.divisi_id = C.id', 'left');
		$this->db->join($this->status_progres_table.' as D', 'D.id = A.status', 'left');
		$this->db->join($this->units_table.' as E', 'E.id = A.id_unit', 'left');
		$this->db->join($this->old_user_table.' as F', 'F.user_id = A.pic', 'left');
		$this->db->join($this->old_user_table.' as G', 'G.user_id = A.pic1', 'left');
		$this->db->join($this->type_incident_table.' as H', 'H.id = A.type_problem', 'left');

		// if id provided
		if ($id!='') {
			$this->db->where('A.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by('A.id', $order_method);
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
	function insert_category($datas)
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
	function update_data($id, $datas)
	{
		$this->db->where('id', $id);
		if($this->db->update($this->schedule_job_table, $datas)) {
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
	function code_check($code)
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
	function name_check($name)
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

	function insert_data($datas)
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

	function update_aset_by_code($id_auto, $datas)
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

	function hapus_data($id)
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

	function tambahComment($data){

        $this->db->insert('log_task', $data);
        
		if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }
            
	}

	function get_status_ticket()
	{
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('status_progres');
		return $query->result_array();	
	}

	function getDetailTicket($dec)        
    {
                
        $this->db->select("A.*,B.username as name_pic,B1.username as name_pic1,B2.username as name_pic_complete,C.nama_unit, C.blok,C.no_unit,D.desc_status,E.username as name_author,F.nama_lokasi,G.type as type_problem, H.service_family_name");
        $this->db->from('schedule_job as A');
        $this->db->join('user as B', 'B.user_id = A.pic ','LEFT');
        $this->db->join('user as B1', 'B1.user_id = A.pic1 ','LEFT');          
        $this->db->join('user as B2', 'B2.user_id = A.pic_complete','LEFT');
        $this->db->join('unit as C', 'C.id = A.id_unit ','LEFT');
        $this->db->join('status_progres as D', 'D.id = A.status ','LEFT');
        $this->db->join('user as E', 'E.user_id = A.user_create ','LEFT');
        $this->db->join('lokasi_kerja as F', 'F.id = A.id_area ','LEFT');
		$this->db->join('type_incident as G', 'G.id = A.type_problem ','LEFT');
		$this->db->join('service_family as H', 'H.id_service_family = A.service_family_id ','LEFT');
        //$this->db->join('(select incident_id,sum(biaya) as total_perbaikan from biaya_perbaikan) as G', 'G.incident_id = A.id ','LEFT');
        $this->db->where('A.id',$dec);
        $this->db->limit(1);
                
        return $this->db->get();
					
	}

	function getLogTicket($dec)
    {
        $this->db->select("A.*,B.username");
        $this->db->from('log_task as A');
        $this->db->join('user as B', 'B.user_id = A.user_id ','LEFT');
        $this->db->where('A.id_task',$dec);
        $this->db->order_by('A.id','desc');
        $data = $this->db->get();        
        return $data->result();
    }

	function getDocument($dec) {
		$this->db->select("A.*,B.username as name_pic");
		$this->db->from('incident_foto as A');
		$this->db->join('user as B', 'B.user_id = A.user_create ','LEFT');
		$this->db->where('A.incident_id',$dec);
		$data = $this->db->get();   
		return $data->result();
	}

	function deleteFile($id){
        $this->db->where('id', $id);
        $this->db->delete('incident_foto');
		if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }
    }

	function approve($dec,$user_id){
		$this->db->set('manager',$user_id);
		$this->db->where('id',$dec);
		$this->db->update('schedule_job');
		if ($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}		
	}

	function update_progress_ticket($dec, $value_progres, $task_progres){
		$this->db->set('last_update', $task_progres);
		$this->db->set('value_progres', $value_progres);
		$this->db->where('id', $dec);
		$this->db->update('schedule_job');
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	function complete($dec,$res,$time,$sol){
		$this->db->set('status',5);
		$this->db->set('note',$sol);
		$this->db->set('result',$res);
		$this->db->set('value_progres',100);
		$this->db->set('finish_date',$time);
		$this->db->where('id',$dec);
		$this->db->update('schedule_job');
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	function cancel($dec, $time, $res){
		$this->db->set('status',6);
		 $this->db->set('result',$res);
		$this->db->set('finish_date',$time);
		$this->db->set('value_progres',100);
		$this->db->where('id',$dec);
		$this->db->update('schedule_job');
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	function getBiaya($dec){
        $this->db->select("A.*,B.username as name_pic, (A.qty*A.biaya) as subtotal");
        $this->db->from('biaya_perbaikan as A');
        $this->db->join('user as B', 'B.user_id = A.user_create ','LEFT');
        $this->db->where('A.incident_id', $dec);
        $data = $this->db->get();
        return $data->result();
    }

	public function chartTicketByStatus()
	{
		$this->db->select(
			$this->status_progres_table.".desc_status, ".
			"COUNT(".$this->schedule_job_table.".status) AS total"
		);
		$this->db->from($this->schedule_job_table);

		$this->db->join($this->status_progres_table, $this->schedule_job_table.'.status = '.$this->status_progres_table.'.id', 'left');

		$this->db->group_by($this->schedule_job_table.'.status');

		$datas = $this->db->get();
		//echo $this->db->last_query();
		return $datas;
	}

	public function chartTypeIncident()
	{
		$this->db->select(
			$this->type_incident_table.".*, "
		);

		$this->db->from($this->type_incident_table);
		$datas = $this->db->get();
		return $datas;
	}

	public function chartTotalEngineer()
	{
		$this->db->select(
			$this->users_table.".*, "
		);

		$this->db->from($this->users_table);

		$this->db->join($this->users_groups_table, $this->users_table.'.id = '.$this->users_groups_table.'.user_id', 'left');

		$this->db->where($this->users_groups_table.'.group_id', 6);

		$datas = $this->db->get();
		return $datas;
	}

}