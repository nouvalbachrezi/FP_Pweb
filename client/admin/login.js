$(document).ready(function() {

    $("#button-masuk").click(function() {
        $("#form-login-admin").submit();        
    });

    $("#form-login-admin").validate({
        messages: {
            username: {
                required: "Kolom harus diisi"
            },
            password: {
                required: "Kolom harus diisi"
            },
        }
    });

});