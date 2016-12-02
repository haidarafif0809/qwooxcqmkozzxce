<?php 
include 'db.php';
include 'sanitasi.php';

$kelas_kamar = stringdoang($_POST['kelas_kamar']);
$operasi = stringdoang($_POST['operasi']);
$cito = stringdoang($_POST['cito']); 
$waktu = date('Y-m-d H:i:s');
$petugas_input = stringdoang($_POST['petugas_input']);
$no_reg = stringdoang($_POST['no_reg']);
$session_id = stringdoang($_POST['session_id']);

$select = $db->query("SELECT id_sub_operasi,harga_jual FROM sub_operasi WHERE id_operasi = '$operasi' AND id_cito = '$cito' AND id_kelas_kamar = '$kelas_kamar'");

while($out = mysqli_fetch_array($select))
{

$id_sub = $out['id_sub_operasi'];

$harga = $out['harga_jual'];

$insert_tbs_utama = $db->prepare("INSERT INTO tbs_operasi (session_id, operasi, sub_operasi, petugas_input, harga_jual, waktu, no_reg) VALUES (?,?,?,?,?,?,?)");

$insert_tbs_utama->bind_param("ssssiss", $session_id, $operasi, $id_sub, $petugas_input, $harga, $waktu, $no_reg);

$insert_tbs_utama->execute();

if (!$insert_tbs_utama) {
die('Query Error : '.$db->errno.
' - '.$db->error);
 }
 else 
 {
    
 }

}

// tampilkan input data
     $utama = $db->query("SELECT * FROM tbs_operasi WHERE no_reg = '$no_reg' ORDER BY id DESC LIMIT 1");
   while($next = mysqli_fetch_array($utama))      
    {
       // ambil nama operasi
      $select_op = $db->query("SELECT nama_operasi,id_operasi FROM operasi ");
      while($get_nama = mysqli_fetch_array($select_op))
      {
        if ($next['operasi'] == $get_nama['id_operasi'])
        {
          $nama_operasinya = $get_nama['nama_operasi'];
        }
      }

      // ambil nama user

      $select_user = $db->query("SELECT nama,id FROM user ");
      while($use = mysqli_fetch_array($select_user))
      {
        if ($next['petugas_input'] == $use['id'])
        {
        $nama_user = $use['nama'];
        }
      }
    echo "<tr class='tr-id-".$next['id']."'>

        <td>". $next['no_reg']."</td>
        <td>". $nama_operasinya."</td>
        <td>Rp. ". rp($next['harga_jual'])."</td>
        <td>". $nama_user."</td>
        <td>". $next['waktu']."</td>";

// cek data di detail agar sama 
$cek_detail = $db->query("SELECT * FROM tbs_detail_operasi WHERE no_reg = '$no_reg' AND id_tbs_operasi = '$next[id]'");
$out_detail = mysqli_num_rows($cek_detail);

if($out_detail > 0)
{

echo "<td><a href='proses_registrasi_operasi.php?id=".$next["id"]."&no_reg=".$next["no_reg"]."&sub_operasi=".$next["sub_operasi"]."&operasi=".$next["operasi"]."' class='btn btn-warning'><i class='fa fa-plus'></i> </a></td>";

}
else
{

echo "<td><a href='proses_registrasi_operasi.php?id=".$next["id"]."&no_reg=".$next["no_reg"]."&sub_operasi=".$next["sub_operasi"]."&operasi=".$next["operasi"]."' class='btn btn-success'><i class='fa fa-chevron-right'></i> </a></td>";
}
   echo" <td><button data-id='".$next['id']."' data-operasi='".$next['operasi']."' data-sub-operasi='".$next['sub_operasi']."'  class='btn btn-danger delete'><i class='fa fa-trash'></i> </button>
    </td>
    </tr>";
    }

    mysqli_close($db); 


 ?>

 
<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  var operasi = $(this).attr('data-operasi');
  var sub = $(this).attr('data-sub-operasi');

  $("#modale-delete").modal('show');
  $("#id_edit").val(id);
  $("#or_edit").val(operasi);  
  $("#sub_edit").val(sub);  

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_edit").val();
var or = $("#or_edit").val();
var sub = $("#sub_edit").val();

$.post('delete_registrasi_operasi.php',{id:id,or:or,sub:sub},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->
