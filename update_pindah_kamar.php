<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

 $reg = stringdoang($_POST['reg_before']); 
 $bed_before = stringdoang($_POST['bed_before']); 
 $group_bed_before = stringdoang($_POST['group_bed_before']); 
 $group_bed2 = stringdoang($_POST['group_bed2']); 
 $bed2 = stringdoang($_POST['bed2']); 
 $id = angkadoang($_POST['id']);
 $lama_inap = angkadoang($_POST['lama_inap']);


$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");



$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

$q = $db->query("SELECT * FROM setting_registrasi");
$dq = mysqli_fetch_array($q);

$pilih_akses_registrasi_ri = $db->query("SELECT registrasi_ri_lihat, registrasi_ri_tambah, registrasi_ri_edit, registrasi_ri_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ri = mysqli_fetch_array($pilih_akses_registrasi_ri);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ri_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


$update_reg = $db->query("UPDATE registrasi SET bed = '$bed2', group_bed = '$group_bed2' WHERE no_reg = '$reg'");

$update_kamar = $db->query("UPDATE bed SET sisa_bed = sisa_bed + 1 WHERE nama_kamar = '$bed_before' AND group_bed = '$group_bed_before'");

$up_bed = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed2' AND group_bed = '$group_bed2'");


// ambil penjamin dari registrasi
$regis = $db->query("SELECT penjamin FROM registrasi WHERE no_reg = '$reg' ");
$keluar2 = mysqli_fetch_array($regis);
// ambil penjamin dari registrasi


// ambil bahan untuk kamar 
$query20 = $db->query(" SELECT * FROM penjamin WHERE nama = '$keluar2[penjamin]'");
$data20  = mysqli_fetch_array($query20);
$level_harga = $data20['harga'];


$cari_harga_kamar = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '$bed2' AND group_bed = '$group_bed2' ");
$kamar_luar = mysqli_fetch_array($cari_harga_kamar);
$harga_kamar1 = $kamar_luar['tarif'];
$harga_kamar2 = $kamar_luar['tarif_2'];
$harga_kamar3 = $kamar_luar['tarif_3'];
$harga_kamar4 = $kamar_luar['tarif_4'];
$harga_kamar5 = $kamar_luar['tarif_5'];
$harga_kamar6 = $kamar_luar['tarif_6'];
$harga_kamar7 = $kamar_luar['tarif_7'];

//end bahan untuk kamar

$ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'BED'");
$b = mysqli_fetch_array($ambil_satuan);
$satuan_bed = $b['id'];


$select_regitrasi = $db->query("SELECT tanggal FROM registrasi WHERE no_reg = '$reg' ");
$array = mysqli_fetch_array($select_regitrasi);

if($array['tanggal'] == $tanggal_sekarang)
{
$delete_bed_lama = $db->query("DELETE FROM tbs_penjualan WHERE kode_barang = '$bed_before' AND no_reg = '$reg' ");
}
else
{
  $update_tbs_kamr = $db->query("UPDATE tbs_penjualan SET jumlah_barang = '$lama_inap' WHERE kode_barang = '$bed_before' AND no_reg = '$reg'");
}


// harga_1 (pertama)
if ($level_harga == 'harga_1')
    {

$subtotal = 1 * $harga_kamar1;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar1','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


    }
//end harga_1 (pertama)

// harga_2 (pertama)
else if ($level_harga == 'harga_2')
{

$subtotal = 1 * $harga_kamar2;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar2','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
//end harga_2 (pertama)


// harga_3 (pertama)
else if ($level_harga == 'harga_3')
{

$subtotal = 1 * $harga_kamar3;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar3','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}

// harga_3 (pertama)
else if ($level_harga == 'harga_4')
{

$subtotal = 1 * $harga_kamar4;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar4','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}

// harga_3 (pertama)
else if ($level_harga == 'harga_5')
{

$subtotal = 1 * $harga_kamar5;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar5','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}

// harga_3 (pertama)
else if ($level_harga == 'harga_6')
{

$subtotal = 1 * $harga_kamar6;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar6','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}

// harga_3 (pertama)
else if ($level_harga == 'harga_7')
{

$subtotal = 1 * $harga_kamar7;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar7','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}

?>
  <?php 
$query7 = $db->query("SELECT * FROM registrasi WHERE jenis_pasien = 'Rawat Inap' AND status = 'menginap' AND status != 'Batal Rawat Inap' AND id = '$id' ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_array($query7);
      
      echo "<tr class='tr-id-".$data['id']."'>";

        if ($registrasi_ri['registrasi_ri_hapus']) {
          echo "<td><button  class='btn btn-floating btn-small btn-info' id='batal_ranap' data-reg='". $data['no_reg']. "' data-id='". $data['id']. "'><i class='fa fa-remove'></i> </button></td>";
        }
        else{
          echo "<td> </td>";
        }

        if ($penjualan['penjualan_tambah'] > 0) {
                 
                 $query_z = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$data[no_reg]' ");
                 $data_z = mysqli_fetch_array($query_z);
                 
                 if ($data_z['status'] == 'Simpan Sementara') {
                 
                 echo "<td> <a href='proses_pesanan_barang_ranap.php?no_faktur=".$data_z['no_faktur']."&no_reg=".$data['no_reg']."&kode_pelanggan=".$data['no_rm']."&nama_pelanggan=".$data_z['nama']."&kode_gudang=".$data_z['kode_gudang']."'class='btn btn-floating btn-small btn btn-danger'><i class='fa fa-credit-card'></i></a> </td>"; 
                 }
                 
                 else {
                 echo "<td><a href='form_penjualan_kasir_ranap.php?no_reg=". $data['no_reg']. "' ' class='btn btn-floating btn-small btn-info'><i class='fa fa-shopping-cart'></i></a></td>";
                 }

        }
        else{
          echo "<td> </td>";
        }

        if ($registrasi_ri['registrasi_ri_lihat']) {
          echo "<td> <button type='button' data-reg='".$data['no_reg']."' data-bed='".$data['bed']."' data-group-bed='".$data['group_bed']."' data-id='".$data['id']."' data-reg='".$data['no_reg']."'  class='btn btn-floating btn-small btn-info pindah'><i class='fa fa-reply'></i></button></td>

          <td><a href='registrasi_operasi.php?no_reg=".$data['no_reg']."&no_rm=".$data['no_rm']."&bed=".$data['bed']."&kamar=".$data['group_bed']."' class='btn btn-floating btn-small btn-danger'><i class='fa fa-plus-circle'></i></a></td>";
        }
        else{
          echo "<td> </td>";
          echo "<td> </td>";
        }          

        if ($rekam_medik['rekam_medik_ri_lihat']) {
          echo "<td><a href='rekam_medik_ranap.php' class='btn btn-floating btn-small btn-danger'><i class='fa fa-medkit'></i></a></td>";
        }
        else{          
          echo "<td> </td>";
        }

            echo "<td>". $data['no_rm']."</td>
            <td>". $data['no_reg']."</td>
            <td>". $data['status']."</td>           
            <td>". $data['nama_pasien']."</td>
            <td>". $data['jam']."</td>           
            <td>". $data['penjamin']."</td>           
            <td>". $data['poli']."</td>
            <td>". $data['dokter_pengirim']."</td>
            <td>". $data['dokter']."</td>           
            <td>". $data['bed']."</td>
            <td>". $data['group_bed']."</td>
            <td>". tanggal($data['tanggal_masuk'])."</td>            
            <td>". $data['penanggung_jawab']."</td>
            <td>". $data['umur_pasien']."</td> 

            

      </tr>";
      
      
    ?>


<script type="text/javascript">
     $(".pindah").click(function(){   
            
            var id = $(this).attr('data-id');
            var reg = $(this).attr('data-reg');
            var bed = $(this).attr('data-bed');
            var group_bed = $(this).attr('data-group-bed');
            var no_reg = $(this).attr('data-reg');

            $("#pindah_kamar").attr("data-id",id);
            $("#pindah_kamar").attr("data-reg",reg);
            $("#pindah_kamar").attr("data-bed",bed);
            $("#pindah_kamar").attr("data-group_bed",group_bed);

                $.post("pindah_kamar.php",{reg:reg,bed:bed,group_bed:group_bed},function(data){
                $("#tampil_kamar").html(data);
                $("#modal_kamar").modal('show');
          
                });
            });
</script>