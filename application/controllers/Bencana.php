<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bencana extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('bencana_model');
        $this->load->model('welcome_model');
    }

    function index(){
    	$data['myJS']   = 'maps/myJS';
    	if(!$this->welcome_model->logged_id()){
    		redirect();
    	}else{
    		$data['menu'] = 1;
    	}

    	$this->template->load('template','bencana/home',$data);
    }

    function get_data_tip()
    {
		$this->load->model('bencana_model');
        $list = $this->bencana_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $field) {
			$no++;

            $row = array();
            $row[] = $no;
            $row[] = "
            	<a class='btn btn-danger btn-sm' onclick ='delete_maps($field->id)'><i class='fa fa-trash'></i></a>
                <a class='btn btn-primary btn-sm' onclick ='edit_maps($field->id)'><i class='fa fa-edit'></i></a>
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

	
}
