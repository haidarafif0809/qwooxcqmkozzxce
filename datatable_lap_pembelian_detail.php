<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

/* Database connection end */

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur',
	1 => 'suplier',
	2 => 'total',
	3 => 'tanggal',
	4 => 'jam',
	5 => 'user',
	6 => 'status',
	7 => 'potongan',
	8 => 'tax',
	9 => 'sisa',
	10 => 'kredit'

);

// getting total number records without any search
$sql = "SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa ";
$sql.="FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";

$query=mysqli_query($conn, $sql) or die("show_data_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa ";
$sql.="FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR dp.kode_barang LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("show_data_pembelian.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY CONCAT(dp.tanggal,' ',dp.jam) DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("show_data_pembelian.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			$nestedData[] = $row['no_faktur'];
					$nestedData[] = $row['kode_barang'];
					$nestedData[] = $row['nama_barang'];
					$nestedData[] = $row['jumlah_barang'];
					$nestedData[] = $row['nama'];
					$nestedData[] = rp($row['harga']);
					$nestedData[] = rp($row['subtotal']);
					$nestedData[] = rp($row['potongan']);
					$nestedData[] = rp($row['tax']);
					$nestedData[] = rp($row['sisa']);
			$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
