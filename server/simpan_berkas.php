<?php 
    include "./config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["izin"]) && $_SESSION["izin"] == "user") {

        $attribute = array(
            "pas_foto", "foto_ktp", "foto_kk", "ijazah", "transkrip_nilai"
        );
        $data_complete = true;
        $data_needed = count($attribute);

        for ($i = 0; $i < $data_needed && $data_complete; $i++) {
            if (!isset($_FILES[$attribute[$i]])) {
                $data_complete = false;
            }
        }
    
        if ($data_complete) {
            $akun_id = $_SESSION["id"];

            $query_old_files = "SELECT u_pas_foto, u_foto_ktp, u_foto_kk, u_ijazah, u_transkrip_nilai, u_status_pendaftaran FROM user WHERE u_id = $akun_id";
            $result_old_files = mysqli_query($connection, $query_old_files);
            
            if ($result_old_files && mysqli_num_rows($result_old_files) > 0) {
                $data_old_files = mysqli_fetch_array($result_old_files);

                if ($data_old_files["u_status_pendaftaran"] != "Valid") {

                    $paths = array();
                    $success_moving_file = true;
                    for ($i = 0; $i < $data_needed && $data_complete; $i++) {
                        $foto = $_FILES[$attribute[$i]]['name'];
                        $tmp = $_FILES[$attribute[$i]]['tmp_name'];
        
                        $fotobaru = date('dmYHis').$foto;
                        $paths[$attribute[$i]] = "/images/$fotobaru";
        
                        if(!move_uploaded_file($tmp, ".".$paths[$attribute[$i]])) {
                            $success_moving_file = false;
                        }
                    }
        
                    if ($success_moving_file) {
        
                        if ($data_old_files["u_pas_foto"] != null) {
                            unlink(".".$data_old_files["u_pas_foto"]);
                        }
                        if ($data_old_files["u_foto_ktp"] != null) {
                            unlink(".".$data_old_files["u_foto_ktp"]);
                        }
                        if ($data_old_files["u_foto_kk"] != null) {
                            unlink(".".$data_old_files["u_foto_kk"]);
                        }
                        if ($data_old_files["u_ijazah"] != null) {
                            unlink(".".$data_old_files["u_ijazah"]);
                        }
                        if ($data_old_files["u_transkrip_nilai"] != null) {
                            unlink(".".$data_old_files["u_transkrip_nilai"]);
                        }
        
                        $pas_foto = $paths["pas_foto"];
                        $foto_ktp = $paths["foto_ktp"];
                        $foto_kk = $paths["foto_kk"];
                        $ijazah = $paths["ijazah"];
                        $transkrip_nilai = $paths["transkrip_nilai"];

                        $query = "UPDATE user SET u_pas_foto = '$pas_foto', u_foto_ktp = '$foto_ktp', u_foto_kk = '$foto_kk', u_ijazah = '$ijazah', u_transkrip_nilai = '$transkrip_nilai' WHERE u_id = $akun_id";
                        $result = mysqli_query($connection, $query);
                    }
                    else {
                        foreach($paths as $attr => $path) {
                            unlink($path);
                        }
                    }
                }
            }
        }
        header("Location: ../client/upload-berkas.php");
    }
    else {
        header("Location: ../client/login.php");
    }
?>