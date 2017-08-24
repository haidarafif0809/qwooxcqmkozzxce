<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$totalData = 0;
$totalFiltered = 0;

$columns = array( 
// datatable column index  => database column name

    0=>'no_reg', 
    1=>'no_rm',
    2=>'nama_pasien',
    3=>'jenis_pasien',
    4=>'tanggal',
    5=>'penjamin',
    6=>'poli',
    7=>'dokter',
    8=>'id'    

);

// getting total number records without any search
$sql = "SELECT no_reg, no_rm, nama_pasien, jenis_pasien, tanggal, penjamin, poli, dokter, id,  id_dokter,  level_harga";
$sql.=" FROM registrasi  ";
$sql.=" WHERE jenis_pasien = 'UGD' AND  (status != 'Batal UGD' AND status != 'Rujuk Rumah Sakit' AND status != 'Sudah Pulang') ";

$query = mysqli_query($conn, $sql) or die("eror 1");
while( $row_data=mysqli_fetch_array($query) ) {  // preparing an array
      $totalData = $totalData + 1;

    }

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, 

    $sql.=" AND (no_reg LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR no_rm LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR nama_pasien LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR jenis_pasien LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
    while($row_filter=mysqli_fetch_array($query) ) {  // preparing an array
     
      $totalFiltered = $totalFiltered + 1; 

    }    
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["penjamin"];
      $nestedData[] = $row["poli"];
      $nestedData[] = $row["id_dokter"];
      $nestedData[] = $row["level_harga"];
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