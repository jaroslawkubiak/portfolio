<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';


$j=0;
$opis = [];
$kolumna = [];

$pytanie = mysqli_query($conn, "SELECT * FROM jpk_vat ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$j++;
	$opis[$j]=$wynik['opis'];
	$kolumna[$j]=$wynik['kolumna'];
	}
	

echo '<table border="0" align="center" width="100%" bgcolor="'.$kolor_bialy.'" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr class="text" align="center" bgcolor="'.$kolor_tabeli.'"><td>Kolumna<br>w pliku<br>JPK VAT</td>';
	echo '<td>Opis</td></tr>';

for($x = 1; $x<=$j; $x++)
	{
	echo '<tr class="text" align="center"><td>'.$kolumna[$x].'</td>';
	echo '<td align="left">'.$opis[$x].'</td></tr>';
	}


echo '</table>';

echo '</td></tr></table>';

?>