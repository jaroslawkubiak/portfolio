<?php
$user_id = $_SESSION["USER_ID"];

if($submit == 'Dodaj')
	{
	$wartosc_wplaty = change($wartosc_wplaty);
	// echo 'wartosc_wplaty='.$wartosc_wplaty.'<br>';
	$pytanie252 = mysqli_query($conn, "SELECT zamowienie_id, typ_dok, nabywca_id, wplacono, wartosc_brutto_fv, nr_fv_korygowanej FROM fv_naglowek WHERE id = ".$id_fv_do_wplaty.";");
	while($wynik252= mysqli_fetch_assoc($pytanie252))
		{
		$typ_dok2=$wynik252['typ_dok'];
		$nabywca_id_2=$wynik252['nabywca_id'];
		$zamowienie_id_2=$wynik252['zamowienie_id'];
		$wplacono_2=$wynik252['wplacono'];
		$wartosc_brutto_fv_2=$wynik252['wartosc_brutto_fv'];
		$nr_fv_korygowanej=$wynik252['nr_fv_korygowanej'];
		}

	
	$pytanie33 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$user_imie=$wynik33['imie'];
		$user_nazwisko=$wynik33['nazwisko'];
		}

	$data_wplaty = date('d-m-Y', $time);
	
	$wartosc_wplaty = number_format($wartosc_wplaty, 2,'.','');
	$query = mysqli_query($conn, "INSERT INTO fv_wplaty (`fv_id`, `nr_fv`, `zamowienie_id`, `nabywca_id`, `data_wplaty`, `data_wplaty_time`,`wartosc_wplaty`, `user_id`, `user_imie`, `user_nazwisko`) values ('$id_fv_do_wplaty', '$nr_fv_do_wplaty', '$zamowienie_id_2', '$nabywca_id_2', '$data_wplaty', '$time', '$wartosc_wplaty', '$user_id', '$user_imie', '$user_nazwisko');");
	
	$wplacono_2 += $wartosc_wplaty;
	// echo '$do_zaplaty_2='.$do_zaplaty_2;
	
	
	$wplacono_2 = number_format($wplacono_2, 2,'.','');
	$wartosc_brutto_fv_2 = number_format($wartosc_brutto_fv_2, 2,'.','');
	$ins1=mysqli_query($conn, "update fv_naglowek set wplacono = ".$wplacono_2." WHERE id = ".$id_fv_do_wplaty.";");
	if($wplacono_2 == $wartosc_brutto_fv_2) $ins1=mysqli_query($conn, "update fv_naglowek set zaplacona = 'tak' WHERE id = ".$id_fv_do_wplaty.";");
	

	// ponowne sprawdzenie czy fv jest zaplacona
	$pytanie252 = mysqli_query($conn, "SELECT wplacono, wartosc_brutto_fv FROM fv_naglowek WHERE id = ".$id_fv_do_wplaty.";");
	while($wynik252= mysqli_fetch_assoc($pytanie252))
		{
		$wplacono_3=$wynik252['wplacono'];
		$wartosc_brutto_fv_3=$wynik252['wartosc_brutto_fv'];
		}
	if($wplacono_3 == $wartosc_brutto_fv_3) $ins1=mysqli_query($conn, "update fv_naglowek set zaplacona = 'tak' WHERE id = ".$id_fv_do_wplaty.";");
	
	
	$pusta = '';
	$fv_id = $id_fv_do_wplaty;

	//sprawdzenie czy korekta jest poprawnie zaplacona - czy wplacono roznice miedzy korekta a fv
	if($typ_dok2 == 'Korekta')
	{
		$pytanie2112 = mysqli_query($conn, "SELECT wartosc_brutto_fv FROM fv_naglowek WHERE nr_dok = '".$nr_fv_korygowanej."' AND typ_dok = 'Faktura';");
		while($wynik2112= mysqli_fetch_assoc($pytanie2112))
			{
			$wartosc_brutto_korygowanej_fv=$wynik2112['wartosc_brutto_fv'];
			$zest_wartosc_brutto_fv = $wartosc_brutto_fv_2 - $wartosc_brutto_korygowanej_fv;
			}

			
		$zest_wartosc_brutto_fv = number_format($zest_wartosc_brutto_fv, 2,'.','');
		$wplacono_3 = number_format($wplacono_3, 2,'.','');
		if($wplacono_3 == $zest_wartosc_brutto_fv) $ins1=mysqli_query($conn, "update fv_naglowek set zaplacona = 'tak' WHERE id = ".$id_fv_do_wplaty.";");
			
		//generuje nowy plik pdf
		include('php/generuj_fakture_korekte.php');
	}

	if($typ_dok2 == 'Faktura') include('php/generuj_fakture.php');
	
	echo '<meta http-equiv="refresh" content="0.1; URL=index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak='.$jak.'&drukuj_fv='.$id_fv_do_wplaty.'&nr_fv_do_wplaty='.$nr_fv_do_wplaty.'&data_poczatkowa='.$data_poczatkowa.'&rodzaj_dokumentu='.$rodzaj_dokumentu.'&data_koncowa='.$data_koncowa.'&szukany_miesiac='.$szukany_miesiac.'&sprawdzany_rok='.$sprawdzany_rok.'&termin_wystawienia='.$termin_wystawienia.'&wg_czego='.$wg_czego.'&submit='.$pusta.'&radio_zaplacone='.$radio_zaplacone.'&rozliczenie='.$rozliczenie.'">';
	}


$SUMA_NETTO = 0;
$SUMA_BRUTTO = 0;
$SUMA_DO_ZAPLATY = 0;
$ilosc_fv = 0;
$faktura_id = [];
$zest_nr_fv = [];
$zest_typ_dok = [];
$zest_waluta = [];
$link_folder2 = [];
$zest_zamowienie_id = [];
$zest_czy_fv_ma_korekte = [];
$zest_nr_zamowienia = [];
$zest_nabywca_nazwa = [];
$zest_nabywca_id = [];
$zest_numer_faktury = [];
$zest_data_wystawienia = [];
$zest_wartosc_netto_fv = [];
$zest_wartosc_brutto_fv = [];
$zest_wartosc_netto_korekta = [];
$zest_wartosc_brutto_korekta = [];
$termin_platnosci = [];
$wyslana_przez_email = [];
$wyslana_przez_email_data = [];
$wyslana_przez_email_user_id = [];
$wyslana_przez_email_user_imie = [];
$wyslana_przez_email_user_nazwisko = [];
$wplacono = [];
$do_zaplaty = [];
$zaplacona = [];

// echo 'WARUNEK='.$WARUNEK.'<br>';
$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek ".$WARUNEK." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$ilosc_fv++;
	$faktura_id[$ilosc_fv]=$wynik22['id'];
	$zest_nr_fv[$ilosc_fv]=$wynik22['nr_dok'];
	$zest_typ_dok[$ilosc_fv]=$wynik22['typ_dok'];
	$zest_waluta[$ilosc_fv]=$wynik22['waluta'];
	$link_folder2[$ilosc_fv]=$wynik22['link_folder'];
	$zest_zamowienie_id[$ilosc_fv]=$wynik22['zamowienie_id'];
	$zest_czy_fv_ma_korekte[$ilosc_fv]=$wynik22['tytul_korekty'];
	
	// jezeli fv ma wystawiona korekte to dodajemy do nr literke K
	if(($zest_czy_fv_ma_korekte[$ilosc_fv] != '') && ($zest_typ_dok[$ilosc_fv] == 'Faktura')) $zest_nr_fv[$ilosc_fv] .= '/K';
	
	$pytanie225 = mysqli_query($conn, "SELECT nr_zamowienia FROM zamowienia WHERE id=".$zest_zamowienie_id[$ilosc_fv].";");
	while($wynik225= mysqli_fetch_assoc($pytanie225))
		$zest_nr_zamowienia[$ilosc_fv]=$wynik225['nr_zamowienia'];
	
	//szukam danych klienta
	$zest_nabywca_id[$ilosc_fv]=$wynik22['nabywca_id'];
	$pytanie72 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$zest_nabywca_id[$ilosc_fv].";");
	while($wynik72= mysqli_fetch_assoc($pytanie72))
		$zest_nabywca_nazwa[$ilosc_fv]=$wynik72['nazwa'];

	$zest_numer_faktury[$faktura_id[$ilosc_fv]] = $zest_nr_fv[$ilosc_fv];
	$zest_data_wystawienia[$ilosc_fv]=$wynik22['data_wystawienia'];
	$zest_wartosc_netto_fv[$ilosc_fv]=$wynik22['wartosc_netto_fv'];
	$zest_wartosc_brutto_fv[$ilosc_fv]=$wynik22['wartosc_brutto_fv'];

	//jezeli to korekta, to liczymy roznice względem fakruty którą koryguje i dodajemy tą wartość do sumy netto i brutto
	if($zest_typ_dok[$ilosc_fv] == 'Korekta')
	{
		$nr_fv_korygowanej[$ilosc_fv]=$wynik22['nr_fv_korygowanej'];
		$pytanie2112 = mysqli_query($conn, "SELECT wartosc_netto_fv, wartosc_brutto_fv FROM fv_naglowek WHERE nr_dok = '".$nr_fv_korygowanej[$ilosc_fv]."' AND typ_dok = 'Faktura' AND tytul_korekty = '".$faktura_id[$ilosc_fv]."' ;");
		while($wynik2112= mysqli_fetch_assoc($pytanie2112))
			{
			$wartosc_netto_korygowanej_fv[$ilosc_fv]=$wynik2112['wartosc_netto_fv'];
			$wartosc_brutto_korygowanej_fv[$ilosc_fv]=$wynik2112['wartosc_brutto_fv'];
			$zest_wartosc_netto_fv[$ilosc_fv] -= $wartosc_netto_korygowanej_fv[$ilosc_fv];
			$zest_wartosc_brutto_fv[$ilosc_fv] -= $wartosc_brutto_korygowanej_fv[$ilosc_fv];
			}
		}

	$termin_platnosci[$ilosc_fv]=$wynik22['termin_platnosci'];
	$wplacono[$ilosc_fv]=$wynik22['wplacono'];
	$do_zaplaty[$ilosc_fv] = $zest_wartosc_brutto_fv[$ilosc_fv] - $wplacono[$ilosc_fv];
	if(($zest_typ_dok[$ilosc_fv] == 'Faktura') || ($zest_typ_dok[$ilosc_fv] == 'Korekta'))
		{
		$SUMA_NETTO += $zest_wartosc_netto_fv[$ilosc_fv];
		$SUMA_BRUTTO += $zest_wartosc_brutto_fv[$ilosc_fv];
		$SUMA_DO_ZAPLATY += $do_zaplaty[$ilosc_fv];
		}
	$zaplacona[$ilosc_fv]=$wynik22['zaplacona'];
	
	$wyslana_przez_email[$ilosc_fv]=$wynik22['wyslana_przez_email'];
	$wyslana_przez_email_data[$ilosc_fv]=$wynik22['wyslana_przez_email_data'];
	$wyslana_przez_email_user_id[$ilosc_fv]=$wynik22['wyslana_przez_email_user_id'];
	
	if($wyslana_przez_email_user_id[$ilosc_fv]) 
		{
		$pytanie2 = mysqli_query($conn, "SELECT imie, nazwisko FROM uzytkownicy WHERE id = ".$wyslana_przez_email_user_id[$ilosc_fv].";");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$wyslana_przez_email_user_imie[$ilosc_fv]=$wynik2['imie'];
			$wyslana_przez_email_user_nazwisko[$ilosc_fv]=$wynik2['nazwisko'];
			}
		}
	}

	if($nr_fv_do_wplaty != '') 
		{
		//szukamy danych dokumentu: folder i typ dok
		$pytanie222 = mysqli_query($conn, "SELECT link_folder, typ_dok FROM fv_naglowek WHERE nr_dok ='".$nr_fv_do_wplaty."';");
		while($wynik222= mysqli_fetch_assoc($pytanie222))
			{
			$typ_dok=$wynik222['typ_dok'];
			$link_folder=$wynik222['link_folder'];
			}

		$nr_fv_do_wplaty_temp = change_link($nr_fv_do_wplaty); // zamieniam / na _
		$nazwa_pliku_temp = 'faktura_'.$nr_fv_do_wplaty_temp.'.pdf';
		if($typ_dok == 'Faktura')
			{
			$napis_typ_dok = 'faktury';
			$napis_typ_dok2 = 'fakturę';
			}
		if($typ_dok == 'Korekta')
			{
			$napis_typ_dok = 'korekty';
			$napis_typ_dok2 = 'korektę';
			}
		
		echo '<table border="0" width="100%" class="text" align="center"><tr valign="middle">';
		echo '<td class="text_duzy_niebieski" align="center">Wpłata do '.$napis_typ_dok.' '.$nr_fv_do_wplaty.' została dodana.</td></tr>';
		echo '<tr align="center" valign="middle" height="50px"><td class="text_duzy_niebieski" width="100%">Wydrukuj nowo wygenerowaną '.$napis_typ_dok2.' '.$nr_fv_do_wplaty.'&nbsp;';
		echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$link_faktura.'" target="_blank">'.$image_pdf_icon2.'</a></td>';
		echo '</tr></table>';
		}

echo '<FORM action="index.php?page=fv_fakturowanie&jak='.$jak.'&wg_czego='.$wg_czego.'" method="post">';
echo '<input type="hidden" name="id_fv_do_wplaty" value="'.$wplata.'">';

if(isset($zest_numer_faktury[$wplata])) echo '<input type="hidden" name="nr_fv_do_wplaty" value="'.$zest_numer_faktury[$wplata].'">';

echo '<input type="hidden" name="data_koncowa" value="'.$data_koncowa.'">';
echo '<input type="hidden" name="data_poczatkowa" value="'.$data_poczatkowa.'">';
echo '<input type="hidden" name="sprawdzany_rok" value="'.$sprawdzany_rok.'">';
echo '<input type="hidden" name="termin_wystawienia" value="'.$termin_wystawienia.'">';
echo '<input type="hidden" name="radio_zaplacone" value="'.$radio_zaplacone.'">';
echo '<input type="hidden" name="rozliczenie" value="'.$rozliczenie.'">';
echo '<input type="hidden" name="terminowosc" value="'.$terminowosc.'">';
echo '<input type="hidden" name="radio_terminowosc" value="'.$radio_terminowosc.'">';
echo '<input type="hidden" name="klient" value="'.$klient.'">';
echo '<input type="hidden" name="klient_nazwa" value="'.$klient_nazwa.'">';
echo '<input type="hidden" name="rodzaj_dokumentu" value="'.$rodzaj_dokumentu.'">';

echo '<table border="0" class="text" BORDERCOLOR="black" frame="box" RULES="all" width="100%" align="center"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center" valign="bottom">';
echo '<td width="20px">'.$ilosc_fv.'</td>';
echo '<td width="10%">Numer<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=id">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=id">'.$image_arrow_up.'</a></div></td>';
if($user_id === 1) echo '<td align="center" valign="middle">Zamówienie</td>';
echo '<td width="20%">Klient<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=nabywca_nazwa">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=nabywca_nazwa">'.$image_arrow_up.'</a></div></td>';
echo '<td width="10%">Data wystawienia<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=data_wystawienia_time">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=data_wystawienia_time">'.$image_arrow_up.'</a></div></td>';
echo '<td width="10%">Termin płatności<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=termin_platnosci">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=termin_platnosci">'.$image_arrow_up.'</a></div></td>';
echo '<td width="12%">Netto<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=wartosc_netto_fv">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=wartosc_netto_fv">'.$image_arrow_up.'</a></div></td>';
echo '<td width="12%">Brutto<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=wartosc_brutto_fv">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=wartosc_brutto_fv">'.$image_arrow_up.'</a></div></td>';
echo '<td width="10%">Do zapłaty<div align="right"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=do_zaplaty">'.$image_arrow_down.'</a><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=do_zaplaty">'.$image_arrow_up.'</a></div></td>';
echo '<td width="7%" valign="middle">Zapłacona</td>';
echo '<td width="7%" valign="middle">Wysłana przez e-mail</td></tr>';

	//echo '<input type="text" id="drukuj_fv" value="'.$drukuj_fv.'">';
for($x=1; $x<=$ilosc_fv; $x++)
	{
	$nazwa_do_zaplaty = 'nazwa_do_zaplaty['.$faktura_id[$x].']';
	echo '<input type="hidden" id="'.$nazwa_do_zaplaty.'" value="'.$do_zaplaty[$x].'">';
	//$nazwa_drukuj = 'nazwa_drukuj['.$faktura_id[$x].']';
	echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'" height="30px">';
	if($drukuj_fv == $faktura_id[$x]) $checked_drukuj_fv = ' checked="checked" '; else $checked_drukuj_fv = ' ';
	echo '<td bgcolor="'.$kolor_typ_dok[$zest_typ_dok[$x]].'"><input type="radio" name="drukuj_fv" '.$checked_drukuj_fv.' value="'.$faktura_id[$x].'" onchange="submit();"></td>';
	
	
	if($user_stanowisko != 'księgowość') 
		{
		if($zest_typ_dok[$x] != 'Faktura') echo '<td bgcolor="'.$kolor_typ_dok[$zest_typ_dok[$x]].'"><a href="index.php?page=wycena_edycja&zamowienie_id='.$zest_zamowienie_id[$x].'&skad=fakturowanie&jak='.$jak.'&wg_czego='.$wg_czego.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'"><font color="black">'.$zest_nr_fv[$x].'</font></a></td>';
		else echo '<td><a href="index.php?page=wycena_edycja&zamowienie_id='.$zest_zamowienie_id[$x].'&skad=fakturowanie&jak='.$jak.'&wg_czego='.$wg_czego.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'"><font color="black">'.$zest_nr_fv[$x].'</font></a></td>';
		}
	else echo '<td bgcolor="'.$kolor_typ_dok[$zest_typ_dok[$x]].'">'.$zest_nr_fv[$x].'</td>';
	
	if($user_id === 1) echo '<td align="center"><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zest_zamowienie_id[$x].'">'.$zest_nr_zamowienia[$x].'</a></td>';
	
	
	if($user_id === 1) echo '<td align="left"><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_dane_do_faktury&id='.$zest_nabywca_id[$x].'">'.$zest_nabywca_nazwa[$x].'</a></td>'; 
	else echo '<td align="left">'.$zest_nabywca_nazwa[$x].'</td>';
	
	
	echo '<td>'.$zest_data_wystawienia[$x].'</td>';
	$termin = date('d-m-Y', $termin_platnosci[$x]);
	echo '<td>'.$termin.'</td>';
	$zest_wartosc_netto_fv[$x] = number_format($zest_wartosc_netto_fv[$x], 2,'.',' ');
	$zest_wartosc_brutto_fv[$x] = number_format($zest_wartosc_brutto_fv[$x], 2,'.',' ');
	
	$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET do_zaplaty = ".$do_zaplaty[$x]." WHERE id = ".$faktura_id[$x].";");
	
	//dodaję znaczek waluty euro do kwoty
	if($zest_waluta[$x] == 'EURO') $waluta_dla_zestawienia = '&#8364;'; else $waluta_dla_zestawienia = '';
	
	$do_zaplaty[$x] = number_format($do_zaplaty[$x], 2,'.',' ');
	if($zest_typ_dok[$x] == 'Faktura') 
		{
		echo '<td align="right">'.$zest_wartosc_netto_fv[$x].'</td>';
		echo '<td align="right">'.$zest_wartosc_brutto_fv[$x].'</td>';
		}
	elseif($zest_typ_dok[$x] == 'Korekta')
		{
		echo '<td align="right" bgcolor="'.$kolor_typ_dok[$zest_typ_dok[$x]].'">'.$zest_wartosc_netto_fv[$x].'</td>';
		echo '<td align="right" bgcolor="'.$kolor_typ_dok[$zest_typ_dok[$x]].'">'.$zest_wartosc_brutto_fv[$x].'</td>';
		}
	else
		{
		echo '<td align="right" title="Nie dodaję do sumy końcowej"><font color="#c9c9c9">'.$waluta_dla_zestawienia.$zest_wartosc_netto_fv[$x].'</font></td>';
		echo '<td align="right" title="Nie dodaję do sumy końcowej"><font color="#c9c9c9">'.$waluta_dla_zestawienia.$zest_wartosc_brutto_fv[$x].'</font></td>';
		}
	
	// do zapłaty
	if($user_stanowisko == 'administrator')
		{
		if(($zest_typ_dok[$x] == 'Faktura') || ($zest_typ_dok[$x] == 'Korekta'))
			{
			if($do_zaplaty[$x] != 0) echo '<td align="right" bgcolor="'.$kolor_typ_dok[$zest_typ_dok[$x]].'"><a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&wplata='.$faktura_id[$x].'"><font color="black">'.$do_zaplaty[$x].'</font></a></td>';
			else echo '<td align="right">'.$do_zaplaty[$x].'</td>';
			}
		else echo '<td align="right" title="Nie dodaję do sumy końcowej"><font color="#c9c9c9">'.$waluta_dla_zestawienia.$do_zaplaty[$x].'</font></td>';
		}
	else echo '<td align="right">'.$do_zaplaty[$x].$waluta_dla_zestawienia.'</td>';
	
		
		if($do_zaplaty[$x] == 0) $obrazek = $image_zaplacona; 

		if($do_zaplaty[$x] > 0) $obrazek = $image_niezaplacona;

		if(($do_zaplaty[$x] != $zest_wartosc_brutto_fv[$x]) && ($do_zaplaty[$x] <> 0))
			{
			$obrazek = $image_czesciowo; 
			$zaplacona[$x] = 'częściowo';
			}
		if($do_zaplaty[$x] < 0) 
			{
			if($zest_typ_dok[$x] == 'Korekta')
				{
				$obrazek = $image_niezaplacona;
				$zaplacona[$x] = 'do zwrotu';
				}
			else
				{
				$obrazek = $image_nadplata;
				$zaplacona[$x] = 'nadpłata';
				}
			}
			
		echo '<td align="left" valign="middle">';
		if(($zest_typ_dok[$x] == 'Faktura') || ($zest_typ_dok[$x] == 'Korekta')) echo '<table width="100%" class="text"><tr valign="middle"><td width="30%" align="center">'.$obrazek.'</td><td width="70%" align="left">'.$zaplacona[$x].'</td></tr></table>';
		echo '</td>';	
		
		if($wyslana_przez_email[$x] == 'tak')
			{
			$data_wysylki_email = date('d-m-Y', $wyslana_przez_email_data[$x]);
			$title = $data_wysylki_email.' '.$wyslana_przez_email_user_imie[$x].' '.$wyslana_przez_email_user_nazwisko[$x];
			echo '<td align="center" title="'.$title.'">'.$image_green_dot_mini.'</td>';
			}
		else echo '<td align="center">'.$image_red_dot_mini.'</td>';
			
	echo '</tr>';	
	//// 32964d
	if($wplata == $faktura_id[$x])
		{
		echo '<tr align="center" bgcolor="#5dec84" valign="middle">';
		if($user_id === 1) echo '<td></td>';
		echo '<td colspan="7" align="right">';
		echo 'Dodaj wpłatę dla faktury '.$zest_numer_faktury[$wplata].'&nbsp;&nbsp;:&nbsp;&nbsp;';
		echo '<td valign="middle">';
		
			echo '<table border="0" cellspacing="0" cellspadding="0" align="center" width="100%"><tr valign="middle"><td align="right" width="100%">';
			echo '<input type="text" size="6" maxlenght="10" id="wartosc_wplaty" name="wartosc_wplaty" autocomplete="off" align="right" class="pole_input_biale">';
			echo '</td><td align="left">';
			echo '<input type="checkbox" id="calosc" name="calosc" onClick="wplac_calosc('.$faktura_id[$x].')">';
			echo '</td></tr></table>';
		
		echo '</td>';	
		echo '<td align="center"><input type="submit" name="submit" value="Dodaj"></td>';	
		echo '<td></td></tr>';	
		}
	}
	
echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="center"><td>'.$ilosc_fv.'</td>';
if($user_id === 1) echo '<td align="right"></td>';
echo '<td colspan="4"></td>';

$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.',' ');
$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
$SUMA_DO_ZAPLATY = number_format($SUMA_DO_ZAPLATY, 2,'.',' ');
echo '<td align="right">'.$SUMA_NETTO.'</td>';
echo '<td align="right">'.$SUMA_BRUTTO.'</td>';
echo '<td align="right">'.$SUMA_DO_ZAPLATY.'</td>';
echo '<td align="right"></td>';
echo '<td align="right"></td>';
echo '</tr></table>';
echo '</form>';

?>