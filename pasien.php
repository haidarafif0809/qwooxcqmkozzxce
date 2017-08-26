<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';



?>



  <!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>
      <input type="hidden" id="id2" name="id2" >
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->


<div style="padding-left:5%; padding-right:5%; ">


 <!-- Modal Untuk Upload Excell-->
<div id="modal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <H2>Form Import Excell Pasien</H2>
        <form action="upload_data_pasien.php" method="POST" enctype="multipart/form-data">
        <div class="form-group" style="height:100px;">
        <input type="file" style="height:60px;" class="form-control" id="csv_pasien" name="csv_pasien" required="" autocomplete="off" >

      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary" id="submit"><span class="glyphicon glyphicon-cloud-upload"></span> Export</button>
      </div>
      </form>
    </div>
    <div class="modal-footer">
    </div>
    </div>
  </div>
</div>
<!--modal end Excell Upload -->

   <h3><b>DATA PASIEN</b></h3> <hr>
    <button  data-target="#modal2" data-toggle="modal" type="button" class="btn btn-primary" ><i class="fa fa-cloud-upload"></i> Import Excell</button>
  <a href="tambah_pasien.php" type="button" class="btn btn-success" ><i class="fa fa-plus"></i> Tambah Pasien</a>
  <a href="format_pasien.php" class="btn btn-default" ><i class="fa fa-download"></i> Download Format Pasien</a> 
    <br>
<br>
<form id="form_cari" action="" method="get" accept-charset="utf-8">
  
  <div class="form-group">
    <label for=""><u>C</u>ari Pasien </label>
    <input type="text" accesskey="c" class="form-control" name="cari" autocomplete="off" id="cari_migrasi" style="width:370px;" placeholder="Cari Nama Pasien">
  </div>
  <button id="submit_cari" accesskey="a" class="btn btn-success"><i class="fa fa-search"></i> C<u>a</u>ri</button>

</form>
<br>
<br>
<span id="hasil_migrasi" style="display: none">
  
 <table id="pasien_lama" class="table table-sm table-bordered">
  <thead>
    <tr>
      <th style='background-color: #4CAF50; color: white' >No. RM </th>
      <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
      <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
      <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
      <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
      <th style='background-color: #4CAF50; color: white' >No HP</th>
      <th style='background-color: #4CAF50; color: white' >Tanggal Terdaftar </th>
      <th style='background-color: #4CAF50; color: white' >Hapus</th>
      <th style='background-color: #4CAF50; color: white' >Edit</th>

    </tr>
  </thead>

 </table>

</span>

</div><!--DIV CONTAINER-->



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(document).on('click', '.delete', function (e) {

  var id = $(this).attr('data-id');

$("#modale-delete").modal('show');
$("#id2").val(id);  

});


</script>
<!--   end script modal confiormasi dellete -->

<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$(document).on('click', '#yesss', function (e) {

var id = $("#id2").val();

$.post('delete_data_pasien.php',{id:id},function(data){

      $(".tr-id-"+id+"").remove();
      $("#modale-delete").modal('hide');

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--script datatable-->
<script type="text/javascript">
  $(function () {
  $("table").dataTable({ordering : false});
  });
</script>
<!--end script datatable-->

 
<!--script datepicker-->  
<script type="text/javascript">
 $(function() 
 {
$( "#tanggal_lahir" ).datepicker({
  dateFormat: "yy-mm-dd"
});
});
</script>


<!--end script datepicker-->
  <script type="text/javascript">
  
  $("#submit_cari").click(function(){
  
    var cari = $("#cari_migrasi").val();
    if (cari == '') {
  
  $("#hasil_migrasi").html('');
  
    }
    else
    {

        $('#pasien_lama').DataTable().destroy();

          var dataTable = $('#pasien_lama').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"data_pasien_online.php", // json datasource
             "data": function ( d ) {
                d.cari = $("#cari_migrasi").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#pasien_lama").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#pasien_lama_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "tr-id-"+aData[9]+"");

          }

        } );
$("#hasil_migrasi").show();

  
    }
   
  
  });
  
  $("#form_cari").submit(function(){
    return false;
  });
  </script>

<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->
