<aside class="row mt-5 mb-3">
    <aside class="col-md-12 text-secondary">
            <a href="<?php echo base_url() ?>"><b>Respon DMC</b></a>
            <?php if($this->session->userdata('USER_ID')): ?>
                <sup>(<a href="javascript:void(0)" onclick="sesuaikan_respon(<?php echo $row_detail->id ?>)">Sesuaikan Respon <i class="far fa-edit"></i></a>)</sup>
            <?php endif ?>
            <a href="javascript:void(0)" class="btn btn-primary btn-sm float-right" onclick="report_respon('<?php echo $row_detail->id ?>')"><i class="fa fa-print"></i> Cetak</a>
    </aside>
</aside>

<aside class="row">
    <aside class="col-md-4">
        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Data Bencana
            </aside>
            <aside class="card-body bg-white text-secondary">
                <b>Nama:</b> <?php echo $row_detail->nama_bencana ?><br>
                <b>Tgl. Kejadian:</b> <?php echo date('d F Y', strtotime($row_detail->tgl_kejadian)) ?><br>
                <b>Lokasi Kejadian:</b><br><?php echo $row_detail->nama_lokasi.", ".$row_detail->kelurahan." ".$row_detail->kecamatan." ".$row_detail->kota." ".$row_detail->provinsi ?><br>
                <small><a href="https://www.google.com/maps?q=loc:<?php echo $row_detail->lat.','.$row_detail->lng ?>" target="_blank">Tampilkan Google Maps</a></small>
            </aside>
        </aside>

        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Dampak
            </aside>
            <aside class="card-body bg-white text-secondary">
                <ul class="list-group list-group-flush">
                <?php
                    $explode_dampak = explode("|", $row_detail->dampak);
                    foreach($explode_dampak as $dampak):
                ?>
                    <li class="list-group-item small"><?php echo $dampak ?></li>
                <?php endforeach ?>
                </ul>
            </aside>
        </aside>

        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Kebutuhan Darurat
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <ul class="list-group list-group-flush">
                <?php
                    $explode_kebutuhan = explode("|", $row_detail->kebutuhan);
                    foreach($explode_kebutuhan as $kebutuhan):
                ?>
                    <li class="list-group-item small"><?php echo $kebutuhan ?></li>
                <?php endforeach ?>
                </ul>
            </aside>
        </aside>

        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Sumber Daya
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <ul class="list-group list-group-flush">
                <?php
                    $explode_sumberdaya = explode("|", $row_detail->sumber_daya);
                    foreach($explode_sumberdaya as $sumberdaya):
                ?>
                    <li class="list-group-item small"><?php echo $sumberdaya ?></li>
                <?php endforeach ?>
                </ul>
            </aside>
        </aside>

        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Kontak Informasi
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <ul class="list-group list-group-flush">
                <?php
                    $explode_pic = explode("|", $row_detail->pic);
                    foreach($explode_pic as $pic):
                ?>
                    <li class="list-group-item small"><?php echo $pic ?></li>
                <?php endforeach ?>
                </ul>
            </aside>
        </aside>

        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Posko
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item small">
                        <?php echo $row_detail->posko ?>
                    </li>
                </ul>
            </aside>
        </aside>

        <aside class="card mb-5">
            <aside class="card-header bg-white text-primary">
                Penerima Manfaat
            </aside>
            <aside class="card-body bg-white text-secondary" id="detail-respon">
                <ul class="list-group list-group-flush">
                    <?php if($row_detail->anggaran<>'0.00'): ?>
                    <li class="list-group-item small">
                        <b>Anggaran :</b> <?php echo $row_detail->anggaran ?>
                    </li>
                    <?php endif ?>
                    <?php if($penerima_manfaat!='0' || !empty($penerima_manfaat)): ?>
                    <li class="list-group-item small">
                        <b>Penerima :</b> <?php echo $penerima_manfaat ?>
                    </li>
                    <?php endif ?>
                </ul>
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
                        <?php if($res_timeline->gambar): ?>
                            <aside class="pb-3 text-center">
                                <a href="<?php echo base_url("upload/$res_timeline->gambar") ?>" target="_blank">
                                    <img src="<?php echo base_url("upload/$res_timeline->gambar") ?>" width="300px">
                                </a>
                            </aside>
                        <?php endif ?>

                        <ul class="list-group list-group-flush">
                            <?php
                                $explode_timeline = explode("|", $res_timeline->deskripsi);
                                foreach($explode_timeline AS $res):
                                    $res_desk = explode("^", $res);
                                    echo "<li class='list-group-item d-flex justify-content-between align-items-center small'>$res_desk[0]<span class='badge badge-primary badge-pill'>$res_desk[1]</span></li>";
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