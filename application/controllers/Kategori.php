<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
    }

    function index(){
    	$tb_user = TB_USER;
        $tb_detail = TB_DETAIL;
        $tb_bencana = TB_TIPE_BENCANA;
        $tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
        $tb_group_kegiatan = TB_GROUP_KEGIATAN;
        $tb_last_update_timeline_kegiatan = TB_LAST_UPDATE_TIMELINE_KEGIATAN;
        $bencana = $this->input->post('id_bencana');
        $where_bencana = null;
        if(!empty($bencana)){
            $where_bencana = "WHERE wd.bencana='$bencana'";
        }
        $query = "SELECT wd.*, wtb.`nama` AS `nama_bencana` FROM $tb_detail wd LEFT JOIN $tb_bencana wtb ON wtb.`id` = wd.`bencana` $where_bencana";
        $data['result'] = $this->db->query($query)->result();
        $data['myJS'] = 'dashboard/myJS';
        if(!$this->welcome_model->logged_id()) {
            $data['menu'] = 0;
        }else{
            $data['menu'] = 1;
        }

        $query_timeline = "SELECT wlutk.`id`, wgk.`nama` as nama_kegiatan, wtk.`detail_id`, u.`nama`, wtb.`nama` AS nama_bencana, wd.`lat`, wd.`lng`, wlutk.`timeline_kegiatan_deskripsi`, wlutk.`tgl_insert` FROM $tb_last_update_timeline_kegiatan wlutk LEFT JOIN $tb_timeline_kegiatan wtk ON wtk.`id` = wlutk.`timeline_kegiatan_id` LEFT JOIN wgm_detail wd ON wd.`id` = wtk.`detail_id` LEFT JOIN $tb_group_kegiatan wgk ON wgk.`id` = wtk.`group_kegiatan_id` LEFT JOIN wgm_tipe_bencana wtb ON wtb.`id` = wd.`bencana` LEFT JOIN $tb_user u ON u.`id` = wlutk.`user_id` LIMIT 5";
        $data['row_timeline'] = $this->db->query($query_timeline)->result();

        $this->template->load('template', 'dashboard/home', $data);
    }

}
