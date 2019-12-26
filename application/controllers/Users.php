<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('users_model');
    }

    function index(){
    	$data['myJS'] = 'users/myJS';
    	if(!$this->welcome_model->logged_id()){
    		redirect();
    	}else{
    		$data['menu'] = 1;
    	}

    	$this->template->load('template', 'users/home', $data);
    }

    function get_data_tip()
    {
		$this->load->model('users_model');
        $list = $this->users_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $field) {
			$no++;

            $row = array();
            $row[] = $no;
            $row[] = "
                <a class='btn btn-warning btn-sm' onclick ='editData($field->id)'><i class='fa fa-edit'></i></a>
                <a class='btn btn-danger btn-sm' onclick ='deleteData($field->id)'><i class='fa fa-trash'></i></a>
            ";
            $row[] = $field->user;
            $row[] = $field->nama;
            $row[] = $field->akses;
            $row[] = $field->flg_active;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->users_model->count_all(),
            "recordsFiltered" => $this->users_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}

    function tambah(){
        $this->load->view('users/modal/tambah_data');
    }

    function simpan(){
        $tb_users = TB_USER;
        $nama = $this->input->post('nama');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $akses = $this->input->post('akses');
        $aktif = $this->input->post('aktif');
        if(strlen($username)<3){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Nama Pengguna Minimal 3 Karakter.</div>');
            redirect('users');
        }elseif(empty($nama)){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Nama Lengkap Tidak Boleh Kosong.</div>');
            redirect('users');
        }elseif(strlen($password)<3){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Kata Kunci Minimal 3 Karakter.</div>');
            redirect('users');
        }else{
            $arr = array(
                'user'=>$username,
                'password'=>md5($password),
                'nama'=>$nama,
                'akses'=>$akses,
                'flg_active'=>$aktif
            );
            $result = $this->users_model->cek_double($username,$tb_users);
            $count = $result->num_rows();

            if($count == 0){
                $result = $this->users_model->simpan_data($arr,$tb_users);

                echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses simpan berhasil.</div>');
                redirect('users'); 
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Nama Pengguna Sudah Terpakai.</div>');
                redirect('users');
            }
        }
    }

    function edit_data(){
        $this->load->model('users_model');
        $tb_users = TB_USER;
        $id = $this->input->post('id');
        $data['myJS'] = 'users/myJS';
        $data['row']=$this->users_model->get_users_id($id,$tb_users);

        $this->load->view('users/modal/edit_data', $data);
    }

    function update(){
        $this->load->model('users_model');
        $tb_users = TB_USER;
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $akses = $this->input->post('akses');
        $aktif = $this->input->post('aktif');
        if(strlen($username)<3){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Nama Pengguna Minimal 3 Karakter.</div>');
            redirect('users');
        }elseif(empty($nama)){
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Nama Lengkap Tidak Boleh Kosong.</div>');
            redirect('users');
        }else{
            if(empty($password)){
                $arr = array(
                    'user'=>$username,
                    'nama'=>$nama,
                    'akses'=>$akses,
                    'flg_active'=>$aktif
                );
            }else{
                $arr = array(
                    'user'=>$username,
                    'password'=>md5($password),
                    'nama'=>$nama,
                    'akses'=>$akses,
                    'flg_active'=>$aktif
                );
            }
            $result = $this->users_model->cek_double($username,$tb_users);
            $count = $result->num_rows();

            if($count == 0){
                $result = $this->users_model->update_data($id,$arr,$tb_users);

                echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses update berhasil.</div>');
                redirect('users'); 
            }else{
                $exist = $this->db->query("SELECT * FROM $tb_users WHERE id='$id'")->row();
                if($exist->user!=$username){
                    echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tersebut sudah ada.</div>');
                }else{
                    $result = $this->users_model->update_data($id,$arr,$tb_users);
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses update berhasil.</div>');
                }
                redirect('users');
            }
        }
    }

    function delete_users(){
        $id = $this->input->post('id');
        $data['id'] = $id;
        $this->load->view('users/modal/delete_data', $data);
    }

    function hapus_data(){
        $id = $this->input->post('id');
        $tb_users = TB_USER;
        $sql = $this->db->query("DELETE FROM $tb_users WHERE id ='$id' ");
        if(!$sql) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus gagal.</div>');
            redirect('users');
        }else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Proses hapus berhasil.</div>');
            redirect('users');
        }

    }
}
