<?php
$aktualny_rok = date('y', $time);

if($etap == 1)
	{
	if($zapisz == 'Dalej') 
	{
	// dodaję nowe suwaki
	if($nowy_sposob_dostawy != '')	
		{
		echo '<div class="text_green" align="center">Dodano nowy sposób dostawy do bazy</div>';
		$pytanie = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`)  values ('sposob_dostawy', '$nowy_sposob_dostawy');");
		$sposob_dostawy = $nowy_sposob_dostawy;
		}
			
	if($typ_zamowienia == 'zlecenie')
		{
		$pytanie33 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_zlecenia_transportowego';");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$kolejny_nr_zlecenia=$wynik33['opis'];
			}
		$nowy_numer_zlecenia = $kolejny_nr_zlecenia."/".$AKTUALNY_MIESIAC."/".$aktualny_rok."/ZT";
		$kolejny_nr_zlecenia++;
		$pytanie122 = mysqli_query($conn, "UPDATE rozne SET opis = '".$kolejny_nr_zlecenia."' WHERE typ = 'nr_zlecenia_transportowego';");
		}
	else $nowy_numer_zlecenia = $nr_listu_przewozowego;

	$query = mysqli_query($conn, "INSERT INTO zlecenia_transportowe_naglowek (`nr_zlecenia_transportowego`, `typ`, `data_zaladunku`, `data_wyjazdu`, `kierowca`, `status`, `sposob_dostawy`) values ('$nowy_numer_zlecenia', '$typ_zamowienia', '$data_zaladunku', '$data_wyjazdu', '$kierowca', 'Potwierdzone', '$sposob_dostawy');");
	$etap = 2;
	}

if((!$submit) && ($zapisz != 'Dalej') && ($etap == 1))
{
echo '<table width="60%" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';
echo '<div class="text_duzy_tlo" align="center">Dodaj zlecenie transportowe</div>';
	
echo '<FORM action="index.php?page=zlecenie_transportowe_dodaj" method="post">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
echo '<INPUT type="hidden" name="etap" value="1">';
echo '<INPUT type="hidden" name="typ_zamowienia" value="'.$typ_zamowienia.'">';


echo '<table width=80% align="center" border="0" cellpadding=3>';
echo '<tr align="center"><td align="right" class="text">Rodzaj zlecenia : </td><td align="left">';
echo '<select name="typ_zamowienia" class="pole_input_biale" style="width: 200px" onchange="submit();">';
echo '<option></option>';
if($typ_zamowienia == 'zlecenie') echo '<option selected="selected" value="zlecenie">Nr zlecenia transportowego</option>';
else echo '<option value="zlecenie">Nr zlecenia transportowego</option>';
if($typ_zamowienia == 'list') echo '<option selected="selected" value="list">Nr listu przewozowego</option>';
else echo '<option value="list">Nr listu przewozowego</option>';
echo '</td><td align="left" class="text">';
if($typ_zamowienia == 'zlecenie')
	{
	$pytanie33 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_zlecenia_transportowego';");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		$kolejny_nr_zlecenia=$wynik33['opis'];
	
	$nowy_numer_zlecenia = $kolejny_nr_zlecenia."/".$AKTUALNY_MIESIAC."/".$aktualny_rok."/ZT";
	echo '</td><td align="left" class="text">'.$nowy_numer_zlecenia.'</td></tr>';
	}
if($typ_zamowienia == 'list') echo '</td><td align="left"><input autocomplete="off" type="text" size="25" maxlength="50" class="pole_input_biale" name="nr_listu_przewozowego" value="'.$nr_listu_przewozowego.'"></td></tr>';

// sposób dostawy
$ilosc_sposobow_dostawy = 0;
$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_dostawy' ORDER BY opis ASC;");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$ilosc_sposobow_dostawy++;
	$sposob_dostawy_id[$ilosc_sposobow_dostawy] = $wynik2['id'];
	$sposob_dostawy_opis[$ilosc_sposobow_dostawy] = $wynik2['opis'];
	}
echo '<tr align="center" class="text"><td align="right">'.$kol_sposob_dostawy.' : </td><td align="left">';
echo '<select name="sposob_dostawy" class="pole_input_biale" style="width: 200px">';
echo '<option></option>';
for ($k=1; $k<=$ilosc_sposobow_dostawy; $k++) 
if($sposob_dostawy == $sposob_dostawy_opis[$k]) echo '<option selected="selected" value="'.$sposob_dostawy_opis[$k].'">'.$sposob_dostawy_opis[$k].'</option>';
else echo '<option value="'.$sposob_dostawy_opis[$k].'">'.$sposob_dostawy_opis[$k].'</option>';
echo '</td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input_biale" name="nowy_sposob_dostawy" value="'.$nowy_sposob_dostawy.'"></td></tr>';

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
echo '<select name="kierowca" class="pole_input_biale" style="width: 200px">';
echo '<option></option>';
for ($k=1; $k<=$ilosc_kierowcow; $k++) 
if($kierowca == $kierowca_id[$k]) echo '<option selected="selected" value="'.$kierowca_id[$k].'">'.$kierowca_opis[$k].'</option>';
else echo '<option value="'.$kierowca_id[$k].'">'.$kierowca_opis[$k].'</option>';
	
echo '</td><td colspan="2"></td></tr>';


echo '<tr align="center"><td align="right" class="text">'.$kol_data_zaladunku.' : </td><td align="left">';         
echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
<td><input type="text" size="10" maxlength="20" class="pole_input_biale" autocomplete="off"  name="data_zaladunku" id="f_date_c" value="'.$data_zaladunku.'"/></td></tr></table>';
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
<td><input type="text" size="10" maxlength="20" readonly="readonly" class="pole_input_biale" autocomplete="off"  name="data_wyjazdu" id="f_date_d" value="'.$data_wyjazdu.'"/></td></tr></table>';
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
echo '<tr class="Text"><td align="center" colspan="4">';
echo '<INPUT type="submit" name="zapisz" value="Dalej">';
echo '</td></tr></table>';
echo '</FORM>';

echo '</td></tr></table>';
}
} //  do if etap ==1

//####################################################################################################################################################################################################################################
//####################################################################### dodajemy zamowienie do zlecenia transportowego    ###########################################################################################
//####################################################################################################################################################################################################################################
if($etap == 2)
{
if($zapisz == 'Dodaj')
	{
	//echo 'dodaje zamowienia do zlec transp<br>';
	$m = 0;
	$ilosc_zaznaczonych_zamowien = 0;
	$SUMA_POBRAN_BRUTTO = 0;
	
	//szukam sposobu płatności klienta
	$pytanie313 = mysqli_query($conn, "SELECT sposob_platnosci FROM klienci WHERE id=".$klient.";");
	while($wynik313= mysqli_fetch_assoc($pytanie313))
		{
		$sposob_platnosci=$wynik313['sposob_platnosci'];
		}
	
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
			$ilosc_zaznaczonych_zamowien++;
			for ($k=1; $k<=$ilosc_pozycji_2[$m]; $k++)
				{
				$nazwa_pozycja = 'pozycja['.$inne_zamowienie_id[$m].']['.$k.']';
				if($pozycja[$inne_zamowienie_id[$m]][$k] == 'on') 
					{
					if($liczba_paczek_wyrobow == '') $liczba_paczek_wyrobow = 0;
					$sql = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `kwota_brutto`, `data_dostawy`, `uwagi`, `liczba_paczek_wyrobow`, `pozycja_wyceny`, `user_id`, `odbior_material`, `odbior_szablon`, `zwrot_material`, `zwrot_szablon`, `zwrot_uszczelki`, `time`) 
					values ('$nowy_numer_zlecenia', '$klient', '$inne_zamowienie_id[$m]', '$wartosc_brutto_wycena[$k]', '$data_dostawy', '$uwagi', '$liczba_paczek_wyrobow', '$k', '$user_id', '$odbior_material', '$odbior_szablon', '$zwrot_material', '$zwrot_szablon', '$zwrot_uszczelki', '$time');";
					mysqli_query($conn, $sql);

					$pytanie13 = mysqli_query($conn, "UPDATE zamowienia SET data_dostawy = '".$data_dostawy."' WHERE id = ".$inne_zamowienie_id[$m].";");

					$SUMA_POBRAN_BRUTTO += $wartosc_brutto_wycena[$k];

					}
				}
			$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '".$nowy_numer_zlecenia."' WHERE id = ".$inne_zamowienie_id[$m].";");
			$pytanie13 = mysqli_query($conn, "UPDATE zamowienia SET data_dostawy = '".$data_dostawy."' WHERE id = ".$inne_zamowienie_id[$m].";");
			}// do if($nazwa_suma[$inne_zamowienie_id[$m]] == 'on') 
		}// do while($wynik3= mysqli_fetch_assoc($pytanie3))

	//sprawdzamy czy wpisać wartość dla sumy pobrań brutto
	if(($sposob_platnosci != 'Gotówka') && ($sposob_platnosci != 'Przedpłata')) $SUMA_POBRAN_BRUTTO=0;
	else 
		{
		$SUMA_POBRAN_BRUTTO = change($SUMA_POBRAN_BRUTTO);
		$pytanie122 =  "UPDATE zlecenia_transportowe_tresc SET suma_pobran_brutto = ".$SUMA_POBRAN_BRUTTO." WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' AND klient_id=".$klient.";";
		mysqli_query($conn, $pytanie122);
		}
		
		
	if($ilosc_zaznaczonych_zamowien != 0) echo '<div class="text_duzy_niebieski" align="center">Pozycja do zlecenia transportowego została dodana.</div><br><br>';
		//echo '$ilosc_zaznaczonych_zamowien='.$ilosc_zaznaczonych_zamowien.'<br>';
	
	// jezeli nie zostało wybrane żadne zamówienie ale zaznaczony jest ptaszek od odbioru lub zwrotu - dodajemy pozycje do zlec tranport na odbior od klienta.
	if(($ilosc_zaznaczonych_zamowien == 0) && (($odbior_material == 'on') || ($odbior_szablon == 'on') || ($zwrot_material == 'on') || ($zwrot_szablon == 'on') || ($zwrot_uszczelki == 'on')))
		{
		if($liczba_paczek_wyrobow == '') $liczba_paczek_wyrobow = 0;
		$query = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `data_dostawy`, `uwagi`, `liczba_paczek_wyrobow`, `user_id`, `odbior_material`, `odbior_szablon`, `zwrot_material`, `zwrot_szablon`, `zwrot_uszczelki`, `time`) values ('$nowy_numer_zlecenia', '$klient', 0,  '$data_dostawy', '$uwagi', '$liczba_paczek_wyrobow', '$user_id', '$odbior_material', '$odbior_szablon', '$zwrot_material', '$zwrot_szablon', '$zwrot_uszczelki', '$time');";
		mysqli_query($conn, $query);
		echo '<div align="center" class="text_duzy_niebieski"><br>Pozycja odbioru została dodana do zlecenia transportowego.</div><br>';
		}
	elseif(($ilosc_zaznaczonych_zamowien == 0) && ($odbior_material == '') && ($odbior_szablon == '') && ($zwrot_material == '') && ($zwrot_szablon == '') && ($zwrot_uszczelki == '')) echo '<div align="center" class="text_duzy_czerwony"><br>Żadna pozycja nie została dodana - brak wybrania czegokolwiek.</div><br>';
		
	if($skad == 'pokaz') echo '<div align="center"><a href="index.php?page=zlecenie_transportowe_pokaz&wg_czego='.$wg_czego.'&jak='.$jak.'&id='.$id.'"><button type="button">Powrót do zlecenia transportowego</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=id"><button type="button">Lista zleceń transportowych</button></a></div>';
	else echo '<div align="center"><a href="index.php?page=zlecenie_transportowe_dodaj&nowy_numer_zlecenia='.$nowy_numer_zlecenia.'&etap=2"><button type="button">Dodaj kolejną pozycję do zlecenia</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=id"><button type="button">Lista zleceń transportowych</button></a></div>';
	$etap = 3;
	} // do if($zapisz == 'Dodaj')

	
	//etap 3 dodajemy pozycje do istniejącego zlec transp
	if((!$submit) && ($zapisz != 'Dodaj') && ($etap == 2))
	{
		echo '<table width="100%" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';
		echo '<div class="text_duzy" align="center">Dodaj pozycję do zlecenia transportowego '.$nowy_numer_zlecenia.'</div><br>';
		
		$pytanie115 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' LIMIT 1;");
		while($wynik115= mysqli_fetch_assoc($pytanie115))
			{
			$id = $wynik115['id'];
			}
		echo '<FORM name="zlec_transp" action="index.php?page=zlecenie_transportowe_dodaj&etap=3" method="post">';
		
		echo '<INPUT type="hidden" name="nowy_numer_zlecenia" value="'.$nowy_numer_zlecenia.'">';
		echo '<INPUT type="hidden" name="etap" value="'.$etap.'">';
		echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		
		$klient_id = [];
		$klient_nazwa = [];

		$ilosc_klientow = 0;
		$pytanie1 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC;");
		while($wynik1= mysqli_fetch_assoc($pytanie1))
			{
			$klient_id_test = $wynik1['id'];
			$jest = 0;
			$pytanie15 = mysqli_query($conn, "SELECT id, nazwa FROM zlecenia_transportowe_tresc WHERE klient_id=".$klient_id_test." AND nr_zlecenia_transportowego='".$nowy_numer_zlecenia."' LIMIT 1;");
			if (mysqli_num_rows($pytanie15) > 0) {
			while($wynik15= mysqli_fetch_assoc($pytanie15))
				{
				//echo 'klient jest w zleceniu='.$klient_id_test.'<br>';
				$jest=1;
				}
			}
			
			if($jest == 0)
				{
				$ilosc_klientow++;
				$klient_id[$ilosc_klientow] = $wynik1['id'];
				$klient_nazwa[$ilosc_klientow] = $wynik1['nazwa'];
				}
			}
		
			echo '<table align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
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
				
			echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
			echo '<td><select name="klient" class="pole_input_biale" onchange="submit();">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_klientow; $k++) 
			if($klient == $klient_id[$k]) echo '<option selected="selected" value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
			else echo '<option value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
			echo '</select></td>';
			
			$pytanie14 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = $klient;");
			while($wynik14= mysqli_fetch_assoc($pytanie14))
				{
				$klient_ulica=$wynik14['dostawy_ulica'];
				$klient_miasto=$wynik14['dostawy_miasto'];
				$klient_kod_pocztowy=$wynik14['dostawy_kod_pocztowy'];
				}
			echo '<td>'.$klient_ulica.'<br>'.$klient_kod_pocztowy.' '.$klient_miasto.'</td>';
				
			//sprawdzanie listy zamówień klienta

			$inne_zamowienie_id = [];
			$inne_nr_zamowienia = [];
			$inne_nr_zamowienia_klienta = [];
			$inne_termin_realizacji = [];
			$ilosc_pozycji = [];
			$inne_wartosc_brutto = [];
			$m = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE klient_id=$klient AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane' ORDER BY id ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$m++;
				$inne_zamowienie_id[$m]=$wynik3['id'];
				$inne_nr_zamowienia[$m]=$wynik3['nr_zamowienia'];
				$inne_nr_zamowienia_klienta[$m]=$wynik3['nr_zamowienia_klienta'];
				$inne_termin_realizacji[$m]=$wynik3['termin_realizacji'];
				$ilosc_pozycji[$m] = 0;
				$pytanie33 = mysqli_query($conn, "SELECT wartosc_brutto FROM wyceny WHERE zamowienie_id=".$inne_zamowienie_id[$m]." ORDER BY pozycja ASC;");
				while($wynik33= mysqli_fetch_assoc($pytanie33))
					{
					$ilosc_pozycji[$m] = $ilosc_pozycji[$m] + 1;
					$wartosc_brutto_wycena=$wynik33['wartosc_brutto'];
					$id_pozycja = 'id_pozycja['.$inne_zamowienie_id[$m].']['.$ilosc_pozycji[$m].']';
					echo '<input type="hidden" id="'.$id_pozycja.'" value="'.$wartosc_brutto_wycena.'">';
					}
				}
				echo '<td>';
				$wysokosc_wiersza = 30;
				echo '<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="text">';
				for ($z=1; $z<=$m; $z++)
					{
					$jest_w_innym_zleceniu = 0;
					$title='';
					$disabled = '';
					$pytanie4 = mysqli_query($conn, "SELECT nr_zlecenia_transportowego FROM zamowienia WHERE id='".$inne_zamowienie_id[$z]."' AND klient_id=".$klient.";");
					while($wynik4= mysqli_fetch_assoc($pytanie4))
						{
						$nr_zlecenia_transportowego_z_zamowienia = $wynik4['nr_zlecenia_transportowego'];
						if($nr_zlecenia_transportowego_z_zamowienia != '')
							{
							$title = $nr_zlecenia_transportowego_z_zamowienia;
							$jest_w_innym_zleceniu = 1;
							$disabled = ' disabled';
							}
						}
						if($jest_w_innym_zleceniu == 0) $font_color = "black"; else $font_color = "red";
						echo '<tr align="center" title="'.$title.'"><td width="18%" height="'.$wysokosc_wiersza.'px"><font color="blue">'.$inne_termin_realizacji[$z].'</font></td>';
						echo '<td width="40%" height="'.$wysokosc_wiersza.'px"><font color="'.$font_color.'">'.$inne_nr_zamowienia[$z].'</font></td>';
						echo '<td width="2%"><font color="'.$font_color.'"><b>&nbsp;|&nbsp;</b></font></td>';
						echo '<td width="40%"><font color="'.$font_color.'">'.$inne_nr_zamowienia_klienta[$z].'</font></td>';
						$nazwa_suma = 'nazwa_suma['.$inne_zamowienie_id[$z].']';
						$id_test = 'id_'.$inne_zamowienie_id[$z];
						
						echo '<td width="4%"><input type="checkbox" id="'.$id_test.'" name="'.$nazwa_suma.'" '.$disabled.' onClick="toggle('.$inne_zamowienie_id[$z].')"></td></tr>';
						
						echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$inne_zamowienie_id[$z].'" value="'.$ilosc_pozycji[$z].'">';
						
						for ($k=1; $k<=$ilosc_pozycji[$z]; $k++)
							{
							$pozycja_dostarczona = '';
							$nazwa_pozycja = 'pozycja['.$inne_zamowienie_id[$z].']['.$k.']';
							$id_pozycja_status = 'id_pozycja_status['.$inne_zamowienie_id[$z].']['.$k.']';
							$id_pozycja_wycena = 'id_pozycja_wycena['.$inne_zamowienie_id[$z].']['.$k.']';
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
							
							if($pozycja_status == 'Dostarczone') echo '<td width="4%" height="'.$wysokosc_wiersza.'px"><input title="'.$pozycja_status.'" type="checkbox" disabled></td></tr>';
							else echo '<td width="4%" height="'.$wysokosc_wiersza.'px"><input title="'.$pozycja_status.'" '.$disabled.' id="'.$id_pozycja_wycena.'" name="'.$nazwa_pozycja.'" type="checkbox" onClick="licz_sume_zamowien('.$inne_zamowienie_id[$z].', '.$k.')"></td></tr>';
							}
						echo '<tr align="center"><td colspan="5" align="right" height="'.$wysokosc_wiersza.'px"><hr></td></tr>';
						}
					echo '</table>';
				echo '</td>';
				
				// suma zamowien
				echo '<td valign="top">';
					echo '<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="text">';
					for ($z=1; $z<=$m; $z++)
						{
						$ilosc_pozycji[$z] = $ilosc_pozycji[$z] + 2; //tylko do wyliczenia wysokości tabeli
						$suma_wysokosc_wiersza = $wysokosc_wiersza*$ilosc_pozycji[$z];
						$input_id_suma_brutto = 'input_id_suma_brutto['.$inne_zamowienie_id[$z].']';
						echo '<tr align="center"><td height="'.$suma_wysokosc_wiersza.'px">';
						echo '<input type="text" id="'.$input_id_suma_brutto.'" class="pole_input_biale_bez_ramki" readonly="readonly" size="5" name="'.$inne_wartosc_brutto[$z].'">'.$waluta;
						echo '</td></tr>';
						}
					echo '</table>';
				echo '</td>';
				
				echo '<td>';
					echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
					<td><input type="text" size="10" maxlength="20" class="pole_input_biale" autocomplete="off"  name="data_dostawy" id="f_date_c" value="'.$data_dostawy.'"/></td></tr></table>';
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
				
				// odbior
				echo '<td>';
					echo '<table border="0" class="text" cellpadding="2" cellspacing="2">';
					echo '<tr><td width="10%" align="left"><input type="checkbox" name="odbior_material"></td><td width="90%" align="left">Materiał</td></tr>';
					echo '<tr><td width="10%" align="left"><input type="checkbox" name="odbior_szablon"></td><td width="90%" align="left">Szablon</td></tr>';
					echo '</table>';
				echo '</td>';
				
				// zwrot
				// echo '<td>';
				// 	echo '<table border="0" class="text" cellpadding="2" cellspacing="2">';
				// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_material"></td><td width="90%" align="left">Materiał</td></tr>';
				// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_szablon"></td><td width="90%" align="left">Szablon</td></tr>';
				// 	echo '<tr><td width="10%" align="left"><input type="checkbox" name="zwrot_uszczelki"></td><td width="90%" align="left">Uszczelka</td></tr>';
				// 	echo '</table>';
				// echo '</td>';
			echo '</tr></table>';
			
		echo '</td></tr>';
		
		echo '<tr><td align="center"><INPUT type="submit" name="zapisz" value="Dodaj"></td></tr>';
		if($skad == 'pokaz') echo '<tr><td align="center">'.$powrot_do_konkretnego_zlecenia_transportowego.'</td></tr>';

		echo '</table>';
		echo '</FORM>';
	} ///	if((!$result) && ($zapisz != 'Dalej') && ($etap == 2))
	
} //if($etap == 2)


?>