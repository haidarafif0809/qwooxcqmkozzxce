<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$status_stok = stringdoang($_GET['status_stok']);
$array = array();
$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);

$query_barang = $db->query("SELECT kode_barang, nama_barang, limit_stok, over_stok, status FROM barang WHERE berkaitan_dgn_stok = 'Barang' ");
while ($data_barang = mysqli_fetch_array($query_barang)) {
  $stok_barang = cekStokPertanggal($data_barang['kode_barang'],$sampai_tanggal);

  if ($status_stok == '0') {
    # code...semua
    array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
  }
  else if ($status_stok == '1') {
    # code...cukup
    if ($stok_barang > $data_barang['limit_stok']) {
      array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
    }

  }
  else if ($status_stok == '2') {
    # code...limit
    if ($stok_barang <= $data_barang['limit_stok']) {
      array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
    }
  }
  else if ($status_stok == '3') {
    # code...over
    if ($stok_barang >= $data_barang['over_stok']) {
      array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
    }
  }

}


    
?>

<div class="container">

<h3> <b> <center>LAPORAN LIMIT STOK PRODUK </center></b></h3><hr>
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
              <tr><td  width="40%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo tanggal($sampai_tanggal); ?> </td></tr>
           
                    
          </tbody>
        </table>
    </div><!--penutup colsm4-->
      
    </div><!--penutup row1-->

    <br>
    <table id="tableuser" class="table table-bordered table-sm">
      <thead>
        <th style="background-color: #4CAF50; color: white;"> Kode Produk</th>
        <th style="background-color: #4CAF50; color: white;"> Nama Produk</th>
        <th style="background-color: #4CAF50; color: white;"> Jumlah Produk</th>
        <th style="background-color: #4CAF50; color: white;"> Status Stok</th>
        <th style="background-color: #4CAF50; color: white;"> LImit Stok </th>
        <th style="background-color: #4CAF50; color: white;"> Over Stok </th>
        <th style="background-color: #4CAF50; color: white;"> Status </th>                  
      </thead>
      <tbody>

      <?php foreach ($array as $arrays => $data_array): ?>
        <tr>
          <td><?php echo $data_array['kode_barang']; ?></td>
          <td><?php echo $data_array['nama_barang']; ?></td>
          <td><?php echo $data_array['stok_barang']; ?></td>
          <td><?php echo $status_stok; ?></td>
          <td><?php echo $data_array['limit_stok']; ?></td>
          <td><?php echo $data_array['over_stok']; ?></td>
          <td><?php echo $data_array['status']; ?></td>
        </tr>

      <?php endforeach ?>
      </tbody>
    </table>

    <div class="row">
      <div class="col-sm-1"></div>
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