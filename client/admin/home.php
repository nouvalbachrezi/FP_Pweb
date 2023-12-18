<?php 
    include "../../server/config.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["izin"])) {
        header("Location: ./login.php");
    }
    else if ($_SESSION["izin"] == "admin") {
        $user_id = $_SESSION["id"];
        $query = "SELECT a_id, a_username FROM admin WHERE a_id = $user_id";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_array($result); 
        }
        else {
            $error = "Gagal mengambil data";
        }
    }
    else {
        header("Location: ../home.php");
    }
?>
<?php if(isset($error)): ?>
    <?php
        echo $error; 
    ?>
<?php else: ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/home.css">
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/color.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/bootstrap.bundle.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <div class="col-12 m-0 p-0" id="header">
            <div class="col-12 m-0 px-5 py-2 bg-black d-flex justify-content-between">
                <div class="col-1">
                    <div class="col-10 p-1">
                        <a href="./home.php"><img class="img-fluid" src="../images/logo.png" alt="logo"></a>
                    </div>
                </div>
                <div class="d-flex align-items-center px-3">
                    <div class="container">
                        <div class="dropdown">
                            <button id="tes" type="button" class="btn btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $data["a_username"]; ?></button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="tes">
                                <li><a class="dropdown-item primary-font" href="../../server/keluar.php">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-5 m-0 d-flex flex-grow-1 justify-content-center align-items-center color-white-background">
            <div class="row col-10 d-flex flex-column">
                <p class="primary-font fs-3 text-center text-decoration-underline">Verifikasi Data Pendaftar</p>
                <div class="d-flex flex-row">
                    <div class="col-4 p-2 d-flex flex-column border-end border-1 border-dark">
                        <p class="primary-font fs-5 text-center">Filter Pendaftar</p>
                        <div class="py-2">
                            <button id="button-filter-menunggu-verifikasi" type="button" class="btn btn-primary btn-block rounded-pill primary-font fs-6">Menungu Verifikasi</button>
                        </div>
                        <div class="py-2">
                            <button id="button-filter-belum-isi" type="button" class="btn btn-warning btn-block rounded-pill primary-font fs-6">Belum Isi Data</button>
                        </div>
                        <div class="py-2">
                            <button id="button-filter-revisi" type="button" class="btn btn-danger btn-block rounded-pill primary-font fs-6">Revisi Data</button>
                        </div>
                        <div class="py-2">
                            <button id="button-filter-lolos" type="button" class="btn btn-success btn-block rounded-pill primary-font fs-6">Lolos</button>
                        </div>    
                    </div>
                    <div class="col-8">
                        <div id="list-pendaftar" class="list-group d-flex flex-row flex-wrap">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./home.js"></script>
    </body>
</html>
<?php endif?>