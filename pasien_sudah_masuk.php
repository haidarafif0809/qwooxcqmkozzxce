<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$tanggal = date("Y-m-d");


$sett_registrasi= $db->query("SELECT * FROM setting_registrasi ");
$data_sett = mysqli_fetch_array($sett_registrasi);

$pilih_akses_registrasi_rj = $db->query("SELECT registrasi_rj_lihat, registrasi_rj_tambah, registrasi_rj_edit, registrasi_rj_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_rj = mysqli_fetch_array($pilih_akses_registrasi_rj);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);


$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_rj_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);

?>

<style>
.disable1
{
background-color:#cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable2
{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable3
{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable4
{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable5
{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable6
{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}

</style>

<!-- Modal Untuk Confirm rUJUKAN KE RAWAT INAP-->
<div id="modal_rujuk_ri" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <span id="tampil_rujuk_inap">
      </span>
    </div>
    <div class="modal-footer">    
       <center><button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Closed</button></center>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan RUJUK KE RAWAT INAP--> 

<!-- Modal Untuk Confirm rujuk KE LUAR RS WITH PENANGANAN-->
<div id="rujuk_penanganan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">

<h3>Keterangan Rujuk Rawat Jalan Dengan Penanganan</h3>
<form role="form" action="proses_keterangan_rujuk" method="POST">

<div class="form-group">
  <textarea type="text" class="form-control" id="keterangan2" name="keterangan2"></textarea>
</div>


<button type="submit" id="submit_rujuk_penanganan" data-id="" data-reg="" class="btn btn-info"><i class='fa fa-plus'></i>Input Keterangan</button>
</form>

      </span>
    </div>
    <div class="modal-footer">       
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end RUJUK LUAR RS WITH PENANGANAN-->



<!-- Modal Untuk Confirm rujuk KE LUAR RS TANPA PENANGANAN-->
<div id="rujuk_non_penanganan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">

      <h3>Keterangan Rujuk Rawat Jalan Tanpa Penanganan</h3>
<form role="form" method="POST">

<div class="form-group">
  <textarea type="text" class="form-control" id="keterangan12" name="keterangan12"></textarea>

</div>


<button type="submit" id="submit_rujuk_non_penanganan" data-id="" data-reg="" class="btn btn-info">Input Keterangan</button>
</form>

      </span>
    </div>
    <div class="modal-footer">       
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end RUJUK LUAR RS TANPA PENANGANAN-->

<!-- Modal Untuk Confirm BATAL RAWAT-->
<div id="detail2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">

      <h1>Keterangan Batal Rawat Jalan</h1>
<form role="form" method="POST">
<div class="form-group">
  <label for="sel1">Keterangan Batal </label>
  <textarea type="text" class="form-control" id="keterangan_batal" name="keterangan"></textarea>
</div>


<button type="submit" class="btn btn-info" id="batal_jalan" data-id="" data-reg="">Input Keterangan</button>
</form>

      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end BATAL RAWAT-->

<div style="padding-left: 5%; padding-right: 5%">

<?php 
if ($registrasi_rj['registrasi_rj_lihat'] > 0) {

  echo "<h3>DATA PASIEN REGISTRASI RAWAT JALAN</h3><hr>";

}
else
{
    echo "<h3>DATA PENJUALAN RAWAT JALAN</h3><hr>";

}
?>
<!-- Nav tabs -->

<ul class="nav nav-tabs yellow darken-4" role="tablist">
<?php 
if ($registrasi_rj['registrasi_rj_lihat'] > 0) {
        echo "<li class='nav-item'><a class='nav-link' href='registrasi_raja.php'> Antrian Pasien R. Jalan </a></li>";
        echo "<li class='nav-item'><a class='nav-link' href='pasien_sudah_panggil.php' > Pasien Dipanggil </a></li>";
      }
      else{
      echo "<li></li>";
      echo "<li></li>";
      }
 ?> 
       <li class="nav-item"><a class="nav-link active" href='pasien_sudah_masuk.php' > Pasien Masuk R.Dokter </a></li>

 <?php 
if ($registrasi_rj['registrasi_rj_lihat'] > 0) {
        echo "<li class='nav-item'><a class='nav-link' href='pasien_batal_rujuk.php' > Pasien Batal / Rujuk Ke Luar </a></li>
        <li class='nav-item'><a class='nav-link' href='pasien_registrasi_rj_belum_selesai.php' >Pasien Belum Selesai Registrasi </a></li>";
}
      else{
      echo "<li></li>";
      echo "<li></li>";
      }
        ?>
</ul>
<br><br>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<!-- PEMBUKA DATA TABLE -->

<span id="tabel-jalan">
<div class="table-responsive">
<table id="pasien_masuk" class="display table table-bordered table-sm">
    <thead>
      <tr>
             <th style='background-color: #4CAF50; color: white' >Transaksi Penjualan</th>
<?php if ($registrasi_rj['registrasi_rj_lihat'] > 0): ?>         
             <th style='background-color: #4CAF50; color: white' >Rujuk Dengan Penanganan</th>
             <th style='background-color: #4CAF50; color: white' >Rujuk Tanpa Penanganan </th>
             <th style='background-color: #4CAF50; color: white' >Rujuk Rawat Inap</th>
             <th style='background-color: #4CAF50; color: white' >Rujuk Lab</th>
             <th style='background-color: #4CAF50; color: white' >Input Hasil Lab</th>
<?php endif?>
<?php if ($rekam_medik['rekam_medik_rj_lihat'] > 0): ?>                      
             <th style='background-color: #4CAF50; color: white' >Rekam Medik</th>
<?php endif?>

<?php if ($registrasi_rj['registrasi_rj_edit'] > 0): ?>         
             <th style='background-color: #4CAF50; color: white' >Edit</th> 
<?php endif?>  

<?php if ($registrasi_rj['registrasi_rj_hapus'] > 0): ?>         
             <th style='background-color: #4CAF50; color: white' >Batal</th> 
<?php endif?>                  
             <th style='background-color: #4CAF50; color: white' >No Urut</th>
             <th style='background-color: #4CAF50; color: white' >Poli</th> 
             <th style='background-color: #4CAF50; color: white' >Dokter</th>   
             <th style='background-color: #4CAF50; color: white' >No REG</th>
             <th style='background-color: #4CAF50; color: white' >No RM </th>
             <th style='background-color: #4CAF50; color: white' >Tanggal</th>       
             <th style='background-color: #4CAF50; color: white' >Nama Pasien</th>
             <th style='background-color: #4CAF50; color: white' >Penjamin</th>
             <th style='background-color: #4CAF50; color: white' >Umur</th>
             <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
             <th style='background-color: #4CAF50; color: white' >Keterangan</th>        
    </tr>
    </thead>
 </table>
</div><!--div responsive-->
 <!-- AKHIR TABLE -->





</span>

</div> <!--container-->



<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
  <script type="text/javascript">
    $(document).on('click', '.pilih1', function (e) {

    var id = $(this).attr('data-id');
    var reg = $(this).attr('data-reg');

          $("#rujuk_penanganan").modal('show');
          $("#submit_rujuk_penanganan").attr("data-id",id);
          $("#submit_rujuk_penanganan").attr("data-reg",reg);

  });

</script>

<script type="text/javascript">
     $(document).on('click', '#submit_rujuk_penanganan', function (e) {    
                    var keterangan = $("#keterangan2").val();
                    var reg = $(this).attr("data-reg");
                    var id = $(this).attr("data-id");                   
                    
                    $("#rujuk_penanganan").modal('hide');
                    
                    $.post("proses_keterangan_rujuk.php",{reg:reg, keterangan:keterangan},function(data){
                      $('#pasien_masuk').DataTable().destroy();
     
                  var dataTable = $('#pasien_masuk').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "ajax":{
                        url :"datatable_pasien_masuk_rj.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".employee-grid-error").html("");
                          $("#pasien_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                          $("#employee-grid_processing").css("display","none");
                          }
                      },
                         "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                          $(nRow).attr('class','tr-id-'+aData[20]+'');         

                      }
                    });
                    });

                    
        }); 

     
</script>




<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
  <script type="text/javascript">
    $(document).on('click', '.pilih1', function (e) {

    var id = $(this).attr('data-id');
    var reg = $(this).attr('data-reg');

          $("#rujuk_non_penanganan").modal('show');
          $("#submit_rujuk_non_penanganan").attr("data-id",id);
          $("#submit_rujuk_non_penanganan").attr("data-reg",reg);

  });

</script>

<script type="text/javascript">
     $(document).on('click', '#submit_rujuk_non_penanganan', function (e) {    
                    var keterangan = $("#keterangan12").val();
                    var reg = $(this).attr("data-reg");
                    var id = $(this).attr("data-id");                   
                    
                    $("#rujuk_penanganan").modal('hide');
                    
                    $.post("proses_keterangan_rujuk_non.php",{reg:reg, keterangan:keterangan},function(data){
                      $('#pasien_masuk').DataTable().destroy();
     
                  var dataTable = $('#pasien_masuk').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "ajax":{
                        url :"datatable_pasien_masuk_rj.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".employee-grid-error").html("");
                          $("#pasien_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                          $("#employee-grid_processing").css("display","none");
                          }
                      },
                         "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                          $(nRow).attr('class','tr-id-'+aData[20]+'');         

                      }
                    });
                    });

                    
        }); 

     
</script>

<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
  <script type="text/javascript">
$(document).on('click', '.pilih12', function (e) {  

    var id = $(this).attr('data-id');
    var reg = $(this).attr('data-reg');

          $("#rujuk_non_penanganan").modal('show');
          $("#submit_rujuk_non_penanganan").attr("data-id",id);
          $("#submit_rujuk_non_penanganan").attr("data-reg",reg);

  });

  $("#submit_rujuk_non_penanganan").click(function(){  
    var keterangan = $("#keterangan12").val();
    var reg = $(this).attr("data-reg");
    var id = $(this).attr("data-id");

            $("#rujuk_non_penanganan").modal('hide');
            
            $.post("proses_keterangan_rujuk_non.php",{reg:reg,keterangan:keterangan},function(data){
            
            $(".tr-id-"+id+"").remove();


            });


   });
     

   $("form").submit(function(){
       return false;
       });
//            tabel lookup mahasiswa         
</script>



<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
  <script type="text/javascript"> 
    $(document).on('click', '.pilih2', function (e) {

    var id = $(this).attr('data-id');
    var reg = $(this).attr('data-reg');

          $("#detail2").modal('show');
          $("#batal_jalan").attr("data-id",id);
          $("#batal_jalan").attr("data-reg",reg);

  });

  $("#batal_jalan").click(function(){  
    var keterangan = $("#keterangan_batal").val();
    var id = $(this).attr("data-id");
    var reg = $(this).attr("data-reg");

        if (keterangan == '') {
          alert("Keterangan batal Harus Diisi");
          $("#keterangan_batal").focus();
        }
        else
        {
            
            $.post("proses_keterangan_batal.php",{reg:reg,keterangan:keterangan},function(data){
            $(".tr-id-"+id+"").remove();
            $("#detail2").modal('hide');

            });


        }

         var table = $('#pasien_masuk').DataTable(); 
         table.row( $(this).parents('tr') ).remove().draw();

   });
     

   $("form").submit(function(){
       return false;
       });
//            tabel lookup mahasiswa         
</script>
<!--  end script untuk akhir detail layanan PERUSAHAAN -->


<!--   script untuk detail layanan MERUJUK-->
<script type="text/javascript">  
    $(document).on('click', '.rujuk_ri', function (e) {
            var reg = $(this).attr('data-reg');
         
                $.post("rujuk_ri_ugd.php",{reg:reg},function(data){
                    $("#tampil_rujuk_inap").html(data);
               $("#modal_rujuk_ri").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         
</script>
<!--  end script untuk akhir detail RUJUK-->


<!-- DATATABLE AJAX PASIEN LAMA-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#pasien_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_pasien_masuk_rj.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#pasien_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih tr-id-"+aData[20]);

              $(nRow).attr('data-no', aData[0]);
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-jenis-kelamin', aData[2]);
              $(nRow).attr('data-alamat', aData[3]);
              $(nRow).attr('data-lahir', aData[4]);
              $(nRow).attr('data-darah', aData[5]);
              $(nRow).attr('data-hp', aData[6]);
              $(nRow).attr('data-penjamin', aData[7]);

          }

        });
      });
    </script>
<!-- / DATATABLE AJAX PASIEN LAMA-->


<!--footer -->
<?php
 include 'footer.php';
?>   
<!--end footer-->
