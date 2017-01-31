<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'kode_barang',
	2 => 'nama_barang',
	3 => 'jenis_transaksi',
	4 => 'jumlah',
	5 => 'harga',
	6 => 'total',
	7 => 'sisa',
	8 => 'tanggal',
	9 => 'jam',
	10 => 'id'
);

// getting total number records without any search
$sql = "SELECT hm.no_faktur,hm.kode_barang,b.nama_barang,hm.total_nilai,hm.sisa,hm.jumlah_kuantitas,hm.tanggal,hm.jam,hm.harga_unit,hm.jenis_transaksi,hm.id ";
$sql.=" FROM hpp_masuk hm LEFT JOIN barang b ON hm.kode_barang = b.kode_barang WHERE hm.jenis_transaksi = 'Penyesuaian Stok Penjualan' ";
$query=mysqli_query($conn, $sql) or die("datatable_kamar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT  hm.no_faktur,hm.kode_barang,b.nama_barang,hm.total_nilai,hm.sisa,hm.jumlah_kuantitas,hm.tanggal,hm.jam,hm.harga_unit,hm.jenis_transaksi,hm.id  ";
$sql.="FROM hpp_masuk hm LEFT JOIN barang b ON hm.kode_barang = b.kode_barang WHERE  hm.jenis_transaksi = 'Penyesuaian Stok Penjualan'  AND 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( hm.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR hm.total_nilai LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR hm.sisa LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR hm.tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_kamar.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY hm.tanggal,hm.jam DESC   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["kode_barang"];
	$nestedData[] = $row["nama_barang"];
	$nestedData[] = $row["jenis_transaksi"];
	$nestedData[] = $row["jumlah_kuantitas"];
	$nestedData[] = rp($row["harga_unit"]);
	$nestedData[] = rp($row["total_nilai"]);
	$nestedData[] = $row["sisa"];
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];
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


