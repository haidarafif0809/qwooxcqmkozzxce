<?php include 'session_login.php';
include 'header.php';
include_once 'navbar.php';
include 'db.php';
include 'sanitasi.php';

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d');
$jam = time('H:i:s');

 ?>
 <div class="container">
<h3>TAMBAH REKAM MEDIK UGD</h3><hr>



<!-- akhir menu rekam medik -->
<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
      <li class="nav-item"><a class="nav-link" href='rekam_medik_ugd.php'> Pencarian Rekam Medik </a></li>
      <li class="nav-item"><a class="nav-link" href='filter_rekam_medik_ugd.php' > Filter Rekam Medik </a></li>
</ul>


 <!-- menu rekam medik -->
<!-- Modal -->
  <div class="modal fade" id="ggs" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cari Pasien</h4>
          </div>
          <div class="modal-body">
          <div class="table-responsive">
          <table id="siswa" class="table table-bordered table-hover table-striped">
              <thead>
                  <tr>
                  <th>No Reg </th>
                  <th>No RM  </th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Umur</th>
                  <th>Jenis Kelamin</th>
                  <th>Jam</th>
               </tr>
               </thead>
          <tbody>
              <?php
               //Data mentah yang ditampilkan ke tabel    
               include 'db.php';
               $hasil = $db->query("SELECT * FROM registrasi WHERE jenis_pasien = 'UGD' AND status = 'Masuk Ruang UGD' AND status != 'Batal UGD' AND status != 'Rujuk Rumah Sakit' ORDER BY id DESC ");

               while ($data =  $hasil->fetch_assoc())
                {
               ?>

              <tr class="pilih2"
               
              data-b="<?php echo $data['dokter'];?>"
              data-d="<?php echo $data['no_rm'];?>"
              data-e="<?php echo $data['no_reg'];?>"
              data-f="<?php echo $data['nama_pasien'];?>"
              data-g="<?php echo $data['alamat_pasien'];?>" 
              data-h="<?php echo $data['umur_pasien'];?>"
              data-i="<?php echo $data['jenis_kelamin'];?>" 
              
              data-k="<?php echo $data['rujukan'];?>"
              data-l="<?php echo $data['eye'];?>"
              data-m="<?php echo $data['verbal'];?>"
              data-n="<?php echo $data['motorik'];?>">

              <td><?php echo $data['no_reg']; ?></td>
              <td><?php echo $data['no_rm']; ?></td>
              <td><?php echo $data['nama_pasien']; ?></td>
              <td><?php echo $data['alamat_pasien']; ?></td>
              <td><?php echo $data['umur_pasien']; ?></td>
              <td><?php echo $data['jenis_kelamin']; ?></td>  
              <td><?php echo $data['jam']; ?></td>           
           </tr>
           <?php
          }
         ?>
       </tbody>
        </table>
     </div><!--responsive-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>  
    </div>
  </div>

<br>
  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ggs"><i class="fa fa-search"></i> Cari</button>


 <form  role="form" action="proses_tambah_rekam_medik_ugd.php" method="POST">

<div class="row">
  <div class="col-sm-3">
<div class="card card-block">


<div class="form-group">
 <div class="row">
 	<div class="col-sm-3">
 		 <label >Dokter Jaga</label>
 	   </div>
   <div class="col-sm-9">
 	<input  style="height: 15px" type="text" class="form-control" id="dokter" name="dokter" readonly="" > 
 </div>
 </div>
</div>


<div class="form-group">
  <div class="row">
      <div class="col-sm-3">
      <label >No. RM</label>
      </div>
      <div class="col-sm-9">
      <input  style="height: 15px" type="text" class="form-control" id="no_rm" name="no_rm"  readonly="" > 
    </div>
  </div>
</div>
 	
 	
<div class="form-group">
 <div class="row">
 	<div class="col-sm-3">
 		<label >No. Reg</label>
 	   </div>
	  	<div class="col-sm-9">
        <input  style="height: 15px" type="text" class="form-control" id="no_reg" name="no_reg"  readonly=""> 
   </div>
  </div>
</div>
 	


<div class="form-group">
    <div class="row">
      <div class="col-sm-3">
      <label >Rujukan</label>
      </div>
      <div class="col-sm-9">
      <input  style="height: 15px" type="text" class="form-control" id="rujukan" name="rujukan" readonly="" > 
      </div>
  </div>
</div>


<div class="form-group">
    <div class="row">
      <div class="col-sm-3">
      <label >Nama</label>
      </div>
      <div class="col-sm-9">
      <input  style="height: 15px" type="text" class="form-control" id="nama" name="nama"  readonly="" > 
      </div>
    </div>
</div>


<div class="form-group">
    <div class="row">
      <div class="col-sm-3">
      <label >Alamat</label>
      </div>
      <div class="col-sm-9">
      <input  style="height: 15px" type="text" class="form-control" id="alamat" name="alamat"  readonly="" > 
    </div>
  </div>
</div>
 	
 	
<div class="form-group">
  <div class="row">
    <div class="col-sm-3">
      <label >Jenis Kelamin</label>
      </div>
      <div class="col-sm-9">
      <input  style="height: 15px" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"  readonly=""> 
      </div>
    </div>
</div>


<div class="form-group">
 	<div class="row">
 	  <div class="col-sm-3">		
   <label >Umur</label>
   	</div>
	  <div class="col-sm-9">
 	  <input  style="height: 15px" type="text" class="form-control" id="umur" name="umur"  readonly=""> 
  </div>
 </div>
</div>
 	

<div class="form-group">
  <div class="row">
    <div class="col-sm-3">
      <label >Respon Mata (Eye)</label>
      </div>
      <div class="col-sm-9">
      <select class="form-control" id="eye" name="eye"  autocomplete="off">
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
      <label >Respon Ucapan (Verbal)</label>
      </div>
      <div class="col-sm-9">
       <select class="form-control" id="verbal" name="verbal" autocomplete="off">
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
      <label >Respon Gerak (Motorik)</label>
      </div>
      <div class="col-sm-9">
       <select class="form-control" id="motorik" name="motorik"  autocomplete="off">
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
      <label >Alergi</label>
    </div>
  <div class="col-sm-9">
      <input  style="height: 15px" type="text" class="form-control" id="alergi" autocomplete="off" name="alergi" value="<?php echo $data['alergi']; ?>" placeholder="Tulis Alergi Pasien"  > 
  </div>
 </div>
</div>
</div>
</div><!-- akhir div col-sm-3 form data pasien -->

<div class="col-sm-9">

<div class="card card-block"><!--div card block-->

<div class="row"><!--div row-->

<div class="form-group col-sm-6">
 <label >Sistole / Diastole (mmHg)</label>
 <input  style="height: 15px" type="text"  class="form-control" id="sistole_distole" autocomplete="off" name="sistole_distole" value="<?php echo $data['sistole_distole']; ?>" > 
</div>


<div class="form-group col-sm-6">
  <label >Frekuensi Pernapasan (kali/menit)</label>
 	<input  style="height: 15px" type="text" class="form-control" id="respiratory_rate" autocomplete="off" name="respiratory_rate" value="<?php echo $data['respiratory']; ?>" > 
</div>

<div class="form-group col-sm-6">
   <label >Suhu (°C)</label>
 	 <input  style="height: 15px" type="text"  class="form-control" id="suhu" name="suhu" autocomplete="off" value="<?php echo $data['suhu']; ?>" > 
</div>

<div class="form-group col-sm-6">
  <label >Nadi (kali/menit)</label>
 	<input  style="height: 15px" type="text"  class="form-control" id="nadi" name="nadi" autocomplete="off" value="<?php echo $data['nadi']; ?>" > 
</div>


<div class="form-group col-sm-6">
  <label >Berat Badan (kg)</label>
 	<input  style="height: 15px" type="text"  class="form-control" id="berat_badan" autocomplete="off" name="berat_badan" value="<?php echo $data['berat_badan']; ?>" > 
</div>

<div class="form-group col-sm-6">
  <label >Tinggi Badan (cm)</label>
 	<input  style="height: 15px" type="text"  class="form-control" id="tinggi_badan" autocomplete="off" name="tinggi_badan" value="<?php echo $data['tinggi_badan']; ?>" > 
</div>


<div class="form-group col-sm-6">
  <label >Anamnesa</label>
 	<textarea class="form-control" id="anamnesa" name="anamnesa" autocomplete="off" ><?php echo $data['anamnesa']; ?></textarea>
</div>

<div class="form-group col-sm-6">
  <label >Pemeriksaan Fisik</label>
 	<textarea class="form-control" id="pemeriksaan_fisik" name="pemeriksaan_fisik" autocomplete="off"><?php echo $data['pemeriksaan_fisik']; ?></textarea> 
</div>


<div class="form-group col-sm-6">
  <label >keadaan Umum</label>
<select class="form-control" id="keadaan_umum" name="keadaan_umum" autocomplete="off" >
    <option value="<?php echo $data['keadaan_umum']; ?>"><?php echo $data['keadaan_umum']; ?></option>
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>


<div class="form-group col-sm-6">
 <label >kesadaran </label>
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
	<label>Diagnosis Utama</label>
</div>

<div class="col-sm-10">
 	<input  style="height: 15px" type="text" class="form-control" autocomplete="off"  id="diagnosis_utama" placeholder="Ketikkan Diagnosis Utama" name="diagnosis_utama" value="<?php echo $data['icd_utama']; ?>" >
</div>

</div><!--end row 1-->

 <div class="form-group row">  
   <div class="col-sm-2">
   <label>Diagnosis Penyerta</label>
   </div>

   <div class="col-sm-10">
   <input  style="height: 15px" type="text" class="form-control"  autocomplete="off" placeholder=" Ketikkan Diagnosis Penyerta" id="diagnosis_penyerta" value="<?php echo $data['icd_penyerta']; ?>" name="diagnosis_penyerta" >       
   </div>
</div><!--end row 2-->



<div class="form-group row">
  <div class="col-sm-2">
  <label>Diagnosis Penyerta Tambahan</label>
  </div>

  <div class="col-md-10">
  <input  style="height: 15px" type="text" class="form-control"  placeholder="Diagnosis Penyerta Tambahan" autocomplete="off" id="diagnosis_penyerta_tambahan" name="diagnosis_penyerta_tambahan" value="<?php echo $data['icd_penyerta_tambahan']; ?>">     
  </div>
</div><!--end row 3-->


<div class="form-group row">
   <div class="col-sm-2">
   <label>Komplikasi</label>
   </div>
  
   <div class="col-sm-10">
   <input  style="height: 15px" type="text" class="form-control"  placeholder=" Ketikkan Komplikasi" autocomplete="off" id="komplikasi" name="komplikasi" value="<?php echo $data['icd_komplikasi']; ?>">    
   </div>
</div><!--end row 4-->


<div class="row">
 <div class="col-sm-9">
 	<select class="form-control" name="kondisi_keluar" autocomplete="off" id="kondisi_keluar" autocomplete="off" placeholder="Pilih Dahulu Kondisi Pasien">
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
 <div class="col-sm-3">
 <button type="submit" class="btn btn-info "><i class='fa fa-plus'></i> Tambah</button>
</div>
</div>



  

</div><!-- akhir div col-sm-9 data rm -->
</div><!-- akhir div row form -->
</div><!-- akhir div card block -->

</form>

</div><!-- akhir div layout form rm jalan -->




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


<!--script ambil datat modal rekam mdik-->
<script type="text/javascript">
$(document).on('click', '.pilih2', function (e) 
{       
  document.getElementById("dokter").value = $(this).attr('data-b');
  document.getElementById("no_rm").value = $(this).attr('data-d');
  document.getElementById("no_reg").value = $(this).attr('data-e');
  document.getElementById("nama").value = $(this).attr('data-f');
  document.getElementById("alamat").value = $(this).attr('data-g');
  document.getElementById("umur").value = $(this).attr('data-h');
  document.getElementById("jenis_kelamin").value = $(this).attr('data-i'); 
  document.getElementById("rujukan").value = $(this).attr('data-k');
  document.getElementById("eye").value = $(this).attr('data-l');
  document.getElementById("verbal").value = $(this).attr('data-m');
  document.getElementById("motorik").value = $(this).attr('data-n');

               ;
                $('#ggs').modal('hide');
            });   
// tabel lookup mahasiswa
</script>
<!--end script ambil datat modal rekam mdik-->

  
            
<!--script datatable-->
<script type="text/javascript">
  $(function () {
  $("table").dataTable();
  });
</script>
<!--end script datatable-->

<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->
