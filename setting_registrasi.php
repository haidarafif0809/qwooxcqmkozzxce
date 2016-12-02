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


<h3><b> SETTING REGISTRASI </b></h3> <hr>

<br>
<br>


<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered">
 
    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white; width: 50%'>Tampil Tanda Tanda Vital </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Tampil Data Pasien Umum </th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM setting_registrasi ORDER BY id DESC");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id']."'>";
      if ($data['tampil_ttv'] == 1) {
        echo"<td class='edit-ttv' data-id='".$data['id']."'><span id='text-ttv-".$data['id']."'>Tampil</span>
      <select style='display:none' id='select-ttv-".$data['id']."' value='".$data['tampil_ttv']."' class='select-ttv' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="1">Tampil</option>';
      
      echo '<option value="0">Tidak</option>';
      
      
      
      echo  '</select>
      </td>';

      }
      else
      {
      echo"<td class='edit-ttv' data-id='".$data['id']."'><span id='text-ttv-".$data['id']."'>Tidak</span>
      <select style='display:none' id='select-ttv-".$data['id']."' value='".$data['tampil_ttv']."' class='select-ttv' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="1">Tampil</option>';
      
      echo '<option value="0">Tidak</option>';
      
      
      
      echo  '</select>
      </td>';
      }
      if ($data['tampil_data_pasien_umum'] == 1) {
      echo"<td class='edit-dpu' data-id='".$data['id']."'><span id='text-dpu-".$data['id']."'>Tampil</span>
      <select style='display:none' id='select-dpu-".$data['id']."' value='".$data['tampil_data_pasien_umum']."' class='select-dpu' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="1">Tampil</option>';
      
      echo '<option value="0">Tidak</option>';
      
      
      
      echo  '</select>
      </td>';
      }
      else
      {
      echo"<td class='edit-dpu' data-id='".$data['id']."'><span id='text-dpu-".$data['id']."'>Tidak</span>
      <select style='display:none' id='select-dpu-".$data['id']."' value='".$data['tampil_data_pasien_umum']."' class='select-dpu' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="1">Tampil</option>';
      
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
                                 
                                 $(".edit-dpu").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-dpu-"+id+"").hide();

                                    $("#select-dpu-"+id+"").show();

                                 });

                                 $(".select-dpu").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_tampil = $(this).val();



                                    $.post("update_setting_registrasi.php",{id:id, select_tampil:select_tampil,jenis_select:"dpu"},function(data){

                                    if (select_tampil == 1) {
                                      select_tampil = 'Tampil';
                                    }
                                    else
                                    {
                                      select_tampil = 'Tidak';
                                    }
                                    $("#text-dpu-"+id+"").show();
                                    $("#text-dpu-"+id+"").text(select_tampil);

                                    $("#select-dpu-"+id+"").hide();           

                                    });
                                 });

                             </script>

    <script type="text/javascript">
                                 
                                 $(".edit-ttv").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-ttv-"+id+"").hide();

                                    $("#select-ttv-"+id+"").show();

                                 });

                                 $(".select-ttv").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_tampil = $(this).val();


                                    $.post("update_setting_registrasi.php",{id:id, select_tampil:select_tampil,jenis_select:"ttv"},function(data){


                                    if (select_tampil == 1) {
                                      select_tampil = 'Tampil';
                                    }
                                    else
                                    {
                                      select_tampil = 'Tidak';
                                    }
                                    
                                    $("#text-ttv-"+id+"").show();
                                    $("#text-ttv-"+id+"").text(select_tampil);

                                    $("#select-ttv-"+id+"").hide();           

                                    });
                                 });

                             </script>
<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->


  