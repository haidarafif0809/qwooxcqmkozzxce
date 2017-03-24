<?php
	// memasukan file db.php
include 'sanitasi.php';
include 'db.php';

$id = angkadoang($_POST['id']);
$nama = angkadoang($_POST['nama']);

$update_diskon = "UPDATE setting_laboratorium SET nama = '$nama' WHERE id = '$id'";

	if ($db->query($update_diskon) === TRUE)
	{

	} 
	else
	{
		echo "Error: " . $update_diskon . "<br>" . $db->error;
	}
        

// UNTUK MENAMPILKAN DATA (BERHUBUNGAN DENGAN JS PREPAND DI FORM)
$perintah = $db->query("SELECT id,nama FROM setting_laboratorium ORDER BY id DESC LIMIT 1");
			//menyimpan data sementara yang ada pada $perintah
			$data1 = mysqli_fetch_array($perintah);
		
			//karena setting INT 1 & 0 maka digunakan if agar menampilkan karakter
			if ($data1['nama'] == 1)
			{
				$nama = 'Dihubungkan';
			}
			else
			{
				$nama = 'Tidak dihubungkan';
			}
			//menampilkan data
			
 			echo "<tr class='tr-id-".$data1['id']."'>

			<td>". $nama ."</td>";
			

			 echo "<td> <button class='btn btn-info btn-edit' data-id='". $data1['id'] ."'  data-nama='". $data1['nama'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

			</tr>";
		
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>