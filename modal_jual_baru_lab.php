<?php include 'session_login.php';
/* Database connection start */
include 'db.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
  0 =>'kode_lab', 
  1 => 'nama',
  2=> 'nambid',
  3 => 'persiapan',
  4=> 'metode',
  5 => 'harga_1',
  6=> 'harga_2',
  7=> 'harga_3',
  8 => 'harga_4',
  9=> 'harga_5',
  10=> 'harga_6',
  11=> 'harga_7',
  12=> 'id',
  13=> 'bidang'


);

// getting total number records without any search
$sql = "SELECT bl.nama AS nambid,jl.id,jl.bidang,jl.kode_lab,jl.nama,jl.persiapan,jl.metode,jl.harga_1,jl.harga_2,jl.harga_3,jl.harga_4,jl.harga_5,jl.harga_6,jl.harga_7 ";
$sql.=" FROM jasa_lab jl INNER JOIN bidang_lab bl ON jl.bidang = bl.id";
$sql.=" ORDER BY jl.id DESC";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT bl.nama AS nambid,jl.id,jl.bidang,jl.kode_lab,jl.nama,jl.persiapan,jl.metode,jl.harga_1,jl.harga_2,jl.harga_3,jl.harga_4,jl.harga_5,jl.harga_6,jl.harga_7 ";
$sql.=" FROM jasa_lab jl INNER JOIN bidang_lab bl ON jl.bidang = bl.id"; 
$sql.=" WHERE 1=1 ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( jl.kode_lab LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR jl.nama LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR bl.nama LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR jl.persiapan LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR jl.metode LIKE '".$requestData['search']['value']."%'  )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 



$sql.=" ORDER BY jl.id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

           

      $nestedData[] = $row["kode_lab"];
      $nestedData[] = $row["nama"];
      $nestedData[] = $row["nambid"];
      $nestedData[] = $row["persiapan"];
      $nestedData[] = $row["metode"];
      $nestedData[] = $row["harga_1"];  
      $nestedData[] = $row["harga_2"];
      $nestedData[] = $row["harga_3"];
      $nestedData[] = $row["harga_4"];
      $nestedData[] = $row["harga_5"];
      $nestedData[] = $row["harga_6"];
      $nestedData[] = $row["harga_7"];
      $nestedData[] = $row["id"];
      $nestedData[] = $row["bidang"];

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
