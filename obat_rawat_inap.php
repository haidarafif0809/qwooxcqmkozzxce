<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';



$session_id = session_id();


$no_reg = stringdoang($_GET['reg']);
$tgl = stringdoang($_GET['tgl']);
$jam = stringdoang($_GET['jam']);
  $id = angkadoang($_GET['id']);

$username = stringdoang($_SESSION['nama']);

$query = $db->query("SELECT * FROM detail_penjualan WHERE no_reg = '$no_reg' AND tipe_produk = 'Obat Obatan' ");

$query1 = $db->query("SELECT * FROM rekam_medik_inap WHERE no_reg = '$no_reg'");
$data1 = mysqli_fetch_array($query1);

$query98 = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg' ");
$keluar2 = mysqli_fetch_array($query98);
$penjamin = $keluar2['penjamin'];


$qertu = $db->query("SELECT pp.nama_dokter,u.id FROM penetapan_petugas pp LEFT JOIN user u ON pp.nama_dokter = u.nama ");
$ss_dokter = mysqli_fetch_array($qertu);

$qertu2 = $db->query("SELECT pp.nama_paramedik,u.id FROM penetapan_petugas pp LEFT JOIN user u ON pp.nama_paramedik = u.nama ");
$ss_paramedik = mysqli_fetch_array($qertu2);

$qertu3 = $db->query("SELECT pp.nama_farmasi,u.id FROM penetapan_petugas pp LEFT JOIN user u ON pp.nama_farmasi = u.nama ");
$ss_farmasi = mysqli_fetch_array($qertu3);

 ?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->




<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<!-- Modal Untuk Confirm SELESAI-->
<div id="modal-selesai" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <center><h4>Anda Yakin Ingin Menyelesaikan Data Rekam Medik Ini ?</h4></center>
    
      <input style="height: 15px;" type="hidden" id="reg2" name="reg2">
            <input style="height: 15px;" type="hidden" id="id2" name="id2">

      
    </div>
    <div class="modal-footer">
        <a href="selesai_ri.php?no_reg=<?php echo $no_reg;?>&id=<?php echo $id;?>" class="btn btn-success" id="yesss" >Yes</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm SELESAI-->


<!-- Modal Cari Produk -->
<div id="myModal2" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center><b>Cari Produk</b></center></h4>
      </div>
      <div class="modal-body">
          <span id="table-produk">
     

              </span> 
            </div> <!--  clsoed modal body  -->
          <div class="modal-footer">
      <center> <button type="button" class="btn btn-danger" accesskey="e" data-dismiss="modal">Clos<u>e</u></button></center> 
      </div>
    </div>
  </div>
</div>
  
<!-- akhir modal Cari Produk-->

<!-- AKHIR MODAL untuk tambah obat obatan -->

 <div class="container"> 
 <h3>INPUT OBAT OBATAN R.INAP</h3><hr>


<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
    
    <li class="nav-item"><a class="nav-link" href='rekam_medik_ranap.php'> Pencarian Rekam Medik </a></li>
   
  <li class="nav-item"><a class="nav-link " href="input_rekam_medik_ranap.php?no_reg=<?php echo $no_reg;?>&id=<?php echo $id;?>&tgl=<?php echo $tgl;?>&jam=<?php echo $jam;?>">Data Pemeriksaan</a></li>

    <li class="nav-item" ><a class="nav-link active" href="obat_rawat_inap.php?reg=<?php echo $no_reg; ?>&id=<?php echo $id;?>&tgl=<?php echo $tgl;?>&jam=<?php echo $jam;?>">Obat-Obatan</a></li>

    <li class="nav-item" ><a class="nav-link" href="tindakan_rawat_inap.php?reg=<?php echo $no_reg; ?>&id=<?php echo $id;?>&tgl=<?php echo $tgl;?>&jam=<?php echo $jam;?>">Tindakan</a></li>

</ul>
 
<br>

  <div class="card card-block" style="width:1000px">
<h3>
<div class="row">

<div class="col-sm-6">
      <table>
      <tr><td>No RM</td><td>&nbsp;:&nbsp;</td><td><?php echo $data1['no_rm']; ?></td></tr>
      <tr><td>Nama Pasien</td><td>&nbsp;:&nbsp;</td><td><?php echo $data1['nama']; ?></td></tr>
</table>
</div>

<div class="col-sm-6">
      <table>
    <tr><td>Tanggal / Jam</td><td>&nbsp;:&nbsp;</td><td><?php echo $tgl; ?> / <?php echo $jam; ?></td></tr>
      <tr><td>Alamat</td><td>&nbsp;:&nbsp;</td><td><?php echo $data1['alamat']; ?></td></tr>
</table>
</div>

</div> 
</h3>




<div class="col-sm-2">
<div class="form-group">
     <label for="penjamin">Petugas:</label>
     <br>
     <input style="height: 15px;" type="text" class="form-control" id="petugas" name="petugas" value="<?php echo $username;?>" readonly="" >
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
     <label for="penjamin">Penjamin:</label>
     <br>
     <input style="height: 15px;" type="text" class="form-control" id="penjamin" name="penjamin" value="<?php echo $penjamin;?>" readonly="" >
</div>
</div>

<?php

$select_to = $db->query("SELECT no_reg,status FROM penjualan WHERE no_reg = '$no_reg' "); 
$out_of = mysqli_fetch_array($select_to);
$status_bayar = $out_of['status'];

$select_dokter = $db->query("SELECT p.dokter,u.nama FROM penjualan p LEFT JOIN user u ON p.dokter = u.id WHERE p.no_reg = '$no_reg' "); 
$out_dokter = mysqli_fetch_array($select_dokter);

$select_perawat = $db->query("SELECT p.perawat,u.nama FROM penjualan p LEFT JOIN user u ON p.perawat = u.id WHERE p.no_reg = '$no_reg' "); 
$out_perawat = mysqli_fetch_array($select_perawat);


$select_apoteker = $db->query("SELECT p.apoteker,u.nama FROM penjualan p LEFT JOIN user u ON p.apoteker = u.id WHERE p.no_reg = '$no_reg' "); 
$out_apoteker = mysqli_fetch_array($select_apoteker);


?>

<?php if ($status_bayar == 'Lunas' OR $status_bayar == 'Piutang'):  ?>

<div class="col-sm-2">

<div class="form-group">
     <label for="penjamin">Dokter Jaga:</label>
     <br>
     <input style="height: 15px;" type="text" class="form-control" id="dokter2" name="dokter2" value="<?php echo $out_dokter['nama'];?>" readonly="" >
</div>
</div>


<div class="col-sm-2">
<div class="form-group">
     <label for="Petugas Paramedik">Petugas Paramedik:</label>
     <br>
     <input style="height: 15px;" type="text" class="form-control" id="perawat2" name="perawat2" value="<?php echo $out_perawat['nama'];?>" readonly="" >
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
     <label for="">Petugas Farmasi:</label>
     <br>
     <input style="height: 15px;" type="text" class="form-control" id="apoteker2" name="apoteker2" value="<?php echo $out_apoteker['nama'];?>" readonly="" >
</div>
</div>



<?php else: ?>

<div class="col-sm-2">
<div class="form-group">
     <label for="penjamin">Dokter Jaga:</label><br>
     <select type="text" class="form-control" id="dokter" placeholder="Isi Dokter" autocomplete="off">
<option value="<?php echo $ss_dokter['id']; ?>"><?php echo $ss_dokter['nama_dokter']; ?></option>

    <?php 
    $query99 = $db->query("SELECT id,nama FROM user WHERE otoritas = 'Dokter' ");
    while ($data99 = mysqli_fetch_array($query99)) {
    echo "<option value='".$data99['id']."'>".$data99['nama']."</option>";
    }
    ?>



    </select> 
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
     <label for="penjamin">Petugas Paramedik:</label><br>
     <select type="text" class="form-control" id="perawat" placeholder="Isi Perawat" autocomplete="off">
<option value="<?php echo $ss_paramedik['id']; ?>"><?php echo $ss_paramedik['nama_paramedik']; ?></option>

    <?php 
    $query99 = $db->query("SELECT id,nama FROM user WHERE otoritas = 'Petugas Paramedik' ");
    while ($data99 = mysqli_fetch_array($query99)) {
    echo "<option value='".$data99['id']."'>".$data99['nama']."</option>";
    }
    ?>



    </select> 
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
     <label for="penjamin">Petugas Farmasi:</label><br>
     <select type="text" class="form-control" id="apoteker" placeholder="Isi Apoteker" autocomplete="off">
<option value="<?php echo $ss_farmasi['id']; ?>"><?php echo $ss_farmasi['nama_farmasi']; ?></option>
     <?php 
     $query09 = $db->query("SELECT id,nama FROM user WHERE otoritas = 'Petugas Farmasi' ");
     while ( $data09 = mysqli_fetch_array($query09)) {
     echo "<option value='".$data09['id']."'>".$data09['nama']."</option>";
     }
     ?>

  
    </select> 
</div>
</div>


<?php endif ;?>


<?php
$select_to = $db->query("SELECT no_reg,status FROM penjualan WHERE no_reg = '$no_reg'"); 
$out_of = mysqli_fetch_array($select_to);
$status_bayar = $out_of['status'];

if ($status_bayar == 'Lunas' OR $status_bayar == 'Piutang'):?> 


<!-- untuk confirmasi SELESAI -->
<br><br>

<button data-no-reg=<?php echo $no_reg;?> data-id=<?php echo $id;?> style='background-color:#80deea;' class='btn btn-default selesai'><i class='fa fa-send'></i> Selesai </button>
<br><br>


<?php else:?>


<div class="col-sm-12">
<!-- OPEN FORM CARI PRODUK -->
<button type="button" id="cari_produk" accesskey="c" class="btn btn-danger" data-target="#myModal2" data-toggle="modal"><i class="fa fa-search"></i>Cari (F1)</button>
<br>
<br>


  <form class="form" role="form" id="formnya" method="POST">

<div class="row">
  <div class="form-group col-sm-3">  
    <select style="height: 15px;" type="text" class="form-control chosen" accesskey="q" id="nama_produk" autocomplete="off" style="width:400px" name="nama_produk">
    <option>Nama Produk</option>
     <?php 
     $produk = $db->query("SELECT kode_barang, nama_barang FROM barang WHERE tipe_barang = 'Obat Obatan' ");
     while ( $data09 = mysqli_fetch_array($produk)) {
     echo "<option value='".$data09['nama_barang']."'>".$data09['nama_barang']."</option>";
     }
     ?>
    </select>
</div>
    
<input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">



  <div class="form-group col-sm-2">  
    <input style="height: 15px;" type="text" class="form-control" id="kode_produk" name="kode_produk" style="width:150px" placeholder="Kode Produk" readonly=""  >
</div>
    

  <div class="form-group col-sm-2">  
    <input style="height: 15px;" type="text" class="form-control" id="jumlah_produk" name="jumlah_produk" style="width:100px" placeholder="Jumlah " autocomplete="off">
</div>


  <div class="form-group col-sm-2">  
  <input style="height: 15px;" type="text" class="form-control" id="dosis" name="dosis" placeholder="Isi Dosis" style="width:100px" autocomplete="off">
</div>



<!-- AKHIR YANG DI HIDDEN DI PRODUK -->

 <div class="col-sm-3">  
<button type="submit" accesskey="t" class="btn btn-primary" id="submit_produk"> <i class="fa fa-plus"></i>Tambah (F3)</button>
</div>
</form> <!-- AKHIR FORM PRODUK -->



<br>

</div>


<?php endif;?>
<!-- AKHIR confirmasi SELESAI -->

<!-- YANG DI HIDDEN DI PRODUK -->
<input style="height: 15px;" type="hidden" id="stok" name="stok">
<input style="height: 15px;" type="hidden" id="tipe_produk" name="tipe_produk">
<input style="height: 15px;" type="hidden" id="limit" name="limit">
<input style="height: 15px;" type="hidden" id="no_rm" name="no_rm" value="<?php echo $keluar2['no_rm'];?>">
<input style="height: 15px;" type="hidden" id="no_reg" name="no_reg" value="<?php echo $no_reg;?>">


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="col-sm-12">
<span id="result">
  <div class="table-responsive">
<table id="table-pelamar" class="table table-sm">
 
    <thead>
      <tr>
         <th style='background-color: #4CAF50; color: white'>No Reg</th>
         <th style='background-color: #4CAF50; color: white'>Kode  </th>
         <th style='background-color: #4CAF50; color: white'>Nama  </th>
         <th style='background-color: #4CAF50; color: white'>Dosis </th>
         <th style='background-color: #4CAF50; color: white'>Jumlah</th>

         <?php 
         $sss = $db->query("SELECT * FROM detail_penjualan dp  LEFT JOIN barang b ON dp.kode_barang = b.kode_barang  WHERE dp.no_reg ='$no_reg' AND b.tipe_barang = 'Obat Obatan' ORDER BY dp.id DESC");
         $asa1 = mysqli_num_rows($sss);
         if($asa1 > 0) {?>

       <?php } else { ?>
       <th style='background-color: #4CAF50; color: white'>Batal</th>
       <?php } ?>
         
    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 

$query5 = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg ='$no_reg' AND tipe_barang = 'Obat Obatan' ORDER BY id DESC");

$ss = $db->query("SELECT dp.no_reg,dp.kode_barang,dp.nama_barang,dp.dosis,dp.id,dp.jumlah_barang FROM detail_penjualan dp  LEFT JOIN barang b ON dp.kode_barang = b.kode_barang  WHERE dp.no_reg ='$no_reg' AND b.tipe_barang = 'Obat Obatan' 
          ORDER BY dp.id DESC");
$asa = mysqli_num_rows($ss);
if ($asa > 0)
      {
        $delete2 = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
   while($data00 = mysqli_fetch_array($ss))
      
      {
      echo 
      "<tr>
      <td>". $data00['no_reg']."</td>
      <td>". $data00['kode_barang']."</td>
      <td>". $data00['nama_barang']."</td>";
      if ($data00['dosis'] == '')
      {
 echo "<td style='background-color:#90caf9;cursor:pointer;'><span class='text-dosis' data-id='". $data00['id']."' id='text-dosis-". $data00['id']."'></span>
      <input autofocus='' class='input-dosis' type='text' id='input-dosis-". $data00['id']."'  data-id='". $data00['id']."' value='".$data00['dosis']."'></td>";
      }
      else
      {
        echo "<td style='background-color:#90caf9;cursor:pointer;'><span class='text-dosis' data-id='". $data00['id']."' id='text-dosis-". $data00['id']."'>". $data00['dosis']."</span>
      <input autofocus='' class='input-dosis' type='hidden' id='input-dosis-". $data00['id']."' data-id='". $data00['id']."' value='".$data00['dosis']."'></td>";
      }
     
      echo "<td>". $data00['jumlah_barang']."</td>
          
      </tr>";
      }


      }


else
      {

 while($data01 = mysqli_fetch_array($query5))
      
      {

      echo 
      "<tr class='tr-id-".$data01['id']." tr-kode-".$data01['kode_barang']."' data-kode-barang='".$data01['kode_barang']."' >
      <td>". $data01['no_reg']."</td>
      <td>". $data01['kode_barang']."</td>
      <td>". $data01['nama_barang']."</td>
      <td>". $data01['dosis']."</td>
      <td>". $data01['jumlah_barang']."</td>
      <td><button class='btn btn-danger btn-sm batal' data-id='".$data01['id']."' data-reg='". $data01['no_reg']."' data-kode-barang='".$data01['kode_barang']."'><i class='fa fa-remove'></i> Batal </button></td>

      </tr>";
      }


  
      }
    ?>
  </tbody>
 </table>
</div> <!--  table responsvie -->
</span>
</div>
</div>
</div> <!-- container  -->

<script type="text/javascript">
    $(document).on('click', '.batal', function (e) {
    var id = $(this).attr("data-id");
    var no_reg = $(this).attr("data-reg");
    var kode_barang = $(this).attr("data-kode-barang");


    $(".tr-id-"+id+"").remove();
    $.post("batal_obat_rekam_medik.php",{id:id,no_reg:no_reg,kode_barang:kode_barang},function(data){
      
    });

  });
</script>


<!-- Script langsung FOCUS jumlah produk  -->                          
 <script type="text/javascript">
      $("#kode_produk").focus(function()
      {

            $("#jumlah_produk").focus();
        
      }); 
</script>
<!-- Akhir Script FOCUS jumlah produk -->

<!--   script untuk EDIT DOUBLE KLIK -->
<script type="text/javascript">
$(".text-dosis").dblclick(function(){
   var id = $(this).attr('data-id');
      $(this).hide();
$("#input-dosis-"+id+"").attr('type','text');

});
</script>
<!--  end script untuk EDIT DOUBLE KLIK -->

<!--  Script Untuk Proses Edit Dosis -->
<script type="text/javascript">
$(".input-dosis").blur(function(){

var id = $(this).attr('data-id');
var dosis = $(this).val();

if (dosis == 0)
{

}
else
  {
$.post('proses_dosis.php',{id:id,dosis:dosis},function(data){ // INI PROSES POST NYA
 
     $("#input-dosis-"+id+"").attr('type','hidden'); // di hidden dari double clicknya
       $("#text-dosis-"+id+"").show(); // text dosis tampilkan lagi
      $("#text-dosis-"+id+"").text(dosis); // untuk ubah text nya yang di masukin baru
    });
  }
});
</script>
<!--  END Script Untuk Proses Edit Dosis  -->

<!—- SCRIPT AMBIL DATA FORM PRODUK —->
<script type="text/javascript">

    $(document).on('click', '.pilih', function (e) {

            $("select").chosen("destroy");
            document.getElementById("kode_produk").value = $(this).attr('data-kode-x');
            document.getElementById("nama_produk").value = $(this).attr('nama-barang');
            document.getElementById("limit").value = $(this).attr('limit_stok');
            document.getElementById("tipe_produk").value = $(this).attr('ber-stok');
            document.getElementById("stok").value = $(this).attr('jumlah-barang');


$("#jumlah_produk").focus();
 $("select").chosen();
    $('#myModal2').modal('hide');
});
     
//            tabel lookup mahasiswa
  
</script>


<!--script chossen-->
<script>
$("select").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
<!--script end chossen-->



<!-- SCRIPT TAMBAH PRODUK TBS -->
<script type="text/javascript">
      $("#submit_produk").click(function() {
                var kode =  $("#kode_produk").val();
                var nama =  $("#nama_produk").val();
                var jumlah = $("#jumlah_produk").val();
                var stok =$("#stok").val();
                var sisa = stok-jumlah;
                var no_faktur = $("#no_faktur").val();
                var dokter =  $("#dokter").val();
                var penjamin =  $("#penjamin").val();
                var petugas = $("#petugas").val();
                var apoteker =$("#apoteker").val();
                var perawat = $("#perawat").val();
                var tipe = $("#tipe_produk").val();
                var no_reg = $("#no_reg").val();
                var dosis = $("#dosis").val();
                var dokter = $("#dokter").val();
                var no_rm = $("#no_rm").val();
                var session_id = $("#session_id").val();
                var cek_barang = $(".tr-kode-"+kode+"").attr("data-kode-barang");
 

       if (kode == ''){
        window.alert("Kode Obat Obatan Harus Terisi");} 

      else if(nama == ''){ 
        window.alert("Nama Obat Obatan Harus Terisi");}

      else if(jumlah == ''){
        window.alert("Jumlah Obat Obatan Harus Terisi");}

      else if(jumlah == 0){
        window.alert("Jumlah Obat Obatan Tidak boleh 0 ");}
    
     else if(dosis == ''){
        window.alert("Dosis Obat Obatan Harus Terisi");}

      else if ( sisa < 0  ){
        window.alert("Stok Obat Obatan Tidak Mencukupi");
        $("#jumlah_produk").val('');
        $("#jumlah_produk").focus();
      }
     else if (kode == cek_barang){
        window.alert("Obat yang anda masukan sudah ada, silahkan pilih obat lain");
        $("#kode_produk").val('');
        $("#nama_produk").val('');
        $("#jumlah_produk").val('');
        $("#stok").val('');
        $("#tipe_produk").val('');
        $("#limit").val('');
        $("#dosis").val('');
        $("select").chosen()
        
      }
      else {

          $.post("proses_tambah_obat_rawat_jalan.php",{no_rm:no_rm,dokter:dokter,dosis:dosis,no_reg:no_reg,tipe:tipe,
          kode:kode,nama:nama,jumlah:jumlah,stok:stok,sisa:sisa,no_faktur:no_faktur,penjamin:penjamin
          ,petugas:petugas,apoteker:apoteker,perawat:perawat,session_id:session_id},function(data){ 

             $("#tbody").prepend(data);
             $("#nama_produk").chosen("destroy");
             $("#kode_produk").val('');
             $("#jumlah_produk").val('');
             $("#stok").val('');
             $("#potongan").val('');
             $("#pajak").val('');
             $("#nama_produk").val('');
             $("#dosis").val('');
             $("#nama_produk").chosen()
             $("#nama_produk").focus();
          
          });                    

        }

    });

    $("form").submit(function(){

      return false;
    });


</script>
<!--END SCRIPT TAMBAH PRODUK TBS -->


<!-- SCRIPT CEK TABLE PRODUK-->
<script type="text/javascript">

//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk").click(function() {

      
 
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var kode_pelanggan = $("#no_rm").val();
      //coding update jumlah barang baru "rabu,(9-3-2016)"
      $.post('modal_jual_baru_obat.php',{kode_pelanggan:kode_pelanggan},function(data) {
      
      $("#table-produk").html(data);

      });
      /* Act on the event */
      });

   </script>


<!-- Script Datalist Produk -->
 <script type="text/javascript">
          $("#nama_produk").change(function(){
               var nama = $("#nama_produk").val();
               var no_reg = $("#no_reg").val();



        if (nama == '')
          {

          $('#kode_produk').val('');
          $('#stok').val('');
          $('#tipe_produk').val('');

          }
        else
        {
            
            $.post("cek_tbs_rekam_medik_obat.php",{nama:nama,no_reg:no_reg},function(data){
                      
                      if (data == 1) {
                        alert("Barang Yang Anda Masukan Sudah Ada");
                         $('#kode_produk').val(''); 
                         $('#nama_produk').val(''); 
                          $('#nama_produk').focus(); 
                      }
            });



            $.getJSON('lihat_produk_stok_opname.php',{nama_produk:$(this).val()}, function(json){
            
                  if (json == null)
                  {
                    $('#nama_produk').val('');
                    $('#kode_produk').val('');
                    $('#stok').val('');
                    $('#tipe_produk').val('');
                  }

                  else 
                  {
                    $('#stok').val(json.kategori);
                    $('#kode_produk').val(json.kode_barang);
                    $('#tipe_produk').val(json.tipe_barang);
                   $('#limit').val(json.limit_stok);

                  }
                                                    
              });
  


      }
    });

</script>





<!--   script modal confirmasi SELESAI -->
<script type="text/javascript">
$(".selesai").click(function(){

  var reg = $(this).attr('data-no-reg');
  var id = $(this).attr('data-id');


$("#modal-selesai").modal('show');
$("#reg2").val(reg);
$("#id2").val(id);
  

});


</script>
<!--   end script modal confiormasi SELESAI -->

<script> 
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk").click();

    });

        shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    });
</script>

  <?php 
  include 'footer.php';
   ?>
