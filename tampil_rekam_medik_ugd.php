<?php 
include 'db.php';
include_once 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$cari_berdasarkan = stringdoang($_POST['cari_berdasarkan']);
$pencarian = stringdoang($_POST['pencarian']);

switch ($cari_berdasarkan) {
    case "nama":
        $query1= $db->query("SELECT * FROM rekam_medik_ugd WHERE nama LIKE '%$pencarian%' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
        echo "<div class='table-responsive'>";
       echo"<table id='table-group' class='table table-bordered table-sm'>


<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

    <thead>
      <tr>
        <th style ='background-color: #4CAF50; color: white' >No Reg </th>
         <th style ='background-color: #4CAF50; color: white' >Nama Pasien</th>
         <th style ='background-color: #4CAF50; color: white' >Tanggal Periksa</th>
         <th style ='background-color: #4CAF50; color: white' >Jam Periksa</th>
         <th style ='background-color: #4CAF50; color: white' >Nama Dokter</th>
    </tr>
    </thead>
    <tbody>";
 
    	while ($data= mysqli_fetch_array($query1))
    	{
    		   echo "<tr class='rekam-medik-inap' data-no='". $data['id'] ."' >
      <td>". $data['no_reg']."</td>
      <td>". $data['nama']."</td>
      <td>". $data['tanggal']."</td>
      <td>". $data['jam']."</td>
      <td>". $data['dokter']."</td>
   
      
      </tr>";
    	}
  echo"
  </tbody>
 </table>
 </div>";
        break;
    case "no_rm":
        $query2= $db->query("SELECT * FROM rekam_medik_ugd  WHERE no_rm LIKE '%$pencarian%' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
        echo"<table id='table-group' class='table table-bordered table-sm'>

    <thead>
      <tr>
         <th style ='background-color: #4CAF50; color: white'>No Reg </th>
         <th style ='background-color: #4CAF50; color: white' >Nama Pasien</th>
         <th style ='background-color: #4CAF50; color: white' >Tanggal Periksa</th>
         <th style ='background-color: #4CAF50; color: white' >Jam Periksa</th>
         <th style ='background-color: #4CAF50; color: white' >Nama Dokter</th>
    </tr>
    </thead>
    <tbody>";
 
    	while ($data= mysqli_fetch_array($query2))
    	{
    		   echo "<tr class='rekam-medik-inap' data-no='". $data['id'] ."' >
      <td>". $data['no_reg']."</td>
      <td>". $data['nama']."</td>
      <td>". $data['tanggal']."</td>
      <td>". $data['jam']."</td>
      <td>". $data['dokter']."</td>
   
      
      </tr>";
    	}
  echo"
  </tbody>
 </table>";
        break;
    default:
        
}


 ?>


<script type="text/javascript">

  $(function () {
  $("#table-group").dataTable();
  });
  
  </script>