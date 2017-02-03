<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>DataTables live example</title>
<script type="text/javascript" charset="utf-8" src="DataTables/media/js/jquery.js"></script>
<script class="jsbin" src="http://datatables.net/download/build/jquery.dataTables.nightly.js"></script>
<style type="text/css">
  @import "DataTables/media/css/demo_table.css";
</style>
</head>
 <body id="dt_example">
<script>
$(document).ready(function() {
    $('#example').dataTable();
} );

$(document).ready( function() {
  $('#example').dataTable( {
   "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
     // Bold the grade for all 'A' grade browsers
     if ( aData[4] == "A" )
     {
       $('td:eq(4)', nRow).html( '<b>A</b>' );
     }
   }
 } );
 } );
    </script>

<div id="container">
  <h1>Live example</h1>

  <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
      <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>
      </tr>
    </thead>
    <tbody>
      <tr class="odd gradeX">
        <td>Trident</td>
        <td>Internet Explorer 4.0</td>
        <td>Win 95+</td>
        <td class="center"> 4</td>
        <td class="center">X</td>
      </tr>
      <tr class="even gradeC">
        <td>Trident</td>
        <td>Internet Explorer 5.0</td>
        <td>Win 95+</td>
        <td class="center">5</td>
        <td class="center">C</td>
      </tr>
      <tr class="odd gradeA">
        <td>Trident</td>
        <td>Internet Explorer 5.5</td>
        <td>Win 95+</td>
        <td class="center">5.5</td>
        <td class="center">A</td>
      </tr>
      <tr class="even gradeA">
        <td>Trident</td>
        <td>Internet Explorer 6</td>
        <td>Win 98+</td>
        <td class="center">6</td>
        <td class="center">A</td>
      </tr>
      <tr class="odd gradeA">
        <td>Trident</td>
        <td>Internet Explorer 7</td>
        <td>Win XP SP2+</td>
        <td class="center">7</td>
        <td class="center">A</td>
      </tr>
      <tr class="even gradeA">
        <td>Trident</td>
        <td>AOL browser (AOL desktop)</td>
        <td>Win XP</td>
        <td class="center">6</td>
        <td class="center">A</td>
      </tr>
      <tr class="gradeA">
        <td>Gecko</td>
        <td>Firefox 1.0</td>
        <td>Win 98+ / OSX.2+</td>
        <td class="center">1.7</td>
        <td class="center">A</td>
      </tr>
      <tr class="gradeA">
        <td>Gecko</td>
        <td>Firefox 1.5</td>
        <td>Win 98+ / OSX.2+</td>
        <td class="center">1.8</td>
        <td class="center">A</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>
      </tr>
    </tfoot>
  </table>
</div>
</body>
</html>