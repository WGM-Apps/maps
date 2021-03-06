<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo APP_NAME ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Owner" content="">
        <meta name="application-name" content="">
        <meta name="create-by" content="Reynaldi">
        <meta name="create-date" content="01/10/2019">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css') ?>"><link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>">
    </head>

    <body class="bg-light">
        <aside class="nav-menu border-right position-fixed nav-slider">
            <img src="<?php echo base_url('assets/icon_marker/logo.png') ?>" width="200px" class="p-3">
            <aside class="card border-0 m-3 text-secondary">
                <span>
                    <a href="<?php echo base_url() ?>">
                        <i class="fa fa-signature fa-fw mr-2"></i>
                        Dashboard
                    </a>
                </span>
                <?php if($menu == 1): ?>
                    <?php if($this->session->userdata('USER_ACCESS')==2): ?>
                        <span data-toggle="collapse" href="#master" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-bars fa-fw mr-2"></i>
                            Master Data
                        </span>
                        <aside class="collapse" id="master">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0"><a href="<?php echo base_url('users') ?>">Users</a></li>
                                <li class="list-group-item border-0"><a href="<?php echo base_url('bencana') ?>">Bencana</a></li>
                                <li class="list-group-item border-0"><a href="<?php echo base_url('kegiatan') ?>">Kegiatan</a></li>
                            </ul>
                        </aside>
                        <span>
                            <a href="<?php echo base_url('maps') ?>">
                                <i class="far fa-map fa-fw mr-2"></i>
                                Maps
                            </a>
                        </span>
                    <?php endif ?>
                    <span data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-chart-line fa-fw mr-2"></i>
                        Kategori bencana
                    </span>
                    <aside class="collapse" id="collapseExample">
                        <?php
                            $res_bencana = $this->db->get(TB_TIPE_BENCANA)->result();
                            foreach($res_bencana as $r):
                        ?>  
                            <form method="post" action="<?php echo base_url() ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="id_bencana" value="<?php echo $r->id ?>">
                                    <button type="submit" class="btn btn-block btn-sm pl-3 pt-2 bg-white text-secondary text-left" style="cursor:pointer">&raquo; <?php echo ucwords(strtolower($r->nama)) ?></button>
                            </form>
                            
                        <?php endforeach ?>
                    </aside>
                <?php else: ?>
                    <span data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-chart-line fa-fw mr-2"></i>
                        Kategori bencana
                    </span>
                    <aside class="collapse" id="collapseExample">
                        <?php
                            $res_bencana = $this->db->get(TB_TIPE_BENCANA)->result();
                            foreach($res_bencana as $r):
                        ?>  
                             <form method="post" action="<?php echo base_url() ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="id_bencana" value="<?php echo $r->id ?>">
                                    <button type="submit" class="btn btn-block btn-sm pl-3 pt-2 bg-white text-secondary text-left" style="cursor:pointer">&raquo; <?php echo ucwords(strtolower($r->nama)) ?></button>
                            </form>
                            
                        <?php endforeach ?>
                    </aside>
                <?php endif ?>
            </aside>
        </aside>

        <aside class="nav-top position-fixed">
            <aside class="row">
                <aside class="col mr-3 ml-3 p-3 tombol">
                    <i class="fa fa-ellipsis-h"></i>
                </aside>
                <aside class="col">
                    <aside class="float-right mr-3 p-3">
                        <span>
                        <?php if($menu == 1): ?>
                            <aside class="dropdown">
                                <a href="javascript:void(0)" class="text-secondary dropdown-toggle" data-toggle="dropdown">
                                    <b><?php echo $this->session->userdata('USER_FULLNAME') ?></b>
                                </a>
                                <aside class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('logout') ?>">
                                        <i class="fa fa-sign-out-alt fa-fw"></i> Keluar
                                    </a>
                                </aside>
                            </aside>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="text-secondary" data-toggle="modal" data-target="#masuk">
                                Masuk
                            </a>
                            <aside class="modal fade" id="masuk" tabindex="-1" role="dialog" aria-labelledby="masukTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <aside class="modal-dialog" role="document">
                                    <aside class="modal-content">
                                        <aside class="modal-header">
                                            <h5 class="modal-title" id="masukTitle">Masuk</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </aside>
                                        <aside class="modal-body">
                                            <form id="form_login">
                                                <aside class="row">
                                                    <aside class="col-md-5">
                                                        <input type="text" name="username" placeholder="Nama pengguna" class="form-control form-control-sm">
                                                    </aside>
                                                    <aside class="col-md-5">
                                                        <input type="password" name="password" placeholder="Kata Kunci" class="form-control form-control-sm">
                                                    </aside>
                                                    <aside class="col-md-2">
                                                        <a href="javascript:void(0)" onclick="proses_login()" id="btn_login" class="btn btn-primary btn-sm btn-block"><i class="fa fa-sign-in-alt"></i></a>
                                                    </aside>
                                                </aside>
                                            </form>

                                            <hr>
                                            <aside id="pesan" class="text-danger"></aside>
                                        </aside>
                                    </aside>
                                </aside>
                            </aside>
                        <?php endif ?>
                        </span>
                    </aside>
                </aside>
            </aside>
        </aside>
        </aside>

        <aside class="content">
            <?php echo $contents ?>
        </aside>
    </body>

    <script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-expander/1.7.0/jquery.expander.js"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/ba0b170900.js') ?>" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/geo.js') ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/script.js') ?>" charset="utf-8"></script>
    <?php
        if(isset($myJS)) $this->load->view($myJS);
    ?>
</html>