<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

/* Database connection end */
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$penjamin = stringdoang($_POST['penjamin']);
$dari_tanggal = stringdoang($_POST['dari_tanggal_penj']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal_penj']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	 
	0 =>'no_rm', 
	1 => 'no_reg',
	2=> 'nama_pasien',
	3 => 'jenis_kelamin',
	4=> 'umur',
	5=> 'alamat_pasien',
	6 => 'penjamin',
	7=> 'no_hp',
	8=> 'tanggal_periksa'	 		 										

);


// getting total number records without any search
$sql = "SELECT r.id,r.no_rm,r.no_reg,r.nama_pasien,r.jenis_kelamin,r.umur_pasien,r.alamat_pasien,r.penjamin,r.hp_pasien,r.tanggal,p.total ";
$sql.=" FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg  WHERE r.penjamin = '$penjamin' AND  r.tanggal >= '$dari_tanggal' AND r.tanggal <= '$sampai_tanggal' AND r.jenis_pasien = 'UGD' ";
$query = mysqli_query($conn, $sql) or die("query 1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT r.id,r.no_rm,r.no_reg,r.nama_pasien,r.jenis_kelamin,r.umur_pasien,r.alamat_pasien,r.penjamin,r.hp_pasien,r.tanggal,p.total ";

$sql.=" FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg  WHERE r.penjamin = '$penjamin' AND  r.tanggal >= '$dari_tanggal' AND r.tanggal <= '$sampai_tanggal' AND r.jenis_pasien = 'UGD' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( r.no_rm LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR r.no_reg LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR r.nama_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR r.penjamin LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR r.alamat_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR r.tanggal LIKE '".$requestData['search']['value']."%' )";
}


$query= mysqli_query($conn, $sql) or die("query 2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("query 3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] =	 $row['no_rm'];
	$nestedData[] =	 $row['no_reg']; 
	$nestedData[] =	 $row['nama_pasien']; 
	$nestedData[] =	 $row['jenis_kelamin']; 
	$nestedData[] =	 $row['umur_pasien']; 
	$nestedData[] =	 $row['alamat_pasien'];
	$nestedData[] =	 $row['hp_pasien']; 
	$nestedData[] =	 $row['penjamin']; 
	$nestedData[] =	 $row['tanggal'];
	$nestedData[] =	 $row['total']; 

	$data[] = $nestedData;
}

$query01 = $db->query("SELECT SUM(p.total) AS total_penjualan FROM penjualan p INNER JOIN registrasi r ON p.no_reg = r.no_reg WHERE r.jenis_pasien = 'UGD' AND p.penjamin = '$penjamin' AND p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total = $cek01['total_penjualan'];
$nestedData=array(); 

	$nestedData[] =	 "";
	$nestedData[] =	 "<b style='color:black'>Penjamin :</b>"; 
	$nestedData[] =	 "<b style='color:black'>". $penjamin ."</b>"; 
	$nestedData[] =	 ""; 
	$nestedData[] =	 ""; 
	$nestedData[] =	 "<b style='color:black'>Periode :</b>"; 
	$nestedData[] =	 "<b style='color:black'>". $dari_tanggal ." s/d ".$sampai_tanggal."</b>"; 
	$nestedData[] =	 ""; 
	$nestedData[] =	 "<b style='color:black'>Jml Total :</b>";
	$nestedData[] =	 "<b style='color:black'>". rp($total) ."</b>";

	$data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>


