<?php include 'session_login.php';

	include 'sanitasi.php';
	include 'db.php';

	$query = $db->query("SELECT * FROM kategori");

 ?>


<table id="table_kategori" class="table table-bordered table-sm">
		<thead> 
			
			<th style="background-color: #4CAF50; color: white"> Nama Kategori </th>
			<th style="background-color: #4CAF50; color: white"> Hapus </th>
			<th style="background-color: #4CAF50; color: white"> Edit </th>		
			
		</thead>
		
	</table>


<!--datatable menggunakan  ajax-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_kategori').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_kategori_barang.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_kategori").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[3]+'');

},
        } );
      } );
    </script>

<script>
    $(document).ready(function(){


//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var nama = $(this).attr("data-kategori");
		var id = $(this).attr("data-id");
		$("#data_kategori").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});

// end fungsi hapus data


//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-kategori"); 
		var id  = $(this).attr("data-id");
		$("#kategori_edit").val(nama);
		$("#id_edit").val(id);
		
		
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