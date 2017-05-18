<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$otoritas_laboratorium = $db->query("SELECT input_jasa_lab, input_hasil_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$take_lab = mysqli_fetch_array($otoritas_laboratorium);
$input_jasa_lab = $take_lab['input_jasa_lab'];
$input_hasil_lab = $take_lab['input_hasil_lab'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'batal', 
	1 => 'rujuk_lab',
	2 => 'input_lab',
	3 => 'edit',
	4 => 'no_reg',
	5 => 'no_rm',
	6 => 'nama_pasien',
	7 => 'jenis_kelamin',
	8 => 'umur_pasien',
	9 => 'dokter',
	10 => 'tanggal',
	11 => 'aps_periksa',
	12 => 'id'

);

// getting total number records without any search
$sql = "SELECT r.id,r.no_reg,r.no_rm,r.nama_pasien,r.jenis_kelamin,r.umur_pasien,u.nama AS dokter_pengirim,r.tanggal,r.aps_periksa";
$sql.=" FROM registrasi r INNER JOIN user u ON r.dokter_pengirim = u.id  WHERE r.jenis_pasien = 'APS' AND r.status = 'aps_masuk' AND r.status != 'Batal APS'";

$query=mysqli_query($conn, $sql) or die("EROR 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT r.id,r.no_reg,r.no_rm,r.nama_pasien,r.jenis_kelamin,r.umur_pasien,u.nama AS dokter_pengirim,r.tanggal,r.aps_periksa";
$sql.=" FROM registrasi r INNER JOIN user u ON r.dokter_pengirim = u.id  WHERE r.jenis_pasien = 'APS' AND r.status = 'aps_masuk' AND r.status != 'Batal APS'";



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama_pasien LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR no_reg LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR no_rm LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("EROR 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("EROR 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$query_cek_status = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$row[no_reg]' ");
    $data_status = mysqli_fetch_array($query_cek_status);
    $data_jumlah_status = mysqli_num_rows($query_cek_status);

   
   	if ($data_jumlah_status > 0 ){
  		$nestedData[] = "";
	}
	else{
 		
 	$nestedData[] = "<button type='button' data-reg='".$row['no_reg']."'  data-id='".$row['id']."'  class='btn btn-floating btn-small btn-info batal_aps' ><b> X </b></button>";
	}


	// untuk input jasa lab
	if ($input_jasa_lab > 0) {
		
		$nestedData[] = "<a href='input_jasa_laboratorium.php?no_rm=".$row['no_rm']."&nama=".$row['nama_pasien']."&no_reg=".$row['no_reg']."&dokter=".$row['dokter_pengirim']."&jenis_kelamin=".$row['jenis_kelamin']."&aps_periksa=".$row['aps_periksa']."&jenis_penjualan=APS' class='btn btn-floating btn-small btn-info'><i class='fa fa-stethoscope'></i></a>";
	}
	
	
	//cek periksaan apa
	$data_periksa = $row["aps_periksa"];
	if($data_periksa == 1){
		// untuk input hasil lab
		if ($input_hasil_lab > 0) {
		$show = $db->query("SELECT COUNT(*) AS jumlah FROM tbs_aps_penjualan WHERE no_reg = '$row[no_reg]' ");
		$take = mysqli_fetch_array($show);

			if ($take['jumlah'] > 0){
				
			$query_cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
			$data_cek_setting = mysqli_fetch_array($query_cek_setting);
			$angka_setting_lab = $data_cek_setting['nama'];

				if($angka_setting_lab == 0){
					$nestedData[] = "<p style='color:red'>Cek Setting Laboratorium</p>";
				}
				else{
					
					$nestedData[] = "<a href='input_tbs_aps_hasil_lab.php?no_rm=".$row['no_rm']."&nama=".$row['nama_pasien']."&no_reg=".$row['no_reg']."&jenis_penjualan=APS' class='btn btn-floating btn-small btn-info'><i class='fa fa-pencil'></i></a>";
					}
			}
			else{
				
				$nestedData[] = "<p style='color:red'>Input Jasa Laboratorium</p>";

			}
		}
		// end untuk input hasil lab

	}
	else{

		//Untuk Input Hasil Radiologiny
		$nestedData[] = "<p style='color:red'>Input Radiologi</p>";

	}

	$nestedData[] = "<a href='registrasi_edit_aps.php?no_reg=". $row['no_reg']."' class='btn btn-floating btn-small btn-info ' ><i class='fa fa-edit'></i></a> ";
	
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["jenis_kelamin"];
	$nestedData[] = $row["umur_pasien"];
	$nestedData[] = $row["dokter_pengirim"];
	$nestedData[] = tanggal_terbalik($row["tanggal"]);

	if($row["aps_periksa"] == 1){
		$aps_periksa = 'Laboratorium';
	}
	else if ($row["aps_periksa"] == 2){
		$aps_periksa = 'Radiologi';
	}
	$nestedData[] = $aps_periksa;

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
