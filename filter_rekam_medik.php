<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include_once 'db.php';
 ?>

<div class="container">

 <h3>FILTER REKAM MEDIK RAWAT JALAN</h3><hr>

<div class="col-sm-12">
  
<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
      <li class="nav-item"><a class="nav-link " href='rekam_medik_raja.php'> Pencarian Rekam Medik </a></li>
        <li class="nav-item"><a class="nav-link active" href='filter_rekam_medik.php' > Filter Rekam Medik </a></li>
</ul>
<br><br>
</div>

<div class="row">
   <div class="col-sm-2">

<div class="card card-block">
 
     <form role="form"  id="formcari" method="post">

<div class="form-group">
  <label>Dari Tanggal</label>
  <input style="height: 15px" type="text" id="dari_tanggal" class="form-control" autocomplete="off" name="dari_tanggal">
</div>  

<div class="form-group">
  <label>Sampai Tanggal</label>
  <input style="height: 15px" type="text" id="sampai_tanggal" class="form-control" autocomplete="off" name="sampai_tanggal">
</div>  



<div class="form-group">
  <label>Cari Berdasarkan :</label>
   <select id="cari_berdasarkan" class="form-control" autocomplete="off" name="cari_berdasarkan">
    <option value="">Silakan Pilih </option>
    <option value="no_rm">No RM</option>
    <option value="nama">Nama</option>
  </select> 
</div>  

<div class="form-group">
  <label>Pencarian</label>
  <input style="height: 15px" type="text" id="pencarian" autocomplete="off" class="form-control" name="pencarian">
</div>  

<button type="submit" class="btn btn-info" id="submit" > <i class="fa fa-search"></i>  Cari</button>


</form>
</div>

<br>

 </div><!—- akhir div col-sm-3 form data pasien -->
 <div class="col-sm-10">
   
<span id="result">
  <br>


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>


<div class="table-responsive">
 <table id="table-group" class="table table-bordered table-sm"> 
    <thead>
      <tr>

         <th style='background-color: #4CAF50; color: white' >No Reg </th>
         <th style='background-color: #4CAF50; color: white' >Nama Pasien</th>
         <th style='background-color: #4CAF50; color: white' >Tanggal Periksa</th>
         <th style='background-color: #4CAF50; color: white' >Nama Dokter</th>
         <th style='background-color: #4CAF50; color: white' >Poli</th>

    </tr>
    </thead>
    <tbody>
  
  </tbody>
 </table>
</div>
 </span>


<span id="result1">


</span>

 </div>

   




</div>

<script>
  $(document).ready(function() {
  $( "#sampai_tanggal" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  </script>
<!--end script datepicker-->

<script>
  $(document).ready(function() {
  $( "#dari_tanggal" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  </script>
<!--end script datepicker-->
 

    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#submit',function(e) {
     $('#table-group').DataTable().destroy();

var dataTable = $('#table-group').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"tampil_rekam_medik.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $('#dari_tanggal').val();
                d.sampai_tanggal = $('#sampai_tanggal').val();
                d.cari_berdasarkan  = $('#cari_berdasarkan').val();
                d.pencarian  = $('#pencarian').val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-group").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-group_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','rekam-medik');
              $(nRow).attr('data-no',aData[5]);
    },
    


        } );

   } );  
  $("#formcari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#formcari :input").each(function(){
          $(this).val('');
      });
  };
  } );
    </script>

<script type="text/javascript">
//            jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.rekam-medik', function (e) {
                var id = $(this).attr('data-no');

               $.post("tampil_data_rekam_medik.php",{id:id},function(info){
                 $("#result1").html(info);

               });
            });
      
</script>

<?php 
include 'footer.php';
 ?>