<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';


$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');


$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

$q = $db->query("SELECT * FROM setting_registrasi");
$dq = mysqli_fetch_array($q);

$pilih_akses_registrasi_ri = $db->query("SELECT registrasi_ri_lihat, registrasi_ri_tambah, registrasi_ri_edit, registrasi_ri_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ri = mysqli_fetch_array($pilih_akses_registrasi_ri);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ri_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


?>

<style>
.disable1{
background-color:#cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable2{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable3{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable4{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable5{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable6{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}

</style>


<script type="text/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

  <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_rawat_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_rawat_inap.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_rawat_inap").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[21]+'');         
},
        } );
      } );
    </script>



<div style="padding-left:5%; padding-right:5%;">

<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->


<!-- Modal Untuk Confirm KAMAR-->
<div id="modal_kamar" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Pindah Kamar</h2></center>       
    </div>
    <div class="modal-body">


      <span id="tampil_kamar">

            <span id="tampil_kamar">

           <div class="table-responsive">

            <table id="table-kamar" class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
              <th>Kelas</th>
              <th>Kode Kamar</th>
              <th>Nama Kamar</th>
              <th>Fasilitas</th>
              <th>Jumlah Bed</th>
              <th>Sisa Bed</th>    
              </tr>
          </thead>
           </table>  
         </div>

      </span>

      </span>
      <form role="form" method="POST">
<div class="row">

  <div class="col-sm-6">

     <div class="form-group" >
        <label for="bed">Nama Kamar Lama</label>
        <input style="height: 20px" type="text" class="form-control" id="kamar_lama" name="kamar_lama" readonly="">
      </div>

      <div class="form-group" >
        <label for="bed">Lama Menginap Kamar Lama:</label>
        <input style="height: 20px" type="text" class="form-control" placeholder="Isi lama menginap di kamar lama" id="lama_inap" name="lama_inap" autocomplete="off">
      </div>

  </div>

  <div class="col-sm-6">
     <div class="form-group" >
        <label for="bed">Kode Kamar Baru:</label>
        <input style="height: 20px" type="text" class="form-control" id="bed2" name="bed2"  readonly="" >
      </div>

      <div class="form-group" >
        <label for="bed">Nama Kamar Baru:</label>
        <input style="height: 20px" type="text" class="form-control" id="group_bed2" name="group_bed2"  readonly="">
      </div>
  </div>
</div>
     

       <button style="width:110px;"" type="button" class="btn btn-warning  waves-effect waves-light" data-ids=""  data-regs="" data-beds="" data-group_beds="" id="pindah_kamar"> <i class="fa fa-reply"></i> Pindah</button>
       </div>
       <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-remove"></i> Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan KAMAR-->



<!-- Modal Untuk LAB RANAP-->
<div id="modal_lab_inap" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Pemeriksaan Laboratorium Rawat Inap </h2></center>       
    </div>
    <div class="modal-body">

      <span id="tampil_lab">
      </span>
     
     <form role="form" method="POST">

<div class="row">
    <div class="col-sm-6">

          <div class="form-group">
            <label for="">No RM</label>
            <input style="height: 20px;" type="text" class="form-control" name="lab_rm" readonly="" autocomplete="off" id="lab_rm" placeholder="Pemeriksaan Ke">
          </div>

          <div class="form-group">
              <label for="">Nama Pasien</label>
              <input  type="text" class="form-control" name="lab_nama" readonly="" autocomplete="off" id="lab_nama" placeholder="Nama Pasien">
          </div>

          <div class="form-group">
              <input style="height: 20px;" type="hidden" class="form-control" name="lab_reg" readonly="" autocomplete="off" id="lab_reg" placeholder=" No Reg">
          </div>

    </div>

    <div class="col-sm-6">

        <div class="form-group">
          <label for="">Kode Kamar</label>
          <input style="height: 20px;" type="text" class="form-control" name="lab_bed" readonly="" autocomplete="off" id="lab_bed" placeholder=" No Reg">
        </div>

        <div class="form-group">
          <label for="">Nama Kamar</label>
          <input type="text" class="form-control" name="lab_kamar" readonly="" autocomplete="off" id="lab_kamar" placeholder=" No Reg">
        </div>

    </div>
  
</div>
     
   <center> <a href="data_laboratorium_inap.php" type="submit" class="btn btn-info" id="input_lab" data-id=""> <i class="fa fa-send" ></i> Yes</a>


        <button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-remove"></i> No</button>
</center> 
     </form>

       </div>
       <div class="modal-footer">
        
    </div>
    </div>
  </div>
</div>
<!--modal end LAB RANAP-->



<!-- Modal Untuk batal ranap-->
<div id="modal_batal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Batal Rawat Inap </h2></center>       
    </div>
    <div class="modal-body">

      <span id="tampil_batal">
      </span>
     
     <form role="form" method="POST">
     
     <div class="form-group">
     <label for="sel1">Keterangan</label>
     <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
     </div>
     
     <input type="hidden" class="form-control" id="no_reg" name="no_reg" data-reg="" >
     
     <button type="submit" class="btn btn-info" id="input_keterangan" data-id=""> <i class="fa fa-send" ></i> Input Keterangan</button>
     </form>

       </div>
       <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-remove"></i> Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end batal ranap-->

<?php if ($registrasi_ri['registrasi_ri_lihat'] > 0)
{

echo "<h3>DATA PASIEN RAWAT INAP </h3>";
}
else
{
  echo "<h3>DATA PENJUALAN RAWAT INAP </h3>";
}
?>
<hr>


  <!-- Modal -->
<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Pencarian Pasien </b></center></h4>
      </div>
      <div class="modal-body">
      <span id="hasil_migrasi"></span>
       <table id="pasien_lama" class="table table-sm table-bordered">
          <thead>
            <tr>
              <th style='background-color: #4CAF50; color: white' >No. RM </th>
              <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
              <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
              <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
              <th style='background-color: #4CAF50; color: white' >No HP</th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Terdaftar </th>
            

            </tr>
          </thead>
         </table>
      </div>
      <div class="modal-footer">
      <center> <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u></button></center> 
      </div>
    </div>

  </div>
</div>
 
<!-- akhir modal -->


 

<!-- Modal rujukan lab-->
<div id="Modal3" class="modal" role="dialog">
 
<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rujuk Laboratorium </h4>

      </div>
      <div class="modal-body">
       <span id="rujukan_lab">
       </span> 
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
  
<!-- akhir modal3-->


<ul class="nav nav-tabs yellow darken-4" role="tablist">
        <li class="nav-item"><a class="nav-link active" href='rawat_inap.php' data-placement='top' >Daftar Pasien <u>R</u>awat Inap</a></li>
        <?php if ($registrasi_ri['registrasi_ri_lihat'] > 0): ?>
        <li class="nav-item"><a class="nav-link" href='daftar_pasien_rawat_inap_batal.php' data-placement='top' title='Klik untuk melihat pasien batal rawat inap.'>  Pasien Batal Rawat Inap </a></li>
        <li class="nav-item"><a class="nav-link" href='daftar_pasien_rawat_inap_pulang.php' data-placement='top' title='Klik untuk melihat pasien sudah pulang dari rawat inap.'> Pasien Rawat Inap Pulang </a></li>
      <?php endif?>
</ul>

<br><br>
<?php if ($registrasi_ri['registrasi_ri_tambah'] > 0): ?>
  <button id="coba" type="submit" class="btn btn-primary" data-toggle="collapse" accesskey="r" ><i class='fa fa-plus'> </i>&nbsp;Tambah</button>

<button style="display:none" data-toggle="collapse tooltip" accesskey="k" id="kembali" class="btn btn-primary" data-placement='top' title='Klik untuk kembali ke utama.'><i class="fa fa-reply"></i> <u>K</u>embali </button>

<a href="rawat_inap_pasien_baru.php" accesskey="b" class="btn btn-info"><i class="fa fa-plus"></i> Pasien <u>B</u>aru </a>


<?php endif ?>



<div id="demo" class="collapse">
<div class="row">

<br>
<div class="col-sm-4">

<div class="card card-block">

<form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Ruangan:</label>
  <select class="form-control" id="ruangan" name="ruangan"  autocomplete="off">
   <option value="">Silakan Pilih</option>
      <?php 
      $query_ruangan = $db->query("SELECT id,nama_ruangan FROM ruangan ORDER BY id");
      while ( $data_ruangan = mysqli_fetch_array($query_ruangan)) {
      echo "<option value='".$data_ruangan['id']."'>".$data_ruangan['nama_ruangan']."</option>";
      }
      ?>
  </select>
</div>

<button type="button" accesskey="c" class="btn btn-success" data-toggle="modal" id="cari_kamar" data-placement='top' title='Klik untuk cari kamar.'> <i class="fa fa-search"></i> <u>C</u>ari kamar</button>
 <br>

  <input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 


<div class="form-group" >
  <label for="bed">Kamar:</label>
  <input style="height: 20px;" type="text" class="form-control disable" id="group_bed" name="group_bed" autocomplete="off" readonly="" >
</div>


<div class="form-group" >
  <label for="bed">Bed:</label>
  <input style="height: 20px;" type="text" class="form-control disable" id="bed" name="bed" autocomplete="off" readonly="" >
</div>

</div>

<div class="card card-block">
   
<div class="form-group">
  <label for="sel1">Perujuk:</label>
  <select class="form-control" id="rujukan" name="rujukan"  autocomplete="off">
   <option value="Non Rujukan">Non Rujukan</option>
      <?php 
      $query_perujuk = $db->query("SELECT nama FROM perujuk ");
      while ( $data_perujuk = mysqli_fetch_array($query)) {
      echo "<option value='".$data_perujuk['nama']."'>".$data_perujuk['nama']."</option>";
      }
      ?>
  </select>
</div>



  
  <div class="form-group">
    <div class="col-sm-6">
      <label for=""><u>C</u>ari Pasien Lama</label>
      <input style="height: 20px;" type="text" accesskey="c" class="form-control" name="cari" autocomplete="off" id="cari_migrasi" placeholder="Nama Pasien Lama">
    </div>

    <div class="col-sm-6">
      <label for="">Alamat Pasien</label>
      <input style="height: 20px;" type="text" accesskey="c" class="form-control" name="cari" autocomplete="off" id="alamat_pasien_lama" placeholder="Alamat Pasien Lama">
      </div>
  </div>

<button id="submit_cari" accesskey="a" type="button" class="btn btn-success" data-toggle='tooltip' data-placement='top' title='Pastikan anda telah mengetikkan nama pasien di kolom cari pasien  sebelum klik tombol cari.'><i class="fa fa-search"></i> C<u>a</u>ri</button>
  <br>
<br>


<div class="form-group" >
 <label for="penjamin">Penjamin:</label>
 <select class="form-control" id="penjamin" name="penjamin"  autocomplete="off">
 <option value=""> --SILAKAN PILIH--</option>
 <?php 
  $query_penjamin = $db->query("SELECT nama FROM penjamin WHERE status = 'Aktif' ORDER BY id ASC");
  while ( $data_penjamin = mysqli_fetch_array($query)) {
  echo "<option value='".$data_penjamin['nama']."'>".$data_penjamin['nama']."</option>";
  }
  ?>
  </select>
</div>
  
<button class="btn btn-success" accesskey="l" id="lay"><i class="fa fa-list"></i> Lihat <u>L</u>ayanan </button>
     
   <br>
  <br>
<div class="form-group">
    <label for="no_rm">No RM:</label>
    <input style="height: 20px;" type="text" class="form-control" id="no_rm" name="no_rm"  readonly="" >
</div>

<div class="form-group">
    <label for="nama_lengkap">Nama Lengkap Pasien:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"  readonly="">
</div>

<div class="form-group" >
  <label for="umur">Jenis Kelamin:</label>
<input style="height: 20px;" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"  readonly="" >
</div>

  
<div class="form-group" style="display: none">
    <input style="height: 20px;" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"  autocomplete="off">
</div>

<div class="form-group">
    <label for="nama_lengkap">Umur:</label>
    <input style="height: 20px;" type="text" class="form-control" id="umur" name="umur"  readonly="" >
</div>


<div class="form-group">
    <label for="alamat">Alamat:</label>
    <textarea class="form-control" id="alamat" name="alamat" ></textarea>
</div>


<div class="form-group">
    <label for="alamat">No Hp:</label><input style="height: 20px;" type="text"   class="form-control" id="hp_pasien" name="hp_pasien"  >
</div>

</div>


</div><!-- penutp colm 1-->


<!--modal Kamar-->
<!-- Modalkamar -->
<div id="myModal1" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content2 -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pencarian Kamar Pasien </h4>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
        <table id="table_kamar" class="table table-bordered table-hover table-striped">
          <thead>
          <tr>
          <th>Kelas</th>
          <th>Ruangan</th>
          <th>Kode Kamar</th>
          <th>Nama Kamar</th>
          <th> Fasilitas</th>
          <th>Jumlah Bed</th>  
          <th>Sisa Bed</th>                                          
          </tr>
          </thead>
          <tbody>
          <?php
          //Data mentah yang ditampilkan ke tabel    
          /*$query_bed = $db->query("SELECT r.nama_ruangan, b.id, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, b.kelas  FROM bed b INNER JOIN ruangan r ON b.ruangan = r.id WHERE b.sisa_bed != 0 AND b.ruangan = '$data_ruangan[id]' GROUP BY b.ruangan ");
                                        
          while ($data_bed =  $query_bed->fetch_assoc()) {
             $query_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($data_kelas = mysqli_fetch_array($query_kelas))
        {
          if($data_bed['kelas'] == $data_kelas['id'])
          {
            $kelas = $data_kelas['nama'];
          }
        }
          ?>
          <tr class="pilih2" 
          data-nama="<?php echo $data_bed['nama_kamar']; ?>" 
          data-group-bed ="<?php echo $data_bed['group_bed']; ?>" >
          
          <td><?php echo $kelas; ?></td>
          <td><?php echo $data_bed['nama_ruangan'] ?></td>
          <td><?php echo $data_bed['nama_kamar']; ?></td>
          <td><?php echo $data_bed['group_bed']; ?></td>
          <td><?php echo $data_bed['fasilitas']; ?></td>
           <td><?php echo $data_bed['jumlah_bed']; ?></td>         
           <td><?php echo $data_bed['sisa_bed']; ?></td>                           
          </tr>
          <?php
          }*/
          ?>
          </tbody>
          </table>  
       </div> <!-- table responsive  -->
        </div>
        <div class="modal-footer">
        <button type="button" accesskey="o" class="btn btn-danger" data-dismiss="modal">Cl<u>o</u>se</button>
        </div>
        </div>
        
        </div>
        </div> 
<!-- akhir modal Kamar-->

<!-- SPAN untuk PENANGGUNG-->


<div class="col-sm-4">
<br>
<br>
<br>

<!-- SPAN untuk TTV -->


  

<?php if ($dq['tampil_data_pasien_umum'] == 1): ?>
<div class="card card-block">
<div class="form-group" >
  <label for="umur">Penanggung Jawab Pasien:</label>
  <input style="height: 20px;" type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab"  autocomplete="off">
</div>

<div class="form-group" >
  <label for="umur">Alamat Penanggung Jawab:</label>
  <input style="height: 20px;" type="text" class="form-control" id="alamat_penanggung" name="alamat_penanggung"  autocomplete="off">
</div> 

<div class="form-group" >
  <label for="umur">No Telp / HP Penanggung  :</label>
  <input style="height: 20px;" type="text" class="form-control" onkeypress="return isNumberKey(event)" id="no_hp_penanggung" name="no_hp_penanggung" maxlenght="12"  autocomplete="off">
</div>

<div class="form-group" >
 <label for="umur">Pekerjaan Penanggung Jawab:</label>
 <input style="height: 20px;" type="text" class="form-control" id="pekerjaan_penanggung" name="pekerjaan_penanggung" autocomplete="off">
</div>



<div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien:</label>
  <select id="hubungan_dengan_pasien" class="form-control " name="hubungan_dengan_pasien"  autocomplete="off">
      
      <option value="Orang Tua">Orang Tua</option>
      <option value="Suami/Istri">Suami/Istri</option>
      <option value="Anak">Anak</option>
      <option value="Keluarga">keluarga</option>
      <option value="Teman">Teman</option>
      <option value="Lain - Lain">Lain - Lain</option>  
  </select>  
</div>

  </div>
<?php endif ?>




<div class="card card-block">


<div class="form-group" >
  <label for="umur">Perkiraan Menginap:</label>
  <input style="height: 20px;" type="text" class="form-control" onkeypress="return isNumberKey(event)"  id="perkiraan_menginap" name="perkiraan_menginap"   autocomplete="off">
</div>

<div class="form-group" >
    <label for="umur">Surat Jaminan:</label>
    <input style="height: 20px;" type="text" class="form-control" id="surat_jaminan"  name="surat_jaminan"  autocomplete="off">
</div>


</div>

<!-- AKHIR UNTUK PANEL TTV -->

<div class="card card-block">

<div class="form-group">
          <label for="alamat">Dokter Penanggung Jawab:</label>
          <select class="form-control" id="dokter_pengirim" name="dokter_pengirim"  autocomplete="off">
           <option value="<?php echo $ss['nama_dokter'];?>"><?php echo $ss['nama_dokter'];?></option>
                  <?php 
                  $query = $db->query("SELECT nama FROM user WHERE tipe = '1' ");
                  while ( $data = mysqli_fetch_array($query)) {
                  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
                  }
                  ?>
          </select>
</div>

<div class="form-group">
    <label for="alamat">Asal Poli :</label>
    <select class="form-control" id="poli" name="poli"  autocomplete="off">
     
          <?php 
          $query = $db->query("SELECT nama FROM poli ");
          while ( $data = mysqli_fetch_array($query)) {
          echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
          }
          ?>
    </select>
</div> 


<div class="form-group">
    <label for="alamat">Dokter Pelaksana:</label>
    <select class="form-control" id="dokter_penanggung_jawab" name="dokter_penanggung_jawab"  autocomplete="off">
          <option value="<?php echo $ss['nama_dokter'];?>"><?php echo $ss['nama_dokter'];?></option>
    <?php 
    $query = $db->query("SELECT nama FROM user WHERE tipe = '1' ");
    while ( $data = mysqli_fetch_array($query)) {
    echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
    }
    ?>
  </select>
</div>

<div class="form-group">
  <label for="sel1">Keadaan Umum Pasien:</label>
  <select class="form-control" id="kondisi" name="kondisi"  autocomplete="off">
 
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>



<div class="form-group ">
  <label >Alergi Obat *</label>
  <input style="height: 20px;" type="text" class="form-control" id="alergi" name="alergi" value="Tidak Ada"  placeholder="Wajib Isi" autocomplete="off"> 
</div>

</div>

<?php if ($dq['tampil_ttv'] == 0): ?>
  <button accesskey="d" style="width:100px" class="btn btn-info" id="daftar"><i class="fa fa-plus">
</i>  <u>D</u>aftar</button>
<?php endif ?>

</div>



<!-- SPAN untuk DATA DIRI LANJUTAN -->

<!-- PANEL DATA DIRI AKHIR -->
<br><br><br>

  <div class="col-sm-4">



<?php if ($dq['tampil_ttv'] == 1): ?>
<div class="card card-block">

<center><h4>Tanda Tanda Vital</h4></center>
<div class="form-group">
 <label >Sistole /Diastole (mmHg):</label>
 <input style="height: 20px;" type="text"  class="form-control" id="sistole_distole"  name="sistole_distole"  autocomplete="off" >
</div>

<div class="form-group ">
  <label >Frekuensi Pernapasan (kali/menit):</label>
  <input style="height: 20px;" type="text"  class="form-control" id="respiratory_rate"  name="respiratory_rate"  autocomplete="off" > 
</div>

<div class="form-group">
  <label >Suhu  (°C):</label>
  <input style="height: 20px;" type="text"  class="form-control" id="suhu" name="suhu"  autocomplete="off"  > 
</div>   

<div class="form-group ">
 <label >Nadi (kali/menit):</label>
 <input style="height: 20px;" type="text"  class="form-control" id="nadi" name="nadi"  autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Berat Badan (kg):</label>
  <input style="height: 20px;" type="text"  class="form-control" id="berat_badan"  name="berat_badan" autocomplete="off"> 
</div>

<div class="form-group ">
 <label >Tinggi Badan (cm):</label>
 <input style="height: 20px;" type="text"  class="form-control" id="tinggi_badan"  name="tinggi_badan"autocomplete="off"> 
</div>

<br>

  <button accesskey="d" style="width:100px" class="btn btn-info" id="daftar"><i class="fa fa-plus">
</i>  <u>D</u>aftar</button>

</div>
<!-- Akhir panel untuk PENANGGUNG -->
<?php endif ?>


</form>
</div> <!-- -->
</div> <!-- row utama -->
</div> <!-- end colapse -->

<!-- PEMBUKA DATA TABLE -->

<br>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="table_baru">
<div class="table-responsive">
<table id="table_rawat_inap" class="table table-bordered table-sm">
 
    <thead>
      <tr>

  <?php if ($registrasi_ri['registrasi_ri_hapus']):?>    
      <th style='background-color: #4CAF50; color: white'>Batal</th>
    <?php endif ?>

      <?php if ($registrasi_ri['registrasi_ri_hapus']):?>         
          <th style='background-color: #4CAF50; color: white' >Edit</th>
   <?php endif ?>
        
         <th style='background-color: #4CAF50; color: white'>Transaksi Penjualan</th>

  <?php if ($registrasi_ri['registrasi_ri_lihat']):?>      
          <th style='background-color: #4CAF50; color: white'>Pindah Kamar</th>
          <th style='background-color: #4CAF50; color: white'>Operasi</th>
          <th style='background-color:#4CAF50; color: white'> Rujuk Lab</th>
          <!--<th style='background-color:#4CAF50; color: white'> Input Hasil Lab</th>-->
  <?php endif ?>

  <?php if ($rekam_medik['rekam_medik_ri_lihat']):?>         
          <th style='background-color: #4CAF50; color: white' >Rekam Medik</th>
   <?php endif ?>
        
          <th style='background-color: #4CAF50; color: white'>No RM</th>
          <th style='background-color: #4CAF50; color: white'>No REG </th>
          <th style='background-color: #4CAF50; color: white'>Status</th>
          <th style='background-color: #4CAF50; color: white'>Nama  </th>
          <th style='background-color: #4CAF50; color: white'>Jam</th>
          <th style='background-color: #4CAF50; color: white'>Penjamin</th>    
          <th style='background-color: #4CAF50; color: white'>Asal Poli</th>
          <th style='background-color: #4CAF50; color: white'>Dokter Pengirim</th>
          <th style='background-color: #4CAF50; color: white'>Dokter Pelaksana</th>
          <th style='background-color: #4CAF50; color: white'>Bed</th>
          <th style='background-color: #4CAF50; color: white'>Kamar</th>
          <th style='background-color: #4CAF50; color: white'>Tanggal Masuk</th>
          <th style='background-color: #4CAF50; color: white'>Penanggung Jawab</th>    
          <th style='background-color: #4CAF50; color: white'>Umur</th>
          
    </tr>
    </thead>
   
 </table>
</div>

</span>
 <!-- AKHIR TABLE -->
</div> <!-- penutup container-->


<script type="text/javascript">
  //cari pasien migrasi
    $(document).on('click','#submit_cari',function() {
  
    var cari = $("#cari_migrasi").val();
    if (cari == '') {  
      $("#hasil_migrasi").html('');  
    }
    else
    {
        $("#myModal").modal('show');
        $('#pasien_lama').DataTable().destroy();

          var dataTable = $('#pasien_lama').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"show_data_pasien.php", // json datasource
             "data": function ( d ) {
                d.cari = $("#cari_migrasi").val();
                d.alamat = $("#alamat_pasien_lama").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#pasien_lama").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#pasien_lama_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih tr-id-"+aData[9]+"");
              $(nRow).attr('data-no', aData[0]);
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-jenis-kelamin', aData[2]);
              $(nRow).attr('data-alamat', aData[3]);
              $(nRow).attr('data-lahir', aData[4]);
              $(nRow).attr('data-darah', aData[7]);
              $(nRow).attr('data-hp', aData[5]);
              $(nRow).attr('data-penjamin', aData[8]);

          } 

        } );


          
    }
   
  
  });
  </script>


<script type="text/javascript">
  // cari kamar seuai dengan ruangannya
    $(document).on('click','#cari_kamar',function() {
  
    var ruangan = $("#ruangan").val();
    if (ruangan == '') {  
      alert("Silakan pilih ruangan terlebih dahulu.");
      $("#ruangan").focus();
    }
    else
    {
        $("#myModal1").modal('show');
        $('#table_kamar').DataTable().destroy();

          var dataTable = $('#table_kamar').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"datatable_cari_kamar_dirawat_inap.php", // json datasource
             "data": function ( d ) {
                d.ruangan = $("#ruangan").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_ruangan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table_ruangan_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih2 tr-id-"+aData[8]+"");
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-group-bed', aData[2]);

          } 

        } );


          
    }
   
  
  });
  </script>

 <script type="text/javascript">
          $("#alamat").focus(function(){
            var cari_migrasi = $("#cari_migrasi").val();
            var no_rm = $("#no_rm").val();
if(no_rm == '')
{
            $("#cari_migrasi").focus();    

}
else
{
  
}
        });
</script>

   <script type="text/javascript">
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#daftar").click(function(){
    var ruangan = $("#ruangan").val();
    var group_bed = $("#group_bed").val();
    var bed = $("#bed").val();
    var rujukan = $("#rujukan").val();
    var no_rm = $("#no_rm").val();
    var nama_lengkap = $("#nama_lengkap").val();
    var jenis_kelamin = $("#jenis_kelamin").val();
    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = $("#umur").val();
    var alamat = $("#alamat").val();
    var hp_pasien = $("#hp_pasien").val();
    var kondisi = $("#kondisi").val();
    var penjamin = $("#penjamin").val();
    if (penjamin == '')
    {
      penjamin = 'PERSONAL';
    }
    var surat_jaminan = $("#surat_jaminan").val();
    var perkiraan_menginap = $("#perkiraan_menginap").val();
    var penanggung_jawab = $("#penanggung_jawab").val();
    var alamat_penanggung = $("#alamat_penanggung").val();
    var no_hp_penanggung = $("#no_hp_penanggung").val();
    var pekerjaan_penanggung = $("#pekerjaan_penanggung").val();
    var hubungan_dengan_pasien = $("#hubungan_dengan_pasien").val();
    var dokter_pengirim = $("#dokter_pengirim").val();
    var poli = $("#poli").val();
    var dokter_penanggung_jawab = $("#dokter_penanggung_jawab").val(); 
    var sistole_distole = $("#sistole_distole").val();
   
    var respiratory_rate = $("#respiratory_rate").val();
    
    var suhu = $("#suhu").val();
    
    var nadi = $("#nadi").val();
     
    var berat_badan = $("#berat_badan").val();
     
    var tinggi_badan = $("#tinggi_badan").val();
   
    var alergi = $("#alergi").val();
   

    var token = $("#token").val();
    var cari_migrasi = $("#cari_migrasi").val();

    $("#kembali").hide();
    $("#daftar").show();

if (ruangan == '')
{

alert("Ruangan Masih Kosong");
  $("#group_bed").focus();

}

else if (group_bed == '')
{

alert("Kamar Masih Kosong");
  $("#group_bed").focus();

}

  else if(bed == '')
{
  alert("Bed Masih Kosong");
  $("#bed").focus();
}
  else if(penjamin == '')
{
  alert("Penjamin Masih Kosong");
  $("#penjamin").focus();
}
else if (no_rm == '')
{
    alert("Pasien Belum Ada!!");
  $("#cari_migrasi").focus();
}
else if (penanggung_jawab == '')
{
  alert("Isi Nama Penanggung Jawab Pasien!!");
 $("#penanggung_jawab").focus();
   
}
else if (alamat_penanggung == '')
{
    alert("Isi Alamat Penanggung Jawab Pasien!!");
    $("#alamat_penanggung").focus();

}
else if (no_hp_penanggung == '') 
{
    alert("Isi No Handphone Penanggung Jawab Pasien!!");
     $("#no_hp_penanggung").focus();

}
else if (pekerjaan_penanggung == '')
{
      alert("Isi Pekerjaan Penanggung Jawab Pasien!!");
      $("#pekerjaan_penanggung").focus();
}
else if (perkiraan_menginap == '')
 {
  alert("Perkiraan Menginap Harus Di isi");
  $("#perkiraan_menginap").focus();
 }
else if (surat_jaminan == '') {
alert("Surat jaminan Harus Di isi");
$("#surat_jaminan").focus();

} 

else{
  $("#coba").show();
 $.post("proses_rawat_inap.php",{ruangan:ruangan,group_bed:group_bed,bed:bed,rujukan:rujukan,penjamin:penjamin,no_rm:no_rm,nama_lengkap:nama_lengkap,jenis_kelamin:jenis_kelamin,tanggal_lahir:tanggal_lahir,umur:umur,alamat:alamat,hp_pasien:hp_pasien,penanggung_jawab:penanggung_jawab,alamat_penanggung:alamat_penanggung,no_hp_penanggung:no_hp_penanggung,pekerjaan_penanggung:pekerjaan_penanggung,hubungan_dengan_pasien:hubungan_dengan_pasien,perkiraan_menginap:perkiraan_menginap,surat_jaminan:surat_jaminan,dokter_pengirim:dokter_pengirim,poli:poli,dokter_penanggung_jawab:dokter_penanggung_jawab,kondisi:kondisi,sistole_distole:sistole_distole,respiratory_rate:respiratory_rate,suhu:suhu,nadi:nadi,berat_badan:berat_badan,tinggi_badan:tinggi_badan,alergi:alergi,token:token},function(data){
     
     $("#demo").hide();

     $("#litombol").show();

        $('#table_rawat_inap').DataTable().destroy();
     
 var dataTable = $('#table_rawat_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_rawat_inap.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_rawat_inap").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[21]+'');

},
        } );
      $("#ruangan").val('');
     $("#group_bed").val('');
     $("#bed").val('');
     $("#no_rm").val('');
     $("#nama_lengkap").val('');
     $("#jenis_kelamin").val('');
     $("#tanggal_lahir").val('');
     $("#umur").val('');
     ("#alamat").val('');
     $("#hp_pasien").val('');
     $("#penanggung_jawab").val('');
     $("#alamat_penanggung").val('');
     $("#no_hp_penanggung").val('');
     $("#pekerjaan_penanggung").val('');
     $("#hubungan_dengan_pasien").val('');
     $("#perkiraan_menginap").val('');
     $("#surat_jaminan").val('');
     $("#dokter_pengirim").val('');
     $("#poli").val('');
     $("#dokter_penanggung_jawab").val('');
     $("#kondisi").val('');
     $("#sistole_distole").val('');
     $("#respiratory_rate").val('');
     $("#suhu").val('');
     $("#nadi").val('');
     $("#berat_badan").val('');
     $("#tinggi_badan").val('');
     $("#alergi").val('');
     $("#token").val('');
     
     });

      }
  });

    $("form").submit(function(){
    return false;
    
    });


   </script>





<script type="text/javascript">
    $(document).ready(function(){
    // Tooltips Initialization
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });

    });
</script>

<!-- data ambil dari pasien  -->
<script type="text/javascript">
//            jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih', function (e) {
                document.getElementById("no_rm").value = $(this).attr('data-no');
                document.getElementById("nama_lengkap").value = $(this).attr('data-nama');
                document.getElementById("tanggal_lahir").value = $(this).attr('data-lahir');
                document.getElementById("alamat").value = $(this).attr('data-alamat');
                document.getElementById("jenis_kelamin").value = $(this).attr('data-jenis-kelamin');
                document.getElementById("hp_pasien").value = $(this).attr('data-hp');
                document.getElementById("penjamin").value = $(this).attr('data-penjamin');

                $('#myModal').modal('hide');


// untuk update umur ketika sudah beda bulan dan tahun

function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("-");   

var dobDay = birthday[0]; 
var dobMonth= birthday[1];
var dobYear= birthday[2];

var nowDay= now.getDate();
var nowMonth = now.getMonth() + 1;  //jan=0 so month+1
var nowYear= now.getFullYear();

var ageyear = nowYear- dobYear;
var agemonth = nowMonth - dobMonth;
var ageday = nowDay- dobDay;
if (agemonth < 0) {
       ageyear--;
       agemonth = (12 + agemonth);
        }
if (nowDay< dobDay) {
      agemonth--;
      ageday = 30 + ageday;
      }


if (ageyear <= 0) {
 var val = agemonth + " Bulan";
}
else {

 var val = ageyear + " Tahun";
}
return val;
}



    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = hitung_umur(tanggal_lahir);
    if (tanggal_lahir == '')
    {
    
    }
    else
    {
    $("#umur").val(umur);
    }


});

      //   tabel lookup mahasiswa        
</script>
<!-- end data ambil dari pasien  -->

<!-- modal ke rujukan lab  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
    $(document).on('click', '.rujuk-lab', function (e) {
            var id = $(this).attr('data-id');

    $.post("form-rujuk-lab-ri.php",{id:id},function(info){
    $("#rujukan_lab").html(info);

    });

    $('#Modal3').modal('show');
    
    });
           
</script>
<!-- akhir modal ke rujukan lab  -->



<script type="text/javascript">

            // jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih3', function (e) {
            document.getElementById("bed2").value = $(this).attr('data-nama');
            document.getElementById("group_bed2").value = $(this).attr('data-group-bed');
                
  });
      
  $(function () {
  $("#siswaki").dataTable();
  });      
          
</script>


<!--   script untuk detail layanan PINDAH KAMAR-->
<script type="text/javascript">
    $(document).on('click', '.pindah', function (e) {
            
            var id = $(this).attr('data-id');
            var reg = $(this).attr('data-reg');
            var bed = $(this).attr('data-bed');
            var group_bed = $(this).attr('data-group-bed');
            var no_reg = $(this).attr('data-reg');

            $("#pindah_kamar").attr("data-ids",id);
            $("#pindah_kamar").attr("data-regs",reg);
            $("#pindah_kamar").attr("data-beds",bed);
            $("#pindah_kamar").attr("data-group_beds",group_bed);

            $("#modal_kamar").modal('show');
            $("#kamar_lama").val(group_bed);

            $('#table-kamar').DataTable().destroy();
                                var dataTable = $('#table-kamar').DataTable( {
                                    "processing": true,
                                    "serverSide": true,
                                    "ajax":{
                                      url :"pindah_kamar.php", // json datasource
                                      type: "post",  // method  , by default get
                                      error: function(){  // error handling
                                        $(".tbody").html("");
                                        $("#table-kamar").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
                                        $("#table-kamar_processing").css("display","none");
                                        
                                      }
                                    },

                                     "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                                          $(nRow).attr('class', "pilih3");
                                         $(nRow).attr('data-group-bed',aData[2]);
                                        $(nRow).attr('data-nama',aData[1]);

                          },
                   });


            });
//            tabel lookup mahasiswa         


  $(document).on('click', '#pindah_kamar', function (e) {
    var reg_before = $(this).attr("data-regs");
    var bed_before = $(this).attr("data-beds");
    var group_bed_before = $(this).attr("data-group_beds");
    var group_bed2 = $("#group_bed2").val();
    var bed2 = $("#bed2").val();
    var lama_inap = $("#lama_inap").val();
    var id = $(this).attr("data-ids");

  

      $.post("update_pindah_kamar.php",{lama_inap:lama_inap,reg_before:reg_before,bed_before:bed_before,group_bed_before:group_bed_before,group_bed2:group_bed2,bed2:bed2,id:id},function(data){
      
      $("#modal_kamar").modal('hide');

        $('#table_rawat_inap').DataTable().destroy();

 var dataTable = $('#table_rawat_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_rawat_inap.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_rawat_inap").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[21]+'');

},
        });

      });
  });
</script>



<script type="text/javascript">

            // jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih3', function (e) {
              var no_reg = $("#no_reg").val();
              var bed2 = $(this).attr('data-nama');
              var group_bed2 = $(this).attr('data-group-bed');


        $.post("cek_kamar_ranap.php",{bed2:bed2,no_reg:no_reg},function(data){

                          if (data == 1) {
                    alert("Kamar yang anda masukan sudah ada,Silahkan pilih kamar lain!");
                      $("#group_bed2").val('')
                      $("#bed2").val('')
                          }
                          else{

                      $("#group_bed2").val(group_bed2)
                      $("#bed2").val(bed2)

                          }
             });    
  });
           
          
</script>

<!--   script untuk Batal-->
<script type="text/javascript">
     $(document).on('click', '.batal_ranap', function (e) {
               var reg = $(this).attr("data-reg");
               var id = $(this).attr("data-id");

               $("#input_keterangan").attr('data-id',id);
               $("#modal_batal").modal('show');
               $("#no_reg").val(reg);


               
     });
//            tabel lookup mahasiswa         
</script>

<script type="text/javascript">
     $(document).on('click', '#input_keterangan', function (e) {    
                    var reg = $("#no_reg").val();
                    var keterangan = $("#keterangan").val();
                    var id = $(this).attr("data-id");                    
                    
                    $("#modal_batal").modal('hide');
                    
                    $.post("proses_keterangan_batal_ri.php",{reg:reg, keterangan:keterangan},function(data){
                      $('#table_rawat_inap').DataTable().destroy();
     
                  var dataTable = $('#table_rawat_inap').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "ajax":{
                        url :"proses_table_rawat_inap.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".employee-grid-error").html("");
                          $("#table_rawat_inap").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                          $("#employee-grid_processing").css("display","none");
                          }
                      },
                         "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                          $(nRow).attr('class','tr-id-'+aData[12]+'');         

                      }
                    });
                    });

                    
        }); 

     
</script>
<!--  end script untuk batal-->



<!--script disable hubungan pasien-->
<script type="text/javascript">
  $("#coba").click(function(){
  $("#demo").show();
  $("#kembali").show();
  $("#litombol").hide();
   $("#coba").hide();
  });
    $("#kembali").click(function(){
  $("#demo").hide();
  $("#coba").show();
  $("#kembali").hide();
  $("#litombol").show();

  });

</script>


<script>

function hitung_umur(tanggal_input){



var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("-");   

var dobDay = birthday[0]; 
var dobMonth= birthday[1];
var dobYear= birthday[2];

var nowDay= now.getDate();
var nowMonth = now.getMonth() + 1;  //jan=0 so month+1
var nowYear= now.getFullYear();

var ageyear = nowYear- dobYear;
var agemonth = nowMonth - dobMonth;
var ageday = nowDay- dobDay;
if (agemonth < 0) {
       ageyear--;
       agemonth = (12 + agemonth);
        }
if (nowDay< dobDay) {
      agemonth--;
      ageday = 30 + ageday;
      }


if (ageyear <= 0) {
 var val = agemonth + " Bulan";
}
else {

 var val = ageyear + " Tahun";
}
return val;
}


$( "#tanggal_lahir" ).change(function(){
    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = hitung_umur(tanggal_lahir);
if (tanggal_lahir == '')
{

}
else
{
  $("#umur").val(umur);
}

});
</script>


<script>
  $(function() {
  $( "#tanggal_lahir" ).pickadate({ selectYears: 100, format: 'yy-mm-dd'});
  });
  </script>


<!-- modal ambil data dari table RI  -->
<script type="text/javascript">
//            jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih2', function (e) {
            document.getElementById("bed").value = $(this).attr('data-nama');
            document.getElementById("group_bed").value = $(this).attr('data-group-bed');
                
  $('#myModal1').modal('hide');
  });
/*      
  $(function () {
  $("#siswa1").dataTable();
  });
// tabel lookup mahasiswa
  */
          
</script>
<!-- end ambil data RI  -->



<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
<script type="text/javascript">
     $("#lay").click(function() 
{   
    var penjamin = $("#penjamin").val();

                $.post("detail_layanan_perusahaan2.php",{penjamin:penjamin},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         
</script>
<!--  end script untuk akhir detail layanan PERUSAHAAN -->


<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_rm = $("#no_rm").val();
    var nama_pasien = $("#nama_pasien").val();

 $.post('cek_pasien_ranap.php',{no_rm:no_rm,nama_pasien:nama_pasien}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Pasien Yang Sudah Ada!");
    $("#no_rm").val('');
    $("#nama_pasien").val('');
    $("#no_hp").val('');
    $("#tanggal_lahir").val('');
    $("#alamat").val('');
    $("#jenis_kelamin").val('');
    $("#penjamin").val('');
    $("#gol_darah").val('');
    $("#umur").val('');

   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>


<!--   script rujuk lab (input data pemeriksaan lab/jasa lab)-->
<script type="text/javascript">
     $(document).on('click', '.pemeriksaan_lab_inap', function (e) {
               var rm = $(this).attr("data-rm");
               var nama = $(this).attr("data-nama");
               var reg = $(this).attr("data-reg");

               var kamar = $(this).attr("data-kamar");
               var bed = $(this).attr("data-bed");

               var id = $(this).attr("data-id");
               var pasien = $('#name-tag-'+id).text();

  
        $("#modal_lab_inap").modal('show');

               $("#lab_nama").val(pasien);
               $("#lab_rm").val(rm);
               $("#lab_reg").val(reg);
               $("#lab_bed").val(bed);
               $("#lab_kamar").val(kamar);

  $("#input_lab").attr('href','data_laboratorium_inap.php?no_reg='+reg+'&nama='+pasien+'&bed='+bed+'&kamar='+kamar+'&no_rm='+rm);
               
     });
</script>
<!--    ENDING script rujuk lab (input data pemeriksaan lab/jasa lab)-->


<!-- footer  -->
<?php 
include 'footer.php'; 
?>
<!-- end footer  -->