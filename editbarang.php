<?php  include 'session_login.php';
// memasukkan file
 include 'header.php';
 include 'navbar.php';
 include 'db.php';

// mengirim data id dengan metode GET
 $id = $_GET['id'];
 
 // perintah untuk menampilkan data yang ada pada tabel barang berdasarkan id
 $query = $db->query("SELECT s.nama,b.id,b.jenis_barang,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang, b.status, b.limit_stok, b.over_stok, b.suplier, b.golongan, b.tipe_barang FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.id = '$id'");
 
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
							<input type="text" name="nama_barang" value="<?php echo $dataqu['nama_barang']; ?>" class="form-control" autocomplete="off" required="" >
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
					<input type="text" name="harga_beli" id="harga_beli" value="<?php echo $dataqu['harga_beli']; ?>" class="form-control" autocomplete="off" required="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >
					</div>

							<div class="form-group">
							<label> Harga Jual Level 1</label>
							<br>
							<input type="text" placeholder="Harga Jual Level 1" name="harga_jual" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual" value="<?php echo $dataqu['harga_jual'] ?>" class="form-control" autocomplete="off" required="">
							</div>
							<div class="form-group">
							<label> Harga Jual Level 2</label>
							<br>
							<input type="text" placeholder="Harga Jual Level 2" name="harga_jual_2" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual2" value="<?php echo $dataqu['harga_jual2'] ?>" class="form-control" autocomplete="off" >
							</div>
							<div class="form-group">
							<label> Harga Jual Level 3</label>
							<br>
							<input type="text" placeholder="Harga Jual Level 3" name="harga_jual_3" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual3"  value="<?php echo $dataqu['harga_jual3'] ?>" class="form-control" autocomplete="off" >
							</div>

							<div class="form-group">
                            <label> Harga Jual Level 4</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 4" name="harga_jual_4" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual4" value="<?php echo $dataqu['harga_jual4'] ?>" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 5</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 5" name="harga_jual_5" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual5" value="<?php echo $dataqu['harga_jual5'] ?>" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 6</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 6" name="harga_jual_6" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual6" value="<?php echo $dataqu['harga_jual6'] ?>" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 7</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 7" name="harga_jual_7" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" id="harga_jual7" value="<?php echo $dataqu['harga_jual7'] ?>" class="form-control" autocomplete="off">
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
					<input type="text" name="limit_stok" id="limit_stok" value="<?php echo $dataqu['limit_stok']; ?>" class="form-control" autocomplete="off"  >
					</div>

					<div class="form-group">
					<label> Over Stok </label><br>
					<input type="text" name="over_stok" id="over_stok" value="<?php echo $dataqu['over_stok']; ?>" class="form-control" autocomplete="off" >
					</div>


					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<!-- membuat tombol Edit -->
					<button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Simpan</button>

</div>
</div><!-- tag penutup div class=container -->

</form>



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

<?php 
// memasukan file footer.php
include 'footer.php'; 
?>
