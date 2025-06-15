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
        $id = $_SESSION['id'];

        // insert gaji
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST['tambah'])){
                $nama = $_POST['nama'];

                $q = "INSERT INTO penggajian (`id_karyawan`) VALUES ('$nama')";
                $r = mysqli_query($con,$q);
                alert('success','Berhasil menambahkan data penggajian');
            }
        }
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HR - Penggajian</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Penggajian</h1>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Overview Penggajian</h6>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#gajiModal">
                                        <i class="fas fa-plus-square"></i> Tambah
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Divisi</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $q = "SELECT *, (j.gaji_pokok + d.tunjangan) AS total_gaji FROM penggajian p JOIN karyawan k ON p.id_karyawan = k.id_karyawan JOIN jabatan j ON k.id_jabatan = j.id_jabatan JOIN divisi d ON k.id_divisi = d.id_divisi ORDER BY p.tanggal ASC";
                                                $r = mysqli_query($con,$q);
                                                $i=1;
                                                if($r){
                                                    while($row = mysqli_fetch_assoc($r)){
                                                        $tanggal = $row['tanggal'];
                                                        echo "<tr>";
                                                        echo "<td>$i</td>";
                                                        echo "<td>$row[nama]</td>";
                                                        echo "<td>$row[nama_jabatan]</td>";
                                                        echo "<td>$row[nama_divisi]</td>";
                                                        echo "<td>" . date('d F Y', strtotime($tanggal)) . "</td>";
                                                        echo "<td>" . number_format($row['total_gaji'], 0, ',', '.') . "</td>";
                                                        echo "<td><a href='detail_gaji.php?id=$row[id_penggajian]' class='btn btn-sm btn-info'>Detail</a></td>";
                                                        echo "</tr>";
                                                        $i++;
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <!-- Tambah Karyawan modal -->
    <div class="modal fade" id="gajiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Gaji</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Nama:</label>
                                <select class="custom-select" name="nama">
                                    <?php
                                        $sql = "SELECT * FROM karyawan";
                                        $re = mysqli_query($con,$sql);
                                            while($dt = mysqli_fetch_assoc($re)){
                                                echo "<option value='$dt[id_karyawan]'>$dt[nama]</option>";
                                            }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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