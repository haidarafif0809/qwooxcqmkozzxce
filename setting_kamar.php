<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';




?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

  <div class="container">


<h3><b> SETTING PROSES KAMAR </b></h3> <hr>

<br>
<br>


<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered">
 
    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white; width: 50%'>Setting Proses Kamar </th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM setting_kamar ORDER BY id DESC");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id']."'>";
      if ($data['proses_kamar'] == 1) {
        echo"<td class='edit-kamar' data-id='".$data['id']."'><span id='text-kamar-".$data['id']."'>Masuk</span>
      <select style='display:none' id='select-kamar-".$data['id']."' value='".$data['proses_kamar']."' class='select-kamar' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="1">Masuk</option>';
      echo '<option value="0">Tidak</option>';
      
      
      
      echo  '</select>
      </td>';

      }
      else
      {
      echo"<td class='edit-kamar' data-id='".$data['id']."'><span id='text-kamar-".$data['id']."'>Tidak</span>
      <select style='display:none' id='select-kamar-".$data['id']."' value='".$data['proses_kamar']."' class='select-kamar' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="1">Masuk</option>';
      
      echo '<option value="0">Tidak</option>';
      
      
      
      echo  '</select>
      </td>';
      }
     
 
     echo"</tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada  Kolom  jika ingin mengedit.</i></h6>





</div><!--CONTAINER-->



<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

  

    <script type="text/javascript">
                                 
                                 $(".edit-kamar").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-kamar-"+id+"").hide();

                                    $("#select-kamar-"+id+"").show();

                                 });

                                 $(".select-kamar").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_tampil = $(this).val();


                                    $.post("update_setting_kamar.php",{id:id, select_tampil:select_tampil,jenis_select:"kamar"},function(data){


                                    if (select_tampil == 1) {
                                      select_tampil = 'Masuk';
                                    }
                                    else
                                    {
                                      select_tampil = 'Tidak';
                                    }
                                    
                                    $("#text-kamar-"+id+"").show();
                                    $("#text-kamar-"+id+"").text(select_tampil);

                                    $("#select-kamar-"+id+"").hide();           

                                    });
                                 });

                             </script>
<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->


  