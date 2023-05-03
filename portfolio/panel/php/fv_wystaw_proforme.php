<?php
$SUMA_NETTO = 0;
$SUMA_BRUTTO = 0;
$ilosc_pozycji = 0;
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

$SUMA_NETTO = 0;
$SUMA_BRUTTO = 0;
$ilosc_pozycji = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' ORDER BY pozycja ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_pozycji++;
	$klient_id=$wynik['klient_id'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$nazwa_produktu[$ilosc_pozycji]=$wynik['nazwa_produktu'];
	$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
	$pozycja_transport[$ilosc_pozycji]=$wynik['pozycja_transport'];
	
	$wartosc_netto[$ilosc_pozycji]=$wynik['wartosc_netto'];
	$SUMA_NETTO += $wartosc_netto[$ilosc_pozycji];
	$wartosc_brutto[$ilosc_pozycji]=$wynik['wartosc_brutto'];
	$SUMA_BRUTTO += $wartosc_brutto[$ilosc_pozycji];
	
	if($wynik['vat'] == 'NP') 
		{
		$stawka_vat_np[$ilosc_pozycji] = 'NP'; 
		$stawka_vat[$ilosc_pozycji] = 0;
		}
	else 
		{
		$stawka_vat_np[$ilosc_pozycji] = $wynik['vat'];
		$stawka_vat[$ilosc_pozycji] = $wynik['vat'];
		}
	
	$cena_netto_za_sztuke[$ilosc_pozycji]=$wynik['cena_netto_za_sztuke'];
	$nr_fv_wycena[$ilosc_pozycji]=$wynik['nr_faktury'];
	$data_fv_wycena[$ilosc_pozycji]=$wynik['data_faktury'];
	
	if($pozycja_transport[$ilosc_pozycji] == 'tak')
		{
		$nazwa_produktu[$ilosc_pozycji] = 'Transport';
		$ilosc_sztuk[$ilosc_pozycji] = 1;
		$cena_netto_za_sztuke[$ilosc_pozycji] = $wartosc_netto[$ilosc_pozycji];
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
	
$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_proformy';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	$numer_fv=$wynik3['opis'];
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
	$nabywca_ostatnio_uzyte_konto=$wynik22['ostatnio_uzyte_konto'];
	}	


if($submit == 'Wystaw')
	{
	$wystawiamy_fv = 0;
	$faktura_juz_jest = 0;
	if($zmienic_sposob_platnosci == 'on')
		{
		$ins=mysqli_query($conn, "update klienci set sposob_platnosci='".$sposob_platnosci."' WHERE id = ".$klient_id.";");
		$ins=mysqli_query($conn, "update klienci set termin_platnosci_dni='".$termin_platnosci."' WHERE id = ".$klient_id.";");
		echo '<div align="center" class="text_duzy_niebieski">Sposób płatności został zmieniony na "'.$sposob_platnosci.'".</div><br>';
		}
		
	if($nowa_informacja_o_fakturze != '')	
		{
		echo '<div class="text_green" align="center">Dodano nową informację o fakturze.</div>';
		$pytanie = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`)  values ('informacja_o_fakturze', '$nowa_informacja_o_fakturze');");
		$informacja_o_fakturze = $nowa_informacja_o_fakturze;
		}
	
	
	$user_id = $_SESSION["USER_ID"];
	$pytanie33 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$user_imie=$wynik33['imie'];
		$user_nazwisko=$wynik33['nazwisko'];
		}
			
	$numer_faktury = $numer_fv.'/'.$AKTUALNY_ROK;
	//echo 'numer_faktury='.$numer_faktury.'<br>';
	$numer_fv++;
	$ins=mysqli_query($conn, "update rozne set opis=".$numer_fv." WHERE typ = 'nr_proformy';");
	
	//$temp = 86400 * 5;
	//$time = $time - $temp;
	
	$data = date('d-m-Y', $time);
	$data_rok = date('Y', $time);
	$data_miesiac = date('m', $time);
	if($data_miesiac != 10) $data_miesiac = zamien_dowolne_znaki($data_miesiac, '0', '');


	// obliczamy termin płatności
	$do_kiedy_termin_platnosci = $time + ($termin_platnosci * 86400); // 86400 to 1 dzień
	
	$kopia_nr = change_link($numer_faktury);
	$link_fv = 'faktura_proforma_'.$kopia_nr.'.pdf';		
	
	
	$ins = mysqli_query($conn, "update klienci set ostatnio_uzyte_konto = '".$wybrane_konto."' WHERE id = ".$klient_id.";");

	//if(($kurs_euro != '') && ($kurs_euro != 0)) $waluta_na_fv = 'EUR'; else 
	$waluta_na_fv = 'PLN';
	$query = mysqli_query($conn, "INSERT INTO fv_naglowek (`nr_dok`, `typ_dok`, `waluta`, `pole_jpk`, `zamowienie_id`, `nabywca_id`, `nabywca_nazwa_skrocona`, `data_wystawienia`, `wartosc_netto_fv`, `vat`, `wartosc_brutto_fv`, `wplacono`, `zaplacona`, `link_folder`, `nazwa_pliku`, `data_wygenerowania_dokumentu`, `nabywca_nazwa`, `nabywca_ulica`, `nabywca_miasto`, `nabywca_kod_pocztowy`, `nabywca_nip`, `nabywca_sposob_platnosci`, `termin_platnosci`, `termin_platnosci_dni`, `data_wystawienia_time`, `data_wystawienia_miesiac`, `data_wystawienia_rok`, `data_zakonczenia_dostawy`, `user_id`, `user_imie`, `user_nazwisko`,`informacja_o_fakturze`, `konto`)
								values ('$numer_faktury', 'Proforma', '$waluta_na_fv', '', '$zamowienie_id', '$klient_id', '$nabywca_nazwa_skrocona', '$data', '0', '$stawka_vat_np[1]', '0', '0', 'nie', 'faktury_proformy', '$link_fv', '$data', '$nabywca_nazwa', '$nabywca_ulica', '$nabywca_miasto', '$nabywca_kod_pocztowy', '$nabywca_nip', '$sposob_platnosci', '$do_kiedy_termin_platnosci', '$termin_platnosci', '$time', '$data_miesiac', '$data_rok', '$data', '$user_id', '$user_imie', '$user_nazwisko', '$informacja_o_fakturze', '$wybrane_konto');");

	$fv_id = mysqli_insert_id($conn);

	$SUMA_NETTO = 0;
	$SUMA_BRUTTO = 0;
	for($x = 1; $x<=$ilosc_pozycji; $x++) 
	if($pozycja[$x] == 'on')
		{
		$SUMA_NETTO += $wartosc_netto[$x];
		$SUMA_BRUTTO += $wartosc_brutto[$x];
	
		$cena_brutto_za_sztuke[$x] = $cena_netto_za_sztuke[$x] + ($cena_netto_za_sztuke[$x] * $stawka_vat[$x]/100);
		$cena_netto_za_sztuke[$x] = change($cena_netto_za_sztuke[$x]);
		$cena_brutto_za_sztuke[$x] = change($cena_brutto_za_sztuke[$x]);
		$wartosc_netto[$x] = change($wartosc_netto[$x]);
		$wartosc_brutto[$x] = change($wartosc_brutto[$x]);
		
		
		$query = mysqli_query($conn, "INSERT INTO fv_pozycje (`fv_id`, `nr_fv`, `zamowienie_id`, `nabywca_id`, `pozycja`, `nazwa_produktu`, `jednostka`, `ilosc`, `cena_netto`, `vat`, `cena_brutto`, `wartosc_netto`, `wartosc_brutto`) values ('$fv_id', '$numer_faktury', '$zamowienie_id', '$klient_id', '$x', '$nazwa_produktu[$x]', '$jednostka[$x]', '$ilosc_sztuk[$x]', '$cena_netto_za_sztuke[$x]', '$stawka_vat_np[$x]', '$cena_brutto_za_sztuke[$x]', '$wartosc_netto[$x]', '$wartosc_brutto[$x]');");

		$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.','');
		$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
		$ins=mysqli_query($conn, "update fv_naglowek set wartosc_netto_fv = ".$SUMA_NETTO." WHERE id = ".$fv_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set vat = '".$stawka_vat_np[$x]."' WHERE id = ".$fv_id.";");
		$ins=mysqli_query($conn, "update fv_naglowek set wartosc_brutto_fv = ".$SUMA_BRUTTO." WHERE id = ".$fv_id.";");
		} // do if($pozycja[$x] == 'on')
		
		echo '<div align="center" class="text_duzy_niebieski">Faktura proforma '.$numer_faktury.' dla zamówienia '.$nr_zamowienia.' została wystawiona.</div><br>';
		include('php/generuj_fakture_proforme.php');
		echo '<center><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_proformy/'.$link_fv.'" target="_blank">'.$image_pdf_icon2.'</a></center>';
		
		if($skad == 'zlecenie_transportowe') echo $powrot_do_konkretnego_zlecenia_transportowego_edycja;
		else echo $powrot_do_zamowienia;

	} 
else
	{

	if(($nabywca_ulica == '') || ($nabywca_miasto == '') || ($nabywca_kod_pocztowy == '') || ($nabywca_nip == '') || ($nabywca_forma_platnosci == '') || ($nabywca_nazwa == '')) $brak_danych_nabywcy = 1; else $brak_danych_nabywcy = 0;
	if(($sprzedawca_nazwa == '') || ($sprzedawca_ulica == '') || ($sprzedawca_miasto == '') || ($sprzedawca_kod_pocztowy == '') || ($sprzedawca_nip == '') || ($sprzedawca_miejsce_wystawienia == '') || ($sprzedawca_konto == '') || ($sprzedawca_email == '')) $brak_danych_sprzedawcy = 1; else $brak_danych_sprzedawcy = 0;

	echo '<FORM action="index.php?page=fv_wystaw_proforme&zamowienie_id='.$zamowienie_id.'" method="post">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	//echo '<input type="hidden" name="kurs_euro" value="'.$kurs_euro.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	echo '<input type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
	echo '<input type="hidden" name="rodzaj_dokumentu" value="'.$rodzaj_dokumentu.'">';


	//if(($kurs_euro != '') && ($kurs_euro != 0)) $napis_euro = '<font color="red"> EURO </font>'; else $napis_euro = ' ';

	echo '<div align="center" class="text_ogromny">Wystaw fakturę proformę do zamówienia : <font color="blue">'.$nr_zamowienia.'</font></div><br>';
	
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
	
	$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_proformy';");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$numer_fv=$wynik3['opis'];
		}	
	echo '<tr class="text_duzy"><td width="50%" align="left">FAKTURA PROFORMA</td><td width="50%" align="right">Nr: '.$numer_fv.'/'.$AKTUALNY_ROK.'</td></tr>';
			
	echo '<tr width="100%"><td colspan="2"><hr></td></tr>';
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
		echo '<tr class="text" align="left"><td width="40%">Miejsce wystawienia:</td><td colspan="2">'.$sprzedawca_miejsce_wystawienia.'</td></tr>';
		echo '<tr class="text" align="left"><td>Termin płatności:</td><td colspan="2">';
		
		echo '<select name="termin_platnosci" class="pole_input" style="width: 60px">';
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
			echo '<tr class="text" align="left"><td>Forma płatności:</td><td>';
			// sposób płatności
			$ilosc_sposob_platnosci = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_platnosci' ORDER BY opis ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$ilosc_sposob_platnosci++;
				$sposob_platnosci_id[$ilosc_sposob_platnosci] = $wynik3['id'];
				$sposob_platnosci_opis[$ilosc_sposob_platnosci] = $wynik3['opis'];
				}
			echo '<select name="sposob_platnosci" class="pole_input" style="width: 180px">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_sposob_platnosci; $k++) 
			if($nabywca_forma_platnosci == $sposob_platnosci_opis[$k]) echo '<option selected="selected" value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			else echo '<option value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			echo '</select>';
			echo '</td>';
			echo '<td width="50%" valign="middle"><input name="zmienic_sposob_platnosci" type="checkbox">zmienić na stałe?</td></tr>';
			}
		echo '</table>';
	echo '</td>';
	echo '<td width="50%" valign="bottom">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
		$data = date('d-m-Y', $time);
		echo '<tr class="text" align="right"><td width="80%">Data wystawienia:</td><td width="20%">'.$data.'</td></tr>';
		echo '<tr class="text" align="right"><td>Data zakończenia dostawy/usług:</td><td>'.$data.'</td></tr>';
		echo '</table>';
	echo '</td></tr>';
		
	
	echo '<tr><td colspan="2">&nbsp;&nbsp;Informacja o fakturze:&nbsp;&nbsp;';
	$ilosc_informacja_o_fakturze = 0;
	$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='informacja_o_fakturze' ORDER BY opis ASC;");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$ilosc_informacja_o_fakturze++;
		$informacja_o_fakturze_id[$ilosc_informacja_o_fakturze] = $wynik3['id'];
		$informacja_o_fakturze_opis[$ilosc_informacja_o_fakturze] = $wynik3['opis'];
		}
	echo '<select name="informacja_o_fakturze" class="pole_input" style="width: 650px">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_informacja_o_fakturze; $k++) 
	if($informacja_o_fakturze == $informacja_o_fakturze_opis[$k]) echo '<option selected="selected" value="'.$informacja_o_fakturze_opis[$k].'">'.$informacja_o_fakturze_opis[$k].'</option>';
	else echo '<option value="'.$informacja_o_fakturze_opis[$k].'">'.$informacja_o_fakturze_opis[$k].'</option>';
	echo '</select>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;LUB&nbsp;&nbsp;&nbsp;&nbsp;<input autocomplete="off" type="text" size="40" maxlength="150" title="Informacja o fakturze" alt="Informacja o fakturze" class="pole_input" name="nowa_informacja_o_fakturze" value="'.$nowa_informacja_o_fakturze.'"><br><br></td></tr>';


	// wykaz pozycji
	echo '<td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="1" BORDERCOLOR="black" frame="box" RULES="all" cellpadding="2" cellspacing="2">';
		echo '<tr class="text" align="center" bgcolor="'.$kolor_szary.'">';
		echo '<td width="10px">Lp.</td>';
		echo '<td>Towar / Usługa</td>';
		echo '<td width="50px">Jednostka</td>';
		echo '<td width="50px">Ilośść</td>';
		echo '<td width="90px">Cena<br>netto</td>';
		echo '<td width="50px">VAT</td>';
		echo '<td width="90px">Cena<br>brutto</td>';
		echo '<td width="90px">Wartość<br>netto</td>';
		echo '<td width="90px">Wartość<br>brutto</td>';
		echo '<td width="80px" valign="middle">Pozycje';
		if($ilosc_pozycji >=2) 
			{
			$id_test = 'id_'.$zamowienie_id;
			echo '<input type="checkbox" id="'.$id_test.'" name="nazwa_wszystkie_pozycje" checked onClick="zaznacz_pozycje('.$zamowienie_id.')">';
			}
		echo '</td></tr>';
			
		echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id.'" value="'.$ilosc_pozycji.'">';
		
		$czy_mozna_wystawiac_fv = 0;
		for($x = 1; $x<=$ilosc_pozycji; $x++)
			{
			echo '<tr class="text" align="center" bgcolor="white"><td width="10px">'.$x.'</td>';
			echo '<td align="left">'.$nazwa_produktu[$x].'</td>';
			echo '<td>';
				$nazwa_jednostka = 'jednostka['.$x.']';
				echo '<select name="'.$nazwa_jednostka.'" class="pole_input_biale">';
				for($k = 1; $k <= $DL_TABELA_LISTA_JEDNOSTEK; $k++)
				if($jednostka == $TABELA_LISTA_JEDNOSTEK[$k]) echo '<option selected="selected" value="'.$TABELA_LISTA_JEDNOSTEK[$k].'">'.$TABELA_LISTA_JEDNOSTEK[$k].'</option>';
				else echo '<option value="'.$TABELA_LISTA_JEDNOSTEK[$k].'">'.$TABELA_LISTA_JEDNOSTEK[$k].'</option>';
				echo '</select>';
			echo '</td>';
			$ilosc_sztuk[$x] = number_format($ilosc_sztuk[$x], 2,'.','');
			echo '<td align="right">'.$ilosc_sztuk[$x].'</td>';
			//if(($kurs_euro != '') && ($kurs_euro != 0)) $cena_netto_za_sztuke[$x] = $cena_netto_za_sztuke[$x]/$kurs_euro;		
			$cena_netto_za_sztuke[$x] = number_format($cena_netto_za_sztuke[$x], 2,'.','');
			echo '<td align="right">'.$cena_netto_za_sztuke[$x].'</td>';
			
			if($stawka_vat_np[$x] == 'NP')
				{
				echo '<td>'.$stawka_vat_np[$x].'</td>';
				}
			else
				{
				echo '<td>'.$stawka_vat[$x].'%</td>';
				} 
			
			$cena_brutto_za_sztuke[$x] = $cena_netto_za_sztuke[$x] + ($cena_netto_za_sztuke[$x] * $stawka_vat[$x]/100);
			$cena_brutto_za_sztuke[$x] = number_format($cena_brutto_za_sztuke[$x], 2,'.','');
			echo '<td align="right">'.$cena_brutto_za_sztuke[$x].'</td>';
			$waluta_na_fv = ' PLN';

			//sprawdzamy czy ktoras z wartosci pozycji wyceny nie jest rowna 0 - wtedy uniemozliwiamy wystawienie fv
			if(($wartosc_netto[$x] == 0) || ($wartosc_brutto[$x]  == 0) || ($wartosc_netto[$x] == '') || ($wartosc_brutto[$x]  == '')) $czy_mozna_wystawiac_fv++;
			
			if(($wartosc_netto[$x] == 0) || ($wartosc_netto[$x]  == '')) $zerowa_wartosc_netto[$x] = ' bgcolor="red" '; else $zerowa_wartosc_netto[$x] = '';
			if(($wartosc_brutto[$x] == 0) || ($wartosc_brutto[$x]  == '')) $zerowa_wartosc_brutto[$x] = ' bgcolor="red" '; else $zerowa_wartosc_brutto[$x] = '';

			$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
			$wartosc_brutto[$x] = number_format($wartosc_brutto[$x], 2,'.',' ');
			echo '<td align="right" '.$zerowa_wartosc_netto[$x].'>'.$wartosc_netto[$x].'</td>';
			echo '<td align="right" '.$zerowa_wartosc_brutto[$x].'>'.$wartosc_brutto[$x].'</td>';

			$nazwa_pozycja = 'pozycja['.$x.']';
			if($nr_fv_wycena[$x] != '') 
				{
				$disabled = ' disabled="disabled" '; 
				$checked = ' ';
				$title = 'Nr faktury: '.$nr_fv_wycena[$x];
				}
				else 
				{
				$disabled = '';
				$checked = ' checked ';
				$title = '';
				}
			if($nr_fv_wycena[$x] == '') echo '<td><input name="'.$nazwa_pozycja.'" type="checkbox" '.$checked.' '.$disabled.' ></td></tr>';
			else echo '<td title="'.$title.'"><input type="checkbox" disabled="disabled"></td></tr>';
			}
		//$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
		echo '<tr class="text" align="center" bgcolor="white"><td colspan="6" align="left">Razem słownie: ';
		
		//if(($kurs_euro != '') && ($kurs_euro != 0)) $slownie_kwota = kwotaslownieeuro($SUMA_BRUTTO); else 
		$slownie_kwota = kwotaslownie($SUMA_BRUTTO);
		
		echo $slownie_kwota;
		echo '</td>';
		echo '<td align="right">Razem w '.$waluta_na_fv.': </td>';
		/*
		if(($kurs_euro != '') && ($kurs_euro != 0))
			{
			$SUMA_NETTO = $SUMA_NETTO/$kurs_euro;
			$SUMA_BRUTTO = $SUMA_BRUTTO/$kurs_euro;
			}
		*/
		$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.',' ');
		$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
		
		echo '<td align="right" bgcolor="'.$kolor_szary.'">'.$SUMA_NETTO.'</td>';
		echo '<td align="right" bgcolor="'.$kolor_szary.'">'.$SUMA_BRUTTO.'</td>';
		echo '<td align="right"></td>';
		echo '</table>';
	echo '</td></tr>';
	
	// wybór konta
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
		echo 'Wybierz konto : ';
		echo '<select name="wybrane_konto" class="pole_input" style="width: 600px">';
		if($nabywca_ostatnio_uzyte_konto == $sprzedawca_konto) echo '<option value="'.$sprzedawca_konto.'" selected="selected">'.$sprzedawca_konto.'</option>';
		else echo '<option value="'.$sprzedawca_konto.'">'.$sprzedawca_konto.'</option>';
		
		if($nabywca_ostatnio_uzyte_konto == $sprzedawca_konto_euro) echo '<option value="'.$sprzedawca_konto_euro.'" selected="selected">'.$sprzedawca_konto_euro.'</option>';
		else echo '<option value="'.$sprzedawca_konto_euro.'">'.$sprzedawca_konto_euro.'</option>';
		echo '</select>';
	echo '</td></tr>';

	
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
		if($brak_danych_sprzedawcy == 1) echo '<a href="index.php?page=fv_ustawienia&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id&skad=wystaw_fv"><font color="red" size="+2">Uzupełnij dane sprzedawcy!</a></font>';
		elseif($brak_danych_nabywcy == 1) echo '<a href="index.php?page=klienci_edycja&id='.$klient_id.'&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id&skad=wystaw_fv"><font color="red" size="+2">Uzupełnij dane nabywcy!</a></font>';
		elseif($czy_mozna_wystawiac_fv != 0) echo '<a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id"><font color="red" size="+2">Uzupełnij wartość wszystkich pozycji!</a></font>';
		else echo '<input type="submit" name="submit" value="Wystaw">';
	echo '</td></tr>';
	
	echo '</form>';
	echo '</table>';
	
	echo '<br><div align="center"><a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do edycji wyceny</a></div>';
	} // do else

?>