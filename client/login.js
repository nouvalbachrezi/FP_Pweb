$(document).ready(function() {

    $("#button-registrasi").click(function() {
        window.location.href = "./registrasi.php"
    });

    $("#button-masuk").click(function() {
        $("#form-login").submit();        
    });

    $("#form-login").validate({
        rules: {
            nomor_induk_kependudukan: {
                minlength: 16,
                maxlength: 16,
                numeric: true
            },
            password: {
                minlength: 8,
                maxlength: 16
            }
        },
        messages: {
            
            nomor_induk_kependudukan: {
                minlength: "Panjang NIK adalah 16 angka",
                maxlength: "Panjang NIK adalah 16 angka",
                numeric: "NIK hanya terdiri dari angka",
                required: "Kolom harus diisi"
            },
            password: {
                minlength: "Panjang sandi minimal 8 huruf",
                maxlength: "Panjang sandi maksimal 16 huruf",
                required: "Kolom harus diisi"
            },
        }
    });

});

$.validator.addMethod("numeric", function(value, element) {
    return value.match(/^\d+$/);
}, 
"Hanya terdiri dari angka"
);