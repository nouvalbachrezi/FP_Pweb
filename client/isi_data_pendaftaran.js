$(document).ready(function() {

    $("#button-simpan-data").click(function() {
        $("#form-isi-data-pendaftaran").submit();    
    });

    $("#form-isi-data-pendaftaran").validate({
        rules: {
            nomor_handphone: {
                minlength: 6,
                maxlength: 12,
                numeric: true
            },
            email : {
                email: true
            },
            alamat: {
                maxlength: 255
            },
            kualifikasi_pendidikan: {
                maxlength: 100
            },
            instansi: {
                maxlength: 100
            },
            departemen: {
                maxlength: 100
            },
            formasi_jabatan: {
                maxlength: 100
            }
        },
        messages: {
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
            alamat: {
                maxlength: "Maksimal hanya 255 huruf",
                required: "Kolom harus diisi"
            },
            jenis_kelamin: {
                required: ""
            },
            kualifikasi_pendidikan: {
                maxlength: "Maksimal 100 huruf",
                required: "Kolom harus diisi"
            },
            instansi: {
                maxlength: "Maksimal 100 huruf",
                required: "Kolom harus diisi"
            },
            departemen: {
                maxlength: "Maksimal 100 huruf",
                required: "Kolom harus diisi"
            },
            formasi_jabatan: {
                maxlength: "Maksimal 100 huruf",
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
