<?php 
include 'db.php';
include 'sanitasi.php';
$cari = stringdoang($_POST['cari']);


$query = $db->query("SELECT id,kode_pelanggan,nama_pelanggan,jenis_kelamin,alamat_sekarang,tgl_lahir,no_telp,gol_darah,tanggal,penjamin FROM pelanggan WHERE (kode_pelanggan LIKE '%$cari%' OR nama_pelanggan LIKE '%$cari%' OR alamat_sekarang LIKE '%$cari%')");


 ?>
<div class="table-responsive">
 <table id="pasien_lama" class="table table-sm table-bordered">
 	<thead>
 		<tr>
 			<th style='background-color: #4CAF50; color: white' >No. RM </th>
 			<th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
 			<th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
 			<th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
 			<th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
 			<th style='background-color: #4CAF50; color: white' >No HP</th>
 			<th style='background-color: #4CAF50; color: white' >Tanggal Terdaftar </th>
      <th style='background-color: #4CAF50; color: white' >Hapus</th>
      <th style='background-color: #4CAF50; color: white' >Edit</th>

 		</tr>
 	</thead>
 	<tbody>
 		<?php
 		while ($data = mysqli_fetch_array($query)) {
 			# code...
 			echo "<tr class='pilih tr-id-".$data['id']."'
 			data-darah='". $data['gol_darah']."'
 			data-no='". $data['kode_pelanggan']."'
         data-nama='".$data['nama_pelanggan']."'
         data-lahir='". tanggal_terbalik($data['tgl_lahir'])."'
         data-alamat='". $data['alamat_sekarang']."' 
         data-jenis-kelamin='". $data['jenis_kelamin']. "'
         data-hp ='". $data['no_telp']."'
                  data-penjamin ='". $data['penjamin']."'

 			><td>".$data['kode_pelanggan']."</td>
 			<td>".$data['nama_pelanggan']."</td>
 			<td>".$data['jenis_kelamin']."</td>
 			<td>".$data['alamat_sekarang']."</td>
 			<td>".tanggal($data['tgl_lahir'])."</td>
 			<td>". $data['no_telp']."</td>
 			<td>".tanggal($data['tanggal'])."</td>
      
      <td><button data-id='".$data['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i> Hapus </button></td>

      <td><a href='edit_data_pasien.php?id=".$data['id']."'class='btn btn-warning'><i class='fa fa-edit'></i> Edit </a></td>
      
      </tr>
 			";
 		}


 		?>
 	</tbody>
 </table>
 </div>
<script type="text/javascript">
  $(function () {
  $("#pasien_lama").dataTable({"ordering": false});
  });  
</script>

<script type="text/javascript">
$(document).on('click', '.delete', function (e) {

  var id = $(this).attr('data-id');

$("#modale-delete").modal('show');
$("#id2").val(id);  

});


</script>


