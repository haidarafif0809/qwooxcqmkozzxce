<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_GET['id']);

$select_to = $db->query("SELECT bl.nama,sh.id,sh.nama_pemeriksaan,sh.kelompok_pemeriksaan,sh.model_hitung,sh.text_reference,sh.normal_lk,sh.normal_pr,sh.metode,sh.kategori_index,sh.text_hasil,sh.satuan_nilai_normal FROM setup_hasil sh INNER JOIN bidang_lab bl ON sh.kelompok_pemeriksaan = bl.id WHERE sh.id = '$id'");
$call = mysqli_fetch_array($select_to);


?>
   <!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>
      <input type="hidden" id="id2" name="id2">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->



<div class="container">
<h3>EDIT SETUP HASIL</h3><hr>


<form role="form" action="update_setup_hasil.php" method="POST">

<div class="form-group">
  <label for="sel1">Kelompok Pemeriksaan</label>
  <select class="form-control" id="kelompok" name="kelompok"> 
<option value="<?php echo $call['kelompok_pemeriksaan']; ?>"><?php echo $call['nama']; ?></option>
  <?php 
  $query1 = $db->query("SELECT nama,id FROM bidang_lab");
  while ( $data1 = mysqli_fetch_array($query1))
  {
  echo "<option value='".$data1['id']."'>".$data1['nama']."</option>";
  }
?>
  </select>
</div>

 <span id="periksa"> 
<div class="form-group">
  <label for="sel1">Nama Pemeriksaan</label>
  <select class="form-control" id="pemeriksaan" name="pemeriksaan" required="">  
  <option value="<?php echo $call['nama_pemeriksaan']; ?>"><?php echo $call['nama_pemeriksaan']; ?></option> 
  </select>
</div>
  </span>

<div class="form-group">
  <label for="setup">Text Hasil</label>
  <input style="height: 15px" type="text" class="form-control" id="text_hasil" value="<?php echo $call['text_hasil']; ?>" name="text_hasil" autocomplete="off">
</div>

<div class="form-group">
  <label for="setup">Metode</label>
  <input type="text" class="form-control" id="metode" value="<?php echo $call['metode']; ?>" name="metode" autocomplete="off">
</div>

<div class="row">
<div class="col-sm-3">


<?php if ($call['model_hitung'] == 'Text')
{

  ?>
<div class="form-group">
  <label for="setup">Model Hitung</label>
  <select  class="form-control" id="model_hitung" name="model_hitung" autocomplete="off">
        <option value="<?php echo  $call['model_hitung'];?>"><?php echo  $call['model_hitung'];?></option>
  <option value="Numeric">Numeric</option>
  <option value="Text">Text</option>
  </select>
</div>
</div>
<?php 
}
else
{


?>
<div class="form-group">
  <label for="setup">Model Hitung</label>
  <select  class="form-control" id="model_hitung" name="model_hitung" autocomplete="off">
  <option value="Numeric">Numeric</option>
  <option value="Text">Text</option>
  </select>
</div>
</div>
<?php
}
?>
   <div class="col-sm-3">
    <div class="form-group itung" >
  <label for="setup">&nbsp;</label>

  <select  class="form-control" id="perhitungan" name="perhitungan" autocomplete="off">
      <option value="<?php echo  $call['model_hitung'];?>"><?php echo  $call['model_hitung'];?></option>

    <option value="Lebih Kecil Dari">Lebih Kecil Dari</option>
    <option value="Lebih Kecil Sama Dengan">Lebih Kecil Sama Dengan</option>
     <option value="Lebih Besar Dari">Lebih Besar Dari</option>
    <option value="Lebih Besar Sama Dengan">Lebih Besar Sama Dengan</option>
      <option value="Antara Sama Dengan">Antara Sama Dengan</option>
        </select>
</div>
  </div>

 <div class="col-sm-3">
<div class="form-group itung" >
  <label for="setup">Text Depan</label>
  <input style="height: 15px" type="text" class="form-control" id="text_depan" value="<?php echo $call['text_reference']; ?>" name="text_depan" autocomplete="off">
</div>
</div>

   <div class="col-sm-3">
<div class="form-group itung">
  <label for="setup">Satuan Nilai Normal</label>
<select class="form-control" id="satuan_nilai" placeholder="Ketik / Pilih Satuan Nilai" name="satuan_nilai" autocomplete="off">
  <option  value="<?php echo $call ['satuan_nilai_normal']; ?>"><?php echo $call['satuan_nilai_normal']; ?></option>
    <option value="mg/dL">mg/dL</option>
  <option value="mg/dL">mg/dL</option>
    <option value="g/dL">g/dL</option>
  <option value="ug/dL">ug/dL</option>
  <option value="U/L">U/L</option>
  <option value="/lp">/lp</option>
  <option value="/mL">/mL</option>
  <option value="IU/mL">IU/mL</option>
  <option value="mm/jam">mm/jam</option>
  <option value="mmol/L">mmol/L</option>
  <option value="%">%</option>
  <option value="/mm3">/mm3</option>
  <option value="seconds">seconds</option>
  </select>
</div>
</div>

</div>


<div class="row">
<div class="col-sm-5">

<div class="card card-block" style="background-color:#03a9f4 ;">

<center><h4>Nilai Normal Laki-Laki </h4></center>

<div class="row">
<div class="col-sm-5"> 


<div class="form-group nilai">
  <label for="setup" id="range"></label>
  <input style="height: 20px" type="text" class="form-control" value="<?php echo $call['normal_lk']; ?>" id="nilai_lk" name="nilai_lk" autocomplete="off">
</div>

<center> <img src="save_picture\user-laki.png" style="width:100px;">  </center>

</div>


<div class="col-sm-2">
<br>

<center> <p id="sd"> s/d  </p> </center>
 </div>
<div class="col-sm-5"> 

<div class="form-group nilai2">
  <label for="setup"></label>
  <input style="height: 20px" type="text" class="form-control" id="nilai_lk2" value="<?php echo $call['normal_lk2']; ?>" name="nilai_lk2" autocomplete="off">
</div>



</div>

 </div>



<div class="form-group">
  <label for="setup">Text</label>
  <textarea class="form-control" id="text_lk" name="text_lk" autocomplete="off"><?php echo $call['normal_lk']; ?></textarea>
</div>

</div> <!--  col sm 6 yang PERTAMA    -->

</div> <!--    PANEL BODY BG COLOR  -->

<div class="col-sm-2">
  <br>
  <br>
  <br>
  <center><h3>  Copy</h3></center>
  <br>
 <button class="btn btn-default" id="copy" type="button" style="width:100%;background-color:#000000;color:#ffffff;" ><i class="fa fa-arrow-right"></i></button> 
 <br>
  <br>
  <br>
  <br>
</div>

<div class="col-sm-5">

<div class="card card-block" style="background-color:#f48fb1;">
<center><h4>Nilai Normal Perempuan</h4></center>

<div class="row">
<div class="col-sm-5"> 

<div class="form-group nilai">
  <label for="setup" id="range1"></label>
  <input style="height: 20px" type="text" class="form-control" id="nilai_p" value="<?php echo $call['normal_pr']; ?>" name="nilai_p" autocomplete="off">
</div>

  <input type="hidden" class="form-control" id="id" value="<?php echo $id; ?>" name="id" autocomplete="off">

<center> <img src="save_picture\user-perempuan.png" style="width:100px;"> </center>


</div>

<div class="col-sm-2">
<br>

<center> <p id="sd1"> s/d  </p> </center>
 </div>


<div class="col-sm-5"> 

<div class="form-group nilai2">
  <label for="setup"></label>
  <input style="height: 20px" type="text" class="form-control" id="nilai_p2" value="<?php echo $call['normal_pr2']; ?>" name="nilai_p2" autocomplete="off">
</div>

</div>

 </div>


<div class="form-group">
  <label for="setup">Text</label>
  <textarea class="form-control" id="text_p" name="text_p" autocomplete="off"><?php echo $call['normal_pr']; ?></textarea>
</div>

</div> <!--  col sm 6 yang KEDUA    -->

</div> <!--    PANEL BODY BG COLOR  -->

</div> <!--  CLOSED ROW  -->





<div class="form-group">
  <label for="setup">Kategori Index</label>
  <select  class="form-control" id="kategori_index" name="kategori_index" autocomplete="off">
  <option value="<?php echo $call['kategori_index']; ?>"><?php echo $call['kategori_index']; ?></option>
<option value="Header">Header</option>
<option value="Detail">Detail</option>
</select>
</div>


<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
</form>
  
</div>


<script type="text/javascript">
$("#copy").click(function(){

var nilai_lk  = $("#nilai_lk").val();
var nilai_lk2  = $("#nilai_lk2").val();
$("#nilai_p").val(nilai_lk);
$("#nilai_p2").val(nilai_lk2);

});

</script>

<script type="text/javascript">
$("#copy").click(function(){

var text_lk  = $("#text_lk").val();

$("#text_p").val(text_lk);


});


</script>


<script type="text/javascript">
$(document).ready(function(){


var perhitungan = $("#perhitungan").val();

if(perhitungan == 'Antara Sama Dengan')
{

$("#range").html('Range');
$("#sd").show();
$("#range1").html('Range');
$("#sd1").show();
$(".nilai2").show();


}

else{
  $("#range").html('Nilai');
$("#sd").hide();
$("#range1").html('Nilai');
$("#sd1").hide();
$(".nilai2").hide();

}



  });

</script>

<script type="text/javascript">
//saat pilih kelompok pemeriksaan, nama pemeriksaan yang ada dalm kelompok tsb muncul
  $(document).ready(function(){
          var kelompok = $("#kelompok").val();
    $.post("cek_nama_pemeriksaan.php",{kelompok:kelompok},function(data){
$("#periksa").html(data);
});

    $("#kelompok").change(function(){
      var kelompok = $("#kelompok").val();
$.post("cek_nama_pemeriksaan.php",{kelompok:kelompok},function(data){

$("#periksa").html(data);

});
    });
  });
</script> 

<script type="text/javascript">
$("#perhitungan").change(function(){


var perhitungan = $("#perhitungan").val();

if(perhitungan == 'Antara Sama Dengan')
{

$("#range").html('Range');
$("#sd").show();
$("#range1").html('Range');
$("#sd1").show();
$(".nilai2").show();
$("#nilai_lk").val('');
$("#nilai_p").val('');
$("#nilai_lk2").val('');
$("#nilai_p2").val('');


}

else{
  $("#range").html('Nilai');
$("#sd").hide();
$("#range1").html('Nilai');
$("#sd1").hide();
$(".nilai2").hide();
$("#nilai_lk").val('');
$("#nilai_p").val('');
$("#nilai_lk2").val('');
$("#nilai_p2").val('');

}



  });

</script>



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');

$("#modale-delete").modal('show');
$("#id2").val(id);  

});


</script>
<!--   end script modal confiormasi dellete -->

<script type="text/javascript">
$(document).ready(function(){

var model_hitung = $("#model_hitung").val();

if (model_hitung == 'Numeric')
{

$("#text_lk").attr('readonly',true);
$("#text_p").attr('readonly',true);
$("#text_lk").css('background-color','#424242');
$("#text_p").css('background-color','#424242');
$("#text_lk").val('');
$("#text_p").val('');

$("#nilai_lk").attr('readonly',false);
$("#nilai_p").attr('readonly',false);
$("#nilai_lk").css('background-color','white');
$("#nilai_p").css('background-color','white');

$(".itung").show();
}

else
{

  $("#nilai_lk").attr('readonly',true);
$("#nilai_p").attr('readonly',true);
$("#nilai_lk").css('background-color','#424242');
$("#nilai_p").css('background-color','#424242');
$("#nilai_lk").val('');
$("#nilai_p").val('');
$("#nilai_lk2").val('');
$("#nilai_p2").val('');
$("#text_depan").val('');
$("#satuan_nilai").val('');

  $("#range").html('Nilai');
$("#sd").hide();
$("#range1").html('Nilai');
$("#sd1").hide();
$(".nilai2").hide();


$("#text_lk").attr('readonly',false);
$("#text_p").attr('readonly',false);
$("#text_lk").css('background-color','white');
$("#text_p").css('background-color','white');

$(".itung").hide();

}



 });
 


</script>



<script type="text/javascript">
$("#model_hitung").change(function(){

var model_hitung = $("#model_hitung").val();

if (model_hitung == 'Numeric')
{

$("#text_lk").attr('readonly',true);
$("#text_p").attr('readonly',true);
$("#text_lk").css('background-color','#424242');
$("#text_p").css('background-color','#424242');
$("#text_lk").val('');
$("#text_p").val('');
$("#perhitungan").val('Silakan Pilih');
$("#perhitungan").val('Silakan Pilih');

$("#nilai_lk").attr('readonly',false);
$("#nilai_p").attr('readonly',false);
$("#nilai_lk").css('background-color','white');
$("#nilai_p").css('background-color','white');

$(".itung").show();
}

else
{

  $("#nilai_lk").attr('readonly',true);
$("#nilai_p").attr('readonly',true);
$("#nilai_lk").css('background-color','#424242');
$("#nilai_p").css('background-color','#424242');
$("#nilai_lk").val('');
$("#nilai_p").val('');
$("#nilai_lk2").val('');
$("#nilai_p2").val('');
$("#text_depan").val('');
$("#satuan_nilai").val('');
$("#perhitungan").val('');
$("#perhitungan").val('');

  $("#range").html('Nilai');
$("#sd").hide();
$("#range1").html('Nilai');
$("#sd1").hide();
$(".nilai2").hide();


$("#text_lk").attr('readonly',false);
$("#text_p").attr('readonly',false);
$("#text_lk").css('background-color','white');
$("#text_p").css('background-color','white');

$(".itung").hide();

}



 });
 


</script>




<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id2").val();

$.post('delete_setup_hasil.php',{id:id},function(data){
    if(data == 'ok')
    {
      $("#modale-delete").modal('hide');
      $("#table_baru").load("table_baru_setup_hasil.php"); // ini table baru setelah proses confirm delete (tampilan)
    }
  else{
    }

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->


<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_setup_hasil.php',{q:q},function(data)
{
  $("#table_baru").html(data);
  
});
});
</script>
<!-- END script cari untuk pegy natio -->


  <?php 
  include 'footer.php';
   ?>