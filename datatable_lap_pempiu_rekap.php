<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_pembayaran', 
	1 => 'no_faktur_penjualan',
	2 => 'tanggal',
	3 => 'kode_pelanggan',
	4 => 'nama_pelanggan',
	5 => 'nama_daftar_akun',
	6 => 'potongan',
	7 => 'jumlah_bayar',
	8 => 'id'

);

// getting total number records without any search
$sql = "SELECT dpp.id, dpp.no_faktur_pembayaran, dpp.no_faktur_penjualan, dpp.tanggal, dpp.tanggal_jt, dpp.kredit, dpp.potongan, dpp.total, dpp.jumlah_bayar, dpp.kode_pelanggan, p.nama_pelanggan, pp.dari_kas, pp.total, da.nama_daftar_akun ";
$sql.=" FROM detail_pembayaran_piutang dpp INNER JOIN pelanggan p ON dpp.kode_pelanggan = p.kode_pelanggan INNER JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran INNER JOIN daftar_akun da ON pp.dari_kas = da.kode_daftar_akun WHERE dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pempiu_rekap.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT dpp.id, dpp.no_faktur_pembayaran, dpp.no_faktur_penjualan, dpp.tanggal, dpp.tanggal_jt, dpp.kredit, dpp.potongan, dpp.total, dpp.jumlah_bayar, dpp.kode_pelanggan, p.nama_pelanggan, pp.dari_kas, pp.total, da.nama_daftar_akun ";
$sql.=" FROM detail_pembayaran_piutang dpp INNER JOIN pelanggan p ON dpp.kode_pelanggan = p.kode_pelanggan INNER JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran INNER JOIN daftar_akun da ON pp.dari_kas = da.kode_daftar_akun WHERE dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal' AND 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( dpp.no_faktur_pembayaran LIKE '".$requestData['search']['value']."%' ";
	$sql.="  OR dpp.no_faktur_penjualan LIKE '".$requestData['search']['value']."%' ";
	$sql.="  OR dpp.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.="  OR dpp.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.="  OR p.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.="  OR da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatablee_lap_pempiu_rekap.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			$nestedData[] = $row['no_faktur_pembayaran'];
			$nestedData[] = $row['no_faktur_penjualan'];
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['kode_pelanggan'] . $row['nama_pelanggan'];
			$nestedData[] = $row['nama_daftar_akun'];
			$nestedData[] = $row['potongan'];
			$nestedData[] = rp($row['jumlah_bayar']);

	$nestedData[] = $row["id"];
	$data[] = $nestedData;
}

$nestedData=array(); 
			$nestedData[] = "<b style='color:black' > Periode : </b>";
			$nestedData[] = "<b style='color:black' > $dari_tanggal</b>";
			$nestedData[] = "<b style='color:black' > s/d </b>";
			$nestedData[] = "<b style='color:black' > $sampai_tanggal</b>";
			$nestedData[] = "";
			$nestedData[] = "";
			$nestedData[] = "";

	$nestedData[] = $row["id"];
	$data[] = $nestedData;


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

