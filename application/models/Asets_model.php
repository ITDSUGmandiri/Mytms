<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asets_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->asets_table	 	= 'aset';
		$this->areas_table		= 'lokasi_kerja';
		$this->units_table	 	= 'unit';
		$this->users_table      = 'users';
		$this->loggedinuser     = $this->ion_auth->user()->row();
	}

	public function get_aset_by_id($id='')
	{

		$this->db->select(
			$this->areas_table.".nama_lokasi, ".
			$this->units_table.".nama_unit, ".
			$this->units_table.".blok, ".
			$this->units_table.".no_unit, ".
			$this->asets_table.".*"
		);

		$this->db->from($this->asets_table);

		$this->db->join(
			$this->areas_table, 
			$this->areas_table.'.id = '.$this->asets_table.'.id_area',
			'left'
		);

		$this->db->join(
			$this->units_table, 
			$this->asets_table.'.id_unit = '.$this->units_table.'.id',
			'left'
		);

		// if id_lok provided
		if ($id!='') {
			$this->db->where($this->asets_table.'.id', $id);
		}

		$datas = $this->db->get();

		//echo $this->db->last_query();

		return $datas;

	}

	function getlist_aset_by_unit_area($aColumns, $sWhere, $sOrder, $top, $limit, $params)
    {

		$limit = " limit " . $top . ", ".$limit."";

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$id_kategori = $params['id_kategori'];
		
		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						left join inv_categories on inv_categories.id = aset.category_id
						$sWhere and id_area = '$id_lok' ";

				if ($id_unit != '0'){
				
					$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' ";

					if ($id_status != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' ";

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
			
						}
						
					} else {

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' and aset.category_id = '$id_kategori' ";
			
						}

					}
		
				} else {

					if ($id_status != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								$sWhere and id_area = '$id_lok' and aset.status_aset = '$id_status' ";

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									$sWhere and id_area = '$id_lok' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
							
						}

					} else {

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									$sWhere and id_area = '$id_lok' and aset.category_id = '$id_kategori' ";
							
						}

					}

				}
			
			} else {

				$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						left join inv_categories on inv_categories.id = aset.category_id
						where id_area = '$id_lok' ";

				if ($id_unit != '0'){

					$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							where id_area = '$id_lok' and id_unit = '$id_unit' ";

					if ($id_status != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' ";

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									where id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";

						}
								
					} else {

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									where id_area = '$id_lok' and id_unit = '$id_unit' and aset.category_id = '$id_kategori' ";
							
						}

					}

				} else {

					if ($id_status != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where id_area = '$id_lok' and aset.status_aset = '$id_status' ";

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									where id_area = '$id_lok' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
							
						}

					} else {

						if ($id_kategori != '0'){

							$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									left join inv_categories on inv_categories.id = aset.category_id
									where id_area = '$id_lok' and aset.category_id = '$id_kategori' ";
							
						}

					}

				}
	
			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
					from aset
					left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
					left join unit on unit.id = aset.id_unit
					left join inv_status on inv_status.id = aset.status_aset
					left join inv_categories on inv_categories.id = aset.category_id $sWhere ";

				if ($id_status != '0'){

					$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							$sWhere and aset.status_aset = '$id_status' ";

					if ($id_kategori != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								$sWhere and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
								
					}
									
				} else {

					if ($id_kategori != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								$sWhere and aset.category_id = '$id_kategori' ";
								
					}

				}

			} else {

				$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
					from aset
					left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
					left join unit on unit.id = aset.id_unit
					left join inv_status on inv_status.id = aset.status_aset
					left join inv_categories on inv_categories.id = aset.category_id ";

				if ($id_status != '0'){

					$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							where aset.status_aset = '$id_status' ";

					if ($id_kategori != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
								
					}
									
				} else {

					if ($id_kategori != '0'){

						$ssql = "select lokasi_kerja.nama_lokasi, unit.nama_unit, unit.blok, unit.no_unit, aset.*, inv_status.name as nama_status_aset, inv_categories.name as kategori_aset
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where aset.category_id = '$id_kategori' ";
								
					}

				}

			}

		}

		//$ssql = $ssql . $sOrder . $limit;

		if(isset($_POST['order'])) 
        {
            //$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$ssql = $ssql . $sOrder . $limit;
        } 
    	else // if(isset($this->order))
    	{
            //$order = $this->order;
            //$this->db->order_by(key($order), $order[key($order)]);
			$ssql = $ssql . 'order by id_area asc, id_unit asc, unit.blok asc, unit.no_unit asc' . $limit;
        }
		
		//echo $ssql;
        $query = $this->db->query($ssql);
		return $query;
		
    }

	function getlist_aset_by_unit_area_total($sIndexColumn, $params)
	{

		$level = $this->session->userdata('level');
		$id_faskes = $this->session->userdata('id_faskes');
		$id_user = $this->session->userdata('id_user');

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$id_kategori = $params['id_kategori'];

		if ($id_lok != '0'){

			$ssql = "select count(aset.id) as total_jml_data 
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						left join inv_categories on inv_categories.id = aset.category_id
						where id_area = '$id_lok' ";

			if ($id_unit != '0'){
			
				$ssql = "select count(aset.id) as total_jml_data 
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						left join inv_categories on inv_categories.id = aset.category_id
						where id_area = '$id_lok' and id_unit = '$id_unit' ";

				if ($id_status != '0'){

					$ssql = "select count(aset.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							where id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' ";

					if ($id_kategori != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";

					}

				} else {

					if ($id_kategori != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where id_area = '$id_lok' and id_unit = '$id_unit' and aset.category_id = '$id_kategori' ";
						
					}

				}

			} else {

				if ($id_status != '0'){

					$ssql = "select count(aset.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							where id_area = '$id_lok' and aset.status_aset = '$id_status' ";

					if ($id_kategori != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where id_area = '$id_lok' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
						
					}

				} else {

					if ($id_kategori != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								left join inv_categories on inv_categories.id = aset.category_id
								where id_area = '$id_lok' and aset.category_id = '$id_kategori' ";
						
					}

				}

			}

		} else {

			$ssql = "select count(unit.id) as total_jml_data 
					from aset
					left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
					left join unit on unit.id = aset.id_unit
					left join inv_status on inv_status.id = aset.status_aset
					left join inv_categories on inv_categories.id = aset.category_id";

			if ($id_status != '0'){

				$ssql = "select count(aset.id) as total_jml_data 
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						left join inv_categories on inv_categories.id = aset.category_id
						where aset.status_aset = '$id_status' ";

				if ($id_kategori != '0'){

					$ssql = "select count(aset.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							where aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
						
				}
	
			} else {

				if ($id_kategori != '0'){

					$ssql = "select count(aset.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							left join inv_categories on inv_categories.id = aset.category_id
							where aset.category_id = '$id_kategori' ";
						
				}

			}

		}

		$query = $this->db->query($ssql);
        return $query;
		
    }

	function getlist_aset_by_unit_area_filteredtotal($sIndexColumn, $aColumns, $sWhere, $sOrder, $top, $limit, $params)
	{

		$id_lok = $params['id_lok'];
		$id_unit = $params['id_unit'];
		$id_status = $params['id_status'];
		$id_kategori = $params['id_kategori'];

		if ($id_lok != '0'){

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(unit.id) as total_jml_data 
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						$sWhere and id_area = '$id_lok'";

				if ($id_unit != '0'){
			
					$ssql = "select count(aset.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							$sWhere and id_area = '$id_lok' and id_unit = '$id_unit'";

					if ($id_status != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status'";

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori'";
							
						}

					} else {

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									$sWhere and id_area = '$id_lok' and id_unit = '$id_unit' and aset.category_id = '$id_kategori'";

						}

					}
			
				} else {

					if ($id_status != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								$sWhere and id_area = '$id_lok' and aset.status_aset = '$id_status'";

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									$sWhere and id_area = '$id_lok' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori'";
							
						}

					} else {

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									$sWhere and id_area = '$id_lok' and aset.category_id = '$id_kategori'";
							
						}

					}

				}

			} else {		

				$ssql = "select count(unit.id) as total_jml_data 
						from aset
						left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
						left join unit on unit.id = aset.id_unit
						left join inv_status on inv_status.id = aset.status_aset
						where id_area = '$id_lok' ";

				if ($id_unit != '0'){
			
					$ssql = "select count(aset.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							where id_area = '$id_lok' and id_unit = '$id_unit' ";

					if ($id_status != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								where id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' ";

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									where id_area = '$id_lok' and id_unit = '$id_unit' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";
							
						}

					} else {

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									where id_area = '$id_lok' and id_unit = '$id_unit' and aset.category_id = '$id_kategori' ";
							
						}

					}
					
				} else {

					if ($id_status != '0'){

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								where id_area = '$id_lok' and aset.status_aset = '$id_status' ";

						if ($id_kategori != '0'){

							$ssql = "select count(aset.id) as total_jml_data 
									from aset
									left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
									left join unit on unit.id = aset.id_unit
									left join inv_status on inv_status.id = aset.status_aset
									where id_area = '$id_lok' and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori' ";

						}

					} else {

						$ssql = "select count(aset.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								where id_area = '$id_lok' and aset.category_id = '$id_kategori' ";

					}

				}

			}

		} else {

			if ((isset($sWhere)) AND ($sWhere != '')){

				$ssql = "select count(unit.id) as total_jml_data 
					from aset
					left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
					left join unit on unit.id = aset.id_unit
					left join inv_status on inv_status.id = aset.status_aset $sWhere ";

				if ($id_status != '0'){

					$ssql = "select count(unit.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							$sWhere and aset.status_aset = '$id_status'";

					if ($id_kategori != '0'){

						$ssql = "select count(unit.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								$sWhere and aset.status_aset = '$id_status' and aset.category_id = '$id_kategori'";
						
					}

				} else {

					if ($id_kategori != '0'){

						$ssql = "select count(unit.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								$sWhere and aset.category_id = '$id_kategori'";

					}

				}

			} else {

				$ssql = "select count(unit.id) as total_jml_data 
					from aset
					left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
					left join unit on unit.id = aset.id_unit
					left join inv_status on inv_status.id = aset.status_aset";

				if ($id_status != '0'){

					$ssql = "select count(unit.id) as total_jml_data 
							from aset
							left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
							left join unit on unit.id = aset.id_unit
							left join inv_status on inv_status.id = aset.status_aset
							where aset.status_aset = '$id_status'";

					if ($id_kategori != '0'){

						$ssql = "select count(unit.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								where aset.status_aset = '$id_status' and aset.category_id = '$id_kategori'";
						
					}

				} else {

					if ($id_kategori != '0'){

						$ssql = "select count(unit.id) as total_jml_data 
								from aset
								left join lokasi_kerja on lokasi_kerja.id = aset.id_area 
								left join unit on unit.id = aset.id_unit
								left join inv_status on inv_status.id = aset.status_aset
								where aset.category_id = '$id_kategori'";

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
	* nomor_aset check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$nomor_aset
	* @return 	array
	*
	*/
	public function nomor_aset_check($nomor_aset)
	{
		$this->db->where('nomor_aset', trim($nomor_aset));
		$datas = $this->db->get($this->asets_table);

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

	public function hapus_data($id)
	{

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 
	
		// hapus users
		$this->db->where('id', $id);
		$this->db->delete($this->asets_table);
		
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
		if($this->db->update($this->asets_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	public function update_aset_by_id($id, $datas)
	{
		// user and datetime
		$datas['user_change'] = $this->loggedinuser->username;
		$this->db->set('change_date', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->asets_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

}
// End of categories model
