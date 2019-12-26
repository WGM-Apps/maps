
<script>

$('#tbDetail').DataTable({ 
    "bSort" : false,
    "processing": true, 
    "serverSide": true,
     
    "ajax": {
        "url": "bencana/get_data_tip",
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

function tambahData(){

    $.ajax({
        url: "<?php echo base_url('bencana/tambah')?>",
        type: "POST",
        cache: false,
        beforeSend : function(){
            $('#ModalForm').modal({backdrop: 'static', keyboard: false});
        },
        success: function(html){
            $("#ModalForm").modal('show');
            $("#ModalForm").html(html);
        }
    });
}

function deleteData(id){
    var data = {id:id}

    $.ajax({
        url: "<?php echo base_url('bencana/delete_bencana')?>",
        type: "POST",
        cache: false,
        data : data,
        beforeSend : function(){
            $('#ModalForm').modal({backdrop: 'static', keyboard: false});
        },
        success: function(html){
            $("#ModalForm").modal('show');
            $("#ModalForm").html(html);
        }
    });
}

function editData(id){
    var data = {id:id}

    $.ajax({
        url: "<?php echo base_url('bencana/edit_bencana')?>",
        type: "POST",
        cache: false,
        data : data,
        beforeSend : function(){
            $('#ModalForm').modal({backdrop: 'static', keyboard: false});
        },
        success: function(html){
            $("#ModalForm").modal('show');
            $("#ModalForm").html(html);
        }
    });
}



</script>