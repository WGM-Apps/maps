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

    //-----Adds an element to the document-------
    function addElementDampak(parentId, elementTag, elementId, html) {
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.innerHTML = html;
        p.appendChild(newElement);
    }

    function removeElementDampak(elementId) {
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
    }

    var fileIdDampak = 0;
    function addDampak() {
        fileIdDampak++;
        var html =  '<aside class="row">'+
                    '<aside class="col-md-10"><input type="text" name="dampak[]" placeholder="Keterangan Dampak..." onkeyup="javascript:this.value=this.value.toUpperCase()" class="form-control" /></aside>'+
                    '<aside class="col"><a href="javascript:void(0)" onclick="javascript:removeElementDampak(\'fileDampak-' + fileIdDampak + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                    '<i class="fa fa-times"></i></a></aside>'+
                    '</aside>';
        addElementDampak('dampak', 'p', 'fileDampak-' + fileIdDampak, html);
    }
    //-----Close Adds an element to the document-------

    //-----Adds an element to the document-------
    function addElementKebutuhan(parentId, elementTag, elementId, html) {
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.innerHTML = html;
        p.appendChild(newElement);
    }

    function removeElementKebutuhan(elementId) {
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
    }

    var fileIdKebutuhan = 0;
    function addKebutuhan() {
        fileIdKebutuhan++;
        var html =  '<aside class="row">'+
                    '<aside class="col-md-10"><input type="text" name="kebutuhan[]" placeholder="Keterangan Kebutuhan..." onkeyup="javascript:this.value=this.value.toUpperCase()" class="form-control" /></aside>'+
                    '<aside class="col"><a href="javascript:void(0)" onclick="javascript:removeElementKebutuhan(\'fileKebutuhan-' + fileIdKebutuhan + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                    '<i class="fa fa-times"></i></a></aside>'+
                    '</aside>';
        addElementKebutuhan('kebutuhan', 'p', 'fileKebutuhan-' + fileIdKebutuhan, html);
    }
    //-----Close Adds an element to the document-------

    //-----Adds an element to the document-------
    function addElementPIC(parentId, elementTag, elementId, html) {
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.innerHTML = html;
        p.appendChild(newElement);
    }

    function removeElementPIC(elementId) {
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
    }

    var fileIdPIC = 0;
    function addPIC() {
        fileIdPIC++;
        var html =  '<aside class="row">'+
                    '<aside class="col-md-10"><input type="text" name="pic[]" placeholder="PIC" onkeyup="javascript:this.value=this.value.toUpperCase()" class="form-control" style="width: 50%;display: inline;" /><input type="text" name="hp[]" placeholder="HP" onkeypress="return formatNumber(event)" class="form-control" style="width: 50%;display: inline;" /></aside>'+
                    '<aside class="col"><a href="javascript:void(0)" onclick="javascript:removeElementPIC(\'filePIC-' + fileIdPIC + '\'); return false;" class="btn btn-outline-danger btn-block btn-sm">'+
                    '<i class="fa fa-times"></i></a></aside>'+
                    '</aside>';
        addElementPIC('PIC', 'p', 'filePIC-' + fileIdPIC, html);
    }

    //-----Close Adds an element to the document-------

    function simpan_maps() {
        var data = $('#frm_simpan_maps').serialize();
        var btn = document.getElementById('simpan_maps');
        $.ajax({
            type: "post",
            url: "<?php echo base_url('maps/simpan_maps')?>",
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
            "url": "maps/get_data_tip",
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

    function delete_maps(id){
        var data = {id:id}

        $.ajax({
            url: "<?php echo base_url('maps/hapus_data')?>",
            type: "POST",
            cache: false,
            data : data,
            beforeSend : function(){
                $('#ModalDelete').modal({backdrop: 'static', keyboard: false});
            },
            success: function(html){
                $("#ModalDelete").modal('show');
                $("#ModalDelete").html(html);
            }
        });
    }

    function edit_maps(id){
        var data = {id:id}

        $.ajax({
            url: "<?php echo base_url('maps/edit_maps')?>",
            type: "POST",
            cache: false,
            data : data,
            beforeSend : function(){
                $('#ModalEdit').modal({backdrop: 'static', keyboard: false});
            },
            success: function(html){
                $("#ModalEdit").modal('show');
                $("#ModalEdit").html(html);
            }
        });
    }

    var delay;
    function manual_position() {
        clearTimeout(delay);
        delay = setTimeout(function() {
            marker.setMap(null);
            var manual_lat = $('#text_lat').val();
            var manual_lng = $('#text_lng').val();
            document.getElementById('current').innerHTML="<a href='javascript:void(0)' onclick='initialize_map(); initialize()'><i class='fa fa-map-marker-alt'></i> Lokasi saat ini</a> <a class='float-right' target='_blank' href='https://www.google.com/maps?q=loc:"+manual_lat+","+manual_lng+"'><i class='fa fa-map'></i> Lihat Google Maps</a>";
            var pos= new google.maps.LatLng(manual_lat, manual_lng);
            map.setCenter(pos);
            map.setZoom(14);

            marker = new google.maps.Marker({
                position: pos,
                map: map
            });
        }, 2000);
    }

</script>