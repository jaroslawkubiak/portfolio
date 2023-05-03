<?php
echo '<table width="350px" align="center" border="0" cellspacing="0" cellpadding="0"><tr width="100%"><td>';
	echo '<FORM id="dlugosc_luku2" action="index.php?page=dlugosc_luku" method="post">';
		echo '<table width="330px" align="center" border="1" cellspacing="0" cellpadding="10" frame="box" rules="all">';
		echo '<tr class="text_duzy" bgcolor="#ffffff">';
		echo '<td width="70%" align="right">'.$wyraz_Szerokosc.' <font color="red">cm</font></td>';
		echo '<td width="30%" align="left"><input type="text" id="szerokosc" name="szerokosc" autocomplete="off" class="pole_input_biale_ramka" size="4" onkeyup="ObliczDlugoscLuku();"></td>';
		echo '</tr>';
		
		echo '<tr class="text_duzy" align="center" bgcolor="#ffffff">';
		echo '<td align="right">'.$wyraz_Wysokosc.' <font color="red">cm</font></td>';
		echo '<td align="left"><input type="text" id="wysokosc" name="wysokosc" autocomplete="off" class="pole_input_biale_ramka" size="4" onkeyup="ObliczDlugoscLuku();"></td>';
		echo '</tr>';
		
		echo '<tr class="text_duzy" align="center" bgcolor="#ffffff">';
		echo '<td align="right">'.$wyraz_Dlugosc_luku.' <font color="red">cm</font></td>';
		echo '<td align="left"><input type="text" id="dlugosc_luku" name="dlugosc_luku" autocomplete="off" size="4" class="pole_input_biale_bez_ramki" readonly="readonly"></td>';
		echo '</tr>';
		
		echo '<tr class="text_duzy" align="center" bgcolor="#ffffff">';
		echo '<td align="right">'.$wyraz_Promien.' <font color="red">cm</font></td>';
		echo '<td align="left"><input type="text" id="promien" name="promien" autocomplete="off" size="4" class="pole_input_biale_bez_ramki" readonly="readonly"></td>';
		echo '</tr>';
		
		echo '<tr align="center" bgcolor="#ffff00"><td colspan="2"><input type="text" id="luk" name="luk" autocomplete="off" class="pole_input_zolte_bez_ramki_duzy_tekst" readonly="readonly"></td></tr>';
		
		echo '</table>';
	echo '</form>';

echo '<div align="center" class="text_duzy_czerwony">Proszę wpisywać wartości w cm!</div>';
echo '</td></tr></table>';
?>