<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_GET['no_faktur']);
$no_rm = stringdoang($_GET['no_rm']);
$id = angkadoang($_GET['id']);

$query_nama_pasien = $db->query("SELECT nama,no_reg FROM penjualan WHERE no_faktur = '$no_faktur' ");
$data_nama_pasien = mysqli_fetch_array($query_nama_pasien);
$nama_pasien = $data_nama_pasien['nama'];
$no_reg = $data_nama_pasien['no_reg'];


//MULAI DATA JASA LABORATORIUM
$query_tbs_aps = $db->query("SELECT no_faktur FROM tbs_aps_penjualan WHERE no_faktur = '$no_faktur'");
$data_tbs_aps = mysqli_num_rows($query_tbs_aps);

if ($data_tbs_aps > 0){
      $query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_faktur = '$no_faktur'");
}
//AKHIR DATA JASA LABORATORIUM

//Mulai Hapus TBS Hasil Laboratorium
$query_cek_tbs_hasil = $db->query("SELECT no_faktur FROM tbs_hasil_lab WHERE no_faktur = '$no_faktur'");
$data_tbs_hasil = mysqli_num_rows($query_cek_tbs_hasil);

if ($data_tbs_hasil > 0){
   $query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_hasil_lab WHERE no_faktur = '$no_faktur'");
}
//Akhir Hapus TBS Hasil Laboratorium

$query_ambil_kode_jasa = $db->query("SELECT kode_barang FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while($data_kode_jasa = mysqli_fetch_array($query_ambil_kode_jasa)){

      $query_kode_hasil = $db->query("SELECT dokter,petugas_analis FROM hasil_lab WHERE kode_barang = '$data_kode_jasa[kode_barang]' AND no_faktur = '$no_faktur'");

      $data_kode_hasil = mysqli_fetch_array($query_kode_hasil);
}
            $query_input_data_tbs_aps = "INSERT INTO tbs_aps_penjualan (no_faktur,kode_jasa,nama_jasa,
            harga,subtotal,tanggal,jam,no_reg,dokter,analis) SELECT '$no_faktur',kode_barang,nama_barang,harga,
            subtotal,tanggal,jam,no_reg,'$data_kode_hasil[dokter]','$data_kode_hasil[petugas_analis]' FROM detail_penjualan
            WHERE no_faktur = '$no_faktur'";

            if ($db->query($query_input_data_tbs_aps) === TRUE){
            } 
            else{
            echo "Error: " . $query_input_data_tbs_aps . "<br>" . $db->error;
            }

      



//AKHIR DATA JASA LABORATORIUM

//MULAI DATA FEE LABORATORIUM
$query_data_fee_produk = $db->query("SELECT * FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' ");
$data_tampil_fee = mysqli_num_rows($query_data_fee_produk);

if ($data_tampil_fee > 0){
      $query_hapus_tbs_fee = $db->query("DELETE FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' ");
}

$query_masuk_tbs_fee = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) SELECT no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam FROM laporan_fee_produk WHERE no_faktur = '$no_faktur'";

      if ($db->query($query_masuk_tbs_fee) === TRUE){
      } 
      else{
      echo "Error: " . $query_masuk_tbs_fee . "<br>" . $db->error;
      }

//AKHIR DATA FEE LABORATORIUM

//INSERT DARI LAPORAN HASIL -> TBS HASIL 
$query_hasil_lab = "INSERT INTO tbs_hasil_lab (id_pemeriksaan, hasil_pemeriksaan, no_faktur,
no_reg, no_rm, status_pasien, nilai_normal_lk, nilai_normal_pr, normal_lk2, normal_pr2, nama_pemeriksaan,
model_hitung, satuan_nilai_normal, id_sub_header, kode_barang, id_setup_hasil, tanggal, jam, dokter,
analis) SELECT id_pemeriksaan,hasil_pemeriksaan, no_faktur, no_reg, no_rm, status_pasien, nilai_normal_lk, nilai_normal_pr, nilai_normal_lk2, nilai_normal_pr2, nama_pemeriksaan, model_hitung, satuan_nilai_normal, id_sub_header, kode_barang, id_setup_hasil, tanggal, jam, dokter, petugas_analis FROM hasil_lab WHERE no_faktur = '$no_faktur'";
      if ($db->query($query_hasil_lab) === TRUE) {
      }
      else{
            echo "Error: " . $query_hasil_lab . "<br>" . $db->error;
      }
//INSERT DARI LAPORAN HASIL -> TBS HASIL

header ('location:form_edit_penjualan_aps.php?no_faktur='.$no_faktur.'&no_rm='.$no_rm.'&nama_pasien='.$nama_pasien.'&no_reg='.$no_reg.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>