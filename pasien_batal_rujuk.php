<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$tanggal = date("Y-m-d");

?>


<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">    
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->


<style>
.disable1{
background-color:#cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable2{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable3{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable4{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable5{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable6{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}

</style>


<div style="padding-left:5%; padding-right:5%;">

<h3>DATA PASIEN REGISTRASI RAWAT JALAN</h3><hr>


<ul class="nav nav-tabs yellow darken-4" role="tablist">
        <li class="nav-item"><a class="nav-link" href='registrasi_raja.php'> Antrian Pasien R. Jalan </a></li>
        <li class="nav-item"><a class="nav-link" href='pasien_sudah_panggil.php' > Pasien Dipanggil </a></li>
        <li class="nav-item"><a class="nav-link" href='pasien_sudah_masuk.php' > Pasien Masuk R.Dokter </a></li>
        <li class="nav-item"><a class="nav-link active" href='pasien_batal_rujuk.php' > Pasien Batal / Rujuk Ke Luar </a></li>
        <li class="nav-item"><a class="nav-link" href='pasien_registrasi_rj_belum_selesai.php' >Pasien Belum Selesai Pembayaran </a></li>
</ul>
<br><br>


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<!-- PEMBUKA DATA TABLE -->

<span id="tabel-jalan">
<div class="table-responsive">
<table id="table_br_rawat_jalan" class="table table-bordered">
    <thead>
      <tr>
             <th style='background-color: #4CAF50; color: white'>No REG</th>
             <th style='background-color: #4CAF50; color: white'>No RM </th>
             <th style='background-color: #4CAF50; color: white'>Tanggal</th>       
             <th style='background-color: #4CAF50; color: white'>Nama Pasien</th>
             <th style='background-color: #4CAF50; color: white'>Penjamin</th>
             <th style='background-color: #4CAF50; color: white'>Umur</th>
             <th style='background-color: #4CAF50; color: white'>Jenis Kelamin</th>
             <th style='background-color: #4CAF50; color: white'>Keterangan</th>
             <th style='background-color: #4CAF50; color: white'>Dokter</th>
             <th style='background-color: #4CAF50; color: white'>Poli</th>               
             <th style='background-color: #4CAF50; color: white'>No Urut</th>
             <th style='background-color: #4CAF50; color: white'>Status</th>          
    </tr>
    </thead>
    
 </table>
</div><!--div responsive-->
 <!-- AKHIR TABLE -->



</span>
</div> <!--container-->

<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_batal_rujuk.php',{q:q},function(data)
{
  $("#tabel-jalan").html(data);
  
});
});
</script>
<!-- END script cari untuk pegy natio -->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_br_rawat_jalan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_pasien_batruj.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_br_rawat_jalan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[12]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>

<!--footer -->
<?php
 include 'footer.php';
?>
<!--end footer-->



















