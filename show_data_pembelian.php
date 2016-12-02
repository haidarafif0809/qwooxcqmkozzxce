<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

/* Database connection end */


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
$sql = "SELECT * ";
$sql.="FROM pembelian ";

$query=mysqli_query($conn, $sql) or die("show_data_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT *";
$sql.="FROM pembelian  ";
$sql.="WHERE 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR suplier LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR total LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR jam LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR user LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR status LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR kredit LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("show_data_pembelian.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("show_data_pembelian.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
$select = $db->query("SELECT nama FROM suplier WHERE id = '$row[suplier]'");
$out = mysqli_fetch_array($select);

	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $out["nama"];
	$nestedData[] = $row["total"];
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["user"];
	$nestedData[] = $row["status"];
	$nestedData[] = $row["potongan"];
	$nestedData[] = $row["tax"];
	$nestedData[] = $row["sisa"];
	$nestedData[] = $row["kredit"];
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
