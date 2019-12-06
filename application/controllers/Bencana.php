<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bencana extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('bencana_model');
    }

    function index(){
    	$data['myJS'] = 'bencana/myJS';
    	if(!$this->welcome_model->logged_id()){
    		redirect();
    	}else{
    		$data['menu'] = 1;
    	}

    	$this->template->load('template', 'bencana/home', $data);
    }

    function get_data_tip()
    {
		$this->load->model('bencana_model');
        $list = $this->bencana_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        // <a class='btn btn-danger btn-sm' onclick ='deleteData($field->id)'><i class='fa fa-trash'></i></a>
        
        foreach ($list as $field) {
			$no++;

            $row = array();
            $row[] = $no;
            $row[] = "
            	
                <a class='btn btn-warning btn-sm' onclick ='editData($field->id)'><i class='fa fa-edit'></i></a>
            ";
            $row[] = $field->nama;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->bencana_model->count_all(),
            "recordsFiltered" => $this->bencana_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

    function tambah(){
        $this->load->view('bencana/modal/tambah_data');
    }

    function simpan(){
        $tb_bencana = TB_TIPE_BENCANA;
        $nama_bencana = $this->input->post('nama_bencana');
        $result = $this->bencana_model->cek_double($nama_bencana,$tb_bencana);
        $count = $result->num_rows();

        if($count == 0){
           $result = $this->bencana_model->simpan_data($nama_bencana,$tb_bencana);

            echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses simpan berhasil.</div>');
            redirect('bencana'); 
        }else{

            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tersebut sudah ada.</div>');
            redirect('bencana');
        }


        
    }

    function edit_bencana(){
        $this->load->model('bencana_model');
        $tb_bencana = TB_TIPE_BENCANA;
        $id = $this->input->post('id');
        $data['myJS'] = 'bencana/myJS';
        $data['row']=$this->bencana_model->get_bencana_id($id,$tb_bencana);

        $this->load->view('bencana/modal/edit_bencana', $data);
    }


    function hapus_bencana(){
        $id = $this->input->post('id');
        $data['id'] = $id;
        $this->load->view('bencana/modal/delete_bencana', $data);
    }

    function update(){
        $this->load->model('bencana_model');
        $tb_bencana = TB_TIPE_BENCANA;
        $id = $this->input->post('id');
        $nama_bencana = $this->input->post('nama_bencana');
        $result = $this->bencana_model->cek_double($nama_bencana,$tb_bencana);
        $count = $result->num_rows();

        if($count == 0){
           $result = $this->bencana_model->update_data($id,$nama_bencana,$tb_bencana);

            echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses update berhasil.</div>');
            redirect('bencana'); 
        }else{

            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tersebut sudah ada.</div>');
            redirect('bencana');
        }
    }

    function delete_bencana(){
        $id = $this->input->post('id');
        $data['id'] = $id;
        $this->load->view('bencana/modal/delete_bencana', $data);
    }

    function hapus_data(){
        $id = $this->input->post('id');

        $result = $this->db->query("SELECT * from wgm_detail  WHERE bencana ='$id' ");
        $count  = $result->num_rows();

        if($count > 0){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Master tidak bisa dihapus sudah ada detailnya.</div>');
            redirect('bencana');
        }else{
            $sql = $this->db->query("DELETE FROM wgm_tipe_bencana WHERE  id ='$id' ");
            if(!$sql) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus gagal.</div>');
                redirect('bencana');
            }else {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus berhasil.</div>');
                redirect('bencana');
            }
        }

    }
}
