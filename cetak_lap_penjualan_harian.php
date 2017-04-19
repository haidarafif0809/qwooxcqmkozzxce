<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);

$perintah = $db->query("SELECT tanggal FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY tanggal");

$query_count_penjualan = $db->query("SELECT no_faktur FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$jumlah_count_penjualan = mysqli_num_rows($query_count_penjualan);

$query_sum_total_dan_kredit_penjualan = $db->query("SELECT SUM(nilai_kredit) AS total_kredit, SUM(total) AS total_total FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data_sum_total_dan_kredit_penjualan = mysqli_fetch_array($query_sum_total_dan_kredit_penjualan);

$total_total = $data_sum_total_dan_kredit_penjualan['total_total'];
$total_kredit = $data_sum_total_dan_kredit_penjualan['total_kredit'];

$total_bayar = $total_total - $total_kredit;

 ?>

<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PENJUALAN HARIAN </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
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
                  <th> Tanggal </th>                  
                  <th> Jumlah Transaksi </th>
                  <th> Total Transaksi </th>
                  <th> Jumlah Bayar Tunai </th>
                  <th> Jumlah Bayar Kredit </th>
                                                     
            </thead>
            
            <tbody>
            <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data = mysqli_fetch_array($perintah))
          {
          //menampilkan data           

            $query_count_penjualan = $db->query("SELECT no_faktur FROM penjualan WHERE tanggal = '$data[tanggal]'");
            $jumlah_count_penjualan = mysqli_num_rows($query_count_penjualan);
            
            $query_sum_total_dan_kredit_penjualan = $db->query("SELECT SUM(nilai_kredit) AS total_kredit, SUM(total) AS total_total FROM penjualan WHERE tanggal = '$data[tanggal]'");
            $data_sum_total_dan_kredit_penjualan = mysqli_fetch_array($query_sum_total_dan_kredit_penjualan);
            
            $t_total = $data_sum_total_dan_kredit_penjualan['total_total'];
            $t_kredit = $data_sum_total_dan_kredit_penjualan['total_kredit'];
            
            $t_bayar = $t_total - $t_kredit;

          echo "<tr>
          <td>". $data['tanggal'] ."</td>
          <td>". $jumlah_count_penjualan."</td>
          <td>". rp($t_total) ."</td>
          <td>". rp($t_bayar) ."</td>
          <td>". rp($t_kredit) ."</td>


          </tr>";
          }

    echo "<tr style='color:red'>
          <td>TOTAL</td>
          <td>". rp($jumlah_count_penjualan)."</td>
          <td>". rp($total_total) ."</td>
          <td>". rp($total_bayar) ."</td>
          <td>". rp($total_kredit) ."</td>
          </tr>";

                  //Untuk Memutuskan Koneksi Ke Database
                  
                  mysqli_close($db); 
        
        
          ?>
          
            </tbody>

      </table>

</div>
</div>


 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>