<?php
echo '<FORM id="przekatna" action="index.php?page=przekatna" method="post">';

	echo '<table width="300px" align="center" border="1" cellspacing="0" cellpadding="10" frame="box" rules="all">';
	echo '<tr class="text_duzy" bgcolor="#ffffff">';
	echo '<td width="70%" align="right">'.$wyraz_Szerokosc.'</td>';
	echo '<td width="30%" align="left"><input type="text" id="szerokosc" name="szerokosc" autocomplete="off" class="pole_input_biale_ramka" size="4" onkeyup="ObliczPrzekatna();"></td>';
	echo '</tr>';
	
	echo '<tr class="text_duzy" align="center" bgcolor="#ffffff">';
	echo '<td align="right">'.$wyraz_Wysokosc.'</td>';
	echo '<td align="left"><input type="text" id="wysokosc" name="wysokosc" autocomplete="off" class="pole_input_biale_ramka" size="4" onkeyup="ObliczPrzekatna();"></td>';
	echo '</tr>';
	
	echo '<tr class="text_duzy" align="center" bgcolor="#ffffff">';
	echo '<td align="right">Przekątna</td>';
	echo '<td align="left"><input type="text" id="przekatna" name="przekatna" autocomplete="off" size="4" class="pole_input_biale_bez_ramki" readonly="readonly"></td>';
	echo '</tr>';
	
	echo '</table>';

echo '</form>';
?>