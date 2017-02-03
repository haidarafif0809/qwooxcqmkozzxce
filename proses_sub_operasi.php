<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$id_operasi = stringdoang($_POST['id_operasi']);
$kelas_kamar = stringdoang($_POST['kelas_kamar']);
$kelas_citu = stringdoang($_POST['kelas_citu']);
$harga_jual = stringdoang($_POST['harga_jual']);

$pilih_akses_sub_operasi = $db->query("SELECT sub_operasi_tambah, sub_operasi_edit, sub_operasi_hapus, sub_operasi_lihat, detail_sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$sub_operasi = mysqli_fetch_array($pilih_akses_sub_operasi);    

$query = $db->prepare("INSERT INTO sub_operasi (id_operasi,id_kelas_kamar,id_cito,harga_jual) VALUES (?,?,?,?) ");

$query->bind_param("sssi", $id_operasi,$kelas_kamar,$kelas_citu,$harga_jual);

$query->execute();
    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
      else{

   }



$query = $db->query("SELECT * FROM sub_operasi ORDER BY id_sub_operasi DESC LIMIT 1 ");
   while($data = mysqli_fetch_array($query))    
      {

     $seelect_op = $db->query("SELECT id_operasi,nama_operasi FROM operasi");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_operasi'] == $out_op['id_operasi'])
          {
            $nama_operasi = $out_op['nama_operasi'];
          }
        }

        $select_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($out_kelas = mysqli_fetch_array($select_kelas))
        {
          if($data['id_kelas_kamar'] == $out_kelas['id'])
          {
            $kelas = $out_kelas['nama'];
          }
        }

$select_cito = $db->query("SELECT id,nama FROM cito");
        while($out_cito = mysqli_fetch_array($select_cito))
        {
          if($data['id_cito'] == $out_cito['id'])
          {
            $cito = $out_cito['nama'];
          }
        }

      echo "<tr class='tr-id-".$data['id_sub_operasi']."'>

            <td>". $nama_operasi ."</td>
            <td>". $kelas ."</td>
            <td>". $cito ."</td>
            <td> ". rp($data['harga_jual']) ."</td>";

if ($sub_operasi['detail_sub_operasi_lihat'] > 0) {
  echo "<td><a href='detail_operasi.php?id=".$data["id_sub_operasi"]."&nama_operasi=".$nama_operasi."&kelas=".$kelas."&cito=".$cito."&harga_jual=".$data["harga_jual"]."&id_operasi=".$data["id_operasi"]."' class='btn btn-success'>Detail Operasi </a></td>";
}
else{
  echo "<td> </td>";
}

if ($sub_operasi['sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id-sub='". $data['id_sub_operasi'] ."' data-id-op='". $nama_operasi ."' data-id-kelas='". $data['id_kelas_kamar'] ."' data-id-cito='". $data['id_cito'] ."' data-harga='". $data['harga_jual'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
    echo "<td>  </td>";
}

if ($sub_operasi['sub_operasi_hapus'] > 0) {
  echo " <td> <button class='btn btn-danger delete' data-id='". $data['id_sub_operasi'] ."' data-kelas='". $kelas ."' data-namacit='". $cito ."' data-namaoper='". $nama_operasi ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
else{
   echo " <td> </td>";
}

echo "</tr>";
}
    ?>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  var nama = $(this).attr('data-namacit');
  var kelas = $(this).attr('data-kelas');
  var namaoper = $(this).attr('data-namaoper');


  $("#modale-delete").modal('show');
  $("#id_delete").val(id);
  $("#nama_cito_delete").val(nama);
  $("#kelas_delete").val(kelas);
  $("#nama_operasi_delete").val(namaoper);

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_delete").val();

$.post('delete_sub_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  
    });

});
</script>
                            
                            

