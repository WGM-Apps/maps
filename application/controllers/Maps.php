<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('maps_model');
    }

    function index(){
    	$data['myJS'] = 'maps/myJS';
    	if(!$this->welcome_model->logged_id()){
    		redirect();
    	}else{
    		$data['menu'] = 1;
    	}
    	$this->load->template('maps/home',$data);
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
		$pic = $this->input->post('pic');
		$hp = $this->input->post('hp');
		$posko = $this->input->post('posko');
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
		}elseif(empty($dampak)) {
			$isValid = 0;
			$isPesan = "Dampak wajib diisi";
		}elseif(empty($kebutuhan)) {
			$isValid = 0;
			$isPesan = "Kebutuhan wajib diisi";
		}else {

			$deskripsipic ="";

			for ($i=0; $i < count($pic) ; $i++) { 
	            $deskripsipic .=$pic[$i]."-".$hp[$i]."|";
	        }

	        $deskripsipic = substr($deskripsipic,0,strlen($deskripsipic) - 1);

			$explode_dampak = implode('|', $dampak);
			$explode_kebutuhan = implode('|', $kebutuhan);
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
				'dampak' => strtoupper($explode_dampak),
				'kebutuhan' => strtoupper($explode_kebutuhan),
				'pic'=> strtoupper($deskripsipic),
				'posko' =>strtoupper($posko),
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

            $row = array();
            $row[] = $no;
            $row[] = "
            	<a class='btn btn-danger btn-sm' onclick ='delete_maps($field->id)'><i class='fa fa-trash'></i></a>
                <a class='btn btn-primary btn-sm' onclick ='edit_maps($field->id)'><i class='fa fa-edit'></i></a>
                <a class='btn btn-warning btn-sm' href='https://www.google.com/maps?q=loc:$field->lat,$field->lng' target='_blank' title='Buka Google Maps'><i class='fa fa-map'></i></a>
            ";
            $row[] = $field->nama;
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
		$sumber_daya = $this->input->post('sumber_daya');
		$pic = $this->input->post('pic');
		$hp = $this->input->post('hp');
		$posko = $this->input->post('posko');
		$anggaran = $this->input->post('anggaran');


		$this->maps_model->update_maps($id,$bencana,$tgl_kejadian,$nama_lokasi,$kelurahan,$kecamatan,$kota,$provinsi,$dampak,$kebutuhan,$pic,$hp,$posko,$anggaran,$sumber_daya);

		echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Maps Berhasil diupdate.</div>');
		redirect('maps');

	}

	function list_bencana(){
		$id = $this->input->get('id');

		$this->load->view('maps/modal/delete_maps');
	}

	function export_excel(){
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		header('Pragma: public');
	    header('Cache-control: private');
	    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	    header("Content-type: application/x-msexcel; charset=utf-8");
	    header("Content-Disposition: attachment; filename=Report Data Maps.xlsx");
	    header("Pragma: no-cache");
	    header("Expires: 0");

	    $periode_awal = $this->input->post('periode_awal');
	    $periode_akhir = $this->input->post('periode_akhir');

	    $query = "SELECT * 
	              FROM $tb_detail wd LEFT JOIN $tb_bencana wtb ON wtb.`id` = wd.`bencana` 
	              WHERE wd.tgl_kejadian >='$periode_awal' AND wd.tgl_kejadian <='$periode_akhir' ";

	    $execQuery = $this->db->query($query);
	    if($execQuery){
	        echo "<style>
	                table{
	                    border-collapse: collapse;
	                }
	                th{
	                    background-color:blue;
	                    color:white;
	                }
	                th, td {
	                    border-color: rgba(121, 117, 117, 0.6);
	                    border-style: solid !important;
	                    border-width : 0.3pt;
	                }
	                .str{
	                    mso-number-format:\@;
	                }
	               </style>
	                <h1>REPORT DATA MAPS ALL</h1>
	                <table>
	                <tr>
	                    <TH>Nama Bencana</TH>
	                    <TH>Tgl kejadian</TH>
	                    <TH>Lokasi</TH>
	                    <TH>Kelurahan</TH>
	                    <TH>Kecamatan</TH>
	                    <TH>Kota</TH>
	                    <TH>Provinsi</TH>
	                    <TH>Dampak</TH>
	                    <TH>Kebutuhan</TH>
	                    
	                </tr>";

	        $rows = $execQuery->result_array();
	        foreach ($rows as $data) {

	        	
	        	echo "<tr>
	                    <td class ='str'>".$data['nama']."</td>
	                    <td class ='str'>".date('d-m-Y',strtotime($data['tgl_kejadian']))."</td>
	                    <td class ='str'>".$data['nama_lokasi']."</td>
	                    <td class ='str'>".$data['kelurahan']."</td>
	                    <td class ='str'>".$data['kecamatan']."</td>
	                    <td class ='str'>".$data['kota']."</td>
	                    <td class ='str'>".$data['provinsi']."</td>
	                    <td class ='str'>".$data['dampak']."</td>
	                    <td class ='str'>".$data['kebutuhan']."</td>
	                </tr>";
	        }

	        echo '</table>';
	    }else{
	        echo "
	            <table border=1 style='border: 1px solid black'>
	                <tr><h4>INVALID</h4></tr>
	            </table>";
	    }
	}
}
