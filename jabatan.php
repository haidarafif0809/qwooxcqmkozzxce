<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel jabatan
$query = $db->query("SELECT * FROM jabatan");

 ?>


<div class="container"><!--tag yang digunakan untuk membuat tampilan form menjadi rapih dalam satu tempat-->

<h3><b> DATA JABATAN</b></h3> <hr>

<?php
include 'db.php';

$pilih_akses_jabatan = $db->query("SELECT jabatan_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_tambah = '1'");
$jabatan = mysqli_num_rows($pilih_akses_jabatan);


    if ($jabatan > 0){
// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> JABATAN </button>';
}
?>

<br>
<br>



<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Jabatan</h4>
      </div>
    <div class="modal-body">
<form role="form">
					<div class="form-group">
					<label> Nama Jabatan </label><br>
					<input type="text" name="nama" id="nama_jabatan" class="form-control" autocomplete="off"  >
					</div>
					
					
					<div class="form-group">
					<label> Wewenang </label><br>
					<textarea type="text" name="wewenang" id="wewenang" class="form-control"></textarea>
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

</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Jabatan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Jabatan :</label>
     <input type="text" id="data_jabatan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Jabatan</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Jabatan:</label>
     <input type="text" class="form-control" id="jabatan_edit" autocomplete="off">
     <input type="text" class="form-control" id="id_edit">
    
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
</div><!-- end of modal edit data  -->

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead> 
			
			<th> Nama Jabatan </th>
			<th> Wewenang </th>
<?php  
include 'db.php';

$pilih_akses_jabatan_hapus = $db->query("SELECT jabatan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_hapus = '1'");
$jabatan_hapus = mysqli_num_rows($pilih_akses_jabatan_hapus);


    if ($jabatan_hapus > 0){
			echo "<th> Hapus </th>";
		}
?>



<!--
include 'db.php';

$pilih_akses_jabatan_edit = $db->query("SELECT jabatan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_edit = '1'");
$jabatan_edit = mysqli_num_rows($pilih_akses_jabatan_edit);


    if ($jabatan_edit > 0){
    	echo "<th> Edit </th>";
    }
    */
 
	-->
			
		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>";
			include 'db.php';

				$pilih_akses_jabatan_edit = $db->query("SELECT jabatan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_edit = '1'");
				$jabatan_edit = mysqli_num_rows($pilih_akses_jabatan_edit);

				    if ($jabatan_edit > 0){ 
			echo"<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['nama'] ."</span><input type='hidden' class='edit_nama' id='edit-nama-".$data['id']."' value='". $data['nama'] ."' data-id='".$data['id']."' data-nama='".$data['nama']."' data-www='".$data['wewenang']."'></td>";

			echo"<td class='edit-www' data-id='".$data['id']."'><span id='text-www-".$data['id']."'>". $data['wewenang'] ."</span><input type='hidden' class='edit_www' id='edit-www-".$data['id']."' value='". $data['wewenang'] ."' data-id='".$data['id']."' data-nama='".$data['nama']."' data-www='".$data['wewenang']."'></td>";

				}
				else
				{
					echo"<td>". $data['nama'] ."</td>";
					echo"<td>". $data['wewenang'] ."</td>";
				}


include 'db.php';

$pilih_akses_jabatan_hapus = $db->query("SELECT jabatan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_hapus = '1'");
$jabatan_hapus = mysqli_num_rows($pilih_akses_jabatan_hapus);


    if ($jabatan_hapus > 0){

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-jabatan='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

/*
include 'db.php';

$pilih_akses_jabatan_edit = $db->query("SELECT jabatan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_edit = '1'");
$jabatan_edit = mysqli_num_rows($pilih_akses_jabatan_edit);


    if ($jabatan_edit > 0){ 
			echo "<td> <button class='btn btn-info btn-edit' data-jabatan='". $data['nama'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
			</tr>";
			}

			*/
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

	<?php include 'db.php';

				$pilih_akses_jabatan_edit = $db->query("SELECT jabatan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_edit = '1'");
				$jabatan_edit = mysqli_num_rows($pilih_akses_jabatan_edit);

				    if ($jabatan_edit > 0){ 
				    	echo "<h6 style='text-align: left ; color: red'><i> * Klik 2x pada kolom jika ingin mengedit.</i></h6>";
				    }
				     ?>
	
</span>
</div>
</div> <!-- tag penutup cantainer -->

<script type="text/javascript">
	$(document).on('dblclick','.edit-nama',function(e){

			var id = $(this).attr("data-id");
			$("#text-nama-"+id+"").hide();
			$("#edit-nama-"+id+"").attr("type","text");

	});


	$(document).on('blur','.edit_nama',function(e){

		var id = $(this).attr("data-id");
		var nama_lama = $(this).attr("data-nama");
		var www = $(this).attr("data-www");
		var nama = $("#edit-nama-"+id+"").val();
		var jenis_update = 'Jabatan';

		$.post('cek_jabatan.php',{nama:nama}, function(data){
			if (data == 1) {
				alert('Nama Jabatan Sudah Ada!');
				$("#text-nama-"+id+"").show();
				$("#edit-nama-"+id+"").attr("type","hidden");
				$("#edit-nama-"+id+"").val(nama_lama);
				$("#text-nama-"+id+"").text(nama_lama);
				$("#edit-nama-"+id+"").attr("data-nama",nama_lama);
			}
			else
			{
				$("#edit-nama-"+id+"").attr("data-nama",nama);				
				$.post("update_jabatan.php",{id:id,nama:nama,jenis_update:jenis_update,www:www},function(data){

					$("#text-nama-"+id+"").show();
					$("#edit-nama-"+id+"").attr("type","hidden");
					$("#edit-nama-"+id+"").val(nama);
					$("#text-nama-"+id+"").text(nama);
					
				});
			}

		});

	});

</script>
				
<script type="text/javascript">
	$(document).on('dblclick','.edit-www',function(e){

			var id = $(this).attr("data-id");
			$("#text-www-"+id+"").hide();
			$("#edit-www-"+id+"").attr("type","text");

	});


	$(document).on('blur','.edit_www',function(e){

		var id = $(this).attr("data-id");
		var nama = $(this).attr("data-nama");
		var www_lama = $(this).attr("data-www");
		var www = $("#edit-www-"+id+"").val();
		var jenis_update = 'www';


				$("#edit-www-"+id+"").attr("data-www",www)
				$.post("update_jabatan.php",{id:id,nama:nama,jenis_update:jenis_update,www:www},function(data){

					$("#text-www-"+id+"").show();
					$("#edit-www-"+id+"").attr("type","hidden");
					$("#edit-www-"+id+"").val(www);
					$("#text-www-"+id+"").text(www);
				});


	});

</script>
						
<script>
$(document).ready(function(){
$(document).on('click','#submit_tambah',function(e){

		var nama = $("#nama_jabatan").val();
		var wewenang = $("#wewenang").val();

		$("#nama_jabatan").val('');
		

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		
		else {
		

// cek namanya
 $.post('cek_jabatan.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Jabatan Sudah Ada!');
          $("#nama_jabatan").focus();
          $("#nama_jabatan").val('');
        }
        else{

// Start Proses
 $.post('prosesjabatan.php',{nama:nama,wewenang:wewenang},function(data){

		if (data != '') {
		$("#nama_jabatan").val('');
		$("#wewenang").val('');

		$(".alert").show('fast');
		$("#table_baru").load('tabel-jabatan.php');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});
// Finish Proses
        }

      }); // end post dari cek nama


	}

		function tutupmodal() {
		
		}		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
	$(document).on('click','.btn-hapus',function(e){

		var nama = $(this).attr("data-jabatan");
		var id = $(this).attr("data-id");
		$("#data_jabatan").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();

		$.post("hapusjabatan.php",{id:id},function(data){

		if (data != "") {
		$("#table_baru").load('tabel-jabatan.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

/*//fungsi edit data 
$(document).on('click','.btn-edit',function(e){
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-jabatan"); 
		var id  = $(this).attr("data-id");
		$("#jabatan_edit").val(nama);
		$("#id_edit").val(id);
		$("#submit_edit").attr("data-nama",nama);

		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#jabatan_edit").val();
		var id = $("#id_edit").val();
    	var show_name = $(this).attr("data-nama"); 

		if (nama == ""){
			alert("Nama Harus Diisi");
			$("#jabatan_edit").focus();
		}
		else {

	// cek namanya
 $.post('cek_jabatan.php',{nama:nama}, function(data){
        if(data == 1){
          alert('Nama Bidang Laboratorium yang anda masukkan sudah ada!');
          $("#jabatan_edit").val(show_name); // menampilkan NAMA yang sebelumnya
          $("#jabatan_edit").focus();
        }
        else{

// mulai proses edit
   $.post("update_jabatan.php",{id:id,nama:nama},function(data){
		if (data != '') {
		$(".alert").show('fast');
		$("#table_baru").load('tabel-jabatan.php');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});
// end proses edit

        }

      }); // end post dari cek nama
	
		}
									

		function tutupmodal() {
		
		}	
		});
		

*/
//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		

		function tutupalert() {
		$(".alert").hide("fast")
		}
		


</script>

<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>

<!-- memasukan file footer.db -->
<?php include 'footer.php'; ?>
