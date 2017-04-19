<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$perintah11 = $db->query("SELECT * FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$total_row = mysqli_num_rows($perintah11);

$perintah210 = $db->query("SELECT SUM(total) AS total_total, SUM(nilai_kredit) AS total_kredit FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data210 = mysqli_fetch_array($perintah210);

$total_total = $data210['total_total'];
$total_kredit = $data210['total_kredit'];

$total_bayar = $total_total - $total_kredit;


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'tanggal', 
);

// getting total number records without any search
$sql =" SELECT tanggal ";
$sql.=" FROM penjualan ";
$sql.=" WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY tanggal";
$query=mysqli_query($conn, $sql) or die("eror.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT tanggal ";
$sql.=" FROM penjualan ";
$sql.=" WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND (tanggal LIKE '".$requestData['search']['value']."%' )";  

}
 // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " GROUP BY tanggal ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("eror.php2: get employees");
$totalFiltered = mysqli_num_rows($query);

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();      

    $perintah1 = $db->query("SELECT * FROM penjualan WHERE tanggal = '$row[tanggal]'");
    $data1 = mysqli_num_rows($perintah1);
            
    $perintah2 = $db->query("SELECT SUM(total) AS t_total, SUM(nilai_kredit) AS t_kredit FROM penjualan WHERE tanggal = '$row[tanggal]'");
    $data2 = mysqli_fetch_array($perintah2);
    $t_total = $data2['t_total'];
    $t_kredit = $data2['t_kredit'];

    $t_bayar = $t_total - $t_kredit;

      $nestedData[] = "<p>". $row['tanggal'] ."</p>";
      $nestedData[] = "<p>". $data1."</p>";
      $nestedData[] = "<p>". rp($t_total) ."</p>";
      $nestedData[] = "<p>". rp($t_bayar) ."</p>";
      $nestedData[] = "<p>". rp($t_kredit) ."</p>";

  $data[] = $nestedData;
}

  $nestedData=array();  


      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_row)." </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_total)." </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_bayar)." </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_kredit)." </p>";
	
	$data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>