<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$token = stringdoang($_POST['token']);

$pilih_akses_registrasi_ugd = $db->query("SELECT registrasi_ugd_lihat, registrasi_ugd_tambah, registrasi_ugd_edit, registrasi_ugd_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ugd = mysqli_fetch_array($pilih_akses_registrasi_ugd);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ugd_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


// start data agar tetap masuk 
try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown
 // begin data

if ($token == '')
{
  
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';

}
else
{
$petugas = stringdoang($_SESSION['nama']);
$no_rm = stringdoang($_POST['no_rm']);
$nama_pasien =  stringdoang($_POST['nama_pasien']);
$alamat = stringdoang($_POST['alamat']);
$no_hp = angkadoang($_POST['no_hp']);
$umur = stringdoang($_POST['umur']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$gol_darah = stringdoang($_POST['gol_darah']);
$penjamin = stringdoang($_POST['penjamin']);
$pengantar = stringdoang($_POST['pengantar']);
$nama_pengantar = stringdoang($_POST['nama_pengantar']);
$hp_pengantar = angkadoang($_POST['hp_pengantar']);
$alamat_pengantar = stringdoang($_POST['alamat_pengantar']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$keterangan = stringdoang($_POST['keterangan']);
$kondisi = stringdoang($_POST['kondisi']);
$dokter_jaga = stringdoang($_POST['dokter_jaga']);
$rujukan = stringdoang($_POST['rujukan']);
$eye = stringdoang($_POST['eye']);
$verbal = stringdoang($_POST['verbal']);
$motorik = stringdoang($_POST['motorik']);
$alergi = stringdoang($_POST['alergi']);



$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d ");
$waktu = date("Y-m-d H:i:s");

$bulan_php = date('m');
$tahun_php = date('Y');

$select_to = $db->query("SELECT nama_pasien,no_rm FROM registrasi WHERE jenis_pasien = 'UGD' ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_pasien AND $keluar['no_rm'] == $no_rm)
{


}

else{


                                          // START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA
// START UNTUK NO REG 
//ambil 2 angka terakhir dari tahun sekarang 

 $tahun_terakhir = substr($tahun_php, 2);
//ambil bulan sekarang



 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_reg FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_reg'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_php) {
  # code...
 $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

 $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


 }
 // AKHIR UNTUK NO REG
                      // END UNTUK AMBIL NO REG LEWAT PROSES SAJA




$sql6 = $db->prepare("INSERT INTO registrasi (eye,verbal,motorik,alergi,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal,
	kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,keterangan,dokter,pengantar_pasien,
	nama_pengantar,hp_pengantar,alamat_pengantar,hubungan_dengan_pasien,hp_pasien,jenis_pasien)
	 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

 $sql6->bind_param("ssssssssssssssssssssssssss", $eye,$verbal,$motorik,$alergi,$nama_pasien,$jam,$penjamin,$ug_stat,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$petugas,$alamat,$umur,$jenis_kelamin,$rujukan,$keterangan,$dokter_jaga,$pengantar,$nama_pengantar,
  $hp_pengantar,$alamat_pengantar,
  $hubungan_dengan_pasien,$no_hp,$ug_me);

 $ug_me = 'UGD';
 $ug_stat = 'Masuk Ruang UGD';


$sql6->execute();


// UPDATE PASIEN NYA
$update_pasien = "UPDATE pelanggan SET gol_darah = '$gol_darah', umur = '$umur', no_telp = '$no_hp', alamat_sekarang = '$alamat', penjamin = '$penjamin' WHERE kode_pelanggan = '$no_rm'";
if ($db->query($update_pasien) === TRUE) 
  {
} 
else 
    {
    echo "Error: " . $update_pasien . "<br>" . $db->error;
    }



$query11 = $db->prepare("INSERT INTO rekam_medik_ugd (tanggal,jam,no_reg,no_rm,nama,jenis_kelamin,umur,alamat,eye,verbal,motorik,rujukan,
  pengantar,alergi,keadaan_umum,dokter,petugas)
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query11->bind_param("sssssssssssssssss", $tanggal_sekarang,$jam,$no_reg,$no_rm,$nama_pasien,$jenis_kelamin,$umur,$alamat,$eye,$verbal,$motorik,
  $rujukan,$pengantar,$alergi,$kondisi,$dokter_jaga,$petugas);

$query11->execute();



} // biar gk double 
} // token
      


// Countinue data 
   // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 

//untuk otoritas akses
$pilih_akses_registrasi_rj = $db->query("SELECT registrasi_rj_lihat, registrasi_rj_tambah, registrasi_rj_edit, registrasi_rj_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_rj = mysqli_fetch_array($pilih_akses_registrasi_rj);

$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

$pilih_akses_registrasi_ugd = $db->query("SELECT registrasi_ugd_lihat, registrasi_ugd_tambah, registrasi_ugd_edit, registrasi_ugd_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ugd = mysqli_fetch_array($pilih_akses_registrasi_ugd);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ugd_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 => 'no_reg', 
  1 => 'no_rm',
  2 => 'penjamin',
  3 => 'nama_pasien',
  4 => 'jenis_kelamin',
  5 => 'umur_pasien',
  6 => 'hp_pasien',
  7 => 'keterangan',
  8 => 'dokter',
  9 => 'pengantar_pasien',
  10 => 'nama_pengantar',
  11 => 'hp_pengantar',
  12 => 'tanggal',
  13 => 'alamat_pengantar',
  14 => 'hubungan_dengan_pasien',
  15 => 'status',
  16 => 'id'
);

// getting total number records without any search
$sql = "SELECT no_reg,no_rm,penjamin,nama_pasien,jenis_kelamin,umur_pasien,hp_pasien,keterangan,dokter,pengantar_pasien,nama_pengantar,hp_pengantar,tanggal,alamat_pengantar,hubungan_dengan_pasien,id,status ";
$sql.=" FROM registrasi WHERE jenis_pasien = 'UGD' AND status = 'Masuk Ruang UGD' AND status != 'Batal UGD' AND status != 'Rujuk Rumah Sakit' AND TO_DAYS(NOW()) - TO_DAYS(tanggal) <= 7";

$query=mysqli_query($conn, $sql) or die("datatable_registrasi_ugd.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT no_reg,no_rm,penjamin,nama_pasien,jenis_kelamin,umur_pasien,hp_pasien,keterangan,dokter,pengantar_pasien,nama_pengantar,hp_pengantar,tanggal,alamat_pengantar,hubungan_dengan_pasien,id,status ";
$sql.=" FROM registrasi WHERE 1=1 AND jenis_pasien = 'UGD' AND status = 'Masuk Ruang UGD' AND status != 'Batal UGD' AND status != 'Rujuk Rumah Sakit' AND TO_DAYS(NOW()) - TO_DAYS(tanggal) <= 7";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( nama_pasien LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR no_reg LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR no_rm LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_registrasi_ugd.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("datatable_registrasi_ugd.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

  $query_z = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$row[no_reg]' ");
    $data_z = mysqli_fetch_array($query_z);

    if ($registrasi_ugd['registrasi_ugd_hapus'] > 0) {
    $nestedData[] = "<button type='button' data-reg='".$row['no_reg']."'  data-id='".$row['id']."'  class='btn btn-floating btn-small btn-info pulang_rumah' ><b> X </b></button>";
  }
  else{
    $nestedData[] = "";
  }


  if ($penjualan['penjualan_tambah'] > 0) {

      if ($data_z['status'] == 'Simpan Sementara') {

       $nestedData[] = "<a href='proses_pesanan_barang_ugd.php?no_faktur=".$data_z['no_faktur']."&no_reg=".$row['no_reg']."&no_rm=".$row['no_rm']."&nama_pasien=".$data_z['nama']."&kode_gudang=".$data_z['kode_gudang']."'class='btn btn-floating btn-small btn btn-danger'><i class='fa fa-credit-card'></i></a>"; 
      }
      else
      {
      $nestedData[] = "<a href='form_penjualan_ugd.php?no_reg=". $row['no_reg']."' class='btn btn-floating btn-small btn-info penjualan' ><i class='fa fa-shopping-cart'></a>";

      }

    }
    else{
    $nestedData[] = "";
    }

  if ($registrasi_ugd['registrasi_ugd_lihat'] > 0) {
      $nestedData[] = "<button  type='button' data-reg='".$row['no_reg']."' data-id='".$row['id']."'  class='btn btn-floating btn-small btn-info rujuk' ><i class='fa fa-bus'></i>   </button>";

      $nestedData[] = "<button  type='button' data-reg='".$row['no_reg']."' class='btn btn-floating btn-small btn-info rujuk_ri' ><i class='fa fa-hotel'></i>   </button>";
  }
  else{
    $nestedData[] = "";
    $nestedData[] = "";
  }

  if ($rekam_medik['rekam_medik_ugd_lihat']) {
    $nestedData[] = "<a href='rekam_medik_ugd.php' class='btn btn-floating btn-small btn-info penjualan' ><i class='fa fa-medkit'></i></a>";
  }
  else{
    $nestedData[] = "";
  }

  
  $nestedData[] = $row["no_reg"];
  $nestedData[] = $row["no_rm"];
  $nestedData[] = $row["penjamin"];
  $nestedData[] = $row["nama_pasien"];
  $nestedData[] = $row["jenis_kelamin"];
  $nestedData[] = $row["umur_pasien"];
  $nestedData[] = $row["hp_pasien"];
  $nestedData[] = $row["keterangan"];
  $nestedData[] = $row["dokter"];
  $nestedData[] = $row["pengantar_pasien"];
  $nestedData[] = $row["nama_pengantar"];
  $nestedData[] = $row["hp_pengantar"];
  $nestedData[] = $row["tanggal"];
  $nestedData[] = $row["alamat_pengantar"];
  $nestedData[] = $row["hubungan_dengan_pasien"];
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
