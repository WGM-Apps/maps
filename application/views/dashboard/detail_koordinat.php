<aside class="row mt-3 mb-3">
    <aside class="col-md-12 text-secondary">
            <a href="<?php echo base_url() ?>">Respon DMC</a> >
            Maps
    </aside>
</aside>

<aside class="row">
    <aside class="col-md-4">
        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Data Bencana
            </aside>
            <aside class="card-body bg-white text-secondary">
                Nama: <?php echo $row->nama_bencana ?><br>
                Tgl. Kejadian: .....<br>
                Lokasi Kejadian: <?php echo $row->nama_lokasi.", ".$row->kelurahan." ".$row->kecamatan." ".$row->kota." ".$row->provinsi ?><br>
            </aside>
        </aside>
        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Dampak
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_dampak" readonly><?php echo $row->dampak ?></textarea>
            </aside>
        </aside>
        <aside class="card">
            <aside class="card-header bg-white text-primary">
                Kebutuhan Darurat
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly><?php echo $row->kebutuhan ?></textarea>
            </aside>
        </aside>
    </aside>
    <aside class="col-md-4">
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Assesment
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Kesehata
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Evakuasi
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Air & Sanitasi
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
    </aside>
    <aside class="col-md-4">
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Permakanan
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Dukungan Psikososial
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Logistik
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
        <aside class="card mb-2">
            <aside class="card-header bg-white text-primary">
                Recovery Awal
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly></textarea>
            </aside>
        </aside>
    </aside>
</aside>