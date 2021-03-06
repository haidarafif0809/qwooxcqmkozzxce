<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


$query02 = $db->query("SELECT SUM(subtotal) AS total_akhir FROM detail_retur_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = rp($cek02['total_akhir']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'no_faktur_retur', 
	1 => 'tanggal',
	2 => 'nama',
	3 => 'total',
	4 => 'potongan',
	5 => 'tax',
  	6 => 'tunai',
  	7 => 'id'
);


// getting total number records without any search
$sql = "SELECT s.nama AS nama_satuan,drp.id,drp.no_faktur_retur,drp.tanggal,drp.kode_barang,drp.nama_barang,drp.jumlah_retur,drp.satuan,drp.harga,drp.potongan,drp.subtotal ";
$sql.=" FROM detail_retur_pembelian drp INNER JOIN satuan s ON drp.satuan = s.id WHERE drp.tanggal >= '$dari_tanggal' AND drp.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_repem.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT s.nama AS nama_satuan,drp.id,drp.no_faktur_retur,drp.tanggal,drp.kode_barang,drp.nama_barang,drp.jumlah_retur,drp.satuan,drp.harga,drp.potongan,drp.subtotal ";
$sql.=" FROM detail_retur_pembelian drp INNER JOIN satuan s ON drp.satuan = s.id WHERE drp.tanggal >= '$dari_tanggal' AND drp.tanggal <= '$sampai_tanggal' AND 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur_retur LIKE '".$requestData['search']['value']."%' ";
	$sql.="	OR tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.="	OR kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.="	OR nama_barang LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_lap_repem.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();
      
		$nestedData[] = $row['no_faktur_retur'];
		$nestedData[] = $row['tanggal'];
		$nestedData[] = $row['kode_barang'];
		$nestedData[] = $row['nama_barang'];
		$nestedData[] = $row['jumlah_retur'];
		$nestedData[] = $row['nama_satuan'];
		$nestedData[] = rp($row['harga']);
		$nestedData[] = rp($row['potongan']);
		$nestedData[] = rp($row['subtotal']);

	$nestedData[] = $row['id'];
	$data[] = $nestedData;
}

$nestedData = array();
		$nestedData[] = "<b style='color:black' >Periode :</b>";
		$nestedData[] = "<b style='color:black' >$dari_tanggal</b>";
		$nestedData[] = "<b style='color:black' >s/d</b>";
		$nestedData[] = "<b style='color:black' >$sampai_tanggal</b>";
		$nestedData[] = "";
		$nestedData[] = "";
		$nestedData[] = "";
		$nestedData[] = "<b style='color:black' >Total Seluruh :</b>";
		$nestedData[] = "<b style='color:black' >$total_akhir</b>";
		$data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

