<?php 
    include "../server/config.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<?php if(!isset($_SESSION["izin"])): ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="./css/login_registrasi.css">
		<link rel="stylesheet" type="text/css" href="./css/font.css">
		<link rel="stylesheet" type="text/css" href="./css/color.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    </head>
    <body class="login-registrasi-background">
        <div class="container min-vh-100 d-flex align-items-center">
            <div class="row p-5 align-middle justify-content-center">
                <div class="col-6 p-5 rounded-corners bg-light">
                    <div class="col-12">
                        <form id="form-login" method="post" action="../server/login.php">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="form-outline col-4">
                                    <img class="img-fluid" src="./images/logo.png" alt="Logo Lemari"/>
                                </div>
                            </div>
                            <p class="primary-font fs-4 text-center mt-4">Masuk Pendaftaran CPNS</p>
    
                            <!-- Input nomor induk kependudukan -->
                            <div class="form-outline mt-4">
                                <input type="text" name="nomor_induk_kependudukan" id="input_nik" class="form-control rounded-pill border border-success primary-font fs-6 required" value="" placeholder="NIK" />
                            </div>
    
                            <!-- Input password -->
                            <div class="form-outline mt-4">
                                <input type="password" name="password" id="input_password" class="form-control rounded-pill border border-success primary-font fs-6 required" value="" placeholder="Password"/>
                            </div>
                        
                            <!-- Tombol registrasi -->
                            <div class="col d-flex justify-content-between mt-3">
                                <button id="button-registrasi" type="button" class="btn btn-primary btn-block rounded-pill mb-4 primary-font fs-6">Registrasi</button>
                                <button id="button-masuk" type="button" class="btn btn-primary btn-block rounded-pill mb-4 primary-font fs-6">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./login.js"></script>
    </body>
</html>
<?php elseif(isset($_SESSION["izin"]) && $_SESSION["izin"] == "user"): ?>
    <?php
        header("Location: ./home.php") 
    ?>
<?php elseif(isset($_SESSION["izin"]) && $_SESSION["izin"] == "admin"): ?>
    <?php
        header("Location: ./admin/home.php") 
    ?>
<?php endif ?>