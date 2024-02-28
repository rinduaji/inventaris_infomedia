<?php
require 'vendor/autoload.php';


// --- Membuat Koneksi ke Database ---
$conn = mysqli_connect("10.194.41.9", "root", "infonusa", "stock_infomedia");



if (isset($_POST['submit'])) {
    $err        = "";
    $ekstensi   = "";
    $success    = "";

    $file_name  = $_FILES['filexls']['name']; // mendapatkan nama file yang diupload
    $file_data  = $_FILES['filexls']['tmp_name']; // mendapatkan tmp file yang diupload

    if (empty($file_name)) {
        $err           .= "<li>Silahkan Masukkan File yang Diinginkan.</li>";
    } else {
        $ekstensi       = pathinfo($file_name)['extension'];
    }

    $ekstensi_allowed   = array("xls", "xlsx");
    if (!in_array($ekstensi, $ekstensi_allowed)) {
        $err           .= "<li>Silahkan Masukkan File dengan Format XLS atau XLSX.
        File yang kamu masukkan <b>$file_name</b> punya tipe <b>$ekstensi</b></li>";
    }
    if (empty($err)) {
        $reader = PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_data);
        $spreadsheet = $reader->load($file_data);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $jumlahData = 0;
        for ($i = 1; $i < count($sheetData); $i++) {
            $idm    = $_POST['idm'];
            $namabarang = $sheetData[$i]['1'];
            $ip = $sheetData[$i]['2'];
            $ext = $sheetData[$i]['3'];
            $barcode = $sheetData[$i]['4'];
            $deskripsi = $sheetData[$i]['5'];
            $merk = $sheetData[$i]['6'];
            $no_seri = $sheetData[$i]['7'];
            $inventaris = $sheetData[$i]['8'];
            $layanan = $sheetData[$i]['9'];
            $kondisi = $sheetData[$i]['10'];
            $nama_gedung = $sheetData[$i]['11'];
            $lantai = $sheetData[$i]['12'];
            $keterangan = $sheetData[$i]['13'];
            $processor = $sheetData[$i]['14'];
            $hdd = $sheetData[$i]['15'];
            $memori = $sheetData[$i]['16'];
            $ssd = $sheetData[$i]['17'];
            $lup = date("Y-m-d h:i:s");

            $excel = "INSERT INTO perangkat (idmasuk, namabarang, ip, ext, barcode, deskripsi, merk, no_seri, 
            inventaris, layanan, kondisi, nama_gedung, lantai, keterangan ,processor, hdd, memori, ssd, lup) 
            values ('$idm','$namabarang', '$ip', '$ext', '$barcode' , '$deskripsi', '$merk', '$no_seri', '$inventaris',
            '$layanan', '$kondisi', '$nama_gedung', '$lantai', '$keterangan', '$processor', '$hdd', '$memori', 
            '$ssd', '$lup')";

            mysqli_query($conn, $excel);


            $jumlahData++;
        }

        if ($jumlahData > 0) {
            $idm    = $_POST['idm'];
            $selectqty = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM perangkat WHERE idmasuk='$idm'");
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


            $success = "$jumlahData data berhasil ditambahkan";
            header('location:detail.php?id=' . $idm);
        }
    }


    if ($err) {
?>
        <div class="alert alert-danger">
            <ul><?php echo $err ?></ul>
        </div>
    <?php
    }

    if ($success) {
    ?>
        <div class="alert alert-success">
            <ul><?php echo $success ?></ul>
        </div>
<?php
    }
}
