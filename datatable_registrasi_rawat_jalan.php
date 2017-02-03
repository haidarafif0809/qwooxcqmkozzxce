<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$tanggal = date("Y-m-d");


$pilih_akses_registrasi_rj = $db->query("SELECT registrasi_rj_lihat, registrasi_rj_tambah, registrasi_rj_edit, registrasi_rj_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_rj = mysqli_fetch_array($pilih_akses_registrasi_rj);
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'aksi',
	1 => 'batal',
	2 => 'no_reg', 
	3 => 'no_rm',
	4 => 'tanggal',
	5 => 'nama_pasien',
	6 => 'penjamin',
	7 => 'umur_pasien',
	8 => 'jenis_kelamin',
	9 => 'dokter',
	10 => 'poli',
	11 => 'no_urut',
	12 => 'id'
	



);

// getting total number records without any search

$sql = "SELECT status, no_urut, id, no_reg, no_rm, tanggal, nama_pasien, penjamin, umur_pasien, jenis_kelamin, dokter, poli ";
$sql.=" FROM registrasi WHERE jenis_pasien = 'Rawat Jalan' AND  status != 'Proses' AND status != 'Sudah Pulang' AND status != 'Batal Rawat' AND status != 'Rujuk Keluar Ditangani' AND status != 'Rujuk Rawat Jalan' AND status != 'Rujuk Keluar Tidak Ditangani' AND tanggal = '$tanggal' ";

$query=mysqli_query($conn, $sql) or die("datatable_registrasi_rawat_jalan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT status, no_urut, id, no_reg, no_rm, tanggal, nama_pasien, penjamin, umur_pasien, jenis_kelamin, dokter, poli ";
$sql.=" FROM registrasi WHERE 1=1 AND jenis_pasien = 'Rawat Jalan' AND  status != 'Proses' AND status != 'Sudah Pulang' AND status != 'Batal Rawat' AND status != 'Rujuk Keluar Ditangani' AND status != 'Rujuk Rawat Jalan' AND status != 'Rujuk Keluar Tidak Ditangani' AND tanggal = '$tanggal'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_rm LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%'";  
	$sql.=" OR no_reg LIKE '".$requestData['search']['value']."%'";    
	$sql.=" OR nama_pasien LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("datatable_registrasi_rawat_jalan.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

$registrasi = $db->query("SELECT status, no_urut, id, no_reg, no_rm, tanggal, nama_pasien, penjamin, umur_pasien, jenis_kelamin, dokter, poli FROM registrasi WHERE no_reg = '$row[no_reg]' ");
$data_reg = mysqli_fetch_array($registrasi);

if ($registrasi_rj['registrasi_rj_lihat']) {
          if ($data_reg['status'] == 'menunggu') {

          	$nestedData[] = "
						<button  class='btn btn-warning pilih1' data-id='".$data_reg['id']."' id='panggil-".$data_reg['id']."' data-status='di panggil' data-urut='". $data_reg['no_urut']."' data-poli='".$data_reg['poli']."'> Panggil  </button>
						<button style='display:none'  class='btn btn-success pilih00' data-id='".$data_reg['id']."' id='proses-".$data_reg['id']."' data-status='Proses'  data-urut='". $data_reg['no_urut']."'> Masuk </button>
					";

          	}
          elseif ($data_reg['status'] == 'di panggil') {

          	$nestedData[] = "
          				<button  class='btn btn-success pilih00' data-id='".$data_reg['id']."' id='proses-".$data_reg['id']."' data-status='Proses'  data-urut='". $data_reg['no_urut']."'> Masuk </button>
          				";
            }
}
else{
}

if ($registrasi_rj['registrasi_rj_edit'] > 0) {  
	$nestedData[] = "<a href='edit_registrasi_rawat_jalan.php?no_reg=". $row['no_reg']."&status_registrasi=pasien_antian' class='btn btn-floating btn-success'><i class='fa fa-edit'> </i></a>";
}	
else{
	$nestedData[] = "";
}

if ($registrasi_rj['registrasi_rj_hapus'] > 0) {     
     $nestedData[] = "<button class='btn btn-danger btn-floating pilih2' data-id='". $data_reg['id']."' data-reg='". $data_reg['no_reg']."'> <b> X </b> </button></td>";
}

else{

		$nestedData[] = "";


}	

	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["tanggal"];	
	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["penjamin"];
	$nestedData[] = $row["umur_pasien"];	
	$nestedData[] = $row["jenis_kelamin"];
	$nestedData[] = $row["dokter"];	
	$nestedData[] = $row["poli"];
	$nestedData[] = $row["no_urut"];
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


