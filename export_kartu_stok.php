<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kartu_stok.xls");

include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_GET['id_produk']);
$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);
$bulan = stringdoang($_GET['bulan']);
$tahun = stringdoang($_GET['tahun']);



if ($bulan == '1')
{
	$moon = 'Januari';
}
else if ($bulan == '2')
{
	$moon = 'Febuari';
}
else if ($bulan == '3')
{
	$moon = 'Maret';
}
else if ($bulan == '4')
{
	$moon = 'April';
}
else if ($bulan == '5')
{
	$moon = 'Mei';
}
else if ($bulan == '6')
{
	$moon = 'Juni';
}
else if ($bulan == '7')
{
	$moon = 'Juli';
}
else if ($bulan == '8')
{
	$moon = 'Agustus';
}
else if ($bulan == '9')
{
	$moon = 'September';
}
else if ($bulan == '10')
{
	$moon = 'Oktober';
}
else if ($bulan == '11')
{
	$moon = 'November';
}
else if ($bulan == '12')
{
	$moon = 'Desember';
}



if($bulan == '1')
{
	$bulan = 12;
	$tahun_before = $tahun - 1;

// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun_before'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun_before'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

}
else
{

// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

}

 ?>


<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Data Kartu Stok</b></h3></center></tr>
		<tr><td width="70%"><b>Kode Barang</b></td> <td>=</td> <td><b><?php echo $kode_barang ?></b></td> </tr>
		<tr><td width="70%"><b>Nama Barang</b></td> <td>=</td> <td><b><?php echo $nama_barang ?></b></td> </tr>
		<tr><td width="70%"><b>Bulan</b></td> <td>=</td> <td><b><?php echo $moon; ?></b></td> </tr>
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


$bulan = stringdoang($_GET['bulan']);

$select = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal ");


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



