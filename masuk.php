<?php 
include_once('header.php');
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Barang Masuk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Berikut ini adalah Data Barang Masuk yang ada di Infomedia</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Barang Masuk
                            </button>
                            <a href="export_masuk.php" class="btn btn-info">Export</a>
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
                                            <th>Tanggal Masuk</th>
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
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM masuk as m INNER JOIN stock as s INNER JOIN login as l WHERE s.idbarang = m.idbarang AND l.iduser = m.iduser");
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $idb = $data['idbarang'];
                                            $idm = $data['idmasuk'];
                                            $idu = $data['iduser'];
                                            $namabarang = $data['namabarang'];
                                            $nama_admin = $data['nama_admin'];
                                            $pengirim_msk = $data['pengirim_msk'];
                                            $alamat_penerima_msk = $data['alamat_penerima_msk'];
                                            $nohp_msk = $data['nohp_msk'];
                                            $tanggal_msk = $data['tanggal_msk'];
                                            $qty = $data['qty'];
                                            $kondisi_msk = $data['kondisi_msk'];
                                            $layanan_msk = $data['layanan_msk'];
                                            $area_msk = $data['area_msk'];
                                            $ttd = $data['paraf'];

                                            // --- Cek Ada Gambar atau Tidak ---
                                            $gambar = $data['image']; // --- Mengambil Gambar ---
                                            if($gambar==null){
                                                // --- Jika Tidak Ada Gambar ---
                                                $img    = 'Image Not Available';
                                            }
                                            else{
                                                // --- Jika Ada Gambar ---
                                                $img    = '<img src="images/'.$gambar.'" class="zoomable">';
                                            }

                                            // !! PENGECEKAN PARAF !!

                                            // --- Cek Ada Paraf atau Tidak ---
                                            $paraf = $data['paraf_msk']; // --- Mengambil Paraf ---
                                            if($paraf==null){
                                                // --- Jika Tidak Ada Paraf ---
                                                $prf_msk    = 'Paraf Not Available';
                                            }
                                            else{
                                                // --- Jika Ada Paraf ---
                                                $prf_msk    = '<img src="paraf masuk/'.$paraf.'" class="zoomable">';
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $img; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $pengirim_msk; ?></td>
                                                <td><?= $nama_admin; ?></td>
                                                <td><?= $alamat_penerima_msk; ?></td>
                                                <td><?= $nohp_msk; ?></td>
                                                <td><?= $tanggal_msk; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $kondisi_msk; ?></td>
                                                <td><?= $layanan_msk; ?></td>
                                                <td><?= $area_msk; ?></td>
                                                <td><?= $prf_msk; ?></td>
                                                <td><img src="paraf/<?= $ttd; ?>" alt="TTD" class="zoomable"></img></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idm; ?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="idbarangygmaudihapus" value="<?= $idb; ?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idm; ?>">
                                                        Delete
                                                    </button>
                                                    <a href="detail.php?id=<?= $idm; ?>" class="btn btn-info" >
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idm; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang Masuk</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="text" name="pengirim_msk" value="<?= $pengirim_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="alamat_penerima_msk" value="<?= $alamat_penerima_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="nohp_msk" value="<?= $nohp_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="date" name="tanggal_msk" value="<?= $tanggal_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="kondisi_msk" value="<?= $kondisi_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="layanan_msk" value="<?= $layanan_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="area_msk" value="<?= $area_msk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="file" name="paraf_msk" class="form-control">
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                                <button type="submit" class="btn btn-success" name="updatebarangmasuk">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idm; ?>">
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
                                                                <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="deletebarangmasuk">Delete</button>
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
    </div>
    
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambahkan Barang Masuk Baru</h4>
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
                    <input type="text" name="pengirim_msk" placeholder="Masukkan Pengirim Barang" class="form-control" required>
                    <br>
                    <select name='penerimanya' class="form-control">
                        <?php
                        $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM login WHERE jabatan <> 'admin' ORDER BY nama_admin ASC");
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
                    <input type="text" name="alamat_penerima_msk" placeholder="Masukkan Alamat Penerima Barang" class="form-control" required>
                    <br>
                    <input type="text" name="nohp_msk" placeholder="Masukkan No. Handphone Penerima Barang" class="form-control" required>
                    <br>
                    <input type="date" name="tanggal_msk" placeholder="Masukkan Tanggal Masuk Barang" class="form-control" required>
                    <br>
                    <input type="number" name="qty" placeholder="Masukkan Jumlah Masuk Barang" class="form-control">
                    <br>
                    <input type="text" name="kondisi_msk" placeholder="Masukkan Kondisi Barang Masuk" class="form-control" required>
                    <br>
                    <input type="text" name="layanan_msk" placeholder="Masukkan Layanan Barang Masuk" class="form-control" required>
                    <br>
                    <input type="text" name="area_msk" placeholder="Masukkan Area Barang Masuk" class="form-control" required>
                    <br>
                    <input type="file" name="paraf_msk" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('footer.php');
?>