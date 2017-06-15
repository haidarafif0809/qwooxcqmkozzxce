<?php
	// memasukan file db.php
include 'sanitasi.php';
include 'db.php';

$id = angkadoang($_POST['id']);
$nama = angkadoang($_POST['nama']);
$jenis = angkadoang($_POST['jenis_lab']);

$update_diskon = "UPDATE setting_laboratorium SET nama = '$nama' WHERE id = '$id'";

	if ($db->query($update_diskon) === TRUE){
		echo "Berhasil";
	} 
	else{
		echo "Error: " . $update_diskon . "<br>" . $db->error;
	}
        

// UNTUK MENAMPILKAN DATA (BERHUBUNGAN DENGAN JS PREPAND DI FORM)
/*$query_setting_laboratorium = $db->query("SELECT id,nama,jenis_lab FROM setting_laboratorium ORDER BY id ASC");
			//menyimpan data sementara yang ada pada $perintah
		$data_setting = mysqli_fetch_array($query_setting_laboratorium);
		
			//karena setting INT 1 & 0 maka digunakan if agar menampilkan karakter
			if ($data_setting['nama'] == 1){
				$nama = 'Input Hasil Baru Bayar';
			}
			else{
				$nama = 'Bayar Dulu Baru Input Hasil';
			}
			//menampilkan data
			
 			echo "<tr class='tr-id-".$data_setting['id']."'>

			<td>". $nama ."</td>
			<td>". $data_setting['jenis_lab'] ."</td>";

			 echo "<td> <button class='btn btn-info btn-edit' data-id='". $data_setting['id'] ."' data-jenis='". $data_setting['jenis_lab'] ."' data-nama='". $data_setting['nama'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

			</tr>";
		*/
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>