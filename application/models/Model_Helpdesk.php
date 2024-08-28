<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Helpdesk extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->database();
        $us = $this->session->userdata('user_id');
        
        if(empty($us))
        {
            $this->session->sess_destroy();
            redirect('Auth');
        }
        
    }

      function Data_unit()
    {
       $this->db->select("A.id,A.blok,A.no_unit,B.username");
                $this->db->from('unit as A');
                   $this->db->join('user as B', 'B.user_id = A.penghuni ','LEFT');
                 $this->db->order_by('A.blok','asc');
                $data = $this->db->get();
                return $data->result();

    }
    
    function Log_task($dec)
    {
       
        $this->db->select("A.*,B.username");
        $this->db->from('log_task as A');
        $this->db->join('user as B', 'B.user_id = A.user_id ','LEFT');
        $this->db->where('A.id_task',$dec);
        $this->db->order_by('A.id','desc');
        $data = $this->db->get();        
        return $data->result();

    }
    function Document($dec) {
             $this->db->select("A.*,B.username as name_pic");
                $this->db->from('incident_foto as A');
                $this->db->join('user as B', 'B.user_id = A.user_create ','LEFT');
                $this->db->where('A.incident_id',$dec);
                $data = $this->db->get();
                return $data->result();

    }

    function Biaya($dec) {

        $this->db->select("A.*,B.username as name_pic, (A.qty*A.biaya) as subtotal");
        $this->db->from('biaya_perbaikan as A');
        $this->db->join('user as B', 'B.user_id = A.user_create ','LEFT');
        $this->db->where('A.incident_id',$dec);
        $data = $this->db->get();

        return $data->result();

    }

     function Type_incident() {
             $this->db->select("A.*");
                $this->db->from('type_incident as A');
                $data = $this->db->get();
                return $data->result();

    }

    function Detail($dec)        
    {
                
        $this->db->select("A.*,B.username as name_pic,B1.username as name_pic1,B2.username as name_pic_complete,C.nama_unit, C.blok,C.no_unit,D.desc_status,E.username as name_author,C1.nama as npenghuni,F.nama_lokasi");
        $this->db->from('schedule_job as A');
        $this->db->join('user as B', 'B.user_id = A.pic ','LEFT');
        $this->db->join('user as B1', 'B1.user_id = A.pic1 ','LEFT');          
        $this->db->join('user as B2', 'B2.user_id = A.pic_complete','LEFT');
        $this->db->join('unit as C', 'C.id = A.id_unit ','LEFT');
        $this->db->join('penghuni as C1', 'C1.kode = C.penghuni ','LEFT');
        $this->db->join('status_progres as D', 'D.id = A.status ','LEFT');
        $this->db->join('user as E', 'E.user_id = A.user_create ','LEFT');
        $this->db->join('lokasi_kerja as F', 'F.id = A.id_area ','LEFT');
        //$this->db->join('(select incident_id,sum(biaya) as total_perbaikan from biaya_perbaikan) as G', 'G.incident_id = A.id ','LEFT');
        $this->db->where('A.id',$dec);
                
        $this->db->limit(1);
                
        $data = $this->db->get();
                
        return $data->result();
                    
    }

   function Tambah_comment($data){
        $this->db->insert('log_task', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }
            }

            
               function Take_job($dec){
                $this->db->set('status',2);
                   $this->db->set('value_progres',5);
                $this->db->where('id',$dec);
                $this->db->update('schedule_job');
                if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }

            }


               function Complete($dec,$res,$time,$sol){
                $this->db->set('status',5);
                $this->db->set('note',$sol);
                $this->db->set('result',$res);
                $this->db->set('value_progres',100);
                $this->db->set('finish_date',$time);
                $this->db->where('id',$dec);
                $this->db->update('schedule_job');
                if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }

            }


               function Cancel($dec,$time,$res){
                $this->db->set('status',6);
                 $this->db->set('result',$res);
                $this->db->set('finish_date',$time);
                $this->db->set('value_progres',100);
                $this->db->where('id',$dec);
                $this->db->update('schedule_job');
                if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }

            }
            
        function  Edit($dec,$task_name_edit,$task_remarks_edit,$participan_edit1,$participan_edit2,$pr_edit,$id_area_edit,$id_unit_edit,$type_edit) {
              $this->db->set('id_area',$id_area_edit);
                $this->db->set('id_unit',$id_unit_edit);
                $this->db->set('type_problem',$participan_edit1);
                $this->db->set('job_detail',$task_name_edit);
                $this->db->set('note',$task_remarks_edit);
                $this->db->set('pic',$participan_edit1);
                $this->db->set('pic1',$participan_edit2);
                $this->db->set('type',$pr_edit);
                $this->db->where('id',$dec);
                $this->db->update('schedule_job');
                if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }



            }



                    
        function Update($dec,$value_progres,$task_progres){
                $this->db->set('last_update',$task_progres);
                $this->db->set('value_progres',$value_progres);
                $this->db->where('id',$dec);
                $this->db->update('schedule_job');
                if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }

            }



                function Approve($dec,$user_id){
                $this->db->set('manager',$user_id);
                $this->db->where('id',$dec);
                $this->db->update('schedule_job');
                if($this->db->affected_rows() > 0){
            return true;
        }
        else
        {
            return false;
        }

            }



            


                     function Pic()
            {
               $this->db->select("A.user_id,A.username");
                $this->db->from('user as A');
                $this->db->where('A.user_type',6);
                   $this->db->where('A.status',1);
                $data = $this->db->get();
                return $data->result();
            }


            	function Delete_file($id){
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

       function List_lokasi()
            {
               $this->db->select("A.*");
               $this->db->from('lokasi_kerja as A');
                 $this->db->where_not_in('A.id', '1');
               $this->db->order_by('A.nama_lokasi', "asc");
                 $data = $this->db->get();
                return $data->result();
            }


               function Unit_data($type)
            {
               $this->db->select("A.id,A.blok,A.no_unit,A.nama_unit,C1.nama");
               $this->db->from('unit as A');
                 $this->db->join('penghuni as C1', 'C1.kode = A.penghuni ','LEFT');
               $this->db->where('id_lok', $type);
               $this->db->order_by('A.blok', "asc");
               $data = $this->db->get();
               return $data->result();
            }
   
}