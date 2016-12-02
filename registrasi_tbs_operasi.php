<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$session_id = $_POST['session_id'];    
$detail_operasi = stringdoang($_POST['detail_operasi']);
$petugas = stringdoang($_POST['petugas']);
$waktu = date('Y-m-d H:i:s');
$user_input = $_SESSION['id'];
$no_reg = stringdoang($_POST['no_reg']);
$id_before = stringdoang($_POST['id_before']);
$sub_before = stringdoang($_POST['sub_before']);
$or_utama = stringdoang($_POST['or_utama']);

$tbs_detail_or = $db->prepare("INSERT INTO tbs_detail_operasi (session_id, id_detail_operasi, id_user, id_sub_operasi,id_operasi, waktu, petugas_input, no_reg, id_tbs_operasi) VALUES (?,?,?,?,?,?,?,?,?)");

    $tbs_detail_or->bind_param("sssssssss",
    $session_id, $detail_operasi, $petugas, $sub_before, $or_utama, $waktu, $user_input, $no_reg, $id_before);
  

$tbs_detail_or->execute();
if (!$tbs_detail_or) {
die('Query Error : '.$db->errno.
' - '.$db->error);
 }
 else 
 {
         
 }

// tampikan input
     $query = $db->query("SELECT * FROM tbs_detail_operasi WHERE no_reg = '$no_reg' ORDER BY id DESC LIMIT 1");
   while($data = mysqli_fetch_array($query))      
    {
       // menampilkan seluruh data yang ada pada tabel suplier
      $show_nama_detail_operasi = $db->query("SELECT * FROM detail_operasi WHERE id_detail_operasi = '$data[id_detail_operasi]'");
      
      // menyimpan data sementara yang ada pada $query
      while($show_nama = mysqli_fetch_array($show_nama_detail_operasi))
      {
        $namanya = $show_nama['nama_detail_operasi'];
      }

      // nama user
       $select_user = $db->query("SELECT nama,id FROM user ");
        while($use = mysqli_fetch_array($select_user))
        {
        if ($data['petugas_input'] == $use['id'])
        {
        $nama_user = $use['nama'];
        }
        }

  // nama user operasi
   $petugs = $db->query("SELECT nama,id FROM user ");
      while($use_pt = mysqli_fetch_array($petugs))
      {
        if ($data['id_user'] == $use_pt['id'])
        {
        $nama_pt_or = $use_pt['nama'];
        }
      }

    echo "<tr class='tr-id-".$data['id']."'>

        <td>". $data['no_reg']."</td>
        <td>". $namanya."</td>
        <td>". $nama_pt_or."</td>
        <td>". $nama_user."</td>
        <td>". $data['waktu']."</td>

    <td><button data-id='".$data['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i> </button>
    </td>
    </tr>";
    }

mysqli_close($db); 
 ?>
 
<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');

  $("#modale-delete").modal('show');
  $("#id_edit").val(id);  

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_edit").val();

$.post('delete_reg_detail_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->
