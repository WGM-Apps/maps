<aside class="row mt-5 mb-3">
    <aside class="col-md-12 text-secondary">
            <a href="<?php echo base_url() ?>"><b>Respon DMC</b></a>
            <?php if($this->session->userdata('USER_ID')): ?>
                <sup>(<a href="javascript:void(0)" onclick="sesuaikan_respon(<?php echo $row_detail->id ?>)">Sesuaikan Respon <i class="far fa-edit"></i></a>)</sup>
            <?php endif ?>
    </aside>
</aside>

<aside class="row">
    <aside class="col-md-4">
        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Data Bencana
            </aside>
            <aside class="card-body bg-white text-secondary">
                Nama: <?php echo $row_detail->nama_bencana ?><br>
                Tgl. Kejadian: <?php echo date('d-m-Y', strtotime($row_detail->tgl_kejadian)) ?><br>
                Lokasi Kejadian: <?php echo $row_detail->nama_lokasi.", ".$row_detail->kelurahan." ".$row_detail->kecamatan." ".$row_detail->kota." ".$row_detail->provinsi ?><br>
            </aside>
        </aside>
        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Dampak
            </aside>
            <aside class="card-body bg-white text-secondary">
                <textarea class="form-control" rows="5" id="txt_dampak" readonly><?php echo $row_detail->dampak ?></textarea>
            </aside>
        </aside>
        <aside class="card">
            <aside class="card-header bg-white text-primary">
                Kebutuhan Darurat
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <textarea class="form-control" rows="5" id="txt_kebutuhan" readonly><?php echo $row_detail->kebutuhan ?></textarea>
            </aside>
        </aside>
    </aside>

    <aside class="col-md-8">
        <!-- <aside class="row"> -->
        <?php foreach($row_timeline AS $res_timeline): ?>
            <aside class="w-100">
                <aside class="card mb-4">
                    <aside class="card-header bg-white text-primary">
                        <?php echo $res_timeline->wgk_nama ?>
                    </aside>
                    <aside class="card-body bg-white text-secondary">
                        <ul class="list-group list-group-flush">
                        <?php
                            $explode_timeline = explode("|", $res_timeline->deskripsi);
                            foreach($explode_timeline AS $res):
                                echo "<li class='list-group-item small'>$res</li>";
                            endforeach;
                        ?>
                        </ul>
                    </aside>
                </aside>
            </aside>
        <?php endforeach ?>
        <!-- </aside> -->
    </aside>
</aside>

<div class="modal fade" id="sesuaikan_respon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Respon DMC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="detail_respon"></div>
        </div>
    </div>
</div>