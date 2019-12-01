<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('maps_model');
        $this->load->model('welcome_model');

    }

    function maps(){
    	$data['result'] = $this->db->get(TB_TIPE_BENCANA)->result();
    	$data['myJS']   = 'maps/myJS';
    	if(!$this->welcome_model->logged_id()){
    		redirect();
    	}else{
    		$data['menu'] = 1;
    	}

    	$this->template->load('template','maps/home',$data);
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
		}elseif(empty($tgl_kejadian)) {
			$isValid = 0;
			$isPesan = "Tgl Kejadian wajib disi";
		}elseif(empty($nama_lokasi)) {
			$isValid = 0;
			$isPesan = "Nama lokasi wajib disi";
		}elseif(empty($kelurahan)) {
			$isValid = 0;
			$isPesan = "Kelurahan wajib diisi";
		}elseif(empty($kecamatan)) {
			$isValid = 0;
			$isPesan = "Kecamtan wajib diisi";
		}elseif(empty($kota)) {
			$isValid = 0;
			$isPesan = "Kota wajib diisi";
		}elseif(empty($provinsi)) {
			$isValid = 0;
			$isPesan = "Provinsi wajib diisi";
		}elseif(empty($dampak)) {
			$isValid = 0;
			$isPesan = "Dampak wajib diisi";
		}elseif(empty($kebutuhan)) {
			$isValid = 0;
			$isPesan = "Kebutuhan wajib diisi";
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

	function delete_maps(){
		$id = $this->input->post('id');

		$sql = $this->db->query("UPDATE  wgm_detail set flg_active = 'N' WHERE id ='$id' ");
		if(!$sql) {
			echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus gagal.</div>');
			redirect('maps');
		}else {
			echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus berhasil.</div>');
			redirect('maps');
		}
	}

	function get_data_tip()
    {
		$this->load->model('maps_model');
        $list = $this->maps_model->get_datatables();
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
            	<a class='btn btn-danger btn-sm' onclick ='delete_maps($field->id)'><i class='fa fa-trash'></i></a>
                <a class='btn btn-primary btn-sm' onclick ='edit_maps($field->id)'><i class='fa fa-edit'></i></a>
                <a class='btn btn-warning btn-sm' href='https://www.google.com/maps?q=loc:$field->lat,$field->lng' target='_blank' title='Buka Google Maps'><i class='fa fa-map'></i></a>
            ";
            $row[] = $bencana;
            $row[] = $field->nama_lokasi.", ".$field->kelurahan.", ".$field->kecamatan.", ".$field->kota.", ".$field->provinsi;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->maps_model->count_all(),
            "recordsFiltered" => $this->maps_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

	function edit_maps(){
		$this->load->model('maps_model');
		$id = $this->input->post('id');
		$data['myJS'] = 'maps/myJS';

		$x['bencana']=$this->maps_model->get_bencana();
		$x['row']=$this->maps_model->get_lokasi_id($id);

		$this->load->view('maps/modal/edit_maps', $x);
	}


	function hapus_data(){
		$id = $this->input->post('id');
		$data['id'] = $id;
		$this->load->view('maps/modal/delete_maps', $data);
	}

	function update_maps(){
		$this->load->model('maps_model');
		$id = $this->input->post('id');
		$bencana = $this->input->post('bencana');
		$tgl_kejadian = $this->input->post('tgl_kejadian');
		$nama_lokasi = $this->input->post('nama_lokasi');
		$kelurahan = $this->input->post('kelurahan');
		$kecamatan = $this->input->post('kecamatan');
		$kota = $this->input->post('kota');
		$provinsi = $this->input->post('provinsi');
		$dampak = $this->input->post('dampak');
		$kebutuhan = $this->input->post('kebutuhan');


		$this->maps_model->update_maps($id,$bencana,$tgl_kejadian,$nama_lokasi,$kelurahan,$kecamatan,$kota,$provinsi,$dampak,$kebutuhan);

		echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Maps Berhasil diupdate.</div>');
		redirect('maps');

	}

	function list_bencana(){
		$id = $this->input->get('id');

		$this->load->view('maps/modal/delete_maps', $data);
	}
}
