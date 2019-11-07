<script src="https://maps.google.com/maps/api/js"></script>
<script>    
    var marker;
    function initialize() {  
        // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;
        //  Variabel untuk menyimpan peta Roadmap
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP
        } 
        // Pembuatan petanya
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);      
        // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();
        // Pengambilan data dari database
        <?php
            foreach ($result as $data) {
                $lat    = $data->lat;
                $lng    = $data->lng;
                $bencana   = $data->bencana;
                $nama   = $data->nama_lokasi;
                $kelurahan   = $data->kelurahan;
                $kecamatan   = $data->kecamatan;
                $kota   = $data->kota;
                $provinsi   = $data->provinsi;
                $deskripsi   = $data->deskripsi;

                if($bencana == 1){
                    $bencana = 'GEMPA BUMI';
                }elseif($bencana == 2){
                    $bencana = 'GUNUNG MELETUS';
                }elseif($bencana == 3){
                    $bencana = 'TSUNAMI';
                }

                $content  = "<b>$bencana</b>";
                $content .= "<br>";
                $content .= "<small>($nama<br>$kelurahan, $kecamatan<br>$kota - $provinsi)</small>";
                $content .= "<hr>";
                $content .= $deskripsi;
                $content .= "<hr>";
                $content .= "<a target=&quot;_blank&quot; href=https://www.google.com/maps?q=loc:$lat,$lng>Tampilkan Google Maps</a>";
                echo ("addMarker($lat, $lng, '$content');");                        
            }    
        ?> 
        // Proses membuat marker 
        function addMarker(lat, lng, info) {
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: map,
                position: lokasi
            });       
            map.fitBounds(bounds);
            bindInfoWindow(marker, map, infoWindow, info);
         }        
        // Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, map, infoWindow, html) {
            google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    $('#filter_bencana').on('change', function() {
        window.location = "<?php echo base_url('welcome/index/') ?>"+this.value;
    });

    function proses_login() {
        var data = $('#form_login').serialize();
        $.ajax({
            url : '<?php echo base_url("welcome/login") ?>',
            type : 'post',
            cahce : false,
            data : data,
            dataType : 'json',
            beforeSend : function(){
                $('#btn_login').html("<i class='fa fa-spinner fa-spin'></i>");
            },
            success : function(result){
                localStorage.clear();
                var isValid = result.isValid;
                var isPesan = result.isPesan;
                if(isValid == 1){
                    $('#btn_login').html("<i class='fa fa-sign-in-alt'></i>");
                    $('#btn_login').show();
                    $('#pesan').html(isPesan);
                }else{
                    window.location.href = './';
                }
            }
        });
    }
</script>