<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_persediaan_barang.xls");

include 'db.php';
include 'sanitasi.php';

    
 ?>


<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Data Produk</b></h3></center></tr>
	</tbody>
</table>
</b>
</h3>
    <table id="kartu_stok" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th style='background-color: #4CAF50; color: white'> Kode Barang </th>
            <th style='background-color: #4CAF50; color: white'> Nama Barang </th>
            <th style='background-color: #4CAF50; color: white'> Harga Beli </th>
            <th style='background-color: #4CAF50; color: white'> Margin</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 1</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 2</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 3</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 4</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 5</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 6</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 7</th>
            <th style='background-color: #4CAF50; color: white'> HPP</th>
            <th style='background-color: #4CAF50; color: white'> Jumlah Barang </th>
            <th style='background-color: #4CAF50; color: white'> Satuan </th>
            <th style='background-color: #4CAF50; color: white'> Satuan Konversi </th>
            <th style='background-color: #4CAF50; color: white'> Kategori </th>

		</thead>
<tbody>

<?php 
$total_akhir_hpp = 0;

    $perintah = $db->query("SELECT s.nama,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang FROM barang b LEFT JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang'  ORDER BY b.id DESC");

while ($row = mysqli_fetch_array($perintah)) {

        $a = $row['harga_beli'];
        $b = $row['harga_jual'];

          if ($b == '') {
              $f = 0;
          }
          else{
            $c = $b - $a;
            $d = $c;

            if ($d == 0 OR $b == 0) {
            	$f = 0;
            }
            else{

            	 //Gross Profit Margin itu rumusnya (harga jual-harga beli)/Harga jual x 100
            $e =  ($d / $b) * 100;

            $f = round($e,2);

            }
           
          }

            $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $ambil_sisa = mysqli_fetch_array($select);


            $hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $cek_awal_masuk = mysqli_fetch_array($hpp_masuk);
            
            $hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]'");
            $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);


            $total_hpp = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

            $total_akhir_hpp = $total_akhir_hpp + $total_hpp;

            if ($ambil_sisa['jumlah_barang'] == 0) {
               
            }
            else
            {


                     echo "<tr>
                        <td>".$row["kode_barang"]."</td>
                        <td>".$row["nama_barang"]."</td>
                        <td>".$row["harga_beli"]."</td>
                        <td>".persen($f)."</td>
                        <td>".$row["harga_jual"]."</td>
                        <td>".$row["harga_jual2"]."</td>
                        <td>".$row["harga_jual3"]."</td>
                        <td>".$row["harga_jual4"]."</td>
                        <td>".$row["harga_jual5"]."</td>
                        <td>".$row["harga_jual6"]."</td>
                        <td>".$row["harga_jual7"]."</td>
                        <td>".$total_hpp."</td>
                        <td>".$ambil_sisa['jumlah_barang']."</td>
                        <td>".$row["nama"]."</td>
                        <td>".$row["kategori"]."</td>
                    </tr>";
                    
            }

   
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



