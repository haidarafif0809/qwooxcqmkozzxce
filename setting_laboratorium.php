<?php include 'session_login.php';

//memasukkan file session login, header, navbar, sanitasi dan db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">

<h3><b>SETTING LABORATORIUM </b></h3><hr>

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <center> <h3 class="modal-title"><b>Edit Setting Laboratorium</b></h3></center>
      </div>
      <div class="modal-body">
  <form role="form" method="post">

	<div  class="form-group">
		<label> Nama Setting </label><br>
		
		 <select style="font-size:15px; height:40px" name="nama_edit" id="nama_edit" class="form-control chosen">
        <option value="1">Dihubungkan</option>  
        <option value="0">Tidak dihubungkan</option>  
                  
          </select>
	</div>
			
	<input type="hidden" name="id" id="id_edit" value="">
   
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 
      </div>
      <div class="modal-footer">
      <center>
      <button type="submit" id="submit_edit" class="btn btn-warning">Yes</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </center>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
	<thead>
		<th style='background-color: #4CAF50; color: white'>Nama Setting</th>
		<th style='background-color: #4CAF50; color: white'>Edit</th>	
	</thead>

	<tbody id="tbody">

		<?php
			$perintah = $db->query("SELECT id,nama FROM setting_laboratorium");
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
		{
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
		}
	

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

	</tbody>

</table>
  <h6 style="text-align: left ; color: red"><i> Note* Jika nama setting Dihubungkan, maka jika pasien tersebut rujuk laboratorium dan belum di input hasilnya (Tombol Bayar Tidak akan Muncul).</i></h6>
</div>

<script>
//Datatable 		
$(document).ready(function(){
	$('#tableuser').dataTable();
});
</script>


<script type="text/javascript">
//Script fungsi edit data 
$(document).on('click','.btn-edit',function(e){		
	$("#modal_edit").modal('show');

		var nama = $(this).attr("data-nama"); 
		var id  = $(this).attr("data-id");
		
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		
	});

//Script Proses Edit 	
$(document).on('click','#submit_edit',function(e){
	var id = $("#id_edit").val();
	var nama = $("#nama_edit").val();

		$("#modal_edit").modal("hide");
		$(".tr-id-"+id+"").remove();

	$.post("proses_setting_laboratorium.php",{id:id,nama:nama},function(data){
		$("#tbody").prepend(data);
	});
	});
</script>

</div> <!--Penutup Container-->

<?php include 'footer.php'; ?>