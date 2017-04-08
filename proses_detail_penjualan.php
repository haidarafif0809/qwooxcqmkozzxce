<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];
$no_reg = $_POST['no_reg'];

$detail = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");

?>

<div class="container">				
<div class="table-responsive"> 
<table id="table" class="table table-hover table-sm">
	<thead>

	<th> Nomor Faktur </th>
	<th> Kode Produk </th>
	<th> Nama Produk </th>
	<th> Jumlah Produk </th>
	<th> Satuan </th>
	<th> Tipe Produk </th>
	<th> Harga </th>
	<th> Potongan </th>
	<th> Tax </th>
	<th> Subtotal </th>
					
					
	</thead>
					
	<tbody>
	

	<?php
					
					//menyimpan data sementara yang ada pada $perintah
	while ($data1 = mysqli_fetch_array($detail))
	{

$query = $db->query("SELECT dp.id, dp.lab, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / sk.konversi AS jumlah_produk, dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, sk.id_satuan, s.nama, sa.nama AS satuan_asal, SUM(hk.sisa_barang) AS sisa_barang, dp.tipe_produk FROM detail_penjualan dp LEFT JOIN satuan_konversi sk ON dp.satuan = sk.id_satuan LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id LEFT JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.no_faktur = '$no_faktur' AND dp.kode_barang = '$data1[kode_barang]' ");

$data = mysqli_fetch_array($query);
//menampilkan data
					
echo "<tr>
					<td>". $data['no_faktur'] ."</td>
					<td>". $data['kode_barang'] ."</td>
					<td>". $data['nama_barang'] ."</td>";

					if ($data['jumlah_produk'] > 0) {
						echo "<td>". $data['jumlah_produk'] ."</td>";
					}
					else{
						echo "<td>". $data['jumlah_barang'] ."</td>";
					}
					if ($data['lab'] == 'Laboratorium') {
						echo"<td>Laboratorium</td>";
					}
					else{
						echo "<td>". $data['nama'] ."</td>";
					}
					echo"
					<td>". $data['tipe_produk'] ."</td>
					<td>". rp($data['harga']) ."</td>
					<td>". rp($data['potongan']) ."</td>
					<td>". rp($data['tax']) ."</td>
					<td>". rp($data['subtotal']) ."</td>

					</tr>";
					}


// OPERASI TABLE
 $take_data_or = $db->query("SELECT * FROM hasil_operasi WHERE no_reg = '$no_reg'");

    while($out_operasi = mysqli_fetch_array($take_data_or))
      {
                   
        $select_or = $db->query("SELECT id_operasi,nama_operasi FROM operasi WHERE id_operasi = '$out_operasi[operasi]'");
        $outin = mysqli_fetch_array($select_or);
        

        echo"<tr>
                    
            <td>". $data['no_faktur'] ."</td>
            <td class='table1' >-</td>

            ";

            if($out_operasi['operasi'] == $outin['id_operasi'])
            {
              echo"<td class='table1' align='left'>". $outin['nama_operasi'] ."</td>";
            }
            else{
              echo "<td> </td>";
            }
            

            echo " 
            <td class='table1' >-</td>
            <td class='table1' >-</td>
            <td class='table1' >-</td>
            <td class='table1' >". rp($out_operasi['harga_jual']) ."</td>
            <td class='table1' >-</td>
            <td class='table1' >-</td>
            <td class='table1' >". rp($out_operasi['harga_jual']) ."</td>
      </tr>";

                    
                  
    }


// RADIOLOGI TABLE
 $select_hasil_radiologi = $db->query("SELECT no_faktur, kode_barang, nama_barang, jumlah_barang, harga, tipe_barang, potongan, tax, subtotal FROM hasil_pemeriksaan_radiologi WHERE no_reg = '$no_reg'");

    while($data_hasil = mysqli_fetch_array($select_hasil_radiologi))
      {
       
        echo"<tr>
                    
            <td class='table1'>".$data_hasil['no_faktur']."</td>   
            <td class='table1'>".$data_hasil['kode_barang']."</td>  
            <td class='table1'>".$data_hasil['nama_barang']."</td>  
            <td class='table1'>".$data_hasil['jumlah_barang']."</td>
            <td class='table1'>Radiologi</td>
            <td class='table1'>". $data_hasil['tipe_barang'] ."</td>
            <td class='table1'>". rp($data_hasil['harga']) ."</td>
            <td class='table1'>". rp($data_hasil['potongan']) ."</td>
            <td class='table1'>". rp($data_hasil['tax']) ."</td>
            <td class='table1'>". rp($data_hasil['subtotal']) ."</td>
      </tr>";

                    
                  
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
</tbody>
					
</table>
</div>
</div>

					<script>
		
		$(document).ready(function(){
		$('#table').DataTable(
			{"ordering": false});
		});
		</script>