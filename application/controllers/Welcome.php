<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
    }

	public function index()
	{
		$tb_user = TB_USER;
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		$tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
		$tb_group_kegiatan = TB_GROUP_KEGIATAN;
		$tb_last_update_timeline_kegiatan = TB_LAST_UPDATE_TIMELINE_KEGIATAN;
		$bencana = $this->uri->segment(3);
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

	function login() {
		$username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $check = $this->welcome_model->check_login(array('user' => $username), array('password' => $password));

        if($check != FALSE) {
            $r = $check;
            $session_data = array(
                'USER_ID' => $r->id,
                'USER_NAME' => $r->user,
                'USER_FULLNAME' => $r->nama,
                'USER_ACTIVE' => $r->flg_active,
            );
            $this->session->set_userdata($session_data);
            $data = array('isValid'=>0);
            echo json_encode($data);
        }else {
            $data = array('isValid'=>1, 'isPesan'=>'Nama pengguna atau kata kunci salah');
            echo json_encode($data);
        }
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
	
	function maps() {
		$data['result'] = $this->db->get(TB_TIPE_BENCANA)->result();
		$data['myJS'] = 'maps/myJS';
		if(!$this->welcome_model->logged_id()) {
            redirect();
        }else{
			$data['menu'] = 1;
		}
		$this->template->load('template', 'maps/home', $data);
	}
	
	function get_detail_koordinat()
	{
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		$tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
		$tb_group_kegiatan = TB_GROUP_KEGIATAN;
		$id = $this->input->post('id');

		$query_detail = "SELECT wd.*, wtb.`nama` AS nama_bencana FROM $tb_detail wd LEFT JOIN $tb_bencana wtb ON wtb.`id` = wd.`bencana` WHERE wd.`id`='$id'";
		$detail = $this->db->query($query_detail)->row();
		$data['row_detail'] = $detail;
		
		$query_timeline = "SELECT wtk.*, wgk.`id` AS wgk_id, wgk.`nama` AS wgk_nama FROM $tb_timeline_kegiatan wtk LEFT JOIN $tb_group_kegiatan wgk ON wgk.`id` = wtk.`group_kegiatan_id` WHERE wtk.`detail_id` = '$detail->id'";
		$timeline = $this->db->query($query_timeline)->result();
		$data['row_timeline'] = $timeline;
		
		$this->load->view('dashboard/detail_koordinat', $data);
	}

	function modal_respon()
	{
		$idx = $this->input->post('data');
		$tb_group_kegiatan = TB_GROUP_KEGIATAN;

		$query_group = "SELECT * FROM $tb_group_kegiatan";
		$data['row_group'] = $this->db->query($query_group)->result();

		$this->load->view('dashboard/modal_respon', $data);
	}
}
