<?php include 'session_login.php';
                             
//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
//menampilkan seluruh data yang ada pada tabel pembelian

$perintah = $db->query("SELECT * FROM item_masuk");
                                                    
?>
                              
                              <!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
                              <div class="container">
                              
                          
                              
                              <!-- membuat form menjadi beberpa bagian -->
                              <form enctype="multipart/form-data" role="form" action="form_item_masuk.php" method="post ">
                              
                              <!-- membuat teks dengan ukuran h3 -->
                              <h3> <u>FORM ITEM MASUK</u> </h3><br> 
                              
                              <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
                              <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
                              
                              </form>
                              
                              
                              <!-- membuat tombol agar menampilkan modal -->
                              <button type="button" class="btn btn-info" id="cari_item_masuk" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari</button>
                              
                              <!-- Tampilan Modal -->
                              <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog ">
                              
                              <!-- Isi Modal-->
                              <div class="modal-content">
                              <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Data Barang</h4>
                              </div>
                              <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
                              
                              <div class="table-responsive">                              
                             <center>
                              <table id="table_item_masuk" class="table table-bordered table-sm">
                            <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
                          <th> Kode Barang </th>
                          <th> Nama Barang </th>
                          <th> Jumlah Barang </th>
                          <th> Kategori </th>
                          <th> Suplier </th>
                          <th> Satuan </th>
                          <th> Harga Beli</th>
        
                          </thead> <!-- tag penutup tabel -->
                              </table>
                              </center>
                              </div> 
                              
                              </div><!-- tag penutup modal body -->
                              <!-- tag pembuka modal footer -->
                              <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div> <!--tag penutup moal footer -->
                              </div>
                              
                              </div>
                              </div>
                              
                              <div class="row">

                                  <div class="col-sm-9">
                                      <!-- membuat form -->
                                      <form action="proses_tbs_item_masuk.php" role="form" id="formtambahproduk">
                                     

                                      <div class="col-sm-3">
                                      <input style="height: 20px" type="text"  class="form-control" id="kode_barang" placeholder="Kode / Nama Produk" autocomplete="off">
                                      </div>

                                      <div class="col-sm-2">
                                      <input style="height: 20px" type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                      </div>

                                      <div class="col-sm-2">
                                      <input style="height: 20px; width: 90px" type="text" class="form-control" name="hpp_item_masuk" id="hpp_item_masuk" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="Nilai HPP" autocomplete="off">
                                      </div>


                                      <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah</button>
                                     
                                      


                                      <input type="hidden" class="form-control"  name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
                                      <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
                                      <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
                                      <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
                                      <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >                                   
                                      </form>


                              
                              <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                              <span id="result">  
                              
                              <div class="table-responsive">
                              <!--tag untuk membuat garis pada tabel-->     
                              <table id="tableuser" class="table table-bordered table-sm">
                              <thead>
                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              
                              <th> Hapus </th>
                              
                              </thead>
                              
                              <tbody id="tbody">

                              <?php
                              
                              //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                              $perintah = $db->query("SELECT tim.id,tim.kode_barang,tim.nama_barang,tim.jumlah,tim.harga,tim.subtotal,s.nama FROM tbs_item_masuk tim INNER JOIN satuan s ON tim.satuan = s.id
                              WHERE tim.session_id = '$session_id'");
                              
                              //menyimpan data sementara yang ada pada $perintah
                              
                              while ($data1 = mysqli_fetch_array($perintah))
                              {
                              //menampilkan data
                              echo "<tr class='tr-id-".$data1['id']." tr-kode-".$data1['kode_barang']."' kode_barang='".$data1['kode_barang']."'>
                              <td>". $data1['kode_barang'] ."</td>
                              <td>". $data1['nama_barang'] ."</td>

                             <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-subtotal='".$data1['subtotal']."' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' > </td>
                             

                              <td>". $data1['nama'] ."</td>
                              <td>". rp($data1['harga']) ."</td>
                              <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                              
                              <td> <button class='btn btn-danger btn-sm btn-hapus' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."' > <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                              </tr>";
                              }


                              //Untuk Memutuskan Koneksi Ke Database
                              
                              mysqli_close($db); 
                              ?>

                              </tbody>
                              
                              </table>
                              </div>
                              </span>

                                  </div>

                                  <div class="col-sm-3">
                                      <form action="proses_bayar_item_masuk.php" id="form_item_masuk" method="POST"><!--tag pembuka form-->
                                      
                                      <label> Total </label><br>
                                      <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
                                      <input type="text" name="total" id="total_item_masuk" class="form-control" data-total="" placeholder="Total" readonly=""  >
                                      
                                      
                                      <label> Keterangan </label><br>
                                      <textarea name="keterangan" id="keterangan" style="height: 85px" class="form-control" ></textarea>
                                      
                                      <a class="btn btn-primary" href="form_item_masuk.php" id="transaksi_baru" style="display: none"> <span class='glyphicon glyphicon-repeat'> </span> Transaksi Baru</a>
                                      <!--membuat tombol submit bayar & Hutang-->
                                      <button type="submit" id="pembayaran_item_masuk" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai </a> </button>
                                      
                                      
                                      <!--membuaat link pada tombol batal-->
                                      <a href='batal_item_masuk.php?session_id=<?php echo $session_id;?>' id='batal' class='btn btn-danger'><i class='fa fa-close'></i> Batal </a>
                                      
                                      <input type="hidden" name="session_id" id="nomorfaktur" class="form-control" value="<?php echo $session_id; ?>">
                                      
                                      </form><!--tag penutup form-->
                                      
                                      <div class="alert alert-success" id="alert_berhasil" style="display:none">
                                      <strong>Success!</strong> Data Item Masuk Berhasil
                                      </div>
                                  </div>

                                
                              </div>
                              
                    
                              
<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Item Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_nama" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Item Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
                  <label> Jumlah Barang Baru </label> <br>
                  <input type="text" name="jumlah_baru" id="edit_jumlah" class="form-control" autocomplete="off" required="" >

                  <input type="hidden" name="jumlah_lama" id="edit_jumlah_lama" readonly="">

                  <input type="hidden" name="harga" id="edit_harga">

                  <input type="hidden" class="form-control" id="id_edit">
                              
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

</div>

  </div>
</div><!-- end of modal edit data  -->

                              
                              
                              
                              <span id="demo"> </span>

                              
                              </div><!-- end of container -->
                              
<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#tableuser').DataTable({"ordering":false});
    });

</script>                 
          
                              
                              <!--untuk memasukkan perintah java script-->
                              <script type="text/javascript">
                              
                              // jika dipilih, nim akan masuk ke input dan modal di tutup
                              $(document).on('click', '.pilih', function (e) {
                              document.getElementById("kode_barang").value = $(this).attr('data-kode');
                              document.getElementById("nama_barang").value = $(this).attr('nama-barang');
                              document.getElementById("satuan_produk").value = $(this).attr('satuan');
                              document.getElementById("harga_produk").value = $(this).attr('harga');
                              
                              
                              
                              $('#myModal').modal('hide');
                              });
                              
 
                              
                              
                              </script>
                              
                              
                              <script>
                              //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
                              $("#submit_produk").click(function(){

                                    var kode_barang = $("#kode_barang").val();
                                    var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
                                    var satuan = $("#satuan_produk").val();
                                    var nama_barang = $("#nama_barang").val();
                                    var harga = $("#harga_produk").val();
                                    var session_id = $("#session_id").val();
                                    var cek_barang = $(".tr-kode-"+kode_barang+"").attr("kode_barang");
                                    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
                                    var hpp_item_masuk = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#hpp_item_masuk").val()))));
                                    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                              
                                        
                                        if (total == '') 
                                        {
                                        total = 0;
                                        }
                                        
                                        if (hpp_item_masuk == "") {
                                          harga = harga;
                                        }
                                        else{
                                          harga = hpp_item_masuk;
                                        }


                                        

                                        var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);
                                        
                                        var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);
                                        
                                                                                
     
                                    if (kode_barang == ""){
                                    alert("Kode Harus Diisi");
                                    $("#kode_barang").focus();
                                    }
                                    else if (jumlah_barang == ""){
                                    alert("Jumlah Barang Harus Diisi");
                                    $("#jumlah_barang").focus();
                                    }
                                    else if (kode_barang == cek_barang){
                                    alert("Barang yang anda masukan sudah ada, silahkan pilih barang lain.");
                                    $("#kode_barang").val('');
                                    $("#jumlah_barang").val('');
                                    $("#hpp_item_masuk").val('');
                                    $("#satuan_produk").val('');
                                    $("#nama_barang").val('');
                                    $("#harga_produk").val('')
                                    $("#cari_item_masuk").click();


                                    }                                   
                                    else
                                    {

                                      
                                      $("#total_item_masuk").val(tandaPemisahTitik(subtotal));

                                      
                                      $.post("proses_tbs_item_masuk.php",{hpp_item_masuk:hpp_item_masuk,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {
                                      

                                      $("#tbody").prepend(info);
                                      $("#hpp_item_masuk").val('');
                                      $("#kode_barang").val('');
                                      $("#nama_barang").val('');
                                      $("#jumlah_barang").val('');
                                      
                                      });

                                    }
                              
                                      $("form").submit(function(){
                                      return false;
                                      });
                              
                              
                              
                                  });
                              
                                      //menampilkan no urut faktur setelah tombol click di pilih
                                      $("#cari_item_masuk").click(function() {
                                      $.get('no_faktur_IM.php', function(data) {
                                      /*optional stuff to do after getScript */ 
                                      $("#nomorfaktur").val(data);
                                      $("#nomorfaktur1").val(data);
                                      });
                                      //menyembunyikan notif berhasil
                                      $("#alert_berhasil").hide();
                                      /* Act on the event */
           

   });            
 </script>
        

<script type="text/javascript">
  $(document).ready(function(){
    $("#table_item_masuk").DataTable().destroy();
          var dataTable = $('#table_item_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_item_masuk_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_item_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]+"("+aData[1]+")");
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[6]);


          }

        }); 
});
</script>


<script type="text/javascript" language="javascript" >
   $("#cari_item_masuk").click(function() {
       
     
  });
 
 </script>


                              <script type="text/javascript">
                              //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
                              $("#pembayaran_item_masuk").click(function(){
                              
                                    var total = $("#total_item_masuk").val();
                                    var keterangan = $("#keterangan").val();
                                    var session_id = $("#session_id").val();

                                    $("#keterangan").val('');
                                    $("#total_item_masuk").val('');
                              

                                    if (total == ""){
                                    alert("Tidak Ada Total Item Masuk");
                                    }

                                   
                                    else
                                    {

                                      $("#pembayaran_item_masuk").hide();
                                      $("#batal").hide();
                                      $("#transaksi_baru").show();


                              
                              $.post("proses_bayar_item_masuk.php",{session_id:session_id,total:total,keterangan:keterangan},function(info) {
                              
                              $("#demo").html(info);       
                              $("#result").load("tabel_item_masuk.php");
                              $("#alert_berhasil").show();
                              $("#total_item_masuk").val('');
                              $("#keterangan").val('');
                              
                              
                              
                              
                              });

                                }
                              
                              // #result didapat dari tag span id=result
                              
                              //mengambil no_faktur pembelian agar berurutan
                              
                              $("#form_item_masuk").submit(function(){
                              return false;
                              });
                              });
                              
                              
                              
                              </script>
                              
                              
                              <script>
                              
                              $(document).ready(function(){

                                var session_id = $("#session_id").val();

                              $.post("cek_total_item_masuk.php",
                              {
                              session_id: session_id 
                              },
                              function(data){
                                data = data.replace(/\s+/g, '');
                              $("#total_item_masuk").val(data);
                              });
                              
                              });
                              
                              </script>
                              
                              
                              
          <script type="text/javascript">
            $(document).ready(function(){


//fungsi hapus data 
            $(document).on('click', '.btn-hapus', function (e) {
            var id = $(this).attr("data-id");
            var sub_total = $(this).attr("data-subtotal");
            var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));

            if (total == '') 
              {
                total = 0;
              }
                                        
            else if (sub_total == '') {
                sub_total = 0;
              }


            
            var total_akhir = parseInt(total,10) - parseInt(sub_total,10);

            $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));

$(".tr-id-"+id).remove();
            $.post("hapus_tbs_item_masuk.php",{id:id},function(data){
         
            
            
                     
            });
            });

            $('form').submit(function(){
            
            return false;
            });
            
            });
            

        </script>

<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>

   <script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){
           var session_id = $("#session_id").val();
          var kode_barang = $("#kode_barang").val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          
          $.post('cek_kode_barang_tbs_item_masuk.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").focus();
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)        

      $.getJSON('lihat_item_masuk.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#satuan_produk').val('');
        $('#harga_produk').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga_beli);
      }
                                              
        });
        
        });
        });

      
      
</script>

                                    <script type="text/javascript">
                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    
                                    $(".input_jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);
                                    
                                    $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    
                                    $.post("update_jumlah_barang_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
                                    

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    
                                    
                                    });
                                    
                                    $("#kode_barang").focus();
                                    
                                    });
                                    
                                    </script>    


<?php include 'footer.php'; ?>