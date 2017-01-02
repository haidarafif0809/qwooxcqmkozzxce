<?php

include 'db.php';

$select = $db_pasien->("SELECT id,kode_pelanggan,tgl_lahir FROM pasien_rizal WHERE id >= '421463' AND id <= '521682' ");
while($sd = mysqli_fetch_array($select))
{
	$update = $db_pasien->("UPDATE pelanggan SET kode_pelanggan = '$sd[kode_pelanggan]' , tgl_lahir = '$sd[tgl_lahir]' WHERE id = '$sd[id]'  ");
}

?>