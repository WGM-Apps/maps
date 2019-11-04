<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		// $bencana = $this->input->post('bencana');
		$bencana = $this->uri->segment(3);
		if(!empty($bencana)){
			$this->db->where('bencana', $bencana);
		}
		$data['result'] = $this->db->get(TB_DETAIL)->result();
		$data['myJS'] = 'dashboard/myJS';
		$this->template->load('template', 'dashboard/home', $data);
	}

	function maps() {
		$data['result'] = $this->db->get(TB_TIPE_BENCANA)->result();
		$data['myJS'] = 'maps/myJS';
		$this->template->load('template', 'maps/home', $data);
	}

	function simpan_maps() {
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		$bencana = $this->input->post('bencana');
		$nama_lokasi = $this->input->post('nama_lokasi');
		$kelurahan = $this->input->post('kelurahan');
		$kecamatan = $this->input->post('kecamatan');
		$kota = $this->input->post('kota');
		$provinsi = $this->input->post('provinsi');
		$deskripsi = $this->input->post('deskripsi');
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
				'nama_lokasi' => strtoupper($nama_lokasi),
				'kelurahan' => strtoupper($kelurahan),
				'kecamatan' => strtoupper($kecamatan),
				'kota' => strtoupper($kota),
				'provinsi' => strtoupper($provinsi),
				'deskripsi' => strtoupper($deskripsi),
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
            $row[] = $field->lat;
            $row[] = $field->lng;
            $row[] = $bencana;
            $row[] = $field->nama_lokasi.", ".$field->kelurahan.", ".$field->kecamatan.", ".$field->kota.", ".$field->provinsi;
            $row[] = $field->deskripsi;
            $row[] = "
                <a class='btn btn-primary text-light btn-sm' href='javascript:void(0)' data-toggle='modal' data-target='#viewKepatuhanMatriks' data-id='$field->id' title='Lihat Matriks'><i class='fa fa-table'></i></a>

                <a class='btn btn-warning text-light btn-sm' href='".base_url($field->id)."' title='Edit'><i class='fa fa-edit'></i></a>
            ";
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
	
}
