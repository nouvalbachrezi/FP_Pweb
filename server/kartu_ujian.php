<?php

    require("./dompdf/autoload.inc.php");
    use Dompdf\Dompdf;

    include "config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["izin"])) {
        header("Location: ../client/home.php");
    }
    else if ($_SESSION["izin"] == "user") {
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

                $path = "../client/images/logo.png";
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $file_data = file_get_contents($path);
                $base64_logo = 'data:image/' . $type . ';base64,' . base64_encode($file_data);

                $path = ".".$data["u_pas_foto"];
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $file_data = file_get_contents($path);
                $base64_pas_foto = 'data:image/' . $type . ';base64,' . base64_encode($file_data);

                $dompdf = new Dompdf();
                $dompdf->loadHtml("
                <div style='display: block;'>
                    <img width='140' height='140' src='$base64_logo'>
                    <p style='font-size: large; text-align: center; font-weight: bold;'>KARTU PESERTA UJIAN CPNS 2017</p>
                </div>
                <hr>
                <div style='display: block;'>
                    <div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Instansi</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_instansi']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Lokasi Tes</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data_jadwal['j_lokasi_ujian']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Jadwal Tes</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data_jadwal['j_tanggal_ujian']} {$data_jadwal['j_waktu_ujian']} </p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>NIK</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_nik']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Nomor Peserta</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>".str_pad($data['u_nomor_registrasi'],8,'0', STR_PAD_LEFT)."</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Nama</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_nama_lengkap']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Jenis Kelamin</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_jenis_kelamin']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Tempat/Tanggal Lahir</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_tempat_lahir']}/{$data['u_tanggal_lahir']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Kualifikasi Pendidikan</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_kualifikasi_pendidikan']}</p>
                            </div>
                        </div>
                        <div style='display: block;'>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large; font-weight: bold;'>Formasi Jabatan</p>
                            </div>
                            <div style='display: inline-flex; width: 40%'>
                                <p style='font-size: large;'>{$data['u_formasi_jabatan']}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img width='192' height='256' src='$base64_pas_foto'>
                    </div>
                </div>
                ");
                
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream();
            }
            else {
                $error = "Gagal mengambil data";
            }
        }
        else {
            $error = "Gagal mengambil data";
        }
    }
    else if ($_SESSION["izin"] == "admin") {
        header("Location: ../client/admin/home.php");
    }
?>