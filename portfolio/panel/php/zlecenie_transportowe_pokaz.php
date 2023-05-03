<?php
//status ma zawsze byc Potweirdzone
if(($nr_zlecenia_transportowego == 'Kurier') || ($nr_zlecenia_transportowego == 'Odbiór własny')) 
{
	$status = 'Potwierdzone';
	$sposob_dostawy = $nr_zlecenia_transportowego;
}

if($usunac == 1)
	{
	//ustawiamy puste zlecenie transportowe dla każdego zamówienia z usuwanego zlec transp
	$pytanie15 = mysqli_query($conn, "SELECT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
	while($wynik15= mysqli_fetch_assoc($pytanie15))
		{
		$zamowienie_id=$wynik15['zamowienie_id'];
		$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
		}
	// usuwamy zlec transp
	mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."';");
	mysqli_query($conn, "DELETE FROM zlecenia_transportowe_naglowek WHERE nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."';");
	
	echo '<div align="center" class="text_duzy_niebieski"><br>Zlecenie transportowe zostało usunięte z bazy</div>';
	}
elseif($zapisz == 'Zapisz')
	{
	if($nowy_sposob_dostawy != '')	
		{
		echo '<div class="text_green" align="center">Dodano nowy sposób dostawy do bazy</div>';
		$pytanie = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`)  values ('sposob_dostawy', '$nowy_sposob_dostawy');");
		$sposob_dostawy = $nowy_sposob_dostawy;
		}

	// sprawdzam status - jak w drodze do klienta
	if($status == 'W drodze do klienta')
		{
		$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET status = 'W drodze do klienta' WHERE id = ".$zlecenie_transportowe_id.";");		
		$pytanie15 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND zamowienie_id <> 0 ORDER BY zamowienie_id ASC;");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			{
			$zam_id=$wynik15['zamowienie_id'];
			$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET status = 'W drodze do klienta' WHERE id = ".$zam_id.";");
			}		
		echo '<div class="text_duzy_niebieski" align="center">Status zamówień został zmieniony na : W drodze do klienta.</div>';
		}
		
	if($status != 'Dostarczone')
		{
		$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET sposob_dostawy = '".$sposob_dostawy."' WHERE id = ".$zlecenie_transportowe_id.";");
		$pytanie123 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET kierowca = '".$kierowca."' WHERE id = ".$zlecenie_transportowe_id.";");
		$pytanie124 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET data_zaladunku = '".$data_zaladunku."' WHERE id = ".$zlecenie_transportowe_id.";");
		$pytanie125 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET data_wyjazdu = '".$data_wyjazdu."' WHERE id = ".$zlecenie_transportowe_id.";");
		$pytanie125 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET status = '".$status."' WHERE id = ".$zlecenie_transportowe_id.";");
		$pytanie125 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET strefa = '".$strefa."' WHERE id = ".$zlecenie_transportowe_id.";");
		}
		
	//zmiana kolejności i zapisywanie sumy pobran brutto
	$pytanie157 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
	while($wynik157= mysqli_fetch_assoc($pytanie157))
		{
		$kolejnosc=$wynik157['kolejnosc'];
		$klient_id=$wynik157['klient_id'];
		$pytanie666 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET kolejnosc = ".$KOLEJNY_NUMER[$klient_id]." WHERE klient_id = ".$klient_id." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
		$nazwa_suma_pobran_brutto[$klient_id] = change($nazwa_suma_pobran_brutto[$klient_id]);
		$pytanie666 = "UPDATE zlecenia_transportowe_tresc SET suma_pobran_brutto = ".$nazwa_suma_pobran_brutto[$klient_id]." WHERE klient_id = ".$klient_id." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';";
		mysqli_query($conn, $pytanie666);

		$nazwa_suma_do_zaplaty[$klient_id] = change($nazwa_suma_do_zaplaty[$klient_id]);
		//sprawdzamy czy suma pobran brutto została edytowana - tzn jest inna niż suma do zapłaty z faktur
		if($nazwa_suma_do_zaplaty[$klient_id] != $nazwa_suma_pobran_brutto[$klient_id]) 
			{
				$pytanie666 = "UPDATE zlecenia_transportowe_tresc SET suma_pobran_brutto_edycja = 'tak' WHERE klient_id = ".$klient_id." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';";
				mysqli_query($conn, $pytanie666);
			}
		}

	// tabelka potwierdzająca zamknięcie zleceń transportowych
	if(($status == "Dostarczone") && ($zamykam_zlecenie == 0))
		{
			$zamowienie_id = [];
			$blad_o_braku_faktury = [];
		echo '<div class="text_duzy" align="center">Wybierz zamówienia które zostały dostarczone:</div><br>';
		$ilosc_zamowien_do_zamkniecia = 0;
		$pytanie4 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND zamowienie_id <> 0 ORDER BY zamowienie_id ASC;");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$ilosc_zamowien_do_zamkniecia++;
			$zamowienie_id[$ilosc_zamowien_do_zamkniecia] = $wynik4['zamowienie_id'];
			}
		
		for ($z=1; $z<=$ilosc_zamowien_do_zamkniecia; $z++)
			{
			$blad_o_braku_faktury[$zamowienie_id[$z]] = '';
			$pytanie45 = mysqli_query($conn, "SELECT nr_faktury, data_faktury FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$z]." AND (nr_faktury = '' OR data_faktury = '') ;");
			while($wynik45= mysqli_fetch_assoc($pytanie45))
				{
				$blad_o_braku_faktury[$zamowienie_id[$z]] = 'BRAK NR FV';
				}
			}		
		
		echo '<FORM action="index.php?page=zlecenie_transportowe_pokaz" method="post">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="zlecenie_transportowe_id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="nr_zlecenia_transportowego" value="'.$nr_zlecenia_transportowego.'">';
		echo '<INPUT type="hidden" name="zamykam_zlecenie" value="1">';
		echo '<INPUT type="hidden" name="status" value="'.$status.'">';
		
		echo '<table align="center" border="0" cellpadding="1" class="tabela">';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td width="45%" height="25px">'.$kol_nr_zamowienia_arcus2.'</td>';
		echo '<td width="45%" height="25px">'.$kol_nr_zamowienia_klienta2.'</td>';
		echo '<td width="10%" height="25px">Dostarcz</td></tr>';
		
		$inne_nr_zamowienia = [];
		$inne_nr_zamowienia_klienta = [];

		for ($z=1; $z<=$ilosc_zamowien_do_zamkniecia; $z++)
			{
			$pytanie3 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id[$z].";");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$inne_nr_zamowienia[$z]=$wynik3['nr_zamowienia'];
				$inne_nr_zamowienia_klienta[$z]=$wynik3['nr_zamowienia_klienta'];
				}
			//sprawdzam czy są nr faktur, jak nie ma to odznaczam zamknięcie zamówienia
			if($blad_o_braku_faktury[$zamowienie_id[$z]] == 'BRAK NR FV') 
				{
				echo '<tr align="center" bgcolor="#0cfb06" class="text"><td width="45%" height="25px">'.$inne_nr_zamowienia[$z].' '.$blad_o_braku_faktury[$zamowienie_id[$z]].'</td>';
				$checked = '';
				}
			else 
				{
				echo '<tr align="center" bgcolor="'.$kolor_bialy.'" class="text"><td width="45%" height="25px">'.$inne_nr_zamowienia[$z].'</td>';
				$checked = ' checked';
				}
			
			echo '<td width="45%">'.$inne_nr_zamowienia_klienta[$z].'</td>';
			$nazwa_suma = 'nazwa_suma['.$zamowienie_id[$z].']';
			echo '<td width="10%"><input type="checkbox" '.$checked.' name="'.$nazwa_suma.'"></tr>';
			}
		echo '</table>';
		echo '<br><div align="center"><INPUT type="submit" name="zapisz" value="Zapisz"></div>';
		echo '</form>';
		//$zamykam_zlecenie = 1;
		}
	elseif(($status == "Dostarczone") && ($zamykam_zlecenie == 1))
		{
		//zamykam zlecenie transportowe
		//szukam ilosc zamowien
		$pytanie15 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND zamowienie_id <> 0 ORDER BY zamowienie_id ASC;");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			{
			$zamowienie_id=$wynik15['zamowienie_id'];

			//sprawdzamy czy zamówienie nie jest zablokowane przed zamykaniem.
			$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT zablokowac, nr_zamowienia FROM zamowienia WHERE id = ".$zamowienie_id.";"));
			$zablokowac = $sql['zablokowac'];
			$nr_zamowienia2 = $sql['nr_zamowienia'];
			
			if($zablokowac != 'on')
				{
				// echo 'zam id = '.$zamowienie_id.'<br>';
				if($nazwa_suma[$zamowienie_id] == 'on') 
					{
					//  echo 'zamówienie zahaczone<br>';
					//szukamy ilosc pozycji dla kazdej wyceny
					$pytanie127 = mysqli_query($conn, "SELECT ilosc_pozycji FROM wyceny WHERE zamowienie_id=".$zamowienie_id." LIMIT 1;");
					while($wynik127= mysqli_fetch_assoc($pytanie127))
						$ilosc_pozycji_zamowienia[$z]=$wynik127['ilosc_pozycji'];
					
					$ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id] = 0;


					//sprawdzamy ile pozycji jest w zleceniu transportowym
					for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++)
						{
						$tabela_z_pozycjami_wyceny[$zamowienie_id][$y] = 0;
						$pytanie1273 = mysqli_query($conn, "SELECT pozycja_wyceny FROM zlecenia_transportowe_tresc WHERE zamowienie_id=".$zamowienie_id." AND pozycja_wyceny = ".$y.";");
						while($wynik1273= mysqli_fetch_assoc($pytanie1273))
							{
							$ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id]++;
							$tabela_z_pozycjami_wyceny[$zamowienie_id][$y] = 1; // jezeli 1 to pozycja jest w wycenie
							}
						}
						
					$brak = 0;
					$ile_pozycji = 0;
					//sprawdzamy czy jest wystawiona faktura do tej wyceny
					$pytanie33 = mysqli_query($conn, "SELECT nr_faktury, data_faktury, nr_zamowienia, pozycja FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." ORDER BY pozycja ASC;");
					while($wynik33= mysqli_fetch_assoc($pytanie33))
						{
						$ile_pozycji++;
						$nr_faktury[$ile_pozycji]=$wynik33['nr_faktury'];
						$data_faktury[$ile_pozycji]=$wynik33['data_faktury'];
						$nr_zamowienia=$wynik33['nr_zamowienia'];
						if($nr_faktury[$ile_pozycji] == '') $brak++;
						if($data_faktury[$ile_pozycji] == '') $brak++;
						}
						
					for($pozycja = 1; $pozycja <= $ile_pozycji; $pozycja++)
						{
						if(($nr_faktury[$pozycja] == '') || ($data_faktury[$pozycja] == '')) echo '<div align="center" class="text_duzy_czerwony"><br>Zamówienie '.$nr_zamowienia.' (ID='.$zamowienie_id.') NIE zostało zamknięte. Brak numeru faktury lub daty faktury w wycenie pozycja nr '.$pozycja.'</div><br>';
						elseif($brak == 0)
							{
							if($ilosc_pozycji_zamowienia[$z] == $ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id])  // całe zamówienie pojechało - zamykam
								{
								$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET status = 'Dostarczone' WHERE id = ".$zamowienie_id.";");
								$pytanie666 = mysqli_query($conn, "UPDATE wyceny SET status = 'Dostarczone' WHERE zamowienie_id = ".$zamowienie_id.";");
								}
							// te zamówienia nie zostały dostarczone w całości - brak niektórych pozycji
							else 
								{
								for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++) 
									{
									//echo '2<br>';
									if($tabela_z_pozycjami_wyceny[$zamowienie_id][$y] == 0) $pytanie666 = mysqli_query($conn, "UPDATE wyceny SET status = 'W realizacji' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$y.";");	// if $tabela_z_pozycjami_wyceny[$zamowienie_id][$y] == 0 oznacza ze pozycja NIE została dostarczona!!
									else $pytanie666 = mysqli_query($conn, "UPDATE wyceny SET status = 'Dostarczone' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$y.";");
									}
								$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET status = 'W realizacji' WHERE id = ".$zamowienie_id.";");
								$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
								}
							}
						//echo '<br><br>############################################################################<br><br>';
						}						

					} // do if($nazwa_suma[$zamowienie_id] == 'on') 
				else 
					{
					// zamowienie nie zostało dostarczone, zostały odhaczone wcześniej
					//  echo 'zam nie zahaczone<br>';
					$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET status = '' WHERE id = ".$zamowienie_id.";");
					$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
					}
				} 
			else 
				{
				$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET status = '' WHERE id = ".$zamowienie_id.";");
				$pytanie666 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
				echo '<div class="text_duzy_czerwony" align="center">Zamówienie '.$nr_zamowienia2.' jest zablokowane i nie zostało zamknięte.</div><br>';	
				}
			}

		$pytanie125 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET status = '".$status."' WHERE id = ".$zlecenie_transportowe_id.";");
		echo '<div class="text_duzy_niebieski" align="center">Zlecenie transportowe zostało zamknięte.</div><br>';	
		}
	else echo '<div class="text_duzy_niebieski" align="center">Dane zlecenia transportowego zostały zmienione.</div><br>';	
	if($zamykam_zlecenie != 1) echo $powrot_do_konkretnego_zlecenia_transportowego;
	}
else
	{
	//##############################################################################################################################################
	//########################################################  NAGŁOWEK       #####################################################################
	//##############################################################################################################################################

	//deklaracja tablic
		$data_faktury = [];
		$blad_o_braku_faktury = [];
		$inne_nr_zamowienia = [];
		$inne_nr_zamowienia_klienta = [];
		$nazwa_suma = [];
		$tabela_z_pozycjami_wyceny = [];
		$tabela_z_pozycjami_wyceny_status = [];
		$ilosc_pozycji_w_zleceniu_transportowym = [];
		$informacja_o_ilosci_pozycji = [];
		$nr_zamowienia = [];
		$nr_zamowienia_klienta = [];
		$zamowienie_data_wysylki_potwierdzenia_dostawy = [];
		$zamowienie_link_dostawa = [];
		$status_zamowienia = [];
		$nr_faktury = [];
		$ilosc_pozycji_zamowienia = [];
		$nr_faktury_sort = [];
		$klient_id = [];
		$zalega = [];
		$data_dostawy = [];
		$numer_wz = [];
		$uwagi = [];
		$kolejnosc = [];
		$data_dostarczenia = [];
		$podpis_imie_nazwisko = [];
		$podpis_link = [];
		$odbior_material = [];
		$odbior_szablon = [];
		$zwrot_material = [];
		$zwrot_szablon = [];
		$zwrot_uszczelki = [];
		$zamowienie_id = [];
		$sposob_platnosci = [];
		$status_id = [];
		$status_opis = [];
		$sposob_dostawy_id = [];
		$sposob_dostawy_opis = [];
		$kierowca_id = [];
		$kierowca_opis = [];
		$SUMA_DO_ZAPLATY = [];
		$napis_edytowano = [];
		$styl = [];
		$odbior_klient_nazwa = [];
		$odbior_nr_zamowienia = [];
		$strefa_straceni_klienci_id = [];
		$strefa_straceni_klienci = [];
		$strefa_aktywni_klienci_id = [];
		$strefa_aktywni_klienci = [];
		$strefa_potencjalni_klienci_id = [];
		$strefa_potencjalni_klienci = [];
		$ilosc_pozycji_zamowienia = [];
		$ilosc_pozycji_w_zleceniu_transportowym = [];
		$tabela_z_pozycjami_wyceny = [];
		$inne_nr_zamowienia_klienta = [];
		$nazwa_suma = [];

	$pytanie3 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE id = $id;");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$nr_zlecenia_transportowego=$wynik3['nr_zlecenia_transportowego'];
		$typ=$wynik3['typ'];
		$data_zaladunku=$wynik3['data_zaladunku'];
		$data_wyjazdu=$wynik3['data_wyjazdu'];
		$kierowca=$wynik3['kierowca'];
		$sposob_dostawy=$wynik3['sposob_dostawy'];
		$status=$wynik3['status'];
		$w_drodze_do_klienta=$wynik3['w_drodze_do_klienta'];
		$strefa = $wynik3['strefa'];
		}
	
	//liczymy sume brutto zlecenia transp
	$SUMA_BRUTTO = 0;
	$pytanie15 = mysqli_query($conn, "SELECT kwota_brutto, zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
	while($wynik15= mysqli_fetch_assoc($pytanie15))
		{
		$kwota_brutto=$wynik15['kwota_brutto'];
		//sprawdzamy czy zlec transp to odbiór osobisty lub kurier. jezeli tak, to sprawdzamy status zamowienia, czy nie jest zamknięte. Jak dostarczone, anulowane lub odebrane to nie liczymy sumy i nie wyswietlamy na liście w zlec transp
		if(($nr_zlecenia_transportowego == 'Odbiór własny') || ($nr_zlecenia_transportowego == 'Kurier'))
		{
			$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM zamowienia WHERE id = ".$wynik15['zamowienie_id'].";"));
			if(($sql['status'] != 'Dostarczone') && ($sql['status'] != 'Odebrane') && ($sql['status'] != 'Anulowane'))
				$SUMA_BRUTTO += $kwota_brutto;
		}
		else $SUMA_BRUTTO += $kwota_brutto;
		}
	$SUMA_BRUTTO = change($SUMA_BRUTTO);
	$sql = "UPDATE zlecenia_transportowe_naglowek SET suma_zlecenia = ".$SUMA_BRUTTO." WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';";
	$pytanie122 = mysqli_query($conn, $sql);


	if($status == 'Dostarczone') $disabled = 'disabled'; else $disabled = '';
	echo '<table width="60%" align="center" border="0" cellpadding="3"><tr><td align="center" valign="top">';
		
	echo '<div class="text_duzy_tlo" align="center">Zlecenie transportowe '.$nr_zlecenia_transportowego.'</div><br>';
	
	echo '<FORM action="index.php?page=zlecenie_transportowe_pokaz" method="post">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<INPUT type="hidden" name="zlecenie_transportowe_id" value="'.$id.'">';
	echo '<INPUT type="hidden" name="nr_zlecenia_transportowego" value="'.$nr_zlecenia_transportowego.'">';
	echo '<INPUT type="hidden" name="id" value="'.$id.'">';
	echo '<INPUT type="hidden" name="zamykam_zlecenie" value="0">';
	
		echo '<table width="60%" align="center" border="0" cellpadding="3">';

		//dla zleceń Kurier i odbiór własny brak możliwości zmiany opcji w nagłówku
		if(($nr_zlecenia_transportowego == 'Kurier') || ($nr_zlecenia_transportowego == 'Odbiór własny')) $tylko_do_odczytu = ' disabled '; else $tylko_do_odczytu = '';

		// sposób dostawy
		$ilosc_sposobow_dostawy = 0;
		$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_dostawy' ORDER BY opis ASC;");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$ilosc_sposobow_dostawy++;
			$sposob_dostawy_id[$ilosc_sposobow_dostawy] = $wynik2['id'];
			$sposob_dostawy_opis[$ilosc_sposobow_dostawy] = $wynik2['opis'];
			}
		echo '<tr align="center" class="text"><td align="right">'.$kol_sposob_dostawy.' : </td><td align="left" width="200px">';
		echo '<select name="sposob_dostawy" class="pole_input_biale" style="width: 200px" '.$disabled.' '.$tylko_do_odczytu.'>';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_sposobow_dostawy; $k++) 
		if($sposob_dostawy == $sposob_dostawy_opis[$k]) echo '<option selected="selected" value="'.$sposob_dostawy_opis[$k].'">'.$sposob_dostawy_opis[$k].'</option>';
		else echo '<option value="'.$sposob_dostawy_opis[$k].'">'.$sposob_dostawy_opis[$k].'</option>';
		echo '</select>';
		echo '</td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" '.$disabled.' '.$tylko_do_odczytu.' class="pole_input_biale" name="nowy_sposob_dostawy" value="'.$nowy_sposob_dostawy.'"></td></tr>';
	
		if(($nr_zlecenia_transportowego != 'Kurier') && ($nr_zlecenia_transportowego != 'Odbiór własny'))
		{
			// kierowca
			$ilosc_kierowcow = 0;
			$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'kierowca' AND aktywny = 'on' ORDER BY id ASC;");
			while($wynik2= mysqli_fetch_assoc($pytanie2))
				{
				$ilosc_kierowcow++;
				$kierowca_id[$ilosc_kierowcow] = $wynik2['id'];
				$kierowca_opis[$ilosc_kierowcow] = $wynik2['imie'].' '.$wynik2['telefon'];
				}
			echo '<tr align="center" class="text"><td align="right">'.$kol_kierowca.' : </td><td align="left">';
			echo '<select name="kierowca" class="pole_input_biale" style="width: 200px" '.$disabled.' '.$tylko_do_odczytu.'>';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_kierowcow; $k++) 
			if($kierowca == $kierowca_id[$k]) echo '<option selected="selected" value="'.$kierowca_id[$k].'">'.$kierowca_opis[$k].'</option>';
			else echo '<option value="'.$kierowca_id[$k].'">'.$kierowca_opis[$k].'</option>';
			echo '</select>';
			echo '</td><td colspan="2"></td></tr>';
		
		
			// strefa
			echo '<tr align="center" class="text"><td align="right">'.$kol_strefa.' : </td><td align="left">';
			echo '<select name="strefa" class="pole_input_biale"  '.$disabled.' '.$tylko_do_odczytu.'>';
			for($k=1; $k<=$DL_TABELA_STREFY; $k++)
				if($strefa == $TABELA_STREFY[$k]) echo '<option selected="selected" value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
				else echo '<option value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
			echo '</select>';
			echo '</td><td colspan="2"></td></tr>';	
		
			echo '<tr align="center"><td align="right" class="text">'.$kol_data_zaladunku.' : </td><td align="left">';         
			echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td><input type="text" size="10" maxlength="20" class="pole_input_biale" autocomplete="off" '.$disabled.'  '.$tylko_do_odczytu.' name="data_zaladunku" id="f_date_c" value="'.$data_zaladunku.'"/></td></tr></table>';
			?>
			<script type="text/javascript">
				Calendar.setup({
					inputField     :    "f_date_c",     // id of the input field
					ifFormat       :    "%d-%m-%Y",      // format of the input field
					button         :    "f_date_c",  // trigger for the calendar (button ID)
					singleClick    :    true
				});
			</script>
			</td><td></td><td></td></tr>	
			<?php
			echo '<tr align="center"><td align="right" class="text">'.$kol_data_wyjazdu.' : </td><td align="left">';         
			
			echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td><input type="text" size="10" maxlength="20" readonly="readonly" class="pole_input_biale" autocomplete="off" '.$disabled.' '.$tylko_do_odczytu.' name="data_wyjazdu" id="f_date_d" value="'.$data_wyjazdu.'"/></td></tr></table>';
			?>
			<script type="text/javascript">
				Calendar.setup({
					inputField     :    "f_date_d",     // id of the input field
					ifFormat       :    "%d-%m-%Y",      // format of the input field
					button         :    "f_date_d",  // trigger for the calendar (button ID)
					singleClick    :    true
				});
			</script>
			</td><td></td><td></td></tr>	
			<?php
		}
		// status
		$ilosc_statusow = 0;
		$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status_zlec_trans' ORDER BY opis ASC;");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$ilosc_statusow++;
			$status_id[$ilosc_statusow] = $wynik2['id'];
			$status_opis[$ilosc_statusow] = $wynik2['opis'];
			}
		echo '<tr align="center" class="text"><td align="right">'.$kol_status.' : </td><td align="left">';
		echo '<select name="status" class="pole_input_biale" style="width: 200px" '.$disabled.' '.$tylko_do_odczytu.'>';
		for ($k=1; $k<=$ilosc_statusow; $k++) 
		if($status == $status_opis[$k]) echo '<option selected="selected" value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
		else echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
		echo '</select>';
		echo '</td><td colspan="2"></td></tr>';
	
		if(($status != 'Dostarczone') && ($nr_zlecenia_transportowego != 'Kurier') && ($nr_zlecenia_transportowego != 'Odbiór własny'))
			{
			echo '<tr class="text"><td align="center" colspan="4" class="text_red">';
			echo 'Zaznacz, aby usunąć zlecenie transportowe <input type="checkbox" name="usunac" value="1"><br>';
			echo '</td></tr>';
			}
		echo '</table>';
	
	echo '</td></tr></table>';

//##############################################################################################################################################
//######################################################## KONIEC NAGŁOWKA #####################################################################
//##############################################################################################################################################

echo '<table width="100%" align="center" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
$ilosc_klientow = 0;
$pytanie37 = mysqli_query($conn, "SELECT DISTINCT klient_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' ORDER BY kolejnosc ASC;");
while($wynik37= mysqli_fetch_assoc($pytanie37))
	{
	//tylko w przypadku zleceń kurier i odbiór własny
	if(($nr_zlecenia_transportowego == 'Kurier') || ($nr_zlecenia_transportowego == 'Odbiór własny'))
		{
		//sprawdzamy czy dany klient ma jakieś zamówienie któego status jest inny niż dostarczone.
		$temp_klient_id=$wynik37['klient_id'];
		$ilosc_zamowien_niedostarczonych[$temp_klient_id] = 0;
		$pytanie15 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$temp_klient_id.";");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			{
			$temp_zamowienie_id=$wynik15['zamowienie_id'];
			$pytanie125 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id=".$temp_zamowienie_id." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane';");
			while($wynik125= mysqli_fetch_assoc($pytanie125))
				$ilosc_zamowien_niedostarczonych[$temp_klient_id] += 1;
			}

		//jak ilość zamówień ze statusem innym niż dostarczone jest większa niż 0 to dodajemy klienta do listy w zleceniu transportowym
		if($ilosc_zamowien_niedostarczonych[$temp_klient_id] != 0)
			{
			$ilosc_klientow++;
			$klient_id[$ilosc_klientow]=$wynik37['klient_id'];
			//sprawdzamy czy klient ma zaleg le faktury po terminie
			$zalega[$klient_id[$ilosc_klientow]] = $image_green_dot_mini;
			$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE zaplacona = 'nie' AND termin_platnosci < '".$time."' AND nabywca_id =".$klient_id[$ilosc_klientow]." AND typ_dok = 'Faktura';");
			while($wynik22= mysqli_fetch_assoc($pytanie22))
				$zalega[$klient_id[$ilosc_klientow]] = $image_red_dot_mini;
			}
		}
	else
		{
		$ilosc_klientow++;
		$klient_id[$ilosc_klientow]=$wynik37['klient_id'];
		
		//sprawdzamy czy klient ma zaleg le faktury po terminie
		$zalega[$klient_id[$ilosc_klientow]] = $image_green_dot_mini;
		$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE zaplacona = 'nie' AND termin_platnosci < '".$time."' AND nabywca_id =".$klient_id[$ilosc_klientow]." AND typ_dok = 'Faktura';");
		while($wynik22= mysqli_fetch_assoc($pytanie22))
			$zalega[$klient_id[$ilosc_klientow]] = $image_red_dot_mini;
		}




	// echo 'dla klienta id='.$temp_klient_id.' jest '.$ilosc_zamowien_niedostarczonych[$temp_klient_id].' zamowien<br>';
	}
for ($x=1; $x<=$ilosc_klientow; $x++)
	{
	$pytanie343 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$x].";");
	while($wynik343= mysqli_fetch_assoc($pytanie343))
		{
		$data_dostawy[$x]=$wynik343['data_dostawy'];
		$numer_wz[$x]=$wynik343['numer_wz'];
		$uwagi[$x]=$wynik343['uwagi'];
		$kolejnosc[$x] = $wynik343['kolejnosc'];
		$data_dostarczenia[$x] = $wynik343['data_dostarczenia'];
		$podpis_imie_nazwisko[$x] = $wynik343['podpis_imie_nazwisko'];
		$podpis_link[$x] = $wynik343['podpis_link'];
		$odbior_material[$x] = $wynik343['odbior_material'];
		$odbior_szablon[$x] = $wynik343['odbior_szablon'];
		$zwrot_material[$x] = $wynik343['zwrot_material'];
		$zwrot_szablon[$x] = $wynik343['zwrot_szablon'];
		$zwrot_uszczelki[$x] = $wynik343['zwrot_uszczelki'];
		}
	}
		
	//#######################################################################     tabela główna z listą zamówień    ##############################################################################################
	$szer_kol_lp = 10;
	$szer_kol_klient = 120;
	$szer_kol_adres_dostawy = 150;
	$szer_kol_numery = 300;
	$szer_kol_pozycje = 130;
	$szer_kol_status = 120;
	$szer_kol_suma_zam = 100;
	$szer_kol_suma_pobran = 100;
	$szer_kol_status_platnosci = 70;
	$szer_kol_data_dostawy = 80;
	$szer_kol_uwagi = 200;
	$szer_kol_odior = 100;
	$szer_kol_zwrot = 240;
	$szer_kol_pod_zwrotami = 60;
	$szer_kol_liczba_paczek = 100;
	$szer_kol_podpis = 100;
	$szerokosc_tabeli = $szer_kol_lp + $szer_kol_klient + $szer_kol_adres_dostawy + $szer_kol_numery + $szer_kol_pozycje + $szer_kol_status + $szer_kol_suma_zam + $szer_kol_suma_pobran + $szer_kol_status_platnosci + $szer_kol_data_dostawy + $szer_kol_uwagi + $szer_kol_odior + $szer_kol_zwrot + $szer_kol_liczba_paczek + $szer_kol_podpis;
	
if($ilosc_klientow != 0)
{
	echo '<table align="center" class="tabela" width="'.$szerokosc_tabeli.'px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
	echo '<td width="'.$szer_kol_lp.'px" rowspan="2">'.$kol_lp.'</td>';
	echo '<td width="'.$szer_kol_klient.'px" rowspan="2">'.$kol_klient.'</td>';
	echo '<td width="'.$szer_kol_adres_dostawy.'px" rowspan="2">'.$kol_adres_dostawy.'</td>';
	echo '<td width="'.$szer_kol_numery.'px" rowspan="2">';
		echo '<table width="100%" align="center" border="0" cellpadding="3" class="text">';
		echo '<tr align="center"><td width="32%" height="30px">Nr zam ARCUS</td>';
		echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
		echo '<td width="32%" height="30px">Nr zam klienta</td>';
		echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
		echo '<td width="32%" height="30px">Nr faktury</td></tr>';
		echo '</table>';		
	echo '</td>';
	echo '<td width="'.$szer_kol_pozycje.'px" rowspan="2">'.$kol_pozycje_zamowienia.'</td>';
	echo '<td width="'.$szer_kol_status.'px" rowspan="2">'.$kol_status_zamowien.'</td>';
	echo '<td width="'.$szer_kol_suma_zam.'px" rowspan="2">'.$kol_suma_zamowien_brutto.'</td>';
	echo '<td width="'.$szer_kol_suma_pobran.'px" rowspan="2">'.$kol_suma_pobran_brutto.'</td>';
	echo '<td width="'.$szer_kol_status_platnosci.'px" rowspan="2">'.$kol_status_platnosci.'</td>';
	echo '<td width="'.$szer_kol_data_dostawy.'px" rowspan="2">'.$kol_data_dostawy.'</td>';
	echo '<td width="'.$szer_kol_uwagi.'px" rowspan="2">'.$kol_uwagi.'</td>';
	echo '<td width="'.$szer_kol_odior.'px" rowspan="2">'.$kol_odbior.'</td>';
	echo '<td width="'.$szer_kol_zwrot.'px" colspan="4">'.$kol_zwrot.'</td>';
	echo '<td width="'.$szer_kol_liczba_paczek.'px" rowspan="2">'.$kol_liczba_paczek.'</td>';
	echo '<td width="'.$szer_kol_podpis.'px" rowspan="2">'.$kol_podpis.'</td>';
	echo '</tr>';

	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
	echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_szablony_przy_wyrobach.'</td>';
	echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_szablony_luzem.'</td>';
	echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_profile.'</td>';
	echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_uszczelki.'</td>';
	echo '</tr>';
	//############################################################################################################################################################################################################ 


$kol_szablony_przy_wyrobach = 'Szablony przy wyrobach';
$kol_szablony_luzem = 'Szablony luzem';
$kol_profile = 'Profile';
$kol_uszczelki = 'Uszczelki';

	$SUMA_POBRAN_BRUTTO = 0;
	for ($k=1; $k<=$ilosc_klientow; $k++)
		{
		echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
		$KOLEJNY_NUMER = 'KOLEJNY_NUMER['.$klient_id[$k].']';
		echo '<td bgcolor="'.$kolor_tabeli.'" class="text"><INPUT type="text" name="'.$KOLEJNY_NUMER.'" autocomplete="off" value="'.$kolejnosc[$k].'" class="pole_input_kolejnosc" style="width: 25px" '.$disabled.'></td>';
		
		$pytanie14 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id[$k].";");
		while($wynik14= mysqli_fetch_assoc($pytanie14))
			{
			$klient_nazwa=$wynik14['nazwa'];
			$klient_ulica=$wynik14['dostawy_ulica'];
			$klient_miasto=$wynik14['dostawy_miasto'];
			$klient_kod_pocztowy=$wynik14['dostawy_kod_pocztowy'];
			$sposob_platnosci[$k]=$wynik14['sposob_platnosci'];
			}
		
		//#######################################################################    nazwa klienta     ################################################################################################################
		if($status != 'Dostarczone') echo '<td><a href="index.php?page=zlecenie_transportowe_edytuj&klient='.$klient_id[$k].'&id='.$id.'&nowy_numer_zlecenia='.$nr_zlecenia_transportowego.'&wg_czego='.$wg_czego.'&jak='.$jak.'"><font color="black">'.$klient_nazwa.'</font></a></td>';
		else echo '<td>'.$klient_nazwa.'</td>';
		echo '<td>'.$klient_ulica.'<br>'.$klient_kod_pocztowy.' '.$klient_miasto.'</td>';
			
		$edytowana_suma_pobran_brutto = [];
		$suma_pobran_brutto_ze_zlecenia = [];
		//ilosc zamowien
		$ilosc_zamowien = 0;
		$liczba_paczek_realizacja_produkcji = 0;
		$SUMA_BRUTTO_KLIENT = 0;
		$pytanie15 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$k]." ORDER BY zamowienie_id ASC;");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			{
			//tylko w przypadku zleceń kurier i odbiór własny
			if(($nr_zlecenia_transportowego == 'Kurier') || ($nr_zlecenia_transportowego == 'Odbiór własny'))
				{
				$temp_zamowienie_id=$wynik15['zamowienie_id'];
				//sprawdzamy status zamówienia - jak Dostarczone, to nie wyświetlamy na liście.
				$pytanie125 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id=".$temp_zamowienie_id.";");
				while($wynik125= mysqli_fetch_assoc($pytanie125))
						$temp_status=$wynik125['status'];
				}
			else $temp_status = '';

			if(($temp_status != 'Dostarczone') && ($temp_status != 'Odebrane') && ($temp_status != 'Anulowane'))
			{
				$ilosc_zamowien++;
				$zamowienie_id[$ilosc_zamowien]=$wynik15['zamowienie_id'];
				$pytanie152 = mysqli_query($conn, "SELECT kwota_brutto, suma_pobran_brutto_edycja, suma_pobran_brutto FROM zlecenia_transportowe_tresc WHERE zamowienie_id='".$zamowienie_id[$ilosc_zamowien]."' AND klient_id=".$klient_id[$k]." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
				while($wynik152= mysqli_fetch_assoc($pytanie152))
					{
					$SUMA_BRUTTO_KLIENT += $wynik152['kwota_brutto'];
					$edytowana_suma_pobran_brutto[$klient_id[$k]] = $wynik152['suma_pobran_brutto_edycja'];
					$suma_pobran_brutto_ze_zlecenia[$klient_id[$k]] = $wynik152['suma_pobran_brutto'];
					}

				//szukamy ilości paczek z realizacji produkcji
				$pytanie = mysqli_query($conn, "SELECT DISTINCT data_wykonania FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id[$ilosc_zamowien]." AND rodzaj_produktu = 10;");
				while($wynik= mysqli_fetch_assoc($pytanie))
					{
					$data_wykonania = $wynik['data_wykonania'];
					
					$pytanie21 = mysqli_query($conn, "SELECT ilosc_paczek FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id[$ilosc_zamowien]." AND data_wykonania = '".$data_wykonania."' LIMIT 1;");
					while($wynik21= mysqli_fetch_assoc($pytanie21))
						$liczba_paczek_realizacja_produkcji += $wynik21['ilosc_paczek'];
					}
				}	
			}
		//#######################################################################    NUMERY ZAMOWIEN     ################################################################################################################
		echo '<td>';
		
		// echo 'ilosc_zamowien='.$ilosc_zamowien.'<br>';
		$wysokosc_wiersza = 45;
		echo '<table width="100%" align="center" border="0" cellpadding="0" class="text">';
		for ($z=1; $z<=$ilosc_zamowien; $z++)
			{
			if($zamowienie_id[$z] != 0)
				{
				$pytanie12 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id=".$zamowienie_id[$z].";");
				while($wynik12= mysqli_fetch_assoc($pytanie12))
					{
					$nr_zamowienia[$z]=$wynik12['nr_zamowienia'];
					$nr_zamowienia_klienta[$z]=$wynik12['nr_zamowienia_klienta'];
					$zamowienie_data_wysylki_potwierdzenia_dostawy[$z]=$wynik12['data_wysylki_potwierdzenia_dostawy'];
					$zamowienie_link_dostawa[$z]=$wynik12['link_dostawa'];
					$status_zamowienia[$zamowienie_id[$z]]=$wynik12['status'];
					}
				echo '<tr align="center"><td width="32%" height="'.$wysokosc_wiersza.'px"><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zamowienie_id[$z].'&jak='.$jak.'&wg_czego='.$wg_czego.'&id_zlec_transp='.$id.'"><font color="black">'.$nr_zamowienia[$z].'</font></a></td>';
				echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
				echo '<td width="32%">'.$nr_zamowienia_klienta[$z].'</td>';
				echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
				// sprawdzamy nr faktur
				$temp = 0;
				$przynajmniej_jedna_faktura_wpisana = 0;
				$przynajmniej_jedna_faktura_pusta = 0;
				$pytanie123 = mysqli_query($conn, "SELECT nr_faktury, pozycja FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$z]." ORDER BY pozycja ASC");
				while($wynik123= mysqli_fetch_assoc($pytanie123))
					{
					$temp++;
					$nr_faktury[$temp] = '';
					$pozycja=$wynik123['pozycja'];
					$pytanie1273 = mysqli_query($conn, "SELECT pozycja_wyceny FROM zlecenia_transportowe_tresc WHERE zamowienie_id=".$zamowienie_id[$z]." AND pozycja_wyceny = ".$pozycja." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
					while($wynik1273= mysqli_fetch_assoc($pytanie1273))
						{
						$nr_faktury[$pozycja]=$wynik123['nr_faktury'];
						if($nr_faktury[$pozycja] != '') $przynajmniej_jedna_faktura_wpisana = 1;
						else $przynajmniej_jedna_faktura_pusta = 1;
						}
					}
				$ilosc_pozycji_zamowienia[$z] = $temp;

				$nr_faktury_sort = array_unique($nr_faktury);
				echo '<td width="32%">';
				if($przynajmniej_jedna_faktura_wpisana == 1)
					{
					for ($m=1; $m<=$ilosc_pozycji_zamowienia[$z]; $m++)	
					if($nr_faktury_sort[$m] != '') echo '<a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id[$z].'&jak=DESC&wg_czego=id&skad=zlecenie_transportowe&id_zlec_transp='.$id.'"><font color="black">'.$nr_faktury_sort[$m].'</font></a><br>';
					if($przynajmniej_jedna_faktura_pusta == 1) echo '<a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id[$z].'&jak=DESC&wg_czego=id&skad=zlecenie_transportowe&id_zlec_transp='.$id.'"><font color="red">BRAK NR FV</font></a>';
					}
				else echo '<a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id[$z].'&jak=DESC&wg_czego=id&skad=zlecenie_transportowe&id_zlec_transp='.$id.'"><font color="black">---</font></a>';
				echo '</td></tr>';
				} // do if($zamowienie_id[$z] != 0)
			else 
				{
				// JAK ODBIOR, CZYLI ZAMOWIENIE ID = 0, TO WSTAWIAMY SAME KRESECZKI
				echo '<tr align="center"><td width="32%" height="'.$wysokosc_wiersza.'px">---</td>';
				echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
				echo '<td width="32%">---</td>';
				echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
				echo '<td width="32%">---</td></tr>';
				//zerujemy zmienne, aby nie wyświetlał poprzednich
				$zamowienie_data_wysylki_potwierdzenia_dostawy[1] = '';
				$zamowienie_link_dostawa[1] = '';
				
				}
			} // do for ($z=1; $z<=$ilosc_zamowien; $z++)
		echo '</table>';
		echo '</td>';
		//#######################################################################    NUMERY ZAMOWIEN     #############################################################################################################



		//#################################################    sprawdzanie które pozycje wyceny są uwzględnione w zleceniu transportowym   ###########################################################################
		echo '<td>';
			echo '<table width="100%" align="center" border="0" cellpadding="3" class="text">';
			for ($z=1; $z<=$ilosc_zamowien; $z++)
				{
				if($zamowienie_id[$z] != 0)
					{
					$ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id[$z]] = 0;
					//sprawdzamy ile pozycji jest w zleceniu transportowym
					for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++)
						{
						$tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] = 0;
						$pytanie1273 = mysqli_query($conn, "SELECT pozycja_wyceny FROM zlecenia_transportowe_tresc WHERE zamowienie_id=".$zamowienie_id[$z]." AND pozycja_wyceny = ".$y." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
						while($wynik1273= mysqli_fetch_assoc($pytanie1273))
							{
							$ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id[$z]]++;
							$tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] = 1; // jezeli 1 to pozycja jest w wycenie
							}
						///sprawdzamy status każdej z pozycji
						$pytanie73 = mysqli_query($conn, "SELECT status FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$z]." AND pozycja = ".$y.";");
						while($wynik73= mysqli_fetch_assoc($pytanie73))
							{
							$tabela_z_pozycjami_wyceny_status[$zamowienie_id[$z]][$y] = $wynik73['status'];
							}
						}
					$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = '';
					if($ilosc_pozycji_zamowienia[$z] == $ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id[$z]]) $informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = "Wszystkie pozycje.  ";
					else
						{
						// sprawdzamy ktore pozycje dokładnie nie znajdują sie w zleceniu transportowym
						$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = 'Bez pozycji : ';
						for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++)
							{
							if($tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] == 0) if($tabela_z_pozycjami_wyceny_status[$zamowienie_id[$z]][$y] != 'Dostarczone') $informacja_o_ilosci_pozycji[$zamowienie_id[$z]] .= $y.', ';
							}
						if($informacja_o_ilosci_pozycji[$zamowienie_id[$z]] == 'Bez pozycji : ') 
							{
							$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = 'Pozycje : ';
							for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++) if($tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] == 1) $informacja_o_ilosci_pozycji[$zamowienie_id[$z]] .= $y.', ';
							}
						}

					$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = mb_substr($informacja_o_ilosci_pozycji[$zamowienie_id[$z]], 0, -2); //uwuwamy dw ostatnie znaki ze stringa
					echo '<tr class="text" align="center" height="'.$wysokosc_wiersza.'px"><td>'.$informacja_o_ilosci_pozycji[$zamowienie_id[$z]].'</td></tr>';
					} // if($zamowienie_id[$z] != 0)
				else echo '<tr class="text" align="center" height="'.$wysokosc_wiersza.'px"><td>---</td></tr>';
				} //for ($z=1; $z<=$ilosc_zamowien; $z++)
			echo '</table>';
		echo '</td>';
		//############################################################################################################################################################################################################ 
			
			
			
		//########################################################################   status zamówień   ############################################################################################################# 
		echo '<td>';
			echo '<table width="100%" align="center" border="0" cellpadding="3" class="text">';
			for ($z=1; $z<=$ilosc_zamowien; $z++) 
				{
				if($status_zamowienia[$zamowienie_id[$z]] == '') $status_zamowienia[$zamowienie_id[$z]] = '---';
				echo '<tr class="text" align="center" height="'.$wysokosc_wiersza.'px"><td>'.$status_zamowienia[$zamowienie_id[$z]].'</td></tr>';
				}
			echo '</table>';
		echo '</td>';

		//########################################################################   suma zamówień brutto  ############################################################################################################# 
		$SUMA_BRUTTO_KLIENT_POKAZ = kwota($SUMA_BRUTTO_KLIENT);
		echo '<td>'.$SUMA_BRUTTO_KLIENT_POKAZ.'</td>';
		
		

		//########################################################################   suma pobrań brutto  ############################################################################################################# 
		$SUMA_DO_ZAPLATY[$k] = 0;
		echo '<td align="center">';
			//jeżeli klient ma sposób płatności gotówka lub przedpłata to szukamy ile ma do zapłacenia z faktur.
			if(($sposob_platnosci[$k] == 'Gotówka') || ($sposob_platnosci[$k] == 'Przedpłata')) 
				{
				for ($z=1; $z<=$ilosc_zamowien; $z++) 
					{
					$pytanie1273 = mysqli_query($conn, "SELECT do_zaplaty FROM fv_naglowek WHERE typ_dok = 'Faktura' AND zamowienie_id=".$zamowienie_id[$z].";");
					while($wynik1273= mysqli_fetch_assoc($pytanie1273))
						$SUMA_DO_ZAPLATY[$k] = $SUMA_DO_ZAPLATY[$k] + $wynik1273['do_zaplaty'];
					} 
				}

			
			$nazwa_suma_do_zaplaty = 'nazwa_suma_do_zaplaty['.$klient_id[$k].']';
			echo '<input type="hidden" name="'.$nazwa_suma_do_zaplaty.'" value="'.$SUMA_DO_ZAPLATY[$k].'"size="8">';

			$styl[$k] = 'pole_input_biale_ramka';
			if($edytowana_suma_pobran_brutto[$klient_id[$k]] != 'tak') 
				{
				$SUMA_DO_ZAPLATY[$k] = change($SUMA_DO_ZAPLATY[$k]);
				$pytanie122 = "UPDATE zlecenia_transportowe_tresc SET suma_pobran_brutto = ".$SUMA_DO_ZAPLATY[$k]." WHERE klient_id=".$klient_id[$k]." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';";
				mysqli_query($conn, $pytanie122);
				}
			else
				{
				$napis_edytowano[$k] = '<font color="red">Edytowano</font><br>';
				$styl[$k] = 'pole_input_edycja_right';
				$SUMA_DO_ZAPLATY[$k] = $suma_pobran_brutto_ze_zlecenia[$klient_id[$k]];
				}
			
			$nazwa_suma_pobran_brutto = 'nazwa_suma_pobran_brutto['.$klient_id[$k].']';
			echo '<table align="center" width="90%" border="0" class="text" cellspacing="0" cellpadding="0"><tr height="20px" align="right"><td>';
			if(($sposob_platnosci[$k] == 'Gotówka') || ($sposob_platnosci[$k] == 'Przedpłata')) echo '<font color="green">'.$sposob_platnosci[$k].'</font>';
			echo '</td></tr><tr height="20px" align="right"><td>';
			$SUMA_DO_ZAPLATY[$k] = change($SUMA_DO_ZAPLATY[$k]);
			$SUMA_POBRAN_BRUTTO += $SUMA_DO_ZAPLATY[$k];
			echo '<input type="text" name="'.$nazwa_suma_pobran_brutto.'" value="'.$SUMA_DO_ZAPLATY[$k].'" autocomplete="off" size="8" class="'.$styl[$k].'"  '.$disabled.'>';
			echo '</td></tr><tr height="20px" align="right"><td>'.$napis_edytowano[$k].'</td></tr></table>';
		echo '</td>';
		//############################################################################################################################################################################################################ 

		//########################################################################   status płatności   ############################################################################################################# 
		echo '<td>'.$zalega[$klient_id[$k]].'</td>';
		
		//########################################################################   data dostawy  ############################################################################################################# 
		echo '<td>';
		if($data_dostawy[$k] != '')
			{
			if($zamowienie_data_wysylki_potwierdzenia_dostawy[1] == '') echo '<a href="javascript: potwierdzenie_dostawy_okienko(\''.$id.'\',\''.$klient_id[$k].'\',\''.$user_id.'\')">'.$data_dostawy[$k].'</a>';
			else echo '<a href="javascript: potwierdzenie_dostawy_okienko(\''.$id.'\',\''.$klient_id[$k].'\',\''.$user_id.'\')">'.$data_dostawy[$k].'</a><br><br><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_dostawy/'.$zamowienie_link_dostawa[1].'" target="_blank"><font color="blue">WYSŁANO</font><br>'.$numer_wz[$k].'</a>';
			}
		echo '</td>';
			
			
		echo '<td>'.$uwagi[$k].'</td>';
		//########################################################################  odbior i zwrot       ############################################################################################################# 
		$pytanie3432 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$k]." AND pozycja_wyceny = 1;");
		while($wynik3432= mysqli_fetch_assoc($pytanie3432))
			{
			$odbior_material[$k] = $wynik3432['odbior_material'];
			$odbior_szablon[$k] = $wynik3432['odbior_szablon'];

			//uzupełniam dane do wszystkich pozycji
			$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET odbior_material = '".$odbior_material[$k]."' WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$k].";");		
			$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET odbior_szablon = '".$odbior_szablon[$k]."' WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$k].";");		


			// $zwrot_material[$k] = $wynik3432['zwrot_material'];
			// $zwrot_szablon[$k] = $wynik3432['zwrot_szablon'];
			// $zwrot_uszczelki[$k] = $wynik3432['zwrot_uszczelki'];
			}

		if($odbior_material[$k] == 'on') $odbior_material[$k] = 'checked';
		if($odbior_szablon[$k] == 'on') $odbior_szablon[$k] = 'checked';
		// if($zwrot_material[$k] == 'on') $zwrot_material[$k] = 'checked';
		// if($zwrot_szablon[$k] == 'on') $zwrot_szablon[$k] = 'checked';
		// if($zwrot_uszczelki[$k] == 'on') $zwrot_uszczelki[$k] = 'checked';
		$atrybut_checkbox = ' onclick="return false"';

		echo '<td>';
			echo '<table border="0" class="text" cellpadding="2" cellspacing="2">';
			echo '<tr><td width="10%" align="left"><input type="checkbox" name="odbior_material" '.$odbior_material[$k].' '.$atrybut_checkbox.'></td><td width="90%" align="left">Materiał</td></tr>';
			echo '<tr><td width="10%" align="left"><input type="checkbox" name="odbior_szablon" '.$odbior_szablon[$k].' '.$atrybut_checkbox.'></td><td width="90%" align="left">Szablon</td></tr>';
			echo '</table>';
		echo '</td>';
		
		// echo '<td>';
		// 	echo '<table border="0" class="text" cellpadding="2" cellspacing="2">';
		// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_material" '.$zwrot_material[$k].' '.$atrybut_checkbox.'></td><td width="90%" align="left">Materiał</td></tr>';
		// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_szablon" '.$zwrot_szablon[$k].' '.$atrybut_checkbox.'></td><td width="90%" align="left">Szablon</td></tr>';
		// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_uszczelki" '.$zwrot_uszczelki[$k].' '.$atrybut_checkbox.'></td><td width="90%" align="left">Uszczelka</td></tr>';
		// 	echo '</table>';
		// echo '</td>';

		//zwrot
		$suma_szablony_przy_wyrobach_ilosc = 0;
		$suma_szablony_luzem_ilosc = 0;
		$suma_profile_ilosc = 0;
		$suma_uszczelki_ilosc = 0;
		for ($z=1; $z<=$ilosc_zamowien; $z++)
			{
			$sql1 = "SELECT * FROM realizacja_produkcji_szablony WHERE zamowienie_id = ".$zamowienie_id[$z].";";
			$result = mysqli_query($conn, $sql1);
			if(mysqli_num_rows($result) > 0) 
				{
					while ($wynik = mysqli_fetch_assoc($result)) 
					{
						$szablony_przy_wyrobach_on = $wynik['szablony_przy_wyrobach_on'];
						$szablony_przy_wyrobach_ilosc = $wynik['szablony_przy_wyrobach_ilosc'];
						if($szablony_przy_wyrobach_on == 'on') $suma_szablony_przy_wyrobach_ilosc += $szablony_przy_wyrobach_ilosc;
			
						$szablony_luzem_on = $wynik['szablony_luzem_on'];
						$szablony_luzem_ilosc = $wynik['szablony_luzem_ilosc'];
						if($szablony_luzem_on == 'on') $suma_szablony_luzem_ilosc += $szablony_luzem_ilosc;
			
						$profile_on = $wynik['profile_on'];
						$profile_ilosc = $wynik['profile_ilosc'];
						if($profile_on == 'on') $suma_profile_ilosc += $profile_ilosc;
			
						$profile_on = $wynik['uszczelki_on'];
						$uszczelki_ilosc = $wynik['uszczelki_ilosc'];
						if($profile_on == 'on') $suma_uszczelki_ilosc += $uszczelki_ilosc;

					}
				}
			}
		
		echo '<td align="center" class="text_duzy">';
		if($suma_szablony_przy_wyrobach_ilosc != 0) echo $suma_szablony_przy_wyrobach_ilosc;
		echo '</td>';
		echo '<td align="center" class="text_duzy">';
		if($suma_szablony_luzem_ilosc != 0) echo $suma_szablony_luzem_ilosc;
		echo '</td>';
		echo '<td align="center" class="text_duzy">';
		if($suma_profile_ilosc != 0) echo $suma_profile_ilosc;
		echo '</td>';
		echo '<td align="center" class="text_duzy">';
		if($suma_uszczelki_ilosc != 0) echo $suma_uszczelki_ilosc;
		echo '</td>';

		//############################################################################################################################################################################################################ 
			
		echo '<td class="text_duzy">'.$liczba_paczek_realizacja_produkcji.'</td>';

		//########################################################################  podpis       ############################################################################################################# 
		if($podpis_link[$k] != '') 
			{
			$data_dostarczenia[$k] = date('d-m-Y H:i:s', $data_dostarczenia[$k]);
			echo '<td>'.$data_dostarczenia[$k].'<br>';
			echo '<img src="http://kierowcy.arcus-luki.pl/podpisy/'.$podpis_link[$k].'" border="0" height="100px">';
			echo '<br>'.$podpis_imie_nazwisko[$k].'</td>';
			}
		else echo '<td></td>';
		echo '</tr>';
		}
			
		echo '<tr bgcolor="'.$kolor_tabeli.'" class="text"><td></td>';
		echo '<td></td>';		//klient
		echo '<td></td>';		//adres dostawy
		echo '<td></td>';		//nr zamowien
		echo '<td></td>';		//pozycje wyceny
		echo '<td></td>';		//status zamowien
		$SUMA_BRUTTO = kwota($SUMA_BRUTTO);
		echo '<td align="center">'.$SUMA_BRUTTO.$waluta.'</td>';		
		$SUMA_POBRAN_BRUTTO = kwota($SUMA_POBRAN_BRUTTO);
		echo '<td align="center">'.$SUMA_POBRAN_BRUTTO.$waluta.'</td>';	//suma pobrań brutto	
		echo '<td></td>';		//status płatności	
		echo '<td></td>';		//data dostawy
		echo '<td></td>';		//uwagi
		echo '<td></td>';		//odbior
		echo '<td></td>';		//zwrot			
		echo '<td></td>';		//zwrot			
		echo '<td></td>';		//zwrot			
		echo '<td></td>';		//zwrot			
		echo '<td></td>';		//liczba paczek wyrobow		
		echo '<td></td>';		//podpis
		echo '</tr></table>';
		//####################################################################        KONIEC GŁOWNEJ TABELI     ################################################################################# 
} //do if ilosc klientow = 0;
else echo '<div class="text_duzy_niebieski">Brak klientów w zleceniu transportowym.</div><br><br>';



	echo '</tr></td>';
	if($status != 'Dostarczone')
		{
		echo '<tr><td align="center">';
		echo '<a href="index.php?page=zlecenie_transportowe_dodaj&nowy_numer_zlecenia='.$nr_zlecenia_transportowego.'&etap=2&skad=pokaz&id='.$id.'&wg_czego='.$wg_czego.'&jak='.$jak.'"><button type="button">Dodaj kolejną pozycję do zlecenia</button></a><br><br>';
		echo '</td></tr>';
		
		if(($nr_zlecenia_transportowego != 'Kurier') && ($nr_zlecenia_transportowego != 'Odbiór własny'))
		{
		// #################################### odbiór materiału od klienta #############################
		echo '<tr><td align="center" class="text">';
		
			echo '<table border="0" width="60%" cellpadding="0" cellspacing="0" class="text"><tr><td align="right" width="50%" valign="top"><font color="blue">Odbiór materiału od klienta :&nbsp;</font></td>';
			echo '<td class="text" width="50%">';
			
				echo '<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" class="text">';
				$ilosc_klientow_do_odbioru = 0;
				$pytanie1201 = mysqli_query($conn, "SELECT DISTINCT klient_nazwa FROM zamowienia WHERE stan='Dostawa' AND odbior_materialu = 'on' AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane';");
				while($wynik1201= mysqli_fetch_assoc($pytanie1201))
					{
					$ilosc_klientow_do_odbioru++;
					$odbior_klient_nazwa[$ilosc_klientow_do_odbioru]=$wynik1201['klient_nazwa'];
					}
				for($y=1; $y <= $ilosc_klientow_do_odbioru; $y++)
					{
					$ilosc_zamowien_do_odbioru=0;
					$pytanie13 = mysqli_query($conn, "SELECT nr_zamowienia FROM zamowienia WHERE klient_nazwa='".$odbior_klient_nazwa[$y]."' AND stan='Dostawa' AND odbior_materialu = 'on' AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane';");
					while($wynik13= mysqli_fetch_assoc($pytanie13))
						{
						$ilosc_zamowien_do_odbioru++;
						$odbior_nr_zamowienia[$ilosc_zamowien_do_odbioru]=$wynik13['nr_zamowienia'];
						}
						
					echo '<tr><td align="left">&nbsp;'.$odbior_klient_nazwa[$y];
					if($ilosc_zamowien_do_odbioru == 1) echo '&nbsp;('.$odbior_nr_zamowienia[1].')';
					else
						{
						echo '&nbsp;(';
						for ($m=1; $m<=$ilosc_zamowien_do_odbioru-1; $m++) echo $odbior_nr_zamowienia[$m].',&nbsp;';
						echo $odbior_nr_zamowienia[$ilosc_zamowien_do_odbioru];
						echo ')';
						}
					echo '</td></tr>';
					}
				echo '</table>';

			echo '</td></tr></table>';
		echo '</td></tr>';
		
		
		// #################################### klienci z danej strefy #############################
		echo '<tr><td align="center" class="text">';
		if($strefa != '')
			{
			$ilosc_aktywnych_klientow_ze_strefy = 0;
			$ilosc_straconych_klientow_ze_strefy = 0;
			$ilosc_potencjalnych_klientow_ze_strefy = 0;
			$pytanie1273 = mysqli_query($conn, "SELECT * FROM klienci WHERE strefa = '".$strefa."' ORDER BY nazwa ASC;");
			while($wynik1273= mysqli_fetch_assoc($pytanie1273))
				{
				//szukamy daty ost zamowienia
				$data_ostatniego_zamowienia=$wynik1273['data_ostatniego_zamowienia'];
				if($data_ostatniego_zamowienia != '')
					{
					$rozbite = explode("-", $data_ostatniego_zamowienia);
					$data_ostatniego_zamowienia_time = mktime(0, 0, 0, $rozbite[1], $rozbite[0], $rozbite[2]);
					
					//sprawdzamy czy klient aktywny
					$odstep = $time - $czas_miedzy_zamowieniami_2 - $data_ostatniego_zamowienia_time;
					if($odstep > 0) 
						{
						$ilosc_straconych_klientow_ze_strefy++;
						$strefa_straceni_klienci_id[$ilosc_straconych_klientow_ze_strefy] = $wynik1273['id'];
						$strefa_straceni_klienci[$ilosc_straconych_klientow_ze_strefy] = $wynik1273['nazwa'];
						}
					else 
						{
						$ilosc_aktywnych_klientow_ze_strefy++;
						$strefa_aktywni_klienci_id[$ilosc_aktywnych_klientow_ze_strefy] = $wynik1273['id'];
						$strefa_aktywni_klienci[$ilosc_aktywnych_klientow_ze_strefy] = $wynik1273['nazwa'];
						}
					}
				else
					{
					$ilosc_potencjalnych_klientow_ze_strefy++;
					$strefa_potencjalni_klienci_id[$ilosc_potencjalnych_klientow_ze_strefy] = $wynik1273['id'];
					$strefa_potencjalni_klienci[$ilosc_potencjalnych_klientow_ze_strefy] = $wynik1273['nazwa'];
					}
					
				}
			echo '<table border="0" width="'.$szerokosc_tabeli.'px" cellpadding="4" cellspacing="4" class="text"><tr align="left" width="100%"><td><font color="blue">Aktywni klienci ('.$ilosc_aktywnych_klientow_ze_strefy.') :</font><br>';
			for($k = 1; $k <= $ilosc_aktywnych_klientow_ze_strefy; $k++)
				{
				echo '<a href="javascript: info_zlecenie_transportowe(\''.$strefa_aktywni_klienci_id[$k].'\')"><font color="black">'.$strefa_aktywni_klienci[$k].'</a>';
				if($k != $ilosc_aktywnych_klientow_ze_strefy) echo ', ';
				}
			echo '</td></tr><tr align="left" width="100%"><td><font color="blue">Straceni klienci ('.$ilosc_straconych_klientow_ze_strefy.') :</font><br>';
			for($k = 1; $k <= $ilosc_straconych_klientow_ze_strefy; $k++)
				{
				echo '<a href="javascript: info_zlecenie_transportowe(\''.$strefa_straceni_klienci_id[$k].'\')"><font color="black">'.$strefa_straceni_klienci[$k].'</a>';
				if($k != $ilosc_straconych_klientow_ze_strefy) echo ', ';
				}
			echo '</td></tr><tr align="left" width="100%"><td><font color="blue">Potencjalni klienci ('.$ilosc_potencjalnych_klientow_ze_strefy.') :</font><br>';
			for($k = 1; $k <= $ilosc_potencjalnych_klientow_ze_strefy; $k++)
				{
				echo '<a href="javascript: info_zlecenie_transportowe(\''.$strefa_potencjalni_klienci_id[$k].'\')"><font color="black">'.$strefa_potencjalni_klienci[$k].'</a>';
				if($k != $ilosc_potencjalnych_klientow_ze_strefy) echo ', ';
				}
			echo '</td></tr></table>';
			}
		else echo '<font color="red">Aby zobaczyć listę aktywnych klientów - zdefiniuj strefę dla zlecenia transportowego.</font>';
		echo '</td></tr>';
		}
		
		
		echo '<tr><td colspan="4" align="center"><INPUT type="submit" name="zapisz" value="Zapisz"></td></tr>';
		}
	
	echo '<tr><td align="center">';
		echo '<table border="0" width="40%" cellpadding="0" cellspacing="3" class="text">';
		echo '<tr align="center"><td>Drukuj zlecenie transportowe</td>';
		echo '<td>Drukuj zlecenie załadunkowe</td></tr>';
		echo '<tr align="center"><td><a href="php/drukuj/drukuj_zlecenie_transportowe.php?id='.$id.'" target="_blank">'.$image_printer.'</a></td>';
		echo '<td><a href="php/drukuj/drukuj_zlecenie_zaladunkowe.php?id='.$id.'" target="_blank">'.$image_printer.'</a></td></tr>';
		echo '</table>';	
	echo '</td></tr>';
	
	echo '</table>';
	echo '</FORM>';
} // do else
echo $powrot_do_zlecenia_transportowe;
?>