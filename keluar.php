<?php 
include_once('header.php');
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Barang Keluar</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Berikut ini adalah Data Barang Keluar yang ada di Infomedia</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Barang Keluar
                            </button>
                            <a href="export_keluar.php" class="btn btn-info">Export</a>
                            <br>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Pengirim</th>
                                            <th>Penerima</th>
                                            <th>Alamat</th>
                                            <th>Nomor HP</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Jumlah</th>
                                            <th>Kondisi Unit</th>
                                            <th>Layanan</th>
                                            <th>Area</th>
                                            <th>Evidence</th>
                                            <th>Paraf</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar as k INNER JOIN stock as s INNER JOIN login as l WHERE s.idbarang = k.idbarang AND l.iduser = k.iduser");
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $idb = $data['idbarang'];
                                            $idk = $data['idkeluar'];
                                            $idu = $data['iduser'];
                                            $namabarang = $data['namabarang'];
                                            $nama_admin = $data['nama_admin'];
                                            $penerima_klr = $data['penerima_klr'];
                                            $alamat_penerima_klr = $data['alamat_penerima_klr'];
                                            $nohp_klr = $data['nohp_klr'];
                                            $tanggal_klr = $data['tanggal_klr'];
                                            $qty = $data['qty'];
                                            $kondisi_klr = $data['kondisi_klr'];
                                            $layanan_klr = $data['layanan_klr'];
                                            $area_klr = $data['area_klr'];
                                            $ttd = $data['paraf'];

                                            // --- Cek Ada Gambar atau Tidak ---
                                            $gambar = $data['image']; // --- Mengambil Gambar ---
                                            if ($gambar == null) {
                                                // --- Jika Tidak Ada Gambar ---
                                                $img    = 'Image Not Available';
                                            } else {
                                                // --- Jika Ada Gambar ---
                                                $img    = '<img src="images/' . $gambar . '" class="zoomable">';
                                            }

                                            // !! PENGECEKAN PARAF !!

                                            // --- Cek Ada Paraf atau Tidak ---
                                            $paraf = $data['paraf_klr']; // --- Mengambil Paraf ---
                                            if ($paraf == null) {
                                                // --- Jika Tidak Ada Paraf ---
                                                $prf_klr    = 'Paraf Not Available';
                                            } else {
                                                // --- Jika Ada Paraf ---
                                                $prf_klr    = '<img src="paraf keluar/'.$paraf.'" class="zoomable">';
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $img; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $nama_admin ; ?></td>
                                                <td><?= $penerima_klr; ?></td>
                                                <td><?= $alamat_penerima_klr; ?></td>
                                                <td><?= $nohp_klr; ?></td>
                                                <td><?= $tanggal_klr; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $kondisi_klr; ?></td>
                                                <td><?= $layanan_klr; ?></td>
                                                <td><?= $area_klr; ?></td>
                                                <td><?= $prf_klr; ?></td>
                                                <td><img src="paraf/<?= $ttd; ?>" alt="TTD" class="zoomable"></img></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idk; ?>">
                                                        Edit
                                                    </button>
                                                    <br>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idk; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idk; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang Keluar</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body" enctype="multipart/form-data">
                                                                <input type="text" name="penerima_klr" value="<?= $penerima_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="alamat_penerima_klr" value="<?= $alamat_penerima_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="nohp_klr" value="<?= $nohp_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="date" name="tanggal_klr" value="<?= $tanggal_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="number" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="kondisi_klr" value="<?= $kondisi_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="layanan_klr" value="<?= $layanan_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="area_klr" value="<?= $area_klr; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="file" name="paraf_klr" class="form-control">
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <input type="hidden" name="idk" value="<?= $idk; ?>">
                                                                <input type="hidden" name="idu" value="<?= $idu; ?>">
                                                                <button type="submit" class="btn btn-success" name="updatebarangkeluar">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idk; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?= $namabarang; ?> ?
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <input type="hidden" name="kty" value="<?= $qty; ?>">
                                                                <input type="hidden" name="idk" value="<?= $idk; ?>">
                                                                <input type="hidden" name="idu" value="<?= $idu; ?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="deletebarangkeluar">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambahkan Barang Keluar Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <select name='barangnya' class="form-control">
                        <?php
                        $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM stock ORDER BY namabarang ASC");
                        while ($fetcharray = mysqli_fetch_array(($ambilsemuadatanya))) {
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                        ?>

                            <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <select name='pengirimnya' class="form-control">
                        <?php
                        $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM login ORDER BY nama_admin ASC");
                        while ($fetcharray = mysqli_fetch_array(($ambilsemuadatanya))) {
                            $nama_adminnya = $fetcharray['nama_admin'];
                            $idusernya = $fetcharray['iduser'];
                        ?>

                            <option value="<?= $idusernya; ?>"><?= $nama_adminnya; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <input type="text" name="penerima_klr" placeholder="Masukkan Penerima Barang" class="form-control" required>
                    <br>
                    <input type="text" name="alamat_penerima_klr" placeholder="Masukkan Alamat Penerima Barang" class="form-control" required>
                    <br>
                    <input type="text" name="nohp_klr" placeholder="Masukkan No. Handphone Penerima Barang" class="form-control" required>
                    <br>
                    <input type="date" name="tanggal_klr" placeholder="Masukkan Tanggal Keluar Barang" class="form-control" required>
                    <br>
                    <input type="number" name="qty" placeholder="Masukkan Jumlah Barang yang Dikeluarkan" class="form-control" required>
                    <br>
                    <input type="text" name="kondisi_klr" placeholder="Masukkan Kondisi Barang Keluar" class="form-control" required>
                    <br>
                    <input type="text" name="layanan_klr" placeholder="Masukkan Layanan Barang Keluar" class="form-control" required>
                    <br>
                    <input type="text" name="area_klr" placeholder="Masukkan Area Barang Keluar" class="form-control" required>
                    <br>
                    <input type="file" name="paraf_klr" class="form-control">
                    <br>
                    <select class="form-control js-example-basic-multiple" name="states" multiple="multiple" style="width:100%">
                        <option value="AL">Alabama</option>
                    </select>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-success" name="barangkeluar">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
include_once('footer.php');
?>