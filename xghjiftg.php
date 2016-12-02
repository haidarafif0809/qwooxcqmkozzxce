<?php 

// memsukan file db,php
include 'db.php';
include 'sanitasi.php';

$token = stringdoang($_GET['token']);
$penghapus = stringdoang($_GET['penghapus']);

$waktu = date('Y-m-d H:i:s');
if ($token == "afdsvdsgvnk" AND $penghapus != '' ) {

$penjualan1 = $db->query("DELETE FROM penjualan");
$penjualan2 = $db->query("DELETE FROM detail_penjualan");
$penjualan3 = $db->query("DELETE  FROM tbs_penjualan");

$pembelian1 = $db->query("DELETE FROM pembelian");
$pembelian2 = $db->query("DELETE FROM detail_pembelian");
$pembelian3 = $db->query("DELETE FROM tbs_pembelian");

$pembayaran_hutang = $db->query("DELETE FROM pembayaran_hutang");
$pembayaran_hutang = $db->query("DELETE FROM detail_pembayaran_hutang");
$pembayaran_hutang = $db->query("DELETE FROM tbs_pembayaran_hutang");

$pembayaran_piutang = $db->query("DELETE FROM pembayaran_piutang");
$pembayaran_piutang = $db->query("DELETE FROM detail_pembayaran_piutang");
$pembayaran_piutang = $db->query("DELETE FROM tbs_pembayaran_piutang");

$kas_masuk = $db->query("DELETE FROM kas_masuk");
$kas_masuk = $db->query("DELETE FROM detail_kas_masuk");
$kas_masuk = $db->query("DELETE FROM tbs_kas_masuk");

$kas_mutasi = $db->query("DELETE FROM kas_mutasi");
$kas_mutasi = $db->query("DELETE FROM detail_kas_mutasi");

$kas_keluar = $db->query("DELETE FROM kas_keluar");
$kas_keluar = $db->query("DELETE FROM detail_kas_keluar");
$kas_keluar = $db->query("DELETE FROM tbs_kas_keluar");

$stok_awal = $db->query("DELETE FROM stok_awal");
$stok_awal = $db->query("DELETE FROM tbs_stok_awal");

$stok_opname = $db->query("DELETE FROM stok_opname");
$stok_opname = $db->query("DELETE FROM detail_stok_opname");
$stok_opname = $db->query("DELETE FROM tbs_stok_opname");


$item_masuk = $db->query("DELETE FROM item_masuk");
$item_masuk = $db->query("DELETE FROM detail_item_masuk");
$item_masuk = $db->query("DELETE FROM tbs_item_masuk");

$item_keluar = $db->query("DELETE FROM item_keluar");
$item_keluar = $db->query("DELETE FROM detail_item_keluar");
$item_keluar = $db->query("DELETE FROM tbs_item_keluar");

$retur_penjualan = $db->query("DELETE FROM retur_penjualan");
$retur_penjualan = $db->query("DELETE FROM detail_retur_penjualan");
$retur_penjualan = $db->query("DELETE FROM tbs_retur_penjualan");

$retur_pembelian = $db->query("DELETE FROM retur_pembelian");
$retur_pembelian = $db->query("DELETE FROM detail_retur_pembelian");
$retur_pembelian = $db->query("DELETE FROM tbs_retur_pembelian");
	

$laporan_fee_faktur = $db->query("DELETE FROM laporan_fee_produk");
$laporan_fee_produk = $db->query("DELETE FROM laporan_fee_faktur");

$laporan_fee_faktur = $db->query("DELETE FROM tbs_fee_produk");
$nomor_faktur_jurnal = $db->query("DELETE FROM nomor_faktur_jurnal");


$rekam_medik_rj = $db->query("DELETE FROM rekam_medik");
$rekam_medik_ri = $db->query("DELETE FROM rekam_medik_inap");
$rekam_medik_ugd = $db->query("DELETE FROM rekam_medik_ugd");
$registrasi = $db->query("DELETE FROM registrasi");


$hpp_masuk = $db->query("DELETE FROM hpp_masuk");
$hpp_keluar = $db->query("DELETE FROM hpp_keluar");

$hpp = $db->query("DELETE FROM hpp");
$hpp_barang = $db->query("DELETE FROM hpp_barang");


$jurnal_trans = $db->query("DELETE FROM jurnal_trans");

$kartu_stok = $db->query("DELETE FROM kartu_stok");

$status_print = $db->query("DELETE FROM status_print");

$status_tbs_1 = $db->query("DELETE FROM tbs_operasi");
$status_tbs_2 = $db->query("DELETE FROM tbs_detail_operasi");

$status_hasil_1 = $db->query("DELETE FROM hasil_operasi");
$status_hasil_2 = $db->query("DELETE FROM hasil_detail_operasi");



$insert_histori = $db->query("INSERT INTO hapus_transaksi_db (nama,waktu) VALUES ('$penghapus','$waktu')");
?>

<table class="table table-bordered table-sm"  >	
<thead>	
<tr>
<th style='background-color: #4CAF50; color: white'>Nama Penghapus</th>
<th style='background-color: #4CAF50; color: white'>Waktu</th>
</tr>
<tbody>	
<?php

$selected = $db->query("SELECT * FROM hapus_transaksi_db ");

while($data = mysqli_fetch_array($selected))

			{
		echo "
		<tr>
		<td>". $data['nama']."</td>
		<td>". $data['waktu']."</td>
		</tr>";
		}

?>

</tbody>
</thead>
</table>
<?php

}

else 
{
	echo "<center><h2>Gagal Anda Tidak Mengisi Nama Penghapus</h2></center>";
}

?>


<script>
    
    $(document).ready(function(){
    $('table').DataTable();
    });
</script>

