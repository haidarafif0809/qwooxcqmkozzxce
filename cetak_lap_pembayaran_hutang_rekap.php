<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

 
$select_query = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");


$select_jumlah = $db->query("SELECT SUM(jumlah_bayar) AS total_akhir 
  FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while ($out = mysqli_fetch_array($select_jumlah))
{
$total_akhir = $out['total_akhir'];
}




 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBAYARAN HUTANG REKAP </b></h3>
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

      <th style="background-color: #4CAF50; color: white;"> No Faktur Bayar</th>
      <th style="background-color: #4CAF50; color: white;"> No Faktur Beli</th>
      <th style="background-color: #4CAF50; color: white;"> Suplier </th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
      <th style="background-color: #4CAF50; color: white;"> Jatuh Tempo </th>
      <th style="background-color: #4CAF50; color: white;"> Kredit </th>
      <th style="background-color: #4CAF50; color: white;"> Potongan </th>
      <th style="background-color: #4CAF50; color: white;"> Total Hutang </th>
      <th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
      
    </thead>
    
    <tbody>
    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($select_query))
      {
    $suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$data1[suplier]'");
        $out = mysqli_fetch_array($suplier);
        if ($data1['suplier'] == $out['id'])
        {
          $out['nama'];
        }
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $out['nama'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>

      
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


<div class="col-sm-9">
</div>


<div class="col-sm-3">
<h4><b>Total :</b> <?php echo rp($total_akhir); ?></h4>
</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>