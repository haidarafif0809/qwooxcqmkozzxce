<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';

  $no_reg = $_GET['no_reg'];

    $select_hasil_radiologi = $db->query("SELECT hp.no_reg, hp.tanggal, hp.jam, hp.dokter_pengirim, hp.dokter_pelaksana, hp.dokter_periksa, hp.keterangan, r.poli, r.alamat_pasien, r.no_rm, r.nama_pasien, r.jenis_pasien FROM tbs_penjualan_radiologi hp INNER JOIN registrasi r ON hp.no_reg = r.no_reg WHERE hp.no_reg = '$no_reg' ORDER BY hp.kontras ASC");
    $data_hasil = mysqli_fetch_array($select_hasil_radiologi);

    $select_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($select_perusahaan);


 ?>


<style type="text/css">
    .satu {
       font-size: 15px;
       font: verdana;
       }
    .rata-kiri    { text-align: left;}
    .rata-kanan   { text-align: right;}
    .rata-tengah  { text-align: center;}
    .rata-kanan-kiri { text-align: justify;}
</style>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> Hasil Radiolologi </b> </h4> </center><hr>


  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>

      <tr><td width="25%">No. REG</td> <td> :&nbsp;</td> <td><?php echo $no_reg; ?> </tr>    
      <tr><td width="25%">No. RM</td> <td> :&nbsp;</td> <td><?php echo $data_hasil['no_rm']; ?> </tr>    
      <tr><td width="25%">Nama Pasien</td> <td> :&nbsp;</td> <td><?php echo $data_hasil['nama_pasien']; ?> </tr>  
      <tr><td width="25%">Alamat</td> <td> :&nbsp;</td> <td><?php echo $data_hasil['alamat_pasien']; ?> </tr>            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>

      <tr><td width="25%">Tanggal</td> <td> :&nbsp;</td> <td><?php echo tanggal($data_hasil['tanggal']); ?> </tr> 
      <tr><td width="25%">Pasien</td> <td> :&nbsp;</td> <td><?php echo $data_hasil['jenis_pasien']; ?> </tr> 
      <tr><td width="25%">Poli</td> <td> :&nbsp;</td> <td><?php echo $data_hasil['poli']; ?> </tr> 

      </tbody>
</table>

    </div> <!--end col-sm-2-->
   </div> <!--end row-->  




<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 30%"> <center> Nama Pemeriksaan </center> </th>
            <th class="table1" style="width: 30%"> <center> Dokter Pengirim </center> </th>
            <th class="table1" style="width: 50%"> <center> Hasil Pemeriksaan </center> </th>
            
        </thead>
        <tbody>
        <?php

        $no_urut = 0;

        $while_hasil_radiologi = $db->query("SELECT tp.nama_barang, tp.dokter_pengirim, tp.keterangan,u.nama FROM tbs_penjualan_radiologi tp INNER JOIN user u ON tp.dokter_pengirim = u.id WHERE tp.no_reg = '$no_reg' ORDER BY tp.kontras ASC");
        
            //menyimpan data sementara yang ada pada $perintah
            while ($data_while = mysqli_fetch_array($while_hasil_radiologi))
            {

              $no_urut ++;

            echo "<tr>
            <td class='table1 rata-tengah'>".$no_urut."</td>
            <td class='table1 rata-kiri'>".$data_while['nama_barang']."</td>
            <td class='table1 rata-kiri'>".$data_while['nama']."</td>
            <td class='table1 rata-kanan-kiri'>".$data_while['keterangan']."</td>
            <tr>";

            }

            //Untuk Memutuskan Koneksi Ke Database

            mysqli_close($db); 

        ?>
    </tbody>
</table>


    <div class="col-sm-9">
    
    <font class="satu"><b>Nama Pasien <br><br><br> <font class="satu"><?php echo $data_hasil['nama_pasien']; ?></font> </b></font>
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>