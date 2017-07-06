<?php session_start();
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();


$jam = date('H:i:s');
$id_pemeriksaan = stringdoang($_POST['id_periksa']);
$kode_jasa_lab = stringdoang($_POST['kode_jasa_lab']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$analis  = stringdoang($_POST['analis']);
$dokter = stringdoang($_POST['dokter']);
$nama_pasien = stringdoang($_POST['nama_pasien']);
$tipe_barang = stringdoang($_POST['tipe_barang']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$pemeriksaan_keberapa = stringdoang($_POST['pemeriksaan_keberapa']);
$tanggal = stringdoang($_POST['tanggal']);

  //Hapus Jika id sama dengan yang sudah ada di TBS
$query_hapus = $db->query("DELETE FROM tbs_hasil_lab WHERE kode_barang = '$kode_jasa_lab'");


$cek_setting = $db->query("SELECT nama FROM setting_laboratorium WHERE jenis_lab = 'Rawat Inap'");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama']; //jika hasil 1 maka = input hasil baru bayar, jika 0 maka = bayar dulu baru input hasil

if($hasil_setting == '1'){
    //INPUT JASA LABORATORIUM , ANAK DARI HEADER
    $cek_id_pemeriksaan = $db->query("SELECT id,nama,harga_1 FROM jasa_lab WHERE kode_lab = '$kode_jasa_lab'");
    $out = mysqli_fetch_array($cek_id_pemeriksaan);

    $id_jasa_lab = $out['id'];
    $nama_jasa = $out['nama'];
    $harga_jasa = $out['harga_1'];

    $cek_ibu_header = $db->query("SELECT id FROM setup_hasil WHERE nama_pemeriksaan = '$id_jasa_lab'");
    while($out_mother = mysqli_fetch_array($cek_ibu_header)){
      
      $id_mother = $out_mother['id'];

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
          //Insert TBS HASIL LAB

        $insert_anaknya = "INSERT INTO tbs_hasil_lab (satuan_nilai_normal,
        model_hitung,no_rm,no_reg,id_pemeriksaan,nilai_normal_lk,nilai_normal_pr,status_pasien,
        nama_pemeriksaan,id_sub_header,normal_lk2,normal_pr2,kode_barang,
        id_setup_hasil, hasil_pemeriksaan, dokter, analis,tanggal, jam) VALUES 
        ('$drop[satuan_nilai_normal]','$drop[model_hitung]',
        '$no_rm','$no_reg','$drop[nama_pemeriksaan]','$drop[normal_lk]',
        '$drop[normal_pr]','$jenis_penjualan','$nama_jasa_anak','$id_mother',
        '$drop[normal_lk2]','$drop[normal_pr2]','$kode_jasa_lab',
        '$drop[id]','Ada Pengeditan','$dokter','$analis','$tanggal','$jam')";

            if ($db->query($insert_anaknya) === TRUE){
            
            } 
            else{
            echo "Error: " . $insert_anaknya . "<br>" . $db->error;
            }
        }
          //under while 3x
      }
    }
  //INPUT JASA LABORATORIUM , ANAK DARI HEADER
}
else{

}

    //INPUT JASA LABORATORIUM , ANAK DARI HEADER
    $cek_id_pemeriksaan = $db->query("SELECT id,nama,harga_1 FROM jasa_lab WHERE kode_lab = '$kode_jasa_lab'");
    $out = mysqli_fetch_array($cek_id_pemeriksaan);

    $id_jasa_lab = $out['id'];
    $nama_jasa = $out['nama'];
    $harga_jasa = $out['harga_1'];


    //INSERT TBS APS PENJUALAN
    $query_insert_tbs_aps_penjualan = $db->query("INSERT INTO tbs_aps_penjualan (no_reg,kode_jasa,nama_jasa,harga,subtotal,dokter,
      analis,no_periksa_lab_inap,tanggal,jam) VALUES ('$no_reg','$kode_jasa_lab',
      '$nama_jasa','$harga_jasa','$harga_jasa','$dokter','$analis','$pemeriksaan_keberapa','$tanggal','$jam')");

    //INSERT TBS PENJUALAN
    $query_insert_tbs_penjualan = $db->query("INSERT INTO tbs_penjualan 
      (no_reg,kode_barang,nama_barang,harga,subtotal,lab_ke_berapa,tanggal,jam,jumlah_barang, tipe_barang,lab,status_lab) VALUES ('$no_reg','$kode_jasa_lab','$nama_jasa',
      '$harga_jasa','$harga_jasa','$pemeriksaan_keberapa','$tanggal','$jam','1','jasa',
      'Laboratorium','edit')");

  // INSERT FEE DOKTER JASA LAB
    $query_fee_jasa_lab = $db->query("SELECT jumlah_prosentase, jumlah_uang FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$kode_jasa_lab'");
    $jumlah__fee_jasa_lab = mysqli_num_rows($query_fee_jasa_lab);
    $data_fee_jasa_lab = mysqli_fetch_array($query_fee_jasa_lab);

    if ($jumlah__fee_jasa_lab > 0){

        if ($data_fee_jasa_lab['jumlah_prosentase'] != 0 AND $data_fee_jasa_lab['jumlah_uang'] == 0 ){

            $hasil_hitung_fee_persen_dokter = $harga_jasa * $data_fee_jasa_lab['jumlah_prosentase'] / 100;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$dokter','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_persen_dokter','$tanggal','$jam')";
                  
                  if ($db->query($insert_dokter) === TRUE) {
                  
                  } 
                  else{
                  echo "Error: " . $insert_dokter . "<br>" . $db->error;
                  }

          }
        else{

            $hasil_hitung_fee_nominal_dokter = $data_fee_jasa_lab['jumlah_uang'] * 1;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$dokter','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_nominal_dokter','$tanggal','$jam')";
              
              if ($db->query($insert_dokter) === TRUE) {          
              } 
              else{
              echo "Error: " . $insert_dokter . "<br>" . $db->error;
              }
          }

    }
   // END INSERT FEE DOKTER JASA LAB


  // INSERT FEE ANALIS JASA LAB
    $query_fee_jasa_lab = $db->query("SELECT jumlah_prosentase, jumlah_uang FROM fee_produk WHERE nama_petugas = '$analis' AND kode_produk = '$kode_jasa_lab'");
    $jumlah__fee_jasa_lab = mysqli_num_rows($query_fee_jasa_lab);
    $data_fee_jasa_lab = mysqli_fetch_array($query_fee_jasa_lab);

    if ($jumlah__fee_jasa_lab > 0){

        if ($data_fee_jasa_lab['jumlah_prosentase'] != 0 AND $data_fee_jasa_lab['jumlah_uang'] == 0 ){

            $hasil_hitung_fee_persen_dokter = $harga_jasa * $data_fee_jasa_lab['jumlah_prosentase'] / 100;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$analis','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_persen_dokter','$tanggal','$jam')";
                  
                  if ($db->query($insert_dokter) === TRUE) {
                  
                  } 
                  else {
                  echo "Error: " . $insert_dokter . "<br>" . $db->error;
                  }

          }
        else{

            $hasil_hitung_fee_nominal_dokter = $data_fee_jasa_lab['jumlah_uang'] * 1;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$analis','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_nominal_dokter','$tanggal','$jam')";
              
              if ($db->query($insert_dokter) === TRUE) {          
              } 
              else{
              echo "Error: " . $insert_dokter . "<br>" . $db->error;
              }
          }

    }
   // END INSERT FEE ANALIS JASA LAB


?>