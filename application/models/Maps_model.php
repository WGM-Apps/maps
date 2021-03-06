<?php
class Maps_model extends ci_model{

    
    var $table = TB_DETAIL;
    var $column_order = array(null, 'id');
    var $column_search = array('nama_lokasi', 'kelurahan', 'kecamatan', 'kota', 'provinsi');
    var $order = array(TB_DETAIL.'.id' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select($this->table.".*,".TB_TIPE_BENCANA.".id AS id_bencana,".TB_TIPE_BENCANA.".nama AS nama,");
        $this->db->from($this->table);
        $this->db->join(TB_TIPE_BENCANA, TB_TIPE_BENCANA. '.id =' .$this->table. '.bencana', 'LEFT');
        $this->db->where('flg_active', 'Y');
 
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

    function get_bencana(){
        $hsl=$this->db->query("SELECT * FROM wgm_tipe_bencana ");
        return $hsl;    
    }

    function get_lokasi_id($id){
        $query ="SELECT wd.*, wtb.`nama` AS `nama_bencana` 
                 FROM wgm_detail wd LEFT JOIN wgm_tipe_bencana wtb ON wtb.`id`=wd.`bencana` WHERE wd.`id`='$id' ";
        $hsl=$this->db->query($query);
        return $hsl;    
    }

    function update_maps($id,$bencana,$tgl_kejadian,$nama_lokasi,$kelurahan,$kecamatan,$kota,$provinsi,$dampak,$kebutuhan,$pic,$hp,$posko,$anggaran,$sumber_daya){

        $deskripsidampak ="";
        $deskripsikebutuhan ="";
        $desksumberdaya ="";
        $deskripsipic ="";

        for ($i=0; $i < count($sumber_daya) ; $i++) { 
            $desksumberdaya .=$sumber_daya[$i]."|";
        }

        $desksumberdaya = substr($desksumberdaya,0,strlen($desksumberdaya) - 1);


        for ($i=0; $i < count($dampak) ; $i++) { 
            $deskripsidampak .=$dampak[$i]."|";
        }

        $deskripsidampak = substr($deskripsidampak,0,strlen($deskripsidampak) - 1);


        for ($i=0; $i < count($kebutuhan) ; $i++) { 
            $deskripsikebutuhan .=$kebutuhan[$i]."|";
        }

        $deskripsikebutuhan = substr($deskripsikebutuhan,0,strlen($deskripsikebutuhan) - 1);

        for ($i=0; $i < count($pic) ; $i++) { 
            $deskripsipic .=$pic[$i]."-".$hp[$i]."|";
        }

        $deskripsipic = substr($deskripsipic,0,strlen($deskripsipic) - 1);


        $query ="UPDATE wgm_detail SET bencana ='$bencana',tgl_kejadian ='$tgl_kejadian',
                              nama_lokasi ='$nama_lokasi',kelurahan ='$kelurahan' ,kecamatan ='$kecamatan',
                              kota ='$kota',provinsi ='$provinsi',dampak ='$deskripsidampak',kebutuhan ='$deskripsikebutuhan',
                              pic ='$deskripsipic' ,posko ='$posko',anggaran ='$anggaran',sumber_daya ='$desksumberdaya'
                              WHERE id ='$id'";
        
        $hsl=$this->db->query($query);

        return $hsl;  
    }
}