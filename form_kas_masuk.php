<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';

 $session_id = session_id();
 
 $query = $db->query("SELECT * FROM kas_masuk ");
 
 $tbs = $db->query("SELECT tk.dari_akun,tk.ke_akun, da.nama_daftar_akun FROM tbs_kas_masuk tk INNER JOIN daftar_akun da ON tk.ke_akun = da.kode_daftar_akun WHERE tk.session_id = '$session_id' ");

 $data_tbs = mysqli_num_rows($tbs);
 $data_tbs1 = mysqli_fetch_array($tbs);

 ?>

<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>

<script type="text/javascript">
  $(function() {
    $( "#tanggal1" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>





<div class="container">

<h3> <u> FORM KAS MASUK </u> </h3>
<br><br>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Kas Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Dari Akun :</label>
     <input type="text" id="hapus_dari" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Kas Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    
    <label> Jumlah Baru </label><br>
    <input type="text" name="jumlah_baru" id="jumlah_baru" autocomplete="off" class="form-control" required="">

    <input type="hidden" name="jumlah" id="jumlah_lama" class="form-control" readonly="" required=""> 
          
    <input type="hidden" id="id_edit" class="form-control" > 
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<form  role="form" method="post" id="formtambahproduk">

<div class="row">
					<div class="form-group col-sm-3">
					<label> Tanggal </label><br>
					<input style="height:15px" type="text" name="tanggal" id="tanggal1" placeholder="Tanggal" value="<?php echo date("Y-m-d"); ?>" class="form-control" required="" >
          
			   <!--HIDDEN SESSION-->		
          <input style="height:15px" type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >

          </div>

          <div class="form-group col-sm-3">
          <label> User </label><br>
          <input style="height:15px" type="text" name="user" id="user" placeholder="Tanggal" value="<?php echo $_SESSION['nama']; ?>" class="form-control" required="" >
          </div>

          <div class="form-group col-sm-6">
          <label> Keterangan </label><br>
          <textarea  name="keterangan" autocomplete="off" id="keterangan" placeholder="Keterangan" class="form-control"></textarea>
          </div>

</div> <!-- tag penutup div row -->

  
<br>


<div class="row">
 <div class="card card-block">
<div class="form-group col-sm-3">
          <label> Dari Akun </label><br>
          <select type="text" name="dari_akun" id="dariakun" class="form-control" >
          <option value="">--SILAHKAN PILIH--</option>

           <?php 

    
    $query = $db->query("SELECT * FROM daftar_akun ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
    }
    
    
    ?>
            </select>
</div>


 <?php if ($data_tbs > 0): ?>
            
            <div class="form-group col-sm-3">
            <label> Ke Akun </label><br>
            <select type="text" name="ke_akun" id="keakun" class="form-control" disabled="true">
            <option value="<?php echo $data_tbs1['ke_akun']; ?>"><?php echo $data_tbs1['nama_daftar_akun']; ?></option>
            
            <?php 
            
            
            $query = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
            while($data = mysqli_fetch_array($query))
            {
            
            echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
            }
            
            
            ?>
            </select>
            </div>

<?php else: ?>
					<div class="form-group col-sm-3">
					<label> Ke Akun </label><br>
					<select type="text" name="ke_akun" id="keakun" class="form-control" >
					<option value="">--SILAHKAN PILIH--</option>

					 <?php 

    
    $query = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
    }
    
    
    ?>
   					</select>
   					</div>

<?php endif ?>   



<div class="form-group col-sm-3">
    <label> Jumlah </label><br>
    <input style="height:15px" type="text" name="jumlah" id="jumlah" autocomplete="off" placeholder="Jumlah" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" style="height: 20px" >
</div>

<div class="form-group col-sm-3">
    <label><br><br><br></label>
    <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>
</div>


</div>
</div><!--div row closed-->


</form>

<form action="proses_kas_masuk.php" id="form_submit" method="POST"><!--tag pembuka form-->
<style type="text/css">
	.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>

      

           <!--membuat tombol submit bayar & Hutang-->
     

      <a class="btn btn-info" href="form_kas_masuk.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>
     

          </form><!--tag penutup form-->
  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
  <div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Data Kas Masuk Berhasil
</div>

      <span id="result">  
      
        <div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->     
  <table id="tableuser" class="table table-bordered table-sm">
    <thead>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Jumlah </th>      
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Keterangan </th>
      <th> User </th>    
      <th> Hapus </th>
      
    </thead>
    
    <tbody id="prepend">
    <?php

    //menampilkan semua data yang ada pada tabel tbs kas masuk dalam DB
$perintah = $db->query("SELECT km.id, km.session_id, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM tbs_kas_masuk km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun WHERE km.session_id = '$session_id' ORDER BY km.id DESC");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
 
        $perintah1 = $db->query("SELECT km.id, km.session_id, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM tbs_kas_masuk km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE km.dari_akun = '$data1[dari_akun]'");
        $data10 = mysqli_fetch_array($perintah1);

        //menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td data-dari-akun ='".$data10['nama_daftar_akun']."'>". $data10['nama_daftar_akun'] ."</td>
      <td>". $data1['nama_daftar_akun'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". rp($data1['jumlah']) ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input-jumlah' data-id='".$data1['id']."' autofocus='' data-jumlah='".$data1['jumlah']."'> </td>   

      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td>". $data1['user'] ."</td>

      <td> <button class='btn btn-danger btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-jumlah='".$data1['jumlah']."' data-dari='". $data1['dari_akun'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
      
      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>
  </div>
        </span>

<br>


<div class="row">

<div class="form-group col-sm-6" id="col_sm_6">
    <b><label> Total Akhir </label><br></b>
    <input style="height:15px;font-size: 25px" type="text" name="jumlah" id="jumlahtotal" readonly="" placeholder="Total" class="form-control">
</div>
</div> <!-- tag penutup div row-->


 <button type="submit" id="submit_kas_masuk" class="btn btn-info"> <i class='fa fa-send'></i> Submit </a> </button>

</div> <!-- tag penutup div container -->



<script>

// untk menampilkan datatable atau filter seacrh
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>


<script type="text/javascript">
  
  $(document).ready(function(){

  $("#dariakun").change(function(){

          var keakun = $("#keakun").val();
          var session_id = $("#session_id").val();
          var dariakun = $("#dariakun").val();
if (dariakun == keakun)
{

alert("Nama Akun Tidak Boleh Sama");
$("#dariakun").val('');
}
else
{

          $.post("cek_tbs_kas_masuk.php",{session_id:session_id,keakun:keakun,dariakun:dariakun},function(data){
            data = data.replace(/\s+/g, '');
          if (data == "ya") {
          
            alert("Akun Sudah Ada, Silakan Pilih Akun lain!");
            $("#dariakun").val('');
          }
          else{
          
          }

});
}
        });
});

</script>


<script type="text/javascript">
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk

$(document).on('click', '#submit_produk', function (e) {

   	var session_id = $("#session_id").val();
   	var keterangan = $("#keterangan").val();
   	var dari_akun = $("#dariakun").val();
   	var ke_akun = $("#keakun").val();
   	var jumlah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah").val()))));
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
   	var tanggal = $("#tanggal1").val();


if(total == '') 
        {
          total = 0;
        }

if(jumlah == '')
        {
          jumlah = 0;
        }

var subtotal = parseInt(total,10) + parseInt(jumlah,10);


if (ke_akun == "") {

alert('Data Ke Akun Harus Di Isi');

}
else if (dari_akun == "") {

alert('Data Dari Akun Harus Di Isi');

}

else if (jumlah == "")
{

	alert('Data Jumlah Harus Di Isi');
}
else {


  $("#jumlahtotal").val(tandaPemisahTitik(subtotal))

	$.post("proses_tbs_kas_masuk.php",{session_id:session_id,keterangan:keterangan,dari_akun:dari_akun,ke_akun:ke_akun,jumlah:jumlah,tanggal:tanggal,total:total}, function(info) {

     $("#result").html(info);
     $("#dariakun").val('');
     $("#jumlah").val('');
     $("#keterangan").val('');
       
   });
}


      $("#formtambahproduk").submit(function(){
    return false;
});
  
var ke_akun = $("#keakun").val();

if (ke_akun != ""){
$("#keakun").attr("disabled", true);
}

  });

</script>

<script type="text/javascript">

$(document).ready(function(){
    var session_id = $("#session_id").val();
$.post("cek_jumlah_kas_masuk.php",
    {
        session_id: session_id
    }, function(data){
      data = data.replace(/\s+/g, '');
        $("#jumlahtotal"). val(data);
    });

});


</script>

<script>
$(document).ready(function(){
    $("#keakun").change(function(){
      var dari_akun = $("#dariakun").val();
      var ke_akun = $("#keakun").val();

if (ke_akun == dari_akun)
{

alert("Nama Akun Tidak Boleh Sama");
    $("#keakun").val('');  
}
        
    });
});
</script>



<script>
$(document).ready(function(){
    $("#dariakun").change(function(){
      var dari_akun = $("#dariakun").val();
      var session_id = $("#session_id").val();

      $.post("cek_tbs_kas_masuk.php",{session_id:session_id,dariakun:dariakun},function(data){
      data = data.replace(/\s+/g, '');
      
          if (data == "ya") {          
            alert("Akun Sudah Ada, Silakan Pilih Akun lain!");
            $("#keterangan").val(data);
          }
          else{
          $("#jumlah").val(data);
          }

});

        
    });
});
</script>



<script type="text/javascript">
 
   $("#submit_kas_masuk").click(function(){

   	var session_id = $("#session_id").val();
    var no_faktur = $("#nomorfaktur1").val();
   	var keterangan = $("#keterangan").val();
   	var ke_akun = $("#keakun").val();
    var dari_akun = $("#dariakun").val();
   	var jumlah = $("#jumlahtotal").val();
   	var tanggal = $("#tanggal1").val();

    $("#dariakun").val('');
    $("#keakun").val('');
    $("#jumlah").val('');
    $("#keterangan").val('');
    $("#jumlahtotal").val('');
  

     $.post("cek_submit_kas_masuk.php", {session_id:session_id}, function(data){
if (data == 'kosong')
{
  alert("Anda Belum Memasukan Transaksi");
}

else {      


      $("#submit_kas_masuk").hide();
      $("#transaksi_baru").show();
   	
$.post("proses_kas_masuk.php", {session_id:session_id,no_faktur:no_faktur,keterangan:keterangan,ke_akun:ke_akun,jumlah:jumlah,tanggal:tanggal}, function(info) {

		$("#alert_berhasil").show();
		$("#result").html(info);
		$("#dariakun").val('');
		$("#keakun").val('');
		$("#jumlah").val('');
		$("#keterangan").val('');
    $("#jumlahtotal").val('');
   });

      $("#form_submit").submit(function(){
        return false;
      });

  }// else cek transaksi kosong
});// penutup cek submit kas masuk
  
 });

     
   $("#submit_kas_masuk").mouseleave(function(){

          $.get('no_faktur_KM.php', function(data) {
   /*optional stuff to do after getScript */ 

$("#nomorfaktur1").val(data);
 });
          var ke_akun = $("#keakun").val();
          if (ke_akun == ""){
          	$("#keakun").attr("disabled", false);

          }

         
 });
  
</script>

<script>
	
$("#keakun").focus(function(){
$("#alert_berhasil").hide();
});

</script>


                                  <script type="text/javascript">
                               
                                  $(document).ready(function(){
                                  
                                  //fungsi hapus data 
                                  $(".btn-hapus-tbs").click(function(){
                                  var id = $(this).attr("data-id");
                                  var jumlah = $(this).attr("data-jumlah");
                                  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
                                 

                                  
                                  if (total == '') 
                                  {
                                  total = 0;
                                  }
                                  else if(jumlah == '')
                                  {
                                  jumlah = 0;
                                  };
                                  var subtotal = parseInt(total,10) - parseInt(jumlah,10);
                                  
                                  
                                  if (subtotal == 0) 
                                  {
                                  subtotal = 0;
                                  $("#keakun").attr("disabled", false);
                                  }



                                  $("#jumlahtotal").val(tandaPemisahTitik(subtotal))
                                 
                                  $(".tr-id-"+id+"").remove();
                                  $.post("hapus_tbs_kas_masuk.php",{id:id},function(data){

                                  });
                                  
                                  });
                                  
                                  
                                  //end fungsi hapus data

                                  
                                  $('form').submit(function(){
                                  
                                  return false;
                                  });
                                  });
                                  
                                  
                                  function tutupalert() {
                                  $("#alert").html("")
                                  }
                                  
                                  function tutupmodal() {
                                  $("#modal_edit").modal("hide")
                                  }
                                  
                                  </script>
  


                                  <script type="text/javascript">
                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    var input_jumlah = $("#text-jumlah-"+id+"").text();
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input-jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var input_jumlah = $(this).val();
                                    
                                    var jumlah_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-jumlah")))));
                                    var total_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
                                    
                                    
                                    
                                    if (total_lama == '') 
                                    {
                                    total_lama = 0;
                                    }
                                    
                                    var subtotal = parseInt(total_lama,10) - parseInt(jumlah_lama,10) + parseInt(input_jumlah,10);
                                    
                                    
                                    $.post("update_tbs_kas_masuk.php",{id:id,input_jumlah:input_jumlah,jenis_edit:"jumlah"},function(data){
                                   
                                    $("#input-jumlah-"+id).attr("data-jumlah", input_jumlah);
                                    $("#btn-hapus-"+id).attr("data-jumlah", input_jumlah);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(tandaPemisahTitik(input_jumlah));
                                    $("#jumlahtotal").val(tandaPemisahTitik(subtotal));
                                    $("#jumlah").val(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");           
                                    
                                    });
                                    
                                    
                                    
                                    });
                                    
                                    </script>

<?php 
include 'footer.php';
 ?>

