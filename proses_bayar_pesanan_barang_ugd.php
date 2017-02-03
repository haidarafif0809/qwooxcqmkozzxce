<?php session_start();

    include 'sanitasi.php';
    include 'db.php';


    $total = angkadoang($_POST['total']);
    $no_reg = stringdoang($_POST['no_reg']);  
    $biaya_adm = stringdoang($_POST['biaya_adm']);
    $potongan = stringdoang($_POST['potongan']);
    $nomor_faktur = stringdoang($_POST['no_faktur']);

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query32 = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$nomor_faktur'");
 $data32 = mysqli_fetch_array($query32);
 $total_ss = $data32['total_penjualan'];


 $total_tbs = ($total_ss - $potongan) + $biaya_adm;


if ($total != $total_tbs) {
    echo 1;
  }
  else{

echo $nomor_faktur = stringdoang($_POST['no_faktur']);
    $total = angkadoang($_POST['total']);
    $total2 = angkadoang($_POST['total2']);
    $user = $_SESSION['nama'];
    $sales = stringdoang($_POST['petugas_kasir']);
    $kode_pelanggan = stringdoang($_POST['no_rm']);
    $no_jurnal = no_jurnal();
    $no_reg = stringdoang($_POST['no_reg']);  
    $no_rm = stringdoang($_POST['no_rm']);   

    
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = $tanggal_sekarang." ".$jam_sekarang;
           

    
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    
    $perintah0 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$sales'");
    $cek = mysqli_fetch_array($perintah0);
    $nominal = $cek['jumlah_uang'];
    $prosentase = $cek['jumlah_prosentase'];

    if ($nominal != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$nomor_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '')");

    }

    elseif ($prosentase != 0) {


     
      $fee_prosentase = $prosentase * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam) VALUES ('$cek[nama_petugas]', '$nomor_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang')");
      
    }



$delete = $db->query("DELETE FROM laporan_fee_produk WHERE no_faktur = '$nomor_faktur' AND no_reg = '$no_reg'");
              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg = '$no_reg'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$cek0[nama_petugas]', '$nomor_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");


            }
            
            $delete = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$nomor_faktur'");
            
                      
            $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' AND no_reg = '$no_reg'");
              while ($data = mysqli_fetch_array($query))
                {

                $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_barang] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);

                if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
                  $harga = $data_konversi['harga_konversi'];
                  $jumlah_barang = $data_konversi['jumlah_konversi'];
                  $satuan = $data_konversi['satuan'];
                }
                else{
                  $harga = $data['harga'];
                  $jumlah_barang = $data['jumlah_barang'];
                  $satuan = $data['satuan'];
                }

                $waktu = $tanggal_sekarang." ".$jam_sekarang;
              
                  $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, no_reg, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,tipe_produk,waktu) VALUES ('$nomor_faktur','$no_rm', '$data[no_reg]', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang','$data[tipe_barang]','$waktu')";


                  if ($db->query($query2) === TRUE) {
                  } 

                  else {
                  echo "Error: " . $query2 . "<br>" . $db->error;
                  }

                  
                }
            

          
            $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $tunai_i = $pembayaran - $total;
            

            if ($tunai_i >= 0) 
            
            {

              $ket_jurnal = "Penjualan UGD Lunas ".$ambil_kode_pelanggan['nama_pelanggan']." ";
            
             $stmt = $db->prepare("UPDATE penjualan SET apoteker = ?, perawat = ?, petugas_lain = ?, biaya_admin = ?, kode_gudang = ?, total = ?, jam = ?, status = 'Lunas', potongan = ?,  sisa = ?, cara_bayar = ?, tunai = ?, ppn = ?, status_jual_awal = 'Tunai', keterangan = ?, user = ?, no_faktur_jurnal = ?, keterangan_jurnal = ? WHERE no_faktur = ? AND no_reg = ?") ;
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssisisiisisssssss",
                $petugas_farmasi, $petugas_paramedik, $petugas_lain, $biaya_adm, $kode_gudang, $total, $jam, $potongan,$sisa_pembayaran, $cara_bayar, $pembayaran, $ppn_input, $keterangan, $nama_petugas,$no_jurnal,$ket_jurnal, $nomor_faktur, $no_reg) );
              

               $petugas_farmasi = stringdoang($_POST['petugas_farmasi']);
               $petugas_paramedik = stringdoang($_POST['petugas_paramedik']);
               $petugas_lain = stringdoang($_POST['petugas_lain']);
               $biaya_adm = stringdoang($_POST['biaya_adm']);
               $kode_gudang = stringdoang($_POST['kode_gudang']);
               $total = stringdoang($_POST['total']);
               $jam = date('H:i:s');
               $potongan = stringdoang($_POST['potongan']);
               $sisa_pembayaran = stringdoang($_POST['sisa_pembayaran']);
               $cara_bayar = stringdoang($_POST['cara_bayar']);
               $pembayaran = stringdoang($_POST['pembayaran']);
               $ppn_input = stringdoang($_POST['ppn_input']);
               $keterangan = stringdoang($_POST['keterangan']);
               $nomor_faktur = stringdoang($_POST['no_faktur']);
               $no_reg = stringdoang($_POST['no_reg']);   

               $nama_petugas = $_SESSION['nama'];
               $_SESSION['no_faktur'] = $nomor_faktur;    

               $user = $_SESSION['user_name'];
            
            // jalankan query
            
            $stmt->execute();          

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$nomor_faktur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

 $biaya_adm = stringdoang($_POST['biaya_adm']);

/*
//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$nomor_faktur','1', '$user')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$nomor_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$nomor_faktur','1', '$user')");



if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_adm;


  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

} 


else if ($ppn_input == "Include") {
//ppn == Include

  $total_penjualan = ($total2 + $biaya_adm) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
      }
      

  }

else {
  //ppn == Exclude
  $total_penjualan = ($total2 - $total_tax) + $biaya_adm;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
}

}


if ($potongan != "") {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$nomor_faktur','1', '$user')");
}

*/      
              
 }
 

            else if ($tunai_i < 0 ) 

            {

              $ket_jurnal = "Penjualan UGD Piutang ".$ambil_kode_pelanggan['nama_pelanggan']." ";
            
             $stmt = $db->prepare("UPDATE penjualan SET apoteker = ?, perawat = ?, petugas_lain = ?, biaya_admin = ?, kode_gudang = ?, total = ?, jam = ?, status = 'Piutang', potongan = ?, kredit = ?, cara_bayar = ?, tunai = ?, ppn = ?, status_jual_awal = 'Kredit', keterangan = ?, user = ?, nilai_kredit = ?, no_faktur_jurnal = ?, keterangan_jurnal = ? WHERE no_faktur = ? AND no_reg = ?") ;
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssisisiisisssissss",
                $petugas_farmasi, $petugas_paramedik, $petugas_lain, $biaya_adm, $kode_gudang, $total, $jam, $potongan, $kredit, $cara_bayar, $pembayaran, $ppn_input, $keterangan, $nama_petugas, $kredit,$no_jurnal,$ket_jurnal, $nomor_faktur, $no_reg) );
              
               $petugas_farmasi = stringdoang($_POST['petugas_farmasi']);
               $petugas_paramedik = stringdoang($_POST['petugas_paramedik']);
               $petugas_lain = stringdoang($_POST['petugas_lain']);
               $biaya_adm = stringdoang($_POST['biaya_adm']);
               $kode_gudang = stringdoang($_POST['kode_gudang']);
               $total = stringdoang($_POST['total']);
               $jam = date('H:i:s');
               $potongan = stringdoang($_POST['potongan']);
               $kredit = stringdoang($_POST['kredit']);
               $cara_bayar = stringdoang($_POST['cara_bayar']);
               $pembayaran = stringdoang($_POST['pembayaran']);
               $ppn_input = stringdoang($_POST['ppn_input']);
               $keterangan = stringdoang($_POST['keterangan']);
               $nomor_faktur = stringdoang($_POST['no_faktur']);
               $no_reg = stringdoang($_POST['no_reg']);   

               $nama_petugas = $_SESSION['nama'];
               $_SESSION['no_faktur'] = $nomor_faktur;  

              
    // jalankan query
              $stmt->execute();
            

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$nomor_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

 $biaya_adm = stringdoang($_POST['biaya_adm']);
            $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $piutang_1 = $total - $pembayaran;
/*
//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$nomor_faktur','1', '$user')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$nomor_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$nomor_faktur','1', '$user')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$piutang_1', '0', 'Penjualan', '$nomor_faktur','1', '$user')");


if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_adm;


  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

} 


else if ($ppn_input == "Include") {
//ppn == Include

  $total_penjualan = ($total2 + $biaya_adm) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
}


  }

else {
  //ppn == Exclude
  $total_penjualan = ($total2 - $total_tax) + $biaya_adm;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
}

}


if ($potongan != "") {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan UGD Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$nomor_faktur','1', '$user')");
}

*/
   
}

            $update_registrasi = $db->query("UPDATE registrasi SET status = 'Sudah Pulang' WHERE no_reg ='$no_reg'");
            
            $perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
            $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE no_faktur = '$nomor_faktur' AND no_reg = '$no_reg' ");


}//braket cek subtotal (di proses)





//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>