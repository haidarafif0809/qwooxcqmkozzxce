<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
    $nomor_faktur = stringdoang($_GET['no_faktur']);
    $suplier = stringdoang($_GET['suplier']);
    $nama_suplier = stringdoang($_GET['nama_suplier']);
    $kode_gudang = stringdoang($_GET['kode_gudang']);
    $nama_gudang = stringdoang($_GET['nama_gudang']);

    $tbs = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$nomor_faktur'");
    $data_tbs = mysqli_num_rows($tbs);


//menampilkan seluruh data yang ada pada tabel pembelian
    $perintah = $db->query("SELECT tanggal,no_faktur_suplier FROM pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_tanggal = mysqli_fetch_array($perintah);

    $jumlah_bayar_hutang = $db->query("SELECT SUM(jumlah_bayar) AS jumlah_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");

    $ambil_jumlah = mysqli_fetch_array($jumlah_bayar_hutang);

    $jumlah_bayar = $ambil_jumlah['jumlah_bayar'];

    $potongan_hutang0 = $db->query("SELECT SUM(potongan) AS potongan FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");
    $ambil_potongan = mysqli_fetch_array($potongan_hutang0);
    $potongan_hutang = $ambil_potongan['potongan'];

    $jumlah_bayar_lama = $jumlah_bayar + $potongan_hutang;

    $data_potongan = $db->query("SELECT total, potongan, tax, ppn,tanggal_jt FROM pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_potongan = mysqli_fetch_array($data_potongan);

    $potongan = $ambil_potongan['potongan'];
    $tax = $ambil_potongan['tax'];
    $ppn = $ambil_potongan['ppn'];
    $total = $ambil_potongan['total'];
    $tanggal_jt = $ambil_potongan['tanggal_jt'];

    $data_potongan_persen = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_potongan_persen = mysqli_fetch_array($data_potongan_persen);
    $subtotal_persen = $ambil_potongan_persen['subtotal'];

    if ($potongan == "0.00") {
     $hasil_persen = 0;
    }
    else
    {
           $potongan_persen = $potongan / $subtotal_persen * 100;
           $hasil_persen = intval($potongan_persen);
    }



    if ($tax == 0) {
    $hasil_tax = 0;
    }
    else
    {
    $subtotal_tax = $subtotal_persen - $potongan;
    $hasil_sub = intval($subtotal_tax);
    $potongan_tax = $tax / $hasil_sub * 100;
    $hasil_tax = intval($potongan_tax);
    }


    ?>

    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
    }
    </style>
    
    <script>
    $(function() {
    $( ".tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });

    Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
  };
    </script>
    
    <script src="shortcut.js"></script>
    
<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
     <div style="padding-left: 5%; padding-right: 2%">
    
              
          <!-- membuat teks dengan ukuran h3 -->
          <h3> EDIT DATA PEMBELIAN </h3><br>


<!--membuat agar tabel berada dalam baris tertentu-->


<!--membuat tampilan halaman menjadi 8 bagian-->


<div class="row">
    <div class="col-sm-8">


      <!-- membuat form menjadi beberpa bagian -->
        <form enctype="multipart/form-data" role="form" method="post ">


        <div class="col-sm-2">
         <input type="text" class="form-control" name="no_faktur_suplier" id="no_faktur_suplier" autocomplete="off" placeholder="No. Faktur Suplier" value="<?php echo $ambil_tanggal['no_faktur_suplier']; ?>">
          
        </div>

              <div class="col-sm-2">
              <label> Suplier </label><br>
                
                <select name="suplier" id="nama_suplier" class="form-control chosen" required="" >
                <option value="<?php echo $suplier ?>"><?php echo $nama_suplier ?></option>
                <?php 
                
                // menampilkan seluruh data yang ada pada tabel suplier
                $query = $db->query("SELECT id,nama FROM suplier");
                
                // menyimpan data sementara yang ada pada $query
                while($data = mysqli_fetch_array($query))
                {
                
                echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
                }
                
                
                ?>
                </select>                               
              </div>
                
                
               
                
              <div class="col-sm-2">
                <label> Gudang </label><br>
                
                <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
                <option value="<?php echo $kode_gudang ?>"><?php echo $nama_gudang ?></option>
                <?php 
                
                // menampilkan seluruh data yang ada pada tabel suplier
                $query = $db->query("SELECT kode_gudang,nama_gudang FROM gudang");
                
                // menyimpan data sementara yang ada pada $query
                while($data = mysqli_fetch_array($query))
                {
                
                echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
                }
                
                
                ?>
                </select>
              </div>

              <div class="col-sm-2">
                <?php if ($data_tbs > 0): ?>

                      
                            <label>PPN</label>
                            <select name="ppn" id="ppn" class="form-control" disabled="true">
                            <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option> 
                            <option value="Include">Include</option>  
                            <option value="Exclude">Exclude</option>
                            <option value="Non">Non</option>          
                            </select>
                      

                            <?php else: ?>
                            
                         

                          
                            <label>PPN</label>
                            <select name="ppn" id="ppn" class="form-control">
                            <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option> 
                            <option value="Include">Include</option>  
                            <option value="Exclude">Exclude</option>
                            <option value="Non">Non</option>          
                            </select>
                         

                            <?php endif ?> 
              </div>            
                

              <div class="col-sm-2">
                <label> No Faktur </label><br>                
                <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
                <input style="height:20px" type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $nomor_faktur; ?>" required="" >
              </div>

              <div class="col-sm-2">
                <label> Tanggal </label><br>
                <input style="height:20px" type="text" name="tanggal" value="<?php echo $ambil_tanggal['tanggal']; ?>" id="tanggal" placeholder="  " value="" class="form-control tanggal" >
              </div>          
                

              

        </form> <!-- tag penutup form -->
              
         
              <div class="col-sm-12">
              <!-- membuat tombol agar menampilkan modal -->
              <button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"></i> Cari (F1)</button>
              <br><br>
                
              </div>
              <!-- Tampilan Modal -->
              <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
              
              <!-- Isi Modal-->
              <div class="modal-content">
              <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Data Barang</h4>
              </div>
              <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
              
              <!--perintah agar modal update-->
              <div class="table-resposive">
              <span class="modal_baru">
              
              
              </span>
      </div> <!-- / responsive -->        
      </div> <!-- tag penutup modal body -->
              
              <!-- tag pembuka modal footer -->
              <div class="modal-footer">
             
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div> <!--tag penutup moal footer -->
              </div>
              
              </div>
              </div>
              
              
              <form class="form-group" action="proses_tbs_edit_pembelian.php" role="form" id="formtambahproduk">
            
            <div class="col-sm-3">

  <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" harga_beli="'.koma($key['harga_beli'],2).'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" over_stok="'.$key['over_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        ?>
    </select>
            </div>      

              <!-- memasukan teks pada kolom kode barang -->
              <input style="height:20px" type="hidden" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
            
              
            <div class="col-sm-1">
              <input style="height:20px" type="text" class="form-control" accesskey="j" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Jumlah">
            </div>
              

            <div class="col-sm-2" style="width:90px">
                <select style="font-size:13px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="">
                
                <?php 
                
                
                $query = $db->query("SELECT id, nama  FROM satuan");
                while($data = mysqli_fetch_array($query))
                {
                
                echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
                }
                            
                ?>
                
                </select>
            </div>           
                

            <div class="col-sm-2" >
              <input style="height: 20px" type="text" id="harga_baru" name="harga_baru" class="form-control" placeholder="Harga">
            </div>              
              
            <div class="col-sm-2" style="width:90px">
              <input style="height: 20px" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Disc." >
            </div>
              
            <div class="col-sm-2" style="width:90px">
              <input style="height: 20px" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Pajak %" >
            </div>      

            <div class="col-sm-3">
              <!-- membuat tombol submit-->
              <button type="submit" id="submit_produk" class="btn btn-success"><i class="fa fa-plus"></i> Tambah (F3)</button>
            </div>
              
          
<!--HIDEN HIDDEN HIDDEN HIDDEN -->
              <input type="hidden" class="form-control"  name="over_stok" id="over_stok" autocomplete="off" placeholder="Over Stok">
              <input type="hidden" id="harga_lama" name="harga_lama" class="form-control" required="">

              <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
              <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
              <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
              <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
              <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
              <input type="hidden" name="no_faktur" class="form-control" value="<?php echo $nomor_faktur; ?>" required="" >
<!--HIDEN HIDDEN HIDDEN HIDDEN -->
        
        
   

        </form>

      <!-- Modal Hapus data -->
      <div id="modal_hapus" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Konfirmsi Hapus Data Edit Pembelian</h4>
            </div>
            <div class="modal-body">
         <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
         <form >
          <div class="form-group">
           <input type="text" id="nama-barang" class="form-control" readonly=""> 
           <input type="text" id="kode-barang" class="form-control" readonly=""> 
           <input type="hidden" id="id_hapus" class="form-control" >

          </div>
         
         </form>
         
        <div class="alert alert-success" style="display:none">
         <strong>Berhasil!</strong> Data berhasil Di Hapus
        </div>
       

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
              <h4 class="modal-title">Edit Data Pembelian Barang</h4>
            </div>
            <div class="modal-body">
        <form role="form">
         <div class="form-group">
          <label for="email">Jumlah Baru:</label>
           <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
          <label for="email">Jumlah Lama:</label>
           <input type="text" class="form-control" id="barang_lama" readonly="">
           <input type="hidden" class="form-control" id="harga_edit" readonly="">
           <input type="hidden" class="form-control" id="kode_edit" readonly="">
           <input type="hidden" class="form-control" id="faktur_edit" readonly="">
           <input type="hidden" class="form-control" id="potongan_edit" readonly="">
           <input type="hidden" class="form-control" id="tax_edit" readonly="">
           <input type="hidden" class="form-control" id="id_edit">
          
         </div>
         
         
         <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
        </form>
        <span id="alert"></span>
        <div class="alert-edit alert-success" style="display:none">
         <strong>Berhasil!</strong> Data berhasil Di Edit
        </div>
       

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div><!-- end of modal edit data  -->


      <div id="modal_alert" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info!</span></h3>
              <h4>Maaf No Transaksi <strong><?php echo $nomor_faktur; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi Penjualan, Pembayaran Hutang atau Retur Pembelian. Dengan daftar sebagai berikut :</h4>
            </div>

            <div class="modal-body">
            <span id="span_modal_alert">
             </span>


           </div>

            <div class="modal-footer">
              <h6 style="text-align: left"><i> 
              * Jika ingin mengedit jumlah harus lebih besar dari jumlah yang sudah keluar  <br>

              <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

        
            <!--Mendefinisikan sebuah bagian dalam dokumen-->  


        <div class="table-responsive"><!--tag untuk membuat garis pada tabel-->       
              <span id="result">  
        <table id="table_tbs_pembelian" class="table table-bordered table-sm">
          <thead>
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Harga </th>
            <th> Subtotal </th>
            <th> Potongan </th>
            <th> Tax </th>
            <th> Hapus </th>
            
          </thead>
        </table>
          </span> <!--tag penutup span-->
        </div>
        <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


      
    </div><!-- DISINI Penutup COL_SM_8-->

<!-- DISINI BATAS COL-SM-->

  <style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>



    <div class="col-sm-4">

      <form action="proses_bayar_beli.php" id="form_beli" method="POST"><!--tag pembuka form-->

          <div class="card card-block" style="width:80%; ">
            
            <div class="row">
              <div class="col-sm-6">
                <label> <b> Subtotal </b></label><br>
                <input style="height:20px;font-size:15px" type="text" name="total" id="total_pembelian1" class="form-control" placeholder="" readonly=""  >                
              </div>

              <div class="col-sm-6">
                <label> Potongan ( Rp ) </label><br>
                <input style="height:20px;font-size:15px" type="text" name="potongan" id="potongan_pembelian" value="<?php echo koma($potongan,2); ?>" class="form-control" autocomplete="off" placeholder=" ">
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <label> Potongan ( % ) </label><br>
                <input style="height:20px;font-size:15px" type="text" name="potongan_persen" id="potongan_persen" value="<?php echo koma($hasil_persen,2); ?>" class="form-control" autocomplete="off" placeholder="">
              </div>        
                
                
              <div class="col-sm-6">
                <label> Tax </label><br>
                <input style="height:20px;font-size:15px" type="text" name="tax" id="tax" class="form-control" value="<?php echo $hasil_tax; ?>" autocomplete="off" placeholder="" >
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <label> Tanggal Jatuh Tempo </label><br>
                <input style="height:20px;font-size:15px" type="text" name="tanggal_jt" id="tanggal_jt" placeholder="  " value="<?php echo $tanggal_jt; ?>" class="form-control tanggal" >
              </div> 


              <div class="col-sm-6">
                <label> <b> Cara Bayar (F4) </b></label><br>
                <select type="text" name="cara_bayar" id="carabayar1" class="form-control"  required="" style="font-size: 16px" >
                  <option> Silahkan Pilih </option>
                    <?php 

                      $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                      $data_sett = mysqli_fetch_array($sett_akun);

                      echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";                          
                                                        
                      $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
                      while($data = mysqli_fetch_array($query))
                      {
                            
                      echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                      }


                //Untuk Memutuskan Koneksi Ke Database
                mysqli_close($db); 
                            
                    ?>
                            
                </select>
              </div> 
            </div>

            <div class="row">
              <div class="col-sm-6">
                <label style="font-size:15px"> <b> Total Akhir </b></label><br>
                <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
                <b><input type="text" style="height: 20px; width:90%; font-size:20px;" name="total" id="total_pembelian" class="form-control"  placeholder="" readonly="" style="font-size: 20px" ></b>
              </div>
                

              <div class="col-sm-6">
                <label style="font-size:15px">  <b> Pembayaran (F6) </b> </label><br>
                <input type="text" style="height: 20px; width:90%; font-size:20px;" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" placeholder="" required="" style="font-size: 20px"></b>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <label> Kembalian </label><br>
                <b><input style="height:20px;font-size:15px" type="text" name="sisa_pembayaran" id="sisa_pembayaran_pembelian" class="form-control" placeholder=" " readonly="" style="font-size: 20px"></b>
              </div>

              <div class="col-sm-6">
                <label> Kredit </label><br>
              <b><input style="height:20px;font-size:15px" type="text" name="kredit" id="kredit" class="form-control" placeholder="" readonly=""  style="font-size: 20px" ></b>
              </div>
            </div>
             

          </div> <!-- END CARD CARD_BLOCK --> 
                              
                
<!-- HIDDEN HIDDEN HIDDEN HIDDEN -->
                <b><input type="hidden" name="zxzx" id="zxzx" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>
                <b><input type="hidden" name="jumlah_bayar_lama" id="jumlah_bayar_lama" value="<?php echo $jumlah_bayar_lama; ?>" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly=""></b>
                <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="">
                <!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
                <input type="hidden" name="no_faktur" class="form-control" value="<?php echo $nomor_faktur; ?>" required="" >                
                <input type="hidden" name="suplier" id="supplier" class="form-control" required="" >
                <input type="hidden" name="ppn_input" id="ppn_input" value="<?php echo $ppn; ?>" class="form-control" placeholder="ppn input">  
<!-- HIDDEN HIDDEN HIDDEN HIDDEN -->


                <!--membuat tombol submit bayar & Hutang-->
                <button type="submit" id="pembayaran" class="btn btn-info" data-faktur='<?php echo $nomor_faktur ?>'>Bayar (F8)</button>

                <a href="pembelian.php" id="transaksi_baru" class="btn btn-primary" style="display: none">Transaksi Baru (F5)</a>


                <button type="submit" id="hutang" class="btn btn-warning" data-faktur='<?php echo $nomor_faktur ?>'>Hutang (F9)</button>
                
                <!--membuaat link pada tombol batal-->
                <a href='batal_pembelian.php?no_faktur=<?php echo $nomor_faktur;?>' id='batal' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Batal (F10) </a>

                <a href="cetak_coba_tunai.php" id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai (Ctrl + U)</a>

                <a href="cetak_coba_hutang.php" id="cetak_hutang" style="display: none;" class="btn btn-success" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Hutang (Ctrl + H)</a>


        <br>
      <div class="alert alert-success" id="alert_berhasil" style="display:none">
      <strong>Success!</strong> Pembayaran Berhasil
      </div>
            </div>



      </form><!--tag penutup form-->
      <span id="demo"> </span>


      
    </div><!-- DISINI Penutup COL_SM_4-->
</div>



</div><!-- end of container -->


<script type="text/javascript">
  $(document).ready(function(){
              $('#table_tbs_pembelian').DataTable().destroy();

                          var dataTable = $('#table_tbs_pembelian').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"datatable_edit_tbs_pembelian.php", // json datasource
                              type: "post",  // method  , by default get
                              "data": function ( d ) {
                                   d.no_faktur = $("#nomorfaktur").val();
                                   // d.custom = $('#myInput').val();
                                   // etc
                                },
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#table_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[9]+'');         

                            }
                          });
  });
</script>


<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("over_stok").value = $(this).attr('over_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("id_produk").value = $(this).attr('id-barang');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');

 $("#kode_barang").trigger("chosen:updated");
  
  $('#myModal').modal('hide');
  });
   
   
  </script> <!--tag penutup perintah java script-->


<script type="text/javascript">
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_pembelian.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#span_modal_alert").html(data); 

});

  });
</script>


   <script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
    
  
  $(document).on('click', '#submit_produk', function (e) {

    var no_faktur = $("#nomorfaktur").val();
    var suplier = $("#nama_suplier").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = $("#harga_produk").val();
    var harga_baru = $("#harga_baru").val().replace('.','');
    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var tax = $("#tax1").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_produk").val();
    var kode_gudang = $("#kode_gudang").val();
    var ppn = $("#ppn").val();
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));


  
        if (potongan == '') 
          {
             potongan = 0.00;
          }

        else
          {
            var pos = potongan.search("%");
           if (pos > 0) 
            {
               var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
               potongan_persen = potongan_persen.replace("%","");
               potongan = parseFloat(jumlah_barang,2) * parseFloat(harga_baru.replace(',','.'),2) * parseFloat(potongan_persen.replace(',','.'),2) / 100 ;
            };
          }


        if (potongan == 0.00) 
          {
            var subtotal = parseFloat(jumlah_barang,2) *  parseFloat(harga_baru.replace(',','.'),2);
          }
        else
          {
            var subtotal = parseFloat(jumlah_barang,2) *  parseFloat(harga_baru.replace(',','.'),2) - parseFloat(potongan,2);
          }

    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
    if (tax_faktur == '') {
      tax_faktur = 0.00;
    };

    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

    if (total == '') 
    {
      var total_akhir = 0.00;

    }
    else{
      var total_akhir = parseFloat(total.replace(',','.'),2) + parseFloat(subtotal,2);
    }

        if (pot_fakt_per == '') {
          pot_fakt_per = 0;
        }

        else
          {
            var pos1 = pot_fakt_per.search("%");
           if (pos1 > 0) 
            {
               var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
               pot_fakt_per = pot_fakt_per.replace("%","");
            };
          }

      potongaaan = parseFloat(total_akhir) * parseFloat(pot_fakt_per) / 100;

      var hitung_tax = parseFloat(total_akhir,2) - parseFloat(potongaaan,2);

      if (tax_faktur != 0) {
        var tax_bener = parseFloat(hitung_tax,2) * parseFloat(tax_faktur,2) / 100;
      }
      else
      {
        var tax_bener = 0;  
      }

      
     var total_bener = parseFloat(hitung_tax,2) + parseFloat(tax_bener,2);


  if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (suplier == ''){
  alert("Suplier Harus Dipilih");
  }
  else if (kode_barang == ''){
  alert("Kode Barang Harus Diisi");
  }
    else if (kode_gudang == ''){
  alert("Kode Gudang Harus Diisi");
  }
    else if (ppn == ''){
  alert("PPN Harus Diisi");
  }    else if (tax > 100){
  alert("Tax Tidak Boleh Lebih Dari 100%");
  }


  
  else {

       if (harga != harga_baru) {

             var pesan_alert = confirm("Apakah Anda Ingin Merubah Harga '"+nama_barang+"', Pada Master Data Produk ?");
             if (pesan_alert == true) {

              var status_update = 1;

        
                  $("#total_pembelian").val(total_bener.format(2, 3, '.', ','));
                $("#total_pembelian1").val(total_akhir.format(2, 3, '.', ','));
                $("#potongan_pembelian").val(potongaaan.format(2, 3, '.', ','));
                $("#tax_rp").val(tax_bener.format(2, 3, '.', ','));
 
            $.post("proses_tbs_edit_pembelian.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan},function(data){
      
                          var table_tbs_pembelian = $('#table_tbs_pembelian').DataTable();
                  table_tbs_pembelian.draw();

              $("#kode_barang").val('').trigger("chosen:updated");
              $("#kode_barang").trigger('chosen:open');
              $("#ppn").attr("disabled", true);
              $("#no_faktur_suplier").attr("disabled", true);
              $("#nama_barang").val('');
              $("#kode_barang").val('');
              $("#jumlah_barang").val('');
              $("#potongan1").val('');
              $("#tax1").val('');  
              $("#harga_produk").val('');
              $("#harga_baru").val(''); 

              });

            }
            else{

              var status_update = 0;

                  $("#total_pembelian").val(total_bener.format(2, 3, '.', ','));
                $("#total_pembelian1").val(total_akhir.format(2, 3, '.', ','));
                $("#potongan_pembelian").val(potongaaan.format(2, 3, '.', ','));
                $("#tax_rp").val(tax_bener.format(2, 3, '.', ','));

                $.post("proses_tbs_edit_pembelian.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan},function(data){
      
                            var table_tbs_pembelian = $('#table_tbs_pembelian').DataTable();
                  table_tbs_pembelian.draw();

                $("#kode_barang").val('').trigger("chosen:updated");
                $("#kode_barang").trigger('chosen:open');
                $("#ppn").attr("disabled", true);
                $("#no_faktur_suplier").attr("disabled", true);
                $("#nama_barang").val('');
                $("#kode_barang").val('');
                $("#jumlah_barang").val('');
                $("#potongan1").val('');
                $("#tax1").val('');  
                $("#harga_produk").val('');
                $("#harga_baru").val(''); 

               });
              }

    }
    else{
              var status_update = 0;
                

                $("#total_pembelian").val(total_bener.format(2, 3, '.', ','));
                $("#total_pembelian1").val(total_akhir.format(2, 3, '.', ','));
                $("#potongan_pembelian").val(potongaaan.format(2, 3, '.', ','));
                $("#tax_rp").val(tax_bener.format(2, 3, '.', ','));


                 $.post("proses_tbs_edit_pembelian.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan},function(data){
      
                              var table_tbs_pembelian = $('#table_tbs_pembelian').DataTable();
                  table_tbs_pembelian.draw();

                  $("#kode_barang").val('').trigger("chosen:updated");
                  $("#kode_barang").trigger('chosen:open');
                  $("#ppn").attr("disabled", true);
                  $("#no_faktur_suplier").attr("disabled", true);
                  $("#nama_barang").val('');
                  $("#kode_barang").val('');
                  $("#jumlah_barang").val('');
                  $("#potongan1").val('');
                  $("#tax1").val('');  
                  $("#harga_produk").val('');
                  $("#harga_baru").val(''); 

                });

    }
}

  });
              
     $("#formtambahproduk").submit(function(){
     return false;
     });


</script>


<script type="text/javascript">
       $("#cari_produk_pembelian").click(function() {

     //menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
     /* Act on the event */

     var suplier = $("#nama_suplier").val();
     
     $.post("modal_beli_coba.php",{suplier:suplier},function(data) {
     
     $(".modal_baru").html(data);
     $("#cetak_tunai").hide('');
     $("#cetak_hutang").hide('');
     
     
     });
     
     });


</script>



 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

       var no_faktur = $("#nomorfaktur").val();
       var no_faktur_suplier = $("#no_faktur_suplier").val();
       var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_pembelian").val()))));
       var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
       var suplier1 = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
       var total_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
       var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
       var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
       var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
       var tax1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
       var cara_bayar = $("#carabayar1").val();
       var jumlah_barang = $("#jumlah_barang").val();
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
       var tanggal = $("#tanggal").val();
       var jumlah_bayar_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_bayar_lama").val()))));
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();


       var sisa = parseFloat($("#pembayaran_pembelian").val(),2) - parseFloat($("#total_pembelian").val(),2);
       var sisa_kredit = parseFloat($("#total_pembelian").val(),2) - parseFloat($("#pembayaran_pembelian").val(),2);


       if (jumlah_bayar_lama == "") {
        jumlah_bayar_lama = 0.00;
       }

       var jumlah_kredit_baru = parseFloat(kredit.replace(',','.'),10) - parseFloat(jumlah_bayar_lama.replace(',','.'),10);
       var x = parseFloat(jumlah_bayar_lama.replace(',','.'),10) + parseFloat(pembayaran.replace(',','.'),10);
       $("#zxzx").val(x);


 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");
  $("#pembayaran_pembelian").val('');
  $("#pembayaran_pembelian").focus();
 }


 else if (suplier1 == "") 
 {

alert("Suplier Harus Di Isi");

 }
else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }

 else if (sisa < 0) 
 {

alert("Silakan Bayar Hutang");

 }

   else if ((total_1 ==  0 && total ==  0 && potongan_persen != 100 && pembayaran == 0) || (total_1 ==  "" && total == "" && potongan_persen != 100 && pembayaran == ""))
 {

alert(" Anda Belum Melakukan Pembelian ");

 }

 else if (jumlah_bayar_lama == 0)
 {

       $("#pembayaran").hide();
       $("#batal").hide();
       $("#hutang").hide();
       $("#transaksi_baru").show(); 
       
       $.post("proses_bayar_edit_pembelian.php",{total_1:total_1,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier1,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,tax1:tax1,cara_bayar:cara_bayar,jumlah_barang:jumlah_barang,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,tanggal:tanggal,total_1:total_1,jumlah_kredit_baru:jumlah_kredit_baru,x:x,ppn:ppn,ppn_input:ppn_input,no_faktur_suplier:no_faktur_suplier},function(info) {
       
       
       $("#alert_berhasil").show();
       $("#result").html();
       $("#cetak_tunai").show();
        $("#result").hide();

       
       });
 }

else
 {


      if (x > total)
      {
      
      var no_faktur = $(this).attr("data-faktur");
      
      $.post('alert_hutang_pembelian.php',{no_faktur:no_faktur},function(data){
      
      
      $("#modal_alert").modal('show');
      $("#span_modal_alert").html(data);
      
      });
      
      }

}


 $("form").submit(function(){
    return false;
});

    

  });
            


            
  
        
  </script>

   <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#hutang").click(function(){
       
       var no_faktur = $("#nomorfaktur").val();
       var no_faktur_suplier = $("#no_faktur_suplier").val();
       var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_pembelian").val()))));
       var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
       var suplier = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
       var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
       var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
       var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
       var cara_bayar = $("#carabayar1").val();
       var jumlah_barang = $("#jumlah_barang").val();
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
       var tanggal = $("#tanggal").val();
       var total_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
       var jumlah_bayar_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_bayar_lama").val()))));
       var tax1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();
       
       var sisa = parseFloat($("#pembayaran_pembelian").val(),2) - parseFloat($("#total_pembelian").val(),2);
       var sisa_kredit = parseFloat($("#total_pembelian").val(),2) - parseFloat($("#pembayaran_pembelian").val(),2);


       var jumlah_kredit_baru = parseFloat(kredit.replace(',','.'),10) - parseFloat(jumlah_bayar_lama.replace(',','.'),10);
       var x = parseFloat(jumlah_bayar_lama.replace(',','.'),10) + parseFloat(pembayaran.replace(',','.'),10);
       $("#zxzx").val(x);


      if (kredit == "" )
      {

        alert ("Jumlah Pembayaran Tidak Mencukupi");
      }

       else if (suplier == "") 
       {
       
       alert("Suplier Harus Di Isi");
       
       }
       else if (tanggal_jt == "")
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");
      $("#tanggal_jt").focus();
       }

  else if ((total_1 ==  0 && total ==  0 && potongan_persen != 100 && pembayaran == 0) || (total_1 ==  "" && total == "" &&potongan_persen != 100 && pembayaran == ""))
 {

alert(" Anda Belum Melakukan Pembelian ");

 }
       
 else if (jumlah_bayar_lama == 0 || x <= total)
 {


          $("#pembayaran").hide();
          $("#batal").hide();
          $("#hutang").hide();
          $("#transaksi_baru").show();
       
       $.post("proses_bayar_edit_pembelian.php",{total_1:total_1,tax1:tax1,tanggal:tanggal,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,jumlah_barang:jumlah_barang,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_1:total_1,jumlah_kredit_baru:jumlah_kredit_baru,x:x,ppn:ppn,ppn_input:ppn_input,no_faktur_suplier:no_faktur_suplier},function(info) {

       
       $("#alert_berhasil").show();
        $("#result").hide();
       $("#result").html(info);
       $("#cetak_hutang").show();
       $("#sisa_pembayaran_pembelian").val('');
       $("#tanggal_jt").val('');
       
       
       
       });
        // #result didapat dari tag span id=result
  }

else
 {


      if (x > total)
      {
      
      var no_faktur = $(this).attr("data-faktur");
      
      $.post('alert_hutang_pembelian.php',{no_faktur:no_faktur},function(data){
      
      
      $("#modal_alert").modal('show');
      $("#span_modal_alert").html(data);
      
      });
      
      }

}
      


 $("form").submit(function(){
       return false;
       });

  });    
  </script>

<script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_pembelian").click(function(){
  var no_faktur = $("#nomorfaktur").val();

  $.post("cek_tbs_coba.php",{no_faktur: "<?php echo $nomor_faktur; ?>"},function(data){
        if (data == "1") {


             $("#ppn").attr("disabled", true);

        }
        else{

             $("#ppn").attr("disabled", false);
        }
    });

});
});
</script>



<script type="text/javascript">
// untuk memunculkan data cek total pembelian
$(document).ready(function(){

var no_faktur = $("#nomorfaktur").val();
  
  var potongan_pembelian = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
   
   var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
        


$.post("cek_total_coba.php",{no_faktur:no_faktur},function(data){
      $("#total_pembelian1").val(data);

      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));

          if (tax == 0) {
            var t_tax =  0; 
          }
          else
          {
            var t_tax =  parseFloat(data,2) * parseFloat(tax,2) / 100; 
          }
            
            if (data == '') {
              data = 0;
            }

          var total_akhirr = (parseFloat(subtotal.replace(',','.'),2) - parseFloat(potongan_pembelian.replace(',','.'),2)) + parseFloat(t_tax,2);

        


        $("#total_pembelian").val(total_akhirr.format(2, 3, '.', ','));

    });

});


</script>


<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
    
 $.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });

    });//penutup click(function()
  });//penutup ready(function()
</script>

<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").keyup(function(){
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
      if (pembayaran == "") {
        var pembayaran = "0,00";
      }
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
       var sisa = parseFloat(pembayaran.replace(',','.')) - parseFloat(total.replace(',','.'));
        var sisa_kredit = parseFloat(total.replace(',','.')) - parseFloat(pembayaran.replace(',','.')); 
       
        

        if (sisa < 0 )
        {
        $("#kredit").val(sisa_kredit.format(2, 3, '.', ','));
        $("#sisa_pembayaran_pembelian").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        
        $("#sisa_pembayaran_pembelian").val(sisa.format(2, 3, '.', ','));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        }

      
    });


  });
</script>



<script>
// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){


$("#pembayaran_pembelian").keyup(function(){
      var jumlah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
      var jumlah_kas = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah1").val()))));
      var sisa = parseFloat(jumlah_kas,2) - parseFloat(jumlah,2);
      var carabayar1 = $("#carabayar1").val();


       if (sisa < 0 || carabayar1 == "") 

      {
          $("#submit").hide();
          $("#kredit").val('0');
          $("#pembayaran_pembelian").val('');
          $("#potongan_pembelian").val('');
          $("#potongan_persen").val('');
          $("#tax").val('');

        alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");

      }
      else {
        $("#submit").show();
      }
});

  });
</script>

<!-- AUTOCOMPLETE 
<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>




<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").keyup(function(){

          var kode_barang = $("#kode_barang").val();
    
          var no_faktur = $("#nomorfaktur").val();
          
          $.post("cek_barang_pembelian.php",
          {
          kode_barang: kode_barang
          },
          function(data){
          $("#jumlahbarang").val(data);
          });
          
          $.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)


      $.getJSON('lihat_nama_barang_pembelian.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#over_stok').val('');
        $('#harga_produk').val('');
        $('#satuan_produk').val('');
        $('#harga_baru').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#over_stok').val(json.over_stok);
        $('#harga_produk').val(json.harga_beli);
        $('#satuan_produk').val(json.satuan);
        $('#harga_baru').val(json.harga_beli);
      }
                                              
        });
        
        });
        });

      
      
</script> -->


<script>

//untuk menampilkan sisa penjualan secara otomatis
  $(document).ready(function(){

  $("#jumlah_barang").keyup(function(){

    var jumlah_barang = $("#jumlah_barang").val();
    if (jumlah_barang == "") {
      jumlah_barang = 0;
    }
    var jumlahbarang =$("#jumlahbarang").val();
     var over_stok = $("#over_stok").val();
    var stok = parseInt(jumlah_barang) + parseInt(jumlahbarang);


if( over_stok < stok ){

      alert ("Persediaan Barang Ini Sudah Melebihi Batas Stok!");
      
    }


  });
});

</script>


<!--membuat menampilkan no faktur dan suplier pada tax-->
<script>

$(document).ready(function(){
    $("#nama_suplier").change(function(){
      var suplier = $("#nama_suplier").val();
      $("#supplier").val(suplier);
        
    });
});
</script>

<script>

// BELUM KELAR !!!!!!
$(document).ready(function(){
    $("#carabayar1").change(function(){
      var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });


            
            var suplier = $("#nama_suplier").val();
            
            if (suplier != ""){
            $("#nama_suplier").attr("disabled", true);
            }
            
            
            });
        
    });
</script>

<script type="text/javascript">
        $(document).ready(function(){    
        $("#potongan_persen").keyup(function(){

        var potongan_persen = $("#potongan_persen").val();
        if (potongan_persen == "") {
        potongan_persen = 0;
        }

        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total_pembelian1").val()))));
        var potongan_pembelian = ((parseFloat(total.replace(',','.')) * parseFloat(potongan_persen)) / 100);

        if (potongan_pembelian != ""){
             $("#potongan_pembelian").attr("readonly", true);
             }

             else{
              $("#potongan_pembelian").attr("readonly", false);
             }

        var tax = $("#tax").val();
        if (tax == "") {
        tax = 0;
      }
       var ambil_semula = parseFloat(total.replace(',','.'),2);

        var sisa_potongan = parseFloat(total.replace(',','.'),2) - parseFloat(potongan_pembelian,2);


    var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
    if (pembayaran == "") {
      var pembayaran = "0,00";
    }
       var sisa = parseFloat(pembayaran.replace(',','.')) - parseFloat(sisa_potongan);
        var sisa_kredit = parseFloat(sisa_potongan) - parseFloat(pembayaran.replace(',','.')); 
       
        



             /*var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);*/

        
        if (potongan_persen > 100) 
        {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
          $("#potongan_persen").val('');
          $("#potongan_pembelian").val('');
          $("#total_pembelian").val(ambil_semula.format(2, 3, '.', ','));

        }
        else{
          $("#total_pembelian").val(sisa_potongan.format(2, 3, '.', ','));
          $("#potongan_pembelian").val(potongan_pembelian.format(2, 3, '.', ','));

         if (sisa < 0 )
        {
        $("#kredit").val(sisa_kredit.format(2, 3, '.', ','));
        $("#sisa_pembayaran_pembelian").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        
        $("#sisa_pembayaran_pembelian").val(sisa.format(2, 3, '.', ','));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        }

        }
  });
//END  $("#potongan_persen").keyup(function(){

        $("#potongan_pembelian").keyup(function(){

        var potongan_pembelian =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_pembelian").val() ))));

        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
        var tax = $("#tax").val();
        if (tax == "") {
        tax = 0;
         }
        var potongan_persen = ((parseFloat(potongan_pembelian,2) / parseFloat(total.replace(',','.'),2)) * 100);




     
if(potongan_persen > 100.00)
      {
        alert("Potongan Tidak Dapat Lebih dari 100% !!");
         $("#potongan_persen").val('');
        $("#potongan_pembelian").val('');
      
         var tax = $("#tax").val();

        if (tax == "")
        {
          tax = 0;
        }
        var t_tax = ((parseFloat(total.replace(',','.')) * parseFloat(tax.replace(',','.'))) / 100);
      
        var hasil_akhir = parseFloat(total.replace(',','.'));

        $("#total1").val(hasil_akhir.format(2, 3, '.', ','));

      }
      else
      {

         $("#potongan_persen").val(potongan_persen.format(2, 3, '.', ','));

 if (potongan_pembelian == 0,00 || potongan_pembelian == "" )
      {
        var sisa_potongan = parseFloat(total.replace(',','.'));
       }
       else
      {
        var sisa_potongan = parseFloat(total.replace(',','.')) - parseFloat(potongan_pembelian.replace(',','.'));
      } 
             if (tax == 0)
              {
               var t_tax = 0;
              }
              
              var t_tax = ((parseFloat(sisa_potongan) * parseFloat(tax)) / 100);


             var hasil_akhir = parseFloat(sisa_potongan) /*+ parseFloat(biaya_adm.replace(',','.')); */ + parseFloat(t_tax,10);
        

       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
       var sisa = parseFloat(pembayaran.replace(',','.')) - parseFloat(hasil_akhir);
        var sisa_kredit = parseFloat(hasil_akhir) - parseFloat(pembayaran.replace(',','.')); 


        $("#total_pembelian").val(hasil_akhir.format(2, 3, '.', ','));

        if (sisa < 0 )
        {
        $("#kredit").val(sisa_kredit.format(2, 3, '.', ','));
        $("#sisa_pembayaran_pembelian").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        
        $("#sisa_pembayaran_pembelian").val(sisa.format(2, 3, '.', ','));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        }


     }

});
// END $("#potongan_pembelian").keyup(function(){        
       

     $("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total_pembelian").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - Math.round(potongan);

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');
                 $("#total_pembelian").val(tandaPemisahTitik(total));

              }
              else
              {
                $("#total_pembelian").val(Math.round(total_akhir));
              }
        

       $("#tax_rp").val(Math.round(t_tax))


        });
        });
        
        </script>




      <script type="text/javascript">
        
        $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});

      </script>


      <script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});

</script>



<script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data
$(document).on('click', '.btn-hapus-tbs', function (e) {
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));

      if (total == '') 
        {
          total = 0;
        };
      var total_akhir1 = parseFloat(total.replace(',','.'),2) - parseFloat(subtotal_tbs.replace(',','.'),2);

       var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

    if (tax_faktur == '') {
      tax_faktur = 0;
    };

  var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
   if (pot_fakt_per == "" || pot_fakt_per == 0,00 || pot_fakt_rp == 0  ) {
        pot_fakt_per = 0.00;
      }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
 if (pot_fakt_rp == "" || pot_fakt_rp == 0,00 || pot_fakt_rp == 0 ) {
        pot_fakt_rp = 0.00;
      }


   if (pot_fakt_per == 0.00) {

      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseFloat(potongaaan,2) / parseFloat(total_akhir1,2) * 100;
      var potongaaan = pot_fakt_rp;
      var hitung_tax = parseFloat(total_akhir1,2) - parseFloat(pot_fakt_rp,2);

      var tax_bener = parseFloat(hitung_tax) * parseFloat(tax_faktur) / 100;

      if ( pot_fakt_rp == 0.00 )
      {
        var total_akhir = parseFloat(total_akhir1,2)+ parseFloat(tax_bener);
      }
      else
      {
        var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(pot_fakt_rp.replace(',','.'),2) + parseFloat(tax_bener);
      }

    }
    else if(pot_fakt_rp == 0.00)
    {     
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
          potongan_persen = potongan_persen.replace("%","");

      potongaaan = parseFloat(total_akhir1,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;
      
      var potongaaan_per = pot_fakt_per;
      var hitung_tax = parseFloat(total_akhir1,2) - parseFloat(potongaaan,2);

      var tax_bener = parseFloat(hitung_tax) * parseFloat(tax_faktur) / 100;
      if (pot_fakt_rp == 0.00 )
      {
     var total_akhir = parseFloat(total_akhir1,2) + parseFloat(tax_bener);
      }
      else
      {
     var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(potongaaan,2) + parseFloat(Math.round(tax_bener));
      }
    }
     else if(pot_fakt_rp != 0.00 && pot_fakt_rp != 0.00)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = parseFloat(total_akhir1,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;
      
      var potongaaan_per = pot_fakt_per;
      var hitung_tax = parseFloat(total_akhir1,2) - parseFloat(potongaaan,2);

     var tax_bener = parseFloat(hitung_tax) * parseFloat(tax_faktur) / 100;
      if ( pot_fakt_rp == 0 )
      {
        var total_akhir = parseFloat(total_akhir1,2) + parseFloat(tax_bener);
      }
      else
      {
        var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(potongaaan,2) + parseFloat(Math.round(tax_bener));
      }
    
    }
      
      $("#total_pembelian").val(total_akhir.format(2, 3, '.', ','));
      $("#total_pembelian1").val(total_akhir1.format(2, 3, '.', ','));
      $("#tax_rp").val(tax_bener.format(2, 3, '.', ','));
      $("#potongan_pembelian").val(potongaaan.format(2, 3, '.', ','));

    $.post("hapus_coba.php",{id:id},function(data){
    if (data != '') {

      $(".tr-id-"+id+"").remove();
    
    }

    });
    
    
    });

//end fungsi hapus data

$('form').submit(function(){    
     return false;
    });
        

  });
     
     function tutupmodal() {
     $(".modal").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }

</script>



 <script type="text/javascript">
                                 $(document).on('dblclick', '.edit-jumlah', function (e) {

                                      var id = $(this).attr("data-id");
                   
                                     
                                        $("#text-jumlah-"+id+"").hide();                                        
                                        $("#input-jumlah-"+id+"").attr("type", "text");


                                 });


                                     $(document).on('blur','.input_jumlah',function(e){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    if (jumlah_baru == '') {
                                      jumlah_baru = 0;
                                    }
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
                                    
                                    var tax_fak = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                                      if (tax_fak == '') {
                                             tax_fak = 0;
                                        };

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                              
                                    var ppn = $("#ppn").val();



                                    if (ppn == 'Exclude') {

                                    var subtotal1 = parseFloat(harga.replace(',','.'),2) * parseFloat(jumlah_baru.replace(',','.'),2) - parseFloat(potongan.replace(',','.'),2);

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));

                                     var subtotal_ex = parseFloat(subtotal_lama.replace(',','.'),2) - parseFloat(tax.replace(',','.'),2);

                                     var cari_tax = (parseFloat(tax.replace(',','.'),2) * 100) / parseFloat(subtotal_ex,2);

                                    var cari_tax1 = parseFloat(subtotal1,2) * parseFloat(cari_tax,2) / 100;

                                    var jumlah_tax = cari_tax1;

                                    var subtotal = parseFloat(subtotal1,2) + parseFloat(jumlah_tax,2);

                                    
                                    var subtotal_penjualan = parseFloat(subtotal_penjualan,10) - parseFloat(subtotal_lama,10) + subtotal;
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;
                                  }
                                  else{

                                  var subtotal1 = parseFloat(harga.replace(',','.'),2) * parseFloat(jumlah_baru.replace(',','.'),2) - parseFloat(potongan.replace(',','.'),2);

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));

                                      var cari_tax = parseFloat(subtotal_lama.replace(',','.'),2) - parseFloat(tax.replace(',','.'),2);
                                    var cari_tax1 = parseFloat(subtotal_lama.replace(',','.'),2) / parseFloat(cari_tax,2);

                                    var tax_ex = cari_tax1;

                                    var subtotal = subtotal1;
                                    var tax_ex1 = parseFloat(subtotal,2) / parseFloat(tax_ex,2);
                                    var tax_ex2 = parseFloat(subtotal,2) - parseFloat(tax_ex1,2);
                                    var jumlah_tax = tax_ex2;
                                    

                                    var subtotal_penjualan = parseFloat(subtotal_penjualan,2) - parseFloat(subtotal_lama.replace(',','.'),2) + parseFloat(subtotal,2);

                                    }
                                    ////////////////////////PPN
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));

                                    /*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
                                    if(biaya_adm == '' || biaya_adm == 0,00)
                                    {
                                      biaya_adm = 0,00;
                                    }*/
                                   

                                subtotal_penjualan = parseFloat(subtotal_penjualan.replace(',','.'),2) - parseFloat(subtotal_lama.replace(',','.'),2) + parseFloat(subtotal,2);



                                     var potongan_persen = $("#potongan_persen").val();
                                      if (potongan_persen == '' || potongan_persen == 0,00)
                                    {
                                      potongan_persen = 0;
                                    }

                                    if (potongan_persen == 0)
                                    {
                                      potongaaan = 0,00;
                                    }
                                    else
                                    {
                                      potongaaan = parseFloat(subtotal_penjualan,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;
                                    }

                                    $("#potongan_pembelian").val(potongaaan.format(2, 3, '.', ','));
                                    
                                  
                                    var sub_total = parseFloat(subtotal_penjualan,2) - parseFloat(potongaaan,2);

                                    if (tax_fak == 0)
                                    {
                                      var tax_fak = 0.00;
                                    }
                                    else
                                    {
                                    var tax_fak = parseFloat(tax_fak.replace(',','.'),2) * parseFloat(sub_total,2) / 100;
                                    }
                                   

                                    if (potongaaan == 0,00 )
                                    {
                                     var sub_akhir = (parseFloat(subtotal_penjualan,2));
                                    }
                                    else
                                    {
                                    var sub_akhir = parseFloat(subtotal_penjualan,2)  - parseFloat(potongaaan,2);
                                    }

  
                                    var jumlah_kirim = jumlah_baru.replace(',','.');
                                    var harga_kirim = harga.replace(',','.');




                            if (jumlah_baru == 0 || jumlah_baru == "") {
                              alert("Jumlah barang tidak boleh nol atau kosong");
                                    
                                     $("#input-jumlah-"+id+"").val(jumlah_lama.format(2, 3, '.', ','));
                                    $("#text-jumlah-"+id+"").text(jumlah_lama.format(2, 3, '.', ','));
                                    $("#text-jumlah-"+id+"").show();
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                                            
                            }
                            else
                            {

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_kirim);
                                    $("#text-subtotal-"+id+"").text(subtotal.format(2, 3, '.', ','));
                                    $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal.format(2, 3, '.', ','));
                                    if (jumlah_tax == "") {
                                       $("#text-tax-"+id+"").text("0,00");
                                    }
                                    else{
                                      $("#text-tax-"+id+"").text(jumlah_tax.format(2, 3, '.', ','));
                                    }

                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total_pembelian1").val(subtotal_penjualan.format(2, 3, '.', ','));   
                                    $("#total_pembelian").val(sub_akhir.format(2, 3, '.', ','));      
                                    $("#potongan_pembelian").val(potongaaan.format(2, 3, '.', ','));

                                    if(tax_fak == 0)
                                    {
                                      $("#tax_rp").val(tax_fak); 
                                    }
                                    else{
                                      $("#tax_rp").val(tax_fak.format(2, 3, '.', ','));
                                    }
                                      
                                    
                                     $.post("update_pesanan_barang_beli.php",{harga:harga,jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang},function(info){

                                    

                                    });
                            }



                                    $("#kode_barang").focus();

                                 });

                             </script>




                              <script type="text/javascript">
                         
                                  $(document).on('dblclick','.edit-harga',function(){

                                      var id = $(this).attr("data-id");

                   
                                     
                                        $("#text-harga-"+id+"").hide();                                        
                                        $("#input-harga-"+id+"").attr("type", "text");



                                 });

                                     $(document).on('blur','.input_harga',function(){

                                    var id = $(this).attr("data-id");
                                    var harga_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var nama_barang = $(this).attr("data-nama");
                                    var jumlah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-jumlah")))));
                                    var harga_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-harga-"+id+"").text()))));
                                    var no_faktur = $("#nomorfaktur").val();

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
                                    
                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                    
                                    var subtotal = parseFloat(jumlah.replace(',','.'),2) * parseFloat(harga_baru.replace(',','.'),2) - parseFloat(potongan.replace(',','.'),2);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
                                    
                                    subtotal_penjualan = parseFloat(subtotal_penjualan.replace(',','.'),2) - parseFloat(subtotal_lama.replace(',','.'),2) + parseFloat(subtotal);

                                          var potongan_pembelian = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));

                                          var tax = $("#tax").val();
                                          var t_tax =  parseFloat(subtotal_penjualan,2) * parseFloat(tax.replace(',','.'),2) / 100; 

                                          var total_akhirr = parseFloat(subtotal_penjualan,2) - parseFloat(potongan_pembelian.replace(',','.'),2) + parseFloat(t_tax);

                                    
                                    var tax_tbs = parseFloat(tax.replace(',','.'),2) / parseFloat(subtotal_lama.replace(',','.'),2) * 100;
                                    var jumlah_tax = parseFloat(tax_tbs,2) * parseFloat(subtotal,2) / 100;

                                    var harga_edit = harga_baru;

                                    var pesan_alert = confirm("Apakah Anda Yakin Merubah Harga '"+nama_barang+"' Menjadi Rp. '"+harga_edit+"' ?");
                                    if (pesan_alert == true) {


                                      $.post("update_pesanan_barang_harga_beli.php",{jumlah:jumlah,harga_lama:harga_lama,jumlah_tax:jumlah_tax,potongan:potongan,id:id,harga_baru:harga_edit,kode_barang:kode_barang},function(info){

                                      
                                      $("#text-harga-"+id+"").show();
                                      $("#text-harga-"+id+"").text(harga_edit);
                                      $("#text-subtotal-"+id+"").text(subtotal.format(2, 3, '.', ','));
                                      $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal.format(2, 3, '.', ','));


                                      $("#text-tax-"+id+"").text(jumlah_tax.format(2, 3, '.', ','));
                                      $("#input-harga-"+id+"").attr("type", "hidden"); 
                                      $("#input-jumlah-"+id+"").attr("data-harga", harga_edit); 
                                      $("#total_pembelian").val(total_akhirr.format(2, 3, '.', ','));
                                      $("#total_pembelian1").val(subtotal_penjualan.format(2, 3, '.', ','));         

                                      });

                                    }
                                    else {

                                    }
                                  
                                    $("#kode_barang").focus();
                                    $("#pembayaran_pembelian").val("");

                                 });
      </script>

<script type="text/javascript">
    $(document).ready(function(){

var ppn_input = $("#ppn_input").val();

      if (ppn_input == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn_input == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }

    $("#ppn").change(function(){

    var ppn = $("#ppn").val();
    $("#ppn_input").val(ppn);

  if (ppn == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }


  });
  });
</script>


<script>

$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      

      $.getJSON("cek_satuan_konversi.php",{satuan_konversi:satuan_konversi, id_produk:id_produk},function(info){
        
        if (satuan_konversi == prev) {
        

          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else if (info.jumlah_total == 0) {
          alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val('');
          $("#harga_baru").val(harga_lama);

        }

        else{
          $("#harga_produk").val(info.harga_pokok);
          $("#harga_baru").val(info.harga_pokok);
        }

      });
        
    });

});
</script>


<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var harga_beli = $('#opt-produk-'+kode_barang).attr("harga_beli");
    var harga_jual = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_jual2 = $('#opt-produk-'+kode_barang).attr('harga_jual_2');  
    var harga_jual3 = $('#opt-produk-'+kode_barang).attr('harga_jual_3');
    var harga_jual4 = $('#opt-produk-'+kode_barang).attr('harga_jual_4');
    var harga_jual5 = $('#opt-produk-'+kode_barang).attr('harga_jual_5');  
    var harga_jual6 = $('#opt-produk-'+kode_barang).attr('harga_jual_6');
    var harga_jual7 = $('#opt-produk-'+kode_barang).attr('harga_jual_7');
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var status = $('#opt-produk-'+kode_barang).attr("status");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
    var over_stok = $('#opt-produk-'+kode_barang).attr("over_stok");
    var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
    var tipe_barang = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var no_faktur = $("#nomorfaktur").val();

    
    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#over_stok").val(over_stok);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#satuan_konversi").val(satuan);
    $("#ber_stok").val(ber_stok);
    $("#id_produk").val(id_barang);
    $("#harga_produk").val(harga_beli);
    $("#harga_lama").val(harga_beli);
    $("#harga_baru").val(harga_beli);
        


if (ber_stok == 'Barang') {

    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jumlahbarang").val(data);
    });

}


$.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     



  });
  });
  });

      
      
</script>


<script type="text/javascript"> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');

    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_pembelian").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 

    
    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").focus();

    }); 

    
    shortcut.add("f6", function() {
        // Do something

        $("#pembayaran_pembelian").focus();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#pembayaran").click();

    }); 

    
    shortcut.add("f9", function() {
        // Do something

        $("#hutang").click();

    }); 

    
    shortcut.add("f10", function() {
        // Do something



        window.location.href="batal_edit_pembelian.php?session_id=<?php echo $nomor_faktur; ?>";


    }); 

    
    shortcut.add("ctrl+u", function() {
        // Do something


        window.location.href="cetak_pembelian_tunai.php";


    }); 

    
    shortcut.add("ctrl+h", function() {
        // Do something


        window.location.href="cetak_pembelian_hutang.php";


    }); 

   
</script>

<script type="text/javascript">

$(document).ready(function(){
  var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });
});
</script>



<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

