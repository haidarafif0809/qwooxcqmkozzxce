<?php include 'session_login.php';



    include 'header.php';
    include 'navbar.php';
    include 'sanitasi.php';
    include 'db.php';

    $nama = $_GET['nama'];
    $id = $_GET['id'];

    $otoritas_akses = $db->query("SELECT * FROM hak_otoritas ho LEFT JOIN otoritas_penjualan open ON ho.id = open.id_otoritas LEFT JOIN otoritas_pembelian opem ON ho.id = opem.id_otoritas LEFT JOIN otoritas_master_data omd ON ho.id = omd.id_otoritas LEFT JOIN otoritas_pembayaran opemb ON ho.id = opemb.id_otoritas LEFT JOIN otoritas_transaksi_kas otk ON ho.id = otk.id_otoritas LEFT JOIN otoritas_kas_keluar okk ON ho.id = okk.id_otoritas LEFT JOIN otoritas_kas_masuk okm ON ho.id = okm.id_otoritas LEFT JOIN otoritas_kas_mutasi okmut ON ho.id = okmut.id_otoritas LEFT JOIN otoritas_persediaan operse ON ho.id = operse.id_otoritas LEFT JOIN otoritas_stok_opname oso ON ho.id = oso.id_otoritas LEFT JOIN otoritas_stok_awal osa ON ho.id = osa.id_otoritas LEFT JOIN otoritas_item_masuk oim ON ho.id = oim.id_otoritas LEFT JOIN otoritas_item_keluar oik ON ho.id = oik.id_otoritas LEFT JOIN otoritas_kas ok ON ho.id = ok.id_otoritas LEFT JOIN otoritas_laporan ol ON ho.id = ol.id_otoritas LEFT JOIN otoritas_registrasi oreg ON ho.id = oreg.id_otoritas LEFT JOIN otoritas_rekam_medik orm ON ho.id = orm.id_otoritas LEFT JOIN otoritas_setting os ON ho.id = os.id_otoritas LEFT JOIN otoritas_tipe_produk otp ON ho.id = otp.id_otoritas LEFT JOIN otoritas_laboratorium olab ON ho.id = olab.id_otoritas WHERE ho.id = '$id'");
    $data_otoritas = mysqli_fetch_array($otoritas_akses);


    $oto_jual = $db->query("SELECT * FROM hak_otoritas ho LEFT JOIN otoritas_penjualan_rj opr ON ho.id = opr.id_otoritas LEFT JOIN otoritas_penjualan_inap opi ON ho.id = opi.id_otoritas LEFT JOIN otoritas_penjualan_ugd opu ON ho.id = opu.id_otoritas  LEFT JOIN otoritas_penjualan_apotek opap ON ho.id = opap.id_otoritas LEFT JOIN otoritas_penjualan_lab opl ON ho.id = opl.id_otoritas WHERE ho.id = '$id'");
    $data_otoritas1 = mysqli_fetch_array($oto_jual);


 ?>

 <div class="container">
 
<form role="form" action="simpan_hak_otoritas.php" method="post">
 <h3><u>Hak Akses <?php echo $nama; ?></u></h3>
 <br>
 
 <div class="form-group">
 	<label>Otoritas</label><br>
 	<input type="text" class="form-control" id="otoritas" name="nama" value="<?php echo $nama; ?>" readonly="">

 </div>


    <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>" readonly="">

<div class="form-group col-sm-12"> <!-- start otoritas pilih semua-->
    <input type="checkbox" value="1" class="cekcbox1 filled-in" id="checkbox1">
    <label for="checkbox1">Pilih Semua</label>
</div> <!--  /start otoritas pilih semua-->


<div class="form-group col-sm-2"> <!-- / of otoritas registrasi -->
<label>Registrasi</label><br>

<?php 

if ($data_otoritas['registrasi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2000" name="registrasi_lihat" checked=""> 
    <label for="checkbox2000">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2000" name="registrasi_lihat">
    <label for="checkbox2000">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas registrasi -->


<div class="form-group col-sm-2"> <!-- / of otoritas rekam medik -->
<label>Rekam Medik</label><br>

<?php 

if ($data_otoritas['rekam_medik_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="20001" name="rekam_medik_lihat" checked=""> 
    <label for="20001">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="20001" name="rekam_medik_lihat">
    <label for="20001">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas rekam medik -->


<div class="form-group col-sm-2"> <!-- / of otoritas master_data -->
<label>Master Data</label><br>

<?php 

if ($data_otoritas['master_data_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="master_data_lihat" checked=""> 
    <label for="checkbox2">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="master_data_lihat">
    <label for="checkbox2">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas master_data -->





<div class="form-group col-sm-2"> <!-- start otoritas set_akun -->
<label>Setting Akun</label><br>

<?php 

if ($data_otoritas['set_akun_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox3" name="set_akun_lihat" checked="">
    <label for="checkbox3">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox3" name="set_akun_lihat">
    <label for="checkbox3">Lihat</label> <br>';  
}

 ?>


</div> <!-- / of otoritas set_akun -->


<div class="form-group col-sm-2"> <!-- start otoritas pembayaran -->
<label>Menu Pembayaran</label><br>

<?php 

if ($data_otoritas['pembayaran_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox4" name="pembayaran_lihat" checked="">
    <label for="checkbox4">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox4" name="pembayaran_lihat">
    <label for="checkbox4">Lihat</label> <br>';  
}

 ?>


</div> <!-- / of otoritas pembayaran -->


<div class="form-group col-sm-2"> <!-- start otoritas persediaan -->
<label>Menu Persediaan</label><br>

<?php 

if ($data_otoritas['persediaan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox5" name="persediaan_lihat" checked="">
    <label for="checkbox5">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox5" name="persediaan_lihat">
    <label for="checkbox5">Lihat</label> <br>';  
}

 ?>


</div> <!-- / of otoritas persediaan -->


<div class="form-group col-sm-2"> <!-- start otoritas transaksi_kas -->
<label>Menu Transaksi Kas</label><br>

<?php 

if ($data_otoritas['transaksi_kas_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox6" name="transaksi_kas_lihat" checked="">
    <label for="checkbox6">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox6" name="transaksi_kas_lihat">
    <label for="checkbox6">Lihat</label> <br>';  
}

 ?>


</div> <!-- / of otoritas transaksi_kas -->




<div class="form-group col-sm-2"> <!-- start otoritas retur -->
<label>Menu Retur</label><br>

<?php 

if ($data_otoritas['retur_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox7" name="retur_lihat" checked="">
    <label for="checkbox7">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox7" name="retur_lihat">
    <label for="checkbox7">Lihat</label> <br>';  
}

 ?>


</div> <!-- / of otoritas retur -->




<div class="form-group col-sm-2"> <!-- start otoritas posisi_kas -->
<label>Posisi Kas</label><br>

<?php 

if ($data_otoritas['posisi_kas_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox8" name="posisi_kas_lihat" checked="">
    <label for="checkbox8">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox8" name="posisi_kas_lihat">
    <label for="checkbox8">Lihat</label> <br>';  
}

 ?>


</div> <!-- / of otoritas posisi_kas -->




<div class="form-group col-sm-2"> <!-- start otoritas akuntansi -->
<label>Menu Akuntansi</label><br>

<?php 

if ($data_otoritas['akuntansi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox9" name="akuntansi_lihat" checked="">
    <label for="checkbox9">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox9" name="akuntansi_lihat">
    <label for="checkbox9">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas akuntansi -->



<div class="form-group col-sm-2"> <!-- / of otoritas menu setting -->
<label>Menu Setting</label><br>

<?php 

if ($data_otoritas['setting_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20102" name="setting_lihat" checked=""> 
    <label for="checkbox20102">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20102" name="setting_lihat">
    <label for="checkbox20102">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas menu setting -->


<div class="form-group col-sm-2"> <!-- / of otoritas menu laboratorium -->
<label>Menu Laboratorium</label><br>

<?php 

if ($data_otoritas['laboratorium_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25999" name="laboratorium_lihat" checked=""> 
    <label for="checkbox25999">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25999" name="laboratorium_lihat">
    <label for="checkbox25999">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas menu laboratorium -->

<div class="form-group col-sm-2"> <!-- / of otoritas setting registrasi-->
<label>Setting Registrasi</label><br>

<?php 

if ($data_otoritas['setting_registrasi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox201245" name="setting_registrasi_lihat" checked=""> 
    <label for="checkbox201245">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox201245" name="setting_registrasi_lihat">
    <label for="checkbox201245">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas setting registrasi-->


<div class="form-group col-sm-2"> <!-- / of otoritas setting penetapan petugas -->
<label>Setting Penetapan Petugas</label><br>

<?php 

if ($data_otoritas['penetapan_petugas_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20122" name="penetapan_petugas_lihat" checked=""> 
    <label for="checkbox20122">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20122" name="penetapan_petugas_lihat">
    <label for="checkbox20122">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas setting penetapan petugas -->

<!-- / of otoritas setting LABORATORIUM -->
<div class="form-group col-sm-2">
<label>Setting Laboratorium</label><br>
<?php 
if ($data_otoritas['setting_laboratorium_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox220" name="setting_lab_lihat" checked=""> 
    <label for="checkbox220">Lihat</label> <br>';
}
else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2021" name="setting_lab_lihat">
    <label for="checkbox2021">Lihat</label> <br>';  
}
?>
</div>
<!-- / of otoritas setting LABORATORIUM -->

<div class="form-group col-sm-2"> <!-- / of otoritas setting printer -->
<label>Setting Printer</label><br>

<?php 

if ($data_otoritas['printer_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20124" name="printer_lihat" checked=""> 
    <label for="checkbox20124">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20124" name="printer_lihat">
    <label for="checkbox20124">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas setting printer -->


<div class="form-group col-sm-2"> <!-- / of otoritas setting printer -->
<label>Setting Proses Kamar</label><br>

<?php 

if ($data_otoritas['kamar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox201248" name="kamar_lihat" checked=""> 
    <label for="checkbox201248">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox201248" name="kamar_lihat">
    <label for="checkbox201248">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas setting printer -->



<div class="form-group col-sm-2"> <!-- / of otoritas master_data -->
<label>Kartu Stok</label><br>

<?php 

if ($data_otoritas['kartu_stok_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2012" name="kartu_stok_lihat" checked=""> 
    <label for="checkbox2012">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2012" name="kartu_stok_lihat">
    <label for="checkbox2012">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas master_data -->

<div class="form-group col-sm-2"> <!-- start otoritas laporan_mutasi_stok -->
<label>Laporan Mutasi Stok</label><br>

<?php 

if ($data_otoritas['laporan_mutasi_stok_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox10" name="laporan_mutasi_stok_lihat" checked="">
    <label for="checkbox10">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox10" name="laporan_mutasi_stok_lihat">
    <label for="checkbox10">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan_mutasi_stok -->


<div class="form-group col-sm-2"> <!-- start otoritas laporan -->
<label>Menu Laporan</label><br>

<?php 

if ($data_otoritas['laporan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox11" name="laporan_lihat" checked="">
    <label for="checkbox11">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox11" name="laporan_lihat">
    <label for="checkbox11">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan -->
<div class="form-group col-sm-2"> <!-- start otoritas buku_besar -->
<label>Buku Besar</label><br>

<?php 

if ($data_otoritas['buku_besar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox12" name="buku_besar_lihat" checked="">
    <label for="checkbox12">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox12" name="buku_besar_lihat">
    <label for="checkbox12">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas buku_besar -->
<div class="form-group col-sm-2"> <!-- start otoritas laporan_jurnal -->
<label>Laporan Jurnal</label><br>

<?php 

if ($data_otoritas['laporan_jurnal_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1212" name="laporan_jurnal_lihat" checked="">
    <label for="checkbox1212">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1212" name="laporan_jurnal_lihat">
    <label for="checkbox1212">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan_jurnal -->
<div class="form-group col-sm-2"> <!-- start otoritas laporan_laba_kotor -->
<label>Laporan Laba Kotor</label><br>

<?php 

if ($data_otoritas['laporan_laba_kotor_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox13" name="laporan_laba_kotor_lihat" checked="">
    <label for="checkbox13">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox13" name="laporan_laba_kotor_lihat">
    <label for="checkbox13">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan_laba_kotor -->
<div class="form-group col-sm-2"> <!-- start otoritas laporan_laba_rugi -->
<label>Laporan Laba Rugi</label><br>

<?php 

if ($data_otoritas['laporan_laba_rugi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox14" name="laporan_laba_rugi_lihat" checked="">
    <label for="checkbox14">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox14" name="laporan_laba_rugi_lihat">
    <label for="checkbox14">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan_laba_rugi -->

<div class="form-group col-sm-2"> <!-- start otoritas laporan_neraca -->
<label>Laporan Neraca</label><br>

<?php 

if ($data_otoritas['laporan_neraca_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox15" name="laporan_neraca_lihat" checked="">
    <label for="checkbox15">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox15" name="laporan_neraca_lihat">
    <label for="checkbox15">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan_neraca -->

<div class="form-group col-sm-2"> <!-- start otoritas laporan laboratorium -->
<label>Laporan Laboratorium</label><br>

<?php 

if ($data_otoritas['laporan_laboratorium_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox15477" name="laporan_laboratorium_lihat" checked="">
    <label for="checkbox15477">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox15477" name="laporan_laboratorium_lihat">
    <label for="checkbox15477">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan laboratorium -->

<div class="form-group col-sm-2"> <!-- start otoritas aporan kunjungan rj -->
<label>Laporan Kunjungan R. Jalan</label><br>

<?php 

if ($data_otoritas['laporan_kunjungan_rj'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1514" name="laporan_kunjungan_rj" checked="">
    <label for="checkbox1514">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1514" name="laporan_kunjungan_rj">
    <label for="checkbox1514">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas aporan kunjungan rj -->





<div class="form-group col-sm-2"> <!-- start otoritas aporan kunjungan ri -->
<label>Laporan Kunjungan R. Inap</label><br>

<?php 

if ($data_otoritas['laporan_kunjungan_ri'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox15235" name="laporan_kunjungan_ri" checked="">
    <label for="checkbox15235">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox15235" name="laporan_kunjungan_ri">
    <label for="checkbox15235">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas aporan kunjungan ri -->

<div class="form-group col-sm-2"> <!-- start otoritas laporan kunjungan UGD -->
<label>Laporan Kunjungan UGD</label><br>

<?php 

if ($data_otoritas['laporan_kunjungan_ugd'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1547" name="laporan_kunjungan_ugd" checked="">
    <label for="checkbox1547">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1547" name="laporan_kunjungan_ugd">
    <label for="checkbox1547">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas laporan kunjungan UGD -->




<div class="form-group col-sm-2"> <!-- start otoritas MENU RAWAT JALAN -->
<label>Penjualan Rawat Jalan</label><br>

<?php 

if ($data_otoritas['menu_rawat_jalan'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox251" name="menu_rawat_jalan" checked="">
    <label for="checkbox251">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox251" name="menu_rawat_jalan">
    <label for="checkbox251">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas MENU RAWAT JALAN -->

<div class="form-group col-sm-2"> <!-- start otoritas MENU RAWAT INAP -->
<label>Penjualan Rawat Inap</label><br>

<?php 

if ($data_otoritas['menu_rawat_inap'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2512" name="menu_rawat_inap" checked="">
    <label for="checkbox2512">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2512" name="menu_rawat_inap">
    <label for="checkbox2512">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas MENU RAWAT INAP -->



<div class="form-group col-sm-2"> <!-- start otoritas MENU UGD -->
<label>Penjualan UGD</label><br>

<?php 

if ($data_otoritas['menu_ugd'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25123" name="menu_ugd" checked="">
    <label for="checkbox25123">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25123" name="menu_ugd">
    <label for="checkbox25123">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas MENU UGD -->



<div class="form-group col-sm-2"> <!-- start otoritas MENU Apotek -->
<label>Penjualan Apotek</label><br>

<?php 

if ($data_otoritas['menu_apotek'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox251234" name="menu_apotek" checked="">
    <label for="checkbox251234">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox251234" name="menu_apotek">
    <label for="checkbox251234">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas MENU Apotek -->


<div class="form-group col-sm-2"> <!-- start otoritas MENU Apotek -->
<label>Penjualan Laboratorium</label><br>

<?php 

if ($data_otoritas['menu_laboratorium'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2512345" name="menu_laboratorium" checked="">
    <label for="checkbox2512345">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2512345" name="menu_laboratorium">
    <label for="checkbox2512345">Lihat</label> <br>';  
}

 ?>

</div> <!-- / of otoritas MENU Apotek -->


<div class="form-group col-sm-12">
    
</div>


<div class="form-group col-sm-4">
    OTORITAS FORM PENJUALAN RAWAT JALAN
</div>

<div class="form-group col-sm-4">
    OTORITAS FORM PENJUALAN RAWAT INAP
</div>

<div class="form-group col-sm-4">
    OTORITAS FORM PENJUALAN UGD
</div>

<div class="form-group col-sm-2">


    <?php 

    if ($data_otoritas1['tombol_submit'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk" name="tombol_submit_produk" checked="">
        <label for="tombol_submit_produk">Tombol Submit</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk" name="tombol_submit_produk">
        <label for="tombol_submit_produk">Tombol Submit</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_bayar'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar" name="tombol_bayar" checked="">
        <label for="tombol_bayar">Tombol Bayar</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar" name="tombol_bayar">
        <label for="tombol_bayar">Tombol Bayar</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_simpan'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_simpan" name="tombol_simpan" checked="">
        <label for="tombol_simpan">Tombol Simpan</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_simpan" name="tombol_simpan">
        <label for="tombol_simpan">Tombol Simpan</label> <br>';  
    }

     ?>


    <?php 

    if ($data_otoritas1['tombol_piutang'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang" name="tombol_piutang" checked="">
        <label for="tombol_piutang">Tombol Piutang</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang" name="tombol_piutang">
        <label for="tombol_piutang">Tombol Piutang</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-2">

    <?php 

    if ($data_otoritas1['tombol_batal'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal" name="tombol_batal" checked="">
        <label for="tombol_batal">Tombol Batal</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal" name="tombol_batal">
        <label for="tombol_batal">Tombol Batal</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['hapus_produk'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk" name="hapus_produk" checked="">
        <label for="hapus_produk">Tombol Hapus</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk" name="hapus_produk">
        <label for="hapus_produk">Tombol Hapus</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['edit_produk'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk" name="edit_produk" checked="">
        <label for="edit_produk">Edit Produk</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk" name="edit_produk">
        <label for="edit_produk">Edit Produk</label> <br>';  
    }

     ?>


    
</div>



<div class="form-group col-sm-2">


    <?php 

    if ($data_otoritas1['tombol_submit_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_inap" name="tombol_submit_produk_inap" checked="">
        <label for="tombol_submit_produk_inap">Tombol Submit</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_inap" name="tombol_submit_produk_inap">
        <label for="tombol_submit_produk_inap">Tombol Submit</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_bayar_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_inap" name="tombol_bayar_inap" checked="">
        <label for="tombol_bayar_inap">Tombol Bayar</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_inap" name="tombol_bayar_inap">
        <label for="tombol_bayar_inap">Tombol Bayar</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_simpan_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_simpan_inap" name="tombol_simpan_inap" checked="">
        <label for="tombol_simpan_inap">Tombol Simpan</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_simpan_inap" name="tombol_simpan_inap">
        <label for="tombol_simpan_inap">Tombol Simpan</label> <br>';  
    }

     ?>


    <?php 

    if ($data_otoritas1['tombol_piutang_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_inap" name="tombol_piutang_inap" checked="">
        <label for="tombol_piutang_inap">Tombol Piutang</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_inap" name="tombol_piutang_inap">
        <label for="tombol_piutang_inap">Tombol Piutang</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-2">

    <?php 

    if ($data_otoritas1['tombol_batal_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_inap" name="tombol_batal_inap" checked="">
        <label for="tombol_batal_inap">Tombol Batal</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_inap" name="tombol_batal_inap">
        <label for="tombol_batal_inap">Tombol Batal</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['hapus_produk_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_inap" name="hapus_produk_inap" checked="">
        <label for="hapus_produk_inap">Tombol Hapus</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_inap" name="hapus_produk_inap">
        <label for="hapus_produk_inap">Tombol Hapus</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['edit_produk_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_inap" name="edit_produk_inap" checked="">
        <label for="edit_produk_inap">Edit Produk</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_inap" name="edit_produk_inap">
        <label for="edit_produk_inap">Edit Produk</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['edit_tanggal_inap'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_tanggal_inap" name="edit_tanggal_inap" checked="">
        <label for="edit_tanggal_inap">Edit Tanggal</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_tanggal_inap" name="edit_tanggal_inap">
        <label for="edit_tanggal_inap">Edit Tanggal</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-2">


    <?php 

    if ($data_otoritas1['tombol_submit_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_ugd" name="tombol_submit_produk_ugd" checked="">
        <label for="tombol_submit_produk_ugd">Tombol Submit</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_ugd" name="tombol_submit_produk_ugd">
        <label for="tombol_submit_produk_ugd">Tombol Submit</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_bayar_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_ugd" name="tombol_bayar_ugd" checked="">
        <label for="tombol_bayar_ugd">Tombol Bayar</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_ugd" name="tombol_bayar_ugd">
        <label for="tombol_bayar_ugd">Tombol Bayar</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_simpan_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_simpan_ugd" name="tombol_simpan_ugd" checked="">
        <label for="tombol_simpan_ugd">Tombol Simpan</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_simpan_ugd" name="tombol_simpan_ugd">
        <label for="tombol_simpan_ugd">Tombol Simpan</label> <br>';  
    }

     ?>


    <?php 

    if ($data_otoritas1['tombol_piutang_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_ugd" name="tombol_piutang_ugd" checked="">
        <label for="tombol_piutang_ugd">Tombol Piutang</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_ugd" name="tombol_piutang_ugd">
        <label for="tombol_piutang_ugd">Tombol Piutang</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-2">

    <?php 

    if ($data_otoritas1['tombol_batal_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_ugd" name="tombol_batal_ugd" checked="">
        <label for="tombol_batal_ugd">Tombol Batal</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_ugd" name="tombol_batal_ugd">
        <label for="tombol_batal_ugd">Tombol Batal</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['hapus_produk_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_ugd" name="hapus_produk_ugd" checked="">
        <label for="hapus_produk_ugd">Tombol Hapus</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_ugd" name="hapus_produk_ugd">
        <label for="hapus_produk_ugd">Tombol Hapus</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['edit_produk_ugd'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_ugd" name="edit_produk_ugd" checked="">
        <label for="edit_produk_ugd">Edit Produk</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_ugd" name="edit_produk_ugd">
        <label for="edit_produk_ugd">Edit Produk</label> <br>';  
    }

     ?>


    
</div>

<div class="form-group col-sm-12">
    
</div>

<div class="form-group col-sm-4">
    OTORITAS FORM PENJUALAN APOTEK
</div>

<div class="form-group col-sm-4">
    OTORITAS FORM PENJUALAN LABORATORIUM
</div>

<div class="form-group col-sm-4">
    OTORITAS TIPE PRODUK
</div>



<div class="form-group col-sm-2">


    <?php 

    if ($data_otoritas1['tombol_submit_apotek'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_apotek" name="tombol_submit_produk_apotek" checked="">
        <label for="tombol_submit_produk_apotek">Tombol Submit</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_apotek" name="tombol_submit_produk_apotek">
        <label for="tombol_submit_produk_apotek">Tombol Submit</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_bayar_apotek'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_apotek" name="tombol_bayar_apotek" checked="">
        <label for="tombol_bayar_apotek">Tombol Bayar</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_apotek" name="tombol_bayar_apotek">
        <label for="tombol_bayar_apotek">Tombol Bayar</label> <br>';  
    }

     ?>



    <?php 

    if ($data_otoritas1['tombol_piutang_apotek'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_apotek" name="tombol_piutang_apotek" checked="">
        <label for="tombol_piutang_apotek">Tombol Piutang</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_apotek" name="tombol_piutang_apotek">
        <label for="tombol_piutang_apotek">Tombol Piutang</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-2">

    <?php 

    if ($data_otoritas1['tombol_batal_apotek'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_apotek" name="tombol_batal_apotek" checked="">
        <label for="tombol_batal_apotek">Tombol Batal</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_apotek" name="tombol_batal_apotek">
        <label for="tombol_batal_apotek">Tombol Batal</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['hapus_produk_apotek'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_apotek" name="hapus_produk_apotek" checked="">
        <label for="hapus_produk_apotek">Tombol Hapus</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_apotek" name="hapus_produk_apotek">
        <label for="hapus_produk_apotek">Tombol Hapus</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['edit_produk_apotek'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_apotek" name="edit_produk_apotek" checked="">
        <label for="edit_produk_apotek">Edit Produk</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_apotek" name="edit_produk_apotek">
        <label for="edit_produk_apotek">Edit Produk</label> <br>';  
    }

     ?>


    
</div>

<div class="form-group col-sm-2">


    <?php 

    if ($data_otoritas1['tombol_submit_lab'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_lab" name="tombol_submit_produk_lab" checked="">
        <label for="tombol_submit_produk_lab">Tombol Submit</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_submit_produk_lab" name="tombol_submit_produk_lab">
        <label for="tombol_submit_produk_lab">Tombol Submit</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['tombol_bayar_lab'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_lab" name="tombol_bayar_lab" checked="">
        <label for="tombol_bayar_lab">Tombol Bayar</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_bayar_lab" name="tombol_bayar_lab">
        <label for="tombol_bayar_lab">Tombol Bayar</label> <br>';  
    }

     ?>


    <?php 

    if ($data_otoritas1['tombol_piutang_lab'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_lab" name="tombol_piutang_lab" checked="">
        <label for="tombol_piutang_lab">Tombol Piutang</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_piutang_lab" name="tombol_piutang_lab">
        <label for="tombol_piutang_lab">Tombol Piutang</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-2">

    <?php 

    if ($data_otoritas1['tombol_batal_lab'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_lab" name="tombol_batal_lab" checked="">
        <label for="tombol_batal_lab">Tombol Batal</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tombol_batal_lab" name="tombol_batal_lab">
        <label for="tombol_batal_lab">Tombol Batal</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['hapus_produk_lab'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_lab" name="hapus_produk_lab" checked="">
        <label for="hapus_produk_lab">Tombol Hapus</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="hapus_produk_lab" name="hapus_produk_lab">
        <label for="hapus_produk_lab">Tombol Hapus</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas1['edit_produk_lab'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_lab" name="edit_produk_lab" checked="">
        <label for="edit_produk_lab">Edit Produk</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="edit_produk_lab" name="edit_produk_lab">
        <label for="edit_produk_lab">Edit Produk</label> <br>';  
    }

     ?>


    
</div>


<div class="form-group col-sm-2">


    <?php 

    if ($data_otoritas['tipe_barang'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_barang" name="tipe_barang" checked="">
        <label for="tipe_barang">Barang</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_barang" name="tipe_barang">
        <label for="tipe_barang">Barang</label> <br>';  
    }

     ?>

    <?php 

    if ($data_otoritas['tipe_jasa'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_jasa" name="tipe_jasa" checked="">
        <label for="tipe_jasa">Jasa</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_jasa" name="tipe_jasa">
        <label for="tipe_jasa">Jasa</label> <br>';  
    }

     ?>



    <?php 

    if ($data_otoritas['tipe_alat'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_alat" name="tipe_alat" checked="">
        <label for="tipe_alat">Alat</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_alat" name="tipe_alat">
        <label for="tipe_alat">Alat</label> <br>';  
    }

     ?>

</div>

<div class="form-group col-sm-2">

    <?php 

    if ($data_otoritas['tipe_bhp'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_bhp" name="tipe_bhp" checked="">
        <label for="tipe_bhp">BHP</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_bhp" name="tipe_bhp">
        <label for="tipe_bhp">BHP</label> <br>';  
    }

     ?>



    <?php 

    if ($data_otoritas['tipe_obat'] == '1'){
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_obat" name="tipe_obat" checked="">
        <label for="tipe_obat">Obat Obatan</label> <br>';
    }

    else{
        echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="tipe_obat" name="tipe_obat">
        <label for="tipe_obat">Obat Obatan</label> <br>';  
    }

     ?>
    
</div>


<div class="form-group col-sm-12">
    
</div>

<div class="form-group col-sm-2"> <!-- start otoritas registrasi rawat jalan -->
<label>Registrasi Rawat Jalan</label><br>

<?php 

if ($data_otoritas['registrasi_rj_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox001" name="registrasi_rj_lihat" checked="">
    <label for="checkbox001">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox001" name="registrasi_rj_lihat">
    <label for="checkbox001">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_rj_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox002" name="registrasi_rj_tambah" checked=""> 
    <label for="checkbox002">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox002" name="registrasi_rj_tambah"> 
    <label for="checkbox002">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_rj_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox003" name="registrasi_rj_edit" checked="">
    <label for="checkbox003">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox003" name="registrasi_rj_edit">
    <label for="checkbox003">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_rj_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox004" name="registrasi_rj_hapus" checked="">
    <label for="checkbox004">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox004" name="registrasi_rj_hapus">
    <label for="checkbox004">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas registrasi rawat jalan -->


<div class="form-group col-sm-2"> <!-- start otoritas registrasi rawat ri -->
<label>Registrasi Rawat Inap</label><br>

<?php 

if ($data_otoritas['registrasi_ri_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox005" name="registrasi_ri_lihat" checked="">
    <label for="checkbox005">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox005" name="registrasi_ri_lihat">
    <label for="checkbox005">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_ri_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox006" name="registrasi_ri_tambah" checked=""> 
    <label for="checkbox006">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox006" name="registrasi_ri_tambah"> 
    <label for="checkbox006">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_ri_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox007" name="registrasi_ri_edit" checked="">
    <label for="checkbox007">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox007" name="registrasi_ri_edit">
    <label for="checkbox007">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_ri_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox008" name="registrasi_ri_hapus" checked="">
    <label for="checkbox008">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox008" name="registrasi_ri_hapus">
    <label for="checkbox008">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas registrasi rawat inap -->


<div class="form-group col-sm-2"> <!-- start otoritas registrasi UGD -->
<label>Registrasi UGD</label><br>

<?php 

if ($data_otoritas['registrasi_ugd_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox009" name="registrasi_ugd_lihat" checked="">
    <label for="checkbox009">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox009" name="registrasi_ugd_lihat">
    <label for="checkbox009">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_ugd_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox010" name="registrasi_ugd_tambah" checked=""> 
    <label for="checkbox010">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox010" name="registrasi_ugd_tambah"> 
    <label for="checkbox010">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_ugd_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox011" name="registrasi_ugd_edit" checked="">
    <label for="checkbox011">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox011" name="registrasi_ugd_edit">
    <label for="checkbox011">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['registrasi_ugd_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox012" name="registrasi_ugd_hapus" checked="">
    <label for="checkbox012">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox012" name="registrasi_ugd_hapus">
    <label for="checkbox012">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas registrasi UGD -->



<div class="form-group col-sm-2"> <!-- start otoritas registrasi rawat jalan -->
<label>Rekam Medik Rawat Jalan</label><br>

<?php 

if ($data_otoritas['rekam_medik_rj_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox013" name="rekam_medik_rj_lihat" checked="">
    <label for="checkbox013">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox013" name="rekam_medik_rj_lihat">
    <label for="checkbox013">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_rj_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox014" name="rekam_medik_rj_tambah" checked=""> 
    <label for="checkbox014">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox014" name="rekam_medik_rj_tambah"> 
    <label for="checkbox014">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_rj_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox015" name="rekam_medik_rj_edit" checked="">
    <label for="checkbox015">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox015" name="rekam_medik_rj_edit">
    <label for="checkbox015">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_rj_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox016" name="rekam_medik_rj_hapus" checked="">
    <label for="checkbox016">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox016" name="rekam_medik_rj_hapus">
    <label for="checkbox016">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas rekam_medik rawat jalan -->


<div class="form-group col-sm-2"> <!-- start otoritas rekam_medik rawat ri -->
<label>Rekam Medik Rawat Inap</label><br>

<?php 

if ($data_otoritas['rekam_medik_ri_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox017" name="rekam_medik_ri_lihat" checked="">
    <label for="checkbox017">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox017" name="rekam_medik_ri_lihat">
    <label for="checkbox017">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_ri_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox018" name="rekam_medik_ri_tambah" checked=""> 
    <label for="checkbox018">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox018" name="rekam_medik_ri_tambah"> 
    <label for="checkbox018">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_ri_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox019" name="rekam_medik_ri_edit" checked="">
    <label for="checkbox019">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox019" name="rekam_medik_ri_edit">
    <label for="checkbox019">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_ri_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox020" name="rekam_medik_ri_hapus" checked="">
    <label for="checkbox020">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox020" name="rekam_medik_ri_hapus">
    <label for="checkbox020">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas rekam_medik rawat inap -->


<div class="form-group col-sm-2"> <!-- start otoritas rekam_medik UGD -->
<label>Rekam Medik UGD</label><br>

<?php 

if ($data_otoritas['rekam_medik_ugd_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox021" name="rekam_medik_ugd_lihat" checked="">
    <label for="checkbox021">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox021" name="rekam_medik_ugd_lihat">
    <label for="checkbox021">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_ugd_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox022" name="rekam_medik_ugd_tambah" checked=""> 
    <label for="checkbox022">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox022" name="rekam_medik_ugd_tambah"> 
    <label for="checkbox022">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_ugd_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox023" name="rekam_medik_ugd_edit" checked="">
    <label for="checkbox023">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox023" name="rekam_medik_ugd_edit">
    <label for="checkbox023">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['rekam_medik_ugd_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox024" name="rekam_medik_ugd_hapus" checked="">
    <label for="checkbox024">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox024" name="rekam_medik_ugd_hapus">
    <label for="checkbox024">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas registrasi UGD -->


<div class="form-group col-sm-2"> <!-- start otoritas penjualan -->
<label>Penjualan</label><br>

<?php 

if ($data_otoritas['penjualan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox17" name="penjualan_lihat" checked="">
    <label for="checkbox17">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox17" name="penjualan_lihat">
    <label for="checkbox17">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['penjualan_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox18" name="penjualan_tambah" checked=""> 
    <label for="checkbox18">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox18" name="penjualan_tambah"> 
    <label for="checkbox18">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['penjualan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox19" name="penjualan_edit" checked="">
    <label for="checkbox19">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox19" name="penjualan_edit">
    <label for="checkbox19">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['penjualan_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20" name="penjualan_hapus" checked="">
    <label for="checkbox20">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox20" name="penjualan_hapus">
    <label for="checkbox20">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas penjualan -->



<div class="form-group col-sm-2"> <!-- start otoritas pembelian -->
<label>Pembelian</label><br>

<?php 

if ($data_otoritas['pembelian_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox21" name="pembelian_lihat" checked="">
    <label for="checkbox21">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox21" name="pembelian_lihat">
    <label for="checkbox21">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pembelian_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox22" name="pembelian_tambah" checked=""> 
    <label for="checkbox22">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox22" name="pembelian_tambah"> 
    <label for="checkbox22">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['pembelian_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox23" name="pembelian_edit" checked="">
    <label for="checkbox23">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox23" name="pembelian_edit">
    <label for="checkbox23">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pembelian_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox24" name="pembelian_hapus" checked="">
    <label for="checkbox24">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox24" name="pembelian_hapus">
    <label for="checkbox24">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas pembelian -->




<div class="form-group col-sm-2"> <!-- start otoritas user -->
<label>User</label><br>

<?php 

if ($data_otoritas['user_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25" name="user_lihat" checked="">
    <label for="checkbox25">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25" name="user_lihat">
    <label for="checkbox25">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['user_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox26" name="user_tambah" checked=""> 
    <label for="checkbox26">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox26" name="user_tambah"> 
    <label for="checkbox26">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['user_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox27" name="user_edit" checked="">
    <label for="checkbox27">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox27" name="user_edit">
    <label for="checkbox27">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['user_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox28" name="user_hapus" checked="">
    <label for="checkbox28">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox28" name="user_hapus">
    <label for="checkbox28">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas user -->




<div class="form-group col-sm-2"> <!-- start otoritas poli -->
<label>Poli</label><br>

<?php 

if ($data_otoritas['poli_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox251" name="poli_lihat" checked="">
    <label for="checkbox251">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox251" name="poli_lihat">
    <label for="checkbox251">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['poli_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox261" name="poli_tambah" checked=""> 
    <label for="checkbox261">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox261" name="poli_tambah"> 
    <label for="checkbox261">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['poli_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox271" name="poli_edit" checked="">
    <label for="checkbox271">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox271" name="poli_edit">
    <label for="checkbox271">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['poli_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox281" name="poli_hapus" checked="">
    <label for="checkbox281">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox281" name="poli_hapus">
    <label for="checkbox281">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas poli -->



<div class="form-group col-sm-2"> <!-- start otoritas kamar -->
<label>Kamar</label><br>

<?php 

if ($data_otoritas['kamar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox250" name="kamar_lihat" checked="">
    <label for="checkbox250">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox250" name="kamar_lihat">
    <label for="checkbox250">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kamar_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox260" name="kamar_tambah" checked=""> 
    <label for="checkbox260">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox260" name="kamar_tambah"> 
    <label for="checkbox260">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['kamar_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox270" name="kamar_edit" checked="">
    <label for="checkbox270">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox270" name="kamar_edit">
    <label for="checkbox270">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kamar_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox280" name="kamar_hapus" checked="">
    <label for="checkbox280">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox280" name="kamar_hapus">
    <label for="checkbox280">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kamar -->



<div class="form-group col-sm-2"> <!-- start otoritas penjamin -->
<label>Penjamin</label><br>

<?php 

if ($data_otoritas['penjamin_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox252" name="penjamin_lihat" checked="">
    <label for="checkbox252">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox252" name="penjamin_lihat">
    <label for="checkbox252">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['penjamin_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox262" name="penjamin_tambah" checked=""> 
    <label for="checkbox262">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox262" name="penjamin_tambah"> 
    <label for="checkbox262">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['penjamin_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox272" name="penjamin_edit" checked="">
    <label for="checkbox272">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox272" name="penjamin_edit">
    <label for="checkbox272">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['penjamin_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox282" name="penjamin_hapus" checked="">
    <label for="checkbox282">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox282" name="penjamin_hapus">
    <label for="checkbox282">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas penjamin -->


<div class="form-group col-sm-2"> <!-- start otoritas perujuk -->
<label>Perujuk</label><br>

<?php 

if ($data_otoritas['perujuk_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox258" name="perujuk_lihat" checked="">
    <label for="checkbox258">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox258" name="perujuk_lihat">
    <label for="checkbox258">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['perujuk_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox268" name="perujuk_tambah" checked=""> 
    <label for="checkbox268">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox268" name="perujuk_tambah"> 
    <label for="checkbox268">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['perujuk_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox278" name="perujuk_edit" checked="">
    <label for="checkbox278">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox278" name="perujuk_edit">
    <label for="checkbox278">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['perujuk_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox288" name="perujuk_hapus" checked="">
    <label for="checkbox288">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox288" name="perujuk_hapus">
    <label for="checkbox288">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas perujuk -->


<div class="form-group col-sm-2"> <!-- start otoritas jenis obat -->
<label>Jenis Obat</label><br>

<?php 

if ($data_otoritas['jenis_obat_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2501" name="jenis_obat_lihat" checked="">
    <label for="checkbox2501">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2501" name="jenis_obat_lihat">
    <label for="checkbox2501">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['jenis_obat_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2601" name="jenis_obat_tambah" checked=""> 
    <label for="checkbox2601">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2601" name="jenis_obat_tambah"> 
    <label for="checkbox2601">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['jenis_obat_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2701" name="jenis_obat_edit" checked="">
    <label for="checkbox2701">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2701" name="jenis_obat_edit">
    <label for="checkbox2701">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['jenis_obat_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2801" name="jenis_obat_hapus" checked="">
    <label for="checkbox2801">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2801" name="jenis_obat_hapus">
    <label for="checkbox2801">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas jenis obat -->


<div class="form-group col-sm-2"> <!-- start otoritas kelas kamar -->
<label>Kelas Kamar</label><br>

<?php 

if ($data_otoritas['kelas_kamar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2091" name="kelas_kamar_lihat" checked="">
    <label for="checkbox2091">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2091" name="kelas_kamar_lihat">
    <label for="checkbox2091">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kelas_kamar_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2092" name="kelas_kamar_tambah" checked=""> 
    <label for="checkbox2092">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2092" name="kelas_kamar_tambah"> 
    <label for="checkbox2092">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['kelas_kamar_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2093" name="kelas_kamar_edit" checked="">
    <label for="checkbox2093">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2093" name="kelas_kamar_edit">
    <label for="checkbox2093">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kelas_kamar_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2094" name="kelas_kamar_hapus" checked="">
    <label for="checkbox2094">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2094" name="kelas_kamar_hapus">
    <label for="checkbox2094">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kelas kamar -->


<div class="form-group col-sm-2"> <!-- start otoritas cito -->
<label>Cito</label><br>

<?php 

if ($data_otoritas['cito_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2505" name="cito_lihat" checked="">
    <label for="checkbox2505">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2505" name="cito_lihat">
    <label for="checkbox2505">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['cito_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2605" name="cito_tambah" checked=""> 
    <label for="checkbox2605">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2605" name="cito_tambah"> 
    <label for="checkbox2605">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['cito_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2705" name="cito_edit" checked="">
    <label for="checkbox2705">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2705" name="cito_edit">
    <label for="checkbox2705">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['cito_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2805" name="cito_hapus" checked="">
    <label for="checkbox2805">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2805" name="cito_hapus">
    <label for="checkbox2805">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas cito -->


<div class="form-group col-sm-2"> <!-- start otoritas operasi -->
<label>Operasi</label><br>

<?php 

if ($data_otoritas['operasi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25012" name="operasi_lihat" checked="">
    <label for="checkbox25012">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25012" name="operasi_lihat">
    <label for="checkbox25012">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['operasi_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox26012" name="operasi_tambah" checked=""> 
    <label for="checkbox26012">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox26012" name="operasi_tambah"> 
    <label for="checkbox26012">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['operasi_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox27012" name="operasi_edit" checked="">
    <label for="checkbox27012">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox27012" name="operasi_edit">
    <label for="checkbox27012">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['operasi_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox28012" name="operasi_hapus" checked="">
    <label for="checkbox28012">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox28012" name="operasi_hapus">
    <label for="checkbox28012">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas operasi -->



<div class="form-group col-sm-2"> <!-- start otoritas sub operasi -->
<label>Sub Operasi</label><br>

<?php 

if ($data_otoritas['sub_operasi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25058" name="sub_operasi_lihat" checked="">
    <label for="checkbox25058">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox25058" name="sub_operasi_lihat">
    <label for="checkbox25058">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['sub_operasi_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox21235" name="sub_operasi_tambah" checked=""> 
    <label for="checkbox21235">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox21235" name="sub_operasi_tambah"> 
    <label for="checkbox21235">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['sub_operasi_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2748" name="sub_operasi_edit" checked="">
    <label for="checkbox2748">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2748" name="sub_operasi_edit">
    <label for="checkbox2748">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['sub_operasi_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox24785" name="sub_operasi_hapus" checked="">
    <label for="checkbox24785">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox24785" name="sub_operasi_hapus">
    <label for="checkbox24785">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas sub operasi -->



<div class="form-group col-sm-2"> <!-- start otoritas detail sub operasi -->
<label>Detail Sub Operasi</label><br>

<?php 

if ($data_otoritas['detail_sub_operasi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox250581" name="detail_sub_operasi_lihat" checked="">
    <label for="checkbox250581">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox250581" name="detail_sub_operasi_lihat">
    <label for="checkbox250581">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['detail_sub_operasi_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox212351" name="detail_sub_operasi_tambah" checked=""> 
    <label for="checkbox212351">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox212351" name="detail_sub_operasi_tambah"> 
    <label for="checkbox212351">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['detail_sub_operasi_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox27481" name="detail_sub_operasi_edit" checked="">
    <label for="checkbox27481">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox27481" name="detail_sub_operasi_edit">
    <label for="checkbox27481">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['detail_sub_operasi_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox247851" name="detail_sub_operasi_hapus" checked="">
    <label for="checkbox247851">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox247851" name="detail_sub_operasi_hapus">
    <label for="checkbox247851">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas detail sub operasi -->



<div class="form-group col-sm-2"> <!-- start otoritas jabatan -->
<label>Jabatan</label><br>

<?php 

if ($data_otoritas['jabatan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox29" name="jabatan_lihat" checked="">
    <label for="checkbox29">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox29" name="jabatan_lihat">
    <label for="checkbox29">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['jabatan_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox30" name="jabatan_tambah" checked=""> 
    <label for="checkbox30">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox30" name="jabatan_tambah"> 
    <label for="checkbox30">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['jabatan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox31" name="jabatan_edit" checked="">
    <label for="checkbox31">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox31" name="jabatan_edit">
    <label for="checkbox31">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['jabatan_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox32" name="jabatan_hapus" checked="">
    <label for="checkbox32">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox32" name="jabatan_hapus">
    <label for="checkbox32">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas jabatan -->


<div class="form-group col-sm-2"> <!-- start otoritas suplier -->
<label>Suplier</label><br>

<?php 

if ($data_otoritas['suplier_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox33" name="suplier_lihat" checked="">
    <label for="checkbox33">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox33" name="suplier_lihat">
    <label for="checkbox33">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['suplier_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox34" name="suplier_tambah" checked=""> 
    <label for="checkbox34">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox34" name="suplier_tambah"> 
    <label for="checkbox34">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['suplier_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox35" name="suplier_edit" checked="">
    <label for="checkbox35">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox35" name="suplier_edit">
    <label for="checkbox35">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['suplier_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox36" name="suplier_hapus" checked="">
    <label for="checkbox36">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox36" name="suplier_hapus">
    <label for="checkbox36">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas suplier -->



<div class="form-group col-sm-2"> <!-- start otoritas pelanggan -->
<label>Pelanggan</label><br>

<?php 

if ($data_otoritas['pelanggan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox37" name="pelanggan_lihat" checked="">
    <label for="checkbox37">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox37" name="pelanggan_lihat">
    <label for="checkbox37">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pelanggan_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox38" name="pelanggan_tambah" checked=""> 
    <label for="checkbox38">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox38" name="pelanggan_tambah"> 
    <label for="checkbox38">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['pelanggan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox39" name="pelanggan_edit" checked="">
    <label for="checkbox39">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox39" name="pelanggan_edit">
    <label for="checkbox39">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pelanggan_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox40" name="pelanggan_hapus" checked="">
    <label for="checkbox40">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox40" name="pelanggan_hapus">
    <label for="checkbox40">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas pelanggan -->



<div class="form-group col-sm-2"> <!-- start otoritas satuan -->
<label>Satuan</label><br>

<?php 

if ($data_otoritas['satuan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox41" name="satuan_lihat" checked="">
    <label for="checkbox41">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox41" name="satuan_lihat">
    <label for="checkbox41">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['satuan_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox42" name="satuan_tambah" checked=""> 
    <label for="checkbox42">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox42" name="satuan_tambah"> 
    <label for="checkbox42">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['satuan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox43" name="satuan_edit" checked="">
    <label for="checkbox43">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox43" name="satuan_edit">
    <label for="checkbox43">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['satuan_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox44" name="satuan_hapus" checked="">
    <label for="checkbox44">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox44" name="satuan_hapus">
    <label for="checkbox44">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas satuan -->




<div class="form-group col-sm-2"> <!-- start otoritas item -->
<label>Item</label><br>

<?php 

if ($data_otoritas['item_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox45" name="item_lihat" checked="">
    <label for="checkbox45">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox45" name="item_lihat">
    <label for="checkbox45">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['item_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox46" name="item_tambah" checked=""> 
    <label for="checkbox46">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox46" name="item_tambah"> 
    <label for="checkbox46">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['item_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox47" name="item_edit" checked="">
    <label for="checkbox47">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox47" name="item_edit">
    <label for="checkbox47">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['item_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox48" name="item_hapus" checked="">
    <label for="checkbox48">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox48" name="item_hapus">
    <label for="checkbox48">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas item -->


<div class="form-group col-sm-2"> <!-- start otoritas pemasukan -->
<label>Pemasukan</label><br>

<?php 

if ($data_otoritas['pemasukan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox49" name="pemasukan_lihat" checked="">
    <label for="checkbox49">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox49" name="pemasukan_lihat">
    <label for="checkbox49">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pemasukan_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox50" name="pemasukan_tambah" checked=""> 
    <label for="checkbox50">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox50" name="pemasukan_tambah"> 
    <label for="checkbox50">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['pemasukan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox51" name="pemasukan_edit" checked="">
    <label for="checkbox51">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox51" name="pemasukan_edit">
    <label for="checkbox51">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pemasukan_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox52" name="pemasukan_hapus" checked="">
    <label for="checkbox52">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox52" name="pemasukan_hapus">
    <label for="checkbox52">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas pemasukan -->

<div class="form-group col-sm-2"> <!-- start otoritas pengeluaran -->
<label>Pengeluaran</label><br>

<?php 

if ($data_otoritas['pengeluaran_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox53" name="pengeluaran_lihat" checked="">
    <label for="checkbox53">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox53" name="pengeluaran_lihat">
    <label for="checkbox53">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pengeluaran_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox54" name="pengeluaran_tambah" checked=""> 
    <label for="checkbox54">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox54" name="pengeluaran_tambah"> 
    <label for="checkbox54">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['pengeluaran_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox55" name="pengeluaran_edit" checked="">
    <label for="checkbox55">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox55" name="pengeluaran_edit">
    <label for="checkbox55">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pengeluaran_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox56" name="pengeluaran_hapus" checked="">
    <label for="checkbox56">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox56" name="pengeluaran_hapus">
    <label for="checkbox56">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas pengeluaran -->


<div class="form-group col-sm-2"> <!-- start otoritas komisi_faktur -->
<label>Komisi Faktur</label><br>

<?php 

if ($data_otoritas['komisi_faktur_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox57" name="komisi_faktur_lihat" checked="">
    <label for="checkbox57">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox57" name="komisi_faktur_lihat">
    <label for="checkbox57">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['komisi_faktur_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox58" name="komisi_faktur_tambah" checked=""> 
    <label for="checkbox58">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox58" name="komisi_faktur_tambah"> 
    <label for="checkbox58">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['komisi_faktur_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox59" name="komisi_faktur_edit" checked="">
    <label for="checkbox59">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox59" name="komisi_faktur_edit">
    <label for="checkbox59">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['komisi_faktur_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox60" name="komisi_faktur_hapus" checked="">
    <label for="checkbox60">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox60" name="komisi_faktur_hapus">
    <label for="checkbox60">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas komisi_faktur -->



<div class="form-group col-sm-2"> <!-- start otoritas komisi_produk -->
<label>Komisi Produk</label><br>

<?php 

if ($data_otoritas['komisi_produk_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox61" name="komisi_produk_lihat" checked="">
    <label for="checkbox61">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox61" name="komisi_produk_lihat">
    <label for="checkbox61">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['komisi_produk_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox62" name="komisi_produk_tambah" checked=""> 
    <label for="checkbox62">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox62" name="komisi_produk_tambah"> 
    <label for="checkbox62">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['komisi_produk_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox63" name="komisi_produk_edit" checked="">
    <label for="checkbox63">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox63" name="komisi_produk_edit">
    <label for="checkbox63">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['komisi_produk_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox64" name="komisi_produk_hapus" checked="">
    <label for="checkbox64">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox64" name="komisi_produk_hapus">
    <label for="checkbox64">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas komisi_produk -->









<div class="form-group col-sm-2"> <!-- start otoritas hak_otoritas -->
<label>Hak Otoritas</label><br>

<?php 

if ($data_otoritas['hak_otoritas_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox65" name="hak_otoritas_lihat" checked="">
    <label for="checkbox65">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox65" name="hak_otoritas_lihat">
    <label for="checkbox65">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['hak_otoritas_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox66" name="hak_otoritas_tambah" checked=""> 
    <label for="checkbox66">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox66" name="hak_otoritas_tambah"> 
    <label for="checkbox66">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['hak_otoritas_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox67" name="hak_otoritas_edit" checked="">
    <label for="checkbox67">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox67" name="hak_otoritas_edit">
    <label for="checkbox67">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['hak_otoritas_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox68" name="hak_otoritas_hapus" checked="">
    <label for="checkbox68">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox68" name="hak_otoritas_hapus">
    <label for="checkbox68">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas hak_otoritas -->
<div class="form-group col-sm-2"> <!-- start otoritas kategori -->
<label>Kategori</label><br>

<?php 

if ($data_otoritas['kategori_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox69" name="kategori_lihat" checked="">
    <label for="checkbox69">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox69" name="kategori_lihat">
    <label for="checkbox69">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kategori_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox70" name="kategori_tambah" checked=""> 
    <label for="checkbox70">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox70" name="kategori_tambah"> 
    <label for="checkbox70">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['kategori_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox71" name="kategori_edit" checked="">
    <label for="checkbox71">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox71" name="kategori_edit">
    <label for="checkbox71">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kategori_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox72" name="kategori_hapus" checked="">
    <label for="checkbox72">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox72" name="kategori_hapus">
    <label for="checkbox72">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kategori -->



<div class="form-group col-sm-2"> <!-- start otoritas gudang -->
<label>Gudang</label><br>

<?php 

if ($data_otoritas['gudang_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox73" name="gudang_lihat" checked="">
    <label for="checkbox73">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox73" name="gudang_lihat">
    <label for="checkbox73">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['gudang_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox74" name="gudang_tambah" checked=""> 
    <label for="checkbox74">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox74" name="gudang_tambah"> 
    <label for="checkbox74">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['gudang_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox75" name="gudang_edit" checked="">
    <label for="checkbox75">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox75" name="gudang_edit">
    <label for="checkbox75">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['gudang_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox76" name="gudang_hapus" checked="">
    <label for="checkbox76">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox76" name="gudang_hapus">
    <label for="checkbox76">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas gudang -->


<div class="form-group col-sm-2"> <!-- start otoritas grup_akun -->
<label>Group Akun</label><br>

<?php 

if ($data_otoritas['grup_akun_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox77" name="grup_akun_lihat" checked="">
    <label for="checkbox77">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox77" name="grup_akun_lihat">
    <label for="checkbox77">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['grup_akun_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox78" name="grup_akun_tambah" checked=""> 
    <label for="checkbox78">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox78" name="grup_akun_tambah"> 
    <label for="checkbox78">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['grup_akun_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox79" name="grup_akun_edit" checked="">
    <label for="checkbox79">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox79" name="grup_akun_edit">
    <label for="checkbox79">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['grup_akun_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox80" name="grup_akun_hapus" checked="">
    <label for="checkbox80">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox80" name="grup_akun_hapus">
    <label for="checkbox80">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas grup_akun -->




<div class="form-group col-sm-2"> <!-- start otoritas stok_awal -->
<label>Stok Awal</label><br>

<?php 

if ($data_otoritas['stok_awal_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox81" name="stok_awal_lihat" checked="">
    <label for="checkbox81">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox81" name="stok_awal_lihat">
    <label for="checkbox81">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['stok_awal_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox82" name="stok_awal_tambah" checked=""> 
    <label for="checkbox82">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox82" name="stok_awal_tambah"> 
    <label for="checkbox82">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['stok_awal_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox83" name="stok_awal_edit" checked="">
    <label for="checkbox83">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox83" name="stok_awal_edit">
    <label for="checkbox83">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['stok_awal_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox84" name="stok_awal_hapus" checked="">
    <label for="checkbox84">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox84" name="stok_awal_hapus">
    <label for="checkbox84">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas stok_awal -->

<div class="form-group col-sm-2"> <!-- start otoritas stok_opname -->
<label>Stok Opname</label><br>

<?php 

if ($data_otoritas['stok_opname_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox85" name="stok_opname_lihat" checked="">
    <label for="checkbox85">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox85" name="stok_opname_lihat">
    <label for="checkbox85">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['stok_opname_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox86" name="stok_opname_tambah" checked=""> 
    <label for="checkbox86">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox86" name="stok_opname_tambah"> 
    <label for="checkbox86">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['stok_opname_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox87" name="stok_opname_edit" checked="">
    <label for="checkbox87">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox87" name="stok_opname_edit">
    <label for="checkbox87">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['stok_opname_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox88" name="stok_opname_hapus" checked="">
    <label for="checkbox88">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox88" name="stok_opname_hapus">
    <label for="checkbox88">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas stok_opname -->


<div class="form-group col-sm-2"> <!-- start otoritas item_masuk -->
<label>Item Masuk</label><br>

<?php 

if ($data_otoritas['item_masuk_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox89" name="item_masuk_lihat" checked="">
    <label for="checkbox89">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox89" name="item_masuk_lihat">
    <label for="checkbox89">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['item_masuk_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox90" name="item_masuk_tambah" checked=""> 
    <label for="checkbox90">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox90" name="item_masuk_tambah"> 
    <label for="checkbox90">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['item_masuk_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox91" name="item_masuk_edit" checked="">
    <label for="checkbox91">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox91" name="item_masuk_edit">
    <label for="checkbox91">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['item_masuk_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox92" name="item_masuk_hapus" checked="">
    <label for="checkbox92">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox92" name="item_masuk_hapus">
    <label for="checkbox92">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas item_masuk -->

<div class="form-group col-sm-2"> <!-- start otoritas item_keluar -->
<label>Item Keluar</label><br>

<?php 

if ($data_otoritas['item_keluar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox93" name="item_keluar_lihat" checked="">
    <label for="checkbox93">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox93" name="item_keluar_lihat">
    <label for="checkbox93">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['item_keluar_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox94" name="item_keluar_tambah" checked=""> 
    <label for="checkbox94">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox94" name="item_keluar_tambah"> 
    <label for="checkbox94">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['item_keluar_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox95" name="item_keluar_edit" checked="">
    <label for="checkbox95">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox95" name="item_keluar_edit">
    <label for="checkbox95">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['item_keluar_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox96" name="item_keluar_hapus" checked="">
    <label for="checkbox96">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox96" name="item_keluar_hapus">
    <label for="checkbox96">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas item_keluar -->



<div class="form-group col-sm-2"> <!-- start otoritas daftar_akun -->
<label>Daftar Akun</label><br>

<?php 

if ($data_otoritas['daftar_akun_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox97" name="daftar_akun_lihat" checked="">
    <label for="checkbox97">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox97" name="daftar_akun_lihat">
    <label for="checkbox97">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['daftar_akun_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox98" name="daftar_akun_tambah" checked=""> 
    <label for="checkbox98">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox98" name="daftar_akun_tambah"> 
    <label for="checkbox98">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['daftar_akun_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox99" name="daftar_akun_edit" checked="">
    <label for="checkbox99">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox99" name="daftar_akun_edit">
    <label for="checkbox99">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['daftar_akun_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox100" name="daftar_akun_hapus" checked="">
    <label for="checkbox100">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox100" name="daftar_akun_hapus">
    <label for="checkbox100">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas daftar_akun -->




<div class="form-group col-sm-2"> <!-- start otoritas pembayaran_hutang -->
<label>Pembayaran Hutang</label><br>

<?php 

if ($data_otoritas['pembayaran_hutang_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox101" name="pembayaran_hutang_lihat" checked="">
    <label for="checkbox101">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox101" name="pembayaran_hutang_lihat">
    <label for="checkbox101">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pembayaran_hutang_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox102" name="pembayaran_hutang_tambah" checked=""> 
    <label for="checkbox102">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox102" name="pembayaran_hutang_tambah"> 
    <label for="checkbox102">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['pembayaran_hutang_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox103" name="pembayaran_hutang_edit" checked="">
    <label for="checkbox103">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox103" name="pembayaran_hutang_edit">
    <label for="checkbox103">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pembayaran_hutang_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox104" name="pembayaran_hutang_hapus" checked="">
    <label for="checkbox104">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox104" name="pembayaran_hutang_hapus">
    <label for="checkbox104">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas pembayaran_hutang -->


<div class="form-group col-sm-2"> <!-- start otoritas pembayaran_piutang -->
<label>Pembayaran Piutang</label><br>

<?php 

if ($data_otoritas['pembayaran_piutang_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox105" name="pembayaran_piutang_lihat" checked="">
    <label for="checkbox105">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox105" name="pembayaran_piutang_lihat">
    <label for="checkbox105">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pembayaran_piutang_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox106" name="pembayaran_piutang_tambah" checked=""> 
    <label for="checkbox106">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox106" name="pembayaran_piutang_tambah"> 
    <label for="checkbox106">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['pembayaran_piutang_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox107" name="pembayaran_piutang_edit" checked="">
    <label for="checkbox107">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox107" name="pembayaran_piutang_edit">
    <label for="checkbox107">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['pembayaran_piutang_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox108" name="pembayaran_piutang_hapus" checked="">
    <label for="checkbox108">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox108" name="pembayaran_piutang_hapus">
    <label for="checkbox108">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas pembayaran_piutang -->




<div class="form-group col-sm-2"> <!-- start otoritas kas_masuk -->
<label>Kas Masuk</label><br>

<?php 

if ($data_otoritas['kas_masuk_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox109" name="kas_masuk_lihat" checked="">
    <label for="checkbox109">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox109" name="kas_masuk_lihat">
    <label for="checkbox109">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_masuk_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox110" name="kas_masuk_tambah" checked=""> 
    <label for="checkbox110">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox110" name="kas_masuk_tambah"> 
    <label for="checkbox110">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_masuk_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox111" name="kas_masuk_edit" checked="">
    <label for="checkbox111">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox111" name="kas_masuk_edit">
    <label for="checkbox111">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_masuk_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox112" name="kas_masuk_hapus" checked="">
    <label for="checkbox112">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox112" name="kas_masuk_hapus">
    <label for="checkbox112">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kas_masuk -->


<div class="form-group col-sm-2"> <!-- start otoritas kas_keluar -->
<label>Kas Keluar</label><br>

<?php 

if ($data_otoritas['kas_keluar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox113" name="kas_keluar_lihat" checked="">
    <label for="checkbox113">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox113" name="kas_keluar_lihat">
    <label for="checkbox113">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_keluar_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox114" name="kas_keluar_tambah" checked=""> 
    <label for="checkbox114">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox114" name="kas_keluar_tambah"> 
    <label for="checkbox114">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_keluar_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox115" name="kas_keluar_edit" checked="">
    <label for="checkbox115">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox115" name="kas_keluar_edit">
    <label for="checkbox115">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_keluar_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox116" name="kas_keluar_hapus" checked="">
    <label for="checkbox116">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox116" name="kas_keluar_hapus">
    <label for="checkbox116">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kas_keluar -->

<div class="form-group col-sm-2"> <!-- start otoritas kas_mutasi -->
<label>Kas Mutasi</label><br>

<?php 

if ($data_otoritas['kas_mutasi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox117" name="kas_mutasi_lihat" checked="">
    <label for="checkbox117">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox117" name="kas_mutasi_lihat">
    <label for="checkbox117">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_mutasi_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox118" name="kas_mutasi_tambah" checked=""> 
    <label for="checkbox118">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox118" name="kas_mutasi_tambah"> 
    <label for="checkbox118">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_mutasi_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox119" name="kas_mutasi_edit" checked="">
    <label for="checkbox119">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox119" name="kas_mutasi_edit">
    <label for="checkbox119">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['kas_mutasi_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox120" name="kas_mutasi_hapus" checked="">
    <label for="checkbox120">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox120" name="kas_mutasi_hapus">
    <label for="checkbox120">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kas_mutasi -->







<div class="form-group col-sm-2"> <!-- start otoritas retur_penjualan -->
<label> Retur Penjualan</label><br>

<?php 

if ($data_otoritas['retur_penjualan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox121" name="retur_penjualan_lihat" checked="">
    <label for="checkbox121">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox121" name="retur_penjualan_lihat">
    <label for="checkbox121">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['retur_penjualan_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox122" name="retur_penjualan_tambah" checked=""> 
    <label for="checkbox122">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox122" name="retur_penjualan_tambah"> 
    <label for="checkbox122">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['retur_penjualan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox123" name="retur_penjualan_edit" checked="">
    <label for="checkbox123">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox123" name="retur_penjualan_edit">
    <label for="checkbox123">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['retur_penjualan_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox124" name="retur_penjualan_hapus" checked="">
    <label for="checkbox124">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox124" name="retur_penjualan_hapus">
    <label for="checkbox124">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas retur_penjualan -->

<div class="form-group col-sm-2"> <!-- start otoritas retur_pembelian -->
<label>Retur Pembelian</label><br>

<?php 

if ($data_otoritas['retur_pembelian_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox125" name="retur_pembelian_lihat" checked="">
    <label for="checkbox125">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox125" name="retur_pembelian_lihat">
    <label for="checkbox125">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['retur_pembelian_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox126" name="retur_pembelian_tambah" checked=""> 
    <label for="checkbox126">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox126" name="retur_pembelian_tambah"> 
    <label for="checkbox126">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['retur_pembelian_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox127" name="retur_pembelian_edit" checked="">
    <label for="checkbox127">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox127" name="retur_pembelian_edit">
    <label for="checkbox127">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['retur_pembelian_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox128" name="retur_pembelian_hapus" checked="">
    <label for="checkbox128">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox128" name="retur_pembelian_hapus">
    <label for="checkbox128">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas retur_pembelian -->


<div class="form-group col-sm-2"> <!-- start otoritas retur_pembelian -->
<label>Transaksi Jurnal</label><br>

<?php 

if ($data_otoritas['transaksi_jurnal_manual_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1251" name="transaksi_jurnal_manual_lihat" checked="">
    <label for="checkbox1251">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1251" name="transaksi_jurnal_manual_lihat">
    <label for="checkbox1251">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['transaksi_jurnal_manual_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1261" name="transaksi_jurnal_manual_tambah" checked=""> 
    <label for="checkbox1261">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1261" name="transaksi_jurnal_manual_tambah"> 
    <label for="checkbox1261">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['transaksi_jurnal_manual_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1271" name="transaksi_jurnal_manual_edit" checked="">
    <label for="checkbox1271">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1271" name="transaksi_jurnal_manual_edit">
    <label for="checkbox1271">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['transaksi_jurnal_manual_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1281" name="transaksi_jurnal_manual_hapus" checked="">
    <label for="checkbox1281">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1281" name="transaksi_jurnal_manual_hapus">
    <label for="checkbox1281">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas transaksi_jurnal_manual -->

<div class="form-group col-sm-2"> <!-- start otoritas / -->
<label>Daftar Pajak</label><br>

<?php 

if ($data_otoritas['daftar_pajak_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1322" name="daftar_pajak_lihat" checked="">
    <label for="checkbox1322">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1322" name="daftar_pajak_lihat">
    <label for="checkbox1322">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['daftar_pajak_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1332" name="daftar_pajak_tambah" checked="">
    <label for="checkbox1332">tambah</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1332" name="daftar_pajak_tambah">
    <label for="checkbox1332">tambah</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['daftar_pajak_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1321" name="daftar_pajak_edit" checked="">
    <label for="checkbox1321">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1321" name="daftar_pajak_edit">
    <label for="checkbox1321">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['daftar_pajak_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1334" name="daftar_pajak_hapus" checked="">
    <label for="checkbox1334">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox1334" name="daftar_pajak_hapus">
    <label for="checkbox1334">Hapus</label> <br>';  
}

 ?>
</div> <!-- /  -->


<div style="display: none" class="form-group col-sm-2"> <!-- start otoritas laporan_pemasukan_tanggal -->
<label>Laporan Pemasukan</label><br>

<?php 

if ($data_otoritas['laporan_pemasukan_tanggal_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pemasukan_tanggal_lihat" checked=""> Pertanggal <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pemasukan_tanggal_lihat"> Pertanggal <br>';  
}

if ($data_otoritas['laporan_pemasukan_rekap_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pemasukan_rekap_lihat" checked=""> Pemasukan Rekap <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pemasukan_rekap_lihat"> Pemasukan Rekap <br>';  
}

if ($data_otoritas['laporan_pemasukan_periode_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pemasukan_periode_lihat" checked=""> Perperiode <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pemasukan_periode_lihat"> Perperiode <br>';  
}

 ?>

</div> <!-- / of otoritas lap_pemasukan_tanggal, rekap $ perperiode -->

<div style="display: none" class="form-group col-sm-2"> <!-- start otoritas laporan_pengeluaran_tanggal -->
<label>Laporan Pengeluaran</label><br>

<?php 

if ($data_otoritas['laporan_pengeluaran_tanggal_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pengeluaran_tanggal_lihat" checked=""> Pertanggal <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pengeluaran_tanggal_lihat"> Pertanggal <br>';  
}

if ($data_otoritas['laporan_pengeluaran_rekap_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pengeluaran_rekap_lihat" checked=""> Rekap <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pengeluaran_rekap_lihat"> Rekap <br>';  
}

if ($data_otoritas['laporan_pengeluaran_periode_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pengeluaran_periode_lihat" checked=""> Perperiode <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2" name="laporan_pengeluaran_periode_lihat"> Perperiode <br>';  
}

 ?>

</div> <!-- / of otoritas lap_pemasukan_tanggal, rekap $ perperiode -->

<div class="form-group col-sm-2"> <!-- start otoritas laporan_komisi -->
<label>Laporan Komisi</label><br>

<?php 

if ($data_otoritas['laporan_komisi_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox129" name="laporan_komisi_lihat" checked=""> 
    <label for="checkbox129">Komisi</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox129" name="laporan_komisi_lihat"> 
    <label for="checkbox129">Komisi</label><br>';  
}

if ($data_otoritas['laporan_komisi_produk_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox130" name="laporan_komisi_produk_lihat" checked="">
    <label for="checkbox130"> Komisi / Produk</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox130" name="laporan_komisi_produk_lihat">
    <label for="checkbox130"> Komisi / Produk</label> <br>';  
}

if ($data_otoritas['laporan_komisi_faktur_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox131" name="laporan_komisi_faktur_lihat" checked="">
    <label for="checkbox131"> Komisi / Faktur</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox131" name="laporan_komisi_faktur_lihat">
    <label for="checkbox131"> Komisi / Faktur</label> <br>';  
}


?>

</div> <!-- / of otoritas lap_komisi -->


<div class="form-group col-sm-2"> <!-- start otoritas master BIAYA ADMIN -->
<label>Biaya Admin</label><br>

<?php 

if ($data_otoritas['biaya_admin_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2525" name="biaya_admin_lihat" checked="">
    <label for="checkbox2525">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2525" name="biaya_admin_lihat">
    <label for="checkbox2525">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['biaya_admin_tambah'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2626" name="biaya_admin_tambah" checked=""> 
    <label for="checkbox2626">Tambah</label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2626" name="biaya_admin_tambah"> 
    <label for="checkbox2626">Tambah</label><br>';  
}

 ?>

<?php 

if ($data_otoritas['biaya_admin_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2727" name="biaya_admin_edit" checked="">
    <label for="checkbox2727">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2727" name="biaya_admin_edit">
    <label for="checkbox2727">Edit</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['biaya_admin_hapus'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2828" name="biaya_admin_hapus" checked="">
    <label for="checkbox2828">Hapus</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox2828" name="biaya_admin_hapus">
    <label for="checkbox2828">Hapus</label> <br>';  
}

 ?>

</div> <!-- / of otoritas master BIAYA ADMIN -->

<div class="form-group col-sm-12">
    
</div>


 <div class="form-group col-sm-2"> <!-- start otoritas set_diskon_tax -->
<label>Diskon / Pajak</label><br>

<?php 

if ($data_otoritas['set_diskon_tax_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox132" name="set_diskon_tax_lihat" checked="">
    <label for="checkbox132">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox132" name="set_diskon_tax_lihat">
    <label for="checkbox132">Lihat</label> <br>';  
}

 ?>

<?php 

if ($data_otoritas['set_diskon_tax_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox133" name="set_diskon_tax_edit" checked="">
    <label for="checkbox133">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox133" name="set_diskon_tax_edit">
    <label for="checkbox133">Edit</label> <br>';  
}

 ?>

</div> <!-- / of otoritas set_diskon_tax -->


<div class="form-group col-sm-2"> <!-- start otoritas set_perusahaan -->
<label>Perusahaan</label><br>

<?php 

if ($data_otoritas['set_perusahaan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox134" name="set_perusahaan_lihat" checked="">
    <label for="checkbox134">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox134" name="set_perusahaan_lihat">
    <label for="checkbox134">Lihat</label> <br>';  
}


if ($data_otoritas['set_perusahaan_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox135" name="set_perusahaan_edit" checked="">
    <label for="checkbox135">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox135" name="set_perusahaan_edit">
    <label for="checkbox135">Edit</label> <br>';  
}

 ?>


</div> <!-- / of otoritas set_perusahaan -->

<div class="form-group col-sm-2"> <!-- start otoritas kas -->
<label>Kas</label><br>

<?php 

if ($data_otoritas['kas_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox136" name="kas_lihat" checked="">
    <label for="checkbox136">Lihat</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox136" name="kas_lihat">
    <label for="checkbox136">Lihat</label> <br>';  
}

 ?>

 <?php 

if ($data_otoritas['kas_edit'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox137" name="kas_edit" checked="">
    <label for="checkbox137">Edit</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox137" name="kas_edit">
    <label for="checkbox137">Edit</label> <br>';  
}

 ?>

</div> <!-- / of otoritas kas -->




<div class="form-group col-sm-2"> <!-- start otoritas cash_flow_tanggal -->
<label> Laporan Cash Flow</label><br>

<?php 

if ($data_otoritas['cash_flow_tanggal_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox138" name="cash_flow_tanggal_lihat" checked="">
    <label for="checkbox138">Pertanggal</label>  <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox138" name="cash_flow_tanggal_lihat">
    <label for="checkbox138">Pertanggal</label>  <br>';  
}

if ($data_otoritas['cash_flow_periode_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox139" name="cash_flow_periode_lihat" checked="">
    <label for="checkbox139">Perperiode</label>  <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox139" name="cash_flow_periode_lihat">
    <label for="checkbox139">Perperiode</label>  <br>';  
}

 ?>

</div> <!-- / of otoritas cash_flow_tanggal $ perperiode-->



<div class="form-group col-sm-2"> <!-- start otoritas laporan_retur_pembelian -->
<label>Laporan Retur</label><br>

<?php 

if ($data_otoritas['laporan_retur_pembelian_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox140" name="laporan_retur_pembelian_lihat" checked=""> 
    <label for="checkbox140">Retur Pembelian</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox140" name="laporan_retur_pembelian_lihat"> 
    <label for="checkbox140">Retur Pembelian</label> <br>';  
}

if ($data_otoritas['laporan_retur_penjualan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox141" name="laporan_retur_penjualan_lihat" checked=""> 
    <label for="checkbox141">Retur Penjualan </label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox141" name="laporan_retur_penjualan_lihat"> 
    <label for="checkbox141">Retur Penjualan </label><br>';  
}

?>

</div> <!-- / of otoritas lap_retur pembelian - retur  penjualan -->

<div class="form-group col-sm-12">
    
</div>

<div class="form-group col-sm-3"> <!-- start otoritas laporan_pembayaran_hutang -->
<label>Laporan Pembayaran</label><br>

<?php 

if ($data_otoritas['laporan_pembayaran_hutang_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox142" name="laporan_pembayaran_hutang_lihat" checked="">
    <label for="checkbox142">Pembayaran Hutang</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox142" name="laporan_pembayaran_hutang_lihat">
    <label for="checkbox142">Pembayaran Hutang</label> <br>';  
}

if ($data_otoritas['laporan_pembayaran_piutang_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox143" name="laporan_pembayaran_piutang_lihat" checked=""> 
    <label for="checkbox143">Pembayaran Piutang</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox143" name="laporan_pembayaran_piutang_lihat"> 
    <label for="checkbox143">Pembayaran Piutang</label> <br>';  
}

?>

</div> <!-- / of otoritas lap_retur pembelian - retur  penjualan -->



<div class="form-group col-sm-3"> <!-- start otoritas laporan_pembelian -->
<label>Laporan Pembelian & Penjualan</label><br>

<?php 

if ($data_otoritas['laporan_pembelian_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox144" name="laporan_pembelian_lihat" checked=""> 
    <label for="checkbox144">Laporan Pembelian</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox144" name="laporan_pembelian_lihat"> 
    <label for="checkbox144">Laporan Pembelian</label> <br>';  
}

if ($data_otoritas['laporan_penjualan_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox145" name="laporan_penjualan_lihat" checked=""> 
    <label for="checkbox145">Laporan Penjualan</label> <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox145" name="laporan_penjualan_lihat"> 
    <label for="checkbox145">Laporan Penjualan</label> <br>';  
}

?>

</div> <!-- / of otoritas lap_pembelian - penjualan -->


<div class="form-group col-sm-3"> <!-- start otoritas laporan_hutang_beredar -->
<label>Laporan Hutang & Piutang</label><br>

<?php 

if ($data_otoritas['laporan_hutang_beredar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox146" name="laporan_hutang_beredar_lihat" checked="">
    <label for="checkbox146">Hutang Beredar</label>  <br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox146" name="laporan_hutang_beredar_lihat">
    <label for="checkbox146">Hutang Beredar</label>  <br>';  
}

if ($data_otoritas['laporan_piutang_beredar_lihat'] == '1'){
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox147" name="laporan_piutang_beredar_lihat" checked=""> 
    <label for="checkbox147">Piutang Beredar </label><br>';
}

else{
    echo '<input type="checkbox" value="1" class="cekcbox filled-in" id="checkbox147" name="laporan_piutang_beredar_lihat"> 
    <label for="checkbox147">Piutang Beredar </label><br>';  
}

?>

</div> <!-- / of otoritas lap_hutangpembelian - piutang penjualan -->



<div class="form-group col-sm-12">
<button type="submit" class="btn btn-info" id="submit_tambah"><i class='fa fa-save'></i> Simpan</button>
</div>


</form>
</div>

<script type="text/javascript">
$(function() {
    $('.cekcbox1').click(function() {
        $('.cekcbox').prop('checked', this.checked);
    });
});
</script>

<?php include 'footer.php'; ?>