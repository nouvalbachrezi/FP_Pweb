<?php 
    include "./config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["izin"]) && $_SESSION["izin"] == "admin") {

        $_POST = json_decode(file_get_contents('php://input'), true);

        $attribute = array(
            "kategori"
        );
        $data_complete = true;
        $data_needed = count($attribute);
    
        for ($i = 0; $i < $data_needed && $data_complete; $i++) {
            if (!isset($_POST[$attribute[$i]])) {
                $data_complete = false;
            }
        }
    
        $data = array();
        if ($data_complete) {
            $kategori = $_POST["kategori"];
    
            $query = "SELECT u_id, u_nama_lengkap, u_status_pendaftaran FROM user WHERE u_status_pendaftaran = '$kategori'";
            $result = mysqli_query($connection, $query);

            if ($result) {

                while($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
            }
            echo json_encode($data);
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