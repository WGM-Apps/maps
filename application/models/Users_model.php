<?php
class Users_model extends ci_model{
	
	var $table = TB_USER;
    var $column_order = array(null, 'id');
    var $column_search = array('nama','user');
    var $order = array('nama' => 'ASC');

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

    function cek_double($user,$table){
        $hsl=$this->db->query("SELECT * from $table WHERE user ='$user'  ");
        return $hsl; 
    }

    function simpan_data($arr,$table){
         $hsl=$this->db->insert($table, $arr);
        return $hsl;
    }

    function get_users_id($id,$table){
        $hsl=$this->db->query("SELECT * from $table WHERE id ='$id' ");
        return $hsl; 
    }

    function update_data($id,$arr,$table){
        $this->db->where('id', $id);
         $hsl=$this->db->update($table, $arr);
        return $hsl;
    }
}