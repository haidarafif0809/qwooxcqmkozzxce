<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$no_rm = stringdoang($_GET['no_rm']);
$no_reg = stringdoang($_GET['no_reg']);

$query = $db->query("SELECT * FROM rekam_medik_inap WHERE no_rm = '$no_rm' AND no_reg = '$no_reg'");
$data = mysqli_fetch_array($query);


?>
<div class="container"> 

<h2><center><b>Data Laporan Pasien Rawat Inap</b></center></h2>


<br>
 <h4> 
 <b>
  No RM : <?php echo $data['no_rm']; ?><br> 
  Nama Pasien : <?php echo $data['nama']; ?> <br>
  Tanggal / Jam : <?php echo $data['tanggal_periksa']; ?> /  <?php echo $data['jam']; ?>
  </b>
</h4>
<br>

<h4>
<table>
<tbody>
  

<tr><td>Frekuensi Pernapasan</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['respiratory']; ?> &nbsp;Kali / Menit </td></tr>

<tr><td>Sistole /Distole</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['sistole_distole']; ?> &nbsp;mmHg </td></tr>

<tr><td>Suhu</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['suhu']; ?> &nbsp;°C </td></tr>

<tr><td>Nadi</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['nadi']; ?>  &nbsp;Kali / Menit    </td></tr>

<tr><td>Berat Badan</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['berat_badan']; ?> &nbsp;Kg   </td></tr>

<tr><td>Tinggi Badan</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['tinggi_badan']; ?> &nbsp;Cm  </td></tr>

<tr><td>Anamnesa</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['anamnesa']; ?></td></tr>

<tr><td>Pemeriksaan Fisik</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['pemeriksaan_fisik']; ?></td></tr>

<tr><td>keadaan Umum</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['keadaan_umum']; ?></td></tr>

<tr><td>kesadaran</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['kesadaran']; ?></td></tr>

<tr><td>Diagnosis Utama</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['kode_utama']; ?>  / <?php echo $data['icd_utama']; ?>   </td></tr>

<tr><td>Diagnosis Penyerta</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['kode_penyerta']; ?>  / <?php echo $data['icd_penyerta']; ?>   </td></tr>

<tr><td>Diagnosis Penyerta Tambahan</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['kode_penyerta_tambahan']; ?>  / <?php echo $data['icd_penyerta_tambahan']; ?>   </td></tr>

<tr><td>Komplikasi</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['kode_komplikasi']; ?> / <?php echo $data['icd_komplikasi']; ?>    </td></tr>

<tr><td>Kondisi Keluar</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['kondisi_keluar']; ?></td></tr>

<tr><td>Alergi Obat</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['alergi']; ?></td></tr>


 </tbody>
</table>

</h4>
<hr>
<div class="row">
<div class="col-sm-6">
  

<h4 style='padding:10px'><b>Obat Obatan</b></h4>
<h4>
<table>
  <thead>
    <b><tr><td style='padding:10px'>Nama Obat</td><td></td><td style='padding:10px'>Dosis</td><td></td><td>Jumlah</td></tr></b>
  </thead>
<tbody>
<?php 

$query2 = $db->query("SELECT nama_barang,dosis,jumlah_barang FROM detail_penjualan WHERE no_reg = '$data[no_reg]' AND tipe_produk = 'Obat Obatan'");
while($muncul = mysqli_fetch_array($query2))
  {


echo "<tr><td style='padding:10px'>".$muncul['nama_barang']."</td><td></td><td style='padding:10px'>".$muncul['dosis']."</td><td></td><td>".$muncul['jumlah_barang']."</td></tr>";


}
 ?>
 </tbody>
</table>
</h4>
</div>

<div class="col-sm-6">
<h4 style='padding:10px'><b>Tindakan</b></h4>
<h4>
<table>
  <thead>
    <b><tr><td style='padding:10px'>Nama</td><td></td><td>Jumlah</td></tr></b>
  </thead>
<tbody>
<?php 

$query22 = $db->query("SELECT nama_barang,jumlah_barang FROM detail_penjualan WHERE no_reg = '$data[no_reg]' AND tipe_produk = 'Jasa'");
while($muncul2 = mysqli_fetch_array($query22))
  {


echo "<tr><td style='padding:10px'>".$muncul2['nama_barang']."</td><td></td><td>".$muncul2['jumlah_barang']."</td></tr>";


}
 ?>
 </tbody>
</table>
</h4>
</div>

</div>

<a href='export_lap_kunjungan_ri.php?no_rm=<?php echo $no_rm; ?>&no_reg=<?php echo $no_reg; ?>' type='submit' class='btn btn-warning btn-lg'>Download Excel</a>


</div>

<?php include 'footer.php'; ?>


  