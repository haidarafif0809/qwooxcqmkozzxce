<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
	include 'header.php';
	include 'navbar.php';
	include 'db.php';


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
						  $query = $db->query("SELECT id, url_cari_pasien, url_data_pasien FROM setting_registrasi_pasien ");
						  while($data = mysqli_fetch_array($query)) {
						    echo "
						    <tr>";
						    if ($data['id'] == 6) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Master Data Pasien</th>";
						    }
						    if ($data['id'] == 1) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien Rawat Jalan</th>";
						    }
						    if ($data['id'] == 3) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien Rawat Inap</th>";
						    }
						    if ($data['id'] == 4) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien UGD</th>";
						    }
						    if ($data['id'] == 5) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien APS</th>";
						    }
						    if ($data['id'] == 2) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Filter Pencarian Pasien Rawat Jalan</th>";
						    }
						    if ($data['id'] == 7) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Data Pasien Rawat Jalan</th>";
						    }
						    if ($data['id'] == 9) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Data Pasien Rawat Inap</th>";
						    }
						    if ($data['id'] == 8) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Data Pasien UGD</th>";
						    }

						    echo "<td style='cursor:pointer;' class='edit-cari' data-id='".$data['id']."'><span id='text-cari-".$data['id']."'>".$data['url_cari_pasien']."</span> <input type='hidden' id='input-cari-".$data['id']."' value='".$data['url_cari_pasien']."' class='input_cari' data-id='".$data['id']."' data-cari='".$data['url_cari_pasien']."' autofocus=''></td>
						    </tr>";

						    echo "
						    <tr>";
						    if ($data['id'] == 6) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Master Data Pasien Baru</th>";
						    }
						    if ($data['id'] == 1) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien Baru Rawat Jalan</th>";
						    }
						    if ($data['id'] == 3) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien Baru Rawat Inap</th>";
						    }
						    if ($data['id'] == 4) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien Baru UGD</th>";
						    }
						    if ($data['id'] == 5) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Pasien Baru APS</th>";
						    }
						    if ($data['id'] == 7) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Edit Data Pasien Rawat Jalan</th>";
						    }
						    if ($data['id'] == 9) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Edit Data Pasien Rawat Inap</th>";
						    }
						    if ($data['id'] == 8) {
						    	echo "<th style='background-color: #4CAF50; color: white;'>Edit Data Pasien UGD</th>";
						    }

						    if ($data['url_data_pasien'] != NULL) {						    	
							   	echo "<td style='cursor:pointer;' class='edit-data' data-id='".$data['id']."'><span id='text-data-".$data['id']."'>".$data['url_data_pasien']."</span> <input type='hidden' id='input-data-".$data['id']."' value='".$data['url_data_pasien']."' class='input_data' data-id='".$data['id']."' data-data='".$data['url_data_pasien']."' autofocus=''></td>
							    </tr>";
						    }
						    
						  }
						?>		
				</thead>
					
			</table>
		</div>	
		
	<h6 style="text-align: left ; color: red"><i> * Klik 2x Pada Kolom Yang Ingin Diubah.</i></h6>
</div>


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

var pesan_alert = confirm("Apakah Anda Yakin Ingin Mengubah Data Ini?");
if (pesan_alert == true) {

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

}
else{
			$("#text-cari-"+id+"").show();
			$("#text-cari-"+id+"").text(input_cari);
			$("#input-cari-"+id+"").attr("type", "hidden");           
			$("#input-cari-"+id+"").val(input_cari);
			$("#input-cari-"+id+"").attr("data-cari",input_cari);
}

});
</script>

<!-- URL UNTUK LINK PORSES TAMBAH PASIEN -->
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

var pesan_alert = confirm("Apakah Anda Yakin Ingin Mengubah Data Ini?");
if (pesan_alert == true) {

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

}
else{
			$("#text-data-"+id+"").show();
			$("#text-data-"+id+"").text(input_data);
			$("#input-data-"+id+"").attr("type", "hidden");           
			$("#input-data-"+id+"").val(input_data);
			$("#input-data-"+id+"").attr("data-data",input_data);
}


});
</script>

<?php 
include 'footer.php';
 ?>