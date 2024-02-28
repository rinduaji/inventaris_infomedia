<?php
include_once('header.php');
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Detail Barang</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Berikut ini adalah Detail Barang yang ada di Infomedia</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="masuk.php" class="btn btn-secondary">Back</a>
                    <a href="import_detail.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Import</a>
                    <a href="export_detail.php" class="btn btn-info">Export</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $idmasuk = $_GET['id'];
                                $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM perangkat WHERE idmasuk='$idmasuk'");
                                $i = 1;
                                while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                    $idp = $data['idperangkat'];
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
                                        <td><?= $i++; ?></td>
                                        <td><?= $namabarang; ?></td>
                                        <td><?= $ip; ?></td>
                                        <td><?= $ext; ?></td>
                                        <td><?= $barcode; ?></td>
                                        <td><?= $deskripsi; ?></td>
                                        <td><?= $merk; ?></td>
                                        <td><?= $no_seri; ?></td>
                                        <td><?= $inventaris; ?></td>
                                        <td><?= $layanan; ?></td>
                                        <td><?= $kondisi; ?></td>
                                        <td><?= $nama_gedung; ?></td>
                                        <td><?= $lantai; ?></td>
                                        <td><?= $keterangan; ?></td>
                                        <td><?= $processor; ?></td>
                                        <td><?= $hdd; ?></td>
                                        <td><?= $memori; ?></td>
                                        <td><?= $ssd; ?></td>
                                        <td><?= $lup; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idp; ?>">
                                                Edit
                                            </button>
                                            <input type="hidden" name="idperangkatygmaudihapus" value="<?= $idp; ?>">
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idp; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit<?= $idp; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="ip" value="<?= $ip; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="ext" value="<?= $ext; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="barcode" value="<?= $barcode; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="merk" value="<?= $merk; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="no_seri" value="<?= $no_seri; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="inventaris" value="<?= $inventaris; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="layanan" value="<?= $layanan; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="kondisi" value="<?= $kondisi; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="nama_gedung" value="<?= $nama_gedung; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="lantai" value="<?= $lantai; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="keterangan" value="<?= $keterangan; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="processor" value="<?= $processor; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="hdd" value="<?= $hdd; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="memori" value="<?= $memori; ?>" class="form-control" >
                                                        <br>
                                                        <input type="text" name="ssd" value="<?= $ssd; ?>" class="form-control" >
                                                        <br>
                                                        <input type="date" name="lup" value="<?= $lup; ?>" class="form-control" >
                                                        <br>
                                                        <input type="hidden" name="idperangkat" value="<?= $idp; ?>">
                                                        <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-success" name="updatedetail">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete<?= $idp; ?>">
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
                                                        <input type="hidden" name="idperangkat" value="<?= $idp; ?>">
                                                        <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn btn-danger" name="hapusdetail">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

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
<?php
include_once('footer.php');
?>