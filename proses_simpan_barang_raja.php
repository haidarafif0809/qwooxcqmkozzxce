<?php session_start();
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST



$session_id = session_id();


    //ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:sa');


$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$ber_stok = stringdoang($_POST['ber_stok']);
$nama_petugas = stringdoang($_SESSION['nama']);
$kode_gudang = stringdoang($_POST['kode_gudang']);
$penjamin = stringdoang($_POST['penjamin']);
$nama_pasien = stringdoang($_POST['nama_pasien']);
    $petugas_kasir = stringdoang($_POST['petugas_kasir']);
    $petugas_paramedik = stringdoang($_POST['petugas_paramedik']);
    $petugas_farmasi = stringdoang($_POST['petugas_farmasi']);
    $petugas_lain = stringdoang($_POST['petugas_lain']);
    $dokter = stringdoang($_POST['dokter']);
$kredit_piutang = angkadoang($_POST['sisa_kredit']);
$sisa_kredit = angkadoang($_POST['kredit']);
$sisa = angkadoang($_POST['sisa']);
$keterangan = stringdoang($_POST['keterangan']);
$tax = angkadoang($_POST['tax']);
$biaya_admin = angkadoang($_POST['biaya_adm']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$potongan = angkadoang($_POST['potongan']);
$pembayaran = angkadoang($_POST['pembayaran']);
$total = angkadoang($_POST['total']);
$total2 = angkadoang($_POST['total2']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$ppn_input = stringdoang($_POST['ppn_input']);
    $user = $_SESSION['user_name'];

   $_SESSION['no_faktur'] = $no_faktur;


 $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    // petugas kasir
    $fee_kasir = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_kasir'");
    $data_fee_kasir = mysqli_fetch_array($fee_kasir);
    $nominal_kasir = $data_fee_kasir['jumlah_uang'];
    $prosentase_kasir = $data_fee_kasir['jumlah_prosentase'];

    if ($nominal_kasir != 0) {
      

      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar,no_reg,no_rm) VALUES ('$data_fee_kasir[nama_petugas]', '$no_faktur', '$nominal_kasir', '$tanggal_sekarang', '$jam_sekarang', '','$no_reg','$no_rm')");

    }

    elseif ($prosentase_kasir != 0) {


     
      $fee_prosentase = $prosentase_kasir * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_kasir[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')");
      
    }
    
    // petugas paramedik
    $fee_paramedik = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_paramedik'");
    $data_fee_paramedik = mysqli_fetch_array($fee_paramedik);
    $nominal_paramedik = $data_fee_paramedik['jumlah_uang'];
    $prosentase_paramedik = $data_fee_paramedik['jumlah_prosentase'];

    if ($nominal_paramedik != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar,no_reg,no_rm) VALUES ('$data_fee_paramedik[nama_petugas]', '$no_faktur', '$nominal_paramedik', '$tanggal_sekarang', '$jam_sekarang', '','$no_reg','$no_rm')");

    }

    elseif ($prosentase_paramedik != 0) {


     
      $fee_prosentase = $prosentase_paramedik * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg,no_rm) VALUES ('$data_fee_paramedik[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')");
      
    }
    
    // petugas farmasi
    $fee_farmasi = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_farmasi'");
    $data_fee_farmasi = mysqli_fetch_array($fee_farmasi);
    $nominal_farmasi = $data_fee_farmasi['jumlah_uang'];
    $prosetase_farmasi = $data_fee_farmasi['jumlah_prosentase'];

    if ($nominal_farmasi != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar,no_reg,no_rm) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$nominal_farmasi', '$tanggal_sekarang', '$jam_sekarang', '','$no_reg','$no_rm')");

    }

    elseif ($prosetase_farmasi != 0) {


     
      $fee_prosentase = $prosetase_farmasi * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg,no_rm) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')");
      
    }
    
    // petugas lain
    $fee_lain = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_lain'");
    $data_fee_lain = mysqli_fetch_array($fee_lain);
    $nominal_lain = $data_fee_lain['jumlah_uang'];
    $prosentase_lain = $data_fee_lain['jumlah_prosentase'];

    if ($nominal_lain != 0) {
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg,no_rm) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$nominal_lain', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')");

    }

    elseif ($prosentase_lain != 0) {


     
      $fee_prosentase = $prosentase_lain * $total / 100;
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg,no_rm) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')");
      
    }

    
    //dokter
    $fee_dokter = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$dokter'");
    $data_fee_dokter = mysqli_fetch_array($fee_dokter);
    $nominal_dokter = $data_fee_dokter['jumlah_uang'];
    $prosentase_dokter = $data_fee_dokter['jumlah_prosentase'];


    if ($nominal_dokter != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar,no_reg,no_rm) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$nominal_dokter', '$tanggal_sekarang', '$jam_sekarang', '','$no_reg','$no_rm')");

    }

    elseif ($prosentase_dokter != 0) {


     
      $fee_prosentase = $prosentase_dokter * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')");
      
    }

    // tbs_fee_produk
              
    $fee_produk_ksir = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg  = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_ksir)){



          $query10 = "INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang','$no_reg','$no_rm')"  ;

          if ($db->query($query10) === TRUE) {
        } 

        else {
        echo "Error: " . $query10 . "<br>" . $db->error;
        }


    }
    





              
$stmt = $db->prepare("INSERT INTO penjualan (no_faktur, no_reg, penjamin, apoteker, perawat, petugas_lain, dokter, kode_gudang, kode_pelanggan, tanggal, jam, user, sales, status, potongan, no_pesanan,tax,jenis_penjualan,nama,biaya_admin,total,tunai,sisa,kredit,nilai_kredit,cara_bayar,ppn) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,'Simpan Sementara',?,'1',?,?,?,?,?,?,?,?,?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssssssiisssiiiiiss",
              $no_faktur,$no_reg,$penjamin,$petugas_farmasi,$petugas_paramedik,$petugas_lain, $dokter, $kode_gudang, $no_rm, $tanggal_sekarang, $jam_sekarang, $nama_petugas, $petugas_kasir, $potongan,$tax,$jenis_penjualan,$nama_pasien,$biaya_admin,$total,$pembayaran,$sisa,$sisa_kredit,$sisa_kredit,$cara_bayar,$ppn_input);
              

              
    // jalankan query
              $stmt->execute();
              
              


    // cek query
if (!$stmt) 
   {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
   }

else 
    {
    
    }




    $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg'");
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
        
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, no_reg, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa, tipe_produk, lab) VALUES ('$no_faktur','$no_rm', '$no_reg', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang', '$data[tipe_barang]', '$data[lab]')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }

        
      }





$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_reg = '$no_reg'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];


$biaya_admin = angkadoang($_POST['biaya_adm']);

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

$kredit_piutang = $total - $pembayaran;

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$kredit_piutang', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");




if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_admin;

 $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
$ppn_input;
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}


  }

else {
  //ppn == Exclude
  $total_penjualan = $total2 + $biaya_admin;
  $pajak = $tax;
$ppn_input;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}




   
    echo "Success";

/* BOT STAR AUTO
     $ambil_tbs = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot233675698:AAEbTKDcPH446F-bje4XIf1YJ0kcmoUGffA/sendMessage?chat_id=-129639785&text=";
      $text = urlencode("No Faktur : ".$no_faktur."\n");
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


     
     
}
*/
   
    /* bot makanan
      
      $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-134496145&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
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


     
     
}
        
*/
/* bot minuman
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-147051127&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
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
*/

/* bot beef
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-127377681&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
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
*/  
// PRINT OTOMATIS (DARI SINI)
/*   
$pilih_makanan = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Makanan'");
$ambil_makanan = mysqli_num_rows($pilih_makanan);



if ($ambil_makanan > 0) {
  $insert_status_print_makanan = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Makanan', '1') ");


}


    
$pilih_minuman = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Minuman'");
$ambil_minuman = mysqli_num_rows($pilih_minuman);



if ($ambil_minuman > 0 ) {
  $insert_status_print_minuman = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Minuman', '1') ");
}



$pilih_beef = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Beef'");

$ambil_beef = mysqli_num_rows($pilih_beef);

if ($ambil_beef > 0) {
  $insert_status_print_beef = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Beef', '1') ");
}


    

  $insert_status_print_bill = $db->query("INSERT INTO status_print (no_faktur,tipe_produk,no_pesanan) VALUES ('$no_faktur', 'Semua', '1') ");

*/



     $query3 = $db->query("DELETE FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '$no_reg'");
    $query30 = $db->query("DELETE FROM tbs_fee_produk WHERE session_id = '$session_id' AND no_reg = '$no_reg'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


    ?>