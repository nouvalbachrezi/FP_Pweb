<?php 
    include "../server/config.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["izin"]) && $_SESSION["izin"] == "admin") {
        header("Location: ./admin/home.php");
    }
    else if (isset($_SESSION["izin"]) && $_SESSION["izin"] == "user") {
        $user_id = $_SESSION["id"];
        $query = "SELECT u_nama_lengkap, u_pas_foto, u_status_pendaftaran FROM user WHERE u_id = $user_id";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_array($result); 
        }
        else {
            $error = "Gagal mengambil data";
        }
    }
    else {
        header("Location: ./login.php");
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
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/home.css">
		<link rel="stylesheet" type="text/css" href="./css/font.css">
		<link rel="stylesheet" type="text/css" href="./css/color.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="./bootstrap/js/bootstrap.bundle.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <div class="col-12 m-0 p-0" id="header">
            <div class="col-12 m-0 px-5 py-2 bg-black d-flex justify-content-between">
                <div class="col-1">
                    <div class="col-10 p-1">
                        <a href="./home.php"><img class="img-fluid" src="./images/logo.png" alt="logo"></a>
                    </div>
                </div>
                <div class="d-flex align-items-center px-3">
                    <a class="text-decoration-none" href="./home.php"><p class="m-0 p-0 primary-font text-primary">Beranda</p></a>
                </div>
                <div class="d-flex align-items-center px-3">
                    <a class="text-decoration-none" href="./status_pendaftaran.php"><p class="m-0 p-0 primary-font text-light">Cek Status Pendaftaran</p></a>
                </div>
                <div class="d-flex align-items-center px-3">
                    <a class="text-decoration-none" href="./hasil_ujian.php"><p class="m-0 p-0 primary-font text-light">Cek Hasil Ujian</p></a>
                </div>
                <div class="d-flex align-items-center px-3">
                    <a class="text-decoration-none" href="<?php echo ($data["u_status_pendaftaran"] == "Lolos") ? "./kartu_ujian.php" : "#" ?>"><p class="m-0 p-0 primary-font <?php echo ($data["u_status_pendaftaran"] == "Lolos") ? "text-light" : "text-white-50" ?>">Cetak Kartu Ujian</p></a>
                </div>
                <div class="d-flex align-items-center px-3">
                    <div class="container">
                        <div class="dropdown">
                            
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="tes">
                                <li><a class="dropdown-item primary-font" href="../server/keluar.php">Keluar</a></li>
                            </ul><button id="tes" type="button" class="btn btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $data["u_nama_lengkap"]; ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-5 m-0 d-flex flex-grow-1 justify-content-center align-items-center color-white-background">
            <div class="row col-10 d-flex flex-column">
                <div class="card-corner bg-light p-4"> 
                    <div class="row col-12">
                        <div class="col-3 m-0">
                            <img src="<?php echo $data["u_pas_foto"] == null ? "./images/foto kosong.png" : "../server".$data["u_pas_foto"] ?>" class="img-fluid">
                        </div>
                        <div class="col-9 px-5"> 
                            <div class="row d-flex flex-column">
                                <div class="pb-3">
                                    <p class="primary-font fw-bold fs-5">Selamat Datang, <?php echo strtoupper($data["u_nama_lengkap"]); ?>!</p>
                                </div>
                                <div class="pb-3">
                                    <p class="primary-font fs-5">Seilahkan untuk memasukkan data pendaftaran dan mengupload berkas terkait. Pastikan semua sudah terisi agar dapat diverifikasi oleh verifikator</p>
                                </div>
                                <div class="pb-3">
                                    <p class="primary-font fs-5">Pastikan semua data diisi dengan benar dan dokumen memiliki format yang tepat</p>
                                </div>
                                <div class="pb-3">
                                    <p class="primary-font fs-5">Mohon cek secara berkala status pendaftaran anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="row col-10 pt-5">
                        <div class="card-corner bg-light p-4">
                            <div class="d-flex flex-row justify-content-between px-4 py-3">
                                <button id="isi-data-pendaftaran" type="button" class="btn btn-primary btn-block col-4 rounded-pill primary-font fs-6">Isi Data Pendaftaran</button>
                                <button id="upload-berkas" type="button" class="btn btn-primary btn-block col-4 rounded-pill primary-font fs-6">Upload Berkas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./home.js"></script>
    </body>
</html>
<?php endif ?>