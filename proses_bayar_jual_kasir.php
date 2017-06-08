<?php include 'session_login.php';
include 'db.php';
include_once 'sanitasi.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date("Y-m-d H:i:s");

try {

$total = angkadoang($_POST['total']);
$potongan = angkadoang($_POST['potongan']);
$biaya_admin = angkadoang($_POST['biaya_adm']);
$no_reg = stringdoang($_POST['no_reg']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg'");
 $data = mysqli_fetch_array($query);
 $total_ss = $data['total_penjualan'];

 $sum_harga = $db->query("SELECT SUM(subtotal) AS harga_radiologi FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1' AND no_faktur IS NULL");
 $data_radiologi= mysqli_fetch_array($sum_harga);


$total_tbs = ($total_ss - $potongan) + $biaya_admin + $data_radiologi['harga_radiologi'];

if ($total != $total_tbs) {
    echo 1;
  }
  else{
  
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

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
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

  

 $session_id = session_id();

$no_rm = stringdoang($_POST['no_rm']);
$ber_stok = stringdoang($_POST['ber_stok']);
$tanggal_jt = tanggal_mysql($_POST['tanggal_jt']);
$nama_petugas = stringdoang($_SESSION['nama']);
$kode_gudang = stringdoang($_POST['kode_gudang']);
$ppn_input = stringdoang($_POST['ppn_input']);
$penjamin = stringdoang($_POST['penjamin']);
$nama_pasien = stringdoang($_POST['nama_pasien']);
$analis = stringdoang($_POST['analis']);

    $petugas_kasir = stringdoang($_POST['petugas_kasir']);
    $id_user = stringdoang($_POST['id_user']);
    $petugas_paramedik = stringdoang($_POST['petugas_paramedik']);
    $petugas_farmasi = stringdoang($_POST['petugas_farmasi']);
    $petugas_lain = stringdoang($_POST['petugas_lain']);
    $dokter = stringdoang($_POST['dokter']);

$keterangan = stringdoang($_POST['keterangan']);
$total2 = angkadoang($_POST['total2']);
$harga = angkadoang($_POST['harga']);
/*
$tax = angkadoang($_POST['tax']);
*/

$sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
$sisa_kredit = angkadoang($_POST['kredit']);
$sisa = angkadoang($_POST['sisa']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$no_jurnal = no_jurnal();



    $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    // petugas analis
    $fee_kasir = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$analis'");
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

       // petugas kasir
    $fee_kasir = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$id_user'");
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
    $fee_paramedik = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_paramedik'");
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
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$nominal_farmasi', '$tanggal_sekarang', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosetase_farmasi != 0) {


     
      $fee_prosentase = $prosetase_farmasi * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_farmasi[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }
    
    // petugas lain
    $fee_lain = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$petugas_lain'");
    $data_fee_lain = mysqli_fetch_array($fee_lain);
    $nominal_lain = $data_fee_lain['jumlah_uang'];
    $prosentase_lain = $data_fee_lain['jumlah_prosentase'];

    if ($nominal_lain != 0) {
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$nominal_lain', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_lain != 0) {


     
      $fee_prosentase = $prosentase_lain * $total / 100;
      
      $fee_lain = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_lain[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }

    
    //dokter
    $fee_dokter = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$dokter'");
    $data_fee_dokter = mysqli_fetch_array($fee_dokter);
    $nominal_dokter = $data_fee_dokter['jumlah_uang'];
    $prosentase_dokter = $data_fee_dokter['jumlah_prosentase'];


    if ($nominal_dokter != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar, no_rm, no_reg) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$nominal_dokter', '$tanggal_sekarang', '$jam_sekarang', '', '$no_rm', '$no_reg')");

    }

    elseif ($prosentase_dokter != 0) {


     
      $fee_prosentase = $prosentase_dokter * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_dokter[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");
      
    }

    // FEE FAKTUR FEE FAKTUR FEE FAKTUR FEE FAKTUR FEE FAKTUR FEE FAKTUR 

    // FEE PRODUK FEE PRODUK FEE PRODUK FEE PRODUK FEE PRODUK FEE PRODUK 

     // petugas analis
              
    $fee_produk_ksir = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg = '$no_reg'");
   while  ($data_fee_produk = mysqli_fetch_array($fee_produk_ksir)){


          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$data_fee_produk[nama_petugas]', '$no_faktur', '$data_fee_produk[kode_produk]', '$data_fee_produk[nama_produk]', '$data_fee_produk[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang', '$no_rm', '$no_reg')");


    }



$hapus_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");

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
        
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, no_reg, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,tipe_produk,lab, dosis) VALUES ('$no_faktur','$no_rm', '$no_reg', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang','$data[tipe_barang]','$data[lab]','$data[dosis]')";


        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }

        
      }

//INSERT DARI TBS PENJUALAN RADIOLOGI KE HASIL PEMERIKSAAN RADIOLOGI
        $insert_hasil_radiologi = "INSERT INTO hasil_pemeriksaan_radiologi (no_faktur, no_reg, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, foto, tipe_barang, tanggal, jam, radiologi, kontras, dokter_pengirim, dokter_pelaksana, dokter_periksa, status_periksa, status_simpan, keterangan) SELECT '$no_faktur', no_reg, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, foto, tipe_barang, tanggal, jam, radiologi, kontras, dokter_pengirim, dokter_pelaksana, dokter_periksa, status_periksa, status_simpan, keterangan FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' ";

          if ($db->query($insert_hasil_radiologi) === TRUE) {
          
            }

          else {
              echo "Error: " . $insert_hasil_radiologi . "<br>" . $db->error;
            }

//INSERT DARI TBS PENJUALAN RADIOLOGI KE HASIL PEMERIKSAAN RADIOLOGI



// START INSERT KE HASIL LABORATORIUM
$cek_lab = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg'");
$out_lab = mysqli_num_rows($cek_lab);
if($out_lab > 0 ){
  //Insert Data Pemeriksaannya 
  $query_insert_data_periksa = "INSERT INTO pemeriksaan_laboratorium 
  (no_reg,no_rm,waktu,status,nama_pasien,status_pasien) VALUES 
  ('$no_reg','$no_rm','$waktu','1','$nama_pasien','Rawat Jalan')";
    if ($db->query($query_insert_data_periksa) === TRUE){

    }
    else{
      echo "Error: " . $query_insert_data_periksa . "<br>" . $db->error;
      }

  //Update no faktur di hasil labortoriumnya
  $update_hasilnya = $db->query("UPDATE hasil_lab SET no_faktur = '$no_faktur' WHERE no_reg = '$no_reg'");

}
else
{
  // Cek dulu setting, jika tidak di hubungkan akan jalankan ini
  $cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
  $get = mysqli_fetch_array($cek_setting);
  $hasil = $get['nama'];
  if($hasil == 0){

    //ambil di tbs penjualan jasa labnya
    $taked_tbs = $db->query("SELECT kode_barang,nama_barang FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium'");
    while ($out_tbs = mysqli_fetch_array($taked_tbs))
    {
      //cek ID jasa laboratoriumnya
        $cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$out_tbs[kode_barang]'");
        $out = mysqli_fetch_array($cek_id_pemeriksaan);
        $id_pemeriksaan = $out['id'];

      //SELECT UNTUK CEK JASA INDUX, JIKA JASA INDUX JANGAN DI INSERT KE HASIL !!
        $cek_indux_or_no = $db->query("SELECT nama_pemeriksaan FROM setup_hasil WHERE nama_pemeriksaan = '$id_pemeriksaan' AND kategori_index = 'Header'");
        $out_bukan_indux = mysqli_fetch_array($cek_indux_or_no);
        $id_indux = $out_bukan_indux['nama_pemeriksaan'];

        if($id_indux == $id_pemeriksaan){

        }
        else
        {
        
        $cek_hasil = $db->query("SELECT id,normal_lk2,normal_pr2,normal_lk,
        normal_pr,model_hitung,satuan_nilai_normal FROM setup_hasil 
        WHERE nama_pemeriksaan = '$id_pemeriksaan'");
        $out_hasil = mysqli_fetch_array($cek_hasil);
        $hasil_pria = $out_hasil['normal_lk'];
        $hasil_wanita = $out_hasil['normal_pr'];
        $model_hitung = $out_hasil['model_hitung'];
        $satuan_nilai_normal = $out_hasil['satuan_nilai_normal'];

        $id_subnya = $out_hasil['id'];
        $hasil_pria2 = $out_hasil['normal_lk2'];
        $hasil_wanita2 = $out_hasil['normal_pr2'];
          //Select untuk Data yang sudah di input kan hasilnya tidak di insert dan tidak di DELETE (TIDAK DI DELETE SUDAH ADA DI ATAS)
        $get_data = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE id_pemeriksaan = '$id_pemeriksaan' AND hasil_pemeriksaan != '' AND no_reg = '$no_reg'");
        $out_data = mysqli_num_rows($get_data);
        $out_data_id = mysqli_fetch_array($get_data);

        $datanya = $out_data_id['id_pemeriksaan'];

        if($out_data > 0 AND $datanya != ''){

        }
        else{
        $insert_on = $db->query("INSERT INTO hasil_lab (satuan_nilai_normal,model_hitung,no_faktur, id_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_pasien,nama_pemeriksaan, nama_pasien, status,no_rm,no_reg,kode_barang,nilai_normal_lk2,nilai_normal_pr2) VALUES 
          ('$satuan_nilai_normal','$model_hitung','$no_faktur','$id_pemeriksaan',
          '$hasil_pria','$hasil_wanita','Rawat Jalan','$out_tbs[nama_barang]',
          '$nama_pasien','Unfinish','$no_rm','$no_reg','$out_tbs[kode_barang]',
          '$hasil_pria2','$hasil_wanita2')");
      
       


        } 
      }
    }

//selesai untuk yang tidak memiliki Header / Ibu
//NOTE* BAGIAN ATAS INSERT DARI TBS , DAN BAGIAN BAWAH INSERT DETAIL YANG INDUX (HEADER)-NYA ADA DI TBS PENJUALAN !!

//START Proses untuk input Header and Detail Jasa Laboratorium
//Ambil setup hasil yang nama pemeriksaaannya (id) sama dengan id di jasa_lab dan di setup hasilnya Header (Indux)
$perintah = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium'");
while($data = mysqli_fetch_array($perintah)){

  $kode_barang = $data['kode_barang'];

  $cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$kode_barang'");
  $out = mysqli_fetch_array($cek_id_pemeriksaan);
  $id_jasa_lab = $out['id'];

  $cek_ibu_header = $db->query("SELECT id FROM setup_hasil WHERE nama_pemeriksaan = '$id_jasa_lab'");
  while($out_mother = mysqli_fetch_array($cek_ibu_header)){
  $id_mother = $out_mother['id'];

//DI EDIT YANG WHILE INI QUERY SALAH !!!!!!
  $select_detail_anaknya = $db->query("SELECT * FROM setup_hasil WHERE sub_hasil_lab = '$id_mother'");
  while($drop = mysqli_fetch_array($select_detail_anaknya)){
  $ambil_nama_jasa = $db->query("SELECT nama FROM jasa_lab WHERE id = '$drop[nama_pemeriksaan]'");
  $get = mysqli_fetch_array($ambil_nama_jasa);
  $nama_jasa_anak = $get['nama'];
  
//Select untuk Data yang sudah di input kan hasilnya tidak di insert dan tidak di DELETE (TIDAK DI DELETE SUDAH ADA DI ATAS)
  $get_data = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE id_pemeriksaan = '$drop[nama_pemeriksaan]' AND hasil_pemeriksaan != '' AND no_reg = '$no_reg'");
  $out_data = mysqli_num_rows($get_data);
  $out_data_id = mysqli_fetch_array($get_data);

  $datanya = $out_data_id['id_pemeriksaan'];

  if($out_data > 0 AND $datanya != ''){

  }
  else{

  $insert_anaknya = "INSERT INTO hasil_lab (no_faktur,satuan_nilai_normal,
  model_hitung,no_rm,no_reg,id_pemeriksaan,nilai_normal_lk,nilai_normal_pr,status_pasien,nama_pemeriksaan,id_sub_header,nilai_normal_lk2,nilai_normal_pr2,kode_barang,status,nama_pasien) VALUES ('$no_faktur','$drop[satuan_nilai_normal]','$drop[model_hitung]',
  '$no_rm','$no_reg','$drop[nama_pemeriksaan]','$drop[normal_lk]',
  '$drop[normal_pr]','$jenis_penjualan','$nama_jasa_anak','$id_mother',
  '$drop[normal_lk2]','$drop[normal_pr2]','$kode_barang','Unfinish','$nama_pasien')";

      if ($db->query($insert_anaknya) === TRUE)
      {
      
      } 
      else 
      {
      echo "Error: " . $insert_anaknya . "<br>" . $db->error;
      }
    }
    //under while 3x
  }
 }
}
   $delete_tbs_hasil_lab = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");
   
  }// end if setting lab
} // else jika setting nya bayar dulu baru input hasil
//Ending Proses untuk input Header and Detail Jasa Laboratorium
// ENDING INSERT KE HASIL LABORATORIUM

    $sisa = angkadoang($_POST['sisa']);
    $sisa_kredit = angkadoang($_POST['kredit']);
                $pembayaran = angkadoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $tunai_i = $pembayaran - $total;

          if ($tunai_i >= 0) 

            {
              $ket_jurnal = "Penjualan ".$jenis_penjualan." Lunas ".$ambil_kode_pelanggan['nama_pelanggan']." ";

              $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, no_reg, penjamin, apoteker, perawat, petugas_lain, dokter, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, /*tax,*/ sisa, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,nama,biaya_admin, no_faktur_jurnal, keterangan_jurnal,
                kredit, nilai_kredit) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Lunas',?,/*?,*/?,?,?,'Tunai',?,?,?,?,?,?,?,'0','0')");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssissssiisisssssss",
              $no_faktur,$no_reg,$penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $nama_petugas, $petugas_kasir, $potongan, /*$tax,*/ $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$jenis_penjualan,$nama_pasien,$biaya_admin,$no_jurnal,$ket_jurnal);
 

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


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '$no_reg' ");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);


$biaya_admin = angkadoang($_POST['biaya_adm']);

            
              
}



              else if ($tunai_i != 0)
              
            {

                $kredit_s = $total - $pembayaran;

              $ket_jurnal = "Penjualan ".$jenis_penjualan." Piutang ".$ambil_kode_pelanggan['nama_pelanggan']." ";
                
               $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, no_reg, penjamin, apoteker, perawat, petugas_lain, dokter, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan,/* tax,*/ kredit,nilai_kredit,cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,nama,tanggal_jt,biaya_admin, no_faktur_jurnal, keterangan_jurnal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Piutang',?/*,?*/,?,?,?,?,'Kredit',?,?,?,?,?,?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssissssiiisissssssss",
              $no_faktur,$no_reg,$penjamin,$petugas_farmasi, $petugas_paramedik, $petugas_lain, $dokter, $kode_gudang, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $nama_petugas, $petugas_kasir, $potongan, /*$tax, */ $kredit_s, $kredit_s, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$jenis_penjualan,$nama_pasien,$tanggal_jt,$biaya_admin,$no_jurnal,$ket_jurnal);
 

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


            $sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '$no_reg' ");
            $jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
            $total_tax = $jumlah_tax['total_tax'];

            $ppn_input = stringdoang($_POST['ppn_input']);
            $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
            $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);




            $pembayaran = stringdoang($_POST['pembayaran']);
            $total = stringdoang($_POST['total']);
            $piutang_1 = $total - $pembayaran;

   
}



// coding untuk memasukan history_tbs dan menghapus tbs
    $tbs_penjualan_masuk = "INSERT INTO history_tbs_penjualan (no_reg,no_faktur,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax,session_id,satuan,dosis) SELECT no_reg,'$no_faktur',kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax,session_id,satuan,dosis FROM tbs_penjualan WHERE no_reg = '$no_reg' ";
        if ($db->query($tbs_penjualan_masuk) === TRUE) {
              
        }
        else{
            echo "Error: " . $tbs_penjualan_masuk . "<br>" . $db->error;
        }

    $tbs_fee_masuk = " INSERT INTO history_tbs_fee_produk 
      (no_reg,no_faktur,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) SELECT no_reg,'$no_faktur',no_rm,nama_petugas,kode_produk,
      nama_produk,jumlah_fee,tanggal,jam,waktu,session_id FROM tbs_fee_produk WHERE no_reg = '$no_reg'";
        if ($db->query($tbs_fee_masuk) === TRUE) {
              
        }
        else{
            echo "Error: " . $tbs_fee_masuk . "<br>" . $db->error;
        }



    $update_registrasi = $db->query("UPDATE registrasi SET status = 'Sudah Pulang' WHERE no_reg ='$no_reg'");




    $tbs_penjualan_hapus = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
    $tbs_penjualan_radiologi_hapus = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' ");
    $tbs_fee_hapus = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");
// end coding untuk memasukan history_tbs dan menghapus tbs


}// braket if cek subtotal penjualan


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