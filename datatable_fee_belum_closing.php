<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$nama_petugas = stringdoang($_POST['nama_petugas']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$dari_jam = stringdoang($_POST['dari_jam']);
$sampai_jam = stringdoang($_POST['sampai_jam']);

$waktu_dari = $dari_tanggal." ".$dari_jam;
$waktu_sampai = $sampai_tanggal." ".$sampai_jam;

$query0 = $db->query("SELECT SUM(tfp.jumlah_fee) AS total_fee FROM tbs_fee_produk tfp LEFT JOIN registrasi r ON tfp.no_reg = r.no_reg WHERE tfp.nama_petugas = '$nama_petugas' AND (tfp.waktu >= '$waktu_dari' AND tfp.waktu <= '$waktu_sampai') AND r.jenis_pasien = 'Rawat Inap' ");

$cek0 = mysqli_fetch_array($query0);
$total_fee = rp($cek0['total_fee']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama', 
	1 => 'no_faktur',
	2 => 'kode_produk',
	3 => 'nama_produk',
	4 => 'jumlah_fee',
  	5 => 'tanggal',
	6 => 'jam',
	7 => 'id'
);

// getting total number records without any search
$sql = "SELECT lfp.id, lfp.nama_petugas, lfp.no_faktur, lfp.kode_produk, lfp.nama_produk, lfp.jumlah_fee, lfp.tanggal, lfp.jam, u.nama AS nama_user ";
$sql.=" FROM tbs_fee_produk lfp LEFT JOIN user u ON lfp.nama_petugas = u.id LEFT JOIN registrasi r ON lfp.no_reg = r.no_reg WHERE lfp.nama_petugas = '$nama_petugas' AND (lfp.waktu >= '$waktu_dari' AND lfp.waktu <= '$waktu_sampai') AND r.jenis_pasien = 'Rawat Inap'  ";
$query=mysqli_query($conn, $sql) or die("datatable_penjamin.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT lfp.id, lfp.nama_petugas, lfp.no_faktur, lfp.kode_produk, lfp.nama_produk, lfp.jumlah_fee, lfp.tanggal, lfp.jam, u.nama AS nama_user ";
$sql.=" FROM tbs_fee_produk lfp LEFT JOIN user u ON lfp.nama_petugas = u.id LEFT JOIN registrasi r ON lfp.no_reg = r.no_reg WHERE lfp.nama_petugas = '$nama_petugas' AND (lfp.waktu >= '$waktu_dari' AND lfp.waktu <= '$waktu_sampai') AND r.jenis_pasien = 'Rawat Inap'  AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( u.nama LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR lfp.no_faktur LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR lfp.kode_produk LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR lfp.nama_produk LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR lfp.tanggal LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("datatablee_petugas_per_produk.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	  $nestedData[] = $row['nama_user'];
      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['kode_produk'];
      $nestedData[] = $row['nama_produk'];
      $nestedData[] = rp($row['jumlah_fee']);
      $nestedData[] = tanggal($row['tanggal']);
      $nestedData[] = $row['jam'];
	  $nestedData[] = $row['id'];
	  $data[] = $nestedData;
}


$nestedData=array(); 
	  $nestedData[] = "<b style='color : black;'> Periode :</b>";
      $nestedData[] = "<b style='color : black;'>".$dari_tanggal." ".$dari_jam." s/d ".$sampai_tanggal." ".$sampai_jam." </b>";
      $nestedData[] = "<b style='color : black;'></b>";
      $nestedData[] = "<b style='color : black'> Total Komisi/Produk :</b>";
      $nestedData[] = "<b style='color : black;'> $total_fee</b>";
      $nestedData[] = "<b style='color : black;'></b>";
      $nestedData[] = "<b style='color : black;'> </b>";
	  $nestedData[] = $row['id'];
	  $data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

