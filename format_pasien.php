<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=format_pasien.xls");
 
?>
<style>
tr:nth-child(even){background-color: #f2f2f2}
</style> 
<table id="tableuser" border="1">
		<thead>
			<th style='background-color: #4CAF50; color:white'> &nbsp;&nbsp;# &nbsp;&nbsp;</th>
			<th style='background-color: #4CAF50; color:white'> No. RM Lama </th>
			<th style='background-color: #4CAF50; color:white'> Nama Lengkap Pasien</th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Lahir Pasien</th>
			<th style='background-color: #4CAF50; color:white'> Alamat Tinggal Sekarang </th>
			<th style='background-color: #4CAF50; color:white'> No Handphone </th>
			<th style='background-color: #4CAF50; color:white'> Jenis Kelamin </th>
			
		</thead>
</table>