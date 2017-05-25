<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);

$pilih_akses_tombol = $db->query("SELECT hapus_produk FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_jasa',
    1=>'nama_jasa',
    2=>'harga',
    3=>'komisi',
    4=>'dokter',
    5=>'analis',
    6=>'tanggal',
    7=>'jam',
    8=>'hapus',
    9=>'id'


);

// getting total number records without any search
$sql =" SELECT tp.id,u.nama AS nama_dokter, tp.no_reg, tp.no_faktur, tp.kode_jasa, tp.nama_jasa, tp.harga, tp.subtotal, tp.dokter, tp.analis, tp.tanggal, tp.jam, uu.nama AS nama_analis";
$sql.=" FROM tbs_aps_penjualan tp LEFT JOIN user u on tp.dokter = u.id LEFT JOIN user uu on tp.analis = uu.id";
$sql.=" WHERE tp.no_reg = '$no_reg' AND (tp.no_faktur IS NULL OR tp.no_faktur = '')";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id,u.nama AS nama_dokter, tp.no_reg, tp.no_faktur, tp.kode_jasa, tp.nama_jasa, tp.harga, tp.subtotal, tp.dokter, tp.analis, tp.tanggal, tp.jam, uu.nama AS nama_analis";
$sql.=" FROM tbs_aps_penjualan tp LEFT JOIN user u on tp.dokter = u.id LEFT JOIN user uu on tp.analis = uu.id";
$sql.=" WHERE tp.no_reg = '$no_reg' AND (tp.no_faktur IS NULL OR tp.no_faktur = '')";

    $sql.=" AND (kode_jasa LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR nama_jasa LIKE '".$requestData['search']['value']."%' )";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY kode_jasa DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array(); 


      $nestedData[] = $row["kode_jasa"];
      $nestedData[] = $row["nama_jasa"];
      $nestedData[] = "<p  align='right'> ".rp($row["harga"])."</p>";
      //TBS FEE
      $query_tbs_fee = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_jasa]' AND f.jam = '$row[jam]' ");

      $nama_fee = "<p style='font-size:15px;'> ";
      while($data_fee = mysqli_fetch_array($query_tbs_fee))
        {
          $nama_fee .= "".$data_fee["nama"].", ";
        }
        $nama_fee .= "</p>";
      //END TBS FEE
      $nestedData[] = $nama_fee; //Tampilan TBS FEE
      $nestedData[] = $row["nama_dokter"];
      $nestedData[] = $row["nama_analis"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["jam"];

      if ($otoritas_tombol['hapus_produk'] > 0) {

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-kode='". $row['kode_jasa'] ."' data-barang='". $row['nama_jasa'] ."'>Hapus</button>";
      }

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