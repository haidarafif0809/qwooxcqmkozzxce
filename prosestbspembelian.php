<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    $session_id = $_POST['session_id'];

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = stringdoang($_POST['jumlah_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $harga = stringdoang($_POST['harga']);
    $harga_update = stringdoang($_POST['harga_baru']);
    $harga_baru = str_replace(",",".",$harga_update);
    $tax = stringdoang($_POST['tax']);
    $potongan = stringdoang($_POST['potongan']);
    $a = $harga * $jumlah_barang;
    $status_update = stringdoang($_POST['status_update']);


          if(strpos($potongan, "%") !== false)
          {
               $potongan_jadi = $a * $potongan / 100;
               $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $potongan;
              $potongan_tampil = $potongan;
          }
    $tax = stringdoang($_POST['tax']);
    $satu = 1;
    $x = $a - $potongan_tampil;

        $hasil_tax = $satu + ($tax / 100); 
        
        $hasil_tax2 = $x / $hasil_tax; 

        $tax_persen = $x - $hasil_tax2; 
        
       $tax_persen = round($tax_persen);


    if ($harga != $harga_baru) {
      if ($status_update > 0) {
        $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_baru' WHERE kode_barang = '$kode_barang'");
      }
      else{
        $query00 = $db->query("UPDATE barang SET harga_beli = '$harga' WHERE kode_barang = '$kode_barang'");
      }
      $harga_beli = $harga_baru;
    }
    else{
      $harga_beli = $harga;
    }

  
        $perintah = $db->prepare("INSERT INTO tbs_pembelian (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax) VALUES (?,?,?,?,?,?,?,?,?)");

        $perintah->bind_param("sssssssss",
          $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_beli, $subtotal, $potongan_tampil, $tax_persen);
          
          $kode_barang = stringdoang($_POST['kode_barang']);
          $nama_barang = stringdoang($_POST['nama_barang']);
          $jumlah_barang = stringdoang($_POST['jumlah_barang']);
          $satuan = stringdoang($_POST['satuan']);
          $subtotal = $harga_beli * $jumlah_barang - $potongan_jadi;

        $perintah->execute();

        
if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   
}

    

          mysqli_close($db); 
?>