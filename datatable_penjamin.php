<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'nama', 
	1 => 'alamat',
	2 => 'no_telp',
	3 => 'harga',
	4 => 'jatuh_tempo',
	5  => 'id'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM penjamin";
$query=mysqli_query($conn, $sql) or die("datatable_penjamin.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM penjamin WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR no_telp LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_penjamin.php: get employees");
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

	if ($row['harga'] == 'harga_1') {
      $nestedData[] = "Level 1";
      }
      else if ($row['harga'] == 'harga_2') {
      $nestedData[] = "Level 2";
      }
      else if ($row['harga'] == 'harga_3') {
      $nestedData[] = "Level 3";
      }
      else if ($row['harga'] == 'harga_4') {
      $nestedData[] = "Level 4";
      }
      else if ($row['harga'] == 'harga_5') {
      $nestedData[] = "Level 5";
      }
      else if ($row['harga'] == 'harga_6') {
      $nestedData[] = "Level 6";
      }
      else if ($row['harga'] == 'harga_7') {
      $nestedData[] = "Level 7";
      }

     if ($row['jatuh_tempo'] == ''){
        $nestedData[] = $row["jatuh_tempo"];
      }
      else
      {
          $nestedData[] = $row["jatuh_tempo"];
      }
	
	$nestedData[] = "<button class='btn btn-success detaili' data-id='".$row['id']."'><span class='glyphicon glyphicon-list'></span> Lihat Layanan </button>";


	//edit
		$pilih_akses_penjamin = $db->query("SELECT penjamin_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjamin_edit = '1' ");
		$penjamin = mysqli_num_rows($pilih_akses_penjamin);

	          if ($penjamin > 0){
		            $nestedData[] = "<a href='edit_penjamin.php?id=".$row['id']."' class='btn btn-warning'><span class='glyphicon glyphicon-wrench'></span> Edit </a>";
		          }

		//hapus
		$pilih_akses_penjamin_hapus = $db->query("SELECT penjamin_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjamin_hapus = '1'");
		$penjamin_hapus = mysqli_num_rows($pilih_akses_penjamin_hapus);
		if ($penjamin_hapus > 0) {
			$nestedData[] = "<button class='btn btn-danger delete' data-id='".$row['id']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button>";
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
