<?php 
    include "./config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["izin"]) && $_SESSION["izin"] == "admin") {

        $_POST = json_decode(file_get_contents('php://input'), true);

        $attribute = array(
            "user_id", "status_pendaftaran"
        );
        $data_complete = true;
        $data_needed = count($attribute);
    
        for ($i = 0; $i < $data_needed && $data_complete; $i++) {
            if (!isset($_POST[$attribute[$i]])) {
                $data_complete = false;
            }
        }
    
        if ($data_complete) {
            $user_id = $_POST["user_id"];
            $status_pendaftaran = $_POST["status_pendaftaran"];
    
            if ($status_pendaftaran == "Lolos") {
                $query = "CALL lolos_berkas($user_id)";
            }
            else if ($status_pendaftaran == "Revisi Data") {
                $query = "UPDATE user SET u_status_pendaftaran = 'Revisi Data' WHERE u_id = $user_id AND u_status_pendaftaran = 'Menunggu Verifikasi'";
            }
            $result = mysqli_query($connection, $query);

            if ($result) {
                echo json_encode("Success");
            }
            else {
                echo json_encode("Failed");
            }
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