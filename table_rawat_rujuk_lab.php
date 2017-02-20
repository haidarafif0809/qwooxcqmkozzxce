<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode', 
    1=>'nama',
    2=>'petugas',
    3=>'jumlah',
    4=>'satuan',
    5=>'dosis',
    6=>'harga',
    7=>'subtotal',
    8=>'potongan',
    9=>'pajak'


);


// getting total number records without any search
$sql =" SELECT tp.jam,tp.id,tp.tipe_barang,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama , tp.dosis";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id  ";
$sql.=" WHERE tp.no_reg = '$no_reg' AND tp.lab IS NULL ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.jam,tp.id,tp.tipe_barang,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama , tp.dosis";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id  ";
$sql.=" WHERE tp.no_reg = '$no_reg' AND tp.lab IS NULL ";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      $kd = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_barang]' AND f.jam = '$row[jam]' ");

      $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_barang]' AND f.jam = '$row[jam]' ");

      $nu = mysqli_fetch_array($kd);

        if ($nu['nama'] != '')
        {
          $nama_fee = "";
          while($nur = mysqli_fetch_array($kdD))
          {
          $nama_fee .= "<p style='font-size:15px;'> ".$nur["nama"].", </p>";
          }          
          $nestedData[] = $nama_fee;
        }

        else
        {
           $nestedData[] = "";
        }


      $nestedData[] = rp($row["jumlah_barang"]);
      $nestedData[] = $row["nama"];
      $nestedData[] = $row["dosis"];
      $nestedData[] = rp($row["harga"]);
      $nestedData[] = rp($row["subtotal"]);
      $nestedData[] = rp($row["potongan"]);
      $nestedData[] = rp($row["tax"]);

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