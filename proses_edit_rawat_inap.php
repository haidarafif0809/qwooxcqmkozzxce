<?php include 'session_login.php';
include 'db.php';
include_once 'sanitasi.php';

$query_setting_reg = $db->query("SELECT tampil_ttv,tampil_data_pasien_umum FROM setting_registrasi")->fetch_array();
$token = stringdoang(urlencode($_POST['token']));

$session_id = session_id();

// start data agar tetap masuk 
try {
// First of all, let's begin a transaction
$db->begin_transaction();
// A set of queries; if one fails, an exception should be thrown
// begin data

if ($token == ''){
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{
      $username = $_SESSION['user_name'];

      $ruangan = angkadoang(urlencode($_POST['ruangan']));
      $no_rm = stringdoang(urlencode($_POST['no_rm_lama']));
      $nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));      
      $tempat_lahir = stringdoang(urlencode($_POST['tempat_lahir']));
      $tanggal_lahir = stringdoang(urlencode($_POST['tanggal_lahir']));
      $tanggal_lahir = tanggal_mysql($tanggal_lahir);
      $umur = stringdoang(urlencode($_POST['umur']));
      $alamat_sekarang = stringdoang(urlencode($_POST['alamat_sekarang']));      
      $no_telepon = stringdoang(urlencode($_POST['no_telepon']));      
      $jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));  
      $penjamin = stringdoang(urlencode($_POST['penjamin']));
      $gol_darah = stringdoang(urlencode($_POST['gol_darah']));
      $poli = stringdoang(urlencode($_POST['poli']));
      $dokter = stringdoang(urlencode($_POST['dokter']));
      $kondisi = stringdoang(urlencode($_POST['kondisi']));
      $rujukan = stringdoang(urlencode($_POST['rujukan']));

//JIKA KOLOM DATA PASIEN DI TAMPILKAN, SAAT REGISTRASI PASIEN BARU
if ($query_setting_reg['tampil_data_pasien_umum'] == 1) {

    $no_kk = stringdoang(urlencode($_POST['no_kk']));
    $nama_kk = stringdoang(urlencode($_POST['nama_kk']));
    $status_kawin = stringdoang(urlencode($_POST['status_kawin']));
    $pendidikan_terakhir = stringdoang(urlencode($_POST['pendidikan_terakhir']));
    $agama = stringdoang(urlencode($_POST['agama']));
    $pekerjaan_penanggung = stringdoang(urlencode($_POST['pekerjaan_penanggung']));
    $nama_penanggungjawab = stringdoang(urlencode($_POST['nama_penanggungjawab']));
    $hubungan_dengan_pasien = stringdoang(urlencode($_POST['hubungan_dengan_pasien']));
    $no_hp_penanggung = stringdoang(urlencode($_POST['no_hp_penanggung']));
    $alamat_penanggung = stringdoang(urlencode($_POST['alamat_penanggung']));
    $alamat_ktp = stringdoang(urlencode($_POST['alamat_ktp']));
    $no_ktp = stringdoang(urlencode($_POST['no_ktp']));
    $hubungan_dengan_pasien = stringdoang(urlencode($_POST['hubungan_dengan_pasien']));
    $no_hp_penanggung = stringdoang(urlencode($_POST['no_hp_penanggung']));
}
else{

    $no_kk = "";
    $nama_kk = "";
    $status_kawin = "";
    $pendidikan_terakhir = "";
    $agama = "";
    $pekerjaan_penanggung = "";
    $nama_penanggungjawab = "";
    $hubungan_dengan_pasien = "";
    $no_hp_penanggung = "";
    $alamat_penanggung = "";
    $alamat_ktp = "";
    $no_ktp = "";
    $hubungan_dengan_pasien = "";
    $no_hp_penanggung = "";

}

$alergi = stringdoang(urlencode($_POST['alergi']));
  if ($query_setting_reg['tampil_ttv'] == 1) {
      $sistole_distole = stringdoang(urlencode($_POST['sistole_distole']));
      $respiratory_rate = stringdoang(urlencode($_POST['respiratory_rate']));
      $suhu = stringdoang(urlencode($_POST['suhu']));
      $nadi = stringdoang(urlencode($_POST['nadi']));
      $berat_badan = stringdoang(urlencode($_POST['berat_badan']));
      $tinggi_badan = stringdoang(urlencode($_POST['tinggi_badan']));  }
  else{
      $sistole_distole = "";
      $respiratory_rate = "";
      $suhu = "";
      $nadi = "";
      $berat_badan = "";
      $tinggi_badan = "";
  }

      $group_bed = stringdoang(urlencode($_POST['group_bed']));
      $bed = stringdoang(urlencode($_POST['bed']));
      $perkiraan_menginap = angkadoang(urlencode($_POST['perkiraan_menginap']));
      $surat_jaminan = stringdoang(urlencode($_POST['surat_jaminan']));
      $dokter_penanggung_jawab = stringdoang(urlencode($_POST['dokter_penanggung_jawab']));
      $no_reg = stringdoang(urlencode($_POST['no_reg']));


      $group_bed_lama = stringdoang(urlencode($_POST['group_bed_lama']));
      $bed_lama = stringdoang(urlencode($_POST['bed_lama']));


      $jam =  date("H:i:s");
      $tanggal_sekarang = date("Y-m-d");

      $data_registrasi = $db->query("SELECT nama_pasien FROM registrasi  WHERE jenis_pasien = 'Rawat Inap'  ORDER BY id DESC LIMIT 1 ")->fetch_array();

      if ($data_registrasi['nama_pasien'] == urldecode($nama_lengkap) ){
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
      }
      else{
            // INSERT KE REGISTRASI
            $update_registrasi = $db->prepare("UPDATE registrasi SET  alergi = ? ,rujukan = ? ,nama_pasien = ? ,penjamin = ? ,no_rm = ?, kondisi = ? ,petugas = ? ,alamat_pasien = ?,umur_pasien = ? ,hp_pasien = ? ,bed = ?,group_bed = ?,menginap = ? ,dokter = ? ,dokter_pengirim = ? ,penanggung_jawab = ? , alamat_penanggung_jawab = ? ,hp_penanggung_jawab = ? ,pekerjaan_penanggung_jawab = ? ,hubungan_dengan_pasien = ? , jenis_kelamin = ? ,poli = ?, ruangan = ? WHERE no_reg = ? ");

            $update_registrasi->bind_param("ssssssssssssssssssssssis",urldecode($alergi),urldecode($rujukan),urldecode($nama_lengkap),urldecode($penjamin),urldecode($no_rm),urldecode($kondisi),urldecode($username),urldecode($alamat_sekarang),urldecode($umur),urldecode($no_telepon),urldecode($bed),urldecode($group_bed),urldecode($perkiraan_menginap),urldecode($dokter),urldecode($dokter_penanggung_jawab),urldecode($nama_penanggungjawab),urldecode($alamat_penanggung),urldecode($no_hp_penanggung),urldecode($pekerjaan_penanggung),urldecode($hubungan_dengan_pasien),urldecode($jenis_kelamin),urldecode($poli),urldecode($ruangan),urldecode($no_reg));

            $update_registrasi->execute();


            $update_rekam_medik = $db->prepare("UPDATE rekam_medik_inap SET group_bed = ? , alergi = ? , no_rm = ? , nama = ? ,alamat = ? ,umur = ? ,jenis_kelamin = ? ,sistole_distole = ? ,suhu = ? ,berat_badan = ? ,tinggi_badan = ? ,nadi = ? ,
            respiratory = ? ,poli = ? , dokter = ? ,kondisi = ? ,rujukan = ? , dokter_penanggung_jawab = ? , bed = ?, ruangan = ? WHERE no_reg = ?");

            $update_rekam_medik->bind_param("sssssssssssssssssssis", urldecode($group_bed),urldecode($alergi),urldecode($no_rm),urldecode($nama_lengkap),urldecode($alamat_sekarang),urldecode($umur),urldecode($jenis_kelamin),urldecode($sistole_distole),urldecode($suhu),urldecode($berat_badan),urldecode($tinggi_badan),urldecode($nadi),urldecode($respiratory_rate),urldecode($poli),urldecode($dokter),urldecode($kondisi),urldecode($rujukan),urldecode($dokter_penanggung_jawab),urldecode($bed),urldecode($ruangan),urldecode($no_reg));


            $update_rekam_medik->execute();

          //SELECT UNTUK MENGAMBIL SETTING URL U/ EDIT DATA PASIEN RI
            $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '9' ")->fetch_array();


          //PROSES UPDATE PASIEN KE DB ONLINE
            $url = $query_setting_registrasi_pasien['url_data_pasien'];
            $data_url = $url.'?umur='.$umur.'&no_telepon='.$no_telepon.'&alamat_sekarang='.$alamat_sekarang.'&penjamin='.$penjamin.'&nama_lengkap='.$nama_lengkap.'&tempat_lahir='.$tempat_lahir.'&no_rm='.$no_rm;

            $file_get = file_get_contents($data_url);


            // UPDATE KAMAR
            $query = $db->query("UPDATE bed SET sisa_bed = sisa_bed + 1 WHERE nama_kamar = '".urldecode($bed_lama)."' AND group_bed = '".urldecode($group_bed_lama)."'");
            // END UPDATE KAMAR


            // UPDATE KAMAR
            $query43 = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '".urldecode($bed)."' AND group_bed = '".urldecode($group_bed)."'");
            // END UPDATE KAMAR


            // ambil bahan untuk kamar 
            $ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'HARI' ")->fetch_array();
            $satuan_bed = $ambil_satuan['id'];


            $query_penjamin = $db->query(" SELECT harga FROM penjamin WHERE nama = '".urldecode($penjamin)."'")->fetch_array();
            $level_harga = $query_penjamin['harga'];

            $cari_harga_kamar = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '".urldecode($bed)."' AND group_bed = '".urldecode($group_bed)."' ");
            $kamar_luar = mysqli_fetch_array($cari_harga_kamar);
            $harga_kamar1 = $kamar_luar['tarif'];
            $harga_kamar2 = $kamar_luar['tarif_2'];
            $harga_kamar3 = $kamar_luar['tarif_3'];
            $harga_kamar4 = $kamar_luar['tarif_4'];
            $harga_kamar5 = $kamar_luar['tarif_5'];
            $harga_kamar6 = $kamar_luar['tarif_6'];
            $harga_kamar7 = $kamar_luar['tarif_7'];

            //end bahan untuk kamar


            $query_set_kamar = $db->query(" SELECT proses_kamar FROM setting_kamar ");
            $data_sett_kamar  = mysqli_fetch_array($query_set_kamar);


                if ($data_sett_kamar['proses_kamar'] == 1)
                {


                    if ($level_harga == 'harga_1') {
                      $subtotal = $perkiraan_menginap * $harga_kamar1;
                    }
                    else if ($level_harga == 'harga_2') {
                      $subtotal = $perkiraan_menginap * $harga_kamar2;
                    }
                    else if ($level_harga == 'harga_3') {
                      $subtotal = $perkiraan_menginap * $harga_kamar3;
                    }
                    else if ($level_harga == 'harga_4') {
                      $subtotal = $perkiraan_menginap * $harga_kamar4;
                    }
                    else if ($level_harga == 'harga_5') {
                      $subtotal = $perkiraan_menginap * $harga_kamar5;
                    }
                    else if ($level_harga == 'harga_6') {
                      $subtotal = $perkiraan_menginap * $harga_kamar6;
                    }
                    else if ($level_harga == 'harga_7') {
                      $subtotal = $perkiraan_menginap * $harga_kamar7;
                    }

                    $query_insert_tbs_penjualan = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal,ruangan)
                     VALUES ('$session_id','".urldecode($no_reg)."','".urldecode($bed)."','".urldecode($group_bed)."','".urldecode($perkiraan_menginap)."','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang','".urldecode($ruangan)."')";
                          if ($db->query($query_insert_tbs_penjualan) === TRUE) {
                      
                          } 
                          else {
                            echo "Error: " . $query_insert_tbs_penjualan . "<br>" . $db->error;
                          }
                }


      } // biar gak double pasiennya
} // token

  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';


// Countinue data 
   // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 

mysqli_close($db);


?>
<!---->