<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);
$no_rm = stringdoang($_POST['no_rm']);
$nama = stringdoang($_POST['nama']);
$bed = stringdoang($_POST['bed']);
$kamar = stringdoang($_POST['kamar']);
$penjamin = stringdoang($_POST['penjamin']);
$dokter = stringdoang($_POST['dokter']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'id',
    1=>'session_id',
    2=>'no_faktur',
    3=>'no_reg',
    4=>'kode_barang',
    5=>'nama_barang',
    6=>'jumlah_barang',
    7=>'harga',
    8=>'subtotal',
    9=>'potongan',
    10=>'tax',
    11=>'foto',
    12=>'tipe_barang',
    13=>'tanggal',
    14=>'jam',
    15=>'radiologi',
    16=>'dokter_pengirim',
    17=>'dokter_pelaksana',
    18=>'dokter_periksa'

);

// getting total number records without any search
$sql =" SELECT tr.id, tr.session_id, tr.no_faktur, tr.no_reg, tr.kode_barang, tr.nama_barang, tr.jumlah_barang, tr.harga, tr.subtotal, tr.potongan, tr.tax, tr.foto, tr.tipe_barang, tr.tanggal, tr.jam, tr.radiologi, tr.dokter_pengirim, tr.dokter_pelaksana, tr.dokter_periksa, tr.no_pemeriksaan, u.nama AS nama_dkoter_pengirim";
$sql.=" FROM tbs_penjualan_radiologi tr LEFT JOIN user u ON tr.dokter_pengirim = u.id";
$sql.=" WHERE tr.no_reg = '$no_reg' AND tr.radiologi = 'Radiologi' AND (tr.no_faktur IS NULL OR tr.no_faktur = '') GROUP BY no_pemeriksaan ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tr.id, tr.session_id, tr.no_faktur, tr.no_reg, tr.kode_barang, tr.nama_barang, tr.jumlah_barang, tr.harga, tr.subtotal, tr.potongan, tr.tax, tr.foto, tr.tipe_barang, tr.tanggal, tr.jam, tr.radiologi, tr.dokter_pengirim, tr.dokter_pelaksana, tr.dokter_periksa, tr.no_pemeriksaan, u.nama AS nama_dkoter_pengirim";
$sql.=" FROM tbs_penjualan_radiologi tr LEFT JOIN user u ON tr.dokter_pengirim = u.id";
$sql.=" WHERE tr.no_reg = '$no_reg' AND tr.radiologi = 'Radiologi' AND (tr.no_faktur IS NULL OR tr.no_faktur = '')";

    $sql.=" AND (tr.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tr.nama_barang LIKE '".$requestData['search']['value']."%' )";
    $sql.=" GROUP BY no_reg AND no_pemeriksaan ";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tr.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array(); 


      $nestedData[] = "<p  align='center'> ".$row["no_pemeriksaan"]."</p>";
      $nestedData[] = $no_reg;
      $nestedData[] = "<p  align='center'> ".$no_rm."</p>";
      $nestedData[] = $nama;
      $nestedData[] = $penjamin;
      $nestedData[] = $bed;
      $nestedData[] = $kamar;

      //Edit Jasa Radiologi
      $nestedData[] ='<td> <a href="form_edit_pemeriksaan_radiologi_inap.php?id='.$row["id"].'&no_pemeriksaan='.$row["no_pemeriksaan"].'&no_rm='.$no_rm.'&nama_pasien='.$nama.'&penjamin='.$penjamin.'&no_reg='.$no_reg.'&dokter='.$dokter.'&bed='.$bed.'&kamar='.$kamar.'&tanggal='.$row["tanggal"].'" class="btn btn-info btn-floating"> <i class="fa fa-edit"> </i></a></td>';

      //Detail Jasa Radiologi
      $nestedData[] = "<td><button class='btn btn-floating  btn-info detail-radiologi-inap' data-reg='".$row['no_reg']."' data-periksa='".$row['no_pemeriksaan']."'><i class='fa fa-list'></i></button></td>";

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