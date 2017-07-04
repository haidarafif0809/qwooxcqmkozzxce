
<div id="modal_logout" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: black">Konfirmasi LogOut</h4>
      </div>

      <div class="modal-body">
   
   <h3 style="color: black">Apakah Anda Yakin Ingin Keluar ?</h3>
 

     </div>

      <div class="modal-footer">
        <a href="logout.php"> <button class="btn btn-warning" ><i class="fa  fa-check "></i> Ya </button></a>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa  fa-close "></i> Batal</button>
      </div>
    </div>

  </div>
</div>

    <!--Double navigation-->
    <header>

        <!-- Sidebar navigation -->
        <ul id="slide-out" class="side-nav custom-scrollbar">

            <!-- Logo -->
            <li>
                <div class="logo-wrapper waves-light">
                    <a href="http://www.andaglos.id"><img src="save_picture/andaglos_logo.png" class="img-fluid flex-center"></a>
                </div>
            </li>
            <!--/. Logo -->

            <!--Social-->
            <li>
                <ul class="social">
                    <li><a class="icons-sm fb-ic" href="https://www.facebook.com/andaglos/?fref=ts"><i class="fa fa-facebook"> </i></a></li>
                    <li><a class="icons-sm gplus-ic" href="#"><i class="fa fa-google-plus"> </i></a></li>
                </ul>
            </li>
            <!--/Social-->

          
            <!-- Side navigation links -->
            <li>
                <ul class="collapsible collapsible-accordion">

<?php 
include 'db.php';

$pilih_akses_lihat = $db->query("SELECT ots.transfer_stok_lihat,open.menu_aps,open.menu_rawat_jalan,open.menu_rawat_inap,open.menu_ugd,open.menu_apotek,open.menu_laboratorium,open.penjualan_lihat, open.retur_lihat, open.retur_penjualan_lihat, opemb.pembelian_lihat, opemb.retur_pembelian_lihat, omd.master_data_lihat, omd.biaya_admin_lihat,omd.user_lihat, omd.satuan_lihat, omd.pelanggan_lihat, omd.jabatan_lihat, omd.suplier_lihat, omd.master_data_lihat, omd.item_lihat, omd.komisi_faktur_lihat, omd.komisi_produk_lihat, omd.set_perusahaan_lihat, omd.set_diskon_tax_lihat, omd.hak_otoritas_lihat, omd.kategori_lihat, omd.gudang_lihat, omd.daftar_akun_lihat, omd.grup_akun_lihat, omd.set_akun_lihat, omd.daftar_pajak_lihat, omd.poli_lihat, omd.kamar_lihat, omd.penjamin_lihat, omd.perujuk_lihat, omd.jenis_obat_lihat, omd.kelas_kamar_lihat,omd.ruangan_lihat,omd.ruangan_tambah,omd.ruangan_edit,omd.ruangan_hapus, omd.cito_lihat, omd.operasi_lihat, p.pembayaran_lihat, p.pembayaran_hutang_lihat, p.pembayaran_piutang_lihat, otk.transaksi_kas_lihat, okm.kas_masuk_lihat, okk.kas_keluar_lihat, okmu.kas_mutasi_lihat, op.persediaan_lihat, op.kartu_stok_lihat, oim.item_masuk_lihat, oik.item_keluar_lihat, osa.stok_awal_lihat, oso.stok_opname_lihat, okas.kas_lihat, olap.akuntansi_lihat, olap.laporan_mutasi_stok_lihat, olap.laporan_lihat, olap.buku_besar_lihat, olap.laporan_jurnal_lihat, olap.laporan_laba_rugi_lihat, olap.laporan_laba_kotor_lihat, olap.laporan_neraca_lihat, olap.transaksi_jurnal_manual_lihat, olap.cash_flow_tanggal_lihat, olap.cash_flow_periode_lihat, olap.laporan_komisi_lihat, olap.laporan_komisi_produk_lihat, olap.laporan_komisi_faktur_lihat, olap.laporan_pembelian_lihat, olap.laporan_hutang_beredar_lihat, olap.laporan_penjualan_lihat, olap.laporan_piutang_beredar_lihat, olap.laporan_retur_penjualan_lihat, olap.laporan_retur_pembelian_lihat, olap.laporan_pembayaran_hutang_lihat, olap.laporan_pembayaran_piutang_lihat, olap.laporan_kunjungan_rj,olap.laporan_laboratorium_lihat, olap.laporan_kunjungan_ri, olap.laporan_kunjungan_ugd, oreg.registrasi_rj_lihat, oreg.registrasi_ri_lihat, oreg.registrasi_ugd_lihat, oreg.registrasi_aps_lihat, oreg.registrasi_lihat, orm.rekam_medik_rj_lihat, orm.rekam_medik_ri_lihat, orm.rekam_medik_ugd_lihat, orm.rekam_medik_lihat, ose.setting_lihat, ose.setting_laboratorium_lihat, ose.setting_registrasi_lihat, ose.penetapan_petugas_lihat, ose.printer_lihat,ose.kamar_lihat,labo.laboratorium_lihat, labo.input_hasil_lab, ord.radiologi_lihat, ord.pemeriksaan_radiologi, ord.daftar_radiologi, ord.hasil_radiologi FROM hak_otoritas AS ho LEFT JOIN otoritas_penjualan AS open ON ho.id = open.id_otoritas LEFT JOIN otoritas_pembelian AS opemb ON ho.id = opemb.id_otoritas LEFT JOIN otoritas_master_data AS omd ON ho.id = omd.id_otoritas LEFT JOIN otoritas_pembayaran AS p ON ho.id = p.id_otoritas LEFT JOIN otoritas_transaksi_kas AS otk ON ho.id = otk.id_otoritas LEFT JOIN otoritas_kas_masuk AS okm ON ho.id = okm.id_otoritas LEFT JOIN otoritas_kas_keluar AS okk ON ho.id = okk.id_otoritas LEFT JOIN otoritas_kas_mutasi AS okmu ON ho.id = okmu.id_otoritas LEFT JOIN otoritas_persediaan AS op ON ho.id = op.id_otoritas LEFT JOIN otoritas_item_masuk AS oim ON ho.id = oim.id_otoritas LEFT JOIN otoritas_item_keluar AS oik ON ho.id = oik.id_otoritas LEFT JOIN otoritas_stok_awal AS osa ON ho.id = osa.id_otoritas LEFT JOIN otoritas_stok_opname AS oso ON ho.id = oso.id_otoritas LEFT JOIN otoritas_laporan AS olap ON ho.id = olap.id_otoritas LEFT JOIN otoritas_kas AS okas ON ho.id = okas.id_otoritas LEFT JOIN otoritas_registrasi oreg ON ho.id = oreg.id_otoritas LEFT JOIN otoritas_rekam_medik orm ON ho.id = orm.id_otoritas LEFT JOIN otoritas_setting ose ON ho.id = ose.id_otoritas LEFT JOIN otoritas_laboratorium labo ON ho.id = labo.id_otoritas LEFT JOIN otoritas_radiologi ord ON ho.id = ord.id_otoritas LEFT JOIN otoritas_transfer_stok ots ON ho.id = ots.id_otoritas WHERE ho.id = '$_SESSION[otoritas_id]'");



$lihat = mysqli_fetch_array($pilih_akses_lihat);

?>


<?php 

if ($lihat['registrasi_lihat'] > 0){
    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-hospital-o "></i> Registrasi <i class="fa fa-angle-down rotate-icon"></i></a>
    <div class="collapsible-body">
       <ul>';
}

if ($lihat['registrasi_rj_lihat'] > 0){
    echo '<li><a href="registrasi_raja.php" class="waves-effect"> Rawat Jalan </a></li>';
}

if ($lihat['registrasi_ri_lihat'] > 0){
    echo '<li><a href="rawat_inap.php" class="waves-effect"> Rawat Inap </a></li>';
}

if ($lihat['registrasi_ugd_lihat'] > 0){
    echo '<li><a href="registrasi_ugd.php" class="waves-effect"> UGD </a></li>';
}

if ($lihat['registrasi_aps_lihat'] > 0){
    echo '<li><a href="registrasi_laboratorium.php" class="waves-effect"> Laboratorium / Radiologi </a></li>';
}

if ($lihat['registrasi_lihat'] > 0){
    echo '</ul>
    </div>
</li>';
}

 ?>

<?php 

if ($lihat['rekam_medik_lihat'] > 0){
    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-medkit"></i> Rekam Medik <i class="fa fa-angle-down rotate-icon"></i></a>
    <div class="collapsible-body">
       <ul>';
}

if ($lihat['rekam_medik_rj_lihat'] > 0){
    echo '<li><a href="rekam_medik_raja.php" class="waves-effect"> Rawat Jalan </a></li>';
}

if ($lihat['rekam_medik_ri_lihat'] > 0){
    echo '<li><a href="rekam_medik_ranap.php" class="waves-effect"> Rawat Inap </a></li>';
}

if ($lihat['rekam_medik_ugd_lihat'] > 0){
    echo '<li><a href="rekam_medik_ugd.php" class="waves-effect"> UGD </a></li>';
}

if ($lihat['rekam_medik_lihat'] > 0){
    echo '</ul>
    </div>
</li>';
}

?>

<?php

if ($lihat['penjualan_lihat'] > 0){
    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-shopping-cart"></i> Penjualan <i class="fa fa-angle-down rotate-icon"></i></a>
    <div class="collapsible-body">
       <ul>';
}

if ($lihat['menu_rawat_jalan'] > 0){
        echo '<li><a href="form_penjualan_kasir.php" class="waves-effect"> Rawat Jalan</a></li>';
       }

if ($lihat['menu_rawat_inap'] > 0){
        echo ' <li><a href="form_penjualan_kasir_ranap.php" class="waves-effect"> Rawat Inap </a></li>';
    }

if ($lihat['menu_ugd'] > 0){
        echo ' <li><a href="form_penjualan_ugd.php" class="waves-effect">  UGD </a></li>';
    }

if ($lihat['menu_apotek'] > 0){
        echo '<li><a href="form_penjualan_kasir_apotek.php" class="waves-effect"> Apotek </a></li>';
    }

if ($lihat['menu_laboratorium'] > 0){
        echo '<li><a href="form_penjualan_lab.php"  class="waves-effect"> Laboratorium </a></li>';
    }


if ($lihat['menu_aps'] > 0){
    echo '<li><a href="form_penjualan_aps.php"  class="waves-effect"> Aps </a></li>';
    }

if ($lihat['penjualan_lihat'] > 0){           
       echo '</ul>
    </div
</li>';
}

if ($lihat['pembelian_lihat'] > 0){

                echo '<li><a href="pembelian.php" class="waves-effect"> <i class="fa fa-shopping-basket"></i> Pembelian </a></li>';
}

if ($lihat['master_data_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-server"></i> Master Data <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}
?>

<?php

if ($lihat['biaya_admin_lihat'] > 0){

        echo '<li><a href="biaya_admin.php" class="waves-effect">Biaya Admin</a></li>';
}
if ($lihat['user_lihat'] > 0){
                                echo '<li><a href="user.php" class="waves-effect">User</a></li>';
}


if ($lihat['poli_lihat'] > 0){
    echo '<li><a href="poli.php" class="waves-effect">Poli</a></li>';
}

if ($lihat['ruangan_lihat'] > 0){
    echo '<li><a href="form_ruangan.php" class="waves-effect" >Ruangan</a></li>';
}

if ($lihat['kamar_lihat'] > 0){
    echo '<li><a href="kamar.php" class="waves-effect">Kamar</a></li>';
}

if ($lihat['penjamin_lihat'] > 0){
    echo '<li><a href="penjamin.php" class="waves-effect">Penjamin</a></li>';
}

if ($lihat['perujuk_lihat'] > 0){
    echo '<li><a href="perujuk.php" class="waves-effect">Perujuk</a></li>';
}


?>

<?php

if ($lihat['jabatan_lihat'] > 0){                               
                                echo '<li><a href="jabatan.php" class="waves-effect">Jabatan</a></li>';
}

if ($lihat['hak_otoritas_lihat'] > 0){
                                echo '<li><a href="hak_otoritas.php" class="waves-effect">Otoritas</a></li>';
}

if ($lihat['suplier_lihat'] > 0){
                                echo '<li><a href="suplier.php" class="waves-effect">Suplier</a></li>';
}

if ($lihat['pelanggan_lihat'] > 0){
                                echo '<li><a href="pasien.php" class="waves-effect">Pasien</a></li>';
}

if ($lihat['item_lihat'] > 0){
                                echo '<li><a href="barang.php?kategori=semua&tipe=barang_jasa" class="waves-effect" >Produk</a></li>';
}

if ($lihat['jenis_obat_lihat'] > 0){
    echo '<li><a href="tambah_jenis_obat.php" class="waves-effect" >Jenis Obat</a></li>';
}
            
if ($lihat['kelas_kamar_lihat'] > 0){
    echo '<li><a href="kelas_kamar.php" class="waves-effect" >Kelas Kamar</a></li>';
}
            
if ($lihat['cito_lihat'] > 0){
    echo '<li><a href="cito.php" class="waves-effect" >Cito</a></li>';
}
            
if ($lihat['operasi_lihat'] > 0){
    echo '<li><a href="operasi.php" class="waves-effect" >Operasi</a></li>';
}
           

?>
   <li><a href="penyesuaian_stok.php" class="waves-effect" >Penyesuaian Stok</a></li>

<?php
if ($lihat['satuan_lihat'] > 0){
                                echo '<li><a href="satuan.php" class="waves-effect">Satuan</a></li>';
}

if ($lihat['kategori_lihat'] > 0){
                                echo '<li><a href="kategori_barang.php" class="waves-effect">Kategori</a></li>';
}

if ($lihat['komisi_produk_lihat'] > 0){
                                echo '<li><a href="fee_produk.php" class="waves-effect">Komisi Produk</a></li>';
}

if ($lihat['komisi_faktur_lihat'] > 0){
                                echo '<li><a href="fee_faktur.php" class="waves-effect">Komisi Faktur</a></li>';
}

if ($lihat['gudang_lihat'] > 0){
                                echo '<li><a href="gudang.php" class="waves-effect">Gudang</a></li>';
}

if ($lihat['daftar_akun_lihat'] > 0){
                                echo '<li><a href="daftar_akun.php?kategori=Aktiva" class="waves-effect">Daftar Akun</a></li>';
}

if ($lihat['grup_akun_lihat'] > 0){
                                echo '<li><a href="daftar_group_akun.php" class="waves-effect">Group Akun</a></li>';
}


/*
if ($lihat['daftar_pajak_lihat'] > 0){
                                echo '<li><a href="daftar_pajak.php" class="waves-effect">Daftar Pajak</a></li>';
}

*/

 
  if ($lihat['master_data_lihat'] > 0){                           
                          echo ' </ul>
                        </div>
                    </li>';
}


if ($lihat['pembayaran_lihat'] > 0){
                    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-credit-card"></i> Pembayaran <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

if ($lihat['pembayaran_hutang_lihat'] > 0){
                                echo '<li><a href="pembayaran_hutang.php" class="waves-effect">Hutang</a></li>';
}

 if ($lihat['pembayaran_piutang_lihat'] > 0){
                                echo '<li><a href="pembayaran_piutang.php" class="waves-effect">Piutang</a></li>';
}

 if ($lihat['pembayaran_lihat'] > 0){
                       echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['transaksi_kas_lihat'] > 0){
            echo '<li>
            <a class="collapsible-header waves-effect arrow-r"><i class="fa fa-credit-card"></i> Transaksi <i class="fa fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
                            <ul>';
}

 if ($lihat['kas_masuk_lihat'] > 0){
                                echo '<li><a href="kas_masuk.php" class="waves-effect">Kas Masuk</a></li>';
}

 if ($lihat['kas_keluar_lihat'] > 0){
                                echo '<li><a href="kas_keluar.php" class="waves-effect">Kas Keluar</a></li>';
}

 if ($lihat['kas_mutasi_lihat'] > 0){
                                echo '<li><a href="kas_mutasi.php" class="waves-effect">Kas Mutasi</a></li>';
}
 if ($lihat['transaksi_kas_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';

}
?>

<?php if ($lihat['persediaan_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-archive"></i> Persediaan <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

if ($lihat['kartu_stok_lihat'] > 0){
 echo '<li><a href="kartu_stok.php" class="waves-effect" style="font-size: 16px">Kartu Stok</a></li>';


 echo '<li><a href="kartu_stok_periode.php" class="waves-effect" style="font-size: 16px">Kartu Stok Per Periode</a></li>';
}

?>




<?php
 if ($lihat['item_lihat'] > 0){
                            echo '<li><a href="barang.php?kategori=semua&tipe=barang" class="waves-effect" style="font-size: 16px">Persediaan Barang</a></li>';
}

 if ($lihat['item_masuk_lihat'] > 0){
                            echo '<li><a href="item_masuk.php" class="waves-effect">Item Masuk</a></li>';
}

 if ($lihat['item_keluar_lihat'] > 0){
                            echo '<li><a href="item_keluar.php" class="waves-effect">Item Keluar</a></li>';
}

 if ($lihat['stok_awal_lihat'] > 0){
                            echo '<li><a href="stok_awal.php" class="waves-effect">Stok Awal</a></li>';
}

 if ($lihat['stok_opname_lihat'] > 0){
                            echo '<li><a href="stok_opname.php" class="waves-effect">Stok Opname</a></li>';
}

 if ($lihat['transfer_stok_lihat'] > 0){
                            echo '<li><a href="transfer_stok.php" class="waves-effect">Transfer Stok</a></li>';
}

 if ($lihat['laporan_mutasi_stok_lihat'] > 0){
                            echo '<li><a href="lap_mutasi_stok.php" class="waves-effect">Lap. Mutasi Stok</a></li>';
}

echo '<li><a href="cache_produk_penjualan.php" target="blank" class="waves-effect">Update Cache Produk</a></li>';
echo '<li><a href="update_cache_browser_barang.php" target="blank" class="waves-effect"> Cache Produk Offline</a></li>';
echo '<li><a href="cache_produk_lab.php" target="blank" class="waves-effect">Update Cache P.Lab</a></li>';
echo '<li><a href="cache_produk_obat.php" target="blank" class="waves-effect">Update Cache Obat Obatan</a></li>';
echo '<li><a href="cache_produk_tindakan.php" target="blank" class="waves-effect">Update Cache Tindakan</a></li>';
echo '<li><a href="cache_produk_radiologi.php" target="blank" class="waves-effect">Update Cache Radiologi</a></li>';

if ($lihat['persediaan_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['retur_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-exchange"></i> Retur <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

 if ($lihat['retur_penjualan_lihat'] > 0){
                            echo '<li><a href="retur_penjualan.php" class="waves-effect">Retur Penjualan</a></li>';
}

 if ($lihat['retur_pembelian_lihat'] > 0){
                            echo '<li><a href="retur_pembelian.php" class="waves-effect">Retur Pembelian</a></li>';
}

if ($lihat['retur_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['akuntansi_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-balance-scale"></i> Akuntansi <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}


 if ($lihat['buku_besar_lihat'] > 0){
                            echo '<li><a href="laporan_buku_besar.php" class="waves-effect">Buku Besar Per Periode</a></li>';
}

if ($lihat['buku_besar_lihat'] > 0){
                            echo '<li><a href="laporan_buku_besar_per_tanggal.php" class="waves-effect">Buku Besar Per Tanggal</a></li>';
}



if ($lihat['cash_flow_tanggal_lihat'] > 0){
                            echo '<li><a href="cashflow_tanggal.php" class="waves-effect">Cashflow Per Tanggal</a></li>';
}

 if ($lihat['cash_flow_periode_lihat'] > 0){
                            echo '<li><a href="cashflow_periode.php" class="waves-effect">Cashflow Per Periode</a></li>';
}


 if ($lihat['laporan_neraca_lihat'] > 0){
                            echo '<li><a href="laporan_neraca.php" class="waves-effect"> Neraca</a></li>';
}

 if ($lihat['laporan_laba_rugi_lihat'] > 0){
                            echo '<li><a href="lap_laba_rugi_penjualan.php" class="waves-effect"> Laba Rugi</a></li>';
}

 if ($lihat['laporan_laba_kotor_lihat'] > 0){
                            echo '<li><a href="lap_laba_kotor_penjualan.php" class="waves-effect"> Laba Kotor </a></li>';
}

 if ($lihat['laporan_jurnal_lihat'] > 0){
                            echo '<li><a href="laporan_jurnal_transaksi.php" class="waves-effect"> Jurnal Umum</a></li>';
}

 if ($lihat['transaksi_jurnal_manual_lihat'] > 0){
                            echo '<li><a href="transaksi_jurnal_manual.php" class="waves-effect">Jurnal</a></li>';
}

if ($lihat['akuntansi_lihat'] > 0){       
                        echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['laporan_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-book"></i> Laporan <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

echo '<li><a href="laporan_jumlah_pasien.php" class="waves-effect">Lap. Jumlah Pasien</a></li>';

if ($lihat['laporan_laboratorium_lihat'] > 0){
    echo '<li><a href="laporan_hasil_lab.php" class="waves-effect">Lap. Hasil Laboratorium</a></li>';
}

 if ($lihat['laporan_kunjungan_rj'] > 0){
    echo '<li><a href="lap_kunjungan_rj.php" class="waves-effect">Lap. Kunjungan R.Jalan</a></li>';
 }

 if ($lihat['laporan_kunjungan_ri'] > 0){
    echo '<li><a href="lap_kunjungan_ri.php" class="waves-effect">Lap. Kunjungan R.Inap </a></li>';
 }

 if ($lihat['laporan_kunjungan_ugd'] > 0){
    echo '<li><a href="lap_kunjungan_ugd.php" class="waves-effect">Lap. Kunjungan UGD</a></li>';
 }


?>

<?php
 if ($lihat['laporan_penjualan_lihat'] > 0){
                            echo '<li><a href="lap_penjualan.php" class="waves-effect">Lap. Penjualan</a></li>';
}

 if ($lihat['laporan_pembelian_lihat'] > 0){
                            echo '<li><a href="lap_pembelian.php" class="waves-effect">Lap. Pembelian</a></li>';
}

 if ($lihat['laporan_piutang_beredar_lihat'] > 0){
                            echo '<li><a href="laporan_penjualan_piutang.php" class="waves-effect">Lap. Piutang Beredar </a></li>';
}

 if ($lihat['laporan_hutang_beredar_lihat'] > 0){
                            echo '<li><a href="laporan_pembelian_hutang.php" class="waves-effect">Lap. Hutang Beredar</a></li>';
}

 if ($lihat['laporan_retur_penjualan_lihat'] > 0){
                            echo '<li><a href="lap_retur_penjualan.php" class="waves-effect">Lap. Retur Penjualan</a></li>';
}

 if ($lihat['laporan_retur_pembelian_lihat'] > 0){
                            echo '<li><a href="lap_retur_pembelian.php" class="waves-effect">Lap. Retur Pembelian</a></li>';
}

 if ($lihat['laporan_pembayaran_piutang_lihat'] > 0){
                            echo '<li><a href="lap_pembayaran_piutang.php" class="waves-effect" style="font-size: 15px">Lap. Pembayaran Piutang</a></li>';
}

 if ($lihat['laporan_pembayaran_hutang_lihat'] > 0){
                            echo '<li><a href="lap_pembayaran_hutang.php" class="waves-effect" style="font-size: 15px">Lap. Pembayaran Hutang</a></li>';
}

 if ($lihat['laporan_komisi_lihat'] > 0){
                            echo '<li><a href="lap_jumlah_fee.php" class="waves-effect">Lap. Komisi </a></li>';
}

 if ($lihat['laporan_komisi_produk_lihat'] > 0){
                            echo '<li><a href="laporan_fee_produk.php" class="waves-effect">Lap. Komisi / Produk</a></li>';
}

 if ($lihat['laporan_komisi_faktur_lihat'] > 0){
                            echo '<li><a href="laporan_fee_faktur.php" class="waves-effect">Lap. Komisi / Faktur </a></li>';
}

if ($lihat['laporan_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';
}

?>

<?php 
if ($lihat['setting_lihat'] > 0){
    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cogs"></i> Setting <i class="fa fa-angle-down rotate-icon"></i></a>
  <div class="collapsible-body">
     <ul>';
    }

if ($lihat['setting_laboratorium_lihat'] > 0){
        echo '<li><a href="setting_laboratorium.php" class="waves-effect">Laboratorium</a></li>';
     }

     if ($lihat['setting_registrasi_lihat'] > 0){
        echo '<li><a href="setting_registrasi.php" class="waves-effect">Registrasi</a></li>';
     }

          if ($lihat['kamar_lihat'] > 0){
        echo '<li><a href="setting_kamar.php" class="waves-effect">Proses Kamar</a></li>';
     }

     
     if ($lihat['penetapan_petugas_lihat'] > 0){
        echo '<li><a href="penetapan_petugas.php" class="waves-effect"> Penetapan Petugas</a></li>';
     }
     
     if ($lihat['printer_lihat'] > 0){
        echo '<li><a href="setting_printer.php" class="waves-effect"> Printer</a></li>';
     }
     


     if ($lihat['set_akun_lihat'] > 0){
            echo '<li><a href="setting_akun_data_item.php" class="waves-effect"> Akun</a></li>';
    }

    if ($lihat['set_perusahaan_lihat'] > 0){
            echo '<li><a href="setting_perusahaan.php" class="waves-effect"> Data Perusahaan</a></li>';
    }

    if ($lihat['set_diskon_tax_lihat'] > 0){
                                echo '<li><a href="set_diskon_tax.php" class="waves-effect"> Diskon Penjualan</a></li>';
    }

?>

     </ul>
  </div>
</li>

<?php 
if ($lihat['laboratorium_lihat'] > 0)
{ ?>

<li ><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-flask"></i>Laboratorium <i class="fa fa-angle-down rotate-icon"></i></a>
    <div class="collapsible-body">
       <ul>

<?php if ($lihat['input_hasil_lab'] > 0){ ?>
<li><a href="form_input_hasil_lab.php" class="waves-effect" >Input Hasil Laboratorium</a></li>
<?php } ?>



<li><a href="lab_bidang.php" class="waves-effect" >Kelompok Bidang</a></li>
<li><a href="jasa_lab.php" class="waves-effect" >Nama Pemeriksaan</a></li>
<li><a href="setup_hasil.php" class="waves-effect" >Parameter Laboratorium</a></li>
</ul>
    </div>
</li>

<?php } ?>

<?php 
if ($lihat['radiologi_lihat'] > 0) {
    echo '<li ><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-universal-access"></i>Radiologi <i class="fa fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
                <ul>';
}

if ($lihat['pemeriksaan_radiologi'] > 0) {
    echo '<li><a href="hasil_pemeriksaan_radiologi.php" class="waves-effect" >Hasil Radiologi</a></li>';
}

if ($lihat['daftar_radiologi'] > 0) {
    echo '<li><a href="daftar_pemeriksaan_radiologi.php" class="waves-effect" >Daftar Pemeriksaan</a></li>';
}

if ($lihat['hasil_radiologi'] > 0) {
    echo '<li><a href="form_pemeriksaan_radiologi.php" class="waves-effect" >Pemeriksaan Radiologi</a></li>';
}

if ($lihat['radiologi_lihat'] > 0) {
        echo '</ul>
        </div>
    </li>';
}
 ?>


<?php

 if ($lihat['kas_lihat'] > 0){
                echo '<li><a href="kas.php" class="waves-effect"> <i class="fa fa-money"></i> Posisi Kas </a></li>';
}
?>
                <li><a href="https://www.andaglos.id" class="waves-effect"> <i class="fa fa-envelope"></i> Contact Us </a></li>
                    


            </ul>
            </li>
            <!--/. Side navigation links -->

        </ul>
        <!-- Sidebar navigation -->


        <!--Navbar-->
        <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

            <!-- SideNav slide-out button -->
            <div class="pull-left">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
            </div>





          <?php 

      include_once 'db.php';
      
      $perusahaan = $db->query("SELECT nama_perusahaan FROM perusahaan ");
      $ambil_perusahaan = mysqli_fetch_array($perusahaan);


           ?>


            <div class="breadcrumb-dn">
                <p style="font-size: 100%"><?php echo $ambil_perusahaan['nama_perusahaan']; ?></p>
            </div>

            <ul class="nav navbar-nav pull-right">
        
        <li class="nav-item">
        <a class="nav-link" href="form_ubah_password.php"> Ubah Password</a>

        </li>

        <li class="nav-item ">
                    <a href="https://www.andaglos.id" class="nav-link"><i class="fa fa-envelope"></i> <span class="hidden-sm-down">Contact Us</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"><i class="fa fa-user"></i> <span class="hidden-sm-down"><?php echo $_SESSION['nama'];?></span>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" id="loguot"><i class="fa  fa-sign-out" data-toggle="modal" ></i> <span class="hidden-sm-down">LogOut</span>
                    </a>

                </li>
                
                
            </ul>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double navigation-->

    <main>