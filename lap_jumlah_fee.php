<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';



 ?>


<div style="padding-right: 5%; padding-left: 5%;">
<h3>KOMISI / PETUGAS</h3><hr>


<button type="button" class="btn btn-danger btn-md" id="cari_petugas" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"> </i> Cari Petugas</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Daftar Petugas</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->
<span class="modal_baru">
 <div class="table-responsive">       
<table id="table_petugas_fee" class="table table-bordered">
    <thead>
      <th> Username </th></th>
      <th> Nama Lengkap </th>
      <th> Alamat </th>
      <th> Jabatan </th>
      <th> Otoritas </th>
      <th> Status </th>
    </thead>
  </table>
</div>
</span>
          
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>

<br>      
<form class="form-inline" role="form">
              
                  <div class="form-group"> 

                  <input type="hidden" name="nama_petugas" id="nama_petugas" class="form-control" placeholder="Nama Petugas" required="">

                  <input type="text" name="nama_petugas_value" id="nama_petugas_value" class="form-control" placeholder="Nama Petugas" required="" autocomplete="off">

                  </div>                  

                  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-send"></i> Submit </button>

</form>


<span id="result">
<div class="row 1">
<h3><center><b>Komisi Produk / Petugas</b></center></h3><br><br>
<div class="table-responsive">
<table id="table_komisi_faktur" class="table table-bordered table-sm">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Kode Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Nama Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>
            </thead>
      </table>
</div>
</div><!--/div class="row"-->

<br>

<div class="row 2">
<h3><center><b>Komisi Faktur / Petugas</b></center></h3><br><br>
<div class="table-responsive">
<table id="table_komisi_produk" class="table table-bordered table-sm">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>
            </thead>
      </table>
</div>
</div><!--/div class="row"-->
</span>
<span id="cetak" style="display: none;">
  <a href='cetak_laporan_komisi.php' id="cetak_lap" target="blank" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Komisi / Petugas</a>
</span>
</div>

<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  // /PICKERDATE
</script>

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#table_petugas_fee').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_petugas_fee.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_petugas_fee").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('username', aData[0]);
              $(nRow).attr('data-petugas', aData[1]);
              $(nRow).attr('alamat', aData[2]);
              $(nRow).attr('jabatan', aData[3]);
              $(nRow).attr('otoritas', aData[4]);
              $(nRow).attr('status', aData[5]);
              $(nRow).attr('data-petugas-value', aData[6]);
          },

        });    
     
  });
 
 </script>

<script type="text/javascript">
// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("nama_petugas_value").value = $(this).attr('data-petugas');
  document.getElementById("nama_petugas").value = $(this).attr('data-petugas-value');

  $('#myModal').modal('hide');
  });
  </script> <!--tag penutup perintah java script-->


<script type="text/javascript">
// FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
  $(document).ready(function() {
  $(document).on('click','#submit',function(e) {

         $('#table_komisi_produk').DataTable().destroy();
         $('#table_komisi_faktur').DataTable().destroy();
        var nama_petugas = $("#nama_petugas").val();
        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val();
          if (nama_petugas == '') {
            alert("Silakan nama petugas diisi terlebih dahulu.");
            $("#nama_petugas").focus();
          } 
          else if (dari_tanggal == '') {
            alert("Silakan dari tanggal diisi terlebih dahulu.");
            $("#dari_tanggal").focus();
          }
          else if (sampai_tanggal == '') {
            alert("Silakan sampai tanggal diisi terlebih dahulu.");
            $("#sampai_tanggal").focus();
          }
            else{ 
              //TABLE KOMISI PRODUK
              var dataTable = $('#table_komisi_faktur').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     false,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"datatable_komisi_faktur_per_petugas.php", // json datasource
                   "data": function ( d ) {
                      d.nama_petugas = $("#nama_petugas").val();
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table_komisi_faktur").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });

              ////TABLE KOMISI FAKTUR
              var dataTable = $('#table_komisi_produk').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     false,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"datatable_komisi_produk_per_petugas.php", // json datasource
                   "data": function ( d ) {
                      d.nama_petugas = $("#nama_petugas").val();
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table_komisi_produk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
    
    $("#cetak").show();
    $("#cetak_lap").attr("href", "cetak_laporan_komisi.php?nama_petugas="+nama_petugas+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
}//end else
        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // /FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
</script>

<?php 
include 'footer.php';
 ?>