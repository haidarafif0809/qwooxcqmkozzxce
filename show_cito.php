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


<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
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
</div>

<script>
    $(document).ready(function(){
    

    //fungsi hapus data 
        $(".btn-hapus").click(function(){
        var nama = $(this).attr("data-nama");
        var id = $(this).attr("data-id");

        $("#nama_hapus").val(nama);
        $("#btn_jadi_hapus").attr("data-id",id);

        $("#modal_hapus").modal('show');
        
        
        });


        $("#btn_jadi_hapus").click(function(){
        
        var id = $(this).attr("data-id");

        $(".tr-id-"+id+"").remove();
        
        $.post("delete_cito.php",{id:id},function(data){

        $("#modal_hapus").modal('hide');
         


        
        });
        
        });
// end fungsi hapus data


//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-nama"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else {

		$("#modal_edit").modal("hide");
		$(".tr-id-"+id+"").remove();
		$.post("update_cito.php",{id:id,nama:nama},function(data){

		$("#tbody").prepend(data);

		

		
		
		});
		}
									


		});
		


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