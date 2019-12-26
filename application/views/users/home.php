<aside class="p-3">
    <aside class="row mb-3">
        <aside class="col-md-12 text-secondary">
                <a href="<?php echo base_url() ?>">Dashboard</a> >
                Master Users
        </aside>
    </aside>
    <aside class="card mt-3">
        <aside class="card-header">
            Master Users
        </aside>
        <?php echo $this->session->flashdata('msg');?>
        <aside class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-sm" onclick="tambahData()">
                        <span class="fa fa-plus"></span> &nbsp;Tambah
                    </button>
                </div>
            </div>
            <hr width="100%">
            <aside class="scrollmenu">
                <table class="table table-hover table-bordered table-sm w-100" id="tbDetail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="10"><center>No</center></th>
                            <th><center>Nama Pengguna</center></th>
                            <th><center>Nama Lengkap</center></th>
                            <th width="10"><center>Akses</center></th>
                            <th width="10"><center>Aktif</center></th>
                        </tr>
                    </thead>
                </table>
            </aside>
        </aside>
    </aside>
</aside>
<div id="ModalForm" class="modal"></div>

