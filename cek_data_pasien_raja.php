<?php 
include 'db.php';
include 'sanitasi.php';

$no_rm = stringdoang($_POST['no_rm']);
$nama_pasien = stringdoang($_POST['nama_pasien']);

$query = $db->query("SELECT no_rm FROM registrasi WHERE no_rm = '$no_rm' AND nama_pasien = '$nama_pasien' AND status != 'Sudah Pulang' AND status != 'Batal Rawat' AND jenis_pasien = 'Rawat Jalan' AND status != 'Rujuk Rawat Jalan' AND status != 'Rujuk Keluar Ditangani' AND status != 'Rujuk Keluar Tidak Ditangani' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>