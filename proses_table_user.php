<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

/* Database connection end */
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	0 =>'reset', 
	1 => 'username',
	2=> 'password',
	3 => 'nama_lengkap',
	4=> 'alamat',
	5 => 'jabatan',
	6=> 'otoritas',
	7=> 'tipe_user',
	8 => 'status',
	9=> 'status_sales',
	10 => 'hapus',
	11=> 'edit',
	12=> 'id'


);

// getting total number records without any search
$sql = " SELECT u.status, u.username, u.password, u.nama, u.alamat, u.jabatan, u.otoritas, u.tipe, u.status_sales, u.id, j.nama AS nama_jabatan ";
$sql.=" FROM user u INNER JOIN jabatan j ON u.jabatan = j.id ";

$query = mysqli_query($conn, $sql) or die("query 1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT u.status, u.username, u.password, u.nama, u.alamat, u.jabatan, u.otoritas, u.tipe, u.status_sales, u.id, j.nama AS nama_jabatan ";
$sql.=" FROM user u INNER JOIN jabatan j ON u.jabatan = j.id WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( u.status LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR u.username LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.jabatan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.otoritas LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.tipe LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.status_sales LIKE '".$requestData['search']['value']."%' )";
}


$query= mysqli_query($conn, $sql) or die("query 2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  u.id   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("query 3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


$nestedData[] = "<button class='btn btn-warning btn-reset' data-reset-id='". $row['id'] ."' data-reset-user='". $row['username'] ."'><span class='glyphicon glyphicon-refresh'> </span> Reset Password </button>";


	$nestedData[] = $row['username'];
	$nestedData[] = $row['password'];
	$nestedData[] = $row['nama'];
	$nestedData[] = $row['alamat'];
	$nestedData[] = $row['nama_jabatan'];
	$nestedData[] = $row['otoritas'];

         if ($row['tipe'] == '1')
         {
          $nestedData[] =  "<p>Dokter</p>";
         }
         elseif ($row['tipe'] == '2')
         {
        $nestedData[] =  "<p>Paramedik</p>";
         }
         elseif ($row['tipe'] == '3')
         {
        $nestedData[] =  "<p>Farmasi</p>";
         }
         elseif ($row['tipe'] == '4')
         {
        $nestedData[] =  "<p>Admin</p>";
         }
            elseif ($row['tipe'] == '5')
         {
        $nestedData[] =  "<p>Lain Lain</p>";
         }

         $nestedData[] = $row['status'];

      if ($row['status_sales'] == 'Iya') {
        
         $nestedData[] = "<i class='fa fa-check'> </i>";
      }
      else{
        $nestedData[] = "<i class='fa fa-close'> </i>";
      }


$pilih_akses_user_hapus = $db->query("SELECT user_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_hapus = '1'");
$user_hapus = mysqli_num_rows($pilih_akses_user_hapus);


    if ($user_hapus > 0){
        $nestedData[] = " <button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-user='". $row['username'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> ";

      }

$pilih_akses_user_edit = $db->query("SELECT user_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_edit = '1'");
$user_edit = mysqli_num_rows($pilih_akses_user_edit);


    if ($user_edit > 0){

        $nestedData[] = "<a href='edituser.php?id=". $row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit </a>";
         }

	$nestedData[] = $row['id'];	
	
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
