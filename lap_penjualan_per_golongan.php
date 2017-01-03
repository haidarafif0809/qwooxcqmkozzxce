<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';

?>

<div class="container">

<h3> LAPORAN PENJUALAN REKAP PER GOLONGAN BARANG </h3><hr>

<form id="perhari" class="form" action="proses_lap_golongan_barang_rekap.php" method="POST" role="form">

<div class="col-sm-2"> 
<select name="golongan" id="golongan" autocomplete="off" class="form-control" placeholder="Golongan" required="">
<option value="Barang">Barang</option>
<option value="Jasa">Jasa</option>
</select>
</div>

<div class="col-sm-2"> 
    <input style="height: 17px" type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
</div>

<div class="col-sm-2"> 
    <input style="height: 17px" type="text" name="dari_jam" id="dari_jam" class="form-control jam_cari" placeholder="Dari Jam" required="">
</div>

<div class="col-sm-2"> 
    <input style="height: 17px" type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal"  required="">
</div>

<div class="col-sm-2"> 
    <input style="height: 17px" type="text" name="sampai_jam" id="sampai_jam" class="form-control jam_cari" placeholder="Sampai Jam" required="">
</div>

<button type="submit" name="submit" id="btntgl" class="btn btn-default" style="background-color:blue"><i class='fa fa-list'></i> Lihat </button>

</form>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="result">
 <div class="card card-block">
 <div class="table-responsive">
    <table id="table_lap" class="table table-bordered table-sm">
 
    <thead>
      <tr>
         <th style="background-color: #4CAF50; color: white;">Nama Produk</th>
         <th style="background-color: #4CAF50; color: white;"> Total Produk</th>        
         <th style="background-color: #4CAF50; color: white;"> Total Nilai </th>

    </tr>
    </thead>
    <tbody>
    
  
  </tbody>
 </table>
</div> <!--  end table responsive  -->
</div>
</span>
<span id="cetak" style="display: none;">
  <a href='cetak_penjualan_rekap_golongan.php' target="blank" id="cetak_lap" class='btn btn-danger'><i class='fa fa-print'> </i> Cetak Penjualan / Golongan</a>
  <a href='export_lap_penjualan_golongan.php' target="blank" id="export_lap" class='btn btn-primary'><i class='fa fa-print'> </i> Export Excel</a>
</span>

</div>

<!--  date and time picker  -->
<script>
  $(function() {
    $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });


</script>

<script type="text/javascript">
  
  $(function(){
    $('.jam_cari').pickatime({
        // 12 or 24 hour 
        twelvehour: false
    });
  });

</script>


<!--  end date and time picker  -->




<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#btntgl',function(e) {
     $('#table_lap').DataTable().destroy();


        var golongan = $("#golongan").val();
        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val();
        var dari_jam = $("#dari_jam").val();        
        var sampai_jam = $("#sampai_jam").val();

          var dataTable = $('#table_lap').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_lap_golongan_barang_rekap.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#dari_tanggal").val();
                d.dari_jam = $("#dari_jam").val();
                d.sampai_tanggal = $("#sampai_tanggal").val();
                d.sampai_jam = $("#sampai_jam").val();
                d.golongan = $("#golongan").val();
                                                                                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    


        });

          $("#result").show()
          $("#cetak").show();
          $("#cetak_lap").attr("href", "cetak_penjualan_rekap_golongan.php?golongan="+golongan+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&dari_jam="+dari_jam+"&sampai_jam="+sampai_jam+"");

          $("#export_lap").attr("href", "export_lap_penjualan_golongan.php?golongan="+golongan+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&dari_jam="+dari_jam+"&sampai_jam="+sampai_jam+"");


   });

  $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };
  } );
    </script>


<?php 
include 'footer.php';
 ?>