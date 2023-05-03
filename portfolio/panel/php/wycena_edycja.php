<?php

$SORTOWANIE_DIV = '&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'';
//usuwamy pzoycje
if($usun_pozycje != '')
	{
	//echo '$usun_pozycje='.$usun_pozycje.'<br>';
	//sprawdzamy ile jest pozycji
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE id = ".$usun_pozycje.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji_zamowienie=$wynik['ilosc_pozycji'];
		$nr_faktury_zamowienie=$wynik['nr_faktury'];
		$pozycja_do_usuniecia=$wynik['pozycja'];
		}	
	
	$nowa_ilosc_pozycji_zamowienie = $ilosc_pozycji_zamowienie - 1;
	mysqli_query($conn, "DELETE FROM wyceny WHERE id = ".$usun_pozycje.";");
	if($wycena_wstepna_nr != '')
		{
		mysqli_query($conn, "UPDATE wyceny SET ilosc_pozycji = ".$nowa_ilosc_pozycji_zamowienie." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."';"); //ustawiam now ilosc pozycji dla wyceny
		mysqli_query($conn, "UPDATE wyceny SET pozycja = ".$ilosc_pozycji_zamowienie." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'tak' ;");
		}
	else
		{
		mysqli_query($conn, "UPDATE wyceny SET ilosc_pozycji = ".$nowa_ilosc_pozycji_zamowienie." WHERE zamowienie_id = ".$zamowienie_id.";"); //ustawiam now ilosc pozycji dla wyceny
		mysqli_query($conn, "UPDATE wyceny SET pozycja = ".$ilosc_pozycji_zamowienie." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak' ;");
		}


	if($ilosc_pozycji_zamowienie != $pozycja_do_usuniecia)
		{
		$temp = $ilosc_pozycji_zamowienie - $pozycja_do_usuniecia;
		for($i = 1; $i <= $temp; $i++)
			{
			$temp2 = $pozycja_do_usuniecia + 1;
			mysqli_query($conn, "UPDATE wyceny SET pozycja = ".$pozycja_do_usuniecia." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$temp2.";");
			mysqli_query($conn, "UPDATE wyceny SET pozycja = ".$pozycja_do_usuniecia." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = ".$temp2.";");
			$pozycja_do_usuniecia++;
			}
		}
		
	if($nr_faktury_zamowienie != '')
		{
		$pytanie2 = mysqli_query($conn, "SELECT id FROM fv_naglowek WHERE nr_dok = '".$nr_faktury_zamowienie."';");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$fv_id=$wynik2['id'];
			}
		mysqli_query($conn, "DELETE FROM fv_pozycje WHERE pozycja_id = ".$usun_pozycje.";");
		
		$WART_NETTO_FV = 0;
		$WART_BRUTTO_FV = 0;
		$pytanie27 = mysqli_query($conn, "SELECT * FROM wyceny WHERE nr_faktury = '".$nr_faktury_zamowienie."';");
		while($wynik27= mysqli_fetch_assoc($pytanie27))
			{
			$wartosc_netto_wycena=$wynik27['wartosc_netto'];
			$wartosc_brutto_wycena=$wynik27['wartosc_brutto'];
			$WART_NETTO_FV += $wartosc_netto_wycena;
			$WART_BRUTTO_FV += $wartosc_brutto_wycena;
			}
		
		mysqli_query($conn, "UPDATE fv_naglowek SET wartosc_netto_fv = ".$WART_NETTO_FV." WHERE id = ".$fv_id.";");
		mysqli_query($conn, "UPDATE fv_naglowek SET wartosc_brutto_fv = ".$WART_BRUTTO_FV." WHERE id = ".$fv_id.";");
		
		
		if($adres_ip != '127.0.0.1')  include('php/generuj_fakture.php');
		echo '<table border="0" width="1500px" class="text" align="left"><tr valign="middle" width="100%" >';
		echo '<td class="text_duzy_niebieski" align="right" width="70%">Wydrukuj nowo wygenerowaną fakturę '.$nr_fv_oryginalny.'</td>';
		// adres_serwera_do_faktur zapisane jest w connection.php
		echo '<td align="left" width="30%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a></td>';
		echo '</tr></table><br>';
		}
	
	// usuwamy pozycje ze zlec transp
	mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_wyceny=".$pozycja_do_usuniecia.";");
	
	} // do if($usun_pozycje != '')

//############################################


// dodajemy pozycje transportowa do zamowienia
if(($dodaj_pozycje_transport == 'tak') && ($wycena_wstepna_nr == ''))
	{
	//sprawdzamy ile jest pozycji
	$pytanie = mysqli_query($conn, "SELECT ilosc_pozycji FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." ORDER BY pozycja DESC LIMIT 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		$ilosc_pozycji_zamowienie=$wynik['ilosc_pozycji'];

	// echo 'ilosc pozycji z bazy:'.$ilosc_pozycji_zamowienie.'<br>';
	$ilosc_pozycji_zamowienie++;
	$pytanie1 = mysqli_query($conn, "UPDATE wyceny SET ilosc_pozycji = ".$ilosc_pozycji_zamowienie." WHERE zamowienie_id = ".$zamowienie_id.";");
	
	$pytanie4 = mysqli_query($conn, "SELECT klient_id, klient_nazwa, nr_zamowienia FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = 1;");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$klient_wycena=$wynik4['klient_id'];
		$klient_nazwa_wycena=$wynik4['klient_nazwa'];
		$nr_zamowienia_wycena=$wynik4['nr_zamowienia'];
		}	
	
	$pytanie3 = mysqli_query($conn, "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `nazwa_produktu`, `vat`, `korekta_fv`, `data_dodania_pozycji`, `dodal_user_id`) values ('$klient_wycena', '$klient_nazwa_wycena', '$zamowienie_id', '$nr_zamowienia_wycena', '$ilosc_pozycji_zamowienie', '$ilosc_pozycji_zamowienie', 'tak', 'Transport', 23, 'NIE', '$time', '$zalogowany_user');");

	
	//sprawdzamy czy zamowienie ma juz wypelnione zlec tranp
	$pytanie145 = mysqli_query($conn, "SELECT nr_zlecenia_transportowego FROM zamowienia WHERE id=".$zamowienie_id.";");
	while($wynik145= mysqli_fetch_assoc($pytanie145))
		$nr_zlecenia_transportowego=$wynik145['nr_zlecenia_transportowego'];
		
	// jezeli dodajemy pozycje z poziomu zlecenia transportowego to od razu ją zaznaczamy i dodajemy do zlecenia LUB jezeli nr już jest
	if(($skad == 'zlecenie_transportowe') || ($nr_zlecenia_transportowego != ''))
		{
		$pytanie15 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE id=".$id_zlec_transp.";");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			$nr_zlecenia_transportowego=$wynik15['nr_zlecenia_transportowego'];


		$pytanie155 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND zamowienie_id =".$zamowienie_id.";");
		while($wynik155= mysqli_fetch_assoc($pytanie155))
			{
			$klient_id=$wynik155['klient_id'];
			$data_dostawy=$wynik155['data_dostawy'];
			$uwagi=$wynik155['uwagi'];
			$liczba_paczek_wyrobow=$wynik155['liczba_paczek_wyrobow'];
			$liczba_paczek_zwrot=$wynik155['liczba_paczek_zwrot'];
			$kolejnosc=$wynik155['kolejnosc'];
			}
	
		$pytanie152 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id=".$zamowienie_id.";");
		while($wynik152= mysqli_fetch_assoc($pytanie152))
			$pozycja_wyceny=$wynik152['pozycja'];
		
		// $sql = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `data_dostawy`, `uwagi`, `liczba_paczek_wyrobow`, `kolejnosc`, `pozycja_wyceny`, `user_id`, `time`) 
		// values ('$nr_zlecenia_transportowego', '$klient_id', '$zamowienie_id', '$data_dostawy', '$uwagi', '$liczba_paczek_wyrobow', '$kolejnosc', '$pozycja_wyceny', '$zalogowany_user', '$time');";
		// show_mysqli_query($conn, $sql);
		// echo 'insert2<br>';
		}
	}
	// KONIEC dodajemy pozycje transportowa do zamowienia
elseif(($dodaj_pozycje_transport == 'tak') && ($wycena_wstepna_nr != ''))
	{
	//dodajemy pozycje transport do wyceny wstepnej
	//sprawdzamy ile jest pozycji
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' ORDER BY pozycja DESC LIMIT 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji_wycena_wstepna=$wynik['ilosc_pozycji'];
		$klient_wycena_id=$wynik['klient_id'];
		$klient_nazwa_id=$wynik['klient_nazwa'];
		$data_wyceny=$wynik['data_wyceny'];
		$data_waznosci=$wynik['data_waznosci_wyceny'];
		$email=$wynik['wycena_wstepna_email'];
		$user_id_z_wyceny=$wynik['user_id'];
		$termin_realizacji=$wynik['termin_realizacji'];
		$sposob_dostawy=$wynik['sposob_dostawy_wycena_wstepna'];
		}	

	$ilosc_pozycji_wycena_wstepna++;
	$pytanie3 = mysqli_query($conn, "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `nazwa_produktu`,  `vat`, `korekta_fv`, `wycena_wstepna_nr`, `data_wyceny`, `user_id`, `data_waznosci_wyceny`, `wycena_wstepna_email`, `termin_realizacji`, `sposob_dostawy_wycena_wstepna`) 
	values ('$klient_wycena_id', '$klient_nazwa_id', '$wycena_wstepna_nr', '$ilosc_pozycji_wycena_wstepna', '$ilosc_pozycji_wycena_wstepna', 'tak', 'Transport', 23, 'NIE', '$wycena_wstepna_nr', '$data_wyceny', '$user_id_z_wyceny', '$data_waznosci', '$email', '$termin_realizacji', '$sposob_dostawy');");

	$pytanie1 = mysqli_query($conn, "UPDATE wyceny SET ilosc_pozycji = ".$ilosc_pozycji_wycena_wstepna." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."';");

	// jezeli dodajemy pozycje z poziomu zlecenia transportowego to od razu ją zaznaczamy i dodajemy do zlecenia LUB jezeli nr już jest
	if(($skad == 'zlecenie_transportowe') || ($nr_zlecenia_transportowego != ''))
		{
		$pytanie15 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE id=".$id_zlec_transp.";");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			$nr_zlecenia_transportowego=$wynik15['nr_zlecenia_transportowego'];


		$pytanie155 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND zamowienie_id =".$zamowienie_id.";");
		while($wynik155= mysqli_fetch_assoc($pytanie155))
			{
			$klient_id=$wynik155['klient_id'];
			$data_dostawy=$wynik155['data_dostawy'];
			$uwagi=$wynik155['uwagi'];
			$liczba_paczek_wyrobow=$wynik155['liczba_paczek_wyrobow'];
			$liczba_paczek_zwrot=$wynik155['liczba_paczek_zwrot'];
			$kolejnosc=$wynik155['kolejnosc'];
			}
	
		$pytanie152 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id=".$zamowienie_id.";");
		while($wynik152= mysqli_fetch_assoc($pytanie152))
			$pozycja_wyceny=$wynik152['pozycja'];
		
		// $sql = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `data_dostawy`, `uwagi`, `liczba_paczek_wyrobow`, `kolejnosc`, `pozycja_wyceny`, `user_id`, `time`) 
		// values ('$nr_zlecenia_transportowego', '$klient_id', '$zamowienie_id', '$data_dostawy', '$uwagi', '$liczba_paczek_wyrobow', '$kolejnosc', '$pozycja_wyceny', '$zalogowany_user', '$time');";
		// show_mysqli_query($conn, $sql);
		// echo 'insert1<br>';
		}

	}


if($dodaj_pozycje_transport == 'tak')
{
	// echo 'dodaje##############<br>';
	// echo 'nr_zlecenia_transportowego='.$nr_zlecenia_transportowego.'<br>';
	// echo 'klient_id='.$klient_id.'<br>';
	// echo 'zamowienie_id='.$zamowienie_id.'<br>';
	// echo 'data_dostawy='.$data_dostawy.'<br>';
	// echo 'uwagi='.$uwagi.'<br>';
	// echo 'pozycja_wyceny='.$pozycja_wyceny.'<br>';

	$sql = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `data_dostawy`, `uwagi`, `liczba_paczek_wyrobow`, `pozycja_wyceny`, `user_id`, `time`) 
	values ('$nr_zlecenia_transportowego', '$klient_id', '$zamowienie_id', '$data_dostawy', '$uwagi', '$liczba_paczek_wyrobow', '$pozycja_wyceny', '$zalogowany_user', '$time');";
	// mysqli_query($conn, $sql);
	$result = mysqli_query($conn, $sql);

		//sprawdzamy czy byl blad
		$blad_zapytania = mysqli_error($conn);
		$szukaj = "'";
		$zamien_na = " ";
		$przerobione_sql = zamien_dowolne_znaki($sql, $szukaj, $zamien_na);
		$szukaj = '"';
		$zamien_na = ' ';
		$przerobione_sql = zamien_dowolne_znaki($przerobione_sql, $szukaj, $zamien_na);
		if($blad_zapytania != '')
			{
			$szukaj = "'";
			$zamien_na = " ";
			$przerobione_blad_zapytania = zamien_dowolne_znaki($blad_zapytania, $szukaj, $zamien_na);
			$szukaj = '"';
			$zamien_na = ' ';
			$przerobione_blad_zapytania = zamien_dowolne_znaki($przerobione_blad_zapytania, $szukaj, $zamien_na);
			}
		else $przerobione_blad_zapytania = 'BRAK BŁĘDU.';
		$sql3 = "INSERT INTO `bledy` (`user_id`, `tresc`, `blad`, `time`, `zamowienie_id`) VALUES ('$zalogowany_user', '$przerobione_sql', '$przerobione_blad_zapytania', '$time', '$zamowienie_id');";
		$pytanie12 = mysqli_query($conn, $sql3);	

	if(!$result) echo'<div class="text_duzy"><font color="red">Pozycja transportowa NIE została dodana do zlecenia transportowego!</div>';
	else echo'<div class="text_duzy"><font color="blue">Pozycja transportowa została dodana do zlecenia transportowego nr :  </font><font color="blue">'.$nr_zlecenia_transportowego.'</font></div>';
}
	

// dodajemy nowa pozycje do zamowienia NIE Z WYCENY WSTEPNEJ
if(($nowa_pozycja == 'tak') && ($wycena_wstepna_nr == ''))
	{
	//sprawdzamy ile jest pozycji i czy jest pozycja transportowa
	$pytanie = mysqli_query($conn, "SELECT ilosc_pozycji, pozycja_transport FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." ORDER BY pozycja DESC LIMIT 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$pozycja_transport_zamowienie=$wynik['pozycja_transport'];
		$ilosc_pozycji_zamowienie=$wynik['ilosc_pozycji'];
		$stopien_trudnosci=$wynik['stopien_trudnosci'];
		}	
	$ilosc_pozycji_zamowienie++;

	$pytanie1 = mysqli_query($conn, "UPDATE wyceny SET ilosc_pozycji = ".$ilosc_pozycji_zamowienie." WHERE zamowienie_id = ".$zamowienie_id.";");
	if($pozycja_transport_zamowienie == 'tak') 
		{
		$pytanie2 = mysqli_query($conn, "UPDATE wyceny SET pozycja = ".$ilosc_pozycji_zamowienie." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		$nowa_pozycja_2 = $ilosc_pozycji_zamowienie - 1;
		}
	else $nowa_pozycja_2 = $ilosc_pozycji_zamowienie;

	$pytanie4 = mysqli_query($conn, "SELECT klient_id, klient_nazwa, nr_zamowienia FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = 1;");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$klient_wycena=$wynik4['klient_id'];
		$klient_nazwa_wycena=$wynik4['klient_nazwa'];
		$nr_zamowienia_wycena=$wynik4['nr_zamowienia'];
		}
	// poprzednie zapytanie zwrcio wynik pusty - znaczy e jest 0 pozycji w wycenie
	if(($nr_zamowienia_wycena == '') && ($klient_wycena == ''))
		{
		$pytanie4 = mysqli_query($conn, "SELECT klient_id, klient_nazwa, nr_zamowienia FROM zamowienia WHERE id = ".$zamowienie_id.";");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$klient_wycena=$wynik4['klient_id'];
			$klient_nazwa_wycena=$wynik4['klient_nazwa'];
			$nr_zamowienia_wycena=$wynik4['nr_zamowienia'];
			}
		}
	
	// pobieram cennik dla klienta
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id=".$klient_wycena.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$cena[1] = number_format($wynik['wygiecie_ramy_z_pvc'], 2,'.','');
		$cena[2] = number_format($wynik['wygiecie_skrzydla_z_pvc'], 2,'.','');
		$cena[3] = number_format($wynik['wygiecie_listwy_z_pvc'], 2,'.','');
		$cena[4] = number_format($wynik['wygiecie_innego_elementu_z_pvc'], 2,'.','');
		
		$cena[5] = number_format($wynik['wygiecie_ramy_z_alu'], 2,'.','');
		$cena[6] = number_format($wynik['wygiecie_skrzydla_z_alu'], 2,'.','');
		$cena[7] = number_format($wynik['wygiecie_listwy_z_alu'], 2,'.','');
		$cena[8] = number_format($wynik['wygiecie_innego_elementu_z_alu'], 2,'.','');
	
		$cena[9] = number_format($wynik['wygiecie_wzmocnienia_okiennego'], 2,'.','');
		$cena[10] = number_format($wynik['wygiecie_innego_elementu_ze_stali'], 2,'.','');
		$cena[11] = number_format($wynik['zgrzanie'], 2,'.','');
		$cena[12] = number_format($wynik['wyfrezowanie_odwodnienia'], 2,'.','');
		
		$cena[13] = number_format($wynik['wstawienie_slupka'], 2,'.','');
		$cena[14] = number_format($wynik['dociecie_listwy_przyszybowej'], 2,'.','');
		$cena[15] = number_format($wynik['okucie'], 2,'.','');
		$cena[16] = number_format($wynik['zaszklenie'], 2,'.','');
		
		$cena[17] = number_format($wynik['wykonanie_innej_uslugi'], 2,'.','');
		$cena[18] = number_format($wynik['oscieznica'], 2,'.','');
		$cena[19] = number_format($wynik['skrzydlo'], 2,'.','');
		$cena[20] = number_format($wynik['listwa'], 2,'.','');

		$cena[21] = number_format($wynik['slupek'], 2,'.','');
		$cena[22] = number_format($wynik['wzmocnienie_do_ramy'], 2,'.','');
		$cena[23] = number_format($wynik['wzmocnienie_do_skrzydla'], 2,'.','');
		$cena[24] = number_format($wynik['wzmocnienie_do_slupka'], 2,'.','');
		
		$cena[25] = number_format($wynik['wzmocnienie_do_luku'], 2,'.','');
		$cena[26] = number_format($wynik['okucia'], 2,'.','');
		$cena[27] = number_format($wynik['szyby'], 2,'.','');
		$cena[28] = number_format($wynik['inny_element'], 2,'.','');

		$cena[29] = number_format($wynik['wstawienie_slupka_ruchomego'], 2,'.','');
		$cena[30] = number_format($wynik['dociecie_kompletu_listew_przyszybowych'], 2,'.','');
		}
	
		$stopien_trudnosci = 1;
		
	$pytanie3 = "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`
	, `wygiecie_ramy_pvc_cena`, `wygiecie_skrzydla_pvc_cena`, `wygiecie_listwy_pvc_cena`, `wygiecie_innego_pvc_cena`, `wygiecie_ramy_alu_cena`, `wygiecie_skrzydla_alu_cena`, `wygiecie_listwy_alu_cena`, `wygiecie_innego_alu_cena`
	, `wygiecie_wzmocnienia_okiennego_cena`, `wygiecie_innego_cena`, `zgrzanie_cena`, `wyfrezowanie_odwodnienia_cena`, `wstawienie_slupka_cena`, `listwa_przyszybowa_cena`, `okucie_cena`, `zaszklenie_cena`, `innej_uslugi_cena`
	, `oscieznica_cena`, `skrzydlo_cena`, `listwa_cena`, `slupek_cena`, `wzmocnienie_ramy_cena`, `wzmocnienie_skrzydla_cena`, `wzmocnienie_slupka_cena`, `wzmocnienie_luku_cena`, `okucia_cena`, `szyby_cena`, `inny_element_cena`, `vat`, `korekta_fv`, `data_dodania_pozycji`, `dodal_user_id`, `wstawienie_slupka_ruchomego_cena`, `dociecie_kompletu_listew_przyszybowych_cena`, `stopien_trudnosci`) 
	  
	values ('$klient_wycena', '$klient_nazwa_wycena', '$zamowienie_id', '$nr_zamowienia_wycena', '$ilosc_pozycji_zamowienie', '$nowa_pozycja_2', 'nie'
	, '$cena[1]', '$cena[2]', '$cena[3]', '$cena[4]', '$cena[5]', '$cena[6]', '$cena[7]', '$cena[8]', '$cena[9]', '$cena[10]'
	, '$cena[11]', '$cena[12]', '$cena[13]', '$cena[14]', '$cena[15]', '$cena[16]', '$cena[17]', '$cena[18]', '$cena[19]', '$cena[20]'
	, '$cena[21]', '$cena[22]', '$cena[23]', '$cena[24]', '$cena[25]', '$cena[26]', '$cena[27]', '$cena[28]', 23, 'NIE', '$time', '$zalogowany_user', '$cena[29]', '$cena[30]', '$stopien_trudnosci');";

	mysqli_query($conn, $pytanie3);



	}
	
elseif(($nowa_pozycja == 'tak') && ($wycena_wstepna_nr != ''))
	{
	// echo 'dodaje pozycje wyceny wstepnej<br>';
	//sprawdzamy ile jest pozycji i czy jest pozycja transportowa
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' ORDER BY pozycja DESC LIMIT 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$pozycja_transport_zamowienie=$wynik['pozycja_transport'];
		$ilosc_pozycji_zamowienie=$wynik['ilosc_pozycji'];
		$klient_wycena=$wynik['klient_id'];
		$klient_nazwa_wycena=$wynik['klient_nazwa'];
		$nr_zamowienia_wycena=$wycena_wstepna_nr;
		$data_wyceny=$wynik['data_wyceny'];
		$data_waznosci_wyceny=$wynik['data_waznosci_wyceny'];
		$wycena_wstepna_email=$wynik['wycena_wstepna_email'];
		$termin_realizacji=$wynik['termin_realizacji'];
		$sposob_dostawy_wycena_wstepna=$wynik['sposob_dostawy_wycena_wstepna'];
		$wycena_wstepna_wartosc_netto=$wynik['wycena_wstepna_wartosc_netto'];
		$user_wycena=$wynik['user_id'];

		$stopien_trudnosci=$wynik['stopien_trudnosci'];
		}	
	$ilosc_pozycji_zamowienie++;
	


	$pytanie1 = "UPDATE wyceny SET ilosc_pozycji = ".$ilosc_pozycji_zamowienie." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."';";
	mysqli_query($conn, $pytanie1);

	if($pozycja_transport_zamowienie == 'tak') 
		{
		$pytanie2 = mysqli_query($conn, "UPDATE wyceny SET pozycja = ".$ilosc_pozycji_zamowienie." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'tak';");
		$nowa_pozycja_2 = $ilosc_pozycji_zamowienie - 1;
		}
	else $nowa_pozycja_2 = $ilosc_pozycji_zamowienie;

	// pobieram cennik dla klienta
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id=".$klient_wycena.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$cena[1] = number_format($wynik['wygiecie_ramy_z_pvc'], 2,'.','');
		$cena[2] = number_format($wynik['wygiecie_skrzydla_z_pvc'], 2,'.','');
		$cena[3] = number_format($wynik['wygiecie_listwy_z_pvc'], 2,'.','');
		$cena[4] = number_format($wynik['wygiecie_innego_elementu_z_pvc'], 2,'.','');
		
		$cena[5] = number_format($wynik['wygiecie_ramy_z_alu'], 2,'.','');
		$cena[6] = number_format($wynik['wygiecie_skrzydla_z_alu'], 2,'.','');
		$cena[7] = number_format($wynik['wygiecie_listwy_z_alu'], 2,'.','');
		$cena[8] = number_format($wynik['wygiecie_innego_elementu_z_alu'], 2,'.','');
	
		$cena[9] = number_format($wynik['wygiecie_wzmocnienia_okiennego'], 2,'.','');
		$cena[10] = number_format($wynik['wygiecie_innego_elementu_ze_stali'], 2,'.','');
		$cena[11] = number_format($wynik['zgrzanie'], 2,'.','');
		$cena[12] = number_format($wynik['wyfrezowanie_odwodnienia'], 2,'.','');
		
		$cena[13] = number_format($wynik['wstawienie_slupka'], 2,'.','');
		$cena[14] = number_format($wynik['dociecie_listwy_przyszybowej'], 2,'.','');
		$cena[15] = number_format($wynik['okucie'], 2,'.','');
		$cena[16] = number_format($wynik['zaszklenie'], 2,'.','');
		
		$cena[17] = number_format($wynik['wykonanie_innej_usługi'], 2,'.','');
		$cena[18] = number_format($wynik['oscieznica'], 2,'.','');
		$cena[19] = number_format($wynik['skrzydlo'], 2,'.','');
		$cena[20] = number_format($wynik['listwa'], 2,'.','');

		$cena[21] = number_format($wynik['slupek'], 2,'.','');
		$cena[22] = number_format($wynik['wzmocnienie_do_ramy'], 2,'.','');
		$cena[23] = number_format($wynik['wzmocnienie_do_skrzydla'], 2,'.','');
		$cena[24] = number_format($wynik['wzmocnienie_do_slupka'], 2,'.','');
		
		$cena[25] = number_format($wynik['wzmocnienie_do_luku'], 2,'.','');
		$cena[26] = number_format($wynik['okucia'], 2,'.','');
		$cena[27] = number_format($wynik['szyby'], 2,'.','');
		$cena[28] = number_format($wynik['inny_element'], 2,'.','');
		}
	
	$pytanie3 =  "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `wygiecie_ramy_pvc_cena`, `wygiecie_skrzydla_pvc_cena`, `wygiecie_listwy_pvc_cena`, `wygiecie_innego_pvc_cena`, `wygiecie_ramy_alu_cena`, `wygiecie_skrzydla_alu_cena`, `wygiecie_listwy_alu_cena`, `wygiecie_innego_alu_cena`, `wygiecie_wzmocnienia_okiennego_cena`, `wygiecie_innego_cena`, `zgrzanie_cena`, `wyfrezowanie_odwodnienia_cena`, `wstawienie_slupka_cena`, `listwa_przyszybowa_cena`, `okucie_cena`, `zaszklenie_cena`, `innej_uslugi_cena`, `oscieznica_cena`, `skrzydlo_cena`, `listwa_cena`, `slupek_cena`, `wzmocnienie_ramy_cena`, `wzmocnienie_skrzydla_cena`, `wzmocnienie_slupka_cena`, `wzmocnienie_luku_cena`, `okucia_cena`, `szyby_cena`, `inny_element_cena`, `vat`, `korekta_fv`, `wycena_wstepna_nr`, `data_wyceny`, `user_id`, `data_waznosci_wyceny`, `wycena_wstepna_email`, `termin_realizacji`, `sposob_dostawy_wycena_wstepna`, `stopien_trudnosci`) values ('$klient_wycena', '$klient_nazwa_wycena', '$nr_zamowienia_wycena', '$ilosc_pozycji_zamowienie', '$nowa_pozycja_2', 'nie', '$cena[1]', '$cena[2]', '$cena[3]', '$cena[4]', '$cena[5]', '$cena[6]', '$cena[7]', '$cena[8]', '$cena[9]', '$cena[10]', '$cena[11]', '$cena[12]', '$cena[13]', '$cena[14]', '$cena[15]', '$cena[16]', '$cena[17]', '$cena[18]', '$cena[19]', '$cena[20]', '$cena[21]', '$cena[22]', '$cena[23]', '$cena[24]', '$cena[25]', '$cena[26]', '$cena[27]', '$cena[28]', 23, 'NIE', '$wycena_wstepna_nr', '$data_wyceny', '$user_wycena', '$data_waznosci_wyceny', '$wycena_wstepna_email', '$termin_realizacji', '$sposob_dostawy_wycena_wstepna', '$stopien_trudnosci');";

	mysqli_query($conn, $pytanie3);
	}



//zmieniam dane w bazie
if($etap == 2)
	{
	$SUMA_sztuki = 0;
	$SUMA_luki_pvc = 0;
	$SUMA_luki_stal = 0;
	$SUMA_luki_alu = 0;
	$SUMA_zgrzewy = 0;
	$SUMA_odwodnienia = 0;
	$SUMA_slupki = 0;
	$SUMA_slupki_ruchome = 0;
	$SUMA_okuwanie = 0;
	$SUMA_szklenie = 0;
	$SUMA_dociecie_listwy = 0;
	$SUMA_dociecie_kompletu_listew_przyszybowych = 0;
	// zapis danych do bazy

	//#######################     zmieniam cennik klienta 		 ######################
	if($zmienic_cennik_klienta == 'on')
		{
		echo '<div class="text_green" align="center">Cennik klienta został zmieniony.</div>';
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_ramy_z_pvc=".$nazwa_wygiecie_ramy_z_pvc_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_skrzydla_z_pvc=".$nazwa_wygiecie_skrzydla_z_pvc_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_listwy_z_pvc=".$nazwa_wygiecie_listwy_z_pvc_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_innego_elementu_z_pvc=".$nazwa_wygiecie_innego_elementu_z_pvc_cena[1]." WHERE id=".$klient.";");
		
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_ramy_z_alu=".$nazwa_wygiecie_ramy_z_alu_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_skrzydla_z_alu=".$nazwa_wygiecie_skrzydla_z_alu_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_listwy_z_alu=".$nazwa_wygiecie_listwy_z_alu_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_innego_elementu_z_alu=".$nazwa_wygiecie_innego_elementu_z_alu_cena[1]." WHERE id=".$klient.";");

		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_wzmocnienia_okiennego=".$nazwa_wygiecie_wzmocnienia_okiennego_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wygiecie_innego_elementu_ze_stali=".$nazwa_wygiecie_innego_elementu_ze_stali_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set zgrzanie=".$nazwa_zgrzanie_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wyfrezowanie_odwodnienia=".$nazwa_wyfrezowanie_odwodnienia_cena[1]." WHERE id=".$klient.";");

		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wstawienie_slupka=".$nazwa_wstawienie_slupka_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set dociecie_listwy_przyszybowej=".$nazwa_dociecie_listwy_przyszybowej_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set okucie=".$nazwa_okucie_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set zaszklenie=".$nazwa_zaszklenie_cena[1]." WHERE id=".$klient.";");
		
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wykonanie_innej_usługi=".$nazwa_wykonanie_innej_uslugi_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set oscieznica=".$nazwa_oscieznica_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set skrzydlo=".$nazwa_skrzydlo_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set listwa=".$nazwa_listwa_cena[1]." WHERE id=".$klient.";");

		$modyfikuj=mysqli_query($conn, "UPDATE klienci set slupek=".$nazwa_slupek_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wzmocnienie_do_ramy=".$nazwa_wzmocnienie_do_ramy_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wzmocnienie_do_skrzydla=".$nazwa_wzmocnienie_do_skrzydla_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wzmocnienie_do_slupka=".$nazwa_wzmocnienie_do_slupka_cena[1]." WHERE id=".$klient.";");

		$modyfikuj=mysqli_query($conn, "UPDATE klienci set wzmocnienie_do_luku=".$nazwa_wzmocnienie_do_luku_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set okucia=".$nazwa_okucia_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set szyby=".$nazwa_szyby_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci set inny_element=".$nazwa_inny_element_cena[1]." WHERE id=".$klient.";");		
		}

	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		// rozbicie daty faktury na time
		if($nazwa_data_faktury[$i] != '') 
			{
			//echo 'niepusty nr fv<br>';
			$pieces = explode("-", $nazwa_data_faktury[$i]);		
			$data_faktury_time[$i] = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
			$data_faktury_miesiac = $pieces[1];
			$data_faktury_rok = $pieces[2];
			if($data_faktury_miesiac != 10) $data_faktury_miesiac = zamien_dowolne_znaki($data_faktury_miesiac, '0', '');

			// if((eregi('\0', $data_faktury_miesiac)) && ($data_faktury_miesiac != 10)) $data_faktury_miesiac = str_replace("0", ";", $data_faktury_miesiac);
			///echo 'data_faktury_miesiac='.$data_faktury_miesiac.'<br>';
			}
		else
			{
			$nazwa_data_faktury[$i] = '';
			$data_faktury_time[$i] = '';
			$data_faktury_miesiac = '';
			$data_faktury_rok = '';
			}
			

		include ("php/wycena_dodatkowe_zabezpieczenie.php");

		// zamiana ewentualnych przecinków na kropki
		include ("php/wycena_zamiana_przecinkow_na_kropki.php");
		$SUMA_wartosc_netto = 0;
		$SUMA_wartosc_brutto = 0;

		if($wycena_wstepna_nr != '')
			{
			if($i == 1)	mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_checkbox_wygiecie_wzmocnienia = '".$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]."' WHERE id = ".$klient." ;");

			mysqli_query($conn, "UPDATE wyceny SET nr_faktury = '".$nazwa_nr_faktury[$i]."', data_faktury = '".$nazwa_data_faktury[$i]."', data_faktury_time = '".$data_faktury_time[$i]."', data_faktury_miesiac = '".$data_faktury_miesiac."', data_faktury_rok = '".$data_faktury_rok."', wygiecie_ramy_pvc_ilosc_szt = ".$nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i].", wygiecie_ramy_pvc_ilosc_m = ".$nazwa_wygiecie_ramy_z_pvc_ilosc_m[$i].", wygiecie_ramy_pvc_cena = ".$nazwa_wygiecie_ramy_z_pvc_cena[$i].", wygiecie_ramy_pvc_wartosc = ".$nazwa_wygiecie_ramy_z_pvc_wartosc[$i].", wygiecie_skrzydla_pvc_ilosc_szt = ".$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i].", wygiecie_skrzydla_pvc_ilosc_m = ".$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m[$i].", wygiecie_skrzydla_pvc_cena = ".$nazwa_wygiecie_skrzydla_z_pvc_cena[$i].", wygiecie_skrzydla_pvc_wartosc = ".$nazwa_wygiecie_skrzydla_z_pvc_wartosc[$i].", wygiecie_listwy_pvc_ilosc_szt = ".$nazwa_wygiecie_listwy_z_pvc_ilosc_szt[$i].", wygiecie_listwy_pvc_ilosc_m = ".$nazwa_wygiecie_listwy_z_pvc_ilosc_m[$i].", wygiecie_listwy_pvc_cena = ".$nazwa_wygiecie_listwy_z_pvc_cena[$i].", wygiecie_listwy_pvc_wartosc = ".$nazwa_wygiecie_listwy_z_pvc_wartosc[$i].", wygiecie_innego_pvc_ilosc_szt = ".$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i].", wygiecie_innego_pvc_ilosc_m = ".$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m[$i].", wygiecie_innego_pvc_cena = ".$nazwa_wygiecie_innego_elementu_z_pvc_cena[$i].", wygiecie_innego_pvc_wartosc = ".$nazwa_wygiecie_innego_elementu_z_pvc_wartosc[$i].", wygiecie_ramy_alu_ilosc_szt = ".$nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i].", wygiecie_ramy_alu_ilosc_m = ".$nazwa_wygiecie_ramy_z_alu_ilosc_m[$i].", wygiecie_ramy_alu_cena = ".$nazwa_wygiecie_ramy_z_alu_cena[$i].", wygiecie_ramy_alu_wartosc = ".$nazwa_wygiecie_ramy_z_alu_wartosc[$i].", wygiecie_skrzydla_alu_ilosc_szt = ".$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i].", wygiecie_skrzydla_alu_ilosc_m = ".$nazwa_wygiecie_skrzydla_z_alu_ilosc_m[$i].", wygiecie_skrzydla_alu_cena = ".$nazwa_wygiecie_skrzydla_z_alu_cena[$i].", wygiecie_skrzydla_alu_wartosc = ".$nazwa_wygiecie_skrzydla_z_alu_wartosc[$i].", wygiecie_listwy_alu_ilosc_szt = ".$nazwa_wygiecie_listwy_z_alu_ilosc_szt[$i].", wygiecie_listwy_alu_ilosc_m = ".$nazwa_wygiecie_listwy_z_alu_ilosc_m[$i].", wygiecie_listwy_alu_cena = ".$nazwa_wygiecie_listwy_z_alu_cena[$i].", wygiecie_listwy_alu_wartosc = ".$nazwa_wygiecie_listwy_z_alu_wartosc[$i].", wygiecie_innego_alu_ilosc_szt = ".$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i].", wygiecie_innego_alu_ilosc_m = ".$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m[$i].", wygiecie_innego_alu_cena = ".$nazwa_wygiecie_innego_elementu_z_alu_cena[$i].", wygiecie_innego_alu_wartosc = ".$nazwa_wygiecie_innego_elementu_z_alu_wartosc[$i].", wygiecie_wzmocnienia_okiennego_ilosc_szt = ".$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i].", wygiecie_wzmocnienia_okiennego_ilosc_m = ".$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m[$i].", wygiecie_wzmocnienia_okiennego_cena = ".$nazwa_wygiecie_wzmocnienia_okiennego_cena[$i].", wygiecie_wzmocnienia_okiennego_wartosc = ".$nazwa_wygiecie_wzmocnienia_okiennego_wartosc[$i].", wygiecie_innego_ilosc_szt = ".$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i].", wygiecie_innego_ilosc_m = ".$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m[$i].", wygiecie_innego_cena = ".$nazwa_wygiecie_innego_elementu_ze_stali_cena[$i].", wygiecie_innego_wartosc = ".$nazwa_wygiecie_innego_elementu_ze_stali_wartosc[$i].", zgrzanie_ilosc = ".$nazwa_zgrzanie_ilosc_m[$i].", zgrzanie_cena = ".$nazwa_zgrzanie_cena[$i].", zgrzanie_wartosc = ".$nazwa_zgrzanie_wartosc[$i].", wyfrezowanie_odwodnienia_ilosc = ".$nazwa_wyfrezowanie_odwodnienia_ilosc_m[$i].", wyfrezowanie_odwodnienia_cena = ".$nazwa_wyfrezowanie_odwodnienia_cena[$i].", wyfrezowanie_odwodnienia_wartosc = ".$nazwa_wyfrezowanie_odwodnienia_wartosc[$i].", wstawienie_slupka_ilosc = ".$nazwa_wstawienie_slupka_ilosc_m[$i].", wstawienie_slupka_cena = ".$nazwa_wstawienie_slupka_cena[$i].", wstawienie_slupka_wartosc = ".$nazwa_wstawienie_slupka_wartosc[$i].", listwa_przyszybowa_ilosc = ".$nazwa_dociecie_listwy_przyszybowej_ilosc_m[$i].", listwa_przyszybowa_cena = ".$nazwa_dociecie_listwy_przyszybowej_cena[$i].", listwa_przyszybowa_wartosc = ".$nazwa_dociecie_listwy_przyszybowej_wartosc[$i].", okucie_ilosc = ".$nazwa_okucie_ilosc_m[$i].", okucie_cena = ".$nazwa_okucie_cena[$i].", okucie_wartosc = ".$nazwa_okucie_wartosc[$i].", zaszklenie_ilosc = ".$nazwa_zaszklenie_ilosc_m[$i].", zaszklenie_cena = ".$nazwa_zaszklenie_cena[$i].", zaszklenie_wartosc = ".$nazwa_zaszklenie_wartosc[$i].", innej_uslugi_ilosc = ".$nazwa_wykonanie_innej_uslugi_ilosc_m[$i].", innej_uslugi_cena = ".$nazwa_wykonanie_innej_uslugi_cena[$i].", innej_uslugi_wartosc = ".$nazwa_wykonanie_innej_uslugi_wartosc[$i].", oscieznica_ilosc = ".$nazwa_oscieznica_ilosc_m[$i].", oscieznica_cena = ".$nazwa_oscieznica_cena[$i].", oscieznica_wartosc = ".$nazwa_oscieznica_wartosc[$i].", skrzydlo_ilosc = ".$nazwa_skrzydlo_ilosc_m[$i].", skrzydlo_cena = ".$nazwa_skrzydlo_cena[$i].", skrzydlo_wartosc = ".$nazwa_skrzydlo_wartosc[$i].", listwa_ilosc = ".$nazwa_listwa_ilosc_m[$i].", listwa_cena = ".$nazwa_listwa_cena[$i].", listwa_wartosc = ".$nazwa_listwa_wartosc[$i].", slupek_ilosc = ".$nazwa_slupek_ilosc_m[$i].", slupek_cena = ".$nazwa_slupek_cena[$i].", slupek_wartosc = ".$nazwa_slupek_wartosc[$i].", wzmocnienie_ramy_ilosc = ".$nazwa_wzmocnienie_do_ramy_ilosc_m[$i].", wzmocnienie_ramy_cena = ".$nazwa_wzmocnienie_do_ramy_cena[$i].", wzmocnienie_ramy_wartosc = ".$nazwa_wzmocnienie_do_ramy_wartosc[$i].", wzmocnienie_skrzydla_ilosc = ".$nazwa_wzmocnienie_do_skrzydla_ilosc_m[$i].", wzmocnienie_skrzydla_cena = ".$nazwa_wzmocnienie_do_skrzydla_cena[$i].", wzmocnienie_skrzydla_wartosc = ".$nazwa_wzmocnienie_do_skrzydla_wartosc[$i].", wzmocnienie_slupka_ilosc = ".$nazwa_wzmocnienie_do_slupka_ilosc_m[$i].", wzmocnienie_slupka_cena = ".$nazwa_wzmocnienie_do_slupka_cena[$i].", wzmocnienie_slupka_wartosc = ".$nazwa_wzmocnienie_do_slupka_wartosc[$i].", wzmocnienie_luku_ilosc = ".$nazwa_wzmocnienie_do_luku_ilosc_m[$i].", wzmocnienie_luku_cena = ".$nazwa_wzmocnienie_do_luku_cena[$i].", wzmocnienie_luku_wartosc = ".$nazwa_wzmocnienie_do_luku_wartosc[$i].", okucia_ilosc = ".$nazwa_okucia_ilosc_m[$i].", okucia_cena = ".$nazwa_okucia_cena[$i].", okucia_wartosc = ".$nazwa_okucia_wartosc[$i].", szyby_ilosc = ".$nazwa_szyby_ilosc_m[$i].", szyby_cena = ".$nazwa_szyby_cena[$i].", szyby_wartosc = ".$nazwa_szyby_wartosc[$i].", inny_element_ilosc = ".$nazwa_inny_element_ilosc_m[$i].", inny_element_cena = ".$nazwa_inny_element_cena[$i].", inny_element_wartosc = ".$nazwa_inny_element_wartosc[$i].", okna = ".$nazwa_okna_wartosc[$i].", drzwi_wewnetrzne = ".$nazwa_drzwi_wewnetrzne_wartosc[$i].", drzwi_zewnetrzne = ".$nazwa_drzwi_zewnetrzne_wartosc[$i].", bramy = ".$nazwa_bramy_wartosc[$i].", parapety = ".$nazwa_parapety_wartosc[$i].", rolety_zewnetrzne = ".$nazwa_rolety_zewnetrzne_wartosc[$i].", rolety_wewnetrzne = ".$nazwa_rolety_wewnetrzne_wartosc[$i].", moskitiery = ".$nazwa_moskitiery_wartosc[$i].", montaz = ".$nazwa_montaz_wartosc[$i].", odpady_pvc = ".$nazwa_odpady_z_pvc_wartosc[$i].", odpady_alu_stal = ".$nazwa_odpady_ze_stali_wartosc[$i].", transport = ".$nazwa_transport_wartosc[$i].", inne = ".$nazwa_inne_wartosc[$i].", nazwa_produktu = '".$nazwa_nazwa_produktu[$i]."', cena_netto_za_sztuke = ".$nazwa_cena_netto_za_sztuke[$i].", ilosc_sztuk = ".$nazwa_ilosc_sztuk[$i].", wartosc_netto = ".$nazwa_wartosc_netto[$i].", vat = '".$nazwa_vat[$i]."', checkbox_wygiecie_wzmocnienia = '".$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]."' , checkbox_wygiecie_skrzydla = '".$nazwa_wygiecie_skrzydla_ptaszek[$i]."' , checkbox_wygiecie_listwy = '".$nazwa_wygiecie_listwy_ptaszek[$i]."', wstawienie_slupka_ruchomego_ilosc = ".$nazwa_wstawienie_slupka_ruchomego_ilosc_m[$i]." , wstawienie_slupka_ruchomego_cena = ".$nazwa_wstawienie_slupka_ruchomego_cena[$i].", wstawienie_slupka_ruchomego_wartosc = ".$nazwa_wstawienie_slupka_ruchomego_wartosc[$i].", dociecie_kompletu_listew_przyszybowych_ilosc = ".$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m[$i]." , dociecie_kompletu_listew_przyszybowych_cena = ".$nazwa_dociecie_kompletu_listew_przyszybowych_cena[$i].", 
			dociecie_kompletu_listew_przyszybowych_wartosc = ".$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc[$i].", 
			stopien_trudnosci = ".$nazwa_stopien_trudnosci[$i]." 
			WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = ".$i.";");
			

			mysqli_query($conn, "UPDATE wyceny SET wartosc_brutto = ".$nazwa_wartosc_brutto[$i]." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = ".$i.";");
			mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET kwota_brutto = ".$nazwa_wartosc_brutto[$i]." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_wyceny = ".$i.";");
			mysqli_query($conn, "UPDATE wyceny SET uwagi = '".$nazwa_uwagi[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = ".$i.";");
			}
		else
			{
			//zwykła wycena do zamówienia
			mysqli_query($conn, "UPDATE wyceny SET nazwa_produktu = '".$nazwa_nazwa_produktu[$i]."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$i.";");

			if($i == 1)	mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_checkbox_wygiecie_wzmocnienia = '".$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]."' WHERE id = ".$klient." ;");

	
			mysqli_query($conn, "UPDATE wyceny SET checkbox_wygiecie_wzmocnienia = '".$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]."', cena_netto_za_sztuke = ".$nazwa_cena_netto_za_sztuke[$i].", ilosc_sztuk = ".$nazwa_ilosc_sztuk[$i].", wartosc_netto = ".$nazwa_wartosc_netto[$i].", vat = '".$nazwa_vat[$i]."', wartosc_brutto = ".$nazwa_wartosc_brutto[$i].", uwagi = '".$nazwa_uwagi[$i]."', nr_faktury = '".$nazwa_nr_faktury[$i]."', data_faktury = '".$nazwa_data_faktury[$i]."', data_faktury_time = '".$data_faktury_time[$i]."', data_faktury_miesiac = '".$data_faktury_miesiac."', data_faktury_rok = '".$data_faktury_rok."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$i.";");


			$sql = "UPDATE wyceny SET wygiecie_ramy_pvc_ilosc_szt = ".$nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i].", wygiecie_ramy_pvc_ilosc_m = ".$nazwa_wygiecie_ramy_z_pvc_ilosc_m[$i].", wygiecie_ramy_pvc_cena = ".$nazwa_wygiecie_ramy_z_pvc_cena[$i].", wygiecie_ramy_pvc_wartosc = ".$nazwa_wygiecie_ramy_z_pvc_wartosc[$i].", wygiecie_skrzydla_pvc_ilosc_szt = ".$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i].", wygiecie_skrzydla_pvc_ilosc_m = ".$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m[$i].", wygiecie_skrzydla_pvc_cena = ".$nazwa_wygiecie_skrzydla_z_pvc_cena[$i].", wygiecie_skrzydla_pvc_wartosc = ".$nazwa_wygiecie_skrzydla_z_pvc_wartosc[$i].", checkbox_wygiecie_skrzydla = '".$nazwa_wygiecie_skrzydla_ptaszek[$i]."', wygiecie_listwy_pvc_ilosc_szt = ".$nazwa_wygiecie_listwy_z_pvc_ilosc_szt[$i].", wygiecie_listwy_pvc_ilosc_m = ".$nazwa_wygiecie_listwy_z_pvc_ilosc_m[$i].", wygiecie_listwy_pvc_cena = ".$nazwa_wygiecie_listwy_z_pvc_cena[$i].", wygiecie_listwy_pvc_wartosc = ".$nazwa_wygiecie_listwy_z_pvc_wartosc[$i].", checkbox_wygiecie_listwy = '".$nazwa_wygiecie_listwy_ptaszek[$i]."', wygiecie_innego_pvc_ilosc_szt = ".$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i].", wygiecie_innego_pvc_ilosc_m = ".$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m[$i].", wygiecie_innego_pvc_cena = ".$nazwa_wygiecie_innego_elementu_z_pvc_cena[$i].", wygiecie_innego_pvc_wartosc = ".$nazwa_wygiecie_innego_elementu_z_pvc_wartosc[$i].", wygiecie_ramy_alu_ilosc_szt = ".$nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i].", wygiecie_ramy_alu_ilosc_m = ".$nazwa_wygiecie_ramy_z_alu_ilosc_m[$i].", wygiecie_ramy_alu_cena = ".$nazwa_wygiecie_ramy_z_alu_cena[$i].", wygiecie_ramy_alu_wartosc = ".$nazwa_wygiecie_ramy_z_alu_wartosc[$i].", wygiecie_skrzydla_alu_ilosc_szt = ".$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i].", wygiecie_skrzydla_alu_ilosc_m = ".$nazwa_wygiecie_skrzydla_z_alu_ilosc_m[$i].", wygiecie_skrzydla_alu_cena = ".$nazwa_wygiecie_skrzydla_z_alu_cena[$i].", wygiecie_skrzydla_alu_wartosc = ".$nazwa_wygiecie_skrzydla_z_alu_wartosc[$i].", wygiecie_listwy_alu_ilosc_szt = ".$nazwa_wygiecie_listwy_z_alu_ilosc_szt[$i].", wygiecie_listwy_alu_ilosc_m = ".$nazwa_wygiecie_listwy_z_alu_ilosc_m[$i].", wygiecie_listwy_alu_cena = ".$nazwa_wygiecie_listwy_z_alu_cena[$i].", wygiecie_listwy_alu_wartosc = ".$nazwa_wygiecie_listwy_z_alu_wartosc[$i].", wygiecie_innego_alu_ilosc_szt = ".$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i].", wygiecie_innego_alu_ilosc_m = ".$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m[$i].", wygiecie_innego_alu_cena = ".$nazwa_wygiecie_innego_elementu_z_alu_cena[$i].", wygiecie_innego_alu_wartosc = ".$nazwa_wygiecie_innego_elementu_z_alu_wartosc[$i].", wygiecie_wzmocnienia_okiennego_ilosc_szt = ".$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i].", wygiecie_wzmocnienia_okiennego_ilosc_m = ".$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m[$i].", wygiecie_wzmocnienia_okiennego_cena = ".$nazwa_wygiecie_wzmocnienia_okiennego_cena[$i].", wygiecie_wzmocnienia_okiennego_wartosc = ".$nazwa_wygiecie_wzmocnienia_okiennego_wartosc[$i].", wygiecie_innego_ilosc_szt = ".$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i].", wygiecie_innego_ilosc_m = ".$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m[$i].", wygiecie_innego_cena = ".$nazwa_wygiecie_innego_elementu_ze_stali_cena[$i].", wygiecie_innego_wartosc = ".$nazwa_wygiecie_innego_elementu_ze_stali_wartosc[$i].", zgrzanie_ilosc = ".$nazwa_zgrzanie_ilosc_m[$i].", zgrzanie_cena = ".$nazwa_zgrzanie_cena[$i].", zgrzanie_wartosc = ".$nazwa_zgrzanie_wartosc[$i].", wyfrezowanie_odwodnienia_ilosc = ".$nazwa_wyfrezowanie_odwodnienia_ilosc_m[$i].", wyfrezowanie_odwodnienia_cena = ".$nazwa_wyfrezowanie_odwodnienia_cena[$i].", wyfrezowanie_odwodnienia_wartosc = ".$nazwa_wyfrezowanie_odwodnienia_wartosc[$i].", wstawienie_slupka_ilosc = ".$nazwa_wstawienie_slupka_ilosc_m[$i].", wstawienie_slupka_cena = ".$nazwa_wstawienie_slupka_cena[$i].", wstawienie_slupka_wartosc = ".$nazwa_wstawienie_slupka_wartosc[$i].", wstawienie_slupka_ruchomego_ilosc = ".$nazwa_wstawienie_slupka_ruchomego_ilosc_m[$i].", wstawienie_slupka_ruchomego_cena = ".$nazwa_wstawienie_slupka_ruchomego_cena[$i].", wstawienie_slupka_ruchomego_wartosc = ".$nazwa_wstawienie_slupka_ruchomego_wartosc[$i].", listwa_przyszybowa_ilosc = ".$nazwa_dociecie_listwy_przyszybowej_ilosc_m[$i].", listwa_przyszybowa_cena = ".$nazwa_dociecie_listwy_przyszybowej_cena[$i].", listwa_przyszybowa_wartosc = ".$nazwa_dociecie_listwy_przyszybowej_wartosc[$i].", dociecie_kompletu_listew_przyszybowych_ilosc = ".$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m[$i].", dociecie_kompletu_listew_przyszybowych_cena = ".$nazwa_dociecie_kompletu_listew_przyszybowych_cena[$i].", dociecie_kompletu_listew_przyszybowych_wartosc = ".$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc[$i].", okucie_ilosc = ".$nazwa_okucie_ilosc_m[$i].", okucie_cena = ".$nazwa_okucie_cena[$i].", okucie_wartosc = ".$nazwa_okucie_wartosc[$i].", zaszklenie_ilosc = ".$nazwa_zaszklenie_ilosc_m[$i].", zaszklenie_cena = ".$nazwa_zaszklenie_cena[$i].", zaszklenie_wartosc = ".$nazwa_zaszklenie_wartosc[$i].", innej_uslugi_ilosc = ".$nazwa_wykonanie_innej_uslugi_ilosc_m[$i].", innej_uslugi_cena = ".$nazwa_wykonanie_innej_uslugi_cena[$i].", innej_uslugi_wartosc = ".$nazwa_wykonanie_innej_uslugi_wartosc[$i].", oscieznica_ilosc = ".$nazwa_oscieznica_ilosc_m[$i].", oscieznica_cena = ".$nazwa_oscieznica_cena[$i].", oscieznica_wartosc = ".$nazwa_oscieznica_wartosc[$i].", skrzydlo_ilosc = ".$nazwa_skrzydlo_ilosc_m[$i].", skrzydlo_cena = ".$nazwa_skrzydlo_cena[$i].", skrzydlo_wartosc = ".$nazwa_skrzydlo_wartosc[$i].", listwa_ilosc = ".$nazwa_listwa_ilosc_m[$i].", listwa_cena = ".$nazwa_listwa_cena[$i].", listwa_wartosc = ".$nazwa_listwa_wartosc[$i].", slupek_ilosc = ".$nazwa_slupek_ilosc_m[$i].", slupek_cena = ".$nazwa_slupek_cena[$i].", slupek_wartosc = ".$nazwa_slupek_wartosc[$i].", wzmocnienie_ramy_ilosc = ".$nazwa_wzmocnienie_do_ramy_ilosc_m[$i].", wzmocnienie_ramy_cena = ".$nazwa_wzmocnienie_do_ramy_cena[$i].", wzmocnienie_ramy_wartosc = ".$nazwa_wzmocnienie_do_ramy_wartosc[$i].", wzmocnienie_skrzydla_ilosc = ".$nazwa_wzmocnienie_do_skrzydla_ilosc_m[$i].", wzmocnienie_skrzydla_cena = ".$nazwa_wzmocnienie_do_skrzydla_cena[$i].", wzmocnienie_skrzydla_wartosc = ".$nazwa_wzmocnienie_do_skrzydla_wartosc[$i].", wzmocnienie_slupka_ilosc = ".$nazwa_wzmocnienie_do_slupka_ilosc_m[$i].", wzmocnienie_slupka_cena = ".$nazwa_wzmocnienie_do_slupka_cena[$i].", wzmocnienie_slupka_wartosc = ".$nazwa_wzmocnienie_do_slupka_wartosc[$i].", wzmocnienie_luku_ilosc = ".$nazwa_wzmocnienie_do_luku_ilosc_m[$i].", wzmocnienie_luku_cena = ".$nazwa_wzmocnienie_do_luku_cena[$i].", wzmocnienie_luku_wartosc = ".$nazwa_wzmocnienie_do_luku_wartosc[$i].", okucia_ilosc = ".$nazwa_okucia_ilosc_m[$i].", okucia_cena = ".$nazwa_okucia_cena[$i].", okucia_wartosc = ".$nazwa_okucia_wartosc[$i].", szyby_ilosc = ".$nazwa_szyby_ilosc_m[$i].", szyby_cena = ".$nazwa_szyby_cena[$i].", szyby_wartosc = ".$nazwa_szyby_wartosc[$i].", inny_element_ilosc = ".$nazwa_inny_element_ilosc_m[$i].", inny_element_cena = ".$nazwa_inny_element_cena[$i].", inny_element_wartosc = ".$nazwa_inny_element_wartosc[$i].", okna = ".$nazwa_okna_wartosc[$i].", drzwi_wewnetrzne = ".$nazwa_drzwi_wewnetrzne_wartosc[$i].", drzwi_zewnetrzne = ".$nazwa_drzwi_zewnetrzne_wartosc[$i].", bramy = ".$nazwa_bramy_wartosc[$i].", parapety = ".$nazwa_parapety_wartosc[$i].", rolety_zewnetrzne = ".$nazwa_rolety_zewnetrzne_wartosc[$i].", rolety_wewnetrzne = ".$nazwa_rolety_wewnetrzne_wartosc[$i].", moskitiery = ".$nazwa_moskitiery_wartosc[$i].", montaz = ".$nazwa_montaz_wartosc[$i].", odpady_pvc = ".$nazwa_odpady_z_pvc_wartosc[$i].", odpady_alu_stal = ".$nazwa_odpady_ze_stali_wartosc[$i].", transport = ".$nazwa_transport_wartosc[$i].", inne = ".$nazwa_inne_wartosc[$i].", stopien_trudnosci = ".$nazwa_stopien_trudnosci[$i]."  WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$i.";";
			

			mysqli_query($conn, $sql);

			mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET kwota_brutto = ".$nazwa_wartosc_brutto[$i]." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_wyceny = ".$i.";");

	

			//obliczanie sztuk itp dla bazy zamowienia
			$SUMA_sztuki += $nazwa_ilosc_sztuk[$i];
			$SUMA_luki_pvc = $SUMA_luki_pvc + $nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i] + $nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i] + $nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i];
			$SUMA_luki_stal = $SUMA_luki_stal + $nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i] + $nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i];
			$SUMA_luki_alu = $SUMA_luki_alu + $nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i] + $nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i] + $nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i];
			$SUMA_zgrzewy += $nazwa_zgrzanie_ilosc_m[$i];
			$SUMA_slupki += $nazwa_wstawienie_slupka_ilosc_m[$i];
			$SUMA_odwodnienia += $nazwa_wyfrezowanie_odwodnienia_ilosc_m[$i];
			$SUMA_dociecie_listwy += $nazwa_dociecie_listwy_przyszybowej_ilosc_m[$i];
			$SUMA_szklenie += $nazwa_zaszklenie_ilosc_m[$i];
			$SUMA_okuwanie += $nazwa_okucie_ilosc_m[$i];
			$SUMA_slupki_ruchome += $nazwa_wstawienie_slupka_ruchomego_ilosc_m[$i];
			$SUMA_dociecie_kompletu_listew_przyszybowych += $nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m[$i];

			$SUMA_wartosc_netto += $nazwa_wartosc_netto[$i];
			$SUMA_wartosc_brutto += $nazwa_wartosc_brutto[$i];
			}// do else wycena_wstepna_nr
		
		} // do for($i = 1; $i <= $ilosc_pozycji; $i++
	//dla wyceny

	// echo '1 pozycja_transport='.$pozycja_transport.'<br>';
	if(($pozycja_transport == 'tak') && ($wycena_wstepna_nr == ''))
		{
		// rozbicie daty faktury na time
		$ilosc_pozycji++;
		//echo '<br><br>';
		//echo '$nazwa_data_faktury['.$ilosc_pozycji.']='.$nazwa_data_faktury[$ilosc_pozycji].'<br>';
		//echo '$ilosc_pozycji'.$ilosc_pozycji.'<br>';
		if($nazwa_data_faktury[$ilosc_pozycji] != '') 
			{
			$pieces = explode("-", $nazwa_data_faktury[$ilosc_pozycji]);		
			$data_faktury_time[$ilosc_pozycji] = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
			$data_faktury_miesiac = $pieces[1];
			$data_faktury_rok = $pieces[2];
			if($data_faktury_miesiac != 10) $data_faktury_miesiac = zamien_dowolne_znaki($data_faktury_miesiac, '0', '');
			// if((eregi('\0', $data_faktury_miesiac)) && ($data_faktury_miesiac != 10)) $data_faktury_miesiac = str_replace("0", ";", $data_faktury_miesiac);
			}
			
		$SUMA_wartosc_netto += $nazwa_wartosc_netto_pozycja_transport;
		$SUMA_wartosc_brutto += $nazwa_wartosc_brutto_pozycja_transport;
		//echo '$nazwa_data_faktury['.$ilosc_pozycji.']='.$nazwa_data_faktury[$ilosc_pozycji].'<br>';
		//echo '$nazwa_nr_faktury[$ilosc_pozycji]='.$nazwa_nr_faktury[$ilosc_pozycji].'<br>';

		mysqli_query($conn, "UPDATE wyceny SET data_faktury_time = '".$data_faktury_time[$ilosc_pozycji]."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET data_faktury = '".$nazwa_data_faktury[$ilosc_pozycji]."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET data_faktury_miesiac = '".$data_faktury_miesiac."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET data_faktury_rok = '".$data_faktury_rok."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET nr_faktury = '".$nazwa_nr_faktury[$ilosc_pozycji]."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$ilosc_pozycji.";");
		mysqli_query($conn, "UPDATE wyceny SET transport = ".$nazwa_pozycja_transport_wartosc." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET wartosc_netto = ".$nazwa_wartosc_netto_pozycja_transport." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET vat = '".$nazwa_vat_pozycja_transport."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET wartosc_brutto = ".$nazwa_wartosc_brutto_pozycja_transport." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_transport = 'tak';");

		mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET kwota_brutto = ".$nazwa_wartosc_brutto_pozycja_transport." WHERE zamowienie_id = ".$zamowienie_id." AND pozycja_wyceny = ".$i.";");
		}
	elseif(($pozycja_transport == 'tak') && ($wycena_wstepna_nr != ''))
		{
		// dla WYCENY WSTEPNEJ
		// rozbicie daty faktury na time
		$ilosc_pozycji++;
			
		mysqli_query($conn, "UPDATE wyceny SET transport = ".$nazwa_pozycja_transport_wartosc." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET wartosc_netto = ".$nazwa_wartosc_netto_pozycja_transport." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET vat = '".$nazwa_vat_pozycja_transport."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'tak';");
		mysqli_query($conn, "UPDATE wyceny SET wartosc_brutto = ".$nazwa_wartosc_brutto_pozycja_transport." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'tak';");
		}

		
		//sprawdzanie czy zmienia sie kwota na wystawionej juz fakturze
		$ilosc_fv_do_wygenerowania = 0;
		$lista_fv_do_wygenerowania[0] = '';
		for($i = 1; $i <= $ilosc_pozycji; $i++)
			{
			if($nazwa_nr_faktury[$i] != '')
				{
				$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE nr_dok = '".$nazwa_nr_faktury[$i]."';");
				while($wynik2= mysqli_fetch_assoc($pytanie2))
					{
					$fv_id=$wynik2['id'];
					}
				$pytanie27 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE nr_fv = '".$nazwa_nr_faktury[$i]."' AND pozycja = ".$i.";");
				while($wynik27= mysqli_fetch_assoc($pytanie27))
					{
					$wartosc_brutto_pozycja_z_faktury[$i]=$wynik27['wartosc_brutto'];
					$nazwa_produktu_pozycja_z_faktury[$i]=$wynik27['nazwa_produktu'];
					$ilosc_pozycja_z_faktury[$i]=$wynik27['ilosc'];
					$vat_pozycja_z_faktury[$i]=$wynik27['vat'];
					}
				if(($nazwa_produktu_pozycja_z_faktury[$i] != $nazwa_nazwa_produktu[$i]) || ($ilosc_pozycja_z_faktury[$i] != $nazwa_ilosc_sztuk[$i]) || ($vat_pozycja_z_faktury[$i] != $nazwa_vat[$i]) || ($wartosc_brutto_pozycja_z_faktury[$i] != $nazwa_wartosc_brutto[$i]))
					{
					//sprawdzamy czy jjuz wpis z nr faktury nie istnieje w bazie
					if(array_search($nazwa_nr_faktury[$i], $lista_fv_do_wygenerowania) == false) 
						{
						$ilosc_fv_do_wygenerowania++;
						$lista_fv_do_wygenerowania[$ilosc_fv_do_wygenerowania] = $nazwa_nr_faktury[$i];
						}
					} // do if(($nazwa_produktu_pozycja_z_faktury[$i] != $naz
				} /// if($nazwa_nr_faktury[$i] != '')
			} //for($i = 1; $i <= $ilosc_pozycji; $i++)
			
			//#############################################################################################################################################
			// ###############################################      generowanie nowych faktur     #########################################################
			//#############################################################################################################################################
			//echo 'ilosc_fv_do_wygenerowania='.$ilosc_fv_do_wygenerowania.'<br><br>';
			for($i = 1; $i <= $ilosc_fv_do_wygenerowania; $i++) 
				{
				// echo 'fv='.$lista_fv_do_wygenerowania[$i].'<br>';
				$ilosc_pozycji_na_fv = 0;
				$pytanie20 = mysqli_query($conn, "SELECT * FROM wyceny WHERE nr_faktury = '".$lista_fv_do_wygenerowania[$i]."' ORDER BY pozycja ASC;");
				while($wynik20= mysqli_fetch_assoc($pytanie20))
					{
					$ilosc_pozycji_na_fv++;
					$wartosc_netto_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['wartosc_netto'];
					$wartosc_brutto_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['wartosc_brutto'];
					$vat_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['vat'];
					$ilosc_sztuk_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['ilosc_sztuk'];
					$cena_netto_za_sztuke_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['cena_netto_za_sztuke'];
					$nazwa_produktu_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['nazwa_produktu'];
					$pozycja_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['pozycja'];
					$pozycja_transport_z_wyceny[$ilosc_pozycji_na_fv]=$wynik20['pozycja_transport'];
					if($pozycja_transport_z_wyceny[$ilosc_pozycji_na_fv] == 'tak') 
						{
						$nazwa_produktu_z_wyceny[$ilosc_pozycji_na_fv] = 'Transport';
						$cena_netto_za_sztuke_z_wyceny[$ilosc_pozycji_na_fv]=$wartosc_netto_z_wyceny[$ilosc_pozycji_na_fv];
						$ilosc_sztuk_z_wyceny[$ilosc_pozycji_na_fv]=1;
						}
					}
				$SUMA_NETTO = 0;
				$SUMA_BRUTTO = 0;
				// echo '$ilosc_pozycji_na_fv='.$ilosc_pozycji_na_fv.'<br>';
				
				for($m = 1; $m <= $ilosc_pozycji_na_fv; $m++)
					{ 
					$SUMA_NETTO += $wartosc_netto_z_wyceny[$m];
					$SUMA_BRUTTO += $wartosc_brutto_z_wyceny[$m];
				
					$cena_brutto_za_sztuke[$m] = $cena_netto_za_sztuke_z_wyceny[$m] + ($cena_netto_za_sztuke_z_wyceny[$m] * $vat_z_wyceny[$m]/100);
					$cena_brutto_za_sztuke[$m] = number_format($cena_brutto_za_sztuke[$m], 2,'.','');

					$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.','');
					$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
	
					$data = date('d-m-Y', $time);
					$data_rok = date('Y', $time);
					$data_miesiac = date('m', $time);
					$SQL = [];
					//tresc zapytan
					$SQL[1] = "UPDATE fv_pozycje set nazwa_produktu = '".$nazwa_produktu_z_wyceny[$m]."' WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					$SQL[2] = "UPDATE fv_pozycje set ilosc = ".$ilosc_sztuk_z_wyceny[$m]." WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					$SQL[3] = "UPDATE fv_pozycje set cena_netto = ".$cena_netto_za_sztuke_z_wyceny[$m]." WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					$SQL[4] = "UPDATE fv_pozycje set vat = '".$vat_z_wyceny[$m]."' WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					$SQL[5] = "UPDATE fv_pozycje set cena_brutto = ".$cena_brutto_za_sztuke[$m]." WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					$SQL[6] = "UPDATE fv_pozycje set wartosc_netto = ".$wartosc_netto_z_wyceny[$m]." WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					$SQL[7] = "UPDATE fv_pozycje set wartosc_brutto = ".$wartosc_brutto_z_wyceny[$m]." WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' AND pozycja = ".$pozycja_z_wyceny[$m].";";
					
					$SQL[8] = "UPDATE fv_naglowek set wartosc_netto_fv = ".$SUMA_NETTO." WHERE nr_dok = '".$lista_fv_do_wygenerowania[$i]."';";
					$SQL[9] = "UPDATE fv_naglowek set wartosc_brutto_fv = ".$SUMA_BRUTTO." WHERE nr_dok = '".$lista_fv_do_wygenerowania[$i]."';";
					$SQL[10] = "UPDATE fv_naglowek set user_nazwisko = '".$user_nazwisko."' WHERE nr_dok = '".$lista_fv_do_wygenerowania[$i]."';";
					$SQL[11] = "UPDATE fv_naglowek set user_imie = '".$user_imie."' WHERE nr_dok = '".$lista_fv_do_wygenerowania[$i]."';";

					//wykonanie zapytan
					for($s=1; $s<=11; $s++) mysqli_query($conn, $SQL[$s]);


					$pytanie247 = mysqli_query($conn, "SELECT vat FROM fv_pozycje WHERE nr_fv = '".$lista_fv_do_wygenerowania[$i]."' ORDER BY pozycja ASC LIMIT 1;");
					while($wynik247= mysqli_fetch_assoc($pytanie247))
						$vat_dla_pierwszej_pozycji=$wynik247['vat'];

					$sql = "UPDATE fv_naglowek set vat = '".$vat_dla_pierwszej_pozycji."' WHERE nr_dok = '".$lista_fv_do_wygenerowania[$i]."';";
					mysqli_query($conn, $sql);

					}
				$pytanie1247 = mysqli_query($conn, "SELECT id, nazwa_pliku, nr_dok FROM fv_naglowek WHERE nr_dok = '".$lista_fv_do_wygenerowania[$i]."';");
				while($wynik1247= mysqli_fetch_assoc($pytanie1247))
					{
					//echo 'mam id i link<br>';
					$fv_id=$wynik1247['id'];
					$nazwa_pliku=$wynik1247['nazwa_pliku'];
					}
				//echo 'fv_id='.$fv_id.'<br>';
				//echo 'nazwa_pliku='.$nazwa_pliku.'<br>';
				
				include('php/generuj_fakture.php');
				
				echo '<table border="0" width="600px" class="text" align="center"><tr valign="middle">';
				echo '<td class="text_duzy_niebieski" align="right" width="70%">Wydrukuj fakturę '.$lista_fv_do_wygenerowania[$i].'</td>';
				// adres_serwera_do_faktur zapisane jest w connection.php
				echo '<td align="left" width="30%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a></td>';
				echo '</tr></table>';
				} // for($i = 1; $i <= $ilosc_fv_do_wygenerowania; $i++) 
		



	//zmiana danych dla bazy zamwienia
	$SUMA_wartosc_netto = change($SUMA_wartosc_netto);
	$SUMA_wartosc_brutto = change($SUMA_wartosc_brutto);

	mysqli_query($conn, "UPDATE zamowienia SET sztuki = ".$SUMA_sztuki.", luki_pvc = ".$SUMA_luki_pvc.", luki_stal = ".$SUMA_luki_stal.", luki_alu = ".$SUMA_luki_alu.", zgrzewy = ".$SUMA_zgrzewy.", odwodnienia = ".$SUMA_odwodnienia.", slupki = ".$SUMA_slupki.", okuwanie = ".$SUMA_okuwanie.", szklenie = ".$SUMA_szklenie.", dociecie_listwy = ".$SUMA_dociecie_listwy.", slupek_ruchomy = ".$SUMA_slupki_ruchome.", komplet_listew = ".$SUMA_dociecie_kompletu_listew_przyszybowych.", wartosc_netto = ".$SUMA_wartosc_netto.", wartosc_brutto = ".$SUMA_wartosc_brutto." WHERE id = ".$zamowienie_id.";");


	echo '<br><div class="text_duzy_niebieski" align="center">Dane wyceny zmienione.</div>';
	if($skad == 'zlecenie_transportowe') echo $powrot_do_konkretnego_zlecenia_transportowego_edycja;
	if($wycena_wstepna_nr != '') echo $powrot_do_wycen_wstepnej;
	else 
		{
		echo $powrot_do_wyceny;
		echo $powrot_do_konkretnego_zamowienia;
		echo $powrot_do_wysortowanych_zamowien;
		echo $powrot_do_rejestru_zamowien;
		}
	}
else
	{
	$SUMA_NETTO = 0;
	$SUMA_BRUTTO = 0;
	$ilosc_pozycji = 0;
	$ilosc_pozycji_z_faktura = 0;
	$zapisz_disabled_licz = 0;

	//########################################################################################################################################################################################
	//###################################################        wycena_wstepna_nr      ######################################################################################################
	//########################################################################################################################################################################################
	// szukamy ilosc pozycji w wycenie, zapobiegamy bdowi ktry pokazywa trzy takie same pozycje
	if($wycena_wstepna_nr != '') $pytanie = mysqli_query($conn, "SELECT ilosc_pozycji FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."';");
	else $pytanie = mysqli_query($conn, "SELECT ilosc_pozycji FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		$calkowita_ilosc_pozycji=$wynik['ilosc_pozycji'];
	
		// if($zalogowany_user == 1) echo "memory_get_usage before: " . memory_get_usage() . "<br>";

		include("php/wyceny_deklaracja_pustych_tablic.php");


	if($wycena_wstepna_nr != '') $pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' ORDER BY pozycja ASC LIMIT ".$calkowita_ilosc_pozycji.";");
	else $pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' ORDER BY pozycja ASC LIMIT ".$calkowita_ilosc_pozycji.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji++;
		$klient_id=$wynik['klient_id'];
		$klient_nazwa=$wynik['klient_nazwa'];
		$nr_zamowienia=$wynik['nr_zamowienia'];
		$pozycja[$ilosc_pozycji]=$wynik['pozycja'];
		$pozycja_id[$ilosc_pozycji]=$wynik['id'];
		$pozycja_transport[$ilosc_pozycji]=$wynik['pozycja_transport'];

		$wygiecie_ramy_pvc_cena[$ilosc_pozycji] = number_format($wynik['wygiecie_ramy_pvc_cena'], 2,'.','');
		$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji] = number_format($wynik['wygiecie_ramy_pvc_wartosc'], 2,'.','');
		$wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji] = number_format($wynik['wygiecie_ramy_pvc_ilosc_szt'], 2,'.','');
		$wygiecie_ramy_pvc_ilosc_m[$ilosc_pozycji] = number_format($wynik['wygiecie_ramy_pvc_ilosc_m'], 2,'.','');
		
		$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_ilosc_szt'];
		$wygiecie_skrzydla_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_ilosc_m'];
		$wygiecie_skrzydla_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_cena'];
		$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_wartosc'];
		$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_pvc_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji], 2,'.','');
		$checkbox_wygiecie_skrzydla[$ilosc_pozycji] = $wynik['checkbox_wygiecie_skrzydla'];

		$wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_ilosc_szt'];
		$wygiecie_listwy_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_ilosc_m'];
		$wygiecie_listwy_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_cena'];
		$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_wartosc'];
		$wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_pvc_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_listwy_pvc_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_listwy_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_listwy_pvc_wartosc[$ilosc_pozycji], 2,'.','');
		$checkbox_wygiecie_listwy[$ilosc_pozycji] = $wynik['checkbox_wygiecie_listwy'];
		
		$wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_ilosc_szt'];
		$wygiecie_innego_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_ilosc_m'];
		$wygiecie_innego_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_cena'];
		$wygiecie_innego_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_wartosc'];
		$wygiecie_innego_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_innego_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_innego_pvc_wartosc[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_pvc_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_innego_pvc_ilosc_m[$ilosc_pozycji], 2,'.','');

		$wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_ilosc_szt'];
		$wygiecie_ramy_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_ilosc_m'];
		$wygiecie_ramy_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_cena'];
		$wygiecie_ramy_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_wartosc'];
		$wygiecie_ramy_alu_cena[$ilosc_pozycji] = number_format($wygiecie_ramy_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_ramy_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_ramy_alu_wartosc[$ilosc_pozycji], 2,'.','');
		$wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_ramy_alu_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_ramy_alu_ilosc_m[$ilosc_pozycji], 2,'.','');

		$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_ilosc_szt'];
		$wygiecie_skrzydla_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_ilosc_m'];
		$wygiecie_skrzydla_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_cena'];
		$wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_wartosc'];
		$wygiecie_skrzydla_alu_cena[$ilosc_pozycji] = number_format($wygiecie_skrzydla_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_alu_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_skrzydla_alu_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji], 2,'.','');
		
		$wygiecie_listwy_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_ilosc_szt'];
		$wygiecie_listwy_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_ilosc_m'];
		$wygiecie_listwy_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_cena'];
		$wygiecie_listwy_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_wartosc'];
		$wygiecie_listwy_alu_cena[$ilosc_pozycji] = number_format($wygiecie_listwy_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_alu_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_listwy_alu_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_alu_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_listwy_alu_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_listwy_alu_wartosc[$ilosc_pozycji], 2,'.','');
	
		$wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_ilosc_szt'];
		$wygiecie_innego_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_ilosc_m'];
		$wygiecie_innego_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_cena'];
		$wygiecie_innego_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_wartosc'];
		$wygiecie_innego_alu_cena[$ilosc_pozycji] = number_format($wygiecie_innego_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_alu_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_innego_alu_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_innego_alu_wartosc[$ilosc_pozycji], 2,'.','');
		
		$wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
		$wygiecie_wzmocnienia_okiennego_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_ilosc_m'];
		$wygiecie_wzmocnienia_okiennego_cena[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_cena'];
		$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_wartosc'];
		$wygiecie_wzmocnienia_okiennego_cena[$ilosc_pozycji] = number_format($wygiecie_wzmocnienia_okiennego_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_wzmocnienia_okiennego_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_wzmocnienia_okiennego_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji] = number_format($wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji], 2,'.','');
		$checkbox_wygiecie_wzmocnienia[$ilosc_pozycji] = $wynik['checkbox_wygiecie_wzmocnienia'];

		$wygiecie_innego_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_innego_ilosc_szt'];
		$wygiecie_innego_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_innego_ilosc_m'];
		$wygiecie_innego_cena[$ilosc_pozycji]=$wynik['wygiecie_innego_cena'];
		$wygiecie_innego_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_wartosc'];
		$wygiecie_innego_cena[$ilosc_pozycji] = number_format($wygiecie_innego_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_ilosc_szt[$ilosc_pozycji] = number_format($wygiecie_innego_ilosc_szt[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_ilosc_m[$ilosc_pozycji] = number_format($wygiecie_innego_ilosc_m[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_wartosc[$ilosc_pozycji] = number_format($wygiecie_innego_wartosc[$ilosc_pozycji], 2,'.','');

		$zgrzanie_ilosc[$ilosc_pozycji]=$wynik['zgrzanie_ilosc'];
		$zgrzanie_cena[$ilosc_pozycji]=$wynik['zgrzanie_cena'];
		$zgrzanie_wartosc[$ilosc_pozycji]=$wynik['zgrzanie_wartosc'];
		$zgrzanie_cena[$ilosc_pozycji] = number_format($zgrzanie_cena[$ilosc_pozycji], 2,'.','');
		$zgrzanie_ilosc[$ilosc_pozycji] = number_format($zgrzanie_ilosc[$ilosc_pozycji], 2,'.','');
		$zgrzanie_wartosc[$ilosc_pozycji] = number_format($zgrzanie_wartosc[$ilosc_pozycji], 2,'.','');

		$wyfrezowanie_odwodnienia_ilosc[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_ilosc'];
		$wyfrezowanie_odwodnienia_cena[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_cena'];
		$wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_wartosc'];
		$wyfrezowanie_odwodnienia_ilosc[$ilosc_pozycji] = number_format($wyfrezowanie_odwodnienia_ilosc[$ilosc_pozycji], 2,'.','');
		$wyfrezowanie_odwodnienia_cena[$ilosc_pozycji] = number_format($wyfrezowanie_odwodnienia_cena[$ilosc_pozycji], 2,'.','');
		$wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji] = number_format($wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji], 2,'.','');

		$wstawienie_slupka_ilosc[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ilosc'], 2,'.','');
		$wstawienie_slupka_cena[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_cena'], 2,'.','');
		$wstawienie_slupka_wartosc[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_wartosc'], 2,'.','');
	
		$listwa_przyszybowa_ilosc[$ilosc_pozycji] = number_format($wynik['listwa_przyszybowa_ilosc'], 2,'.','');
		$listwa_przyszybowa_cena[$ilosc_pozycji] = number_format($wynik['listwa_przyszybowa_cena'], 2,'.','');
		$listwa_przyszybowa_wartosc[$ilosc_pozycji] = number_format($wynik['listwa_przyszybowa_wartosc'], 2,'.','');

		$wstawienie_slupka_ruchomego_ilosc[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ruchomego_ilosc'], 2,'.','');
		$wstawienie_slupka_ruchomego_cena[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ruchomego_cena'], 2,'.','');
		$wstawienie_slupka_ruchomego_wartosc[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ruchomego_wartosc'], 2,'.','');

		$dociecie_kompletu_listew_przyszybowych_ilosc[$ilosc_pozycji] = number_format($wynik['dociecie_kompletu_listew_przyszybowych_ilosc'], 2,'.','');
		$dociecie_kompletu_listew_przyszybowych_cena[$ilosc_pozycji] = number_format($wynik['dociecie_kompletu_listew_przyszybowych_cena'], 2,'.','');
		$dociecie_kompletu_listew_przyszybowych_wartosc[$ilosc_pozycji] = number_format($wynik['dociecie_kompletu_listew_przyszybowych_wartosc'], 2,'.','');

		$okucie_ilosc[$ilosc_pozycji] = number_format($wynik['okucie_ilosc'], 2,'.','');
		$okucie_cena[$ilosc_pozycji] = number_format($wynik['okucie_cena'], 2,'.','');
		$okucie_wartosc[$ilosc_pozycji] = number_format($wynik['okucie_wartosc'], 2,'.','');

		$zaszklenie_ilosc[$ilosc_pozycji] = number_format($wynik['zaszklenie_ilosc'], 2,'.','');
		$zaszklenie_cena[$ilosc_pozycji] = number_format($wynik['zaszklenie_cena'], 2,'.','');
		$zaszklenie_wartosc[$ilosc_pozycji] = number_format($wynik['zaszklenie_wartosc'], 2,'.','');

		$innej_uslugi_ilosc[$ilosc_pozycji] = number_format($wynik['innej_uslugi_ilosc'], 2,'.','');
		$innej_uslugi_cena[$ilosc_pozycji] = number_format($wynik['innej_uslugi_cena'], 2,'.','');
		$innej_uslugi_wartosc[$ilosc_pozycji] = number_format($wynik['innej_uslugi_wartosc'], 2,'.','');

		$oscieznica_ilosc[$ilosc_pozycji] = number_format($wynik['oscieznica_ilosc'], 2,'.','');
		$oscieznica_cena[$ilosc_pozycji] = number_format($wynik['oscieznica_cena'], 2,'.','');
		$oscieznica_wartosc[$ilosc_pozycji] = number_format($wynik['oscieznica_wartosc'], 2,'.','');

		$skrzydlo_ilosc[$ilosc_pozycji] = number_format($wynik['skrzydlo_ilosc'], 2,'.','');
		$skrzydlo_cena[$ilosc_pozycji] = number_format($wynik['skrzydlo_cena'], 2,'.','');
		$skrzydlo_wartosc[$ilosc_pozycji] = number_format($wynik['skrzydlo_wartosc'], 2,'.','');

		$listwa_ilosc[$ilosc_pozycji] = number_format($wynik['listwa_ilosc'], 2,'.','');
		$listwa_cena[$ilosc_pozycji] = number_format($wynik['listwa_cena'], 2,'.','');
		$listwa_wartosc[$ilosc_pozycji] = number_format($wynik['listwa_wartosc'], 2,'.','');

		$slupek_ilosc[$ilosc_pozycji] = number_format($wynik['slupek_ilosc'], 2,'.','');
		$slupek_cena[$ilosc_pozycji] = number_format($wynik['slupek_cena'], 2,'.','');
		$slupek_wartosc[$ilosc_pozycji] = number_format($wynik['slupek_wartosc'], 2,'.','');

		$wzmocnienie_ramy_ilosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_ramy_ilosc'], 2,'.','');
		$wzmocnienie_ramy_cena[$ilosc_pozycji] = number_format($wynik['wzmocnienie_ramy_cena'], 2,'.','');
		$wzmocnienie_ramy_wartosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_ramy_wartosc'], 2,'.','');

		$wzmocnienie_skrzydla_ilosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_skrzydla_ilosc'], 2,'.','');
		$wzmocnienie_skrzydla_cena[$ilosc_pozycji] = number_format($wynik['wzmocnienie_skrzydla_cena'], 2,'.','');
		$wzmocnienie_skrzydla_wartosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_skrzydla_wartosc'], 2,'.','');
		
		$wzmocnienie_slupka_ilosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_slupka_ilosc'], 2,'.','');
		$wzmocnienie_slupka_cena[$ilosc_pozycji] = number_format($wynik['wzmocnienie_slupka_cena'], 2,'.','');
		$wzmocnienie_slupka_wartosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_slupka_wartosc'], 2,'.','');
		
		$wzmocnienie_luku_ilosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_luku_ilosc'], 2,'.','');
		$wzmocnienie_luku_cena[$ilosc_pozycji] = number_format($wynik['wzmocnienie_luku_cena'], 2,'.','');
		$wzmocnienie_luku_wartosc[$ilosc_pozycji] = number_format($wynik['wzmocnienie_luku_wartosc'], 2,'.','');

		$okucia_ilosc[$ilosc_pozycji] = number_format($wynik['okucia_ilosc'], 2,'.','');
		$okucia_cena[$ilosc_pozycji] = number_format($wynik['okucia_cena'], 2,'.','');
		$okucia_wartosc[$ilosc_pozycji] = number_format($wynik['okucia_wartosc'], 2,'.','');

		$szyby_ilosc[$ilosc_pozycji] = number_format($wynik['szyby_ilosc'], 2,'.','');
		$szyby_cena[$ilosc_pozycji] = number_format($wynik['szyby_cena'], 2,'.','');
		$szyby_wartosc[$ilosc_pozycji] = number_format($wynik['szyby_wartosc'], 2,'.','');

		$inny_element_ilosc[$ilosc_pozycji] = number_format($wynik['inny_element_ilosc'], 2,'.','');
		$inny_element_cena[$ilosc_pozycji] = number_format($wynik['inny_element_cena'], 2,'.','');
		$inny_element_wartosc[$ilosc_pozycji] = number_format($wynik['inny_element_wartosc'], 2,'.','');

		$okna[$ilosc_pozycji] = number_format($wynik['okna'], 2,'.','');
		$drzwi_wewnetrzne[$ilosc_pozycji] = number_format($wynik['drzwi_wewnetrzne'], 2,'.','');
		$drzwi_zewnetrzne[$ilosc_pozycji] = number_format($wynik['drzwi_zewnetrzne'], 2,'.','');
		$bramy[$ilosc_pozycji] = number_format($wynik['bramy'], 2,'.','');
		$parapety[$ilosc_pozycji] = number_format($wynik['parapety'], 2,'.','');
		$rolety_zewnetrzne[$ilosc_pozycji] = number_format($wynik['rolety_zewnetrzne'], 2,'.','');
		$rolety_wewnetrzne[$ilosc_pozycji] = number_format($wynik['rolety_wewnetrzne'], 2,'.','');
		$moskitiery[$ilosc_pozycji] = number_format($wynik['moskitiery'], 2,'.','');
		$montaz[$ilosc_pozycji] = number_format($wynik['montaz'], 2,'.','');
		$odpady_pvc[$ilosc_pozycji] = number_format($wynik['odpady_pvc'], 2,'.','');
		$odpady_alu_stal[$ilosc_pozycji] = number_format($wynik['odpady_alu_stal'], 2,'.','');
		$transport[$ilosc_pozycji] = number_format($wynik['transport'], 2,'.','');
		$inne[$ilosc_pozycji] = number_format($wynik['inne'], 2,'.','');
		$stopien_trudnosci[$ilosc_pozycji]=$wynik['stopien_trudnosci'];

		$nazwa_produktu[$ilosc_pozycji]=$wynik['nazwa_produktu'];
		if($nazwa_produktu[$ilosc_pozycji] != '') $zapisz_disabled_licz++;
		$cena_netto_za_sztuke[$ilosc_pozycji] = number_format($wynik['cena_netto_za_sztuke'], 2,'.','');
		
		$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
		if($ilosc_sztuk[$ilosc_pozycji] != '') $zapisz_disabled_licz++;
		$wartosc_netto[$ilosc_pozycji]=$wynik['wartosc_netto'];
		$SUMA_NETTO += $wartosc_netto[$ilosc_pozycji];
		$wartosc_netto[$ilosc_pozycji] = number_format($wartosc_netto[$ilosc_pozycji], 2,'.','');
		$vat_baza[$ilosc_pozycji]=$wynik['vat'];
		
		$wartosc_brutto[$ilosc_pozycji]=$wynik['wartosc_brutto'];
		$wartosc_brutto[$ilosc_pozycji] = number_format($wartosc_brutto[$ilosc_pozycji], 2,'.','');
		$SUMA_BRUTTO += $wartosc_brutto[$ilosc_pozycji];
		$nr_faktury[$ilosc_pozycji]=$wynik['nr_faktury'];
		if($nr_faktury[$ilosc_pozycji] != '') $ilosc_pozycji_z_faktura++;
		$data_faktury[$ilosc_pozycji]=$wynik['data_faktury'];
		
		$uwagi[$ilosc_pozycji]=$wynik['uwagi'];
		}
	$calkowita_ilosc_pozycji = $ilosc_pozycji;

	// jezeli ilosc pozycji jest pusta - pewnie dodawalismy zamowienie i grzebalismy w ustawieniach.
	if($ilosc_pozycji == 0)
		{
		$pytanie55 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
		while($wynik55= mysqli_fetch_assoc($pytanie55))
			{
			$nr_zamowienia=$wynik55['nr_zamowienia'];
			$klient_nazwa=$wynik55['klient_nazwa'];
			}
		}
		
	echo '<table border="0" valign="top" align="left" width="100%"><tr class="text_duzy">';
	if($wycena_wstepna_nr != '') $napis_wycena = 'Wycena wstępna'; else $napis_wycena = 'Wycena'; 
	for ($k=1; $k<=5; $k++) echo '<td width="20%" align="center">'.$napis_wycena.' : <font color="blue">'.$nr_zamowienia.'</font> dla klienta <font color="blue">'.$klient_nazwa.'</font></td>';
	echo '</tr></table><br>';	
	
	$status_zamowienia = '';
	if($zamowienie_id != '') 
	{
		$pytanie666 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id = ".$zamowienie_id.";");
		while($wynik666= mysqli_fetch_assoc($pytanie666))
			if(isset($wynik666['status'])) $status_zamowienia = $wynik666['status'];
	}
	
	
	// wywietlamy info o wystawieniu faktury dla pozycji
	if($status_zamowienia != 'Dostarczone')
		{
		for ($x=1;$x<=$ilosc_pozycji; $x++)
			if($nr_faktury[$x] != '')
				{
				echo '<table border="0" valign="top" align="left" width="100%"><tr class="text_duzy">';
				for ($k=1; $k<=5; $k++) echo '<td width="20%" align="center"><font color="red">UWAGA: Dla pozycji '.$x.' wygenerowana jest faktura. </font></td>';
				echo '</tr></table><br>';	
				}
		}
	
	if(($status_zamowienia == 'Dostarczone') || ($status_zamowienia == 'Anulowane') || ($status_zamowienia == 'Odebrane')) 
		{
		$disabled = " disabled"; 
		$zamowienie_zamkniete = 1;
		}
	else 
		{
		$disabled = "";
		$zamowienie_zamkniete = 0;
		}
	
	include("php/dlugosc_luku_wyceny.php");


	echo '<FORM name="wycena" action="index.php?page=wycena_edycja" method="post">';
	echo '<INPUT type="hidden" name="etap" value="2">';
	if($pozycja_transport[$ilosc_pozycji] == 'tak') $temp_ilosc_pozycji = $ilosc_pozycji - 1; else $temp_ilosc_pozycji = $ilosc_pozycji; // pozycja musi by o jeden mniej bo nie dziala java i liczenie wartosci 
	//$temp_ilosc_pozycji = $ilosc_pozycji;
	echo '<input type="hidden" id="id_ilosc_pozycji" name="ilosc_pozycji" value="'.$temp_ilosc_pozycji.'">';
	echo '<input type="hidden" name="klient" value="'.$klient_id.'">'; // klient ID
	echo '<input type="hidden" name="klient_nazwa" value="'.$klient_nazwa.'">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	echo '<input type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
	echo '<input type="hidden" id="id_pozycja_transport" name="pozycja_transport" value="'.$pozycja_transport[$ilosc_pozycji].'">';
	echo '<input type="text" id="sprawdz" value="tak">';
	echo '<input type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
	//sortowanie
	echo '<INPUT type="hidden" name="SORT_STAN" value="'.$SORT_STAN.'">';
	echo '<INPUT type="hidden" name="SORT_NR_ZLECENIA_TRANSPORTOWEGO" value="'.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'">';
	echo '<INPUT type="hidden" name="SORT_PROFIL" value="'.$SORT_PROFIL.'">';
	echo '<INPUT type="hidden" name="SORT_RODZAJ_SZYB" value="'.$SORT_RODZAJ_SZYB.'">';
	echo '<INPUT type="hidden" name="SORT_RODZAJ_OKUC" value="'.$SORT_RODZAJ_OKUC.'">';
	echo '<INPUT type="hidden" name="pokaz" value="'.$pokaz.'">';
	echo '<INPUT type="hidden" name="SORT_MAGAZYN" value="'.$SORT_MAGAZYN.'">';
	echo '<INPUT type="hidden" name="SORT_KOLOR_PROFILI" value="'.$SORT_KOLOR_PROFILI.'">';
	echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA" value="'.$SORT_NR_ZAMOWIENIA.'">';
	echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA_KLIENTA" value="'.$SORT_NR_ZAMOWIENIA_KLIENTA.'">';
	echo '<INPUT type="hidden" name="SORT_ZAMOWIONY_PRODUKT" value="'.$SORT_ZAMOWIONY_PRODUKT.'">';
	echo '<INPUT type="hidden" name="SORT_TERMIN_REALIZACJI" value="'.$SORT_TERMIN_REALIZACJI.'">';
	echo '<INPUT type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
	echo '<INPUT type="hidden" name="SORT_DATA_PRZYJECIA" value="'.$SORT_DATA_PRZYJECIA.'">';
	echo '<INPUT type="hidden" name="SORT_DATA_DOSTAWY" value="'.$SORT_DATA_DOSTAWY.'">';
	echo '<INPUT type="hidden" name="SORT_STATUS" value="'.$SORT_STATUS.'">';
	echo '<INPUT type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';

	
	// ################################## POZIOM 1 ##################################
	$szerokosc_pola_input_ilosc = '40px';
	$szerokosc_pola_input_cena = '50px';
	$szerokosc_pola_input_wartosc = '50px';
	$szer_inne_wartosc = '100px';

	//obliczanie szerokosci tabeli dla wycen
	$ilosc_kolumn_ilosc = 49; 
	$ilosc_kolumn_cena = 30;
	$ilosc_kolumn_wartosc = 44;
	$ilosc_kolumn_rozne = 5; //nazwa produktu, wart netto i brutto, cena za szt, uwagi

	$szerokosc_kolumny_ilosc = 50;
	$szerokosc_kolumny_cena = 60;
	$szerokosc_kolumny_wartosc = 70;
	$szerokosc_kolumny_rozne = 120;
	$szerokosc_kolumny_nazwa_produktu = 250;

	$szerokosc_tabeli_glownej = $ilosc_kolumn_ilosc*$szerokosc_kolumny_ilosc + $ilosc_kolumn_cena*$szerokosc_kolumny_cena + $ilosc_kolumn_wartosc*$szerokosc_kolumny_wartosc + $ilosc_kolumn_rozne*$szerokosc_kolumny_rozne + $szerokosc_kolumny_nazwa_produktu*2;

	echo '<br><table valign="top" align="left" width="'.$szerokosc_tabeli_glownej.'px" border="1" cellspacing="1" cellpadding="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';


	include("php/wycena_edycja_nazwy_kolumn.php");
	
	// pobieram stawki VAT
	$TAB_VAT_DL = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM vat ORDER BY id ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$TAB_VAT_DL++;
		$TAB_VAT[$TAB_VAT_DL]=$wynik['wartosc'];
		}

//sprawdzamy czy istnieje pozycja transportowa - jeli tak zmiejszamy ilosc pozycji o 1
if($pozycja_transport[$ilosc_pozycji] == 'tak') $ilosc_pozycji--;

$wysykosc_wiersza = '35px';
//pole potrzebne do wylyczania wygiecia ramy z pvc - przy korekcie nie ma ptaszków
echo '<input type="hidden" id="czy_to_korekta" value="nie">';

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{
	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		if($zamowienie_zamkniete == 0) 
			{
			$styl = "pole_input_biale_ramka"; 
			$styl_zolte_pola = "pole_input_zolte_ramka";
			$styl_uwagi = "pole_input_biale_ramka_uwagi"; 
			}
		else 
			{
			$styl = "pole_input_biale_bez_ramki"; 
			$styl_zolte_pola = "pole_input_zolte_bez_ramki";
			$styl_uwagi = "pole_input_biale_bez_ramki_uwagi"; 
			}
		$styl_select = "pole_select_biale_z_ramka"; 
		}
	else 
		{
		$wiersz = $kolor_szary;
		if($zamowienie_zamkniete == 0) 
			{
			$styl = "pole_input_szare_ramka"; 
			$styl_zolte_pola = "pole_input_zolte_ramka";
			$styl_uwagi = "pole_input_szare_ramka_uwagi"; 
			}
		else 
			{
			$styl = "pole_input_szare_bez_ramki"; 
			$styl_zolte_pola = "pole_input_zolte_bez_ramki";
			$styl_uwagi = "pole_input_szare_bez_ramki_uwagi"; 
			}
		$styl_select = "pole_select_szare_z_ramka"; 
		}



	if($nr_faktury[$x] != '') echo '<tr bgcolor="'.$wiersz.'" align="center"><td bgcolor="'.$kolor_tabeli.'">'.$x.'/'.$calkowita_ilosc_pozycji.'</td>';
	elseif(($ilosc_pozycji != 1) && ($status_zamowienia != 'Dostarczone') && ($status_zamowienia != 'Anulowane') && ($status_zamowienia != 'Odebrane')) 
	{
		echo '<tr bgcolor="'.$wiersz.'" align="center" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">';
			echo '<table class="text" border="0" cellpadding="2" cellspacing="2" align="center"><tr><td>';
				echo $x.'/'.$calkowita_ilosc_pozycji;
			echo '</td><td>';
				echo '<a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&usun_pozycje='.$pozycja_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_delete.'</a>';
			echo '</td></tr></table>';
		echo '</td>';
	}
	else echo '<tr bgcolor="'.$wiersz.'" align="center"><td bgcolor="'.$kolor_tabeli.'">'.$x.'/'.$calkowita_ilosc_pozycji.'</td>';
	
	// ###################################################################################################################################################################################
	// ######################################################################################################################################################################
	// #######################################################################  łuki z pvc          ###################################################################
	// #######################################################################  wygiecie_ramy_z_pvc ###################################################################
	//   #################   kolumna E ilość sz  
	$id_wygiecie_ramy_z_pvc_ilosc_szt = 'id_wygiecie_ramy_z_pvc_ilosc_szt_'.$x;
	$nazwa_wygiecie_ramy_z_pvc_ilosc_szt = 'nazwa_wygiecie_ramy_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_pvc_ilosc_szt.'" name="'.$nazwa_wygiecie_ramy_z_pvc_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" value="'.$wygiecie_ramy_pvc_ilosc_szt[$x].'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_sztuki_wygiecie_wzmocnienia_okiennego('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna F ilość metr  
	$id_wygiecie_ramy_z_pvc_ilosc_m = 'id_wygiecie_ramy_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_ramy_z_pvc_ilosc_m = 'nazwa_wygiecie_ramy_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_ramy_z_pvc_ilosc_m.'" value="'.$wygiecie_ramy_pvc_ilosc_m[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_ramy_z_pvc('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna G cena, ID z cennika = 1    ####################################
	$id_cena_ramy = 'id_cena_ramy_'.$x;	
	$nazwa_wygiecie_ramy_z_pvc_cena = 'nazwa_wygiecie_ramy_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_ramy_pvc_cena[$x].'" id="'.$id_cena_ramy.'" name="'.$nazwa_wygiecie_ramy_z_pvc_cena.'"  style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_ramy_z_pvc('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna H  wartosc   ####################################
	$id_wygiecie_ramy_z_pvc_wartosc = 'id_wygiecie_ramy_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_ramy_z_pvc_wartosc = 'nazwa_wygiecie_ramy_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_ramy_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_ramy_z_pvc_wartosc.'" value="'.$wygiecie_ramy_pvc_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	//   #######################################################################  wygiecie_skrzydla_z_pvc ###################################################################
	//   #################   kolumna z ptaszkiem do zaznaczania
	$id_wygiecie_skrzydla_ptaszek = 'id_wygiecie_skrzydla_ptaszek_'.$x;
	$nazwa_wygiecie_skrzydla_ptaszek = 'nazwa_wygiecie_skrzydla_ptaszek['.$x.']';
	if($checkbox_wygiecie_skrzydla[$x] == 'on') 
	{
		$atrybut_wygiecie_skrzydla = 'checked="checked"'; 
		$atrybut_wygiecie_skrzydla_szt_i_m = 'readonly="readonly"'; 
	}
	else 
	{
		$atrybut_wygiecie_skrzydla = '';
		$atrybut_wygiecie_skrzydla_szt_i_m = ''; 
	}
	echo '<td align="center"><input type="checkbox" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_ptaszek.'" name="'.$nazwa_wygiecie_skrzydla_ptaszek.'" '.$atrybut_wygiecie_skrzydla.' class="'.$styl.'" '.$disabled.' onclick="Zaznaczenie_checkboxa_wygiecie_skrzydla('.$x.', '.$ilosc_pozycji.');"></td>';




	//   #################   kolumna I ilość sz  
	$id_wygiecie_skrzydla_z_pvc_ilosc_szt = 'id_wygiecie_skrzydla_z_pvc_ilosc_szt_'.$x;
	$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt = 'nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_pvc_ilosc_szt.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt.'" value="'.$wygiecie_skrzydla_pvc_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wygiecie_skrzydla_szt_i_m.' onkeyup="Oblicz_sztuki_wygiecie_wzmocnienia_okiennego('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna J ilość metr  
	$id_wygiecie_skrzydla_z_pvc_ilosc_m = 'id_wygiecie_skrzydla_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m = 'nazwa_wygiecie_skrzydla_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m.'" value="'.$wygiecie_skrzydla_pvc_ilosc_m[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wygiecie_skrzydla_szt_i_m.' onkeyup="Oblicz_wygiecie_skrzydla_z_pvc('.$x.');"></td>';
	//   #################   kolumna K cena, ID z cennika = 2    ####################################
	$id_cena_skrzydla = 'id_cena_skrzydla_'.$x;	
	$nazwa_wygiecie_skrzydla_z_pvc_cena = 'nazwa_wygiecie_skrzydla_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_skrzydla_pvc_cena[$x].'" id="'.$id_cena_skrzydla.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_skrzydla_z_pvc('.$x.');"></td>';
	//   #################   kolumna L  wartosc   ####################################
	$id_wygiecie_skrzydla_z_pvc_wartosc = 'id_wygiecie_skrzydla_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_skrzydla_z_pvc_wartosc = 'nazwa_wygiecie_skrzydla_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_skrzydla_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_wartosc.'" value="'.$wygiecie_skrzydla_pvc_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	//   #######################################################################  wygiecie_listwy_z_pvc ###################################################################
	//   #################   kolumna z ptaszkiem do zaznaczania
	$id_wygiecie_listwy_ptaszek = 'id_wygiecie_listwy_ptaszek_'.$x;
	$nazwa_wygiecie_listwy_ptaszek = 'nazwa_wygiecie_listwy_ptaszek['.$x.']';
	if($checkbox_wygiecie_listwy[$x] == 'on') 
	{
		$atrybut_wygiecie_listwy = 'checked="checked"'; 
		$atrybut_wygiecie_listwy_szt_i_m = 'readonly="readonly"'; 
	}
	else 
	{
		$atrybut_wygiecie_listwy = '';
		$atrybut_wygiecie_listwy_szt_i_m = ''; 
	}

	echo '<td align="center"><input type="checkbox" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_ptaszek.'" name="'.$nazwa_wygiecie_listwy_ptaszek.'" '.$atrybut_wygiecie_listwy.' class="'.$styl.'" '.$disabled.' onclick="Zaznaczenie_checkboxa_wygiecie_listwy('.$x.', '.$ilosc_pozycji.');"></td>';
	
	


	//   #################   kolumna M ilość sz  
	$id_wygiecie_listwy_z_pvc_ilosc_szt = 'id_wygiecie_listwy_z_pvc_ilosc_szt_'.$x;
	$nazwa_wygiecie_listwy_z_pvc_ilosc_szt = 'nazwa_wygiecie_listwy_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_pvc_ilosc_szt.'" name="'.$nazwa_wygiecie_listwy_z_pvc_ilosc_szt.'" value="'.$wygiecie_listwy_pvc_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wygiecie_listwy_szt_i_m.'></td>';
	//   #################   kolumna N ilość metr  
	$id_wygiecie_listwy_z_pvc_ilosc_m = 'id_wygiecie_listwy_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_listwy_z_pvc_ilosc_m = 'nazwa_wygiecie_listwy_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_pvc_ilosc_m.'" value="'.$wygiecie_listwy_pvc_ilosc_m[$x].'" name="'.$nazwa_wygiecie_listwy_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wygiecie_listwy_szt_i_m.' onkeyup="Oblicz_wygiecie_listwy_z_pvc();"></td>';
	//   #################   kolumna O cena, ID z cennika = 3    ####################################
	$id_cena_listwy = 'id_cena_listwy_'.$x;	
	$nazwa_wygiecie_listwy_z_pvc_cena = 'nazwa_wygiecie_listwy_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_listwy_pvc_cena[$x].'" id="'.$id_cena_listwy.'" name="'.$nazwa_wygiecie_listwy_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_listwy_z_pvc();"></td>';
	//   #################   kolumna P  wartosc   ####################################
	$id_wygiecie_listwy_z_pvc_wartosc = 'id_wygiecie_listwy_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_listwy_z_pvc_wartosc = 'nazwa_wygiecie_listwy_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_listwy_z_pvc_wartosc.'" value="'.$wygiecie_listwy_pvc_wartosc[$x].'" name="'.$nazwa_wygiecie_listwy_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
			
	//   #######################################################################  wygiecie_innego elementu_z_pvc ###################################################################
	//   #################   kolumna Q ilość sz  
	$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt = 'nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt.'" value="'.$wygiecie_innego_pvc_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	//   #################   kolumna R ilość metr  
	$id_wygiecie_innego_elementu_z_pvc_ilosc_m = 'id_wygiecie_innego_elementu_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m = 'nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_z_pvc_ilosc_m.'" value="'.$wygiecie_innego_pvc_ilosc_m[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_innego_elementu_z_pvc();"></td>';
	//   #################   kolumna S cena, ID z cennika = 4    ####################################
	$id_cena_innego_elementu = 'id_cena_innego_elementu_'.$x;	
	$nazwa_wygiecie_innego_elementu_z_pvc_cena = 'nazwa_wygiecie_innego_elementu_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_innego_pvc_cena[$x].'" id="'.$id_cena_innego_elementu.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_innego_elementu_z_pvc();"></td>';
	//   #################   kolumna T  wartosc   ####################################
	$id_wygiecie_innego_elementu_z_pvc_wartosc = 'id_wygiecie_innego_elementu_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_z_pvc_wartosc = 'nazwa_wygiecie_innego_elementu_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_z_pvc_wartosc.'" value="'.$wygiecie_innego_pvc_wartosc[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';



	// ##################################################################################################################################################################################
	// #######################################################################  uki z aluminium               ###################################################################
	// #######################################################################  wygiecie_ramy_z_alu            ###################################################################
	// ################################################################################################################################################################################
	
	//   #################   kolumna u ilość sz  
 	$nazwa_wygiecie_ramy_z_alu_ilosc_szt = 'nazwa_wygiecie_ramy_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_ramy_z_alu_ilosc_szt.'" value="'.$wygiecie_ramy_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	//   #################   kolumna v ilość metr  
	$id_wygiecie_ramy_z_alu_ilosc_m = 'id_wygiecie_ramy_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_ramy_z_alu_ilosc_m = 'nazwa_wygiecie_ramy_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_alu_ilosc_m.'" value="'.$wygiecie_ramy_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_ramy_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_ramy_z_alu();"></td>';
	//   #################   kolumna w cena, ID z cennika = 5    ####################################
	$id_cena_ramy_alu = 'id_cena_ramy_alu_'.$x;	
	$nazwa_wygiecie_ramy_z_alu_cena = 'nazwa_wygiecie_ramy_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_ramy_alu.'" value="'.$wygiecie_ramy_alu_cena[$x].'" name="'.$nazwa_wygiecie_ramy_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_ramy_z_alu();"></td>';
	//   #################   kolumna x  wartosc   ####################################
	$id_wygiecie_ramy_z_alu_wartosc = 'id_wygiecie_ramy_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_ramy_z_alu_wartosc = 'nazwa_wygiecie_ramy_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_ramy_z_alu_wartosc.'" value="'.$wygiecie_ramy_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_ramy_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	//   #######################################################################  wygiecie_skrzydla_z_alu ###################################################################
	//   #################   kolumna y ilość sz  
	$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt = 'nazwa_wygiecie_skrzydla_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt.'" value="'.$wygiecie_skrzydla_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	//   #################   kolumna z ilość metr  
	$id_wygiecie_skrzydla_z_alu_ilosc_m = 'id_wygiecie_skrzydla_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_skrzydla_z_alu_ilosc_m = 'nazwa_wygiecie_skrzydla_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_alu_ilosc_m.'" value="'.$wygiecie_skrzydla_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_skrzydla_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_skrzydla_z_alu();"></td>';
	//   #################   kolumna aa cena, ID z cennika = 6    ####################################
	$id_cena_skrzydla_alu = 'id_cena_skrzydla_alu_'.$x;	
	$nazwa_wygiecie_skrzydla_z_alu_cena = 'nazwa_wygiecie_skrzydla_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_skrzydla_alu.'" value="'.$wygiecie_skrzydla_alu_cena[$x].'" name="'.$nazwa_wygiecie_skrzydla_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_skrzydla_z_alu();"></td>';
	//   #################   kolumna ab  wartosc   ####################################
	$id_wygiecie_skrzydla_z_alu_wartosc = 'id_wygiecie_skrzydla_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_skrzydla_z_alu_wartosc = 'nazwa_wygiecie_skrzydla_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_skrzydla_z_alu_wartosc.'" value="'.$wygiecie_skrzydla_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_skrzydla_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	//   #######################################################################  wygiecie_listwy_z_alu ###################################################################
	//   #################   kolumna ac ilość sz  
	$nazwa_wygiecie_listwy_z_alu_ilosc_szt = 'nazwa_wygiecie_listwy_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_listwy_z_alu_ilosc_szt.'" value="'.$wygiecie_listwy_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	//   #################   kolumna ad ilość metr  
	$id_wygiecie_listwy_z_alu_ilosc_m = 'id_wygiecie_listwy_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_listwy_z_alu_ilosc_m = 'nazwa_wygiecie_listwy_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_alu_ilosc_m.'" value="'.$wygiecie_listwy_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_listwy_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_listwy_z_alu();"></td>';
	//   #################   kolumna ae cena, ID z cennika = 7    ####################################
	$id_cena_listwy_alu = 'id_cena_listwy_alu_'.$x;	
	$nazwa_wygiecie_listwy_z_alu_cena = 'nazwa_wygiecie_listwy_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_listwy_alu.'" value="'.$wygiecie_listwy_alu_cena[$x].'" name="'.$nazwa_wygiecie_listwy_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_listwy_z_alu();"></td>';
	//   #################   kolumna af  wartosc   ####################################
	$id_wygiecie_listwy_z_alu_wartosc = 'id_wygiecie_listwy_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_listwy_z_alu_wartosc = 'nazwa_wygiecie_listwy_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_listwy_z_alu_wartosc.'" value="'.$wygiecie_listwy_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_listwy_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	//   #######################################################################  wygiecie_innego elementu_z_alu ###################################################################
	//   #################   kolumna ag ilość sz  
	$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt = 'nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt.'" value="'.$wygiecie_innego_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	//   #################   kolumna ah ilość metr  
	$id_wygiecie_innego_elementu_z_alu_ilosc_m = 'id_wygiecie_innego_elementu_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m = 'nazwa_wygiecie_innego_elementu_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_z_alu_ilosc_m.'" value="'.$wygiecie_innego_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_innego_elementu_z_alu();"></td>';
	//   #################   kolumna ai cena, ID z cennika = 8    ####################################
	$id_cena_innego_elementu_alu = 'id_cena_innego_elementu_alu_'.$x;	
	$nazwa_wygiecie_innego_elementu_z_alu_cena = 'nazwa_wygiecie_innego_elementu_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_innego_elementu_alu.'" value="'.$wygiecie_innego_alu_cena[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_innego_elementu_z_alu();"></td>';
	//   #################   kolumna aj  wartosc   ####################################
	$id_wygiecie_innego_elementu_z_alu_wartosc = 'id_wygiecie_innego_elementu_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_z_alu_wartosc = 'nazwa_wygiecie_innego_elementu_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_z_alu_wartosc.'" value="'.$wygiecie_innego_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// ############################################################################################################################################################################
	// #######################################################################  łuki ze stali                      ################################################################
	// #######################################################################  Wygicie wzmocnienia okiennego     #################################################################
	// ############################################################################################################################################################################

	//   #################   kolumna z ptaszkiem do zaznaczania
	$id_wygiecie_wzmocnienia_okiennego_ptaszek = 'id_wygiecie_wzmocnienia_okiennego_ptaszek_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek = 'nazwa_wygiecie_wzmocnienia_okiennego_ptaszek['.$x.']';
	if($checkbox_wygiecie_wzmocnienia[$x] == 'on') 
	{
		//jak zaznaczony to obliczamy jeszcze raz wartosci dla wzmocnienia i luku
		$atrybut_wzmocnienie_okienne = 'checked="checked"'; 
		$atrybut_wzmocnienie_okienne_szt_i_m = 'readonly="readonly"'; 

		$wygiecie_wzmocnienia_okiennego_ilosc_szt[$x] = $wygiecie_ramy_pvc_ilosc_szt[$x] + $wygiecie_skrzydla_pvc_ilosc_szt[$x];
		$wygiecie_wzmocnienia_okiennego_ilosc_m[$x] = $wygiecie_ramy_pvc_ilosc_m[$x] + $wygiecie_skrzydla_pvc_ilosc_m[$x];
		$wzmocnienie_luku_ilosc[$x] = $wygiecie_wzmocnienia_okiennego_ilosc_m[$x];
		$wzmocnienie_luku_wartosc[$x] = $wzmocnienie_luku_ilosc[$x] * $wzmocnienie_luku_cena[$x];
		$wygiecie_wzmocnienia_okiennego_wartosc[$x] = $wygiecie_wzmocnienia_okiennego_ilosc_m[$x] * $wygiecie_wzmocnienia_okiennego_cena[$x];


		$wygiecie_wzmocnienia_okiennego_ilosc_szt[$x] = number_format($wygiecie_wzmocnienia_okiennego_ilosc_szt[$x], 2,'.','');
		$wygiecie_wzmocnienia_okiennego_ilosc_m[$x] = number_format($wygiecie_wzmocnienia_okiennego_ilosc_m[$x], 2,'.','');
		$wzmocnienie_luku_ilosc[$x] = number_format($wzmocnienie_luku_ilosc[$x], 2,'.','');
		$wzmocnienie_luku_wartosc[$x] = number_format($wzmocnienie_luku_wartosc[$x], 2,'.','');
		$wygiecie_wzmocnienia_okiennego_wartosc[$x] = number_format($wygiecie_wzmocnienia_okiennego_wartosc[$x], 2,'.','');

	}
	else 
	{
		$atrybut_wzmocnienie_okienne = '';
		$atrybut_wzmocnienie_okienne_szt_i_m = ''; 
	}
	echo '<td align="center"><input type="checkbox" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ptaszek.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek.'" '.$atrybut_wzmocnienie_okienne.' class="'.$styl.'" '.$disabled.' onclick="Zaznaczenie_checkboxa_wzmocnienie_okienne('.$x.', '.$ilosc_pozycji.');"></td>';



	//   #################   kolumna ak ilość sz  
	$id_wygiecie_wzmocnienia_okiennego_ilosc_szt = 'id_wygiecie_wzmocnienia_okiennego_ilosc_szt_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt = 'nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ilosc_szt.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt.'" value="'.$wygiecie_wzmocnienia_okiennego_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wzmocnienie_okienne_szt_i_m.' onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna al ilość metr  
	$id_wygiecie_wzmocnienia_okiennego_ilosc_m = 'id_wygiecie_wzmocnienia_okiennego_ilosc_m_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m = 'nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ilosc_m.'" value="'.$wygiecie_wzmocnienia_okiennego_ilosc_m[$x].'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wzmocnienie_okienne_szt_i_m.' onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna am cena, ID z cennika = 9    ####################################
	$id_cena_wzmocnienia_okiennego = 'id_cena_wzmocnienia_okiennego_'.$x;	
	$nazwa_wygiecie_wzmocnienia_okiennego_cena = 'nazwa_wygiecie_wzmocnienia_okiennego_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wzmocnienia_okiennego.'" value="'.$wygiecie_wzmocnienia_okiennego_cena[$x].'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna an  wartosc   ####################################
	$id_wygiecie_wzmocnienia_okiennego_wartosc = 'id_wygiecie_wzmocnienia_okiennego_wartosc_'.$x;		
	$nazwa_wygiecie_wzmocnienia_okiennego_wartosc = 'nazwa_wygiecie_wzmocnienia_okiennego_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_wzmocnienia_okiennego_wartosc.'" value="'.$wygiecie_wzmocnienia_okiennego_wartosc[$x].'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wygiecie_innego_elementu_ze_stali            ###################################################################
	//   #################   kolumna ao ilość sz  
	$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt = 'nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt.'" value="'.$wygiecie_innego_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	//   #################   kolumna ap ilość metr  
	$id_wygiecie_innego_elementu_ze_stali_ilosc_m = 'id_wygiecie_innego_elementu_ze_stali_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m = 'nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_ze_stali_ilosc_m.'" value="'.$wygiecie_innego_ilosc_m[$x].'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_innego_elementu_ze_stali();"></td>';
	//   #################   kolumna aq cena, ID z cennika = 10    ####################################
	$id_cena_wygiecie_innego_elementu_ze_stali = 'id_cena_wygiecie_innego_elementu_ze_stali_'.$x;	
	$nazwa_wygiecie_innego_elementu_ze_stali_cena = 'nazwa_wygiecie_innego_elementu_ze_stali_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wygiecie_innego_elementu_ze_stali.'" value="'.$wygiecie_innego_cena[$x].'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wygiecie_innego_elementu_ze_stali();"></td>';
	//   #################   kolumna ar  wartosc   ####################################
	$id_wygiecie_innego_elementu_ze_stali_wartosc = 'id_wygiecie_innego_elementu_ze_stali_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_ze_stali_wartosc = 'nazwa_wygiecie_innego_elementu_ze_stali_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_ze_stali_wartosc.'" value="'.$wygiecie_innego_wartosc[$x].'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	// ##################################################################################################################################################################################
	// #######################################################################  Konstrukcje okienne z pvc          ###################################################################
	// ##################################################################################################################################################################################
	
	// #######################################################################  Zgrzanie	###################################################################
	//   #################   kolumna as ilość  
	$id_zgrzanie_ilosc_m = 'id_zgrzanie_ilosc_m_'.$x;
	$nazwa_zgrzanie_ilosc_m = 'nazwa_zgrzanie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_zgrzanie_ilosc_m.'" name="'.$nazwa_zgrzanie_ilosc_m.'" value="'.$zgrzanie_ilosc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_zgrzanie();"></td>';
	//   #################   kolumna at cena, ID z cennika = 11    ####################################
	$id_cena_zgrzanie = 'id_cena_zgrzanie_'.$x;	
	$nazwa_zgrzanie_cena = 'nazwa_zgrzanie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_zgrzanie.'" value="'.$zgrzanie_cena[$x].'" name="'.$nazwa_zgrzanie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_zgrzanie();"></td>';
	//   #################   kolumna au  wartosc   ####################################
	$id_zgrzanie_wartosc = 'id_zgrzanie_wartosc_'.$x;		
	$nazwa_zgrzanie_wartosc = 'nazwa_zgrzanie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_zgrzanie_wartosc.'" value="'.$zgrzanie_wartosc[$x].'" name="'.$nazwa_zgrzanie_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	//   #######################################################################  Wyfrezowanie odwodnienia  ###################################################################
	//   #################   kolumna av ilość 
	$id_wyfrezowanie_odwodnienia_ilosc_m = 'id_wyfrezowanie_odwodnienia_ilosc_m_'.$x;
	$nazwa_wyfrezowanie_odwodnienia_ilosc_m = 'nazwa_wyfrezowanie_odwodnienia_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wyfrezowanie_odwodnienia_ilosc_m.'" value="'.$wyfrezowanie_odwodnienia_ilosc[$x].'" name="'.$nazwa_wyfrezowanie_odwodnienia_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wyfrezowanie_odwodnienia();"></td>';
	//   #################   kolumna aw cena, ID z cennika = 12    ####################################
	$id_cena_wyfrezowanie_odwodnienia = 'id_cena_wyfrezowanie_odwodnienia_'.$x;	
	$nazwa_wyfrezowanie_odwodnienia_cena = 'nazwa_wyfrezowanie_odwodnienia_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wyfrezowanie_odwodnienia_cena[$x].'" id="'.$id_cena_wyfrezowanie_odwodnienia.'" name="'.$nazwa_wyfrezowanie_odwodnienia_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wyfrezowanie_odwodnienia();"></td>';
	//   #################   kolumna ax  wartosc   ####################################
	$id_wyfrezowanie_odwodnienia_wartosc = 'id_wyfrezowanie_odwodnienia_wartosc_'.$x;		
	$nazwa_wyfrezowanie_odwodnienia_wartosc = 'nazwa_wyfrezowanie_odwodnienia_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wyfrezowanie_odwodnienia_wartosc.'" value="'.$wyfrezowanie_odwodnienia_wartosc[$x].'" name="'.$nazwa_wyfrezowanie_odwodnienia_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  Wstawienie supka stałego	###################################################################
	//   #################   kolumna ay ilość  
	$id_wstawienie_slupka_ilosc_m = 'id_wstawienie_slupka_ilosc_m_'.$x;
	$nazwa_wstawienie_slupka_ilosc_m = 'nazwa_wstawienie_slupka_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wstawienie_slupka_ilosc_m.'" value="'.$wstawienie_slupka_ilosc[$x].'" name="'.$nazwa_wstawienie_slupka_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wstawienie_slupka();"></td>';
	//   #################   kolumna az cena   ####################################
	$id_cena_wstawienie_slupka = 'id_cena_wstawienie_slupka_'.$x;	
	$nazwa_wstawienie_slupka_cena = 'nazwa_wstawienie_slupka_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wstawienie_slupka.'" value="'.$wstawienie_slupka_cena[$x].'" name="'.$nazwa_wstawienie_slupka_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wstawienie_slupka();"></td>';
	//   #################   kolumna ba  wartosc   ####################################
	$id_wstawienie_slupka_wartosc = 'id_wstawienie_slupka_wartosc_'.$x;		
	$nazwa_wstawienie_slupka_wartosc = 'nazwa_wstawienie_slupka_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wstawienie_slupka_wartosc.'" value="'.$wstawienie_slupka_wartosc[$x].'" name="'.$nazwa_wstawienie_slupka_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  Wstawienie supka ruchomego	###################################################################
	//   #################   kolumna ay ilość  
	$id_wstawienie_slupka_ruchomego_ilosc_m = 'id_wstawienie_slupka_ruchomego_ilosc_m_'.$x;
	$nazwa_wstawienie_slupka_ruchomego_ilosc_m = 'nazwa_wstawienie_slupka_ruchomego_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wstawienie_slupka_ruchomego_ilosc_m.'" value="'.$wstawienie_slupka_ruchomego_ilosc[$x].'" name="'.$nazwa_wstawienie_slupka_ruchomego_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wstawienie_slupka_ruchomego();"></td>';
	//   #################   kolumna az cena   ####################################
	$id_cena_wstawienie_slupka_ruchomego = 'id_cena_wstawienie_slupka_ruchomego_'.$x;	
	$nazwa_wstawienie_slupka_ruchomego_cena = 'nazwa_wstawienie_slupka_ruchomego_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wstawienie_slupka_ruchomego.'" value="'.$wstawienie_slupka_ruchomego_cena[$x].'" name="'.$nazwa_wstawienie_slupka_ruchomego_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wstawienie_slupka_ruchomego();"></td>';
	//   #################   kolumna ba  wartosc   ####################################
	$id_wstawienie_slupka_ruchomego_wartosc = 'id_wstawienie_slupka_ruchomego_wartosc_'.$x;		
	$nazwa_wstawienie_slupka_ruchomego_wartosc = 'nazwa_wstawienie_slupka_ruchomego_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wstawienie_slupka_ruchomego_wartosc.'" value="'.$wstawienie_slupka_ruchomego_wartosc[$x].'" name="'.$nazwa_wstawienie_slupka_ruchomego_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';



	// #######################################################################  Docięcie listwy przyszybowej	###################################################################
	//   #################   kolumna bb ilość  
	$id_dociecie_listwy_przyszybowej_ilosc_m = 'id_dociecie_listwy_przyszybowej_ilosc_m_'.$x;
	$nazwa_dociecie_listwy_przyszybowej_ilosc_m = 'nazwa_dociecie_listwy_przyszybowej_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_dociecie_listwy_przyszybowej_ilosc_m.'" value="'.$listwa_przyszybowa_ilosc[$x].'" name="'.$nazwa_dociecie_listwy_przyszybowej_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_dociecie_listwy_przyszybowej();"></td>';
	//   #################   kolumna bc cena   ####################################
	$id_cena_dociecie_listwy_przyszybowej = 'id_cena_dociecie_listwy_przyszybowej_'.$x;	
	$nazwa_dociecie_listwy_przyszybowej_cena = 'nazwa_dociecie_listwy_przyszybowej_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_dociecie_listwy_przyszybowej.'" value="'.$listwa_przyszybowa_cena[$x].'" name="'.$nazwa_dociecie_listwy_przyszybowej_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_dociecie_listwy_przyszybowej();"></td>';
	//   #################   kolumna bd  wartosc   ####################################
	$id_dociecie_listwy_przyszybowej_wartosc = 'id_dociecie_listwy_przyszybowej_wartosc_'.$x;		
	$nazwa_dociecie_listwy_przyszybowej_wartosc = 'nazwa_dociecie_listwy_przyszybowej_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_dociecie_listwy_przyszybowej_wartosc.'" value="'.$listwa_przyszybowa_wartosc[$x].'" name="'.$nazwa_dociecie_listwy_przyszybowej_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  Docięcie  kompletu listew przyszybowych	###################################################################
	//   #################   kolumna bb ilość  
	$id_dociecie_kompletu_listew_przyszybowych_ilosc_m = 'id_dociecie_kompletu_listew_przyszybowych_ilosc_m_'.$x;
	$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m = 'nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_dociecie_kompletu_listew_przyszybowych_ilosc_m.'" value="'.$dociecie_kompletu_listew_przyszybowych_ilosc[$x].'" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_dociecie_kompletu_listew_przyszybowych();"></td>';
	//   #################   kolumna bc cena   ####################################
	$id_cena_dociecie_kompletu_listew_przyszybowych = 'id_cena_dociecie_kompletu_listew_przyszybowych_'.$x;	
	$nazwa_dociecie_kompletu_listew_przyszybowych_cena = 'nazwa_dociecie_kompletu_listew_przyszybowych_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_dociecie_kompletu_listew_przyszybowych.'" value="'.$dociecie_kompletu_listew_przyszybowych_cena[$x].'" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_dociecie_kompletu_listew_przyszybowych();"></td>';
	//   #################   kolumna bd  wartosc   ####################################
	$id_dociecie_kompletu_listew_przyszybowych_wartosc = 'id_dociecie_kompletu_listew_przyszybowych_wartosc_'.$x;		
	$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc = 'nazwa_dociecie_kompletu_listew_przyszybowych_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_dociecie_kompletu_listew_przyszybowych_wartosc.'" value="'.$dociecie_kompletu_listew_przyszybowych_wartosc[$x].'" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  okucie	 ###################################################################
	//   #################   kolumna be ilość  
	$id_okucie_ilosc_m = 'id_okucie_ilosc_m_'.$x;
	$nazwa_okucie_ilosc_m = 'nazwa_okucie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_okucie_ilosc_m.'" name="'.$nazwa_okucie_ilosc_m.'" value="'.$okucie_ilosc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_okucie();"></td>';
	//   #################   kolumna bf cena, ID z cennika = 15    ####################################
	$id_cena_okucie = 'id_cena_okucie_'.$x;	
	$nazwa_okucie_cena = 'nazwa_okucie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_okucie.'" value="'.$okucie_cena[$x].'" name="'.$nazwa_okucie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_okucie();"></td>';
	//   #################   kolumna bg  wartosc   ####################################
	$id_okucie_wartosc = 'id_okucie_wartosc_'.$x;		
	$nazwa_okucie_wartosc = 'nazwa_okucie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_okucie_wartosc.'" name="'.$nazwa_okucie_wartosc.'" value="'.$okucie_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  zaszklenie	###################################################################
	//   #################   kolumna bh ilość  
	$id_zaszklenie_ilosc_m = 'id_zaszklenie_ilosc_m_'.$x;
	$nazwa_zaszklenie_ilosc_m = 'nazwa_zaszklenie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_zaszklenie_ilosc_m.'" name="'.$nazwa_zaszklenie_ilosc_m.'" value="'.$zaszklenie_ilosc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_zaszklenie();"></td>';
	//   #################   kolumna bi cena, ID z cennika = 16   ####################################
	$id_cena_zaszklenie = 'id_cena_zaszklenie_'.$x;	
	$nazwa_zaszklenie_cena = 'nazwa_zaszklenie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_zaszklenie.'" name="'.$nazwa_zaszklenie_cena.'" value="'.$zaszklenie_cena[$x].'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_zaszklenie();"></td>';
	//   #################   kolumna bj  wartosc   ####################################
	$id_zaszklenie_wartosc = 'id_zaszklenie_wartosc_'.$x;		
	$nazwa_zaszklenie_wartosc = 'nazwa_zaszklenie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_zaszklenie_wartosc.'" name="'.$nazwa_zaszklenie_wartosc.'" value="'.$zaszklenie_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wykonanie_innej_uslugi	###################################################################
	//   #################   kolumna bk ilość  
	$id_wykonanie_innej_uslugi_ilosc_m = 'id_wykonanie_innej_uslugi_ilosc_m_'.$x;
	$nazwa_wykonanie_innej_uslugi_ilosc_m = 'nazwa_wykonanie_innej_uslugi_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wykonanie_innej_uslugi_ilosc_m.'" value="'.$innej_uslugi_ilosc[$x].'" name="'.$nazwa_wykonanie_innej_uslugi_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wykonanie_innej_uslugi();"></td>';
	//   #################   kolumna bl cena, ID z cennika = 17    ####################################
	$id_cena_wykonanie_innej_uslugi = 'id_cena_wykonanie_innej_uslugi_'.$x;	
	$nazwa_wykonanie_innej_uslugi_cena = 'nazwa_wykonanie_innej_uslugi_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wykonanie_innej_uslugi.'" value="'.$innej_uslugi_cena[$x].'" name="'.$nazwa_wykonanie_innej_uslugi_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wykonanie_innej_uslugi();"></td>';
	//   #################   kolumna bm  wartosc   ####################################
	$id_wykonanie_innej_uslugi_wartosc = 'id_wykonanie_innej_uslugi_wartosc_'.$x;		
	$nazwa_wykonanie_innej_uslugi_wartosc = 'nazwa_wykonanie_innej_uslugi_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wykonanie_innej_uslugi_wartosc.'" value="'.$innej_uslugi_wartosc[$x].'" name="'.$nazwa_wykonanie_innej_uslugi_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	// ##################################################################################################################################################################################
	// #######################################################################  Materia          ###################################################################
	// ##################################################################################################################################################################################

	// #######################################################################  oscieznica	 ###################################################################
	//   #################   kolumna bn ilość  
	$id_oscieznica_ilosc_m = 'id_oscieznica_ilosc_m_'.$x;
	$nazwa_oscieznica_ilosc_m = 'nazwa_oscieznica_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_oscieznica_ilosc_m.'" value="'.$oscieznica_ilosc[$x].'" name="'.$nazwa_oscieznica_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_oscieznica();"></td>';
	//   #################   kolumna bo cena, ID z cennika = 18    ####################################
	$id_cena_oscieznica = 'id_cena_oscieznica_'.$x;	
	$nazwa_oscieznica_cena = 'nazwa_oscieznica_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$oscieznica_cena[$x].'" id="'.$id_cena_oscieznica.'" name="'.$nazwa_oscieznica_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_oscieznica();"></td>';
	//   #################   kolumna bp  wartosc   ####################################
	$id_oscieznica_wartosc = 'id_oscieznica_wartosc_'.$x;		
	$nazwa_oscieznica_wartosc = 'nazwa_oscieznica_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_oscieznica_wartosc.'" value="'.$oscieznica_wartosc[$x].'" name="'.$nazwa_oscieznica_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  skrzydlo	###################################################################
	//   #################   kolumna bq ilość  
	$id_skrzydlo_ilosc_m = 'id_skrzydlo_ilosc_m_'.$x;
	$nazwa_skrzydlo_ilosc_m = 'nazwa_skrzydlo_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_skrzydlo_ilosc_m.'" value="'.$skrzydlo_ilosc[$x].'" name="'.$nazwa_skrzydlo_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_skrzydlo();"></td>';
	//   #################   kolumna br cena, ID z cennika = 19    ####################################
	$id_cena_skrzydlo = 'id_cena_skrzydlo_'.$x;	
	$nazwa_skrzydlo_cena = 'nazwa_skrzydlo_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$skrzydlo_cena[$x].'" id="'.$id_cena_skrzydlo.'" name="'.$nazwa_skrzydlo_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_skrzydlo();"></td>';
	//   #################   kolumna bs  wartosc   ####################################
	$id_skrzydlo_wartosc = 'id_skrzydlo_wartosc_'.$x;		
	$nazwa_skrzydlo_wartosc = 'nazwa_skrzydlo_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_skrzydlo_wartosc.'" value="'.$skrzydlo_wartosc[$x].'" name="'.$nazwa_skrzydlo_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  listwa	##################################################################
	//   #################   kolumna bt ilość  
	$id_listwa_ilosc_m = 'id_listwa_ilosc_m_'.$x;
	$nazwa_listwa_ilosc_m = 'nazwa_listwa_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_listwa_ilosc_m.'" value="'.$listwa_ilosc[$x].'" name="'.$nazwa_listwa_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_listwa();"></td>';
	//   #################   kolumna bu cena, ID z cennika = 20    ####################################
	$id_cena_listwa = 'id_cena_listwa_'.$x;	
	$nazwa_listwa_cena = 'nazwa_listwa_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$listwa_cena[$x].'" id="'.$id_cena_listwa.'" name="'.$nazwa_listwa_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_listwa();"></td>';
	//   #################   kolumna bv  wartosc   ####################################
	$id_listwa_wartosc = 'id_listwa_wartosc_'.$x;		
	$nazwa_listwa_wartosc = 'nazwa_listwa_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_listwa_wartosc.'" value="'.$listwa_wartosc[$x].'" name="'.$nazwa_listwa_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  slupek	 ###################################################################
	//   #################   kolumna bw ilość  
	$id_slupek_ilosc_m = 'id_slupek_ilosc_m_'.$x;
	$nazwa_slupek_ilosc_m = 'nazwa_slupek_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_slupek_ilosc_m.'" value="'.$slupek_ilosc[$x].'" name="'.$nazwa_slupek_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_slupek();"></td>';
	//   #################   kolumna bx cena, ID z cennika = 21    ####################################
	$id_cena_slupek = 'id_cena_slupek_'.$x;	
	$nazwa_slupek_cena = 'nazwa_slupek_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$slupek_cena[$x].'" id="'.$id_cena_slupek.'" name="'.$nazwa_slupek_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_slupek();"></td>';
	//   #################   kolumna by  wartosc   ####################################
	$id_slupek_wartosc = 'id_slupek_wartosc_'.$x;		
	$nazwa_slupek_wartosc = 'nazwa_slupek_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_slupek_wartosc.'" value="'.$slupek_wartosc[$x].'" name="'.$nazwa_slupek_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wzmocnienie_do_ramy	  ###################################################################
	//   #################   kolumna bz ilość  
	$id_wzmocnienie_do_ramy_ilosc_m = 'id_wzmocnienie_do_ramy_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_ramy_ilosc_m = 'nazwa_wzmocnienie_do_ramy_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_ramy_ilosc_m.'" value="'.$wzmocnienie_ramy_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_ramy_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_ramy();"></td>';
	//   #################   kolumna ca cena, ID z cennika = 22    ####################################
	$id_cena_wzmocnienie_do_ramy = 'id_cena_wzmocnienie_do_ramy_'.$x;	
	$nazwa_wzmocnienie_do_ramy_cena = 'nazwa_wzmocnienie_do_ramy_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_ramy_cena[$x].'" id="'.$id_cena_wzmocnienie_do_ramy.'" name="'.$nazwa_wzmocnienie_do_ramy_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_ramy();"></td>';
	//   #################   kolumna cb  wartosc   ####################################
	$id_wzmocnienie_do_ramy_wartosc = 'id_wzmocnienie_do_ramy_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_ramy_wartosc = 'nazwa_wzmocnienie_do_ramy_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_ramy_wartosc.'" value="'.$wzmocnienie_ramy_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_ramy_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wzmocnienie_do_skrzydla	 ###################################################################
	//   #################   kolumna cc ilość  
	$id_wzmocnienie_do_skrzydla_ilosc_m = 'id_wzmocnienie_do_skrzydla_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_skrzydla_ilosc_m = 'nazwa_wzmocnienie_do_skrzydla_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_skrzydla_ilosc_m.'" value="'.$wzmocnienie_skrzydla_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_skrzydla_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_skrzydla();"></td>';
	//   #################   kolumna cd cena, ID z cennika = 23    ####################################
	$id_cena_wzmocnienie_do_skrzydla = 'id_cena_wzmocnienie_do_skrzydla_'.$x;	
	$nazwa_wzmocnienie_do_skrzydla_cena = 'nazwa_wzmocnienie_do_skrzydla_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_skrzydla_cena[$x].'" id="'.$id_cena_wzmocnienie_do_skrzydla.'" name="'.$nazwa_wzmocnienie_do_skrzydla_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_skrzydla();"></td>';
	//   #################   kolumna ce  wartosc   ####################################
	$id_wzmocnienie_do_skrzydla_wartosc = 'id_wzmocnienie_do_skrzydla_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_skrzydla_wartosc = 'nazwa_wzmocnienie_do_skrzydla_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_skrzydla_wartosc.'" value="'.$wzmocnienie_skrzydla_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_skrzydla_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	// #######################################################################  wzmocnienie_do_slupka	###################################################################
	//   #################   kolumna cf ilość  
	$id_wzmocnienie_do_slupka_ilosc_m = 'id_wzmocnienie_do_slupka_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_slupka_ilosc_m = 'nazwa_wzmocnienie_do_slupka_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_slupka_ilosc_m.'" value="'.$wzmocnienie_slupka_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_slupka_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_slupka();"></td>';
	//   #################   kolumna cg cena, ID z cennika = 24    ####################################
	$id_cena_wzmocnienie_do_slupka = 'id_cena_wzmocnienie_do_slupka_'.$x;	
	$nazwa_wzmocnienie_do_slupka_cena = 'nazwa_wzmocnienie_do_slupka_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_slupka_cena[$x].'" id="'.$id_cena_wzmocnienie_do_slupka.'" name="'.$nazwa_wzmocnienie_do_slupka_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_slupka();"></td>';
	//   #################   kolumna ch  wartosc   ####################################
	$id_wzmocnienie_do_slupka_wartosc = 'id_wzmocnienie_do_slupka_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_slupka_wartosc = 'nazwa_wzmocnienie_do_slupka_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_slupka_wartosc.'" value="'.$wzmocnienie_slupka_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_slupka_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  wzmocnienie_do_luku	 ###################################################################
	//   #################   kolumna ci ilość  
	$id_wzmocnienie_do_luku_ilosc_m = 'id_wzmocnienie_do_luku_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_luku_ilosc_m = 'nazwa_wzmocnienie_do_luku_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_luku_ilosc_m.'" value="'.$wzmocnienie_luku_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_luku_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' '.$atrybut_wzmocnienie_okienne_szt_i_m.' onkeyup="Oblicz_wzmocnienie_do_luku();"></td>';
	//   #################   kolumna cj cena, ID z cennika = 25    ####################################
	$id_cena_wzmocnienie_do_luku = 'id_cena_wzmocnienie_do_luku_'.$x;	
	$nazwa_wzmocnienie_do_luku_cena = 'nazwa_wzmocnienie_do_luku_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_luku_cena[$x].'" id="'.$id_cena_wzmocnienie_do_luku.'" name="'.$nazwa_wzmocnienie_do_luku_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_wzmocnienie_do_luku();"></td>';
	//   #################   kolumna ck  wartosc   ####################################
	$id_wzmocnienie_do_luku_wartosc = 'id_wzmocnienie_do_luku_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_luku_wartosc = 'nazwa_wzmocnienie_do_luku_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_luku_wartosc.'" value="'.$wzmocnienie_luku_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_luku_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  okucia	  ###################################################################
	//   #################   kolumna cl ilość  
	$id_okucia_ilosc_m = 'id_okucia_ilosc_m_'.$x;
	$nazwa_okucia_ilosc_m = 'nazwa_okucia_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_okucia_ilosc_m.'" value="'.$okucia_ilosc[$x].'" name="'.$nazwa_okucia_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_okucia();"></td>';
	//   #################   kolumna cm cena, ID z cennika = 26    ####################################
	$id_cena_okucia = 'id_cena_okucia_'.$x;	
	$nazwa_okucia_cena = 'nazwa_okucia_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$okucia_cena[$x].'" id="'.$id_cena_okucia.'" name="'.$nazwa_okucia_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_okucia();"></td>';
	//   #################   kolumna cn  wartosc   ####################################
	$id_okucia_wartosc = 'id_okucia_wartosc_'.$x;		
	$nazwa_okucia_wartosc = 'nazwa_okucia_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_okucia_wartosc.'" value="'.$okucia_wartosc[$x].'" name="'.$nazwa_okucia_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  szyby	 ###################################################################
	//   #################   kolumna co ilość  
	$id_szyby_ilosc_m = 'id_szyby_ilosc_m_'.$x;
	$nazwa_szyby_ilosc_m = 'nazwa_szyby_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_szyby_ilosc_m.'" value="'.$szyby_ilosc[$x].'" name="'.$nazwa_szyby_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_szyby();"></td>';
	//   #################   kolumna cp cena, ID z cennika = 27    ####################################
	$id_cena_szyby = 'id_cena_szyby_'.$x;	
	$nazwa_szyby_cena = 'nazwa_szyby_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$szyby_cena[$x].'" id="'.$id_cena_szyby.'" name="'.$nazwa_szyby_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_szyby();"></td>';
	//   #################   kolumna cq  wartosc   ####################################
	$id_szyby_wartosc = 'id_szyby_wartosc_'.$x;		
	$nazwa_szyby_wartosc = 'nazwa_szyby_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_szyby_wartosc.'" value="'.$szyby_wartosc[$x].'" name="'.$nazwa_szyby_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  inny_element  ###################################################################
	//   #################   kolumna cr ilość  
	$id_inny_element_ilosc_m = 'id_inny_element_ilosc_m_'.$x;
	$nazwa_inny_element_ilosc_m = 'nazwa_inny_element_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_inny_element_ilosc_m.'" value="'.$inny_element_ilosc[$x].'" name="'.$nazwa_inny_element_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_inny_element();"></td>';
	//   #################   kolumna cs cena, ID z cennika = 28    ####################################
	$id_cena_inny_element = 'id_cena_inny_element_'.$x;	
	$nazwa_inny_element_cena = 'nazwa_inny_element_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$inny_element_cena[$x].'" id="'.$id_cena_inny_element.'" name="'.$nazwa_inny_element_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" '.$disabled.' onkeyup="Oblicz_inny_element();"></td>';
	//   #################   kolumna ct  wartosc   ####################################
	$id_inny_element_wartosc = 'id_inny_element_wartosc_'.$x;		
	$nazwa_inny_element_wartosc = 'nazwa_inny_element_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_inny_element_wartosc.'" value="'.$inny_element_wartosc[$x].'" name="'.$nazwa_inny_element_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	// ##################################################################################################################################################################################
	// ##################################################################################################################################################################################
	// #######################################################################  Pozostae wartosci          ###################################################################
	// ##################################################################################################################################################################################
	// ##################################################################################################################################################################################
	
	//   #################   kolumna cu  okna   ####################################
	$id_okna_wartosc = 'id_okna_wartosc_'.$x;	
	$nazwa_okna_wartosc = 'nazwa_okna_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$okna[$x].'" id="'.$id_okna_wartosc.'" name="'.$nazwa_okna_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_okna();">'.$waluta.'</td>';
	
	//   #################   kolumna cv  Drzwi wewntrzne   ####################################
	$id_drzwi_wewnetrzne_wartosc = 'id_drzwi_wewnetrzne_wartosc_'.$x;	
	$nazwa_drzwi_wewnetrzne_wartosc = 'nazwa_drzwi_wewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$drzwi_wewnetrzne[$x].'" id="'.$id_drzwi_wewnetrzne_wartosc.'" name="'.$nazwa_drzwi_wewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_drzwi_wewnetrzne();">'.$waluta.'</td>';

	//   #################   kolumna cw  Drzwi zewntrzne   ####################################
	$id_drzwi_zewnetrzne_wartosc = 'id_drzwi_zewnetrzne_wartosc_'.$x;	
	$nazwa_drzwi_zewnetrzne_wartosc = 'nazwa_drzwi_zewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$drzwi_zewnetrzne[$x].'" id="'.$id_drzwi_zewnetrzne_wartosc.'" name="'.$nazwa_drzwi_zewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_drzwi_zewnetrzne();">'.$waluta.'</td>';
	
	//   #################   kolumna cy  Bramy   ####################################
	$id_bramy_wartosc = 'id_bramy_wartosc_'.$x;	
	$nazwa_bramy_wartosc = 'nazwa_bramy_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$bramy[$x].'" id="'.$id_bramy_wartosc.'" name="'.$nazwa_bramy_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_bramy();">'.$waluta.'</td>';

	//   #################   kolumna cy  Parapety   ####################################
	$id_parapety_wartosc = 'id_parapety_wartosc_'.$x;	
	$nazwa_parapety_wartosc = 'nazwa_parapety_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$parapety[$x].'" id="'.$id_parapety_wartosc.'" name="'.$nazwa_parapety_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_parapety();">'.$waluta.'</td>';
	
	//   #################   kolumna cz  Rolety zewntrzne   ####################################
	$id_rolety_zewnetrzne_wartosc = 'id_rolety_zewnetrzne_wartosc_'.$x;	
	$nazwa_rolety_zewnetrzne_wartosc = 'nazwa_rolety_zewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$rolety_zewnetrzne[$x].'" id="'.$id_rolety_zewnetrzne_wartosc.'" name="'.$nazwa_rolety_zewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_rolety_zewnetrzne();">'.$waluta.'</td>';
				
	//   #################   kolumna da  Rolety wewntrzne   ####################################
	$id_rolety_wewnetrzne_wartosc = 'id_rolety_wewnetrzne_wartosc_'.$x;	
	$nazwa_rolety_wewnetrzne_wartosc = 'nazwa_rolety_wewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$rolety_wewnetrzne[$x].'" id="'.$id_rolety_wewnetrzne_wartosc.'" name="'.$nazwa_rolety_wewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_rolety_wewnetrzne();">'.$waluta.'</td>';

	//   #################   kolumna db  Moskitiery   ####################################
	$id_moskitiery_wartosc = 'id_moskitiery_wartosc_'.$x;	
	$nazwa_moskitiery_wartosc = 'nazwa_moskitiery_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$moskitiery[$x].'" id="'.$id_moskitiery_wartosc.'" name="'.$nazwa_moskitiery_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_moskitiery();">'.$waluta.'</td>';

	//   #################   kolumna dc  Monta   ####################################
	$id_montaz_wartosc = 'id_montaz_wartosc_'.$x;	
	$nazwa_montaz_wartosc = 'nazwa_montaz_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$montaz[$x].'" id="'.$id_montaz_wartosc.'" name="'.$nazwa_montaz_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_montaz();">'.$waluta.'</td>';
	
	//   #################   kolumna dd  Odpady z pvc   ####################################
	$id_odpady_z_pvc_wartosc = 'id_odpady_z_pvc_wartosc_'.$x;	
	$nazwa_odpady_z_pvc_wartosc = 'nazwa_odpady_z_pvc_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$odpady_pvc[$x].'" id="'.$id_odpady_z_pvc_wartosc.'" name="'.$nazwa_odpady_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_odpady_z_pvc();">'.$waluta.'</td>';

	//   #################   kolumna de  Odpady ze stali i alu   ####################################
	$id_odpady_ze_stali_wartosc = 'id_odpady_ze_stali_wartosc_'.$x;	
	$nazwa_odpady_ze_stali_wartosc = 'nazwa_odpady_ze_stali_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$odpady_alu_stal[$x].'" id="'.$id_odpady_ze_stali_wartosc.'" name="'.$nazwa_odpady_ze_stali_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_odpady_ze_stali();">'.$waluta.'</td>';
	
	//   #################   kolumna de  transport   ####################################
	$id_transport_wartosc = 'id_transport_wartosc_'.$x;	
	$nazwa_transport_wartosc = 'nazwa_transport_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$transport[$x].'" id="'.$id_transport_wartosc.'" name="'.$nazwa_transport_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_transport();">'.$waluta.'</td>';
	
	//   #################   kolumna dg  inne   ####################################
	$id_inne_wartosc = 'id_inne_wartosc_'.$x;	
	$nazwa_inne_wartosc = 'nazwa_inne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$inne[$x].'" id="'.$id_inne_wartosc.'" name="'.$nazwa_inne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="Zamien_przecinek_inne();">'.$waluta.'</td>';

	//   #################   kolumna stopien trudnosci  ####################################
	$id_stopien_trudnosci = 'id_stopien_trudnosci'.$x;	
	$nazwa_stopien_trudnosci = 'nazwa_stopien_trudnosci['.$x.']';		
	echo '<td align="center"><select name="'.$nazwa_stopien_trudnosci.'" id="'.$id_stopien_trudnosci.'" class="'.$styl_select.'" style="width: 50px">';
	for ($k=1; $k<=$DLUGOSC_TABELA_STOPIEN_TRUDNOSCI; $k++) 
	if($stopien_trudnosci[$x] == $TABELA_STOPIEN_TRUDNOSCI[$k]) echo '<option selected="selected" value="'.$TABELA_STOPIEN_TRUDNOSCI[$k].'">'.$TABELA_STOPIEN_TRUDNOSCI[$k].'</option>';
	else echo '<option value="'.$TABELA_STOPIEN_TRUDNOSCI[$k].'">'.$TABELA_STOPIEN_TRUDNOSCI[$k].'</option>';
	echo '</select></td>';
	

	// ######################################################################################################################################################################################
	// ######################################################################################################################################################################################
	// ####################################################################################################################################################################################
	// ###################################################################################################################################################################################
	// #################   kolumna DH   nazwa produktu  ################################################
	$produkt_id = [];
	$produkt_opis = [];	
	if($zamowienie_zamkniete == 1)
		{
		echo '<td align="left" width="200px" >'.$nazwa_produktu[$x].'</td>';
		}
	else
		{
		$ilosc_produktow = 0;
		$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC;");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$ilosc_produktow++;
			$produkt_id[$ilosc_produktow] = $wynik2['id'];
			$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
			}
		$nazwa_nazwa_produktu = 'nazwa_nazwa_produktu['.$x.']';	
		$id_nazwa_produktu = 'id_nazwa_produktu_'.$x;
		echo '<td align="center"><select name="'.$nazwa_nazwa_produktu.'" id="'.$id_nazwa_produktu.'" onchange="CzyMoznaZapisac();" class="'.$styl_select.'" style="width: 200px" '.$disabled.'>';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_produktow; $k++) 
		if($nazwa_produktu[$x] == $produkt_opis[$k]) echo '<option selected="selected" value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
		else echo '<option value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
		echo '</select></td>';
		}
	//   #################   kolumna DI    Cena netto za sztuke  ####################################
	$id_cena_netto_za_sztuke = 'id_cena_netto_za_sztuke_'.$x;	
	$nazwa_cena_netto_za_sztuke = 'nazwa_cena_netto_za_sztuke['.$x.']';
	echo '<td align="center" bgcolor="#ccffcc"><input type="text" value="'.$cena_netto_za_sztuke[$x].'" id="'.$id_cena_netto_za_sztuke.'" name="'.$nazwa_cena_netto_za_sztuke.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_zielone_ramka">'.$waluta.'</td>';

	//   #################   kolumna DJ    ilosc sztuk  ####################################
	$id_ilosc_sztuk = 'id_ilosc_sztuk_'.$x;
	$nazwa_ilosc_sztuk = 'nazwa_ilosc_sztuk['.$x.']';	
	echo '<td align="center"><input type="text" TABINDEX="'.$x.'" value="'.$ilosc_sztuk[$x].'" id="'.$id_ilosc_sztuk.'" name="'.$nazwa_ilosc_sztuk.'" onkeyup="ObliczNettoZaSztuke();" size="3" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	
	//   #################   kolumna DK    wartosc netto  ####################################
	$id_wartosc_netto = 'id_wartosc_netto_'.$x;		
	$nazwa_wartosc_netto = 'nazwa_wartosc_netto['.$x.']';	
	echo '<td align="center" bgcolor="#ffcc99"><input type="text" id="'.$id_wartosc_netto.'" value="'.$wartosc_netto[$x].'" name="'.$nazwa_wartosc_netto.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
	
	//   #################   kolumna DL    VAT  ####################################
	$id_vat = 'id_vat_'.$x;		
	$nazwa_vat = 'nazwa_vat['.$x.']';	
	echo '<td bgcolor="#ffcc99" align="center"><select name="'.$nazwa_vat.'" id="'.$id_vat.'" class="pole_select_pomaranczowe_z_ramka" style="width: 50px" onchange="ObliczWartoscBrutto();" '.$disabled.'>';
	for ($k=1; $k<=$TAB_VAT_DL; $k++) if($vat_baza[$x] == $TAB_VAT[$k]) echo '<option selected="selected" value="'.$vat_baza[$x].'">'.$TAB_VAT[$k].'</option>';
	else echo '<option value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>'; 
	echo '</select></td>';
	
	//   #################   kolumna DM    wartosc brutto  ####################################
	$id_wartosc_brutto = 'id_wartosc_brutto_'.$x;		
	$nazwa_wartosc_brutto = 'nazwa_wartosc_brutto['.$x.']';	
	echo '<td align="center" bgcolor="#ff99cc"><input type="text" id="'.$id_wartosc_brutto.'" value="'.$wartosc_brutto[$x].'" name="'.$nazwa_wartosc_brutto.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';	
	
	//   #################   kolumna DN    nr faktury  ####################################
	$id_nr_faktury = 'id_nr_faktury_'.$x;		
	$nazwa_nr_faktury = 'nazwa_nr_faktury['.$x.']';	
	if($x == 1) echo '<td align="center"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" value="'.$nr_faktury[$x].'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onchange="Skopiuj_nr_faktury();" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	else echo '<td align="center"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" value="'.$nr_faktury[$x].'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onkeyup="Skasuj_date_faktury('.$x.');"  autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	
	//   #################   kolumna DO    data faktury  ####################################
	$id_data_faktury = 'id_data_faktury_'.$x;		
	$nazwa_data_faktury = 'nazwa_data_faktury['.$x.']';	
	if($x == 1) echo '<td align="center"><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" value="'.$data_faktury[$x].'" size="10" onchange="Skopiuj_date_faktury();" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	else echo '<td align="center"><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" value="'.$data_faktury[$x].'" size="10" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
	
	?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "<?php echo $id_data_faktury; ?>",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_date_c",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	<?php

	//   #################   kolumna DP    uwagi  ####################################
	$nazwa_uwagi = 'nazwa_uwagi['.$x.']';	
	echo '<td align="center"><textarea name="'.$nazwa_uwagi.'" TABINDEX="'.$x.'" cols="20" rows="1" class="'.$styl_uwagi.'" '.$disabled.'>'.$uwagi[$x].'</textarea></td></tr>';
	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)

	//   #########################################################################################################################
	//   #########################################################################################################################
	//    wyswietlanie pozycji transportowej
	//   #########################################################################################################################
	//   #########################################################################################################################
	//$pozycja_transport_juz_jest = 0;
	$temp_ilosc_pozycji = $ilosc_pozycji + 1;

	if(isset($pozycja_transport[$temp_ilosc_pozycji]))
	if($pozycja_transport[$temp_ilosc_pozycji] == 'tak')
		{
		//$pozycja_transport_juz_jest = 1;
		$x = $ilosc_pozycji + 1;
		if($x%2)
			{	
			$wiersz = $kolor_bialy;
			if($zamowienie_zamkniete == 0) $styl = "pole_input_biale_ramka"; else $styl = "pole_input_biale_bez_ramki"; 
			$styl_select = "pole_select_biale_z_ramka"; 
			}
		else 
			{
			$wiersz = $kolor_szary;
			if($zamowienie_zamkniete == 0) $styl = "pole_input_szare_ramka"; else $styl = "pole_input_szare_bez_ramki"; 
			$styl_select = "pole_select_szare_z_ramka"; 
			}

		echo '<tr bgcolor="'.$wiersz.'" align="center" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">';
			echo '<table class="text" border="0" cellpadding="2" cellspacing="2"><tr><td>';
				echo $x.'/'.$x;
				if($zamowienie_zamkniete == 0) if($nr_faktury[$x] == '') echo '</td><td><a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&usun_pozycje='.$pozycja_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_delete.'</a>';
			echo '</td></tr></table>';
		echo '</td>';

		echo '<td align="left" colspan="115" class="text"></td>';

		//   #################   kolumna DE  transport   ####################################
		echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="id_pozycja_transport_wartosc" value="'.$transport[$x].'" name="nazwa_pozycja_transport_wartosc" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="'.$styl_zolte_pola.'"  '.$disabled.' onkeyup="ObliczWartoscNettoPozycjaTransport();">'.$waluta.'</td>';
		
		echo '<td align="left" colspan="4" class="text"></td>';
		//   #################   kolumna DK    wartosc netto  ####################################
		echo '<td align="center" bgcolor="#ffcc99"><input type="text" id="id_wartosc_netto_pozycja_transport" value="'.$wartosc_netto[$x].'" name="nazwa_wartosc_netto_pozycja_transport" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
		
		//   #################   kolumna DL    VAT  ####################################
		echo '<td bgcolor="#ffcc99" align="center"><select name="nazwa_vat_pozycja_transport" id="id_vat_pozycja_transport" class="pole_select_pomaranczowe_z_ramka" style="width: 50px" onchange="ObliczWartoscNettoPozycjaTransport();" '.$disabled.'>';
		for ($k=1; $k<=$TAB_VAT_DL; $k++) if($vat_baza[$x] == $TAB_VAT[$k]) echo '<option selected="selected" value="'.$vat_baza[$x].'">'.$TAB_VAT[$k].'</option>';
		else echo '<option value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>'; 
		echo '</select></td>';

		//   #################   kolumna DM    wartosc brutto  ####################################
		echo '<td align="center" bgcolor="#ff99cc"><input type="text" id="id_wartosc_brutto_pozycja_transport" value="'.$wartosc_brutto[$x].'" name="nazwa_wartosc_brutto_pozycja_transport" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';

		//   #################   kolumna DN    nr faktury  ####################################
		$id_nr_faktury = 'id_nr_faktury_'.$x;		
		$nazwa_nr_faktury = 'nazwa_nr_faktury['.$x.']';	
		echo '<td align="center"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" id="'.$id_nr_faktury.'" value="'.$nr_faktury[$x].'" size="10" maxlenght="50" onkeyup="Skasuj_date_faktury('.$x.');" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';
		
		//   #################   kolumna DO    data faktury  ####################################
		$id_data_faktury = 'id_data_faktury_'.$x;		
		$nazwa_data_faktury = 'nazwa_data_faktury['.$x.']';	
		echo '<td align="center"><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" value="'.$data_faktury[$x].'" size="10" autocomplete="off" class="'.$styl.'" '.$disabled.'></td>';

		?>
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "<?php echo $id_data_faktury; ?>",     // id of the input field
				ifFormat       :    "%d-%m-%Y",      // format of the input field
				button         :    "f_date_c",  // trigger for the calendar (button ID)
				singleClick    :    true
			});
		</script>
		<?php

		echo '<td align="left" class="text"></td>';
		echo '</tr>';
		}
	else echo '<input type="hidden" id="id_wartosc_netto_pozycja_transport" name="nazwa_wartosc_netto_pozycja_transport">';	// to musi by bo nie dziaa sumowanie netto i brutto



	echo '<tr><td style="background-color:#ffffff; border-bottom-color:#ffffff; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>'; //pozycja
	// $nowa_ilosc_pozycji = $temp_ilosc_pozycji + 1;
	$link = 'index.php?page=wycena_edycja&nowa_pozycja=tak&jak='.$jak.'&wg_czego='.$wg_czego.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&zamowienie_id='.$zamowienie_id;
	$link2 = 'index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&skad='.$skad.'&id_zlec_transp='.$id_zlec_transp.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&dodaj_pozycje_transport=tak';
	
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;">';

	if($zamowienie_zamkniete == 0) echo '<a href="'.$link.'">Dodaj kolejną pozycję</a>';
	echo '</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;">';

// echo '$temp_ilosc_pozycji='.$temp_ilosc_pozycji.'<br>';
// 	echo '$pozycja_transport[$temp_ilosc_pozycji] ='.$pozycja_transport[$temp_ilosc_pozycji] .'<br>';
// 	echo '$pozycja_transport ='.$pozycja_transport .'<br>';

	if(($pozycja_transport[$temp_ilosc_pozycji] != 'tak') && ($zamowienie_zamkniete == 0)) echo '<a href="'.$link2.'">Dodaj pozycję transportową</a>';
	echo '</td>';
	
	//echo 'zapisz_disabled_licz='.$zapisz_disabled_licz.'<br>';
	if($zapisz_disabled_licz == $ilosc_pozycji*2) $zapisz_disabled = ''; else $zapisz_disabled = 'disabled';
	if($zamowienie_zamkniete == 1) $zapisz_disabled = 'disabled';

	echo '<td align="center" colspan="37" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" '.$zapisz_disabled.' id="zapisz1" name="submit" value="Zapisz"></td>';
	echo '<td align="center" colspan="32" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" '.$zapisz_disabled.' id="zapisz2" name="submit" value="Zapisz"></td>';
	echo '<td align="center" colspan="30" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"><input type="submit" TABINDEX="'.$x.'" '.$zapisz_disabled.' id="zapisz3" name="submit" value="Zapisz"></td>';
	$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.','');
	echo '<td align="center" bgcolor="#ffcc99" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;"><input type="text" id="id_suma_netto" value="'.$SUMA_NETTO.'" name="nazwa_suma_netto" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
	echo '<td align="center" bgcolor="#ff99cc" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;"><input type="text" id="id_suma_brutto" value="'.$SUMA_BRUTTO.'" name="nazwa_suma_brutto" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';
	
	$typ_zamowienia = '';
	//sprawdzamy czy zamowienie nie jest raklamacja
	if($zamowienie_id != '')
	{
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT typ FROM zamowienia WHERE id = ".$zamowienie_id.";"));
		$typ_zamowienia = $sql['typ'];
	}
	
	echo '<input type="text" id="status" value="'.$status_zamowienia.'">';

	
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;">';
		
	if(($zamowienie_zamkniete == 0) && ($ilosc_pozycji_z_faktura != $calkowita_ilosc_pozycji)) echo '<a href="index.php?page=fv_wystaw_rodzaj_dokumentu&zamowienie_id='.$zamowienie_id.'&wg_czego='.$wg_czego.'&jak='.$jak.'&skad='.$skad.'&id_zlec_transp='.$id_zlec_transp.'">'.$image_wystaw_fv.'</a>';
// echo '$wycena_wstepna_nr='.$wycena_wstepna_nr.'<br>';
// echo '$zamowienie_id='.$zamowienie_id.'<br>';
	
	// sprawdzamy ile jest numerow faktur dla tego zamowienia
	if($zamowienie_id != '')
	// if(($wycena_wstepna_nr != '') && ($zamowienie_id != ''))
	{
		$ile_roznych_faktur = 0;
		$pytanie = mysqli_query($conn, "SELECT DISTINCT nr_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND nr_faktury <> '' AND korekta_fv = 'NIE' ;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ile_roznych_faktur++;
			$rozne_faktury[$ile_roznych_faktur]=$wynik['nr_faktury'];
			//sprawdzamy nr fv, czy to nie jest juz korekta
			if (preg_match("/K/", $rozne_faktury[$ile_roznych_faktur])) $czy_to_korekta[$ile_roznych_faktur] = 'TAK'; else $czy_to_korekta[$ile_roznych_faktur] = 'NIE';
			}


		// echo '$ile_roznych_faktur='.$ile_roznych_faktur.'<br>';

		// echo 'czy_to_korekta[1]='.$czy_to_korekta[1].'<br>';


		if(($ile_roznych_faktur == 1) && ($czy_to_korekta[1] == 'NIE')) echo '<a href="index.php?page=wycena_edycja_korekta_fv&zamowienie_id='.$zamowienie_id.'&wg_czego='.$wg_czego.'&jak='.$jak.'&skad='.$skad.'&id_zlec_transp='.$id_zlec_transp.'&faktura_do_korekty='.$rozne_faktury[1].'&calkowita_ilosc_pozycji='.$temp_ilosc_pozycji.'">'.$image_wystaw_korekte_fv.'</a>';
		else
			{
			echo '<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="text">';
			for($f = 1; $f<= $ile_roznych_faktur; $f++)	
				{
				if(($czy_to_korekta[$f] == 'NIE') && ($zamowienie_zamkniete == 0))
					{
					echo '<tr align="center" valign="middle" height="25px"><td>';
					echo '<a href="index.php?page=wycena_edycja_korekta_fv&zamowienie_id='.$zamowienie_id.'&wg_czego='.$wg_czego.'&jak='.$jak.'&skad='.$skad.'&id_zlec_transp='.$id_zlec_transp.'&faktura_do_korekty='.$rozne_faktury[$f].'&calkowita_ilosc_pozycji='.$temp_ilosc_pozycji.'">'.$image_wystaw_korekte_fv.'</a></td><td>';
					echo '<a href="index.php?page=wycena_edycja_korekta_fv&zamowienie_id='.$zamowienie_id.'&wg_czego='.$wg_czego.'&jak='.$jak.'&skad='.$skad.'&id_zlec_transp='.$id_zlec_transp.'&faktura_do_korekty='.$rozne_faktury[$f].'&calkowita_ilosc_pozycji='.$temp_ilosc_pozycji.'">'.$rozne_faktury[$f].'</a></td></tr>';
					}
				}
			echo '</table>';
			}
	}
	echo '</td>';
	
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" '.$zapisz_disabled.' id="zapisz4" name="submit" value="Zapisz"></td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;">';
		if($zamowienie_zamkniete == 0) echo '<input type="checkbox" '.$disabled.' name="zmienic_cennik_klienta">Zmienić cennik klienta?';
	echo '</td></tr>';
	
	echo '</form>';
echo '</table>'; // koniec tabeli gwnej

//if($user_id == 1) echo '<div align="left"><a href="index.php?page=fv_wystaw_rodzaj_dokumentu&zamowienie_id='.$zamowienie_id.'&wg_czego='.$wg_czego.'&jak='.$jak.'&skad='.$skad.'&id_zlec_transp='.$id_zlec_transp.'">tylko ja'.$image_wystaw_fv.'</a></div>';

$link_do_drukwoania = '<br><a href="php/drukuj/drukuj_wycena.php?zamowienie_id='.$zamowienie_id.'" target="_blank">'.$image_printer.'</a>';
$link_do_drukwoania_wycenny_wstepnej = '<br><a href="php/drukuj/drukuj_wycena.php?wycena_wstepna='.$wycena_wstepna_nr.'" target="_blank">'.$image_printer.'</a>';
if($wycena_wstepna_nr != '')
	{
	echo '<table border="0" width="100%"><tr align="center">';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
		echo '<td width="10%">'.$powrot_do_wycen_wstepnej.$link_do_drukwoania_wycenny_wstepnej.'</td>';
	echo '</tr></table>';
	}
elseif($skad == 'zlecenie_transportowe')
	{
	echo '<table border="0" width="100%"><tr align="center">';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.$link_do_drukwoania.'</td>';
	echo '</tr></table>';
	}
elseif($skad == 'fakturowanie')
	{
	echo '<table border="0" width="100%"><tr align="center">';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_fakturowania.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_fakturowania.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_fakturowania.$link_do_drukwoania.'</td>';
	echo '</tr></table>';
	}
else
	{
	// dla zwyklych wycen
	echo '<table border="0" width="100%"><tr align="center">';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.$link_do_drukwoania.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.$link_do_drukwoania.'</td>';
	echo '</tr></table>';
	}
} // do else

?>