<?php
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$query_total_penjualan = $db->query("SELECT SUM(total) AS total_akhir, SUM(potongan) AS potongan_akhir, SUM(tax) AS tax_akhir, SUM(biaya_admin) AS biaya_admin_akhir, SUM(sisa) AS kembalian_akhir, SUM(kredit) AS kredit_akhir  FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_total_penjualan = mysqli_fetch_array($query_total_penjualan);

$subtotal = $data_total_penjualan['total_akhir'] + $data_total_penjualan['potongan_akhir'] - $data_total_penjualan['tax_akhir'] - $data_total_penjualan['biaya_admin_akhir'];


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
$sql =" SELECT dp.id,pel.nama_pelanggan,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.biaya_admin,dp.sisa,dp.kredit ";
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

$query_subtotal = $db->query("SELECT SUM(subtotal) AS subtotal  FROM detail_penjualan WHERE no_faktur = '$row[no_faktur]' ");
$data_subtotal = mysqli_fetch_array($query_subtotal);

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = "<p>".$row['kode_pelanggan']." || ".$row['nama_pelanggan']." </p>";
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['jam'];
      $nestedData[] = $row['user'];
      $nestedData[] = $row['status'];
      $nestedData[] = rp($data_subtotal['subtotal']);
      $nestedData[] = rp($row['potongan']);
      $nestedData[] = rp($row['tax']);
      $nestedData[] = rp($row['biaya_admin']);
      $nestedData[] = rp($row['total']);
      $nestedData[] = rp($row['kredit']);

  $data[] = $nestedData;
}

  $nestedData=array();

      $nestedData[] = "<p style='color:red'>TOTAL</p>";
      $nestedData[] = "<p style='color:red'></p>";
      $nestedData[] = "<p style='color:red'></p>";
      $nestedData[] = "<p style='color:red'></p>";
      $nestedData[] = "<p style='color:red'></p>";
      $nestedData[] = "<p style='color:red'></p>";
      $nestedData[] = "<p style='color:red'>".rp($subtotal)."</p>";
      $nestedData[] = "<p style='color:red'>".rp($data_total_penjualan['potongan_akhir'])."</p>";
      $nestedData[] = "<p style='color:red'>".rp($data_total_penjualan['tax_akhir'])."</p>";
      $nestedData[] = "<p style='color:red'>".rp($data_total_penjualan['biaya_admin_akhir'])."</p>";
      $nestedData[] = "<p style='color:red'>".rp($data_total_penjualan['total_akhir'])."</p>";
      $nestedData[] = "<p style='color:red'>".rp($data_total_penjualan['kredit_akhir'])."</p>";

  $data[] = $nestedData;

  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>