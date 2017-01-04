<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

 <div class="container">

<h3><b><center>Laporan Kunjungan Pasien Rawat Jalan</center></b></h3>

<div class="btn-group">
   <button class="btn btn-danger dropdown-toggle" type="button" id="myDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Cari Berdasarkan
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" id="nav_rm" href="#">No RM</a>
        <a class="dropdown-item" id="nav_tanggal" href="#">Tanggal</a>
        <a class="dropdown-item" id="nav_ex" href="#">No RM dan Tanggal</a>
        <a class="dropdown-item" id="nav_penjamin" href="#">Penjamin Dan Periode</a>

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

<!--=========show tanggal============-->

<span id="show_tanggal"><!--span untuk cari bersarkan tanggal-->
<form class="form-inline" role="form" id="form_tanggal">
<div class="form-group"> 
	<input type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
	<input type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_tanggal" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span><!--Akhir span untuk cari bersarkan tanggal-->

<!--========show ex=============-->

<span id="show_ex"><!--span untuk cari bersarkan tanggal-->
<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group"> 
	<input type="text" name="no_rm_ex" id="no_rm_ex" autocomplete="off" class="form-control" placeholder="No RM" >
	</div>

<div class="form-group"> 
	<input type="text" name="dari_tanggal_ex" id="dari_tanggal_ex" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
	<input type="text" name="sampai_tanggal_ex" id="sampai_tanggal_ex"  autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_ex" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span><!--Akhir span untuk cari bersarkan tanggal-->
<br>

<!--=====AWAL CARI BERDASARKAN PENJAMIN DAN PERIODE-->
<span id="show_penjamin"><!--span PENJAMIN-->
<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group"> 
  <select type="text" name="penjamin" id="penjamin" autocomplete="off" class="form-control" placeholder="Penjamin" >
  <option>Pilih Penjamin</option>
  <?php 
    $pilih = $db->query("SELECT nama FROM penjamin ");
    while ($iya = mysqli_fetch_array($pilih)) {
      
    echo "<option value=".$iya['nama'].">".$iya['nama']."</option>";
  }
   ?>
  </select>
  </div>

<div class="form-group"> 
  <input type="text" name="dari_tanggal_penj" id="dari_tanggal_penj" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal_penj" id="sampai_tanggal_penj" autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_penj" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span><!--Akhir span PENJAMIN-->
<!--AKHIR CARI BERDASARKAN  PENJAMIN DAN PERIODE-->

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

     </table>
</span><!--akhir span untuk table-->
</div>

<div class="table-responsive">
<span id="berdasarkan_penjamin" style="display: none;"><!--span untuk table-->       
    <table id="table_lap_rj_penjamin" class="table table-bordered table-sm">
        <thead>
          <th style='background-color: #4CAF50; color:white'> No RM </th>
          <th style='background-color: #4CAF50; color:white'> No REG </th>
          <th style='background-color: #4CAF50; color:white'> Nama Pasien </th>
          <th style='background-color: #4CAF50; color:white'> Jenis Kelamin </th>
          <th style='background-color: #4CAF50; color:white'> Umur </th>
          <th style='background-color: #4CAF50; color:white'> Alamat Pasien </th>
          <th style='background-color: #4CAF50; color:white'> No Handphone </th>
          <th style='background-color: #4CAF50; color:white'> Penjamin </th>
          <th style='background-color: #4CAF50; color:white'> Tanggal Periksa </th>
          <th style='background-color: #4CAF50; color:white'> Jumlah </th>
        </thead>
     </table>
</span><!--akhir span untuk table-->
</div>

<span id="download_exc">
<a href='export_excel_kunjungan_pasien_rm_rj.php' type='submit' id='btn_exc' class='btn btn-warning btn-lg'>Download Excel</a>
</span>

<span id="download_exc_tanggal">
<a href='export_excel_kunjungan_pasien_tanggal_rj.php' type='submit' id='btn_exc_tanggal'  class='btn btn-warning btn-lg'>Download Excel</a>
</span>

<span id="download_exc_rm_tanggal">
<a href='export_excel_ex_rj.php' type='submit' id='btn_exc_rm_tanggal' class='btn btn-warning btn-lg'>Download Excel</a>
</span>

<span id="download_exc_penjamin">
<a href='export_excel_ex_rj_penjamin.php' type='submit' id='btn_exc_penjamin' class='btn btn-warning btn-lg'>Download Excel</a>
</span>

</div><!--Div Countainer-->


<script type="text/javascript">
//berdasarkan no rm
  $(document).ready(function() {
$(document).on('click','#lihat_rm',function(e) {
        $('#result').show();
        $('#berdasarkan_penjamin').hide();
         $('#table_lap_rj').DataTable().destroy();

          var no_rm = $("#no_rm").val();
          if (no_rm == '') {
          alert("Silakan isi no. rm terlebih dahulu");
        }
        else{
          var dataTable = $('#table_lap_rj').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_table_lab_kunjungan_rm.php", // json datasource
             "data": function ( d ) {
                d.no_rm = $("#no_rm").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_rj").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    
        });
        }
  $("#download_exc").show();
   $("#download_exc_tanggal").hide();
  $("#download_exc_rm_tanggal").hide();
  $("#download_exc_penjamin").hide();
  $("#btn_exc").attr("href", "export_excel_kunjungan_pasien_rm_rj.php?no_rm="+no_rm+"");

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });   
</script>

<script type="text/javascript">
//berdasarkan tanggal
         $(document).ready(function() {
$(document).on('click','#lihat_tanggal',function(e) {
        $('#result').show();
        $('#berdasarkan_penjamin').hide();

         $('#table_lap_rj').DataTable().destroy();

        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val(); 
        if (dari_tanggal == '') {
          alert("Silakan tentukan dari tanggal terlebih dahulu");
        }
        else if (sampai_tanggal == '') {
          alert("Silakan tentukan sampai tanggal terlebih dahulu");
        }
        else{

          var dataTable = $('#table_lap_rj').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":    "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_table_lab_kunj_tgl_rj.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#dari_tanggal").val();
                d.sampai_tanggal = $("#sampai_tanggal").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_rj").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    
        });
      }
  $("#download_exc_tanggal").show();
   $("#download_exc_rm_tanggal").hide();
  $("#download_exc_penjamin").hide();
    $("#download_exc").hide();
  $("#btn_exc_tanggal").attr("href", "export_excel_kunjungan_pasien_tanggal_rj.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });   
</script>



<script type="text/javascript">
//berdasrkan rm dan tanggal
        $(document).ready(function() {
$(document).on('click','#lihat_ex',function(e) {
        $('#result').show();
        $('#berdasarkan_penjamin').hide();

         $('#table_lap_rj').DataTable().destroy();

          var no_rm = $("#no_rm_ex").val();
        var dari_tanggal = $("#dari_tanggal_ex").val();        
        var sampai_tanggal = $("#sampai_tanggal_ex").val(); 
        if (no_rm == '') {
          alert("Silakan isi no. rm terlebih dahulu");
        }
        else if (dari_tanggal == '') {
          alert("Silakan tentukan dari tanggal terlebih dahulu");
        }
        else if (sampai_tanggal == '') {
          alert("Silakan tentukan sampai tanggal terlebih dahulu");
        }
        else{

          var dataTable = $('#table_lap_rj').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_table_lab_kunj_mix.php", // json datasource
             "data": function ( d ) {
                 d.no_rm_ex    = $("#no_rm_ex").val();
                d.dari_tanggal_ex = $("#dari_tanggal_ex").val();
                d.sampai_tanggal_ex = $("#sampai_tanggal_ex").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_rj").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    
        });
      }
  $("#download_exc_tanggal").hide();
   $("#download_exc_rm_tanggal").show();
  $("#download_exc_penjamin").hide();
    $("#download_exc").hide();
  $("#btn_exc_rm_tanggal").attr("href", "export_excel_ex_rj.php?no_rm="+no_rm+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });     
</script>

<script type="text/javascript">
//berdasrkan penjamin dan periode
        $(document).ready(function() {
$(document).on('click','#lihat_penj',function(e) {
        $('#result').hide();
        $('#berdasarkan_penjamin').show();

         $('#table_lap_rj_penjamin').DataTable().destroy();

        var penjamin = $("#penjamin").val();
        var dari_tanggal = $("#dari_tanggal_penj").val();        
        var sampai_tanggal = $("#sampai_tanggal_penj").val(); 
        if (penjamin == '') {
          alert("Silakan isi penjamin terlebih dahulu");
        }
        else if (dari_tanggal == '') {
          alert("Silakan tentukan dari tanggal terlebih dahulu");
        }
        else if (sampai_tanggal == '') {
          alert("Silakan tentukan sampai tanggal terlebih dahulu");
        }
        else{
          var dataTable = $('#table_lap_rj_penjamin').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"datatable_lab_kunj_rj_penjamin.php", // json datasource
             "data": function ( d ) {
                 d.penjamin    = $("#penjamin").val();
                d.dari_tanggal_penjamin = $("#dari_tanggal_penj").val();
                d.sampai_tanggal_penjamin = $("#sampai_tanggal_penj").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_rj_penjamin").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
            }
          }
    
        });
      }
  $("#download_exc_tanggal").hide();
 $("#download_exc_penjamin").show();
   $("#download_exc_rm_tanggal").hide();
    $("#download_exc").hide();
  $("#btn_exc_penjamin").attr("href", "export_excel_ex_rj_penjamin.php?penjamin="+penjamin+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });     
</script>



<script type="text/javascript">
      $(document).ready(function() {
        var dataTable = $('#table_lap_rj').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_kunj_all_rj.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_rj").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_rj_processing").css("display","none");
                
            }
          }
        } );
      } );                  
</script> 
     

<script type="text/javascript">
   $(document).ready(function(){
      $("#show_no_rm").hide();
      $("#show_tanggal").hide();
      $("#show_penjamin").hide();
      $("#show_ex").hide();
      $("#download_exc").hide();
      $("#download_exc_penjamin").hide();
      $("#download_exc_tanggal").hide();
      $("#download_exc_rm_tanggal").hide();
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#nav_rm").click(function(){    
    $("#show_no_rm").show();
    $("#show_tanggal").hide();
    $("#show_ex").hide();
    $("#show_penjamin").hide();
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
    $("#show_penjamin").hide();
    });

    $("#nav_penjamin").click(function(){
    $("#show_penjamin").show();  
    $("#show_ex").hide();  
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



<?php 
include 'footer.php';
 ?>












