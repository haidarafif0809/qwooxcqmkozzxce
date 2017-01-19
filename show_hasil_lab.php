<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];

$detail = $db->query("SELECT * FROM hasil_lab WHERE no_faktur = '$no_faktur'");

?>

<div class="container">				
<div class="table-responsive"> 

<table id="tableuser" class="table table-bordered table-sm">
        <thead>

           <th> Nama Pemeriksaan </th>
           <th> Hasil Pemeriksaan </th>
           <th> Nilai Normal Pria </th>
           <th> Nilai Normal Wanita </th>
           
            
        </thead>
        
        <tbody>
        <?php

            
$show = $db->query("SELECT * FROM hasil_lab WHERE no_faktur = '$no_faktur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($take = mysqli_fetch_array($show))
            {
                //menampilkan data
            echo "<tr>
                <td>". $take['nama_pemeriksaan'] ."</td>
                <td>". $take['hasil_pemeriksaan'] ."</td>";



$model_hitung = $take['model_hitung']; 
if($model_hitung == '')
{
  echo "<td>&nbsp; ". '-' ." </td>
        <td>&nbsp; ". '-'." </td>
        ";
}
else
{
switch ($model_hitung) {
    case "Lebih Kecil Dari":
        echo "<td>&lt;&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
        <td>&lt;&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Kecil Sama Dengan":
        echo "<td>&lt;=&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
        <td>&lt;=&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Besar Dari":
        echo "<td>&gt;&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
        <td>&gt;&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>
        ";
        break;
          case "Lebih Besar Sama Dengan":
        echo "<td>&gt;=&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
        <td>&gt;=&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>
        ";
        break;
          case "Antara Sama Dengan":
        echo "<td>". $take['nilai_normal_lk']."&nbsp;-&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
        <td>". $take['nilai_normal_pr']."&nbsp;-&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>
        ";
        break;
    } 
}



                echo " 
            <tr>";

            }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

        ?>
        </tbody>

    </table>
</div>
</div>

					<script>
		
		$(document).ready(function(){
		$('#table').DataTable(
			{"ordering": false});
		});
		</script>