<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$pilih_akses_jenis_obat = $db->query("SELECT jenis_obat_tambah, jenis_obat_edit, jenis_obat_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$jenis_obat = mysqli_fetch_array($pilih_akses_jenis_obat);

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
$sql.=" FROM jenis";
$query=mysqli_query($conn, $sql) or die("datatable_jenis_obat.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM jenis WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_jenis_obat.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

      if ($jenis_obat['jenis_obat_edit'] > 0) {
        $nestedData[] = "<td class='edit-jual' data-id='".$row['id']."' ><span id='text-jual-".$row['id']."'>". $row['nama'] ."</span> <input type='hidden' id='input-jual-".$row['id']."' value='".$row['nama']."' class='input_jual' data-id='".$row['id']."' autofocus=''></td>";
      }
      else{
        $nestedData[] = $row["nama"];
      }

      if ($jenis_obat['jenis_obat_hapus'] > 0) {
        $nestedData[] = "<td><button data-id='".$row['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
      }
      else{
        $nestedData[] = "can't deleted";
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
