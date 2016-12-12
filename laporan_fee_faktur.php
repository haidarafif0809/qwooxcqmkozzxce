<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT f.nama_petugas, f.no_faktur, f.jumlah_fee, f.tanggal, f.jam, u.nama FROM laporan_fee_faktur f INNER JOIN user u ON f.nama_petugas = u.id ORDER BY f.id DESC");

 ?>

<div class="container">
<h3><b> LAPORAN KOMISI FAKTUR </b></h3><hr>
<a href="lap_jumlah_fee_faktur_petugas.php" class="btn btn-info"> <i class="fa fa-list"> </i> KOMISI / PETUGAS</a><br><br>

<div class="table-responsive">
<table id="table_lap_fee_faktur" class="table table-bordered">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>


                  <?php 

                  
                  ?>
                  
            </thead>
            
            <tbody>
          
            </tbody>

      </table>

</div>
</div>


<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_lap_fee_faktur').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"show_data_laporan_fee_faktur.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_lap_fee_faktur").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_lap_fee_faktur_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>
<!--end ajax datatable-->


<?php 
include 'footer.php';
 ?>