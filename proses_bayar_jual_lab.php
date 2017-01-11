
<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$session_id = session_id();
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);


try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown

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
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }



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
$dokter = stringdoang($_POST['dokter']);

$apoteker = stringdoang($_POST['apoteker']);
$nama_petugas = stringdoang($_SESSION['nama']);
$petugas = $_SESSION['id'];
$ppn_input = stringdoang($_POST['ppn_input']);
$penjamin = stringdoang($_POST['penjamin']);
$user = $_SESSION['nama'];
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

    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);


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
      
    }



              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$apoteker' AND session_id = '$session_id'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_rm) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang','$no_rm')");


    }// end fee analis


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

              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$petugas' AND session_id = '$session_id'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,no_rm) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang','$no_rm')");


    }
// end fee petugas kasir

  $query = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '' AND lab = 'Laboratorium'");
    while ($data = mysqli_fetch_array($query))
      {
        
$cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$data[kode_barang]'");
$out = mysqli_fetch_array($cek_id_pemeriksaan);
$id_pemeriksaan = $out['id'];

$cek_hasil = $db->query("SELECT normal_lk,normal_pr FROM setup_hasil WHERE nama_pemeriksaan = '$id_pemeriksaan'");
$out_hasil = mysqli_fetch_array($cek_hasil);
$hasil_pria = $out_hasil['normal_lk'];
$hasil_wanita = $out_hasil['normal_pr'];

$insert_on = $db->query("INSERT INTO hasil_lab (no_faktur, id_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_pasien,
nama_pemeriksaan, nama_pasien, status,no_rm,petugas_analis,dokter) VALUES ('$no_faktur','$id_pemeriksaan','$hasil_pria',
'$hasil_wanita','Umum','$data[nama_barang]','$nama_pelanggan','Unfinish','$no_rm','$apoteker','$dokter')");
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, tanggal, jam, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, sisa,tipe_produk,lab) VALUES ('$no_faktur','$no_rm', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]', '$data[jumlah_barang]','$data[tipe_barang]','$data[lab]')";

        if ($db->query($query2) === TRUE){
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
              
              $stmt = $db->prepare("INSERT INTO penjualan (nama, no_faktur, penjamin, analis, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,biaya_admin) VALUES (?,?,?,?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,'Tunai',?,?,'Laboratorium',?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssissssiiisissi",
              $nama_pelanggan, $no_faktur, $penjamin, $apoteker, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $user, $id_kasir, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$biaya_admin);
 

              $pj_total = $total - ($potongan + $tax);


              $_SESSION['no_faktur']=$no_faktur;
              
    // jalankan query
              $stmt->execute();
              
              
    // UPDATE KAS 
              $stmt1 = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");
              
              $stmt1->bind_param("is", 
              $total, $cara_bayar);
              
              // siapkan "data" query
              
              $total = angkadoang($_POST['total']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              
              // jalankan query
              $stmt1->execute();


$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
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
     
              
              
              $stmt = $db->prepare("INSERT INTO penjualan (nama, no_faktur, penjamin, analis, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, sales, status, potongan, tax, kredit, nilai_kredit, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,biaya_admin) VALUES (?,?,?,?,?,?,?,?,?,?,?,'Piutang',?,?,?,?,?,?,'Kredit',?,?,'Laboratorium',?)");
              

              $stmt->bind_param("sssssisssssiiiisisii",
              $nama_pelanggan, $no_faktur, $penjamin, $apoteker, $no_rm, $total , $tanggal_sekarang, $tanggal_jt, $jam_sekarang, $user, $id_kasir, $potongan, $tax, $piutang_1, $piutang_1, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$biaya_admin);

              $pj_total = $total - ($potongan + $tax);

              $_SESSION['no_faktur']=$no_faktur;
              
              // jalankan query
              $stmt->execute();
              
              
              
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    


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
      $ambil_tbs1 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' ORDER BY id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
            $pesanan =  $data12['nama_barang']." - ".$data12['jumlah_barang']." - ".$data12['harga']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE session_id = '$session_id' ORDER BY id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) 
      {
      $pesanan_jadi = $pesanan_jadi."Subtotal : ".$total;
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      

      
      }


     
     
}
*/

    $query3 = $db->query("DELETE FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '' ");
    $query3 = $db->query("DELETE FROM tbs_fee_produk WHERE session_id = '$session_id' AND no_reg = '' AND no_rm = '$no_rm'");


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


