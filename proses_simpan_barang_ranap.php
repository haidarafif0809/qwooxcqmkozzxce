<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST

$no_reg = stringdoang($_POST['no_reg']);
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$no_rm = stringdoang($_POST['no_rm']);
$ppn_input = stringdoang($_POST['ppn_input']);
$total2 = angkadoang($_POST['total2']);
$kredit = angkadoang($_POST['sisa_kredit']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);
$potongan = angkadoang($_POST['potongan']);
$biaya_admin = angkadoang($_POST['biaya_adm']);
$user = stringdoang($_SESSION['nama']);
$no_jurnal = no_jurnal();
 
    // ubtuk mengambil nama pelanggan
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    // hapus detail penjualan
    $delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$no_reg' ");

    //ambil data brang-barang yang ada di tbs berdasrakan no_reg
    $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
    while ($data = mysqli_fetch_array($query))
    {
        
        $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_barang] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
        $harga = $data_konversi['harga_konversi'];
        $jumlah_barang = $data_konversi['jumlah_konversi'];
          if ($data['lab'] == 'Laboratorium') {          
            $satuan = 'Lab';
          }
          else{
          $satuan = $data_konversi['satuan'];
          }
      }
      else{
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_barang'];
         if ($data['lab'] == 'Laboratorium') {          
            $satuan = 'Lab';
          }
          else{
           $satuan = $data['satuan'];
         }
      }

      
        $query2 = $db->query("INSERT INTO detail_penjualan (no_faktur, tanggal, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan,harga, subtotal, potongan, tax, hpp, sisa, no_pesanan, komentar,jam,tipe_produk,dosis,no_reg,no_rm, lab) 
          VALUES 
          ('$no_reg','$data[tanggal]','$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$satuan','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]','$data[hpp]','$data[jumlah_barang]', '1', '$data[komentar]','$data[jam]','$data[tipe_barang]','$data[dosis]','$no_reg','$no_rm','$data[lab]')");


    }


// deleet jurnal trans
$delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_reg' ");

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_reg'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_reg = '$no_reg'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];


      // Jika total hp nya kosong atau null atau nol, maka tidak di jurnal ke persediaan maupun hpp, karena item yang ada di tbs mungkin adalah jasa  
      if ($total_hpp != '' OR $total_hpp != 'NULL' OR $total_hpp != 0 ) {

        //PERSEDIAAN    
              $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_reg','1', '$user')");
              

      //HPP    
            $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_reg','1', '$user')");


      }


 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_reg','1', '$user')");

 //PIUTANG
        $insert_juranla = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$kredit', '0', 'Penjualan', '$no_reg','1', '$user')");


          // jika ppn nya non=>tidak pakai pajak

          if ($ppn_input == "Non") {// if ($ppn_input == "Non") {

              // total penjualan = total tbs + biaya admin;
              $total_penjualan = $total2 + $biaya_admin;

              // Insert Juranal
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_reg','1', '$user')");

          } // if ($ppn_input == "Non") {

          // Jika ppn nya Include
          else if ($ppn_input == "Include") {//else if ($ppn_input == "Include") {
            // total penjualan = total tbs + biaya admin - total_tax; 
            $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
            $pajak = $total_tax;

           //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_reg','1', '$user')");

                      if ($pajak != "" || $pajak != 0) {//if ($pajak != "" || $pajak != 0) {
                        //PAJAK
                              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_reg','1', '$user')");
                      }//if ($pajak != "" || $pajak != 0) {


            }//else if ($ppn_input == "Include") {

          else {// else
            //ppn == Exclude
            // total penjualan = total tbs + biaya admin - total_tax; 
            $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
            $pajak = $total_tax;

           //insert jurnal
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_reg','1', '$user')");


                      if ($pajak != "" || $pajak != 0) {//if ($pajak != "" || $pajak != 0) {
                      //PAJAK
                              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_reg','1', '$user')");
                      }//if ($pajak != "" || $pajak != 0) {

          }// end else

          //jika potongan nya tidak koasong atau titdak nol
        if ($potongan != "" || $potongan != 0 ) {//if ($potongan != "" || $potongan != 0 ) {
        //POTONGAN
                $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan R.Inap Simpan Sementara - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_reg','1', '$user')");
        }//if ($potongan != "" || $potongan != 0 ) {

  echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

/*/ BOT STAR AUTO
     $ambil_tbs = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_reg'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot233675698:AAEbTKDcPH446F-bje4XIf1YJ0kcmoUGffA/sendMessage?chat_id=-129639785&text=";
      $text = urlencode("No Faktur : ".$no_reg."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' ORDER BY tp.id ASC");

 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
    
      
      }


     
     
}*/

   
    /* bot makanan
      
      $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_reg'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-134496145&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_reg."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Minuman' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Minuman' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = url_get_contents($url);
      
      }


     
     
}//
        

// bot minuman
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_reg'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-147051127&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_reg."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Makanan' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Makanan' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = url_get_contents($url);
      
      }


     
     
}


// bot beef
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_reg'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-127377681&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_reg."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Beef' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Beef' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = url_get_contents($url);
      
      }


     
     
}

// PRINT OTOMATIS (DARI SINI)


$pilih_makanan = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_reg' AND b.kategori = 'Makanan'");
$ambil_makanan = mysqli_num_rows($pilih_makanan);



if ($ambil_makanan > 0) {
  $insert_status_print_makanan = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_reg', 'Makanan', '1') ");


}


    
$pilih_minuman = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_reg' AND b.kategori = 'Minuman'");
$ambil_minuman = mysqli_num_rows($pilih_minuman);



if ($ambil_minuman > 0 ) {
  $insert_status_print_minuman = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_reg', 'Minuman', '1') ");
}



$pilih_beef = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_reg' AND b.kategori = 'Beef'");
$ambil_beef = mysqli_num_rows($pilih_beef);

if ($ambil_beef > 0) {
  $insert_status_print_beef = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_reg', 'Beef', '1') ");
}


    

  $insert_status_print_bill = $db->query("INSERT INTO status_print (no_faktur,tipe_produk,no_pesanan) VALUES ('$no_reg', 'Semua', '1') ");




  */





    ?>