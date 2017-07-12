<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

?>


<div style="padding-right: 5%; padding-left: 5%;">
<h3>KOMISI PRODUK / PETUGAS</h3><br><br>


<button type="button" class="btn btn-primary btn-md" id="cari_petugas" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"> </i> Cari Petugas</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data User</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->

 <div class="table-responsive">       
<table id="table_fee_petugas" class="table table-bordered">
    <thead>
      <th> Username </th></th>
      <th> Nama Lengkap </th>
      <th> Alamat </th>
      <th> Otoritas </th>
      <th> Status </th>
    </thead>

  </table>
</div>

          
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>

<br>      

       <div class="row">       
                  <div class="col-sm-2"> 
                  <input type="hidden" name="nama_petugas" id="nama_petugas" class="form-control" placeholder="Nama Petugas">

                  <input type="text" name="nama_petugas_value" style="font-size:15px; height:15px" id="nama_petugas_value" class="form-control" placeholder="Nama Petugas" required="" > 

                  </div>                  


                  <div class="col-sm-2"> 

                  <input type="text" name="dari_tanggal" style="font-size:15px; height:15px" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
                  </div>


                  <div class="col-sm-1"> 

                  <input type="text" name="dari_jam" style="font-size:15px; height:15px"  id="dari_jam" class="form-control jam_cari" placeholder="Dari Jam" required="">
                  </div>

                  <div class="col-sm-2"> 

                  <input type="text" name="sampai_tanggal"  style="font-size:15px; height:15px" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal" required="">
                  </div>

                  <div class="col-sm-1"> 

                  <input type="text" name="sampai_jam" style="font-size:15px; height:15px" id="sampai_jam" class="form-control jam_cari" placeholder="Sampai Jam" required="">
                  </div>

        <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-send"></i>Submit </button>

          </div>

<div class="table-responsive">
<span id="result" style="display: none;"><center><h3>Komisi Sudah Closing</h3></center></span>
<table id="table_petugas" class="table table-bordered" style="display: none;">
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


<span id="result2" style="display: none;"><center><h3>Komisi Belum Closing</h3></center></span>
<table id="table_petugas2" class="table table-bordered" style="display: none;">
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

<span id="note" style="display: none;">
Note : <br>
* Komisi Sudah Closing => Komisi dari transaksi yang sudah terselesaikan (Lunas,Piutang,Simpan Semantara) <br>
* Komisi Belum Closing => Komisi dari transaksi yang bulum terselesaikan (Lunas,Piutang,Simpan Sementara->Rawat Inap) <br>
</span>


<span id="cetak" style="display: none;">
  <a href='cetak_lap_jumlah_fee_produk.php' target="blank" id="cetak_lap" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Komisi / Petugas</a>
  <a href='cetak_lap_jumlah_fee_produk_rekap.php' target="blank" id="cetak_lap_rekap" class='btn btn-warning'><i class='fa fa-print'> </i> Cetak Rekap Komisi / Petugas</a>
</span>
</div>



<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });

 
  // /PICKERDATE
</script>


<script type="text/javascript">
            $(document).ready(function() {
                $('.jam_cari').timepicker({
                    showPeriodLabels: false
                });
              });
</script>

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#table_fee_petugas').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_fee_petugas.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_fee_petugas").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('username', aData[0]);
              $(nRow).attr('data-petugas', aData[1]);
              $(nRow).attr('alamat', aData[2]);
              $(nRow).attr('otoritas', aData[3]);
              $(nRow).attr('status', aData[4]);
              $(nRow).attr('data-petugas-value', aData[5]);
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

        $('#table_petugas').DataTable().destroy();
        $('#table_petugas2').DataTable().destroy();

        var nama_petugas = $("#nama_petugas").val();
        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val();
       var dari_jam = $("#dari_jam").val();        
        var sampai_jam = $("#sampai_jam").val();


          if (nama_petugas == '') {
            alert("Silakan nama petugas diisi terlebih dahulu.");
            $("#cari_petugas").focus();
          } 
          else if (dari_tanggal == '') {
            alert("Silakan dari tanggal diisi terlebih dahulu.");
            $("#dari_tanggal").focus();
          }
          else if (sampai_tanggal == '') {
            alert("Silakan sampai tanggal diisi terlebih dahulu.");
            $("#sampai_tanggal").focus();
          }
          else if (dari_jam == '') {
            alert("Silakan dari jam diisi terlebih dahulu.");
            $("#dari_jam").focus();
          }
          else if (sampai_jam == '') {
            alert("Silakan sampai jam diisi terlebih dahulu.");
            $("#sampai_jam").focus();
          }

            else{ 


          $("#table_petugas").show();
          $("#table_petugas2").show();


              //TABLE KOMISI PRODUK (SUDAH CLOSING)
              var dataTable = $('#table_petugas').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     false,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"datatable_petugas_per_produk.php", // json datasource
                   "data": function ( d ) {
                      d.nama_petugas = $("#nama_petugas").val();
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      d.dari_jam = $("#dari_jam").val();
                      d.sampai_jam = $("#sampai_jam").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table_petugas").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });


               //TABLE KOMISI PRODUK (BELUM CLOSING)
              var dataTable = $('#table_petugas2').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     false,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"datatable_fee_belum_closing.php", // json datasource
                   "data": function ( d ) {
                      d.nama_petugas = $("#nama_petugas").val();
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      d.dari_jam = $("#dari_jam").val();
                      d.sampai_jam = $("#sampai_jam").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table_petugas2").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
    
          $("#cetak").show();
          $("#result").show();
          $("#result2").show();
          $("#note").show();

          $("#cetak_lap").attr("href", "cetak_lap_jumlah_fee_produk.php?dari_tanggal="+dari_tanggal+"&dari_jam="+dari_jam+"&sampai_tanggal="+sampai_tanggal+"&sampai_jam="+sampai_jam+"&nama_petugas="+nama_petugas+"");

          $("#cetak_lap_rekap").attr("href", "cetak_lap_jumlah_fee_produk_rekap.php?dari_tanggal="+dari_tanggal+"&dari_jam="+dari_jam+"&sampai_tanggal="+sampai_tanggal+"&sampai_jam="+sampai_jam+"&nama_petugas="+nama_petugas+"");
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