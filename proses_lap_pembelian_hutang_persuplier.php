<?php
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$suplier = stringdoang($_POST['suplier']);
$jumlah_bayar_hutang = 0;

if ($suplier == "semua") {

// LOGIKA UNTUK AMBIL BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)
  $query_sum_dari_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian,SUM(total) AS total_akhir, SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");
  $data_sum_dari_pembelian = mysqli_fetch_array($query_sum_dari_pembelian);

  $query_faktur_pembelian = $db->query("SELECT no_faktur FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");
  while ($data_faktur_pembelian = mysqli_fetch_array($query_faktur_pembelian)) {
    $query_sum_dari_detail_pembayaran_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS ambil_total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_faktur_pembelian[no_faktur]' ");
    $data_sum_dari_detail_pembayaran_hutang = mysqli_fetch_array($query_sum_dari_detail_pembayaran_hutang);
    $jumlah_bayar_hutang = $jumlah_bayar_hutang + $data_sum_dari_detail_pembayaran_hutang['ambil_total_bayar'];
  }
// LOGIKA UNTUK  UNTUK AMBIL  BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

}
else{

// LOGIKA UNTUK AMBIL BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)
  $query_sum_dari_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian,SUM(total) AS total_akhir, SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 AND suplier = '$suplier' ");
  $data_sum_dari_pembelian = mysqli_fetch_array($query_sum_dari_pembelian);

  $query_faktur_pembelian = $db->query("SELECT no_faktur FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 AND suplier = '$suplier' ");
  while ($data_faktur_pembelian = mysqli_fetch_array($query_faktur_pembelian)) {
    $query_sum_dari_detail_pembayaran_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS ambil_total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_faktur_pembelian[no_faktur]' ");
    $data_sum_dari_detail_pembayaran_hutang = mysqli_fetch_array($query_sum_dari_detail_pembayaran_hutang);
    $jumlah_bayar_hutang = $jumlah_bayar_hutang + $data_sum_dari_detail_pembayaran_hutang['ambil_total_bayar'];
  }
// LOGIKA UNTUK  UNTUK AMBIL  BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

}

$total_akhir = $data_sum_dari_pembelian['total_akhir'];
$total_kredit = $data_sum_dari_pembelian['total_kredit'];
$total_bayar = $data_sum_dari_pembelian['tunai_pembelian'] +  $jumlah_bayar_hutang;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array(
// datatable column index  => database column name

  0 => 'Tanggal', 
  1 => 'Nomor',
  2 => 'nama_kostumer',
  3 => 'sales',
  4 => 'nilai_faktur', 
  5 => 'dibayar',
  6 => 'piutang',

);

if ($suplier == "semua") {
  // getting total number records without any search
  $sql =" SELECT p.id,s.nama,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ,p.no_faktur,p.suplier,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit ,p.nilai_kredit";
  $sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0 ";
}
else{
  // getting total number records without any search
  $sql =" SELECT p.id,s.nama,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ,p.no_faktur,p.suplier,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit ,p.nilai_kredit";
  $sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0 AND p.suplier = '$suplier'";
}

$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if ($suplier == "semua") {
  // getting total number records without any search
  $sql =" SELECT p.id,s.nama,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ,p.no_faktur,p.suplier,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit ,p.nilai_kredit";
  $sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0 ";
}
else{
  // getting total number records without any search
  $sql =" SELECT p.id,s.nama,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ,p.no_faktur,p.suplier,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit ,p.nilai_kredit";
  $sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0 AND p.suplier = '$suplier'";
}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";
  
}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.="ORDER BY p.waktu_input DESC  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


$query_nilai_bayar_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$row[no_faktur]' ");
$data_nilai_bayar_hutang = mysqli_fetch_array($query_nilai_bayar_hutang);

$query_sum_tunai_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian FROM pembelian WHERE no_faktur = '$row[no_faktur]' ");
$data_sum_tunai_pembelian = mysqli_fetch_array($query_sum_tunai_pembelian);

$jumlah_bayar_awal = $data_sum_tunai_pembelian['tunai_pembelian'];

$jumlah_nilai_bayar_hutang = mysqli_num_rows($query_nilai_bayar_hutang);

$tot_bayar = $data_nilai_bayar_hutang['total_bayar'] + $jumlah_bayar_awal;
$sisa_kredit = $row['nilai_kredit'] - $data_nilai_bayar_hutang['total_bayar'];

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['nama'];
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['tanggal_jt'];
      $nestedData[] = "<p align='right'> ".rp($row['usia_hutang'])." Hari</p>";
      $nestedData[] = "<p align='right'> ".rp($row['total'])."</p>";

      if ($jumlah_nilai_bayar_hutang > 0 )
      {
        $nestedData[] = "<p align='right'> ".rp($tot_bayar)."</p>";
      }
      else
      {
        $nestedData[] = "0";

      }

      if ($sisa_kredit < 0 ) {
        # code...
         $nestedData[] = 0;
      }
      else {
        $nestedData[] = "<p align='right'> ".rp($sisa_kredit)."</p>";
      }
     

  $data[] = $nestedData;
}


$nestedData=array();      




      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red' align='right'> - </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_akhir)." </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_bayar)." </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_kredit)." </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
  
  $data[] = $nestedData;
  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>