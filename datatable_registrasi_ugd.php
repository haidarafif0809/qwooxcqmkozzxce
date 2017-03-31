<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$otoritas_laboratorium = $db->query("SELECT input_jasa_lab, input_hasil_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$take_lab = mysqli_fetch_array($otoritas_laboratorium);
$input_jasa_lab = $take_lab['input_jasa_lab'];
$input_hasil_lab = $take_lab['input_hasil_lab'];

//untuk otoritas akses
$pilih_akses_registrasi_rj = $db->query("SELECT registrasi_ugd_lihat, registrasi_ugd_tambah, registrasi_ugd_edit, registrasi_ugd_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_rj = mysqli_fetch_array($pilih_akses_registrasi_rj);

$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

$pilih_akses_registrasi_ugd = $db->query("SELECT registrasi_ugd_lihat, registrasi_ugd_tambah, registrasi_ugd_edit, registrasi_ugd_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ugd = mysqli_fetch_array($pilih_akses_registrasi_ugd);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ugd_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'no_reg', 
	1 => 'no_rm',
	2 => 'penjamin',
	3 => 'nama_pasien',
	4 => 'jenis_kelamin',
	5 => 'umur_pasien',
	6 => 'hp_pasien',
	7 => 'keterangan',
	8 => 'dokter',
	9 => 'pengantar_pasien',
	10 => 'nama_pengantar',
	11 => 'hp_pengantar',
	12 => 'tanggal',
	13 => 'alamat_pengantar',
	14 => 'hubungan_dengan_pasien',
	15 => 'status',
	16 => 'id'
);

// getting total number records without any search
$sql = "SELECT reg.no_reg, reg.no_rm, reg.penjamin, reg.nama_pasien, reg.jenis_kelamin, reg.umur_pasien, reg.hp_pasien, reg.keterangan, reg.dokter, reg.pengantar_pasien, reg.nama_pengantar, reg.hp_pengantar, reg.tanggal, reg.alamat_pengantar, reg.hubungan_dengan_pasien, reg.id, reg.status, reg.jam, rek.id AS id_rek ";
$sql.=" FROM registrasi reg INNER JOIN rekam_medik_ugd rek ON reg.no_reg = rek.no_reg WHERE reg.jenis_pasien = 'UGD' AND reg.status = 'Masuk Ruang UGD' AND reg.status != 'Batal UGD' AND reg.status != 'Rujuk Rumah Sakit' AND TO_DAYS(NOW()) - TO_DAYS(reg.tanggal) <= 7";

$query=mysqli_query($conn, $sql) or die("datatable_registrasi_ugd.php: get employeess1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT reg.no_reg, reg.no_rm, reg.penjamin, reg.nama_pasien, reg.jenis_kelamin, reg.umur_pasien, reg.hp_pasien, reg.keterangan, reg.dokter, reg.pengantar_pasien, reg.nama_pengantar, reg.hp_pengantar, reg.tanggal, reg.alamat_pengantar, reg.hubungan_dengan_pasien, reg.id, reg.status, reg.jam, rek.id AS id_rek ";
$sql.=" FROM registrasi reg INNER JOIN rekam_medik_ugd rek ON reg.no_reg = rek.no_reg WHERE reg.jenis_pasien = 'UGD' AND reg.status = 'Masuk Ruang UGD' AND reg.status != 'Batal UGD' AND reg.status != 'Rujuk Rumah Sakit' AND TO_DAYS(NOW()) - TO_DAYS(reg.tanggal) <= 7";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( reg.nama_pasien LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR reg.no_reg LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR reg.tanggal LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR reg.no_rm LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_registrasi_ugd.php: get employeess2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("datatable_registrasi_ugd.php: get employeess3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$query_z = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$row[no_reg]' ");
    $data_z = mysqli_fetch_array($query_z);
    $sttus = mysqli_num_rows($query_z);

    if ($registrasi_ugd['registrasi_ugd_hapus'] > 0) {
    	  if ($sttus > 0 )
		{
  			$nestedData[] = "";
		}
	else
		{
 		$nestedData[] = "<button type='button' data-reg='".$row['no_reg']."'  data-id='".$row['id']."'  class='btn btn-floating btn-small btn-info pulang_rumah' ><b> X </b></button>";
		}

	}





	if ($registrasi_ugd['registrasi_ugd_lihat'] > 0) {
	    $nestedData[] = "<button  type='button' data-reg='".$row['no_reg']."' data-id='".$row['id']."'  class='btn btn-floating btn-small btn-info rujuk' ><i class='fa fa-bus'></i>   </button>";

	    $nestedData[] = "<button  type='button' data-reg='".$row['no_reg']."' class='btn btn-floating btn-small btn-info rujuk_ri' ><i class='fa fa-hotel'></i>   </button>";
	}
	
// untuk input jasa lab
if ($input_jasa_lab > 0) {
 $nestedData[] = "<a href='form_penjualan_lab.php?no_rm=".$row['no_rm']."&nama=".$row['nama_pasien']."&no_reg=".$row['no_reg']."&dokter=".$row['dokter']."&jenis_penjualan=UGD&rujukan=Rujuk UGD' class='btn btn-floating btn-small btn-info'><i class='fa fa-stethoscope'></i></a>
       ";
}

// untuk input hasil lab
if ($input_hasil_lab > 0) {
$show = $db->query("SELECT COUNT(*) AS jumlah FROM tbs_penjualan WHERE no_reg = '$row[no_reg]' AND lab = 'Laboratorium' ");
$take = mysqli_fetch_array($show);

	if ($take['jumlah'] > 0)
	{
		$nestedData[] = "<a href='cek_input_hasil_lab.php?no_rm=".$row['no_rm']."&nama=".$row['nama_pasien']."&no_reg=".$row['no_reg']."&jenis_penjualan=UGD' class='btn btn-floating btn-small btn-info'><i class='fa fa-pencil'></i></a>";
	}
	else
	{
	  $nestedData[] = "<p style='color:red'>Input Laboratorium</p>";

	}
}
// end untuk input hasil lab


	if ($rekam_medik['rekam_medik_ugd_lihat'] > 0) {
	  $nestedData[] = "<a href='input_rekam_medik_ugd.php?no_reg=".$row['no_reg']."&tgl=".$row['tanggal']."&id=".$row['id_rek']."&jam=".$row['jam']."' class='btn-floating btn-info btn-small' ><i class='fa fa-medkit '></i></a>";
	}

	if ($registrasi_ugd['registrasi_ugd_edit'] > 0) {

	$nestedData[] = "<a href='edit_registrasi_ugd.php?no_reg=". $row['no_reg']."' class='btn btn-floating btn-small btn-info ' ><i class='fa fa-edit'></i></a> ";
	}
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["penjamin"];
	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["jenis_kelamin"];
	$nestedData[] = $row["umur_pasien"];
	$nestedData[] = $row["hp_pasien"];
	$nestedData[] = $row["keterangan"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["pengantar_pasien"];
	$nestedData[] = $row["nama_pengantar"];
	$nestedData[] = $row["hp_pengantar"];
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["alamat_pengantar"];
	$nestedData[] = $row["hubungan_dengan_pasien"];
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
