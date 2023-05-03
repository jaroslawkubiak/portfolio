<?php	
$SUMA_NETTO = 0;
$SUMA_BRUTTO = 0;
$SUMA_NETTO_po_korekcie = 0;
$SUMA_BRUTTO_po_korekcie = 0;
$nazwa_produktu = [];
$ilosc_sztuk = [];
$pozycja_transport = [];
$wartosc_netto = [];
$wartosc_brutto = [];
$stawka_vat_np = [];
$stawka_vat = [];
$cena_netto_za_sztuke = [];
$nr_fv_wycena = [];
$data_fv_wycena = [];
$nazwa_pozycja = [];

$ilosc_pozycji2 = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'TAK' AND nr_faktury = '".$faktura_do_korekty."' ORDER BY pozycja ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	//echo 'tutaj1<br>';
	$ilosc_pozycji2++;
	$pozycja_id[$ilosc_pozycji2]=$wynik['id'];
	$klient_id=$wynik['klient_id'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$nazwa_produktu[$ilosc_pozycji2]=$wynik['nazwa_produktu'];
	$ilosc_sztuk[$ilosc_pozycji2]=$wynik['ilosc_sztuk'];
	$pozycja_transport[$ilosc_pozycji2]=$wynik['pozycja_transport'];
	$wartosc_netto[$ilosc_pozycji2]=$wynik['wartosc_netto'];
	$SUMA_NETTO += $wartosc_netto[$ilosc_pozycji2];
	$wartosc_brutto[$ilosc_pozycji2]=$wynik['wartosc_brutto'];
	$SUMA_BRUTTO += $wartosc_brutto[$ilosc_pozycji2];
	$stawka_vat[$ilosc_pozycji2]=$wynik['vat'];
	$cena_netto_za_sztuke[$ilosc_pozycji2]=$wynik['cena_netto_za_sztuke'];
	$nr_fv_wycena[$ilosc_pozycji2]=$wynik['nr_faktury'];
	// szukamy jpk i id
	$pytanie22 = mysqli_query($conn, "SELECT pole_jpk, id, konto FROM fv_naglowek WHERE nr_dok = '".$nr_fv_wycena[$ilosc_pozycji2]."' AND typ_dok = 'Faktura' AND zamowienie_id = ".$zamowienie_id.";");
	while($wynik22= mysqli_fetch_assoc($pytanie22))
		{
		$pole_jpk_faktury=$wynik22['pole_jpk'];
		$id_faktury=$wynik22['id'];
		$wybrane_konto=$wynik22['konto'];
		}
	
	$data_fv_wycena[$ilosc_pozycji2]=$wynik['data_faktury'];

	if($pozycja_transport[$ilosc_pozycji2] == 'tak')
		{
		$nazwa_produktu[$ilosc_pozycji2] = 'Transport';
		$ilosc_sztuk[$ilosc_pozycji2] = 1;
		$cena_netto_za_sztuke[$ilosc_pozycji2] = $wartosc_netto[$ilosc_pozycji2];
		}
	}
// dane po korekcie

$ilosc_pozycji2 = 0; //////																		AND nr_faktury = 'korekta'
$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND nr_faktury = 'korekta' ORDER BY pozycja ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	//echo 'tutaj2<br>';
	$ilosc_pozycji2++;
	$nazwa_produktu_po_korekcie[$ilosc_pozycji2]=$wynik['nazwa_produktu'];
	$ilosc_sztuk_po_korekcie[$ilosc_pozycji2]=$wynik['ilosc_sztuk'];
	$pozycja_transport_po_korekcie[$ilosc_pozycji2]=$wynik['pozycja_transport'];
	
	$wartosc_netto_po_korekcie[$ilosc_pozycji2]=$wynik['wartosc_netto'];
	$SUMA_NETTO_po_korekcie += $wartosc_netto_po_korekcie[$ilosc_pozycji2];
	$wartosc_brutto_po_korekcie[$ilosc_pozycji2]=$wynik['wartosc_brutto'];
	$SUMA_BRUTTO_po_korekcie += $wartosc_brutto_po_korekcie[$ilosc_pozycji2];
	
	$stawka_vat_po_korekcie[$ilosc_pozycji2]=$wynik['vat'];
	$cena_netto_za_sztuke_po_korekcie[$ilosc_pozycji2]=$wynik['cena_netto_za_sztuke'];
	
	if($pozycja_transport_po_korekcie[$ilosc_pozycji2] == 'tak')
		{
		$nazwa_produktu_po_korekcie[$ilosc_pozycji2] = 'Transport';
		$ilosc_sztuk_po_korekcie[$ilosc_pozycji2] = 1;
		$cena_netto_za_sztuke_po_korekcie[$ilosc_pozycji2] = $wartosc_netto_po_korekcie[$ilosc_pozycji2];
		}
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
		
$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_korekty_fv';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	$numer_korekty=$wynik3['opis'];
	}	
	
$pytanie22 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id.";");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$nabywca_nazwa=$wynik22['pelna_nazwa'];
	$nabywca_ulica=$wynik22['ulica'];
	$nabywca_miasto=$wynik22['miasto'];
	$nabywca_kod_pocztowy=$wynik22['kod_pocztowy'];
	$nabywca_kraj=$wynik22['kraj'];
	$nabywca_nip=$wynik22['nip'];
	$nabywca_forma_platnosci=$wynik22['sposob_platnosci'];
	$nabywca_termin_platnosci_dni=$wynik22['termin_platnosci_dni'];
	$nabywca_nazwa_skrocona=$wynik22['nazwa'];
	}	

if($submit)
	{
	if($zmienic_sposob_platnosci == 'on')
		{
		$ins=mysqli_query($conn, "update klienci set sposob_platnosci='".$sposob_platnosci."', termin_platnosci_dni='".$termin_platnosci."' WHERE id = ".$klient_id.";");
		echo '<div align="center" class="text_duzy_niebieski">Sposób płatności został zmieniony na "'.$sposob_platnosci.'".</div><br>';
		}
			
	$user_id = $_SESSION["USER_ID"];
	$pytanie33 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$user_imie=$wynik33['imie'];
		$user_nazwisko=$wynik33['nazwisko'];
		}
			
	$numer_korekty = $numer_korekty.'/'.$AKTUALNY_ROK.'/K';
	
	$nowy_nr_korekty = $numer_korekty + 1;
	$ins=mysqli_query($conn, "update rozne set opis=".$nowy_nr_korekty." WHERE typ = 'nr_korekty_fv';");

	//$temp = 86400 * 5;
	//$time = $time - $temp;
	$data = date('d-m-Y', $time);
	$data_rok = date('Y', $time);
	$data_miesiac = date('m', $time);
	if($data_miesiac != 10) $data_miesiac = zamien_dowolne_znaki($data_miesiac, '0', '');
	// obliczamy termin płatności
	$do_kiedy_termin_platnosci = $time + ($termin_platnosci * 86400); // 86400 to 1 dzień
	
	$kopia_nr = change_link($numer_korekty);
	$link_fv = 'korekta_'.$kopia_nr.'.pdf';		


	$query = mysqli_query($conn, "INSERT INTO fv_naglowek (`nr_dok`, `typ_dok`, `waluta`, `pole_jpk`, `zamowienie_id`, `nabywca_id`, `nabywca_nazwa_skrocona`, `data_wystawienia`, `wartosc_netto_fv`, `vat`, `wartosc_brutto_fv`, `wplacono`, `zaplacona`, `link_folder`, `nazwa_pliku`, `data_wygenerowania_dokumentu`, `nabywca_nazwa`, `nabywca_ulica`, `nabywca_miasto`, `nabywca_kod_pocztowy`, `nabywca_nip`, `nabywca_sposob_platnosci`, `termin_platnosci`, `termin_platnosci_dni`, `data_wystawienia_time`, `data_wystawienia_miesiac`, `data_wystawienia_rok`, `data_zakonczenia_dostawy`, `user_id`, `user_imie`, `user_nazwisko`,`informacja_o_fakturze`, `nr_fv_korygowanej`, `data_fv_korygowanej`, `tytul_korekty`, `konto`)
	values ('$numer_korekty', 'Korekta', 'PLN', '$pole_jpk', '$zamowienie_id', '$klient_id', '$nabywca_nazwa_skrocona', '$data', '0', '$stawka_vat[1]', '0', '0', 'nie', 'faktury_korekty', '$link_fv', '$data', '$nabywca_nazwa', '$nabywca_ulica', '$nabywca_miasto', '$nabywca_kod_pocztowy', '$nabywca_nip', '$sposob_platnosci', '$do_kiedy_termin_platnosci', '$termin_platnosci', '$time', '$data_miesiac', '$data_rok', '$data', '$user_id', '$user_imie', '$user_nazwisko', '$informacja_o_fakturze', '$nr_fv_wycena[1]', '$data_fv_wycena[1]', '$tytul', '$wybrane_konto');");

	$fv_id = mysqli_insert_id($conn);
	
	// wpisujemy id utworzonej korekty do fv dla której została utworzona
	$ins=mysqli_query($conn, "update fv_naglowek set tytul_korekty = '".$fv_id."' WHERE id = ".$id_faktury.";");
  

	//echo 'fv_id='.$fv_id.'<br>';
	$SUMA_NETTO = 0;
	$SUMA_BRUTTO = 0;
	for($x = 1; $x<=$ilosc_pozycji2; $x++) 
		{
		$SUMA_NETTO += $wartosc_netto_po_korekcie[$x];
		$SUMA_BRUTTO += $wartosc_brutto_po_korekcie[$x];
		$cena_brutto_za_sztuke_po_korekcie[$x] = $cena_netto_za_sztuke_po_korekcie[$x] + ($cena_netto_za_sztuke_po_korekcie[$x] * $stawka_vat_po_korekcie[$x]/100);
		$cena_brutto_za_sztuke_po_korekcie[$x] = number_format($cena_brutto_za_sztuke_po_korekcie[$x], 2,'.','');
		
		//szukamy id pozycji wyceny
		$pytanie2 = mysqli_query($conn, "SELECT pozycja FROM wyceny WHERE id = ".$pozycja_id[$x].";");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			$nr_pozycji_z_wyceny[$x]=$wynik2['pozycja'];

		//szukamy jednostki faktury korygowanej
		$pytanie27 = mysqli_query($conn, "SELECT jednostka FROM fv_pozycje WHERE fv_id = ".$id_faktury." AND pozycja = ".$x.";");
		while($wynik27= mysqli_fetch_assoc($pytanie27))
			$jednostka_z_pozycji[$x]=$wynik27['jednostka'];
			

		$ilosc_sztuk_po_korekcie[$x] = change($ilosc_sztuk_po_korekcie[$x]);
		$cena_netto_za_sztuke_po_korekcie[$x] = change($cena_netto_za_sztuke_po_korekcie[$x]);
		$cena_brutto_za_sztuke_po_korekcie[$x] = change($cena_brutto_za_sztuke_po_korekcie[$x]);
		$wartosc_netto_po_korekcie[$x] = change($wartosc_netto_po_korekcie[$x]);
		$wartosc_brutto_po_korekcie[$x] = change($wartosc_brutto_po_korekcie[$x]);
		$query = mysqli_query($conn, "INSERT INTO fv_pozycje (`fv_id`, `nr_fv`, `zamowienie_id`, `nabywca_id`, `pozycja`, `nazwa_produktu`, `jednostka`, `ilosc`, `cena_netto`, `vat`, `cena_brutto`, `wartosc_netto`, `wartosc_brutto`, `pozycja_id`) 
		values ('$fv_id', '$numer_korekty', '$zamowienie_id', '$klient_id', '$nr_pozycji_z_wyceny[$x]', '$nazwa_produktu_po_korekcie[$x]', '$jednostka_z_pozycji[$x]', '$ilosc_sztuk_po_korekcie[$x]', '$cena_netto_za_sztuke_po_korekcie[$x]', '$stawka_vat_po_korekcie[$x]', '$cena_brutto_za_sztuke_po_korekcie[$x]', '$wartosc_netto_po_korekcie[$x]', '$wartosc_brutto_po_korekcie[$x]', '$pozycja_id[$x]');");

		mysqli_query($conn, "update wyceny set data_faktury = '".$data."', data_faktury_time = '".$time."', data_faktury_miesiac = '".$data_miesiac."', data_faktury_rok = '".$data_rok."', nr_faktury = '".$numer_korekty."' WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' AND nr_faktury = 'korekta';");

		$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.','');
		$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
		$SUMA_NETTO = change($SUMA_NETTO);
		$SUMA_BRUTTO = change($SUMA_BRUTTO);
		$ins=mysqli_query($conn, "update fv_naglowek set wartosc_netto_fv = ".$SUMA_NETTO.", wartosc_brutto_fv = ".$SUMA_BRUTTO." WHERE id = ".$fv_id.";");
		}
	echo '<div align="center" class="text_duzy_niebieski">Korekta '.$numer_korekty.' dla zamówienia '.$nr_zamowienia.' została wystawiona.</div><br>';
	
	
	include('php/generuj_fakture_korekte.php');

	echo '<center><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_korekty/'.$link_fv.'" target="_blank">'.$image_pdf_icon2.'</a></center>';
	
	if($skad == 'zlecenie_transportowe') echo $powrot_do_konkretnego_zlecenia_transportowego_edycja;
	else echo $powrot_do_zamowienia;
	}
else
	{
	$pozycja = [];

	if(($nabywca_ulica == '') || ($nabywca_miasto == '') || ($nabywca_kod_pocztowy == '') || ($nabywca_nip == '') || ($nabywca_forma_platnosci == '') || ($nabywca_nazwa == '')) $brak_danych_nabywcy = 1; else $brak_danych_nabywcy = 0;
	if(($sprzedawca_nazwa == '') || ($sprzedawca_ulica == '') || ($sprzedawca_miasto == '') || ($sprzedawca_kod_pocztowy == '') || ($sprzedawca_nip == '') || ($sprzedawca_miejsce_wystawienia == '') || ($sprzedawca_konto == '') || ($sprzedawca_email == '')) $brak_danych_sprzedawcy = 1; else $brak_danych_sprzedawcy = 0;

	echo '<FORM action="index.php?page=fv_wystaw_korekte&zamowienie_id='.$zamowienie_id.'" method="post">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="pole_jpk" value="'.$pole_jpk_faktury.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	echo '<input type="hidden" name="id_faktury" value="'.$id_faktury.'">';
	echo '<input type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
	echo '<input type="hidden" name="faktura_do_korekty" value="'.$faktura_do_korekty.'">';
	echo '<input type="hidden" name="numer_korekty" value="'.$numer_korekty.'">';
	echo '<input type="hidden" name="calkowita_ilosc_pozycji" value="'.$calkowita_ilosc_pozycji.'">';

	echo '<div align="center" class="text_ogromny">Wystaw korektę faktury do zamówienia : <font color="blue">'.$nr_zamowienia.'</font></div><br>';
	
	echo '<table width="1100px" align="center" class="text" border="0">';
	echo '<tr align="center" class="text"><td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="0">';
		echo '<tr align="center" class="text" valign="top"><td width="50%" align="left"><img src="images/arcus_logo_mini.png" height="100px"></td>';
		echo '<td width="50%" align="right">';
		echo 'Telefon: '.$sprzedawca_telefon.'<br>';
		echo 'e-mail: '.$sprzedawca_email.'<br><br>';
		echo $sprzedawca_www.'<br><br>';
		echo '</td></tr></table>';
	echo '<hr></td></tr>'; // linia pozioma
	
	echo '<tr class="text_duzy"><td width="50%" align="left">FAKTURA KORYGUJĄCA</td><td width="50%" align="right">Nr: '.$numer_korekty.'/'.$AKTUALNY_ROK.'/K</td></tr>';
	echo '<tr width="100%"><td colspan="2"><hr></td></tr>';
	
	echo '<tr class="text"><td width="100%" align="left" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="0">';
		echo '<tr align="left" class="text"><td width="15%">Tytuł:</td>';
		echo '<td width="85%"><input type="text" name="tytul" size="40" class="pole_input_biale"></td></tr>';
		echo '<tr align="left" class="text"><td>Faktura korygowana:</td>';
		echo '<td>'.$nr_fv_wycena[1].' z dnia '.$data_fv_wycena[1].'</td></tr>';
		echo '</table>';
	echo '</td></tr>';
	
	
	// dane sprzedawcy i nabywcy
	echo '<tr align="center" class="text"><td width="50%">';
		if($brak_danych_sprzedawcy == 1) $bg_color="red"; else $bg_color="white";
		echo '<table width="100%" align="center" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_szary.'"><td align="center" class="text_duzy">SPRZEDAWCA</td></tr>';
			echo '<tr><td><table width="100%" align="center" border="0" bgcolor="'.$bg_color.'">';
				echo '<tr><td class="text_duzy" height="70px" valign="top">'.$sprzedawca_nazwa.'</td><tr>';
				echo '<tr><td class="text_sredni">'.$sprzedawca_ulica.'<br>';
				echo $sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.', Polska<br>';
				echo 'NIP '.$sprzedawca_nip.'<br>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';
	echo '</td>';
	echo '<td width="50%">';
		if($brak_danych_nabywcy == 1) $bg_color="red"; else $bg_color="white";
		echo '<table width="100%" align="center" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_szary.'"><td align="center" class="text_duzy">NABYWCA</td></tr>';
			echo '<tr><td><table width="100%" align="center" border="0" bgcolor="'.$bg_color.'">';
				echo '<tr><td class="text_duzy" height="70px" valign="top">'.$nabywca_nazwa.'</td><tr>';
				echo '<tr><td class="text_sredni">'.$nabywca_ulica.'<br>';
				echo $nabywca_kod_pocztowy.' '.$nabywca_miasto.', '.$nabywca_kraj.'<br>';
				echo 'NIP '.$nabywca_nip.'<br>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';
	echo '</td></tr>';
	
	// dane
	echo '<tr align="center" class="text"><td width="50%">';

		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
		echo '<tr class="text" align="left"><td width="30%">Miejsce wystawienia:</td><td colspan="2" width="70%">'.$sprzedawca_miejsce_wystawienia.'</td></tr>';
		echo '<tr class="text" align="left"><td>Termin płatności:</td><td colspan="2">';
		
		echo '<select name="termin_platnosci" class="pole_input">';
		if($nabywca_termin_platnosci_dni == 1) echo '<option selected="selected">1</option>'; else echo '<option>1</option>';
		if($nabywca_termin_platnosci_dni == 3) echo '<option selected="selected">3</option>'; else echo '<option>3</option>';
		if($nabywca_termin_platnosci_dni == 7) echo '<option selected="selected">7</option>'; else echo '<option>7</option>';
		if($nabywca_termin_platnosci_dni == 14) echo '<option selected="selected">14</option>'; else echo '<option>14</option>';
		if($nabywca_termin_platnosci_dni == 21) echo '<option selected="selected">21</option>'; else echo '<option>21</option>';
		if($nabywca_termin_platnosci_dni == 28) echo '<option selected="selected">28</option>'; else echo '<option>28</option>';
		echo '</select>';
		
		
		echo ' dni</td></tr>';
		if($nabywca_forma_platnosci == '') echo '<tr class="text" align="left"><td>Forma płatności:</td><td colspan="2"><font color="red">BRAK SPOSOBU PŁATNO¦CI</font></td></tr>';
		else 
			{
			echo '<tr class="text" align="left"><td>Forma płatności:</td><td width="40%">';
			// sposób płatności
			$ilosc_sposob_platnosci = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_platnosci' ORDER BY opis ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$ilosc_sposob_platnosci++;
				$sposob_platnosci_id[$ilosc_sposob_platnosci] = $wynik3['id'];
				$sposob_platnosci_opis[$ilosc_sposob_platnosci] = $wynik3['opis'];
				}
			echo '<select name="sposob_platnosci" class="pole_input" style="width: 200px">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_sposob_platnosci; $k++) 
			if($nabywca_forma_platnosci == $sposob_platnosci_opis[$k]) echo '<option selected="selected" value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			else echo '<option value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			echo '</td>';
			echo '<td width="30%" valign="middle"><input name="zmienic_sposob_platnosci" type="checkbox">zmienić na stałe?</td></tr>';
			}
		echo '</td></tr></table>';
	echo '</td>';

	echo '<td width="40%">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
		$data = date('d-m-Y', $time);
		echo '<tr class="text" align="right"><td width="80%">Data wystawienia:</td><td width="20%">'.$data.'</td></tr>';
		echo '<tr class="text" align="right"><td>Data zakończenia dostawy/usług:</td><td>'.$data.'</td></tr>';
		echo '</td></tr></table>';
	echo '</td></tr>';
	
	// wykaz pozycji
	echo '<td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="1" BORDERCOLOR="black" frame="box" RULES="all" cellpadding="2" cellspacing="2">';
		echo '<tr class="text" align="center" bgcolor="'.$kolor_szary.'">';
		echo '<td width="10px">Lp.</td>';
		echo '<td>Towar / Usługa</td>';
		echo '<td width="60px">Jednostka</td>';
		echo '<td width="60px">Ilośść</td>';
		echo '<td width="110px">Cena<br>netto</td>';
		echo '<td width="60px">VAT</td>';
		echo '<td width="110px">Cena<br>brutto</td>';
		echo '<td width="110px">Wartość<br>netto</td>';
		echo '<td width="110px">Wartość<br>brutto</td></tr>';
			
		echo '<INPUT type="hidden" name="ilosc_pozycji2" id="'.$zamowienie_id.'" value="'.$ilosc_pozycji2.'">';
		
		for($x = 1; $x<=$ilosc_pozycji2; $x++)
			{
			$nr_pozycja_id = 'pozycja['.$x.']';
			echo '<input type="hidden" name="'.$nr_pozycja_id.'" value="'.$pozycja_id[$x].'">';
			echo '<tr class="text" align="center" bgcolor="white"><td width="10px">'.$x.'</td>';
			echo '<td align="left">';
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="left">'.$nazwa_produktu[$x].'</td></tr>';
				echo '<tr><td align="right"><font size="1"><i>korekta</i></font></td></tr>';
				echo '<tr><td align="right"><font size="1"><i>po korekcie</i></font></td></tr>';
				echo '</table>';
			echo '</td>';
			$pytanie36 = mysqli_query($conn, "SELECT jednostka FROM fv_pozycje WHERE zamowienie_id=".$zamowienie_id." AND pozycja = ".$x.";");
			while($wynik36= mysqli_fetch_assoc($pytanie36))
				{
				$jednostka = $wynik36['jednostka'];
				}
			echo '<td>';	
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="center">'.$jednostka.'</td></tr>';
				echo '<tr class="text"><td align="center">&nbsp;</td></tr>';
				echo '<tr class="text"><td align="center">'.$jednostka.'</td></tr>';
				echo '</table>';
			echo '</td>';
			
			$ilosc_sztuk[$x] = number_format($ilosc_sztuk[$x], 2,'.','');
			$ilosc_sztuk_po_korekcie[$x] = number_format($ilosc_sztuk_po_korekcie[$x], 2,'.','');
			echo '<td align="right">';
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="right">'.$ilosc_sztuk[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">&nbsp;</td></tr>';
				echo '<tr class="text"><td align="right">'.$ilosc_sztuk_po_korekcie[$x].'</td></tr>';
				echo '</table>';
			echo '</td>';
			
			$cena_netto_za_sztuke[$x] = number_format($cena_netto_za_sztuke[$x], 2,'.','');
			$cena_netto_za_sztuke_po_korekcie[$x] = number_format($cena_netto_za_sztuke_po_korekcie[$x], 2,'.','');
			$cena_korekta[$x] = $cena_netto_za_sztuke_po_korekcie[$x] - $cena_netto_za_sztuke[$x];
			$cena_korekta[$x] = number_format($cena_korekta[$x], 2,'.','');
			echo '<td align="right">';
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="right">'.$cena_netto_za_sztuke[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$cena_korekta[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$cena_netto_za_sztuke_po_korekcie[$x].'</td></tr>';
				echo '</table>';
			echo '</td>';
			
			echo '<td align="right">';
				echo '<table border="0" width="100%" align="center">';
				
				if($stawka_vat[$x] != 'NP') $znak_procent = '%'; else $znak_procent = '';
				echo '<tr class="text"><td align="center">'.$stawka_vat[$x].$znak_procent.'</td></tr>';
				echo '<tr class="text"><td align="center">&nbsp;</td></tr>';
				if($stawka_vat_po_korekcie[$x] != 'NP') $znak_procent = '%'; else $znak_procent = '';
				echo '<tr class="text"><td align="center">'.$stawka_vat_po_korekcie[$x].$znak_procent.'</td></tr>';
				echo '</table>';
			echo '</td>';
			
			$cena_brutto_za_sztuke_po_korekcie[$x] = $cena_netto_za_sztuke_po_korekcie[$x] + ($cena_netto_za_sztuke_po_korekcie[$x] * $stawka_vat_po_korekcie[$x]/100);
			$cena_brutto_za_sztuke[$x] = $cena_netto_za_sztuke[$x] + ($cena_netto_za_sztuke[$x] * $stawka_vat[$x]/100);
			$cena_brutto_za_sztuke_korekta[$x] = $cena_brutto_za_sztuke_po_korekcie[$x] - $cena_brutto_za_sztuke[$x];
			$cena_brutto_za_sztuke_po_korekcie[$x] = number_format($cena_brutto_za_sztuke_po_korekcie[$x], 2,'.','');
			$cena_brutto_za_sztuke[$x] = number_format($cena_brutto_za_sztuke[$x], 2,'.','');
			$cena_brutto_za_sztuke_korekta[$x] = number_format($cena_brutto_za_sztuke_korekta[$x], 2,'.','');
			echo '<td align="right">';
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="right">'.$cena_brutto_za_sztuke[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$cena_brutto_za_sztuke_korekta[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$cena_brutto_za_sztuke_po_korekcie[$x].'</td></tr>';
				echo '</table>';
			echo '</td>';
			
			$wartosc_netto_korekta[$x] = $wartosc_netto_po_korekcie[$x] - $wartosc_netto[$x];
			$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
			$wartosc_netto_po_korekcie[$x] = number_format($wartosc_netto_po_korekcie[$x], 2,'.',' ');
			$wartosc_netto_korekta[$x] = number_format($wartosc_netto_korekta[$x], 2,'.',' ');
			echo '<td align="right">';
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="right">'.$wartosc_netto[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$wartosc_netto_korekta[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$wartosc_netto_po_korekcie[$x].'</td></tr>';
				echo '</table>';
			echo '</td>';
			
			$wartosc_brutto_korekta[$x] = $wartosc_brutto_po_korekcie[$x] - $wartosc_brutto[$x];
			$wartosc_brutto[$x] = number_format($wartosc_brutto[$x], 2,'.',' ');
			$wartosc_brutto_korekta[$x] = number_format($wartosc_brutto_korekta[$x], 2,'.',' ');
			$wartosc_brutto_po_korekcie[$x] = number_format($wartosc_brutto_po_korekcie[$x], 2,'.',' ');
			echo '<td align="right">';
				echo '<table border="0" width="100%" align="center">';
				echo '<tr class="text"><td align="right">'.$wartosc_brutto[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$wartosc_brutto_korekta[$x].'</td></tr>';
				echo '<tr class="text"><td align="right">'.$wartosc_brutto_po_korekcie[$x].'</td></tr>';
				echo '</table>';
			echo '</td></tr>';
			}
	
		echo '</table>';
		
		echo '<br><table width="50%" align="right" border="1" cellspacing="0" cellpadding="0" class="text" border="1" BORDERCOLOR="black" frame="box" RULES="all">';
		echo '<tr align="center" height="25px"><td colspan="4" bgcolor="white">SUMA WEDŁUG STAWEK VAT</td></tr>';
		echo '<tr align="center" height="25px" bgcolor="'.$kolor_szary.'">';
			echo '<td width="25%">Netto</td>';
			echo '<td width="20%">Stawka VAT</td>';
			echo '<td width="25%">Kwota VAT</td>';
			echo '<td width="30%">Brutto</td>';
		echo '</tr>';
		
		
		$SUMA_NETTO_KOREKTA = $SUMA_NETTO_po_korekcie - $SUMA_NETTO;
		$SUMA_BRUTTO_KOREKTA = $SUMA_BRUTTO_po_korekcie - $SUMA_BRUTTO;
		$KWOTA_VAT_po_korekcie = $SUMA_BRUTTO_po_korekcie - $SUMA_NETTO_po_korekcie;
		$KWOTA_VAT_KOREKTA = $SUMA_BRUTTO_KOREKTA - $SUMA_NETTO_KOREKTA;
		$KWOTA_VAT = $SUMA_BRUTTO - $SUMA_NETTO;
		$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.',' ');
		$SUMA_NETTO_po_korekcie = number_format($SUMA_NETTO_po_korekcie, 2,'.',' ');
		$SUMA_NETTO_KOREKTA = number_format($SUMA_NETTO_KOREKTA, 2,'.',' ');
		$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
		$SUMA_BRUTTO_po_korekcie = number_format($SUMA_BRUTTO_po_korekcie, 2,'.',' ');
		$SUMA_BRUTTO_KOREKTA_pokaz = number_format($SUMA_BRUTTO_KOREKTA, 2,'.',' ');
		$KWOTA_VAT_po_korekcie = number_format($KWOTA_VAT_po_korekcie, 2,'.',' ');
		$KWOTA_VAT_KOREKTA = number_format($KWOTA_VAT_KOREKTA, 2,'.',' ');
		$KWOTA_VAT = number_format($KWOTA_VAT, 2,'.',' ');

		//przed korektą
		echo '<tr align="right" height="25px" bgcolor="white">';
		echo '<td>'.$SUMA_NETTO.'&nbsp;</td>';
		if($stawka_vat[1] != 'NP') $znak_procent = '%'; else $znak_procent = '';
		echo '<td align="center" rowspan="3">'.$stawka_vat[1].$znak_procent.'</td>';
		echo '<td>'.$KWOTA_VAT.'&nbsp;</td>';
		echo '<td>'.$SUMA_BRUTTO.'&nbsp;</td>';
		echo '</tr>';
	
		//korekta
		echo '<tr align="right" height="25px" bgcolor="white">';
		echo '<td>'.$SUMA_NETTO_KOREKTA.'&nbsp;</td>';
		echo '<td>'.$KWOTA_VAT_KOREKTA.'&nbsp;</td>';
		echo '<td>'.$SUMA_BRUTTO_KOREKTA_pokaz.'&nbsp;</td>';
		echo '</tr>';
		
		//po korekcie
		echo '<tr align="right" height="25px" bgcolor="white">';
		echo '<td>'.$SUMA_NETTO_po_korekcie.'&nbsp;</td>';
		echo '<td>'.$KWOTA_VAT_po_korekcie.'&nbsp;</td>';
		echo '<td>'.$SUMA_BRUTTO_po_korekcie.'&nbsp;</td>';
		echo '</tr>';
		
		//RAZEM
		echo '<tr align="right" height="25px">';
		echo '<td bgcolor="white">'.$SUMA_NETTO_KOREKTA.'&nbsp;</td>';
		echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#000000;"></td>';
		echo '<td bgcolor="white">'.$KWOTA_VAT_KOREKTA.'&nbsp;</td>';
		echo '<td bgcolor="white">'.$SUMA_BRUTTO_KOREKTA_pokaz.'&nbsp;</td>';
		echo '</tr>';
		echo '<input type="hidden" name="SUMA_NETTO_KOREKTA" value="'.$SUMA_NETTO_KOREKTA.'">';
		echo '<input type="hidden" name="SUMA_BRUTTO_KOREKTA" value="'.$SUMA_BRUTTO_KOREKTA_pokaz.'">';
		

		echo '</tr>';
		echo '</table>';

		echo '<table width="50%" align="right" border="0" cellspacing="0" cellpadding="0" class="text">';
		echo '<tr align="center" height="25px"><td>&nbsp;</td></tr>';
		echo '<tr align="center" height="25px"><td>&nbsp;</td></tr>';
		echo '<tr align="right" height="25px"><td><i>przed korektą&nbsp;</i></td></tr>';
		echo '<tr align="right" height="25px"><td><i>korekta&nbsp;</i></td></tr>';
		echo '<tr align="right" height="25px"><td><i>po korekcie&nbsp;</i></td></tr>';
		echo '<tr align="right" height="25px"><td>RAZEM:&nbsp;</td></tr>';
		echo '</table>';
	echo '</td></tr>';
	echo '<tr><td colspan="2">';
		echo '<table width="28%" align="right" border="1" BORDERCOLOR="black" frame="box" RULES="all" class="text">';
		//jak SUMA_NETTO_KOREKTA jest > 0 to napis do zapłaty, jak < 0 to do zwrotu.
		if($SUMA_NETTO_KOREKTA < 0)
			{
			$napis_do_zwrotu_zaplaty = 'DO ZWROTU';
			// $do_zwrotu = $SUMA_BRUTTO_KOREKTA * (-1);
			$do_zwrotu = number_format($SUMA_BRUTTO_KOREKTA, 2,'.',' ');
		
			}
		if($SUMA_NETTO_KOREKTA > 0)
			{
			$napis_do_zwrotu_zaplaty = 'DO ZAPŁATY';
			$do_zwrotu = number_format($SUMA_BRUTTO_KOREKTA, 2,'.',' ');
			}


		echo '<tr align="center" height="25px" bgcolor="'.$kolor_szary.'"><td>'.$napis_do_zwrotu_zaplaty.'</td><td>WALUTA</td></tr>';
		echo '<tr align="center" height="25px" bgcolor="'.$kolor_bialy.'"><td>'.$do_zwrotu.'</td><td>PLN</td></tr>';
		echo '</table>';
		
	echo '</td></tr>';



	echo '<input type="hidden" name="pole_jpk" value="K_19">';

/*	
	//################################################ lista typów JPK    ################################################
	echo '<tr align="center" class="text"><td colspan="2" width="100%"><br><br>';
	$ilosc_jpk=0;
	$pytanie6 = mysqli_query($conn, "SELECT * FROM jpk_vat ORDER BY id ASC;");
	while($wynik6= mysqli_fetch_assoc($pytanie6))
		{
		$ilosc_jpk++;
		$jpk_opis[$ilosc_jpk]=$wynik6['opis'];
		$jpk_kolumna[$ilosc_jpk]=$wynik6['kolumna'];
		}

		echo '<div class="text_duzy_niebeiski">Rodzaj sprzedaży</div><br>';
		echo '<select name="pole_jpk" class="pole_input" disabled>';
		for ($k=1; $k<=$ilosc_jpk; $k++) 
		if($jpk_kolumna[$k] == $pole_jpk_faktury) echo '<option value="'.$jpk_kolumna[$k].'" selected="selected">'.$jpk_kolumna[$k].' - '.$jpk_opis[$k].'</option>';
		else echo '<option value="'.$jpk_kolumna[$k].'">'.$jpk_kolumna[$k].' - '.$jpk_opis[$k].'</option>';
		echo '</select><br><br>';
	echo '</td></tr>';	
*/
	
	
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
		if($brak_danych_sprzedawcy == 1) echo '<a href="index.php?page=fv_ustawienia&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id&skad=wystaw_fv"><font color="red" size="+2">Uzupełnij dane sprzedawcy!</a></font>';
		elseif($brak_danych_nabywcy == 1) echo '<a href="index.php?page=klienci_edycja&id='.$klient_id.'&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id&skad=wystaw_fv"><font color="red" size="+2">Uzupełnij dane nabywcy!</a></font>';
		else echo '<input type="submit" name="submit" value="Wystaw korektę faktury nr: '.$nr_fv_wycena[1].'">';
	echo '</td></tr>';
	
	echo '</form>';
	echo '</table>';
	} // do else

?>