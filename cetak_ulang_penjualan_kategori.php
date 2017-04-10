<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT kode_pelanggan, nama, no_faktur, jenis_penjualan, potongan, tax, biaya_admin, total, tunai, sisa, tanggal FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT SUM(subtotal) AS subtotal_obat FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND (tipe_produk = 'Obat Obatan' OR tipe_produk = 'Barang') ");
    $data2 = mysqli_fetch_array($query2);

    $queryja = $db->query("SELECT SUM(subtotal) AS subtotal_jasa FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND tipe_produk = 'Jasa' AND lab != 'Laboratorium' ");
    $dataja = mysqli_fetch_array($queryja);

    $query_l = $db->query("SELECT SUM(subtotal) AS subtotal_laundry FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND tipe_produk = 'Laundry' ");
    $data_l = mysqli_fetch_array($query_l);

    $query_lab = $db->query("SELECT SUM(subtotal) AS subtotal_lab FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND tipe_produk = 'Jasa' AND lab = 'Laboratorium' ");
    $data_lab = mysqli_fetch_array($query_lab);

    $query_bed = $db->query("SELECT SUM(subtotal) AS subtotal_bed FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND tipe_produk = 'Bed' ");
    $data_bed = mysqli_fetch_array($query_bed);

    $sum_radiologi = $db->query("SELECT SUM(subtotal) AS subtotal_radiologi FROM hasil_pemeriksaan_radiologi WHERE no_faktur = '$no_faktur'");
    $data_radiologi = mysqli_fetch_array($sum_radiologi);

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
      <tr><td width="50%">Obat Obatan</td> <td> :</td> <td><?php echo rp($data2['subtotal_obat']);?> </tr>
      <tr><td  width="50%">Tindakan</td> <td> :</td> <td> <?php echo rp($dataja['subtotal_jasa']);?> </td></tr>            
      <tr><td width="50%">Laboratorium</td> <td> :</td> <td><?php echo rp($data_lab['subtotal_lab']);?> </tr>
      <tr><td width="50%">Radiologi</td> <td> :</td> <td><?php echo rp($data_radiologi['subtotal_radiologi']);?> </tr>
      <?php if ($data0['jenis_penjualan'] == 'Rawat Inap')
      {
echo '<tr><td  width="50%">Laundry</td> <td> :</td> <td>'.$data_l['subtotal_laundry'].' </td></tr>
      <tr><td  width="50%">Bed</td> <td> :</td> <td>'.$data_bed['subtotal_bed'].'</td></tr>';
      }
      ?>
  </tbody>

</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo rp($data0['potongan']);?> </tr>
      <tr><td  width="50%">Pajak</td> <td> :</td> <td> <?php echo rp($data0['tax']);?> </td></tr>
      <tr><td  width="50%">Biaya Admin</td> <td> :</td> <td> <?php echo rp($data0['biaya_admin']);?> </td></tr>      
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
    Selamat Datang Kembali<br>
    Telp. <?php echo $data1['no_telp']; ?><br>


 <script>
$(document).ready(function(){
  window.print();
});
</script>

 </body>
 </html>
