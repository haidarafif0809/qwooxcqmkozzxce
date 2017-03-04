<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$perintah11 = $db->query("SELECT * FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$total_row = mysqli_num_rows($perintah11);

$perintah210 = $db->query("SELECT SUM(total) AS total_total, SUM(kredit) AS total_kredit FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data210 = mysqli_fetch_array($perintah210);

$total_total = $data210['total_total'];
$total_kredit = $data210['total_kredit'];

$total_bayar = $total_total - $total_kredit;


$hitung_harga = $db->query("SELECT SUM(harga_jual) AS total_jual FROM hasil_operasi WHERE DATE(waktu) >= '$dari_tanggal' AND DATE(waktu) <= '$sampai_tanggal' ");
$jumlah_harga = mysqli_fetch_array($hitung_harga);
$total_harga = $jumlah_harga['total_jual'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
  0 =>'no_reg', 
  1 =>'harga_jual', 
  2 =>'waktu', 
  3 =>'sub_operasi', 
  4 =>'operasi', 
  5 =>'id'

);

// getting total number records without any search
$sql =" SELECT p.no_faktur,kk.nama AS kelas_kamar,c.nama AS nama_cito,u.nama AS petugas_input,o.nama_operasi,ho.no_reg,ho.harga_jual,ho.waktu,ho.id,ho.sub_operasi,ho.operasi ";
$sql.=" FROM hasil_operasi ho INNER JOIN operasi o ON ho.operasi = o.id_operasi INNER JOIN user u ON ho.petugas_input = u.id INNER JOIN sub_operasi so ON ho.sub_operasi = so.id_sub_operasi INNER JOIN cito c ON so.id_cito = c.id INNER JOIN kelas_kamar kk ON so.id_kelas_kamar = kk.id INNER JOIN penjualan p ON ho.no_reg = p.no_reg ";
$sql.=" WHERE DATE(ho.waktu) >= '$dari_tanggal' AND DATE(ho.waktu) <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("eror.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT p.no_faktur,kk.nama AS kelas_kamar,c.nama AS nama_cito,u.nama AS petugas_input,o.nama_operasi,ho.no_reg,ho.harga_jual,ho.waktu,ho.id,ho.sub_operasi,ho.operasi ";
$sql.=" FROM hasil_operasi ho INNER JOIN operasi o ON ho.operasi = o.id_operasi INNER JOIN user u ON ho.petugas_input = u.id INNER JOIN sub_operasi so ON ho.sub_operasi = so.id_sub_operasi INNER JOIN cito c ON so.id_cito = c.id INNER JOIN kelas_kamar kk ON so.id_kelas_kamar = kk.id INNER JOIN penjualan p ON ho.no_reg = p.no_reg ";
$sql.=" WHERE DATE(ho.waktu) >= '$dari_tanggal' AND DATE(ho.waktu) <= '$sampai_tanggal' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


  $sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR o.nama_operasi LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR ho.no_reg LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR kk.nama LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR c.nama LIKE '".$requestData['search']['value']."%' ) ";  

}
;
 // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY CONCAT(p.tanggal,' ',p.jam) DESC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("eror.php2: get employees");
$totalFiltered = mysqli_num_rows($query);

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();      

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['no_reg'];
      $nestedData[] = $row['nama_operasi'];
      $nestedData[] = $row['kelas_kamar'];
      $nestedData[] = $row['nama_cito'];
      $nestedData[] = $row['harga_jual'];
      $nestedData[] = $row['petugas_input'];
      $nestedData[] = $row['waktu'];

      $nestedData[] = "<button class='btn btn-floating bnt-lg  btn-info detail-lap-ops' data-id='". $row['id']."'
          data-sub_operasi='". $row['sub_operasi']."' data-operasi='". $row['operasi']." data-no_faktur='". $row['no_faktur']." data-no_reg='". $row['no_reg']."'><i class='fa fa-list'></i></button>";


  $data[] = $nestedData;
}

  $nestedData=array();      

      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "<p> </p>";
      $nestedData[] = "<p> </p>";
      $nestedData[] = "<p> </p>";
      $nestedData[] = "<p> </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_harga)." </p>";
      $nestedData[] = "<p> </p>";
      $nestedData[] = "<p> </p>";
      $nestedData[] = "<p> </p>";


  $data[] = $nestedData;



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>