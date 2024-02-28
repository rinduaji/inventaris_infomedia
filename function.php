<?php
session_start();

// --- Membuat Koneksi ke Database ---
$conn = mysqli_connect("10.194.41.9", "root", "infonusa", "stock_infomedia");

// --- Menambah Stock Barang Baru ---
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi  = $_POST['deskripsi'];
    $jml_awal   = $_POST['jml_awal'];
    $stock      = $_POST['stock'];
    $layanan      = $_POST['layanan'];

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['file']['name']; // --- Mengambil Nama Gambar ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['file']['size']; // --- Mengambil Ukuran Gambar ---
    $file_tmp               = $_FILES['file']['tmp_name']; // --- Mengambil Lokasi Gambar ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi


    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang='$namabarang'");
    $validasi   = mysqli_num_rows($check);

    if ($validasi < 1) {
        // --- Proses Upload Gambar ---
        if (in_array($ekstensi, $allowed_extension) === true) {
            // --- Validasi Ukuran File ---
            if ($ukuran < 5000000) {
                move_uploaded_file($file_tmp, 'images/' . $image);
                $addtotable = mysqli_query($conn, "INSERT into stock (namabarang, deskripsi, jml_awal, stock, layanan, image) VALUES ('$namabarang', '$deskripsi', '$jml_awal' ,'$stock', '$layanan','$image')");
                if ($addtotable) {
                    header('location:index.php');
                } else {
                    echo 'Stock Barang Baru Gagal Ditambahkan';
                    header('location:index.php');
                }
            } else {
                // --- Apabila Ukuran Lebih dari 5 mb / Tidak Sesuai
                echo '
                <script>
                    alert("File Gambar Terlalu Besar atau Tidak Sesuai! File tidak boleh lebih dari 5 mb dan dalam format JPG/PNG.");
                    window.location.href="index.php";
                </script>
                ';
            }
        } else {
            // --- Jika Tidak Ingin Upload Gambar ---
            $addtotable         = mysqli_query($conn, "INSERT into stock (namabarang, deskripsi, jml_awal, stock, layanan) VALUES ('$namabarang', '$deskripsi', '$jml_awal' , '$stock',  '$layanan')");
            if ($addtotable) {
                header('location:index.php');
            } else {
                header('location:index.php');
            }
        }
    } else {
        // --- Nama Barang Telah Terdaftar ---
        echo '
        <script>
            alert("Nama Barang Telah Terdaftar!");
            window.location.href="index.php";
        </script>
        ';
    }
}

// --- Menambah Barang Masuk Baru ---
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $pengirim_msk = $_POST['pengirim_msk'];
    $penerimanya = $_POST['penerimanya'];
    $alamat_penerima_msk  = $_POST['alamat_penerima_msk'];
    $nohp_msk  = $_POST['nohp_msk'];
    $tanggal_msk  = $_POST['tanggal_msk'];
    $qty  = $_POST['qty'];
    $kondisi_msk  = $_POST['kondisi_msk'];
    $layanan_msk  = $_POST['layanan_msk'];
    $area_msk  = $_POST['area_msk'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $addstocksekarangwithqty = $stocksekarang + $qty;

    $updatestockmasuk = mysqli_query($conn, "UPDATE stock set stock='$addstocksekarangwithqty' WHERE idbarang='$barangnya'");

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['paraf_msk']['name']; // --- Mengambil Nama Paraf Masuk ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['paraf_msk']['size']; // --- Mengambil Ukuran Paraf Masuk ---
    $file_tmp               = $_FILES['paraf_msk']['tmp_name']; // --- Mengambil Lokasi Paraf Masuk ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $paraf_msk = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi

    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$barangnya'");
    $validasi   = mysqli_num_rows($check);

    if ($validasi < 1) {
        // --- Proses Upload Gambar ---
        if (in_array($ekstensi, $allowed_extension) === true) {
            // --- Validasi Ukuran File ---
            if ($ukuran < 5000000) {
                move_uploaded_file($file_tmp, 'paraf masuk/' . $paraf_msk);
                $addtomasuk = mysqli_query($conn, "INSERT into masuk (idbarang, pengirim_msk, iduser, alamat_penerima_msk, 
                nohp_msk, tanggal_msk, qty, kondisi_msk, layanan_msk, area_msk, paraf_msk) VALUES ('$barangnya', '$pengirim_msk', 
                '$penerimanya', '$alamat_penerima_msk', '$nohp_msk', '$tanggal_msk', '$qty', '$kondisi_msk', 
                '$layanan_msk', '$area_msk', '$paraf_msk')");
                if ($addtomasuk && $updatestockmasuk) {
                    header('location:masuk.php');
                } else {
                    echo 'File Gambar Terlalu Besar! File tidak boleh lebih dari 5 mb.';
                    header('location:masuk.php');
                }
            } else {
                // --- Apabila File Tidak Sesuai
                echo '
               <script>
                   alert("Format file harus dalam format JPG/PNG!");
                   window.location.href="masuk.php";
               </script>
               ';
            }
        } else {
            // --- Jika Tidak Ingin Upload Gambar ---
            $addtomasuk_no_prf_msk = mysqli_query($conn, "INSERT into masuk (idbarang, pengirim_msk, iduser, alamat_penerima_msk, 
            nohp_msk, tanggal_msk, qty, kondisi_msk, layanan_msk, area_msk) VALUES ('$barangnya', '$pengirim_msk', 
            '$penerimanya', '$alamat_penerima_msk', '$nohp_msk', '$tanggal_msk', '$qty' , '$kondisi_msk', '$layanan_msk', '$area_msk')");
            if ($addtomasuk_no_prf_msk && $updatestockmasuk) {
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
        }
    }
}

// --- Menambah Barang Keluar Baru ---
if (isset($_POST['barangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $pengirimnya = $_POST['pengirimnya'];
    $penerima_klr  = $_POST['penerima_klr'];
    $alamat_penerima_klr  = $_POST['alamat_penerima_klr'];
    $nohp_klr  = $_POST['nohp_klr'];
    $tanggal_klr  = $_POST['tanggal_klr'];
    $qty  = $_POST['qty'];
    $kondisi_klr  = $_POST['kondisi_klr'];
    $layanan_klr  = $_POST['layanan_klr'];
    $area_klr  = $_POST['area_klr'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $addstocksekarangwithqty = $stocksekarang - $qty;

    $updatestockkeluar = mysqli_query($conn, "UPDATE stock set stock='$addstocksekarangwithqty' WHERE idbarang='$barangnya'");

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['paraf_klr']['name']; // --- Mengambil Nama Paraf Keluar ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['paraf_klr']['size']; // --- Mengambil Ukuran Paraf Keluar ---
    $file_tmp               = $_FILES['paraf_klr']['tmp_name']; // --- Mengambil Lokasi Paraf Keluar ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $paraf_klr = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi

    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM keluar WHERE idbarang='$barangnya'");
    $validasi   = mysqli_num_rows($check);

    if ($validasi < 1) {
        // --- Proses Upload Gambar ---
        if (in_array($ekstensi, $allowed_extension) === true) {
            // --- Validasi Ukuran File ---
            if ($ukuran < 5000000) {
                if (move_uploaded_file($file_tmp, 'paraf keluar/' . $paraf_klr)) {
                    $addtokeluar = mysqli_query($conn, "INSERT into keluar (idbarang, iduser, penerima_klr, 
                    alamat_penerima_klr, nohp_klr, tanggal_klr, qty, kondisi_klr, layanan_klr, area_klr, paraf_klr) 
                    VALUES ('$barangnya', '$pengirimnya', '$penerima_klr', '$alamat_penerima_klr', '$nohp_klr', 
                    '$tanggal_klr', '$qty', '$kondisi_klr', '$layanan_klr', '$area_klr', '$paraf_klr')");
                    if ($addtokeluar && $updatestockkeluar) {
                        header('location:keluar.php');
                    } else {
                        echo 'File Gambar Terlalu Besar! File tidak boleh lebih dari 5 mb.';
                        header('location:keluar.php');
                    }
                } else {
                    echo '
                    <script>
                        alert("Format file harus dalam format JPG/PNG!");
                        window.location.href="masuk.php";
                    </script>
                    ';
                }
            }
        } else {
            // --- Jika Tidak Ingin Upload Gambar ---
            $addtokeluar_no_prf_klr = mysqli_query($conn, "INSERT into keluar (idbarang, iduser, penerima_klr, 
            alamat_penerima_klr, nohp_klr, tanggal_klr, qty, kondisi_klr, layanan_klr, area_klr) 
            VALUES ('$barangnya', '$pengirimnya', '$penerima_klr', '$alamat_penerima_klr', '$nohp_klr', 
            '$tanggal_klr', '$qty', '$kondisi_klr', '$layanan_klr', '$area_klr')");
            if ($addtokeluar_no_prf_klr && $updatestockkeluar) {
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
        }
    }
}
// --- Update dari Stock Barang ---
if (isset($_POST['updatebarang'])) {
    $idb            = $_POST['idb'];
    $namabarang     = $_POST['namabarang'];
    $deskripsi      = $_POST['deskripsi'];
    $jml_awal       = $_POST['jml_awal'];
    $stock          = $_POST['stock'];
    $layanan          = $_POST['layanan'];

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg');
    $nama                   = $_FILES['file']['name']; // --- Mengambil Nama Gambar ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['file']['size']; // --- Mengambil Ukuran Gambar ---
    $file_tmp               = $_FILES['file']['tmp_name']; // --- Mengambil Lokasi Gambar ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi

    if ($ukuran == 0) {
        // --- Jika Tidak Ingin Upload ---
        $update         = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', jml_awal='$jml_awal' ,stock='$stock', layanan='$layanan' WHERE idbarang='$idb'");
        if ($update) {
            header('location:index.php');
        } else {
            header('location:index.php');
        }
    } else {
        // --- Jika Ingin Upload ---
        move_uploaded_file($file_tmp, 'images/' . $image);
        $update         = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', jml_awal='$jml_awal' ,stock='$stock', image='$image', layanan='$layanan' WHERE idbarang='$idb'");
        if ($update) {
            header('location:index.php');
        } else {
            header('location:index.php');
        }
    }
}

// --- Delete dari Stock Barang ---
if (isset($_POST['deletebarang'])) {
    $idb            = $_POST['idb'];

    $hapus          = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if ($hapus) {
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

// --- Update dari Barang Masuk ---
if (isset($_POST['updatebarangmasuk'])) {
    $idb                    = $_POST['idb'];
    $idm                    = $_POST['idm'];
    $idu                    = $_POST['idu'];
    $pengirim_msk           = $_POST['pengirim_msk'];
    $alamat_penerima_msk    = $_POST['alamat_penerima_msk'];
    $nohp_msk               = $_POST['nohp_msk'];
    $tanggal_msk            = $_POST['tanggal_msk'];
    $qty                    = $_POST['qty'];
    $kondisi_msk            = $_POST['kondisi_msk'];
    $layanan_msk            = $_POST['layanan_msk'];
    $area_msk               = $_POST['area_msk'];
    $paraf_msk              = $_POST['paraf_msk'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya   = mysqli_fetch_array($lihatstock);
    $stockskrg  = $stocknya['stock'];

    $qtyskrg    = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya     = mysqli_fetch_array($qtyskrg);
    $qtyskrg    = $qtynya['qty'];

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['paraf_msk']['name']; // --- Mengambil Nama Paraf Masuk ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['paraf_msk']['size']; // --- Mengambil Ukuran Paraf Masuk ---
    $file_tmp               = $_FILES['paraf_msk']['tmp_name']; // --- Mengambil Lokasi Paraf Masuk ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $paraf_msk = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi


    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$idb'");
    $validasi   = mysqli_num_rows($check);

    if ($ukuran == 0) {
        // --- Jika Tidak Ingin Upload Paraf ---
        if ($qty > $qtyskrg) {
            $selisih            = $qty - $qtyskrg;
            $kurangin           = $stockskrg + $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE masuk SET qty='$qty', pengirim_msk='$pengirim_msk', 
            alamat_penerima_msk='$alamat_penerima_msk', nohp_msk='$nohp_msk', tanggal_msk='$tanggal_msk', 
            kondisi_msk='$kondisi_msk', layanan_msk='$layanan_msk', area_msk='$area_msk' WHERE idmasuk='$idm'");

            if ($kurangistocknya && $updatenya) {
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
        } else {
            $selisih            = $qtyskrg - $qty;
            $kurangin           = $stockskrg - $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE masuk SET qty='$qty', pengirim_msk='$pengirim_msk', 
            alamat_penerima_msk='$alamat_penerima_msk', nohp_msk='$nohp_msk', tanggal_msk='$tanggal_msk', 
            kondisi_msk='$kondisi_msk', layanan_msk='$layanan_msk', area_msk='$area_msk' WHERE idmasuk='$idm'");
            if ($kurangistocknya && $updatenya) {
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
        }
    } else {
        // --- Jika Ingin Upload Paraf ---
        if ($qty > $qtyskrg) {
            $selisih            = $qty - $qtyskrg;
            $kurangin           = $stockskrg - $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE masuk SET qty='$qty', pengirim_msk='$pengirim_msk', 
            alamat_penerima_msk='$alamat_penerima_msk', nohp_msk='$nohp_msk', tanggal_msk='$tanggal_msk', 
            kondisi_msk='$kondisi_msk', layanan_msk='$layanan_msk', area_msk='$area_msk', paraf_msk='$paraf_msk' 
            WHERE idmasuk='$idm'");

            move_uploaded_file($file_tmp, 'paraf masuk/' . $paraf_msk);
            $updatenya          = mysqli_query($conn, "UPDATE masuk SET qty='$qty', pengirim_msk='$pengirim_msk', 
            alamat_penerima_msk='$alamat_penerima_msk', nohp_msk='$nohp_msk', tanggal_msk='$tanggal_msk', 
            kondisi_msk='$kondisi_msk', layanan_msk='$layanan_msk', area_msk='$area_msk', paraf_msk='$paraf_msk' 
            WHERE idmasuk='$idm'");
            if ($kurangistocknya && $updatenya) {
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
        } else {
            $selisih            = $qtyskrg - $qty;
            $kurangin           = $stockskrg + $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE masuk SET qty='$qty', pengirim_msk='$pengirim_msk', 
            alamat_penerima_msk='$alamat_penerima_msk', nohp_msk='$nohp_msk', tanggal_msk='$tanggal_msk', 
            kondisi_msk='$kondisi_msk', layanan_msk='$layanan_msk', area_msk='$area_msk', paraf_msk='$paraf_msk' 
            WHERE idmasuk='$idm'");

            move_uploaded_file($file_tmp, 'paraf masuk/' . $paraf_msk);
            $updatenya          = mysqli_query($conn, "UPDATE masuk SET qty='$qty', pengirim_msk='$pengirim_msk', 
            alamat_penerima_msk='$alamat_penerima_msk', nohp_msk='$nohp_msk', tanggal_msk='$tanggal_msk', 
            kondisi_msk='$kondisi_msk', layanan_msk='$layanan_msk', area_msk='$area_msk', paraf_msk='$paraf_msk' 
            WHERE idmasuk='$idm'");
            if ($kurangistocknya && $updatenya) {
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
        }
    }
}

// --- Delete dari Barang Masuk ---
if (isset($_POST['deletebarangmasuk'])) {
    $idb            = $_POST['idb'];
    $qty            = $_POST['kty'];
    $idm            = $_POST['idm'];

    $getdatastock   = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data           = mysqli_fetch_array($getdatastock);
    $stock          = $data['stock'];

    $selisih        = $stock - $qty;

    $update         = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata      = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

// --- Update dari Barang Keluar ---
if (isset($_POST['updatebarangkeluar'])) {
    $idb                    = $_POST['idb'];
    $idk                    = $_POST['idk'];
    $idu                    = $_POST['idu'];
    $penerima_klr           = $_POST['penerima_klr'];
    $alamat_penerima_klr    = $_POST['alamat_penerima_klr'];
    $nohp_klr               = $_POST['nohp_klr'];
    $tanggal_klr            = $_POST['tanggal_klr'];
    $qty                    = $_POST['qty'];
    $kondisi_klr            = $_POST['kondisi_klr'];
    $layanan_klr            = $_POST['layanan_klr'];
    $area_klr               = $_POST['area_klr'];
    $paraf_klr              = $_POST['paraf_klr'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya   = mysqli_fetch_array($lihatstock);
    $stockskrg  = $stocknya['stock'];

    $qtyskrg    = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya     = mysqli_fetch_array($qtyskrg);
    $qtyskrg    = $qtynya['qty'];

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['paraf_klr']['name']; // --- Mengambil Nama Paraf Keluar ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['paraf_klr']['size']; // --- Mengambil Ukuran Paraf Keluar ---
    $file_tmp               = $_FILES['paraf_klr']['tmp_name']; // --- Mengambil Lokasi Paraf Keluar ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    //  $paraf_klr = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi
    $paraf_klr = md5(uniqid($nama, true) . time());
    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM keluar WHERE idbarang='$idb'");
    $validasi   = mysqli_num_rows($check);

    if ($ukuran == 0) {
        // Jika Tidak Ingin Upload Paraf
        if ($qty > $qtyskrg) {
            $selisih            = $qty - $qtyskrg;
            $kurangin           = $stockskrg - $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima_klr='$penerima_klr', 
            alamat_penerima_klr='$alamat_penerima_klr', nohp_klr='$nohp_klr', tanggal_klr='$tanggal_klr', 
            kondisi_klr='$kondisi_klr', layanan_klr='$layanan_klr', area_klr='$area_klr' WHERE idkeluar='$idk'");

            if ($kurangistocknya && $updatenya) {
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
        } else {
            $selisih            = $qtyskrg - $qty;
            $kurangin           = $stockskrg + $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima_klr='$penerima_klr', 
            alamat_penerima_klr='$alamat_penerima_klr', nohp_klr='$nohp_klr', tanggal_klr='$tanggal_klr', 
            kondisi_klr='$kondisi_klr', layanan_klr='$layanan_klr', area_klr='$area_klr' WHERE idkeluar='$idk'");

            if ($kurangistocknya && $updatenya) {
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
        }
    } else {
        // Jika Ingin Upload Paraf

        if ($qty > $qtyskrg) {
            $selisih            = $qty - $qtyskrg;
            $kurangin           = $stockskrg - $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima_klr='$penerima_klr', 
            alamat_penerima_klr='$alamat_penerima_klr', nohp_klr='$nohp_klr', tanggal_klr='$tanggal_klr', 
            kondisi_klr='$kondisi_klr', layanan_klr='$layanan_klr', area_klr='$area_klr', paraf_klr='$paraf_klr' 
            WHERE idkeluar='$idk'");
            move_uploaded_file($file_tmp, 'paraf keluar/' . $paraf_klr);
            if ($kurangistocknya && $updatenya) {
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
        } else {
            $selisih            = $qtyskrg - $qty;
            $kurangin           = $stockskrg + $selisih;
            $kurangistocknya    = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya          = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima_klr='$penerima_klr', 
            alamat_penerima_klr='$alamat_penerima_klr', nohp_klr='$nohp_klr', tanggal_klr='$tanggal_klr', 
            kondisi_klr='$kondisi_klr', layanan_klr='$layanan_klr', area_klr='$area_klr', paraf_klr='$paraf_klr' 
            WHERE idkeluar='$idk'");
            move_uploaded_file($file_tmp, 'paraf keluar/' . $paraf_klr);
            if ($kurangistocknya && $updatenya) {
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
        }
    }
}

// --- Delete dari Barang Keluar ---
if (isset($_POST['deletebarangkeluar'])) {
    $idb            = $_POST['idb'];
    $qty            = $_POST['kty'];
    $idk            = $_POST['idk'];

    $getdatastock   = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data           = mysqli_fetch_array($getdatastock);
    $stock          = $data['stock'];

    $selisih        = $stock + $qty;

    $update         = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata      = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

// --- Tambah Admin Baru ---
if (isset($_POST['addnewadmin'])) {
    $nama_admin     = $_POST['nama_admin'];
    $jabatan        = $_POST['jabatan'];
    $area           = $_POST['area'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $layanan        = $_POST['layanan'];

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['ttd']['name']; // --- Mengambil Nama Gambar ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['ttd']['size']; // --- Mengambil Ukuran Gambar ---
    $file_tmp               = $_FILES['ttd']['tmp_name']; // --- Mengambil Lokasi Gambar ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $paraf = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi


    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM login WHERE nama_admin='$nama_admin'");
    $validasi   = mysqli_num_rows($check);

    if ($validasi < 1) {
        // --- Proses Upload Gambar ---
        if (in_array($ekstensi, $allowed_extension) === true) {
            // --- Validasi Ukuran File ---
            if ($ukuran < 5000000) {
                move_uploaded_file($file_tmp, 'paraf/' . $paraf);
                $queryinsert    = mysqli_query($conn, "INSERT into login (nama_admin, jabatan, area, username,layanan, password, paraf) VALUES ('$nama_admin', '$jabatan', '$area', '$username','$layanan', '$password', '$paraf')");

                if ($queryinsert) {
                    header('location:admin.php');
                } else {
                    echo 'Admin Baru Gagal Ditambahkan';
                    header('location:admin.php');
                }
            } else {
                // --- Apabila Ukuran Lebih dari 5 mb / Tidak Sesuai
                echo '
                <script>
                    alert("File Gambar Terlalu Besar atau Tidak Sesuai! File tidak boleh lebih dari 5 mb dan dalam format JPG/PNG.");
                    window.location.href="admin.php";
                </script>
                ';
            }
        } else {
            // --- Jika Tidak Ingin Upload Gambar ---
            $queryinsert    = mysqli_query($conn, "INSERT into login (nama_admin, jabatan, area, username,layanan, password) VALUES ('$nama_admin', '$jabatan', '$area', '$username','$layanan', '$password')");
            if ($queryinsert) {
                header('location:admin.php');
            } else {
                header('location:admin.php');
            }
        }
    }
}

// --- Edit Admin ---
if (isset($_POST['updateadmin'])) {
    $nama_admin     = $_POST['nama_admin'];
    $jabatan        = $_POST['jabatan'];
    $area           = $_POST['area'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $idnya          = $_POST['id'];
    $layanan        = $_POST['layanan'];

    // --- Penambahan Gambar ---
    $allowed_extension      = array('png', 'jpg', 'jpeg');
    $nama                   = $_FILES['ttd']['name']; // --- Mengambil Nama Gambar ---
    $dot                    = explode('.', $nama);
    $ekstensi               = strtolower(end($dot)); // --- Mengambil Ekstensinya ---
    $ukuran                 = $_FILES['ttd']['size']; // --- Mengambil Ukuran Gambar ---
    $file_tmp               = $_FILES['ttd']['tmp_name']; // --- Mengambil Lokasi Gambar ---

    // --- Penamaan File -> Menggunakan Ekstensi ---
    $paraf = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // --- Menggabungkan Nama File yang Terenkripsi dengan Ekstensi


    // --- Validasi Data Check Nama Barang sudah ada atau Belum ---
    $check      = mysqli_query($conn, "SELECT * FROM login WHERE nama_admin='$nama_admin'");
    $validasi   = mysqli_num_rows($check);

    if ($ukuran == 0) {
        // --- Jika Tidak Ingin Upload ---
        $querryupdate = mysqli_query($conn, "UPDATE login SET username='$username', password='$password', nama_admin='$nama_admin', jabatan='$jabatan', area='$area',layanan='$layanan' WHERE iduser='$idnya'");
        if ($querryupdate) {
            header('location:admin.php');
        } else {
            header('location:admin.php');
        }
    } else {
        // --- Jika Ingin Upload ---
        move_uploaded_file($file_tmp, 'paraf/' . $paraf);
        $querryupdate = mysqli_query($conn, "UPDATE login SET username='$username', password='$password', nama_admin='$nama_admin', jabatan='$jabatan', area='$area',layanan='$layanan',paraf='$paraf' WHERE iduser='$idnya'");
        if ($querryupdate) {
            header('location:admin.php');
        } else {
            header('location:admin.php');
        }
    }
}

// --- Delete Admin ---
if (isset($_POST['hapusadmin'])) {
    $idnya      = $_POST['id'];

    $hapusadmin          = mysqli_query($conn, "DELETE FROM login WHERE iduser='$idnya'");
    if ($hapusadmin) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

// --- Update dari Detail Barang ---
if (isset($_POST['updatedetail'])) {
    $idp = $_POST['idperangkat'];
    $namabarang = $_POST['namabarang'];
    $ip = $_POST['ip'];
    $ext = $_POST['ext'];
    $barcode = $_POST['barcode'];
    $deskripsi = $_POST['deskripsi'];
    $merk = $_POST['merk'];
    $no_seri = $_POST['no_seri'];
    $inventaris = $_POST['inventaris'];
    $layanan = $_POST['layanan'];
    $kondisi = $_POST['kondisi'];
    $nama_gedung = $_POST['nama_gedung'];
    $lantai = $_POST['lantai'];
    $keterangan = $_POST['keterangan'];
    $processor = $_POST['processor'];
    $hdd = $_POST['hdd'];
    $memori = $_POST['memori'];
    $ssd = $_POST['ssd'];
    $lup = $_POST['lup'];

    $update         = mysqli_query($conn, "UPDATE perangkat SET namabarang='$namabarang', ip='$ip', ext='$ext', 
        barcode='$barcode', deskripsi='$deskripsi', merk='$merk', no_seri='$no_seri', inventaris='$inventaris', layanan='$layanan',
        kondisi='$kondisi', nama_gedung='$nama_gedung', lantai='$lantai', keterangan='$keterangan', processor='$processor', 
        hdd='$hdd',memori='$memori', ssd='$ssd', lup='$lup' WHERE idperangkat='$idp'");

    if ($update) {
        header('location:detail.php');
    } else {
        header('location:detail.php');
    }
}

// --- Delete dari Detail Barang ---
if (isset($_POST['hapusdetail'])) {
    $idp            = $_POST['idperangkat'];
    $idm            = $_GET['id'];
    $hapus          = mysqli_query($conn, "DELETE FROM perangkat WHERE idperangkat='$idp'");

    $selectqty = mysqli_query($conn, "SELECT COUNT(*) as jumlah from perangkat where idmasuk='$idm'");
    while ($data = mysqli_fetch_array($selectqty)) {
        $jumlah = $data['jumlah'];

        $updateqty = "UPDATE masuk SET qty='$jumlah' WHERE idmasuk='$idm'";
        mysqli_query($conn, $updateqty);
    }

    $selecttotalqtymsk = mysqli_query($conn, "SELECT SUM(m.qty) as jumlahmasuk, s.namabarang, m.layanan_msk, s.jml_awal FROM masuk as m INNER JOIN stock as s ON m.idbarang=s.idbarang");
    while($datamasuk = mysqli_fetch_array($selecttotalqtymsk)) {
        $totaldatamasuk = $datamasuk['jml_awal'] - $datamasuk['jumlahmasuk'];
        $layanan = $datamasuk['layanan_msk'];
        $namabarang = $datamasuk['namabarang'];

        $updateqtystock = "UPDATE stock SET stock='$totaldatamasuk' WHERE layanan='$layanan' AND namabarang='$namabarang'";
        mysqli_query($conn, $updateqtystock);
    }
    
    if ($updateqty) {
        header('location:detail.php?id='.$idm);
    } else {
        header('location:detail.php?id='.$idm);
    }
}
