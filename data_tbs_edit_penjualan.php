<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);
$no_faktur = stringdoang($_POST['no_faktur']);


$pilih_akses_tombol = $db->query("SELECT edit_produk,hapus_produk FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'nama_pelaksana',
    3=>'jumlah_barang',
    4=>'satuan',
    5=>'harga',
    6=>'potongan',
    7=>'tax',
    8=>'subtotal',
    9=>'id'   

);

// getting total number records without any search
$sql =" SELECT tp.no_reg,tp.id,tp.no_faktur,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.jam,tp.tipe_barang,s.nama ";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.no_faktur = '$no_faktur' AND tp.no_reg = '$no_reg' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql ="SELECT tp.no_reg,tp.id,tp.no_faktur,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.jam,tp.tipe_barang,s.nama ";
$sql.="  FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.no_faktur = '$no_faktur' AND tp.no_reg = '$no_reg'  ";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";


    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}

 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array(); 


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

                
                $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_barang]' AND f.no_reg = '$no_reg' ");
                    

                $nama_fee = "<p style='font-size:15px;'> ";

                   while($nur = mysqli_fetch_array($kdD))
                  {
                   $nama_fee .= " ".$nur['nama']." ,";
                  }
                $nama_fee .= "</p>";

                    $nestedData[] = $nama_fee;

               
       

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$row[no_faktur]' AND kode_barang = '$row[kode_barang]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$row[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

  if ($row_retur > 0 || $row_piutang > 0) 
{

             $nestedData[] = "<p class='edit-jumlah-alert' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."'  data-kode='".$row['kode_barang']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-satuan='".$row['satuan']."' data-harga='".$row['harga']."' data-tipe='".$row['tipe_barang']."'> </p>";  

}
  else 
{

 if ($otoritas_tombol['edit_produk'] > 0)
  { 

  $nestedData[] = " <p class='edit-jumlah' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."'  data-kode='".$row['kode_barang']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-satuan='".$row['satuan']."' data-harga='".$row['harga']."' data-tipe='".$row['tipe_barang']."'> </p>";  
  }
else
  {
  $nestedData[] = "<p style='font-size:15px' align='right' class='tidak_punya_otoritas' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". rp($row['jumlah_barang']) ."</span> </p>";
   }

}

    $nestedData[] = $row["nama"];
    $nestedData[] = "<p  align='right'><span id='text-harga-".$row['id']."'> ".rp($row["harga"])."</span> </p>";
    
    $nestedData[] = "<p class='edit-potongan' style='font-size:15px' align='right' data-id=".$row['id']."><span id='text-potongan-".$row['id']."'> ".rp($row["potongan"])." </span> 
      <input type='hidden' id='input-potongan-".$row['id']."' value='".$row['potongan']."' class='input_potongan' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."'> </p>";


    $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".rp($row["tax"])." </span> </p>";
    $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".rp($row["subtotal"])." </span> </p>";

if ($row_retur > 0 || $row_piutang > 0) {

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-alert-hapus' id='btn-hapus-".$row['id']."' data-id='".$row['id']."' data-subtotal='".$row['subtotal']."' data-faktur='".$row['no_faktur']."' data-kode='".$row['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button>";

} 

else{

  if ($otoritas_tombol['hapus_produk'] > 0) {

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-".$row['id']."' data-id='". $row['id'] ."' data-subtotal='".$row['subtotal']."' data-kode-barang='". $row['kode_barang'] ."' data-barang='". $row['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button>";

    }
else
{
   $nestedData[] = "<p style='font-size:12px; color:red'> Tidak Ada Otoritas </p>";
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