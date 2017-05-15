<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = stringdoang($_POST['session_id']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'id', 
    1=>'no_faktur_penjualan',
    2=>'tanggal',
    3=>'tanggal_jt',
    4=>'kredit',
    5=>'potongan',
    6=>'total',
    7=>'jumlah_bayar'   

);

// getting total number records without any search
$sql =" SELECT id, no_faktur_penjualan, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar ";
$sql.=" FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT id, no_faktur_penjualan, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar ";
$sql.=" FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'";

    $sql.=" AND (no_faktur_penjualan LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR tanggal_jt LIKE '".$requestData['search']['value']."%' )";


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

      $nestedData[] = $row["no_faktur_penjualan"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["tanggal_jt"];
      $nestedData[] = rp($row["kredit"]);
      $nestedData[] = rp($row["potongan"]);
      $nestedData[] = rp($row["total"]);
      $nestedData[] = rp($row["jumlah_bayar"]);

      $nestedData[] = "<p> <button class='btn btn-sm btn-danger btn-hapus' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_penjualan'] ."' data-piutang='". $row['kredit'] ."' data-jumlah-bayar='". $row['jumlah_bayar'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </p>";
      $nestedData[] = "<p> <button class='btn btn-sm btn-success btn-edit-tbs' data-id='". $row['id'] ."' data-kredit='". $row['kredit'] ."' data-jumlah-bayar='". $row['jumlah_bayar'] ."' data-no-faktur-penjualan='". $row['no_faktur_penjualan'] ."' data-potongan='". $row['potongan'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </p>";

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