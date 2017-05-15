<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


$query_detail_penjualan = $db->query("SELECT no_faktur FROM penjualan WHERE dari_tanggal >= '$dari_tanggal' AND sampai_tanggal <= '$sampai_tanggal' ");
while($data_detail_penjualan = mysqli_fetch_array($query_detail_penjualan)){

$query_barang_tipe_produk = $db->query("SELECT dp.kode_barang,dp.jumlah_barang,dp.no_faktur,dp.tanggal,dp.jam FROM barang bb INNER JOIN detail_penjualan dp ON bb.kode_barang = dp.kode_barang WHERE dp.no_faktur = '$data_detail_penjualan[no_faktur]' AND bb.berkaitan_dgn_stok = 'Barang' ");
while($data_barang_tipe_produk = mysqli_fetch_array($query_barang_tipe_produk)){

$jumlah_hpp_masuk		= "";	
$no_faktur_hpp_masukk	= "";
$sisa_harga_hppmasuk	= "";
$jumlah_r = $data_barang_tipe_produk['jumlah_barang'];

 $query_barang_tipe_produk = $db->query("SELECT hm.jumlah_kuantitas - IFNULL(SUM(hk.jumlah_kuantitas),0) AS sisa_hpp, hm.no_faktur, hm.sisa_harga INTO jumlah_hpp_masuk,no_faktur_hpp_masukk, sisa_harga_hppmasuk FROM hpp_masuk hm LEFT JOIN hpp_keluar hk ON hk.kode_barang = hm.kode_barang AND hm.no_faktur = hk.no_faktur_hpp_masuk WHERE hm.kode_barang = '$data_barang_tipe_produk[kode_barang]' GROUP BY hm.id HAVING sisa_hpp > 0 ORDER BY hm.tanggal,hm.jam ASC LIMIT 1");


        if($jumlah_r == $jumlah_hpp_masuk){

		$jumlah_r = 0; 

      $insert_hpp_keluar_jika_jumlah_sama = $db->query("INSERT INTO hpp_keluar (no_faktur,no_faktur_hpp_masuk,kode_barang,jenis_transaksi,jumlah_kuantitas,harga_unit,total_nilai,tanggal,jam,sisa_barang,waktu) VALUES ('$data_barang_tipe_produk[no_faktur]','$no_faktur_hpp_masukk','$data_barang_tipe_produk[kode_barang]','Penjualan',$jumlah_r,'','',$data_barang_tipe_produk[tanggal],$data_barang_tipe_produk[jam],$jumlah_r,'$data_barang_tipe_produk[tanggal].''.$data_barang_tipe_produk[jam]')");

		}

        elseif ($jumlah_r > $jumlah_hpp_masuk){

	$jumlah_r = $jumlah_r - $jumlah_hpp_masuk; 


 	$insert_hpp_keluar_jika_jumlah_r_lebih_dari_jumlah_hpp_masuk = $db->query("INSERT INTO hpp_keluar (no_faktur,no_faktur_hpp_masuk,kode_barang,jenis_transaksi,jumlah_kuantitas,harga_unit,total_nilai,tanggal,jam,sisa_barang,waktu) VALUES ('$data_barang_tipe_produk[no_faktur]','$no_faktur_hpp_masukk','$data_barang_tipe_produk[kode_barang]','Penjualan',$jumlah_hpp_masuk,'','',$data_barang_tipe_produk[tanggal],$data_barang_tipe_produk[jam],$jumlah_hpp_masuk,'$data_barang_tipe_produk[tanggal].''.$data_barang_tipe_produk[jam]')");
      

		}

         elseif ($jumlah_r < $jumlah_hpp_masuk){


          $jumlah_r = 0;


	$insert_hpp_keluar_jika_jumlah_r_kurang_dari_jumlah_hpp_masuk = $db->query("INSERT INTO hpp_keluar (no_faktur,no_faktur_hpp_masuk,kode_barang,jenis_transaksi,jumlah_kuantitas,harga_unit,total_nilai,tanggal,jam,sisa_barang,waktu) VALUES ($data_barang_tipe_produk[no_faktur]','$no_faktur_hpp_masukk','$data_barang_tipe_produk[kode_barang]','Penjualan',$jumlah_r,'','',$data_barang_tipe_produk[tanggal],$data_barang_tipe_produk[jam],$jumlah_r,'$data_barang_tipe_produk[tanggal].''.$data_barang_tipe_produk[jam]')"); 

     
          }

}

}

?>