<form id="frm-respon" method="post" enctype="multipart/form-data">
    <aside class="modal-body">
        <aside id="accordion">
        <?php foreach($row_group as $res): ?>
            <aside class="card-header" data-toggle="collapse" data-target="#group<?php echo $res->id ?>" aria-expanded="true" aria-controls="group<?php echo $res->id ?>" style="cursor:pointer">
                <?php echo $res->nama ?>
            </aside>
            <aside id="group<?php echo $res->id ?>" class="collapse p-2" aria-labelledby="group<?php echo $res->id ?>" data-parent="#accordion">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="gambar<?php echo $res->id ?>">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>
                
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
                //-----Adds an element to the document-------
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
                            // var isValid = res.isValid,
                            //     isPesan = res.isPesan;
                            // if(isValid == 0) {
                            //     $('.btn_post_request').html('<a href="javascript:void(0)" onclick="post_request()" class="btn btn-success"><i class="fa fa-check"></i> Kirim</a>');
                            //     $('.pesan').html(isPesan);
                            // }else {
                            //     $('.pesan').html(isPesan);
                            //     $('#modal-create-rfm').modal('hide');
                            //     $('#modal-create-rfp').modal('hide');
                            //     reload_table();
                            // }
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