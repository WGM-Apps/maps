<?php
    $b=$row->row_array();
    $id  = $b['id'];
    $nama  = $b['nama'];
?>
<div class="modal-dialog">

    <div class="modal-content">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'bencana/update'?>" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        Nama
                    </div>
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input name="nama_bencana" id="nama_bencana" value="<?php echo $nama ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="tutup" data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button class="btn btn-primary btn-sm" type="submit"><span class="fa fa-save"></span> Update</button>
            </div>
        </form>
    </div>
</div>