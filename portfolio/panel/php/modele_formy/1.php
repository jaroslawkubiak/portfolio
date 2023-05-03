<table id="Tabela_01" width="801" height="533" border="0" cellpadding="0" cellspacing="0">
<tr><td colspan="5"><img src="php/modele_formy/model1/2_01.gif" width="800" height="93" alt=";"></td>
<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="93" alt=";"></td>
</tr><tr>
<?php

	echo '<td rowspan="3" align="center"><input type="text" id="wartosc1" name="wartosc1" autocomplete="off" class="pole_input_modele_right" size="2" value="'.$wartosc1.'">w1</td>';
	echo '<td colspan="3" rowspan="4"><img src="php/modele_formy/model1/2_03.gif" width="638" height="347" alt=";"></td>';
	echo '<td align="center"><input type="text" id="wysokosc" name="wysokosc" autocomplete="off" class="pole_input_modele_left" size="2" onkeyup="ObliczDlugoscLuku();" value="'.$wysokosc.'">w</td>';
	echo '<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="43" alt=";"></td></tr>';
	
	echo '<tr><td><img src="php/modele_formy/model1/2_05.gif" width="90" height="26" alt=";"></td>';
	echo '<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="26" alt=";"></td></tr>';
	
	echo '<tr><td align="center"><input type="text" id="wartosc2" name="wartosc2" autocomplete="off" class="pole_input_modele_left" size="2" value="'.$wartosc2.'">w2</td>';
	echo '<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="247" alt=";"></td></tr>';
	
	echo '<tr><td rowspan="3"><img src="php/modele_formy/model1/2_07.gif" width="72" height="124" alt=";"></td>';
	echo '<td rowspan="3"><img src="php/modele_formy/model1/2_08.gif" width="90" height="124" alt=";"></td>';
	echo '<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="31" alt=";"></td></tr>';
	
	echo '<tr><td rowspan="2"><img src="php/modele_formy/model1/2_09.gif" width="67" height="93" alt=";"></td>';
	echo '<td align="center"><input type="text" id="szerokosc" name="szerokosc" autocomplete="off" class="pole_input_modele_center" size="2" onkeyup="ObliczDlugoscLuku();" value="'.$szerokosc.'">s</td>';
	echo '<td rowspan="2"><img src="php/modele_formy/model1/2_11.gif" width="65" height="93" alt=";"></td>';
	echo '<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="26" alt=";"></td></tr>';

	$rama_metry_obliczona = ($dlugosc_luku + $szerokosc + $wartosc2 + $wartosc2)/1000; 	/// =(D31+L25+U16+U16)/1000
	$skrzydlo_metry_obliczona = ($dlugosc_luku + $szerokosc + $wartosc2 + $wartosc2 + $wartosc1 + $wartosc1)/1000;  //   =(D31+L25+U16+U16+F14+F14)/1000
	$listwa_metry_obliczona = ($dlugosc_luku)/1000; 	/// =D31/1000
	$slupek_metry_obliczona = ($wartosc1)/1000; 	/// =F14/1000
	$wzmocnienie_ramy_metry_obliczona = ($szerokosc + $wartosc2 + $wartosc2)/1000; 	/// =(L25+U16+U16)/1000
	$wzmocnienie_skrzydla_metry_obliczona = ($szerokosc + $wartosc2 + $wartosc2 + $wartosc1 + $wartosc1)/1000; 	/// =(L25+U16+U16+F14+F14)/1000
	$wzmocnienie_slupka_metry_obliczona = ($wartosc1)/1000; 	/// =F14/1000
	$wzmocnienie_luku_metry_obliczona = ($dlugosc_luku)/1000; 	/// =D31/1000
	$ilosc_zgrzanie_obliczone = 12; // zale¿ne od modelu

?>
<tr><td><img src="php/modele_formy/model1/2_12.gif" width="506" height="67" alt=";"></td>
<td><img src="php/modele_formy/model1/spacer.gif" width="1" height="67" alt=";"></td></tr></table>
