<?php session_start();
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

$jam = date('H:i:s');

$no_faktur = stringdoang($_POST['no_faktur']);
$id_pemeriksaan = stringdoang($_POST['id_periksa']);
$kode_jasa_lab = stringdoang($_POST['kode_jasa_lab']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$analis  = stringdoang($_POST['analis']);
$dokter = stringdoang($_POST['dokter']);
$nama_pasien = stringdoang($_POST['nama_pasien']);
$tipe_barang = stringdoang($_POST['tipe_barang']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$tanggal = stringdoang($_POST['tanggal']);

 
//Hapus Jika id sama dengan yang sudah ada di TBS
$query_hapus = $db->query("DELETE FROM tbs_hasil_lab WHERE kode_barang = '$kode_jasa_lab'");

//Select Detail dari ID Headernya
$query_select_detail = $db->query("SELECT id,nama_pemeriksaan,
  kelompok_pemeriksaan,model_hitung,normal_lk,normal_pr,text_hasil,
  metode,normal_lk2,normal_pr2,text_reference,satuan_nilai_normal,
  sub_hasil_lab,nama_sub FROM setup_hasil WHERE id = 
  '$id_pemeriksaan' AND kategori_index = 'Detail'");
while($data_query_select_detail = mysqli_fetch_array($query_select_detail)){

  //Ambil Nama Jasa
  $query_ambil_nama_jasa = $db->query("SELECT nama,harga_1 FROM jasa_lab WHERE id = '$data_query_select_detail[nama_pemeriksaan]'");
  while($data_nama_jasa = mysqli_fetch_array($query_ambil_nama_jasa)){
  $nama_jasa = $data_nama_jasa['nama'];
  $harga_jasa = $data_nama_jasa['harga_1'];
  
  //INSERT DATA DETAILNYA KE TBS HASIL LAB 
  $query_insert_tbs_hasil = $db->query("INSERT INTO tbs_hasil_lab
    (id_pemeriksaan, no_reg, no_rm, kode_barang, status_pasien,
    nilai_normal_lk,nilai_normal_pr,normal_lk2,normal_pr2,
    nama_pemeriksaan,model_hitung,satuan_nilai_normal,id_sub_header,
    id_setup_hasil,tanggal,jam,dokter,analis,harga,hasil_pemeriksaan,no_faktur) VALUES 
    ('$data_query_select_detail[nama_pemeriksaan]',
    '$no_reg','$no_rm','$kode_jasa_lab','APS',
    '$data_query_select_detail[normal_lk]',
    '$data_query_select_detail[normal_pr]',
    '$data_query_select_detail[normal_lk2]',
    '$data_query_select_detail[normal_pr2]',
    '$nama_jasa','$data_query_select_detail[model_hitung]',
    '$data_query_select_detail[satuan_nilai_normal]',
    '$data_query_select_detail[sub_hasil_lab]',
    '$data_query_select_detail[id]','$tanggal','$jam','$dokter',
    '$analis','$harga_jasa','Edit Penjualan APS','$no_faktur')");

    //INSERT TBS APS PENJUALAN
    $query_insert_tbs_aps_penjualan = $db->query("INSERT INTO tbs_aps_penjualan (no_faktur,no_reg,kode_jasa,nama_jasa,
      harga,dokter,analis,tanggal,jam) VALUES ('$no_faktur','$no_reg','$kode_jasa_lab',
      '$nama_jasa','$harga_jasa','$dokter','$analis','$tanggal','$jam')");

      // INSERT FEE DOKTER JASA LAB
    $query_fee_jasa_lab = $db->query("SELECT jumlah_prosentase, jumlah_uang FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$kode_jasa_lab'");
    $jumlah__fee_jasa_lab = mysqli_num_rows($query_fee_jasa_lab);
    $data_fee_jasa_lab = mysqli_fetch_array($query_fee_jasa_lab);

    if ($jumlah__fee_jasa_lab > 0){

        if ($data_fee_jasa_lab['jumlah_prosentase'] != 0 AND $data_fee_jasa_lab['jumlah_uang'] == 0 ){

            $hasil_hitung_fee_persen_dokter = $harga_jasa * $data_fee_jasa_lab['jumlah_prosentase'] / 100;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,no_faktur,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$no_faktur','$no_rm','$dokter','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_persen_dokter','$tanggal','$jam')";
                  
                  if ($db->query($insert_dokter) === TRUE) {
                  
                  } 
                  else 
                  {
                  echo "Error: " . $insert_dokter . "<br>" . $db->error;
                  }

          }
        else{

            $hasil_hitung_fee_nominal_dokter = $data_fee_jasa_lab['jumlah_uang'] * 1;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,no_faktur,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$no_faktur','$no_rm','$dokter','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_nominal_dokter','$tanggal','$jam')";
              
              if ($db->query($insert_dokter) === TRUE) {          
              } 
              else
              {
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
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,no_faktur,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$no_faktur','$no_rm','$analis','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_persen_dokter','$tanggal','$jam')";
                  
                  if ($db->query($insert_dokter) === TRUE) {
                  
                  } 
                  else 
                  {
                  echo "Error: " . $insert_dokter . "<br>" . $db->error;
                  }

          }
        else{

            $hasil_hitung_fee_nominal_dokter = $data_fee_jasa_lab['jumlah_uang'] * 1;
            $insert_dokter = "INSERT INTO tbs_fee_produk (no_reg,no_faktur,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$no_faktur','$no_rm','$analis','$kode_jasa_lab','$nama_jasa','$hasil_hitung_fee_nominal_dokter','$tanggal','$jam')";
              
              if ($db->query($insert_dokter) === TRUE) {          
              } 
              else
              {
              echo "Error: " . $insert_dokter . "<br>" . $db->error;
              }
          }

    }
   // END INSERT FEE ANALIS JASA LAB
  }

}

?>