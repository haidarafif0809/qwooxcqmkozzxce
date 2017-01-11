<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_GET['no_faktur']);

$select = $db->query("SELECT * FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai'");
$out = mysqli_fetch_array($select);

$query1 = $db->query("SELECT * FROM perusahaan");
$data1 = mysqli_fetch_array($query1);

$tanggal = date('Y-m-d');
 ?>

<div class="container">
    
    <div class="row"><!--row1-->
    <h3> <center><b> HASIL LABORATORIUM </b></center></h3><hr>
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
                         

   <table>
  <tbody>

      <tr><td width="50%">No Faktur</td> <td> :&nbsp;</td> <td> <?php echo $out['no_faktur']; ?> </td></tr> 
      <tr><td  width="50%">Nama Pasien</td> <td> :&nbsp;</td> <td> <?php echo $out['nama_pasien'];?> </td></tr>
      <tr><td  width="50%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo $out['tanggal']; ?> </td></tr>
            
  </tbody>
  </table>
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-2">
               
                Petugas : <?php echo $_SESSION['nama']; ?>  <br>

        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
</div> <!-- end of container-->


<br>
<div class="container">

<table id="tableuser" class="table table-bordered table-sm">
        <thead>

           <th> Nama Pemeriksaan </th>
           <th> Hasil Pemeriksaan </th>
           <th> Nilai Normal Pria </th>
           <th> Nilai Normal Wanita </th>
           <th> Status Ab-normal </th>
           <th> Status Rawat </th>
           
            
        </thead>
        
        <tbody>
        <?php

            
$show = $db->query("SELECT * FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai'");
            //menyimpan data sementara yang ada pada $perintah
            while ($take = mysqli_fetch_array($show))
            {
                //menampilkan data
            echo "<tr>
                <td>". $take['nama_pemeriksaan'] ."</td>
                <td>". $take['hasil_pemeriksaan'] ."</td>";

$ambil_model = $db->query("SELECT model_hitung,satuan_nilai_normal,normal_lk2,normal_pr2 FROM setup_hasil WHERE nama_pemeriksaan = '$take[id_pemeriksaan]'");
while($show_model = mysqli_fetch_array($ambil_model))
{

$model_hitung = $show_model['model_hitung']; 
switch ($model_hitung) {
    case "Lebih Kecil Dari":
        echo "<td>&lt;&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&lt;&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Kecil Sama Dengan":
        echo "<td>&lt;=&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&lt;=&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Besar Dari":
        echo "<td>&gt;&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&gt;&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
          case "Lebih Besar Sama Dengan":
        echo "<td>&gt;=&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&gt;=&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
          case "Antara Sama Dengan":
        echo "<td>". $take['nilai_normal_lk']."&nbsp;-&nbsp; ". $show_model['normal_lk2']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>". $take['nilai_normal_pr']."&nbsp;-&nbsp; ". $show_model['normal_pr2']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
    } 
    
          echo " <td>". $take['status_abnormal'] ."</td>
            <td>". $take['status_pasien'] ."</td>
            <tr>";
}
            }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

        ?>
        </tbody>

    </table>
      <br>

    
<hr>
 <div class="row">
     
<div class="col-sm-1">
     </div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>
     <div class="col-sm-2">
     </div>
     <div class="col-sm-3">
     </div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>



</div>
        

</div> <!--end container-->




 <script>
$(document).ready(function(){
  window.print();
});
</script>





<?php include 'footer.php'; ?>