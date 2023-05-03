<?php
if($usunac_zamowienie != '')
	{
	echo '<div align="center" class="text_duzy_niebieski">'.$wyraz_Zamowienie.' usunięte.</div>';
	mysqli_query($conn, "DELETE FROM magazyn_zamowienia_naglowek WHERE id = ".$zamowienie_id.";");
	mysqli_query($conn, "DELETE FROM magazyn_zamowienia_pozycje WHERE zamowienie_id = ".$zamowienie_id.";");
	echo $powrot_do_rejestru_zamowien_do_dostawcow;
	}
else
	{
	if($usun_pozycje != '')
		{
		echo '<div align="center" class="text_duzy_niebieski">Pozycja usunięta</div>';
		mysqli_query($conn, "DELETE FROM magazyn_zamowienia_pozycje WHERE id = ".$usun_pozycje." LIMIT 1");
		}
		
	if($Zapisz != '')
		{
		echo '<div align="center" class="text_duzy_niebieski">Dane zapisane</div>';
		$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET uwagi = '".$uwagi."' WHERE id = ".$zamowienie_id.";");
					
		
		// wysylamy zamowienie - generujemy pdf
		if(($wyslac_zamowienie == 'on') && ($klient_email != ''))
			{
			$pytanie77 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek  WHERE id = ".$zamowienie_id.";");
			while($wynik77= mysqli_fetch_assoc($pytanie77))
				{
				$korekta=$wynik77['korekta'];
				}	
				
			if($korekta == 'tak') 
				{
				$data_wyslania_korekta = date('d-m-Y', $time);
				$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET data_wyslania_korekta = '".$data_wyslania_korekta."' WHERE id = ".$zamowienie_id.";");
				}
			include("php/zamowienie_do_dostawcow_pdf.php");
			}
		elseif($klient_email == '') echo '<div align="center" class="text_duzy_czerwony">Brak adresu email dostawcy.</div>';

		
		if($zrealizowac_zamowienie == 'on')
			{
			//echo 'zrealizowac_zamowienie='.$zrealizowac_zamowienie.'<br>';
			$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET status = '".$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3]."' WHERE id = ".$zamowienie_id.";");
			echo '<meta http-equiv="refresh" content="0.00001; URL=index.php?page=zamowienia_do_dostawcow&jak=DESc&wg_czego=data_zamowienia_time&zrealizowac_zamowienie=tak">';
			}
		
		$data_wyslania_korekta = date('d-m-Y', $time);
		if($korekta_zamowienia == 'on') 
			{
			$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET korekta = 'tak' WHERE id = ".$zamowienie_id.";");
			}
		else 
			{
			$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET korekta = '' WHERE id = ".$zamowienie_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET data_wyslania_korekta = '' WHERE id = ".$zamowienie_id.";");
			//echo 'zmieniam na pusta<br>';
			}
		}
	
	$pytanie = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek  WHERE id = ".$zamowienie_id.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$klient_id=$wynik['klient_id'];
		$klient_nazwa=$wynik['klient_nazwa'];
		$nr_zamowienia=$wynik['nr_zamowienia'];
		$data_zamowienia=$wynik['data_zamowienia'];
		$data_wyslania=$wynik['data_wyslania'];
		$wartosc_netto=$wynik['wartosc_netto'];
		$status=$wynik['status'];
		$uwagi=$wynik['uwagi'];
		$korekta=$wynik['korekta'];
		$data_wyslania_korekta=$wynik['data_wyslania_korekta'];
		}	
	
	if($uwagi != '') 
		{
		// szukamy enterow w uwagach i zamieniamy je na spacje.
		
		function szyfruj ($ciag)
			{
			$wynik = "";
			$tablica = str_split($ciag);
			foreach($tablica as $znak)
				{
				$wynik .= ord($znak).",";
				} 
			unset($znak);
			return $wynik;
			}
		$uwagi2 = szyfruj($uwagi); 
		
		$pieces = explode(",", $uwagi2);
		$dl_tabeli = count($pieces);
		$dl_tabeli--;
		$dl_tabeli--;
		$uwagi_po_zmianach = "";
		for($x=0; $x<=$dl_tabeli; $x++)
			{
			if($pieces[$x] == '10') $pieces[$x] = '32';
			if($pieces[$x] == '13') $pieces[$x] = '32';
			$uwagi_po_zmianach .= chr($pieces[$x]);
			}

		$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET uwagi = '".$uwagi_po_zmianach."' WHERE id = ".$zamowienie_id.";");
		$uwagi = $uwagi_po_zmianach;
		}
	
	//sortowanie zleceń
	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="zamowienia_do_dostawcow_edycja">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="pokaz" value="'.$pokaz.'">';                                
	echo '<input type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';                                
	echo '<input type="hidden" name="SORT_NUMERY_ZAMOWIEN" value="'.$SORT_NUMERY_ZAMOWIEN.'">';                                
	echo '<input type="hidden" name="SORT_DATA_ZAMOWIENIA" value="'.$SORT_DATA_ZAMOWIENIA.'">';                                
	echo '<input type="hidden" name="SORT_DATA_WYSLANIA" value="'.$SORT_DATA_WYSLANIA.'">';                                
	echo '<input type="hidden" name="SORT_STATUS" value="'.$SORT_STATUS.'">';                                
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';                                
	echo '<input type="hidden" name="dostawca_id" value="'.$klient_id.'">';                                
	
		echo '<table width="1400px" align="center" class="text" cellpadding="3" border="0"><tr align="center" class="text"><td width="40%" align="left">';
		echo '<img src="images/arcus_logo_mini.png" height="150px">';
		echo '</td>';
		echo '<td width="20%" align="center">';
			if($data_wyslania == '') echo '<a href="index.php?page=zamowienia_do_dostawcow_dodaj&zamowienie_id='.$zamowienie_id.'&klient='.$klient_id.'&jak=ASC&wg_czego=system&nowy_numer_zamowienia='.$nr_zamowienia.'&etap=2">Dodaj kolejne pozycje</a>';
		echo '</td>';		
		echo '<td width="40%" class="text_duzy" align="right" valign="top"><br>';
		$pytanie32 = mysqli_query($conn, "SELECT * FROM dostawcy WHERE id='".$klient_id."';");
		while($wynik32= mysqli_fetch_assoc($pytanie32))
			{
			$klient_nazwa = $wynik32['dostawca_nazwa'];
			$klient_ulica = $wynik32['ulica'];
			$klient_miasto = $wynik32['miasto'];
			$klient_kod_pocztowy = $wynik32['kod_pocztowy'];
			
			
			$email_1=$wynik32['email_1'];
			$email_2=$wynik32['email_2'];
			$email_3=$wynik32['email_3'];
			$email_4=$wynik32['email_4'];
			$email_5=$wynik32['email_5'];
			
			$ostatnio_uzyty_email=$wynik32['ostatnio_uzyty_email'];
			}
		echo $klient_nazwa.'<br>';
		echo $klient_ulica.'<br>';
		echo $klient_kod_pocztowy.' '.$klient_miasto.'<br>';
		echo '</td></tr>';
		
		if($korekta == 'tak')
			{
			echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="3">KOREKTA ZAMÓWIENIA NR : '.$nr_zamowienia.'</td></tr>';
			$checked_korekta = 'checked="checked"'; 
			}
		else
			{
			$checked_korekta = '';
			echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="3">ZAMÓWIENIE NR : '.$nr_zamowienia.'</td></tr>';
			}
		
		if($status == $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[2]) 
			{
			echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="3">';
			echo 'KOREKTA ZAMÓWIENIA<input type="checkbox" name="korekta_zamowienia" title="Korekta zamówienia" '.$checked_korekta.'><br>';
			echo '</td></tr>';
			}
	
		
		echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="3">';
			echo '<table class="tabela" width="100%" align="left"><tr valign="middle" align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
			echo '<td width="16%">'.$kol_data_zamowienia.'</td>';
			echo '<td width="16" bgcolor="'.$kolor_bialy.'">'.$data_zamowienia.'</td>';
			echo '<td width="16%">'.$kol_data_wyslania.'</td>';
			echo '<td width="16%" bgcolor="'.$kolor_bialy.'">'.$data_wyslania.'</td>';
			echo '<td width="16%">Status</td>';
			echo '<td width="16%" bgcolor="'.$kolor_bialy.'">'.$status.'</td></tr></table>';
		echo '</td></tr>';
		
		$pozycja_id = [];
	
		echo '<tr align="center" class="text"><td width="100%" align="center" colspan="3">';
			$ilosc_pozycji = 0;
			$wartosc_zamowienia = 0;
			$pytanie373 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_pozycje WHERE nr_zamowienia ='".$nr_zamowienia."' ORDER BY id ASC");
			while($wynik373= mysqli_fetch_assoc($pytanie373))
				{
				$ilosc_pozycji++;
				$pozycja_id[$ilosc_pozycji] = $wynik373['id'];
				$zamowienie_id = $wynik373['zamowienie_id'];
				$system_zamowienie[$ilosc_pozycji]=$wynik373['system'];
				$element_zamowienie[$ilosc_pozycji]=$wynik373['element'];
				$kolor_zamowienie[$ilosc_pozycji]=$wynik373['kolor'];
				$uszczelka_zamowienie[$ilosc_pozycji]=$wynik373['uszczelka'];
				$jednostka_zamowienie[$ilosc_pozycji]=$wynik373['jednostka'];
				$symbol_profilu_zamowienie[$ilosc_pozycji]=$wynik373['symbol_profilu'];
				$symbol_koloru_zamowienie[$ilosc_pozycji]=$wynik373['symbol_koloru'];
				$cena_netto_zakupu_zl_zamowienie[$ilosc_pozycji]=$wynik373['cena_netto_zakupu_zl'];
				$ilosc_zamowienie[$ilosc_pozycji]=$wynik373['ilosc'];
				$wartosc_netto_zamowienie[$ilosc_pozycji]=$wynik373['wartosc_netto'];
				$wartosc_zamowienia += $wartosc_netto_zamowienie[$ilosc_pozycji];
				$cena_netto_zakupu_zl_zamowienie[$ilosc_pozycji] = number_format($cena_netto_zakupu_zl_zamowienie[$ilosc_pozycji], 2,'.',' ');
				$wartosc_netto_zamowienie[$ilosc_pozycji] = number_format($wartosc_netto_zamowienie[$ilosc_pozycji], 2,'.',' ');
				}
			
				// wyswietlamy juz dodane pozycje
				echo '<table width="100%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
				echo '<td width="5%" valign="middle">'.$kol_lp.'</td>';
				echo '<td width="8%">System</td>';
				echo '<td width="8%">Element</td>';
				echo '<td width="8%">Kolor</td>';
				echo '<td width="8%">Uszczelka</td>';
				echo '<td width="8%">Symbol profilu</td>';
				echo '<td width="8%">Symbol koloru</td>';
				echo '<td width="8%">'.$kol_ilosc.'</td>';
				echo '<td width="8%">Cena netto zakupu zł</td>';
				echo '<td width="8%">'.$kol_wartosc_netto.'</td>';
				if(($ilosc_pozycji >= 2) && ($status != $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3]))echo '<td width="2%">Usuń</td>';
				echo '</tr>';
				
				for ($x=1; $x<=$ilosc_pozycji; $x++)
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
					echo '<td align="right">'.$wartosc_netto_zamowienie[$x].' '.$waluta.'</td>';
					if(($ilosc_pozycji >= 2) && ($status != $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3])) echo '<td align="center"><a href="index.php?page=zamowienia_do_dostawcow_edycja&zamowienie_id='.$zamowienie_id.'&usun_pozycje='.$pozycja_id[$x].'">'.$image_delete.'</a></td>';
					//else echo '<td align="center"></td>';
					echo '</tr>';
					}
				echo '<tr><td colspan="8" bgcolor="white"></td>';
				$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET wartosc_netto = ".$wartosc_zamowienia." WHERE nr_zamowienia ='".$nr_zamowienia."' ");
				$wartosc_zamowienia = number_format($wartosc_zamowienia, 2,'.',' ');
				echo '<td colspan="2" align="right" bgcolor="'.$kolor_tabeli.'">'.$kol_wartosc_zamowienia.' : '.$wartosc_zamowienia.' '.$waluta.'&nbsp;</td>';
				if(($ilosc_pozycji >= 2) && ($status != $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3])) echo '<td bgcolor="white"></td>';
				echo '</table>';
		echo '</td></tr>';
		
		echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="3">';
			echo '<table width="100%" align="center" class="text" border="0"><tr align="center" class="text">';
			echo '<td width="25%" valign="middle"><a href="php/drukuj/drukuj_zamowienie_do_dostawcow.php?zamowienie_id='.$zamowienie_id.'" target="_blank">'.$image_printer.'<br>Drukuj '.$wyraz_ZAMOWIENIE.'</a></td>';
			echo '<td width="50%">';
				echo 'UWAGI DO ZAMÓWIENIA<br>';
				if($status == $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3]) echo '<textarea name="uwagi" cols="80" rows="5" class="pole_input_biale" disabled >'.$uwagi.'</textarea><br>';
				else echo '<textarea name="uwagi" cols="80" rows="5" class="pole_input_edycja">'.$uwagi.'</textarea><br>';
			echo '</td>';
			echo '<td width="25%">';
				$nr_zamowienia2 = change_link($nr_zamowienia); // zamieniam / na _
				$nazwa_pliku = 'zamowienie_'.$nr_zamowienia2.'.pdf';
				if($data_wyslania != '') echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_zamowienia_do_dostawcow/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'<br>Podgląd PDF</a>';
				else echo $image_pdf_icon_gray.'<br>Brak pliku';
			echo '</td>';
			echo '</tr></table>';
		echo '</td></tr>';
		
		echo '<tr class="text_duzy_niebieski"><td align="center" colspan="3">';
			if($korekta == '')
				{
				//echo 'korekta pusta<br>';
				if($data_wyslania != '') echo 'ZAMÓWIENIE WYSŁANE<input type="checkbox" name="wyslac_zamowienie" checked="checked" disabled title="Zamówienie już zostało wysłane"><br>';
				elseif(($email_1 != '') || ($email_2 != '') || ($email_3 != '') || ($email_4 != '') || ($email_5 != ''))
					{
					echo '<select name="klient_email" class="pole_input" style="width: 200px">';
					echo '<option></option>';
					if(($email_1 != '') && ($ostatnio_uzyty_email == $email_1)) echo '<option selected value="'.$email_1.'">'.$email_1.'</option>'; elseif(($email_1 != '') && ($ostatnio_uzyty_email != $email_1)) echo '<option value="'.$email_1.'">'.$email_1.'</option>'; 
					if(($email_2 != '') && ($ostatnio_uzyty_email == $email_2)) echo '<option selected value="'.$email_2.'">'.$email_2.'</option>'; elseif(($email_2 != '') && ($ostatnio_uzyty_email != $email_2)) echo '<option value="'.$email_2.'">'.$email_2.'</option>'; 
					if(($email_3 != '') && ($ostatnio_uzyty_email == $email_3)) echo '<option selected value="'.$email_3.'">'.$email_3.'</option>'; elseif(($email_3 != '') && ($ostatnio_uzyty_email != $email_3)) echo '<option value="'.$email_3.'">'.$email_3.'</option>'; 
					if(($email_4 != '') && ($ostatnio_uzyty_email == $email_4)) echo '<option selected value="'.$email_4.'">'.$email_4.'</option>'; elseif(($email_4 != '') && ($ostatnio_uzyty_email != $email_4)) echo '<option value="'.$email_4.'">'.$email_4.'</option>'; 
					if(($email_5 != '') && ($ostatnio_uzyty_email == $email_5)) echo '<option selected value="'.$email_5.'">'.$email_5.'</option>'; elseif(($email_5 != '') && ($ostatnio_uzyty_email != $email_5)) echo '<option value="'.$email_5.'">'.$email_5.'</option>'; 
					echo '</select></td></tr>';
					
					echo '<tr class="text_duzy_niebieski"><td align="center" colspan="3">WYSŁAĆ ZAMÓWIENIE <input type="checkbox" name="wyslac_zamowienie">';
					}
				
				else echo 'WYSŁAĆ '.$wyraz_ZAMOWIENIE.' <input type="checkbox" disabled name="wyslac_zamowienie"><div class="text_red">Nie można wysłać. Brak e-mail dostawcy.</div>';
				}
			else
				{
				//echo 'korekta TAK<br>';
				//echo 'data_wyslania_korekta='.$data_wyslania_korekta.'<br>';
				if($data_wyslania_korekta != '') echo ''.$wyraz_ZAMOWIENIE.' WYSŁANE<input type="checkbox" name="wyslac_zamowienie" checked="checked" disabled title="Zamówienie już zostało wysłane"><br>';
				else echo 'WYSŁAĆ '.$wyraz_ZAMOWIENIE.' <input type="checkbox" name="wyslac_zamowienie"><br>'.$klient_email;;
				}
		
		echo '</td></tr>';		
		
		echo '<tr class="text_duzy_czerwony"><td align="center" colspan="3">';
			if($status == $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[2]) echo 'ZREALIZUJ ZAMÓWIENIE <input type="checkbox" name="zrealizowac_zamowienie"><br>';
			elseif($status == $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3]) echo 'ZAMÓWIENIE ZREALIZOWANE<input type="checkbox" checked="checked" name="zrealizowac_zamowienie" disabled title="Wyślij zamówienie, aby je zrealizować"><br>';
			else echo 'ZREALIZUJ '.$wyraz_ZAMOWIENIE.' <input type="checkbox" name="zrealizowac_zamowienie" disabled title="Wyślij zamówienie, aby je zrealizować"><br>';
		echo '</td></tr>';		
		
		if($status  != $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3])
			{
			echo '<tr class="text_red"><td align="center" colspan="3">';
				echo 'Zaznacz, aby usunąć '.$wyraz_ZAMOWIENIE.' <input type="checkbox" name="usunac_zamowienie" class="pole_input"><br>';
			echo '</td></tr>';
			}
		
		echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="3">';
			if($status != $TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3]) echo '<input type="submit" name="Zapisz" value="Zapisz">';
		echo '</td></tr>';
		
	
	echo '</table>';
	echo '</form>';
	echo $powrot_do_rejestru_zamowien_do_dostawcow;
	} // do else
?>