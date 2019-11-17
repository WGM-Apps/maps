<script src="https://maps.google.com/maps/api/js"></script>
<script>
    initialize_map();
    initialize();
    
    var marker;
    function initialize_map()
    {
        var myOptions = {
            zoom: 4,
            mapTypeControl: true,
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
            navigationControl: true,
            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
            mapTypeId: google.maps.MapTypeId.ROADMAP      
            }	
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        
        google.maps.event.addListener(map, 'click', function(event) {
            taruhMarker(this, event.latLng);
        });
    }
    
    function initialize() {
        if(geo_position_js.init())
        {
            document.getElementById('current').innerHTML="Mencari lokasi saat ini...";
            geo_position_js.getCurrentPosition(show_position,function(){document.getElementById('current').innerHTML="<small class='text-danger'><i class='fa fa-times'></i> Tidak dapat menemukan lokasi, pastikan GPS aktif</small>"},{enableHighAccuracy:true});
        }
        else
        {
            document.getElementById('current').innerHTML="Functionality not available";
        }
    }

    function show_position(p) {
        var lat_maps = p.coords.latitude.toFixed(12);
        var lng_maps = p.coords.longitude.toFixed(12);
        $("#text_lat").val(lat_maps);
        $("#text_lng").val(lng_maps);
        document.getElementById('current').innerHTML="<a href='javascript:void(0)' onclick='initialize_map(); initialize()'><i class='fa fa-map-marker-alt'></i> Lokasi saat ini</a> <a class='float-right' target='_blank' href='https://www.google.com/maps?q=loc:"+lat_maps+","+lng_maps+"'><i class='fa fa-map'></i> Lihat Google Maps</a>";
        var pos=new google.maps.LatLng(lat_maps, lng_maps);
        map.setCenter(pos);
        map.setZoom(14);

        marker = new google.maps.Marker({
            position: pos,
            map: map
        });
    }
    
    function taruhMarker(map, posisiTitik) {
        var lat_maps = posisiTitik.lat();
        var lng_maps = posisiTitik.lng();

        if(marker){
            marker.setPosition(posisiTitik);
        }else{
            marker = new google.maps.Marker({
                position: posisiTitik,
                map: map,
            });
        }
        $("#text_lat").val(lat_maps);
        $("#text_lng").val(lng_maps);
        
        document.getElementById('current').innerHTML="<a href='javascript:void(0)' onclick='initialize_map(); initialize()'><i class='fa fa-map-marker-alt'></i> Lokasi saat ini</a> <a class='float-right' target='_blank' href='https://www.google.com/maps?q=loc:"+lat_maps+","+lng_maps+"'><i class='fa fa-map'></i> Lihat Google Maps</a>";
    }

    function simpan_maps() {
        var data = $('#frm_simpan_maps').serialize();
        var btn = document.getElementById('simpan_maps');
        $.ajax({
            type: "post",
            url: "<?php echo base_url('welcome/simpan_maps')?>",
            data: data,
            dataType: "json",
            beforeSend: function(){
                btn.setAttribute('onclick', 'return false');
                btn.setAttribute('class', 'btn btn-secondary btn-block btn-sm');
                $('#simpan_maps').html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            },
            success: function (e) {
                var isValid = e.isValid;
                var isPesan = e.isPesan;
                if(isValid == 0) {
                    alert(isPesan);
                    btn.setAttribute('onclick', 'simpan_maps()');
                    btn.setAttribute('class', 'btn btn-primary btn-block btn-sm');
                    $('#simpan_maps').html('Simpan');
                }else {
                    window.location = './';
                }
            }
        });
    }

    $('#tbDetail').DataTable({ 
        "bSort" : false,
        "processing": true, 
        "serverSide": true,
         
        "ajax": {
            "url": "welcome/get_data_tip",
            "type": "post"
        },

        "columns": [
            { "data": "0" },
            { "data": "1" },
            { "data": "2" },
            { "data": "3" },
        ],
        "order": []

    });
</script>