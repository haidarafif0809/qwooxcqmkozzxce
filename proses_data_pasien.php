<?php 
  include 'db.php';
  include 'sanitasi.php';

  $jam =  date("H:i:s");
  $tanggal_sekarang = date("Y-m-d");
  $waktu = date("Y-m-d H:i:s");
  $bulan_php = date('m');
  $tahun_php = date('Y');

  $nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));
  $jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));
  $tanggal_lahir = stringdoang(urlencode(tanggal_mysql($_POST['tanggal_lahir'])));
  $umur = stringdoang(urlencode($_POST['umur']));
  $tempat_lahir = stringdoang(urlencode($_POST['tempat_lahir']));
  $alamat_sekarang = stringdoang(urlencode($_POST['alamat_sekarang']));
  $no_ktp = angkadoang(urlencode($_POST['no_ktp']));
  $alamat_ktp = stringdoang(urlencode($_POST['alamat_ktp']));
  $no_hp = angkadoang(urlencode($_POST['no_hp']));
  $status_kawin = stringdoang(urlencode($_POST['status_kawin']));
  $pendidikan_terakhir = stringdoang(urlencode($_POST['pendidikan_terakhir']));
  $agama = stringdoang(urlencode($_POST['agama']));
  $nama_suamiortu = stringdoang(urlencode($_POST['nama_suamiortu']));
  $pekerjaan_suamiortu = stringdoang(urlencode($_POST['pekerjaan_suamiortu']));
  $nama_penanggungjawab = stringdoang(urlencode($_POST['nama_penanggungjawab']));
  $hubungan_dengan_pasien = stringdoang(urlencode($_POST['hubungan_dengan_pasien']));
  $no_hp_penanggung = stringdoang(urlencode($_POST['no_hp_penanggung']));
  $alamat_penanggung = stringdoang(urlencode($_POST['alamat_penanggung']));
  $no_kk = angkadoang(urlencode($_POST['no_kk']));
  $nama_kk = stringdoang(urlencode($_POST['nama_kk']));
  $gol_darah = stringdoang(urlencode($_POST['gol_darah']));
  $penjamin = stringdoang(urlencode($_POST['penjamin']));


//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU UGD
  $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '6' ");
  $data_reg_pasien = mysqli_fetch_array($query_setting_registrasi_pasien );

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?nama_lengkap='.$nama_lengkap.'&jenis_kelamin='.$jenis_kelamin.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&tempat_lahir='.$tempat_lahir.'&alamat_sekarang='.$alamat_sekarang.'&no_ktp='.$no_ktp.'&alamat_ktp='.$alamat_ktp.'&no_hp='.$no_hp.'&status_kawin='.$status_kawin.'&pendidikan_terakhir='.$pendidikan_terakhir.'&agama='.$agama.'&pekerjaan_suamiortu='.$pekerjaan_suamiortu.'&nama_suamiortu='.$nama_suamiortu.'&nama_penanggungjawab='.$nama_penanggungjawab.'&hubungan_dengan_pasien='.$hubungan_dengan_pasien.'&no_hp_penanggung='.$no_hp_penanggung.'&alamat_penanggung='.$alamat_penanggung.'&no_kk='.$no_kk.'&nama_kk='.$nama_kk.'&gol_darah='.$gol_darah.'&penjamin='.$penjamin;

  $file_get = file_get_contents($data_url);

  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=pasien.php">';
  //Untuk Memutuskan Koneksi Ke Database
  mysqli_close($db_pasien);   

?>