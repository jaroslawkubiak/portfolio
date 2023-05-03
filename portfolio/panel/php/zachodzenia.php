<?php
//tabela do mniejszych stron
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
echo '<div class="text_duzy" align="center">Zachodzenia</div><br>';

	if($usun_id != '')
		{
		mysqli_query($conn, "DELETE FROM zachodzenia WHERE id = ".$usun_id." LIMIT 1;");
		echo '<div align="center" class="text_duzy_niebieski">Wpis usunięty</div><br>';
		}
		

	$id = [];
	$artykul = [];
	$zachodzenie = [];
		
	$i=0;
	if($szukaj != '') $pytanie = mysqli_query($conn, "SELECT * FROM zachodzenia WHERE artykul LIKE '%".$szukaj."%' ORDER BY ".$wg_czego." ".$jak.";");
	else $pytanie = mysqli_query($conn, "SELECT * FROM zachodzenia ORDER BY ".$wg_czego." ".$jak.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$id[$i]=$wynik['id'];
		$artykul[$i]=$wynik['artykul'];
		$zachodzenie[$i]=$wynik['zachodzenie'];
		}

	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="zachodzenia">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                

	echo '<table width="80%" align="center" border="0" cellpadding="3"><tr><td width="100%" align="right" valign="top">';
		// guzik dodaj nowe zachodzenie
		echo '<table width="200px" align="right" border="0" cellpadding="1" cellspacing="1"><tr class="text"><td width="100%" align="right" valign="middle">';
			echo '<a href="index.php?page=zachodzenia_dodaj&jak=DESC&wg_czego=id">'.$image_plusik.'</a>';
		echo '</td><td>';
			echo '<a href="index.php?page=zachodzenia_dodaj&jak=DESC&wg_czego=id">Dodaj</a>';
		echo '</td></tr></table>';

	echo '</td></tr><tr><td>';
		echo '<table width="100%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		if($szukaj != '') echo '<td width="5%">'.$kol_lp.'<br><a href="index.php?page=zachodzenia&jak=DESC&wg_czego=id">'.$image_close.'</a></td>';
		else echo '<td width="5%">'.$kol_lp.'</td>';

		echo '<td width="20%">Artykuł';
			echo '<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr valign="bottom">';
			echo '<td align="right" valign="bottom" width="20%">&nbsp;</td>';
			echo '<td>';
				echo '<table border="0" width="100%" cellspacing="0" cellpadding="0" valign="bottom"><tr valign="bottom">';
				echo '<td align="right" valign="bottom" width="20%">&nbsp;</td>';
				echo '<td width="40%"><input type="text" id="szukaj" autocomplete="off" size="20" class="pole_input_sortowanie" name="szukaj" value="'.$szukaj.'"></td>';
				echo '<td align="left"><INPUT type="image" name="submit" src="images/search_black.png"></td></tr>';
				echo '</table>';
			echo '</td>';
			echo '<td width="20%" align="right">&nbsp;<a href="index.php?page=zachodzenia&jak=DESC&wg_czego=artykul&szukaj='.$szukaj.'">'.$image_arrow_down.'</a><a href="index.php?page=zachodzenia&jak=ASC&wg_czego=artykul&szukaj='.$szukaj.'">'.$image_arrow_up.'</a></td></tr>';
			echo '</table>';
		echo '</td>';


		echo '<td width="20%">Zachodzenie (mm)</td>';
		echo '<td width="5%">Usuń</td></tr>';

		for ($x=1; $x<=$i; $x++)
			{
			echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
			echo '<td><a href="index.php?page=zachodzenia_edycja&id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$artykul[$x].'</a></td>';
			echo '<td>'.$zachodzenie[$x].' mm</td>';
			echo '<td><a href="index.php?page=zachodzenia&usun_id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_delete.'</a></td>';
			echo '</tr>';
			}
		echo '</table>';
	echo '</td></tr></table>';
echo '</form>';

echo '</td></tr></table>';


?>