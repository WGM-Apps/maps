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

		$query_timeline = "SELECT wlutk.`id`, wgk.`nama` as nama_kegiatan, wtk.`detail_id`, u.`nama`, wtb.`nama` AS nama_bencana, wd.`lat`, wd.`lng`, wlutk.`timeline_kegiatan_deskripsi`, wlutk.`tgl_insert` FROM $tb_last_update_timeline_kegiatan wlutk LEFT JOIN $tb_timeline_kegiatan wtk ON wtk.`id` = wlutk.`timeline_kegiatan_id` LEFT JOIN wgm_detail wd ON wd.`id` = wtk.`detail_id` LEFT JOIN $tb_group_kegiatan wgk ON wgk.`id` = wtk.`group_kegiatan_id` LEFT JOIN wgm_tipe_bencana wtb ON wtb.`id` = wd.`bencana` LEFT JOIN $tb_user u ON u.`id` = wlutk.`user_id` GROUP BY CONCAT(wlutk.`timeline_kegiatan_deskripsi`, wlutk.`timeline_kegiatan_id`, u.`nama`) ORDER BY tgl_insert DESC LIMIT 5";
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
		$tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;

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
		$tb_last_update_timeline_kegiatan = TB_LAST_UPDATE_TIMELINE_KEGIATAN;
		$tb_group_kegiatan = TB_GROUP_KEGIATAN;

		$gambar1 = $_FILES['gambar1'];
		$gambar2 = $_FILES['gambar2'];
		$gambar3 = $_FILES['gambar3'];
		$gambar4 = $_FILES['gambar4'];
		$gambar5 = $_FILES['gambar5'];
		$gambar6 = $_FILES['gambar6'];
		$gambar7 = $_FILES['gambar7'];
		$gambar8 = $_FILES['gambar8'];
		$gambar9 = $_FILES['gambar9'];
		$gambar10 = $_FILES['gambar10'];
		$gambar11 = $_FILES['gambar11'];
		$path = "upload/";

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

		$cek_kegiatan1 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail1 AND group_kegiatan_id = $id_group_kegiatan1")->row();

		$cek_kegiatan2 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail2 AND group_kegiatan_id = $id_group_kegiatan2")->row();
		
		$cek_kegiatan3 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail3 AND group_kegiatan_id = $id_group_kegiatan3")->row();
		
		$cek_kegiatan4 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail4 AND group_kegiatan_id = $id_group_kegiatan4")->row();
		
		$cek_kegiatan5 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail5 AND group_kegiatan_id = $id_group_kegiatan5")->row();
		
		$cek_kegiatan6 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail6 AND group_kegiatan_id = $id_group_kegiatan6")->row();
		
		$cek_kegiatan7 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail7 AND group_kegiatan_id = $id_group_kegiatan7")->row();
		
		$cek_kegiatan8 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail8 AND group_kegiatan_id = $id_group_kegiatan8")->row();
		
		$cek_kegiatan9 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail9 AND group_kegiatan_id = $id_group_kegiatan9")->row();
		
		$cek_kegiatan10 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail10 AND group_kegiatan_id = $id_group_kegiatan10")->row();
		
		$cek_kegiatan11 = $this->db->query("SELECT COUNT(*) as total, id, gambar FROM $tb_timeline_kegiatan WHERE detail_id = $id_detail11 AND group_kegiatan_id = $id_group_kegiatan11")->row();

		if(empty($gambar1['name'])){
			$new_name1 = null;
		}else{
			$name = $gambar1['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name1 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar1['tmp_name'];
			if($cek_kegiatan1->gambar){
				unlink($path.$cek_kegiatan1->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name1);
		}

		if(empty($gambar2['name'])){
			$new_name2 = null;
		}else{
			$name = $gambar2['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name2 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar2['tmp_name'];
			if($cek_kegiatan2->gambar){
				unlink($path.$cek_kegiatan2->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name2);
		}

		if(empty($gambar3['name'])){
			$new_name3 = null;
		}else{
			$name = $gambar3['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name3 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar3['tmp_name'];
			if($cek_kegiatan3->gambar){
				unlink($path.$cek_kegiatan3->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name3);
		}

		if(empty($gambar4['name'])){
			$new_name4 = null;
		}else{
			$name = $gambar4['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name4 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar4['tmp_name'];
			if($cek_kegiatan4->gambar){
				unlink($path.$cek_kegiatan4->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name4);
		}

		if(empty($gambar5['name'])){
			$new_name5 = null;
		}else{
			$name = $gambar5['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name5 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar5['tmp_name'];
			if($cek_kegiatan5->gambar){
				unlink($path.$cek_kegiatan5->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name5);
		}

		if(empty($gambar6['name'])){
			$new_name6 = null;
		}else{
			$name = $gambar6['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name6 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar6['tmp_name'];
			if($cek_kegiatan6->gambar){
				unlink($path.$cek_kegiatan6->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name6);
		}

		if(empty($gambar7['name'])){
			$new_name7 = null;
		}else{
			$name = $gambar7['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name7 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar7['tmp_name'];
			if($cek_kegiatan7->gambar){
				unlink($path.$cek_kegiatan7->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name7);
		}

		if(empty($gambar8['name'])){
			$new_name8 = null;
		}else{
			$name = $gambar8['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name8 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar8['tmp_name'];
			if($cek_kegiatan8->gambar){
				unlink($path.$cek_kegiatan8->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name8);
		}

		if(empty($gambar9['name'])){
			$new_name9 = null;
		}else{
			$name = $gambar9['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name9 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar9['tmp_name'];
			if($cek_kegiatan9->gambar){
				unlink($path.$cek_kegiatan9->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name9);
		}

		if(empty($gambar10['name'])){
			$new_name10 = null;
		}else{
			$name = $gambar10['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name10 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar10['tmp_name'];
			if($cek_kegiatan10->gambar){
				unlink($path.$cek_kegiatan10->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name10);
		}

		if(empty($gambar11['name'])){
			$new_name11 = null;
		}else{
			$name = $gambar11['name'];
			$ext = explode(".", $name);
			$extensi = end($ext);
			$explode_name = explode(".", $name);
			$random_name = round(microtime(true)).'.'.end($explode_name);
			$new_name11 = md5(date('YmdHis'))."-".$random_name;
			$tmp = $gambar11['tmp_name'];
			if($cek_kegiatan11->gambar){
				unlink($path.$cek_kegiatan11->gambar);
			}
			move_uploaded_file($tmp, $path.''.$new_name11);
		}

		if(empty($deskripsi1)){
			$implode_deskripsi1 = null;
		}else{
			$implode_deskripsi1 = implode('|', $deskripsi1);
		}

		if(empty($deskripsi2)){
			$implode_deskripsi2 = null;
		}else{
			$implode_deskripsi2 = implode('|', $deskripsi2);
		}

		if(empty($deskripsi3)){
			$implode_deskripsi3 = null;
		}else{
			$implode_deskripsi3 = implode('|', $deskripsi3);
		}

		if(empty($deskripsi4)){
			$implode_deskripsi4 = null;
		}else{
			$implode_deskripsi4 = implode('|', $deskripsi4);
		}

		if(empty($deskripsi5)){
			$implode_deskripsi5 = null;
		}else{
			$implode_deskripsi5 = implode('|', $deskripsi5);
		}

		if(empty($deskripsi6)){
			$implode_deskripsi6 = null;
		}else{
			$implode_deskripsi6 = implode('|', $deskripsi6);
		}

		if(empty($deskripsi7)){
			$implode_deskripsi7 = null;
		}else{
			$implode_deskripsi7 = implode('|', $deskripsi7);
		}

		if(empty($deskripsi8)){
			$implode_deskripsi8 = null;
		}else{
			$implode_deskripsi8 = implode('|', $deskripsi8);
		}

		if(empty($deskripsi9)){
			$implode_deskripsi9 = null;
		}else{
			$implode_deskripsi9 = implode('|', $deskripsi9);
		}

		if(empty($deskripsi10)){
			$implode_deskripsi10 = null;
		}else{
			$implode_deskripsi10 = implode('|', $deskripsi10);
		}

		if(empty($deskripsi11)){
			$implode_deskripsi11 = null;
		}else{
			$implode_deskripsi11 = implode('|', $deskripsi11);
		}

		$isPesan = array();
		if($cek_kegiatan1->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi1,
				"gambar" => $new_name1,
			);
			$this->db->where('id', $cek_kegiatan1->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-1 gagal di simpan!";
			}else{
				foreach($deskripsi1 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan1->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-1 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi1 != null){
				$arr = array(
					"detail_id" => $id_detail1,
					"group_kegiatan_id" => $id_group_kegiatan1,
					"deskripsi" => $implode_deskripsi1,
					"gambar" => $new_name1,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-1 gagal di simpan!";
				}else{
					foreach($deskripsi1 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-1 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan2->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi2,
				"gambar" => $new_name2,
			);
			$this->db->where('id', $cek_kegiatan2->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-2 gagal di simpan!";
			}else{
				foreach($deskripsi2 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan2->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-2 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi2 != null){
				$arr = array(
					"detail_id" => $id_detail2,
					"group_kegiatan_id" => $id_group_kegiatan2,
					"deskripsi" => $implode_deskripsi2,
					"gambar" => $new_name2,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-2 gagal di simpan!";
				}else{
					foreach($deskripsi2 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-2 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan3->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi3,
				"gambar" => $new_name3,
			);
			$this->db->where('id', $cek_kegiatan3->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-3 gagal di simpan!";
			}else{
				foreach($deskripsi3 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan3->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-3 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi3 != null){
				$arr = array(
					"detail_id" => $id_detail3,
					"group_kegiatan_id" => $id_group_kegiatan3,
					"deskripsi" => $implode_deskripsi3,
					"gambar" => $new_name3,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-3 gagal di simpan!";
				}else{
					foreach($deskripsi3 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-3 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan4->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi4,
				"gambar" => $new_name4,
			);
			$this->db->where('id', $cek_kegiatan4->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-4 gagal di simpan!";
			}else{
				foreach($deskripsi4 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan4->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-4 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi4 != null){
				$arr = array(
					"detail_id" => $id_detail4,
					"group_kegiatan_id" => $id_group_kegiatan4,
					"deskripsi" => $implode_deskripsi4,
					"gambar" => $new_name4,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-4 gagal di simpan!";
				}else{
					foreach($deskripsi4 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-4 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan5->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi5,
				"gambar" => $new_name5,
			);
			$this->db->where('id', $cek_kegiatan5->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-5 gagal di simpan!";
			}else{
				foreach($deskripsi5 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan5->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-5 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi5 != null){
				$arr = array(
					"detail_id" => $id_detail5,
					"group_kegiatan_id" => $id_group_kegiatan5,
					"deskripsi" => $implode_deskripsi5,
					"gambar" => $new_name5,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-5 gagal di simpan!";
				}else{
					foreach($deskripsi5 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-5 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan6->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi6,
				"gambar" => $new_name6,
			);
			$this->db->where('id', $cek_kegiatan6->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-6 gagal di simpan!";
			}else{
				foreach($deskripsi6 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan6->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-6 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi6 != null){
				$arr = array(
					"detail_id" => $id_detail6,
					"group_kegiatan_id" => $id_group_kegiatan6,
					"deskripsi" => $implode_deskripsi6,
					"gambar" => $new_name6,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-6 gagal di simpan!";
				}else{
					foreach($deskripsi6 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-6 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan7->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi7,
				"gambar" => $new_name7,
			);
			$this->db->where('id', $cek_kegiatan7->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-7 gagal di simpan!";
			}else{
				foreach($deskripsi7 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan7->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-7 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi7 != null){
				$arr = array(
					"detail_id" => $id_detail7,
					"group_kegiatan_id" => $id_group_kegiatan7,
					"deskripsi" => $implode_deskripsi7,
					"gambar" => $new_name7,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-7 gagal di simpan!";
				}else{
					foreach($deskripsi7 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-7 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan8->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi8,
				"gambar" => $new_name8,
			);
			$this->db->where('id', $cek_kegiatan8->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-8 gagal di simpan!";
			}else{
				foreach($deskripsi8 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan8->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-8 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi8 != null){
				$arr = array(
					"detail_id" => $id_detail8,
					"group_kegiatan_id" => $id_group_kegiatan8,
					"deskripsi" => $implode_deskripsi8,
					"gambar" => $new_name8,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-8 gagal di simpan!";
				}else{
					foreach($deskripsi8 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-8 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan9->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi9,
				"gambar" => $new_name9,
			);
			$this->db->where('id', $cek_kegiatan9->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-9 gagal di simpan!";
			}else{
				foreach($deskripsi9 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan9->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-9 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi9 != null){
				$arr = array(
					"detail_id" => $id_detail9,
					"group_kegiatan_id" => $id_group_kegiatan9,
					"deskripsi" => $implode_deskripsi9,
					"gambar" => $new_name9,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-9 gagal di simpan!";
				}else{
					foreach($deskripsi9 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-9 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan10->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi10,
				"gambar" => $new_name10,
			);
			$this->db->where('id', $cek_kegiatan10->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-10 gagal di simpan!";
			}else{
				foreach($deskripsi10 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan10->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-10 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi10 != null){
				$arr = array(
					"detail_id" => $id_detail10,
					"group_kegiatan_id" => $id_group_kegiatan10,
					"deskripsi" => $implode_deskripsi10,
					"gambar" => $new_name10,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-10 gagal di simpan!";
				}else{
					foreach($deskripsi10 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-10 berhasil di simpan!";
				}
			}
		}

		if($cek_kegiatan11->total > 0){
			$arr = array(
				"deskripsi" => $implode_deskripsi11,
				"gambar" => $new_name11,
			);
			$this->db->where('id', $cek_kegiatan11->id);
			$exec = $this->db->update($tb_timeline_kegiatan, $arr);
			if(!$exec){
				$isPesan[] = "Kegitan ke-11 gagal di simpan!";
			}else{
				foreach($deskripsi11 as $desc){
					$arr = array(
						"timeline_kegiatan_id" => $cek_kegiatan11->id,
						"user_id" => $this->session->userdata('USER_ID'),
						"timeline_kegiatan_deskripsi" => $desc,
					);
					$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
				}
				$isPesan[] = "Kegitan ke-11 berhasil di simpan!";
			}
		}else{
			if($implode_deskripsi11 != null){
				$arr = array(
					"detail_id" => $id_detail11,
					"group_kegiatan_id" => $id_group_kegiatan11,
					"deskripsi" => $implode_deskripsi11,
					"gambar" => $new_name11,
				);
				$exec = $this->db->insert($tb_timeline_kegiatan, $arr);
				$last_id = $this->db->insert_id();
				if(!$exec){
					$isPesan[] = "Kegitan ke-11 gagal di simpan!";
				}else{
					foreach($deskripsi11 as $desc){
						$arr = array(
							"timeline_kegiatan_id" => $last_id,
							"user_id" => $this->session->userdata('USER_ID'),
							"timeline_kegiatan_deskripsi" => $desc,
						);
						$this->db->insert($tb_last_update_timeline_kegiatan, $arr);
					}
					$isPesan[] = "Kegitan ke-11 berhasil di simpan!";
				}
			}
		}

		$arr = array('isValid'=>1, 'isPesan'=>$isPesan);
		echo json_encode($arr);
	}

}
