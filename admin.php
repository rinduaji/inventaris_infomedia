<?php
include_once('header.php');
?>


        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Kelola Admin</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Admin
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Username</th>
                                            <th>Area</th>
                                            <th>Layanan</th>
                                            <th>Paraf</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadataadmin = mysqli_query($conn, "SELECT * FROM login");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadataadmin)) {
                                            $iduser = $data['iduser'];
                                            $nama_admin = $data['nama_admin'];
                                            $jabatan = $data['jabatan'];
                                            $username = $data['username'];
                                            $area = $data['area'];
                                            $password = $data['password'];
                                            $layanan = $data['layanan'];

                                            // --- Cek Ada Gambar atau Tidak ---
                                            $ttd = $data['paraf']; // --- Mengambil Gambar ---
                                            if($ttd==null){
                                                // --- Jika Tidak Ada Gambar ---
                                                $prf    = 'Paraf Not Available';
                                            }
                                            else{
                                                // --- Jika Ada Gambar ---
                                                $prf    = '<img src="paraf/'.$ttd.'" class="zoomable">';
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $nama_admin; ?></td>
                                                <td><?= $jabatan; ?></td>
                                                <td><?= $username; ?></td>
                                                <td><?= $area; ?></td>
                                                <td><?= $layanan; ?></td>
                                                <td><?= $prf; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $iduser; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $iduser; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $iduser; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Admin</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="text" name="nama_admin" value="<?= $nama_admin; ?>" class="form-control" placeholder="Nama Admin" required>
                                                                <br>
                                                                <input type="text" name="username" value="<?= $username; ?>" class="form-control" placeholder="Username Admin" required>
                                                                <br>
                                                                <input type="text" name="jabatan" value="<?= $jabatan; ?>" class="form-control" placeholder="Jabatan Admin" required>
                                                                <br>
                                                                <input type="text" name="area" value="<?= $area; ?>" class="form-control" placeholder="Area Admin" required>
                                                                <br>
                                                                <input type="text" name="layanan" value="<?= $layanan; ?>" class="form-control" placeholder="Layanan Admin" required>
                                                                <br>
                                                                <input type="password" name="password" class="form-control" placeholder="Password Admin" required>
                                                                <br>
                                                                <input type="file" name="ttd" class="form-control" placeholder="Paraf" required>
                                                                <br>
                                                                
                                                                <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                                <button type="submit" class="btn btn-success" name="updateadmin">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?= $iduser; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Admin</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?= $nama_admin; ?> sebagai Admin ?
                                                                <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapusadmin">Delete</button>
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
                <h4 class="modal-title">Tambahkan Admin Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="nama_admin" placeholder="Masukkan Nama Admin" class="form-control" required>
                    <br>
                    <input type="text" name="jabatan" placeholder="Masukkan Jabatan Admin" class="form-control" required>
                    <br>
                    <input type="text" name="username" placeholder="Masukkan Username" class="form-control" required>
                    <br>
                    <input type="text" name="area" placeholder="Masukkan Area Admin" class="form-control" required>
                    <br>
                    <input type="text" name="layanan" placeholder="Masukkan Layanan Admin" class="form-control" required>
                    <br>
                    <input type="password" name="password" placeholder="Masukkan Password" class="form-control" required>
                    <br>
                    <input type="file" name="ttd" placeholder="Input Paraf" class="form-control" required>
                    <br>
                    
                    <button type="submit" class="btn btn-success" name="addnewadmin">Submit</button>
                </div>

        </div>
    </div>
</div>
<?php
include_once('footer.php');
?>