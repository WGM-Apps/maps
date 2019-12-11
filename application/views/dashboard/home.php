<aside class="pt-3 pr-3 pl-3">
    <aside class="row">
        <aside class="col-md-9">
            <aside id="map_canvas" class="mx-auto"></aside>
        </aside>
        <aside class="col-md-3 small bg-white">
            <h5 class="pt-3 text-dark">KEGIATAN TERBARU</h5>
            <hr>
            <?php foreach($row_timeline AS $res): ?>
            <b><a href="javascript:void(0)" onclick="viewDetailKordinat(<?php echo $res->detail_id ?>)"><?php echo $res->nama_kegiatan ?></a></b>
            <aside class="readmore"><?php echo substr($res->timeline_kegiatan_deskripsi, 0 ,10) ?>...</aside>
            <small>
                <i class='far fa-clock fa-fw mr-1'></i><?php echo date("h:i:s", strtotime($res->tgl_insert)) ?>
                <i class='far fa-calendar fa-fw mr-1'></i><?php echo date("d-F-Y", strtotime($res->tgl_insert)) ?>
            </small>
            <hr>
            <?php endforeach ?>
        </aside>
    </aside>

    <aside id="deskripsi_page"></aside>

</aside>
<aside class="pt-3 pb-3 bg-white border-top text-center small">
    <a href="<?php echo base_url() ?>">DMC Dompet Dhuafa</a> &copy; <?php echo date('Y') ?>
</aside>