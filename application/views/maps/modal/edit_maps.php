
<div class="modal-dialog modal-lg">
    <div class="modal-content" >
        <div class="modal-header">
            <?php
                $b=$row->row_array();

                $id  = $b['id'];
                $lat  = $b['lat'];
                $lng = $b['lng'];
                $bencana = $b['bencana'];
                $tgl_kejadian = date('Y-m-d',strtotime($b['tgl_kejadian']));
                $nama_lokasi = $b['nama_lokasi'];
                $kelurahan = $b['kelurahan'];
                $kecamatan = $b['kecamatan'];
                $kota = $b['kota'];
                $provinsi = $b['provinsi'];
                $dampak = $b['dampak'];
                $kebutuhan = $b['kebutuhan'];
                $nama_bencana = $b['nama_bencana'];
            ?>
        </div>
        <div class="modal-body">
            <aside class="row p-2">
                <aside class="col-md-6">
                    <aside id="map_canvas" class="mx-auto"></aside>
                </aside>
                <aside class="col-md-6">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'maps/update_maps'?>" enctype="multipart/form-data">
                        <aside class="row">
                            <aside class="col-md-6">
                                <label><small>Latitude</small></label>
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <input type="text" name="lat" id="text_lat" value="<?php echo $lat ?>" class="form-control" readonly>
                            </aside>
                            <aside class="col-md-6">
                                <label><small>Longitude</small></label>
                                <input type="text" name="lng" id="text_lng" value="<?php echo $lng ?>" class="form-control" readonly>
                            </aside>
                        </aside>
                        
                        <aside class="row">
                            <aside class="col-md-6">
                                <label><small>Bencana</small></label>
                                
                                    <?php
                                        $qr=$this->db->query("SELECT * from wgm_tipe_bencana"); ?>
                                    <select name="bencana" id="" class="form-control"> 
                                    <?php    foreach ($qr->result_array() as $x1) {
                                            $id=$x1['id'];
                                            $nama = $x1['nama']; 

                                        if($nama == $nama_bencana){
                                            $select = "selected";
                                        }else{
                                            $select ="";
                                        }
                                    ?>

                                        <option value="<?php echo $id ?>" <?php echo $select ?>><?php echo $nama ?></option>    
                                    <?php    } ?>
                                </select>
                            </aside>
                            <aside class="col-md-6">
                                <label><small>Tgl. Kejadian</small></label>
                                <input type="date" name="tgl_kejadian" id="" value="<?php echo $tgl_kejadian ?>" class="form-control">
                            </aside>
                        </aside>

                        <aside class="form-group">
                            <label><small>Nama Lokasi</small></label>
                            <input type="text" name="nama_lokasi" id="" value="<?php echo $nama_lokasi ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                        </aside>
                        
                        <aside class="row">
                            <aside class="col-md-6">
                                <label><small>Kelurahan</small></label>
                                <input type="text" name="kelurahan" id="" value="<?php echo $kelurahan ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                            </aside>
                            <aside class="col-md-6">
                                <label><small>Kecamatan</small></label>
                                <input type="text" name="kecamatan" id="" value="<?php echo $kecamatan ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                            </aside>
                        </aside>
                        
                        <aside class="row">
                            <aside class="col-md-6">
                                <label><small>Kota</small></label>
                                <input type="text" name="kota" id="" value="<?php echo $kota ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                            </aside>
                            <aside class="col-md-6">
                                <label><small>Provinsi</small></label>
                                <input type="text" name="provinsi" id="" value="<?php echo $provinsi ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                            </aside>
                        </aside>

                        <aside class="form-group">
                            <label><small>Dampak</small></label>
                            <textarea name="dampak" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"><?php echo $dampak ?></textarea>
                        </aside>

                        <aside class="form-group">
                            <label><small>Kebutuhan Darurat</small></label>
                            <textarea name="kebutuhan" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"><?php echo $kebutuhan ?></textarea>
                        </aside>
                        <aside class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-save"></span> Simpan
                            </button>&nbsp;
                            <button id="tutup" type="button" class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-backward"></span> Kembali
                            </button>
                        </aside>
                    </form>
                </aside>
        </div>
    </div>
</div>