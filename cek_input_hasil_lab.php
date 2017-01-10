<?php 
include 'sanitasi.php';
include 'db.php';

$nama = stringdoang($_GET['nama']);
$no_rm = stringdoang($_GET['no_rm']);
$no_reg = stringdoang($_GET['no_reg']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);


$perintah3 = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0)
{
      $perintah2 = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg' ");
}

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT kode_barang,nama_barang FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium'");
while ($data = mysqli_fetch_array($perintah)){

$kode_barang = $data['kode_barang'];
$nama_barang = $data['nama_barang'];

$cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$kode_barang'");
$out = mysqli_fetch_array($cek_id_pemeriksaan);
$id_pemeriksaan = $out['id'];

$cek_hasil = $db->query("SELECT normal_lk,normal_pr FROM setup_hasil WHERE nama_pemeriksaan = '$id_pemeriksaan'");
$out_hasil = mysqli_fetch_array($cek_hasil);
$hasil_pria = $out_hasil['normal_lk'];
$hasil_wanita = $out_hasil['normal_pr'];

$query6 = "INSERT INTO tbs_hasil_lab (no_rm,no_reg,id_pemeriksaan, nilai_normal_lk,nilai_normal_pr,status_pasien,
nama_pemeriksaan) VALUES ('$no_rm','$no_reg','$id_pemeriksaan','$hasil_pria','$hasil_wanita','$jenis_penjualan','$nama_barang')";

      if ($db->query($query6) === TRUE)
      {
      
      } 
      else 
      {
      echo "Error: " . $query6 . "<br>" . $db->error;
      }


}

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=hasil_laboratorium.php?no_rm='.$no_rm.'&no_reg='.$no_reg.'&nama='.$nama.'&jenis_penjualan='.$jenis_penjualan.'">';

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>


