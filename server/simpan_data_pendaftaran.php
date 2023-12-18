<?php 
    include "./config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["izin"]) && $_SESSION["izin"] == "user") {

        $attribute = array(
            "nomor_handphone", "email", "alamat", "jenis_kelamin",
            "kualifikasi_pendidikan", "instansi", "departemen", "formasi_jabatan"
        );
        $data_complete = true;
        $data_needed = count($attribute);
    
        for ($i = 0; $i < $data_needed && $data_complete; $i++) {
            if (!isset($_POST[$attribute[$i]])) {
                $data_complete = false;
            }
        }
    
        if ($data_complete) {
            $akun_id = $_SESSION["id"];

            $nomor_handphone = $_POST["nomor_handphone"];
            $email = $_POST["email"];
            $alamat = $_POST["alamat"];
            $jenis_kelamin = $_POST["jenis_kelamin"];
            $kualifikasi_pendidikan = $_POST["kualifikasi_pendidikan"];
            $instansi = $_POST["instansi"];
            $departemen = $_POST["departemen"];
            $formasi_jabatan = $_POST["formasi_jabatan"];

            $query_status = "SELECT u_status_pendaftaran FROM user WHERE u_id = $akun_id";
            $result_status = mysqli_query($connection, $query_status);

            if ($result_status && mysqli_num_rows($result_status) > 0) {
                $result_data = mysqli_fetch_array($result_status);

                if ($result_data["u_status_pendaftaran"] != "Valid") {
                    $query = "UPDATE user SET u_no_telp = '$nomor_handphone', u_email = '$email', u_alamat = '$alamat', u_jenis_kelamin = '$jenis_kelamin', u_kualifikasi_pendidikan = '$kualifikasi_pendidikan', u_instansi = '$instansi', u_departemen = '$departemen', u_formasi_jabatan = '$formasi_jabatan' WHERE u_id = $akun_id";
                    $result = mysqli_query($connection, $query);
                }
            }
            header("Location: ../client/isi_data_pendaftaran.php");
        }
        else {
            header("Location: ../client/home.php");
        }
    }
    else {
        header("Location: ../client/login.php");
    }
?>