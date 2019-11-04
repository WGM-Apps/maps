<aside class="m-3 p-3">
    <aside class="row mb-3">
        <aside class="col-md-12 text-secondary">
                <a href="<?php echo base_url() ?>">Dashboard</a> >
                Maps
        </aside>
    </aside>

    <aside class="row">
        <aside class="col-md-8">
            <aside id="map_canvas" class="mx-auto"></aside>
        </aside>
        <aside class="col-md-4">
            <form id="frm_simpan_maps">
                <aside id="pesan"></aside>
                <aside class="row">
                    <aside class="col-md-6">
                        <label><small>Latitude</small></label>
                        <input type="text" name="lat" id="text_lat" class="form-control">
                    </aside>
                    <aside class="col-md-6">
                        <label><small>Longitude</small></label>
                        <input type="text" name="lng" id="text_lng" class="form-control">
                    </aside>
                </aside>
                
                <aside class="form-group">
                    <small>
                        <aside id="current">Mengambil lokasi saat ini...</aside>
                    </small>
                </aside>

                <aside class="form-group">
                    <label><small>Bencana</small></label>
                    <select name="bencana" id="" class="form-control">
                        <option value="">-- Pilih Bencana --</option>
                        <option value="1">Gempa Bumi</option>
                        <option value="2">Gunung Meletus</option>
                        <option value="3">Tsunami</option>
                    </select>
                </aside>

                <aside class="form-group">
                    <label><small>Nama Lokasi</small></label>
                    <input type="text" name="nama_lokasi" id="" class="form-control">
                </aside>
                
                <aside class="row">
                    <aside class="col-md-6">
                        <label><small>Kelurahan</small></label>
                        <input type="text" name="kelurahan" id="" class="form-control">
                    </aside>
                    <aside class="col-md-6">
                        <label><small>Kecamatan</small></label>
                        <input type="text" name="kecamatan" id="" class="form-control">
                    </aside>
                </aside>
                
                <aside class="row">
                    <aside class="col-md-6">
                        <label><small>Kota</small></label>
                        <input type="text" name="kota" id="" class="form-control">
                    </aside>
                    <aside class="col-md-6">
                        <label><small>Provinsi</small></label>
                        <input type="text" name="provinsi" id="" class="form-control">
                    </aside>
                </aside>

                <aside class="form-group">
                    <label><small>Deskripsi</small></label>
                    <textarea name="deskripsi" class="form-control"></textarea>
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
    
    <hr>
    
    <aside class="row pt-3">
        <div class="table-responsive">
            <table class="table table-hovered" id="tbDetail">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lat</th>
                        <th>Lng</th>
                        <th>Bencana</th>
                        <th>Lokasi</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </aside>
</aside>