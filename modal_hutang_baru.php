<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


 $suplier = stringdoang($_POST['suplier']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 =>'no_faktur_pembayaran', 
  1 => 'tanggal',
  2 => 'jam',
  3 => 'keterangan',
  4 => 'total',
  5 => 'user_buat',
  6 => 'user_edit',
  7 => 'tanggal_edit',
  8 => 'nama_daftar_akun',
  9 => 'id'
);

// getting total number records without any search
$sql = "SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama ";
$sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id  WHERE p.suplier = '$suplier' AND kredit != 0 ";
$query=mysqli_query($conn, $sql) or die("datatable_pembayaran_hutang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama ";
$sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id  WHERE p.suplier = '$suplier' AND kredit != 0 AND 1=1 "; 
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR p.total LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR p.suplier LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_pembayaran_hutang.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY p.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['nama'];
      $nestedData[] = $row['total'];
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['tanggal_jt'];
      $nestedData[] = $row['jam'];
      $nestedData[] = $row['user'];
      $nestedData[] = $row['status'];
      $nestedData[] = $row['potongan'];
      $nestedData[] = $row['tax'];
      $nestedData[] = $row['sisa'];
      $nestedData[] = $row['kredit'];
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

