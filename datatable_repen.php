<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_retur', 
	1 => 'kode_pelanggan',
	2 => 'total',
	3 => 'potongan',
	4 => 'tax',
	5 => 'tanggal',
	6 => 'jam',
	7 => 'user_buat',
	8 => 'user_edit',
	9 => 'tanggal_edit',
	10 => 'tunai',
	11 => 'sisa',
	12 => 'id'

);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM retur_penjualan";
$query=mysqli_query($conn, $sql) or die("datatable_repen.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM retur_penjualan WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur_retur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_repen.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$pilih_akses_retur_penjualan = $db->query("SELECT * FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
		$retur_penjualan = mysqli_fetch_array($pilih_akses_retur_penjualan);
	
		$query_pel = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$row[kode_pelanggan]' ");
				$data_pelanggan = mysqli_fetch_array($query_pel);

				//menampilkan data

			$nestedData[] = "<button class='btn btn-info detail' no_faktur_retur='". $row['no_faktur_retur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button>";

		if ($retur_penjualan['retur_penjualan_edit'] > 0) {

					$nestedData[] = "<a href='proses_edit_retur_penjualan.php?no_faktur_retur=". $row['no_faktur_retur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
				}


		if ($retur_penjualan['retur_penjualan_hapus'] > 0) {

		$pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$row[no_faktur_retur]' AND sisa != jumlah_kuantitas");
		$row_alert = mysqli_num_rows($pilih);

			if ($row_alert > 0) {
				

				$nestedData[] = "<button class='btn btn-danger btn-alert' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_retur'] ."' data-pelanggan='". $row['kode_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
			} 

			else {

				$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_retur'] ."' data-pelanggan='". $row['kode_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
			}


					
		}
					
					$nestedData[] = "<a href='cetak_lap_retur_penjualan.php?no_faktur_retur=".$row['no_faktur_retur']."' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Retur</a>";

					$nestedData[] = $row["no_faktur_retur"];
					$nestedData[] = ($row["kode_pelanggan"].$data_pelanggan["nama_pelanggan"]);
					$nestedData[] = rp($row["total"]);
					$nestedData[] = rp($row["potongan"]);
					$nestedData[] = rp($row["tax"]);
					$nestedData[] = $row["tanggal"];
					$nestedData[] = $row["jam"];
					$nestedData[] = $row["user_buat"];
					$nestedData[] = $row["user_edit"];
					$nestedData[] = $row["tanggal_edit"];
					$nestedData[] = rp($row["tunai"]);
					$nestedData[] = rp($row["sisa"]);
		
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
