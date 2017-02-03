<?php
include 'db.php';

$select_pasien = $db_pasien->query("SELECT id_pasien, kode_pasien, tgl_lahir_pasien FROM pasien_rama WHERE id_pasien  >= '521683' AND id_pasien <= '592620' ");

while ($data_pasien = mysqli_fetch_array($select_pasien)) {
    
    $update_pasien = $db_pasien->query("UPDATE pelanggan SET kode_pelanggan = '$data_pasien[kode_pasien]', tgl_lahir = '$data_pasien[tgl_lahir_pasien]' WHERE id = '$data_pasien[id_pasien]' ");

}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>