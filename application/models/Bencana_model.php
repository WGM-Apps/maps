<?php
class Bencana_model extends ci_model{
	
	var $table = TB_TIPE_BENCANA;
    var $column_order = array(null, 'id');
    var $column_search = array('nama');
    var $order = array('id' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function cek_double($nama,$table){
        $hsl=$this->db->query("SELECT * from $table WHERE nama ='$nama'  ");
        return $hsl; 
    }

    function simpan_data($nama,$table,$gambar){
         $hsl=$this->db->query("INSERT INTO $table (nama,icon) VALUES ('$nama','$gambar') ");
        return $hsl;
    }

    function get_bencana_id($id,$table){
        $hsl=$this->db->query("SELECT * from $table WHERE id ='$id' ");
        return $hsl; 
    }

    function update_data($id,$nama,$table){
         $hsl=$this->db->query("UPDATE $table SET nama ='$nama' WHERE id ='$id' ");
        return $hsl;
    }
}