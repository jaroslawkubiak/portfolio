<?php
if($usunac != '')
	{
	mysqli_query($conn, "DELETE FROM oferta_indywidualna WHERE id = ".$usunac." LIMIT 1");
	echo '<div align="center" class="text_duzy_niebieski">Oferta została usunięta.</div><br><br>';
	}

if($usun != '')	
	{
	$pytanie2 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna WHERE id = ".$usun.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$oferta_usun_data=$wynik2['data'];
		$oferta_usun_klient_nazwa=$wynik2['klient_nazwa'];
		}
	echo '<div align="center" class="text_duzy">Czy na pewno usunąć ofertę dla <font color="blue">'.$oferta_usun_klient_nazwa.'</font> z dnia <font color="blue">'.$oferta_usun_data.'</font>?</div><br><br>';
	echo '<div align="center"><a href="index.php?page=oferty_wychodzace&usunac='.$usun.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="red" size="+2">USUŃ</font></a></div><br><br>';
	}


$warunek = "";
if($SORT_KLIENT_NAZWA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	else $warunek .= ' AND klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	}          
if($SORT_DATA_PRZYJECIA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE data = "'.$SORT_DATA_PRZYJECIA.'"';
	else $warunek .= ' AND data = "'.$SORT_DATA_PRZYJECIA.'"';
	}        
if($SORT_TYTUL_OFERTY != "") 
	{
	if($warunek == "") $warunek .= 'WHERE tytul_oferty = "'.$SORT_TYTUL_OFERTY.'"';
	else $warunek .= ' AND tytul_oferty = "'.$SORT_TYTUL_OFERTY.'"';
	}        

$SORTOWANIE_DIV = '&pokaz='.$pokaz.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_TYTUL_OFERTY='.$SORT_TYTUL_OFERTY.'';



$ilosc_ofert = 0;
$pytanie2 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$ilosc_ofert++;
	$oferta_id[$ilosc_ofert]=$wynik2['id'];
	$oferta_klient_id[$ilosc_ofert]=$wynik2['klient_id'];
	$oferta_klient_nazwa[$ilosc_ofert]=$wynik2['klient_nazwa'];
	
	$oferta_tytul[$ilosc_ofert]=$wynik2['tytul_oferty'];
	//szukam zaczonych plikw do oferty
	$ilosc_plikow_oferta[$oferta_id[$ilosc_ofert]] = 0;
	$pytanie77 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_wyslane_pliki WHERE oferta_id = ".$oferta_id[$ilosc_ofert].";");
	while($wynik77= mysqli_fetch_assoc($pytanie77))
		{
		$ilosc_plikow_oferta[$oferta_id[$ilosc_ofert]]++;
		$wyslany_plik_id[$oferta_id[$ilosc_ofert]][$ilosc_plikow_oferta[$oferta_id[$ilosc_ofert]]]=$wynik77['plik_id'];
		}
	
	//szukam imie i nazwisko usera ktry wysa ofert
	$oferta_user_id[$ilosc_ofert]=$wynik2['user_id'];
	$pytanie177 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$oferta_user_id[$ilosc_ofert].";");
	while($wynik177= mysqli_fetch_assoc($pytanie177))
		{
		$oferta_user_imie[$ilosc_ofert]=$wynik177['imie'];
		$oferta_user_nazwisko[$ilosc_ofert]=$wynik177['nazwisko'];
		}		
	$oferta_data[$ilosc_ofert]=$wynik2['data'];
	$oferta_email[$ilosc_ofert]=$wynik2['email'];
	}

	$ilosc_kolumn = 5;
	$szerokosc_kolumny = 100/$ilosc_kolumn;		

	//#################################################### pobieram dane do sortowania  ####################################################
	$ilosc_klientow = 0;
	$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC");
	while($wynik24= mysqli_fetch_assoc($pytanie24))
		{
		$ilosc_klientow++;
		$KLIENT_NAZWA[$ilosc_klientow] = $wynik24['nazwa'];
		}
		
	
	$ilosc_data_przyjecia = -1;
	$result = mysqli_query($conn, "SELECT DISTINCT data FROM oferta_indywidualna ORDER BY data_time DESC");
	while ($a_row = mysqli_fetch_assoc($result) )
		{
		$ilosc_data_przyjecia++;
		$DATA_PRZYJECIA[$ilosc_data_przyjecia] = $a_row['data'];
		}
	//sort ($DATA_PRZYJECIA);
	
	$ilosc_tytul = -1;
	$result = mysqli_query($conn, "SELECT DISTINCT tytul_oferty FROM oferta_indywidualna WHERE tytul_oferty <> '' ORDER BY id ASC");
	while ($a_row = mysqli_fetch_assoc ($result) )
		{
		$ilosc_tytul++;
		$TYTUL_OFERTY[$ilosc_tytul] = $a_row['tytul_oferty'];
		}
	sort ($TYTUL_OFERTY);
	//############################################################################################################################################
			
	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="pokaz" value="1">';        

	echo '<table border="0" width="100%" class="tabela" align="center">';
	echo '<tr class="text" align="center" bgcolor="'.$kolor_tabeli.'">';

	if($pokaz == 1) echo '<td width="2%" valign="middle">'.$kol_lp.'<br>'.$ilosc_ofert.'<br><a href="index.php?page=oferty_wychodzace&jak=DESC&wg_czego=id">'.$image_close.'</a></td>';
	else echo '<td  width="2%" valign="middle">'.$kol_lp.'<br>'.$ilosc_ofert.'</td>';

	// kol nazwa klienta
	echo '<td width="10%">';
		echo '<table width="100%" align="center" border="0" class="text" cellspacing="0" cellpadding="0"><tr><td width="20%"></td><td width="60%" align="center">'.$kol_klient.'</td><td width="20%">';
		echo '<div align="right"><a href="index.php?page=oferty_wychodzace'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=klient_nazwa">'.$image_arrow_down.'</a><a href="index.php?page=oferty_wychodzace'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=klient_nazwa">'.$image_arrow_up.'</a></div>';
		echo '</tr><tr><td colspan="3">';
		echo '<select name="SORT_KLIENT_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_klientow; $k++) 
		if ($KLIENT_NAZWA[$k] == $SORT_KLIENT_NAZWA) echo '<option value="'.$KLIENT_NAZWA[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
		else echo '<option value="'.$KLIENT_NAZWA[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
		echo '</select>';
		echo '</td></tr></table>';
	echo '</td>';
	
	// data wysłania oferty 
	echo '<td width="15%">';
		echo '<table width="100%" align="center" border="0" class="text" cellspacing="0" cellpadding="0"><tr><td width="20%"></td><td width="60%" align="center">Data wysłania oferty</td><td width="20%">';
		echo '<div align="right"><a href="index.php?page=oferty_wychodzace'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=data">'.$image_arrow_down.'</a><a href="index.php?page=oferty_wychodzace'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=data">'.$image_arrow_up.'</a></div>';
		echo '</tr><tr><td colspan="3">';
		echo '<select name="SORT_DATA_PRZYJECIA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=0; $k<=$ilosc_data_przyjecia; $k++) 
			if ($DATA_PRZYJECIA[$k] == $SORT_DATA_PRZYJECIA) echo '<option value="'.$DATA_PRZYJECIA[$k].'" selected="selected">'.$DATA_PRZYJECIA[$k].'</option>';
			else echo '<option value="'.$DATA_PRZYJECIA[$k].'">'.$DATA_PRZYJECIA[$k].'</option>';
		echo '</select>';
		echo '</td></tr></table>';
	echo '</td>';
	
	// Tytuł oferty 
	echo '<td width="15%">';
		echo '<table width="100%" align="center" border="0" class="text" cellspacing="0" cellpadding="0"><tr><td width="20%"></td><td width="60%" align="center">Tytuł oferty</td><td width="20%">';
		echo '<div align="right"><a href="index.php?page=oferty_wychodzace'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=tytul_oferty">'.$image_arrow_down.'</a><a href="index.php?page=oferty_wychodzace'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=tytul_oferty">'.$image_arrow_up.'</a></div>';
		echo '</tr><tr><td colspan="3">';
		echo '<select name="SORT_TYTUL_OFERTY" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=0; $k<=$ilosc_tytul; $k++) 
			if ($TYTUL_OFERTY[$k] == $SORT_TYTUL_OFERTY) echo '<option value="'.$TYTUL_OFERTY[$k].'" selected="selected">'.$TYTUL_OFERTY[$k].'</option>';
			else echo '<option value="'.$TYTUL_OFERTY[$k].'">'.$TYTUL_OFERTY[$k].'</option>';
		echo '</select>';
		echo '</td></tr></table>';
	echo '</td>';
	
	echo '<td width="50%">';
		echo '<table width="100%" align="center" border="0" class="text" cellspacing="0" cellpadding="0"><tr><td width="100%" align="center">Załączniki</td></tr>';
		echo '<tr bgcolor="'.$kolor_szary.'" align="left"><td>&nbsp;&nbsp;Nazwa pliku <font color="blue">niebieska</font> - plik stały z ustawień, nazwa pliku <font color="green">zielona</font> - plik jednorazowy, nazwa pliku <font color="red">czerwona</font> - plik zarchiwizowany.</td></tr></table>';
	echo '</td>';
	
	echo '<td width="2%">Usuń</td>';
	echo '</tr>';

	for ($x=1; $x<=$ilosc_ofert; $x++)
		{
		echo '<tr class="text" bgcolor="'.$kolor_tabeli.'" align="center">';
		echo '<td>'.$x.'</td>';
		echo '<td bgcolor="'.$kolor_bialy.'">'.$oferta_klient_nazwa[$x].'</td>';
		echo '<td bgcolor="'.$kolor_bialy.'">'.$oferta_data[$x].'</td>';
		echo '<td bgcolor="'.$kolor_bialy.'">'.$oferta_tytul[$x].'</td>';
		
		echo '<td align="left" bgcolor="'.$kolor_bialy.'">';
			echo '<table width="100%" align="left" border="0" cellspacing="0" cellpadding="0">';
			$licz = 0;
			for($z=1; $z<=10; $z++) 
				{
				if($licz == 0) echo '<tr>';	
				if($licz < $ilosc_kolumn)
					{
					$licz++;
					echo '<td class="text_duzy" width="'.$szerokosc_kolumny.'%" valign="top" align="left">';
					if($wyslany_plik_id[$oferta_id[$x]][$z] != '')
						{
						$pytanie88 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki WHERE id = ".$wyslany_plik_id[$oferta_id[$x]][$z].";");
						while($wynik88= mysqli_fetch_assoc($pytanie88))
							{
							$plik_opis=$wynik88['opis'];
							$plik_typ=$wynik88['typ'];
							$plik_link=$wynik88['link'];
							$plik_nazwa=$wynik88['plik_nazwa'];
							}
						$ikonka_pliku = $image_plik_nieznany;
						if((preg_match("/.jpg/", $plik_nazwa)) || (preg_match("/.JPG/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;
						if((preg_match("/.doc/", $plik_nazwa)) || (preg_match("/.DOC/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;
						if((preg_match("/.xls/", $plik_nazwa)) || (preg_match("/.XLS/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;
						if((preg_match("/.pdf/", $plik_nazwa)) || (preg_match("/.PDF/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;

						if($plik_typ == 'staly') 
							{
							echo '<table border="0" align="left"><tr align="center"><td align="left">';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki/'.$plik_nazwa.'" target="_blank">'.$ikonka_pliku.'</a>';
							echo '</td><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki/'.$plik_nazwa.'" target="_blank"><font color="blue">'.$plik_nazwa.'</font></a>';
							echo '</td></tr></table>';
							}
						if($plik_typ == 'temp') 
							{
							echo '<table border="0" align="left"><tr align="center"><td align="left">';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa.'" target="_blank">'.$ikonka_pliku.'</a>';
							echo '</td><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa.'" target="_blank"><font color="green">'.$plik_nazwa.'</font></a>';
							echo '</td></tr></table>';
							}
						if($plik_typ == 'archiwum') 
							{
							echo '<table border="0" align="left"><tr align="center"><td align="left">';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa.'" target="_blank">'.$ikonka_pliku.'</a>';
							echo '</td><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa.'" target="_blank"><font color="red">'.$plik_nazwa.'</font></a>';
							echo '</td></tr></table>';
							}
						}
					echo '</td>';
					}
				if($licz == $ilosc_kolumn) 
					{
					echo '</tr>';	
					$licz=0;
					}
				} // do for($z=1; $z<=9; $z++) 
			echo '</table>';
		echo '</td><td><a href="index.php?page=oferty_wychodzace&usun='.$oferta_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_trash_mini.'</a>';
		echo '</td></tr>';
		}
	echo '</table>';

echo '</form>';
?>