<aside class="p-3">
    <aside class="row mb-3">
        <aside class="col-md-12 text-secondary">
                <a href="<?php echo base_url() ?>">Dashboard</a> >
                Master bencana
        </aside>
    </aside>
    <aside class="card mt-3">
        <aside class="card-header">
            Master Bencana
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
                <table class="table table-hover table-bordered table-sm" id="tbDetail">
                    <thead>
                        <tr>
                            <th width="30"><center>No</center></th>
                            <th width="50"><center>Aksi</center></th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                </table>
            </aside>
        </aside>
    </aside>
</aside>
<div id="ModalForm" class="modal"></div>
