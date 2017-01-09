<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$jumlah_total_bersih = $db->query("SELECT SUM(total) AS total_bersih FROM penjualan");
$ambil = mysqli_fetch_array($jumlah_total_bersih);

$sub_total_bersih = $ambil['total_bersih'];


$jumlah_total_kotor = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan");
$ambil_kotor = mysqli_fetch_array($jumlah_total_kotor);

$sub_total_kotor = $ambil_kotor['total_kotor'];

$jumlah_potongan = $db->query("SELECT SUM(potongan) AS total_potongan FROM penjualan");
$ambil_potongan = mysqli_fetch_array($jumlah_potongan);

$sub_total_potongan = $ambil_potongan['total_potongan'];

$jumlah_total_tax = $db->query("SELECT SUM(tax) AS total_tax FROM penjualan");
$ambil_tax = mysqli_fetch_array($jumlah_total_tax);

$sub_total_tax = $ambil_tax['total_tax'];

$pilih_akses_penjualan = $db->query("SELECT penjualan_lihat, penjualan_tambah, penjualan_edit, penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);


$columns = array( 
// datatable column index  => database column name


  
	0 =>'no_faktur', 
	1 =>'kode_pelanggan',
	2 =>'no_reg',
	3 =>'dokter',
	4 =>'penjamin',
	5 =>'tanggal',
	6 =>'user',
	7 =>'total',
	8 =>'jenis_penjualan',
	9 =>'status',
  10 =>'jam',
  11 => 'id'

);

// getting total number records without any search
$sql = "SELECT *";
$sql.=" FROM penjualan";
$query = mysqli_query($conn, $sql) or die("show_data_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *";
$sql.=" FROM penjualan ";
$sql.="WHERE 1=1 ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR no_reg LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR kode_pelanggan LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR nama LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR total LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR jenis_penjualan LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR penjamin LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR status LIKE '".$requestData['search']['value']."%' )";


}

$query=mysqli_query($conn, $sql) or die("show_data_penjualan.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("show_data_penjualan.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
// start EDIT

if ($penjualan['penjualan_edit'] > 0) {

  if ($row['status'] == 'Simpan Sementara') {
    $nestedData[] ="<td> </td>";
  }
  else{

        if ($row['jenis_penjualan'] == 'Rawat Jalan')
        {
        
     $nestedData[] ='<td> <a href="cek_edit_penjualan_rj.php?id='.$row["id"].'&no_faktur='.$row["no_faktur"].'&no_rm='.$row["kode_pelanggan"].'&no_reg='.$row["no_reg"].'" class="btn btn-warning btn-floating"> <i class="fa fa-edit"> </i></a></td>';
        }
        elseif ($row['jenis_penjualan'] == 'Rawat Inap')
        {
        
        
        $nestedData[] ='<td> <a href="cek_edit_penjualan_ri.php?id='.$row["id"].'&no_faktur='.$row["no_faktur"].'&no_rm='.$row["kode_pelanggan"].'&no_reg='.$row["no_reg"].'" class="btn btn-danger btn-floating"> <i class="fa fa-edit"> </i></a></td>';
        
        }
        elseif ($row['jenis_penjualan'] == 'UGD')
        {
        
       $nestedData[] ='<td> <a href="cek_edit_penjualan_ugd.php?id='.$row["id"].'&no_faktur='.$row["no_faktur"].'&no_rm='.$row["kode_pelanggan"].'&no_reg='.$row["no_reg"].'" class="btn btn-info btn-floating"> <i class="fa fa-edit"> </i></a></td>';
        
        }
        elseif ($row['jenis_penjualan'] == 'Apotek')
        {
        
        $nestedData[] ='<td> <a href="cek_edit_penjualan_apotek.php?id='.$row["id"].'&no_faktur='.$row["no_faktur"].'&no_rm='.$row["kode_pelanggan"].'" class="btn btn-success btn-floating"> <i class="fa fa-edit"> </i></a></td>';
        
        }
        elseif ($row['jenis_penjualan'] == 'Laboratorium')
        {
        
        $nestedData[] ='<td> <a href="cek_edit_penjualan_laboratorium.php?id='.$row["id"].'&no_faktur='.$row["no_faktur"].'&no_rm='.$row["kode_pelanggan"].'" class="btn btn-success btn-floating"> <i class="fa fa-edit"> </i></a></td>';
        
        }

  }


}
else{
  $nestedData[] ="<td> </td>";
}
// end EDIT


// Start Tombol Hapus

$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);

        $query_penj = $db->query("SELECT nama FROM penjualan WHERE no_faktur = '$row[no_faktur]' ");
        $data_pej = mysqli_fetch_array($query_penj);
        if ($data_pej['nama'] == 'Umum') {
          $pelanggan = 'Umum';    
        }
        else{
        $query_pel = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$row[kode_pelanggan]' ");
        $data_pelanggan = mysqli_fetch_array($query_pel);
        $pelanggan = $data_pelanggan['nama_pelanggan'];
        }

        $query_dok = $db->query("SELECT nama FROM user WHERE id = '$row[dokter]' ");
        $data_dok = mysqli_fetch_array($query_dok);

				$sum_subtotal = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan WHERE no_faktur = '$row[no_faktur]' ");

				$ambil_sum_subtotal = mysqli_fetch_array($sum_subtotal);
				$total_kotor = $ambil_sum_subtotal['total_kotor'];




  if ($penjualan_hapus > 0){

      $pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$row[no_faktur]'");
      $row_retur = mysqli_num_rows($pilih);
      
      $pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$row[no_faktur]'");
      $row_piutang = mysqli_num_rows($pilih);

// if untuk sumputin tombol Hapus
if ($row['status'] == 'Simpan Sementara') 
{
    $nestedData[] ="<td> </td>";
}
else
{
      if ($row_retur > 0 || $row_piutang > 0) {
      
     $nestedData[] ="<td> <button class='btn btn-danger btn-floating btn-alert' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."'> <i class='fa fa-trash'> </i></button></td>";
      
      } 
      
      else {
      
     $nestedData[] =" <td> <button class='btn btn-danger btn-floating btn-hapus' data-id='".$row['id']."' data-pelanggan='".$row['kode_pelanggan']."' data-faktur='".$row['no_faktur']."' kode_meja='".$row['kode_meja']."'> <i class='fa fa-trash'> </i></button></td>";
      }

}

    }
// End Tombol Hapus

// Tampilan Detail
$nestedData[] = "<td><button class='btn btn-floating  btn-info detail-penjualan' data-faktur='".$row['no_faktur']."' data-id='".$row['id']."' data-reg='".$row['no_reg']."'><i class='fa fa-list'></i></button></td>";


// Cetak Tunai
if ($row['status'] == 'Lunas') {
$nestedData[] ='<td>
<div class="dropdown">

    <button class="btn btn-success btn-floating dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-print"> </i>
    </button>

    <div class="dropdown-menu dropdown-primary" aria-labelledby="dropdownMenu4" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

        <a class="dropdown-item" href="cetak_ulang_penjualan_detail.php?no_faktur='.$row["no_faktur"].'&id='.$row["id"].'">Print Detail</a>

        <a class="dropdown-item" href="cetak_ulang_penjualan_kategori.php?no_faktur='.$row["no_faktur"].'">Print Kategori</a>

        <a class="dropdown-item" href="cetak_penjualan_tunai.php?no_faktur='.$row["no_faktur"].'">Print Penjualan Post</a>

        <a class="dropdown-item" href="cetak_penjualan_tunai_besar.php?no_faktur='.$row["no_faktur"].'">Print Penjualan Besar</a>

    </div>
</div>
 </td>';
}
else
{
  $nestedData[] ="<td></td>";
}
// End Cetak Tunai

// Start Cetak Piutang
if ($row['status'] == 'Piutang') {
  $nestedData[] ="<td> <a href='cetak_lap_penjualan_piutang.php?no_faktur=".$row['no_faktur']."' id='cetak_piutang' class='btn btn-warning btn-floating' target='blank'><i class='fa fa-print'> </i></a> </td>";
}
else
{
  $nestedData[] ="<td>  </td>";
}
// end cetak piutang


	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["kode_pelanggan"];
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $pelanggan;
	$nestedData[] = $data_dok['nama'];
	$nestedData[] = $row["penjamin"];
  $nestedData[] = tanggal_terbalik($row["tanggal"]);
  $nestedData[] = $row["jam"];
	$nestedData[] = $row["user"];
	$nestedData[] = rp($row["total"]);
	$nestedData[] = $row["jenis_penjualan"];
	$nestedData[] = $row["status"];
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
