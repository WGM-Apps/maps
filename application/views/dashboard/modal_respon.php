<form id="frm-respon" method="post" enctype="multipart/form-data">
    <aside class="modal-body">
        <aside id="accordion">
        <?php foreach($row_group as $res): ?>
            <aside class="card-header" data-toggle="collapse" data-target="#group<?php echo $res->id ?>" aria-expanded="true" aria-controls="group<?php echo $res->id ?>" style="cursor:pointer">
                <?php echo $res->nama ?>
            </aside>
            <aside id="group<?php echo $res->id ?>" class="collapse p-2" aria-labelledby="group<?php echo $res->id ?>" data-parent="#accordion">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <?php
                                $tb_timeline_kegiatan = TB_TIMELINE_KEGIATAN;
                                $tb_last_update_timeline_kegiatan = TB_LAST_UPDATE_TIMELINE_KEGIATAN;
                                $cek_kegiatan = $this->db->query("SELECT *, COUNT(*) AS total FROM $tb_timeline_kegiatan WHERE detail_id = $idx AND group_kegiatan_id = $res->id");
                                $cek_total = $cek_kegiatan->row();
                                if($cek_total->gambar){
                                    $url_gambar = base_url("upload/$cek_total->gambar");
                                    echo "<a href='$url_gambar' target='_blank'><i class='fa fa-image fa-2x'></i></a>";
                                }else{
                                    echo "<small style='font-size:7pt'>GAMBAR KOSONG</small>";
                                }
                            ?>
                        </div>
                        <div class="col-md-10">
                            <input type="file" class="form-control form-control-file" name="gambar<?php echo $res->id ?>">
                        </div>
                    </div>
                </div>
                <?php
                    if($cek_total->total > 0){
                        $exs = explode('|', $cek_total->deskripsi);
                        foreach($exs as $eExs){
                            echo "
                                <aside class='form-group'>
                                    <input type='text' name='deskripsi$res->id[]' value='$eExs' class='form-control form-control-sm'>
                                </aside>
                            ";
                        }
                    }
                ?>
                <aside class="form-group" id="files<?php echo $res->id ?>"></aside>

                <input type="hidden" name="id_detail<?php echo $res->id ?>" value="<?php echo $idx ?>">
                <input type="hidden" name="id_group_kegiatan<?php echo $res->id ?>" value="<?php echo $res->id ?>">

                <aside class="form-group">
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm text-white" onclick="addFile<?php echo $res->id ?>();"><i class="far fa-clipboard"></i> Tambah Keterangan</a> 
                </aside>
            </aside>

            <script>
                //-----Adds an element to the document-------
                function addElement<?php echo $res->id ?>(parentId, elementTag, elementId, html) {
                    var p = document.getElementById(parentId);
                    var newElement = document.createElement(elementTag);
                    newElement.setAttribute('id', elementId);
                    newElement.innerHTML = html;
                    p.appendChild(newElement);
                }

                function removeElement<?php echo $res->id ?>(elementId) {
                    var element = document.getElementById(elementId);
                    element.parentNode.removeChild(element);
                }

                var fileId<?php echo $res->id ?> = 0;
                function addFile<?php echo $res->id ?>() {
                    fileId<?php echo $res->id ?>++;
                    var html =  '<aside class="row">'+
                                '<aside class="col-md-11"><input type="text" name="deskripsi<?php echo $res->id ?>[]" placeholder="Keterangan Kegiatan..." class="form-control form-control-sm" /></aside>'+
                                '<aside class="col-md-1"><a href="javascript:void(0)" onclick="javascript:removeElement<?php echo $res->id ?>(\'file<?php echo $res->id ?>-' + fileId<?php echo $res->id ?> + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                                '<i class="fa fa-times"></i></a></aside>'+
                                '</aside>';
                    addElement<?php echo $res->id ?>('files<?php echo $res->id ?>', 'p', 'file<?php echo $res->id ?>-' + fileId<?php echo $res->id ?>, html);
                }
                //-----Close Adds an element to the document-------
                function simpan_respon(){
                    var form = $('#frm-respon')[0];
                    var data = new FormData(form);
                    $.ajax({
                        type: "post",
                        url: "welcome/simpan_respon",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",
                        beforeSend: function() {
                            // $('.btn_post_request').html('<a href="javascript:void(0)" class="btn btn-secondary"><i class="fas fa-spinner fa-pulse"></i> Proses</a>');
                        },
                        success: function (res) {
                            var isValid = res.isValid,
                                isPesan = res.isPesan;
                            if(isValid == 0) {
                                // $('.btn_post_request').html('<a href="javascript:void(0)" onclick="post_request()" class="btn btn-success"><i class="fa fa-check"></i> Kirim</a>');
                                // $('.pesan').html(isPesan);
                                alert(isPesan);
                            }else {
                                $('#sesuaikan_respon').modal('hide');
                            }
                        }
                    });
                }
            </script>
        <?php endforeach ?>
        </aside>
    </aside>
    <aside class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="simpan_respon()">Simpan Perubahan</button>
    </aside>
</form>