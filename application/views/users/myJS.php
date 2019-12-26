
<script>


$('#tbDetail').DataTable({ 
    "bSort" : false,
    "processing": true, 
    "serverSide": true,
     
    "ajax": {
        "url": "users/get_data_tip",
        "type": "post"
    },

    "columns": [
        { "data": "0" },
        { "data": "1" },
        { "data": "2" },
        { "data": "3" },
        { "data": "4" },
        { "data": "5" },
    ],
    "order": []

});

function tambahData(){

    $.ajax({
        url: "<?php echo base_url('users/tambah')?>",
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
        url: "<?php echo base_url('users/delete_users')?>",
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
        url: "<?php echo base_url('users/edit_data')?>",
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