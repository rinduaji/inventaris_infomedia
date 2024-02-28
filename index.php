<?php 
include_once('header.php');
?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Stock Barang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Berikut ini adalah Stock Barang yang ada di Infomedia</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Stock Barang
                            </button>
                            <a href="export_stock.php" class="btn btn-info">Export</a>
                        </div>
                        <div class="card-body">
                            <?php
                                $ambildatastock = mysqli_query($conn, "SELECT * FROM stock WHERE stock < 1");

                                while($fetch=mysqli_fetch_array($ambildatastock)){
                                    $barang = $fetch['namabarang'];
                                
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>PERHATIAN!</strong> Stock <?=$barang;?> telah habis.
                            </div>
                            <?php
                                }
                            ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah Awal</th>
                                            <th>Stock</th>
                                            <th>Layanan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $namabarang = $data['namabarang'];
                                            $deskripsi = $data['deskripsi'];
                                            $jml_awal = $data['jml_awal'];
                                            $stock = $data['stock'];
                                            $layanan = $data['layanan'];
                                            $idb = $data['idbarang'];
                                            
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

                                        ?>
                                            <tr>
                                                <td><?= $img; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $deskripsi; ?></td>
                                                <td><?= $jml_awal; ?></td>
                                                <td><?= $stock; ?></td>
                                                <td><?= $layanan; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idb; ?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="idbarangygmaudihapus" value="<?= $idb; ?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idb; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idb; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="number" name="jml_awal" value="<?= $jml_awal; ?>" class="form-control">
                                                                <br>
                                                                <input type="number" name="stock" value="<?= $stock; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="layanan" value="<?= $layanan; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="file" name="file" class="form-control">
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <button type="submit" class="btn btn-success" name="updatebarang">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idb; ?>">
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
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="deletebarang">Delete</button>
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
    
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambahkan Stock Barang Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="namabarang" placeholder="Masukkan Nama Barang dan Merek" class="form-control" required>
                    <br>
                    <input type="text" name="deskripsi" placeholder="Masukkan Deskripsi Barang" class="form-control" required>
                    <br>
                    <input type="number" name="jml_awal" placeholder="Masukkan Jumlah Awal Barang" class="form-control">
                    <br>
                    <input type="number" name="stock" placeholder="Masukkan Stock Barang" class="form-control">
                    <br>
                    <input type="text" name="layanan" placeholder="Masukkan Layanan Barang" class="form-control">
                    <br>
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-success" name="addnewbarang">Submit</button>
                </div>

        </div>
    </div>
</div>

<?php 
include_once('footer.php');
?>