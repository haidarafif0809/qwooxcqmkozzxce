<?php 
include 'sanitasi.php';
include 'db.php';

$query = $db->query("SELECT rekam_medik.no_reg, rekam_medik.no_rm, rekam_medik.nama, rekam_medik.alamat,
  rekam_medik.umur, rekam_medik.jenis_kelamin, rekam_medik.poli, rekam_medik.dokter, rekam_medik.jam, rekam_medik.tanggal_periksa,rekam_medik.id FROM rekam_medik INNER JOIN registrasi ON rekam_medik.no_reg = registrasi.no_reg WHERE registrasi.status != 'Batal Rawat' AND registrasi.status != 'Rujuk Keluar Klinik Tidak Ditangani' AND rekam_medik.status IS NULL ORDER BY id DESC");

 ?>

<br>

  
<div class="container">
 <div class="table-responsive">
<table id="table_rawat_inap" class="table table-bordered">
    <thead>
      <tr>
         <th>No Reg </th>
         <th>No RM  </th>
         <th>Nama</th>
         <th>Alamat</th>
         <th>Umur</th>
         <th>Jenis Kelamin</th> 
         <th>Poli</th>
         <th>Dokter</th>
         <th>Jam</th>
         <th>Tanggal Periksa</th> 
         <th>Aksi Rekam Medik</th>
         <th>Rujuk Laboratorium</th>
        <th>Selesai</th>
    </tr>
    </thead>
    <tbody>
    
   <?php 

while($data = mysqli_fetch_array($query))
      
      {

      echo "<tr>
            <td>". $data['no_reg']."</td>
            <td>". $data['no_rm']."</td>
            <td>". $data['nama']."</td>   
            <td>". $data['alamat']."</td>
            <td>". $data['umur']." </td>
            <td>". $data['jenis_kelamin']."</td>    
            <td>". $data['poli']."</td>
            <td>". $data['dokter']."</td>
            <td>". $data['jam']."</td>
            <td>". $data['tanggal_periksa']."</td>
      <td><a href='kepala_rekam_medik_2.php?no_reg=".$data['no_reg']."&tgl=".$data['tanggal_periksa']."&jam=".$data['jam']."' class='btn btn-warning'><span class='glyphicon glyphicon-eye-open'></span> Input Rekam Medik</a></td>";

             ?>

         <?php 

        $table23 = $db->query("SELECT status_pembayaran FROM penjualan WHERE no_reg = '$data[no_reg]' ");
        $dataki = mysqli_fetch_array($table23);
            if ($dataki['status_pembayaran'] == 'Lunas' OR  $dataki['status_pembayaran'] == 'Piutang'  OR  $dataki['status_pembayaran'] == 'Piutang Apotek'  )
            {

 $das = $db->query("SELECT dosis FROM detail_penjualan WHERE no_reg = '$data[no_reg]' ");
  $sad = mysqli_fetch_array($das);
  if($sad['dosis'] == '')
   {

      echo "
      <td></td>
      <td></td>";
   }

  else
          {
              
              echo "<td></td>
               <td><a href='selesai_ri.php?no_reg=".$data['no_reg']."&id=".$data['id']."' class='btn btn-danger'><span class='glyphicon glyphicon-send'></span> Selesai </a></td>";
           
            }

            }
            else
            {
         echo "<td><a href='form-rujuk-lab-rj.php?no_reg=".$data['no_reg']."' class='btn btn-success'><span class='glyphicon glyphicon-hand-right'></span> Rujuk Laboratorium</a></td>
         <td></td>";
            }

      
           echo  
              "
           

              </tr>";
      
      }
    ?>
  </tbody>
 </table>
</div>

