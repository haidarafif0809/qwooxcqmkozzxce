<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$db->query("SET SQL_BIG_SELECTS=1");


$query = $db->query("SELECT rekam_medik_ugd.no_reg, rekam_medik_ugd.no_rm, rekam_medik_ugd.nama, rekam_medik_ugd.alamat,
rekam_medik_ugd.umur, rekam_medik_ugd.jenis_kelamin, rekam_medik_ugd.alergi, rekam_medik_ugd.dokter, rekam_medik_ugd.jam, rekam_medik_ugd.tanggal, rekam_medik_ugd.id FROM rekam_medik_ugd INNER JOIN registrasi ON rekam_medik_ugd.no_reg = registrasi.no_reg WHERE registrasi.status != 'Batal UGD' AND rekam_medik_ugd.status IS NULL ORDER BY rekam_medik_ugd.id DESC ");


$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ugd_lihat, rekam_medik_ugd_tambah, rekam_medik_ugd_edit, rekam_medik_ugd_hapus FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);

 ?>

    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_rekam_medik_ugd.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_inap").append('<tbody class="tbody"><tr><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_inap_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>

 <style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>



<div style="padding-left:5%; padding-right:5%;">
 <h3>DATA REKAM MEDIK UGD</h3><hr>

<!-- akhir menu rekam medik -->
<ul class="nav nav-tabs md-pills pills-ins" role="tablist">

<?php if ($rekam_medik['rekam_medik_ugd_tambah'] > 0): ?>  
      <li class="nav-item"><a href="tambah_rekam_medik_ugd.php" id="link" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Rekam Medik</a></li>
<?php endif ?>

      <li class="nav-item"><a class="nav-link active" href='rekam_medik_ugd.php'> Pencarian Rekam Medik </a></li>
      <li class="nav-item"><a class="nav-link " href='filter_rekam_medik_ugd.php' > Filter Rekam Medik </a></li>
</ul>

<br>

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
         <th style='background-color: #4CAF50; color: white' >Alergi</th>      
         <th style='background-color: #4CAF50; color: white' >Dokter Jaga</th>
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