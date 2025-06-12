<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start();
        require('../config.php');
        require('../essentials.php');

        if(!isset($_SESSION['id'])){
            redirect('../index.php');
        } else if ($_SESSION['role'] !== 'hr'){
            redirect('../index.php');
        }
        $id_gaji = $_GET['id'];
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HR - Detail Gaji</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIPEKA</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="karyawan.php">
                    <i class="fas fa-fw fa-id-card"></i>
                    <span>Karyawan</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="jabatan.php">
                    <i class="fas fa-fw fa-id-badge"></i>
                    <span>Jabatan</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="divisi.php">
                    <i class="fas fa-fw fa-industry"></i>
                    <span>Divisi</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="penggajian.php">
                    <i class="fas fa-fw fa-money-check-alt"></i>
                    <span>Penggajian</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <div class="nav-item no-arrow mx-1">
                            <a class="nav-link" href="../logout.php" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                Logout
                            </a>
                        </div>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <div class="nav-item dropdown no-arrow">
                            <div class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nama'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </div>
                        </div>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Detail Gaji</h1>
                    </div>
                    <form class="offset-md-1">
                        <?php
                            $q = "SELECT *, (j.gaji_pokok + d.tunjangan) AS total_gaji FROM penggajian p JOIN karyawan k ON p.id_karyawan = k.id_karyawan JOIN jabatan j ON k.id_jabatan = j.id_jabatan JOIN divisi d ON k.id_divisi = d.id_divisi ORDER BY p.tanggal ASC";
                            $r = mysqli_query($con,$q);
                            $dt = mysqli_fetch_assoc($r);
                            $tanggal = $dt['tanggal'];
                        ?>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Nama:</label>
                            <input type="text" value="<?php echo $dt['nama'] ?>" name="nama" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Jabatan:</label>
                            <input type="text" value="<?php echo $dt['nama_jabatan'] ?>" name="nama_jabatan" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Divisi:</label>
                            <input type="text" value="<?php echo $dt['nama_divisi'] ?>" name="nama_divisi" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Gaji Pokok:</label>
                            <input type="text" value="<?php echo "Rp. " . number_format($dt['gaji_pokok'], 0, ',', '.') ?>" name="gaji_pokok" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Tunjangan:</label>
                            <input type="text" value="<?php echo "Rp. " . number_format($dt['tunjangan'], 0, ',', '.') ?>" name="tunjangan" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Total:</label>
                            <input type="text" value="<?php echo "Rp. " . number_format($dt['total_gaji'], 0, ',', '.') ?>" name="total_gaji" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label fw-bold">Tanggal:</label>
                            <input type="text" value="<?php echo date('d F Y', strtotime($tanggal)) ?>" name="tanggal" class="form-control shadow-none" readonly>
                        </div>
                        <div class="col-md-10">
                            <a href="penggajian.php" class="btn btn-dark">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SIPEKA 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingin Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Tekan "Logout" dibawah untuk keluar dar sesi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>
</html>