<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';


$no_reg = stringdoang($_GET['reg']);
$tgl = stringdoang($_GET['tgl']);
$jam = stringdoang($_GET['jam']);

$username = stringdoang($_SESSION['nama']);

$query = $db->query("SELECT * FROM detail_penjualan WHERE tipe_produk = 'Jasa'  AND no_reg = '$no_reg'  ");

$query1 = $db->query(" SELECT * FROM rekam_medik WHERE no_reg = '$no_reg'");
$data = mysqli_fetch_array($query1);

$query98 = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg' ");
$keluar2 = mysqli_fetch_array($query98);
$penjamin = $keluar2['penjamin'];



$qertu = $db->query("SELECT pp.nama_paramedik,u.id FROM penetapan_petugas pp LEFT JOIN user u ON pp.nama_paramedik = u.nama ");
$ss_paramedik = mysqli_fetch_array($qertu);

$qertu2 = $db->query("SELECT pp.nama_farmasi,u.id FROM penetapan_petugas pp LEFT JOIN user u ON pp.nama_farmasi = u.nama ");
$ss_farmasi = mysqli_fetch_array($qertu2);


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
      
    </div>
    <div class="modal-footer">
        <a href="selesai_rj.php?no_reg=<?php echo $no_reg;?>" class="btn btn-success" id="yesss" >Yes</a>
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
       <center> <button type="button" accesskey="e" class="btn btn-warning" data-dismiss="modal">Clos<u>e</u></button></center>
      </div>
    </div>
  </div>
</div>
  
<!-- akhir modal Cari Produk-->

<!-- AKHIR MODAL untuk tambah Tindakan -->


 <div class="container">
   <h3>INPUT TINDAKAN R.JALAN</h3><hr>

<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
      <li class="nav-item"><a class="nav-link " href="rekam_medik_raja.php"> Pencarian Rekam Medik </a></li>
        <li class="nav-item"><a class="nav-link" href="input_rekammedik_raja.php?no_reg=<?php echo $no_reg;?>&tgl=<?php echo $tgl;?>&jam=<?php echo $jam;?>" >Data Pemeriksaan</a></li>
         <li class="nav-item"><a class="nav-link " href="obat_rawat_jalan.php?reg=<?php echo $no_reg; ?>&tgl=<?php echo $tgl;?>&jam=<?php echo $jam;?>" >Obat-Obatan</a></li>
          <li class="nav-item"><a class="nav-link active" href="tindakan_rawat_jalan.php?reg=<?php echo $no_reg; ?>&tgl=<?php echo $tgl;?>&jam=<?php echo $jam;?>">Tindakan</a></li>
</ul>

<br>

 <div class="card card-block" style="width:1000px">
<h3>
<div class="row">

<div class="col-sm-6">
      <table>
      <tr><td>No RM</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['no_rm']; ?></td></tr>
      <tr><td>Nama Pasien</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['nama']; ?></td></tr>
</table>
</div>

<div class="col-sm-6">
      <table>
    <tr><td>Tanggal / Jam</td><td>&nbsp;:&nbsp;</td><td><?php echo $tgl; ?> / <?php echo $jam; ?></td></tr>
      <tr><td>Alamat</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['alamat']; ?></td></tr>
</table>
</div>

</div> 
</h3>
  



<div class="col-sm-2">

  <div class="form-group">

     <label for="penjamin">Dokter Jaga:</label><br>
     <input style="height: 15px;" type="text" class="form-control" id="dokter" name="dokter" value="<?php echo $data['dokter'];?>" readonly="" >
</div>
</div>


<div class="col-sm-2">
<div class="form-group">

     <label for="penjamin">Petugas:</label><br>
     <input style="height: 15px;" type="text" class="form-control" id="petugas" name="petugas" value="<?php echo $username;?>" readonly="" >
</div>
</div>

<div class="col-sm-2">
<div class="form-group">

     <label for="penjamin">Penjamin:</label><br>
     <input style="height: 15px;" type="text" class="form-control" id="penjamin" name="penjamin" value="<?php echo $penjamin;?>" readonly="" >
</div>
</div>


<?php

$select_to = $db->query("SELECT no_reg,status,perawat,apoteker FROM penjualan WHERE no_reg = '$no_reg' "); 
$out_of = mysqli_fetch_array($select_to);
$status_bayar = $out_of['status'];

$select_perawat = $db->query("SELECT p.perawat,u.nama FROM penjualan p LEFT JOIN user u ON p.perawat = u.id WHERE p.no_reg = '$no_reg' "); 
$out_perawat = mysqli_fetch_array($select_perawat);


$select_apoteker = $db->query("SELECT p.apoteker,u.nama FROM penjualan p LEFT JOIN user u ON p.apoteker = u.id WHERE p.no_reg = '$no_reg' "); 
$out_apoteker = mysqli_fetch_array($select_apoteker);

if ($status_bayar == 'Lunas' OR $status_bayar == 'Piutang'):?> 

<div class="col-sm-2">
<div class="form-group">
     <label for="Petugas Paramedik">Petugas Paramedik:</label><br>
     <input style="height: 15px;" type="text" class="form-control" id="perawat2" name="perawat2" value="<?php echo $out_perawat['nama']; ?>" readonly="" >
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
     <label for="">Petugas Farmasi:</label><br>
     <input style="height: 15px;" type="text" class="form-control" id="apoteker2" name="apoteker2" value="<?php echo $out_apoteker['nama']; ?>" readonly="" >
</div>
</div>



<?php else: ?>



<div class="col-sm-2">
<div class="form-group">
     <label for="penjamin">Petugas Paramedik:</label><br>
     <select type="text" class="form-control" id="perawat" placeholder="Isi Perawat" autocomplete="off">
<option value="<?php echo $ss_paramedik['id'];?>"><?php echo $ss_paramedik['nama_paramedik'];?></option>
    <?php 
    $query99 = $db->query("SELECT id,nama FROM user WHERE otoritas = 'Petugas Paramedik' ");
    while ( $data99 = mysqli_fetch_array($query99)) {
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
<option value="<?php echo $ss_farmasi['id'];?>"><?php echo $ss_farmasi['nama_farmasi'];?></option>
     <?php 
     $query09 = $db->query("SELECT id,nama FROM user WHERE otoritas = 'Petugas Farmasi' ");
     while ( $data09 = mysqli_fetch_array($query09)) {
     echo "<option value='".$data09['id']."'>".$data09['nama']."</option>";
     }
     ?>

    </select> 
</div>
</div>




<?php endif;?>


<?php
$select_to = $db->query("SELECT no_reg,status FROM penjualan WHERE no_reg = '$no_reg'"); 
$out_of = mysqli_fetch_array($select_to);
$status_bayar = $out_of['status'];

if ($status_bayar == 'Lunas' OR $status_bayar == 'Piutang'):?> 

<div class="col-sm-12">
<button data-no-reg='".$no_reg."' style='background-color:#80deea;' class='btn btn-default selesai'><i class='fa fa-send'></i> Selesai </button>
</div>

<br><br>

<?php else: ?>

<div class="col-sm-12">
<!-- OPEN FORM CARI PRODUK -->
<button type="button" accesskey="c" id="cari_produk" class="btn btn-danger" data-target="#myModal2" data-toggle="modal"><i class="fa fa-search"></i> Cari(F1)</button>
<br>
<br>
</div>


  <form class="form" role="form" id="formnya"  method="POST">


<div class="col-sm-4">
<div class="form-group">  
 <select style="height: 15px;" type="text" class="form-control chosen" accesskey="q" id="kode_produk" autocomplete="off" style="width:400px" name="kode_produk">
  <option value="">SILAKAN PILIH</option>
 <?php 
        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk_tindakan');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        ?>
    </select>

</div>
</div>
 
<div class="form-group">    
    <input style="height: 15px;" type="hidden" class="form-control" id="nama_produk" name="nama_produk" style="width:150px" placeholder="Kode Produk" readonly=""  >
</div>
    

<div class="col-sm-3">
  <div class="form-group"> 
      <input style="height: 15px;" type="text" class="form-control" id="jumlah_produk" name="jumlah_produk" style="width:100px" placeholder="Jumlah " autocomplete="off">
  </div>
</div>

<div class="col-sm-3">
<button type="submit" accesskey="t" class="btn btn-primary" id="submit_produk"><i class="fa fa-plus"></i>Tambah (F3)</button>
</div>
</form>

<div class="col-sm-12">

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
         <th style='background-color: #4CAF50; color: white'>Jumlah</th>
         <th style='background-color: #4CAF50; color: white'>Waktu</th>

          <?php 
         $sss = $db->query("SELECT * FROM detail_penjualan WHERE no_reg ='$no_reg' AND tipe_produk = 'Jasa' ORDER BY id DESC");
         $asa1 = mysqli_num_rows($sss);
         if($asa1 > 0) {?>

       <?php } else { ?>
       <th style='background-color: #4CAF50; color: white'>Batal</th>
       <?php } ?>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
$query5 = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Jasa' ORDER BY id DESC");
 

$ss = $db->query("SELECT * FROM detail_penjualan WHERE no_reg ='$no_reg' AND tipe_produk = 'Jasa' ORDER BY id DESC");
$asa = mysqli_num_rows($ss);
if ($asa == 0)
{

   while($data = mysqli_fetch_array($query5))
      {
     echo 
      "<tr class='tr-id-".$data['id']." tr-kode-".$data['kode_barang']."' data-kode-barang='".$data['kode_barang']."' >
      <td>". $data['no_reg']."</td>
      <td>". $data['kode_barang']."</td>
      <td>". $data['nama_barang']."</td>
      <td>". $data['jumlah_barang']."</td>
            <td>". $data['tanggal']." ".$data['jam']."</td>

      <td><button class='btn btn-danger btn-sm batal' data-id='".$data['id']."' data-reg='". $data['no_reg']."' data-kode-barang='". $data['kode_barang']."'>
      <i class='fa fa-remove'></i> Batal </button></td>
      </tr>";
       }


}
else
{


   while($data = mysqli_fetch_array($ss))
      
      {
      echo 
      "<tr>
      <td>". $data['no_reg']."</td>
      <td>". $data['kode_barang']."</td>
      <td>". $data['nama_barang']."</td>
      <td>". $data['jumlah_barang']."</td>
      </tr>";
      }
 }
      

    ?>
  </tbody>
 </table>
    </div> <!-- table responsive -->

            <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Tindakan atau Nama Tindakan.</b></i></h6>


  </span>
</div>
</div>

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

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_produk").trigger("chosen:open");

    });
</script>


<!—- SCRIPT AMBIL DATA FORM PRODUK -—>
<script type="text/javascript">

    $(document).on('click', '.pilih', function (e) {

            document.getElementById("kode_produk").value = $(this).attr('data-kode-x');
            $("#kode_produk").trigger("chosen:updated");

            document.getElementById("nama_produk").value = $(this).attr('nama-barang');
            document.getElementById("limit").value = $(this).attr('limit_stok');
            document.getElementById("tipe_produk").value = $(this).attr('ber-stok');

    var no_reg = $("#no_reg").val();
      var kode = $("#kode_produk").val();
    
$.post("cek_kode_barang_tbs_penjualan.php",{kode_barang:kode,no_reg:no_reg},function(data){

               if(data == 1)
               {
                alert("Anda Tidak Bisa Menambahkan Jasa / Tindakan Yang Sudah Ada");
              $("#kode_produk").val('');
              $("#kode_produk").trigger('chosen:updated');
              $("#kode_produk").trigger('chosen:open');
               $("#nama_produk").val('');
                
                }                      
            });




     $("#jumlah_produk").focus();
 $("select").chosen();
    $('#myModal2').modal('hide');
});
//            tabel lookup mahasiswa
  
</script>
<!--END AMBIL DATA FORM PRODUK —>



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
                var dokter =  $("#dokter").val();
                var penjamin =  $("#penjamin").val();
                var petugas = $("#petugas").val();
                var apoteker =$("#apoteker").val();
                var perawat = $("#perawat").val();
                var tipe = $("#tipe_produk").val();
                var no_reg = $("#no_reg").val();
                var no_rm = $("#no_rm").val();
                var cek_barang = $(".tr-kode-"+kode+"").attr("data-kode-barang");
 
       if (kode == ''){
        window.alert("Kode Obat Obatan Harus Terisi");} 

      else if(nama == ''){ 
        window.alert("Nama Obat Obatan Harus Terisi");}

      else if(jumlah == ''){
        window.alert("Jumlah Obat Obatan Harus Terisi");}

      else if(jumlah == 0){
        window.alert("Jumlah Obat Obatan Tidak boleh 0 ");}
    
      else {

          $.post("proses_tambah_tindakan.php",{no_rm:no_rm,dokter:dokter,no_reg:no_reg,tipe:tipe,
          kode:kode,nama:nama,jumlah:jumlah,stok:stok,sisa:sisa,penjamin:penjamin
          ,petugas:petugas,apoteker:apoteker,perawat:perawat},function(data){ 

             $("#tbody").prepend(data);
             $("#kode_produk").val('');
             $("#kode_produk").trigger("chosen:updated");
             $("#kode_produk").trigger("chosen:open");
             $("#jumlah_produk").val('');
             $("#stok").val('');
             $("#limit").val('');
             $("#tipe_produk").val('');
             $("#nama_produk").val('');
          
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
      $.post('modal_jual_baru_tindakan.php',{kode_pelanggan:kode_pelanggan},function(data) {
      
      $("#table-produk").html(data);

      });
      /* Act on the event */
      });

   </script>


<!-- Script Datalist Produk -->
 <script type="text/javascript">
   $(document).ready(function(){

          $("#kode_produk").change(function(){
    var kode = $(this).val();
    var nama = $('#opt-produk-'+kode).attr("nama-barang");
    var harga_jual = $('#opt-produk-'+kode).attr("harga");
    var harga_jual2 = $('#opt-produk-'+kode).attr('harga_jual_2');  
    var harga_jual3 = $('#opt-produk-'+kode).attr('harga_jual_3');
    var harga_jual4 = $('#opt-produk-'+kode).attr('harga_jual_4');
    var harga_jual5 = $('#opt-produk-'+kode).attr('harga_jual_5');  
    var harga_jual6 = $('#opt-produk-'+kode).attr('harga_jual_6');
    var harga_jual7 = $('#opt-produk-'+kode).attr('harga_jual_7');
    var jumlah_barang = $('#opt-produk-'+kode).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode).attr("satuan");
    var kategori = $('#opt-produk-'+kode).attr("kategori");
    var status = $('#opt-produk-'+kode).attr("status");
    var suplier = $('#opt-produk-'+kode).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode).attr("limit_stok");
    var ber_stok = $('#opt-produk-'+kode).attr("ber-stok");
    var tipe_barang = $('#opt-produk-'+kode).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode).attr("id-barang");
     var no_reg = $("#no_reg").val();

                    
                    $("#nama_produk").val(nama);
                    $("#tipe_produk").val(tipe_barang);
                   $("#limit").val(limit_stok);         

    

$.post("cek_kode_barang_tbs_penjualan.php",{kode_barang:kode,no_reg:no_reg},function(data){

               if(data == 1)
               {
                alert("Anda Tidak Bisa Menambahkan Jasa / Tindakan Yang Sudah Ada");
              $("#kode_produk").val('');
              $("#kode_produk").trigger('chosen:updated');
              $("#kode_produk").trigger('chosen:open');
               $("#nama_produk").val('');
                
                }                      
            });

});
                                                    
});
</script>


<!--   script modal confirmasi SELESAI -->
<script type="text/javascript">
$(".selesai").click(function(){

  var reg = $(this).attr('data-no-reg');


$("#modal-selesai").modal('show');
$("#reg2").val(reg);


});


</script>
<!--   end script modal confiormasi SELESAI -->


      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>


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