<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

/* Database connection end */
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	0 =>'no_rm', 
	1 => 'no_reg',
	2=> 'status',
	3 => 'nama',
	4=> 'jam',
	5 => 'penjamin',
	6=> 'asal_poli',
	7=> 'dokter_pengirim',
	8 => 'dokter_pelaksanan',
	9=> 'bed',
	10 => 'kamar',
	11=> 'dokter_pengirim',
	12=> 'dokter_pelaksana',
	13=> 'tanggal_masuk',
	14=> 'penanggung_jawab',
	15=> 'umur'

		 		 										

);


// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM registrasi ";
$sql.=" WHERE  jenis_pasien = 'Rawat Inap' AND status = 'Sudah Pulang' ";
$query = mysqli_query($conn, $sql) or die("query 1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT  * ";
$sql.=" FROM registrasi ";
$sql.=" WHERE 1=1 ";
$sql.=" AND jenis_pasien = 'Rawat Inap'  ";
$sql.=" AND status = 'Sudah Pulang' ";


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR no_rm LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR status LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR nama_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR penjamin LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR poli LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dokter_pengirim LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR group_bed LIKE '".$requestData['search']['value']."%' )";
}


$query= mysqli_query($conn, $sql) or die("query 2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["status"];
	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["penjamin"];	
	$nestedData[] = $row["poli"];
	$nestedData[] = $row["dokter_pengirim"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["bed"];
	$nestedData[] = $row["group_bed"];
	$nestedData[] = tanggal($row["tanggal_masuk"]);	
	$nestedData[] = $row["penanggung_jawab"]; 
	$nestedData[] = $row["umur_pasien"];

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
