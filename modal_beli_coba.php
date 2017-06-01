<?php 

    include 'sanitasi.php';
    include 'db.php';
    include 'persediaan.function.php';

?>

<table id="tableuser" class="table table-bordered table-sm" >
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php $perintah = $db->query("SELECT b.id, b.kode_barang, b.nama_barang, b.harga_beli, b.satuan, b.kategori, b.suplier, b.over_stok, b.stok_barang, sk.harga_pokok FROM barang b LEFT JOIN satuan_konversi sk ON b.id = sk.id_produk WHERE b.berkaitan_dgn_stok = 'Barang' || b.berkaitan_dgn_stok = '' GROUP BY b.kode_barang ");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {

            $stok_barang = cekStokHpp($data1['kode_barang']);
            

        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' over_stok='". $data1['over_stok'] ."'
        satuan='". $data1['satuan'] ."' harga='". koma($data1['harga_beli'],2) ."' jumlah-barang='". $stok_barang ."' id-barang='". $data1['id'] ."' harga-pokok='". $data1['harga_pokok'] ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". koma($data1['harga_beli'],2) ."</td>
            <td>". $stok_barang ."</td>
            <td>". $data1['satuan'] ."</td>
            <td>". $data1['kategori'] ."</td>
            <td>". $data1['suplier'] ."</td>
            </tr>";
      
         }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
    
        </tbody> <!--tag penutup tbody-->
        
        </table> <!-- tag penutup table-->
        </div>
        
<script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>
