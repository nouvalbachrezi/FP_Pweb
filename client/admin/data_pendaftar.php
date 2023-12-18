<?php 
    include "../../server/config.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["izin"])) {
        header("Location: ./login.php");
    }
    else if ($_SESSION["izin"] == "admin") {
        if (isset($_GET["user_id"])) {
            $admin_id = $_SESSION["id"];
            $query = "SELECT a_id, a_username FROM admin WHERE a_id = $admin_id";
            $result = mysqli_query($connection, $query);

            $user_id = $_GET["user_id"];
            $query_user_data = "SELECT u_nik, u_nama_lengkap, u_email, u_no_kk, u_no_telp, u_tempat_lahir, u_tanggal_lahir, u_alamat, u_jenis_kelamin, u_kualifikasi_pendidikan, u_instansi, u_departemen, u_formasi_jabatan, u_pas_foto, u_foto_ktp, u_foto_kk, u_ijazah, u_transkrip_nilai, u_status_pendaftaran FROM user WHERE u_id = $user_id";
            $result_user_data = mysqli_query($connection, $query_user_data);

            if ($result && mysqli_num_rows($result) == 1 && $result_user_data && mysqli_num_rows($result_user_data) == 1) {
                $data = mysqli_fetch_array($result);

                $user_data = mysqli_fetch_array($result_user_data);
            }
            else {
                $error = "Gagal mengambil data";
            }
        }
        else {
            header("Location: ./home.php");
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
        <title>Data Pendaftar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
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
                                <li><a class="dropdown-item primary-font" href="#">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 p-5 m-0 d-flex flex-grow-1 justify-content-center align-items-center color-white-background">
            <div class="row col-6 d-flex flex-column">
                <p class="primary-font fs-3 text-center text-decoration-underline">Formulir Pendaftaran</p>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">NIK</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_nik"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Nama Lengkap</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_nama_lengkap"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Nomor Kartu Keluarga</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_no_kk"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Tempat Lahir</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_tempat_lahir"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Tanggal Lahir</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_tanggal_lahir"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Alamat</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_alamat"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Jenis Kelamin</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_jenis_kelamin"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Kualifikasi Pendidikan</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_kualifikasi_pendidikan"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Instansi</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_instansi"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Departemen</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_departemen"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Formasi Jabatan</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_formasi_jabatan"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Status Pendaftaran</p>
                    <p class="primary-font fs-5 mt-2"><?php echo $user_data["u_status_pendaftaran"] ?></p>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Pas Foto</p>
                    <div class="d-flex flex-row justify-content-center mt-2">
                        <div class="col-4">
                            <?php 
                                if (is_null($user_data["u_pas_foto"])) {
                                    echo "<img class='img-fluid' src='../images/foto kosong.png'>";
                                } 
                                else {
                                    $link = $user_data["u_pas_foto"];
                                    echo "<img class='img-fluid' src='../../server$link'>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Foto Kartu Tanda Penduduk</p>
                    <div class="d-flex flex-row justify-content-center mt-2">
                        <?php 
                            if (is_null($user_data["u_foto_ktp"])) {
                                echo "<a class='primary-font fs-5 mt-2' href='#'>Belum Upload File</a>";
                            } 
                            else {
                                $link = $user_data["u_foto_ktp"];
                                echo "<a class='primary-font fs-5 mt-2' href='../../server$link' target='_blank'>Klik untuk membuka Foto Kartu Tanda Penduduk</a>";
                            }
                        ?>
                    </div>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Foto Kartu Keluarga</p>
                    <div class="d-flex flex-row justify-content-center mt-2">
                        <?php 
                            if (is_null($user_data["u_foto_kk"])) {
                                echo "<a class='primary-font fs-5 mt-2' href='#'>Belum Upload File</a>";
                            } 
                            else {
                                $link = $user_data["u_foto_kk"];
                                echo "<a class='primary-font fs-5 mt-2' href='../../server$link' target='_blank'>Klik untuk membuka Foto Kartu Keluarga</a>";
                            }
                        ?>
                    </div>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Foto Ijazah</p>
                    <div class="d-flex flex-row justify-content-center mt-2">
                        <?php 
                            if (is_null($user_data["u_ijazah"])) {
                                echo "<a class='primary-font fs-5 mt-2' href='#'>Belum Upload File</a>";
                            } 
                            else {
                                $link = $user_data["u_ijazah"];
                                echo "<a class='primary-font fs-5 mt-2' href='../../server$link' target='_blank'>Klik untuk membuka Foto Ijazah</a>";
                            }
                        ?>
                    </div>
                </div>
                <div class="row d-flex flex-column py-2">
                    <p class="primary-font fs-5 fw-bold m-0">Foto Transkrip Nilai</p>
                    <div class="d-flex flex-row justify-content-center mt-2">
                        <?php 
                            if (is_null($user_data["u_transkrip_nilai"])) {
                                echo "<a class='primary-font fs-5 mt-2' href='#'>Belum Upload File</a>";
                            } 
                            else {
                                $link = $user_data["u_transkrip_nilai"];
                                echo "<a class='primary-font fs-5 mt-2' href='../../server$link' target='_blank'>Klik untuk membuka Foto Transkrip Nilai</a>";
                            }
                        ?>
                    </div>
                </div>
                <div class="row d-flex flex-column py-2">
                    <div class="d-flex flex-row justify-content-between px-4 py-3">
                        <?php if ($user_data["u_status_pendaftaran"] == "Menunggu Verifikasi" || $user_data["u_status_pendaftaran"] == "Revisi Data"): ?>
                            <button type="button" class="btn btn-success btn-block col-4 rounded-pill primary-font fs-6" onclick="ubah_status(<?php echo $user_id; ?>, 'Lolos');">Lolos</button>
                            <button type="button" class="btn btn-danger btn-block col-4 rounded-pill primary-font fs-6" onclick="ubah_status(<?php echo $user_id; ?>, 'Revisi Data');">Revisi</button>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./data_pendaftar.js"></script>
    </body>
</html>
<?php endif ?>