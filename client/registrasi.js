$(document).ready(function() {

    let inputTanggalLahir = document.getElementById("input_tanggal_lahir");
    inputTanggalLahir.addEventListener("focusin", function() {
        if (this.type != "date") {
            this.type = "date";
        }
    });
    inputTanggalLahir.addEventListener("focusout", function() {
        if (this.value == "") {
            this.type = "text";
        }
    });

    $("#button-register").click(function() {
        $("#form-registrasi").submit();    
    });

    $("#button-masuk").click(function() {
        window.location.href = "./login.php"    
    });

    $("#form-registrasi").validate({
        rules: {
            nomor_induk_kependudukan: {
                minlength: 16,
                maxlength: 16,
                numeric: true
            },
            nomor_kartu_keluarga: {
                minlength: 16,
                maxlength: 16,
                numeric: true
            },
            nama_lengkap: {
                maxlength: 55
            },
            nomor_handphone: {
                minlength: 6,
                maxlength: 12,
                numeric: true
            },
            email: {
                email: true
            }, 
            password: {
                minlength: 8,
                maxlength: 16
            }, 
            ulangi_password: {
                minlength: 8,
                maxlength: 16,
                equalTo: "#input_password"
            }
        },
        messages: {
            
            nomor_induk_kependudukan: {
                minlength: "Panjang NIK adalah 16 angka",
                maxlength: "Panjang NIK adalah 16 angka",
                numeric: "NIK hanya terdiri dari angka",
                required: "Kolom harus diisi"
            },
            nomor_kartu_keluarga: {
                minlength: "Panjang Nomor KK adalah 16 angka",
                maxlength: "Panjang Nomor KK adalah 16 angka",
                numeric: "Nomor KK hanya terdiri dari angka",
                required: "Kolom harus diisi"
            },
            nama_lengkap: {
                maxlength: "Nama maksimal 55 huruf termasuk spasi"
            },
            tempat_lahir: {
                required: "Kolom harus diisi"
            },
            tanggal_lahir: {
                required: "Kolom harus diisi"
            },
            nomor_handphone: {
                minlength: "Panjang nomor telepon tidak benar",
                maxlength: "Panjang nomor telepon tidak benar",
                numeric: "Nomor telepon hanya terdiri dari angka",
                required: "Kolom harus diisi"
            },
            email: {
                email: "Format email tidak benar",
                required: "Kolom harus diisi"
            }, 
            password: {
                minlength: "Panjang sandi minimal 8 huruf",
                maxlength: "Panjang sandi maksimal 16 huruf",
                required: "Kolom harus diisi"
            }, 
            ulangi_password: {
                minlength: "Panjang sandi minimal 8 huruf",
                maxlength: "Panjang sandi maksimal 16 huruf",
                equalTo: "Sandi tidak sesuai",
                required: "Kolom harus diisi"
            }
        }
    });

});

$.validator.addMethod("numeric", function(value, element) {
    return value.match(/^\d+$/);
}, 
"Hanya terdiri dari angka"
);

$.validator.addMethod("email", function(value, element) {
    return value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
}, 
"Format email tidak benar"
);
