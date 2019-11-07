<script>
    function proses_login() {
        var data = $('#form_login').serialize();
        $.ajax({
            url : 'auth_controller/login',
            type : 'post',
            cahce : false,
            data : data,
            dataType : 'json',
            beforeSend : function(){
                $('#btn_login').html("<img src='assets/img/loading.gif' width='20px'>");
            },
            success : function(result){
                localStorage.clear();
                var isValid = result.isValid;
                var isPesan = result.isPesan;
                if(isValid == 1){
                    $('#btn_login').html('Masuk');
                    $('#btn_login').show();
                    $('#pesan').html(isPesan);
                }else{
                    window.location.href = './';
                }
            }
        });
    }
    </script>