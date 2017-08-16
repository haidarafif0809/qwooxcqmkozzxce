<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$no_reg = stringdoang($_GET['no_reg']);
$no_rm = stringdoang($_GET['no_rm']);
$id = angkadoang($_GET['id']);

$ambil_penjualan = $db->query("SELECT nama,kode_gudang FROM penjualan WHERE no_faktur = '$no_faktur' ");
$dd = mysqli_fetch_array($ambil_penjualan);


$nama_pasien = $dd['nama'];
$kode_gudang = $dd['kode_gudang'];

$perintah3 = $db->query("SELECT no_faktur, no_reg FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, tipe_produk, tanggal, jam, potongan, tax, hpp, lab, ruangan FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
while ($data = mysqli_fetch_array($perintah)){


 $query6 = "INSERT INTO tbs_penjualan (no_faktur, no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax,hpp,lab, ruangan) VALUES ('$no_faktur','$no_reg','$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[satuan]','$data[harga]','$data[subtotal]','$data[tipe_produk]','$data[tanggal]','$data[jam]','$data[potongan]','$data[tax]','$data[hpp]','$data[lab]','$data[ruangan]')";



      if ($db->query($query6) === TRUE) {
      
      } 
      else 
      {
      echo "Error: " . $query6 . "<br>" . $db->error;
      }


}



$perintah30 = $db->query("SELECT no_reg FROM tbs_fee_produk WHERE  no_reg = '$no_reg' ");
$data10 = mysqli_num_rows($perintah30);

if ($data10 > 0){

$perintah2 = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");
}


$fee_produk = $db->query("SELECT no_faktur, no_reg, no_rm, nama_petugas, kode_produk, nama_produk, jumlah_fee, tanggal, jam FROM laporan_fee_produk WHERE no_reg = '$no_reg' ");
while ($data_fee = mysqli_fetch_array($fee_produk)){

	$barang = $db->query("SELECT kode_barang FROM barang WHERE kode_barang = '$data_fee[kode_produk]' ");
$y = mysqli_num_rows($barang);

if ($y > 0) {

$insert2 = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_fee[no_faktur]','$data_fee[no_reg]','$data_fee[no_rm]','$data_fee[nama_petugas]','$data_fee[kode_produk]','$data_fee[nama_produk]','$data_fee[jumlah_fee]','$data_fee[tanggal]','$data_fee[jam]')";

      if ($db->query($insert2) === TRUE) {
      
      } 
      else 
      {
      echo "Error: " . $insert2 . "<br>" . $db->error;
      }
}	

}

// INSERT OPERASI

$perintah7 = $db->query("SELECT no_reg FROM tbs_operasi WHERE no_reg = '$no_reg' ");
$data17 = mysqli_num_rows($perintah7);

if ($data17 > 0){

$perintah23 = $db->query("DELETE FROM tbs_operasi WHERE no_reg = '$no_reg' ");
}


$fee_hasil_oprs = $db->query("SELECT sub_operasi, petugas_input, harga_jual, operasi, waktu FROM hasil_operasi WHERE no_reg = '$no_reg' ");


while ($data_fee = mysqli_fetch_array($fee_hasil_oprs)){

$insert_operasi = "INSERT INTO tbs_operasi (sub_operasi,petugas_input, no_reg, harga_jual, operasi, waktu) VALUES ('$data_fee[sub_operasi]','$data_fee[petugas_input]', '$no_reg', '$data_fee[harga_jual]', '$data_fee[operasi]', '$data_fee[waktu]')";

        if ($db->query($insert_operasi) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_operasi . "<br>" . $db->error;
        }


}


// IBSERT HASIL DETAIL OPERASI

$perintah8 = $db->query("SELECT no_reg FROM tbs_detail_operasi WHERE no_reg = '$no_reg' ");
$data100 = mysqli_num_rows($perintah8);

if ($data100 > 0){

$perintah239 = $db->query("DELETE FROM tbs_detail_operasi WHERE no_reg = '$no_reg' ");
}

    $detail_ops = $db->query("SELECT id_detail_operasi, id_user, id_sub_operasi, id_operasi, petugas_input, waktu, id_tbs_operasi FROM hasil_detail_operasi WHERE no_reg = '$no_reg'");
    while ($data_detail_ops = mysqli_fetch_array($detail_ops))
      {

        $insert_detail_operasi = "INSERT INTO tbs_detail_operasi (id_detail_operasi,id_user, id_sub_operasi, id_operasi, petugas_input, no_reg, waktu, id_tbs_operasi) VALUES ('$data_detail_ops[id_detail_operasi]','$data_detail_ops[id_user]', '$data_detail_ops[id_sub_operasi]', '$data_detail_ops[id_operasi]', '$data_detail_ops[petugas_input]', '$no_reg', '$data_detail_ops[waktu]', '$data_detail_ops[id_tbs_operasi]')";

        if ($db->query($insert_detail_operasi) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_detail_operasi . "<br>" . $db->error;
        }

      }

	 header ('location:form_edit_penjualan_ri.php?no_faktur='.$no_faktur.'&no_rm='.$no_rm.'&kode_gudang='.$kode_gudang.'&nama_pasien='.$nama_pasien.'&no_reg='.$no_reg.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>


