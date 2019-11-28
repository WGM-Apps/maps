<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
    }

	public function index()
	{
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		// $bencana = $this->input->post('bencana');
		$bencana = $this->uri->segment(3);
		$where_bencana = null;
		if(!empty($bencana)){
			// $this->db->where('bencana', $bencana);
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

	function simpan_maps() {
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		$bencana = $this->input->post('bencana');
		$tgl_kejadian = $this->input->post('tgl_kejadian');
		$nama_lokasi = $this->input->post('nama_lokasi');
		$kelurahan = $this->input->post('kelurahan');
		$kecamatan = $this->input->post('kecamatan');
		$kota = $this->input->post('kota');
		$provinsi = $this->input->post('provinsi');
		$dampak = $this->input->post('dampak');
		$kebutuhan = $this->input->post('kebutuhan');
		$date_now = date('Y-m-d');

		if(empty($lat) || empty($lng)) {
			$isValid = 0;
			$isPesan = "Latitude dan Longtitude tidak boleh kosong";
		}elseif(empty($bencana)) {
			$isValid = 0;
			$isPesan = "Pilih salah satu bencana";
		}else {
			$arr = array(
				'lat' => strtoupper($lat),
				'lng' => strtoupper($lng),
				'bencana' => strtoupper($bencana),
				'tgl_kejadian' => strtoupper($tgl_kejadian),
				'nama_lokasi' => strtoupper($nama_lokasi),
				'kelurahan' => strtoupper($kelurahan),
				'kecamatan' => strtoupper($kecamatan),
				'kota' => strtoupper($kota),
				'provinsi' => strtoupper($provinsi),
				'dampak' => strtoupper($dampak),
				'kebutuhan' => strtoupper($kebutuhan),
				'create_date' => $date_now,
				'flg_active' => 'Y',
			);
			$sql = $this->db->insert(TB_DETAIL, $arr);
			if(!$sql) {
				$isValid = 0;
				$isPesan = "Gagal menyimpan lokasi bencana";
			}else {
				$isValid = 1;
				$isPesan = "Berhasil menyimpan lokasi bencana";
			}
		}
		$arr = array(
			'isValid' => $isValid,
			'isPesan' => $isPesan
		);
		echo json_encode($arr);
	}

	function get_data_tip()
    {
		$this->load->model('welcome_model');
        $list = $this->welcome_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $field) {
			$no++;
			if($field->bencana == '1'){
				$bencana = "Gempa Bumi";
			}elseif($field->bencana == '2'){
				$bencana = "Gunung Meletus";
			}elseif($field->bencana == '2'){
				$bencana = "Tsunami";
			}else{
				$bencana = "Lainnya";
			}

            $row = array();
            $row[] = $no;
            $row[] = "
                <a class='btn btn-primary text-light btn-sm' href='javascript:void(0)' data-toggle='modal' data-target='#viewKepatuhanMatriks' data-id='$field->id' title='Lihat Matriks'><i class='fa fa-table'></i></a>

                <a class='btn btn-warning text-light btn-sm' href='".base_url($field->id)."' title='Edit'><i class='fa fa-edit'></i></a>

                <a class='btn btn-success text-light btn-sm' href='https://www.google.com/maps?q=loc:$field->lat,$field->lng' target='_blank' title='Buka Google Maps'><i class='fa fa-map'></i></a>
            ";
            $row[] = $bencana;
            $row[] = $field->nama_lokasi.", ".$field->kelurahan.", ".$field->kecamatan.", ".$field->kota.", ".$field->provinsi;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->welcome_model->count_all(),
            "recordsFiltered" => $this->welcome_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	function get_detail_koordinat() {
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		$tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
		$id = $this->input->post('id');
		
		// $query = "SELECT wd.*, wtb.`nama` AS `nama_bencana` FROM $tb_detail wd LEFT JOIN $tb_bencana wtb ON wtb.`id`=wd.`bencana` WHERE wd.`id`='$id'";
		// $data['row'] = $this->db->query($query)->row();

		$query = "SELECT wd.*, wtb.`nama` AS `nama_bencana` FROM $tb_detail wd LEFT JOIN $tb_bencana wtb ON wtb.`id`=wd.`bencana` WHERE wd.`id`='$id'";

		$data['row'] = $this->db->query($query)->row();

		$this->load->view('dashboard/detail_koordinat', $data);
	}
}
