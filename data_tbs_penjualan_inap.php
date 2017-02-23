<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_penjualan_inap WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

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
    8=>'jam',
    9=>'id',
    9=>'dosis'    

);

// getting total number records without any search
$sql =" SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.tanggal,tp.jam,tp.no_reg,tp.tipe_barang,tp.dosis,s.nama";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id";
$sql.=" WHERE tp.no_reg = '$no_reg'  AND (tp.lab IS NULL OR tp.lab = '') AND (tp.no_faktur IS NULL OR tp.no_faktur = '') ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.tanggal,tp.jam,tp.no_reg,tp.tipe_barang,tp.dosis,s.nama";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id";
$sql.=" WHERE tp.no_reg = '$no_reg'  AND (tp.lab IS NULL OR tp.lab = '') AND (tp.no_faktur IS NULL OR tp.no_faktur = '') ";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.tanggal,tp.jam DESC   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

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

      if ($otoritas_tombol['edit_produk_inap'] > 0){

      $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jumlah' data-id='".$row['id']."' data-kode='".$row['kode_barang']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-harga='".$row['harga']."' data-tipe='".$row['tipe_barang']."' data-satuan='".$row['satuan']."' data-nama-barang='".$row['nama_barang']."' onkeydown='return numbersonly(this, event);'> </p>";

    }
    else{

      $nestedData[] = "<p style='font-size:15px' align='right' class='gk_bisa_edit'>". rp($row['jumlah_barang']) ." </p>";
    }


      $nestedData[] = $row["nama"];


      $nestedData[] = "<p style='font-size:15px' class='edit-dosis' data-id='".$row['id']."'> <span id='text-dosis-".$row['id']."'>".$row["dosis"]."</span> <input type='hidden' id='input-dosis-".$row['id']."' value='".$row['dosis']."' class='input_dosis' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-tipe='".$row['tipe_barang']."' data-nama-barang='".$row['nama_barang']."'> </p>";


      $nestedData[] = "<p  align='right'>".rp($row["harga"])."</p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".rp($row["subtotal"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-potongan-".$row['id']."'> ".rp($row["potongan"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".rp($row["tax"])." </span> </p>";

      $nestedData[] = "".$row['tanggal']." ".$row['jam']."";
      
      if ($otoritas_tombol['hapus_produk_inap'] > 0) {

                $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-".$row['id']."' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-barang='". $row['nama_barang'] ."' data-subtotal='". $row['subtotal'] ."'>Hapus</button>";
      }
      else{
                $nestedData[] = "<p  style='font-size:15px; color:red'> Tidak Ada Otoritas</p>";
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