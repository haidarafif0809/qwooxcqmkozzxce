<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');



 ?>




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




<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_rawat_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_pasien_ri_batal.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_rawat_inap").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
               
            }
          }
        } );
      } );
    </script>


<div style="padding-left:5%; padding-right:5%;">


 <h3>DATA PASIEN RAWAT INAP</h3><hr>

<ul class="nav nav-tabs yellow darken-4" role="tablist">
        <li class="nav-item"><a class="nav-link" href='rawat_inap.php' data-placement='top' >Daftar Pasien <u>R</u>awat Inap</a></li>
        <li class="nav-item"><a class="nav-link active" href='daftar_pasien_rawat_inap_batal.php' data-placement='top' title='Klik untuk melihat pasien batal rawat inap.'>  Pasien Batal Rawat Inap </a></li>
        <li class="nav-item"><a class="nav-link" href='daftar_pasien_rawat_inap_pulang.php' data-placement='top' title='Klik untuk melihat pasien sudah pulang dari rawat inap.'> Pasien Rawat Inap Pulang </a></li>
</ul>
<br>
<div class="table-responsive">
<table id="table_rawat_inap" class="table table-bordered table-sm">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white'>No RM</th>
          <th style='background-color: #4CAF50; color: white'>No REG </th>
          <th style='background-color: #4CAF50; color: white'>Status</th>
          <th style='background-color: #4CAF50; color: white'>Nama  </th>
          <th style='background-color: #4CAF50; color: white'>Jam</th>
          <th style='background-color: #4CAF50; color: white'>Penjamin</th>    
          <th style='background-color: #4CAF50; color: white'>Asal Poli</th>
          <th style='background-color: #4CAF50; color: white'>Dokter Pengirim</th>
          <th style='background-color: #4CAF50; color: white'>Dokter Pelaksana</th>
          <th style='background-color: #4CAF50; color: white'>Bed</th>
          <th style='background-color: #4CAF50; color: white'>Kamar</th>
          <th style='background-color: #4CAF50; color: white'>Tanggal Masuk</th>
          <th style='background-color: #4CAF50; color: white'>Penanggung Jawab</th>    
          <th style='background-color: #4CAF50; color: white'>Umur</th>
          
    </tr>
    </thead>
   
 </table>
</div>


</div>


<script type="text/javascript">
    $(document).ready(function(){
    // Tooltips Initialization
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });
    });
</script>


<?php include 'footer.php';
?>



