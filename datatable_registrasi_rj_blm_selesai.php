<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */
$tanggal = date("Y-m-d");
$sett_registrasi= $db->query("SELECT * FROM setting_registrasi ");
$data_sett = mysqli_fetch_array($sett_registrasi);

$pilih_akses_registrasi_rj = $db->query("SELECT registrasi_rj_lihat, registrasi_rj_tambah, registrasi_rj_edit, registrasi_rj_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_rj = mysqli_fetch_array($pilih_akses_registrasi_rj);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_reg', 
	1 =>'no_rm', 
	2 =>'tanggal', 
	3 =>'nama_pasien', 
	4 =>'penjamin', 
	5 =>'umur_pasien', 
	6 =>'jenis_kelamin', 
	7 =>'keterangan', 
	8 =>'dokter', 
	9 =>'poli', 
	10 =>'no_urut', 
	11 =>'status', 
	12 =>'id' 
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM registrasi WHERE jenis_pasien = 'Rawat Jalan' AND  status != 'Proses' AND status != 'Sudah Pulang' AND status != 'Batal Rawat' AND status != 'Rujuk Keluar Ditangani' AND status != 'Rujuk Rawat Jalan' AND status != 'Rujuk Keluar Tidak Ditangani' AND tanggal <= '$tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_registrasi_rj_blm_selesai.php3: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM registrasi WHERE jenis_pasien = 'Rawat Jalan' AND  status != 'Proses' AND status != 'Sudah Pulang' AND status != 'Batal Rawat' AND status != 'Rujuk Keluar Ditangani' AND status != 'Rujuk Rawat Jalan' AND status != 'Rujuk Keluar Tidak Ditangani' AND tanggal <= '$tanggal' AND 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR nama_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR poli LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR penjamin LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("datatable_registrasi_rj_blm_selesai.php2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("datatable_registrasi_rj_blm_selesai.php1: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	if ($registrasi_rj['registrasi_rj_lihat']) {
          if ($row['status'] == 'menunggu') {

          	$nestedData[] = "
						<button  class='btn btn-warning pilih1' data-id='".$row['id']."' id='panggil-".$row['id']."' data-status='di panggil' data-urut='". $row['no_urut']."' data-poli='".$row['poli']."'> Panggil  </button>
						<button style='display:none'  class='btn btn-success pilih00' data-id='".$row['id']."' id='proses-".$row['id']."' data-status='Proses'  data-urut='". $row['no_urut']."'> Masuk </button>
					";

          	}
          elseif ($row['status'] == 'di panggil') {

          	$nestedData[] = "
          				<button  class='btn btn-success pilih00' data-id='".$row['id']."' id='proses-".$row['id']."' data-status='Proses'  data-urut='". $row['no_urut']."'> Masuk </button>
          				";
            }
            
            else{
 $nestedData[] = "";
}

}
            else{
 $nestedData[] = "";
}
	if ($registrasi_rj['registrasi_rj_hapus'] > 0) {
            $nestedData[] = "<button class='btn btn-danger btn-floating pilih2' data-id='". $row['id']."' data-reg='". $row['no_reg']."'> <b> X </b> </button>";
        }
    else{
            $nestedData[] = "";
        }
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_rm"];
	$nestedData[] = tanggal($row["tanggal"]);
	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["penjamin"];
	$nestedData[] = $row["umur_pasien"];
	$nestedData[] = $row["jenis_kelamin"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["poli"];
	$nestedData[] = $row["no_urut"];
	$nestedData[] = $row["status"];
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
