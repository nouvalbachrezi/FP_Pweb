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
        $query = "SELECT u_nik, u_nama_lengkap, u_email, u_no_kk, u_no_telp, u_tempat_lahir, u_tanggal_lahir, u_alamat, u_jenis_kelamin, u_kualifikasi_pendidikan, u_instansi, u_departemen, u_formasi_jabatan, u_status_pendaftaran FROM user WHERE u_id = $user_id";
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
        <title>Data Pribadi</title>
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
                        <a href="./home.home"><img class="img-fluid" src="./images/logo.png" alt="logo"></a>
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
            <div class="row col-8 d-flex flex-column">
                <div class="card-corner bg-light p-4"> 
                    <div class="row col-10 mx-auto">
                        <form id="form-isi-data-pendaftaran" method="post" action="../server/simpan_data_pendaftaran.php">
                            <div class="row d-flex flex-column">
                                <div class="pb-3">
                                    <p class="primary-font fs-4 text-center">Isi Data Pendaftaran</p>
                                </div>
                            </div>
                            <!-- Input nomor induk kependudukan -->
                            <label class="primary-font fs-6" for="input-nik">Nomor Induk kependudukan</label>
                            <div class="form-outline mb-4 mt-2">
                                <p class="primary-font"><?php echo $data["u_nik"]; ?></p>
                                <!-- <input type="text" name="nomor-induk-kependudukan" id="input-nik" class="form-control rounded-pill border border-success primary-font fs-6 required" value="XXXXXXXXXXXXXXXX" readonly/> -->
                            </div>

                            <!-- Input nomor kartu keluarga -->
                            <label class="primary-font fs-6" for="input-kk">Nomor Kartu Keluarga</label>
                            <div class="form-outline mb-4 mt-2">
                                <p class="primary-font"><?php echo $data["u_no_kk"]; ?></p>
                                <!-- <input type="text" name="nomor-kartu-keluarga" id="input-kk" class="form-control rounded-pill border border-success primary-font fs-6 required" value="XXXXXXXXXXXXXXXX" readonly/> -->
                            </div>

                            <!-- Input nama lengkap -->
                            <label class="primary-font fs-6" for="input-nama-lengkap">Nama Lengkap</label>
                            <div class="form-outline mb-4 mt-2">
                                <p class="primary-font"><?php echo $data["u_nama_lengkap"]; ?></p>
                                <!-- <input type="text" name="nama-lengkap" id="input-nama-lengkap" class="form-control rounded-pill border border-success primary-font fs-6 required" value="XXXXXXXXXXXXXXXX" readonly/> -->
                            </div>

                            <!-- Input tempat lahir -->
                            <label class="primary-font fs-6" for="input-tempat-lahir">Tempat Lahir</label>
                            <div class="form-outline mb-4 mt-2">
                                <p class="primary-font"><?php echo $data["u_tempat_lahir"]; ?></p>
                                <!-- <input type="text" name="tempat-lahir" id="input-tempat-lahir" class="form-control rounded-pill border border-success primary-font fs-6 required" value="XXXXXXXXXXXXXXXX" readonly/> -->
                            </div>

                            <!-- Input tanggal lahir -->
                            <label class="primary-font fs-6" for="input-tanggal-lahir">Tanggal Lahir</label>
                            <div class="form-outline mb-4 mt-2">
                                <p class="primary-font"><?php echo $data["u_tanggal_lahir"]; ?></p>
                                <!-- <input type="text" name="tanggal-lahir" id="input-tanggal-lahir" class="form-control rounded-pill border border-success primary-font fs-6 required" value="XXXXXXXXXXXXXXXX" readonly/> -->
                            </div>

                            <!-- Input nomor handphone -->
                            <label class="primary-font fs-6" for="input-nomor-handphone">Nomor HP</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="nomor_handphone" id="input-nomor-handphone" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_no_telp"]; ?>" />
                            </div>

                            <!-- Input email -->
                            <label class="primary-font fs-6" for="">Email</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="email" id="input-email" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_email"]; ?>" />
                            </div>

                            <!-- Input alamat domisili -->
                            <label class="primary-font fs-6" for="input-alamat">Alamat Domisili</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="alamat" id="input-alamat" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_alamat"] != null ? $data["u_alamat"] : ""; ?>" />
                            </div>

                            <!-- Input jenis kelamin -->
                            <label class="primary-font fs-6" for="input-jenis-kelamin">Jenis Kelamin</label>                            
                            <div class="form-outline mb-4 mt-2 d-flex ">
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input p-3 me-3 border-success required" <?php echo $data["u_jenis_kelamin"] == "Laki-laki" ? "checked" : ""; ?> type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki">
                                    <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input p-3 me-3 border-success required" <?php echo $data["u_jenis_kelamin"] == "Perempuan" ? "checked" : ""; ?> type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>

                            <!-- Input kualifikasi pendidikan -->
                            <label class="primary-font fs-6" for="input-kualifikasi-pendidikan">Kualifikasi Pendidikan</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="kualifikasi_pendidikan" id="input-kualifikasi-pendidikan" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_kualifikasi_pendidikan"] != null ? $data["u_kualifikasi_pendidikan"] : ""; ?>" />
                            </div>                            

                            <!-- Input instansi -->
                            <label class="primary-font fs-6" for="input-instansi">Instansi</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="instansi" id="input-instansi" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_instansi"] != null ? $data["u_instansi"] : ""; ?>" />
                            </div>                            

                            <!-- Input departemen -->
                            <label class="primary-font fs-6" for="input-departemen">Departemen</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="departemen" id="input-departemen" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_departemen"] != null ? $data["u_departemen"] : ""; ?>" />
                            </div>                            

                            <!-- Input formasi-jabatan -->
                            <label class="primary-font fs-6" for="input-formasi-jabatan">Formasi Jabatan</label>                            
                            <div class="form-outline mb-4 mt-2">
                                <input type="text" name="formasi_jabatan" id="input-formasi-jabatan" class="form-control rounded-pill border border-success primary-font fs-6 required" value="<?php echo $data["u_formasi_jabatan"] != null ? $data["u_formasi_jabatan"] : ""; ?>" />
                            </div>                            


                            <!-- Tombol registrasi -->
                            <?php if(!isset($data["u_status_pendaftaran"]) || is_null($data["u_status_pendaftaran"]) || $data["u_status_pendaftaran"] != "Lolos"): ?>
                            <div class="col d-flex justify-content-between mt-3">
                                <button id="button-simpan-data" type="button" class="btn btn-primary btn-block rounded-pill mb-4 primary-font fs-6">Simpan Data</button>
                            </div>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./isi_data_pendaftaran.js"></script>
    </body>
</html>
<?php endif ?>