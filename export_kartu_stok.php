<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kartu_stok.xls");

include 'db.php';
include 'sanitasi.php';

$daritgl = stringdoang($_GET['daritgl']);
$sampaitgl = stringdoang($_GET['sampaitgl']);
$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);



// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND waktu <= '$daritgl' ");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND waktu <= '$daritgl' ");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

 ?>


<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Data Kartu Stok</b></h3></center></tr>
		<tr><td><b>Kode Barang</b></td> <td>=</td> <td><b><?php echo $kode_barang ?></b></td> </tr>
		<tr><td><b>Nama Barang</b></td> <td>=</td> <td><b><?php echo $nama_barang ?></b></td> </tr>
		<tr><td><b>Periode</b></td> <td>=</td> <td><b><?php echo $daritgl; ?> Sampai <?php echo$sampaitgl;   ?></b></td> </tr>
	</tbody>
</table>
</b>
</h3>
    <table id="kartu_stok" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Tipe </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Masuk </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Keluar </th>
      <th style='background-color: #4CAF50; color:white'> Saldo</th>

</thead>
<tbody>
<tr style="color:red;">
<td></td>
<td style='background-color:gold;'>Saldo Awal</td>
<td></td>
<td></td>
<td></td>
<td style='background-color:gold;'><?php echo $total_saldo ?></td>
</tr>

<?php 

$select = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp,waktu FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND tanggal >= '$daritgl' AND tanggal <= '$sampaitgl' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp,waktu FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal >= '$daritgl' AND tanggal <= '$sampaitgl' ORDER BY waktu ASC ");


while($data = mysqli_fetch_array($select))
	{

if ($data['jenis_hpp'] == '1')
{
	$masuk = $data['jumlah_kuantitas'];
	$total_saldo = ($total_saldo + $masuk);

			echo "<tr>
			<td>". $data['no_faktur'] ."</td>
			<td>". $data['jenis_transaksi'] ."</td>
			<td>". $data['tanggal'] ."</td>
			<td>". rp($masuk) ."</td>
		  	<td>0</td>
		  	<td>". rp($total_saldo) ."</td>
			";
}
else
{

$keluar = $data['jumlah_kuantitas'];
$total_saldo = $total_saldo - $keluar;

			echo "<tr>
			<td>". $data['no_faktur'] ."</td>
			<td>". $data['jenis_transaksi'] ."</td>
			<td>". $data['tanggal'] ."</td>
			<td>0</td>
		  	<td>".rp($keluar)."</td>
		  	<td>". rp($total_saldo) ."</td>
			";
}

		echo "</tr>";


} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



