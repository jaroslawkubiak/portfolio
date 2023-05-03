<?php
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="'.$page.'">';


if($SPRAWDZANY_ROK == '')  $SPRAWDZANY_ROK = $AKTUALNY_ROK;

$system_profili_opis = array();
$system_profili_id = array();

$ilosc_profili = 0;
$pytanie13 = mysqli_query($conn, "SELECT id, opis FROM suwaki WHERE typ = 'profil' ORDER BY opis ASC;");
while($wynik13 = mysqli_fetch_assoc($pytanie13))
	{
		$ilosc_profili++;
		$system_profili_opis[$ilosc_profili] = $wynik13['opis'];
		$system_profili_id[$ilosc_profili] = $wynik13['id'];
		$wartosc[$system_profili_id[$ilosc_profili]] = 0;
	}


	$pytanie1 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE data_wystawienia_rok = '".$SPRAWDZANY_ROK."';");
	while($wynik1 = mysqli_fetch_assoc($pytanie1))
		{
		$zamowienie_id = $wynik1['zamowienie_id'];
		$wartosc_netto_fv = $wynik1['wartosc_netto_fv'];
		
		$pytanie13 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id=".$zamowienie_id.";");
		while($wynik13 = mysqli_fetch_assoc($pytanie13))
			{
			$system_profili = $wynik13['system_profili'];
			}

		for($m=1; $m<=$ilosc_profili; $m++)
			if($system_profili == $system_profili_opis[$m]) $wartosc[$system_profili_id[$m]] += $wartosc_netto_fv;

		}
	

	echo '<table valign="top" align="center" border="0" cellspacing="5" cellpadding="5" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td width="100%">Wybierz rok : ';
	echo '<select name="SPRAWDZANY_ROK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	for($x= 1; $x<= $DLUGOSC_TABELA_LISTA_LAT_WYCENA_DANE; $x++) 
		{
		if ($TABELA_LISTA_LAT_WYCENA_DANE[$x] == $SPRAWDZANY_ROK) echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'" selected="selected">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
		else echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
		}
	echo '</select>';
	echo '</td></tr></table><br>';


	echo '<table width="400px" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
	echo '<td width="60%">System</td>';
	echo '<td width="40%">'.$wyraz_Wartosc.' faktur</td></tr>';
	
		for ($x=1; $x<=$ilosc_profili; $x++)
			{
			echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'">';
			echo '<td>'.$system_profili_opis[$x].'</td>';
			$wartosc[$system_profili_id[$x]] = number_format($wartosc[$system_profili_id[$x]], 2,'.',' ');
			echo '<td align="right">'.$wartosc[$system_profili_id[$x]].' zł</td></tr>';
			}
	echo '</table>';


echo '</form>';

?>