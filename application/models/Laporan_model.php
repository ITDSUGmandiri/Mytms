<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->asets_table	 	= 'aset';
		$this->units_table	 	= 'unit';
		$this->areas_table		= 'lokasi_kerja';
		$this->users_table      = 'users';
		$this->status_table     = 'status';
		$this->penghunis_table  = 'penghuni';
		$this->loggedinuser     = $this->ion_auth->user()->row();

	}

	function get_rekap_aset_unit($data)
	{

		$ssql = "select klasifikasi_standar_unit.*, aset.nama as nama_barang,
				unit.id, unit.nama_unit, unit.blok, unit.no_unit, status.status_detail,
				
				case when aset.nama IS NULL then 'X' else 'V' end as is_barang_ada
				
				from klasifikasi_standar_unit 
				join unit on unit.klasifikasi_id = klasifikasi_standar_unit.klasifikasi_id
				
				left join aset on aset.id_unit = unit.id 
				and klasifikasi_standar_unit.bagian = aset.bagian and klasifikasi_standar_unit.nama_aset = aset.nama

				join status on status.id=unit.status
				";

		$id_lok = $data['id_lok'];
		$id_unit = $data['id_unit'];
		$jenis_laporan = $data['jenis_laporan'];

		if ($id_lok <> '0'){
			$ssql = $ssql . " where unit.id_lok = '$id_lok'";
		}

		if ($id_unit <> '0'){
			$ssql = $ssql . " and unit.id = '$id_unit'";
		}

		if ($jenis_laporan == '1'){
			$ssql = $ssql . " and aset.nama is not null";
		}

		if ($jenis_laporan == '2'){
			$ssql = $ssql . " and aset.nama is null";
		}

		$orderby = " order by unit.id asc, klasifikasi_standar_unit.id_klasifikasi_standar_unit asc";
		$ssql = $ssql . $orderby;

		// echo $ssql;

		// die;

		$query = $this->db->query($ssql);
		return $query->result();	
		
	}

}
// End of Laporan model