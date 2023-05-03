<?php
if(($zapisz == 'Zapisz') && ($pracownik_a != ''))
	{
	// kopiowanie nazwisk pracownikow, aby nie było tak że 1 jest, 2 pusty, 3 jest itp
	
	$pytanie123 = mysqli_query($conn, "SELECT nr_zamowienia FROM zamowienia WHERE id = ".$zamowienie_id_akord.";");
	while($wynik123= mysqli_fetch_assoc($pytanie123))
		{
		$nr_zamowienia=$wynik123['nr_zamowienia'];
		}
		
	if($pracownik_b == '') 
		{
		$pracownik_b = $pracownik_c;
		$pracownik_c = '';
		}

	if($pracownik_c == '') 
		{
		$pracownik_c = $pracownik_d;
		$pracownik_d = '';
		}
		
	if($pracownik_b == '') 
		{
		$pracownik_b = $pracownik_c;
		$pracownik_c = '';
		}
	
	// zapis uzytkownikow do tymczasowej bazy danych
	$data_dopisania = date('d-m-Y', time());
	$pytanie = mysqli_query($conn, "DELETE FROM pracownicy_do_akordow WHERE data_dopisania = '".$data_dopisania."' AND rodzaj_produktu = '".$rodzaj_produktu."';");
	$sql = mysqli_query($conn, "INSERT INTO `pracownicy_do_akordow` (`data_dopisania`, `rodzaj_produktu`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`) VALUES ('$data_dopisania', '$rodzaj_produktu', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d');");			
	

	//szukamy danych wpisu akordu
	$pytanie1223 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE id = ".$akord_do_edycji.";");
	while($wynik1223= mysqli_fetch_assoc($pytanie1223))
		{
		$zamowic_profile=$wynik1223['zamowic_profile'];
		$ilosc_paczek=$wynik1223['ilosc_paczek'];
		$data_wykonania_dzien=$wynik1223['data_wykonania_dzien'];
		$data_wykonania_miesiac=$wynik1223['data_wykonania_miesiac'];
		$data_wykonania_rok=$wynik1223['data_wykonania_rok'];
		$wartosc_realizacji=$wynik1223['wartosc_realizacji'];
		$wartosc_profili=$wynik1223['wartosc_profili'];
		}
		
	$pytanie = mysqli_query($conn, "DELETE FROM realizacja_produkcji WHERE id = ".$akord_do_edycji.";");
		
		if($nazwa_wszystkie_pozycje == 'on')
			{
			$jedna_z_pozycji_jest_rowna_0 = 0;
			$ilosc = 0;
			for ($x=1; $x<=$ilosc_pozycji; $x++) 
				{
				$ilosc += $ilosc_dla_pozycji[$rodzaj_produktu][$x];
				if($ilosc_dla_pozycji[$rodzaj_produktu][$x] == 0) $jedna_z_pozycji_jest_rowna_0 = 1;
				}
			if($jedna_z_pozycji_jest_rowna_0 == 0) 
				{
				mysqli_query($conn, "INSERT INTO `realizacja_produkcji` (`id`, `zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`, `data_wykonania_dzien`, `data_wykonania_miesiac`, `data_wykonania_rok`, `wartosc_realizacji`) 
				VALUES ('$akord_do_edycji', '$zamowienie_id_akord', '$data_wykonania', 'on', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile', '$ilosc_paczek', '$data_wykonania_dzien', '$data_wykonania_miesiac', '$data_wykonania_rok', '$wartosc_realizacji');");			
				}
			else
				{
				for ($x=1; $x<=$ilosc_pozycji; $x++)
					{
					$ilosc = $ilosc_dla_pozycji[$rodzaj_produktu][$x];
					if(($pozycja[$x] == 'on') && ($ilosc != 0)) mysqli_query($conn, "INSERT INTO `realizacja_produkcji` (`zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`, `data_wykonania_dzien`, `data_wykonania_miesiac`, `data_wykonania_rok`, `wartosc_realizacji`) VALUES ('$zamowienie_id_akord', '$data_wykonania', '$x', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile', '$ilosc_paczek', '$data_wykonania_dzien', '$data_wykonania_miesiac', '$data_wykonania_rok', '$wartosc_realizacji');");
					}
				}
			}
		else
			{
			for ($x=1; $x<=$ilosc_pozycji; $x++)
				{
				$ilosc = $ilosc_dla_pozycji[$rodzaj_produktu][$x];
				if(($pozycja[$x] == 'on') && ($ilosc != 0) && ($nazwa_wszystkie_pozycje != 'on')) mysqli_query($conn, "INSERT INTO `realizacja_produkcji` (`zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`, `data_wykonania_dzien`, `data_wykonania_miesiac`, `data_wykonania_rok`, `wartosc_realizacji`) VALUES ('$zamowienie_id_akord', '$data_wykonania', '$x', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile', '$ilosc_paczek', '$data_wykonania_dzien', '$data_wykonania_miesiac', '$data_wykonania_rok', '$wartosc_realizacji');");
				}
			}
		echo '<div align="center" class="text_duzy_niebieski"><br>Dane zostały zmienione.</div>';
	echo $powrot_do_realizacja_produkcji_historia_wpisow;

	}
else
	{
	if(($pracownik_a == '') && ($zapisz == 'Zapisz')) echo '<div align="center" class="text_duzy_czerwony">Proszę wybrać przynajmniej jednego pracownika (górna lista rozwijana).</div>';
	//$czy_zaznaczone_wszystkie = 0;
	//for ($z=1; $z<=$ilosc_pozycji; $z++) if($pozycja[$z] == 'on') $czy_zaznaczone_wszystkie++;
	//echo 'czy_zaznaczone_wszystkie='.$czy_zaznaczone_wszystkie.'<br>';

	$ilosc_zamowien=0;
	//echo 'zlecenie_transportowe='.$zlecenie_transportowe.'<br>';
	$WARUNEK = " status <> 'Dostarczone' && status <> 'Anulowane' && status <> 'Odebrane'";
	if(preg_match("/ZT/", $zlecenie_transportowe)) $WARUNEK = " nr_zlecenia_transportowego = '".$zlecenie_transportowe."'"; //jezeli wybrano zlec transp wyszukaj tylko te zamowienia ze zlecenia transportowego
	elseif($zlecenie_transportowe == 'WSZYSTKIE') $WARUNEK = " status <> 'Dostarczone' && status <> 'Anulowane' && status <> 'Odebrane'";
	elseif($zlecenie_transportowe != '') $WARUNEK = " nr_zamowienia = '".$zlecenie_transportowe."'"; // jeżeli wybrano zamówienie, pokaż tylko to zamówienie
	//echo 'warunek='.$WARUNEK.'<br>';
	$baza_zamowienie_id = [];
	$baza_nr_zamowienia = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM zamowienia WHERE  ".$WARUNEK." ORDER BY id DESC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_zamowien++;
		$baza_zamowienie_id[$ilosc_zamowien]=$wynik['id'];
		$baza_nr_zamowienia[$ilosc_zamowien]=$wynik['nr_zamowienia'];
		}
	//echo 'ilosc zam='.$ilosc_zamowien.'<br>';
	if($zmiana == '')
		{
		$pytanie3 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE id=".$akord_do_edycji.";");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			{
			$pracownik_a=$wynik3['pracownik_a'];
			$pracownik_b=$wynik3['pracownik_b'];
			$pracownik_c=$wynik3['pracownik_c'];
			$pracownik_d=$wynik3['pracownik_d'];
			$rodzaj_produktu=$wynik3['rodzaj_produktu'];
			$pozycja_edycja=$wynik3['pozycja'];
			$ilosc=$wynik3['ilosc'];
			$data_wykonania=$wynik3['data_wykonania'];
			$zamowienie_id_akord=$wynik3['zamowienie_id'];
			}
		}
	
// tabel główna
echo '<table align="left" border="0"><tr><td>';
	
	echo '<table align="left" class="tabela" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="150px">Nr zamówienia</td>';
		echo '<td width="150px">Rodzaj produktu</td>';
		echo '<td width="180px">Pozycja</td>';
		echo '<td width="100px">Ilość</td>';
		echo '<td width="240px">Pracownicy</td></tr>';
	
		echo '<FORM id="myForm" method="post">';
		echo '<input type="hidden" name="page" value="realizacja_produkcji_edycja_akordu">';
		echo '<INPUT type="hidden" name="zamowienie_id_akord" value="'.$zamowienie_id_akord.'">';
		echo '<INPUT type="hidden" name="zlecenie_transportowe" value="'.$zlecenie_transportowe.'">';
		echo '<INPUT type="hidden" name="klienci_do_planu_produkcji" value="'.$klienci_do_planu_produkcji.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		
		echo '<INPUT type="hidden" name="data_poczatkowa" value="'.$data_poczatkowa.'">';
		echo '<INPUT type="hidden" name="data_koncowa" value="'.$data_koncowa.'">';
		echo '<INPUT type="hidden" name="sprawdzany_pracownik" value="'.$sprawdzany_pracownik.'">';
		echo '<INPUT type="hidden" name="sprawdzane_zamowienie" value="'.$sprawdzane_zamowienie.'">';
		echo '<INPUT type="hidden" name="zmiana" value="tak">';
		echo '<INPUT type="hidden" name="akord_do_edycji" value="'.$akord_do_edycji.'">';
		echo '<INPUT type="hidden" name="data_wykonania" value="'.$data_wykonania.'">';
		
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td>';
		echo '<table border="0" align="center" width="100%"><tr><td>&nbsp;</td></tr><tr><td align="center">';
			echo '<select name="zamowienie_id_akord" onchange="submit();" class="pole_input_czerwone">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_zamowien; $k++) 
				if ($baza_zamowienie_id[$k] == $zamowienie_id_akord) echo '<option value="'.$baza_zamowienie_id[$k].'" selected="selected">'.$baza_nr_zamowienia[$k].'</option>';
				else echo '<option value="'.$baza_zamowienie_id[$k].'">'.$baza_nr_zamowienia[$k].'</option>';
			echo '</select>';
			
			$ilosc_pozycji=0;
			$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_akord." AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
			while($wynik4= mysqli_fetch_assoc($pytanie4))
				{
				$ilosc_pozycji++;
				$klient_nazwa_2=$wynik4['klient_nazwa'];
				}
			echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id_akord.'" value="'.$ilosc_pozycji.'">';
		echo '</td></tr><tr><td align="center" class="text">';
			echo $klient_nazwa_2;
		echo '</td></tr></table>';
			echo '</td>';
		
		 
		// rodzaj produktu   zmien_rodzaj_produktu('.$zamowienie_id.');
		echo '<td>';
			echo '<select name="rodzaj_produktu" onchange="submit();" class="pole_input_czerwone">';
			echo '<option></option>';
				if ($rodzaj_produktu == 0) echo '<option value="0" selected="selected">'.$TABELA_LISTA_PRODUKTOW[0].'</option>';
				else echo '<option value="0">'.$TABELA_LISTA_PRODUKTOW[0].'</option>';
				
				if ($rodzaj_produktu == 1) echo '<option value="1" selected="selected">'.$TABELA_LISTA_PRODUKTOW[1].'</option>';
				else echo '<option value="1">'.$TABELA_LISTA_PRODUKTOW[1].'</option>';
				
				if ($rodzaj_produktu == 2) echo '<option value="2" selected="selected">'.$TABELA_LISTA_PRODUKTOW[2].'</option>';
				else echo '<option value="2">'.$TABELA_LISTA_PRODUKTOW[2].'</option>';

				if ($rodzaj_produktu == 3) echo '<option value="3" selected="selected">'.$TABELA_LISTA_PRODUKTOW[3].'</option>';
				else echo '<option value="3">'.$TABELA_LISTA_PRODUKTOW[3].'</option>';
				
				if ($rodzaj_produktu == 4) echo '<option value="4" selected="selected">'.$TABELA_LISTA_PRODUKTOW[4].'</option>';
				else echo '<option value="4">'.$TABELA_LISTA_PRODUKTOW[4].'</option>';
				
				if ($rodzaj_produktu == 5) echo '<option value="5" selected="selected">'.$TABELA_LISTA_PRODUKTOW[5].'</option>';
				else echo '<option value="5">'.$TABELA_LISTA_PRODUKTOW[5].'</option>';
				
				// if ($rodzaj_produktu == 7) echo '<option value="7" selected="selected">'.$TABELA_LISTA_PRODUKTOW[7].'</option>';
				// else echo '<option value="7">'.$TABELA_LISTA_PRODUKTOW[7].'</option>';
				
				if ($rodzaj_produktu == 11) echo '<option value="11" selected="selected">'.$TABELA_LISTA_PRODUKTOW[11].'</option>';
				else echo '<option value="11">'.$TABELA_LISTA_PRODUKTOW[11].'</option>';
				
				if ($rodzaj_produktu == 10) echo '<option value="10" selected="selected">'.$TABELA_LISTA_PRODUKTOW[10].'</option>';
				else echo '<option value="10">'.$TABELA_LISTA_PRODUKTOW[10].'</option>';
			echo '</select>';
		echo '</td>';



		// #############################     pozycje    ##############################################################################################################################################################################
		echo '<td>';
		$SUMA_ELEMENTOW_DANEGO_TYPU = [];
	
		for ($m=1; $m<=9; $m++) $SUMA_ELEMENTOW_DANEGO_TYPU[$m] = 0;
		$ilosc_pozycji=0;
		$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_akord." AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$ilosc_pozycji++;
				$wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_ramy_pvc_ilosc_szt'];
				$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_skrzydla_pvc_ilosc_szt'];
				$wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_innego_pvc_ilosc_szt'];
			$suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji]+$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji]+$wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[1] += $suma_rodzaj_produktu[1][$ilosc_pozycji];
				$wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_listwy_pvc_ilosc_szt'];
				if(($suma_rodzaj_produktu[1][$ilosc_pozycji] == 0) && ($wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji] != 0)) $suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji];

				$wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
				$wygiecie_innego_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_innego_ilosc_szt'];
			$suma_rodzaj_produktu[2][$ilosc_pozycji] = $wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji]+$wygiecie_innego_ilosc_szt[$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[2] += $suma_rodzaj_produktu[2][$ilosc_pozycji];
	
				$wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_ramy_alu_ilosc_szt'];
				$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
				$wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji]=$wynik4['wygiecie_innego_alu_ilosc_szt'];
			$suma_rodzaj_produktu[3][$ilosc_pozycji] = $wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji]+$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji]+$wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[3] += $suma_rodzaj_produktu[3][$ilosc_pozycji];

			$suma_rodzaj_produktu[4][$ilosc_pozycji]=$wynik4['zgrzanie_ilosc'];
			$suma_rodzaj_produktu[5][$ilosc_pozycji]=$wynik4['wstawienie_slupka_ilosc'];
			$suma_rodzaj_produktu[6][$ilosc_pozycji]=$wynik4['wyfrezowanie_odwodnienia_ilosc'];
			$suma_rodzaj_produktu[7][$ilosc_pozycji]=$wynik4['listwa_przyszybowa_ilosc'];
			$suma_rodzaj_produktu[11][$ilosc_pozycji]=$wynik4['dociecie_kompletu_listew_przyszybowych_ilosc'];
			$suma_rodzaj_produktu[8][$ilosc_pozycji]=$wynik4['okucie_ilosc'];
			$suma_rodzaj_produktu[9][$ilosc_pozycji]=$wynik4['zaszklenie_ilosc'];
			$suma_rodzaj_produktu[0][$ilosc_pozycji]=$wynik4['ilosc_sztuk'];
			$suma_rodzaj_produktu[10][$ilosc_pozycji]=$wynik4['ilosc_sztuk'];
			
			$SUMA_ELEMENTOW_DANEGO_TYPU[4] += $suma_rodzaj_produktu[4][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[5] += $suma_rodzaj_produktu[5][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[6] += $suma_rodzaj_produktu[6][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[7] += $suma_rodzaj_produktu[7][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[8] += $suma_rodzaj_produktu[8][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[9] += $suma_rodzaj_produktu[9][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[0] += $suma_rodzaj_produktu[0][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[10] += $suma_rodzaj_produktu[10][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[11] += $suma_rodzaj_produktu[11][$ilosc_pozycji];
			
			}	
			
			
		//echo 'zamowienie_id_akord='.$zamowienie_id_akord.'<br>';
		//echo 'pozycja_edycja2='.$pozycja_edycja.'<br>';
		if(($zamowienie_id_akord != '') && ($rodzaj_produktu != ''))
			{
			echo '<table align="center" border="0" cellpadding="0" cellspacing="0" class="text">';
			echo '<tr align="center" height="20px"><td>Wszystkie pozycje : </td>';
			$id_test = 'id_'.$zamowienie_id_akord;
			$checked = '';
			//if($czy_zaznaczone_wszystkie != $ilosc_pozycji) $nazwa_wszystkie_pozycje = ''; else $nazwa_wszystkie_pozycje = 'on';
			if($nazwa_wszystkie_pozycje == 'on') $checked = "checked";					
			if($pozycja_edycja == 'on') $checked = "checked";
							
			echo '<td><input type="checkbox" id="'.$id_test.'" name="nazwa_wszystkie_pozycje" '.$checked.' onClick="zaznacz_pozycje('.$zamowienie_id_akord.')"></td></tr>';
			echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id_akord.'" value="'.$ilosc_pozycji.'">';
			for ($m=1; $m<=$ilosc_pozycji; $m++) 
				{
				$zapytanie_wykonane = 0;
				$pytanie43 = mysqli_query($conn, "SELECT id, ilosc FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND rodzaj_produktu = ".$rodzaj_produktu." AND pozycja = 'on';");
				while($wynik43= mysqli_fetch_assoc($pytanie43))
					{
					$zapytanie_wykonane = 1;
					$id_akordu = $wynik43['id'];
					if($akord_do_edycji != $id_akordu) $ilosc_juz_wykonanych_on = $wynik43['ilosc']; else $ilosc_juz_wykonanych_on = 0;
					//echo '$ilosc_juz_wykonanych_on='.$ilosc_juz_wykonanych_on.'<br>';
					}
				if($zapytanie_wykonane == 0) //jezeli nie sa wpisane wszystkie pozycje jako ON|!!!
					{
					$ilosc_juz_wykonanych[$m] = 0;
					//sprawdzamy czy już jakies elementy nie zostały zrobione
					$pytanie43 = mysqli_query($conn, "SELECT id, ilosc FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND rodzaj_produktu = ".$rodzaj_produktu." AND pozycja = ".$m.";");
					while($wynik43= mysqli_fetch_assoc($pytanie43))
						{
						//$zapytanie_wykonane = 1;
						$temp=$wynik43['ilosc'];
						$id_akordu = $wynik43['id'];
						//echo 'poz='.$m.', ilosc='.$temp.'<br>';
						//echo 'id_akordu='.$id_akordu.'<br>';
						//echo 'akord_do_edycji='.$akord_do_edycji.'<br>';
						if($akord_do_edycji != $id_akordu) $ilosc_juz_wykonanych[$m] += $temp; else $ilosc_juz_wykonanych[$m] = 0;
						}
					$suma_rodzaj_produktu[$rodzaj_produktu][$m] = $suma_rodzaj_produktu[$rodzaj_produktu][$m] - $ilosc_juz_wykonanych[$m]; //odliczamy juz wykonane elementy
					$SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] = $SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] - $ilosc_juz_wykonanych[$m];
					}
				else
					{
					//echo 'id_akordu2='.$id_akordu.'<br>';
					//echo 'akord_do_edycji='.$akord_do_edycji.'<br>';
					if($akord_do_edycji != $id_akordu) echo $suma_rodzaj_produktu[$rodzaj_produktu][$m] = 0; //odliczamy juz wykonane elementy
					}
				$checked = '';
				if(($zmiana == 'tak') && ($pozycja[$m] == 'on')) $checked = "checked";
				if(($zmiana == '') && ($pozycja_edycja == 'on')) $checked = "checked";
				if(($zmiana == '') && ($pozycja_edycja == $m)) $checked = "checked";
				$nazwa_pozycja = 'pozycja['.$m.']';
				echo '<tr align="center" height="20px"><td>Pozycja '.$m.' : </td>';
				echo '<td><input name="'.$nazwa_pozycja.'" type="checkbox" '.$checked.' onchange="submit();"></td></tr>';
				}
				if($zapytanie_wykonane == 1)
					$SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] = $SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] - $ilosc_juz_wykonanych_on;
			
			echo '</table>';
			}

		// #############################     ilosc          ##############################################################################################################################################################################
		echo '<td>';
		$suma_do_zrobienia = 0;
		if(($zamowienie_id_akord != '') && ($rodzaj_produktu != ''))
			{
			echo '<table align="center" border="0" cellpadding="0" cellspacing="0" class="text">';
			echo '<tr align="center" height="20px"><td></td></tr>';
			for ($m=1; $m<=$ilosc_pozycji; $m++) 
				{
				if(($pozycja[$m] == 'on') || ($pozycja_edycja == 'on'))
					{
					$suma_do_zrobienia += $suma_rodzaj_produktu[$rodzaj_produktu][$m];
					echo '<tr align="center" height="20px"><td width="100px">';
					if($suma_rodzaj_produktu[$rodzaj_produktu][$m] != 0)
						{
						$nazwa_ilosc_dla_pozycji = 'ilosc_dla_pozycji['.$rodzaj_produktu.']['.$m.']';
						if(($nazwa_wszystkie_pozycje == 'on') || ($pozycja_edycja == 'on'))
							{
							echo '<INPUT type="hidden" name="'.$nazwa_ilosc_dla_pozycji.'"  value="'.$suma_rodzaj_produktu[$rodzaj_produktu][$m].'">';
							$disabled = ' disabled';
							}
						else $disabled = '';

						echo '<select name="'.$nazwa_ilosc_dla_pozycji.'" class="pole_input_czerwone" '.$disabled.'>';
						for ($a=1; $a<=$suma_rodzaj_produktu[$rodzaj_produktu][$m]; $a++) 
							{
							if(($a == $suma_rodzaj_produktu[$rodzaj_produktu][$m]) && ($ilosc_dla_pozycji[$rodzaj_produktu][$m] == '')) echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
							elseif(($ilosc_dla_pozycji[$rodzaj_produktu][$m] == $a)) echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
							elseif($ilosc == $a) echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
							else echo '<option value="'.$a.'">'.$a.'</option>';
							}
						echo '</select></td></tr>';
						}
					else echo '0</td></tr>';
					}
				elseif($pozycja_edycja == $m)
					{
					echo '<tr align="center" height="20px"><td width="100px">';
					$nazwa_ilosc_dla_pozycji = 'ilosc_dla_pozycji['.$rodzaj_produktu.']['.$m.']';
					echo '<select name="'.$nazwa_ilosc_dla_pozycji.'" class="pole_input_czerwone" '.$disabled.'>';
					for ($a=1; $a<=$suma_rodzaj_produktu[$rodzaj_produktu][$m]; $a++) 
						{
						if(($a == $suma_rodzaj_produktu[$rodzaj_produktu][$m]) && ($ilosc_dla_pozycji[$rodzaj_produktu][$m] == '') && ($ilosc == '')) echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
						elseif(($ilosc_dla_pozycji[$rodzaj_produktu][$m] == $a) && ($ilosc == '')) echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
						elseif($ilosc == $a) echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
						else echo '<option value="'.$a.'">'.$a.'</option>';
						}
					echo '</select></td></tr>';
					}
				else echo '<tr align="center" height="20px"><td width="100px">&nbsp;</td></tr>';
				}
			echo '</table>';
			}
		echo '</td>';

	$ilosc_pracownikow=0;
	$id_pracownika = [];
	$imie = [];
	$nazwisko = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' ORDER BY id ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pracownikow++;
		$id_pracownika[$ilosc_pracownikow]=$wynik['id'];
		$imie[$ilosc_pracownikow]=$wynik['imie'];
		$nazwisko[$ilosc_pracownikow]=$wynik['nazwisko'];
		}

	// lista pracownikow
	echo '<td align="left">';
		echo '<table align="left" border="0" cellpadding="0" cellspacing="0" class="text">';
			
				
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_a" class="pole_input_czerwone">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_a == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr>';
		
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_b" class="pole_input_czerwone">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_b == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr>';
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_c" class="pole_input_czerwone">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_c == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr>';
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_d" class="pole_input_czerwone">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_d == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr></table>';
	echo '</td></tr>';
echo '</table>';

echo '</td></tr><tr><td align="left">';
	echo '<div align="center"><input type="submit" value="Zapisz" name="zapisz" class="button_zapisz_produkcja"></div>';

echo '</td></tr><tr><td align="left" colspan="2"><br>';
echo '</form>';
echo '</td></tr><tr><td align="left" colspan="2">';
	echo $powrot_do_realizacja_produkcji_historia_wpisow;
echo '</td></tr></table>';
//if(($czy_zaznaczone_wszystkie != 0) && ($suma_do_zrobienia != 0)) echo '<div align="center"><input type="submit" value="Zapisz" name="zapisz" class="button_zapisz_produkcja"></div>';
} // do else if zapisz -== zapsiz
?>