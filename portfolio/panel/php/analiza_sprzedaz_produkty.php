<?php
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="'.$page.'">';

if($SPRAWDZANY_ROK == "") $SPRAWDZANY_ROK = $AKTUALNY_ROK;
	echo '<table valign="top" align="center" border="0" cellspacing="3" cellpadding="3" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td width="100%">';
		echo 'Wybierz rok : ';
		echo '<select name="SPRAWDZANY_ROK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		for($x=2019; $x<=$AKTUALNY_ROK; $x++)
			{
			if ($x == $SPRAWDZANY_ROK) echo '<option value="'.$x.'" selected="selected">'.$x.'</option>';
			else echo '<option value="'.$x.'">'.$x.'</option>';
			}
		echo '</select>';
	echo '</td></tr></table><br>';


	$ilosc_grup = 0;
	$pytanie6 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'grupa_produktow' ORDER BY opis ASC;");
	while($wynik6= mysqli_fetch_assoc($pytanie6))
		{
		$ilosc_grup++;
		$grupa_opis[$ilosc_grup]=$wynik6['opis'];
		$grupa_id[$ilosc_grup]=$wynik6['id'];
		}

	$szer_rozne = '70px';
	$wysokosc_rozne = '30px';
	echo '<table valign="top" align="center" border="1" cellspacing="1" cellpadding="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" height="'.$wysokosc_rozne.'"><td width="20%">Produkt</td>';
	for($k=1; $k<=12; $k++) echo '<td width="'.$szer_rozne.'">'.$TABELA_MIESIECY[$k].'</td>';
	echo '</tr>';
	
	
	for($y=1; $y<=$ilosc_grup; $y++) 
		{
		$SUMA_GRUPA[$grupa_id[$y]][$mies] = 0;
		$ilosc_produktow = 0;
		$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' AND grupa = '".$grupa_opis[$y]."' ORDER BY opis ASC;");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$ilosc_produktow++;
			$produkt_id[$ilosc_produktow] = $wynik2['id'];
			$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
			$produkt_grupa[$ilosc_produktow] = $wynik2['grupa'];
			}

		for($x=1; $x<=$ilosc_produktow; $x++) 
			for($mies=1; $mies<=12; $mies++) 
				{
				$SUMA_PRODUKT[$produkt_id[$x]][$mies] = 0;
				$pytanie42 = mysqli_query($conn, "SELECT wartosc_netto FROM wyceny WHERE nazwa_produktu = '".$produkt_opis[$x]."' AND data_faktury_miesiac = '$mies' AND data_faktury_rok = '$SPRAWDZANY_ROK' AND korekta_fv = 'NIE';");
				while($wynik42= mysqli_fetch_assoc($pytanie42))
					{
					$SUMA_PRODUKT[$produkt_id[$x]][$mies] += $wynik42['wartosc_netto'];
					$SUMA_GRUPA[$grupa_id[$y]][$mies] += $wynik42['wartosc_netto'];
					}
				}
			
		echo '<tr align="center" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_szary.'" width="350px" align="left" class="text">'.$grupa_opis[$y].'</td>';
		for($mies=1; $mies<=12; $mies++) 
			{
			$SUMA_GRUPA[$grupa_id[$y]][$mies] = number_format($SUMA_GRUPA[$grupa_id[$y]][$mies], 2,'.',' ');
			echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_szary.'">'.$SUMA_GRUPA[$grupa_id[$y]][$mies].'</td>';
			}
		echo '</tr>'; 	
		
		for($x=1; $x<=$ilosc_produktow; $x++) 
			{
			echo '<tr align="center" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_bialy.'" width="350px" align="left">'.$produkt_opis[$x].'</td>';
			for($mies=1; $mies<=12; $mies++) 
				{
				$SUMA_PRODUKT[$produkt_id[$x]][$mies] = number_format($SUMA_PRODUKT[$produkt_id[$x]][$mies], 2,'.',' ');
				echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_bialy.'">'.$SUMA_PRODUKT[$produkt_id[$x]][$mies].'</td>';
				}
			echo '</tr>'; 		
			}
		}	

	echo '</table>';
echo '</form>';
?>