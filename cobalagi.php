<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';



$query = $db->query("SELECT rekam_medik_ugd.no_reg, rekam_medik_ugd.no_rm, rekam_medik_ugd.nama, rekam_medik_ugd.alamat,
rekam_medik_ugd.umur, rekam_medik_ugd.jenis_kelamin, rekam_medik_ugd.alergi, rekam_medik_ugd.dokter, rekam_medik_ugd.jam, rekam_medik_ugd.tanggal, rekam_medik_ugd.id FROM rekam_medik_ugd INNER JOIN registrasi ON rekam_medik_ugd.no_reg = registrasi.no_reg WHERE registrasi.status != 'Batal UGD' AND rekam_medik_ugd.status IS NULL ORDER BY rekam_medik_ugd.id DESC ");


 ?>

 
<div class="container">
 <h3>DATA REKAM MEDIK UGD</h3><hr>

<!-- akhir menu rekam medik -->
<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
      <li class="nav-item"><a class="nav-link active" href='rekam_medik_ugd.php'> Pencarian Rekam Medik </a></li>
      <li class="nav-item"><a class="nav-link " href='filter_rekam_medik_ugd.php' > Filter Rekam Medik </a></li>
</ul>

<br>
 <a href="tambah_rekam_medik_ugd.php" id="link" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambah Rekam Medik</a>
<br>

<span id="tmpl-form">

<div class="table-responsive">
<table id="table_inap" class="table table-bordered">
 
    <thead>
      <tr>
         <th>No Reg </th>
         <th>No RM  </th>
         <th>Nama</th>
         <th>Alamat</th>
         <th>Umur</th>
         <th>Jenis Kelamin</th>   
         <th>Alergi</th>      
         <th>Dokter Jaga</th>
         <th>Jam</th>
         <th>Tanggal Periksa</th>
         <th>Aksi Rekam Medik</th>
         <th>Selesai</th>
    </tr>
    </thead>
    <tbody>
    
   <?php 

while($data = mysqli_fetch_array($query))
      
      {
      echo 
      "<tr>

      <td>". $data['no_reg']."</td>
      <td>". $data['no_rm']."</td>
      <td>". $data['nama']."</td>
      <td>". $data['alamat']."</td>
      <td>". $data['umur']."</td>
      <td>". $data['jenis_kelamin']."</td>        
      <td>". $data['alergi']."</td>
      <td>". $data['dokter']."</td>
      <td>". $data['jam']."</td>
      <td>". tanggal($data['tanggal'])."</td>

<td><a href='rekam_medik_ugd.php?no_reg=".$data['no_reg']."&tgl=".$data['tanggal']."&id=".$data['id']."&jam=".$data['jam']."' class='btn btn-warning' ><span class='glyphicon glyphicon-hand-right'></span> Input Rekam Medik</a></td>";


$table23 = $db->query("SELECT status FROM penjualan WHERE no_reg = '$data[no_reg]' ");
$dataki = mysqli_fetch_array($table23);
if ($dataki['status'] == 'Lunas' OR  $dataki['status'] == 'Piutang' OR $dataki['status'] == 'Piutang Apotek')
  {

 $das = $db->query("SELECT dosis FROM detail_penjualan WHERE no_reg = '$data[no_reg]' ");
        $sad = mysqli_fetch_array($das);
          if($sad['dosis'] != '')
        {
              echo 
              "<td><a href='selesai_ugd.php?no_reg=".$data['no_reg']."&id=".$data['id']."' class='btn btn-danger'><span class='glyphicon glyphicon-send'></span> Selesai </a></td>";
        }

        else
            {
            echo "
                  <td></td>";
            }
   }
   else{
    echo "<td> </td>";
   }

    echo "</tr>";
      }
     
    ?>
  </tbody>
 </table>
</div><!-- table responsive  -->



</span>  
</div>



<?php 
  include 'footer.php';
?>