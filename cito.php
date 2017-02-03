<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel jabatan
$query = $db->query("SELECT * FROM cito");

$pilih_akses_cito = $db->query("SELECT cito_tambah, cito_edit, cito_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$cito = mysqli_fetch_array($pilih_akses_cito);
 ?>
<div class="container">


 <h3><b> Data Cito</b></h3> <hr>
<?php if ($cito['cito_tambah'] > 0): ?>
	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> Tambah Data </button>
<br><br>
<?php endif ?>


<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Tambah Cito</b></center></h4>
      </div>
    <div class="modal-body">
<form role="form">
					<div class="form-group">
					<label> Nama Cito </label><br>
					<input type="text" name="nama" id="nama" class="form-control" autocomplete="off"  >
					</div>
					
					
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>

 	</div><!-- end of modal body -->

					<div class ="modal-footer">
					<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
	</div>
	</div>

</div>
<!-- end of modal Tambah data  -->



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b><center>Konfirmsi Hapus Data Cito</center></b></h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Cito :</label>
     <input type="text" id="nama_hapus" class="form-control" readonly=""> 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus" data-id=""> <i class='fa fa-cek'> </i> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <i class='fa fa-remove'> </i> Batal</button>
      </div>
    </div>

  </div>
</div>
<!-- end of modal hapus data  -->


<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Cito</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Cito:</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" data-nama="" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- end of modal edit data  -->

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead> 
			
			<th style='background-color: #4CAF50; color: white'> Nama Cito </th>
			<th style='background-color: #4CAF50; color: white'> Hapus </th>
			<th style='background-color: #4CAF50; color: white'> Edit </th>
			
		</thead>
		
		<tbody id="tbody">
		<?php

		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr class='tr-id-".$data['id']."'>
			
			<td>". $data['nama'] ."</td>";

if ($cito['cito_hapus']) {
	echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-nama='". $data['nama'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>";
}
else {
	echo "<td>  </td>";
}


if ($cito['cito_edit']) {
	echo "<td> <button class='btn btn-info btn-edit' data-nama='". $data['nama'] ."' data-id='". $data['id'] ."'> <i class='fa fa-edit'> </i> Edit </button> </td>";
}
else {
	echo "<td>  </td>";
}


			echo "</tr>";
			}
	

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</span>

</div><!--div responsive-->

</div><!--div counteiner-->

							
<script>
    $(document).ready(function(){

//fungsi untuk menambahkan data
		$(document).on('click','#submit_tambah',function(e){
		var nama = $("#nama").val();

		if (nama == "")
		{
			alert("Nama Harus Diisi");
		}
		else 
		{

			$.post("cek_nama_cito.php",{nama:nama},function(data){

						if (data == 1) {
							alert("Nama Cito yang anda masukan sudah ada");
							 $("#nama").val('');
							 $("#nama").focus();
						}
						else
						{
								$("#myModal").modal("hide");
								$("#nama").val('');
								$.post('proses_cito.php',{nama:nama},function(data){

								$("#tbody").prepend(data);

								});	
						}



			});
						
		}

		function tutupmodal() {
		
		}		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var nama = $(this).attr("data-nama");
		var id = $(this).attr("data-id");

		$("#nama_hapus").val(nama);
		$("#btn_jadi_hapus").attr("data-id",id);

		$("#modal_hapus").modal('show');
		
		
		});


		$(document).on('click','#btn_jadi_hapus',function(e){

		
		var id = $(this).attr("data-id");

		$(".tr-id-"+id+"").remove();
		
		$.post("delete_cito.php",{id:id},function(data){

		$("#modal_hapus").modal('hide');
		 


		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(document).on('click','.btn-edit',function(e){

		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-nama"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		$("#submit_edit").attr("data-nama",nama);
		
		});
		
		$(document).on('click','#submit_edit',function(e){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();
		var nama2 = $(this).attr("data-nama");

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else if (nama == nama2) {
								$("#modal_edit").modal("hide");
								$(".tr-id-"+id+"").remove();
								$.post("update_cito.php",{id:id,nama:nama},function(data){

								$("#tbody").prepend(data);

								});
		}
		else 
		{


			$.post("cek_nama_cito.php",{nama:nama},function(data){

						if (data == 1) {
							alert("Nama Cito yang anda masukan sudah ada");
							 $("#nama_edit").val(nama2);
							 $("#nama_edit").focus();
						}
						else
						{
								$("#modal_edit").modal("hide");
								$(".tr-id-"+id+"").remove();
								$.post("update_cito.php",{id:id,nama:nama},function(data){

								$("#tbody").prepend(data);

								});
						}
					});

		}
									


		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});


</script>

<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>

<?php include 'footer.php' ?>