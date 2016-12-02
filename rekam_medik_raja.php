<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include_once 'db.php';


$query = $db->query("SELECT rekam_medik.no_reg, rekam_medik.no_rm, rekam_medik.nama, rekam_medik.alamat,
  rekam_medik.umur, rekam_medik.jenis_kelamin, rekam_medik.poli, rekam_medik.dokter, rekam_medik.jam, rekam_medik.tanggal_periksa,rekam_medik.id FROM rekam_medik INNER JOIN registrasi ON rekam_medik.no_reg = registrasi.no_reg WHERE registrasi.status != 'Batal Rawat' AND registrasi.status != 'Rujuk Keluar Klinik Tidak Ditangani' AND rekam_medik.status IS NULL ORDER BY id DESC");

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_rj_lihat, rekam_medik_rj_tambah, rekam_medik_rj_edit, rekam_medik_rj_hapus FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


 ?>

    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_rawat_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_rekam_medik_raja.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_rawat_inap").append('<tbody class="tbody"><tr><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_rawat_inap_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>


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
 <h3>DATA REKAM MEDIK RAWAT JALAN</h3><hr>


<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
      <li class="nav-item"><a class="nav-link active" href='rekam_medik_raja.php'> Pencarian Rekam Medik </a></li>
        <li class="nav-item"><a class="nav-link" href='filter_rekam_medik.php' > Filter Rekam Medik </a></li>
</ul>
<!-- akhir menu rekam medik -->

<br>
<br>
<span id="tmpl-form"><!--tampil-form jquery cepat(fast)-->


<div class="table-responsive">
<table id="table_rawat_inap" class="table table-bordered table-sm">
 
    <thead>
      <tr>
         <th style='background-color: #4CAF50; color: white'>No Reg </th>
         <th style='background-color: #4CAF50; color: white'>No RM  </th>
         <th style='background-color: #4CAF50; color: white'>Nama</th>
         <th style='background-color: #4CAF50; color: white'>Alamat</th>
         <th style='background-color: #4CAF50; color: white'>Umur</th>
         <th style='background-color: #4CAF50; color: white'>Jenis Kelamin</th>
          
         <th style='background-color: #4CAF50; color: white'>Poli</th>
         <th style='background-color: #4CAF50; color: white'>Dokter</th>
         <th style='background-color: #4CAF50; color: white'>Jam</th>
         <th style='background-color: #4CAF50; color: white'>Tanggal Periksa</th> 
         <th style='background-color: #4CAF50; color: white'>Aksi Rekam Medik</th>
        <th style='background-color: #4CAF50; color: white'>Selesai</th>
    </tr>
    </thead>
   
 </table>
</div>


</span><!--end tampil_form-->

</div>


<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_rm_rj.php',{q:q},function(data)
{
  $("#tmpl-form").html(data);
  
});
});
</script>



<?php
 include 'footer.php';
?>