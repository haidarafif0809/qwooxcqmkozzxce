<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


$pilih_akses_pembayaran_piutang = $db->query("SELECT * FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$pembayaran_piutang = mysqli_fetch_array($pilih_akses_pembayaran_piutang);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_pembayaran', 
	1 => 'tanggal',
	2 => 'jam',
	3 => 'keterangan',
	4 => 'total',
	5 => 'user_buat',
  6 => 'user_edit',
  7 => 'tanggal_edit',
  8 => 'nama_daftar_akun',
  9 => 'id'
);

// getting total number records without any search
$sql = "SELECT p.id, p.no_faktur_pembayaran, p.tanggal, p.jam, p.nama_suplier, p.keterangan, p.total, p.user_buat, p.user_edit, p.tanggal_edit, p.dari_kas,da.nama_daftar_akun ";
$sql.=" FROM pembayaran_piutang p INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun";
$query=mysqli_query($conn, $sql) or die("datatable_pembayaran_hutang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT p.id, p.no_faktur_pembayaran, p.tanggal, p.jam, p.nama_suplier, p.keterangan, p.total, p.user_buat, p.user_edit, p.tanggal_edit, p.dari_kas,da.nama_daftar_akun ";
$sql.=" FROM pembayaran_piutang p INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.no_faktur_pembayaran LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.nama_suplier LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_pembayaran_hutang.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY CONCAT(p.tanggal,' ',p.jam) DESC ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	   
    $perintah5 = $db->query("SELECT * FROM detail_pembayaran_piutang");
    $data5 = mysqli_fetch_array($perintah5);


    $select_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$row[nama_suplier]'");
    $data_pelanggan = mysqli_fetch_array($select_pelanggan);

        //menampilkan data
      $nestedData[] = "<button class='btn btn-info detail' no_faktur_pembayaran='". $row['no_faktur_pembayaran'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button>"; 


if ($pembayaran_piutang['pembayaran_piutang_edit'] > 0) {
      $nestedData[] = "<a href='proses_edit_pembayaran_piutang.php?no_faktur_pembayaran=". $row['no_faktur_pembayaran']."&no_faktur_penjualan=". $data5['no_faktur_penjualan']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
    }

if ($pembayaran_piutang['pembayaran_piutang_hapus'] > 0) {    

      $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-suplier='". $row['nama_suplier'] ."' data-nama-pelanggan='". $data_pelanggan['nama_pelanggan'] ."' data-no-faktur='". $row['no_faktur_pembayaran'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
}

    $nestedData[] = "<a href='cetak_lap_pembayaran_piutang.php?no_faktur_pembayaran=".$row['no_faktur_pembayaran']."'  class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Piutang </a>";



      $nestedData[] = $row['no_faktur_pembayaran'];
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['jam'];

      $nestedData[] = $row['keterangan'];
      $nestedData[] = rp($row['total']);
      $nestedData[] = $row['user_buat'];
      $nestedData[] = $row['user_edit'];
      $nestedData[] = $row['tanggal_edit'];
      $nestedData[] = $row['nama_daftar_akun'];
      
		
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

