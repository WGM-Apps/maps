<script src="https://maps.google.com/maps/api/js"></script>
<script>
    $(document).ready(function () {
        $('.readmore').expander({
            slicePoint: 5,
            expandText: ' >>',
            userCollapseText: ' <<'
        });
    });

    var marker;
    function initialize() {  
        // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;
        //  Variabel untuk menyimpan peta Roadmap
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP
        } 
        // Pembuatan petanya
        var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);      
        // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();
        // Pengambilan data dari database
        <?php
            foreach ($result as $data) {
                $id    = $data->id;
                $lat    = $data->lat;
                $lng    = $data->lng;
                $bencana   = $data->nama_bencana;
                $nama   = $data->nama_lokasi;
                $kelurahan   = $data->kelurahan;
                $kecamatan   = $data->kecamatan;
                $kota   = $data->kota;
                $provinsi   = $data->provinsi;
                $dampak = $data->dampak;
                $kebutuhan = $data->kebutuhan;

                $content  = "<b>$bencana</b>";
                $content .= "<br>";
                $content .= "<small>($nama<br>$kelurahan, $kecamatan<br>$kota - $provinsi)</small>";
                $content .= "<hr>";
                $content .= "<center><a href=javascript:void(0) onclick=viewDetailKordinat($id)>Lihat Detail</a></center>";
                $content .= "<hr>";
                $content .= "<center><a target=&quot;_blank&quot; href=https://www.google.com/maps?q=loc:$lat,$lng><small>Tampilkan Google Maps</small></a></center>";
                echo ("addMarker($lat, $lng, '$content');");                        
            }    
        ?> 
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
    };

    function filter_bencana(id) {
        window.location.href = "<?php echo base_url('welcome/index/') ?>"+id;
    };

    function viewDetailKordinat(id){
        $.ajax({
            type: "post",
            url: "welcome/get_detail_koordinat",
            data: "id="+id,
            success: function (response) {
                $('#deskripsi_page').html(response);
                var hash = "#deskripsi_page";
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
            
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            }
        });
    };

    function sesuaikan_respon(id){
        $('#sesuaikan_respon').modal('show');
        $.ajax({
            type: "post",
            url: "welcome/modal_respon",
            data: "data="+id,
            beforeSend: function () {
                $(".detail_respon").html("<center>Memuat...</center>");
            },
            success: function (response) {
                $(".detail_respon").html(response);
            }
        });
    }

</script>