<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();


 ?>

<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_user.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tableuser").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[12]+'');

},
        } );
      } );
    </script>

<div class="table-responsive">
<span id="table-baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>

			<th style='background-color: #4CAF50; color: white'> Reset Password </th>
			<th style='background-color: #4CAF50; color: white'> Username </th>
			<th style='background-color: #4CAF50; color: white'> Password </th>
			<th style='background-color: #4CAF50; color: white'> Nama Lengkap </th>
			<th style='background-color: #4CAF50; color: white'> Alamat </th>
			<th style='background-color: #4CAF50; color: white'> Jabatan </th>
			<th style='background-color: #4CAF50; color: white'> Otoritas </th>
			<th style='background-color: #4CAF50; color: white'> Tipe User </th>
			<th style='background-color: #4CAF50; color: white'> Status </th>
			<th style='background-color: #4CAF50; color: white'> Status Sales </th>
<?php 
include 'db.php';

$pilih_akses_user_hapus = $db->query("SELECT user_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_hapus = '1'");
$user_hapus = mysqli_num_rows($pilih_akses_user_hapus);


    if ($user_hapus > 0){

			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";

		}
?>

<?php 
include 'db.php';

$pilih_akses_user_edit = $db->query("SELECT user_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_edit = '1'");
$user_edit= mysqli_num_rows($pilih_akses_user_edit);


    if ($user_edit > 0){
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
		}
	?>
			
			
		</thead>
	</table>
</span>
</div>


        <script type="text/javascript">
//fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {
		var username = $(this).attr("data-user");
		var id = $(this).attr("data-id");
		$("#user_name").val(username);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


$(document).on('click', '#btn_jadi_hapus', function (e) {
		
		var id = $("#id_hapus").val();
		$.post("hapususer.php",{id:id},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');

	 $('#table_rawat_inap').DataTable().destroy();
        
		    var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_user.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tableuser").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[12]+'');
			},
       });


		}

		
		});
		
		
		});

		</script> 
		
		<script>
//fungsi reset password data 
		$(".btn-reset").click(function(){
		var reset_user_name = $(this).attr("data-reset-user");
		var reset_id = $(this).attr("data-reset-id");
		$("#reset_user_name").val(reset_user_name);
		$("#reset_id_hapus").val(reset_id);
		$("#modal_reset").modal('show');
		
		
		$(".alert-success").hide();
		});


		$("#btn_jadi_reset").click(function(){
		

		var user_name = $("#reset_user_name").val();
		var id = $("#reset_id_hapus").val();
		$.post("reset_password.php",{id:id},function(data){
		if (data != "") {
		$("#table-baru").load('tabel-user.php');
		$(".alert-success").show();
		$("#modal_reset").modal('hide');
		
		}

		
		});
		
		
		});

</script>    