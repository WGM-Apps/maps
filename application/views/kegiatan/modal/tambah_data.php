<div class="modal-dialog">
    <div class="modal-content">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'kegiatan/simpan'?>" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        Nama
                    </div>
                    <div class="col-md-10">
                        <input name="nama_kegiatan" id="nama_kegiatan" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="tutup" data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button class="btn btn-primary btn-sm" type="submit"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </form>
    </div>
</div>