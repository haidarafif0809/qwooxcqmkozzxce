<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1> BUKU BESAR PER TANGGAL</h1><hr>


<form id="perhari" class="form-inline" action="proses_buku_besar_pertanggal.php" method="POST" role="form">

<div class="form-group">
    <input type="text" class="form-control dsds" id="tanggal" autocomplete="off" name="tanggal" placeholder="Tanggal ">
</div>

<div class="form-group">

    <select  type="text" class="form-control chosen" id="daftar_akun" name="daftar_akun" required="">
    <option value=""> </option>
    <?php 


$ambil_kas = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, jt.kode_akun_jurnal FROM daftar_akun da INNER JOIN jurnal_trans jt ON da.kode_daftar_akun = jt.kode_akun_jurnal GROUP BY da.kode_daftar_akun");

    while($data_kas = mysqli_fetch_array($ambil_kas))
    {
    
    echo "<option value='".$data_kas['kode_daftar_akun'] ."'>".$data_kas['nama_daftar_akun'] ."</option>";

    }

 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>
 </select>
</div>


<div class="form-group">

    <select  type="text" class="form-control" id="rekap" name="rekap">
    <option value="">--SILAKAN PILIH--</option>
    <option value="direkap_perhari"> Direkap Per Hari </option>
    <option value="tidak_direkap_perhari">Tidak Direkap Per Hari </option>
    </select>

</div>
    
<button id="btn-tgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>
<br>
<span id="result"></span>
</div> <!-- END DIV container -->

<!-- Script Untuk Tampilan-->
<script type="text/javascript">
$("#btn-tgl").click(function() {
      var tanggal = $("#tanggal").val();
      var daftar_akun = $("#daftar_akun").val();
      var rekap = $("#rekap").val();
      if (tanggal == "") {
        alert("Silakan isi tanggal terlebih dahulu.");
        $("#tanggal").focus();
      }
      else if (daftar_akun == "") {
        alert("Select an option");
        $("#daftar_akun").focus();
      }
      else if (rekap == "") {
        alert("Silakan Pilih");
        $("#rekap").focus();
      }
      else{



    $.post("proses_buku_besar_pertanggal.php" ,{tanggal:tanggal,daftar_akun:daftar_akun,rekap:rekap},function(data){


    $("#result").html(data); 

  });  
     }
});

$("#perhari").submit(function(){
    return false;
});
function clearInput(){
    $("#perhari :input").each(function(){
        $(this).val('');
    });
};
</script>
<!-- END Script Untuk Tampilan-->


<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( ".dsds" ).datepicker({ dateFormat: "yy-mm-dd", beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
         inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
    } });
  });
</script> 
<!--end SCRIPT datepicker -->

      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

      <?php 
      include 'footer.php';
       ?>