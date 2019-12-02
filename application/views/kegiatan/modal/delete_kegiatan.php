<div class="modal-dialog">
    <div class="modal-content">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'kegiatan/hapus_data'?>" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="regular13" class="col-sm-2 control-label"></label>
                    <div class="col-sm-8">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <p>Apakah Anda yakin mau menghapus data </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" id="tutup" data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button class="btn btn-danger" type="submit"><span class="fa fa-trash"></span> Hapus</button>
            </div>
        </form>
    </div>
</div>