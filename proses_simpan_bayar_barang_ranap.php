<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST


$no_faktur = stringdoang($_POST['no_faktur']);
$no_reg = stringdoang($_POST['no_reg']);
$total = angkadoang($_POST['total']);
$potongan = angkadoang($_POST['potongan']);
$biaya_admin = angkadoang($_POST['biaya_admin']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query111 = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur'");
 $data111 = mysqli_fetch_array($query111);
 $total111 = $data111['total_penjualan'];


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query222 = $db->query("SELECT SUM(harga_jual) AS harga_jual FROM tbs_operasi WHERE no_reg = '$no_reg' ");
 $data222 = mysqli_fetch_array($query222);
 $total222 = $data222['harga_jual'];

 $total_sum = ($total111 + $total222);


 $total_tbs = ($total_sum - $potongan) + $biaya_admin;

if ($total != $total_tbs) {
    echo 1;
  }
  else{


$user = $_SESSION['nama'];
$session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');


echo $no_faktur = stringdoang($_POST['no_faktur']);
$no_rm = stringdoang($_POST['no_rm']);
$ber_stok = stringdoang($_POST['ber_stok']);
$tanggal_jt = tanggal_mysql($_POST['tanggal_jt']);
$tanggal = tanggal_mysql($_POST['tanggal']);
$nama_petugas = stringdoang($_SESSION['nama']);
$kode_gudang = stringdoang($_POST['kode_gudang']);
$ppn_input = stringdoang($_POST['ppn_input']);
$penjamin = stringdoang($_POST['penjamin']);
$nama_pasien = stringdoang($_POST['nama_pasien']);

    $petugas_kasir = stringdoang($_POST['sales']);
    $petugas_paramedik = stringdoang($_POST['petugas_paramedik']);
    $petugas_farmasi = stringdoang($_POST['petugas_farmasi']);
    $petugas_lain = stringdoang($_POST['petugas_lain']);
    $dokter = stringdoang($_POST['dokter']);
    $dokter_pj = stringdoang($_POST['dokter_pj']);

$keterangan = stringdoang($_POST['keterangan']);
$total2 = angkadoang($_POST['total2']);
$tax = angkadoang($_POST['tax']);
$sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
$sisa_kredit = angkadoang($_POST['kredit']);
$kredit = angkadoang($_POST['sisa_kredit']);
$sisa = angkadoang($_POST['sisa']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);




$user = stringdoang($_SESSION['nama']);
$no_jurnal = no_jurnal();
 

$delete_lap_fee = $db->query("DELETE FROM laporan_fee_faktur WHERE no_reg = '$no_reg' ");

    // petugas kasir
    $fee_kasir = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_kasir' ");
    $data_fee_kasir = mysqli_fetch_array($fee_kasir);
    $nominal_kasir = $data_fee_kasir['jumlah_uang'];
    $prosentase_kasir = $data_fee_kasir['jumlah_prosentase'];

    if ($nominal_kasir != 0) {
      

      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_kasir[nama_petugas]', '$no_faktur', '$nominal_kasir', '$tanggal', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_kasir != 0) {


     
      $fee_prosentase = $prosentase_kasir * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_kasir[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }
    
    // petugas paramedik
    $fee_paramedik = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_paramedik' ");
    $data_fee_paramedik = mysqli_fetch_array($fee_paramedik);
    $nominal_paramedik = $data_fee_paramedik['jumlah_uang'];
    $prosentase_paramedik = $data_fee_paramedik['jumlah_prosentase'];

    if ($nominal_paramedik != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_paramedik[nama_petugas]', '$no_faktur', '$nominal_paramedik', '$tanggal', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_paramedik != 0) {


     
      $fee_prosentase = $prosentase_paramedik * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_paramedik[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }
    
    // petugas farmasi
    $fee_farmasi = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_farmasi'");
    $data_fee_farmasi = mysqli_fetch_array($fee_farmasi);
    $nominal_farmasi = $data_fee_farmasi['jumlah_uang'];
    $prosetase_farmasi = $data_fee_farmasi['jumlah_prosentase'];

    if ($nominal_farmasi != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$nominal_farmasi', '$tanggal', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosetase_farmasi != 0) {


     
      $fee_prosentase = $prosetase_farmasi * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }
    
    // petugas lain
    $fee_lain = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_lain' ");
    $data_fee_lain = mysqli_fetch_array($fee_lain);
    $nominal_lain = $data_fee_lain['jumlah_uang'];
    $prosentase_lain = $data_fee_lain['jumlah_prosentase'];

    if ($nominal_lain != 0) {
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$nominal_lain', '$tanggal', '$jam_sekarang', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_lain != 0) {


     
      $fee_prosentase = $prosentase_lain * $total / 100;
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }

    
    //dokter
    $fee_dokter = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$dokter' ");
    $data_fee_dokter = mysqli_fetch_array($fee_dokter);
    $nominal_dokter = $data_fee_dokter['jumlah_uang'];
    $prosentase_dokter = $data_fee_dokter['jumlah_prosentase'];


    if ($nominal_dokter != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$nominal_dokter', '$tanggal', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_dokter != 0) {


     
      $fee_prosentase = $prosentase_dokter * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }

    // FEE FAKTUR FEE FAKTUR FEE FAKTUR FEE FAKTUR FEE FAKTUR FEE FAKTUR 

  
  $delete_lap_fee_produk = $db->query("DELETE FROM laporan_fee_produk WHERE no_reg = '$no_reg' ");

    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg = '$no_reg'");
   while  ($cek0 = mysqli_fetch_array($query0)){


          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_rm,no_reg) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$cek0[tanggal]', '$cek0[jam]','$no_rm','$no_reg')");


    }

        // FEE PETUGAS OPERASI

              
   $fee_petugas_operasi = $db->query("SELECT tdp.no_reg,tdp.id_sub_operasi,do.jumlah_persentase,tdp.id_user,tdp.waktu,tp.harga_jual,do.id_detail_operasi,do.nama_detail_operasi,DATE(tdp.waktu) AS tanggal, TIME(tdp.waktu) AS jam FROM tbs_detail_operasi tdp LEFT JOIN sub_operasi tp ON tdp.id_sub_operasi = tp.id_sub_operasi LEFT JOIN detail_operasi do ON tdp.id_detail_operasi = do.id_detail_operasi WHERE tdp.no_reg = '$no_reg'");

   while  ($data_fee_produk = mysqli_fetch_array($fee_petugas_operasi)){

          $jumlah_fee1 = ($data_fee_produk['jumlah_persentase'] * $data_fee_produk['harga_jual']) / 100;
          $jumlah_fee = round($jumlah_fee1);
    

          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[id_user]', '$no_faktur', '$data_fee_produk[id_detail_operasi]', '$data_fee_produk[nama_detail_operasi]  - $data_fee_produk[waktu]', '$jumlah_fee', '$data_fee_produk[tanggal]', '$data_fee_produk[jam]','$no_reg','$no_rm')");

  
    }
// end laporan fee produk

$delete_penjualan = $db->query("DELETE FROM penjualan WHERE no_reg = '$no_reg' ");

            $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, no_reg, penjamin, apoteker, perawat, petugas_lain, dokter, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, cara_bayar, tunai, keterangan, ppn,jenis_penjualan,nama,kredit,nilai_kredit,biaya_admin) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Simpan Sementara',?,?,?,?,?,?,?,'Rawat Inap',?,?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssissssiiisisssiii",
              $no_faktur,$no_reg,$penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $no_rm, $total, $tanggal, $jam_sekarang, $nama_petugas, $petugas_kasir, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$nama_pasien,$sisa_kredit,$sisa_kredit,$biaya_admin);

              
    // jalankan query
              $stmt->execute();


 $z = $db->query("DELETE FROM detail_penjualan WHERE no_reg = '$no_reg' ");

    $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
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

        
        $query2 = $db->query("INSERT INTO detail_penjualan (no_faktur, tanggal, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan,harga, subtotal, potongan, tax, hpp, sisa, no_pesanan, komentar,jam,tipe_produk,dosis,no_reg,no_rm,lab) 
          VALUES 
          ('$no_faktur','$data[tanggal]','$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$satuan','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]','$data[hpp]','$data[jumlah_barang]', '1', '$data[komentar]','$data[jam]','$data[tipe_barang]','$data[dosis]','$data[no_reg]','$no_rm','$data[lab]')");


    }


    echo "Success";




$delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur' ");

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_reg = '$no_reg'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];


$biaya_admin = angkadoang($_POST['biaya_admin']);

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

$kredit_piutang = $total - $pembayaran;

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$kredit_piutang', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");




if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_admin;

 $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
$ppn_input;
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}


  }

else {
  //ppn == Exclude
  $total_penjualan = $total2 + $biaya_admin;
  $pajak = $tax;
$ppn_input;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}



/*
// BOT STAR AUTO
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

   
    // bot makanan
      
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
        

// bot minuman
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


// bot beef
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

// PRINT OTOMATIS (DARI SINI)


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



     $query00 = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
     $query01 = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");

}//braket cek subtotal (diproses)

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


    ?>