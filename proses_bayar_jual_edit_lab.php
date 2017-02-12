
<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('H:i:sa Y-m-d');


try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown
$no_rm = stringdoang($_POST['kode_pelanggan']);
$nama_pelanggan = stringdoang($_POST['nama_pelanggan']);


if ($no_rm == "" || $nama_pelanggan == "") {

$no_rm = "Umum";
$nama_pelanggan = "Umum";

}
else{

$no_rm = stringdoang($_POST['kode_pelanggan']);
$nama_pelanggan = stringdoang($_POST['nama_pelanggan']);

}

echo $no_faktur = stringdoang($_POST['no_faktur']);
$apoteker = stringdoang($_POST['apoteker']);
$nama_petugas = stringdoang($_SESSION['nama']);
$ppn_input = stringdoang($_POST['ppn_input']);
$penjamin = stringdoang($_POST['penjamin']);
$user = $_SESSION['nama'];

$petugas = $_SESSION['id'];
$keterangan = stringdoang($_POST['keterangan']);
$total = angkadoang($_POST['total']);
$total2 = angkadoang($_POST['total2']);
$potongan = angkadoang($_POST['potongan']);
$tax = angkadoang($_POST['tax']);
$biaya_admin = angkadoang($_POST['biaya_admin']);
$sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
$sisa = angkadoang($_POST['sisa']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);
$tanggal_jt = stringdoang($_POST['tanggal_jt']);
$tanggal_jt = tanggal_mysql($tanggal_jt);
$no_jurnal = no_jurnal();

$id_userr = $db->query("SELECT id FROM user WHERE nama = '$user'");
$data_id = mysqli_fetch_array($id_userr);
$id_kasir = $data_id['id'];

// delete llaporan_fee_faktur
$delete = $db->query("DELETE FROM laporan_fee_faktur WHERE no_faktur = '$no_faktur' AND nama_petugas = '$apoteker' ");

// fee analis
    $perintah0 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$apoteker'");
    $cek = mysqli_fetch_array($perintah0);
    $nominal = $cek['jumlah_uang'];
    $prosentase = $cek['jumlah_prosentase'];

    if ($nominal != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar,no_rm) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '$no_rm')");

    }

    elseif ($prosentase != 0) {


     
      $fee_prosentase = $prosentase * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam,no_rm) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_rm')");
      
    }// end analis


// delete llaporan_fee_produk
$delete_agi = $db->query("DELETE FROM laporan_fee_produk WHERE no_faktur = '$no_faktur' AND nama_petugas = '$apoteker' ");
              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$apoteker' AND no_faktur = '$no_faktur'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_rm) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang','$no_rm')");


    }// end fee analis


// delete llaporan_fee_faktur
$delete1 = $db->query("DELETE FROM laporan_fee_faktur WHERE no_faktur = '$no_faktur' AND nama_petugas = '$petugas' ");


// fee petugas kasir
  $perintah0 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas'");
    $cek = mysqli_fetch_array($perintah0);
    $nominal = $cek['jumlah_uang'];
    $prosentase = $cek['jumlah_prosentase'];

    if ($nominal != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar,no_rm) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '$no_rm')");

    }

    elseif ($prosentase != 0) {


     
      $fee_prosentase = $prosentase * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam,no_rm) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang','$no_rm')");
      
    }

    
    // delete llaporan_fee_produk
$delete_agi1 = $db->query("DELETE FROM laporan_fee_produk WHERE no_faktur = '$no_faktur' AND nama_petugas = '$petugas' ");   

    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$petugas' AND no_faktur = '$no_faktur'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang')");


    }
// end fee petugas kasir



    $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);


    $query3 = $db->query("DELETE  FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ");


    $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium'");
    while ($data = mysqli_fetch_array($query))
      {
        
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, tanggal, jam, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, sisa,tipe_produk,lab) VALUES ('$no_faktur','$no_rm', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]', '$data[jumlah_barang]','$data[tipe_barang]','$data[lab]')";

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
                        
             $stmt = $db->prepare("UPDATE penjualan SET nama = ?, penjamin = ?, analis = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, petugas_edit = ?, sales = ?, status = 'Lunas', potongan = ?, tax = ?, sisa = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Tunai', keterangan = ?, ppn = ?, biaya_admin = ?, waktu_edit = ? WHERE no_faktur = ?");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("ssssissssiiisississ",
              $nama_pelanggan, $penjamin, $apoteker, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $user, $id_kasir, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$biaya_admin, $waktu, $no_faktur);
                         
    // jalankan query
              $stmt->execute();
              
              
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);



//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$no_faktur','1', '$user')");



if ($ppn_input == "Non") {

    $total_penjualan = $total2 + $biaya_admin;


  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

} 


else if ($ppn_input == "Include") {
//ppn == Include

  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0 ) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
      }
      

  }

else {
  //ppn == Exclude
  $total_penjualan = $total2 + $biaya_admin;
  $pajak = $tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$user')");
}

            
              
 }
              


            else if ($tunai_i < 0)
              
            {
              
             $pembayaran = stringdoang($_POST['pembayaran']);
    $total = stringdoang($_POST['total']);
    $piutang_1 = $total - $pembayaran;

             $stmt = $db->prepare("UPDATE penjualan SET nama = ?, penjamin = ?, analis = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, petugas_edit = ?, sales = ?, status = 'Piutang', potongan = ?, tax = ?, kredit = ?, nilai_kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Kredit', keterangan = ?, ppn = ?, biaya_admin = ?, waktu_edit = ? WHERE no_faktur = ?");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("ssssissssiiiisississ",
              $nama_pelanggan, $penjamin, $apoteker, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $user, $id_kasir, $potongan, $tax, $piutang_1, $piutang_1, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$biaya_admin, $waktu, $no_faktur);
                          
              // jalankan query
              $stmt->execute();
              
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    
/*

//PERSEDIAAN   
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$user')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$piutang_1', '0', 'Penjualan', '$no_faktur','1', '$user')");


if ($ppn_input == "Non") {
// ppn == NON
    $total_penjualan = $total2 + $biaya_admin;

 $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
$ppn_input;
  $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
}


  }

else {

  //ppn == Exclude
  $total_penjualan = $total2 + $biaya_admin;
  $pajak = $tax;
$ppn_input;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Laboratorium Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$user')");
}


   
}

*/
    // cek query
if (!$stmt) 
      {
        die('Query Error : '.$db->errno.
          ' - '.$db->error);
      }

else 
      {
    
      }



// BOT STAR AUTO      

              $total = angkadoang($_POST['total']);
/*
                    
      $url = "https://api.telegram.org/bot233675698:AAEbTKDcPH446F-bje4XIf1YJ0kcmoUGffA/sendMessage?chat_id=-129639785&text=";
      $text = urlencode("No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' ORDER BY id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
            $pesanan =  $data12['nama_barang']." - ".$data12['jumlah_barang']." - ".$data12['harga']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' ORDER BY id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) 
      {
      $pesanan_jadi = $pesanan_jadi."Subtotal : ".$total;
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      

      
      }


     */

     
}

   // history tbs penjulan 


        $deletehistory_tbs_penjualan = $db->query("DELETE FROM history_edit_tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ");


         $history_tbs_penjualan = "INSERT INTO history_edit_tbs_penjualan (session_id,no_faktur,no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,hpp,tipe_barang,dosis,tanggal,jam,lab) SELECT session_id,no_faktur,no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,hpp,tipe_barang,dosis,tanggal,jam,lab FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ";

        if ($db->query($history_tbs_penjualan) === TRUE) {
        } 

        else {
        echo "Error: " . $history_tbs_penjualan . "<br>" . $db->error;
        }

        // end

           // history tbs fee produk 


        $delete_history_tbs_fee_produk = $db->query("DELETE FROM history_edit_tbs_fee_produk WHERE no_faktur = '$no_faktur'  ");


         $history_tbs_fee_produk = "INSERT INTO history_edit_tbs_fee_produk (session_id,nama_petugas,no_faktur,kode_produk,nama_produk,jumlah_fee,tanggal,waktu,jam,no_reg,no_rm) SELECT session_id,nama_petugas,no_faktur,kode_produk,nama_produk,jumlah_fee,tanggal,waktu,jam,no_reg,no_rm FROM tbs_fee_produk WHERE no_faktur = '$no_faktur'";

        if ($db->query($history_tbs_fee_produk) === TRUE) {
        } 

        else {
        echo "Error: " . $history_tbs_fee_produk . "<br>" . $db->error;
        }

        // end


    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ");


    $query_terakhir = $db->query("DELETE FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' ");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>


