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
        $query = "SELECT u_nik, u_nama_lengkap , u_pas_foto, u_foto_ktp, u_foto_kk, u_ijazah, u_transkrip_nilai, u_status_pendaftaran FROM user WHERE u_id = $user_id";
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
<html>
    <head>
        <title>Upload Berkas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./css/home.css">
		<link rel="stylesheet" type="text/css" href="./css/font.css">
		<link rel="stylesheet" type="text/css" href="./css/color.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
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
                    <a class="text-decoration-none" href="./home.php"><p class="m-0 p-0 primary-font text-light">Beranda</p></a>
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
                            <button id="tes" type="button" class="btn btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Nama</button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="tes">
                                <li><a class="dropdown-item" href="#">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-5 m-0 d-flex flex-grow-1 justify-content-center align-items-center color-white-background">
            <div class="row col-8 d-flex flex-column">
                <div class="card-corner bg-light p-4"> 
                    <div class="row col-10 mx-auto">
                        <form id="form-upload-berkas" method="POST" enctype="multipart/form-data" action="../server/simpan_berkas.php">
                            <div class="row d-flex flex-column">
                                <div class="pb-3">
                                    <p class="primary-font fs-4 text-center">Isi Data Pendaftaran</p>
                                </div>
                            </div>
                            <!-- Input pas-foto -->
                            <label class="primary-font fs-6" for="input-pas-foto">Pas Foto</label>
                            <div class="form-outline mb-4 mt-2 d-flex flex-row">
                                <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                                <div class="col-6">
                                    <input type="file" name="pas_foto" id="input-pas-foto" class="form-control form-control-lg required">
                                </div>
                                <?php endif ?>
                                
                                <div class="col-6 p-2 m-0 d-flex flex-column justify-content-center">
                                <?php if(isset($data["u_pas_foto"]) && !is_null($data["u_pas_foto"])): ?>    
                                    <a href="<?php echo "../server".$data["u_pas_foto"] ?>"><p class="primary-font fs-6 text-center">Pas Foto</p></a>
                                <?php else: ?>
                                    <p class="primary-font fs-6 text-center">Belum upload</p>
                                <?php endif ?>
                                </div>
                            </div>

                            <!-- Input foto-ktp -->
                            <label class="primary-font fs-6" for="input-foto-ktp">Kartu Tanda Penduduk</label>
                            <div class="form-outline mb-4 mt-2 d-flex flex-row">
                                <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                                <div class="col-6">
                                    <input type="file" name="foto_ktp" id="input-foto-ktp" class="form-control form-control-lg required">
                                </div>
                                <?php endif ?>
                                <div class="col-6 p-2 m-0 d-flex flex-column justify-content-center">
                                    <?php if(isset($data["u_foto_ktp"]) && !is_null($data["u_foto_kk"])): ?>    
                                        <a href="<?php echo "../server".$data["u_foto_ktp"] ?>"><p class="primary-font fs-6 text-center">Foto Kartu Tanda Penduduk</p></a>
                                    <?php else: ?>
                                        <p class="primary-font fs-6 text-center">Belum upload</p>
                                    <?php endif ?>
                                </div>
                            </div>

                            <!-- Input foto-kk -->
                            <label class="primary-font fs-6" for="input-foto-kk">Kartu Keluarga</label>
                            <div class="form-outline mb-4 mt-2 d-flex flex-row">
                                <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                                <div class="col-6">
                                    <input type="file" name="foto_kk" id="input-foto-kk" class="form-control form-control-lg required">
                                </div>
                                <?php endif ?>
                                <div class="col-6 p-2 m-0 d-flex flex-column justify-content-center">
                                    <?php if(isset($data["u_foto_kk"]) && !is_null($data["u_foto_kk"])): ?>    
                                        <a href="<?php echo "../server".$data["u_foto_kk"] ?>"><p class="primary-font fs-6 text-center">Foto Kartu Keluarga</p></a>
                                    <?php else: ?>
                                        <p class="primary-font fs-6 text-center">Belum upload</p>
                                    <?php endif ?>
                                </div>
                            </div>

                            <!-- Input ijazah -->
                            <label class="primary-font fs-6" for="input-ijazah">Ijazah</label>
                            <div class="form-outline mb-4 mt-2 d-flex flex-row">
                                <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                                <div class="col-6">
                                    <input type="file" name="ijazah" id="input-ijazah" class="form-control form-control-lg required">
                                </div>
                                <?php endif ?>
                                <div class="col-6 p-2 m-0 d-flex flex-column justify-content-center">
                                    <?php if(isset($data["u_ijazah"]) && !is_null($data["u_ijazah"])): ?>    
                                        <a href="<?php echo "../server".$data["u_ijazah"] ?>"><p class="primary-font fs-6 text-center">Foto Ijazah</p></a>
                                    <?php else: ?>
                                        <p class="primary-font fs-6 text-center">Belum upload</p>
                                    <?php endif ?>
                                </div>
                            </div>

                            <!-- Input transkrip-nilai -->
                            <label class="primary-font fs-6" for="input-transkrip-nilai">Transkrip Nilai</label>
                            <div class="form-outline mb-4 mt-2 d-flex flex-row">
                                <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                                <div class="col-6">
                                    <input type="file" name="transkrip_nilai" id="input-transkrip-nilai" class="form-control form-control-lg required">
                                </div>
                                <?php endif ?>
                                <div class="col-6 p-2 m-0 d-flex flex-column justify-content-center">
                                    <?php if(isset($data["u_transkrip_nilai"]) && !is_null($data["u_transkrip_nilai"])): ?>    
                                        <a href="<?php echo "../server".$data["u_transkrip_nilai"] ?>"><p class="primary-font fs-6 text-center">Foto Transkrip Nilai</p></a>
                                    <?php else: ?>
                                        <p class="primary-font fs-6 text-center">Belum upload</p>
                                    <?php endif ?>
                                </div>
                            </div>

                            <!-- Tombol registrasi -->
                            <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                            <div class="col d-flex justify-content-between mt-3">
                                <button id="button-upload-berkas" type="button" class="btn btn-primary btn-block rounded-pill mb-4 primary-font fs-6">Update Berkas</button>
                            </div>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./upload-berkas.js"></script>
    </body>
</html>