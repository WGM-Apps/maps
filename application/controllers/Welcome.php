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
		$data['idx'] = $idx;

		$this->load->view('dashboard/modal_respon', $data);
	}

	function simpan_respon()
	{
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		$tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
		$tb_group_kegiatan = TB_GROUP_KEGIATAN;

		$gambar1 = $this->input->post('gambar1');
		$gambar2 = $this->input->post('gambar2');
		$gambar3 = $this->input->post('gambar3');
		$gambar4 = $this->input->post('gambar4');
		$gambar5 = $this->input->post('gambar5');
		$gambar6 = $this->input->post('gambar6');
		$gambar7 = $this->input->post('gambar7');
		$gambar8 = $this->input->post('gambar8');
		$gambar9 = $this->input->post('gambar9');
		$gambar10 = $this->input->post('gambar10');
		$gambar11 = $this->input->post('gambar11');

		$deskripsi1 = $this->input->post('deskripsi1');
		$deskripsi2 = $this->input->post('deskripsi2');
		$deskripsi3 = $this->input->post('deskripsi3');
		$deskripsi4 = $this->input->post('deskripsi4');
		$deskripsi5 = $this->input->post('deskripsi5');
		$deskripsi6 = $this->input->post('deskripsi6');
		$deskripsi7 = $this->input->post('deskripsi7');
		$deskripsi8 = $this->input->post('deskripsi8');
		$deskripsi9 = $this->input->post('deskripsi9');
		$deskripsi10 = $this->input->post('deskripsi10');
		$deskripsi11 = $this->input->post('deskripsi11');

		$id_detail1 = $this->input->post('id_detail1');
		$id_detail2 = $this->input->post('id_detail2');
		$id_detail3 = $this->input->post('id_detail3');
		$id_detail4 = $this->input->post('id_detail4');
		$id_detail5 = $this->input->post('id_detail5');
		$id_detail6 = $this->input->post('id_detail6');
		$id_detail7 = $this->input->post('id_detail7');
		$id_detail8 = $this->input->post('id_detail8');
		$id_detail9 = $this->input->post('id_detail9');
		$id_detail10 = $this->input->post('id_detail10');
		$id_detail11 = $this->input->post('id_detail11');

		$id_group_kegiatan1 = $this->input->post('id_group_kegiatan1');
		$id_group_kegiatan2 = $this->input->post('id_group_kegiatan2');
		$id_group_kegiatan3 = $this->input->post('id_group_kegiatan3');
		$id_group_kegiatan4 = $this->input->post('id_group_kegiatan4');
		$id_group_kegiatan5 = $this->input->post('id_group_kegiatan5');
		$id_group_kegiatan6 = $this->input->post('id_group_kegiatan6');
		$id_group_kegiatan7 = $this->input->post('id_group_kegiatan7');
		$id_group_kegiatan8 = $this->input->post('id_group_kegiatan8');
		$id_group_kegiatan9 = $this->input->post('id_group_kegiatan9');
		$id_group_kegiatan10 = $this->input->post('id_group_kegiatan10');
		$id_group_kegiatan11 = $this->input->post('id_group_kegiatan11');
		
		$implode_deskripsi1 = implode('|', $deskripsi1);
		$implode_deskripsi2 = implode('|', $deskripsi2);
		$implode_deskripsi3 = implode('|', $deskripsi3);
		$implode_deskripsi4 = implode('|', $deskripsi4);
		$implode_deskripsi5 = implode('|', $deskripsi5);
		$implode_deskripsi6 = implode('|', $deskripsi6);
		$implode_deskripsi7 = implode('|', $deskripsi7);
		$implode_deskripsi8 = implode('|', $deskripsi8);
		$implode_deskripsi9 = implode('|', $deskripsi9);
		$implode_deskripsi10 = implode('|', $deskripsi10);
		$implode_deskripsi11 = implode('|', $deskripsi11);

		$cek_kegiatan1 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail1 AND group_kegiatan_id = $id_group_kegiatan1")->row();

		$cek_kegiatan2 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail2 AND group_kegiatan_id = $id_group_kegiatan2")->row();
		
		$cek_kegiatan3 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail3 AND group_kegiatan_id = $id_group_kegiatan3")->row();
		
		$cek_kegiatan4 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail4 AND group_kegiatan_id = $id_group_kegiatan4")->row();
		
		$cek_kegiatan5 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail5 AND group_kegiatan_id = $id_group_kegiatan5")->row();
		
		$cek_kegiatan6 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail6 AND group_kegiatan_id = $id_group_kegiatan6")->row();
		
		$cek_kegiatan7 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail7 AND group_kegiatan_id = $id_group_kegiatan7")->row();
		
		$cek_kegiatan8 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail8 AND group_kegiatan_id = $id_group_kegiatan8")->row();
		
		$cek_kegiatan9 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail9 AND group_kegiatan_id = $id_group_kegiatan9")->row();
		
		$cek_kegiatan10 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail10 AND group_kegiatan_id = $id_group_kegiatan10")->row();
		
		$cek_kegiatan11 = $this->db->query("SELECT COUNT(*) as total, id FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail11 AND group_kegiatan_id = $id_group_kegiatan11")->row();

		if($cek_kegiatan1->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi1
			);
			$this->db->where('id', $cek_kegiatan1->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail1,
				"group_kegiatan_id" => $id_group_kegiatan1,
				"deskripsi" => $implode_deskripsi1
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan2->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi2
			);
			$this->db->where('id', $cek_kegiatan2->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail2,
				"group_kegiatan_id" => $id_group_kegiatan2,
				"deskripsi" => $implode_deskripsi2
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan3->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi3
			);
			$this->db->where('id', $cek_kegiatan3->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail3,
				"group_kegiatan_id" => $id_group_kegiatan3,
				"deskripsi" => $implode_deskripsi3
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan4->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi4
			);
			$this->db->where('id', $cek_kegiatan4->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail4,
				"group_kegiatan_id" => $id_group_kegiatan4,
				"deskripsi" => $implode_deskripsi4
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan5->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi5
			);
			$this->db->where('id', $cek_kegiatan5->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail5,
				"group_kegiatan_id" => $id_group_kegiatan5,
				"deskripsi" => $implode_deskripsi5
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan6->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi6
			);
			$this->db->where('id', $cek_kegiatan6->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail6,
				"group_kegiatan_id" => $id_group_kegiatan6,
				"deskripsi" => $implode_deskripsi6
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan7->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi7
			);
			$this->db->where('id', $cek_kegiatan7->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail7,
				"group_kegiatan_id" => $id_group_kegiatan7,
				"deskripsi" => $implode_deskripsi7
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan8->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi8
			);
			$this->db->where('id', $cek_kegiatan8->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail8,
				"group_kegiatan_id" => $id_group_kegiatan8,
				"deskripsi" => $implode_deskripsi8
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan9->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi9
			);
			$this->db->where('id', $cek_kegiatan9->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail9,
				"group_kegiatan_id" => $id_group_kegiatan9,
				"deskripsi" => $implode_deskripsi9
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan10->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi10
			);
			$this->db->where('id', $cek_kegiatan10->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail10,
				"group_kegiatan_id" => $id_group_kegiatan10,
				"deskripsi" => $implode_deskripsi10
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}

		if($cek_kegiatan11->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi11
			);
			$this->db->where('id', $cek_kegiatan11->id);
			$this->db->update($tb_timeline_kegiatan, $arr);
		}else{
			$arr = array(
				"detail_id" => $id_detail11,
				"group_kegiatan_id" => $id_group_kegiatan11,
				"deskripsi" => $implode_deskripsi11
			);
			$this->db->insert($tb_timeline_kegiatan, $arr);
		}
	}

}
