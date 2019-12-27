<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('kegiatan_model');
    }

    function index(){
    	$data['myJS'] = 'kegiatan/myJS';
    	if(!$this->welcome_model->logged_id()){
    		redirect();
    	}else{
    		$data['menu'] = 1;
    	}

    	$this->template->load('template', 'kegiatan/home', $data);
    }

    function get_data_tip()
    {
		$this->load->model('kegiatan_model');
        $list = $this->kegiatan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        // <a class='btn btn-danger btn-sm' onclick ='deleteData($field->id)'><i class='fa fa-trash'></i></a>
        
        foreach ($list as $field) {
			$no++;

            $row = array();
            $row[] = $no;
            $row[] = "
            	
                <a class='btn btn-warning btn-block btn-sm' onclick ='editData($field->id)'><i class='fa fa-edit'></i></a>
            ";
            $row[] = $field->nama;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kegiatan_model->count_all(),
            "recordsFiltered" => $this->kegiatan_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

    function tambah(){
        $this->load->view('kegiatan/modal/tambah_data');
    }

    function simpan(){
        $tb_kegiatan = TB_GROUP_KEGIATAN;
        $nama_kegiatan = $this->input->post('nama_kegiatan');
        $result = $this->kegiatan_model->cek_double($nama_kegiatan,$tb_kegiatan);
        $count = $result->num_rows();

        if($count == 0){
           $result = $this->kegiatan_model->simpan_data($nama_kegiatan,$tb_kegiatan);

            echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses simpan berhasil.</div>');
            redirect('kegiatan'); 
        }else{

            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tersebut sudah ada.</div>');
            redirect('kegiatan');
        }


        
    }

    function edit_kegiatan(){
        $this->load->model('kegiatan_model');
        $tb_kegiatan = TB_GROUP_KEGIATAN;
        $id = $this->input->post('id');
        $data['myJS'] = 'kegiatan/myJS';
        $data['row']=$this->kegiatan_model->get_kegiatan_id($id,$tb_kegiatan);

        $this->load->view('kegiatan/modal/edit_kegiatan', $data);
    }


    function hapus_kegiatan(){
        $id = $this->input->post('id');
        $data['id'] = $id;
        $this->load->view('kegiatan/modal/delete_kegiatan', $data);
    }

    function update(){
        $this->load->model('kegiatan_model');
        $tb_kegiatan = TB_GROUP_KEGIATAN;
        $id = $this->input->post('id');
        $nama_kegiatan = $this->input->post('nama_kegiatan');
        $result = $this->kegiatan_model->cek_double($nama_kegiatan,$tb_kegiatan);
        $count = $result->num_rows();

        if($count == 0){
           $result = $this->kegiatan_model->update_data($id,$nama_kegiatan,$tb_kegiatan);

            echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses update berhasil.</div>');
            redirect('kegiatan'); 
        }else{

            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tersebut sudah ada.</div>');
            redirect('kegiatan');
        }
    }

    function delete_kegiatan(){
        $id = $this->input->post('id');
        $data['id'] = $id;
        $this->load->view('kegiatan/modal/delete_kegiatan', $data);
    }

    function hapus_data(){
        $id = $this->input->post('id');

        $result = $this->db->query("SELECT * from wgm_group_kegiatan_detail  WHERE id_wgm_group_kegiatan ='$id' ");
        $count  = $result->num_rows();

        if($count > 0){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Master tidak bisa dihapus sudah ada detailnya.</div>');
            redirect('kegiatan');
        }else{
            $sql = $this->db->query("DELETE FROM wgm_group_kegiatan WHERE  id ='$id' ");
            if(!$sql) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus gagal.</div>');
                redirect('kegiatan');
            }else {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus berhasil.</div>');
                redirect('kegiatan');
            }
        }

    }
}
