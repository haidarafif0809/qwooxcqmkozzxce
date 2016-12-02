<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST



       $query =$db->prepare("UPDATE barang SET nama_barang = ?, harga_beli = ?, harga_jual = ?, harga_jual2 = ?, harga_jual3 = ?,harga_jual4 = ?,harga_jual5 = ?,harga_jual6 = ?,harga_jual7 = ?, satuan = ?, gudang = ?, kategori = ?, status = ?,suplier = ?, limit_stok = ?, over_stok = ? , tipe_barang = ?, golongan = ?,berkaitan_dgn_stok = ? ,jenis_barang = ?  WHERE id = ? ");

       $query->bind_param("siiiiiiiiissssiissssi",
        $nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3, $harga_jual_4, $harga_jual_5, $harga_jual_6, $harga_jual_7, $satuan, $gudang, $kategori_obat, $status, $suplier,$limit_stok, $over_stok, $tipe,$golongan_obat,$golongan_produk,$jenis_obat,$id);

           
           $nama_barang = stringdoang($_POST['nama_barang']);
           $harga_jual = angkadoang($_POST['harga_jual']);
           $harga_jual_2 = angkadoang($_POST['harga_jual_2']);
           $harga_jual_3 = angkadoang($_POST['harga_jual_3']);
           $harga_jual_4 = angkadoang($_POST['harga_jual_4']);
           $harga_jual_5 = angkadoang($_POST['harga_jual_5']);
           $harga_jual_6 = angkadoang($_POST['harga_jual_6']);
           $harga_jual_7 = angkadoang($_POST['harga_jual_7']);

           $satuan = stringdoang($_POST['satuan']);
           $status = stringdoang($_POST['status']);
           $suplier = stringdoang($_POST['suplier']);
           $gudang = stringdoang($_POST['gudang']);
           $tipe = stringdoang($_POST['tipe']);
           $id = stringdoang($_POST['id']);
           $golongan_produk = stringdoang($_POST['golongan_produk']);

if($tipe == 'Obat Obatan'){
  
        $golongan_obat = stringdoang($_POST['golongan_obat']);
        $kategori_obat = stringdoang($_POST['kategori_obat']);
        $jenis_obat = stringdoang($_POST['jenis_obat']);
        $harga_beli = angkadoang($_POST['harga_beli']);
        $limit_stok = angkadoang($_POST['limit_stok']);
        $over_stok = angkadoang($_POST['over_stok']);
        }

else if($tipe != 'Obat Obatan' AND $tipe != 'Jasa')
 {

        $golongan_obat = "-";
        $kategori_obat = "-";
        $jenis_obat = "-";
        $harga_beli = angkadoang($_POST['harga_beli']);
        $limit_stok = angkadoang($_POST['limit_stok']);
        $over_stok = angkadoang($_POST['over_stok']);
 }
 else 
 {
  
        $golongan_obat = "-";
        $kategori_obat = "-";
        $jenis_obat = "-";
        $harga_beli = "0";
        $limit_stok = "-";
        $over_stok = "-";
 }

        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang_jasa">';
 }


        
        
       
  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);         




    
    ?>