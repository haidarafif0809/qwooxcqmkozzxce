<?php
include 'db.php';
include 'sanitasi.php';




// Send Data Untuk Filter (Dapat Data Yang Dikirim)
$filter_limit = angkadoang($_POST['filter_limit']);


$query_filter = $db->query("SELECT * FROM barang WHERE over_stok <= '$filter_limit'");



?>



<table id="table_filter_limit" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Tipe </th>
            <th> Satuan </th>
            <th> Over Stok</th>
            <th>Tipe Barang</th>
           	<th> Jumlah Barang</th>
</thead>
<tbody>
<?php  
	
		while($data = mysqli_fetch_array($query_filter))
		{
			$out_limit_stok = $data['over_stok'];
			$hasilnya = $out_limit_stok + $filter_limit;

				// Cek Jumlah Barang Yang Ada
			$select_jumlah = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$data[kode_barang]'");
			$ambil_sisa_barang = mysqli_fetch_array($select_jumlah);
			 $hasil_barang = $ambil_sisa_barang['jumlah_barang'];

		if($hasil_barang < $hasilnya AND $hasil_barang >= '0')
		{
			$take_satuan = $db->query("SELECT id,nama FROM satuan");
			$out_take = mysqli_fetch_array($take_satuan);

			echo "<tr>
			<td>". $data['kode_barang'] ."</td>
			<td>". $data['nama_barang'] ."</td>
			<td>". $data['berkaitan_dgn_stok'] ."</td>";
			if ($data['satuan'] == $out_take['id'])
			{
				echo"<td>". $out_take['nama'] ."</td>";
			}
			else
			{
				echo"<td></td>";

			}
			echo "
			<td>". $data['over_stok'] ."</td>
			<td>". $data['berkaitan_dgn_stok'] ."</td>";
			// ending dapat sisa barangnya
			echo"<td>". $hasil_barang ."</td>";
			}
			else
			{

			}
			
			
		echo "</tr>";
	
		}
		

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>  

</div> <!-- penutup table responsive -->

<a href='expor_excel_filter_over_barang.php?filter_limit=<?php echo $filter_limit; ?>' type='submit' class='btn btn-warning btn-lg'>Download Excel</a>

</div> <!--Closed Container-->

<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table_over').DataTable({"ordering":false});
    });

</script>

