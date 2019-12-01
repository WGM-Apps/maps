<script >

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


</script>