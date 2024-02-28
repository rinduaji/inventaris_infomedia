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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
    <div class="container">
        <h2>Detail Barang</h2>
        <h4>Infomedia Nusantara</h4>

        <a href="detail.php" class="btn btn-info">Back</a>
            <br></br>
        <div class="data-tables datatable-dark">

            <table class="table table-bordered" id="exportstock" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>IP</th>
                        <th>Extension</th>
                        <th>Barcode</th>
                        <th>Deskripsi</th>
                        <th>Merk</th>
                        <th>Nomor Seri</th>
                        <th>Nomor Inventaris</th>
                        <th>Layanan</th>
                        <th>Kondisi</th>
                        <th>Nama Gedung</th>
                        <th>Lantai</th>
                        <th>Keterangan</th>
                        <th>Processor</th>
                        <th>HDD</th>
                        <th>Memory</th>
                        <th>SSD</th>
                        <th>LUP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM perangkat");
                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                        $namabarang = $data['namabarang'];
                        $ip = $data['ip'];
                        $ext = $data['ext'];
                        $barcode = $data['barcode'];
                        $deskripsi = $data['deskripsi'];
                        $merk = $data['merk'];
                        $no_seri = $data['no_seri'];
                        $inventaris = $data['inventaris'];
                        $layanan = $data['layanan'];
                        $kondisi = $data['kondisi'];
                        $nama_gedung = $data['nama_gedung'];
                        $lantai = $data['lantai'];
                        $keterangan = $data['keterangan'];
                        $processor = $data['processor'];
                        $hdd = $data['hdd'];
                        $memori = $data['memori'];
                        $ssd = $data['ssd'];
                        $lup = $data['lup'];

                    ?>
                        <tr>
                            <td><?php echo $namabarang; ?></td>
                            <td><?php echo $ip; ?></td>
                            <td><?php echo $ext; ?></td>
                            <td><?php echo $barcode; ?></td>
                            <td><?php echo $deskripsi; ?></td>
                            <td><?php echo $merk; ?></td>
                            <td><?php echo $no_seri; ?></td>
                            <td><?php echo $inventaris; ?></td>
                            <td><?php echo $layanan; ?></td>
                            <td><?php echo $kondisi; ?></td>
                            <td><?php echo $nama_gedung; ?></td>
                            <td><?php echo $lantai; ?></td>
                            <td><?php echo $keterangan; ?></td>
                            <td><?php echo $processor; ?></td>
                            <td><?php echo $hdd; ?></td>
                            <td><?php echo $memori; ?></td>
                            <td><?php echo $ssd; ?></td>
                            <td><?php echo $lup; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#exportstock').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>