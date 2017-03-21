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
	
	0 => 'no_rm',
	1 => 'no_reg',
	2 => 'no_faktur',
	3 => 'nama_pasien',
	4 => 'dokter',
	5 => 'analis',
	6 => 'status_rawat',
	7 => 'tanggal',
	8 => 'id'


);


// getting total number records without any search

$sql = "SELECT us.nama AS dokter, se.nama AS analis,hl.nama_pasien,hl.no_rm,hl.no_faktur,hl.no_reg,hl.nama_pemeriksaan,hl.status,
	hl.hasil_pemeriksaan,hl.id,hl.status_pasien,hl.tanggal ";
$sql.= "FROM hasil_lab hl LEFT JOIN user us ON hl.dokter = us.id  LEFT JOIN user se ON hl.petugas_analis = se.id";
$sql.=" WHERE hl.tanggal >= '$dari_tanggal' AND hl.tanggal <= '$sampai_tanggal'";
$sql.=" GROUP BY hl.no_reg";

$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT us.nama AS dokter, se.nama AS analis,hl.nama_pasien,hl.no_rm,hl.no_faktur,hl.no_reg,hl.nama_pemeriksaan,hl.status,
	hl.hasil_pemeriksaan,hl.id,hl.status_pasien,hl.tanggal ";
$sql.= "FROM hasil_lab hl LEFT JOIN user us ON hl.dokter = us.id LEFT JOIN user se ON hl.petugas_analis = se.id";
$sql.=" WHERE hl.tanggal >= '$dari_tanggal' AND hl.tanggal <= '$sampai_tanggal'";


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( hl.nama_pasien LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_rm LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR hl.no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_rm LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.tanggal LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR hl.status_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR us.nama LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR se.nama LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR hl.nama_pemeriksaan LIKE '".$requestData['search']['value']."%' )";
}


$sql.=" GROUP BY hl.no_reg";

$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
/*$sql.=" GROUP BY hl.no_rm ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."";*/
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["no_reg"];

if($row["no_faktur"] == '')
{
	$nestedData[] = "<p style='color:red'> Belum Penjualan</p>";
}
else
{
	$nestedData[] = $row["no_faktur"];	
}

	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["analis"];
	$nestedData[] = $row["status_pasien"];
	$nestedData[] = $row["tanggal"];

	$nestedData[] = $row["id"];

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