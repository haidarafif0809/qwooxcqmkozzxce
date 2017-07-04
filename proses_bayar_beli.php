<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang; 

 }
//ambil bulan dari tanggal penjualan terakhir

  $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM pembelian ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM pembelian ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/BL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/BL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }


// PENGAMBILAN DATA YANG DIPOST DARI FORM PEMBELIAN (JADIKAN DILUAR AGAR BISA DIAMBIL SEMUA)
           $sisa_kredit = stringdoang($_POST['kredit']);
           $sisa_kredit = str_replace(',','.',$sisa_kredit);
              if ($sisa_kredit == '' ) {
                $sisa_kredit = 0;
              }
           $suplier = stringdoang($_POST['suplier']);

           $total = stringdoang($_POST['total']);
           $total = str_replace(',','.',$total);
              if ($total == '') {
                $total = 0;
              }

           $total_1 = stringdoang($_POST['total_1']);
           $total_1 = str_replace(',','.',$total_1);
              if ($total_1 == '') {
                $total_1 = 0;
              }

           $potongan = stringdoang($_POST['potongan']);
           $potongan = str_replace(',','.',$potongan);
              if ($potongan == '') {
                $potongan = 0;
              }
           $tax = stringdoang($_POST['tax']);
           $tax = str_replace(',','.',$tax);
              if ($tax == '') {
                $tax = 0;
              }

           $sisa_pembayaran = stringdoang($_POST['sisa_pembayaran']);
           $sisa_pembayaran = str_replace(',','.',$sisa_pembayaran);
              if ($sisa_pembayaran == '') {
                $sisa_pembayaran = 0;
              }

           $sisa = stringdoang($_POST['sisa']);
           $sisa = str_replace(',','.',$sisa);
              if ($sisa == '') {
                $sisa = 0;
              }

           $ppn_input = stringdoang($_POST['ppn_input']);
           $cara_bayar = stringdoang($_POST['cara_bayar']);
           $kode_gudang = stringdoang($_POST['kode_gudang']);
           $tanggal_jt = stringdoang($_POST['tanggal_jt']);
           $pembayaran = stringdoang($_POST['pembayaran']);
           $pembayaran = str_replace(',','.',$pembayaran);
              if ($pembayaran == '') {
                $pembayaran = 0;
              }

           $t_total = $total_1 - $potongan;

           $user = $_SESSION['user_name'];
           $_SESSION['no_faktur'] = $no_faktur;

           $tax_persen = stringdoang($_POST['tax_rp']);
           $tax_persen = str_replace(',','.',$tax_persen);
              if ($tax_persen == '') {
                $tax_persen = 0;
              }

           $nomor_suplier = stringdoang($_POST['no_faktur_suplier']);
// PENGAMBILAN DATA YANG DIPOST DARI FORM PEMBELIAN (JADIKAN DILUAR AGAR BISA DIAMBIL SEMUA)





// BAHAN UNTUK JURNAL PENGAMBILAN SETTING AKUN DAN TOTAL TAX DARI DETAIL PEMBELIAN & SUPLIER 

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);

$select_setting_akun = $db->query("SELECT persediaan,pajak,hutang,potongan FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_pembelian WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];
$total_tax = str_replace(',','.',$total_tax);
if ($total_tax == '') {
     $total_tax = 0;
    }
// BAHAN UNTUK JURNAL PENGAMBILAN SETTING AKUN DAN TOTAL TAX DARI DETAIL PEMBELIAN & SUPLIER 


//START PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN LUNAS
        if ($sisa_kredit == 0 ) {

// START QUERY PEMBELIAN LUNAS
  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO pembelian (no_faktur_suplier,no_faktur, kode_gudang, suplier, total, tanggal, jam, user, status, potongan, tax, sisa, cara_bayar,tunai, status_beli_awal, ppn) VALUES (?,?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,'Tunai',?)");
        
        
        
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssssssssssss", 
        $nomor_suplier,$no_faktur, $kode_gudang, $suplier, $total , $tanggal_sekarang, $jam_sekarang, $user, $potongan, $tax_persen, $sisa, $cara_bayar, $pembayaran, $ppn_input);
  //END hubungkan "data" dengan prepared statements
           


 // jalankan query & statment
 $stmt->execute();
    if (!$stmt) {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else {
    
    } 
// tutup statements
// END QUERY PEMBELIAN LUNAS



      
// START QUERY JURNAL PEMBAYARAN LUNAS 
if ($ppn_input == "Non") {

    $persediaan = $total_1;
    $total_akhir = $total;


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");
} 

else if ($ppn_input == "Include") {
//ppn == Include

  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
}

}


else {

//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
}

}



//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$cara_bayar', '0', '$total_akhir', 'Pembelian', '$no_faktur','1', '$user')");

if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$no_faktur','1', '$user')");
}
// END QUERY JURNAL PEMBELIAN LUNAS


}
//END  PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN LUNAS

  
//START PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN HUTANG
        else if ($sisa_kredit != 0)
        
        {
 

// START QUERY PEMBELIAN PEMBAYARAN HUTANG       
  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO pembelian (no_faktur_suplier,no_faktur, kode_gudang, suplier, total, tanggal,tanggal_jt, jam, user, status, potongan, tax, kredit, nilai_kredit, cara_bayar,tunai,status_beli_awal,ppn) VALUES (?,?,?,?,?,?,?,?,?,'Hutang',?,?,?,?,?,?,'Kredit',?)");
        
        
// hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssssssssssssss", 
        $nomor_suplier,$no_faktur, $kode_gudang, $suplier, $total , $tanggal_sekarang, $tanggal_jt, $jam_sekarang, $user, $potongan, $tax_persen, $sisa_kredit, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input);
//END hubungkan "data" dengan prepared statements
       

// jalankan query & statment
 $stmt->execute();
    if (!$stmt) {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else {
    
    } 
// tutup statements

// END QUERY PEMBELIAN PEMBAYARAN HUTANG


// QUERY JURNAL PEMBELIAN HUTANG
if ($ppn_input == "Non") {

    $persediaan = $total_1;
    $total_akhir = $total;

      //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");

echo 1;

    }

else if ($ppn_input == "Include") {
//ppn == Include

  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;


//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
      }

echo 2;

}

else {

//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;
echo 3;  
//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");
if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
      }


}

//HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '0', '$sisa_kredit', 'Pembelian', '$no_faktur','1', '$user')");

     if ($pembayaran > 0 ) 
     
        {
//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$cara_bayar', '0', '$pembayaran', 'Pembelian', '$no_faktur','1', '$user')");
        }


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian  - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$no_faktur','1', '$user')");
}


}

//END  PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN LUNAS


// proses pemindahan data dari tbs -> detail pembelian
    $query = $db->query("SELECT * FROM tbs_pembelian WHERE session_id = '$session_id'");
    while ($data = mysqli_fetch_array($query))
    {

      $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
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
       

        $query2 = "INSERT INTO detail_pembelian (no_faktur, tanggal, jam, waktu, kode_barang, nama_barang, jumlah_barang, asal_satuan, satuan, harga, subtotal, potongan, tax, sisa) 
		VALUES ('$no_faktur','$tanggal_sekarang','$jam_sekarang','$waktu','$data[kode_barang]','$data[nama_barang]','$jumlah_barang', '$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$jumlah_barang')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }
        
    }
// proses pemindahan data dari tbs -> detail pembelian

// memasukan history edit tbs pembelian   
    $history_tbs_pembelian = $db->query("INSERT INTO history_tbs_pembelian (no_faktur,waktu,session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax) SELECT '$no_faktur','$tanggal_sekarang $jam_sekarang',session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax FROM tbs_pembelian  WHERE session_id = '$session_id' ");
//end memasukan history edit tbs pembelian   

// delete tsb pembelian yang sudah di di pindahkan ke detail pemebelian
    $query3 = $db->query("DELETE FROM tbs_pembelian WHERE session_id = '$session_id'");
// delete tsb pembelian yang sudah di di pindahkan ke detail pemebelian



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
//Untuk Memutuskan Koneksi Ke Database

    ?>