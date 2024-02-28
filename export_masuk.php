<?php
require 'function.php';
require 'cek.php';
?>


<?php
//import koneksi ke database
?>
<html>

    <head>
        <title>Barang Masuk Infomedia</title>
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
            <h2>Barang Masuk</h2>
            <h4>Infomedia Nusantara</h4>
            <a href="masuk.php" class="btn btn-info">Back</a>
            <br></br>
            <div class="data-tables datatable-dark">

                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                    <thead>
                        <tr>                       
                            <th>Nama Barang</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Alamat</th>
                            <th>Nomor HP</th>
                            <th>Tanggal Masuk</th>
                            <th>Jumlah</th>
                            <th>Kondisi Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM masuk as m INNER JOIN stock as s INNER JOIN login as l WHERE s.idbarang = m.idbarang AND l.iduser = m.iduser");
                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                            $idb = $data['idbarang'];
                            $idm = $data['idmasuk'];
                            $namabarang = $data['namabarang'];
                            $pengirim_msk = $data['pengirim_msk'];
                            $nama_admin = $data['nama_admin'];
                            $alamat_penerima_msk = $data['alamat_penerima_msk'];
                            $nohp_msk = $data['nohp_msk'];
                            $tanggal_msk = $data['tanggal_msk'];
                            $qty = $data['qty'];
                            $kondisi_msk = $data['kondisi_msk'];
                        ?>
                            <tr>
                                <td><?php echo $namabarang; ?></td>
                                <td><?php echo $pengirim_msk; ?></td>
                                <td><?php echo $nama_admin; ?></td>
                                <td><?php echo $alamat_penerima_msk; ?></td>
                                <td><?php echo $nohp_msk; ?></td>
                                <td><?php echo $tanggal_msk; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $kondisi_msk; ?></td>
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
                $('#mauexport').DataTable({
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