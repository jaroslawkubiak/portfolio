<?php
if($usunac == 1)
	{
	//usuwamy klienta ze zlec transp
	$pytanie15 = mysqli_query($conn, "SELECT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' AND klient_id=".$klient.";");
	while($wynik15= mysqli_fetch_assoc($pytanie15))
		{
		$zamowienie_id=$wynik15['zamowienie_id'];
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET numer_wz = '' WHERE id = ".$zamowienie_id.";");
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET data_wysylki_potwierdzenia_dostawy = '' WHERE id = ".$zamowienie_id.";");
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET link_dostawa = '' WHERE id = ".$zamowienie_id.";");
		}

	mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
	echo '<div align="center" class="text_duzy_niebieski"><br>Pozycja została usunięta ze zlecenia transportowego.</div>';
	echo $powrot_do_konkretnego_zlecenia_transportowego;
	}

//edycja danych pozycji zlecenia transportowego
if(($zapisz == 'Zapisz') && ($usunac != 1))
	{
	//szukam sposobu płatności klienta
	$pytanie313 = mysqli_query($conn, "SELECT sposob_platnosci FROM klienci WHERE id=".$klient.";");
	while($wynik313= mysqli_fetch_assoc($pytanie313))
		$sposob_platnosci=$wynik313['sposob_platnosci'];

	//szukamy daty wysyłki potwierdzenia dostawy i linku do pliku
	$pytanie44 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' AND klient_id = ".$klient.";");
	while($wynik44= mysqli_fetch_assoc($pytanie44))
		{
		// echo 'szukamy daty wysyłki potwierdzenia dostawy i linku do pliku<br>';
		$link_dostawa=$wynik44['link_dostawa'];
		$data_wysylki_potwierdzenia_dostawy=$wynik44['data_wysylki_potwierdzenia_dostawy'];
		}
	
	
	// usuwanie nr zlecenia transportowego z zamówienia
	$pytanie15 = mysqli_query($conn, "SELECT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' AND klient_id=".$klient.";");
	while($wynik15= mysqli_fetch_assoc($pytanie15))
		{
		// echo 'zmieniam nr zlecenia na pusty<br>';
		$zamowienie_id=$wynik15['zamowienie_id'];
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET numer_wz = '' WHERE id = ".$zamowienie_id.";");

		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET data_wysylki_potwierdzenia_dostawy = '' WHERE id = ".$zamowienie_id.";");
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET link_dostawa = '' WHERE id = ".$zamowienie_id.";");
		}

	$SUMA_POBRAN_BRUTTO = 0;
	if($zamowienie_id != 0) 
		{
		$pytanie3 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."' LIMIT 1;");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			{
			$SUMA_POBRAN_BRUTTO_BAZA=$wynik3['suma_pobran_brutto'];
			$suma_pobran_brutto_edycja=$wynik3['suma_pobran_brutto_edycja'];
			$time_baza=$wynik3['time'];
			$kolejnosc=$wynik3['kolejnosc'];
			$data_dostarczenia=$wynik3['data_dostarczenia'];
			$podpis_imie_nazwisko=$wynik3['podpis_imie_nazwisko'];
			$podpis_link = $wynik3['podpis_link'];
			$numer_wz = $wynik3['numer_wz'];
			}

		mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
	
		$m = 0;
		$pytanie3 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE klient_id=$klient AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane';");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			{
			$m++;
			$ilosc_pozycji_2[$m] = 0;
			$inne_zamowienie_id[$m]=$wynik3['id'];
			$pytanie33 = mysqli_query($conn, "SELECT wartosc_brutto FROM wyceny WHERE zamowienie_id=$inne_zamowienie_id[$m];");
			while($wynik33= mysqli_fetch_assoc($pytanie33))
				{
				$ilosc_pozycji_2[$m]++;
				$wartosc_brutto_wycena[$ilosc_pozycji_2[$m]]=$wynik33['wartosc_brutto'];
				}
			//sprawdzam czy dane zamowienie zostało zaznaczone
			if($nazwa_suma[$inne_zamowienie_id[$m]] == 'on') 
				{
				for ($k=1; $k<=$ilosc_pozycji_2[$m]; $k++)
					{
					if(($sposob_platnosci != 'Gotówka') && ($sposob_platnosci != 'Przedpłata')) $SUMA_POBRAN_BRUTTO=0;
					if($suma_pobran_brutto_edycja == 'tak') $SUMA_POBRAN_BRUTTO = $SUMA_POBRAN_BRUTTO_BAZA;
					$nazwa_pozycja = 'pozycja['.$inne_zamowienie_id[$m].']['.$k.']';
					//sprawdzamy czy dana pozycja w zamówieniu została zaznaczona
					if($pozycja[$inne_zamowienie_id[$m]][$k] == 'on') 
						{
						if($time_baza != '') $time = $time_baza;

						if($liczba_paczek_wyrobow == '') $liczba_paczek_wyrobow = 0;
						if($kolejnosc == '') $kolejnosc = 0;
						$SUMA_POBRAN_BRUTTO = change($SUMA_POBRAN_BRUTTO);

						$query = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `kwota_brutto`, `data_dostawy`, `uwagi`, `liczba_paczek_wyrobow`, `kolejnosc`, `pozycja_wyceny`, `user_id`, `data_dostarczenia`, `podpis_imie_nazwisko`, `podpis_link`, `odbior_material`, `odbior_szablon`, `zwrot_material`, `zwrot_szablon`, `zwrot_uszczelki`, `suma_pobran_brutto`, `suma_pobran_brutto_edycja`, `time`, `numer_wz`) 
						values ('$nowy_numer_zlecenia', '$klient', '$inne_zamowienie_id[$m]', '$wartosc_brutto_wycena[$k]', '$data_dostawy', '$uwagi', '$liczba_paczek_wyrobow', '$kolejnosc', '$k', '$user_id',  '$data_dostarczenia',  '$podpis_imie_nazwisko',  '$podpis_link', '$odbior_material', '$odbior_szablon', '$zwrot_material', '$zwrot_szablon', '$zwrot_uszczelki', '$SUMA_POBRAN_BRUTTO', '$suma_pobran_brutto_edycja', '$time', '$numer_wz');";
						mysqli_query($conn, $query);
						$SUMA_POBRAN_BRUTTO += $wartosc_brutto_wycena[$k];
						} // do if($pozycja[$inne_zamowienie_id[$m]][$k] == 'on') 
					}
				$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."' WHERE id = ".$inne_zamowienie_id[$m].";");
				$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET data_dostawy = '".$data_dostawy."' WHERE id = ".$inne_zamowienie_id[$m].";");
				$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET numer_wz = '".$numer_wz."' WHERE id = ".$inne_zamowienie_id[$m].";");
				$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET data_wysylki_potwierdzenia_dostawy = '".$data_wysylki_potwierdzenia_dostawy."' WHERE id = ".$inne_zamowienie_id[$m].";");
				$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET link_dostawa = '".$link_dostawa."' WHERE id = ".$inne_zamowienie_id[$m].";");
						

				} // do if($nazwa_suma[$inne_zamowienie_id[$m]] == 'on') 
			} // do while($wynik3= mysqli_fetch_assoc($pytanie3))
		
		//sprawdzamy czy wpisać wartość dla sumy pobrań brutto
		if(($sposob_platnosci != 'Gotówka') && ($sposob_platnosci != 'Przedpłata')) $SUMA_POBRAN_BRUTTO=0;
		if($suma_pobran_brutto_edycja == 'tak') $SUMA_POBRAN_BRUTTO = $SUMA_POBRAN_BRUTTO_BAZA;
		$SUMA_POBRAN_BRUTTO = change($SUMA_POBRAN_BRUTTO);
		$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET suma_pobran_brutto = ".$SUMA_POBRAN_BRUTTO." WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' AND klient_id=".$klient.";");
		} // do if($zamowienie_id != 0) 
	else
		{
		//w przypadku braku zaznaczonych zamówień
		$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET user_id = '".$user_id."' WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
		$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET uwagi = '".$uwagi."' WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
		$pytanie123 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET data_dostawy = '".$data_dostawy."' WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
		//$pytanie124 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET liczba_paczek_wyrobow = '".$liczba_paczek_wyrobow."' WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
		
		mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET odbior_material = '".$odbior_material."', odbior_szablon = '".$odbior_szablon."', zwrot_material = '".$zwrot_material."', zwrot_szablon = '".$zwrot_szablon."', zwrot_uszczelki = '".$zwrot_uszczelki."' WHERE klient_id = ".$klient." AND nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."';");
		}

	echo '<div class="text_duzy_niebieski" align="center">Pozycja do zlecenia transportowego została zmieniona.</div><br><br>';
	echo $powrot_do_konkretnego_zlecenia_transportowego;
	}
	
if((!$submit) && ($zapisz != 'Zapisz'))
{

	echo '<table width="100%" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';
	echo '<div class="text_duzy" align="center">Edytuj pozycję do zlecenia transportowego '.$nowy_numer_zlecenia.'</div><br>';
			
	echo '<FORM action="index.php?page=zlecenie_transportowe_edytuj" method="post">';
	echo '<INPUT type="hidden" name="nowy_numer_zlecenia" value="'.$nowy_numer_zlecenia.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="id" value="'.$id.'">';
	echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
	
	echo '<table align="center" class="tabela" ><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
	
	echo '<td width="220px">'.$kol_klient.'</td>';
	echo '<td width="220px">'.$kol_adres_dostawy.'</td>';
	echo '<td width="220px">'.$kol_nr_zamowienia_arcus_klienta.'</td>';
	echo '<td width="120px">'.$kol_suma_zamowien_brutto.'</td>';
	echo '<td width="100px">'.$kol_data_dostawy.'</td>';
	echo '<td width="220px">'.$kol_uwagi.'</td>';
	echo '<td width="120px">'.$kol_odbior.'</td>';
	// echo '<td width="120px">'.$kol_zwrot.'</td>';
	//echo '<td width="80px">'.$kol_liczba_paczek.'</td>';
	echo '</tr>';
	
	$pytanie14 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = $klient;");
	while($wynik14= mysqli_fetch_assoc($pytanie14))
		{
		$klient_nazwa=$wynik14['nazwa'];
		$klient_ulica=$wynik14['dostawy_ulica'];
		$klient_miasto=$wynik14['dostawy_miasto'];
		$klient_kod_pocztowy=$wynik14['dostawy_kod_pocztowy'];
		}
	
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td>'.$klient_nazwa.'</td>';
	echo '<td>'.$klient_ulica.'<br>'.$klient_kod_pocztowy.' '.$klient_miasto.'</td>';
			
	//sprawdzanie listy zamówień klienta
	$m = 0;
	$pytanie3 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE klient_id=$klient AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane' ORDER BY id ASC;");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$m++;
		$inne_zamowienie_id[$m]=$wynik3['id'];
		$inne_nr_zamowienia[$m]=$wynik3['nr_zamowienia'];
		$inne_nr_zamowienia_klienta[$m]=$wynik3['nr_zamowienia_klienta'];
		$poz = 0;
		$pytanie33 = mysqli_query($conn, "SELECT wartosc_brutto FROM wyceny WHERE zamowienie_id=$inne_zamowienie_id[$m] ORDER BY pozycja ASC;");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$poz++;
			$wartosc_brutto_wycena[$inne_zamowienie_id[$m]][$poz]=$wynik33['wartosc_brutto'];
			$id_pozycja = 'id_pozycja['.$inne_zamowienie_id[$m].']['.$poz.']';
			echo '<input type="hidden" id="'.$id_pozycja.'" value="'.$wartosc_brutto_wycena[$inne_zamowienie_id[$m]][$poz].'">';
			}
		$inne_termin_realizacji[$m]=$wynik3['termin_realizacji'];
		}
	echo '<td>';
		$wysokosc_wiersza = 30;
		echo '<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="text">';
		for ($z=1; $z<=$m; $z++) // wykonaj tyle ile jest zamówien dla danego klienta
			{
			$jest_w_innym_zleceniu = 0;
			$jest_w_tym_zleceniu = 0;
			$nie_ma_w_zadnym_zleceniu = 0;
			$title='';
			$jest=0;
			$pytanie35 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id=".$inne_zamowienie_id[$z].";");
			while($wynik35= mysqli_fetch_assoc($pytanie35))
				$nr_zamowienia_transp_dla_tego_zamowienia=$wynik35['nr_zlecenia_transportowego'];
			
							
			if($nr_zamowienia_transp_dla_tego_zamowienia == '') 
				{
				$nie_ma_w_zadnym_zleceniu = 1;
				$disabled = '';
				}
			if($nr_zamowienia_transp_dla_tego_zamowienia == $nowy_numer_zlecenia) 
				{
				$jest_w_tym_zleceniu = 1;
				$disabled = '';						
				}
			elseif(($nr_zamowienia_transp_dla_tego_zamowienia != '') && ($nr_zamowienia_transp_dla_tego_zamowienia != $nowy_numer_zlecenia))
				{
				$disabled = ' disabled';
				$jest_w_innym_zleceniu = 1;
				}
			$title = $nr_zamowienia_transp_dla_tego_zamowienia;

			if($nie_ma_w_zadnym_zleceniu == 1) $font_color = "black";	
			elseif($jest_w_innym_zleceniu == 1) $font_color = "red";
			elseif($jest_w_tym_zleceniu == 1) $font_color = "black";	
			echo '<tr align="center" title="'.$title.'"><td width="18%" height="'.$wysokosc_wiersza.'px"><font color="blue">'.$inne_termin_realizacji[$z].'</font></td>';
			echo '<td width="40%" height="'.$wysokosc_wiersza.'px"><font color="'.$font_color.'">'.$inne_nr_zamowienia[$z].'</font></td>';
			echo '<td width="2%"><font color="'.$font_color.'">&nbsp;|&nbsp;</font></td>';
			echo '<td width="40%"><font color="'.$font_color.'">'.$inne_nr_zamowienia_klienta[$z].'</font></td>';
			$nazwa_suma = 'nazwa_suma['.$inne_zamowienie_id[$z].']';
			$id_test = 'id_'.$inne_zamowienie_id[$z];
			if($nie_ma_w_zadnym_zleceniu == 1) echo '<td width="4%"><input type="checkbox" id="'.$id_test.'" name="'.$nazwa_suma.'" onClick="toggle('.$inne_zamowienie_id[$z].')"></td></tr>';
			elseif($jest_w_innym_zleceniu == 1) echo '<td width="4%"><input type="checkbox" disabled name="'.$nazwa_suma.'"></td></tr>';
			elseif($jest_w_tym_zleceniu == 1) echo '<td width="4%"><input type="checkbox" id="'.$id_test.'" checked name="'.$nazwa_suma.'" onClick="toggle('.$inne_zamowienie_id[$z].')"></td></tr>';
			
			//sprawdzamy ile jest pozycji w wycenie
			$ilosc_pozycji_2[$z] = 0;
			$pytanie45 = mysqli_query($conn, "SELECT wartosc_brutto FROM wyceny WHERE zamowienie_id='".$inne_zamowienie_id[$z]."' ORDER BY pozycja ASC;");
			while($wynik45= mysqli_fetch_assoc($pytanie45))
				{
				$ilosc_pozycji_2[$z]++;
				}
			echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$inne_zamowienie_id[$z].'" value="'.$ilosc_pozycji_2[$z].'">';
			$SUMA_WARTOSC_BRUTTO_ZAMOWIENIE[$inne_zamowienie_id[$z]] = 0;
			for ($k=1; $k<=$ilosc_pozycji_2[$z]; $k++)
				{
				$pozycja_dostarczona = '';
				$nazwa_pozycja = 'pozycja['.$inne_zamowienie_id[$z].']['.$k.']';
				$id_pozycja_wycena = 'id_pozycja_wycena['.$inne_zamowienie_id[$z].']['.$k.']';
				$id_pozycja_status = 'id_pozycja_status['.$inne_zamowienie_id[$z].']['.$k.']';
				$pytanie323 = mysqli_query($conn, "SELECT pozycja_transport, status FROM wyceny WHERE zamowienie_id=".$inne_zamowienie_id[$z]." AND pozycja = ".$k.";");
				while($wynik323= mysqli_fetch_assoc($pytanie323))
					{
					$pozycja_transport=$wynik323['pozycja_transport'];
					$pozycja_status=$wynik323['status'];
					}
				echo '<input type="hidden" id="'.$id_pozycja_status.'" value="'.$pozycja_status.'">'; //wpisujemy status pozycji aby sprawdzic czy mamy ją sumować
				
				if($pozycja_status == 'Dostarczone') $font_color = 'lightgray'; else $font_color = 'black';
				if($pozycja_transport == 'tak') echo '<tr align="center"><td colspan="4" align="right"><font color="'.$font_color.'">Pozycja transportowa '.$k.'&nbsp;&nbsp;</font></td>';
				else echo '<tr align="center"><td colspan="4" align="right"><font color="'.$font_color.'">Pozycja '.$k.'&nbsp;&nbsp;</font></td>';

				//sprawdzamy jaka pozycja wyceny jest wpisana do zlecenia transportowego i sumujemy wartosc brutto
				$zaznaczyc[$k] = '';
				$pytanie425 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE zamowienie_id='".$inne_zamowienie_id[$z]."' AND pozycja_wyceny = ".$k." AND nr_zlecenia_transportowego='".$nowy_numer_zlecenia."';");
				while($wynik425= mysqli_fetch_assoc($pytanie425))
					{
					$zaznaczyc[$k] = ' checked';
					$wartosc_brutto_wycena[$inne_zamowienie_id[$z]][$k].'<br>';
					$SUMA_WARTOSC_BRUTTO_ZAMOWIENIE[$inne_zamowienie_id[$z]] += $wartosc_brutto_wycena[$inne_zamowienie_id[$z]][$k];
					}
					
				if($pozycja_status == 'Dostarczone') echo '<td width="4%" height="'.$wysokosc_wiersza.'px"><input title="'.$pozycja_status.'" type="checkbox" disabled></td></tr>';
				else echo '<td width="4%" height="'.$wysokosc_wiersza.'px"><input title="'.$pozycja_status.'" '.$disabled.' id="'.$id_pozycja_wycena.'" name="'.$nazwa_pozycja.'" type="checkbox" '.$zaznaczyc[$k].' onClick="licz_sume_zamowien('.$inne_zamowienie_id[$z].', '.$k.')"></td></tr>';
				}
			if($z != $m) echo '<tr align="center"><td colspan="5" align="right" height="'.$wysokosc_wiersza.'px"><hr></td></tr>';
			}

		echo '</table>';
	echo '</td>';
						
		// suma zamowien
		echo '<td valign="top">';
		echo '<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="text">';
		for ($z=1; $z<=$m; $z++)
			{
			if($z != $m) $ilosc_pozycji_22[$z] = $ilosc_pozycji_2[$z] + 2; else $ilosc_pozycji_22[$z] =$ilosc_pozycji_2[$z] + 1;
			$suma_wysokosc_wiersza[$z] = $wysokosc_wiersza*$ilosc_pozycji_22[$z];
			$input_id_suma_brutto = 'input_id_suma_brutto['.$inne_zamowienie_id[$z].']';
			echo '<tr align="center"><td height="'.$suma_wysokosc_wiersza[$z].'px">';
			$SUMA_WARTOSC_BRUTTO_ZAMOWIENIE[$inne_zamowienie_id[$z]] = change($SUMA_WARTOSC_BRUTTO_ZAMOWIENIE[$inne_zamowienie_id[$z]]);
			echo '<input type="text" id="'.$input_id_suma_brutto.'" class="pole_input_biale_bez_ramki" value="'.$SUMA_WARTOSC_BRUTTO_ZAMOWIENIE[$inne_zamowienie_id[$z]].'" readonly="readonly" size="7" name="'.$inne_wartosc_brutto[$z].'">'.$waluta;
			echo '</td></tr>';
			}
		echo '</table>';
		echo '</td>';
		
		
		//pobieram pozostałe dane pozycji zlecenia
		$pytanie154 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' AND klient_id=".$klient.";");
		while($wynik154= mysqli_fetch_assoc($pytanie154))
			{
			$data_dostawy=$wynik154['data_dostawy'];
			$zamowienie_id_0 = $wynik154['zamowienie_id'];
			$uwagi=$wynik154['uwagi'];
			$kolejnosc = $wynik154['kolejnosc'];

			//pobieram dane z pozycji 1
			if($wynik154['pozycja_wyceny'] == 1 || ($zamowienie_id_0 == 0))
				{
				$odbior_material = $wynik154['odbior_material'];
				$odbior_szablon = $wynik154['odbior_szablon'];
				$zwrot_material = $wynik154['zwrot_material'];
				$zwrot_szablon = $wynik154['zwrot_szablon'];
				$zwrot_uszczelki = $wynik154['zwrot_uszczelki'];
				}
			}
		echo '<INPUT type="hidden" name="kolejnosc" value="'.$kolejnosc.'">';
		
		echo '<td>';
			echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td><input type="text" size="10" maxlength="20" class="pole_input_biale" autocomplete="off" name="data_dostawy" id="f_date_c" value="'.$data_dostawy.'"/></td></tr></table>';
			?>
				<script type="text/javascript">
				Calendar.setup({
				inputField     :    "f_date_c",     // id of the input field
				ifFormat       :    "%d-%m-%Y",      // format of the input field
				button         :    "f_date_c",  // trigger for the calendar (button ID)
				singleClick    :    true
				});
				</script>
			<?php
		echo '</td>';

		// uwagi
		echo '<td><textarea name="uwagi" cols="30" rows="5" class="pole_input_biale">'.$uwagi.'</textarea></td>';
		
		if($odbior_material == 'on') $odbior_material = ' checked';
		if($odbior_szablon == 'on') $odbior_szablon = ' checked';
		if($zwrot_material == 'on') $zwrot_material = ' checked';
		if($zwrot_szablon == 'on') $zwrot_szablon = ' checked';
		if($zwrot_uszczelki == 'on') $zwrot_uszczelki = ' checked';

		// odbior
		echo '<td>';
			echo '<table border="0" class="text" cellpadding="2" cellspacing="2">';
			echo '<tr><td width="10%" align="left"><input type="checkbox" name="odbior_material" '.$odbior_material.'></td><td width="90%" align="left">Materiał</td></tr>';
			echo '<tr><td width="10%" align="left"><input type="checkbox" name="odbior_szablon" '.$odbior_szablon.'></td><td width="90%" align="left">Szablon</td></tr>';
			echo '</table>';
		echo '</td>';
		
		// zwrot
		// echo '<td>';
		// 	echo '<table border="0" class="text" cellpadding="2" cellspacing="2">';
		// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_material" '.$zwrot_material.'></td><td width="90%" align="left">Materiał</td></tr>';
		// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_szablon" '.$zwrot_szablon.'></td><td width="90%" align="left">Szablon</td></tr>';
		// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_uszczelki" '.$zwrot_uszczelki.'></td><td width="90%" align="left">Uszczelka</td></tr>';
		// 	echo '</table>';
		// echo '</td>';
		
		echo '</tr></table>';
	
	echo '</tr></td>';
	
	echo '<tr class="Text"><td align="center" colspan="4" class="text_red">';
	echo 'Zaznacz, aby usunąć pozycję ze zlecenia transportowego <input type="checkbox" name="usunac" value="1"><br>';
	echo '</td></tr>';

	echo '<tr><td align="center"><INPUT type="submit" name="zapisz" value="Zapisz"></td></tr>';
	echo '</table>';
	echo $powrot_do_konkretnego_zlecenia_transportowego;
	echo '</FORM>';
} ///	if((!$result) && ($zapisz != 'Dalej') && ($etap == 2))
?>