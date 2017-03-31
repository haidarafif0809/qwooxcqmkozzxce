<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);
$no_urut = 0;

$pilih_akses_tombol = $db->query("SELECT status_hasil, foto_hasil, keterangan_hasil FROM otoritas_radiologi WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);
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
$sql =" SELECT tr.id, tr.session_id, tr.status_periksa, tr.no_faktur, tr.no_reg, tr.kode_barang, tr.nama_barang, tr.jumlah_barang, tr.harga, tr.subtotal, tr.potongan, tr.tax, tr.foto, tr.tipe_barang, tr.tanggal, tr.jam, tr.radiologi, tr.dokter_pengirim, tr.dokter_pelaksana, tr.dokter_periksa, tr.keterangan, u.nama AS nama_dkoter_pengirim";
$sql.=" FROM tbs_penjualan_radiologi tr LEFT JOIN user u ON tr.dokter_pengirim = u.id";
$sql.=" WHERE tr.no_reg = '$no_reg' AND tr.radiologi = 'Radiologi' AND (tr.no_faktur IS NULL OR tr.no_faktur = '')";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tr.id, tr.session_id, tr.status_periksa, tr.no_faktur, tr.no_reg, tr.kode_barang, tr.nama_barang, tr.jumlah_barang, tr.harga, tr.subtotal, tr.potongan, tr.tax, tr.foto, tr.tipe_barang, tr.tanggal, tr.jam, tr.radiologi, tr.dokter_pengirim, tr.dokter_pelaksana, tr.dokter_periksa, tr.keterangan, u.nama AS nama_dkoter_pengirim";
$sql.=" FROM tbs_penjualan_radiologi tr LEFT JOIN user u ON tr.dokter_pengirim = u.id";
$sql.=" WHERE tr.no_reg = '$no_reg' AND tr.radiologi = 'Radiologi' AND (tr.no_faktur IS NULL OR tr.no_faktur = '')";

    $sql.=" AND (tr.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tr.nama_barang LIKE '".$requestData['search']['value']."%' )";

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

    $no_urut ++;

      $nestedData[] = $no_urut;
      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      if ($row['dokter_pengirim'] == 0 ) {        
      $nestedData[] = "-";
      }
      else{
      $nestedData[] = $row["nama_dkoter_pengirim"];
      }

if ($otoritas_tombol['status_hasil'] > 0) {

      if ($row["status_periksa"] == '1') {
        $nestedData[] = "<p class='edit-status'  data-kode='".$row['kode_barang']."' data-reg='".$row['no_reg']."' data-id='".$row['id']."'><span id='text-status-".$row['id']."'>Diperiksa</span>
            <select style='display:none' id='select-status-".$row['id']."' data-reg='".$row['no_reg']."' data-nama='".$row['nama_barang']."' value='".$row['status_periksa']."' class='select-status' data-id='".$row['id']."' data-foto='".$row['foto']."'  data-nama='".$row['nama_barang']."' data-ket='".$row['keterangan']."' autofocus=''>
                <option value = '1'> Diperiksa</option>
                <option value = '0'> Tidak Diperiksa</option>
            </select>
          </p>";
       }
      else{
        $nestedData[] = "<p class='edit-status'  data-kode='".$row['kode_barang']."' data-reg='".$row['no_reg']."' data-nama='".$row['nama_barang']."' data-id='".$row['id']."'><span id='text-status-".$row['id']."'>Tidak Diperiksa</span>
            <select style='display:none' id='select-status-".$row['id']."' data-reg='".$row['no_reg']."' value='".$row['status_periksa']."' class='select-status' data-id='".$row['id']."' data-foto='".$row['foto']."'  data-nama='".$row['nama_barang']."' data-ket='".$row['keterangan']."' autofocus=''>
                <option value = '0'> Tidak Diperiksa</option>
                <option value = '1'> Diperiksa </option>
            </select>
          </p>";
      }

}

if ($otoritas_tombol['foto_hasil'] > 0) {
      if ($row['foto'] == Null) {

        $nestedData[] = "<button class='btn btn-primary btn-sm btn-upload' id='upload-foto-". $row['id'] ."' data-id='". $row['id'] ."' data-kode='". $row['kode_barang'] ."' data-reg='". $row['no_reg'] ."'>Browse</button> ";
      }
      else{

      $nestedData[] = "<button class='btn btn-floating btn-small btn-info tampil_foto' data-reg='". $row['no_reg']."' data-nama='". $row['nama_barang']."' data-kode='". $row['kode_barang']."' ><i class='fa fa-photo'></i></button>";
        
      }
}

if ($otoritas_tombol['keterangan_hasil'] > 0) {

      if ($row['keterangan'] == "") {

      $nestedData[] = "<button class='btn btn-floating btn-small btn-success tambah_ket' data-reg='". $row['no_reg']."' data-nama='". $row['nama_barang']."' data-kode='". $row['kode_barang']."' ><i class='fa fa-plus'></i></button>";
      }
      else{
       $nestedData[] = "<button class='btn btn-floating btn-small btn-success lihat_hasil_expertise' data-reg='". $row['no_reg']."' data-nama='". $row['nama_barang']."' data-kode='". $row['kode_barang']."' data-ket='".$row['keterangan']."' ><i class='fa fa-file-text'></i></button>";
      }

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