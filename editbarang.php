<?php  include 'session_login.php';
    // memasukan file login, header, navbar, dan db.
    
    include 'header.php';
    include 'navbar.php';
    include 'sanitasi.php';
    include 'db.php';

// mengirim data id dengan metode GET
 $id = $_GET['id'];
 
 // perintah untuk menampilkan data yang ada pada tabel barang berdasarkan id
 $query = $db->query("SELECT s.nama,b.id,b.jenis_barang,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.harga_jual_inap,b.harga_jual_inap2,b.harga_jual_inap3,b.harga_jual_inap4,b.harga_jual_inap5,b.harga_jual_inap6,b.harga_jual_inap7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang, b.status, b.limit_stok, b.over_stok, b.suplier, b.golongan, b.tipe_barang FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.id = '$id'");
 
 // perintah untuk menyimpan data sementara yang ada pada $query
 $dataqu = mysqli_fetch_array($query);

 ?>



<!-- membuat form dengan metode POST -->
<form enctype="multipart/form-data" action="proseseditbarang.php" method="post">
<div class="container">

<div class="card card-block">

					<!-- membuat agar tampilan form berada dalam satu group-->
					<div class="form-group">
							<label>Nama Barang </label><br>
							<input type="text" style="height: 15px" name="nama_barang" value="<?php echo $dataqu['nama_barang']; ?>" class="form-control" autocomplete="off" required="" >
					</div>


					<div class="form-group">
                            <label> Golongan Produk </label>
                            <br>
                            <select type="text" name="golongan_produk" class="form-control" required="">
                            <option value="<?php echo $dataqu['berkaitan_dgn_stok']; ?>"><?php echo $dataqu['berkaitan_dgn_stok']; ?></option>
                            <option> Barang </option>
                            <option> Jasa </option>
                            </select>
                     </div>

					<div class="form-group">
                            <label> Tipe Produk </label>
                            <br>
                            <select type="text" id="tipe_produk" name="tipe" class="form-control" required="">
                            <option value="<?php echo $dataqu['tipe_barang']; ?>"> <?php echo $dataqu['tipe_barang']; ?></option>
                            <option value="Barang"> Barang </option>
                            <option value="Jasa"> Jasa </option>
                            <option value="Alat"> Alat </option>
                            <option value="BHP"> BHP </option>
                            <option value="Obat Obatan"> Obat-obatan </option>
                            </select>
                            </div>


                            <div class="form-group">
                            <label for="sel1">Jenis Obat</label>
                            <select class="form-control" id="jenis_obat" name="jenis_obat" autocomplete="off">
						<option value="<?php echo $dataqu['jenis_barang']; ?>"> <?php echo $dataqu['jenis_barang']; ?>            
						<?php
                            $query = $db->query("SELECT * FROM jenis");       
                            while ( $data = mysqli_fetch_array($query)) {
                            echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
                            }
                            ?>
                            </select>
                            </div>

                            	<div class="form-group">
							<label> Kategori </label>
							<br>
							<select type="text" name="kategori_obat" id="kategori_obat" class="form-control" required="">
							<option value="<?php echo $dataqu['kategori']; ?>"> <?php echo $dataqu['kategori']; ?> </option>
							<?php 
							
							$ambil_kategori = $db->query("SELECT * FROM kategori");
							
							while($data_kategori = mysqli_fetch_array($ambil_kategori))
							{
							
							echo "<option>".$data_kategori['nama_kategori'] ."</option>";
							
							}
							
							?>
							</select>
							</div>


                            <div class="form-group">
                            <label> Golongan Obat </label>
                            <br>
                            <select type="text" id="golongan_obat" name="golongan_obat" class="form-control">
                            <option value="<?php echo $dataqu['golongan']; ?>"> <?php echo $dataqu['golongan']; ?> </option>
                            <option value="Obat Keras"> Obat Keras </option>
                            <option value="Obat Bebas"> Obat Bebas </option>
                            <option value="Obat Bebas"> Obat Bebas Terbatas </option>
                            <option value="Obat Psikotropika"> Obat Psikotropika </option>
                            <option value="Narkotika"> Narkotika </option>
                            </select>
                            </div>

					<div class="form-group">
					<label> Harga Beli </label><br>
					<input type="text" style="height: 15px" name="harga_beli" id="harga_beli" value="<?php echo tanpaKoma($dataqu['harga_beli']); ?>" class="form-control" autocomplete="off" required="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >
					</div>


                <div class="row row-harga">
                    <div class="col-sm-5">
                        <label>HARGA JUAL RAWAT JALAN</label>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 1" name="harga_jual" id="harga_jual" class="form-control" autocomplete="off" required="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 2" name="harga_jual_2" id="harga_jual2" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual2'] ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 3" name="harga_jual_3" id="harga_jual3" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual3'] ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 4" name="harga_jual_4" id="harga_jual4" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual4'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 5" name="harga_jual_5" id="harga_jual5" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual5'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 6" name="harga_jual_6" id="harga_jual6" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual6'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 7" name="harga_jual_7" id="harga_jual7" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual7'] ?>">
                        </div>      
                    </div>

                    <div class="col-sm-2">
                    <br><br>
                      <center>
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy1">
                            <label for="copy1" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy2">
                            <label for="copy2" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy3">
                            <label for="copy3" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy4">
                            <label for="copy4" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy5">
                            <label for="copy5" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy6">
                            <label for="copy6" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <input type="checkbox" class="checkbox-copy" data-toogle="0" id="copy7">
                            <label for="copy7" style="color: blue"><i class="fa fa-copy"></i></label>
                        </fieldset>
                       </center>
                    </div>

                    <div class="col-sm-5">
                        <label>HARGA JUAL RAWAT INAP</label>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 1" name="harga_jual_inap" id="harga_jual_inap" class="form-control" autocomplete="off" required="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 2" name="harga_jual_inap_2" id="harga_jual_inap2" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap2'] ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 3" name="harga_jual_inap_3" id="harga_jual_inap3" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap3'] ?>">
                        </div>

                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 4" name="harga_jual_inap_4" id="harga_jual_inap4" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap4'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 5" name="harga_jual_inap_5" id="harga_jual_inap5" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap5'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 6" name="harga_jual_inap_6" id="harga_jual_inap6" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap6'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" style="height: 15px" placeholder="Harga Level 7" name="harga_jual_inap_7" id="harga_jual_inap7" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo $dataqu['harga_jual_inap7'] ?>">
                        </div>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                    </div>
                    <div class="col-sm-5" style="padding-left: 67px">
                        <fieldset class="form-group">
                            <input type="checkbox" class="copy-all" data-toogle="0" id="copy-all">
                            <label for="copy-all" style="color: blue"><i class="fa fa-copy"></i> Copy All</label>
                        </fieldset>
                    </div>
                </div>
					
					<div class="form-group">
					<label> Satuan </label><br>
					<select type="text" name="satuan" class="form-control" required="" >
					<option value="<?php echo $dataqu['satuan'] ?>"><?php echo $dataqu['nama'] ?></option>
					
					<?php 
					
					// memasukkakan file db.php
					include 'db.php';
					
					//perintah untuk menampilkan data yang ada pada tabel satuan
					$query1 = $db->query("SELECT * FROM satuan ");
					
					//menyimpan data sementara yang ada pada $query
					while($data1 = mysqli_fetch_array($query1))
					{
					
					//menampilkan data atau isi dari $data
					echo "<option value='".$data1['id'] ."'>".$data1['nama'] ."</option>";
					}
					
					
					?>
					
					</select>
					</div>

							
							<div class="form-group" style="display: none">
							<label> Gudang </label>
							<br>
							<select type="text" name="gudang" class="form-control" >
							<option value="<?php echo $dataqu['gudang']; ?>"> <?php echo $dataqu['gudang']; ?> </option>
							<?php 
							
							$ambil_gudang = $db->query("SELECT nama_gudang FROM gudang");
							
							while($data_gudang = mysqli_fetch_array($ambil_gudang))
							{
							
							echo "<option>".$data_gudang['nama_gudang'] ."</option>";
							
							}
							
							?>
							</select>
							</div>


							
						

							<!-- membuat agar tampilan form berada dalam satu group-->
							<div class="form-group">
							<label> Status </label><br>
							<select type="text" name="status" class="form-control" required="" >
							<option value="<?php echo $dataqu['status']; ?>"><?php echo $dataqu['status']; ?></option>
							<option> Aktif </option>
							<option> Tidak Aktif </option>
							</select>
							</div>
							
						
							
							
					<div class="form-group">
					<label> Suplier </label><br>
					<select type="text" name="suplier" class="form-control" required="" >
					<option value="<?php echo $dataqu['suplier']; ?>"> <?php echo $dataqu['suplier']; ?> </option>
					
					<?php 
					
					//memasukkan file db.php
					include 'db.php';
					
					//perintah untuk menampilakan semua data yang ada pada tabel suplier
					$query2 = $db->query("SELECT * FROM suplier ");
					
					//perintah untuk menyimpan data sementara yang ada pada $query
					while($data2 = mysqli_fetch_array($query2))
					{
					
					//menampilkan data atau isi dari $data
					echo "<option>".$data2['nama'] ."</option>";
					}
					
					//Untuk Memutuskan Koneksi Ke Database
					
					mysqli_close($db); 
					
					?>
					
					</select>
					</div> 

					<div class="form-group">
					<label> Limit Stok </label><br>
					<input type="text" style="height: 15px" name="limit_stok" id="limit_stok" value="<?php echo $dataqu['limit_stok']; ?>" class="form-control" autocomplete="off"  >
					</div>

					<div class="form-group">
					<label> Over Stok </label><br>
					<input type="text" style="height: 15px" name="over_stok" id="over_stok" value="<?php echo $dataqu['over_stok']; ?>" class="form-control" autocomplete="off" >
					</div>


					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<!-- membuat tombol Edit -->
					<button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Simpan</button>

</div>
</div><!-- tag penutup div class=container -->

</form>

<script type="text/javascript">
    $(document).ready(function(){

    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
    	var tipe_produk = $('#tipe_produk').val();

            
             if(tipe_produk == 'Jasa'){
                $("#golongan_obat").attr("disabled", true);
                $("#kategori_obat").attr("disabled", true);
                $("#jenis_obat").attr("disabled", true);
                $("#harga_beli").attr("readonly", true);
                $("#limit_stok").attr("readonly", true);
                $("#over_stok").attr("readonly", true);
            }

            else{

                $("#golongan_obat").attr("disabled", false);
                $("#kategori_obat").attr("disabled", false);
                $("#jenis_obat").attr("disabled", false);
                $("#harga_beli").attr("disabled", false);
                $("#limit_stok").attr("disabled", false);
                $("#over_stok").attr("disabled", false);

            }
            
        });

</script>
<script type="text/javascript">
        $('#tipe_produk').change(function(){
            var tipe_produk = $('#tipe_produk').val();

            
             if(tipe_produk == 'Jasa'){
                $("#golongan_obat").attr("disabled", true);
                $("#kategori_obat").attr("disabled", true);
                $("#jenis_obat").attr("disabled", true);
                $("#harga_beli").attr("disabled", true);
                $("#limit_stok").attr("disabled", true);
                $("#over_stok").attr("disabled", true);
            }

            else{

                $("#golongan_obat").attr("disabled", false);
                $("#kategori_obat").attr("disabled", false);
                $("#jenis_obat").attr("disabled", false);
                $("#harga_beli").attr("disabled", false);
                $("#limit_stok").attr("disabled", false);
                $("#over_stok").attr("disabled", false);

            }
            
            
        });

</script>

<script>

// COPY HARGA JUAL 1
$(document).on('click','#copy1',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj = $("#harga_jual").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap").val(harga_jual_rj);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap").val('');
        }

});

</script>

<script>
// COPY HARGA JUAL 2 
$(document).on('click','#copy2',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj2 = $("#harga_jual2").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap2").val(harga_jual_rj2);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap2").val('');
        }
});

</script>

<script>
// COPY HARGA JUAL 3 
$(document).on('click','#copy3',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj3 = $("#harga_jual3").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap3").val(harga_jual_rj3);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap3").val('');
        }
});

</script> 

<script>
// COPY HARGA JUAL 4 
$(document).on('click','#copy4',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj4 = $("#harga_jual4").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap4").val(harga_jual_rj4);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap4").val('');
        }
});

</script> 

<script>
// COPY HARGA JUAL 5 
$(document).on('click','#copy5',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj5 = $("#harga_jual5").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap5").val(harga_jual_rj5);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap5").val('');
        }
});

</script> 

<script>
// COPY HARGA JUAL 6
$(document).on('click','#copy6',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj6 = $("#harga_jual6").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap6").val(harga_jual_rj6);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap6").val('');
        }
});

</script> 

<script>
// COPY HARGA JUAL 7
$(document).on('click','#copy7',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj7 = $("#harga_jual7").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap7").val(harga_jual_rj7);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap7").val('');
        }
});

</script>

<script>
// COPY SEMUA HARGA JUAL
$(document).on('click','#copy-all',function(e){

    var data_toogle = $(this).attr('data-toogle');
    var harga_jual_rj = $("#harga_jual").val();
    var harga_jual_rj2 = $("#harga_jual2").val();
    var harga_jual_rj3 = $("#harga_jual3").val();
    var harga_jual_rj4 = $("#harga_jual4").val();
    var harga_jual_rj5 = $("#harga_jual5").val();
    var harga_jual_rj6 = $("#harga_jual6").val();
    var harga_jual_rj7 = $("#harga_jual7").val();

        if (data_toogle == 0) {              
            $(this).attr("data-toogle", 1);
            $("#harga_jual_inap").val(harga_jual_rj);
            $("#harga_jual_inap2").val(harga_jual_rj2);
            $("#harga_jual_inap3").val(harga_jual_rj3);
            $("#harga_jual_inap4").val(harga_jual_rj4);
            $("#harga_jual_inap5").val(harga_jual_rj5);
            $("#harga_jual_inap6").val(harga_jual_rj6);
            $("#harga_jual_inap7").val(harga_jual_rj7);
        }
        else{                  
            $(this).attr("data-toogle", 0);
            $("#harga_jual_inap").val('');
            $("#harga_jual_inap2").val('');
            $("#harga_jual_inap3").val('');
            $("#harga_jual_inap4").val('');
            $("#harga_jual_inap5").val('');
            $("#harga_jual_inap6").val('');
            $("#harga_jual_inap7").val('');
        }
});

</script>


<script type="text/javascript">
$(function() {
    $('.copy-all').click(function() {
        $('.checkbox-copy').prop('checked', this.checked);
    });
});
</script>

<?php 
// memasukan file footer.php
include 'footer.php'; 
?>