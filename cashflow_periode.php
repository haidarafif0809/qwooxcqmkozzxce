<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';



 ?>
<div class="container">
<h3><b>Cashflow Per Periode</b></h3>

<div class="dropdown">

    <!--Trigger-->
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Jenis Cashflow</button>

    <!--Menu-->
    <div class="dropdown-menu dropdown-secondary" aria-labelledby="dropdownMenu4" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
        <a class="dropdown-item" id="nav_detail" href="#">Cashflow Detail</a>
        <a class="dropdown-item" id="nav_rekap" href="#">Cashflow Rekap</a>
    </div>
</div>
<br>


<div class="row">
<span id="show_detail" >
	<div class="col-sm-6" >
	<div class="card card-block">
	<center><h4><b>DETAIL</b></h4></center>
<form role="form-inline" id="form_detail" >
<div class="row">
<div class="col-sm-12" >
   

        <div class="form-group"> 
 		<label style="font-size:15px"> Kas </label><br>
            <select type="text" name="kas_detail" id="kas_detail" class="form-control"  style="font-size: 15px" >
                <option value=""> Silahkan Pilih </option>
                    <?php 
                    $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                    $data_sett = mysqli_fetch_array($sett_akun);

                    echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
                         
                    $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                    while($data = mysqli_fetch_array($query))
                        {
                         
                        echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                                                  
                        }
                    ?>
                      
            </select>
		</div>
</div><!--12 in row-->
<br>

<div class="col-sm-6" >

        <div class="form-group"> 
  			<input type="text" name="dari_tanggal_detail" id="dari_tanggal_detail" autocomplete="off" class="form-control tanggal" placeholder=" Dari Tanggal">
		</div>
</div>

<div class="col-sm-6" >
        <div class="form-group"> 
        <input type="text" name="sampai_tanggal_detail" id="sampai_tanggal_detail" autocomplete="off" class="form-control tanggal_sampai" placeholder="Sampai Tanggal">
        </div>
</div>
</div><!--closed row in 12-->
		<center><button type="submit" name="submit" id="submit_detail" class="btn btn-primary" > <i class="fa fa-send"></i> Show </button></center>

</form>
	</div>
	</div>
</span>


<span id="show_rekap">
	<div class="col-sm-6">
	<div class="card card-block">

	<center><h4><b>REKAP</b></h4></center>
	<form role="form" id="form_rekap" >

<div class="row">
<div class="col-sm-12" >

        <div class="form-group"> 
 		<label style="font-size:15px"> Kas </label><br>
            <select type="text" name="kas_rekap" id="kas_rekap" class="form-control"  style="font-size: 15px" >
                <option value=""> Silahkan Pilih </option>
                    <?php 
                    $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                    $data_sett = mysqli_fetch_array($sett_akun);

                    echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
                         
                    $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                    while($data = mysqli_fetch_array($query))
                        {
                         
                        echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                                                  
                        }
                    ?>
                      
            </select>
		</div>
</div>

<div class="col-sm-6" >
        <div class="form-group"> 
  			<input type="text" name="dari_tanggal_rekap" id="dari_tanggal_rekap" autocomplete="off" class="form-control " placeholder="Dari Tanggal">
		</div>
</div>

<div class="col-sm-6" >
        <div class="form-group"> 
            <input type="text" name="sampai_tanggal_rekap" id="sampai_tanggal_rekap" autocomplete="off" class="form-control " placeholder="Sampai Tanggal">
        </div>
</div>

</div><!--closed row 12 in row-->

		<center><button type="submit" name="submit" id="submit_rekap" class="btn btn-primary" > <i class="fa fa-send"></i> Show </button></center>
	</form>
	</div>
	</div>
</span>

</div><!--closed row-->


<span id="show_total" style="display: none">

<div class="card card-block">
<!--START DETAIL SHOW TABLE-->
<span id="show_table_detail">
<!--TABLE KAS MASUK-->
<span id="result_detail_masuk">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Masuk</b> <u>Rp. <span id="hasil_masuk_detail"></span></u> </h4>
<table id="detail_masuk" class="table table-hover table-sm">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> No Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Keterangan </th>
      <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Total </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas Edit </th>
      <th style="background-color: #4CAF50; color: white;"> Waktu</th>
            
    </thead>
    <tbody class="tbody_masuk">
      

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>
</span>

<!--TABLE KAS KELUAR-->
<span id="result_detail_keluar">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Keluar</b> <u>Rp. <span id="hasil_keluar_detail"></span></u> </h4>
<table id="detail_keluar" class="table table-hover table-sm">
    <thead>
      
      <th style="background-color: #4CAF50; color: white;"> No Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Keterangan </th>
      <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Total </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas Edit </th>
      <th style="background-color: #4CAF50; color: white;"> Waktu</th>
            
    </thead>
    <tbody class="tbody_keluar">
      

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>
</span>
<!--TABLE KAS MUTASI MASUK-->
<span id="result_detail_mutasi_masuk">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Masuk)</b> <u>Rp. <span id="hasil_mutasi_masuk_detail"></span></u> </h4>
<table id="detail_mutasi_masuk" class="table table-hover table-sm">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> No Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Keterangan </th>
      <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Total </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas Edit </th>
      <th style="background-color: #4CAF50; color: white;"> Waktu</th>
            
    </thead>
    <tbody class="tbody_mutasi_in">

      

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>
</span>
<!--END MUTASI MASUK-->

<!--TABLE KAS MUTASI KELUAR-->
<span id="result_detail_mutasi">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Keluar)</b> <u>Rp. <span id="hasil_mutasi_detail"></span></u> </h4>
<table id="detail_mutasi" class="table table-hover table-sm">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> No Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Keterangan </th>
      <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
      <th style="background-color: #4CAF50; color: white;"> Total </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas Edit </th>
      <th style="background-color: #4CAF50; color: white;"> Waktu</th>
            
    </thead>
    <tbody class="tbody_mutasi">

      

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>
</span>
<!--END MUTASI KELUAR-->

</span>
<!--ENDING DETAIL SHO TABLE-->



<!--START REKAP SHOW TABLE-->
<span id="show_table_rekap">
<!--TABLE KAS MASUK-->
<span id="result_rekap_masuk">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Masuk</b> <u>Rp. <span id="hasil_masuk"></span></u> </h4>
<table id="rekap_masuk" class="table table-hover table-sm">
        <thead>
            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
                        
        </thead>
        <tbody class="tbody_masuk">
            

        </tbody>

    </table>
</div> <!--/ responsive-->
<hr>
</span>

<!--TABLE KAS KELUAR-->
<span id="result_rekap_keluar">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Keluar</b> <u>Rp. <span id="hasil_keluar"></span></u> </h4>
<table id="rekap_keluar" class="table table-hover table-sm">
        <thead>
            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
                        
        </thead>
        <tbody class="tbody_keluar">
            

        </tbody>

    </table>
</div> <!--/ responsive-->
<hr>
</span>
<!--ENDING TABLE REKAP KAS KELUAR-->

<!--TABLE KAS MUTASI MASUK-->
<span id="result_rekap_mutasi_masuk">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Masuk)</b> <u>Rp. <span id="hasil_mutasi_masuk"></span></u> </h4>
<table id="rekap_mutasi_masuk" class="table table-hover table-sm">
        <thead>
            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
                        
        </thead>
        <tbody class="tbody_mutasi_masuk">

            

        </tbody>

    </table>
</div> <!--/ responsive-->
<hr>
</span>
<!--ENDING KAS MUTASI MASUK-->

<!--TABLE KAS MUTASI KELUAR-->
<span id="result_rekap_mutasi">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Keluar)</b> <u>Rp. <span id="hasil_mutasi"></span></u> </h4>
<table id="rekap_mutasi" class="table table-hover table-sm">
        <thead>
            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
                        
        </thead>
        <tbody class="tbody_mutasi">

            

        </tbody>

    </table>
</div> <!--/ responsive-->
<hr>
</span>
<!--ENDING KAS MUTASI KELUAR-->

</span>
<!--END TABLE REKAP-->

<table style="font-size: 25">
<h3><b>Total Cashflow </b></h3>
<h3>
  <h4><tr> <td> Saldo Awal</td>   <td >:</td>  <td>Rp.</td> <td id="saldo_awal" > </td> </tr>  </h4>
  <h4> <tr> <td> Perubahan Saldo</td>   <td>:</td> <td>Rp.</td> <td id="perubahan_saldo" > </td> </tr></h4>
  <h4><tr> <td> Saldo Akhir</td>  <td>:</td>  <td>Rp.</td> <td id="saldo_akhir" > </td> </tr></h4>

</table>

</div> <!--END card block-->

</span>

<span id="show_cetak_detail" style="display: none;">
    <a href='cetak_detail_periode.php' target="blank" id="cetak_detail" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Cashflow </a>
    <a href='download_detail_periode.php' target="blank" id="download_detail" class='btn btn-default'> <i class='fa fa-download'> </i> Download Cashflow</a>
</span>

<span id="show_cetak_rekap" style="display: none;">
    <a href='cetak_rekap_periode.php' target="blank" id="cetak_rekap" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Cashflow </a>
    <a href='download_rekap_periode.php' target="blank" id="download_rekap" class='btn btn-default'> <i class='fa fa-download'> </i> Download Cashflow</a>
</span> 



</div><!--container closed-->


<script type="text/javascript">
  Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
  
</script>


<!--SCRIPT PROSES DETAIL-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $(document).on('click','#submit_detail',function(e) {

//proses for hasil
var kas_detail = $("#kas_detail").val();
var dari_tanggal = $("#dari_tanggal_detail").val();
var sampai_tanggal = $("#sampai_tanggal_detail").val();

$.getJSON('proses_cashflow_periode_detail.php',{kas_detail:kas_detail,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(json){

    $("#saldo_awal").html(json.keterangan.format(2, 3, '.', ','));
    $("#perubahan_saldo").html(json.provinsi.format(2, 3, '.', ','));
    $("#saldo_akhir").html(json.petugas.format(2, 3, '.', ','));

    $("#hasil_masuk_detail").html(json.kelurahan.format(2, 3, '.', ','));
    $("#hasil_keluar_detail").html(json.kecamatan.format(2, 3, '.', ','));
    $("#hasil_mutasi_detail").html(json.kabupaten.format(2, 3, '.', ','));

    $("#hasil_mutasi_masuk_detail").html(json.petugas_lain.format(2, 3, '.', ','));
    $("#show_total").show();

  });

// end proses for hasil

//untuk tampilkan table kas masuk detail
     $('#detail_masuk').DataTable().destroy();
          var dataTable = $('#detail_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_detail_masuk_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_detail = $("#kas_detail").val();
                d.dari_tanggal = $("#dari_tanggal_detail").val();
                d.sampai_tanggal = $("#sampai_tanggal_detail").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_masuk").html("");
              $("#detail_masuk").append('<tbody class="tbody_masuk"><tr><th colspan="3"></th></tr></tbody>');
              $("#detail_masuk_processing").css("display","none");
                       
            }
          }
    
        });
//Ending untuk tampilkan table kas masuk detail


//untuk tampilkan table kas KELUAR detail
     $('#detail_keluar').DataTable().destroy();
          var dataTable = $('#detail_keluar').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_detail_keluar_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_detail = $("#kas_detail").val();
                d.dari_tanggal = $("#dari_tanggal_detail").val();
                d.sampai_tanggal = $("#sampai_tanggal_detail").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_keluar").html("");
              $("#detail_keluar").append('<tbody class="tbody_keluar"><tr><th colspan="3"></th></tr></tbody>');
              $("#detail_keluar_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas KELUAR detail


//untuk tampilkan table kas MUTASI MASUK detail
     $('#detail_mutasi_masuk').DataTable().destroy();
          var dataTable = $('#detail_mutasi_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_detail_mutasi_masuk_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_detail = $("#kas_detail").val();
                d.dari_tanggal = $("#dari_tanggal_detail").val();
                d.sampai_tanggal = $("#sampai_tanggal_detail").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_mutasi_in").html("");
              $("#detail_mutasi_masuk").append('<tbody class="tbody_mutasi_in"><tr><th colspan="3"></th></tr></tbody>');
              $("#detail_mutasi_masuk_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas MUTASI MASUK detail

//untuk tampilkan table kas MUTASI KELUAR detail
     $('#detail_mutasi').DataTable().destroy();
          var dataTable = $('#detail_mutasi').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_detail_mutasi_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_detail = $("#kas_detail").val();
                d.dari_tanggal = $("#dari_tanggal_detail").val();
                d.sampai_tanggal = $("#sampai_tanggal_detail").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_keluar").html("");
              $("#detail_mutasi").append('<tbody class="tbody_keluar"><tr><th colspan="3"></th></tr></tbody>');
              $("#detail_mutasi_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas MUTASI KELUAR detail


// show table id resultnya and input form jadi kosong
          $("#result_detail_masuk").show();
          $("#result_detail_keluar").show();
          $("#result_detail_mutasi").show();
          $("#show_detail").show();
          $("#show_table_rekap").hide();
          $("#show_table_detail").show();
// show untuk cetak & download
          $("#show_cetak_rekap").hide();
          $("#show_cetak_detail").show();
          $("#cetak_detail").attr("href", "cetak_detail_periode.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&kas_detail="+kas_detail+"");
          $("#download_detail").attr("href", "download_detail_periode.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&kas_detail="+kas_detail+"");
// ending show cetak and download



   });  

          $("#form_detail").submit(function(){
          return false;
          });
          function clearInput(){
          $("#form_detail :input").each(function(){
          $(this).val('');
          });
          };
  });
 
 </script>
 <!--ENDING SCRIPT DETAIL-->


<!--SCRIPT PROSES REKAP-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $(document).on('click','#submit_rekap',function(e) {

//proses for hasil
var kas_rekap = $("#kas_rekap").val();
var dari_tanggal = $("#dari_tanggal_rekap").val();
var sampai_tanggal = $("#sampai_tanggal_rekap").val();



$.getJSON('proses_cashflow_periode_rekap.php',{kas_rekap:kas_rekap,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(json){

    $("#saldo_awal").html(tandaPemisahTitik(json.keterangan));
    $("#perubahan_saldo").html(tandaPemisahTitik(json.provinsi));
    $("#saldo_akhir").html(tandaPemisahTitik(json.petugas));

    $("#hasil_masuk").html(tandaPemisahTitik(json.kelurahan));
    $("#hasil_keluar").html(tandaPemisahTitik(json.kecamatan));
    $("#hasil_mutasi").html(tandaPemisahTitik(json.kabupaten));
    $("#hasil_mutasi_masuk").html(tandaPemisahTitik(json.petugas_lain));


                $("#show_total").show();

  });

// end proses for hasil

//untuk tampilkan table kas masuk
     $('#rekap_masuk').DataTable().destroy();
          var dataTable = $('#rekap_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_rekap_masuk_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_rekap = $("#kas_rekap").val();
                d.dari_tanggal = $("#dari_tanggal_rekap").val();
                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_masuk").html("");
              $("#rekap_masuk").append('<tbody class="tbody_masuk"><tr><th colspan="3"></th></tr></tbody>');
              $("#rekap_masuk_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas masuk


//untuk tampilkan table kas KELUAR
     $('#rekap_keluar').DataTable().destroy();
          var dataTable = $('#rekap_keluar').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_rekap_keluar_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_rekap = $("#kas_rekap").val();
                d.dari_tanggal = $("#dari_tanggal_rekap").val();
                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_keluar").html("");
              $("#rekap_keluar").append('<tbody class="tbody_keluar"><tr><th colspan="3"></th></tr></tbody>');
              $("#rekap_keluar_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas KELUAR


//untuk tampilkan table kas MUTASI MASUK
     $('#rekap_mutasi_masuk').DataTable().destroy();
          var dataTable = $('#rekap_mutasi_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_rekap_mutasi_masuk_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_rekap = $("#kas_rekap").val();
                d.dari_tanggal = $("#dari_tanggal_rekap").val();
                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_mutasi_masuk").html("");
              $("#rekap_mutasi_masuk").append('<tbody class="tbody_mutasi_masuk"><tr><th colspan="3"></th></tr></tbody>');
              $("#rekap_mutasi_masuk_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas MUTASI MASUK


//untuk tampilkan table kas MUTASI KELUAR
     $('#rekap_mutasi').DataTable().destroy();
          var dataTable = $('#rekap_mutasi').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_cashflow_rekap_mutasi_periode.php", // json datasource
             "data": function ( d ) {
                d.kas_rekap = $("#kas_rekap").val();
                d.dari_tanggal = $("#dari_tanggal_rekap").val();
                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_keluar").html("");
              $("#rekap_mutasi").append('<tbody class="tbody_keluar"><tr><th colspan="3"></th></tr></tbody>');
              $("#rekap_mutasi_processing").css("display","none");
              
         
            }
          }
    
        });
//Ending untuk tampilkan table kas MUTASI KELUAR


// show table id resultnya and input form jadi kosong
          $("#result_rekap_masuk").show();
          $("#result_rekap_keluar").show();
          $("#result_rekap_mutasi").show();
          $("#result_rekap_mutasi_masuk").show();
          $("#show_rekap").show();
          
          $("#show_table_rekap").show();
          $("#show_table_detail").hide();

// show untuk cetak & download
          $("#show_cetak_rekap").show();
          $("#show_cetak_detail").hide();
          $("#cetak_rekap").attr("href", "cetak_rekap_periode.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&kas_rekap="+kas_rekap+"");
          $("#download_rekap").attr("href", "download_rekap_periode.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&kas_rekap="+kas_rekap+"");
// ending show cetak and download
   });  

  $("#form_rekap").submit(function(){
      return false;
  });
  function clearInput(){
      $("#form_rekap :input").each(function(){
          $(this).val('');
      });
    };
  });
 
 </script>
 <!--ENDING SCRIPT REKAP-->




    <script>
    $(function() {
    $( "#dari_tanggal_detail" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#sampai_tanggal_detail" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#dari_tanggal_rekap" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#sampai_tanggal_rekap" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>
    
<script type="text/javascript">
$(document).ready(function(){
    $("#nav_detail").click(function(){    
    $("#show_detail").show();
    $("#show_rekap").hide();
    $("#show_total").hide();


    });

    $("#nav_rekap").click(function(){    
    $("#show_rekap").show();  
    $("#show_detail").hide();
    $("#show_total").hide();

    });

});
</script>

<?php include 'footer.php'; ?>