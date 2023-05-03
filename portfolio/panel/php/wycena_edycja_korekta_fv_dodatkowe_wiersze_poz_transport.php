<?php
	echo '<tr bgcolor="#98f3f0" align="center" height="'.$wysykosc_wiersza.'"><td>'.$x.'/'.$x.'</td>';
	echo '<td align="left" colspan="111" class="text"></td>';
	echo '<td align="center">'.$transport[$x].' '.$waluta.'</td>';
	echo '<td align="left" colspan="4" class="text"></td>';
	echo '<td align="center">'.$wartosc_netto[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$vat_baza[$x].'</td>';
	echo '<td align="center">'.$wartosc_brutto[$x].' '.$waluta.'</td>';
	echo '<td align="right">'.$nr_faktury[$x].'</td>';
	echo '<td align="right">'.$data_faktury[$x].'</td>';
	echo '<td align="left" class="text"></td></tr>';
?>