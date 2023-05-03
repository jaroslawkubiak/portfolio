<?php

$napis_guzika_dodaj_wycene = 'Dodaj wycene';
$aktualny_rok = date('y', $time);

if($zapisz == $napis_guzika_dodaj_wycene)
	{
	$nr_zamowienia = dodaj_zamowienie($conn, $klient, $typ_zamowienia, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $bez_potwierdzenia, $rodzaj, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy);
	//szukamy id zamowienia
	$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM zamowienia WHERE nr_zamowienia='".$nr_zamowienia."';"));
	$zamowienie_id = $sql['id'];

	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=wycena_dodaj&klient='.$klient.'&ilosc_pozycji='.$ilosc_pozycji.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&status='.$status.'&jak='.$jak.'&wg_czego='.$wg_czego.'&etap=2"> </head>';
	}

if($zapisz == '+')
	{
	$nr_zamowienia = dodaj_zamowienie($conn, $klient, $typ_zamowienia, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $bez_potwierdzenia, $rodzaj, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy);
	//szukamy id zamowienia
	$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM zamowienia WHERE nr_zamowienia='".$nr_zamowienia."';"));
	$zamowienie_id = $sql['id'];
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=ustawienia_dz_lista&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"> </head>';
	}


if((!$submit) && ($zapisz != 'Dodaj'))
{

echo '<div class="text_duzy" align="center">Dodaj zamówienie</div>';


echo '<table width="1400px" align="center" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
echo '<FORM action="index.php?page=zamowienie_dodaj" method="post">';
echo '<INPUT type="hidden" name="zamowienie_dodaj" value="zamowienie_dodaj">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
echo '<INPUT type="hidden" name="skad" value="zamowienie_dodaj">';

	echo '<table width="100%" align="center" border="0" cellpadding="3" cellpadding="3">';
	
	$klient_id = [];
	$klient_miasto = [];
	$klient_nazwa = [];

	$ilosc_klientow = 0;
	$pytanie1 = mysqli_query($conn, "SELECT * FROM klienci WHERE aktywny = 'on' ORDER BY nazwa ASC;");
	while($wynik1= mysqli_fetch_assoc($pytanie1))
		{
		$ilosc_klientow++;
		$klient_id[$ilosc_klientow] = $wynik1['id'];
		$klient_nazwa[$ilosc_klientow]=$wynik1['nazwa'];
		$klient_miasto[$ilosc_klientow]=$wynik1['miasto'];
		}
			
	echo '<INPUT type="hidden" name="klient_email" value="'.$klient.'">';
	
	if($klient)
	{
		$pytanie55 = mysqli_query($conn, "SELECT * FROM klienci WHERE id=".$klient.";");
		while($wynik55= mysqli_fetch_assoc($pytanie55))
			{
			$klient_email_potwierdzenie_pvc=$wynik55['potwierdzenie_pvc_email'];
			$klient_email_potwierdzenie_alu=$wynik55['potwierdzenie_alu_email'];
			$miasto_dostawy=$wynik55['dostawy_miasto'];
			$strefa=$wynik55['strefa'];
			$klient_aktywny=$wynik55['aktywny'];
			}
	}

	$szerokosc_kolumna1 = '40%';
	$szerokosc_kolumna2 = '20%';
	$szerokosc_kolumna3 = '40%';
	$szerokosc_pola_input = 'size="52"';

	//wyswietlamy info czy klient jest aktywny
	if(($klient != '') && ($klient_aktywny == '')) echo '<div class="text_duzy_czerwony" align="center"><font size="+3">UWAGA! Klient jest nieaktywny!</font></div>';

	echo '<INPUT type="hidden" name="klient_email_potwierdzenie" value="'.$klient_email_potwierdzenie.'">';
	$wartosc_zamowien = 0;
	echo '<tr align="center"><td align="right" width="'.$szerokosc_kolumna1.'" class="text">'.$kol_klient.' : </td><td align="left" width="'.$szerokosc_kolumna2.'">';
	echo '<select name="klient" class="pole_input" style="width: 100%" onchange="submit();">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_klientow; $k++) 
	if($klient == $klient_id[$k]) echo '<option selected="selected" value="'.$klient_id[$k].'">'.$klient_nazwa[$k].' ('.$klient_miasto[$k].')</option>';
	else echo '<option value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
	echo '</select>';
	
	echo '</td><td align="left" width="'.$szerokosc_kolumna3.'">';
	
		if($klient == '') echo '<a href="index.php?page=klienci_dodaj&jak='.$jak.'&wg_czego='.$wg_czego.'&skad=zamowienie_dodaj">'.$image_plusik.'</a>';
		else
			{
			//#########################################    szukamy wartosci zamowien w bierzacym roku      ###########################################
			$pytanie144 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE nabywca_id = ".$klient." AND data_wystawienia_rok = ".$AKTUALNY_ROK.";");
			while($wynik144 = mysqli_fetch_assoc($pytanie144))
				{
				$wartosc_zamowien += $wynik144['wartosc_netto_fv'];
				}
			$wartosc_zamowien = number_format($wartosc_zamowien, 2,'.','');
			echo '<div class="text" align="left">'.$wyraz_Wartosc.' zamówień w '.$AKTUALNY_ROK.' : '.$wartosc_zamowien.' '.$waluta.'</div>';
			//#########################################    szukamy wartosci zamowien w bierzacym roku   KONIEC   ###########################################
			
			
			//#########################################    szukamy daty ostatniego zamowienia      ###########################################
			$data_przyjecia = '';
			$pytanie24 = mysqli_query($conn, "SELECT data_przyjecia FROM zamowienia WHERE klient_id='".$klient."' ORDER BY id DESC LIMIT 1;");
			while($wynik24= mysqli_fetch_assoc($pytanie24))
				{
				$data_przyjecia = $wynik24['data_przyjecia'];

				$pytanie133 = mysqli_query($conn, "UPDATE ".$tabela_klientow." SET data_ostatniego_zamowienia = '".$data_przyjecia."' WHERE id = ".$klient.";");
				}		
			
			echo '<div class="text" align="left">Data ostatniego '.$wyraz_zamowienia.' : '.$data_przyjecia.'</div>';
			//#########################################    szukamy daty ostatniego zamowienia   KONIEC   ###########################################
			
			
			//#########################################    sprawdzamy stan zadluzenia klienta   ###########################################
			$SUMA_DO_ZAPLATY = 0;
			$SUMA_NETTO = 0;
			$SUMA_BRUTTO = 0;
			$ilosc_fv = 0;
			$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE typ_dok = 'Faktura' AND zaplacona = 'nie' AND termin_platnosci < ".$time." AND nabywca_id = ".$klient.";");
			while($wynik22= mysqli_fetch_assoc($pytanie22))
				{
				$ilosc_fv++;
				$faktura_id[$ilosc_fv]=$wynik22['id'];
				$zest_typ_dok[$ilosc_fv]=$wynik22['typ_dok'];
				$zest_wartosc_netto_fv[$ilosc_fv]=$wynik22['wartosc_netto_fv'];
				$zest_wartosc_brutto_fv[$ilosc_fv]=$wynik22['wartosc_brutto_fv'];
				
				$wplacono[$ilosc_fv]=$wynik22['wplacono'];
				$do_zaplaty[$ilosc_fv] = $zest_wartosc_brutto_fv[$ilosc_fv] - $wplacono[$ilosc_fv];
				
				if($zest_typ_dok[$ilosc_fv] == 'Faktura')
					{
					$SUMA_NETTO += $zest_wartosc_netto_fv[$ilosc_fv];
					$SUMA_BRUTTO += $zest_wartosc_brutto_fv[$ilosc_fv];
					$SUMA_DO_ZAPLATY += $do_zaplaty[$ilosc_fv];
					}
				$zaplacona[$ilosc_fv]=$wynik22['zaplacona'];
				}
			if($SUMA_DO_ZAPLATY != 0)
				{
				$SUMA_DO_ZAPLATY = number_format($SUMA_DO_ZAPLATY, 2,'.',' ');
				echo '<div class="text_red" align="left">Istnieją zaległości płatnicze na kwotę  : '.$SUMA_DO_ZAPLATY.'</div>';
				}
			else echo '<div class="text_green" align="left">Brak zaległości płatniczych.</div>';
			//#########################################    sprawdzamy stan zadluzenia klienta  KONIEC  ###########################################
			
			
			
			}
		echo '</td></tr>';
		
		
	// ##############################    adresy dostawy
	if($klient)
	{
	$pytanie188 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
	while($wynik188= mysqli_fetch_assoc($pytanie188))
		{
		$klient_dostawy_ulica=$wynik188['dostawy_ulica'];
		$klient_dostawy_miasto=$wynik188['dostawy_miasto'];
		$klient_dostawy_kod_pocztowy=$wynik188['dostawy_kod_pocztowy'];
		$klient_pomocniczy_ulica=$wynik188['dostawy_pomocniczy_ulica'];
		$klient_pomocniczy_miasto=$wynik188['dostawy_pomocniczy_miasto'];
		$klient_pomocniczy_kod_pocztowy=$wynik188['dostawy_pomocniczy_kod_pocztowy'];
		}

	if(($klient_pomocniczy_ulica != '') && ($klient_pomocniczy_kod_pocztowy != '') && ($klient_pomocniczy_miasto != ''))
		{
		echo '<tr align="center" class="text"><td colspan="3">';
			echo '<table border="0" cellpadding="4" cellspacing="4" align="center" width="50%" class="text"><tr><td align="center" colspan="2" class="text_duzy">Wybierz adres dostawy</td></tr>';


			if($adres_dostawy == 'glowny') 
				{
				$checked_adres_dostawy_glowny = 'checked'; 
				$miasto_dostawy = $klient_dostawy_miasto;
				$kod_pocztowy_dostawy = $klient_dostawy_kod_pocztowy;
				$ulica_dostawy = $klient_dostawy_ulica;
				}
			else $checked_adres_dostawy_glowny = '';
			
			if($adres_dostawy == 'pomocniczy') 
				{
				$checked_adres_dostawy_pomocniczy = 'checked'; 
				$miasto_dostawy = $klient_pomocniczy_miasto;
				$kod_pocztowy_dostawy = $klient_pomocniczy_kod_pocztowy;
				$ulica_dostawy = $klient_pomocniczy_ulica;
				}
			else $checked_adres_dostawy_pomocniczy = '';
			

			if($adres_dostawy == '') 
			{
				$checked_adres_dostawy_glowny = 'checked';
				$kod_pocztowy_dostawy = $klient_dostawy_kod_pocztowy;
				$ulica_dostawy = $klient_dostawy_ulica;
			}
		
			echo '<tr align="center"><td width="50%">Adres główny&nbsp;<input type="radio" name="adres_dostawy" value="glowny" onchange="submit();" '.$checked_adres_dostawy_glowny.'></td><td width="50%">Adres pomocniczy&nbsp;<input type="radio" name="adres_dostawy" onchange="submit();" value="pomocniczy" '.$checked_adres_dostawy_pomocniczy.'></td></tr>';
		
			echo '<tr align="center"><td>';
				echo $klient_dostawy_ulica.'<br>';
				echo $klient_dostawy_kod_pocztowy.' '.$klient_dostawy_miasto;
				echo '<INPUT type="hidden" name="klient_dostawy_kod_pocztowy" value="'.$klient_dostawy_kod_pocztowy.'">';
				echo '<INPUT type="hidden" name="klient_dostawy_ulica" value="'.$klient_dostawy_ulica.'">';
	
			echo '</td><td width="50%">';
				echo $klient_pomocniczy_ulica.'<br>';
				echo $klient_pomocniczy_kod_pocztowy.' '.$klient_pomocniczy_miasto;
				echo '<INPUT type="hidden" name="klient_pomocniczy_kod_pocztowy" value="'.$klient_pomocniczy_kod_pocztowy.'">';
				echo '<INPUT type="hidden" name="klient_pomocniczy_ulica" value="'.$klient_pomocniczy_ulica.'">';
			echo '</td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	else 
	{
		$miasto_dostawy = $klient_dostawy_miasto;
		$kod_pocztowy_dostawy = $klient_dostawy_kod_pocztowy;
		$ulica_dostawy = $klient_dostawy_ulica;
	}

	echo '<INPUT type="hidden" name="miasto_dostawy" value="'.$miasto_dostawy.'">';
	echo '<INPUT type="hidden" name="kod_pocztowy_dostawy" value="'.$kod_pocztowy_dostawy.'">';
	echo '<INPUT type="hidden" name="ulica_dostawy" value="'.$ulica_dostawy.'">';
	
	// ############################## KONIEC  adresy dostawy
	}

	// pobieram dane z bazy
	if($typ_zamowienia == 'zamowienie')
		{
		$opis = 'Numer '.$wyraz_zamowienia.' : ';
		$pytanie33 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_zamowienia'");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$kolejny_nr_zamowienia=$wynik33['opis'];
			}
		$nowy_numer_zamowienia = $kolejny_nr_zamowienia."/".$AKTUALNY_MIESIAC."/".$aktualny_rok;
		}
		
	if($typ_zamowienia == 'reklamacja')
		{
		$opis = 'Numer reklamacji : ';
		$pytanie333 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_reklamacji'");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			{
			$kolejny_nr_reklamacji=$wynik333['opis'];
			}
		
		$nowy_numer_zamowienia = $kolejny_nr_reklamacji."/".$aktualny_rok.'/RK';
		}
	
	echo '<INPUT type="hidden" name="typ_zamowienia" value="'.$typ_zamowienia.'">';


	echo '<tr align="center"><td align="right" class="text">'.$kol_typ.' : </td><td align="left">';
	echo '<select name="typ_zamowienia" class="pole_input" style="width: 100%" onchange="submit();">';
	echo '<option></option>';
	if($typ_zamowienia == 'zamowienie') echo '<option selected="selected" value="zamowienie">Zamówienie</option>';
	else echo '<option value="zamowienie">Zamówienie</option>';
	if($typ_zamowienia == 'reklamacja') echo '<option selected="selected" value="reklamacja">Reklamacja</option>';
	else echo '<option value="reklamacja">Reklamacja</option>';
	echo '</select></td><td align="left" class="text">'.$opis.$nowy_numer_zamowienia.'</td></tr>';

	// nr zam klienta
	echo '<tr align="center"><td align="right" class="text">'.$kol_nr_zamowienia_klienta2.' : </td><td align="left"><input autocomplete="off" type="text" '.$szerokosc_pola_input.' maxlength="20" class="pole_input" name="nr_zamowienia_klienta" value="'.$nr_zamowienia_klienta.'";"></td><td></td></tr>';


	// produkty
	$ilosc_produktow = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$ilosc_produktow++;
		$produkt_id[$ilosc_produktow] = $wynik2['id'];
		$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_produkt.' : </td><td align="left">';
	echo '<select name="produkt" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_produktow; $k++) 
	if($produkt == $produkt_opis[$k]) echo '<option selected="selected" value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	else echo '<option value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// system profile
	$ilosc_profili = 0;
	$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='profil' ORDER BY opis ASC");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$ilosc_profili++;
		$profil_id[$ilosc_profili] = $wynik3['id'];
		$profil_opis[$ilosc_profili] = $wynik3['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_system_prolifi.' : </td><td align="left">';
	echo '<select name="profil" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_profili; $k++) 
	if($profil == $profil_opis[$k]) echo '<option selected="selected" value="'.$profil_opis[$k].'">'.$profil_opis[$k].'</option>';
	else echo '<option value="'.$profil_opis[$k].'">'.$profil_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// kolor profili
	$ilosc_kolor_profili = 0;
	$pytanie6 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_profili' ORDER BY opis ASC");
	while($wynik6= mysqli_fetch_assoc($pytanie6))
		{
		$ilosc_kolor_profili++;
		$kolor_profili_id[$ilosc_kolor_profili] = $wynik6['id'];
		$kolor_profili_opis[$ilosc_kolor_profili] = $wynik6['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_kolor_profili.' : </td><td align="left">';
	echo '<select name="kolor_profili" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_kolor_profili; $k++) 
	if($kolor_profili == $kolor_profili_opis[$k]) echo '<option selected="selected" value="'.$kolor_profili_opis[$k].'">'.$kolor_profili_opis[$k].'</option>';
	else echo '<option value="'.$kolor_profili_opis[$k].'">'.$kolor_profili_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// magazyn
	$ilosc_magazyn = 0;
	$pytanie8 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='magazyn' ORDER BY opis ASC");
	while($wynik8= mysqli_fetch_assoc($pytanie8))
		{
		$ilosc_magazyn++;
		$magazyn_id[$ilosc_magazyn] = $wynik8['id'];
		$magazyn_opis[$ilosc_magazyn] = $wynik8['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_magazyn.' : </td><td align="left">';
	echo '<select name="magazyn" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_magazyn; $k++) 
	if($magazyn == $magazyn_opis[$k]) echo '<option selected="selected" value="'.$magazyn_opis[$k].'">'.$magazyn_opis[$k].'</option>';
	else echo '<option value="'.$magazyn_opis[$k].'">'.$magazyn_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	// stan
	$ilosc_stan = 0;
	$pytanie9 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='stan' ORDER BY opis ASC");
	while($wynik9= mysqli_fetch_assoc($pytanie9))
		{
		$ilosc_stan++;
		$stan_id[$ilosc_stan] = $wynik9['id'];
		$stan_opis[$ilosc_stan] = $wynik9['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_stan.' : </td><td align="left">';
	echo '<select name="stan" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_stan; $k++) 
	if($stan == $stan_opis[$k]) echo '<option selected="selected" value="'.$stan_opis[$k].'">'.$stan_opis[$k].'</option>';
	elseif(($stan == '') && ($stan_opis[$k] == 'Sprawdzić')) echo '<option selected="selected" value="'.$stan_opis[$k].'">'.$stan_opis[$k].'</option>';
	else echo '<option value="'.$stan_opis[$k].'">'.$stan_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	// odbior materialu od klienta
	echo '<tr align="center" class="text"><td align="right">Odbiór materiału od klienta : </td><td align="left">';
		echo '<input type="checkbox" name="odbior_materialu">';
	echo '</td><td align="left"></td></tr>';

	// kolor uszczelek
	$ilosc_kolor_uszczelek = 0;
	$pytanie7 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_uszczelek' ORDER BY opis ASC");
	while($wynik7= mysqli_fetch_assoc($pytanie7))
		{
		$ilosc_kolor_uszczelek++;
		$kolor_uszczelek_id[$ilosc_kolor_uszczelek] = $wynik7['id'];
		$kolor_uszczelek_opis[$ilosc_kolor_uszczelek] = $wynik7['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_kolor_uszczelek.' : </td><td align="left">';
	echo '<select name="kolor_uszczelek" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_kolor_uszczelek; $k++) 
	if($kolor_uszczelek == $kolor_uszczelek_opis[$k]) echo '<option selected="selected" value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
	else echo '<option value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// rodzaj oku
	$ilosc_rodzaj_okuc = 0;
	$pytanie4 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_okuc' ORDER BY opis ASC");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$ilosc_rodzaj_okuc++;
		$rodzaj_okuc_id[$ilosc_rodzaj_okuc] = $wynik4['id'];
		$rodzaj_okuc_opis[$ilosc_rodzaj_okuc] = $wynik4['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_rodzaj_okuc.' : </td><td align="left">';
	echo '<select name="rodzaj_okuc" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_rodzaj_okuc; $k++) 
	if($rodzaj_okuc == $rodzaj_okuc_opis[$k]) echo '<option selected="selected" value="'.$rodzaj_okuc_opis[$k].'">'.$rodzaj_okuc_opis[$k].'</option>';
	else echo '<option value="'.$rodzaj_okuc_opis[$k].'">'.$rodzaj_okuc_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	// rodzaj szyb
	$ilosc_rodzaj_szyb = 0;
	$pytanie5 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_szyb' ORDER BY opis ASC");
	while($wynik5= mysqli_fetch_assoc($pytanie5))
		{
		$ilosc_rodzaj_szyb++;
		$rodzaj_szyb_id[$ilosc_rodzaj_szyb] = $wynik5['id'];
		$rodzaj_szyb_opis[$ilosc_rodzaj_szyb] = $wynik5['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_rodzaj_szyb.' : </td><td align="left">';
	echo '<select name="rodzaj_szyb" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_rodzaj_szyb; $k++) 
	if($rodzaj_szyb == $rodzaj_szyb_opis[$k]) echo '<option selected="selected" value="'.$rodzaj_szyb_opis[$k].'">'.$rodzaj_szyb_opis[$k].'</option>';
	else echo '<option value="'.$rodzaj_szyb_opis[$k].'">'.$rodzaj_szyb_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';
	

	//#########################################   STREFA  #####################################
	echo '<tr align="center" class="text"><td align="right">Strefa : </td><td align="left">';
		echo '<select name="strefa" class="pole_input">';
		for($k=1; $k<=$DL_TABELA_STREFY; $k++)
			if($strefa == $TABELA_STREFY[$k]) echo '<option selected="selected" value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
			else echo '<option value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';

	// termin realizacji zamowienia
	echo '<tr align="center"><td align="right" class="text">'.$kol_termin_realizacji.' : </td><td align="left">';         
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr><td><input type="text" '.$szerokosc_pola_input.' maxlength="20" class="pole_input" autocomplete="off"  name="termin_realizacji" id="f_date_c" value="'.$termin_realizacji.'"/></td></tr></table>';
	?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_date_c",     // id of the input field
			ifFormat       :    "T%W/%y",      // format of the input field
			button         :    "f_date_c",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	</td><td></td></tr>	
	<?php
	
	
	if($typ_zamowienia) require("php/termin_realizacji_tabela.php");
	
	
	if($typ_zamowienia != '') 
		{
		echo '<tr align="center" class="text"><td align="right">Wycena ilość pozycji : </td><td align="left">';
		echo '<select name="ilosc_pozycji" class="pole_input">';
		for ($k=1; $k<=30; $k++) echo '<option value="'.$k.'">'.$k.'</option>';
		echo '</select>&nbsp;<INPUT type="submit" name="zapisz" value="'.$napis_guzika_dodaj_wycene.'">';
		echo '</td><td></td></tr>';
		}


	echo '<tr align="center"><td align="right" class="text">'.$kol_data_dostawy.' : </td><td align="left">';         
	
		echo '<table cellspacing="0" cellpadding="0" border="0"><tr><td><input type="text" '.$szerokosc_pola_input.' maxlength="20" readonly="readonly" class="pole_input" autocomplete="off"  name="data_dostawy" id="f_date_d" value="'.$data_dostawy.'"/></td></tr></table>';
		?>
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "f_date_d",     // id of the input field
				ifFormat       :    "%d-%m-%Y",      // format of the input field
				button         :    "f_date_d",  // trigger for the calendar (button ID)
				singleClick    :    true
			});
		</script>
		</td><td></td></tr>	

<?php


	// status
	$ilosc_status = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status' AND opis <> 'Dostarczone' AND opis <> 'Odebrane' AND opis <> 'Anulowane' ORDER BY opis ASC");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
		{
		$ilosc_status++;
		$status_id[$ilosc_status] = $wynik91['id'];
		$status_opis[$ilosc_status] = $wynik91['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_status_zamowienia.' : </td><td align="left">';
	echo '<select name="status" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_status; $k++) 
	if($status == $status_opis[$k]) echo '<option selected="selected" value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
	elseif(($status == '') && ($status_opis[$k] == 'Nie potwierdzone')) echo '<option selected="selected" value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
	else echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// uwagi 1 
	$ilosc_uwaga_1 = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
		{
		$ilosc_uwaga_1++;
		$uwaga_1_id[$ilosc_uwaga_1] = $wynik91['id'];
		$uwaga_1_opis[$ilosc_uwaga_1] = $wynik91['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_uwagi.' : </td><td align="left">';
	echo '<select name="uwaga_1" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_uwaga_1; $k++) 
	if($uwaga_1 == $uwaga_1_opis[$k]) echo '<option selected="selected" value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
	else echo '<option value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';
	
	// uwagi 2 
	$ilosc_uwaga_2 = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
			{
			$ilosc_uwaga_2++;
			$uwaga_2_id[$ilosc_uwaga_2] = $wynik91['id'];
			$uwaga_2_opis[$ilosc_uwaga_2] = $wynik91['opis'];
			}
	echo '<tr align="center" class="text"><td align="right">'.$kol_uwagi.' : </td><td align="left">';
	echo '<select name="uwaga_2" class="pole_input" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_uwaga_2; $k++) 
	if($uwaga_2 == $uwaga_2_opis[$k]) echo '<option selected="selected" value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
	else echo '<option value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left">';
	if(($typ_zamowienia != '') && ($klient != '')) echo '<INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	echo '<tr align="center"><td align="right" class="text">'.$kol_uwagi_pdf.' : </td><td align="left">';
	echo '<textarea name="uwagi" cols="49" rows="4" class="pole_input_szare_ramka_uwagi">'.$uwagi.'</textarea></td><td></td></tr>';

	echo '<tr align="center"><td align="right" class="text">'.$kol_uwagi_email.' : </td><td align="left">';
	echo '<textarea name="uwagi_do_email" cols="49" rows="4" class="pole_input_szare_ramka_uwagi">'.$uwagi_do_email.'</textarea></td><td></td></tr>';

	
	echo '</FORM>';

		echo '</table>';
	echo '</td></tr></table>';
}
?>