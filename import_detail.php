<?php
require 'function.php';
require 'cek.php';
?>

<?php
//import koneksi ke database
?>
<html>

<head>
    <title>Stock Barang Infomedia</title>
    <link rel="stylesheet" href="assets/import/bootstrap.min.css">
    <script src="assets/import/jquery.min.js"></script>
    <script src="assets/import/popper.min.js"></script>
    <script src="assets/import/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/import/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="assets/import/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/import/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="assets/import/jquery.dataTables.js"></script>
</head>

<body>
    <div class="container">
            <h1 class="mt-4">Import Data</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Upload File Detail Barang dalam bentuk XLS atau XLSX.</li>
                    </ol>
            <div style="margin:auto;width:600px;padding:20px">
            <?php include("aksi.php")?>
                <form action="" method="POST" enctype="multipart/form-data" class="row
                g-2">
                    <div class="col-auto">
                        <input class="form-control" type="file" name = "filexls" id="formFile">
                        <input class="form-control" type="hidden" name = "idm" id="idm" value="<?php echo $_GET['id'] ; ?>">
                        <br>
                    </div>
                    
                    <div class="col-auto">
                        <input type="submit" name="submit" class="btn btn-success" value="Upload">
                        <a href="template-perangkat.xlsx" class="btn btn-primary">Template Excel Perangkat</a>
                        <a href="detail.php" class="btn btn-info">Back</a>
                    </div>
                </form>
            </div>
    </div>

    <script src="assets/import/jquery-3.5.1.js"></script>
    <script src="assets/import/jquery.dataTables.min.js"></script>
    <script src="assets/import/dataTables.buttons.min.js"></script>
    <script src="assets/import/buttons.flash.min.js"></script>
    <script src="assets/import/jszip.min.js"></script>
    <script src="assets/import/pdfmake.min.js"></script>
    <script src="assets/import/vfs_fonts.js"></script>
    <script src="assets/import/buttons.html5.min.js"></script>
    <script src="assets/import/buttons.print.min.js"></script>


</body>

</html>