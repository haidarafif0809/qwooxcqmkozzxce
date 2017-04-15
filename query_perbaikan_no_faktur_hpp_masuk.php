<?php  
 
include 'db.php'; 
include 'sanitasi.php'; 
 
$dari_tanggal = stringdoang($_GET['dari_tanggal']); 
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']); 
 
 
$query_hpp_keluar = $db->query("SELECT no_faktur,jumlah_kuantitas,kode_barang FROM hpp_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'   "); 
 
 
while ($data_hpp_keluar = mysqli_fetch_array($query_hpp_keluar)) { 
 
	echo $data_hpp_keluar['no_faktur'];
	echo $data_hpp_keluar['kode_barang'];
	echo $data_hpp_keluar['jumlah_kuantitas'];

  $jumlah_kuantitas = $data_hpp_keluar['jumlah_kuantitas'];
 
  while ($jumlah_kuantitas > 0) { 
    # code... 
   $query_sisa_hpp_masuk = $db->query("SELECT hm.jumlah_kuantitas - IFNULL(SUM(hk.jumlah_kuantitas),0) AS sisa_hpp, hm.no_faktur FROM hpp_masuk hm LEFT JOIN hpp_keluar hk ON hk.kode_barang = hm.kode_barang AND hm.no_faktur = hk.no_faktur_hpp_masuk WHERE hm.kode_barang =  
   '$data_hpp_keluar[kode_barang]' GROUP BY hm.id HAVING sisa_hpp > 0 ORDER BY hm.tanggal,hm.jam ASC LIMIT 1"); 

    $data_sisa_hpp_masuk = mysqli_fetch_array($query_sisa_hpp_masuk); 
 
	echo $sisa_hpp_masuk = $data_sisa_hpp_masuk['sisa_hpp']; 
    if ($sisa_hpp_masuk == $jumlah_kuantitas) {
    	# code...

    	$query_update_hpp_keluar = $db->query("UPDATE hpp_keluar SET no_faktur_hpp_masuk = '$data_sisa_hpp_masuk[no_faktur]' WHERE no_faktur = '$data_hpp_keluar[no_faktur]' AND kode_barang = '$data_hpp_keluar[kode_barang]'");
    	$jumlah_kuantitas = 0;
    }
    elseif ($sisa_hpp_masuk > $jumlah_kuantitas) {
    	# code...

    	$query_update_hpp_keluar = $db->query("UPDATE hpp_keluar SET no_faktur_hpp_masuk = '$data_sisa_hpp_masuk[no_faktur]' WHERE no_faktur = '$data_hpp_keluar[no_faktur]' AND kode_barang = '$data_hpp_keluar[kode_barang]'");
    	$jumlah_kuantitas = 0;

    }

     elseif ($sisa_hpp_masuk < $jumlah_kuantitas) {
    	# code...

    	$query_update_hpp_keluar = $db->query("UPDATE hpp_keluar SET no_faktur_hpp_masuk = '$data_sisa_hpp_masuk[no_faktur]' WHERE no_faktur = '$data_hpp_keluar[no_faktur]' AND kode_barang = '$data_hpp_keluar[kode_barang]'");
    	$jumlah_kuantitas -= $sisa_hpp_masuk;

    }
     
  } 
 
 
 
 
} 
 
 
 
 
 ?>