<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

?>

<div class="container">



<h3>NAMA PEMERIKSAAAN</h3> <hr>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Pemeriksaan </button>
<br>
<br>


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>


<!--TABEL PEMeRIKSAAN -->
<span id="span_pemeriksaan">            
                
                  <div class="table-responsive">
                    <table id="tabel_pemeriksaan" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th style='background-color: #4CAF50; color: white;'> Kode Pemeriksaan</th>
                              <th style='background-color: #4CAF50; color: white;'> Nama Pemeriksaan</th>
                              <th style='background-color: #4CAF50; color: white;'> Kontras </th>
                              <th style='background-color: #4CAF50; color: white;'> Harga</th>
                              <th style='background-color: #4CAF50; color: white;'> No. Urut</th>
                            <!--
                              <th style='background-color: #4CAF50; color: white;'> Harga 2</th>
                              <th style='background-color: #4CAF50; color: white;'> Harga 3</th>
                              <th style='background-color: #4CAF50; color: white;'> Harga 4</th>
                              <th style='background-color: #4CAF50; color: white;'> Harga 5</th>
                              <th style='background-color: #4CAF50; color: white;'> Harga 6</th>
                              <th style='background-color: #4CAF50; color: white;'> Harga 7</th>
                              -->
                              <th style='background-color: #4CAF50; color: white;'> Hapus</th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>
                  <h6 style="text-align: left ; color: red"><i><b> * Klik 2x Pada Kolom Yang Akan Diedit. </b></i></h6>


</span>
<!-- / TABEL PEMeRIKSAAN -->

<!-- MODAL PEMeRIKSAAN -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Nama Pemeriksaan</h4>
        </div>
        <div class="modal-body">


<form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Kode Pemeriksaan</label>
  <input  style="height: 20px" type="text" class="form-control" id="kode_pemeriksaan" autocomplete="off" name="kode_pemeriksaan">
</div>

<div class="form-group">
  <label for="sel1">Nama Pemeriksaan</label>
  <input  style="height: 20px" type="text" class="form-control" id="nama_pemeriksaan" autocomplete="off" name="nama_pemeriksaan">
</div>

<div class="form-group">
  <label for="sel1">Harga</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_1" autocomplete="off" name="harga_1">
</div>

<!--

<div class="form-group">
  <label for="sel1">Harga 2</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_2" autocomplete="off" name="harga_2">
</div>

<div class="form-group">
  <label for="sel1">Harga 3</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_3" autocomplete="off" name="harga_3">
</div>

<div class="form-group">
  <label for="sel1">Harga 4</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_4" autocomplete="off" name="harga_4">
</div>

<div class="form-group">
  <label for="sel1">Harga 5</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_5" autocomplete="off" name="harga_5">
</div>

<div class="form-group">
  <label for="sel1">Harga 6</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_6" autocomplete="off" name="harga_6">
</div>

<div class="form-group">
  <label for="sel1">Harga 7</label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="harga_7" autocomplete="off" name="harga_7">
</div>

-->


<div class="form-group">
  <label for="sel1"> No. Urut </label>
  <input  style="height: 20px" type="text" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  id="no_urut" autocomplete="off" name="no_urut">
</div>

<div class="form-group">
  <label>Kontras </label>
    <select type="text" name="kontras" id="kontras" class="form-control" required="">
      <option value="">--SILAKAN PILIH--</option>
      <option value="1">Pakai Kontras</option>
      <option value="0">Tidak Pakai Kontras</option>
    </select>

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

<!-- /MODAL PEMeRIKSAAN -->

</div><!--div container-->

<script type="text/javascript">
$(document).ready(function(){
      var dataTable = $('#tabel_pemeriksaan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data Pemeriksaan" },
            "ajax":{
              url :"data_pemeriksaan.php", // json datasource
              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_pemeriksaan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });

      $("#span_pemeriksaan").show()
});
</script>

<script type="text/javascript">
  
    $(document).on('click','#submit_tambah', function(e){

    var kode_pemeriksaan = $("#kode_pemeriksaan").val();
    var nama_pemeriksaan = $("#nama_pemeriksaan").val();
    var harga_1 = $("#harga_1").val();
/**
    var harga_2 = $("#harga_2").val();
    var harga_3 = $("#harga_3").val();
    var harga_4 = $("#harga_4").val();
    var harga_5 = $("#harga_5").val();
    var harga_6 = $("#harga_6").val();
    var harga_7 = $("#harga_7").val();
*/
    var no_urut = $("#no_urut").val();
    var kontras = $("#kontras").val();


    if (kode_pemeriksaan == '') {
      alert("Kode Nama Pemeriksaan Harus Diisi");
       $("#kode_pemeriksaan").focus();
    }
    else if (nama_pemeriksaan == '') {
        alert("Nama Pemeriksaan Harus Diisi");
       $("#nama_pemeriksaan").focus();
    }
     else if (harga_1 == '') {
        alert("Harga 1 Harus Diisi");
       $("#harga_1").focus();
    }
 
    else if (kontras == '') {
        alert("Kelompok Pemeriksaan Harus Diisi");
       $("#kontras").focus();
    }
    else
    {

      $("#modal").modal('hide');
      $.post("proses_tambah_pemeriksaan.php",{kode_pemeriksaan:kode_pemeriksaan,nama_pemeriksaan:nama_pemeriksaan,harga_1:harga_1,no_urut:no_urut,kontras:kontras},function(data){

      });

      $('#tabel_pemeriksaan').DataTable().destroy();
            var dataTable = $('#tabel_pemeriksaan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_pemeriksaan.php", // json datasource
              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_pemeriksaan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
              $("#span_pemeriksaan").show()

              $("#kode_pemeriksaan").val('');
              $("#nama_pemeriksaan").val('');
              $("#harga_1").val('');
              $("#no_urut").val('');
              $("#kontras").val('');

    }


});


        $('form').submit(function(){
    
    return false;
    });

</script>


<script type="text/javascript">
   $("#kode_pemeriksaan").blur(function(){
        var kode_pemeriksaan = $(this).val()

        $.post("cek_kode_pemeriksaan_radiologi.php",{kode_pemeriksaan:kode_pemeriksaan},function(data){
          if (data == 1) {
            alert("Kode Pemeriksaan '"+kode_pemeriksaan+"' Sudah Terdaftar, Silakan Masukan Kode Lain !");
            $("#kode_pemeriksaan").val('');
            $("#kode_pemeriksaan").focus();
          }

        });
   });
</script>


<script type="text/javascript">
   $("#no_urut").blur(function(){
        var no_urut = $(this).val()

      if (no_urut == 0 || no_urut == "") {

      }
      else{

            $.post("cek_no_urut_radiologi.php",{no_urut:no_urut},function(data){
              if (data == 1) {
                alert("No. Urut '"+no_urut+"' Sudah Terdaftar, Silakan Masukan Urutan Lain !");
                $("#no_urut").val('');
                $("#no_urut").focus();
              }

            });        
      }
   });
</script>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus',function(e){

  var id = $(this).attr("data-id");
  var kode_pemeriksaan = $(this).attr("data-kode-pemeriksaan");
  var nama_pemeriksaan = $(this).attr("data-pemeriksaan");

  var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus '"+nama_pemeriksaan+"' "+ "?");
  if (pesan_alert == true) {

          $.post("hapus_data_pemeriksaan.php",{kode_pemeriksaan:kode_pemeriksaan},function(data){
            
          $('#tabel_pemeriksaan').DataTable().destroy();
           var dataTable = $('#tabel_pemeriksaan').DataTable( {
                  "processing": true,
                  "serverSide": true,
                  "info":     true,
                  "language": { "emptyTable":     "Tidak Ada Data Pemeriksaan" },
                  "ajax":{
                    url :"data_pemeriksaan.php", // json datasource
                    type: "post",  // method  , by default get
                    error: function(){  // error handling
                      $(".tbody").html("");
                      $("#tabel_pemeriksaan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                      $("#tableuser_processing").css("display","none");
                      
                    },

                      "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                        $(nRow).attr('class','tr-id-'+aData[11]+'');
                      }
                  }   

            });

          $("#span_pemeriksaan").show()

          });
  }
  else {
      
      }



});
      $('form').submit(function(){   
        return false;
      });


});
  
//end fungsi hapus data
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!-- EDIT NAMA KONTRAS -->
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-nama',function(e){

    var id = $(this).attr("data-id");
    $("#text-nama-"+id+"").hide();
    $("#input-nama-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_nama',function(e){

  var id = $(this).attr("data-id");
  var input_nama = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_nama:input_nama,jenis_edit:"nama_pemeriksaan"},function(data){

    $("#text-nama-"+id+"").show();
    $("#text-nama-"+id+"").text(input_nama);
    $("#input-nama-"+id+"").attr("type", "hidden");

  });
});

</script>
<!-- /EDIT NAMA KONTRAS -->

<!-- EDIT HARGA 1 -->
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-1',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-1-"+id+"").hide();
    $("#input-harga-1-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_1',function(e){

  var id = $(this).attr("data-id");
  var input_harga_1 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_1:input_harga_1,jenis_edit:"harga_1"},function(data){

    $("#text-harga-1-"+id+"").show();
    $("#text-harga-1-"+id+"").text(tandaPemisahTitik(input_harga_1));
    $("#input-harga-1-"+id+"").attr("type", "hidden");

  });
});

</script>
<!-- /EDIT HARGA 1 -->


<!--


 EDIT HARGA 2
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-2',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-2-"+id+"").hide();
    $("#input-harga-2-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_2',function(e){

  var id = $(this).attr("data-id");
  var input_harga_2 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_2:input_harga_2,jenis_edit:"harga_2"},function(data){

    $("#text-harga-2-"+id+"").show();
    $("#text-harga-2-"+id+"").text(tandaPemisahTitik(input_harga_2));
    $("#input-harga-2-"+id+"").attr("type", "hidden");

  });
});

</script>
 /EDIT HARGA 2

 EDIT HARGA 3
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-3',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-3-"+id+"").hide();
    $("#input-harga-3-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_3',function(e){

  var id = $(this).attr("data-id");
  var input_harga_3 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_3:input_harga_3,jenis_edit:"harga_3"},function(data){

    $("#text-harga-3-"+id+"").show();
    $("#text-harga-3-"+id+"").text(tandaPemisahTitik(input_harga_3));
    $("#input-harga-3-"+id+"").attr("type", "hidden");

  });
});

</script>
 /EDIT HARGA 3

 EDIT HARGA 4
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-4',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-4-"+id+"").hide();
    $("#input-harga-4-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_4',function(e){

  var id = $(this).attr("data-id");
  var input_harga_4 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_4:input_harga_4,jenis_edit:"harga_4"},function(data){

    $("#text-harga-4-"+id+"").show();
    $("#text-harga-4-"+id+"").text(tandaPemisahTitik(input_harga_4));
    $("#input-harga-4-"+id+"").attr("type", "hidden");

  });
});

</script>
 /EDIT HARGA 4

 EDIT HARGA 5
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-5',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-5-"+id+"").hide();
    $("#input-harga-5-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_5',function(e){

  var id = $(this).attr("data-id");
  var input_harga_5 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_5:input_harga_5,jenis_edit:"harga_5"},function(data){

    $("#text-harga-5-"+id+"").show();
    $("#text-harga-5-"+id+"").text(tandaPemisahTitik(input_harga_5));
    $("#input-harga-5-"+id+"").attr("type", "hidden");

  });
});

</script>
 /EDIT HARGA 5

 EDIT HARGA 6
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-6',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-6-"+id+"").hide();
    $("#input-harga-6-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_6',function(e){

  var id = $(this).attr("data-id");
  var input_harga_6 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_6:input_harga_6,jenis_edit:"harga_6"},function(data){

    $("#text-harga-6-"+id+"").show();
    $("#text-harga-6-"+id+"").text(tandaPemisahTitik(input_harga_6));
    $("#input-harga-6-"+id+"").attr("type", "hidden");

  });
});

</script>
 /EDIT HARGA 6

 EDIT HARGA 7
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-harga-7',function(e){

    var id = $(this).attr("data-id");
    $("#text-harga-7-"+id+"").hide();
    $("#input-harga-7-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_harga_7',function(e){

  var id = $(this).attr("data-id");
  var input_harga_7 = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, input_harga_7:input_harga_7,jenis_edit:"harga_7"},function(data){

    $("#text-harga-7-"+id+"").show();
    $("#text-harga-7-"+id+"").text(tandaPemisahTitik(input_harga_7));
    $("#input-harga-7-"+id+"").attr("type", "hidden");

  });
});

</script>
 EDIT HARGA 7

-->



<!-- EDIT HARGA 1 -->
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-urutan',function(e){

    var id = $(this).attr("data-id");
    $("#text-urutan-"+id+"").hide();
    $("#input-urutan-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_urutan',function(e){

  var id = $(this).attr("data-id");
  var input_urutan = $(this).val();
  var no_urut_lama = $("#text-urutan-"+id+"").text();

$.post("cek_no_urut_radiologi.php",{no_urut:input_urutan},function(data){

  if (input_urutan == 0) {

      $.post("update_pemeriksaan.php",{id:id, input_urutan:input_urutan,jenis_edit:"no_urut"},function(data){

        $("#text-urutan-"+id+"").show();
        $("#text-urutan-"+id+"").text(tandaPemisahTitik(input_urutan));
        $("#input-urutan-"+id+"").attr("type", "hidden");

      });

  }
  else{

    if (data == 1) {
      alert("No. Urut '"+input_urutan+"' Sudah Terdaftar, Silakan Masukan Urutan Lain !");
      $("#input-urutan-"+id+"").val(no_urut_lama);
      $("#text-urutan-"+id+"").text(no_urut_lama);
      $("#text-urutan-"+id+"").show();
      $("#input-urutan-"+id+"").attr("type", "hidden");
    }
    else{

      $.post("update_pemeriksaan.php",{id:id, input_urutan:input_urutan,jenis_edit:"no_urut"},function(data){

        $("#text-urutan-"+id+"").show();
        $("#text-urutan-"+id+"").text(tandaPemisahTitik(input_urutan));
        $("#input-urutan-"+id+"").attr("type", "hidden");

      });
    }

  }

});

});

</script>
<!-- /EDIT HARGA 1 -->

<!-- EDIT KONTRAS -->
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-kontras',function(e){

  var id = $(this).attr("data-id");

  $("#text-kontras-"+id+"").hide();
  $("#select-kontras-"+id+"").show();

});

$(document).on('blur','.select-kontras',function(e){

  var id = $(this).attr("data-id");
  var select_kontras = $(this).val();

  $.post("update_pemeriksaan.php",{id:id, select_kontras:select_kontras,jenis_edit:"kontras"},function(data){
    if (select_kontras == 1) {
      select_kontras = 'Pakai Kontras';
    }
    else{
      select_kontras = 'Tidak Pakai Kontras';
    }
    $("#text-kontras-"+id+"").show();
    $("#text-kontras-"+id+"").text(select_kontras);
    $("#select-kontras-"+id+"").hide();

  });
});

</script>
<!-- /EDIT KONTRAS -->

<?php 
  include 'footer.php';
?>
