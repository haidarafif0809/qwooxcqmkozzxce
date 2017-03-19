<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$no_reg = stringdoang($_GET['no_reg']);

$select = $db->query("SELECT * FROM hasil_lab WHERE no_reg = '$no_reg' AND status = 'Selesai'");
$out = mysqli_fetch_array($select);

$query1 = $db->query("SELECT * FROM perusahaan ");
$data1 = mysqli_fetch_array($query1);

$tanggal = date('Y-m-d');

$select_bio = $db->query("SELECT umur_pasien,alamat_pasien FROM registrasi WHERE no_rm = '$out[no_rm]'");
$show_bio = mysqli_fetch_array($select_bio);
$umur = $show_bio['umur_pasien'];
$alamat = $show_bio['alamat_pasien'];

$p_analis = $db->query("SELECT id,nama FROM user WHERE id = '$out[petugas_analis]'");
$out_analis = mysqli_fetch_array($p_analis);
$analis = $out_analis['nama'];

$p_dokter = $db->query("SELECT id,nama FROM user WHERE id = '$out[dokter]'");
$out_dokter = mysqli_fetch_array($p_dokter);
$dokter = $out_dokter['nama'];

 ?>

<div class="container">
    
    <div class="row"><!--row1-->
    <h3> <center><b> HASIL LABORATORIUM </b></center></h3><hr>
        <div class="col-sm-1">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='90' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-3">
                         

   <table>
  <tbody>

      <tr><td width="50%">No RM</td> <td> :&nbsp;</td> <td> <?php echo $out['no_rm']; ?> </td></tr>
      <tr><td  width="50%">No REG</td> <td> :&nbsp;</td> <td> <?php echo $out['no_reg'];?> </td></tr>  
      <tr><td  width="50%">Nama Pasien</td> <td> :&nbsp;</td> <td> <?php echo $out['nama_pasien'];?> </td></tr>
      <tr><td  width="50%">Umur Pasien</td> <td> :&nbsp;</td> <td> <?php echo $umur;?> </td></tr>
      <tr><td  width="50%">Alamat Pasien</td> <td> :&nbsp;</td> <td> <?php echo $alamat;?> </td></tr>  
 
  </tbody>
  </table>
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
        
   <table>
  <tbody> 
 
      <tr><td  width="50%">Tanggal &nbsp;:&nbsp;<?php echo $tanggal; ?> </td></tr>
      <tr><td  width="50%">Petugas &nbsp;:&nbsp; <?php echo $_SESSION['nama']; ?> </td></tr>

      <tr><td  width="50%">Dokter &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $dokter;?> </td></tr>
      <tr><td  width="50%">Analis &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <?php echo $analis;?> </td></tr>
      
  </tbody>
  </table>       

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
           <!--<th> Normal / Tidak Normal </th>-->
           <th> Status Rawat </th>
           
            
        </thead>
        
        <tbody>
       <?php

 $show = $db->query("SELECT * FROM hasil_lab WHERE no_reg = '$no_reg' AND status = 'Selesai' AND id_sub_header != '0' GROUP BY id_sub_header ");
  while($drop_show = mysqli_fetch_array($show))
{

  $id_sub_head = $drop_show['id_sub_header']; //ok take id indux /sub

// select id lab nya
  $select = $db->query("SELECT id,nama_pemeriksaan FROM setup_hasil WHERE id = '$id_sub_head' GROUP BY sub_hasil_lab");
$drop = mysqli_fetch_array($select);
   $face_drop = mysqli_num_rows($select);

  $id_set_up = $drop['nama_pemeriksaan'];
  $id_get = $drop['id'];

  $get_name = $db->query("SELECT nama FROM jasa_lab WHERE id = '$id_set_up' GROUP BY id");
  $get = mysqli_fetch_array($get_name);
  $name_sub_header = $get['nama'];
                //menampilkan data
    
 

if($face_drop >= 1)
{

    $hitung_baris = 0;
    echo "
    <tr>";

    if($hitung_baris != 0)
      {
          $name_sub_header = '';
      }
          $hitung_baris++;

          echo "<td><b>".$name_sub_header."</b></td>
                <td><center>-</center></td>
                <td><center>-</center></td>
                <td><center>-</center></td>
                <td><center>-</center></td>

    </tr>";

    $show_one = $db->query("SELECT * FROM hasil_lab WHERE no_reg = '$no_reg' AND status = 'Selesai'  AND id_sub_header = '$id_get' ");
            //menyimpan data sementara yang ada pada $perintah
  
        while ($take = mysqli_fetch_array($show_one))
        {

        echo "<tr>";
        echo "<td>  <li> ". $take['nama_pemeriksaan'] ."</li></td>";
        echo "<td>". $take['hasil_pemeriksaan'] ."</td>";

        $model_hitung = $take['model_hitung']; 
        if($model_hitung == '')
        {
            echo "
            <td>&nbsp; ". '-' ." </td>
            <td>&nbsp; ". '-'." </td>
            ";
        }
        else
        {
          switch ($model_hitung) {
          case "Lebih Kecil Dari":
          echo "<td>&lt;&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
          <td>&lt;&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>";
          
          break;
          case "Lebih Kecil Sama Dengan":
          echo "<td>&lt;=&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
          <td>&lt;=&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>";

          break;
          case "Lebih Besar Dari":
          echo "<td>&gt;&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
          <td>&gt;&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>";

          break;
          case "Lebih Besar Sama Dengan":
          echo "<td>&gt;=&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
          <td>&gt;=&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>";

          break;
          case "Antara Sama Dengan":
          echo "<td>". $take['nilai_normal_lk']."&nbsp;-&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
          <td>". $take['nilai_normal_pr']."&nbsp;-&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']."</td>";
                            
          break;
          //Text
          case "Text":
          echo "<td>&nbsp; ". $take['nilai_normal_lk']."&nbsp;". $take['satuan_nilai_normal']." </td>
          <td>&nbsp; ". $take['nilai_normal_pr']."&nbsp;". $take['satuan_nilai_normal']." </td>";
          break;
          //End Text

                } 
          }  

        echo " <td>". $take['status_pasien'] ."</td>
        <tr>";

        } //END WHILE
} //END IF UNTUK DATA LABORATORIUM YANG ADA HEADER / INDUX

}




//start untuk yang sendirian / yang tidak ber HEADER/INDUX
       $show_two = $db->query("SELECT * FROM hasil_lab WHERE no_reg = '$no_reg' AND status = 'Selesai' AND id_sub_header = 0");
            //menyimpan data sementara yang ada pada $perintah
  
          while ($drop_two = mysqli_fetch_array($show_two))
          {

            echo "<tr>";
            echo "<td><b> ".$drop_two['nama_pemeriksaan']."</b></td>";
            echo "<td>". $drop_two['hasil_pemeriksaan'] ."</td>";

            $model_hitung = $drop_two['model_hitung']; 
            if($model_hitung == '')
            {
              echo "
              <td>&nbsp; ". '-' ." </td>
              <td>&nbsp; ". '-'." </td>
              ";
            }
            else
            {
            
            switch ($model_hitung) {
            case "Lebih Kecil Dari":
            echo "<td>&lt;&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
            <td>&lt;&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>";
            break;
                        
            case "Lebih Kecil Sama Dengan":
            echo "<td>&lt;=&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
            <td>&lt;=&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>";
            
            break;
            case "Lebih Besar Dari":
            echo "<td>&gt;&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
            <td>&gt;&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>";
                            
            break;
            case "Lebih Besar Sama Dengan":
            echo "<td>&gt;=&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
            <td>&gt;=&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>";
                            
            break;
            case "Antara Sama Dengan":
            echo "<td>". $drop_two['nilai_normal_lk']."&nbsp;-&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
            <td>". $drop_two['nilai_normal_pr']."&nbsp;-&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>";
            
            break;
            //Text
            case "Text":
            echo "<td>&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
            <td>&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>";
            break;
            //End Text
                
                } 
              }  
            echo " 
            <td>". $drop_two['status_pasien'] ."</td>
            <tr>";

          } //END WHILE
//ending untuk yang sendirian / yang tidak ber HEADER/INDUX

mysqli_close($db); 

        ?>
        </tbody>

    </table>
      <br>

    
<hr>
 <div class="row">
     
<div class="col-sm-1">
     </div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br></b></div>
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