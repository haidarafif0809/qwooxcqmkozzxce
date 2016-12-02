<?php 
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);
$kode = stringdoang($_POST['kode_jasa']);
$nama = stringdoang($_POST['nama_jasa']);
$harga_1 = angkadoang($_POST['harga_1']);
$harga_2 = angkadoang($_POST['harga_2']);
$harga_3 = angkadoang($_POST['harga_3']);
$harga_4 = angkadoang($_POST['harga_4']);
$harga_5 = angkadoang($_POST['harga_5']);
$harga_6 = angkadoang($_POST['harga_6']);
$harga_7 = angkadoang($_POST['harga_7']);
$bidang = stringdoang($_POST['bidang']);
$persiapan = stringdoang($_POST['persiapan']);
$metode = stringdoang($_POST['metode']);


    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE jasa_lab SET kode_lab = ? , nama = ? ,harga_1 = ? , harga_2 = ?, harga_3 = ?,harga_4 = ? ,harga_5 = ?, harga_6 = ?, harga_7 = ?, bidang = ?, persiapan = ?, metode = ?  WHERE id = ? ");
    
    $query->bind_param("ssiiiiiiisssi",
    	$kode,$nama,$harga_1,$harga_2,$harga_3,$harga_4,$harga_5,$harga_6,$harga_7,$bidang,$persiapan,$metode,$id);


    $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   
}


$query = $db->query("SELECT bl.nama AS nambid,jl.id,jl.bidang,jl.kode_lab,jl.nama,jl.persiapan,jl.metode,jl.harga_1,jl.harga_2,jl.harga_3,jl.harga_4,jl.harga_5,jl.harga_6,jl.harga_7 FROM jasa_lab jl INNER JOIN bidang_lab bl ON jl.bidang = bl.id  WHERE kode_lab = '$kode' AND jl.id = '$id' ORDER BY id DESC LIMIT 1");
   $data = mysqli_fetch_array($query);
      
      
       echo 
       "<tr class='tr-id-".$data['id']."'>
       <td>". $data['kode_lab']."</td>
       <td>". $data['nama']."</td>
       <td>". $data['nambid']."</td>
       <td>". $data['persiapan']."</td>
       <td>". $data['metode']."</td>
       <td>". $data['harga_1']."</td>
       <td>". $data['harga_2']."</td>
       <td>". $data['harga_3']."</td>
       <td>". $data['harga_4']."</td>
       <td>". $data['harga_5']."</td>
       <td>". $data['harga_6']."</td>  
       <td>". $data['harga_7']."</td>     

      <td><button type='button' data-toggle='modal' data-target='#modal_edit' class='btn btn-warning btn-edit'
       data-id='".$data['id']."'  data-kode_lab='".$data['kode_lab']."'  data-nama='".$data['nama']."'  data-bidang='".$data['bidang']."' data-persiapan='".$data['persiapan']."' data-metode='".$data['metode']."' data-harga_1='".$data['harga_1']."' data-harga_2='".$data['harga_2']."' data-harga_3='".$data['harga_3']."' data-harga_4='".$data['harga_4']."' data-harga_5='".$data['harga_5']."' data-harga_6='".$data['harga_6']."' data-harga_7='".$data['harga_7']."'>Edit </button>
      </td>
      <td><button  type='button' data-toggle='modal' data-target='#modal_hapus' data-id='".$data['id']."' data-nama='".$data['nama']."' class='btn btn-danger delete'>Hapus </button>
      </td>
      </tr>";
      
  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);  


 ?>
<!--   script modal confirmasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_hapus").val();
    
    $("#modal_hapus").modal('hide');
    $(".tr-id-"+id+"").remove();
    $.post('delete_jasa_lab.php',{id:id},function(data){

    });

});
</script>