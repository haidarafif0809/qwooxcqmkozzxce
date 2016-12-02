<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_excel_limit_stok.xls");

include 'db.php';
include 'sanitasi.php';

$filter_limit = angkadoang($_GET['filter_limit']);

$query_filter = $db->query("SELECT * FROM barang WHERE limit_stok <= '$filter_limit'");

?>
<h3><b><center> Data Jumlah Barang Yang Mendakati Limit Stok Dari (<?php echo $filter_limit; ?>)</center></b></h3>

 <table id="table_filter_limit" border="1">

        <!-- membuat nama kolom tabel -->
        <thead>

			<th style='background-color: #4CAF50; color:white'> Kode Barang  </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Tipe </th>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>
			<th style='background-color: #4CAF50; color:white'> Limit Stok </th>
			<th style='background-color: #4CAF50; color:white'> Tipe Barang </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah Barang </th>

</thead>
<tbody>
<?php  

		while($data = mysqli_fetch_array($query_filter))
		{
			
			$out_limit_stok = $data['limit_stok'];
			$hasilnya = $out_limit_stok + $filter_limit;

				// Cek Jumlah Barang Yang Ada
			$select_jumlah = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$data[kode_barang]'");
			$ambil_sisa_barang = mysqli_fetch_array($select_jumlah);
			 $hasil_barang = $ambil_sisa_barang['jumlah_barang'];

		if($hasil_barang < $hasilnya AND $hasil_barang >= '0')
		{
			$take_satuan = $db->query("SELECT id,nama FROM satuan");
			$out_take = mysqli_fetch_array($take_satuan);

			echo "<tr>
			<td>". $data['kode_barang'] ."</td>
			<td>". $data['nama_barang'] ."</td>
			<td>". $data['berkaitan_dgn_stok'] ."</td>";
			if ($data['satuan'] == $out_take['id'])
			{
				echo"<td>". $out_take['nama'] ."</td>";
			}
			else
			{
				echo"<td></td>";

			}
			echo "
			<td>". $data['limit_stok'] ."</td>
			<td>". $data['berkaitan_dgn_stok'] ."</td>";
			// ending dapat sisa barangnya
			echo"<td>". $hasil_barang ."</td>";
			}
			else
			{

			}
			
			
		echo "</tr>";
	
		}
		

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>  