<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);

$query4 = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg' ");
$data = mysqli_fetch_array($query4);



$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

?>


 <!-- Modal -->
  <div class="container">

<h3>PERMINTAAN PEMERIKSAAN LABORATORIUM R.INAP</h3>
<hr>
<br>
<div class="row">
  <div class="col-sm-6">

     <div class='form-group'>
        <label for="no_reg">No REG:</label>
        <input style="height:20px;" type="text" class="form-control" id="no_reg" name="no_reg" value="<?php echo $data['no_reg'];?>" readonly="">
     </div>

     <div class="form-group">
        <label for="nama_lengkap">No RM:</label>
        <input style="height:20px;" type="text" class="form-control" id="no_rm" name="no_rm" required="" value="<?php echo $data['no_rm'];?>" readonly="">
     </div>


     <div class="form-group">
       <label for="nama_lengkap">Nama Pasien:</label>
       <input style="height:20px;" type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $data['nama_pasien'];?>" required="" readonly="">
     </div>

     <div class="form-group" >
        <label for="penjamin">Nama Kelamin:</label>
        <input style="height:20px;" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $data['jenis_kelamin'];?>" required="" readonly="" >
     </div>

     <div class="form-group" >
       <label for="penjamin">Penjamin:</label>
       <input style="height:20px;" type="text" class="form-control" id="penjamin" name="penjamin" value="<?php echo $data['penjamin'];?>" required="" readonly="" >
     </div>

    </div><!--end div class col sm 1-->
 <div class="col-sm-6"><!--div class col sm 2-->

    <form role="form"  id="formnya" action="proses_tbs_lab_penjualan.php" method="POST" >

<div class="form-group">
   <label for="penjamin">Dokter Pengirim:</label>
   <select  style="height: 20px"class="form-control" id="dokter" name="dokter" required="" >
    <option value="<?php echo $ss['nama_dokter'];?>"><?php echo $ss['nama_dokter'];?></option>
    
   <?php 
     $query0 = $db->query("SELECT * FROM user WHERE otoritas = 'Dokter' ORDER BY status_pakai DESC");
      while ( $data1 = mysqli_fetch_array($query0))
       {
      echo "<option value='".$data1['nama']."'>".$data1['nama']."</option>";
      }
   ?>
  </select>
</div>


  <!-- FORM BAWAH -->
<div class="form-group">
  <label for="penjamin">Kelompok Tarif:</label>
  <input style="height:20px;" type="text" class="form-control" id="kelompok_tarif" name="kelompok_tarif" required=""  value="<?php echo $data['penjamin'];?>" readonly="">
</div>


<div class="form-group">
  <label for="penjamin">Kelompok Pemeriksaan:</label>
 <select  style="height: 20px"class="form-control" id="bidang" name="bidang" required="" >
  <option value="">Silakan Pilih</option>
  <?php 
  $query3 = $db->query("SELECT * FROM bidang_lab ORDER BY id DESC");
  while ( $data4 = mysqli_fetch_array($query3)) 
  {
  echo "<option value='".$data4['nama']."'>".$data4['nama']."</option>";
  }
   ?>
  </select>
</div>

<span id="result">
  <div class="form-group">
    <label for="penjamin">Nama Pemeriksaan:</label>
    <select  style="height: 20px"class="form-control" id="pemeriksaann" name="pemeriksaann" required="" >
    <option value="">Silakan Pilih</option>
</select>
  </div>
</span>


<span id="mel">
<div class="form-group">
  <label for="penjamin">Tarif :</label>
  <input style="height:20px;" type="text" class="form-control" id="tariff" name="tariff" required="" >
  <input style="height:20px;" type="hidden" class="form-control" id="kode_labb" name="kode_labb" required="">
</div>
</span>

<!--input style="height:20px;" data hidden-->
       <input style="height:20px;" type="hidden" class="form-control" id="no_reg2" name="no_reg2" value="<?php echo $data['no_reg'];?>" readonly="">
       <input style="height:20px;" type="hidden" class="form-control" id="no_rm2" name="no_rm2" required="" value="<?php echo $data['no_rm'];?>" readonly="">
       <input style="height:20px;" type="hidden" class="form-control" id="no_faktur2" name="no_faktur2" required=""  readonly="">
       <input style="height:20px;" type="hidden" class="form-control" id="nama_pasien2" name="nama_pasien2" value="<?php echo $data['nama_pasien'];?>" required="" readonly="">
       <input style="height:20px;" type="hidden" class="form-control" id="jenis_kelamin2" name="jenis_kelamin2" value="<?php echo $data['jenis_kelamin'];?>" required="" readonly="" >
       <input style="height:20px;" type="hidden" class="form-control" id="penjamin2" name="penjamin2" value="<?php echo $data['penjamin'];?>" required="" readonly="" >
       <input style="height:20px;" type="hidden" class="form-control" id="kelompok_tarif2" name="kelompok_tarif2" required=""  value="<?php echo $data['penjamin'];?>">
<!--end data input style="height:20px;" hidden-->
<button type="submit" id="submit_produk" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah </button>
</div><!--penutup div col sm 2-->

<!-- END FORM BAWAH -->
</form>
</div><!--penutup div row-->

<span id="mok"><!--span table baru-->
<div class="table-responsive">
<table id="tbs_penjualan" class="table table-bordered">
    <thead>
      <tr>
         <th>Kode  </th>
         <th>Nama  </th>
         <th>Jumlah  </th>
         <th>Harga </th>
         <th>Subtotal</th>
         <th>Tools</th>
    </tr>
    </thead>
  <tbody>
    
   <?php
     $query5 = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg='$no_reg'");
    while($data7 = mysqli_fetch_array($query5))
      {
       $rp = number_format($data7['harga'],0,',','.');
      $rp_sub = number_format($data7['subtotal'],0,',','.');
      echo "<tr>
      <td>". $data7['kode_barang']."</td>
      <td>". $data7['nama_barang']."</td>
      <td>". $data7['jumlah_barang']."</td>
      <td>Rp. ". $rp."</td>
      <td>Rp. ". $rp_sub."</td>
      <td><button type='button' class='btn btn-info pilih1' data-id='". $data7['id']. "' >Batal</button></td>
      </tr>"; 
      }
    ?>
  </tbody>
</table>
</div><!--end div table responsive-->
</span><!--end span table baru-->


</div><!-- penutup div container-->

<!--script tampil data pemeriksaaan -->
<script type="text/javascript">
            $(document).ready(function(){
 $.post('pemeriksaan.php',{bidang:$(this).val()}, function(data){
              if (data == null)
               {
               $('#result').html('');     
               } 
               else 
               {
                $('#result').html(data);
               }
             });
});
</script>


<!--script chossen-->
<script>
$("select").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
<!--script end chossen-->


<script type="text/javascript">
                $("#bidang").change(function(){
          $.post('pemeriksaan.php',{bidang:$(this).val()}, function(data){
              if (data == null)
               {
               $('#result').html('');     
               } 
               else 
               {
                $('#result').html(data);
               }
                    });
                });
          
</script>
<!--end script tampil data pemeriksaaan-->


<!--script tambah pemerikasaan laboraturium-->
 <script type="text/javascript">
     $("#submit_produk").click(function() {
    $.post($("#formnya").attr("action"), $("#formnya :input style="height:20px;"").serializeArray(), function(info) 
    { 
  $("#mok").html(info); 
    });
    clearInput style="height:20px;"();
  
$("#formnya").submit(function()
{
    return false;
});



function clearInput style="height:20px;"()
{
  $("#dokter").val('');
  $("#bidang").val('');
  $("#pemeriksaann").val('');
  $("#tariff").val('');
  $("#dokter").focus();     
};
});
</script>
<!--end script tambah pemeriksaan laboraturium-->


<!--script datatable-->
<script type="text/javascript">

  $(function () {
  $("#tbs_penjualan").dataTable();
  });
  
  </script>
<!--end script datatable-->


<!--script ambil data  dari modal-->
<script>
    $(document).on('click', '.pilih2', function (e) 
            {                
                document.getElementById("kode_produk").value = $(this).attr('data-kode-produk');
                document.getElementById("nama_produk").value = $(this).attr('data-nama-produk');
                document.getElementById("stok").value = $(this).attr('data-stok');
                document.getElementById("jenis_produk").value = $(this).attr('data-jenis');
               ;
                $('#myModal2').modal('hide');
            });
// tabel lookup mahasiswa  
</script>
<!--end script ambil data dari modal-->


<!--script ambil data produk keyup kodeproduk-->
<script type="text/javascript">
$("#kode_produk").keyup(function()
  {
  var kode_produk = $("#kode_produk").val();
  $.post("cek_nama_produk.php",{kode_produk:kode_produk},function(data)
  {
  $("#nama_produk").val(data);
  });
$.post("cek_stok_produk.php",{kode_produk:kode_produk},function(data)
{
  $("#stok").val(data);
});

});
</script>
<!--end script ambil data produk keyup kodeproduk-->


<!--SCRIPT BATAL PERITEM TBS-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input style="height:20px;" dan modal di tutup
      $(document).on('click', '.pilih1', function (e) {
            var id = $(this).attr('data-id');
            var no_faktur = $(this).attr('data-faktur');
              
      $.post("batal_tbs_lab.php",{id:id,no_faktur:no_faktur},function(data){
            $("#mok").html(data);
           $("#dokter").val('');
           $("#bidang").val('');
           $("#pemeriksaann").val('');
           $("#tariff").val('');
           $("#dokter").focus();
            
            });        
            });
// tabel lookup mahasiswa
         
</script>
<!--END SCRIPT BATAL PERITEM TBS -->

<!--footer-->
<?php 
include 'footer.php';
 ?>
<!--end footer-->

  