<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'url_data_pasien', 
	1 => 'url_cari_pasien',
	2 => 'id'
);

// getting total number records without any search
$sql = "SELECT id, url_cari_pasien, url_data_pasien ";
$sql.=" FROM setting_registrasi_pasien";
$query=mysqli_query($conn, $sql) or die("datatable_setting_registrasi_pasien.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT id, url_cari_pasien, url_data_pasien ";
$sql.=" FROM setting_registrasi_pasien WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( url_data_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR url_cari_pasien LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
$no_urut = 1;
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$nestedData[] = $no_urut++.".";
		$nestedData[] = "<p class='edit-cari' data-id='".$row['id']."'><span id='text-cari-".$row['id']."'>". $row['url_cari_pasien'] ."</span> <input type='hidden' id='input-cari-".$row['id']."' value='".$row['url_cari_pasien']."' class='input_cari' data-id='".$row['id']."' data-cari='".$row['url_cari_pasien']."' autofocus=''></p>";
		$nestedData[] = "<p class='edit-data' data-id='".$row['id']."'><span id='text-data-".$row['id']."'>". $row['url_data_pasien'] ."</span> <input type='hidden' id='input-data-".$row['id']."' value='".$row['url_data_pasien']."' class='input_data' data-id='".$row['id']."' data-data='".$row['url_data_pasien']."' autofocus=''></p>";	

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
