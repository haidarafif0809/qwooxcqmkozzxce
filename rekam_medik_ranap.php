<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ri_lihat, rekam_medik_ri_tambah, rekam_medik_ri_edit, rekam_medik_ri_hapus FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);

 ?>
 
<div style="padding-left: 5%; padding-right: 5%">
 <h3>DATA REKAM MEDIK RAWAT INAP</h3><hr>

<!-- akhir menu rekam medik -->
<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
<?php if ($rekam_medik['rekam_medik_ri_tambah'] > 0): ?>
  
      <li class="nav-item"><a href="tambah_rekam_medik_ri.php" id="link" class="btn btn-success" > <i class="fa fa-plus"></i> Tambah Rekam Medik</a></li>

<?php endif ?>
      <li class="nav-item"><a class="nav-link active" href='rekam_medik_ranap.php'> Pencarian Rekam Medik </a></li>
      <li class="nav-item"><a class="nav-link " href='filter_rekam_medik_ranap.php' > Filter Rekam Medik </a></li>
</ul>
<br>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_rekam_medik_ranap.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_inap").append('<tbody class="tbody"><tr><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>

<span id="tmpl-form">

 <div class="table-responsive">
<table id="table_inap" class="table table-bordered table-sm">
 
    <thead>
      <tr>
         <th style='background-color: #4CAF50; color: white' >No Reg </th>
         <th style='background-color: #4CAF50; color: white' >No RM  </th>
         <th style='background-color: #4CAF50; color: white' >Nama</th>
         <th style='background-color: #4CAF50; color: white' >Alamat</th>
         <th style='background-color: #4CAF50; color: white' >Umur</th>
         <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th> 
         <th style='background-color: #4CAF50; color: white' >Poli</th>
         <th style='background-color: #4CAF50; color: white' >Dokter Penanggung Jawab</th>
         <th style='background-color: #4CAF50; color: white' >Dokter Pelaksana </th>
         <th style='background-color: #4CAF50; color: white' >Bed </th>
         <th style='background-color: #4CAF50; color: white' >Kamar</th>
         <th style='background-color: #4CAF50; color: white' >Jam</th>
         <th style='background-color: #4CAF50; color: white' >Tanggal Periksa</th>
         <th style='background-color: #4CAF50; color: white' >Aksi Rekam Medik</th>
         <th style='background-color: #4CAF50; color: white' >Selesai</th>
    </tr>
    </thead>
  
 </table>
</div><!-- table responsive  -->
</span>  
</div>



<?php 
  include 'footer.php';
?>