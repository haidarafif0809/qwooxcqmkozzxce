<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$query = $db->query("SELECT bl.nama AS nambid,jl.id,jl.bidang,jl.kode_lab,jl.nama,jl.persiapan,jl.metode,jl.harga_1,jl.harga_2,jl.harga_3,jl.harga_4,jl.harga_5,jl.harga_6,jl.harga_7 FROM jasa_lab jl INNER JOIN bidang_lab bl ON jl.bidang = bl.id ORDER BY jl.id DESC");

?>

<div class="container">

   <!-- Modal Untuk Confirm Delete-->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center><br>  
      <input type="hidden" id="id_hapus" name="id_hapus">

      <div class="form-group">
       <label for="sel1"><b>Nama Pemeriksaan</b></label>
       <input type="text" class="form-control" id="nama_hapus" autocomplete="off" name="nama_hapus" readonly="">
     </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="yesss">Ya</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->


    <h3><b>NAMA PEMERIKSAAAN</b></h3> <hr>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah </button>
<br>
<br>

<br>

  <style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="table-jasa" class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>Kode Jasa </th>
        <th>Nama Pemeriksaan </th>
        <th>Kelompok Pemeriksaan</th>
        <th>Persiapan</th>
        <th>Metode</th>
        <th>Harga 1</th>
        <th>Harga 2</th>
        <th>Harga 3</th>
        <th>Harga 4</th>
        <th>Harga 5</th>
        <th>Harga 6</th>   
        <th>Harga 7</th>              
        <th>Edit</th>
        <th>Hapus</th> 
     </tr>
    </thead>
    <tbody id="tbody">
    
   <?php while($data = mysqli_fetch_array($query))
      
      {
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
      
      }
    ?>
  </tbody>
 </table>
</div>

</span>

<!-- Modal -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Nama Pemeriksaan</h4>
        </div>
        <div class="modal-body">


<form role="form" method="POST">

<div class="form-group">
  <label for="sel1"><b>Kode Nama Pemeriksaan</b></label>
  <input type="text" class="form-control" id="kode_jasa" autocomplete="off" name="kode_jasa">
</div>

<div class="form-group">
  <label for="sel1"><b>Nama Pemeriksaan</b></label>
  <input type="text" class="form-control" id="nama_jasa" autocomplete="off" name="nama_jasa">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 1</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_1" autocomplete="off" name="harga_1">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 2</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_2" autocomplete="off" name="harga_2">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 3</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_3" autocomplete="off" name="harga_3">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 4</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_4" autocomplete="off" name="harga_4">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 5</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_5" autocomplete="off" name="harga_5">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 6</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_6" autocomplete="off" name="harga_6">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 7</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_7" autocomplete="off" name="harga_7">
</div>

<div class="form-group">
  <label for="sel1"><b>Kelompok Pemeriksaan</b></label>
  <select class="form-control" id="bidang" autocomplete="off" name="bidang">
  
  <?php 
  $query = $db->query("SELECT nama,id FROM bidang_lab");
while ( $data = mysqli_fetch_array($query))
 {
  echo "<option value='".$data['id']."'>".$data['nama']."</option>";
}
?>
  </select>
</div>

<div class="form-group">
  <label for="sel1"><b>Persiapan </b></label>
  <input type="text" class="form-control" list="per" id="persiapan" placeholder="Pilih Persiapan" autocomplete="off" name="persiapan">
<datalist id="per">
  <option value="-">-</option>
  <option value="Hubungi Petugas">Hubungi Petugas</option>
  <option value="Puasa 12 Jam">Puasa 12 Jam</option>
  <option value="Urine 24 Jam">Urine 24 Jam</option>
  <option value="Feaces 24 Jam">Feaces 24 Jam</option>
</datalist>
</div>

<div class="form-group">
  <label for="sel1"><b>Metode</b></label>
  <input type="text" class="form-control" id="metode" autocomplete="off" name="metode">
</div>

<button type="submit" class="btn btn-info" id="submit_tambah"><i class="fa fa-plus"></i> Tambah</button>
</form>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div> 
    </div>
  </div>





<!-- Modal -->
  <div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Nama Pemeriksaan</h4>
        </div>
        <div class="modal-body">


<form role="form" method="POST">

<div class="form-group">
  <label for="sel1"><b>Kode Nama Pemeriksaan</b></label>
  <input type="text" class="form-control" id="edit_kode_jasa" data-kode="" autocomplete="off" name="kode_jasa">
</div>

<div class="form-group">
  <label for="sel1"><b>Nama Pemeriksaan</b></label>
  <input type="text" class="form-control" id="edit_nama_jasa" autocomplete="off" name="nama_jasa">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 1</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_1" autocomplete="off" name="harga_1">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 2</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_2" autocomplete="off" name="harga_2">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 3</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_3" autocomplete="off" name="harga_3">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 4</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_4" autocomplete="off" name="harga_4">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 5</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_5" autocomplete="off" name="harga_5">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 6</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_6" autocomplete="off" name="harga_6">
</div>

<div class="form-group">
  <label for="sel1"><b>Harga 7</b></label>
  <input type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="edit_harga_7" autocomplete="off" name="harga_7">
</div>

<div class="form-group">
  <label for="sel1"><b>Kelompok Pemeriksaan</b></label>
  <select class="form-control" id="edit_bidang" autocomplete="off" name="bidang">
  
  <?php 
  $query = $db->query("SELECT nama,id FROM bidang_lab");
while ( $data = mysqli_fetch_array($query))
 {
  echo "<option value='".$data['id']."'>".$data['nama']."</option>";
}
?>
  </select>
</div>

<div class="form-group">
  <label for="sel1"><b>Persiapan </b></label>
  <input type="text" class="form-control" list="per" id="edit_persiapan" placeholder="Pilih Persiapan" autocomplete="off" name="persiapan">
<datalist id="per">
  <option value="-">-</option>
  <option value="Hubungi Petugas">Hubungi Petugas</option>
  <option value="Puasa 12 Jam">Puasa 12 Jam</option>
  <option value="Urine 24 Jam">Urine 24 Jam</option>
  <option value="Feaces 24 Jam">Feaces 24 Jam</option>
</datalist>
</div>

<div class="form-group">
  <label for="sel1"><b>Metode</b></label>
  <input type="text" class="form-control" id="edit_metode" autocomplete="off" name="metode">
</div>

<button type="submit" class="btn btn-info" id="submit_edit" data-id="" data-kode_lab=""><i class="fa fa-edit"></i> Edit</button>
</form>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div> 
    </div>
  </div>


   </div><!--div container-->


<script type="text/javascript">
  
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>


<script type="text/javascript">
  
    $(document).on('click','#submit_tambah', function(e){

    var kode_jasa = $("#kode_jasa").val();
    var nama_jasa = $("#nama_jasa").val();
    var harga_1 = $("#harga_1").val();
    var harga_2 = $("#harga_2").val();
    var harga_3 = $("#harga_3").val();
    var harga_4 = $("#harga_4").val();
    var harga_5 = $("#harga_5").val();
    var harga_6 = $("#harga_6").val();
    var harga_7 = $("#harga_7").val();
    var bidang = $("#bidang").val();
    var persiapan = $("#persiapan").val();
    var metode = $("#metode").val();


    if (kode_jasa == '') {
      alert("Kode Nama Pemeriksaan Harus Diisi");
       $("#kode_jasa").focus();
    }
    else if (nama_jasa == '') {
        alert("Nama Pemeriksaan Harus Diisi");
       $("#nama_jasa").focus();
    }
     else if (harga_1 == '') {
        alert("Harga 1 Harus Diisi");
       $("#harga_1").focus();
    }
     else if (harga_2 == '') {
        alert("Harga 2 Harus Diisi");
       $("#harga_2").focus();
    }
     else if (harga_3 == '') {
        alert("Harga 3 Harus Diisi");
       $("#harga_3").focus();
    }
    else if (bidang == '') {
        alert("Kelompok Pemeriksaan Harus Diisi");
       $("#bidang").focus();
    }
    
    else if (persiapan == '') {
        alert("Persiapan Harus Diisi");
       $("#persiapan").focus();
    }
    else if (persiapan == '') {
        alert("Persiapan Harus Diisi");
       $("#persiapan").focus();
    }
    else if (metode == '') {
        alert("Metode Harus Diisi");
       $("#metode").focus();
    }
    else
    {

      $("#modal").modal('hide');
      $.post("proses_jasa_lab.php",{kode_jasa:kode_jasa,nama_jasa:nama_jasa,harga_1:harga_1,harga_2:harga_2,harga_3:harga_3,harga_4:harga_4,harga_5:harga_5,harga_6:harga_6,harga_7:harga_7,bidang:bidang,persiapan:persiapan,metode:metode},function(data){

          $("#tbody").prepend(data);
      
      $("#kode_jasa").val('');
      $("#nama_jasa").val('');
      $("#harga_1").val('');
      $("#harga_2").val('');
      $("#harga_3").val('');
      $("#harga_4").val('');
      $("#harga_5").val('');
      $("#harga_6").val('');
      $("#harga_7").val('');
      $("#bidang").val('');
      $("#persiapan").val('');
       $("#metode").val('');

      });

    }




    });


        $('form').submit(function(){
    
    return false;
    });

</script>



<script type="text/javascript">
  
    $(document).on('click','.btn-edit', function(e){

    var kode_jasa = $(this).attr("data-kode_lab");
    var nama_jasa = $(this).attr("data-nama");
    var harga_1 = $(this).attr("data-harga_1");
    var harga_2 = $(this).attr("data-harga_2");
    var harga_3 = $(this).attr("data-harga_3");
    var harga_4 = $(this).attr("data-harga_4");
    var harga_5 = $(this).attr("data-harga_5");
    var harga_6 = $(this).attr("data-harga_6");
    var harga_7 = $(this).attr("data-harga_7");
    var bidang = $(this).attr("data-bidang");
    var persiapan = $(this).attr("data-persiapan");
    var metode = $(this).attr("data-metode");
    var id = $(this).attr("data-id");


     $("#edit_kode_jasa").val(kode_jasa);
     $("#edit_nama_jasa").val(nama_jasa);
     $("#edit_harga_1").val(harga_1);
     $("#edit_harga_2").val(harga_2);
     $("#edit_harga_3").val(harga_3);
     $("#edit_harga_4").val(harga_4);
     $("#edit_harga_5").val(harga_5);
     $("#edit_harga_6").val(harga_6);
     $("#edit_harga_7").val(harga_7);
     $("#edit_bidang").val(bidang);
     $("#edit_persiapan").val(persiapan);
     $("#edit_metode").val(metode);
     $("#submit_edit").attr("data-id",id);

    $("#submit_edit").attr("data-kode_lab",kode_jasa);
     $("#edit_kode_jasa").attr("data-kode",kode_jasa);

});
     $(document).on('click','#submit_edit', function(e){

       var kode_jasa = $("#edit_kode_jasa").val();
       var nama_jasa = $("#edit_nama_jasa").val();
       var harga_1 = $("#edit_harga_1").val();
       var harga_2 =  $("#edit_harga_2").val();
       var harga_3 =  $("#edit_harga_3").val();
       var harga_4 = $("#edit_harga_4").val();
       var harga_5 = $("#edit_harga_5").val();
       var harga_6 = $("#edit_harga_6").val();
       var harga_7 = $("#edit_harga_7").val();
       var bidang = $("#edit_bidang").val();
       var persiapan = $("#edit_persiapan").val();
       var metode = $("#edit_metode").val();
       var id =  $(this).attr("data-id");


    if (kode_jasa == '') {
      alert("Kode Nama Pemeriksaan Harus Diisi");
       $("#kode_jasa").focus();
    }
    else if (nama_jasa == '') {
        alert("Nama Pemeriksaan Harus Diisi");
       $("#nama_jasa").focus();
    }
     else if (harga_1 == '') {
        alert("Harga 1 Harus Diisi");
       $("#harga_1").focus();
    }
    else if (bidang == '') {
        alert("Kelompok Pemeriksaan Harus Diisi");
       $("#bidang").focus();
    }
    
    else if (persiapan == '') {
        alert("Persiapan Harus Diisi");
       $("#persiapan").focus();
    }
    else if (persiapan == '') {
        alert("Persiapan Harus Diisi");
       $("#persiapan").focus();
    }
    else if (metode == '') {
        alert("Metode Harus Diisi");
       $("#metode").focus();
    }
    else
    {


      $("#modal_edit").modal('hide');

      $(".tr-id-"+id+"").remove();
      $.post("update_jasa_lab.php",{kode_jasa:kode_jasa,nama_jasa:nama_jasa,harga_1:harga_1,harga_2:harga_2,harga_3:harga_3,harga_4:harga_4,harga_5:harga_5,harga_6:harga_6,harga_7:harga_7,bidang:bidang,persiapan:persiapan,metode:metode,id:id},function(data){

      $("#tbody").prepend(data);
      
      $("#edit_kode_jasa").val('');
      $("#edit_nama_jasa").val('');
      $("#edit_harga_1").val('');
      $("#edit_harga_2").val('');
      $("#edit_harga_3").val('');
      $("#edit_harga_4").val('');
      $("#edit_harga_5").val('');
      $("#edit_harga_6").val('');
      $("#edit_harga_7").val('');
      $("#edit_bidang").val('');
      $("#edit_persiapan").val('');
      $("#edit_metode").val('');

      });

    }

     });



    $('form').submit(function(){
    
    return false;
    });

</script>


<script type="text/javascript">
   $("#kode_jasa").blur(function(){
        var kode_jasa = $(this).val()

        $.post("cek_kode_jasa_lab.php",{kode_jasa:kode_jasa},function(data){
          if (data == 1) {
            alert("Kode Nama Pemeriksaan yang anda masukan sudah ada");
            $("#kode_jasa").val('');
            $("#kode_jasa").focus();
          }

        });
   });
</script>

<script type="text/javascript">
   $("#edit_kode_jasa").blur(function(){
        var kode_jasa = $(this).val();
        var kode_jasa2 = $(this).attr("data-kode");

        if (kode_jasa2 == kode_jasa) {

        }
        else
        {
          $.post("cek_kode_jasa_lab.php",{kode_jasa:kode_jasa},function(data){
          if (data == 1) {
            alert("Kode Nama Pemeriksaan yang anda masukan sudah ada");
            $("#edit_kode_jasa").val(kode_jasa2);
            $("#edit_kode_jasa").focus();
          }

        });
        }


   });
</script>


<!--   script modal confirmasi delete -->
<script type="text/javascript">
   $(document).on('click','.delete', function(e){

  var id = $(this).attr('data-id');
  var nama = $(this).attr('data-nama');

    $("#id_hapus").val(id);  
    $("#nama_hapus").val(nama); 

});

   $(document).on('click','#yesss', function(e){


var id = $("#id_hapus").val();
    
    $("#modal_hapus").modal('hide');
    $(".tr-id-"+id+"").remove();
    $.post('delete_jasa_lab.php',{id:id},function(data){

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->



<?php 
  include 'footer.php';
?>
