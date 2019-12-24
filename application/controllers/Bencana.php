<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bencana extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('bencana_model');
        $this->load->library('upload');
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
        $size = 200;
        $nama_bencana = $this->input->post('nama_bencana');
        $nama = strtolower($nama_bencana);

        if(empty($nama_bencana)){
            $isValid = 0;
            $isPesan = 'Nama bencana tidak boleh kosong !!!';
            $json = array("isValid" => $isValid, "isPesan" => $isPesan);
            echo json_encode($json);
            die();
        }

        if(empty($_FILES)){
            $isValid = 0;
            $isPesan = 'File icon tidak boleh kosong !!!';
            $json = array("isValid" => $isValid, "isPesan" => $isPesan);
            echo json_encode($json);
            die();
        }

        if(!empty($_FILES)) {
            $dir_base = $_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])."assets/icon_marker/";
            $dir_file = $dir_base;

            if(!file_exists($dir_file)){
                mkdir("$dir_file");
                chmod("$dir_file", 0777);
            }

            $fileName = $_FILES['file_icon']['name'] ;
            $fileTmpName = $_FILES['file_icon']['tmp_name'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('gif','jpg','jpeg','png','.pdf');
            $file_ext = substr($fileName, strripos($fileName, '.'));
            $file_basename= substr($fileName, 0, strripos($fileName, '.'));
            $newfilename = $nama.$file_ext;


            if (in_array($fileActualExt, $allowed)) {
                
                if(move_uploaded_file($fileTmpName,$dir_file.$newfilename)) {

                    $query ="SELECT * from $tb_bencana WHERE nama ='$nama_bencana' ";
                    $result = $this->db->query($query);
                    $jml = $result->num_rows();

                    if($jml > 0){
                        $isValid = 0;
                        $isPesan = 'Nama bencana sudah ada !!!'; 
                    }else{
                        $query = "INSERT INTO $tb_bencana(nama, icon)
                        VALUES ('$nama_bencana', '$newfilename')";
             

                        $exe = $this->db->query($query);
                        if(!$exe){
                            $isValid = 0;
                            $isPesan = "Data gagal tersimpan, error : ".mysqli_error($KONEKSI);
                        }else{
                            $isValid = 1;
                            $isPesan = "Upload Sukses !!!";
                        }
                    }

                    
                }else{
                    $isValid = 0;
                    $isPesan = 'File gagal terkirim, Silahkan coba kembali !!!';
                }
            }else {
                $isValid = 0;
                $isPesan = 'Tipe File Tidak Diizinkan !!!';
            }


            $json = array("isValid" => $isValid, "isPesan" => $isPesan);
            echo json_encode($json);
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
        $tb_bencana = TB_TIPE_BENCANA;
        $size = 200;
        $nama_bencana = $this->input->post('nama_bencana');
        $id = $this->input->post('id');
        $nama = strtolower($nama_bencana);

        if(empty($nama_bencana)){
            $isValid = 0;
            $isPesan = 'Nama bencana tidak boleh kosong !!!';
            $json = array("isValid" => $isValid, "isPesan" => $isPesan);
            echo json_encode($json);
            die();
        }

        if(empty($_FILES)){
            $isValid = 0;
            $isPesan = 'File icon tidak boleh kosong !!!';
            $json = array("isValid" => $isValid, "isPesan" => $isPesan);
            echo json_encode($json);
            die();
        }

        if(!empty($_FILES)) {
            $dir_base = $_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])."assets/icon_marker/";
            $dir_file = $dir_base;

            if(!file_exists($dir_file)){
                mkdir("$dir_file");
                chmod("$dir_file", 0777);
            }

            $fileName = $_FILES['file_icon']['name'] ;
            $fileTmpName = $_FILES['file_icon']['tmp_name'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('gif','jpg','jpeg','png','.pdf');
            $file_ext = substr($fileName, strripos($fileName, '.'));
            $file_basename= substr($fileName, 0, strripos($fileName, '.'));
            $newfilename = $nama.$file_ext;


            if (in_array($fileActualExt, $allowed)) {
                
                if(move_uploaded_file($fileTmpName,$dir_file.$newfilename)) {

                    $query ="SELECT * from $tb_bencana WHERE nama ='$nama_bencana' <>  id ='$id' ";
                    $result = $this->db->query($query);
                    $jml = $result->num_rows();

                    if($jml > 0){
                        $isValid = 0;
                        $isPesan = 'Nama bencana sudah ada !!!'; 
                    }else{
                        $query = "UPDATE $tb_bencana SET nama ='$nama_bencana' , icon ='$newfilename' WHERE id ='$id' ";
                        $exe = $this->db->query($query);
                        if(!$exe){
                            $isValid = 0;
                            $isPesan = "Data gagal tersimpan, error : ".mysqli_error($KONEKSI);
                        }else{
                            $isValid = 1;
                            $isPesan = "Upload Sukses !!!";
                        }
                    }

                    
                }else{
                    $isValid = 0;
                    $isPesan = 'File gagal terkirim, Silahkan coba kembali !!!';
                }
            }else {
                $isValid = 0;
                $isPesan = 'Tipe File Tidak Diizinkan !!!';
            }


            $json = array("isValid" => $isValid, "isPesan" => $isPesan);
            echo json_encode($json);
        }
    }

    // function update(){
    //     $this->load->model('bencana_model');
    //     $tb_bencana = TB_TIPE_BENCANA;
    //     $id = $this->input->post('id');
    //     $nama_bencana = $this->input->post('nama_bencana');
    //     $result = $this->bencana_model->cek_double($nama_bencana,$tb_bencana);
    //     $count = $result->num_rows();

    //     if($count == 0){
    //        $result = $this->bencana_model->update_data($id,$nama_bencana,$tb_bencana);

    //         echo $this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> Proses update berhasil.</div>');
    //         redirect('bencana'); 
    //     }else{

    //         echo $this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tersebut sudah ada.</div>');
    //         redirect('bencana');
    //     }
    // }

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
