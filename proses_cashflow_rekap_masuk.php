<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

 $kas = stringdoang($_POST['kas_rekap']);
 $tanggal = stringdoang($_POST['tanggal_rekap']);

$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	0=>'tanggal', 
	1=>'dari_akun',
	2=>'ke_akun',
	3=>'total',
	4=>'id'

);
// getting total number records without any search
$sql = "SELECT SUM(js.debit) AS masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur";
$sql.=" FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun";
$sql.=" WHERE DATE(js.waktu_jurnal) = '$tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' GROUP BY js.jenis_transaksi";
$sql.=" ";


$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT SUM(js.debit) AS masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur";
$sql.=" FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun";
$sql.=" WHERE DATE(js.waktu_jurnal) = '$tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' ";

	$sql.=" AND ( js.jenis_transaksi LIKE '".$requestData['search']['value']."%'";
	$sql.=" OR da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' ) GROUP BY js.jenis_transaksi";


}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY js.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

	$nestedData=array(); 

	$select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' 
		AND js.no_faktur = '$row[no_faktur]' AND js.kredit != '0'");
	$out = mysqli_fetch_array($select);


	$nestedData[] = $tanggal;
	$nestedData[] = $out["nama_daftar_akun"];
	$nestedData[] = $row["nama_daftar_akun"];
	$nestedData[] = rp($row["masuk"]);
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

