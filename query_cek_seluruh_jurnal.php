<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>Penjualan</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		<th>Nilai Persediaan Jurnal</th>
		<th>Nilai Persediaan Di hpp Keluar</th>
		<th>Status Balance Persediaan</th>
	</thead>
	<tbody>

<?php 


// jurnal penjualan 

$query_penjualan = $db->query("SELECT no_faktur,tanggal FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_penjualan = mysqli_fetch_array($query_penjualan)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_penjualan = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_penjualan[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_penjualan = mysqli_fetch_array($query_jurnal_penjualan);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_penjualan['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE penjualan SET keterangan = 'Edit Otomatis Jurnal' WHERE no_faktur = '$data_penjualan[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_penjualan['total_debit'] - $data_jurnal_penjualan['total_kredit'];
	$status_balance = 'Balance';


	//nilai persediaan di jurnal 

	$query_nilai_persediaan_jurnal = $db->query("SELECT kredit AS nilai_persediaan FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_penjualan[no_faktur]'");
	$data_nilai_persediaan_jurnal = mysqli_fetch_array($query_nilai_persediaan_jurnal);
	// nilai persediaan di hpp keluar 
	$query_nilai_persediaan_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS nilai_persediaan FROM hpp_keluar WHERE no_faktur = '$data_penjualan[no_faktur]'");
	$data_nilai_persediaan_hpp_keluar = mysqli_fetch_array($query_nilai_persediaan_hpp_keluar);

	//status balance persediaan

	$status_balance_persediaan = 'Balance';
	$selisih_persediaan = $data_nilai_persediaan_jurnal['nilai_persediaan'] - $data_nilai_persediaan_hpp_keluar['nilai_persediaan'];

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 OR $selisih_persediaan != 0) {
		# code...
		$status_balance = 'Tidak Balance';
		$status_balance_persediaan = 'Tidak Balance';

		$db->query("UPDATE penjualan SET keterangan = 'Edit Otomatis Jurnal Karena Tidak Balance' WHERE no_faktur = '$data_penjualan[no_faktur]'");

	}
	echo "<tr>
			<td>".$data_penjualan['no_faktur']."</td>
			<td>".$data_penjualan['tanggal']."</td>
			<td>".$data_jurnal_penjualan['jumlah_jurnal']."</td>
			<td>".$data_jurnal_penjualan['total_debit']."</td>
			<td>".$data_jurnal_penjualan['total_kredit']."</td>
			<td>".$status_balance."</td>
			<td>".$data_nilai_persediaan_jurnal['nilai_persediaan']."</td>
			<td>".$data_nilai_persediaan_hpp_keluar['nilai_persediaan']."</td>
			<td>".$status_balance_persediaan."</td>
		 </tr>";
}


 ?>
</tbody>
</table>


<h2>Pembelian</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		<th>Nilai Persediaan Jurnal</th>
		<th>Nilai Persediaan Di hpp Masuk</th>
		<th>Status Balance Persediaan</th>
	</thead>
	<tbody>


<?php 


// jurnal penjualan 

$query_pembelian = $db->query("SELECT no_faktur,tanggal FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_pembelian = mysqli_fetch_array($query_pembelian)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_pembelian = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_pembelian[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_pembelian = mysqli_fetch_array($query_jurnal_pembelian);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_pembelian['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE pembelian SET no_faktur = '$data_pembelian[no_faktur]' WHERE no_faktur = '$data_pembelian[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_pembelian['total_debit'] - $data_jurnal_pembelian['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE pembelian SET no_faktur = '$data_pembelian[no_faktur]' WHERE no_faktur = '$data_pembelian[no_faktur]'");

	}

	//nilai persediaan di jurnal 

	$query_nilai_persediaan_jurnal = $db->query("SELECT debit AS nilai_persediaan FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_pembelian[no_faktur]'");
	$data_nilai_persediaan_jurnal = mysqli_fetch_array($query_nilai_persediaan_jurnal);
	// nilai persediaan di hpp keluar 
	$query_nilai_persediaan_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS nilai_persediaan FROM hpp_masuk WHERE no_faktur = '$data_pembelian[no_faktur]'");
	$data_nilai_persediaan_hpp_masuk = mysqli_fetch_array($query_nilai_persediaan_hpp_masuk);

	//status balance persediaan

	$status_balance_persediaan = 'Balance';
	$selisih_persediaan = $data_nilai_persediaan_jurnal['nilai_persediaan'] - $data_nilai_persediaan_hpp_masuk['nilai_persediaan'];
	if ($selisih_persediaan != 0) {
		# code...
		$status_balance_persediaan = 'Tidak Balance';

		$update_persediaan_jurnal = $db->query("UPDATE jurnal_trans SET debit = $data_nilai_persediaan_hpp_masuk[nilai_persediaan] WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_pembelian[no_faktur]' ");


	}
	echo "<tr>
			<td>".$data_pembelian['no_faktur']."</td>
			<td>".$data_pembelian['tanggal']."</td>
			<td>".$data_jurnal_pembelian['jumlah_jurnal']."</td>
			<td>".$data_jurnal_pembelian['total_debit']."</td>
			<td>".$data_jurnal_pembelian['total_kredit']."</td>
			<td>".$status_balance."</td>
			<td>".$data_nilai_persediaan_jurnal['nilai_persediaan']."</td>
			<td>".$data_nilai_persediaan_hpp_masuk['nilai_persediaan']."</td>
			<td>".$status_balance_persediaan."</td>
		 </tr>";
}


 ?>
</tbody>
</table>



<h2>Retur Pembelian</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		<th>Nilai Persediaan Jurnal</th>
		<th>Nilai Persediaan Di hpp Keluar</th>
		<th>Status Balance Persediaan</th>
	</thead>
	<tbody>


<?php 


// jurnal penjualan 

$query_retur_pembelian = $db->query("SELECT no_faktur_retur AS no_faktur ,tanggal FROM retur_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_retur_pembelian = mysqli_fetch_array($query_retur_pembelian)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_retur_pembelian = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_retur_pembelian[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_retur_pembelian = mysqli_fetch_array($query_jurnal_retur_pembelian);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_retur_pembelian['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE retur_pembelian SET no_faktur_retur = '$data_retur_pembelian[no_faktur]' WHERE no_faktur_retur = '$data_retur_pembelian[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_retur_pembelian['total_debit'] - $data_jurnal_retur_pembelian['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE retur_pembelian SET no_faktur_retur = '$data_retur_pembelian[no_faktur]' WHERE no_faktur_retur = '$data_retur_pembelian[no_faktur]'");

	}

	//nilai persediaan di jurnal 

	$query_nilai_persediaan_jurnal = $db->query("SELECT kredit AS nilai_persediaan FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_retur_pembelian[no_faktur]'");
	$data_nilai_persediaan_jurnal = mysqli_fetch_array($query_nilai_persediaan_jurnal);

	// nilai persediaan di hpp keluar 
	$query_nilai_persediaan_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS nilai_persediaan FROM hpp_keluar WHERE no_faktur = '$data_retur_pembelian[no_faktur]'");
	$data_nilai_persediaan_hpp_keluar = mysqli_fetch_array($query_nilai_persediaan_hpp_keluar);

	//status balance persediaan

	$status_balance_persediaan = 'Balance';
	$selisih_persediaan = $data_nilai_persediaan_jurnal['nilai_persediaan'] - $data_nilai_persediaan_hpp_keluar['nilai_persediaan'];

	if ($selisih_persediaan != 0) {
		# code...
		$status_balance_persediaan = 'Tidak Balance';

		$update_persediaan_jurnal = $db->query("UPDATE jurnal_trans SET kredit = $data_nilai_persediaan_hpp_keluar[nilai_persediaan] WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_retur_pembelian[no_faktur]' ");


	}
	echo "<tr>
			<td>".$data_retur_pembelian['no_faktur']."</td>
			<td>".$data_retur_pembelian['tanggal']."</td>
			<td>".$data_jurnal_retur_pembelian['jumlah_jurnal']."</td>
			<td>".$data_jurnal_retur_pembelian['total_debit']."</td>
			<td>".$data_jurnal_retur_pembelian['total_kredit']."</td>
			<td>".$status_balance."</td>
			<td>".$data_nilai_persediaan_jurnal['nilai_persediaan']."</td>
			<td>".$data_nilai_persediaan_hpp_keluar['nilai_persediaan']."</td>
			<td>".$status_balance_persediaan."</td>
		 </tr>";
}


 ?>
</tbody>
</table>




<h2>Retur Penjualan</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		<th>Nilai Persediaan Jurnal</th>
		<th>Nilai Persediaan Di hpp Masuk</th>
		<th>Status Balance Persediaan</th>
	</thead>
	<tbody>


<?php 


// jurnal retur penjualan 

$query_retur_penjualan = $db->query("SELECT no_faktur_retur AS no_faktur ,tanggal FROM retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_retur_penjualan = mysqli_fetch_array($query_retur_penjualan)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_retur_penjualan = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_retur_penjualan[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_retur_penjualan = mysqli_fetch_array($query_jurnal_retur_penjualan);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_retur_penjualan['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE retur_penjualan SET no_faktur_retur = '$data_retur_penjualan[no_faktur]' WHERE no_faktur_retur = '$data_retur_penjualan[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_retur_penjualan['total_debit'] - $data_jurnal_retur_penjualan['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE retur_penjualan SET no_faktur_retur = '$data_retur_penjualan[no_faktur]' WHERE no_faktur_retur = '$data_retur_penjualan[no_faktur]'");

	}

	//nilai persediaan di jurnal 

	$query_nilai_persediaan_jurnal = $db->query("SELECT debit AS nilai_persediaan FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_retur_penjualan[no_faktur]'");
	$data_nilai_persediaan_jurnal = mysqli_fetch_array($query_nilai_persediaan_jurnal);

	// nilai persediaan di hpp masuk 
	$query_nilai_persediaan_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS nilai_persediaan FROM hpp_masuk WHERE no_faktur = '$data_retur_penjualan[no_faktur]'");
	
	$data_nilai_persediaan_hpp_masuk = mysqli_fetch_array($query_nilai_persediaan_hpp_masuk);

	//status balance persediaan

	$status_balance_persediaan = 'Balance';
	$selisih_persediaan = $data_nilai_persediaan_jurnal['nilai_persediaan'] - $data_nilai_persediaan_hpp_masuk['nilai_persediaan'];
	if ($selisih_persediaan != 0) {
		# code...
		$status_balance_persediaan = 'Tidak Balance';

		$update_persediaan_jurnal = $db->query("UPDATE jurnal_trans SET debit = $data_nilai_persediaan_hpp_masuk[nilai_persediaan] WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_retur_penjualan[no_faktur]' ");


	}
	echo "<tr>
			<td>".$data_retur_penjualan['no_faktur']."</td>
			<td>".$data_retur_penjualan['tanggal']."</td>
			<td>".$data_jurnal_retur_penjualan['jumlah_jurnal']."</td>
			<td>".$data_jurnal_retur_penjualan['total_debit']."</td>
			<td>".$data_jurnal_retur_penjualan['total_kredit']."</td>
			<td>".$status_balance."</td>
			<td>".$data_nilai_persediaan_jurnal['nilai_persediaan']."</td>
			<td>".$data_nilai_persediaan_hpp_masuk['nilai_persediaan']."</td>
			<td>".$status_balance_persediaan."</td>
		 </tr>";
}


 ?>
</tbody>
</table>

<h2>Item Keluar</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		<th>Nilai Persediaan Jurnal</th>
		<th>Nilai Persediaan Di hpp Keluar</th>
		<th>Status Balance Persediaan</th>
	</thead>
	<tbody>

<?php 


// jurnal item_keluar 

$query_item_keluar = $db->query("SELECT no_faktur,tanggal FROM item_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_item_keluar = mysqli_fetch_array($query_item_keluar)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di item_keluar tersebut
	$query_jurnal_item_keluar = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_item_keluar[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_item_keluar = mysqli_fetch_array($query_jurnal_item_keluar);
	//jika jumlah jurnal nya kurang dari 2 , maka item_keluarnya di lakukan update , agar jurnal nya kembali benar.



	$selisih_debit_kredit = $data_jurnal_item_keluar['total_debit'] - $data_jurnal_item_keluar['total_kredit'];
	$status_balance = 'Balance';


	//nilai persediaan di jurnal 

	$query_nilai_persediaan_jurnal = $db->query("SELECT kredit AS nilai_persediaan FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_item_keluar[no_faktur]'");
	$data_nilai_persediaan_jurnal = mysqli_fetch_array($query_nilai_persediaan_jurnal);
	// nilai persediaan di hpp keluar 
	$query_nilai_persediaan_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS nilai_persediaan FROM hpp_keluar WHERE no_faktur = '$data_item_keluar[no_faktur]'");
	$data_nilai_persediaan_hpp_keluar = mysqli_fetch_array($query_nilai_persediaan_hpp_keluar);

	//status balance persediaan

	$status_balance_persediaan = 'Balance';
	$selisih_persediaan = $data_nilai_persediaan_jurnal['nilai_persediaan'] - $data_nilai_persediaan_hpp_keluar['nilai_persediaan'];

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 OR $selisih_persediaan != 0) {

		$status_balance = 'Tidak Balance';
		$status_balance_persediaan = 'Tidak Balance';

		$db->query("UPDATE jurnal_trans SET debit = '$data_nilai_persediaan_hpp_keluar[nilai_persediaan]' WHERE no_faktur = '$data_item_keluar[no_faktur]' AND kode_akun_jurnal = '5-2202' ");

		$db->query("UPDATE jurnal_trans SET kredit = '$data_nilai_persediaan_hpp_keluar[nilai_persediaan]' WHERE no_faktur = '$data_item_keluar[no_faktur]' AND kode_akun_jurnal = '1-1301' ");

	}
	echo "<tr>
			<td>".$data_item_keluar['no_faktur']."</td>
			<td>".$data_item_keluar['tanggal']."</td>
			<td>".$data_jurnal_item_keluar['jumlah_jurnal']."</td>
			<td>".$data_jurnal_item_keluar['total_debit']."</td>
			<td>".$data_jurnal_item_keluar['total_kredit']."</td>
			<td>".$status_balance."</td>
			<td>".$data_nilai_persediaan_jurnal['nilai_persediaan']."</td>
			<td>".$data_nilai_persediaan_hpp_keluar['nilai_persediaan']."</td>
			<td>".$status_balance_persediaan."</td>
		 </tr>";
}


 ?>
</tbody>
</table>


<h2>Stok Opname</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal stok Opname 

$query_stok_opname = $db->query("SELECT no_faktur AS no_faktur ,tanggal FROM stok_opname WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_stok_opname = mysqli_fetch_array($query_stok_opname)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_stok_opname = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_stok_opname[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_stok_opname = mysqli_fetch_array($query_jurnal_stok_opname);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_stok_opname['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE stok_opname SET no_faktur_retur = '$data_stok_opname[no_faktur]' WHERE no_faktur_retur = '$data_stok_opname[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_stok_opname['total_debit'] - $data_jurnal_stok_opname['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE stok_opname SET no_faktur_retur = '$data_stok_opname[no_faktur]' WHERE no_faktur_retur = '$data_stok_opname[no_faktur]'");

	}





	
	echo "<tr>
			<td>".$data_stok_opname['no_faktur']."</td>
			<td>".$data_stok_opname['tanggal']."</td>
			<td>".$data_jurnal_stok_opname['jumlah_jurnal']."</td>
			<td>".$data_jurnal_stok_opname['total_debit']."</td>
			<td>".$data_jurnal_stok_opname['total_kredit']."</td>
			<td>".$status_balance."</td>

		 </tr>";
}


 ?>
</tbody>
</table>

<h2>Kas Keluar</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal penjualan 

$query_kas_keluar = $db->query("SELECT no_faktur,tanggal FROM kas_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_kas_keluar = mysqli_fetch_array($query_kas_keluar)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_kas_keluar = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_kas_keluar[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_kas_keluar = mysqli_fetch_array($query_jurnal_kas_keluar);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_kas_keluar['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE kas_keluar SET no_faktur = '$data_kas_keluar[no_faktur]' WHERE no_faktur = '$data_kas_keluar[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_kas_keluar['total_debit'] - $data_jurnal_kas_keluar['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE kas_keluar SET no_faktur = '$data_kas_keluar[no_faktur]' WHERE no_faktur = '$data_kas_keluar[no_faktur]'");

	}

	echo "<tr>
			<td>".$data_kas_keluar['no_faktur']."</td>
			<td>".$data_kas_keluar['tanggal']."</td>
			<td>".$data_jurnal_kas_keluar['jumlah_jurnal']."</td>
			<td>".$data_jurnal_kas_keluar['total_debit']."</td>
			<td>".$data_jurnal_kas_keluar['total_kredit']."</td>
			<td>".$status_balance."</td>
		 </tr>";
}


 ?>
</tbody>
</table>



<h2>Kas Masuk</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal penjualan 

$query_kas_masuk = $db->query("SELECT no_faktur,tanggal FROM kas_masuk WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_kas_masuk = mysqli_fetch_array($query_kas_masuk)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_kas_masuk = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_kas_masuk[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_kas_masuk = mysqli_fetch_array($query_jurnal_kas_masuk);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_kas_masuk['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE kas_masuk SET no_faktur = '$data_kas_masuk[no_faktur]' WHERE no_faktur = '$data_kas_masuk[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_kas_masuk['total_debit'] - $data_jurnal_kas_masuk['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE kas_masuk  SET no_faktur = '$data_kas_masuk[no_faktur]' WHERE no_faktur = '$data_kas_masuk[no_faktur]'");

	}

	echo "<tr>
			<td>".$data_kas_masuk['no_faktur']."</td>
			<td>".$data_kas_masuk['tanggal']."</td>
			<td>".$data_jurnal_kas_masuk['jumlah_jurnal']."</td>
			<td>".$data_jurnal_kas_masuk['total_debit']."</td>
			<td>".$data_jurnal_kas_masuk['total_kredit']."</td>
			<td>".$status_balance."</td>
		 </tr>";
}


 ?>
</tbody>
</table>



<h2>Kas Mutasi</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal penjualan 

$query_kas_mutasi = $db->query("SELECT no_faktur,tanggal FROM kas_mutasi WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_kas_mutasi = mysqli_fetch_array($query_kas_mutasi)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_kas_mutasi = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_kas_mutasi[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_kas_mutasi = mysqli_fetch_array($query_jurnal_kas_mutasi);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_kas_mutasi['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE kas_mautasiSET no_faktur = '$data_kas_mutasi[no_faktur]' WHERE no_faktur = '$data_kas_mutasi[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_kas_mutasi['total_debit'] - $data_jurnal_kas_mutasi['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE kas_mutasi  SET no_faktur = '$data_kas_mutasi[no_faktur]' WHERE no_faktur = '$data_kas_mutasi[no_faktur]'");

	}

	echo "<tr>
			<td>".$data_kas_mutasi['no_faktur']."</td>
			<td>".$data_kas_mutasi['tanggal']."</td>
			<td>".$data_jurnal_kas_mutasi['jumlah_jurnal']."</td>
			<td>".$data_jurnal_kas_mutasi['total_debit']."</td>
			<td>".$data_jurnal_kas_mutasi['total_kredit']."</td>
			<td>".$status_balance."</td>
		 </tr>";
}


 ?>
</tbody>
</table>



<h2>Pembayaran Hutang</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal pembayaran hutang 

$query_pembayaran_hutang = $db->query("SELECT no_faktur_pembayaran AS no_faktur ,tanggal FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_pembayaran_hutang = mysqli_fetch_array($query_pembayaran_hutang)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_pembayaran_hutang = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_pembayaran_hutang[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_pembayaran_hutang = mysqli_fetch_array($query_jurnal_pembayaran_hutang);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_pembayaran_hutang['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE pembayaran_hutang SET no_faktur_pembayaran = '$data_pembayaran_hutang[no_faktur]' WHERE no_faktur = '$data_pembayaran_hutang[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_pembayaran_hutang['total_debit'] - $data_jurnal_pembayaran_hutang['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE pembayaran_hutang  SET no_faktur_pembayaran = '$data_pembayaran_hutang[no_faktur]' WHERE no_faktur = '$data_pembayaran_hutang[no_faktur]'");

	}

	echo "<tr>
			<td>".$data_pembayaran_hutang['no_faktur']."</td>
			<td>".$data_pembayaran_hutang['tanggal']."</td>
			<td>".$data_jurnal_pembayaran_hutang['jumlah_jurnal']."</td>
			<td>".$data_jurnal_pembayaran_hutang['total_debit']."</td>
			<td>".$data_jurnal_pembayaran_hutang['total_kredit']."</td>
			<td>".$status_balance."</td>
		 </tr>";
}


 ?>
</tbody>
</table>



<h2>Pembayaran Piutang</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal pembayaran piutang 

$query_pembayaran_piutang = $db->query("SELECT no_faktur_pembayaran AS no_faktur ,tanggal FROM pembayaran_piutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_pembayaran_piutang = mysqli_fetch_array($query_pembayaran_piutang)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_pembayaran_piutang = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_pembayaran_piutang[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_pembayaran_piutang = mysqli_fetch_array($query_jurnal_pembayaran_piutang);
	//jika jumlah jurnal nya kurang dari 2 , maka penjualannya di lakukan update , agar jurnal nya kembali benar.

	if ($data_jurnal_pembayaran_piutang['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE pembayaran_piutang SET no_faktur_pembayaran = '$data_pembayaran_piutang[no_faktur]' WHERE no_faktur = '$data_pembayaran_piutang[no_faktur]'");
	}

	$selisih_debit_kredit = $data_jurnal_pembayaran_piutang['total_debit'] - $data_jurnal_pembayaran_piutang['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		$db->query("UPDATE pembayaran_piutang  SET no_faktur_pembayaran = '$data_pembayaran_piutang[no_faktur]' WHERE no_faktur = '$data_pembayaran_piutang[no_faktur_pembayaranaktur]'");

	}

	echo "<tr>
			<td>".$data_pembayaran_piutang['no_faktur']."</td>
			<td>".$data_pembayaran_piutang['tanggal']."</td>
			<td>".$data_jurnal_pembayaran_piutang['jumlah_jurnal']."</td>
			<td>".$data_jurnal_pembayaran_piutang['total_debit']."</td>
			<td>".$data_jurnal_pembayaran_piutang['total_kredit']."</td>
			<td>".$status_balance."</td>
		 </tr>";
}


 ?>
</tbody>
</table>





<h2>Jurnal Manual</h2>
<table border="1">
<thead>
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
		<th>Total Debit</th>
		<th>Total Kredit</th>
		<th>Status Balance Jurnal</th>
		
	</thead>
	<tbody>


<?php 


// jurnal pembayaran piutang 

$query_jurnal_manual = $db->query("SELECT no_faktur_jurnal AS no_faktur ,tanggal FROM nomor_faktur_jurnal WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_jurnal_manual = mysqli_fetch_array($query_jurnal_manual)) {
	# code...
	//query untuk mengambil ada berapa jumlah jurnal di penjualan tersebut
	$query_jurnal_jurnal_manual = $db->query("SELECT COUNT(*) AS jumlah_jurnal,SUM(debit) AS total_debit,SUM(kredit) AS total_kredit  FROM jurnal_trans WHERE no_faktur = '$data_jurnal_manual[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal_jurnal_manual = mysqli_fetch_array($query_jurnal_jurnal_manual);


	$selisih_debit_kredit = $data_jurnal_jurnal_manual['total_debit'] - $data_jurnal_jurnal_manual['total_kredit'];
	$status_balance = 'Balance';

	// jika debit kredit nya ada selisih maka lakukan update agar menjadi balance
	if ($selisih_debit_kredit != 0 ) {
		# code...
		$status_balance = 'Tidak Balance';

		

	}

	echo "<tr>
			<td>".$data_jurnal_manual['no_faktur']."</td>
			<td>".$data_jurnal_manual['tanggal']."</td>
			<td>".$data_jurnal_jurnal_manual['jumlah_jurnal']."</td>
			<td>".$data_jurnal_jurnal_manual['total_debit']."</td>
			<td>".$data_jurnal_jurnal_manual['total_kredit']."</td>
			<td>".$status_balance."</td>
		 </tr>";
}


 ?>
</tbody>
</table>


 </body>
</html>