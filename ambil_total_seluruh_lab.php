<?php 
include 'db.php';
include 'sanitasi.php';

$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);


$query = $db->query("SELECT no_faktur, potongan, biaya_admin FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'	");
$total_row = 0;
while ($data = $query->fetch_array()) {

	$select = $db->query("SELECT SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total FROM detail_penjualan dp INNER JOIN jasa_lab p ON dp.kode_barang = p.kode_lab WHERE  no_faktur = '$data[no_faktur]' ");
	$row = mysqli_fetch_array($select);
	$sub_bener = $row['total'] + $data['biaya_admin'] - $data['potongan'];
	$total_row = $total_row + $sub_bener;

}
$row['total'] = $total_row ;
echo json_encode($row); 
exit;
?>