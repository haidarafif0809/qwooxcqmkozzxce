<?php 
include 'sanitasi.php';
include 'db.php';
   

    $select = $db->query("SELECT * FROM penjualan WHERE no_faktur >= '4200/JL/01/17' AND no_faktur <= '4207/JL/01/17'");
    while ($data = mysqli_fetch_array($select)) {

      $perintah3 = $db->query("SELECT * FROM tbs_fee_produk WHERE  no_reg = '$data[no_reg]' ");
      $data1 = mysqli_num_rows($perintah3);
      
          if ($data1 > 0){
          
          $perintah2 = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$data[no_reg]' ");
          }
          
          
          $fee_produk = $db->query("SELECT * FROM laporan_fee_produk WHERE no_reg = '$data[no_reg]' ");          
          
          while ($data_fee = mysqli_fetch_array($fee_produk)){
          
          $insert2 = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_fee[no_faktur]','$data_fee[no_reg]','$data_fee[no_rm]','$data_fee[nama_petugas]','$data_fee[kode_produk]','$data_fee[nama_produk]','$data_fee[jumlah_fee]','$data_fee[tanggal]','$data_fee[jam]')";
          
          
          
          
          if ($db->query($insert2) === TRUE) {
          
          } 
          else 
          {
          echo "Error: " . $insert2 . "<br>" . $db->error;
          }
          
          
          }

          $fee_produk_ksir = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg = '$data[no_reg]'");
          while  ($data_fee_produk = mysqli_fetch_array($fee_produk_ksir)){


                $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data[nama_petugas]', '$data[no_faktur]', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$data[tanggal]', '$data[jam]', '$data[kode_pelanggan]', '$data[no_reg]')");


          }
     
    }



    ?>