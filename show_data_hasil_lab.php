<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$otoritas_laboratorium = $db->query("SELECT input_hasil_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$take_lab = mysqli_fetch_array($otoritas_laboratorium);
$input_hasil_lab = $take_lab['input_hasil_lab'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'input',  
	1 => 'cetak',
	2 => 'no_rm',
	3 => 'no_reg',
	4 => 'no_faktur',
	5 => 'nama_pasien',
	6 => 'dokter',
	7 => 'petugas_analis',
	8 => 'status_rawat',
	9 => 'tanggal',
	10 => 'detail',
	11 => 'id'


);


// getting total number records without any search

$sql = "SELECT us.nama AS dokter, se.nama AS analis,hl.nama_pasien,hl.no_rm,hl.no_faktur,hl.no_reg,hl.nama_pemeriksaan,hl.status,hl.hasil_pemeriksaan,hl.nilai_normal_lk,hl.nilai_normal_pr,hl.model_hitung,hl.id,hl.satuan_nilai_normal,hl.status_abnormal,hl.status_pasien,hl.tanggal FROM hasil_lab hl LEFT JOIN user us ON hl.dokter = us.id LEFT JOIN user se ON hl.petugas_analis = se.id GROUP BY hl.no_reg ";

$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT us.nama AS dokter, se.nama AS analis,hl.nama_pasien,hl.no_rm,hl.no_faktur,hl.no_reg,hl.nama_pemeriksaan,hl.status,hl.hasil_pemeriksaan,hl.nilai_normal_lk,hl.nilai_normal_pr,hl.model_hitung,hl.id,hl.satuan_nilai_normal,hl.status_abnormal,hl.status_pasien,hl.tanggal FROM hasil_lab hl LEFT JOIN user us ON hl.dokter = us.id LEFT JOIN user se ON hl.petugas_analis = se.id GROUP BY hl.no_reg ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( hl.nama_pasien LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_rm LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR hl.no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_rm LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.hasil_pemeriksaan LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR hl.tanggal LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR hl.status_abnormal LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR hl.status_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR us.nama LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR se.nama LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR hl.nama_pemeriksaan LIKE '".$requestData['search']['value']."%' )";
}


$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY CONCAT(hl.tanggal,' ',hl.jam) DESC LIMIT ".$requestData['start']." ,".$requestData['length']."";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

if($input_hasil_lab > 0){
	if($row['status'] != 'Selesai')
	{
		$nestedData[] = "<a href='input_hasil_lab.php?no_faktur=". $row['no_faktur']."&nama_pasien=". $row['nama_pasien']."' class='btn btn-success'> Input </a>";
	}
	else
	{
		$nestedData[] = "<p style='color:red'> Selesai </p>";
	}
}

if($row['status'] == 'Selesai' AND $row['no_faktur'] != '')
{
	if($row['status_pasien'] == 'Rawat Inap'){
		$nestedData[] = "<p style='color:red'>Klik Detail</p>";
	}
	else{
$nestedData[] = "<a href='cetak_laporan_hasil_lab.php?no_faktur=".$row['no_faktur']."' target='blank' class='btn btn-floating btn-primary' data-target='blank'> <i class='fa fa-print'></i> </a>";
	}
}
else
{
	$nestedData[] = "<p style='color:red'> Belum Bisa Cetak</p>";
}

	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["no_reg"];

if($row["no_faktur"] == '')
{
	$nestedData[] = "<p style='color:red'> Belum Penjualan</p>";
}
else
{
	$nestedData[] = $row["no_faktur"];	
}

	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["analis"];
	$nestedData[] = $row["status_pasien"];
	$nestedData[] = $row["tanggal"];

if($row['no_faktur'] == '')
{
	$nestedData[] = "<p style='color:red'> Belum Penjualan</p>";
}
else
{	
	if($row['status_pasien'] == 'Rawat Inap')
	{

	$nestedData[] = '<p><a href="detail_laboratorium_inap.php?faktur='.$row["no_faktur"].'&no_reg='.$row["no_reg"].'&nama='.$row["nama_pasien"].'&no_rm='.$row["no_rm"].'" class="btn btn-floating btn-info"><i class="fa fa-list"></i></a></p>';
		 
	}
	else
	{

	$nestedData[] = "<p><button class='btn btn-floating  btn-info detail-lab' data-faktur='".$row['no_faktur']."' data-reg='".$row['no_reg']."'><i class='fa fa-list'></i></button></p>";
	}
	
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