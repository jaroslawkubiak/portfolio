<?php
//tabela do mniejszych stron
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

if($submit)
{
	if($zachodzenie == '') $zachodzenie = 0;
	$query = "INSERT INTO zachodzenia (`artykul`, `zachodzenie`) values ('$artykul', '$zachodzenie');";
	mysqli_query($conn, $query);
	
	echo '<div class="text_duzy_niebieski" align="center">Wpis został dodany</div>';
	echo '<br><div class="text_duzy_niebieski" align="center"><a href="index.php?page=zachodzenia_dodaj&jak=DESC&wg_czego=id">Dodaj kolejny</a></div>';
	
	echo $powrot_do_zachodzenia;
}

else
	{
	$i=0;
	$symbol_profilu = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM magazyn ORDER BY id ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$symbol_profilu[$i]=$wynik['symbol_profilu'];
		}
		

	$symbol_profilu2 = array_unique($symbol_profilu);
	$symbol_profilu_opis = array_values(array_filter($symbol_profilu2));
	sort ($symbol_profilu_opis);
	$ilosc_symboli_profili = count($symbol_profilu_opis);


	echo '<div class="text_duzy" align="center">Dodaj pozycję zachodzenia</div>';
	echo '<table width="50%" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';
	echo '<FORM action="index.php?page=zachodzenia_dodaj" method="post">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';

		echo '<table width="100%" align="center" border="0" cellpadding=3>';
		
		echo '<tr align="center"><td align="right" class="text">Symbol profilu : </td><td align="left">';
			echo '<select name="artykul" class="pole_input" style="width: 200px">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_symboli_profili-1; $k++) 
				if ($symbol_profilu_opis[$k] == $SORT_SYMBOL_PROFILU) echo '<option value="'.$symbol_profilu_opis[$k].'" selected="selected">'.$symbol_profilu_opis[$k].'</option>';
				else echo '<option value="'.$symbol_profilu_opis[$k].'">'.$symbol_profilu_opis[$k].'</option>';
			echo '</select>';
		echo '</td></tr>';		
		
		echo '<tr align="center"><td align="right" class="text">Zachodzenie (mm) : </td><td align="left"><input autocomplete="off" type="text" size="5" maxlength="10" class="pole_input" name="zachodzenie" value="'.$zachodzenie.'"></td></tr>';
		
		echo '<tr class="Text"><td align="center" colspan=2>';
		echo '<INPUT type="submit" name="submit" value="Dodaj">';
		echo '</td></tr></table>';
	echo '</FORM>';
	echo '</td></tr></table>';
	echo $powrot_do_zachodzenia;
}

echo '</td></tr></table>';

?>