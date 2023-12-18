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
        $query = "SELECT u_nama_lengkap, u_status_pendaftaran, u_instansi, jadwal_ujian_j_id, u_nik, u_nomor_registrasi, u_jenis_kelamin, u_tempat_lahir, u_tanggal_lahir, u_kualifikasi_pendidikan, u_pas_foto, u_formasi_jabatan FROM user WHERE u_id = $user_id";
        $result = mysqli_query($connection, $query);

        
        if ($result && mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_array($result);

            $jadwal_id = $data["jadwal_ujian_j_id"];

            $query_lokasi_tes = "SELECT j_lokasi_ujian, j_tanggal_ujian, j_waktu_ujian FROM jadwal_ujian WHERE j_id = $jadwal_id";
            $result_lokasi_tes = mysqli_query($connection, $query_lokasi_tes);

            if ($result_lokasi_tes) {
                $data_jadwal = mysqli_fetch_array($result_lokasi_tes); 
            }
            else {
                $error = "Gagal mengambil data";
            }
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
<?php elseif($data["u_status_pendaftaran"] == "Lolos"): ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cetak Kartu Ujian</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/kartu_ujian.css">
		<link rel="stylesheet" type="text/css" href="./css/font.css">
		<link rel="stylesheet" type="text/css" href="./css/color.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
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
                    <a class="text-decoration-none" href="./kartu_ujian.php"><p class="m-0 p-0 primary-font text-light">Cetak Kartu Ujian</p></a>
                </div>
                <div class="d-flex align-items-center px-3">
                    <div class="container">
                        <div class="dropdown">
                            <button id="tes" type="button" class="btn btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $data["u_nama_lengkap"]; ?></button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="tes">
                                <li><a class="dropdown-item primary-font" href="../server/keluar.php">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-5 m-0 d-flex flex-grow-1 justify-content-center align-items-center color-white-background">
            <div class="row col-10 d-flex flex-column">
                <div class="pb-4 d-flex flex-row justify-content-end">
                    <button id="button-unduh" type="button" class="btn btn-primary btn-block rounded-pill col-2 primary-font fs-6">Unduh</button>
                </div>
                <div class="border border-1 border-dark bg-white">
                    <div class="row d-flex flex-column px-5">
                        <nav class="navbar navbar-expand-md">
                            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active d-flex justify-content-center">
                                        <img class="w-50 img-fluid" src="./images/logo.png">
                                    </li>
                                </ul>
                            </div>
                            <div class="mx-auto order-0 col-6 align-items-center">
                                <p class="navbar-brand mx-auto text-center m-0 p-0 fs-3 fw-bold text-wrap">KARTU PESERTA UJIAN CPNS 2017</p>
                            </div>
                            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2"></div>
                        </nav>
                        <hr>
                        <div class="col-12 d-flex flex-row">
                            <div class="row col-9 d-flex flex-column pb-3">
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Instansi</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_instansi"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Lokasi Tes</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data_jadwal["j_lokasi_ujian"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Jadwal Tes</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data_jadwal["j_tanggal_ujian"]." ".$data_jadwal["j_waktu_ujian"]; ?> </p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">NIK</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_nik"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Nomor Peserta</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo str_pad($data['u_nomor_registrasi'],8,'0', STR_PAD_LEFT); ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Nama</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_nama_lengkap"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Jenis Kelamin</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_jenis_kelamin"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Tempat/Tanggal Lahir</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_tempat_lahir"]."/".$data["u_tanggal_lahir"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Kualifikasi Pendidikan</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_kualifikasi_pendidikan"]; ?></p>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="col-4">
                                        <p class="primary-font fs-5">Formasi Jabatan</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="primary-font fs-5 ps-3"><?php echo $data["u_formasi_jabatan"]; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-3 d-flex flex-column">
                                <svg id="barcode"></svg>
                                <script>JsBarcode("#barcode", ("00000000" + "<?php echo $data["u_nomor_registrasi"]; ?>").slice(-8));</script>
                                
                                <img class="img-fluid" src="../server<?php echo $data["u_pas_foto"]; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./kartu_ujian.js"></script>
    </body>
</html>
<?php else: ?>
    <?php
        header("Location: ./home.php"); 
    ?>
<?php endif ?>