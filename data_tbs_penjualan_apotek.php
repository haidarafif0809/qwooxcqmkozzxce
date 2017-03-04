<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = stringdoang($_POST['session_id']);

$pilih_akses_tombol = $db->query("SELECT edit_produk_apotek, hapus_produk_apotek FROM otoritas_penjualan_apotek WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0 => 'no_reg',
    1 => 'kode_barang',
    2 => 'satuan',
    3 => 'nama_barang',
    4 => 'jumlah_barang',
    5 => 'harga',
    6 => 'subtotal',
    7 => 'potongan',
    8 => 'tax',
    9 => 'jam',
    10 => 'tipe_barang',
    11 => 'nama',
    12 => 'id'

);

// getting total number records without any search
$sql =" SELECT tp.no_reg,tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.jam,tp.tipe_barang,s.nama ";
$sql.=" FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.session_id = '$session_id' AND (tp.no_reg IS NULL OR tp.no_reg = '') AND tp.lab IS NULL ";


$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.no_reg,tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.jam,tp.tipe_barang,s.nama ";
$sql.=" FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.session_id = '$session_id' AND (tp.no_reg IS NULL OR tp.no_reg = '') AND tp.lab IS NULL ";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) { // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_barang]' AND f.no_reg is NULL GROUP BY f.nama_petugas ");

          $nama_fee = "<p style='font-size:15px;'>";
          while($nur = mysqli_fetch_array($kdD))
          {
          $nama_fee .= " ".$nur["nama"].",";
          }
          $nama_fee .= "</p>";  
                 
          $nestedData[] = $nama_fee; 
       
        
       

      if ($otoritas_tombol['edit_produk_apotek'] > 0) {
      
      $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-tipe='".$row['tipe_barang']."' data-harga='".$row['harga']."' data-satuan='".$row['satuan']."' data-tipe='".$row['tipe_barang']."' > </p>";
      
      }
      else{
      
      $nestedData[] = "<<p style='font-size:15px' align='right' class='tidak_punya_otoritas' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-tipe='".$row['tipe_barang']."' data-harga='".$row['harga']."' data-satuan='".$row['satuan']."' data-tipe='".$row['tipe_barang']."' > </p>";
      }


      $nestedData[] = $row["nama"];


      $nestedData[] = "<p  align='right'>".$row["harga"]."</p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".$row["subtotal"]." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-potongan-".$row['id']."'> ".$row["potongan"]." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".$row["tax"]." </span> </p>";

      if ($otoritas_tombol['hapus_produk_apotek'] > 0) {

            $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-id-".$row['id']."' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-barang='". $row['nama_barang'] ."' data-subtotal='". $row['subtotal'] ."'>Hapus</button>";
      }
      else{
              $nestedData[] = "<p style='font-size:15px; color:red'> Tidak Ada Otoritas </p>";
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