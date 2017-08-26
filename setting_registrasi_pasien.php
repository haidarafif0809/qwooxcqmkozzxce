<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
	include 'header.php';
	include 'navbar.php';
	include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
	$perintah = $db->query("SELECT id, url_cari_pasien, url_data_pasien FROM setting_registrasi_pasien");

?>

<style type="text/css">
	th{
		background-color: #4CAF50;
		color: white;
		width: 25%
	}
</style>

<div style="padding-left: 21%; padding-right: 21%">
	<h3>REGISTRASI ONLINE - OFFLINE</h3><hr>


		<div class="table-responsive">
			<table id="tableuser" class="table table-bordered table-sm">
				<thead>
						<?php 
						  $query = $db->query("SELECT id, url_cari_pasien FROM setting_registrasi_pasien WHERE id = '1'");
						  while($data = mysqli_fetch_array($query)) {
						    echo "
						    <tr>
						    	<th style='background-color: #4CAF50; color: white;'>Pasien Rawat Jalan</th>
								<td td class='edit-cari' data-id='".$data['id']."'><span id='text-cari-".$data['id']."'>". $data['url_cari_pasien'] ."</span> <input type='hidden' id='input-cari-".$data['id']."' value='".$data['url_cari_pasien']."' class='input_cari' data-id='".$data['id']."' data-cari='".$data['url_cari_pasien']."' autofocus=''></td>
						    </tr>";
						  }
						?>		
				</thead>
				<thead>
						<?php 
						  $query = $db->query("SELECT id, url_cari_pasien FROM setting_registrasi_pasien WHERE id = '3'");
						  while($data = mysqli_fetch_array($query)) {
						    echo "
						    <tr>
						    	<th style='background-color: #4CAF50; color: white;'>Pasien Rawat Inap</th>
								<td td class='edit-cari' data-id='".$data['id']."'><span id='text-cari-".$data['id']."'>". $data['url_cari_pasien'] ."</span> <input type='hidden' id='input-cari-".$data['id']."' value='".$data['url_cari_pasien']."' class='input_cari' data-id='".$data['id']."' data-cari='".$data['url_cari_pasien']."' autofocus=''></td>
						    </tr>";
						  }
						?>		
				</thead>
				<thead>
						<?php 
						  $query = $db->query("SELECT id, url_cari_pasien FROM setting_registrasi_pasien WHERE id = '4'");
						  while($data = mysqli_fetch_array($query)) {
						    echo "
						    <tr>
						    	<th style='background-color: #4CAF50; color: white;'>Pasien UGD</th>
								<td td class='edit-cari' data-id='".$data['id']."'><span id='text-cari-".$data['id']."'>". $data['url_cari_pasien'] ."</span> <input type='hidden' id='input-cari-".$data['id']."' value='".$data['url_cari_pasien']."' class='input_cari' data-id='".$data['id']."' data-cari='".$data['url_cari_pasien']."' autofocus=''></td>
						    </tr>";
						  }
						?>		
				</thead>
				<thead>
						<?php 
						  $query = $db->query("SELECT id, url_cari_pasien FROM setting_registrasi_pasien WHERE id = '5'");
						  while($data = mysqli_fetch_array($query)) {
						    echo "
						    <tr>
						    	<th style='background-color: #4CAF50; color: white;'>Pasien APS</th>
								<td td class='edit-cari' data-id='".$data['id']."'><span id='text-cari-".$data['id']."'>". $data['url_cari_pasien'] ."</span> <input type='hidden' id='input-cari-".$data['id']."' value='".$data['url_cari_pasien']."' class='input_cari' data-id='".$data['id']."' data-cari='".$data['url_cari_pasien']."' autofocus=''></td>
						    </tr>";
						  }
						?>		
				</thead>
				<thead>
						<?php 
						  $query = $db->query("SELECT id, url_cari_pasien FROM setting_registrasi_pasien WHERE id = '2'");
						  while($data = mysqli_fetch_array($query)) {
						    echo "
						    <tr>
						    	<th style='background-color: #4CAF50; color: white;'>Filter Pencarian Pasien Rawat Jalan</th>
								<td td class='edit-cari' data-id='".$data['id']."'><span id='text-cari-".$data['id']."'>". $data['url_cari_pasien'] ."</span> <input type='hidden' id='input-cari-".$data['id']."' value='".$data['url_cari_pasien']."' class='input_cari' data-id='".$data['id']."' data-cari='".$data['url_cari_pasien']."' autofocus=''></td>
						    </tr>";
						  }
						?>		
				</thead>	
			</table>
		</div>	
		
	<h6 style="text-align: left ; color: red"><i> * Klik 2x Pada Kolom Yang Ingin Diubah.</i></h6>
</div>

<!--DATA TABLE MENGGUNAKAN AJAX
<script type="text/javascript">
      $(document).ready(function() {

          var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_registrasi_pasien.php", //  json datasource           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tableuser").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },
        });


      } );
</script>
-->


<!-- URL CARI PASIEN -->
<script type="text/javascript">
$(document).on('dblclick','.edit-cari',function(e){
	var id = $(this).attr("data-id");
	$("#text-cari-"+id+"").hide();
 	$("#input-cari-"+id+"").attr("type", "text");
 });

$(document).on('blur','.input_cari',function(e){
	var cari_lama = $(this).attr("data-cari");
	var id = $(this).attr("data-id");
	var input_cari = $(this).val();

	if (input_cari == '') {
		alert('Data Tidak Boleh Kosong.');
	}	    
    else{
		// Start Proses
		$.post("update_setting_registrasi_pasien.php",{id:id, input_cari:input_cari, jenis_edit:"url_cari"},function(data){

			$("#text-cari-"+id+"").show();
			$("#text-cari-"+id+"").text(input_cari);
			$("#input-cari-"+id+"").attr("type", "hidden");           
			$("#input-cari-"+id+"").val(input_cari);
			$("#input-cari-"+id+"").attr("data-cari",input_cari);

      	}); // end post dari cek cari

    } // end else breket


});
</script>

<!-- URL DATA PASIEN -->
<script type="text/javascript">
$(document).on('dblclick','.edit-data',function(e){
	var id = $(this).attr("data-id");
	$("#text-data-"+id+"").hide();
 	$("#input-data-"+id+"").attr("type", "text");
 });

$(document).on('blur','.input_data',function(e){
	var data_lama = $(this).attr("data-data");
	var id = $(this).attr("data-id");
	var input_data = $(this).val();

	if (input_data == '') {
		alert('Data Tidak Boleh Kosong.');
	}	    
    else{
		// Start Proses
		$.post("update_setting_registrasi_pasien.php",{id:id, input_data:input_data, jenis_edit:"url_data"},function(data){

			$("#text-data-"+id+"").show();
			$("#text-data-"+id+"").text(input_data);
			$("#input-data-"+id+"").attr("type", "hidden");           
			$("#input-data-"+id+"").val(input_data);
			$("#input-data-"+id+"").attr("data-data",input_data);

      	}); // end post dari cek data

    } // end else breket


});
</script>

<?php 
include 'footer.php';
 ?>