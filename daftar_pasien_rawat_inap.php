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

$query7 = $db->query("SELECT * FROM registrasi WHERE jenis_pasien = 'Rawat Inap' AND status != 'Batal Rawat Inap' AND status != 'Sudah Pulang'  ");

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
<div style="padding-left:5%; padding-right:5%;">

<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal fade" role="dialog">
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
<div id="modal_kamar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Pindah Kamar</h2></center>       
    </div>
    <div class="modal-body">

      <span id="tampil_kamar">
      </span>
      <form role="form" method="POST">

      <div class="form-group" >
        <label for="bed">Kamar :</label>
        <input style="height: 20px" type="text" class="form-control" id="bed2" name="bed2"  readonly="" >
      </div>

      <div class="form-group" >
        <label for="bed">Group Bed:</label>
        <input style="height: 20px" type="text" class="form-control" id="group_bed2" name="group_bed2"  readonly="">
      </div>

 
       <button style='width:100px;'type='button' class='btn btn-warning pindah' data-id=""  data-reg="" data-bed="" data-group_bed="" id="pindah_kamar"> <i class="fa fa-reply"></i>Pindah</button>
       </div>
       <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-remove"></i> Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan KAMAR-->


<!-- Modal Untuk batal ranap-->
<div id="modal_batal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Batal Rawat Jalan </h2></center>       
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

 <h3>DATA PASIEN RAWAT INAP</h3><hr>


<ul class="nav nav-tabs yellow darken-4" role="tablist">
        <li class="nav-item"><a class="nav-link" href='rawat_inap.php' data-placement='top' >Daftar Pasien <u>R</u>awat Inap</a></li>
        <li class="nav-item"><a class="nav-link" href='daftar_pasien_rawat_inap_batal.php' data-placement='top' title='Klik untuk melihat pasien batal rawat inap.'>  Pasien Batal Rawat Inap </a></li>
        <li class="nav-item"><a class="nav-link" href='daftar_pasien_rawat_inap_pulang.php' data-placement='top' title='Klik untuk melihat pasien sudah pulang dari rawat inap.'> Pasien Rawat Inap Pulang </a></li>
</ul>

<br>
<div class="table-responsive">
<table id="table_rawat_inap" class="table table-bordered table-sm">
 
    <thead>
      <tr><th style='background-color: #4CAF50; color: white'>Batal</th>
          <th style='background-color: #4CAF50; color: white'>Transaksi Penjualan</th>
          <th style='background-color: #4CAF50; color: white'>Pindah Kamar</th>
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
    <tbody id="tbody">
    
   <?php while($data = mysqli_fetch_array($query7))
      
      {
      echo "<tr class='tr-id-".$data['id']."'>";

                echo"<td><button style='width:55px;' class='btn btn-floating btn-small btn-info' id='batal_ranap' data-reg='". $data['no_reg']. "' data-id='". $data['id']. "'><i class='fa fa-remove'></i> </button></td>";
        ?>
        <?php
              $query_z = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$data[no_reg]' ");
              $data_z = mysqli_fetch_array($query_z);

               
                    if ($data_z['status'] == 'Simpan Sementara') {

                    echo "<td> <a href='proses_pesanan_barang_ranap.php?no_faktur=".$data_z['no_faktur']."&no_reg=".$data['no_reg']."&kode_pelanggan=".$data['no_rm']."&nama_pelanggan=".$data_z['nama']."&kode_gudang=".$data_z['kode_gudang']."'class='btn btn-floating btn-small btn btn-danger'><i class='fa fa-credit-card'></i></a> </td>"; 
                    }
                    else
                    {
                    echo "<td><a href='form_penjualan_kasir_ranap.php?no_reg=". $data['no_reg']. "' style='width:55px;' class='btn btn-floating btn-small btn-success'><i class='fa fa-shopping-cart'></i></a></td>";
                    }

            echo "<td> <button type='button' data-reg='".$data['no_reg']."' data-bed='".$data['bed']."' data-group-bed='".$data['group_bed']."' data-id='".$data['id']."' data-reg='".$data['no_reg']."'  class='btn btn-floating btn-small btn-info pindah'><i class='fa fa-reply'></i></button></td>";

            echo"<td>". $data['no_rm']."</td>
            <td>". $data['no_reg']."</td>
            <td>". $data['status']."</td>           
            <td>". $data['nama_pasien']."</td>
            <td>". $data['jam']."</td>           
            <td>". $data['penjamin']."</td>           
            <td>". $data['poli']."</td>
            <td>". $data['dokter_pengirim']."</td>
            <td>". $data['dokter']."</td>           
            <td>". $data['bed']."</td>
            <td>". $data['group_bed']."</td>
            <td>". tanggal($data['tanggal_masuk'])."</td>            
            <td>". $data['penanggung_jawab']."</td>
            <td>". $data['umur_pasien']."</td> 

            

      </tr>";
      
      }
    ?>
  </tbody>
 </table>
</div>


</div>




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
     $(".pindah").click(function(){   
            
            var id = $(this).attr('data-id');
            var reg = $(this).attr('data-reg');
            var bed = $(this).attr('data-bed');
            var group_bed = $(this).attr('data-group-bed');
            var no_reg = $(this).attr('data-reg');

            $("#pindah_kamar").attr("data-id",id);
            $("#pindah_kamar").attr("data-reg",reg);
            $("#pindah_kamar").attr("data-bed",bed);
            $("#pindah_kamar").attr("data-group_bed",group_bed);

                $.post("pindah_kamar.php",{reg:reg,bed:bed,group_bed:group_bed},function(data){
                $("#tampil_kamar").html(data);
                $("#modal_kamar").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         


  $(document).on('click', '#pindah_kamar', function (e) {
    var reg_before = $(this).attr("data-reg");
    var bed_before = $(this).attr("data-bed");
    var group_bed_before = $(this).attr("data-group_bed");
    var group_bed2 = $("#group_bed2").val();
    var bed2 = $("#bed2").val();
    var id = $(this).attr("data-id");

      $(".tr-id-"+id+"").remove();
      $.post("update_pindah_kamar.php",{reg_before:reg_before,bed_before:bed_before,group_bed_before:group_bed_before,group_bed2:group_bed2,bed2:bed2,id:id},function(data){
      
      $("#modal_kamar").modal('hide');
      $("#tbody").prepend(data);


      });
  });
</script>


<script type="text/javascript">
  

  $(document).on('click', '#batal_ranap', function (e) {
    var no_reg = $(this).attr("data-reg");
    var id = $(this).attr("data-id");
     $("#no_reg").val(no_reg);
     $("#input_keterangan").attr("data-id",id)

    $("#modal_batal").modal('show');
      
  });


  $(document).on('click', '#input_keterangan', function (e) {
    var no_reg = $("#no_reg").val();
    var keterangan = $("#keterangan").val();
    var id = $(this).attr("data-id");

      $(".tr-id-"+id+"").remove();
      $.post("proses_keterangan_batal_ri.php",{no_reg:no_reg, keterangan:keterangan},function(data){
      
      $("#modal_batal").modal('hide');

      });
  });

</script>


<!--datatable-->
<script type="text/javascript">
  $(function () {
  $("table").dataTable({"ordering": false});
  }); 
</script>
<!--end datatable--> 

<!-- modal ambil data dari table RI  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih2', function (e) {
            document.getElementById("bed").value = $(this).attr('data-nama');
            document.getElementById("group_bed").value = $(this).attr('data-group-bed');
                
  $('#myModal1').modal('hide');
  });
      
  $(function () {
  $("#siswa1").dataTable();
  });
// tabel lookup mahasiswa
  
          
</script>
<!-- end ambil data RI  -->

<?php include 'footer.php';
?>



