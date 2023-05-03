<?php	
if($submit == 'Zapisz')
	{
	$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id=".$edytuj_id.";");
	while($wynik22= mysqli_fetch_assoc($pytanie22))
		{
		$link_folder=$wynik22['link_folder'];
		}	  

	$do_kiedy_termin_platnosci = $data_wystawienia_time + ($nowy_termin_platnosci * 86400); // 86400 to 1 dziem
	
	if($nowa_informacja_o_fakturze != '')	
		{
		echo '<div class="text_green" align="center">Dodano nową informację o fakturze.</div>';
		$pytanie = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`)  values ('informacja_o_fakturze', '$nowa_informacja_o_fakturze');");
		$informacja_o_fakturze = $nowa_informacja_o_fakturze;
		}
		
		$ins=mysqli_query($conn, "update fv_naglowek set pole_jpk = '".$nowe_pole_jpk."' WHERE id = ".$edytuj_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set konto = '".$wybrane_konto."' WHERE id = ".$edytuj_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set nabywca_sposob_platnosci = '".$nowy_sposob_platnosci."' WHERE id = ".$edytuj_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set termin_platnosci_dni = '".$nowy_termin_platnosci."' WHERE id = ".$edytuj_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set termin_platnosci = '".$do_kiedy_termin_platnosci."' WHERE id = ".$edytuj_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set informacja_o_fakturze = '".$informacja_o_fakturze."' WHERE id = ".$edytuj_id.";");
	
	for($x = 1; $x<=$ilosc_pozycji; $x++)
		{
		$ins=mysqli_query($conn, "update fv_pozycje set jednostka = '".$nowa_jednostka[$x]."' WHERE fv_id = ".$edytuj_id." AND pozycja = ".$nazwa_numer_pozycji[$x].";");
		}
		
	$fv_id = $edytuj_id;
	echo '<div align="center" class="text">Dane zostały zmienione.</div>';
	echo '<div align="center" class="text_duzy_niebieski">NOWA FAKTURA ZOSTAŁA WYGENEROWANA</div>';
	include('php/generuj_fakture.php');
	
	echo '<center><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a></center>';
	}
else
	{

	$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$edytuj_id.";");
	while($wynik22= mysqli_fetch_assoc($pytanie22))
		{
		$zamowienie_id = $wynik22['zamowienie_id'];
		$nr_fv = $wynik22['nr_dok'];
		$link_folder = $wynik22['link_folder'];
		$pole_jpk = $wynik22['pole_jpk'];
		$nabywca_sposob_platnosci = $wynik22['nabywca_sposob_platnosci'];
		$termin_platnosci = $wynik22['termin_platnosci'];
		$termin_platnosci_dni = $wynik22['termin_platnosci_dni'];
		$data_wystawienia = $wynik22['data_wystawienia'];
		$data_wystawienia_time = $wynik22['data_wystawienia_time'];
		$data_zakonczenia_dostawy = $wynik22['data_zakonczenia_dostawy'];
		$wartosc_netto_fv = $wynik22['wartosc_netto_fv'];
		$wartosc_brutto_fv = $wynik22['wartosc_brutto_fv'];
		$vat = $wynik22['vat'];
		$wplacono = $wynik22['wplacono'];
		$informacja_o_fakturze = $wynik22['informacja_o_fakturze'];
		// $kurs_euro = $wynik22['kurs_euro'];
		$wybrane_konto = $wynik22['konto'];
		}	
		  

	$numer_pozycji = [];
	$nazwa_produktu = [];
	$jednostka = [];
	$ilosc = [];
	$cena_netto = [];
	$wartosc_vat = [];
	$cena_brutto = [];
	$wartosc_netto = [];
	$wartosc_brutto = [];


	$waluta_na_fv = ' PLN';
	$ilosc_pozycji = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE fv_id = ".$edytuj_id." ORDER BY pozycja ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji++;
		$numer_pozycji[$ilosc_pozycji]=$wynik['pozycja'];
		$nabywca_id=$wynik['nabywca_id'];
		$nazwa_produktu[$ilosc_pozycji]=$wynik['nazwa_produktu'];
		$jednostka[$ilosc_pozycji]=$wynik['jednostka'];
		$ilosc[$ilosc_pozycji]=$wynik['ilosc'];
		$cena_netto[$ilosc_pozycji]=$wynik['cena_netto'];
		$wartosc_vat[$ilosc_pozycji]=$wynik['vat'];
		$cena_brutto[$ilosc_pozycji]=$wynik['cena_brutto'];
		$wartosc_netto[$ilosc_pozycji]=$wynik['wartosc_netto'];
		$wartosc_brutto[$ilosc_pozycji]=$wynik['wartosc_brutto'];
		// if(($kurs_euro != '') && ($kurs_euro != 0))
		// 	{
		// 	$cena_netto[$ilosc_pozycji]=$cena_netto[$ilosc_pozycji]/$kurs_euro;
		// 	$cena_brutto[$ilosc_pozycji]=$cena_brutto[$ilosc_pozycji]/$kurs_euro;
		// 	$wartosc_netto[$ilosc_pozycji]=$wartosc_netto[$ilosc_pozycji]/$kurs_euro;
		// 	$wartosc_brutto[$ilosc_pozycji]=$wartosc_brutto[$ilosc_pozycji]/$kurs_euro;
		// 	$waluta_na_fv = ' EUR';				
		// 	}
		
		}
	
	$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
	while($wynik22= mysqli_fetch_assoc($pytanie22))
		{
		$sprzedawca_nazwa=$wynik22['nazwa'];
		$sprzedawca_ulica=$wynik22['ulica'];
		$sprzedawca_miasto=$wynik22['miasto'];
		$sprzedawca_kod_pocztowy=$wynik22['kod_pocztowy'];
		$sprzedawca_nip=$wynik22['nip'];
		$sprzedawca_miejsce_wystawienia=$wynik22['miejsce_wystawienia'];
		$sprzedawca_konto_opis=$wynik22['konto_opis'];
		$sprzedawca_konto=$wynik22['konto'];
		$sprzedawca_konto_euro=$wynik22['konto_euro'];
		$sprzedawca_opis=$wynik22['opis'];
		$sprzedawca_email=$wynik22['email'];
		$sprzedawca_telefon=$wynik22['telefon'];
		$sprzedawca_www=$wynik22['www'];
		}
		
		
	$pytanie22 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$nabywca_id.";");
	while($wynik22= mysqli_fetch_assoc($pytanie22))
		{
		$nabywca_nazwa=$wynik22['pelna_nazwa'];
		$nabywca_ulica=$wynik22['ulica'];
		$nabywca_miasto=$wynik22['miasto'];
		$nabywca_kod_pocztowy=$wynik22['kod_pocztowy'];
		$nabywca_nip=$wynik22['nip'];
		}	


	echo '<FORM action="index.php?page=fv_edycja&zamowienie_id='.$zamowienie_id.'" method="post">';
	echo '<input type="hidden" name="edytuj_id" value="'.$edytuj_id.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="kurs_euro" value="'.$jak.'">';
	echo '<input type="hidden" name="ilosc_pozycji" value="'.$ilosc_pozycji.'">';
	echo '<input type="hidden" name="termin_wystawienia" value="'.$termin_wystawienia.'">';
	echo '<input type="hidden" name="data_koncowa" value="'.$data_koncowa.'">';
	echo '<input type="hidden" name="data_poczatkowa" value="'.$data_poczatkowa.'">';
	echo '<input type="hidden" name="rozliczenie" value="'.$rozliczenie.'">';
	echo '<input type="hidden" name="rodzaj_dokumentu" value="'.$rodzaj_dokumentu.'">';
	echo '<input type="hidden" name="radio_zaplacone" value="'.$radio_zaplacone.'">';
	echo '<input type="hidden" name="terminowosc" value="'.$terminowosc.'">';
	echo '<input type="hidden" name="radio_terminowosc" value="'.$radio_terminowosc.'">';
	echo '<input type="hidden" name="klient" value="'.$klient.'">';
	echo '<input type="hidden" name="klient_nazwa" value="'.$klient_nazwa.'">';
	echo '<input type="hidden" name="data_wystawienia_time" value="'.$data_wystawienia_time.'">';
	
	
	echo '<div align="center" class="text_ogromny">Edytuj fakturę numer : <font color="blue">'.$nr_fv.'</font></div><br>';
	
	echo '<table width="1100px" align="center" class="text" border="0">';
	echo '<tr align="center" class="text"><td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="0">';
		echo '<tr align="center" class="text" valign="top"><td width="50%" align="left"><img src="images/arcus_logo_mini.png" height="100px"></td>';
		echo '<td width="50%" align="right">';
		echo 'Telefon: '.$sprzedawca_telefon.'<br>';
		echo 'e-mail: '.$sprzedawca_email.'<br><br>';
		echo $sprzedawca_www.'<br><br>';
		echo '</td></tr></table>';
	echo '<hr></td></tr>';
	
	echo '<tr class="text_duzy"><td width="50%" align="left">FAKTURA</td><td width="50%" align="right">Nr: '.$nr_fv.'</td></tr>';
	echo '<tr width="100%"><td colspan="2"><hr></td></tr>';
	
	// dane sprzedawcy i nabywcy
	echo '<tr align="center" class="text"><td width="50%">';
		echo '<table width="100%" align="center" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_szary.'"><td align="center" class="text_duzy">SPRZEDAWCA</td></tr>';
			echo '<tr><td><table width="100%" align="center" border="0" bgcolor="white">';
				echo '<tr><td class="text_duzy" height="70px" valign="top">'.$sprzedawca_nazwa.'</td><tr>';
				echo '<tr><td class="text_sredni">'.$sprzedawca_ulica.'<br>';
				echo $sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.', Polska<br>';
				echo 'NIP '.$sprzedawca_nip.'<br>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';
	echo '</td>';
	echo '<td width="50%">';
		echo '<table width="100%" align="center" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_szary.'"><td align="center" class="text_duzy">NABYWCA</td></tr>';
			echo '<tr><td><table width="100%" align="center" border="0" bgcolor="white">';
				echo '<tr><td class="text_duzy" height="70px" valign="top">'.$nabywca_nazwa.'</td><tr>';
				echo '<tr><td class="text_sredni">'.$nabywca_ulica.'<br>';
				echo $nabywca_kod_pocztowy.' '.$nabywca_miasto.', Polska<br>';
				echo 'NIP '.$nabywca_nip.'<br>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';
	echo '</td></tr>';
	
	
	// dane
	echo '<tr align="center" class="text"><td width="50%">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
			echo '<tr class="text" align="left"><td width="40%">Miejsce wystawienia:</td><td>'.$sprzedawca_miejsce_wystawienia.'</td></tr>';
			echo '<tr class="text" align="left"><td>Termin płatności:</td><td colspan="2">';
			
			echo '<select name="nowy_termin_platnosci" class="pole_input_edycja" style="width: 60px">';
			if($termin_platnosci_dni == 1) echo '<option selected="selected">1</option>'; else echo '<option>1</option>';
			if($termin_platnosci_dni == 3) echo '<option selected="selected">3</option>'; else echo '<option>3</option>';
			if($termin_platnosci_dni == 7) echo '<option selected="selected">7</option>'; else echo '<option>7</option>';
			if($termin_platnosci_dni == 14) echo '<option selected="selected">14</option>'; else echo '<option>14</option>';
			if($termin_platnosci_dni == 21) echo '<option selected="selected">21</option>'; else echo '<option>21</option>';
			if($termin_platnosci_dni == 28) echo '<option selected="selected">28</option>'; else echo '<option>28</option>';
			echo '</select>';
			echo ' dni</td></tr>';
			
			// sposob płatności
			echo '<tr class="text" align="left"><td>Forma płatności:</td><td>';
			$ilosc_sposob_platnosci = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_platnosci' ORDER BY opis ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$ilosc_sposob_platnosci++;
				$sposob_platnosci_id[$ilosc_sposob_platnosci] = $wynik3['id'];
				$sposob_platnosci_opis[$ilosc_sposob_platnosci] = $wynik3['opis'];
				}
			echo '<select name="nowy_sposob_platnosci" class="pole_input_edycja" style="width: 300px">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_sposob_platnosci; $k++) 
			if($nabywca_sposob_platnosci == $sposob_platnosci_opis[$k]) echo '<option selected="selected" value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			else echo '<option value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			echo '</select>';
			echo '</td></tr>';
				
			// informacje o fakturze
			echo '<tr class="text" align="left"><td>Informacja o fakturze:</td><td>';
			$ilosc_informacja_o_fakturze = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='informacja_o_fakturze' ORDER BY opis ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$ilosc_informacja_o_fakturze++;
				$informacja_o_fakturze_id[$ilosc_informacja_o_fakturze] = $wynik3['id'];
				$informacja_o_fakturze_opis[$ilosc_informacja_o_fakturze] = $wynik3['opis'];
				}
			echo '<select name="informacja_o_fakturze" class="pole_input_edycja" style="width: 300px">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_informacja_o_fakturze; $k++) 
			if($informacja_o_fakturze == $informacja_o_fakturze_opis[$k]) echo '<option selected="selected" value="'.$informacja_o_fakturze_opis[$k].'">'.$informacja_o_fakturze_opis[$k].'</option>';
			else echo '<option value="'.$informacja_o_fakturze_opis[$k].'">'.$informacja_o_fakturze_opis[$k].'</option>';
			echo '</select>';
			echo '</td></tr>';
		echo '</table>';
	echo '</td>';
	echo '<td width="50%" valign="bottom">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
		echo '<tr class="text" align="right"><td width="80%">Data wystawienia:</td><td width="20%">'.$data_wystawienia.'</td></tr>';
		echo '<tr class="text" align="right"><td>Data zakończenia dostawy/usług:</td><td>'.$data_zakonczenia_dostawy.'</td></tr>';
		echo '<tr class="text" align="right"><td colspan="2" align="left">LUB&nbsp;&nbsp;<input autocomplete="off" type="text" size="40" maxlength="150" title="Informacja o fakturze" alt="Informacja o fakturze" class="pole_input_edycja" name="nowa_informacja_o_fakturze" value="'.$nowa_informacja_o_fakturze.'"></td></tr>';
		echo '</table>';
	echo '</td></tr>';
	
	// wykaz pozycji
	echo '<td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="0" BORDERCOLOR="black" frame="box" RULES="all" cellpadding="2" cellspacing="2">';
		echo '<tr class="text" align="center" bgcolor="'.$kolor_szary.'">';
		echo '<td width="10px">Lp.</td>';
		echo '<td>Towar / Usługa</td>';
		echo '<td width="50px">Jednostka</td>';
		echo '<td width="50px">Ilość</td>';
		echo '<td width="90px">Cena<br>netto</td>';
		echo '<td width="50px">VAT</td>';
		echo '<td width="90px">Cena<br>brutto</td>';
		echo '<td width="90px">Wartość<br>netto</td>';
		echo '<td width="90px">Wartość<br>brutto</td></tr>';
		
		for($x = 1; $x<=$ilosc_pozycji; $x++)
			{
			echo '<tr class="text" align="center" bgcolor="white"><td width="10px">'.$x.'</td>';
			echo '<td align="left">'.$nazwa_produktu[$x].'</td>';
			echo '<td>';

				$nazwa_numer_pozycji = 'nazwa_numer_pozycji['.$x.']';
				echo '<input type="hidden" name="'.$nazwa_numer_pozycji.'" value="'.$numer_pozycji[$x].'">';
				
				$nazwa_jednostka = 'nowa_jednostka['.$x.']';
				echo '<select name="'.$nazwa_jednostka.'" class="pole_input_edycja">';
				for($k = 1; $k <= $DL_TABELA_LISTA_JEDNOSTEK; $k++)
				if($jednostka[$x] == $TABELA_LISTA_JEDNOSTEK[$k]) echo '<option selected="selected" value="'.$TABELA_LISTA_JEDNOSTEK[$k].'">'.$TABELA_LISTA_JEDNOSTEK[$k].'</option>';
				else echo '<option value="'.$TABELA_LISTA_JEDNOSTEK[$k].'">'.$TABELA_LISTA_JEDNOSTEK[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			$ilosc[$x] = number_format($ilosc[$x], 2,'.','');
			echo '<td align="right">'.$ilosc[$x].'</td>';
			$cena_netto[$x] = number_format($cena_netto[$x], 2,'.','');
			echo '<td align="right">'.$cena_netto[$x].'</td>';
			echo '<td>'.$wartosc_vat[$x].'%</td>';
			$cena_brutto[$x] = number_format($cena_brutto[$x], 2,'.','');
			echo '<td align="right">'.$cena_brutto[$x].'</td>';
			$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
			$wartosc_brutto[$x] = number_format($wartosc_brutto[$x], 2,'.',' ');
			echo '<td align="right">'.$wartosc_netto[$x].'</td>';
			echo '<td align="right">'.$wartosc_brutto[$x].'</td></tr>';
			}
	
		echo '<tr class="text" align="center" bgcolor="white"><td colspan="6" align="left">Razem słownie: ';
		// if(($kurs_euro != '') && ($kurs_euro != 0)) $slownie_kwota = kwotaslownieeuro($wartosc_brutto_fv); else 
		$slownie_kwota = kwotaslownie($wartosc_brutto_fv);
		echo $slownie_kwota;
		echo '</td>';
		echo '<td align="right">Razem w '.$waluta_na_fv.': </td>';
		// if(($kurs_euro != '') && ($kurs_euro != 0))
		// 	{
		// 	$wartosc_netto_fv = $wartosc_netto_fv/$kurs_euro;
		// 	$wartosc_brutto_fv = $wartosc_brutto_fv/$kurs_euro;
		// 	}
		$wartosc_netto_fv = number_format($wartosc_netto_fv, 2,'.',' ');
		$wartosc_brutto_fv = number_format($wartosc_brutto_fv, 2,'.',' ');
		
		echo '<td align="right" bgcolor="'.$kolor_szary.'">'.$wartosc_netto_fv.'</td>';
		echo '<td align="right" bgcolor="'.$kolor_szary.'">'.$wartosc_brutto_fv.'</td></tr>';
		echo '</table>';
	echo '</td></tr>';
	
	
	// wybor konta
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
	
		echo '<br>Wybierz konto : ';
		echo '<select name="wybrane_konto" class="pole_input_edycja" style="width: 600px">';
		if($wybrane_konto == $sprzedawca_konto) echo '<option value="'.$sprzedawca_konto.'" selected="selected">'.$sprzedawca_konto.'</option>';
		else echo '<option value="'.$sprzedawca_konto.'">'.$sprzedawca_konto.'</option>';
		
		if($wybrane_konto == $sprzedawca_konto_euro) echo '<option value="'.$sprzedawca_konto_euro.'" selected="selected">'.$sprzedawca_konto_euro.'</option>';
		else echo '<option value="'.$sprzedawca_konto_euro.'">'.$sprzedawca_konto_euro.'</option>';
		echo '</select>';
	
	echo '</td></tr>';
	
	
	echo '<input type="hidden" name="pole_jpk" value="K_19">';
	
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
		echo '<input type="submit" name="submit" value="Zapisz">';
	echo '</td></tr>';
	
	echo '</form>';
	echo '</table>';
	
	} // do else

echo '<br>'.$powrot_do_fakturowania;
?>