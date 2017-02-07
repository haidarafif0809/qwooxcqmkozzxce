<?php 
include 'db.php';

$no_faktur = $_POST['no_faktur'];
$kode_barang = $_POST['kode_barang'];


 $retur = $db->query ("SELECT no_faktur_pembelian, kode_barang, tanggal FROM detail_retur_pembelian WHERE no_faktur_pembelian = '$no_faktur' AND kode_barang = '$kode_barang'");

 $piutang = $db->query ("SELECT no_faktur_pembelian, tanggal FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$no_faktur'");

      $detail_hutang = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$no_faktur'");
      $ss = mysqli_num_rows($detail_hutang);

 ?>

<h5></h5>
<table id="tableuser" class="table table-hover">
    <thead>

          <th style='background-color: #4CAF50; color:white'> Nomor Faktur</th>
          <th style='background-color: #4CAF50; color:white'> Kode Barang</th>
          <th style='background-color: #4CAF50; color:white'> Tanggal </th>
          <th style='background-color: #4CAF50; color:white'> Keterangan </th>
          </thead>
          
          
    <tbody>
          
          <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data1 = mysqli_fetch_array($retur))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data1['no_faktur_pembelian'] ."</td>
          <td>". $data1['kode_barang'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td> Retur Pembelian </td>

          </tr>";


          }
       
          ?>

          <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data1 = mysqli_fetch_array($hpp_masuk_penjualan))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data1['no_faktur'] ."</td>
          <td>". $data1['kode_barang'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td> Transaksi Penjualan </td>

<?php if ($ss > 0){?>


          }
       
          ?>

    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($piutang))
      {
        //menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td> - </td>
      <td>". $data1['tanggal'] ."</td>
      <td> Pembayaran Hutang </td>


      </tr>";
      }
     



      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    
    </tbody>
</table>
<?php } ?>


<script>
    
    $(document).ready(function(){
    $('#tableuser').DataTable();
    });
    </script>