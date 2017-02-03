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


$no_rm = stringdoang($_POST['no_rm']);


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
$sql = "SELECT id,no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,alamat_pasien,penjamin,hp_pasien,tanggal ";
$sql.=" FROM registrasi WHERE no_rm = '$no_rm' AND jenis_pasien = 'Rawat Jalan' ";
$query = mysqli_query($conn, $sql) or die("query 1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT id,no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,alamat_pasien,penjamin,hp_pasien,tanggal ";

$sql.=" FROM registrasi WHERE 1=1 AND no_rm = '$no_rm' AND jenis_pasien = 'Rawat Jalan' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_rm LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR no_reg LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR nama_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR penjamin LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR alamat_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
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
	$nestedData[] =	 $row['penjamin']; 
	$nestedData[] =	 $row['hp_pasien']; 
	$nestedData[] =	 $row['tanggal']; 

 $nestedData[]= "<a href='detail_lap_kunjungan_rj.php?no_rm=".$row['no_rm']."&no_reg=".$row['no_reg']."' class='btn-floating btn-info btn-small'><i class='fa fa-archive'></i> </a>";

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


