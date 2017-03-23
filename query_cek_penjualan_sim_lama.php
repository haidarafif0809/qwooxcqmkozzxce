<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_simklinik";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$dblama = new mysqli('localhost','root','','aplikasi_simklinik');


// Check connection
if ($dblama->connect_error) {
    die("Connection failed: " . $dblama->connect_error);
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>Penjualan</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
	</thead>
	<tbody>

	<?php 

	$query = $dblama->query("SELECT no_faktur, no_reg,tanggal FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
	while ($data = mysqli_fetch_array($query)) {

			$cek = $db->query("SELECT no_faktur FROM penjualan WHERE no_reg = '$data[no_reg]' ");
			$data_cek = mysqli_num_rows($cek);

			if ($data_cek < 0 ) {

					echo "<tr>
					<td>".$data['no_faktur']."</td>
					<td>".$data['tanggal']."</td>
				 </tr>";
				
			}


	}




	 ?>



	</tbody>
</table>

</body>
</html>