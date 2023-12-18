<?php 
    include "./config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["izin"])) {

        $attribute = array(
            "nomor_induk_kependudukan", "nomor_kartu_keluarga", "nama_lengkap", "tempat_lahir",
            "tanggal_lahir", "nomor_handphone", "email", "password", "ulangi_password"
        );
        $data_complete = true;
        $data_needed = count($attribute);
    
        for ($i = 0; $i < $data_needed && $data_complete; $i++) {
            if (!isset($_POST[$attribute[$i]])) {
                $data_complete = false;
            }
        }
    
        if ($data_complete) {
            $nik = $_POST["nomor_induk_kependudukan"];
            $no_kk = $_POST["nomor_kartu_keluarga"];
            $nama = $_POST["nama_lengkap"];
            $tempat_lahir = $_POST["tempat_lahir"];
            $tanggal_lahir = $_POST["tanggal_lahir"];
            $nomor_hp = $_POST["nomor_handphone"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $ulangi_password = $_POST["ulangi_password"];
    
    
            if ($password == $ulangi_password) {
                $hashed_password = md5($password);
                $query = "INSERT INTO user (u_nik, u_password, u_nama_lengkap, u_email, u_no_kk, u_no_telp, u_tempat_lahir, u_tanggal_lahir, u_status_pendaftaran) VALUES ('$nik', '$hashed_password', '$nama', '$email', '$no_kk', '$nomor_hp', '$tempat_lahir', '$tanggal_lahir', 'Belum Isi Data')";
                
                $result = mysqli_query($connection, $query);
    
                if ($result) {
                    header("Location: ../client/login.php");
                }
                else {
                    header("Location: ../client/registrasi.php?message=registrasi gagal");
                }
            }
            else {
                header("Location: ../client/registrasi.php?message=password tidak sama");
            }
        }
        else {
            header("Location: ../client/registrasi.php?message=data tidak lengkap");
        }
    }
    else {
        if ($_SESSION["izin"] == "user") {
            header("Location: ../client/home.php");
        }
        else if ($_SESSION["izin"] == "admin") {
            header("Location: ../client/admin/home.php");
        }
        else {
            header("Location: ../client/login.php");
        }
    }
?>