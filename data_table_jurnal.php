<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_akun', 
	1 => 'nama_akun',
	2=> 'debit',
	3 => 'kredit',
	4=> 'keterangan'


);

// getting total number records without any search
$sql = "SELECT no_faktur";
$sql.=" FROM jurnal_trans ";
$sql.=" WHERE DATE(waktu_jurnal) >= '$dari_tanggal'";
$sql.=" AND DATE(waktu_jurnal) <= '$sampai_tanggal'";
$sql.=" GROUP BY no_faktur";
$sql.=" ORDER BY waktu_jurnal DESC";

 
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
$sql = "SELECT no_faktur";
$sql.=" FROM jurnal_trans ";
$sql.=" WHERE 1=1 ";
$sql.=" AND DATE(waktu_jurnal) >= '$dari_tanggal'";
$sql.=" AND DATE(waktu_jurnal) <= '$sampai_tanggal'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR DATE(waktu_jurnal) LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR keterangan_jurnal LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" GROUP BY no_faktur";
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

$query15 = $db->query("SELECT SUM(debit) AS debit FROM jurnal_trans WHERE no_faktur = '$row[no_faktur]'");
$cek15 = mysqli_fetch_array($query15);
$debit = $cek15['debit'];

$query105 = $db->query("SELECT SUM(kredit) AS kredit FROM jurnal_trans WHERE no_faktur = '$row[no_faktur]'");
$cek105 = mysqli_fetch_array($query105);
$kredit = $cek105['kredit'];


				$select_jurnal = $db->query("SELECT j.id,j.nomor_jurnal, j.waktu_jurnal, j.keterangan_jurnal, j.kode_akun_jurnal, j.debit, j.kredit, j.jenis_transaksi, j.no_faktur, j.approved, j.user_buat, j.user_edit, d.nama_daftar_akun FROM jurnal_trans j INNER JOIN daftar_akun d ON j.kode_akun_jurnal = d.kode_daftar_akun WHERE j.no_faktur = '$row[no_faktur]' ORDER BY j.id");

				$select = $db->query("SELECT id FROM jurnal_trans WHERE no_faktur = '$row[no_faktur]' ORDER BY id DESC LIMIT 1");
				$data0 = mysqli_fetch_array($select);


				$select_no_faktur = $db->query("SELECT id FROM jurnal_trans WHERE no_faktur = '$row[no_faktur]' ORDER BY id ASC LIMIT 1");
				$data00 = mysqli_fetch_array($select_no_faktur);

while ($data10 = mysqli_fetch_array($select_jurnal))
		{//while ($data10 = mysqli_fetch_array($select_jurnal))
			if ($data10['debit'] == 0 AND $data10['kredit'] == 0) {


			}
			else{//else if ($data10['debit'] == 0 AND $data10['kredit'] == 0) {
					if ($data10['id'] == $data00['id']) {//if ($data['id'] == $data00['id']){ {

					$nestedData[] = "<br><b> Tanggal : ". tanggal($data10['waktu_jurnal']) ." </b>
					<br>
					". $data10['kode_akun_jurnal']." ";
					$nestedData[] = "<br><b> No. Transaksi : ". $data10['no_faktur'] ." </b>
					<br>
					".$data10['nama_daftar_akun']." ";
					
					$nestedData[] = "<br><b> Ref : ". $data10['jenis_transaksi'] ." / ". $data10['no_faktur'] ." </b>
					<br>
					". rp($data10['debit']) ." ";
					
					$nestedData[] = "<br><br>". rp($data10['kredit']) ." ";
					$nestedData[] = "<br><br>". $data10['keterangan_jurnal'] ." ";


					}//if if ($data['id'] == $data00['id']){ {

					else

					{// else if ($data['id'] == $data00['id']){ {
					$nestedData[] = "
					<br>
					". $data10['kode_akun_jurnal']." ";
					$nestedData[] = "
					<br>
					".$data10['nama_daftar_akun']." ";
					
					$nestedData[] = "
					<br>
					". rp($data10['debit']) ." ";
					
					$nestedData[] = "<br>". rp($data10['kredit']) ." ";
					$nestedData[] = "<br>". $data10['keterangan_jurnal'] ." ";

					}// else if ($data['id'] == $data00['id']){ {

			    }//else if ($data['debit'] == 0 AND $data['kredit'] == 0) {

			   if ($data10['id'] == $data0['id']){// if ($data['id'] == $data0['id']){

						   	if ($debit == 0 AND $kredit == 0) {
							
							}		
							
							else
							{ 

								$nestedData[] = "<b>Subtotal  ". $data10['no_faktur'] ."</b>";
								$nestedData[] = "";
								$nestedData[] = "<b>". rp($debit) ."</b>";
								$nestedData[] = "<b>". rp($kredit) ."</b>";
								$nestedData[] = "";
							} 

			   }// if ($data['id'] == $data0['id']){


		}//while ($data = mysqli_fetch_array($select_jurnal))


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
