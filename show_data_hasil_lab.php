<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'input', 
	1 => 'no_rm',
	2 => 'no_reg',
	3 => 'no_faktur',
	4 => 'nama_pasien',
	5 => 'nama_pemeriksaan',
	6 => 'nilai_normal_lk',
	7 => 'nilai_normal_pr',
	8 => 'status_abnormal',
	9 => 'status_rawat',
	10 => 'tanggal',
	11 => 'id'


);


// getting total number records without any search
$sql = "SELECT sh.satuan_nilai_normal,sh.normal_lk2,sh.normal_pr2,sh.model_hitung,hl.nama_pasien,hl.no_rm,hl.no_reg,hl.no_faktur,hl.nama_pemeriksaan,hl.id,hl.status,hl.hasil_pemeriksaan,hl.nilai_normal_lk,hl.nilai_normal_pr,hl.status_abnormal,hl.status_pasien,hl.tanggal ";
$sql.= "FROM hasil_lab hl LEFT JOIN setup_hasil sh ON sh.nama_pemeriksaan = hl.id_pemeriksaan";

$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT sh.satuan_nilai_normal,sh.normal_lk2,sh.normal_pr2,sh.model_hitung,hl.nama_pasien,hl.no_rm,hl.no_reg,hl.no_faktur,hl.nama_pemeriksaan,hl.id,hl.status,hl.hasil_pemeriksaan,hl.nilai_normal_lk,hl.nilai_normal_pr,hl.status_abnormal,hl.status_pasien,hl.tanggal ";
$sql.= "FROM hasil_lab hl LEFT JOIN setup_hasil sh ON sh.nama_pemeriksaan = hl.id_pemeriksaan";
$sql.=" WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( hl.nama_pasien LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_rm LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR hl.no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR hl.no_rm LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR hl.nama_pemeriksaan LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

if($row['status'] != 'Selesai')
{

	$nestedData[] = "<a href='input_hasil_lab.php?no_faktur=". $row['no_faktur']."' class='btn btn-success'> Input </a>";
}
else
{
	$nestedData[] = "<p style='color:red'> Selesai </p>";
}

if($row['status'] == 'Selesai' AND $row['no_faktur'] != '')
{

$nestedData[] = "<a href='cetak_laporan_hasil_lab.php?no_faktur=".$row['no_faktur']."' target='blank' class='btn btn-floating btn-primary' data-target='blank'> <i class='fa fa-print'></i> </a>";
}
else
{
	$nestedData[] = "<p style='color:red'> Belum Bisa Cetak</p>";
}

	
	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_faktur"];	
	$nestedData[] = $row["nama_pasien"];
	$nestedData[] = $row["nama_pemeriksaan"];
	$nestedData[] = $row["hasil_pemeriksaan"];

	

$model_hitung = $row['model_hitung'];

switch ($model_hitung) {
    case "Lebih Kecil Dari":
        $nestedData[] = "&lt;&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "&lt;&nbsp; ".$row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        
        break;

    case "Lebih Kecil Sama Dengan":
        $nestedData[] = "&lt;=&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";  
        $nestedData[] = " &lt;=&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        break;

    case "Lebih Besar Dari":
        $nestedData[] = "&gt;&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "&gt;&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        break;

    case "Lebih Besar Sama Dengan":
        $nestedData[] = "&gt;=&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "&gt;=&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        break;
    
    case "Antara Sama Dengan":
        $nestedData[] = "". $row['nilai_normal_lk']."&nbsp;-&nbsp; ". $row['normal_lk2']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "". $row['nilai_normal_pr']."&nbsp;-&nbsp; ". $row['normal_pr2']."&nbsp;". $row['satuan_nilai_normal']."";
        break;
	} 




	$nestedData[] = $row["status_abnormal"];
	$nestedData[] = $row["status_pasien"];
	$nestedData[] = $row["tanggal"];
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