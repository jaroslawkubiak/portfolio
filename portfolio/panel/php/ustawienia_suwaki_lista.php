<?php
//tabela do mniejszych stron
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Suwaki</div><br>';


	echo '<table align="center" class="text" width="500px" cellpadding="5" cellspacing="5" border="0">';

		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_suwaki_sposob_dostawy"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Sposób dostawy</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_suwaki_sposob_platnosci"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Sposób płatności</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_suwaki_status_firmy"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Status firmy</div></a></td></tr>';
		// echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_suwaki_kierowcy"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Kierowcy - zlecenie transportowe</div></a></td></tr>';

	echo '</table>';

echo '</td></tr></table>';

?>