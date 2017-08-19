<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan_penjualan_golongan.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$golongan = stringdoang($_GET['golongan']);
$penjualan_closing = stringdoang($_GET['closing']);

if ($penjualan_closing == "sudah") {

  $sum_detail_penjualan = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND ( no_faktur != no_reg  OR no_reg IS NULL)");
  $data_detail_penjualan = mysqli_fetch_array($sum_detail_penjualan);
  
  $total_nilai = $data_detail_penjualan['total'];
  $jumlah_produk = $data_detail_penjualan['jumlah'];

}
elseif ($penjualan_closing == "belum") {

  $sum_detail_penjualan = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'  AND no_faktur = no_reg");
  $data_detail_penjualan = mysqli_fetch_array($sum_detail_penjualan);
  
  $total_nilai = $data_detail_penjualan['total'];
  $jumlah_produk = $data_detail_penjualan['jumlah'];

}
else{

  $sum_detail_penjualan = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
  $data_detail_penjualan = mysqli_fetch_array($sum_detail_penjualan);
  
  $total_nilai = $data_detail_penjualan['total'];
  $jumlah_produk = $data_detail_penjualan['jumlah'];

}


?>
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>
 <h3><center>Data Penjualan / Golngan Dari Tanggal <?php echo tanggal_terbalik($dari_tanggal) ?> Sampai Tanggal <?php echo tanggal_terbalik($sampai_tanggal) ?></center></h3>

<center>
 			<table id="tableuser" class="table">				
				<thead>
					<th style='background-color: #4CAF50; color:white'> Nama Produk </th>
					<th style='background-color: #4CAF50; color:white'> Jumlah Produk  </th>
					<th style='background-color: #4CAF50; color:white'> Total Nilai </th>
				</thead>					
	            
	            <tbody>
	            <?php

			              if ($penjualan_closing == "sudah") {
			                
			                $perintah = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total, nama_barang FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND ( no_faktur != no_reg  OR no_reg IS NULL) GROUP BY kode_barang  ORDER BY kode_barang ASC ");
			              }
			              elseif ($penjualan_closing == "belum") {
			                
			                $perintah = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total, nama_barang FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'  AND no_faktur = no_reg GROUP BY kode_barang  ORDER BY kode_barang ASC ");
			              }
			              else{

			                $perintah = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total, nama_barang FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY kode_barang  ORDER BY kode_barang ASC ");
			              }
			                while ($data10 = mysqli_fetch_array($perintah)){
                    
			                    echo "<tr>
			                    <td>". $data10['nama_barang'] ."</td>
			                    <td align='right'>". $data10['jumlah'] ."</td>
			                    <td align='right'>". $data10['total'] ."</td>
			                    </tr>";
			                }

			                    echo "<tr>
			                    <td style=' color:red'> TOTAL </td>
			                    <td style=' color:red' align='right'>".$jumlah_produk."</td>
			                    <td style=' color:red' align='right'>".$total_nilai."</td>
			                    </tr>";


			                        //Untuk Memutuskan Koneksi Ke Database
			                   mysqli_close($db); 
	        

	        
	            ?>
	            </tbody>
            </table>
</center>
