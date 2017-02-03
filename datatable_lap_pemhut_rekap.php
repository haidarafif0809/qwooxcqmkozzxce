<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_pembayaran', 
	1 => 'no_faktur_pembelian',
	2 => 'nama',
	3 => 'tanggal',
	4 => 'tanggal_jt',
	5 => 'kredit',
	6 => 'potongan',
	7 => 'total',
	8 => 'jumlah_bayar',
	9 => 'id'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pemhut.php.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur_pembayaran LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR no_faktur_pembelian LIKE '".$requestData['search']['value']."%' "; 
  	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatablee_lap_pemhut.php.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

      $suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$row[suplier]'");
        $out = mysqli_fetch_array($suplier);
        if ($row['suplier'] == $out['id'])
        {
          $out['nama'];
        }
			$nestedData[] = $row['no_faktur_pembayaran'];
			$nestedData[] = $row['no_faktur_pembelian'];
			$nestedData[] = $out['nama'];
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['tanggal_jt'];
			$nestedData[] = rp($row['kredit']);
			$nestedData[] = rp($row['potongan']);
			$nestedData[] = rp($row['total']);
			$nestedData[] = rp($row['jumlah_bayar']);

	$nestedData[] = $row['id'];
	$data[] = $nestedData;
}

$select_jumlah = $db->query("SELECT SUM(jumlah_bayar) AS total_akhir 
	FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while ($out = mysqli_fetch_array($select_jumlah))
{
$total_akhir = rp($out['total_akhir']);
}

$nestedData=array(); 
			$nestedData[] = "<b style='color: black;'>Periode :</b>";
			$nestedData[] = "<b style='color: black;'>$dari_tanggal</b>";
			$nestedData[] = "<b style='color: black;'>s/d</b>";
			$nestedData[] = "<b style='color: black;'>$sampai_tanggal</b>";
			$nestedData[] = "";
			$nestedData[] = "";
			$nestedData[] = "<b style='color: black;'></b>";
			$nestedData[] = "<b style='color: black;'>Total Bayar</b>";
			$nestedData[] = "<b style='color: black;'>$total_akhir</b>";

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
