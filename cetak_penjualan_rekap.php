<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$status_penjualan = stringdoang($_GET['status_penjualan']);


$tanggal_sekarang = date('Y-m-d');

 
if ($status_penjualan == "Semua") {
$query_total_penjualan = $db->query("SELECT SUM(total) AS total_akhir, SUM(potongan) AS potongan_akhir, SUM(tax) AS tax_akhir, SUM(biaya_admin) AS biaya_admin_akhir, SUM(sisa) AS kembalian_akhir, SUM(kredit) AS kredit_akhir  FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_total_penjualan = mysqli_fetch_array($query_total_penjualan);
$subtotal = $data_total_penjualan['total_akhir'] + $data_total_penjualan['potongan_akhir'] - $data_total_penjualan['tax_akhir'] - $data_total_penjualan['biaya_admin_akhir'];
}

elseif ($status_penjualan == "Lunas") {
$query_total_penjualan = $db->query("SELECT SUM(total) AS total_akhir, SUM(potongan) AS potongan_akhir, SUM(tax) AS tax_akhir, SUM(biaya_admin) AS biaya_admin_akhir, SUM(sisa) AS kembalian_akhir, SUM(kredit) AS kredit_akhir  FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND status = 'Lunas' ");
$data_total_penjualan = mysqli_fetch_array($query_total_penjualan);
$subtotal = $data_total_penjualan['total_akhir'] + $data_total_penjualan['potongan_akhir'] - $data_total_penjualan['tax_akhir'] - $data_total_penjualan['biaya_admin_akhir'];
}

elseif ($status_penjualan == "Piutang") {
$query_total_penjualan = $db->query("SELECT SUM(total) AS total_akhir, SUM(potongan) AS potongan_akhir, SUM(tax) AS tax_akhir, SUM(biaya_admin) AS biaya_admin_akhir, SUM(sisa) AS kembalian_akhir, SUM(kredit) AS kredit_akhir  FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND status = 'Piutang' ");
$data_total_penjualan = mysqli_fetch_array($query_total_penjualan);
$subtotal = $data_total_penjualan['total_akhir'] + $data_total_penjualan['potongan_akhir'] - $data_total_penjualan['tax_akhir'] - $data_total_penjualan['biaya_admin_akhir'];
}
 ?>

<div class="container">
    
                 <h3> <b> <center>LAPORAN PENJUALAN REKAP </center></b></h3><hr>
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->
<br><br>
        <div class="col-sm-5">
<table>
  <tbody>
  
      <tr><td  width="40%">Nama Petugas</td> <td> :&nbsp;</td> <td> <?php echo $_SESSION['nama']; ?></td></tr>
      <tr><td  width="40%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo tanggal($tanggal_sekarang); ?> </td>
      </tr>
      <tr><td  width="40%">Periode</td> <td> :&nbsp;</td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> </td></tr>
   
            
  </tbody>
</table>          
                 
        </div><!--penutup colsm4-->
      
    </div><!--penutup row1-->

<hr>

<table id="tableuser" class="table table-bordered table-sm">
            <thead>
      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
      <th style="background-color: #4CAF50; color: white;"> Jam </th>
      <th style="background-color: #4CAF50; color: white;"> User </th>
      <th style="background-color: #4CAF50; color: white;"> Status </th>
      <th style="background-color: #4CAF50; color: white;"> Subtotal </th>
      <th style="background-color: #4CAF50; color: white;"> Potongan </th>
      <th style="background-color: #4CAF50; color: white;"> Tax </th>
      <th style="background-color: #4CAF50; color: white;"> Biaya Admin </th>
      <th style="background-color: #4CAF50; color: white;"> Total </th>
      <th style="background-color: #4CAF50; color: white;"> Kredit </th>
                  
            </thead>
            
            <tbody>
            <?php

 
if ($status_penjualan == "Semua") {

    $perintah = $db->query("SELECT id,tanggal,no_faktur,kode_pelanggan,total,jam,user,status,potongan,tax,sisa,kredit,biaya_admin FROM penjualan dp WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ORDER BY CONCAT(tanggal,' ',jam) DESC ");
}
elseif ($status_penjualan == "Lunas") {
    $perintah = $db->query("SELECT id,tanggal,no_faktur,kode_pelanggan,total,jam,user,status,potongan,tax,sisa,kredit,biaya_admin FROM penjualan dp WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND status = 'Lunas'  ORDER BY CONCAT(tanggal,' ',jam) DESC ");
}
elseif ($status_penjualan == "Piutang") {
    $perintah = $db->query("SELECT id,tanggal,no_faktur,kode_pelanggan,total,jam,user,status,potongan,tax,sisa,kredit,biaya_admin FROM penjualan dp WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND status = 'Piutang'  ORDER BY CONCAT(tanggal,' ',jam) DESC ");

}


                while ($data10 = mysqli_fetch_array($perintah))
                {

                 $query_subtotal = $db->query("SELECT SUM(subtotal) AS subtotal  FROM detail_penjualan WHERE no_faktur = '$data10[no_faktur]' ");
                 $data_subtotal = mysqli_fetch_array($query_subtotal);

                  $query_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data10[kode_pelanggan]' ");
                  $data_pelanggan = mysqli_fetch_array($query_pelanggan);
                  
                  echo "<tr>
                  <td>". $data10['no_faktur'] ."</td>";

                   if ($data_pelanggan == '' OR $data_pelanggan == 'NULL') {
                     
                      echo"<td>". $data10['kode_pelanggan'] ."</td>";
                    }
                    else
                    {
                      echo"<td>". $data_pelanggan['nama_pelanggan'] ."</td>";
                    }

                  echo"<td>". $data10['tanggal'] ."</td>
                  <td>". $data10['jam'] ."</td>
                  <td>". $data10['user'] ."</td>
                  <td>". $data10['status'] ."</td>
                  <td align='right'>". rp($data_subtotal['subtotal']) ."</td>
                  <td align='right'>". rp($data10['potongan']) ."</td>
                  <td align='right'>". rp($data10['tax']) ."</td>
                  <td align='right'>". rp($data10['biaya_admin']) ."</td>
                  <td align='right'>". rp($data10['total']) ."</td>
                  <td align='right'>". rp($data10['kredit']) ."</td>
                  </tr>";
                }

                  echo "<tr>
                  <td style='color:red'></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td> 
                  <td align='right' style='color:red'>".rp($subtotal)."</td>
                  <td align='right' style='color:red'>".rp($data_total_penjualan['potongan_akhir'])."</td>
                  <td align='right' style='color:red'>".rp($data_total_penjualan['tax_akhir'])."</td>
                  <td align='right' style='color:red'>".rp($data_total_penjualan['biaya_admin_akhir'])."</td>
                  <td align='right' style='color:red'>".rp($data_total_penjualan['total_akhir'])."</td>
                  <td align='right' style='color:red'>".rp($data_total_penjualan['kredit_akhir'])."</td>
                  </tr>";
          //Untuk Memutuskan Koneksi Ke Database                    
               mysqli_close($db); 
            ?>
            </tbody>

      </table>
      <br>
      <div class="col-sm-4"><i>Terbilang : <b><?php echo kekata($data_total_penjualan['total_akhir']); ?></b></i></div>


 <div class="row">
     <div class="col-sm-1">
</div>
     <div class="col-sm-8"><b>&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>

     


</div>
        

</div> <!--end container-->



 <script>
$(document).ready(function(){
  window.print();
});
</script>






<?php include 'footer.php'; ?>