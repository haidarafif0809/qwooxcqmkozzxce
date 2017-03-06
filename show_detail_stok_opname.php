<?php
include 'db.php';
include 'sanitasi.php';

$no_faktur = $_POST['no_faktur'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

    0=>'no_faktur', 
    1=>'kode_barang',
    2=>'nama_barang',
    3=>'stok_komputer',
    4=>'fisik',
    5=>'selisih_fisik', 
    6=>'hpp',
    7=>'selisih_harga',
    8=>'id'

);

// getting total number records without any search


$sql = "SELECT * ";
$sql.=" FROM detail_stok_opname";
$sql.=" WHERE no_faktur = '$no_faktur'";

$query=mysqli_query($conn, $sql) or die("1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT * ";
$sql.=" FROM detail_stok_opname";
$sql.=" WHERE no_faktur = '$no_faktur'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( kode_barang LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR no_faktur LIKE '".$requestData['search']['value']."%' ) ";
} 

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


 $sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

    $nestedData=array(); 

    $nestedData[] = $row["no_faktur"];
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = rp($row["stok_sekarang"]);
    $nestedData[] = rp($row["fisik"]);
    $nestedData[] = rp($row["selisih_fisik"]);
    $nestedData[] = rp($row["hpp"]);
    $nestedData[] = rp($row["selisih_harga"]);
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