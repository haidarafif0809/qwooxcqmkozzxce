<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$nama = stringdoang($_POST['nama']);
$kode = stringdoang($_POST['kode']);

$pilih_akses_operasi = $db->query("SELECT operasi_tambah, operasi_edit, operasi_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$operasi = mysqli_fetch_array($pilih_akses_operasi);

$query = $db->prepare("INSERT INTO operasi (kode_operasi,nama_operasi) VALUES (?,?) ");

$query->bind_param("ss", $kode,$nama);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
      else{

   }



$query = $db->query("SELECT * FROM operasi ORDER BY id_operasi DESC LIMIT 1 ");
   $data = mysqli_fetch_array($query);     
      
      echo "<tr class='tr-id-".$data['id_operasi']."'>

            <td>". $data['kode_operasi'] ."</td>";

// EDIT
      if ($operasi['operasi_edit'] > 0) {
        echo "<td class='edit-nama' data-id='".$data['id_operasi']."'>
      <span id='text-nama-".$data['id_operasi']."'>". $data['nama_operasi'] ."</span>
      <input type='hidden' id='input-nama-".$data['id_operasi']."' value='".$data['nama_operasi']."' class='input_nama' data-id='".$data['id_operasi']."' autofocus=''> </td>";
      }
      else{
        echo "<td> </td>";
      }

// SUB
 
      echo "<td><a href='sub_operasi.php?id=".$data["id_operasi"]."&nama=".$data["nama_operasi"]."' class='btn btn-success'>Sub Operasi </a></td>";
 
// HAPUS
     if ($operasi['operasi_hapus'] > 0) {
       echo "<td><button data-id='".$data['id_operasi']."' data-nama='".$data['nama_operasi']."' data-kode='".$data['kode_operasi']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>
      </td>";
     }
     else{
      echo "<td> </td>";
     }

      echo "</tr>";
    ?>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
    var nama = $(this).attr('data-nama');
    var kode = $(this).attr('data-kode');

  $("#modale-delete").modal('show');
  $("#id_hapus").val(id);  
  $("#nama_hapus").val(nama);  
  $("#kode_hapus").val(kode); 

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_hapus").val();

$.post('delete_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->
                            
                            <script type="text/javascript">
                                 
                                 $(".edit-nama").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-nama-"+id+"").hide();

                                    $("#input-nama-"+id+"").attr("type", "text");

                                 });

                                 $(".input_nama").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var input_nama = $(this).val();


                                    $.post("update_data_poli.php",{id:id, input_nama:input_nama,jenis_edit:"nama_poli"},function(data){

                                    $("#text-nama-"+id+"").show();
                                    $("#text-nama-"+id+"").text(input_nama);

                                    $("#input-nama-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

