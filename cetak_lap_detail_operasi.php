<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);



$detail = $db->query("SELECT p.no_faktur,u.nama AS petugas_ops,uu.nama AS petugas_input,dp.nama_detail_operasi,hdo.waktu,hdo.no_reg FROM hasil_detail_operasi hdo INNER JOIN user u ON hdo.id_user = u.id INNER JOIN user uu ON hdo.petugas_input = uu.id INNER JOIN detail_operasi dp ON hdo.id_detail_operasi = dp.id_detail_operasi INNER JOIN penjualan p ON hdo.no_reg = p.no_reg WHERE DATE(hdo.waktu) >= '$dari_tanggal' AND DATE(hdo.waktu) <= '$sampai_tanggal' ");

$hitung_item = $db->query("SELECT * FROM hasil_detail_operasi WHERE DATE(waktu) >= '$dari_tanggal' AND DATE(waktu) <= '$sampai_tanggal' ");
$jumlah_item = mysqli_num_rows($hitung_item);
 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN DETAIL OPERASI </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
<table>
  <tbody>

      <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td>
      </tr>
            
  </tbody>
</table>           
                 
        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
    <br>
    <br>
    <br>


 <table id="tableuser" class="table table-bordered table-sm">
            <thead>
                  <th> No. Faktur </th>                  
                  <th> No. Reg </th>    
                  <th> Operasi </th>
                  <th> Petugas Operasi </th>
                  <th> Petugas Input </th>
                  <th> Waktu </th>                               
            </thead>
            
            <tbody>
            <?php

                  while ($data1 = mysqli_fetch_array($detail))

                  {
                        //menampilkan data
	
  
			                  echo "<tr>
								<td>". $data1['no_faktur'] ." </td>
								<td>". $data1['no_reg'] ." </td>
								<td>". $data1['nama_detail_operasi'] ."</td>
								<td>". $data1['petugas_ops'] ."</td>
								<td>". $data1['petugas_input'] ."</td>
								<td>". $data1['waktu'] ."</td>
			                  </tr>";

         }

                          //Untuk Memutuskan Koneksi Ke Database
                          
                          mysqli_close($db); 
        
        
            ?>
            </tbody>

      </table>
      <hr>
</div>
</div>

<div class="row">
  <div class="col-sm-7">
</div>

    <div class="col-sm-2">
    <h5>Total Kesluruhan :</h5>
    </div>


   <div class="col-sm-3">

      <p>Jumlah Item : <?php echo $jumlah_item; ?></p>

  </div>
</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>