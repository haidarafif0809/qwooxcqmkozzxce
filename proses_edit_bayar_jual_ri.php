<?php 
include 'db.php';
include_once 'sanitasi.php';

session_start();
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);

try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown


echo $no_faktur = stringdoang($_POST['no_faktur']);

$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$ber_stok = stringdoang($_POST['ber_stok']);
$tanggal_jt = tanggal_mysql($_POST['tanggal_jt']);
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

$keterangan = stringdoang($_POST['keterangan']);
$total = angkadoang($_POST['total']);
$total2 = angkadoang($_POST['total2']);
$potongan = angkadoang($_POST['potongan']);
$tax = angkadoang($_POST['tax']);
$sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
$sisa_kredit = angkadoang($_POST['kredit']);
$sisa = angkadoang($_POST['sisa']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);
$biaya_admin = angkadoang($_POST['biaya_admin']);
$bed = stringdoang($_POST['bed']);
$group_bed = stringdoang($_POST['group_bed']);


$no_jurnal = no_jurnal();


    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    $delete_lap_fee = $db->query("DELETE FROM laporan_fee_faktur WHERE no_reg = '$no_reg' ");


    $delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur' ");

    // petugas kasir
    $fee_kasir = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_kasir' ");
    $data_fee_kasir = mysqli_fetch_array($fee_kasir);           
    $nominal_kasir = $data_fee_kasir['jumlah_uang'];
    $prosentase_kasir = $data_fee_kasir['jumlah_prosentase'];

    if ($nominal_kasir != 0) {
      

      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_kasir[nama_petugas]', '$no_faktur', '$nominal_kasir', '$tanggal_sekarang', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_kasir != 0) {


     
      $fee_prosentase = $prosentase_kasir * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_kasir[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }
    
    // petugas paramedik
    $fee_paramedik = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_paramedik' ");
    $data_fee_paramedik = mysqli_fetch_array($fee_paramedik);
    $nominal_paramedik = $data_fee_paramedik['jumlah_uang'];
    $prosentase_paramedik = $data_fee_paramedik['jumlah_prosentase'];

    if ($nominal_paramedik != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_paramedik[nama_petugas]', '$no_faktur', '$nominal_paramedik', '$tanggal_sekarang', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_paramedik != 0) {


     
      $fee_prosentase = $prosentase_paramedik * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_paramedik[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }

    // petugas farmasi
    $fee_farmasi = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_farmasi'");
    $data_fee_farmasi = mysqli_fetch_array($fee_farmasi);
    $nominal_farmasi = $data_fee_farmasi['jumlah_uang'];
    $prosetase_farmasi = $data_fee_farmasi['jumlah_prosentase'];

    if ($nominal_farmasi != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_reg, no_rm) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$nominal_farmasi', '$tanggal_sekarang', '$jam_sekarang', '', '$no_reg', '$no_rm')");

    }

    elseif ($prosetase_farmasi != 0) {
    

     
      $fee_prosentase = $prosetase_farmasi * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_reg', '$no_rm')");
      
    }
    
    // petugas lain
    $fee_lain = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_lain'");
    $data_fee_lain = mysqli_fetch_array($fee_lain);
    $nominal_lain = $data_fee_lain['jumlah_uang'];
    $prosentase_lain = $data_fee_lain['jumlah_prosentase'];

    if ($nominal_lain != 0) {
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$nominal_lain', '$tanggal_sekarang', '$jam_sekarang', '$no_reg', '$no_rm')");

    }

    elseif ($prosentase_lain != 0) {


     
      $fee_prosentase = $prosentase_lain * $total / 100;
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_reg', '$no_rm')");
      
    }

    
    //dokter
    $fee_dokter = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$dokter'");
    $data_fee_dokter = mysqli_fetch_array($fee_dokter);
    $nominal_dokter = $data_fee_dokter['jumlah_uang'];
    $prosentase_dokter = $data_fee_dokter['jumlah_prosentase'];


    if ($nominal_dokter != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_reg, no_rm) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$nominal_dokter', '$tanggal_sekarang', '$jam_sekarang', '', '$no_reg', '$no_rm')");

    }

    elseif ($prosentase_dokter != 0) {


     
      $fee_prosentase = $prosentase_dokter * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_reg', '$no_rm')");
      
    }

  $delete_lap_fee_produk = $db->query("DELETE FROM laporan_fee_produk WHERE no_reg = '$no_reg' ");

    // FEE PETUGAS OPERASI
              
    $fee_petugas_operasi = $db->query("SELECT tdp.no_reg,tdp.id_sub_operasi,do.jumlah_persentase,tdp.id_user,tdp.waktu,tp.harga_jual,do.id_detail_operasi,do.nama_detail_operasi,DATE(tdp.waktu) AS tanggal, TIME(tdp.waktu) AS jam  FROM tbs_detail_operasi tdp LEFT JOIN sub_operasi tp ON tdp.id_sub_operasi = tp.id_sub_operasi LEFT JOIN detail_operasi do ON tdp.id_detail_operasi = do.id_detail_operasi WHERE tdp.no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_petugas_operasi)){

          $jumlah_fee1 = ($data_fee_produk['jumlah_persentase'] * $data_fee_produk['harga_jual']) / 100;
          $jumlah_fee = round($jumlah_fee1);
    

          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[id_user]', '$no_faktur', '$data_fee_produk[id_detail_operasi]', '$data_fee_produk[nama_detail_operasi]  - $data_fee_produk[waktu]', '$jumlah_fee', '$data_fee_produk[tanggal]', '$data_fee_produk[waktu]','$no_reg','$no_rm')");

  
    }


    // petugas kasir
              
    $fee_produk_ksir = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$petugas_kasir' AND no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_ksir)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$data_fee_produk[tanggal]', '$data_fee_produk[jam]','$no_reg','$no_rm')");


    }
    

// petugas paramedik
       
    $fee_produk_paramedik = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$petugas_paramedik' AND no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_paramedik)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$data_fee_produk[tanggal]', '$data_fee_produk[jam]','$no_reg','$no_rm')");


    }

// petugas farmasi
       
    $fee_produk_farmasi = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$petugas_farmasi' AND no_reg = '$no_reg'
AND no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_farmasi)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$data_fee_produk[tanggal]', '$data_fee_produk[jam]','$no_reg','$no_rm')");


    }

// petugas lain
       
    $fee_produk_lain = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$petugas_lain' AND no_reg = '$no_reg'
AND no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_lain)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$data_fee_produk[tanggal]', '$data_fee_produk[jam]','$no_reg','$no_rm')");


    }

//dokter 
       
    $fee_produk_dokter = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$dokter' AND no_reg = '$no_reg'
AND no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_dokter)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$data_fee_produk[tanggal]', '$data_fee_produk[jam]','$no_reg','$no_rm')");


    }


 $z = $db->query("DELETE FROM detail_penjualan WHERE no_reg = '$no_reg' ");

    $query = $db->query("SELECT * FROM tbs_penjualan WHERE  no_reg = '$no_reg'");
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
        
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, no_reg, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,tipe_produk,lab) VALUES ('$no_faktur','$no_rm', '$no_reg', '$data[tanggal]', '$data[jam]', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang','$data[tipe_barang]','$data[lab]')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }

        
      }



    $sisa = angkadoang($_POST['sisa']);
            $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $tunai_i = $pembayaran - $total;


          if ($tunai_i >= 0) 

            {

              $delete_penjualan = $db->query("DELETE FROM penjualan WHERE no_reg = '$no_reg' ");

              $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, no_reg, penjamin, apoteker, perawat, petugas_lain, dokter, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,nama,biaya_admin) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,'Tunai',?,?,'Rawat Inap',?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssissssiiisisssi",
              $no_faktur,$no_reg,$penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $nama_petugas, $petugas_kasir, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$nama_pasien,$biaya_admin);
 

              $_SESSION['no_faktur']=$no_faktur;
              
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

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);



//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");



if ($ppn_input == "Non") {
    $total_penjualan = $total2 + $biaya_admin;


  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax ;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

if ($pajak != "" || $pajak != 0 ) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
      }
      

  }

else {
  //ppn == Exclude
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}

            
              
}



              else if ($tunai_i != 0)
              
            {
              $nilai_piutang = $total - $pembayaran;

               $delete_penjualan = $db->query("DELETE FROM penjualan WHERE no_reg = '$no_reg' ");
              
             $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, no_reg, penjamin, apoteker, perawat, petugas_lain, dokter, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, kredit, nilai_kredit, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,nama,tanggal_jt,biaya_admin) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Piutang',?,?,?,?,?,?,'Kredit',?,?,'Rawat Inap',?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssissssiiiisissssi",
              $no_faktur,$no_reg,$penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $nama_petugas, $petugas_kasir, $potongan, $tax, $nilai_piutang, $nilai_piutang, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$nama_pasien,$tanggal_jt,$biaya_admin);
 

              $_SESSION['no_faktur']=$no_faktur;
              
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
              
              
              
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);



            $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $piutang_1 = $total - $pembayaran;

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$piutang_1', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");



if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_admin;

 $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
$ppn_input;
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax ;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}


  }

else {
  //ppn == Exclude
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax ;
  $pajak = $total_tax;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Rawat Inap Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
}


   
}


    // cek query
if (!$stmt) 
      {
        die('Query Error : '.$db->errno.
          ' - '.$db->error);
      }

else 
      {
    
      }


// IBSERT HASIL OPERASI

          $tbs_opsss = $db->query("DELETE FROM hasil_operasi WHERE no_reg = '$no_reg'");

    $tbs_ops = $db->query("SELECT * FROM tbs_operasi WHERE no_reg = '$no_reg'");
    while ($data_ops = mysqli_fetch_array($tbs_ops))
      {

        $insert_operasi = "INSERT INTO hasil_operasi (sub_operasi,petugas_input, no_reg, harga_jual, operasi, waktu) VALUES ('$data_ops[sub_operasi]','$data_ops[petugas_input]', '$no_reg', '$data_ops[harga_jual]', '$data_ops[operasi]', '$data_ops[waktu]')";

        if ($db->query($insert_operasi) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_operasi . "<br>" . $db->error;
        }

      }

// IBSERT HASIL DETAIL OPERASI

          $tbs_opsddd = $db->query("DELETE FROM hasil_detail_operasi WHERE no_reg = '$no_reg'");

    $detail_ops = $db->query("SELECT * FROM tbs_detail_operasi WHERE no_reg = '$no_reg'");
    while ($data_detail_ops = mysqli_fetch_array($detail_ops))
      {

        $insert_detail_operasi = "INSERT INTO hasil_detail_operasi (id_detail_operasi,id_user, id_sub_operasi, id_operasi, petugas_input, no_reg, waktu, id_tbs_operasi) VALUES ('$data_detail_ops[id_detail_operasi]','$data_detail_ops[id_user]', '$data_detail_ops[id_sub_operasi]', '$data_detail_ops[id_operasi]', '$data_detail_ops[petugas_input]', '$no_reg', '$data_detail_ops[waktu]', '$data_detail_ops[id_tbs_operasi]')";

        if ($db->query($insert_detail_operasi) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_detail_operasi . "<br>" . $db->error;
        }

      }


    $update_registrasi = $db->query("UPDATE registrasi SET status = 'Sudah Pulang' WHERE no_reg ='$no_reg'");

// UPDATE KAMAR
$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed + 1 WHERE nama_kamar = '$bed' AND group_bed = '$group_bed'");
// END UPDATE KAMAR


    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");
    $hapus_tbs_operasi = $db->query("DELETE  FROM tbs_operasi WHERE no_reg = '$no_reg'");
    $hapus_tbs_detail_operasi = $db->query("DELETE  FROM tbs_detail_operasi WHERE no_reg = '$no_reg'");



    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
}

catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>