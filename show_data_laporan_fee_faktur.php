<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama_petugas', 
	1 => 'no_faktur',
	2 => 'jumlah_fee',
	3 => 'tanggal',
	4 => 'jam'
);

// getting total number records without any search
$sql = "SELECT f.nama_petugas, f.no_faktur, f.jumlah_fee, f.tanggal, f.jam, u.nama ";
$sql.=" FROM laporan_fee_faktur f INNER JOIN user u ON f.nama_petugas = u.id";

$query=mysqli_query($conn, $sql) or die("show_data_laporan_fee_produk.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT f.nama_petugas, f.no_faktur, f.jumlah_fee, f.tanggal, f.jam, u.nama ";
$sql.=" FROM laporan_fee_faktur f INNER JOIN user u ON f.nama_petugas = u.id";
$sql.=" WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( u.nama LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR f.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR f.tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("show_data_laporan_fee_produk.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("show_data_laporan_fee_produk.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nama"];
	$nestedData[] = $row["no_faktur"];
	$nestedData[] = rp($row["jumlah_fee"]);
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];	           
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
