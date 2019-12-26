<?php
    $b=$row->row_array();
    $id  = $b['id'];
    $nama  = $b['nama'];
    $user  = $b['user'];
    $akses  = $b['akses'];
    $flg_active  = $b['flg_active'];
?>
<div class="modal-dialog">

    <div class="modal-content">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'users/update'?>" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="row">
                    <div class="col-md-4">
                        Nama Lengkap
                    </div>
                    <div class="col-md-8">
                        <input name="nama" id="nama" value="<?php echo $nama ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Nama Pengguna
                    </div>
                    <div class="col-md-8">
                        <input name="username" id="username" value="<?php echo $user ?>" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Kata Kunci
                    </div>
                    <div class="col-md-8">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Akses
                    </div>
                    <div class="col-md-8">
                        <select name="akses" class="form-control">
                            <option value="<?php echo $akses ?>"><?php echo $akses ?></option>
                            <option value="0">0 (Tanpa Akses Menu)</option>
                            <option value="1">1 (Akses Menu Dashboard/Sesuaikan Respon)</option>
                            <option value="2">2 (Akses Semua Menu)</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Aktif
                    </div>
                    <div class="col-md-8">
                        <select name="aktif" class="form-control">
                            <option value="<?php echo $flg_active ?>"><?php echo $flg_active ?></option>
                            <option value="Y">Y (Aktif)</option>
                            <option value="N">N (Tidak Aktif)</option>
                        </select>
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