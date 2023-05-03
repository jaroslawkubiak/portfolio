<?php
$aktualny_rok = date('y', $time);

echo '<div class="text_duzy" align="center">Dodaj zamówienie do dostawcy</div>';

echo '<table width="1100px" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';

if($etap == 2)
	{
	if($naglowek == 'TAK')
		{
		//dodaje naglowek zamowienia
		$pytanie33 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'magazyn';");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$kolejny_nr_zamowienia=$wynik33['opis'];
			}
		$nowy_numer_zamowienia = $kolejny_nr_zamowienia."/".$aktualny_rok;
			
		$pytanie32 = mysqli_query($conn, "SELECT * FROM dostawcy WHERE id='".$klient."';");
		while($wynik32= mysqli_fetch_assoc($pytanie32))
			{
			$klient_nazwa = $wynik32['dostawca_nazwa'];
			}
		$data_zamowienia = date('d-m-Y', $time);
		$query = mysqli_query($conn, "INSERT INTO magazyn_zamowienia_naglowek (`klient_id`, `klient_nazwa`, `nr_zamowienia`, `data_zamowienia`, `data_zamowienia_time`, `utworzyl`, `status`) values ('$klient', '$klient_nazwa', '$nowy_numer_zamowienia', '$data_zamowienia', '$time', '$user_id', 'Niewysłane');");
		$zamowienie_id = mysqli_insert_id($conn);

		$kolejny_nr_zamowienia++;
		$pytanie122 = mysqli_query($conn, "UPDATE rozne SET opis = '".$kolejny_nr_zamowienia."' WHERE typ = 'magazyn';");
		}
	
	
	if($Dodaj == 'Dodaj')
		{
		//sprawdzamy ile jest pozycji w magazynie
		$ilosc_pozycji_na_magazynie = 0;
		$pytanie = mysqli_query($conn, "SELECT id FROM magazyn ORDER BY id DESC LIMIT 1;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc_pozycji_na_magazynie=$wynik['id'];
			}
			
		
		
		for($y=1; $y<=$ilosc_pozycji_na_magazynie; $y++)
			{
			if($nazwa_ilosc_do_zamowienia[$y] != '') $nazwa_ilosc_do_zamowienia[$y] = change($nazwa_ilosc_do_zamowienia[$y]);
			
			if(($nazwa_ilosc_do_zamowienia[$y] != '') && ($nazwa_ilosc_do_zamowienia[$y] != 0))
				{
				//echo 'dodaje ilosc dla '.$y.' = '.$nazwa_ilosc_do_zamowienia[$y].'<br>';
				//szukamy danych dla tego id z magazynu = y
				//echo '<div align="center" class="text_green">Pozycja dodana</div>';
				$pytanie373 = mysqli_query($conn, "SELECT * FROM magazyn WHERE id = ".$y.";");
				while($wynik373= mysqli_fetch_assoc($pytanie373))
					{
					$profil_temp=$wynik373['system'];
					$element_temp=$wynik373['element'];
					$kolor_temp=$wynik373['kolor'];
					$jednostka_temp=$wynik373['jednostka'];
					$kolor_uszczelek_temp=$wynik373['uszczelka'];
					$symbol_profilu_temp=$wynik373['symbol_profilu'];
					$symbol_koloru_temp=$wynik373['symbol_koloru'];
					$cena_netto_zakupu_zl_temp=$wynik373['cena_netto_zakupu_zl'];
					}
				
				$ilosc_do_zamowienia = change($nazwa_ilosc_do_zamowienia[$y]);
				$cena_netto_zakupu_zl_temp = change($cena_netto_zakupu_zl_temp);
				$wartosc_netto_temp = $ilosc_do_zamowienia * $cena_netto_zakupu_zl_temp;
				$wartosc_netto_temp = change($wartosc_netto_temp);
				$query = mysqli_query($conn, "INSERT INTO magazyn_zamowienia_pozycje (`zamowienie_id`, `nr_zamowienia`, `magazyn_pozycja_id`, `system`, `element`, `kolor`, `uszczelka`, `symbol_profilu`, `symbol_koloru`, `ilosc`, `cena_netto_zakupu_zl`, `wartosc_netto`, `jednostka`) values ('$zamowienie_id', '$nowy_numer_zamowienia', '$y', '$profil_temp', '$element_temp', '$kolor_temp', '$kolor_uszczelek_temp', '$symbol_profilu_temp', '$symbol_koloru_temp', '$ilosc_do_zamowienia', '$cena_netto_zakupu_zl_temp', '$wartosc_netto_temp', '$jednostka_temp');");
				}
			}
		} // if dodaj

	$system_zamowienie = [];
	$element_zamowienie = [];
	$kolor_zamowienie = [];
	$uszczelka_zamowienie = [];
	$jednostka_zamowienie = [];
	$symbol_profilu_zamowienie = [];
	$symbol_koloru_zamowienie = [];
	$cena_netto_zakupu_zl_zamowienie = [];
	$ilosc_zamowienie = [];
	$wartosc_netto_zamowienie = [];
	$cena_netto_zakupu_zl_zamowienie = [];
	$wartosc_netto_zamowienie = [];
	
	$ilosc_dodanych_pozycji = 0;
	$wartosc_zamowienia = 0;
	$pytanie373 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_pozycje WHERE nr_zamowienia ='".$nowy_numer_zamowienia."' ORDER BY id ASC;");
	while($wynik373= mysqli_fetch_assoc($pytanie373))
		{
		$ilosc_dodanych_pozycji++;
		$zamowienie_id = $wynik373['zamowienie_id'];
		$system_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['system'];
		$element_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['element'];
		$kolor_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['kolor'];
		$uszczelka_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['uszczelka'];
		$jednostka_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['jednostka'];
		$symbol_profilu_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['symbol_profilu'];
		$symbol_koloru_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['symbol_koloru'];
		$cena_netto_zakupu_zl_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['cena_netto_zakupu_zl'];
		$ilosc_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['ilosc'];
		$wartosc_netto_zamowienie[$ilosc_dodanych_pozycji]=$wynik373['wartosc_netto'];
		$wartosc_zamowienia += $wartosc_netto_zamowienie[$ilosc_dodanych_pozycji];
		$cena_netto_zakupu_zl_zamowienie[$ilosc_dodanych_pozycji] = number_format($cena_netto_zakupu_zl_zamowienie[$ilosc_dodanych_pozycji], 2,'.',' ');
		$wartosc_netto_zamowienie[$ilosc_dodanych_pozycji] = number_format($wartosc_netto_zamowienie[$ilosc_dodanych_pozycji], 2,'.',' ');
		}
	
	if($ilosc_dodanych_pozycji != 0)
		{
		// wyswietlamy już dodane pozycje
		echo '<table width="1200px" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="5%" valign="middle">'.$kol_lp.'</td>';
		echo '<td width="8%">System</td>';
		echo '<td width="8%">Element</td>';
		echo '<td width="8%">Kolor</td>';
		echo '<td width="8%">Uszczelka</td>';
		echo '<td width="8%">Symbol profilu</td>';
		echo '<td width="8%">Symbol koloru</td>';
		echo '<td width="8%">'.$kol_ilosc.'</td>';
		echo '<td width="8%">Cena netto zakupu zł</td>';
		echo '<td width="8%">'.$kol_wartosc_netto.'</td></tr>';
		
		for ($x=1; $x<=$ilosc_dodanych_pozycji; $x++)
			{
			echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
			echo '<td>'.$system_zamowienie[$x].'</td>';
			echo '<td>'.$element_zamowienie[$x].'</td>';
			echo '<td>'.$kolor_zamowienie[$x].'</td>';
			echo '<td>'.$uszczelka_zamowienie[$x].'</td>';
			echo '<td>'.$symbol_profilu_zamowienie[$x].'</td>';
			echo '<td>'.$symbol_koloru_zamowienie[$x].'</td>';
			echo '<td>'.$ilosc_zamowienie[$x].' '.$jednostka_zamowienie[$x].'</td>';
			echo '<td align="right">'.$cena_netto_zakupu_zl_zamowienie[$x].' '.$waluta.'</td>';
			echo '<td align="right">'.$wartosc_netto_zamowienie[$x].' '.$waluta.'</td></tr>';
			}
		echo '<tr><td colspan="8" bgcolor="white"></td>';
		$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET wartosc_netto = ".$wartosc_zamowienia." WHERE nr_zamowienia ='".$nowy_numer_zamowienia."';");
		$wartosc_zamowienia = number_format($wartosc_zamowienia, 2,'.',' ');
		echo '<td colspan="2" align="right" bgcolor="'.$kolor_tabeli.'" class="text">Wartość zamówienia : '.$wartosc_zamowienia.' '.$waluta.'&nbsp;&nbsp;&nbsp;</td>';

		echo '</table>';
		}
		
	if($Zapisz == 'Zapisz uwagi')
		{
		echo '<div align="center" class="text_duzy_niebieski">Uwagi zapisane.</div>';
		$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET uwagi = '".$uwagi."' WHERE id = ".$zamowienie_id.";");
		}
		
	//naglowek zamowienia
	echo '<FORM action="index.php?page=zamowienia_do_dostawcow_dodaj" method="post">';
	echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<INPUT type="hidden" name="etap" value="3">';
	echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
	echo '<INPUT type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';

	echo '<table width="100%" align="center" border="0" cellpadding="3"><tr class="text"><td width="30%" align="left">';
	echo '<img src="images/arcus_logo_mini.png" height="150px">';
	echo '</td>';
	
	// jezeli jest juz jakas pozycja mozemy dopisac uwagi
	if($ilosc_dodanych_pozycji != 0)
		{
		$pytanie1373 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek WHERE nr_zamowienia ='".$nowy_numer_zamowienia."' ORDER BY id ASC;");
		while($wynik1373= mysqli_fetch_assoc($pytanie1373))
			{
			$uwagi=$wynik1373['uwagi'];
			}
		echo '<td width="40%" align="center">Uwagi do zamówienia : <br><br>';
		echo '<textarea name="uwagi" cols="80" rows="5" class="pole_input_szare_ramka_uwagi">'.$uwagi.'</textarea><br><br>';
		echo '<input type="submit" name="Zapisz" value="Zapisz uwagi"><br><br>';
		echo $powrot_do_rejestru_zamowien_do_dostawcow_z_dodawania;
		echo '</td>';
	}
	
	
	echo '<td width="30%" class="text_sredni" align="right">';
	$pytanie32 = mysqli_query($conn, "SELECT * FROM dostawcy WHERE id='".$klient."';");
	while($wynik32= mysqli_fetch_assoc($pytanie32))
		{
		$klient_nazwa = $wynik32['dostawca_nazwa'];
		$klient_ulica = $wynik32['ulica'];
		$klient_miasto = $wynik32['miasto'];
		$klient_kod_pocztowy = $wynik32['kod_pocztowy'];
		}
	echo $klient_nazwa.'<br>';
	echo $klient_ulica.'<br>';
	echo $klient_kod_pocztowy.' '.$klient_miasto.'<br>';
	echo '</td></tr>';

	
	echo '<tr class="text"><td width="100%" align="left" colspan="2">Zamówienie nr '.$nowy_numer_zamowienia.'<br>Ilość dodanych pozycji '.$ilosc_dodanych_pozycji.'</td></tr>';

	include ("php/zamowienia_do_dostawcow_dodaj_magazyn.php");
	echo '</form>';
	echo '</table>';
	}


echo '</td></tr></table>';
?>