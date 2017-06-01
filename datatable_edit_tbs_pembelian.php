<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$nomor_faktur = stringdoang($_POST['no_faktur']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


 
$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang',
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'satuan',
    4=>'harga',
    5=>'subtotal',
    6=>'potongan',
    7=>'tax',
    8=>'hapus',
    9=>'id'


);

// getting total number records without any search
$sql =" SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama ";
$sql.=" FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.no_faktur = '$nomor_faktur' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama ";
$sql.=" FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.no_faktur = '$nomor_faktur' ";

    $sql.=" AND (tp.no_faktur LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.kode_barang LIKE '".$requestData['search']['value']."%' )";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array();   


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];
      $nestedData[] = "<p class='edit-jumlah' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."' data-kode='".$row['kode_barang']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-harga='".$row['harga']."' > </p>";
      //TBS FEE

      $nestedData[] = $row["nama"];
      $nestedData[] = "<p class='edit-harga' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."' data-kode='".$row['kode_barang']."'><span id='text-harga-".$row['id']."'>". koma($row['harga'],2) ."</span> <input type='hidden' id='input-harga-".$row['id']."' value='".$row['harga']."' class='input_harga' data-id='".$row['id']."' data-nama='".$row['nama_barang']."' autofocus='' data-kode='".$row['kode_barang']."' data-jumlah='".$row['jumlah_barang']."' > </p>";

      $nestedData[] = "<span id='text-subtotal-".$row['id']."'>". koma($row['subtotal'],2) ."</span>";
      $nestedData[] = "<span id='text-potongan-".$row['id']."'>". koma($row['potongan'],2) ."</span>";
      $nestedData[] = "<span id='text-tax-".$row['id']."'>". koma($row['tax'],2) ."</span>";
      
     $hpp_masuk_pembelian = $db->query ("SELECT no_faktur_hpp_masuk FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$row[no_faktur]' AND kode_barang = '$row[kode_barang]'");
       $row_hpp_keluar = mysqli_num_rows($hpp_masuk_pembelian);


      $pilih = $db->query("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$row[no_faktur]'");
      $row_hutang = mysqli_num_rows($pilih);

      if ($row_hutang > 0 || $row_hpp_keluar > 0 ) {

           $nestedData[] = "<button class='btn btn-danger btn-sm btn-alert-hapus' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."' data-kode='".$row['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></p>";

      } 

      else
      {
            $nestedData[] = "<p> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-".$row['id']."' data-id='". $row['id'] ."' data-subtotal='".$row['subtotal']."' data-kode-barang='". $row['kode_barang'] ."' data-barang='". $row['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
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