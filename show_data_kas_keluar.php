<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

/* Database connection end */
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'dari_akun',
	2 => 'jumlah',
	3 => 'tanggal',
	4 => 'jam',
	5 => 'user',
	6 => 'user_edit',
	7 => 'waktu_edit',
	8=> 'id'
);

// getting total number records without any search
$sql = "SELECT km.user_edit,km.id, km.no_faktur,km.waktu_edit, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun";
$sql.=" FROM kas_keluar km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun";
$query=mysqli_query($conn, $sql) or die("show_data_kkas_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT km.user_edit,km.id, km.no_faktur, km.waktu_edit, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun";
$sql.=" FROM kas_keluar km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR jumlah LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("show_data_kas_kkkeluar.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY km.id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("show_data_kas_keluar.php: get employees");
$data = array();
while($row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();

	$pilih_akses_kas_keluar = $db->query("SELECT * FROM otoritas_kas_keluar WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kas_keluar = mysqli_fetch_array($pilih_akses_kas_keluar);

if ($kas_keluar['kas_keluar_lihat'] == 1) {
	$nestedData[] = "<a href='cetak_kas_keluar.php?no_faktur=".$row['no_faktur']."' target='blank' class='btn btn-primary' data-target='blank'> <i class='fa fa-print'></i> Cetak </a>";
	}

	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["nama_daftar_akun"];
	$nestedData[] = rp($row["jumlah"]);
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["user"];
	$nestedData[] = $row["user_edit"];
	$nestedData[] = $row["waktu_edit"];
	


$nestedData[] ="<button class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."'> <i class='fa fa-th-list'></i> Detail </button>";

if ($kas_keluar['kas_keluar_edit'] == 1) {
		$nestedData[] ="<a href='proses_edit_data_kas_keluar.php?no_faktur=". $row['no_faktur']."&nama_daftar_akun=".$row['nama_daftar_akun']."' class='btn btn-success'> <i class='fa fa-edit'></i> Edit </a>";
		}

if ($kas_keluar['kas_keluar_hapus'] == 1) {

		$nestedData[] ="<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' no-faktur='". $row['no_faktur'] ."'><i class='fa fa-trash'> </i> Hapus </button> ";
}

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