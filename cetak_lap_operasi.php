<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT pl.nama_pelanggan AS nama_pasien, p.no_faktur,kk.nama AS kelas_kamar,c.nama AS nama_cito,u.nama AS petugas_input,o.nama_operasi,ho.no_reg,ho.harga_jual,ho.waktu,ho.id,ho.sub_operasi,ho.operasi FROM hasil_operasi ho INNER JOIN operasi o ON ho.operasi = o.id_operasi INNER JOIN user u ON ho.petugas_input = u.id INNER JOIN sub_operasi so ON ho.sub_operasi = so.id_sub_operasi INNER JOIN cito c ON so.id_cito = c.id INNER JOIN kelas_kamar kk ON so.id_kelas_kamar = kk.id INNER JOIN penjualan p ON ho.no_reg = p.no_reg INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE DATE(ho.waktu) >= '$dari_tanggal' AND DATE(ho.waktu) <= '$sampai_tanggal' ");

$hitung_item = $db->query("SELECT * FROM hasil_operasi WHERE DATE(waktu) >= '$dari_tanggal' AND DATE(waktu) <= '$sampai_tanggal' ");
$jumlah_item = mysqli_num_rows($hitung_item);


$hitung_harga = $db->query("SELECT SUM(harga_jual) AS total_jual FROM hasil_operasi WHERE DATE(waktu) >= '$dari_tanggal' AND DATE(waktu) <= '$sampai_tanggal' ");
$jumlah_harga = mysqli_fetch_array($hitung_harga);
 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN OPERASI </b></h3>
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


 <table id="tableuser" class="table table-bordered">
            <thead>
                  <th> No. Faktur </th>                  
                  <th> No. Reg </th>                  
                  <th> Nama Pasien </th>
                  <th> Operasi </th>
                  <th> Kelas Kamar </th>
                  <th> Cito </th>
                  <th> Harga Jual </th>
                  <th> Petugas Input </th>
                  <th> Waktu </th>                               
            </thead>
            
            <tbody>
            <?php

                  while ($data1 = mysqli_fetch_array($perintah))

                  {
                        //menampilkan data
	
  
			                  echo "<tr>
								<td>". $data1['no_faktur'] ." </td>
								<td>". $data1['no_reg'] ." </td>
								<td>". $data1['nama_pasien'] ." </td>
								<td>". $data1['nama_operasi'] ."</td>
								<td>". $data1['kelas_kamar'] ."</td>
								<td>". $data1['nama_cito'] ."</td>
								<td>". rp($data1['harga_jual']) ."</td>
								<td>". $data1['petugas_input'] ."</td>
								<td>". $data1['waktu'] ."</td>
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
<br>

<div class="col-sm-7">
</div>


<div class="col-sm-2">
<h4><b>Total Keseluruhan :</b></h4>
</div>


<div class="col-sm-3">
        
 <table>
  <tbody>

      <tr><td width="70%">Jumlah Item</td> <td> :&nbsp; </td> <td> <?php echo $jumlah_item; ?> </td></tr>
      <tr><td  width="70%">Total Harga Jual</td> <td> :&nbsp; </td> <td> <?php echo rp($jumlah_harga['total_jual']); ?> </td>
      </tr>

  </tbody>
  </table>


     </div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>