<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);
$tgl = stringdoang($_GET['tgl']);
$jam = stringdoang($_GET['jam']);
$id = stringdoang($_GET['id']);

$query2 = $db->query("SELECT * FROM rekam_medik_ugd INNER JOIN penjualan ON rekam_medik_ugd.no_reg = penjualan.no_reg  WHERE rekam_medik_ugd.id = '$id' ");
$baris = mysqli_num_rows($query2);

if ($baris > 0){

  $query = $db->query("SELECT * FROM rekam_medik_ugd INNER JOIN penjualan ON rekam_medik_ugd.no_reg = penjualan.no_reg  WHERE rekam_medik_ugd.id = '$id'  ");
  $data = mysqli_fetch_array($query);
  $perawat = $data['perawat'];
  $apoteker = $data['apoteker'];
 $dokter2 = $data['dokter'];

  $select = $db->query("SELECT nama FROM user WHERE id = '$perawat'");
  $out = mysqli_fetch_array($select);

  $select1 = $db->query("SELECT nama FROM user WHERE id = '$apoteker'");
  $out1 = mysqli_fetch_array($select1);

  $select2 = $db->query("SELECT nama FROM user WHERE id = '$dokter2'");
  $out2 = mysqli_fetch_array($select2);
  $dokter = $out2['nama'];
}

else{

   $query = $db->query("SELECT * FROM rekam_medik_ugd WHERE id = '$id' ");
  $data = mysqli_fetch_array($query);
  $dokter = $data['dokter'];

  $apoteker = '';
  $perawat = '';

  $select = $db->query("SELECT nama FROM user WHERE id = '$perawat'");
  $out = mysqli_fetch_array($select);

  $select1 = $db->query("SELECT nama FROM user WHERE id = '$apoteker'");
  $out1 = mysqli_fetch_array($select1);
}



$f2 = $db->query("SELECT * FROM detail_penjualan WHERE no_reg = '$data[no_reg]'");
$h2 = mysqli_fetch_array($f2);

 ?>



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
    
      <input style="height:15px" type="hidden" id="reg2" name="reg2">
      
    </div>
    <div class="modal-footer">
        <a href="selesai_ugd.php?no_reg=<?php echo $no_reg;?>&id=<?php echo $id;?>" class="btn btn-success" id="yesss" >Yes</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm SELESAI-->


 <div class="container">
 <h3>INPUT REKAM MEDIK UGD</h3><hr>
 <!-- menu rekam medik -->
<ul class="nav nav-tabs md-pills pills-ins" role="tablist">

  <li class="nav-item"><a class="nav-link" href='rekam_medik_ugd.php'> Pencarian Rekam Medik </a></li>
  <li class="nav-item"><a class="nav-link active" href="input_rekam_medik_ugd.php?no_reg=<?php echo $no_reg;?>&tgl=<?php echo $tgl;?>&id=<?php echo $id;?>&jam=<?php echo $jam;?>">Data Pemeriksaan</a></li>
  <li class="nav-item"><a class="nav-link" href="obat_ugd.php?reg=<?php echo $no_reg; ?>&tgl=<?php echo $tgl;?>&id=<?php echo $id;?>&jam=<?php echo $jam;?>">Obat-Obatan</a></li>
  <li class="nav-item"><a class="nav-link" href="tindakan_ugd.php?reg=<?php echo $no_reg; ?>&tgl=<?php echo $tgl;?>&id=<?php echo $id;?>&jam=<?php echo $jam;?>">Tindakan</a></li>

<!-- akhir menu rekam medik -->
</ul>


<br>
  <div class="card card-block" style="width:700px">
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
    <tr><td>Tanggal / Jam</td><td>&nbsp;:&nbsp;</td><td><?php echo $tgl; ?> / <?php echo $jam;?></td></tr>
      <tr><td>Alamat</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['alamat']; ?></td></tr>
</table>
</div>

</div> 
</h3>
</div>


<!-- untuk confirmasi SELESAI -->
 <?php 
$select_penjualan = $db->query("SELECT status FROM penjualan WHERE no_reg = '$no_reg'");
$out_jual = mysqli_fetch_array($select_penjualan);
$jualan = $out_jual['status'];

if ($jualan == 'Lunas' OR $jualan == 'Piutang' OR $jualan == 'Piutang Apotek')
{
  echo "


<button data-no-reg='".$no_reg."' data-id='".$id."' style='background-color:#80deea;' class='btn btn-default selesai'><span class='glyphicon glyphicon-send'></span> Selesai </button>

";


}
?>
<!-- AKHIR confirmasi SELESAI -->


<form  role="form" action="proses_rekam_medik_ugd.php" method="POST">

<div class="row">
 	<div class="col-sm-3">
  <div class="card card-block">

  <input style="height:15px" type="hidden" name="tanggal_periksa" value="<?php echo $tgl; ?>" >
  <input style="height:15px" type="hidden" name="id" value="<?php echo $id; ?>" >

  <input style="height:15px" type="hidden" name="jam" value="<?php echo $jam;?>" >

<div class="form-group">
   <div class="row">
 	   <div class="col-sm-3">
 		 <label> <b> Dokter Jaga </b> </label>
 	   </div>
	  <div class="col-sm-9">
 	<input style="height:15px" type="text" class="form-control" id="dokter" name="dokter" value="<?php echo $dokter; ?>" readonly="" required=""> 
 </div>
 </div>
</div>



 <div class="form-group">
 <div class="row">
  <div class="col-sm-3">
     <label> <b> Petugas Paramedik </b> </label>
  </div>
      <div class="col-sm-9">

  <input style="height:15px" type="text" class="form-control" id="perawat" name="perawat" value="<?php echo $out['nama']; ?>" readonly="" > 
 </div>
 </div>

 </div><!-- akhir row input -->


 <div class="form-group">
 <div class="row">
  <div class="col-sm-3">
     <label> <b> Petugas Farmasi </b> </label>
  </div>
      <div class="col-sm-9">

  <input style="height:15px" type="text" class="form-control" id="apoteker" name="apoteker" value="<?php echo $out1['nama']; ?>" readonly="" > 
 </div>
 </div>

 </div><!-- akhir row input -->

<div class="form-group">
   <div class="row">
     <div class="col-sm-3">
      <label> <b> No. RM </b> </label>
      </div>
      <div class="col-sm-9">
    <input style="height:15px" type="text" class="form-control" id="no_rm" name="no_rm" value="<?php echo $data['no_rm']; ?>" readonly="" required=""> 
   </div>
  </div>
</div>
 	
      
<div class="form-group">
   <div class="row">
     <div class="col-sm-3">
      <label> <b> No. Reg </b> </label>
      </div>
      <div class="col-sm-9">
      <input style="height:15px" type="text" class="form-control" id="no_reg" name="no_reg" value="<?php echo $data['no_reg']; ?>" readonly="" required=""> 
    </div>
  </div>
</div>
 


<div class="form-group">
    <div class="row">
     <div class="col-sm-3">
    <label> <b> Rujukan </b> </label>
     </div>
   <div class="col-sm-9">
  <input style="height:15px" type="text" class="form-control" id="rujukan" name="rujukan" value="<?php echo $data['rujukan']; ?>" readonly="" required=""> 
  </div>
 </div>
</div>


<div class="form-group">
   <div class="row">
     <div class="col-sm-3">
      <label> <b> Nama </b> </label>
      </div>
      <div class="col-sm-9">
      <input style="height:15px" type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama']; ?>" readonly="" required=""> 
    </div>
  </div>
</div>
      
  
<div class="form-group">
   <div class="row">
     <div class="col-sm-3">   
      <label> <b> Jenis Kelamin </b> </label>
      </div>
      <div class="col-sm-9">
      <input style="height:15px" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $data['jenis_kelamin']; ?>" readonly="" required=""> 
    </div>
  </div>
</div>


<div class="form-group">
  <div class="row">
      <div class="col-sm-3">
      <label> <b> Umur </b> </label>
      </div>
      <div class="col-sm-9">   
      <input style="height:15px" type="text" class="form-control" id="umur" name="umur" value="<?php echo $data['umur']; ?>" readonly="" required=""> 
    </div>
  </div>
</div>
      
 

<div class="form-group">
  <div class="row">
      <div class="col-sm-3">
      <label> <b> Alamat </b> </label>
      </div>
      <div class="col-sm-9">
      <input style="height:15px" type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $data['alamat']; ?>" readonly="" required=""> 
   </div>
  </div>
</div>
 	
 	
 	

<div class="form-group">
  <div class="row">
    <div class="col-sm-3">
  <label for="sel1">Respon Mata (Eye) </label> </label>
</div>
<div class="col-sm-9">
  <select class="form-control" id="eye" name="eye" required="" autocomplete="off">
     <option value="<?php echo $data['eye']; ?>"><?php echo $data['eye']; ?></option>
    <option value="Tidak ada Respon (Meski Dicubit)">Tidak ada Respon (Meski Dicubit)</option>
     <option value="Respon Terhadap nyeri (Dicubit)">Respon Terhadap nyeri (Dicubit)</option>
      <option value="Respon Terhadap suara (Suruh Buka Mata)">Respon Terhadap suara (Suruh Buka Mata)</option>
       <option value="Respon Spontan (Tanpa Stimulus / Rangsang)">Respon Spontan (Tanpa Stimulus / Rangsang)</option>
  </select>
</div>
</div>
</div>

<div class="form-group">
  <div class="row">
    <div class="col-sm-3">
      <label> <b> Respon Ucapan (Verbal) </b> </label>
      </div>
      <div class="col-sm-9">
       <select class="form-control" id="verbal" name="verbal" required="" autocomplete="off">
        <option value="<?php echo $data['verbal']; ?>"><?php echo $data['verbal']; ?></option>
    <option value="Tidak ada Suara">Tidak ada Suara</option>
     <option value="Suara Tidak Jelas (Tanpa Arti, Mengeranga)">Suara Tidak Jelas (Tanpa Arti, Mengeranga)</option>
      <option value="Ucapan Jelas, Subtansi Tidak Jelas/Non-kalimat (Aduh, Ibu)">Ucapan Jelas, Subtansi Tidak Jelas/Non-kalimat (Aduh, Ibu)</option>
       <option value="Berbicara Mengacau (Bingung)">Berbicara Mengacau (Bingung)</option>
        <option value="Berorientasi Baik">Berorientasi Baik</option>   
  </select>
    </div>
  </div>
</div>


<div class="form-group">
  <div class="row">
    <div class="col-sm-3">
      <label> <b> Respon Gerak (Motorik) </b> </label>
      </div>
      <div class="col-sm-9">
       <select class="form-control" id="motorik" name="motorik" required="" autocomplete="off">
         <option value="<?php echo $data['motorik']; ?>"><?php echo $data['motorik']; ?></option>
    <option value="Tidak Ada (flasid)">Tidak Ada (flasid)</option>
     <option value="Exstensi Abnormal">Exstensi Abnormal</option>
      <option value="Fleksi Abnormal">Fleksi Abnormal</option>
       <option value="Fleksi Normal (Menarik Anggota yang Dirangsang)">Fleksi Normal (Menarik Anggota yang Dirangsang)</option>
        <option value="Melokalisir Nyeri (Menjauhkan Saat Diberi Rangsang Nyeri)">Melokalisir Nyeri (Menjauhkan Saat Diberi Rangsang Nyeri)</option>
         <option value="Ikut Perintah">Ikut Perintah</option>  
  </select>
    </div>
  </div>
</div>



<div class="form-group">
  <div class="row">
    <div class="col-sm-3">
      <label> <b> Alergi </b> </label>
    </div>
  <div class="col-sm-9">
      <input style="height:15px" type="text" class="form-control" id="alergi" autocomplete="off" name="alergi" placeholder="Tulis Alergi Pasien" value="<?php echo $data['alergi']; ?>" > 
  </div>
 </div>
</div>

  </div><!-- akhir div card block -->

 </div><!-- akhir div col-sm-3 form data pasien -->




<div class="col-sm-9">

<div class="card card-block">

<div class="row">

<div class="form-group col-sm-6">
 <label> <b> Sistole / Diastole (mmHg) </b> </label>
 <input style="height:15px" type="text" class="form-control" id="sistole_distole" autocomplete="off" name="sistole_distole" value="<?php echo $data['sistole_distole']; ?>" > 
</div>


<div class="form-group col-sm-6">
  <label> <b> Frekuensi Pernapasan (kali/menit) </b> </label>
  <input style="height:15px" type="text" class="form-control" id="respiratory_rate" autocomplete="off" name="respiratory_rate" value="<?php echo $data['respiratory']; ?>" > 
</div>

<div class="form-group col-sm-6">
   <label> <b> Suhu (°C) </b> </label>
   <input style="height:15px" type="text" class="form-control" id="suhu" name="suhu" autocomplete="off" value="<?php echo $data['suhu']; ?>" > 
</div>

<div class="form-group col-sm-6">
  <label> <b> Nadi (kali/menit) </b> </label>
  <input style="height:15px" type="text" class="form-control" id="nadi" name="nadi" autocomplete="off" value="<?php echo $data['nadi']; ?>" > 
</div>


<div class="form-group col-sm-6">
  <label> <b> Berat Badan (kg) </b> </label>
  <input style="height:15px" type="text" class="form-control" id="berat_badan" autocomplete="off" name="berat_badan" value="<?php echo $data['berat_badan']; ?>" > 
</div>

<div class="form-group col-sm-6">
  <label> <b> Tinggi Badan (cm) </b> </label>
  <input style="height:15px" type="text" class="form-control" id="tinggi_badan" autocomplete="off" name="tinggi_badan" value="<?php echo $data['tinggi_badan']; ?>" > 
</div>


<div class="form-group col-sm-6">
  <label> <b> Anamnesa </b> </label>
  <textarea class="form-control" id="anamnesa" name="anamnesa" autocomplete="off"><?php echo $data['anamnesa']; ?></textarea>
</div>

<div class="form-group col-sm-6">
  <label> <b> Pemeriksaan Fisik </b> </label>
  <textarea class="form-control" id="pemeriksaan_fisik" name="pemeriksaan_fisik" autocomplete="off"><?php echo $data['pemeriksaan_fisik']; ?></textarea> 
</div>


<div class="form-group col-sm-6">
  <label> <b> keadaan Umum </b> </label>
<select class="form-control" id="keadaan_umum" name="keadaan_umum" required="" autocomplete="off" >
    <option value="<?php echo $data['keadaan_umum']; ?>"><?php echo $data['keadaan_umum']; ?></option>
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>


<div class="form-group col-sm-6">
 <label> <b> kesadaran  </b> </label>
  <select class="form-control" id="kesadaran" autocomplete="off" name="kesadaran" >
    <option value="<?php echo $data['kesadaran'];?>"><?php echo $data['kesadaran']; ?></option>
    <option value="Compos Mentis">Compos Mentis</option>
    <option value="Apatis">Apatis</option>
    <option value="Somnolent">Somnolent</option>
    <option value="Sopor">Sopor</option>
    <option value="Sopora Coma">Sopora Coma</option>
    <option value="Coma">Coma</option>
  </select>
 </div>
</div>

<div class="form-group row">

<div class="col-sm-2">
  <label> <b> Diagnosis Utama </b> </label>
</div>
<div class="col-sm-10">
  <input style="height:15px" type="text" class="form-control "  list="icd" id="diagnosis_utama" autocomplete="off" placeholder="Ketikkan Diagnosis Utama" name="diagnosis_utama" value="<?php echo $data['icd_utama']; ?>" >
</div>

</div><!--end row 1-->

 <div class="form-group row">  
   <div class="col-sm-2">
   <label> <b> Diagnosis Penyerta </b> </label>
   </div>
   <div class="col-sm-10">
   <input style="height:15px" type="text" class="form-control" list="icd" autocomplete="off" placeholder=" Ketikkan Diagnosis Penyerta" id="diagnosis_penyerta" value="<?php echo $data['icd_penyerta']; ?>" name="diagnosis_penyerta" >       
   </div>
</div><!--end row 2-->



<div class="form-group row">
  <div class="col-sm-2">
  <label> <b> Diagnosis Penyerta Tambahan </b> </label>
  </div>
  <div class="col-sm-10">
  <input style="height:15px" type="text" class="form-control" autocomplete="off" list="icd" placeholder="Diagnosis Penyerta Tambahan" id="diagnosis_penyerta_tambahan" name="diagnosis_penyerta_tambahan" value="<?php echo $data['icd_penyerta_tambahan']; ?>">     
  </div>
</div><!--end row 3-->


<div class="form-group row">
   <div class="col-sm-2">
   <label> <b> Komplikasi </b> </label>
   </div>
   <div class="col-sm-10">
   <input style="height:15px" type="text" class="form-control" autocomplete="off" list="icd" placeholder=" Ketikkan Komplikasi" id="komplikasi" name="komplikasi" value="<?php echo $data['icd_komplikasi']; ?>">    
   </div>
</div><!--end row 4-->


<div class="row">
 <div class="form-group col-sm-10">
  <select class="form-control" name="kondisi_keluar" id="kondisi_keluar" autocomplete="off" placeholder="Pilih Dahulu Kondisi Pasien">
    <option value="<?php echo $data['kondisi_keluar']; ?>"><?php echo $data['kondisi_keluar']; ?></option>
    <option value="Sehat / Sembuh">Sehat / Sembuh</option>
    <option value="Pulang dan Proses Penyembuhan">Pulang dan Proses Penyembuhan</option>
    <option value="Masuk Rawat Inap / ICU/OK">Masuk Rawat Inap / ICU/OK</option>
    <option value="Dirujuk dengan pertolongan Pertama">Dirujuk dengan pertolongan Pertama</option>
    <option value="Dirujuk tanpa pertolongan pertama">Dirujuk tanpa pertolongan pertama</option>
    <option value="Meninggal Dunia">Meninggal Dunia</option>
    <option value="Tidak diketahui kondisinya">Tidak diketahui kondisinya</option>
  </select>
 </div>
 <button type="submit" class="btn btn-info"><i class='fa fa-wrench'></i> Update</button>
</div>


</div><!-- akhir div row form -->


</div><!-- akhir div card-block data rm -->

</div><!-- akhir div col-sm-9 data rm -->

</form>

</div><!-- akhir div layout form rm jalan -->


<!--script diagnosis utama-->
 <script type="text/javascript">
$("#diagnosis_utama").change(function()
{
var diagnosis_utama = $("#diagnosis_utama").val();
$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data)
{
$("#kode_diagnosis_utama").val(data);
});
});
</script>
<!--end script diagnosis utama-->



<!--script diagnosis penyerta-->
<script type="text/javascript">
$("#diagnosis_penyerta").change(function()
{
var diagnosis_utama = $("#diagnosis_penyerta").val();
$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_diagnosis_penyerta").val(data);
});
});
</script>
<!--end script diagnosis penyerta-->



<!--script daiagnosis penyerta-->
<script type="text/javascript">
  $("#diagnosis_penyerta_tambahan").change(function()
  {
  var diagnosis_utama = $("#diagnosis_penyerta_tambahan").val();
  $.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
  $("#kode_diagnosis_penyerta_tambahan").val(data);
  });
  });
</script>
<!--end script daiagnosis penyerta-->


<!--script daiagnosis utama 2-->
<script type="text/javascript">
$("#diagnosis_utama").change(function()
{
var diagnosis_utama = $("#diagnosis_utama").val();
$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_diagnosis_utama").val(data);
});
});
</script>
<!--end script daiagnosis utama 2-->


<!--script komplikasi-->
<script type="text/javascript">
$("#komplikasi").change(function()
{
var diagnosis_utama = $("#komplikasi").val();
$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_komplikasi").val(data);
});
});
</script>
<!--end script komplikasi-->

<!--   script modal confirmasi SELESAI -->
<script type="text/javascript">
$(".selesai").click(function(){

  var reg = $(this).attr('data-no-reg');


$("#modal-selesai").modal('show');
$("#reg2").val(reg);


});


</script>
<!--   end script modal confiormasi SELESAI -->

<!--AUTOCOMPLETE-->

<script>
$(function() {
    $( "#diagnosis_utama" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<script>
$(function() {
    $( "#diagnosis_penyerta" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<script>
$(function() {
    $( "#diagnosis_penyerta_tambahan" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<script>
$(function() {
    $( "#komplikasi" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<!--AUTOCOMPLETE-->

<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->
