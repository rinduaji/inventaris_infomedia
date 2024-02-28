<?php
require 'function.php';
// session_start();
// --- Cek Login ---
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // --- Mencocokkan dengan Database ---
    $cekdatabase = mysqli_query($conn,"SELECT * FROM login WHERE username='$username' and password='$password'");

    // --- Menghitung jumlah Data ---
    $hitung = mysqli_num_rows($cekdatabase);
    while($data = mysqli_fetch_array($cekdatabase)) {
        if($hitung>0){
            $_SESSION['log'] = 'True';
            $_SESSION['nama_admin'] = $data['nama_admin'];
            $_SESSION['jabatan'] = $data['jabatan'];
            $_SESSION['area'] = $data['area'];
            $_SESSION['layanan'] = $data['layanan'];
            $_SESSION['username'] = $data['username'];
            header('location:index.php');
        }
        else{
            header('location:login.php');
        }
    }
}

if(!isset($_SESSION['log'])){

} else{
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="assets/import/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="wallpaper_login">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputusername">Username</label>
                                                <input class="form-control py-4" name="username" id="inputusername" type="username" placeholder="Enter username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-success" href="index.html" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="assets/import/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="assets/import/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
