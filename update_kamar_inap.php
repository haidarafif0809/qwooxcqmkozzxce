<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");

$session_id = session_id();
$lama_inap = angkadoang($_POST['lama_inap']);
$group_bed2 = stringdoang($_POST['group_bed2']);
$bed2 = stringdoang($_POST['bed2']);
$penjamin = stringdoang($_POST['penjamin']);
$no_reg = stringdoang($_POST['no_reg']);
$bed_before = stringdoang($_POST['bed_before']);
$group_bed_before = stringdoang($_POST['group_bed_before']);

$ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'HARI' ");
$b = mysqli_fetch_array($ambil_satuan);
$satuan_bed = $b['id'];

// UPDATE KAMAR BARU
$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed2' AND group_bed = '$group_bed2'");
// END UPDATE KAMAR BARU


// UPDATE REgistrasi
$qwer = $db->query("UPDATE registrasi SET bed = '$bed2' , group_bed = '$group_bed2', menginap = '$lama_inap' WHERE no_reg = '$no_reg' ");
// END UPDATE REgistrasi


// UPDATE KAMAR LAMA
$qwer = $db->query("UPDATE rekam_medik_inap SET bed = '$bed2' , group_bed = '$group_bed2' WHERE no_reg = '$no_reg' ");
// END UPDATE KAMAR LAMA



  
// ambil bahan untuk kamar 
$query20 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data20  = mysqli_fetch_array($query20);
$level_harga = $data20['harga'];

$cari_harga_kamar = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '$bed2' AND group_bed = '$group_bed2' ");
$kamar_luar = mysqli_fetch_array($cari_harga_kamar);
$harga_kamar1 = $kamar_luar['tarif'];
$harga_kamar2 = $kamar_luar['tarif_2'];
$harga_kamar3 = $kamar_luar['tarif_3'];
$harga_kamar4 = $kamar_luar['tarif_4'];
$harga_kamar5 = $kamar_luar['tarif_5'];
$harga_kamar6 = $kamar_luar['tarif_6'];
$harga_kamar7 = $kamar_luar['tarif_7'];
//end bahan untuk kamar


// harga_1 (pertama)
if ($level_harga == 'harga_1')
    {

$subtotal = $lama_inap * $harga_kamar1;




$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


    }
//end harga_1 (pertama)

// harga_2 (pertama)
else if ($level_harga == 'harga_2')
{

$subtotal = $lama_inap * $harga_kamar2;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar2','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
         echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
//end harga_2 (pertama)


// harga_3 (pertama)
else if ($level_harga == 'harga_3')
{

$subtotal = $lama_inap * $harga_kamar3;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar3','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }

}
// harga_3 (pertama)

// harga_4 (pertama)
else if ($level_harga == 'harga_4')
{

$subtotal = $lama_inap * $harga_kamar4;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar4','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
        
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
// harga_4 (pertama)

else if ($level_harga == 'harga_5')
{

$subtotal = $lama_inap * $harga_kamar5;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar5','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_5 (pertama)

else if ($level_harga == 'harga_6')
{

$subtotal = $lama_inap * $harga_kamar6;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar6','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
          
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_6 (pertama)


else if ($level_harga == 'harga_7')
{

$subtotal = $lama_inap * $harga_kamar7;

$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed2','$group_bed2','$lama_inap','$harga_kamar7','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
        
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }

}
// harga_7 (pertama)


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        

 ?>