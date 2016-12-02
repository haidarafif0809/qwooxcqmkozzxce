<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id', 
	1 => 'nama_kategori'
);

// getting total number records without any search
$sql = "SELECT id, nama_kategori ";
$sql.=" FROM kategori";
$query=mysqli_query($conn, $sql) or die("datatable_kategori_barang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT id, nama_kategori ";
$sql.=" FROM kategori WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama_kategori LIKE '".$requestData['search']['value']."%' )"; 
}
$query=mysqli_query($conn, $sql) or die("datatable_kategori_barang.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nama_kategori"];
	//akses hapus
	$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
	$otoritas = mysqli_num_rows($pilih_akses_otoritas);

	    if ($otoritas > 0) {
	$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-kategori='". $row['nama_kategori'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
	}

	//akses edit
	$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
	$otoritas = mysqli_num_rows($pilih_akses_otoritas);

	    if ($otoritas > 0) {
	$nestedData[] = "<button class='btn btn-info btn-edit' data-kategori='". $row['nama_kategori'] ."' data-id='". $row['id'] ."'> <i class='fa fa-edit'> </i> Edit </button>";
		}
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


