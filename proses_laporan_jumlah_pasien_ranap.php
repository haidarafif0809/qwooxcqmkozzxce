<?php
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$query_hitung_jumlah_hari = $db->query("SELECT SUM(DATEDIFF(DATE(p.tanggal), r.tanggal_masuk)) AS jumlah_hari FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg WHERE r.jenis_pasien = 'Rawat Inap' AND r.tanggal_masuk >= '$dari_tanggal' AND r.tanggal_masuk <= '$sampai_tanggal'");
$data_hitung_jumlah_hari = mysqli_fetch_array($query_hitung_jumlah_hari);

$total_pasien_ranap = $data_hitung_jumlah_hari['jumlah_hari'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

  0 => 'no_rm', 
  1 => 'no_reg',
  2 => 'nama_pasien',
  3 => 'penjamin',
  4 => 'tanggal', 
  5 => 'no_faktur'

);


// getting total number records without any search
$sql = "SELECT r.no_rm,r.no_reg,r.nama_pasien,r.penjamin,r.tanggal_masuk, p.tanggal, p.no_faktur, DATEDIFF(DATE(p.tanggal), r.tanggal_masuk) AS jumlah_hari ";
$sql.=" FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg ";
$sql.=" WHERE r.jenis_pasien = 'Rawat Inap' AND r.tanggal_masuk >= '$dari_tanggal' AND r.tanggal_masuk <= '$sampai_tanggal'";

$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT r.no_rm,r.no_reg,r.nama_pasien,r.penjamin,r.tanggal_masuk, p.tanggal, p.no_faktur, DATEDIFF(DATE(p.tanggal), r.tanggal_masuk) AS jumlah_hari ";
$sql.=" FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg ";
$sql.=" WHERE r.jenis_pasien = 'Rawat Inap' AND r.tanggal_masuk >= '$dari_tanggal' AND r.tanggal_masuk <= '$sampai_tanggal'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR r.tanggal_masuk LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR r.nama_pasien LIKE '".$requestData['search']['value']."%' )";
  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.="ORDER BY CONCAT(r.tanggal,' ',r.jam) DESC  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();      

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['nama_pasien'];
      $nestedData[] = $row['penjamin'];
      $nestedData[] = $row['tanggal_masuk'];
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['jumlah_hari'];

  $data[] = $nestedData;

}

  $nestedData=array();      

      $nestedData[] = "<p style='color:red'> TOTAL PASIEN <p>";
      $nestedData[] = "<p style='color:red'> <p>";
      $nestedData[] = "<p style='color:red'> <p>";
      $nestedData[] = "<p style='color:red'> <p>";
      $nestedData[] = "<p style='color:red'> <p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_pasien_ranap)." <p>";

  $data[] = $nestedData;

  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>