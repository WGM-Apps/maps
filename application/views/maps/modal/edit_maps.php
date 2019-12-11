
<div class="modal-dialog modal-lg">
    <div class="modal-content" >
        <div class="modal-header">
            <?php
                $b=$row->row_array();
                $id_wgm  = $b['id'];
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
                $pic = $b['pic'];
                $posko = $b['posko'];
            ?>
        </div>
        <div class="modal-body">
            <aside class="row p-2">
                <aside class="col-md-12">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'maps/update_maps'?>" enctype="multipart/form-data">
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
                                <input type="hidden" name="id" value="<?php echo $id_wgm ?>">
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
                           <!--  <textarea name="dampak" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"><?php echo $dampak ?></textarea> -->
                            <?php
                              $exs = explode('|', $dampak);
                                foreach($exs as $eExs){
                                    echo "
                                        <aside class='form-group'>
                                            <input type='text' name='dampak[]' value='$eExs' class='form-control form-control-sm' onkeyup='javascript:this.value=this.value.toUpperCase()'>
                                        </aside>
                                    ";
                                }

                            ?>
                            <aside class="form-group" id="filesDampak<?php echo $id_wgm?>"></aside>
                            <aside class="form-group">
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm text-white" onclick="addFileDampak<?php echo $id_wgm ?>();"><i class="far fa-clipboard"></i> Tambah Dampak </a> 
                            </aside>
                        </aside>

                        <aside class="form-group">
                            <label><small>Kebutuhan Darurat</small></label>
                            <!-- <textarea name="kebutuhan" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"><?php echo $kebutuhan ?></textarea> -->
                            <?php
                              $exs = explode('|', $kebutuhan);
                                foreach($exs as $eExs){
                                    echo "
                                        <aside class='form-group'>
                                            <input type='text' name='kebutuhan[]' value='$eExs' class='form-control form-control-sm' onkeyup='javascript:this.value=this.value.toUpperCase()'>
                                        </aside>
                                    ";
                                }

                            ?>
                            <aside class="form-group" id="filesKebutuhan<?php echo $id_wgm?>"></aside>
                            <aside class="form-group">
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm text-white" onclick="addFileKebutuhan<?php echo $id_wgm ?>();"><i class="far fa-clipboard"></i> Tambah Kebutuhan </a> 
                            </aside>
                        </aside>
                        <aside class="form-group">
                            <label><small>PIC</small></label>
                            <!-- <textarea name="kebutuhan" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"><?php echo $kebutuhan ?></textarea> -->
                            <?php
                              $exs = explode('|', $pic);
                                foreach($exs as $eExs){

                                    $a = explode('-',$eExs);
                                    echo "
                                        <aside class='form-group'>
                                        <aside class='row'>
                                            <aside class='col-md-11'>
                                                <input type='text' name='pic[]' value='$a[0]' class='form-control form-control-sm' onkeyup='javascript:this.value=this.value.toUpperCase()' style='width: 50%;display: inline;'><input type='text' name='hp[]' value='$a[1]' class='form-control form-control-sm' onkeyup='javascript:this.value=this.value.toUpperCase()' style='width: 50%;display: inline;'>
                                            </aside>
                                        </aside>
                                        </aside>
                                    ";

                                   
                                }

                            ?>
                            <aside class="form-group" id="filespic<?php echo $id_wgm?>"></aside>
                            <aside class="form-group">
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm text-white" onclick="addFilepic<?php echo $id_wgm ?>();"><i class="far fa-clipboard"></i> Tambah pic </a> 
                            </aside>
                        </aside>
                        <aside class="form-group">
                            <label><small>Alamat posko</small></label>
                            <textarea class="form-control" name="posko" onkeyup="javascript:this.value=this.value.toUpperCase()"><?php  echo $posko ?></textarea>
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

<script>
function addElementDampak<?php echo $id_wgm ?>(parentId, elementTag, elementId, html) {
    var p = document.getElementById(parentId);

    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.innerHTML = html;
    p.appendChild(newElement);
}




function removeElementDampak<?php echo $id_wgm ?>(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

var fileId<?php echo $id_wgm ?> = 0;
function addFileDampak<?php echo $id_wgm ?>() {
    fileId<?php echo $id_wgm ?>++;

    var html =  '<aside class="row">'+
                '<aside class="col-md-11"><input type="text" name="dampak[]" placeholder="Dampak..." class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase()" /></aside>'+
                '<aside class="col-md-1"><a href="javascript:void(0)" onclick="javascript:removeElementDampak<?php echo $id_wgm ?>(\'file<?php echo $id_wgm ?>-' + fileId<?php echo $id_wgm ?> + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                '<i class="fa fa-times"></i></a></aside>'+
                '</aside>';
    addElementDampak<?php echo $id_wgm ?>('filesDampak<?php echo $id_wgm ?>', 'p', 'file<?php echo $id_wgm ?>-' + fileId<?php echo $id_wgm ?>, html);
}


function addElementKebutuhan<?php echo $id_wgm ?>(parentId, elementTag, elementId, html) {
    var p = document.getElementById(parentId);

    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.innerHTML = html;
    p.appendChild(newElement);
}




function removeElementKebutuhan<?php echo $id_wgm ?>(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

var fileId<?php echo $id_wgm ?> = 0;
function addFileKebutuhan<?php echo $id_wgm ?>() {
    fileId<?php echo $id_wgm ?>++;

    var html =  '<aside class="row">'+
                '<aside class="col-md-11"><input type="text" name="kebutuhan[]" placeholder="Kebutuhan..." class="form-control form-control-sm"  onkeyup="javascript:this.value=this.value.toUpperCase()" /></aside>'+
                '<aside class="col-md-1"><a href="javascript:void(0)" onclick="javascript:removeElementKebutuhan<?php echo $id_wgm ?>(\'file<?php echo $id_wgm ?>-' + fileId<?php echo $id_wgm ?> + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                '<i class="fa fa-times"></i></a></aside>'+
                '</aside>';
    addElementKebutuhan<?php echo $id_wgm ?>('filesKebutuhan<?php echo $id_wgm ?>', 'p', 'file<?php echo $id_wgm ?>-' + fileId<?php echo $id_wgm ?>, html);
}

function addElementpic<?php echo $id_wgm ?>(parentId, elementTag, elementId, html) {
    var p = document.getElementById(parentId);

    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.innerHTML = html;
    p.appendChild(newElement);
}




function removeElementpic<?php echo $id_wgm ?>(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

var fileId<?php echo $id_wgm ?> = 0;
function addFilepic<?php echo $id_wgm ?>() {
    fileId<?php echo $id_wgm ?>++;

    var html =  '<aside class="form-group">'+
                '<aside class="row">'+
                '<aside class="col-md-11"><input type="text" name="pic[]" placeholder="PIC..." class="form-control form-control-sm"  onkeyup="javascript:this.value=this.value.toUpperCase()" style="width: 50%;display: inline;" /><input type="text" name="hp[]" placeholder="HP..." class="form-control form-control-sm"  onkeyup="javascript:this.value=this.value.toUpperCase()" style="width: 50%;display: inline;" /></aside>'+
                '<aside class="col-md-1"><a href="javascript:void(0)" onclick="javascript:removeElementpic<?php echo $id_wgm ?>(\'file<?php echo $id_wgm ?>-' + fileId<?php echo $id_wgm ?> + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                '<i class="fa fa-times"></i></a></aside>'+
                '</aside></aside>';
    addElementpic<?php echo $id_wgm ?>('filespic<?php echo $id_wgm ?>', 'p', 'file<?php echo $id_wgm ?>-' + fileId<?php echo $id_wgm ?>, html);
}



</script>