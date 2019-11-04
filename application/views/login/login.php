<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo APP_NAME ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Owner" content="">
        <meta name="application-name" content="">
        <meta name="create-by" content="Reynaldi">
        <meta name="create-date" content="01/10/2019">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>">
    </head>

    <body class="bg-white">
        
    </body>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/ba0b170900.js" crossorigin="anonymous"></script>
	<?php
        if(isset($myJS)) $this->load->view($myJS);
    ?>
</html>