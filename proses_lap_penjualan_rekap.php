<?php
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);




// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

  0 => 'Tanggal', 
  1 => 'Nomor',
  2 => 'Kode',
  3 => 'Total',
  4 => 'Jam', 
  5 => 'User',
  6 => 'Status',
  7 => 'Potongan',
  8 => 'tax',
  9 => 'biaya_admin',
  10 => 'kembalian',
  11 => 'kredit'

);


// getting total number records without any search
$sql =" SELECT dp.id,pel.nama_pelanggan,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.biaya_admin,dp.sisa,dp.kredit  ";
$sql.=" FROM penjualan dp LEFT JOIN pelanggan pel ON dp.kode_pelanggan = pel.kode_pelanggan WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";

$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT dp.id,pel.nama_pelanggan,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.biaya_admin,dp.sisa,dp.kredit ";
$sql.=" FROM penjualan dp LEFT JOIN pelanggan pel ON dp.kode_pelanggan = pel.kode_pelanggan WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR dp.tanggal LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR dp.kode_pelanggan LIKE '".$requestData['search']['value']."%' )";
	
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.="ORDER BY CONCAT(dp.tanggal,' ',dp.jam) DESC  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['kode_pelanggan'];
      $nestedData[] = $row['total'];
      $nestedData[] = $row['jam'];
      $nestedData[] = $row['user'];
      $nestedData[] = $row['status'];
      $nestedData[] = rp($row['potongan']);
      $nestedData[] = rp($row['tax']);
      $nestedData[] = rp($row['biaya_admin']);
      $nestedData[] = $row['sisa'];
      $nestedData[] = $row['kredit'];

  $data[] = $nestedData;
}

  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>