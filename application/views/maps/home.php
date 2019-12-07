<aside class="p-3">
    <aside class="row mb-3">
        <aside class="col-md-12 text-secondary">
                <a href="<?php echo base_url() ?>">Dashboard</a> >
                Maps
        </aside>
    </aside>

    <aside id="accordion">
        <aside class="card">
            <aside class="card-header" id="inheren" data-toggle="collapse" data-target="#collapseInheren" aria-expanded="true" aria-controls="collapseInheren" style="cursor:pointer">
                <b class="text-primary">Tambah Detail Lokasi Bencana</b>
            </aside>
            <aside id="collapseInheren" class="collapse" aria-labelledby="inheren" data-parent="#accordion">
                <aside class="row p-2">
                    <aside class="col-md-8">
                        <aside id="map_canvas" class="mx-auto"></aside>
                    </aside>
                    <aside class="col-md-4">
                        <form id="frm_simpan_maps">
                            <aside id="pesan"></aside>
                            <aside class="row">
                                <aside class="col-md-6">
                                    <label><small>Latitude</small></label>
                                    <input type="text" name="lat" id="text_lat" class="form-control" readonly>
                                </aside>
                                <aside class="col-md-6">
                                    <label><small>Longitude</small></label>
                                    <input type="text" name="lng" id="text_lng" class="form-control" readonly>
                                </aside>
                            </aside>
                            
                            <aside class="form-group">
                                <small>
                                    <aside id="current">Mengambil lokasi saat ini...</aside>
                                </small>
                            </aside>
                            
                            <aside class="row">
                                <aside class="col-md-6">
                                    <label><small>Bencana</small></label>
                                    <select name="bencana" id="" class="form-control">
                                        <option value="">Pilih Bencana</option>
                                        <?php foreach($result as $r): ?>
                                        <option value="<?php echo $r->id ?>"><?php echo $r->nama ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </aside>
                                <aside class="col-md-6">
                                    <label><small>Tgl. Kejadian</small></label>
                                    <input type="date" name="tgl_kejadian" id="" class="form-control">
                                </aside>
                            </aside>

                            <aside class="form-group">
                                <label><small>Nama Lokasi</small></label>
                                <input type="text" name="nama_lokasi" id="" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                            </aside>
                            
                            <aside class="row">
                                <aside class="col-md-6">
                                    <label><small>Kelurahan</small></label>
                                    <input type="text" name="kelurahan" id="" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                                </aside>
                                <aside class="col-md-6">
                                    <label><small>Kecamatan</small></label>
                                    <input type="text" name="kecamatan" id="" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                                </aside>
                            </aside>
                            
                            <aside class="row">
                                <aside class="col-md-6">
                                    <label><small>Kota</small></label>
                                    <input type="text" name="kota" id="" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                                </aside>
                                <aside class="col-md-6">
                                    <label><small>Provinsi</small></label>
                                    <input type="text" name="provinsi" id="" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                                </aside>
                            </aside>

                            <aside class="form-group">
                                <label><small>Dampak</small></label>
                                <textarea name="dampak" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"></textarea>
                            </aside>

                            <aside class="form-group">
                                <label><small>Kebutuhan Darurat</small></label>
                                <textarea name="kebutuhan" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()"></textarea>
                            </aside>
                            
                            <aside class="row">
                                <aside class="col-md-8 pt-3">
                                    <a href="javascript:void(0)" onclick="simpan_maps()" id="simpan_maps" class="btn btn-primary btn-block btn-sm">Simpan</a>
                                </aside>
                                <aside class="col-md-4 pt-3">
                                    <input type="reset" class="btn btn-danger btn-block btn-sm" value="Reset">
                                </aside>
                            </aside>
                        </form>
                    </aside>
                </aside>
            </aside>
        </aside>
    </aside>
    
    <aside class="card mt-3">
        <aside class="card-header">
            Koordinat Bencana
        </aside>
        <?php echo $this->session->flashdata('msg');?>
        <aside class="card-body">
            <div class="row">
                <a href="<?php echo base_url().'maps/export_excel' ?>" class="btn btn-success btn-sm float-right" ><i class="fa fa-excel"></i> Export to Excel</a>
            </div>
            <hr width="100%">
            <aside class="scrollmenu">
                <table class="table table-hover table-bordered table-sm" id="tbDetail">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Bencana</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                </table>
            </aside>
        </aside>
    </aside>
</aside>
<div id="ModalEdit" class="modal"></div>
<div id="ModalDelete" class="modal"></div>

