<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_stok_opname.xls");

include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);


 ?>


<div class="container">
<center><h3>Data Stok Opname No Faktur <?php echo $no_faktur; ?></h3></center>

<!--Plus-->
    <table id="kartu_stok" class="table table-bordered">
<center><h4>Data Stok Opnama Plus</h4></center>
        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
      <th style='background-color: #4CAF50; color:white'> Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
      <th style='background-color: #4CAF50; color:white'> HPP</th>
      <th style='background-color: #4CAF50; color:white'> Selisih Harga</th>

</thead>
<tbody>

<?php 
$query_plus = $db->query ("SELECT * FROM detail_stok_opname WHERE no_faktur = '$no_faktur' AND selisih_fisik > '0' ");
while ($out_plus = mysqli_fetch_array($query_plus))
			{
				//menampilkan data
			echo "<tr>
			<td>". $out_plus['no_faktur'] ."</td>
			<td>". $out_plus['kode_barang'] ."</td>
			<td>". $out_plus['nama_barang'] ."</td>
			<td>". $out_plus['stok_sekarang'] ."</td>
			<td>". $out_plus['fisik'] ."</td>
			<td>". $out_plus['selisih_fisik'] ."</td>
			<td>". $out_plus['hpp'] ."</td>
			<td>". $out_plus['selisih_harga'] ."</td>

			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database
?>
        </tbody>
    </table>      
<!-- Ending Plus-->

<br>
<!--Minus-->
    <table id="kartu_stok" class="table table-bordered">
<center><h4>Data Stok Opnama Minus</h4></center>

        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
      <th style='background-color: #4CAF50; color:white'> Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
      <th style='background-color: #4CAF50; color:white'> HPP</th>
      <th style='background-color: #4CAF50; color:white'> Selisih Harga</th>

</thead>
<tbody>

<?php 
$query_minus = $db->query ("SELECT * FROM detail_stok_opname WHERE no_faktur = '$no_faktur' AND selisih_fisik < '0' ");
while ($out_minus = mysqli_fetch_array($query_minus))
			{
				//menampilkan data
			echo "<tr>
			<td>". $out_minus['no_faktur'] ."</td>
			<td>". $out_minus['kode_barang'] ."</td>
			<td>". $out_minus['nama_barang'] ."</td>
			<td>". $out_minus['stok_sekarang'] ."</td>
			<td>". $out_minus['fisik'] ."</td>
			<td>". $out_minus['selisih_fisik'] ."</td>
			<td>". $out_minus['hpp'] ."</td>
			<td>". $out_minus['selisih_harga'] ."</td>

			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      
<!-- Ending Minus-->



</div> <!--Closed Container-->



