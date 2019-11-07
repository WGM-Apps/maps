<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo APP_NAME ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Owner" content="">
        <meta name="application-name" content="">
        <meta name="create-by" content="Reynaldi">
        <meta name="create-date" content="01/10/2019">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>">
    </head>

    <body class="bg-white">
        <aside class="nav-menu border-right position-fixed nav-slider">
            <aside class="card border-0 m-3 text-secondary">
                <span>
                    <a href="<?php echo base_url() ?>">
                        <i class="fa fa-signature fa-fw mr-2"></i>
                        Dashboard
                    </a>
                </span>
                <?php if($menu == 1): ?>
                    <span>
                        <a href="<?php echo base_url('maps') ?>">
                            <i class="far fa-map fa-fw mr-2"></i>
                            Maps
                        </a>
                    </span>
                <?php else: ?>
                    <!-- <span>
                        <a href="<?php echo base_url('maps') ?>">
                            <i class="far fa-map fa-fw mr-2"></i>
                            Maps
                        </a>
                    </span> -->
                <?php endif ?>
                <!-- <span id="nav-menu-setting" onclick="setting_click()">
                    <i class="fa fa-cog fa-fw mr-2"></i>
                    Setting
                </span>
                <span id="nav-menu-manage" onclick="manage_click()">
                    <i class="fa fa-users fa-fw mr-2"></i>
                    Manage
                </span> -->
            </aside>
        </aside>

        <aside class="nav-top position-fixed">
            <aside class="float-left mr-3 p-3 mobile-menu-view">
                <i class="fa fa-ellipsis-h tombol"></i>
            </aside>
            <aside class="float-right mr-3 p-3">
                <span>
                <?php if($menu == 1): ?>
                    <aside class="dropdown">
                        <a href="javascript:void(0)" class="text-secondary dropdown-toggle" data-toggle="dropdown">
                            <b>Reynaldi</b>
                        </a>
                        <aside class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo base_url('logout') ?>">
                                <i class="fa fa-sign-out-alt fa-fw"></i> Keluar
                            </a>
                        </aside>
                    </aside>
                <?php else: ?>
                    <a href="javascript:void(0)" class="text-secondary" data-toggle="modal" data-target="#masuk">
                        Daftar / Masuk
                    </a>
                    <div class="modal fade" id="masuk" tabindex="-1" role="dialog" aria-labelledby="masukTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="masukTitle">Masuk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
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
                                    <!-- <h5>Daftar</h5>
                                    <form>
                                        <aside class="row">
                                            <aside class="col-md-5">
                                                <input type="text" name="" placeholder="Email" class="form-control form-control-sm">
                                            </aside>
                                            <aside class="col-md-5">
                                                <input type="password" name="" placeholder="Kata Kunci" class="form-control form-control-sm">
                                            </aside>
                                            <aside class="col-md-2">
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm btn-block"><i class="fa fa-user-plus"></i></a>
                                            </aside>
                                        </aside>
                                    </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                </span>
            </aside>
        </aside>

        <aside class="content">
            <?php echo $contents ?>
        </aside>
    </body>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://kit.fontawesome.com/ba0b170900.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/geo.js') ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/script.js') ?>" charset="utf-8"></script>
    <?php
        if(isset($myJS)) $this->load->view($myJS);
    ?>
</html>