<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

$total = angkadoang($_POST['total']);
$potongan = angkadoang($_POST['potongan']);
$biaya_admin = angkadoang($_POST['biaya_adm']);
$nomor_faktur = stringdoang($_POST['no_faktur']);
$no_reg = stringdoang($_POST['no_reg']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$nomor_faktur'");
 $data = mysqli_fetch_array($query);
 $total_penjualan = $data['total_penjualan'];

  $sum_harga = $db->query("SELECT SUM(subtotal) AS harga_radiologi FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1' AND no_faktur = '$nomor_faktur'");
 $data_radiologi= mysqli_fetch_array($sum_harga);


$total_tbs = ($total_penjualan + $data_radiologi['harga_radiologi'] - $potongan) + $biaya_admin;

if ($total != $total_tbs) {
    echo 1;
  }
  else{
   

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$waktu = date('Y-m-d H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);

echo $nomor_faktur = stringdoang($_POST['no_faktur']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$ber_stok = stringdoang($_POST['ber_stok']);
$tanggal_jt = tanggal_mysql($_POST['tanggal_jt']);
$nama_petugas = stringdoang($_SESSION['nama']);
$kode_gudang = stringdoang($_POST['kode_gudang']);
$ppn_input = stringdoang($_POST['ppn_input']);
$penjamin = stringdoang($_POST['penjamin']);
$nama_pasienx = stringdoang($_POST['nama_pasien']);

    $petugas_kasir = stringdoang($_POST['petugas_kasir']);
    $petugas_paramedik = stringdoang($_POST['petugas_paramedik']);
    $petugas_farmasi = stringdoang($_POST['petugas_farmasi']);
    $petugas_lain = stringdoang($_POST['petugas_lain']);
    $dokter = stringdoang($_POST['dokter']);

$keterangan = stringdoang($_POST['keterangan']);
$total2 = angkadoang($_POST['total2']);
$harga = angkadoang($_POST['harga']);
$tanggal_edit = stringdoang($_POST['tanggal']);
$jam_sekarang = stringdoang($_POST['jam']);

$waktu_edit = $tanggal_edit." ".$jam_sekarang;

/*/$tax = angkadoang($_POST['tax']);/*/

$sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
$sisa_kredit = angkadoang($_POST['kredit']);
$sisa = angkadoang($_POST['sisa']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$no_jurnal = no_jurnal();

  $ambil_pelanggan = $db_pasien->query("SELECT alamat_sekarang, no_telp , umur, jenis_kelamin,nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm' ");
  $data_pasien = mysqli_fetch_array($ambil_pelanggan);

  $nama_pasien = $data_pasien['nama_pelanggan'];
    
     $quer10000 = $db->query("DELETE  FROM jurnal_trans WHERE no_faktur = '$nomor_faktur' ");

      $quer100 = $db->query("DELETE  FROM laporan_fee_faktur WHERE no_reg = '$no_reg' ");

    // petugas kasir
    $fee_kasir = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_kasir'");
    $data_fee_kasir = mysqli_fetch_array($fee_kasir);
    $nominal_kasir = $data_fee_kasir['jumlah_uang'];
    $prosentase_kasir = $data_fee_kasir['jumlah_prosentase'];

    if ($nominal_kasir != 0) {
      

      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_reg, no_rm) VALUES ('$data_fee_kasir[nama_petugas]', '$nomor_faktur', '$nominal_kasir', '$tanggal_edit', '$jam_sekarang', '', '$no_reg', '$no_rm')");

    }

    elseif ($prosentase_kasir != 0) {


     
      $fee_prosentase = $prosentase_kasir * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_kasir[nama_petugas]', '$nomor_faktur', '$fee_prosentase', '$tanggal_edit', '$jam_sekarang','$no_reg', '$no_rm')");
      
    }
    
    // petugas paramedik
    $fee_paramedik = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_paramedik'");
    $data_fee_paramedik = mysqli_fetch_array($fee_paramedik);
    $nominal_paramedik = $data_fee_paramedik['jumlah_uang'];
    $prosentase_paramedik = $data_fee_paramedik['jumlah_prosentase'];

    if ($nominal_paramedik != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_reg, no_rm) VALUES ('$data_fee_paramedik[nama_petugas]', '$nomor_faktur', '$nominal_paramedik', '$tanggal_edit', '$jam_sekarang', '','$no_reg', '$no_rm')");

    }

    elseif ($prosentase_paramedik != 0) {


     
      $fee_prosentase = $prosentase_paramedik * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_paramedik[nama_petugas]', '$nomor_faktur', '$fee_prosentase', '$tanggal_edit', '$jam_sekarang','$no_reg', '$no_rm')");
      
    }
    
    // petugas farmasi
    $fee_farmasi = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_farmasi'");
    $data_fee_farmasi = mysqli_fetch_array($fee_farmasi);
    $nominal_farmasi = $data_fee_farmasi['jumlah_uang'];
    $prosetase_farmasi = $data_fee_farmasi['jumlah_prosentase'];

    if ($nominal_farmasi != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_reg, no_rm) VALUES ('$data_fee_farmasi[nama_petugas]', '$nomor_faktur', '$nominal_farmasi', '$tanggal_edit', '$jam_sekarang', '','$no_reg', '$no_rm')");

    }

    elseif ($prosetase_farmasi != 0) {


     
      $fee_prosentase = $prosetase_farmasi * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_farmasi[nama_petugas]', '$nomor_faktur', '$fee_prosentase', '$tanggal_edit', '$jam_sekarang','$no_reg', '$no_rm')");
      
    }
    
    // petugas lain
    $fee_lain = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_lain'");
    $data_fee_lain = mysqli_fetch_array($fee_lain);
    $nominal_lain = $data_fee_lain['jumlah_uang'];
    $prosentase_lain = $data_fee_lain['jumlah_prosentase'];

    if ($nominal_lain != 0) {
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_lain[nama_petugas]', '$nomor_faktur', '$nominal_lain', '$tanggal_edit', '$jam_sekarang','$no_reg', '$no_rm')");

    }

    elseif ($prosentase_lain != 0) {


     
      $fee_prosentase = $prosentase_lain * $total / 100;
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_lain[nama_petugas]', '$nomor_faktur', '$fee_prosentase', '$tanggal_edit', '$jam_sekarang','$no_reg', '$no_rm')");
      
    }

    
    //dokter
    $fee_dokter = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$dokter'");
    $data_fee_dokter = mysqli_fetch_array($fee_dokter);
    $nominal_dokter = $data_fee_dokter['jumlah_uang'];
    $prosentase_dokter = $data_fee_dokter['jumlah_prosentase'];


    if ($nominal_dokter != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_reg, no_rm) VALUES ('$data_fee_dokter[nama_petugas]', '$nomor_faktur', '$nominal_dokter', '$tanggal_edit', '$jam_sekarang', '','$no_reg', '$no_rm')");

    }

    elseif ($prosentase_dokter != 0) {


     
      $fee_prosentase = $prosentase_dokter * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_reg, no_rm) VALUES ('$data_fee_dokter[nama_petugas]', '$nomor_faktur', '$fee_prosentase', '$tanggal_edit', '$jam_sekarang','$no_reg', '$no_rm')");
      
    }


            $delete44 = $db->query("DELETE FROM laporan_fee_produk WHERE no_reg = '$no_reg'");


    // laporan fee produk
              
    $fee_produk_ksir = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_ksir)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_reg,no_rm,waktu) VALUES ('$data_fee_produk[nama_petugas]', '$nomor_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$tanggal_edit', '$jam_sekarang','$no_reg','$no_rm','$waktu_edit')");


    }
          

  
  $delete = $db->query("DELETE FROM detail_penjualan WHERE no_reg = '$no_reg'");
            
            
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
        
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, no_reg, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,tipe_produk,lab) VALUES ('$nomor_faktur','$no_rm', '$no_reg', '$tanggal_edit', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang','$data[tipe_barang]','$data[lab]')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }

        
      }
            

            
            $sisa = angkadoang($_POST['sisa']);
            $sisa_kredit = angkadoang($_POST['kredit']);
            $ss_kredit = angkadoang($_POST['sisa_kredit']);
           $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $tunai_i = $pembayaran - $total;


          if ($tunai_i >= 0) 
            
            {
            
            $ket_jurnal = "Penjualan ".$jenis_penjualan." Lunas ".$nama_pasien." ";

            // buat prepared statements
            $stmt2 = $db->prepare("UPDATE penjualan SET penjamin = ?, apoteker = ?, perawat = ?, petugas_lain = ?, dokter = ?, kode_gudang = ?, total = ?, tanggal = ?, jam = ?,  status = 'Lunas', potongan = ?, /*/tax = ?,/*/ sisa = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Tunai', keterangan = ?, ppn = ?,jenis_penjualan = ?,biaya_admin = ?, petugas_edit = ?, waktu_edit = ?, no_faktur_jurnal = ?, keterangan_jurnal = ? , kode_pelanggan = ? , nama = ?, tanggal_jt = '', kredit =  '0', nilai_kredit =  '0'WHERE no_faktur = ?");
            

            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("ssssssissiisisssisssssss", 
            $penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $total, $tanggal_edit, $jam_sekarang, $potongan,/*/ $tax, /*/$sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$jenis_penjualan,$biaya_admin,$nama_petugas,$waktu,$no_jurnal, $ket_jurnal,$no_rm,$nama_pasien,$nomor_faktur);

            
            $stmt2->execute();          

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$nomor_faktur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
/*

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");



if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_admin;


  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

} 


else if ($ppn_input == "Include") {
//ppn == Include

  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;


$pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

if ($pajak != "" || $pajak != 0 ) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
      }
      

  }

else {
  //ppn == Exclude
  $total_penjualan = ($total2 - $total_tax) + $biaya_admin;

$tax = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");


if ($tax != "" || $tax != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$tax', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
}

*/
              
}
            

            else if ($tunai_i != 0 ) 

            {

              $ket_jurnal = "Penjualan ".$jenis_penjualan." Piutang ".$nama_pasien." ";

            $stmt2 = $db->prepare("UPDATE penjualan SET penjamin = ?, apoteker = ?, perawat = ?, petugas_lain = ?, dokter = ?, kode_gudang = ?,total = ?, tanggal = ?, jam = ?, status = 'Piutang', potongan = ?, /*/tax = ?,/*/ kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Kredit', keterangan = ?, ppn = ?,jenis_penjualan = ?,tanggal_jt = ?,biaya_admin = ?, petugas_edit = ?, waktu_edit = ?, no_faktur_jurnal = ?, keterangan_jurnal = ?, nama = ?, kode_pelanggan = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("ssssssissiisissssisssssss", 
            $penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $total, $tanggal_edit , $jam_sekarang,$potongan, /*/$tax, /*/$sisa_kredit, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$jenis_penjualan,$tanggal_jt,$biaya_admin,$nama_petugas,$waktu,$no_jurnal, $ket_jurnal,$nama_pasien,$no_rm,$nomor_faktur);

            
            // jalankan query
            $stmt2->execute(); 
            


            // cek query
        if (!$stmt2) {
           die('Query Error : '.$db->errno.
           ' - '.$db->error);
        }
        else {

        }

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$nomor_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);

                $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $piutang_1 = $total - $pembayaran;
/*

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$piutang_1', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");


if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_admin;

 $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
$ppn_input;
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
}


  }

else {
  //ppn == Exclude
  $total_penjualan = ($total2 - $total_tax) + $biaya_admin;
  $pajak = $total_tax;
$ppn_input;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_edit $jam_sekarang', 'Penjualan Rawat Jalan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$nomor_faktur','1', '$nama_petugas')");
}

*/
   
}

   // history tbs penjulan 


        $deletehistory_tbs_penjualan = $db->query("DELETE FROM history_edit_tbs_penjualan WHERE no_reg = '$no_reg' ");


         $history_tbs_penjualan = "INSERT INTO history_edit_tbs_penjualan (session_id,no_faktur,no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,hpp,tipe_barang,dosis,tanggal,jam,lab) SELECT session_id,no_faktur,no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,hpp,tipe_barang,dosis,tanggal,jam,lab FROM tbs_penjualan WHERE no_reg = '$no_reg' ";

        if ($db->query($history_tbs_penjualan) === TRUE) {
        } 

        else {
        echo "Error: " . $history_tbs_penjualan . "<br>" . $db->error;
        }

        // end

           // history tbs fee produk 


        $delete_history_tbs_fee_produk = $db->query("DELETE FROM history_edit_tbs_fee_produk WHERE no_reg = '$no_reg' ");


         $history_tbs_fee_produk = "INSERT INTO history_edit_tbs_fee_produk (session_id,nama_petugas,no_faktur,kode_produk,nama_produk,jumlah_fee,tanggal,waktu,jam,no_reg,no_rm) SELECT session_id,nama_petugas,no_faktur,kode_produk,nama_produk,jumlah_fee,tanggal,waktu,jam,no_reg,no_rm FROM tbs_fee_produk WHERE no_reg = '$no_reg' ";

        if ($db->query($history_tbs_fee_produk) === TRUE) {
        } 

        else {
        echo "Error: " . $history_tbs_fee_produk . "<br>" . $db->error;
        }

        // end

        
            
    $update_registrasi = $db->query("UPDATE registrasi SET status = 'Sudah Pulang' , nama_pasien = '$nama_pasien', no_rm = '$no_rm', alamat_pasien = '$data_pasien[alamat_sekarang]', hp_pasien = '$data_pasien[no_telp]' , umur_pasien = '$data_pasien[umur]' , jenis_kelamin = '$data_pasien[jenis_kelamin]' WHERE no_reg ='$no_reg'");

    $updatemedik = $db->query("UPDATE rekam_medik SET no_rm = '$no_rm' , nama = '$nama_pasien', alamat = '$data_pasien[alamat_sekarang]' ,umur = '$data_pasien[umur]', jenis_kelamin = '$data_pasien[jenis_kelamin]' WHERE no_reg = '$no_reg'  ");

    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");



}// braket if untuk cek subtotal 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
?>