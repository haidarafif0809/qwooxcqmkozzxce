<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$bed = stringdoang($_POST['bed']);
$kamar = stringdoang($_POST['kamar']);

// storing  request (ie, get/post) global array to a variable  
$otoritas_laboratorium = $db->query("SELECT input_jasa_lab, input_hasil_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$take_lab = mysqli_fetch_array($otoritas_laboratorium);
$input_jasa_lab = $take_lab['input_jasa_lab'];
$input_hasil_lab = $take_lab['input_hasil_lab'];

$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'input',  
	1 => 'cetak',
	2 => 'no_periksa',
	3 => 'no_reg',
	4 => 'no_rm',
	5 => 'nama_pasien',
	6 => 'dokter',
	7 => 'analis',
	8 => 'status',
	9 => 'tanggal',
	10 => 'detail',
	11 => 'id'
);

// getting total number records without any search
$sql = "SELECT us.nama AS dokter,se.nama AS analis,pi.no_reg,pi.no_rm,pi.nama_pasien,pi.no_periksa,pi.status,DATE(pi.waktu) AS tanggal,pi.id,pi.dokter AS id_dokter FROM pemeriksaan_lab_inap pi LEFT JOIN user us ON pi.dokter = us.id LEFT JOIN user se ON pi.analis = se.id WHERE pi.no_reg = '$no_reg' AND pi.no_rm = '$no_rm' ORDER BY pi.no_periksa DESC";

$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT us.nama AS dokter,se.nama AS analis,pi.no_reg,pi.no_rm,pi.nama_pasien,pi.no_periksa,pi.status,DATE(pi.waktu) AS tanggal,pi.id,pi.dokter AS id_dokter FROM pemeriksaan_lab_inap pi LEFT JOIN user us ON pi.dokter = us.id LEFT JOIN user se ON pi.analis = se.id WHERE pi.no_reg = '$no_reg' AND pi.no_rm = '$no_rm' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

$sql.=" AND ( pi.nama_pasien LIKE '".$requestData['search']['value']."%' ";    
$sql.=" OR pi.no_rm LIKE '".$requestData['search']['value']."%' ";     
$sql.=" OR pi.no_reg LIKE '".$requestData['search']['value']."%' ";    
$sql.=" OR pi.no_periksa LIKE '".$requestData['search']['value']."%' )";

}

$sql.=" ORDER BY pi.no_periksa DESC";

$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
/*$sql.=" GROUP BY hl.no_rm ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."";*/
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

// untuk input hasil lab
if ($input_hasil_lab > 0) {
	if($row['status'] == '0')
	{

		$query_cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
		$data_cek_setting = mysqli_fetch_array($query_cek_setting);
		$angka_setting_lab = $data_cek_setting['nama'];
		if($angka_setting_lab == 0){
		$nestedData[] = "<p style='color:red'>Cek Setting Laboratorium</p>";
		}
		else{
		$jenis_penjualan = "Rawat Inap";

		$nestedData[] = "<a href='cek_input_hasil_lab_inap.php?no_reg=". $row['no_reg']."&nama=". $row['nama_pasien']."&no_rm=". $row['no_rm']."&jenis_penjualan=". $jenis_penjualan."&no_periksa=". $row['no_periksa']."' class='btn btn-success'> Input </a>";
		}
	}
	else
	{
		$nestedData[] = "<p style='color:green'> Selesai </p>";
	}
}



if($row['status'] == '0')
{
	$nestedData[] = "<p style='color:red'> Belum Ada Hasil </p>";
	$nestedData[] = $row["no_periksa"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["analis"];
	$nestedData[] = "<p style='color:red'>Belum</p>";
	$nestedData[] = $row["tanggal"];

	$nestedData[] ='<td> <a href="cek_edit_hasil_lab_registrasi_inap.php?id='.$row["id"].'&
	no_periksa='.$row["no_periksa"].'&no_rm='.$row["no_rm"].'&nama_pasien='.$row["nama_pasien"].'&dokter='.$row["id_dokter"].'
	&no_reg='.$row["no_reg"].'&jenis_kelamin='.$jenis_kelamin.'&tanggal='.$row["tanggal"].'&bed='.$bed.'&kamar='.$kamar.'" class="btn btn-info btn-floating"> <i class="fa fa-edit"> </i></a></td>';

	$nestedData[] = "<p style='color:red'> Belum Input Hasil</p>";
}
else
{

	$nestedData[] = "<a href='cetak_hasil_lab_inap_after_input_hasil.php?no_reg=".$row['no_reg']."&no_periksa=".$row['no_periksa']."' target='blank' class='btn btn-floating btn-primary' data-target='blank'> <i class='fa fa-print'></i> </a>";
	$nestedData[] = $row["no_periksa"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["analis"];
	$nestedData[] = "<p style='color:green'>Selesai</p>";
	$nestedData[] = $row["tanggal"];

	$nestedData[] ='<td> <a href="cek_edit_hasil_lab_registrasi_inap.php?id='.$row["id"].'&
	no_periksa='.$row["no_periksa"].'&no_rm='.$row["no_rm"].'&nama_pasien='.$row["nama_pasien"].'&dokter='.$row["id_dokter"].'
	&no_reg='.$row["no_reg"].'&jenis_kelamin='.$jenis_kelamin.'&tanggal='.$row["tanggal"].'&bed='.$bed.'&kamar='.$kamar.'" class="btn btn-info btn-floating"> <i class="fa fa-edit"> </i></a></td>';


	$nestedData[] = "<td><button class='btn btn-floating  btn-info detail-lab-inap' data-reg='".$row['no_reg']."' data-periksa='".$row['no_periksa']."'><i class='fa fa-list'></i></button></td>";
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