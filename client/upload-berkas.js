$(document).ready(function() {

    $("#button-upload-berkas").click(function() {
        $("#form-upload-berkas").submit();    
    });

    $("#form-upload-berkas").validate({
        messages: {
            pas_foto: {
                required: "Foto harus diisi"
            },
            foto_ktp: {
                required: "Foto harus diisi"
            },
            foto_kk: {
                required: "Foto harus diisi"
            },
            ijazah: {
                required: "Foto harus diisi"
            },
            transkrip_nilai: {
                required: "Foto harus diisi"
            }
        }
    });

});
