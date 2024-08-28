<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Counter_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Bangkok');
        $us = $this->session->userdata('user_id');
        if (empty($us)) {
            $this->session->sess_destroy();
            redirect('Auth');
        }
    }

    function getRomawi($m)
    {
        switch ($m) {
            case 1:
                return 'I';
                break;
            case 2:
                return 'II';
                break;
            case 3:
                return 'III';
                break;
            case 4:
                return 'IV';
                break;
            case 5:
                return 'V';
                break;
            case 6:
                return 'VI';
                break;
            case 7:
                return 'VII';
                break;
            case 8:
                return 'VIII';
                break;
            case 9:
                return 'IX';
                break;
            case 10:
                return 'X';
                break;
            case 11:
                return 'XI';
                break;
            case 12:
                return 'XII';
                break;
        }
    }

    function getcodecm()
    {
        date_default_timezone_set('Asia/Bangkok');
        $w = date('ym');
        $m = date('m');
        $y = date('Y');
        $q = $this->db->query("SELECT * FROM counter  where counter.type='CM' AND counter.month='$m' AND counter.year='$y'");
        $kd1 = '';
        $m = $this->getRomawi($m);
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $k) {
                $id = $k['id'];
                $tmp = ((int) $k['val']) + 1;
                $kd = sprintf('%03s', $tmp);
                $kd1 = "$kd/RM3-UG/$m/$y";
                $this->db->set('val', $tmp);
                $this->db->where('id', $id);
                $this->db->update('counter');
            }
        } else {
            $kd = '001';
            $kd1 = "$kd/RM3-UG/$m/$y";
            $data = [
                'type' => 'CM',
                'year' => date('Y'),
                'month' => date('m'),
                'val' => '0001'
            ];
            $this->db->insert('counter', $data);
        }
        return $kd1;
    }

    /*
     * function getcodecm()
     *     {
     *         date_default_timezone_set('Asia/Bangkok');
     *         $w=date('ym');
     *         $m=date('m');
     *         $y=date('y');
     *         $q = $this->db->query("SELECT * FROM counter  where counter.type='CM' AND counter.month='$m' AND counter.year='$y'");
     *         $kd1 = "";
     *
     *         if($q->num_rows()>0){
     *             foreach($q->result_array() as $k){
     *                 $id= $k['id'];
     *                 $tmp = ((int)$k['val'])+1;
     *                 $kd = sprintf("%04s", $tmp);
     *                 $kd1= "CM$w$kd";
     *         $this->db->set('val',$tmp);
     *         $this->db->where('id',$id);
     *         $this->db->update('counter');
     *             }
     *         }else{
     *             $kd = "0001";
     *             $kd1= "CM$w$kd";
     *             $data = [
     * 				'type' => "CM",
     * 				'year' => date("y"),
     * 				'month' => date("m"),
     * 				'val' => "0001"
     *                 ];
     *                 $this->db->insert('counter', $data);
     *         }
     *         return $kd1;
     *     }
     */

    function getcodearea()
    {
        date_default_timezone_set('Asia/Bangkok');
        $w = date('ym');
        $m = date('m');
        $y = date('y');
        $q = $this->db->query("SELECT * FROM counter  where counter.type='AR'");
        $kd1 = '';

        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $k) {
                $id = $k['id'];
                $tmp = ((int) $k['val']) + 1;
                $kd = sprintf('%04s', $tmp);
                $kd1 = "AR$kd";
                $this->db->set('val', $tmp);
                $this->db->where('id', $id);
                $this->db->update('counter');
            }
        } else {
            $kd = '0001';
            $kd1 = "AR$kd";
            $data = [
                'type' => 'AR',
                'year' => date('y'),
                'month' => date('m'),
                'val' => '0001'
            ];
            $this->db->insert('counter', $data);
        }
        return $kd1;
    }

    function getcodeunit()
    {
        date_default_timezone_set('Asia/Bangkok');
        $w = date('ym');
        $m = date('m');
        $y = date('y');
        $q = $this->db->query("SELECT * FROM counter  where counter.type='UN'");
        $kd1 = '';

        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $k) {
                $id = $k['id'];
                $tmp = ((int) $k['val']) + 1;
                $kd = sprintf('%04s', $tmp);
                $kd1 = "UN$kd";
                $this->db->set('val', $tmp);
                $this->db->where('id', $id);
                $this->db->update('counter');
            }
        } else {
            $kd = '0001';
            $kd1 = "UN$kd";
            $data = [
                'type' => 'UN',
                'year' => date('y'),
                'month' => date('m'),
                'val' => '0001'
            ];
            $this->db->insert('counter', $data);
        }
        return $kd1;
    }

    function getcodepenghuni()
    {
        date_default_timezone_set('Asia/Bangkok');
        $w = date('ym');
        $m = date('m');
        $y = date('y');
        $q = $this->db->query("SELECT * FROM counter where counter.type='PE'");
        $kd1 = '';

        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $k) {
                $id = $k['id'];
                $tmp = ((int) $k['val']) + 1;
                $kd = sprintf('%04s', $tmp);
                $kd1 = "PE$kd";
                $this->db->set('val', $tmp);
                $this->db->where('id', $id);
                $this->db->update('counter');
            }
        } else {
            $kd = '0001';
            $kd1 = "PE$kd";
            $data = [
                'type' => 'PE',
                'year' => date('y'),
                'month' => date('m'),
                'val' => '0001'
            ];
            $this->db->insert('counter', $data);
        }
        return $kd1;
    }

    function getcodedok()
    {
        date_default_timezone_set('Asia/Bangkok');
        $w = date('ym');
        $m = date('m');
        $y = date('y');
        $q = $this->db->query("SELECT * FROM counter  where counter.type='DOK'AND counter.month='$m' AND counter.year='$y'");
        $kd1 = '';

        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $k) {
                $id = $k['id'];
                $tmp = ((int) $k['val']) + 1;
                $kd = sprintf('%04s', $tmp);
                $kd1 = "$w/DOK$kd";
                $this->db->set('val', $tmp);
                $this->db->where('id', $id);
                $this->db->update('counter');
            }
        } else {
            $kd = '0001';
            $kd1 = "$w/DOK$kd";
            $data = [
                'type' => 'DOK',
                'year' => date('y'),
                'month' => date('m'),
                'val' => '0001'
            ];
            $this->db->insert('counter', $data);
        }
        return $kd1;
    }
}