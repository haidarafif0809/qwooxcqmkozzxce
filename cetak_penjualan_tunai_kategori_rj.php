<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$no_reg = $_GET['no_reg'];
    

$row = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
$data_row = mysqli_num_rows($row);
if ($data_row > 0) {

    $tanggal = date('Y-m-d');
    $total = $_GET['total'];
    $potongan = $_GET['potongan'];
    $biaya_admin = $_GET['biaya_admin'];
    $tunai = $_GET['tunai'];
    $sisa = $_GET['sisa'];
    $no_rm = $_GET['no_rm'];
    $nama_asli = $_GET['nama_pasien'];

    $query0 = $db->query("SELECT r.id, r.no_rm, r.nama_pasien AS nama_asli, SUM(tp.subtotal) AS total_subtotal, alamat_pasien AS alamat, s.nama AS nama_satuan, r.penjamin, SUM(tp.jumlah_barang) as total_item,  SUM(tp.tax) as pajak, r.jenis_pasien AS jenis_penjualan FROM registrasi r INNER JOIN tbs_penjualan tp on r.no_reg = tp.no_reg INNER JOIN satuan s ON tp.satuan = s.id WHERE r.no_reg = '$no_reg' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT SUM(subtotal) AS subtotal_obat FROM tbs_penjualan WHERE no_reg = '$no_reg' AND (tipe_barang = 'Obat Obatan' OR tipe_barang = 'Barang') ");
    $data2 = mysqli_fetch_array($query2);

    $queryja = $db->query("SELECT SUM(subtotal) AS subtotal_jasa FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Jasa' AND lab = '' ");
    $dataja = mysqli_fetch_array($queryja);

    $query_l = $db->query("SELECT SUM(subtotal) AS subtotal_laundry FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Laundry' ");
    $data_l = mysqli_fetch_array($query_l);

    $query_lab = $db->query("SELECT SUM(subtotal) AS subtotal_lab FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Jasa' AND lab = 'Laboratorium' ");
    $data_lab = mysqli_fetch_array($query_lab);

      $query_bed = $db->query("SELECT SUM(subtotal) AS subtotal_bed FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Bed' ");
    $data_bed = mysqli_fetch_array($query_bed);

    $select_operasi = $db->query("SELECT SUM(harga_jual) AS total_operasi FROM hasil_operasi WHERE no_reg = '$no_reg'");
        $out_operasi = mysqli_fetch_array($select_operasi);

}
else{

    $query0 = $db->query("SELECT p.id,p.no_reg,p.jenis_penjualan,p.kode_pelanggan,p.nama,p.no_faktur,p.potongan,p.tax AS pajak,p.biaya_admin,p.total,p.tunai,p.sisa,p.tanggal,dp.id as iddp,sum(dp.subtotal) as total_subtotal FROM penjualan p inner join detail_penjualan dp on p.no_faktur = dp.no_faktur WHERE p.no_reg = '$no_reg' ");
    $data0 = mysqli_fetch_array($query0);

    $nama_asli = $data0['nama'];
    $no_rm = $data0['kode_pelanggan'];
    $tanggal = date('Y-m-d');
    $total = $data0['total'];
    $potongan = $data0['potongan'];
    $biaya_admin = $data0['biaya_admin'];
    $tunai = $data0['tunai'];
    $sisa = $data0['sisa'];
    

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT SUM(subtotal) AS subtotal_obat FROM detail_penjualan WHERE no_reg = '$no_reg' AND (tipe_produk = 'Obat Obatan' OR tipe_produk = 'Barang') ");
    $data2 = mysqli_fetch_array($query2);

    $queryja = $db->query("SELECT SUM(subtotal) AS subtotal_jasa FROM detail_penjualan WHERE no_reg = '$no_reg' AND tipe_produk = 'Jasa' AND lab = '' ");
    $dataja = mysqli_fetch_array($queryja);

    $query_l = $db->query("SELECT SUM(subtotal) AS subtotal_laundry FROM detail_penjualan WHERE no_reg = '$no_reg' AND tipe_produk = 'Laundry' ");
    $data_l = mysqli_fetch_array($query_l);

    $query_lab = $db->query("SELECT SUM(subtotal) AS subtotal_lab FROM detail_penjualan WHERE no_reg = '$no_reg' AND tipe_produk = 'Jasa' AND lab = 'Laboratorium' ");
    $data_lab = mysqli_fetch_array($query_lab);

      $query_bed = $db->query("SELECT SUM(subtotal) AS subtotal_bed FROM detail_penjualan WHERE no_reg = '$no_reg' AND tipe_produk = 'Bed' ");
    $data_bed = mysqli_fetch_array($query_bed);

    $select_operasi = $db->query("SELECT SUM(harga_jual) AS total_operasi FROM hasil_operasi WHERE no_reg = '$no_reg'");
        $out_operasi = mysqli_fetch_array($select_operasi);
}


 ?>


  <?php echo $data1['nama_perusahaan']; ?><br>
  <?php echo $data1['alamat_perusahaan']; ?><br><br>
  
===================<br>
  <table>
  <tbody>
    <tr>
<td>No RM </td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_rm;?></td></tr><tr>

<td>Nama Pasien </td><td>&nbsp;:&nbsp;</td><td> <?php echo $nama_asli;?></td>
    </tr>
  </tbody>
</table>
===================<br>
 <table>
  <tbody>
    <tr>
<?php if ($data_row > 0): ?>
  <td>No. REG</td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_reg; ?></td></tr><tr>  
<?php else: ?>
  <td>No. Faktur</td><td>&nbsp;:&nbsp;</td><td> <?php echo $data0['no_faktur']; ?></td></tr><tr>
<?php endif ?>
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
      <?php if ($data0['jenis_penjualan'] == 'Rawat Inap')
      {
echo '<tr><td  width="50%">Laundry</td> <td> :</td> <td>'.$data_l['subtotal_laundry'].' </td></tr>
      <tr><td  width="50%">Bed</td> <td> :</td> <td>'.$data_bed['subtotal_bed'].'</td></tr>';
      }
      ?>


<?php 
           

              
 echo' <tr><td  width="50%">Operasi</td> <td> :</td> <td>'.rp($out_operasi['total_operasi']).' </td></tr>';

  

           
//Untuk Memutuskan Koneksi Ke Database

           
           ?> 
           
  </tbody>

</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td width="50%">Subtotal</td> <td> :</td> <td><?php echo rp($data0['total_subtotal']);?> </tr>
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo rp($potongan);?> </tr>
      <tr><td  width="50%">Biaya Admin</td> <td> :</td> <td> <?php echo rp($biaya_admin);?> </td></tr>      
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo rp($total); ?> </tr>
      <tr><td  width="50%">Tunai</td> <td> :</td> <td> <?php echo rp($tunai); ?> </td></tr>
      <tr><td  width="50%">Kembalian</td> <td> :</td> <td> <?php echo rp($sisa); ?>  </td></tr>
            

  </tbody>
</table>
    ===================<br>
    ===================<br>
    Tanggal : <?php echo tanggal($tanggal);?><br>
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
