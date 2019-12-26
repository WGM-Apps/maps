<?php
Class Report_respon extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->library('pdf');
    }
    
    function pdf(){
		$tb_user = TB_USER;
		$tb_detail = TB_DETAIL;
		$tb_bencana = TB_TIPE_BENCANA;
		$tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
		$tb_group_kegiatan = TB_GROUP_KEGIATAN;
		$tb_last_update_timeline_kegiatan = TB_LAST_UPDATE_TIMELINE_KEGIATAN;
        $id = $this->uri->segment(3);
        $bg = base_url('assets/icon_marker/logo.png');
        // $bg1 = base_url('assets/icon_marker/s.jpg');
        $row = $this->db->query("SELECT wd.*, wtb.`nama` AS `nama_bencana`, wtb.`icon` AS `icon_bencana` FROM $tb_detail wd LEFT JOIN $tb_bencana wtb ON wtb.`id` = wd.`bencana` WHERE wd.`id`='$id'")->row();

        $result = $this->db->query("SELECT wtk.*, wgk.`id` AS wgk_id, wgk.`nama` AS wgk_nama FROM $tb_timeline_kegiatan wtk LEFT JOIN $tb_group_kegiatan wgk ON wgk.`id` = wtk.`group_kegiatan_id` WHERE wtk.`detail_id` = '$row->id'")->result();
		
		$query_penerima_manfaat = "SELECT deskripsi FROM $tb_timeline_kegiatan WHERE detail_id ='$row->id'";
		$result_penerima_manfaat = $this->db->query($query_penerima_manfaat);
		$a ="";
		$jml = 0;
		foreach ($result_penerima_manfaat->result_array() as $x) {
			$a = $x['deskripsi'];
			$exs = explode('|', $a);
			foreach ($exs as $b ) {
				$c = explode('^',$b);
				$jml += (int)$c[1];
			}
		}
		// $data['penerima_manfaat'] = $jml;
        
        // echo "<title>$row->nama_bencana</title>";
        $pdf = new FPDF('P','mm','A4');
        $pdf->SetTitle($row->nama_bencana);
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        // $pdf->Image($bg1,0,0,210);
        $pdf->Image($bg,150,10,50);

        $pdf->SetTextColor(44,161,219);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,5,"#SITUATION REPORT PERIODE ".strtoupper(date('d F Y')),0,1,'L');

        $pdf->Cell(10,5,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',50);
        $pdf->MultiCell(130,10,$row->nama_bencana,0,'L');

        // $pdf->Cell(10,5,'',0,1);
        // $pdf->SetTextColor(255,132,37);
        // $pdf->SetFont('Arial','B',20);
        // $pdf->MultiCell(190,5,$row->nama_lokasi,0,'L');

        // $pdf->Cell(10,5,'',0,1);
        // $pdf->SetTextColor(255,132,37);
        // $pdf->SetFont('Arial','B',20);
        // $pdf->MultiCell(190,5,$row->kota,0,'L');

        $pdf->Cell(10,5,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',20);
        $pdf->MultiCell(190,5,$row->provinsi,0,'L');

        $pdf->Cell(10,10,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(190,5,"DAMPAK",0,1,'L');
        // $pdf->SetDrawColor(255,132,37);
        // $pdf->Cell(190,1,'','B',1,'L');

        $pdf->Cell(10,3,'',0,1);
        $explode = explode('|',$row->dampak);
        $no = 1;
        foreach($explode as $ex):
            if($ex){
                $pdf->SetTextColor(255,255,255);
                $pdf->SetFont('Arial','',10);
                $pdf->MultiCell(190,5,$no++.". ".$ex,0,'L');
            }
        endforeach;
        // $pdf->MultiCell(190,5,"asd",0,'L');

        $pdf->Cell(10,10,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(190,5,"KEBUTUHAN DARURAT",0,1,'L');
        // $pdf->SetDrawColor(255,132,37);
        // $pdf->Cell(190,1,'','B',1,'L');

        $pdf->Cell(10,3,'',0,1);
        $explode = explode('|',$row->kebutuhan);
        $no = 1;
        foreach($explode as $ex):
            if($ex){
                $pdf->SetTextColor(255,255,255);
                $pdf->SetFont('Arial','',10);
                $pdf->MultiCell(190,5,$no++.". ".$ex,0,'L');
            }
        endforeach;

        $pdf->Cell(10,10,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(190,5,"SUMBER DAYA",0,1,'L');
        // $pdf->SetDrawColor(255,132,37);
        // $pdf->Cell(190,1,'','B',1,'L');

        $pdf->Cell(10,3,'',0,1);
        $explode = explode('|',$row->sumber_daya);
        $no = 1;
        foreach($explode as $ex):
            if($ex){
                $pdf->SetTextColor(255,255,255);
                $pdf->SetFont('Arial','',10);
                $pdf->MultiCell(190,5,$no++.". ".$ex,0,'L');
            }
        endforeach;
        

        $pdf->Cell(10,5,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(190,5,"RESPON DOMPET DHUAFA",0,1,'L');
        // $pdf->SetDrawColor(255,132,37);
        // $pdf->Cell(190,1,'','B',1,'L');

        $pdf->Cell(10,3,'',0,1);
        $no = 1;
        foreach($result as $ex):
            if($ex){
                $pdf->SetTextColor(255,255,255);
                $pdf->SetFont('Arial','',12);
                $pdf->MultiCell(190,10,$no++.". ".$ex->wgk_nama,0,'L');
            }

            $explode_timeline = explode("|", $ex->deskripsi);
            foreach($explode_timeline AS $res):
                $nilai = explode("^", $res);
                $pdf->SetFont('Arial','',10);
                $pdf->SetX(15);
                $pdf->Cell(190,5,"-  ".strtoupper($nilai[0]),0,1,'L');
                $pdf->Cell(190,5,"        Penerima : ".$nilai[1]." JIWA",0,1,'L');
            endforeach;
        endforeach;
        
        $pdf->Cell(10,5,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(190,5,"PENERIMA MANFAAT",0,1,'L');
        // $pdf->SetDrawColor(255,132,37);
        // $pdf->Cell(190,1,'','B',1,'L');

        $pdf->Cell(10,3,'',0,1);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial','',10);
        if($row->anggaran<>'0.00') $pdf->MultiCell(190,5,"ANGGARAN : ".number_format($row->anggaran,0,'','.'),0,'L');
        if($jml!='0' || !empty($jml)) $pdf->MultiCell(190,5,"PENERIMA : ".$jml." JIWA",0,'L');
        
        $pdf->Cell(10,5,'',0,1);
        $pdf->SetTextColor(255,132,37);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(190,5,"POSKO DOMPET DHUAFA",0,1,'L');
        // $pdf->SetDrawColor(255,132,37);
        // $pdf->Cell(190,1,'','B',1,'L');

        $pdf->Cell(10,3,'',0,1);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(190,5,$row->posko,0,'L');

        $pdf->Cell(10,10,'',0,1);
        $pdf->SetTextColor(44,161,219);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(95,5,"KONTAK INFORMASI",0,1,'L');

        $explode_pic = explode("|", $row->pic);
        foreach($explode_pic AS $res):
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFont('Arial','',10);
            $pdf->MultiCell(95,5,$res,0,'L');
        endforeach;
        
        $pdf->Output();
    }
}