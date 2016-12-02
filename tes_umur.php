


<html>
<head><title>Mengitung Hari</title></head>
<body>
<center><h1>Menghitung Usia</h1></center>
<p>Gunakan fungsi dibawah ini untuk menghitung usia(dalam hari)</p>
<script language = "javascript">
<!--
function hitungUsia(){
    var sekarang = new Date();
    var tanggal = parseInt(document.forms[0].tanggal.value);
    var bulan = parseInt(document.forms[0].bulan.value)-1;
    var tahun = parseInt(document.forms[0].tahun.value);
    var tglLahir = new Date(tahun, bulan, tanggal);
    var selisih = (Date.parse(sekarang.toGMTString())-Date.parse(tglLahir.toGMTString()))/(1000*60*60*24);
    document.forms[0].usia.value = Math.floor(selisih);
    var kdHari = tglLahir.getDay();
    var namaHari = "";
    switch (kdHari){
        case 0 : namaHari = "Minggu"; break;
        case 1 : namaHari = "Senin"; break;
        case 2 : namaHari = "Selasa"; break;
        case 3 : namaHari = "Rabu"; break;
        case 4 : namaHari = "Kamis"; break;
        case 5 : namaHari = "Jumat"; break;
        case 6 : namaHari = "Saptu"; break;
           }
    document.forms[0].hari.value = namaHari;
       }
//-->
</script>
<form>
    Masukan Tanggal Lahir (1-31): <input type="text" name="tanggal" size="2" /><br/>
    Masukan Bulan Lahir (1-12): <input type="text" name="bulan" size="2" /><br/>
    Masukan Tahun Lahir (4 digit): <input type="text" name="tahun" size="4" /><br/>
    <input type="button" name="proses" value="proses" onClick="hitungUsia()"/><br />
    <hr>
    Anda lahir Hari: <input type="text" name="hari" /><br />
    Anda Berusia: <input type="text" name="usia" /><br/>
</form>
</body>
</html>