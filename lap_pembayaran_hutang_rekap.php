<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

 <div class="container">

<h3> LAPORAN PEMBAYARAN HUTANG </h3><hr>

<form class="form-inline" role="form">

			
				
				  <div class="form-group"> 
                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" autocomplete="off" required="">
                  </div>

                  <div class="form-group"> 
                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal"  autocomplete="off" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-bordered">
		<thead>
		
			<th style="background-color: #4CAF50; color: white;"> No Faktur Bayar</th>
			<th style="background-color: #4CAF50; color: white;"> No Faktur Beli</th>
			<th style="background-color: #4CAF50; color: white;"> Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jatuh Tempo </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Total Hutang </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
						
		</thead>
		<tbody>
			

		</tbody>

	</table>
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->

<script>
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  </script>

		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		</script>

		
		<script type="text/javascript">
		$("#submit").click(function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
		
		if (dari_tanggal == '')
		{
			alert("Dari Tanggal Harus Anda Isi !!");
		}
		else if (sampai_tanggal == '')
		{
			alert("Sampai Tanggal Harus Anda Isi !!");
		}
		else
		{
		$.post("proses_lap_pembayaran_hutang_rekap.php",{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){

		
		$("#result").html(info);
		
		});
		}
		
		});      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script>




<?php 
include 'footer.php';
 ?>