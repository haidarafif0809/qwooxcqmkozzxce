<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$pilih_akses_perujuk_edit = $db->query("SELECT perujuk_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$perujuk_edit = mysqli_fetch_array($pilih_akses_perujuk_edit);

$pilih_akses_perujuk_hapus = $db->query("SELECT perujuk_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$perujuk_hapus = mysqli_fetch_array($pilih_akses_perujuk_hapus);
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'nama', 
	1 => 'alamat',
	2=> 'no_telp',
    3=> 'id'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM perujuk";
$query=mysqli_query($conn, $sql) or die("datatable_perujuk.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM perujuk WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR no_telp LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nama"];
	$nestedData[] = $row["alamat"];
	$nestedData[] = $row["no_telp"];

	if ($perujuk_edit > 0) {
        $nestedData[] = "<a href='edit_perujuk.php?id=".$row['id']."'class='btn btn-warning'><span class='glyphicon glyphicon-wrench'></span> Edit </a>";
      }
      else{
        $nestedData[] = "can't edited";
      }

      if ($perujuk_hapus > 0) {
        $nestedData[] = "<button data-id='".$row['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>";
      }
      else{
        $nestedData[] = "can't delete";
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
