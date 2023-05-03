<?php
echo '<FORM id="dlugosc_luku2" action="index.php?page=dlugosc_luku" method="post">';

	echo '<table align="left" border="1" cellspacing="0" cellpadding="5" frame="box" rules="all">';
	echo '<tr class="text" bgcolor="#ffffff">';
	echo '<td width="90px" align="right">'.$wyraz_Szerokosc.' <font color="red">cm</font></td>';
	echo '<td width="50px" align="left"><input type="text" id="szerokosc" name="szerokosc" autocomplete="off" class="pole_input_biale_ramka" size="4" onkeyup="ObliczDlugoscLuku();"></td>';

	echo '<td width="90px" align="right">'.$wyraz_Wysokosc.' <font color="red">cm</font></td>';
	echo '<td width="50px" align="left"><input type="text" id="wysokosc" name="wysokosc" autocomplete="off" class="pole_input_biale_ramka" size="4" onkeyup="ObliczDlugoscLuku();"></td>';

	echo '<td width="100px" align="right">'.$wyraz_Dlugosc_luku.' <font color="red">cm</font></td>';
	echo '<td width="50px" align="left"><input type="text" id="dlugosc_luku" name="dlugosc_luku" autocomplete="off" size="4" class="pole_input_biale_bez_ramki" readonly="readonly"></td>';

	echo '<td width="90px" align="right">'.$wyraz_Promien.' <font color="red">cm</font></td>';
	echo '<td width="50px" align="left"><input type="text" id="promien" name="promien" autocomplete="off" size="4" class="pole_input_biale_bez_ramki" readonly="readonly"></td>';

	echo '<td width="200px" bgcolor="#ffff00" align="center"><input type="text" id="luk" name="luk" autocomplete="off" class="pole_input_zolte_bez_ramki_duzy_tekst" readonly="readonly"></td></tr>';
	echo '</table>';

echo '</form><br><br>';
?>