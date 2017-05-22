<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$penjamin = stringdoang($_POST['penjamin']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'no_faktur', 
    1=>'kode_pelanggan',
    2=>'total',
    3=>'tanggal',
    4=>'tanggal_jt',
    5=>'jam',
    6=>'user',
    7=>'status', 
    8=>'potongan',
    9=>'tax',
    10=>'sisa',
    11=>'kredit' 
);

// getting total number records without any search
if ($penjamin == "") {
  $sql =" SELECT id, no_faktur, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, status, potongan, tax, sisa, kredit ";
  $sql.=" FROM penjualan WHERE kredit != 0";
}
else{  
  $sql =" SELECT id, no_faktur, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, status, potongan, tax, sisa, kredit ";
  $sql.=" FROM penjualan WHERE penjamin = '$penjamin' AND kredit != 0";
}

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
if ($penjamin == "") {
  $sql =" SELECT id, no_faktur, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, status, potongan, tax, sisa, kredit ";
  $sql.=" FROM penjualan WHERE kredit != 0";
}
else{  
  $sql =" SELECT id, no_faktur, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, status, potongan, tax, sisa, kredit ";
  $sql.=" FROM penjualan WHERE penjamin = '$penjamin' AND kredit != 0";
}

    $sql.=" AND (no_faktur LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR kode_pelanggan LIKE '".$requestData['search']['value']."%' )";


    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array();

  $query_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$row[kode_pelanggan]'");
  $data_pelanggan = mysqli_fetch_array($query_pelanggan);

      $nestedData[] = $row["no_faktur"];
      $nestedData[] = $row["kode_pelanggan"];
      $nestedData[] = $data_pelanggan["nama_pelanggan"];
      $nestedData[] = $row["total"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["tanggal_jt"];
      $nestedData[] = $row["jam"];
      $nestedData[] = $row["user"];
      $nestedData[] = $row["status"];
      $nestedData[] = rp($row["potongan"]);
      $nestedData[] = rp($row["tax"]);
      $nestedData[] = rp($row["sisa"]);
      $nestedData[] = rp($row["kredit"]);
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