<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$ruangan = angkadoang($_POST['ruangan']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama_ruangan', 
	1 => 'id',
	2 => 'nama_kamar',
	3 => 'group_bed',
	4 => 'fasilitas',
	5 => 'jumlah_bed',
	6 => 'sisa_bed',
	7 => 'kelas'
);

// getting total number records without any search
if ($ruangan != '') {
	# code...
	//ini apabila ada ruangannya 
	$sql = "SELECT r.id as id_ruangan, r.nama_ruangan, b.id, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, b.kelas, b.ruangan ";
	$sql.=" FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE b.sisa_bed != 0 AND b.ruangan = '$ruangan' ";
	$query=mysqli_query($conn, $sql) or die("datatable_kamar.php: get employees");
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

	$sql = "SELECT r.id as id_ruangan, r.nama_ruangan, b.id, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, b.kelas, b.ruangan ";
	$sql.=" FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE b.sisa_bed != 0 AND b.ruangan = '$ruangan' AND 1=1";
	if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( r.nama_ruangan  LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.nama_kamar LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.group_bed LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR r.nama_ruangan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.fasilitas LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR b.jumlah_bed LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR b.kelas LIKE '".$requestData['search']['value']."%' )";
	}
	$query=mysqli_query($conn, $sql) or die("datatableee_kamar.php: get employees");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
	$sql.=" GROUP BY b.ruangan LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
	$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
}
else{
	$sql = "SELECT r.nama_ruangan, r.id as id_ruangan, b.id, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, b.kelas, b.ruangan ";
	$sql.=" FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE b.sisa_bed != 0 ";
	$query=mysqli_query($conn, $sql) or die("datatable_kamar.php: get employees");
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

	$sql = "SELECT r.nama_ruangan, r.id as id_ruangan, b.id, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, b.kelas, b.ruangan ";
	$sql.=" FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE b.sisa_bed != 0 AND 1=1";
	if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( r.nama_ruangan  LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.nama_kamar LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.group_bed LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR r.nama_ruangan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.fasilitas LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR b.jumlah_bed LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR b.kelas LIKE '".$requestData['search']['value']."%' )";
	}
	$query=mysqli_query($conn, $sql) or die("datatableee_kamar.php: get employees");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
	$sql.=" ORDER  BY b.id LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
	$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
}


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$query_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($data_kelas = mysqli_fetch_array($query_kelas))
        {
          if($row['kelas'] == $data_kelas['id'])
          {
            $kelas = $data_kelas['nama'];
          }
        };

	$nestedData[] = "$kelas";
	$nestedData[] = $row["nama_kamar"];
	$nestedData[] = $row["group_bed"];
	if ($row["ruangan"] == 0) {
		# code...
	$nestedData[] = "-";
	}
	else{
		$nestedData[] = $row["nama_ruangan"];
	}
	$nestedData[] = $row["fasilitas"];
	$nestedData[] = $row["jumlah_bed"];
	$nestedData[] = $row["sisa_bed"];
	$nestedData[] = $row["id"];
	if ($row["ruangan"] == 0) {
		# code...
	$nestedData[] = "-";
	}
	else{
		$nestedData[] = $row["id_ruangan"];
	}

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


