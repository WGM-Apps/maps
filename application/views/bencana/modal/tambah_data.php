<div class="modal-dialog">
    <div class="modal-content">
        <form name="formData" id="formData" method="post" action="javascript:void(0)" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        Nama
                    </div>
                    <div class="col-md-10">
                        <input name="nama_bencana" id="nama_bencana" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase()">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Icon
                    </div>
                    <div class="col-md-10">
                        <input type="file" name="file_icon" id="file_icon" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" id="tutup" data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button class="btn btn-primary btn-sm" type="button" onclick="simpanbencana()"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function simpanbencana(){
    var formData = new FormData($('#formData')[0]); 
    $.ajax({
        url : '<?php echo base_url().'bencana/simpan'?>',
        data : formData,
        cache : false,
        type : 'post',
        dataType : 'json',
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        success : function(res){
            var isValid = res.isValid;
            var isPesan = res.isPesan;

            if(isValid == 0){
                alert(isPesan);
            }else{
                alert(isPesan);
                $("#ModalForm").modal('hide');
            }
            

        }
    });
}

</script>