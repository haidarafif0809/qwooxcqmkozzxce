<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel REGISTRASI (Rawat Jalan)
$select_rj = $db->query("SELECT * FROM registrasi WHERE jenis_pasien = 'Rawat Jalan'");
$out_rj = mysqli_fetch_array($select_rj);





 ?>

 <div class="container">

<h3><b><center>Laporan Kunjungan Pasien UGD</center></b></h3>

<div class="btn-group">
   <button class="btn btn-danger dropdown-toggle" type="button" id="myDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Cari Berdasarkan
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" id="nav_rm" href="#">No RM</a>
        <a class="dropdown-item" id="nav_tanggal" href="#">Tanggal</a>
        <a class="dropdown-item" id="nav_ex" href="#">No RM dan Tanggal</a>

    </div>
</div>


<span id="show_no_rm"><!--span untuk cari bersarkan No RM-->
<form class="form-inline" role="form" id="form_tanggal" >
	<div class="form-group"> 
	<input type="text" name="no_rm" id="no_rm" autocomplete="off" class="form-control" placeholder="No RM" >
	</div>
	<button type="submit" name="submit" id="lihat_rm" class="btn btn-default " style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span><!--Akhir span untuk cari bersarkan No RM-->

<span id="show_tanggal"><!--span untuk cari bersarkan tanggal-->
<form class="form-inline" role="form" id="form_tanggal">
<div class="form-group"> 
	<input type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
	<input type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_tanggal" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span><!--Akhir span untuk cari bersarkan tanggal-->

<span id="show_ex"><!--span untuk cari bersarkan tanggal-->
<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group"> 
	<input type="text" name="no_rm_ex" id="no_rm_ex" autocomplete="off" class="form-control" placeholder="No RM" >
	</div>

<div class="form-group"> 
	<input type="text" name="dari_tanggal_ex" id="dari_tanggal_ex" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
	<input type="text" name="sampai_tanggal_ex" id="sampai_tanggal_ex" autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_ex" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span><!--Akhir span untuk cari bersarkan tanggal-->
<br>


<br>
<div class="table-responsive">
<span id="result"><!--span untuk table-->       
    <table id="table_lap_rj" class="table table-bordered table-sm">
        <thead>
			<th style='background-color: #4CAF50; color:white'> No RM </th>
			<th style='background-color: #4CAF50; color:white'> No REG </th>
			<th style='background-color: #4CAF50; color:white'> Nama Pasien </th>
			<th style='background-color: #4CAF50; color:white'> Jenis Kelamin </th>
			<th style='background-color: #4CAF50; color:white'> Umur </th>
			<th style='background-color: #4CAF50; color:white'> Alamat Pasien </th>
			<th style='background-color: #4CAF50; color:white'> Penjamin </th>
			<th style='background-color: #4CAF50; color:white'> No Handphone </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Periksa </th>

            
           </thead>

        <tbody>
            
      </tbody>
     </table>
</span><!--akhir span untuk table-->
</div>

</div><!--Div Countainer-->


<script type="text/javascript">
        $("#lihat_rm").click(function(){
        
        var no_rm = $("#no_rm").val();        
        
        $.post("show_lap_kunjungan_ugd.php", {no_rm:no_rm},function(info){
        
        $("#result").html(info);

        });
        });
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>

<script type="text/javascript">
        $("#lihat_tanggal").click(function(){
        
        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val();        

        $.post("show_lap_kunjungan_tanggal_ugd.php", {dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){
        
        $("#result").html(info);

        });
        
        
        });      
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>

<script type="text/javascript">
        $("#lihat_ex").click(function(){
        var no_rm_ex = $("#no_rm_ex").val();        
        var dari_tanggal_ex = $("#dari_tanggal_ex").val();        
        var sampai_tanggal_ex = $("#sampai_tanggal_ex").val();        

        $.post("show_lap_ex_ugd.php", {dari_tanggal_ex:dari_tanggal_ex,sampai_tanggal_ex:sampai_tanggal_ex,no_rm_ex:no_rm_ex},function(info){
        
        $("#result").html(info);

        });
        
        
        });      
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>
<script type="text/javascript">
   $(document).ready(function(){
      $("#show_no_rm").hide();
      $("#show_tanggal").hide();
      $("#show_ex").hide();

  });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#nav_rm").click(function(){    
    $("#show_no_rm").show();
    $("#show_tanggal").hide();
    $("#show_ex").hide();
    });

    $("#nav_tanggal").click(function(){    
    $("#show_tanggal").show();  
    $("#show_no_rm").hide();
    $("#show_ex").hide();
    });

    $("#nav_ex").click(function(){
    $("#show_ex").show();  
    $("#show_tanggal").hide();  
    $("#show_no_rm").hide();
	});

});
</script>


<script>
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  </script>

  <script>
  $(function() {
$('.dropdown-toggle').dropdown()
  });
  </script>

<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table_lap_rj').DataTable({"ordering":false});
    });

</script>


<?php 
include 'footer.php';
 ?>












