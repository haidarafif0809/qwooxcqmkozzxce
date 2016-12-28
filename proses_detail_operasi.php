<?php include 'session_login.php';
include 'db.php';
include_once 'sanitasi.php';

$id_operasi = stringdoang($_POST['id_operasi']);
$id_sub_operasi = stringdoang($_POST['id_sub_operasi']);
$nama_operasi = stringdoang($_POST['nama_operasi']);
$jabatan = stringdoang($_POST['jabatan']);
$persentase = stringdoang($_POST['persentase']);


$query = $db->prepare("INSERT INTO detail_operasi (id_sub_operasi,nama_detail_operasi,id_jabatan,
  jumlah_persentase,id_operasi) VALUES (?,?,?,?,?) ");

$query->bind_param("ssssi", $id_sub_operasi,$nama_operasi,$jabatan,$persentase,$id_operasi);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
      else{

   }

$pilih_akses_detail_sub_operasi = $db->query("SELECT detail_sub_operasi_tambah, detail_sub_operasi_edit, detail_sub_operasi_hapus, detail_sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$detail_sub_operasi = mysqli_fetch_array($pilih_akses_detail_sub_operasi); 

 $query = $db->query("SELECT * FROM detail_operasi ORDER BY id_detail_operasi DESC LIMIT 1 ");
   $data = mysqli_fetch_array($query);    
      

         $seelect_op = $db->query("SELECT id,nama FROM jabatan");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_jabatan'] == $out_op['id'])
          {
            $jabatan = $out_op['nama'];
          }
          else
          {

          }
        }
        
      echo "<tr class='tr-id-".$data['id_detail_operasi']."'>

            <td>". $data['nama_detail_operasi'] ."</td>
            <td>". $jabatan ."</td>
            <td>". $data['jumlah_persentase'] ." %</td>";


if ($detail_sub_operasi['detail_sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id='". $data['id_detail_operasi'] ."'
  data-nama='". $data['nama_detail_operasi'] ."' data-jabatan='". $data['id_jabatan'] ."' 
  data-persentase='". $data['jumlah_persentase'] ."'>
  <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
  echo "<td> </td>";
}

if ($detail_sub_operasi['detail_sub_operasi_hapus'] > 0) {
  echo "<td> <button class='btn btn-danger delete' data-id='". $data['id_detail_operasi'] ."'
     data-nama='". $data['nama_detail_operasi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
     
echo "</tr>";

    ?>

<script type="text/javascript">
$(document).ready(function(){
 $("#persentase").keyup(function(){

   var persentase = $("#persentase").val();
   if (persentase > 100)
   {
    alert("Persentase tidak boleh lebih dari 100%");
    $("#persentase").val('');
    $("#persentase").focus();
   }
             


});
});
        
</script>



<script type="text/javascript">
$(document).ready(function(){
 $("#persentase_edit").keyup(function(){

   var persentase = $("#persentase_edit").val();
   if (persentase > 100)
   {
    alert("Persentase tidak boleh lebih dari 100%");
    $("#persentase_edit").val('');
    $("#persentase_edit").focus();
   }
             


});
});
        
</script>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  var nama = $(this).attr('data-nama');

  $("#modale-delete").modal('show');
  $("#id_delete").val(id);
  $("#nama_delete").val(nama);

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_delete").val();

$.post('delete_detail_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  
    });

});
</script>

                            
                            

