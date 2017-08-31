<?php
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$cari = stringdoang($_GET['cari']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 => 'kode_pelanggan', 
  1 => 'nama_pelanggan',
  2 => 'jenis_kelamin',
  3 => 'alamat_sekarang',
  4 => 'tgl_lahir',
  5 => 'no_telp',
  6 => 'tanggal',
  7 => 'hapus',
  8 => 'edit',
  9 => 'id'


);     




$sql = "SELECT id,kode_pelanggan,nama_pelanggan,jenis_kelamin,alamat_sekarang,tgl_lahir,no_telp,gol_darah,tanggal,penjamin   ";
$sql.=" FROM pelanggan ";
$sql.=" WHERE (kode_pelanggan LIKE '%$cari%' ";
$sql.=" OR nama_pelanggan LIKE '%$cari%'  ";
$sql.=" OR tgl_lahir LIKE '%$cari%'  ";
$sql.=" OR alamat_sekarang LIKE '%$cari%') "; 
$sql.=" AND kode_pelanggan != '' ";

$query=mysqli_query($conn_pasien, $sql) or die("Eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT id,kode_pelanggan,nama_pelanggan,jenis_kelamin,alamat_sekarang,tgl_lahir,no_telp,gol_darah,tanggal,penjamin ";
$sql.=" FROM pelanggan WHERE 1=1";
$sql.=" AND (kode_pelanggan LIKE '%$cari%' ";
$sql.=" OR nama_pelanggan LIKE '%$cari%' ";
$sql.=" OR tgl_lahir LIKE '%$cari%'  ";
$sql.=" OR alamat_sekarang LIKE '%$cari%') "; 
$sql.=" AND kode_pelanggan != '' ";

if( !empty(urldecode($requestData['search_value'])) ) {   // if there is a search parameter, urldecode($requestData['search_value']) contains search parameter
  $sql.=" AND ( kode_pelanggan LIKE '".urldecode($requestData['search_value'])."%' ";    
  $sql.=" OR nama_pelanggan LIKE '".urldecode($requestData['search_value'])."%' ";
  $sql.=" OR alamat_sekarang LIKE '".urldecode($requestData['search_value'])."%' ";
  $sql.=" OR penjamin LIKE '".urldecode($requestData['search_value'])."%' )";
}

$query=mysqli_query($conn_pasien, $sql) or die("Eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn_pasien, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

  $nestedData[] = $row["kode_pelanggan"];
  $nestedData[] = $row["nama_pelanggan"];
  $nestedData[] = $row["jenis_kelamin"];  
  $nestedData[] = $row["alamat_sekarang"];
  $nestedData[] = tanggal_terbalik($row["tgl_lahir"]); 
  $nestedData[] = $row["no_telp"];
  $nestedData[] = tanggal_terbalik($row["tanggal"]);
  $nestedData[] = $row["penjamin"];
  
  $nestedData[] = "<button data-id='".$row['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i> Hapus </button>";
  $nestedData[] = "<a href='edit_data_pasien.php?id=".$row['id']."'class='btn btn-warning'><i class='fa fa-edit'></i> Edit </a>";

  $nestedData[] = $row["id"];
  $data[] = $nestedData;
}



$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

if (isset($_GET['callback'])) {
  // Validate the JSONP to make use it is an okay Javascript function to execute
  $jsonp = preg_match('/^[$A-Z_][0-9A-Z_$]*$/i', $_GET['callback']) ?
      $_GET['callback'] :
      false;
   
  if ( $jsonp ) {
      echo $jsonp.'('.json_encode($json_data).');';
  }
}
else{
  echo json_encode($json_data);  // send data as json format  
}

?>