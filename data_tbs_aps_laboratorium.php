<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_reg = stringdoang($_POST['no_reg']);

$requestData= $_REQUEST;

$columns = array( 
    
    0=>'kode_barang',
    1=>'nama_pemeriksaan',
    2=>'dokter',
    3=>'analis',
    4=>'tanggal',
    5=>'jam',
    6=>'hapus',
    7=>'id'
);

$sql =" SELECT tbs.kode_barang,tbs.nama_pemeriksaan,u.nama AS dokter,us.nama AS analis,tbs.harga,tbs.tanggal,tbs.jam,tbs.id";
$sql.=" FROM tbs_hasil_lab tbs LEFT JOIN user u ON tbs.dokter = u.id LEFT JOIN user us ON tbs.analis = us.id";
$sql.=" WHERE tbs.no_reg = '$no_reg' AND tbs.status_pasien = 'APS' AND (tbs.no_faktur IS NULL OR tbs.no_faktur = '')";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tbs.kode_barang,tbs.nama_pemeriksaan,u.nama AS dokter,us.nama AS analis,tbs.harga,tbs.tanggal,tbs.jam,tbs.id";
$sql.=" FROM tbs_hasil_lab tbs LEFT JOIN user u ON tbs.dokter = u.id LEFT JOIN user us ON tbs.analis = us.id";
$sql.=" WHERE tbs.no_reg = '$no_reg' AND tbs.status_pasien = 'APS' AND (tbs.no_faktur IS NULL OR tbs.no_faktur = '')";

  $sql.=" AND (tbs.kode_barang LIKE '".$requestData['search']['value']."%'";  
  $sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR analis LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR tbs.nama_pemeriksaan LIKE '".$requestData['search']['value']."%' )";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tbs.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array(); 


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_pemeriksaan"];
      $nestedData[] = $row["dokter"];
      $nestedData[] = $row["analis"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["jam"];

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-kode='". $row['kode_barang'] ."' data-barang='". $row['nama_pemeriksaan'] ."'>Hapus</button>";
      
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