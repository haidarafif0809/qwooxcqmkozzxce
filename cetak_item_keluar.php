<?php session_start();
include 'db.php';
include 'sanitasi.php';
include 'header.php';

$username = $_SESSION['nama'];
$no_faktur = $_GET['no_faktur'];
$keterangan = $_GET['keterangan'];


$query1 = $db->query("SELECT * FROM perusahaan ");
$data1 = mysqli_fetch_array($query1);
$nama_perusahaan = $data1['nama_perusahaan'];
$alamat_perusahaan = $data1['alamat_perusahaan'];
$no_telp = $data1['no_telp'];
$foto = $data1['foto'];


$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$query = $db->query("SELECT * FROM detail_item_keluar WHERE no_faktur = '$no_faktur' ");
$cek = mysqli_fetch_array($query);
$no_faktur_beli = $cek['no_faktur'];

$query2 = $db->query("SELECT * FROM detail_item_keluar WHERE no_faktur = '$no_faktur' ");

$query3 = $db->query("SELECT SUM(subtotal) AS tot FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($query3);
$total = $ambil['tot'];

?>

<div class="container">
<div class="row"> <!-- Open ROW 1 -->

<div class="col-sm-2"> <!-- Open Col SM 1 -->
	<br>
	<br>
<img src="save_picture/<?php echo $foto;?>" style="width:100px;height:100px;">
</div> <!-- closed Col SM 1 -->

<div class="col-sm-5"> <!-- Open Col SM 2 -->
					<h4>ITEM KELUAR</h4>
					<h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
					<p> <?php echo $data1['alamat_perusahaan']; ?><br>
					No.Telp:<?php echo $data1['no_telp']; ?> </p> 
</div> <!-- Closed Col SM 2 -->

<div class="col-sm-2"></div>

<div class="col-sm-3"> <!-- Open Col SM 3 -->
	<br>
	<br>
	 <table>
    <tbody>
    
	<h5>
	<tr><td>Petugas </td><td>&nbsp;:&nbsp;</td><td> </b> <?php echo $username;?></td></tr>
	<tr><td>No Transaksi</td><td>&nbsp;:&nbsp;</td><td></b> <?php echo $no_faktur;?></td></tr>
	<tr><td>Tanggal  </td><td>&nbsp;:&nbsp;</td><td> </b> <?php echo $tanggal_sekarang;?></td></tr>

</h5>
  
    </tbody>
  </table>
</div><!-- Closed Col SM 3 -->


</div> <!-- Div Closed Class Row 1 -->
<hr>

<table id="hutang" class="table table-bordered table-sm">
	<thead>
		<tr>
		<th>No Faktur</th>
		<th>Kode Barang</th>
		<th>Nama Barang </th>
		<th>Jumlah </th>
		<th>Harga</th>
		<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		while($data = mysqli_fetch_array($query2)){
			echo 
			"<tr>
			<td>".$data['no_faktur']."</td>
			<td>".$data['kode_barang']."</td>
			<td>".$data['nama_barang']."</td>
			<td>".$data['jumlah']."</td>
			<td>".$data['harga']."</td>
			<td>".$data['subtotal']."</td>
			</tr>";
		}
		?>
	</tbody>
</table>


<div class="row"> <!-- oPEN ROW ke 2 -->
<div class="col-sm-8"> <!-- Open Col SM 1 , di ROW ke 2 -->
 <table>
  <tbody>
      <tr><td  width="25%"><font class="satu"><i>Terbilang</i></font></td> <td> :&nbsp;</td> <td><font class="satu"><i> <?php echo kekata($total); ?> </i></font></td></tr>
      <tr><td  width="25%"><font class="satu">Keterangan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $keterangan; ?> </font></td></tr>

            

  </tbody>
</table>

</div> <!-- Closed Col SM 1 , di ROW ke 2 -->

<div class="col-sm-3"> <!-- Open Col SM 2 , di ROW ke 2 -->
 <table>
    <tbody>
      

			Subtotal Pembayaran : </b> <?php echo rp($total);?><br>
		
    </tbody>
  </table>
</div> <!-- Closed Col SM 1 , di ROW ke 2 -->
</div> <!-- Closed ROW KE 2 -->

<br>
<br>
<br>


<div class="row"> <!-- oPEN ROW ke 3 -->

<div class="col-sm-1">
</div>

<div class="col-sm-4"> <!-- Open Col SM 1 , di ROW ke 3 -->
			Hormat Kami<br>
			<br>
			<br>
			<br>
		  <?php echo $username;?></b><br>

</div> <!-- Closed Col SM 1 , di ROW ke 3 -->

<div class="col-sm-1">
	<center><h5><b>Manager</b>
	<br>
	<br>
	<br>
<br>
	.................</b></h5></center>
</div>
<div class="col-sm-3">
	
</div>
<div class="col-sm-3"> <!-- Open Col SM 2 , di ROW ke 3 -->
	Penerima<br>
			<br>
			<br>
			<br>

...................</b><br>
</div> <!-- Closed Col SM 1 , di ROW ke 3 -->
</div> <!-- Closed ROW KE 3 -->
</div> <!-- Div Class Container -->


<script>
$(document).ready(function(){
  window.print();
});
</script> 

