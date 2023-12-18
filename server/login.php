<?php 
    include "./config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["izin"])) {

        $attribute = array(
            "nomor_induk_kependudukan", "password"
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
            $password = $_POST["password"];
    
            $hashed_password = md5($password);
            $query = "SELECT u_id FROM user WHERE u_nik = '$nik' AND u_password = '$hashed_password'";
            
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) == 1) {
                $data = mysqli_fetch_array($result);
                $_SESSION["izin"] = "user";
                $_SESSION["id"] = $data["u_id"];
                header("Location: ../client/home.php");
            }
            else {
                header("Location: ../client/login.php?message=tidak dapat masuk");
            }
        }
        else {
            header("Location: ../client/login.php?message=data tidak lengkap");
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