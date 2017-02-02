

<table border='1'>
<thead>
<th>
No Faktur Double
</th>
</thead>
<tbody>
<?php

include 'db.php';



$query = $db->query("SELECT no_faktur,count(*) as c FROM penjualan GROUP BY no_faktur having c > 1 order by c desc");

while($data = $query->fetch_array()){
	

	echo "<tr><td>".$data['no_faktur']."</td></tr>";

	
}



?>
</tbody>
</table>

