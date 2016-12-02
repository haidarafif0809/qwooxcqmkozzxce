<?php 

    include 'sanitasi.php';
    include 'db.php';

    $status = 'Hutang' ;

?>
      <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="tableuser" class="table table-bordered table-sm">
    <thead>
      <th> Nomor Faktur </th>
      <th> Suplier </th>
      <th> Total Beli</th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
      <th> Jam </th>
      <th> User </th>
      <th> Status </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa </th>
      <th> Kredit </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintahku = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang  FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE status = '$status'" );

    //menyimpan data sementara yang ada pada $perintah
      while ($data11 = mysqli_fetch_array($perintahku))
      {

        // menampilkan data
       echo "<tr class='pilih' no-faktur='". $data11['no_faktur'] ."' kredit='". $data11['kredit'] ."' na_suplier='".$data11['suplier']."' total='". $data11['total'] ."' tanggal_jt='". $data11['tanggal_jt'] ."' >
      
      <td>". $data11['no_faktur'] ."</td>
      <td>". $data11['nama'] ."</td>
      <td>". $data11['total'] ."</td>
      <td>". $data11['tanggal'] ."</td>
      <td>". $data11['tanggal_jt'] ."</td>
      <td>". $data11['jam'] ."</td>
      <td>". $data11['user'] ."</td>
      <td>". $data11['status'] ."</td>
      <td>". $data11['potongan'] ."</td>
      <td>". $data11['tax'] ."</td>
      <td>". $data11['sisa'] ."</td>
      <td>". $data11['kredit'] ."</td>
      </tr>";
      
       }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
    ?>
    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->
  <script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>

