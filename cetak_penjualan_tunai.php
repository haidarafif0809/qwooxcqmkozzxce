<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];


    $query4 = $db->query("SELECT SUM(tax) as pajak FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data4 = mysqli_fetch_array($query4);
    $pajakee = $data4['pajak'];


    $select_operasi = $db->query("SELECT * FROM hasil_operasi WHERE no_reg = '$data0[no_reg]'");

    $query4 = $db->query("SELECT status_print FROM setting_printer WHERE nama_print = 'Printer Struk'");
    $datas = mysqli_fetch_array($query4);
    $status_print = $datas['status_print'];


    
 ?>


  <?php echo $data1['nama_perusahaan']; ?><br>
  <?php echo $data1['alamat_perusahaan']; ?><br><br>

===================<br>
  <table>
  <tbody>
    <tr>
<td>No RM </td><td>&nbsp;:&nbsp;</td><td> <?php echo $data0['kode_pelanggan'];?></td></tr><tr>
<td>Nama Pasien </td><td>&nbsp;:&nbsp;</td><td> <?php echo $data0['nama'];?></td>
    </tr>
  </tbody>
</table>
===================<br>
 <table>
  <tbody>
    <tr>
<td>No Faktur</td><td>&nbsp;:&nbsp;</td><td> <?php echo $data0['no_faktur']; ?></td></tr><tr>
<td>Kasir </td><td>&nbsp;:&nbsp;</td><td> <?php echo $_SESSION['nama']; ?></td>
    </tr>
  </tbody>
</table>
===================<br>
 <table>

  <tbody>
 <?php if ($status_print == 'Detail'){

           while ($data2 = mysqli_fetch_array($query2)){
           
           echo '<tr>
           <td width:"50%"> '. $data2['nama_barang'] .' </td> 
           <td style="padding:3px"> '. $data2['jumlah_barang'] .'</td> 
            <td style="padding:3px"> '. rp($data2['harga']) .'</td> 
             <td style="padding:3px"> '. rp($data2['subtotal']) . ' </td></tr>';
           
           }
       } 

//Untuk Memutuskan Koneksi Ke Database
           
           
           ?> 

<?php 
           while ($out_operasi = mysqli_fetch_array($select_operasi))
           {

              $select_or = $db->query("SELECT id_operasi,nama_operasi FROM operasi");
              $outin = mysqli_fetch_array($select_or);
                 
              echo '<tr>';

              if($out_operasi['operasi'] == $outin['id_operasi'])
              {
                  echo' <td width:"50%"> '. $outin['nama_operasi'] .' </td> ';
              }
                  echo' <td style="padding:3px"> </td> 
                        <td style="padding:3px"></td>
                        <td style="padding:3px"> '. rp($out_operasi['harga_jual']) .'</td> 

              </tr>';

           }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);            
           
           ?> 
           
 </tbody>
</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo rp($data0['potongan']);?> </tr>
      <tr><td  width="50%">Pajak</td> <td> :</td> <td> <?php echo rp($pajakee);?> </td></tr>
      <tr><td  width="50%">Biaya Admin</td> <td> :</td> <td> <?php echo rp($data0['biaya_admin']);?> </td></tr>
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo $total_item; ?> </td></tr>
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo rp($data0['total']); ?> </tr>
      <tr><td  width="50%">Tunai</td> <td> :</td> <td> <?php echo rp($data0['tunai']); ?> </td></tr>
      <tr><td  width="50%">Kembalian</td> <td> :</td> <td> <?php echo rp($data0['sisa']); ?>  </td></tr>
            

  </tbody>
</table>
    ===================<br>
    ===================<br>
    Tanggal : <?php echo tanggal($data0['tanggal']);?><br>
    ===================<br><br>
    Terima Kasih<br>
    Semoga Lekas Sembuh...<br>
    Telp. <?php echo $data1['no_telp']; ?><br>


 <script>
$(document).ready(function(){
  window.print();
});
</script>

 </body>
 </html>
