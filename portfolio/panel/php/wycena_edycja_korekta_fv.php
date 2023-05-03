<?php

$SORTOWANIE_DIV = '&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'';

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
	$SUMA_okuwanie = 0;
	$SUMA_szklenie = 0;
	$SUMA_dociecie_listwy = 0;
	// zapis danych do bazy

	// zmieniam poprzednią wycenę na korektę - brak możliwości dalszej edycji
	$pytanie102 = mysqli_query($conn, "UPDATE wyceny SET korekta_fv = 'TAK' WHERE zamowienie_id = ".$zamowienie_id." AND nr_faktury = '".$faktura_do_korekty."';"); // dodajemy do starej wyceny info że jest do niej korekta
	
	//szukamy nr pozycji do któraj jest korekta
	//echo 'faktura_do_korekty='.$faktura_do_korekty.'<br>';
	$licz_nr_pozycji = 0;


	$pytanie33 = mysqli_query($conn, "SELECT * FROM wyceny WHERE nr_faktury = '".$faktura_do_korekty."' ORDER BY pozycja ASC;");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$licz_nr_pozycji++;
		$nr_pozycji[$licz_nr_pozycji]=$wynik33['pozycja'];
		$nr_pozycji_transport=$wynik33['pozycja_transport'];
		if($nr_pozycji_transport == 'tak') $nr_pozycji_transport = $nr_pozycji[$licz_nr_pozycji];
		}
	
	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		// zamiana ewentualnych przecinków na kropki
		if($nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i] != '') $nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i] = change($nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i]);
		if($nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i] != '') $nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i] = change($nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i]);
		if($nazwa_wygiecie_listwy_z_pvc_ilosc_szt[$i] != '') $nazwa_wygiecie_listwy_z_pvc_ilosc_szt[$i] = change($nazwa_wygiecie_listwy_z_pvc_ilosc_szt[$i]);
		if($nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i] != '') $nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i] = change($nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i]);
		if($nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i] != '') $nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i] = change($nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i]);
		if($nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i] != '') $nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i] = change($nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i]);
		if($nazwa_wygiecie_listwy_z_alu_ilosc_szt[$i] != '') $nazwa_wygiecie_listwy_z_alu_ilosc_szt[$i] = change($nazwa_wygiecie_listwy_z_alu_ilosc_szt[$i]);
		if($nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i] != '') $nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i] = change($nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i]);
		if($nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i] != '') $nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i] = change($nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i]);
		if($nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i] != '') $nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i] = change($nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i]);
		
		// dodanie nowych wpisów w wycenach
		if($pozycja_transport == 'tak') $nowa_ilosc_pozycji = $ilosc_pozycji + 1; 
		else $nowa_ilosc_pozycji = $ilosc_pozycji;//jezeli jest pozycja transportowa to zwiekszamy ilosc pozycji
		
		
		$pytanie1 = mysqli_query($conn, "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `status` 
		,`wygiecie_ramy_pvc_ilosc_szt`, `wygiecie_ramy_pvc_ilosc_m`, `wygiecie_ramy_pvc_cena`, `wygiecie_ramy_pvc_wartosc`
		,`wygiecie_skrzydla_pvc_ilosc_szt`, `wygiecie_skrzydla_pvc_ilosc_m`, `wygiecie_skrzydla_pvc_cena`, `wygiecie_skrzydla_pvc_wartosc`
		,`wygiecie_listwy_pvc_ilosc_szt`, `wygiecie_listwy_pvc_ilosc_m`, `wygiecie_listwy_pvc_cena`, `wygiecie_listwy_pvc_wartosc`
		,`wygiecie_innego_pvc_ilosc_szt`, `wygiecie_innego_pvc_ilosc_m`, `wygiecie_innego_pvc_cena`, `wygiecie_innego_pvc_wartosc`
		
		,`wygiecie_ramy_alu_ilosc_szt`, `wygiecie_ramy_alu_ilosc_m`, `wygiecie_ramy_alu_cena`, `wygiecie_ramy_alu_wartosc`
		,`wygiecie_skrzydla_alu_ilosc_szt`, `wygiecie_skrzydla_alu_ilosc_m`, `wygiecie_skrzydla_alu_cena`, `wygiecie_skrzydla_alu_wartosc`
		,`wygiecie_listwy_alu_ilosc_szt`, `wygiecie_listwy_alu_ilosc_m`, `wygiecie_listwy_alu_cena`, `wygiecie_listwy_alu_wartosc`
		,`wygiecie_innego_alu_ilosc_szt`, `wygiecie_innego_alu_ilosc_m`, `wygiecie_innego_alu_cena`, `wygiecie_innego_alu_wartosc`
		
		,`wygiecie_wzmocnienia_okiennego_ilosc_szt`, `wygiecie_wzmocnienia_okiennego_ilosc_m`, `wygiecie_wzmocnienia_okiennego_cena`, `wygiecie_wzmocnienia_okiennego_wartosc`
		,`wygiecie_innego_ilosc_szt`, `wygiecie_innego_ilosc_m`, `wygiecie_innego_cena`, `wygiecie_innego_wartosc`
		
		,`zgrzanie_ilosc`, `zgrzanie_cena`, `zgrzanie_wartosc` ,`wyfrezowanie_odwodnienia_ilosc`, `wyfrezowanie_odwodnienia_cena`, `wyfrezowanie_odwodnienia_wartosc`
		,`wstawienie_slupka_ilosc`, `wstawienie_slupka_cena`, `wstawienie_slupka_wartosc` ,`listwa_przyszybowa_ilosc`, `listwa_przyszybowa_cena`, `listwa_przyszybowa_wartosc`
		,`okucie_ilosc`, `okucie_cena`, `okucie_wartosc` ,`zaszklenie_ilosc`, `zaszklenie_cena`, `zaszklenie_wartosc` ,`innej_uslugi_ilosc`, `innej_uslugi_cena`, `innej_uslugi_wartosc`
		
		,`oscieznica_ilosc`, `oscieznica_cena`, `oscieznica_wartosc` ,`skrzydlo_ilosc`, `skrzydlo_cena`, `skrzydlo_wartosc`
		,`listwa_ilosc`, `listwa_cena`, `listwa_wartosc` ,`slupek_ilosc`, `slupek_cena`, `slupek_wartosc`
		,`wzmocnienie_ramy_ilosc`, `wzmocnienie_ramy_cena`, `wzmocnienie_ramy_wartosc` ,`wzmocnienie_skrzydla_ilosc`, `wzmocnienie_skrzydla_cena`, `wzmocnienie_skrzydla_wartosc`
		,`wzmocnienie_slupka_ilosc`, `wzmocnienie_slupka_cena`, `wzmocnienie_slupka_wartosc` ,`wzmocnienie_luku_ilosc`, `wzmocnienie_luku_cena`, `wzmocnienie_luku_wartosc`
		,`okucia_ilosc`, `okucia_cena`, `okucia_wartosc` ,`szyby_ilosc`, `szyby_cena`, `szyby_wartosc` ,`inny_element_ilosc`, `inny_element_cena`, `inny_element_wartosc`
		
		,`okna`, `drzwi_wewnetrzne`, `drzwi_zewnetrzne` ,`bramy`, `parapety`, `rolety_zewnetrzne` ,`rolety_wewnetrzne`, `moskitiery`, `montaz` ,`odpady_pvc`, `odpady_alu_stal`, `transport`, `inne`
		,`nazwa_produktu`, `cena_netto_za_sztuke` ,`ilosc_sztuk`, `wartosc_netto`, `vat` ,`wartosc_brutto`, `nr_faktury`, `uwagi`, `korekta_fv`)


		values ('$klient', '$klient_nazwa', '$zamowienie_id', '$nr_zamowienia', '$calkowita_ilosc_pozycji', '$nr_pozycji[$i]', 'nie', '$status'
		, '$nazwa_wygiecie_ramy_z_pvc_ilosc_szt[$i]', '$nazwa_wygiecie_ramy_z_pvc_ilosc_m[$i]', '$nazwa_wygiecie_ramy_z_pvc_cena[$i]', '$nazwa_wygiecie_ramy_z_pvc_wartosc[$i]'
		, '$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt[$i]', '$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m[$i]', '$nazwa_wygiecie_skrzydla_z_pvc_cena[$i]', '$nazwa_wygiecie_skrzydla_z_pvc_wartosc[$i]'
		, '$nazwa_wygiecie_listwy_z_pvc_ilosc_szt[$i]', '$nazwa_wygiecie_listwy_z_pvc_ilosc_m[$i]', '$nazwa_wygiecie_listwy_z_pvc_cena[$i]', '$nazwa_wygiecie_listwy_z_pvc_wartosc[$i]'
		, '$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt[$i]', '$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m[$i]', '$nazwa_wygiecie_innego_elementu_z_pvc_cena[$i]', '$nazwa_wygiecie_innego_elementu_z_pvc_wartosc[$i]'
		
		, '$nazwa_wygiecie_ramy_z_alu_ilosc_szt[$i]', '$nazwa_wygiecie_ramy_z_alu_ilosc_m[$i]', '$nazwa_wygiecie_ramy_z_alu_cena[$i]', '$nazwa_wygiecie_ramy_z_alu_wartosc[$i]'
		, '$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt[$i]', '$nazwa_wygiecie_skrzydla_z_alu_ilosc_m[$i]', '$nazwa_wygiecie_skrzydla_z_alu_cena[$i]', '$nazwa_wygiecie_skrzydla_z_alu_wartosc[$i]'
		, '$nazwa_wygiecie_listwy_z_alu_ilosc_szt[$i]', '$nazwa_wygiecie_listwy_z_alu_ilosc_m[$i]', '$nazwa_wygiecie_listwy_z_alu_cena[$i]', '$nazwa_wygiecie_listwy_z_alu_wartosc[$i]'
		, '$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt[$i]', '$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m[$i]', '$nazwa_wygiecie_innego_elementu_z_alu_cena[$i]', '$nazwa_wygiecie_innego_elementu_z_alu_wartosc[$i]'
		
		, '$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt[$i]', '$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m[$i]', '$nazwa_wygiecie_wzmocnienia_okiennego_cena[$i]', '$nazwa_wygiecie_wzmocnienia_okiennego_wartosc[$i]'
		, '$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt[$i]', '$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m[$i]', '$nazwa_wygiecie_innego_elementu_ze_stali_cena[$i]', '$nazwa_wygiecie_innego_elementu_ze_stali_wartosc[$i]'
		
		, '$nazwa_zgrzanie_ilosc_m[$i]', '$nazwa_zgrzanie_cena[$i]', '$nazwa_zgrzanie_wartosc[$i]'
		, '$nazwa_wyfrezowanie_odwodnienia_ilosc_m[$i]', '$nazwa_wyfrezowanie_odwodnienia_cena[$i]', '$nazwa_wyfrezowanie_odwodnienia_wartosc[$i]'
		, '$nazwa_wstawienie_slupka_ilosc_m[$i]', '$nazwa_wstawienie_slupka_cena[$i]', '$nazwa_wstawienie_slupka_wartosc[$i]'
		, '$nazwa_dociecie_listwy_przyszybowej_ilosc_m[$i]', '$nazwa_dociecie_listwy_przyszybowej_cena[$i]', '$nazwa_dociecie_listwy_przyszybowej_wartosc[$i]'
		, '$nazwa_okucie_ilosc_m[$i]', '$nazwa_okucie_cena[$i]', '$nazwa_okucie_wartosc[$i]'
		, '$nazwa_zaszklenie_ilosc_m[$i]', '$nazwa_zaszklenie_cena[$i]', '$nazwa_zaszklenie_wartosc[$i]'
		, '$nazwa_wykonanie_innej_uslugi_ilosc_m[$i]', '$nazwa_wykonanie_innej_uslugi_cena[$i]', '$nazwa_wykonanie_innej_uslugi_wartosc[$i]'
		
		, '$nazwa_oscieznica_ilosc_m[$i]', '$nazwa_oscieznica_cena[$i]', '$nazwa_oscieznica_wartosc[$i]'
		, '$nazwa_skrzydlo_ilosc_m[$i]', '$nazwa_skrzydlo_cena[$i]', '$nazwa_skrzydlo_wartosc[$i]'
		, '$nazwa_listwa_ilosc_m[$i]', '$nazwa_listwa_cena[$i]', '$nazwa_listwa_wartosc[$i]' , '$nazwa_slupek_ilosc_m[$i]', '$nazwa_slupek_cena[$i]', '$nazwa_slupek_wartosc[$i]'
		, '$nazwa_wzmocnienie_do_ramy_ilosc_m[$i]', '$nazwa_wzmocnienie_do_ramy_cena[$i]', '$nazwa_wzmocnienie_do_ramy_wartosc[$i]'
		, '$nazwa_wzmocnienie_do_skrzydla_ilosc_m[$i]', '$nazwa_wzmocnienie_do_skrzydla_cena[$i]', '$nazwa_wzmocnienie_do_skrzydla_wartosc[$i]'
		, '$nazwa_wzmocnienie_do_slupka_ilosc_m[$i]', '$nazwa_wzmocnienie_do_slupka_cena[$i]', '$nazwa_wzmocnienie_do_slupka_wartosc[$i]'
		, '$nazwa_wzmocnienie_do_luku_ilosc_m[$i]', '$nazwa_wzmocnienie_do_luku_cena[$i]', '$nazwa_wzmocnienie_do_luku_wartosc[$i]'
		, '$nazwa_okucia_ilosc_m[$i]', '$nazwa_okucia_cena[$i]', '$nazwa_okucia_wartosc[$i]' , '$nazwa_szyby_ilosc_m[$i]', '$nazwa_szyby_cena[$i]', '$nazwa_szyby_wartosc[$i]'
		, '$nazwa_inny_element_ilosc_m[$i]', '$nazwa_inny_element_cena[$i]', '$nazwa_inny_element_wartosc[$i]'
		
		, '$nazwa_okna_wartosc[$i]', '$nazwa_drzwi_wewnetrzne_wartosc[$i]', '$nazwa_drzwi_zewnetrzne_wartosc[$i]' , '$nazwa_bramy_wartosc[$i]', '$nazwa_parapety_wartosc[$i]', '$nazwa_rolety_zewnetrzne_wartosc[$i]'
		, '$nazwa_rolety_wewnetrzne_wartosc[$i]', '$nazwa_moskitiery_wartosc[$i]', '$nazwa_montaz_wartosc[$i]' , '$nazwa_odpady_z_pvc_wartosc[$i]', '$nazwa_odpady_ze_stali_wartosc[$i]', '$nazwa_transport_wartosc[$i]', '$nazwa_inne_wartosc[$i]' 
		
		, '$nazwa_nazwa_produktu[$i]', '$nazwa_cena_netto_za_sztuke[$i]', '$nazwa_ilosc_sztuk[$i]', '$nazwa_wartosc_netto[$i]', '$nazwa_vat[$i]' , '$nazwa_wartosc_brutto[$i]', 'korekta', '$nazwa_uwagi[$i]', 'NIE');");
		
		// sumowanie łukóww itp do tabeli zamówienia
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
		
		$SUMA_wartosc_netto += $nazwa_wartosc_netto[$i];
		$SUMA_wartosc_brutto += $nazwa_wartosc_brutto[$i];

		} // do for($i = 1; $i <= $ilosc_pozycji; $i++

		if($pozycja_transport == 'tak')
			{
			// rozbicie daty faktury na time
			if($nazwa_data_faktury[$nowa_ilosc_pozycji] != '') 
				{
				$pieces = explode("-", $nazwa_data_faktury[$i]);		
				$data_faktury_time[$i] = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
				$data_faktury_miesiac = $pieces[1];
				$data_faktury_rok = $pieces[2];
				if($data_faktury_miesiac != 10) $data_faktury_miesiac = zamien_dowolne_znaki($data_faktury_miesiac, '0', '');
				}
			$SUMA_wartosc_netto += $nazwa_wartosc_netto_pozycja_transport;
			$SUMA_wartosc_brutto += $nazwa_wartosc_brutto_pozycja_transport;
			
			$pytanie1 = mysqli_query($conn, "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `status`, `transport`, `wartosc_netto`, `vat` ,`wartosc_brutto`, `nr_faktury`, `korekta_fv`)
			values ('$klient_id', '$klient_nazwa', '$zamowienie_id', '$nr_zamowienia', '$calkowita_ilosc_pozycji', '$nr_pozycji_transport', 'tak', '$status', '$nazwa_pozycja_transport_wartosc', '$nazwa_wartosc_netto_pozycja_transport', '$nazwa_vat_pozycja_transport', '$nazwa_wartosc_brutto_pozycja_transport', 'korekta', 'NIE');");
			}

			//zmiana danych dla bazy zamówienia
			$pytanie100 = mysqli_query($conn, "UPDATE zamowienia SET sztuki = ".$SUMA_sztuki." WHERE id = ".$zamowienie_id.";");
			$pytanie101 = mysqli_query($conn, "UPDATE zamowienia SET luki_pvc = ".$SUMA_luki_pvc." WHERE id = ".$zamowienie_id.";");
			$pytanie102 = mysqli_query($conn, "UPDATE zamowienia SET luki_stal = ".$SUMA_luki_stal." WHERE id = ".$zamowienie_id.";");
			$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET luki_alu = ".$SUMA_luki_alu." WHERE id = ".$zamowienie_id.";");
			$pytanie104 = mysqli_query($conn, "UPDATE zamowienia SET zgrzewy = ".$SUMA_zgrzewy." WHERE id = ".$zamowienie_id.";");
			$pytanie105 = mysqli_query($conn, "UPDATE zamowienia SET odwodnienia = ".$SUMA_odwodnienia." WHERE id = ".$zamowienie_id.";");
			$pytanie106 = mysqli_query($conn, "UPDATE zamowienia SET slupki = ".$SUMA_slupki." WHERE id = ".$zamowienie_id.";");
			$pytanie107 = mysqli_query($conn, "UPDATE zamowienia SET okuwanie = ".$SUMA_okuwanie." WHERE id = ".$zamowienie_id.";");
			$pytanie108 = mysqli_query($conn, "UPDATE zamowienia SET szklenie = ".$SUMA_szklenie." WHERE id = ".$zamowienie_id.";");
			$pytanie109 = mysqli_query($conn, "UPDATE zamowienia SET dociecie_listwy = ".$SUMA_dociecie_listwy." WHERE id = ".$zamowienie_id.";");
			
			// sprawdzamy czy istnieja pozycje ktore nie sa w tej korekcie
			$wartosc_netto = 0;
			$wartosc_brutto = 0;
			$pytanie1 = mysqli_query($conn, "SELECT wartosc_netto, wartosc_brutto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE';");
			while($wynik1= mysqli_fetch_assoc($pytanie1))
				{
				$wartosc_netto_fv = $wynik1['wartosc_netto'];
				$wartosc_brutto_fv = $wynik1['wartosc_brutto'];
				$wartosc_netto += $wartosc_netto_fv;
				$wartosc_brutto += $wartosc_brutto_fv;
				}			
			$pytanie111 = mysqli_query($conn, "UPDATE zamowienia SET wartosc_netto = ".$wartosc_netto." WHERE id = ".$zamowienie_id.";");
			$pytanie111 = mysqli_query($conn, "UPDATE zamowienia SET wartosc_brutto = ".$wartosc_brutto." WHERE id = ".$zamowienie_id.";");
			// koniec - sprawdzamy czy istnieja pozycje ktore nie sa w tej korekcie
		
			echo '<br><div class="text_duzy_niebieski" align="center">Dane wyceny zmienione.</div>';
			echo '<br><div class="text_duzy_zielony" align="center">Za chwilę nastąpi przekierowanie do wystawiania korekty</div>';
			echo '<meta http-equiv="refresh" content="1; URL=index.php?page=fv_wystaw_korekte&zamowienie_id='.$zamowienie_id.'&faktura_do_korekty='.$faktura_do_korekty.'&jak='.$jak.'&wg_czego='.$wg_czego.'&calkowita_ilosc_pozycji='.$calkowita_ilosc_pozycji.'">';

	}
else
	{
	include("php/wyceny_deklaracja_pustych_tablic.php");
	$SUMA_NETTO = 0;
	$SUMA_BRUTTO = 0;
	$ilosc_pozycji = 0;
	$zapisz_disabled_licz = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND nr_faktury = '".$faktura_do_korekty."' ORDER BY pozycja ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji++;
		$klient_id=$wynik['klient_id'];
		$klient_nazwa=$wynik['klient_nazwa'];
		$nr_zamowienia=$wynik['nr_zamowienia'];
		$pozycja[$ilosc_pozycji]=$wynik['pozycja'];
		$pozycja_id[$ilosc_pozycji]=$wynik['id'];
		$pozycja_transport[$ilosc_pozycji]=$wynik['pozycja_transport'];
		$status[$ilosc_pozycji]=$wynik['status'];
	
		$wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_ilosc_szt'];
		$wygiecie_ramy_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_ilosc_m'];
		$wygiecie_ramy_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_cena'];
		$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_wartosc'];
		$wygiecie_ramy_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_ramy_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_ramy_pvc_wartosc[$ilosc_pozycji], 2,'.','');
		
		$checkbox_wygiecie_skrzydla[$ilosc_pozycji] = $wynik['checkbox_wygiecie_skrzydla'];
		$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_ilosc_szt'];
		$wygiecie_skrzydla_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_ilosc_m'];
		$wygiecie_skrzydla_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_cena'];
		$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_wartosc'];
		$wygiecie_skrzydla_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji], 2,'.','');
		
		$checkbox_wygiecie_listwy[$ilosc_pozycji] = $wynik['checkbox_wygiecie_listwy'];
		$wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_ilosc_szt'];
		$wygiecie_listwy_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_ilosc_m'];
		$wygiecie_listwy_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_cena'];
		$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_wartosc'];
		$wygiecie_listwy_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_listwy_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_listwy_pvc_wartosc[$ilosc_pozycji], 2,'.','');

		$wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_ilosc_szt'];
		$wygiecie_innego_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_ilosc_m'];
		$wygiecie_innego_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_cena'];
		$wygiecie_innego_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_wartosc'];
		$wygiecie_innego_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_innego_pvc_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_innego_pvc_wartosc[$ilosc_pozycji], 2,'.','');

		$wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_ilosc_szt'];
		$wygiecie_ramy_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_ilosc_m'];
		$wygiecie_ramy_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_cena'];
		$wygiecie_ramy_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_wartosc'];
		$wygiecie_ramy_alu_cena[$ilosc_pozycji] = number_format($wygiecie_ramy_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_ramy_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_ramy_alu_wartosc[$ilosc_pozycji], 2,'.','');

		$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_ilosc_szt'];
		$wygiecie_skrzydla_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_ilosc_m'];
		$wygiecie_skrzydla_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_cena'];
		$wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_wartosc'];
		$wygiecie_skrzydla_alu_cena[$ilosc_pozycji] = number_format($wygiecie_skrzydla_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji], 2,'.','');
		
		$wygiecie_listwy_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_ilosc_szt'];
		$wygiecie_listwy_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_ilosc_m'];
		$wygiecie_listwy_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_cena'];
		$wygiecie_listwy_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_wartosc'];
		$wygiecie_listwy_alu_cena[$ilosc_pozycji] = number_format($wygiecie_listwy_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_listwy_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_listwy_alu_wartosc[$ilosc_pozycji], 2,'.','');
	
		$wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_ilosc_szt'];
		$wygiecie_innego_alu_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_ilosc_m'];
		$wygiecie_innego_alu_cena[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_cena'];
		$wygiecie_innego_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_wartosc'];
		$wygiecie_innego_alu_cena[$ilosc_pozycji] = number_format($wygiecie_innego_alu_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_alu_wartosc[$ilosc_pozycji] = number_format($wygiecie_innego_alu_wartosc[$ilosc_pozycji], 2,'.','');
		
		$wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
		$wygiecie_wzmocnienia_okiennego_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_ilosc_m'];
		$wygiecie_wzmocnienia_okiennego_cena[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_cena'];
		$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_wartosc'];
		$wygiecie_wzmocnienia_okiennego_cena[$ilosc_pozycji] = number_format($wygiecie_wzmocnienia_okiennego_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji] = number_format($wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji], 2,'.','');
		$checkbox_wygiecie_wzmocnienia[$ilosc_pozycji] = $wynik['checkbox_wygiecie_wzmocnienia'];

		$wygiecie_innego_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_innego_ilosc_szt'];
		$wygiecie_innego_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_innego_ilosc_m'];
		$wygiecie_innego_cena[$ilosc_pozycji]=$wynik['wygiecie_innego_cena'];
		$wygiecie_innego_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_wartosc'];
		$wygiecie_innego_cena[$ilosc_pozycji] = number_format($wygiecie_innego_cena[$ilosc_pozycji], 2,'.','');
		$wygiecie_innego_wartosc[$ilosc_pozycji] = number_format($wygiecie_innego_wartosc[$ilosc_pozycji], 2,'.','');

		$zgrzanie_ilosc[$ilosc_pozycji]=$wynik['zgrzanie_ilosc'];
		$zgrzanie_cena[$ilosc_pozycji]=$wynik['zgrzanie_cena'];
		$zgrzanie_wartosc[$ilosc_pozycji]=$wynik['zgrzanie_wartosc'];
		$zgrzanie_cena[$ilosc_pozycji] = number_format($zgrzanie_cena[$ilosc_pozycji], 2,'.','');
		$zgrzanie_wartosc[$ilosc_pozycji] = number_format($zgrzanie_wartosc[$ilosc_pozycji], 2,'.','');

		$wyfrezowanie_odwodnienia_ilosc[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_ilosc'];
		$wyfrezowanie_odwodnienia_cena[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_cena'];
		$wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_wartosc'];
		$wyfrezowanie_odwodnienia_cena[$ilosc_pozycji] = number_format($wyfrezowanie_odwodnienia_cena[$ilosc_pozycji], 2,'.','');
		$wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji] = number_format($wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji], 2,'.','');

		$wstawienie_slupka_ilosc[$ilosc_pozycji]=$wynik['wstawienie_slupka_ilosc'];
		$wstawienie_slupka_cena[$ilosc_pozycji]=$wynik['wstawienie_slupka_cena'];
		$wstawienie_slupka_wartosc[$ilosc_pozycji]=$wynik['wstawienie_slupka_wartosc'];
		$wstawienie_slupka_cena[$ilosc_pozycji] = number_format($wstawienie_slupka_cena[$ilosc_pozycji], 2,'.','');
		$wstawienie_slupka_wartosc[$ilosc_pozycji] = number_format($wstawienie_slupka_wartosc[$ilosc_pozycji], 2,'.','');

		$listwa_przyszybowa_ilosc[$ilosc_pozycji]=$wynik['listwa_przyszybowa_ilosc'];
		$listwa_przyszybowa_cena[$ilosc_pozycji]=$wynik['listwa_przyszybowa_cena'];
		$listwa_przyszybowa_wartosc[$ilosc_pozycji]=$wynik['listwa_przyszybowa_wartosc'];
		$listwa_przyszybowa_cena[$ilosc_pozycji] = number_format($listwa_przyszybowa_cena[$ilosc_pozycji], 2,'.','');
		$listwa_przyszybowa_wartosc[$ilosc_pozycji] = number_format($listwa_przyszybowa_wartosc[$ilosc_pozycji], 2,'.','');

		$wstawienie_slupka_ruchomego_ilosc[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ruchomego_ilosc'], 2,'.','');
		$wstawienie_slupka_ruchomego_cena[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ruchomego_cena'], 2,'.','');
		$wstawienie_slupka_ruchomego_wartosc[$ilosc_pozycji] = number_format($wynik['wstawienie_slupka_ruchomego_wartosc'], 2,'.','');

		$dociecie_kompletu_listew_przyszybowych_ilosc[$ilosc_pozycji] = number_format($wynik['dociecie_kompletu_listew_przyszybowych_ilosc'], 2,'.','');
		$dociecie_kompletu_listew_przyszybowych_cena[$ilosc_pozycji] = number_format($wynik['dociecie_kompletu_listew_przyszybowych_cena'], 2,'.','');
		$dociecie_kompletu_listew_przyszybowych_wartosc[$ilosc_pozycji] = number_format($wynik['dociecie_kompletu_listew_przyszybowych_wartosc'], 2,'.','');


		$okucie_ilosc[$ilosc_pozycji]=$wynik['okucie_ilosc'];
		$okucie_cena[$ilosc_pozycji]=$wynik['okucie_cena'];
		$okucie_wartosc[$ilosc_pozycji]=$wynik['okucie_wartosc'];
		$okucie_cena[$ilosc_pozycji] = number_format($okucie_cena[$ilosc_pozycji], 2,'.','');
		$okucie_wartosc[$ilosc_pozycji] = number_format($okucie_wartosc[$ilosc_pozycji], 2,'.','');

		$zaszklenie_ilosc[$ilosc_pozycji]=$wynik['zaszklenie_ilosc'];
		$zaszklenie_cena[$ilosc_pozycji]=$wynik['zaszklenie_cena'];
		$zaszklenie_wartosc[$ilosc_pozycji]=$wynik['zaszklenie_wartosc'];
		$zaszklenie_cena[$ilosc_pozycji] = number_format($zaszklenie_cena[$ilosc_pozycji], 2,'.','');
		$zaszklenie_wartosc[$ilosc_pozycji] = number_format($zaszklenie_wartosc[$ilosc_pozycji], 2,'.','');

		$innej_uslugi_ilosc[$ilosc_pozycji]=$wynik['innej_uslugi_ilosc'];
		$innej_uslugi_cena[$ilosc_pozycji]=$wynik['innej_uslugi_cena'];
		$innej_uslugi_wartosc[$ilosc_pozycji]=$wynik['innej_uslugi_wartosc'];
		$innej_uslugi_cena[$ilosc_pozycji] = number_format($innej_uslugi_cena[$ilosc_pozycji], 2,'.','');
		$innej_uslugi_wartosc[$ilosc_pozycji] = number_format($innej_uslugi_wartosc[$ilosc_pozycji], 2,'.','');

		$oscieznica_ilosc[$ilosc_pozycji]=$wynik['oscieznica_ilosc'];
		$oscieznica_cena[$ilosc_pozycji]=$wynik['oscieznica_cena'];
		$oscieznica_wartosc[$ilosc_pozycji]=$wynik['oscieznica_wartosc'];
		$oscieznica_cena[$ilosc_pozycji] = number_format($oscieznica_cena[$ilosc_pozycji], 2,'.','');
		$oscieznica_wartosc[$ilosc_pozycji] = number_format($oscieznica_wartosc[$ilosc_pozycji], 2,'.','');

		$skrzydlo_ilosc[$ilosc_pozycji]=$wynik['skrzydlo_ilosc'];
		$skrzydlo_cena[$ilosc_pozycji]=$wynik['skrzydlo_cena'];
		$skrzydlo_wartosc[$ilosc_pozycji]=$wynik['skrzydlo_wartosc'];
		$skrzydlo_cena[$ilosc_pozycji] = number_format($skrzydlo_cena[$ilosc_pozycji], 2,'.','');
		$skrzydlo_wartosc[$ilosc_pozycji] = number_format($skrzydlo_wartosc[$ilosc_pozycji], 2,'.','');

		$listwa_ilosc[$ilosc_pozycji]=$wynik['listwa_ilosc'];
		$listwa_cena[$ilosc_pozycji]=$wynik['listwa_cena'];
		$listwa_wartosc[$ilosc_pozycji]=$wynik['listwa_wartosc'];
		$listwa_cena[$ilosc_pozycji] = number_format($listwa_cena[$ilosc_pozycji], 2,'.','');
		$listwa_wartosc[$ilosc_pozycji] = number_format($listwa_wartosc[$ilosc_pozycji], 2,'.','');

		$slupek_ilosc[$ilosc_pozycji]=$wynik['slupek_ilosc'];
		$slupek_cena[$ilosc_pozycji]=$wynik['slupek_cena'];
		$slupek_wartosc[$ilosc_pozycji]=$wynik['slupek_wartosc'];
		$slupek_cena[$ilosc_pozycji] = number_format($slupek_cena[$ilosc_pozycji], 2,'.','');
		$slupek_wartosc[$ilosc_pozycji] = number_format($slupek_wartosc[$ilosc_pozycji], 2,'.','');

		$wzmocnienie_ramy_ilosc[$ilosc_pozycji]=$wynik['wzmocnienie_ramy_ilosc'];
		$wzmocnienie_ramy_cena[$ilosc_pozycji]=$wynik['wzmocnienie_ramy_cena'];
		$wzmocnienie_ramy_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_ramy_wartosc'];
		$wzmocnienie_ramy_cena[$ilosc_pozycji] = number_format($wzmocnienie_ramy_cena[$ilosc_pozycji], 2,'.','');
		$wzmocnienie_ramy_wartosc[$ilosc_pozycji] = number_format($wzmocnienie_ramy_wartosc[$ilosc_pozycji], 2,'.','');

		$wzmocnienie_skrzydla_ilosc[$ilosc_pozycji]=$wynik['wzmocnienie_skrzydla_ilosc'];
		$wzmocnienie_skrzydla_cena[$ilosc_pozycji]=$wynik['wzmocnienie_skrzydla_cena'];
		$wzmocnienie_skrzydla_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_skrzydla_wartosc'];
		$wzmocnienie_skrzydla_cena[$ilosc_pozycji] = number_format($wzmocnienie_skrzydla_cena[$ilosc_pozycji], 2,'.','');
		$wzmocnienie_skrzydla_wartosc[$ilosc_pozycji] = number_format($wzmocnienie_skrzydla_wartosc[$ilosc_pozycji], 2,'.','');
		
		$wzmocnienie_slupka_ilosc[$ilosc_pozycji]=$wynik['wzmocnienie_slupka_ilosc'];
		$wzmocnienie_slupka_cena[$ilosc_pozycji]=$wynik['wzmocnienie_slupka_cena'];
		$wzmocnienie_slupka_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_slupka_wartosc'];
		$wzmocnienie_slupka_cena[$ilosc_pozycji] = number_format($wzmocnienie_slupka_cena[$ilosc_pozycji], 2,'.','');
		$wzmocnienie_slupka_wartosc[$ilosc_pozycji] = number_format($wzmocnienie_slupka_wartosc[$ilosc_pozycji], 2,'.','');
		
		$wzmocnienie_luku_ilosc[$ilosc_pozycji]=$wynik['wzmocnienie_luku_ilosc'];
		$wzmocnienie_luku_cena[$ilosc_pozycji]=$wynik['wzmocnienie_luku_cena'];
		$wzmocnienie_luku_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_luku_wartosc'];
		$wzmocnienie_luku_cena[$ilosc_pozycji] = number_format($wzmocnienie_luku_cena[$ilosc_pozycji], 2,'.','');
		$wzmocnienie_luku_wartosc[$ilosc_pozycji] = number_format($wzmocnienie_luku_wartosc[$ilosc_pozycji], 2,'.','');

		$okucia_ilosc[$ilosc_pozycji]=$wynik['okucia_ilosc'];
		$okucia_cena[$ilosc_pozycji]=$wynik['okucia_cena'];
		$okucia_wartosc[$ilosc_pozycji]=$wynik['okucia_wartosc'];
		$okucia_cena[$ilosc_pozycji] = number_format($okucia_cena[$ilosc_pozycji], 2,'.','');
		$okucia_wartosc[$ilosc_pozycji] = number_format($okucia_wartosc[$ilosc_pozycji], 2,'.','');

		$szyby_ilosc[$ilosc_pozycji]=$wynik['szyby_ilosc'];
		$szyby_cena[$ilosc_pozycji]=$wynik['szyby_cena'];
		$szyby_wartosc[$ilosc_pozycji]=$wynik['szyby_wartosc'];
		$szyby_cena[$ilosc_pozycji] = number_format($szyby_cena[$ilosc_pozycji], 2,'.','');
		$szyby_wartosc[$ilosc_pozycji] = number_format($szyby_wartosc[$ilosc_pozycji], 2,'.','');

		$inny_element_ilosc[$ilosc_pozycji]=$wynik['inny_element_ilosc'];
		$inny_element_cena[$ilosc_pozycji]=$wynik['inny_element_cena'];
		$inny_element_wartosc[$ilosc_pozycji]=$wynik['inny_element_wartosc'];
		$inny_element_cena[$ilosc_pozycji] = number_format($inny_element_cena[$ilosc_pozycji], 2,'.','');
		$inny_element_wartosc[$ilosc_pozycji] = number_format($inny_element_wartosc[$ilosc_pozycji], 2,'.','');

		$okna[$ilosc_pozycji]=$wynik['okna'];
		$okna[$ilosc_pozycji] = number_format($okna[$ilosc_pozycji], 2,'.','');

		$drzwi_wewnetrzne[$ilosc_pozycji]=$wynik['drzwi_wewnetrzne'];
		$drzwi_wewnetrzne[$ilosc_pozycji] = number_format($drzwi_wewnetrzne[$ilosc_pozycji], 2,'.','');

		$drzwi_zewnetrzne[$ilosc_pozycji]=$wynik['drzwi_zewnetrzne'];
		$drzwi_zewnetrzne[$ilosc_pozycji] = number_format($drzwi_zewnetrzne[$ilosc_pozycji], 2,'.','');

		$bramy[$ilosc_pozycji]=$wynik['bramy'];
		$bramy[$ilosc_pozycji] = number_format($bramy[$ilosc_pozycji], 2,'.','');

		$parapety[$ilosc_pozycji]=$wynik['parapety'];
		$parapety[$ilosc_pozycji] = number_format($parapety[$ilosc_pozycji], 2,'.','');

		$rolety_zewnetrzne[$ilosc_pozycji]=$wynik['rolety_zewnetrzne'];
		$rolety_zewnetrzne[$ilosc_pozycji] = number_format($rolety_zewnetrzne[$ilosc_pozycji], 2,'.','');

		$rolety_wewnetrzne[$ilosc_pozycji]=$wynik['rolety_wewnetrzne'];
		$rolety_wewnetrzne[$ilosc_pozycji] = number_format($rolety_wewnetrzne[$ilosc_pozycji], 2,'.','');

		$moskitiery[$ilosc_pozycji]=$wynik['moskitiery'];
		$moskitiery[$ilosc_pozycji] = number_format($moskitiery[$ilosc_pozycji], 2,'.','');

		$montaz[$ilosc_pozycji]=$wynik['montaz'];
		$montaz[$ilosc_pozycji] = number_format($montaz[$ilosc_pozycji], 2,'.','');

		$odpady_pvc[$ilosc_pozycji]=$wynik['odpady_pvc'];
		$odpady_pvc[$ilosc_pozycji] = number_format($odpady_pvc[$ilosc_pozycji], 2,'.','');

		$odpady_alu_stal[$ilosc_pozycji]=$wynik['odpady_alu_stal'];
		$odpady_alu_stal[$ilosc_pozycji] = number_format($odpady_alu_stal[$ilosc_pozycji], 2,'.','');

		$transport[$ilosc_pozycji]=$wynik['transport'];
		$transport[$ilosc_pozycji] = number_format($transport[$ilosc_pozycji], 2,'.','');

		$inne[$ilosc_pozycji]=$wynik['inne'];
		$inne[$ilosc_pozycji] = number_format($inne[$ilosc_pozycji], 2,'.','');

		$nazwa_produktu[$ilosc_pozycji]=$wynik['nazwa_produktu'];
		if($nazwa_produktu[$ilosc_pozycji] != '') $zapisz_disabled_licz++;
		$cena_netto_za_sztuke[$ilosc_pozycji]=$wynik['cena_netto_za_sztuke'];
		$cena_netto_za_sztuke[$ilosc_pozycji] = number_format($cena_netto_za_sztuke[$ilosc_pozycji], 2,'.','');
		
		$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
		if($ilosc_sztuk[$ilosc_pozycji] != '') $zapisz_disabled_licz++;
		$wartosc_netto[$ilosc_pozycji]=$wynik['wartosc_netto'];
		$SUMA_NETTO += $wartosc_netto[$ilosc_pozycji];
		$wartosc_netto[$ilosc_pozycji] = number_format($wartosc_netto[$ilosc_pozycji], 2,'.','');
		$vat_baza[$ilosc_pozycji]=$wynik['vat'];
		$nr_faktury[$ilosc_pozycji]=$wynik['nr_faktury'];
		$data_faktury[$ilosc_pozycji]=$wynik['data_faktury'];
		
		$wartosc_brutto[$ilosc_pozycji]=$wynik['wartosc_brutto'];
		$wartosc_brutto[$ilosc_pozycji] = number_format($wartosc_brutto[$ilosc_pozycji], 2,'.','');
		$SUMA_BRUTTO += $wartosc_brutto[$ilosc_pozycji];
		$uwagi[$ilosc_pozycji]=$wynik['uwagi'];
		}
				
	echo '<table border="0" valign="top" align="left" width="100%"><tr class="text_duzy">';
	for ($k=1; $k<=5; $k++) echo '<td width="20%" class="text_duzy_czerwony" align="center">Wycena - KOREKTA: <font color="blue">'.$nr_zamowienia.'</font> dla klienta <font color="blue">'.$klient_nazwa.'</font></td>';
	echo '</tr></table><br>';	
		
	echo '<FORM action="index.php?page=wycena_edycja_korekta_fv" method="post">';
	echo '<INPUT type="hidden" name="etap" value="2">';
	if($pozycja_transport[$ilosc_pozycji] == 'tak') $temp_ilosc_pozycji = $ilosc_pozycji - 1; else $temp_ilosc_pozycji = $ilosc_pozycji; // pozycja musi być o jeden mniej bo nie dziala java i liczenie wartosci 
	//$temp_ilosc_pozycji = $ilosc_pozycji;
	echo '<input type="hidden" id="id_ilosc_pozycji" name="ilosc_pozycji" value="'.$temp_ilosc_pozycji.'">';
	echo '<input type="hidden" name="klient" value="'.$klient_id.'">'; // klient ID
	echo '<input type="hidden" name="klient_id" value="'.$klient_id.'">'; // klient ID
	echo '<input type="hidden" name="klient_nazwa" value="'.$klient_nazwa.'">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="faktura_do_korekty" value="'.$faktura_do_korekty.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	echo '<input type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="status" id ="status" value="'.$status[1].'">';
	echo '<input type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
	echo '<input type="hidden" id="id_pozycja_transport" name="pozycja_transport" value="'.$pozycja_transport[$ilosc_pozycji].'">';
	echo '<input type="hidden" id="sprawdz" value="nie">';
	echo '<input type="hidden" name="calkowita_ilosc_pozycji" value="'.$calkowita_ilosc_pozycji.'">';

	echo '<table valign="top" align="left" width="7000px" border="1" cellspacing="1" cellpadding="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';

	// ################################## POZIOM 1 ##################################
	$szerokosc_pola_input_ilosc = '40px';
	$szerokosc_pola_input_cena = '50px';
	$szerokosc_pola_input_wartosc = '50px';
	$szer_inne_wartosc = '100px';

	//obliczanie szerokosci tabeli dla wycen
	$ilosc_kolumn_ilosc = 49; 
	$ilosc_kolumn_cena = 30;
	$ilosc_kolumn_wartosc = 43;
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

$wysykosc_wiersza = '35px';
//pole potrzebne do wylyczania wygiecia ramy z pvc - przy korekcie nie ma ptaszków
echo '<input type="hidden" id="czy_to_korekta" value="tak">';

//sprawdzamy czy istnieje pozycja transportowa - jeśli tak zmiejszamy ilosc pozycji o 1
if($pozycja_transport[$ilosc_pozycji] == 'tak') $ilosc_pozycji--;

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{
	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		$styl = "pole_input_biale_ramka"; 
		$styl2 = "pole_input_biale_bez_ramki";
		$styl_select = "pole_select_biale_z_ramka"; 
		$styl_uwagi = "pole_input_biale_ramka_uwagi"; 
		}
	else 
		{
		$wiersz = $kolor_szary;
		$styl = "pole_input_szare_ramka";
		$styl2 = "pole_input_szare_bez_ramki";
		$styl_select = "pole_select_szare_z_ramka"; 
		$styl_uwagi = "pole_input_szare_ramka_uwagi"; 
		}

	//sprawdzamy ile pozycji jest na tej fv, nie mozna usunac pozycji jak jest tylko ta jedna na fv
	$ilosc_pozycji_na_fv = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE nr_fv = '".$nr_faktury[$x]."' ORDER BY pozycja ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		$ilosc_pozycji_na_fv++;
		
	if($ilosc_pozycji_na_fv == 1) echo '<tr bgcolor="'.$wiersz.'" align="left" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">&nbsp;&nbsp;'.$x.'/'.$ilosc_pozycji.'</td>';
	else echo '<tr bgcolor="'.$wiersz.'" align="center" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">'.$x.'/'.$ilosc_pozycji.'</td>';
	
	// ##################################################################################################################################################################################################
	// #######################################################################  Łuki z pvc          ###################################################################
	// #######################################################################  wygiecie_ramy_z_pvc ###################################################################
	//   #################   kolumna E ilość sz  
	$nazwa_wygiecie_ramy_z_pvc_ilosc_szt = 'nazwa_wygiecie_ramy_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_ramy_z_pvc_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" value="'.$wygiecie_ramy_pvc_ilosc_szt[$x].'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna F ilość metr  
	$id_wygiecie_ramy_z_pvc_ilosc_m = 'id_wygiecie_ramy_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_ramy_z_pvc_ilosc_m = 'nazwa_wygiecie_ramy_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_ramy_z_pvc_ilosc_m.'" value="'.$wygiecie_ramy_pvc_ilosc_m[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_pvc();"></td>';
	//   #################   kolumna G cena, ID z cennika = 1    ####################################
	$id_cena_ramy = 'id_cena_ramy_'.$x;	
	$nazwa_wygiecie_ramy_z_pvc_cena = 'nazwa_wygiecie_ramy_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_ramy_pvc_cena[$x].'" id="'.$id_cena_ramy.'" name="'.$nazwa_wygiecie_ramy_z_pvc_cena.'"  style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_pvc();"></td>';
	//   #################   kolumna H  wartosc   ####################################
	$id_wygiecie_ramy_z_pvc_wartosc = 'id_wygiecie_ramy_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_ramy_z_pvc_wartosc = 'nazwa_wygiecie_ramy_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_ramy_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_ramy_z_pvc_wartosc.'" value="'.$wygiecie_ramy_pvc_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	

	//   #######################################################################  wygiecie_skrzydla_z_pvc ###################################################################
	//   #################   kolumna I ilość sz  
	$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt = 'nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt.'" value="'.$wygiecie_skrzydla_pvc_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna J ilość metr  
	$id_wygiecie_skrzydla_z_pvc_ilosc_m = 'id_wygiecie_skrzydla_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m = 'nazwa_wygiecie_skrzydla_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m.'" value="'.$wygiecie_skrzydla_pvc_ilosc_m[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_pvc();"></td>';
	//   #################   kolumna K cena, ID z cennika = 2    ####################################
	$id_cena_skrzydla = 'id_cena_skrzydla_'.$x;	
	$nazwa_wygiecie_skrzydla_z_pvc_cena = 'nazwa_wygiecie_skrzydla_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_skrzydla_pvc_cena[$x].'" id="'.$id_cena_skrzydla.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_pvc();"></td>';
	//   #################   kolumna L  wartosc   ####################################
	$id_wygiecie_skrzydla_z_pvc_wartosc = 'id_wygiecie_skrzydla_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_skrzydla_z_pvc_wartosc = 'nazwa_wygiecie_skrzydla_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_skrzydla_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_wartosc.'" value="'.$wygiecie_skrzydla_pvc_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	//   #######################################################################  wygiecie_listwy_z_pvc ###################################################################
	//   #################   kolumna M ilość sz  
	$nazwa_wygiecie_listwy_z_pvc_ilosc_szt = 'nazwa_wygiecie_listwy_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_listwy_z_pvc_ilosc_szt.'" value="'.$wygiecie_listwy_pvc_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna N ilość metr  
	$id_wygiecie_listwy_z_pvc_ilosc_m = 'id_wygiecie_listwy_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_listwy_z_pvc_ilosc_m = 'nazwa_wygiecie_listwy_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_pvc_ilosc_m.'" value="'.$wygiecie_listwy_pvc_ilosc_m[$x].'" name="'.$nazwa_wygiecie_listwy_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_pvc();"></td>';
	//   #################   kolumna O cena, ID z cennika = 3    ####################################
	$id_cena_listwy = 'id_cena_listwy_'.$x;	
	$nazwa_wygiecie_listwy_z_pvc_cena = 'nazwa_wygiecie_listwy_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_listwy_pvc_cena[$x].'" id="'.$id_cena_listwy.'" name="'.$nazwa_wygiecie_listwy_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_pvc();"></td>';
	//   #################   kolumna P  wartosc   ####################################
	$id_wygiecie_listwy_z_pvc_wartosc = 'id_wygiecie_listwy_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_listwy_z_pvc_wartosc = 'nazwa_wygiecie_listwy_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_listwy_z_pvc_wartosc.'" value="'.$wygiecie_listwy_pvc_wartosc[$x].'" name="'.$nazwa_wygiecie_listwy_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
			
	//   #######################################################################  wygiecie_innego elementu_z_pvc ###################################################################
	//   #################   kolumna Q ilość sz  
	$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt = 'nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt.'" value="'.$wygiecie_innego_pvc_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna R ilość metr  
	$id_wygiecie_innego_elementu_z_pvc_ilosc_m = 'id_wygiecie_innego_elementu_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m = 'nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_z_pvc_ilosc_m.'" value="'.$wygiecie_innego_pvc_ilosc_m[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_pvc();"></td>';
	//   #################   kolumna S cena, ID z cennika = 4    ####################################
	$id_cena_innego_elementu = 'id_cena_innego_elementu_'.$x;	
	$nazwa_wygiecie_innego_elementu_z_pvc_cena = 'nazwa_wygiecie_innego_elementu_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wygiecie_innego_pvc_cena[$x].'" id="'.$id_cena_innego_elementu.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_pvc();"></td>';
	//   #################   kolumna T  wartosc   ####################################
	$id_wygiecie_innego_elementu_z_pvc_wartosc = 'id_wygiecie_innego_elementu_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_z_pvc_wartosc = 'nazwa_wygiecie_innego_elementu_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_z_pvc_wartosc.'" value="'.$wygiecie_innego_pvc_wartosc[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// ##############################################################################################################################################################################
	// #######################################################################  Łuki z aluminium               ###################################################################
	// #######################################################################  wygiecie_ramy_z_alu            ###################################################################
	// ################################################################################################################################################################################
	
	//   #################   kolumna u ilość sz  
	$nazwa_wygiecie_ramy_z_alu_ilosc_szt = 'nazwa_wygiecie_ramy_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_ramy_z_alu_ilosc_szt.'" value="'.$wygiecie_ramy_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna v ilość metr  
	$id_wygiecie_ramy_z_alu_ilosc_m = 'id_wygiecie_ramy_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_ramy_z_alu_ilosc_m = 'nazwa_wygiecie_ramy_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_alu_ilosc_m.'" value="'.$wygiecie_ramy_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_ramy_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_alu();"></td>';
	//   #################   kolumna w cena, ID z cennika = 5    ####################################
	$id_cena_ramy_alu = 'id_cena_ramy_alu_'.$x;	
	$nazwa_wygiecie_ramy_z_alu_cena = 'nazwa_wygiecie_ramy_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_ramy_alu.'" value="'.$wygiecie_ramy_alu_cena[$x].'" name="'.$nazwa_wygiecie_ramy_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_alu();"></td>';
	//   #################   kolumna x  wartosc   ####################################
	$id_wygiecie_ramy_z_alu_wartosc = 'id_wygiecie_ramy_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_ramy_z_alu_wartosc = 'nazwa_wygiecie_ramy_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_ramy_z_alu_wartosc.'" value="'.$wygiecie_ramy_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_ramy_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	//   #######################################################################  wygiecie_skrzydla_z_alu ###################################################################
	//   #################   kolumna y ilość sz  
	$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt = 'nazwa_wygiecie_skrzydla_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt.'" value="'.$wygiecie_skrzydla_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna z ilość metr  
	$id_wygiecie_skrzydla_z_alu_ilosc_m = 'id_wygiecie_skrzydla_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_skrzydla_z_alu_ilosc_m = 'nazwa_wygiecie_skrzydla_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_alu_ilosc_m.'" value="'.$wygiecie_skrzydla_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_skrzydla_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_alu();"></td>';
	//   #################   kolumna aa cena, ID z cennika = 6    ####################################
	$id_cena_skrzydla_alu = 'id_cena_skrzydla_alu_'.$x;	
	$nazwa_wygiecie_skrzydla_z_alu_cena = 'nazwa_wygiecie_skrzydla_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_skrzydla_alu.'" value="'.$wygiecie_skrzydla_alu_cena[$x].'" name="'.$nazwa_wygiecie_skrzydla_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_alu();"></td>';
	//   #################   kolumna ab  wartosc   ####################################
	$id_wygiecie_skrzydla_z_alu_wartosc = 'id_wygiecie_skrzydla_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_skrzydla_z_alu_wartosc = 'nazwa_wygiecie_skrzydla_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_skrzydla_z_alu_wartosc.'" value="'.$wygiecie_skrzydla_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_skrzydla_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	//   #######################################################################  wygiecie_listwy_z_alu ###################################################################
	//   #################   kolumna ac ilość sz  
	$nazwa_wygiecie_listwy_z_alu_ilosc_szt = 'nazwa_wygiecie_listwy_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_listwy_z_alu_ilosc_szt.'" value="'.$wygiecie_listwy_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna ad ilość metr  
	$id_wygiecie_listwy_z_alu_ilosc_m = 'id_wygiecie_listwy_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_listwy_z_alu_ilosc_m = 'nazwa_wygiecie_listwy_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_alu_ilosc_m.'" value="'.$wygiecie_listwy_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_listwy_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_alu();"></td>';
	//   #################   kolumna ae cena, ID z cennika = 7    ####################################
	$id_cena_listwy_alu = 'id_cena_listwy_alu_'.$x;	
	$nazwa_wygiecie_listwy_z_alu_cena = 'nazwa_wygiecie_listwy_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_listwy_alu.'" value="'.$wygiecie_listwy_alu_cena[$x].'" name="'.$nazwa_wygiecie_listwy_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_alu();"></td>';
	//   #################   kolumna af  wartosc   ####################################
	$id_wygiecie_listwy_z_alu_wartosc = 'id_wygiecie_listwy_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_listwy_z_alu_wartosc = 'nazwa_wygiecie_listwy_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_listwy_z_alu_wartosc.'" value="'.$wygiecie_listwy_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_listwy_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	//   #######################################################################  wygiecie_innego elementu_z_alu ###################################################################
	//   #################   kolumna ag ilość sz  
	$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt = 'nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt.'" value="'.$wygiecie_innego_alu_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna ah ilość metr  
	$id_wygiecie_innego_elementu_z_alu_ilosc_m = 'id_wygiecie_innego_elementu_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m = 'nazwa_wygiecie_innego_elementu_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_z_alu_ilosc_m.'" value="'.$wygiecie_innego_alu_ilosc_m[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_alu();"></td>';
	//   #################   kolumna ai cena, ID z cennika = 8    ####################################
	$id_cena_innego_elementu_alu = 'id_cena_innego_elementu_alu_'.$x;	
	$nazwa_wygiecie_innego_elementu_z_alu_cena = 'nazwa_wygiecie_innego_elementu_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_innego_elementu_alu.'" value="'.$wygiecie_innego_alu_cena[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_alu();"></td>';
	//   #################   kolumna aj  wartosc   ####################################
	$id_wygiecie_innego_elementu_z_alu_wartosc = 'id_wygiecie_innego_elementu_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_z_alu_wartosc = 'nazwa_wygiecie_innego_elementu_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_z_alu_wartosc.'" value="'.$wygiecie_innego_alu_wartosc[$x].'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// ###############################################################################################################################################################################
	// #######################################################################  Łuki ze stali                      ###################################################################
	// #######################################################################  Wygięcie wzmocnienia okiennego     ###################################################################
	// ##########################################################################################################################################################################

	//   #################   kolumna ak ilość sz  
	$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt = 'nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt.'" value="'.$wygiecie_wzmocnienia_okiennego_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna al ilość metr  
	$id_wygiecie_wzmocnienia_okiennego_ilosc_m = 'id_wygiecie_wzmocnienia_okiennego_ilosc_m_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m = 'nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ilosc_m.'" value="'.$wygiecie_wzmocnienia_okiennego_ilosc_m[$x].'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna am cena, ID z cennika = 9    ####################################
	$id_cena_wzmocnienia_okiennego = 'id_cena_wzmocnienia_okiennego_'.$x;	
	$nazwa_wygiecie_wzmocnienia_okiennego_cena = 'nazwa_wygiecie_wzmocnienia_okiennego_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wzmocnienia_okiennego.'" value="'.$wygiecie_wzmocnienia_okiennego_cena[$x].'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna an  wartosc   ####################################
	$id_wygiecie_wzmocnienia_okiennego_wartosc = 'id_wygiecie_wzmocnienia_okiennego_wartosc_'.$x;		
	$nazwa_wygiecie_wzmocnienia_okiennego_wartosc = 'nazwa_wygiecie_wzmocnienia_okiennego_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_wzmocnienia_okiennego_wartosc.'" value="'.$wygiecie_wzmocnienia_okiennego_wartosc[$x].'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wygiecie_innego_elementu_ze_stali            ###################################################################
	//   #################   kolumna ao ilość sz  
	$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt = 'nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt.'" value="'.$wygiecie_innego_ilosc_szt[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna ap ilość metr  
	$id_wygiecie_innego_elementu_ze_stali_ilosc_m = 'id_wygiecie_innego_elementu_ze_stali_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m = 'nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_ze_stali_ilosc_m.'" value="'.$wygiecie_innego_ilosc_m[$x].'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_ze_stali();"></td>';
	//   #################   kolumna aq cena, ID z cennika = 10    ####################################
	$id_cena_wygiecie_innego_elementu_ze_stali = 'id_cena_wygiecie_innego_elementu_ze_stali_'.$x;	
	$nazwa_wygiecie_innego_elementu_ze_stali_cena = 'nazwa_wygiecie_innego_elementu_ze_stali_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wygiecie_innego_elementu_ze_stali.'" value="'.$wygiecie_innego_cena[$x].'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_ze_stali();"></td>';
	//   #################   kolumna ar  wartosc   ####################################
	$id_wygiecie_innego_elementu_ze_stali_wartosc = 'id_wygiecie_innego_elementu_ze_stali_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_ze_stali_wartosc = 'nazwa_wygiecie_innego_elementu_ze_stali_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_ze_stali_wartosc.'" value="'.$wygiecie_innego_wartosc[$x].'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	// ########################################################################################################################################################################################################
	// #######################################################################  Konstrukcje okienne z pvc          ###################################################################
	// ###############################################################################################################################################################################################################################
	
	// #######################################################################  Zgrzanie	                       ###################################################################
	//   #################   kolumna as ilość  
	$id_zgrzanie_ilosc_m = 'id_zgrzanie_ilosc_m_'.$x;
	$nazwa_zgrzanie_ilosc_m = 'nazwa_zgrzanie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_zgrzanie_ilosc_m.'" name="'.$nazwa_zgrzanie_ilosc_m.'" value="'.$zgrzanie_ilosc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zgrzanie();"></td>';
	//   #################   kolumna at cena, ID z cennika = 11    ####################################
	$id_cena_zgrzanie = 'id_cena_zgrzanie_'.$x;	
	$nazwa_zgrzanie_cena = 'nazwa_zgrzanie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_zgrzanie.'" value="'.$zgrzanie_cena[$x].'" name="'.$nazwa_zgrzanie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zgrzanie();"></td>';
	//   #################   kolumna au  wartosc   ####################################
	$id_zgrzanie_wartosc = 'id_zgrzanie_wartosc_'.$x;		
	$nazwa_zgrzanie_wartosc = 'nazwa_zgrzanie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_zgrzanie_wartosc.'" value="'.$zgrzanie_wartosc[$x].'" name="'.$nazwa_zgrzanie_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	//   #######################################################################  Wyfrezowanie odwodnienia            ###################################################################
	//   #################   kolumna av ilość 
	$id_wyfrezowanie_odwodnienia_ilosc_m = 'id_wyfrezowanie_odwodnienia_ilosc_m_'.$x;
	$nazwa_wyfrezowanie_odwodnienia_ilosc_m = 'nazwa_wyfrezowanie_odwodnienia_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wyfrezowanie_odwodnienia_ilosc_m.'" value="'.$wyfrezowanie_odwodnienia_ilosc[$x].'" name="'.$nazwa_wyfrezowanie_odwodnienia_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wyfrezowanie_odwodnienia();"></td>';
	//   #################   kolumna aw cena, ID z cennika = 12    ####################################
	$id_cena_wyfrezowanie_odwodnienia = 'id_cena_wyfrezowanie_odwodnienia_'.$x;	
	$nazwa_wyfrezowanie_odwodnienia_cena = 'nazwa_wyfrezowanie_odwodnienia_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wyfrezowanie_odwodnienia_cena[$x].'" id="'.$id_cena_wyfrezowanie_odwodnienia.'" name="'.$nazwa_wyfrezowanie_odwodnienia_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wyfrezowanie_odwodnienia();"></td>';
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



	// #######################################################################  okucie	                       ###################################################################
	//   #################   kolumna be ilość  
	$id_okucie_ilosc_m = 'id_okucie_ilosc_m_'.$x;
	$nazwa_okucie_ilosc_m = 'nazwa_okucie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_okucie_ilosc_m.'" name="'.$nazwa_okucie_ilosc_m.'" value="'.$okucie_ilosc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucie();"></td>';
	//   #################   kolumna bf cena, ID z cennika = 15    ####################################
	$id_cena_okucie = 'id_cena_okucie_'.$x;	
	$nazwa_okucie_cena = 'nazwa_okucie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_okucie.'" value="'.$okucie_cena[$x].'" name="'.$nazwa_okucie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucie();"></td>';
	//   #################   kolumna bg  wartosc   ####################################
	$id_okucie_wartosc = 'id_okucie_wartosc_'.$x;		
	$nazwa_okucie_wartosc = 'nazwa_okucie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_okucie_wartosc.'" name="'.$nazwa_okucie_wartosc.'" value="'.$okucie_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  zaszklenie	                       ###################################################################
	//   #################   kolumna bh ilość  
	$id_zaszklenie_ilosc_m = 'id_zaszklenie_ilosc_m_'.$x;
	$nazwa_zaszklenie_ilosc_m = 'nazwa_zaszklenie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_zaszklenie_ilosc_m.'" name="'.$nazwa_zaszklenie_ilosc_m.'" value="'.$zaszklenie_ilosc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zaszklenie();"></td>';
	//   #################   kolumna bi cena, ID z cennika = 16   ####################################
	$id_cena_zaszklenie = 'id_cena_zaszklenie_'.$x;	
	$nazwa_zaszklenie_cena = 'nazwa_zaszklenie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_zaszklenie.'" name="'.$nazwa_zaszklenie_cena.'" value="'.$zaszklenie_cena[$x].'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zaszklenie();"></td>';
	//   #################   kolumna bj  wartosc   ####################################
	$id_zaszklenie_wartosc = 'id_zaszklenie_wartosc_'.$x;		
	$nazwa_zaszklenie_wartosc = 'nazwa_zaszklenie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_zaszklenie_wartosc.'" name="'.$nazwa_zaszklenie_wartosc.'" value="'.$zaszklenie_wartosc[$x].'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wykonanie_innej_uslugi	   ###################################################################
	//   #################   kolumna bk ilość  
	$id_wykonanie_innej_uslugi_ilosc_m = 'id_wykonanie_innej_uslugi_ilosc_m_'.$x;
	$nazwa_wykonanie_innej_uslugi_ilosc_m = 'nazwa_wykonanie_innej_uslugi_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wykonanie_innej_uslugi_ilosc_m.'" value="'.$innej_uslugi_ilosc[$x].'" name="'.$nazwa_wykonanie_innej_uslugi_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wykonanie_innej_uslugi();"></td>';
	//   #################   kolumna bl cena, ID z cennika = 17    ####################################
	$id_cena_wykonanie_innej_uslugi = 'id_cena_wykonanie_innej_uslugi_'.$x;	
	$nazwa_wykonanie_innej_uslugi_cena = 'nazwa_wykonanie_innej_uslugi_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wykonanie_innej_uslugi.'" value="'.$innej_uslugi_cena[$x].'" name="'.$nazwa_wykonanie_innej_uslugi_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wykonanie_innej_uslugi();"></td>';
	//   #################   kolumna bm  wartosc   ####################################
	$id_wykonanie_innej_uslugi_wartosc = 'id_wykonanie_innej_uslugi_wartosc_'.$x;		
	$nazwa_wykonanie_innej_uslugi_wartosc = 'nazwa_wykonanie_innej_uslugi_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wykonanie_innej_uslugi_wartosc.'" value="'.$innej_uslugi_wartosc[$x].'" name="'.$nazwa_wykonanie_innej_uslugi_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	// ####################################################################################################################################################################################
	// #######################################################################  Materiał          ###################################################################
	// #############################################################################################################################################################

	// #######################################################################  oscieznica	 ###################################################################
	//   #################   kolumna bn ilość  
	$id_oscieznica_ilosc_m = 'id_oscieznica_ilosc_m_'.$x;
	$nazwa_oscieznica_ilosc_m = 'nazwa_oscieznica_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_oscieznica_ilosc_m.'" value="'.$oscieznica_ilosc[$x].'" name="'.$nazwa_oscieznica_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_oscieznica();"></td>';
	//   #################   kolumna bo cena, ID z cennika = 18    ####################################
	$id_cena_oscieznica = 'id_cena_oscieznica_'.$x;	
	$nazwa_oscieznica_cena = 'nazwa_oscieznica_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$oscieznica_cena[$x].'" id="'.$id_cena_oscieznica.'" name="'.$nazwa_oscieznica_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_oscieznica();"></td>';
	//   #################   kolumna bp  wartosc   ####################################
	$id_oscieznica_wartosc = 'id_oscieznica_wartosc_'.$x;		
	$nazwa_oscieznica_wartosc = 'nazwa_oscieznica_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_oscieznica_wartosc.'" value="'.$oscieznica_wartosc[$x].'" name="'.$nazwa_oscieznica_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  skrzydlo	   ###################################################################
	//   #################   kolumna bq ilość  
	$id_skrzydlo_ilosc_m = 'id_skrzydlo_ilosc_m_'.$x;
	$nazwa_skrzydlo_ilosc_m = 'nazwa_skrzydlo_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_skrzydlo_ilosc_m.'" value="'.$skrzydlo_ilosc[$x].'" name="'.$nazwa_skrzydlo_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_skrzydlo();"></td>';
	//   #################   kolumna br cena, ID z cennika = 19    ####################################
	$id_cena_skrzydlo = 'id_cena_skrzydlo_'.$x;	
	$nazwa_skrzydlo_cena = 'nazwa_skrzydlo_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$skrzydlo_cena[$x].'" id="'.$id_cena_skrzydlo.'" name="'.$nazwa_skrzydlo_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_skrzydlo();"></td>';
	//   #################   kolumna bs  wartosc   ####################################
	$id_skrzydlo_wartosc = 'id_skrzydlo_wartosc_'.$x;		
	$nazwa_skrzydlo_wartosc = 'nazwa_skrzydlo_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_skrzydlo_wartosc.'" value="'.$skrzydlo_wartosc[$x].'" name="'.$nazwa_skrzydlo_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  listwa	   ###################################################################
	//   #################   kolumna bt ilość  
	$id_listwa_ilosc_m = 'id_listwa_ilosc_m_'.$x;
	$nazwa_listwa_ilosc_m = 'nazwa_listwa_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_listwa_ilosc_m.'" value="'.$listwa_ilosc[$x].'" name="'.$nazwa_listwa_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_listwa();"></td>';
	//   #################   kolumna bu cena, ID z cennika = 20    ####################################
	$id_cena_listwa = 'id_cena_listwa_'.$x;	
	$nazwa_listwa_cena = 'nazwa_listwa_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$listwa_cena[$x].'" id="'.$id_cena_listwa.'" name="'.$nazwa_listwa_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_listwa();"></td>';
	//   #################   kolumna bv  wartosc   ####################################
	$id_listwa_wartosc = 'id_listwa_wartosc_'.$x;		
	$nazwa_listwa_wartosc = 'nazwa_listwa_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_listwa_wartosc.'" value="'.$listwa_wartosc[$x].'" name="'.$nazwa_listwa_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  slupek	   ###################################################################
	//   #################   kolumna bw ilość  
	$id_slupek_ilosc_m = 'id_slupek_ilosc_m_'.$x;
	$nazwa_slupek_ilosc_m = 'nazwa_slupek_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_slupek_ilosc_m.'" value="'.$slupek_ilosc[$x].'" name="'.$nazwa_slupek_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_slupek();"></td>';
	//   #################   kolumna bx cena, ID z cennika = 21    ####################################
	$id_cena_slupek = 'id_cena_slupek_'.$x;	
	$nazwa_slupek_cena = 'nazwa_slupek_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$slupek_cena[$x].'" id="'.$id_cena_slupek.'" name="'.$nazwa_slupek_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_slupek();"></td>';
	//   #################   kolumna by  wartosc   ####################################
	$id_slupek_wartosc = 'id_slupek_wartosc_'.$x;		
	$nazwa_slupek_wartosc = 'nazwa_slupek_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_slupek_wartosc.'" value="'.$slupek_wartosc[$x].'" name="'.$nazwa_slupek_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wzmocnienie_do_ramy	   ###################################################################
	//   #################   kolumna bz ilość  
	$id_wzmocnienie_do_ramy_ilosc_m = 'id_wzmocnienie_do_ramy_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_ramy_ilosc_m = 'nazwa_wzmocnienie_do_ramy_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_ramy_ilosc_m.'" value="'.$wzmocnienie_ramy_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_ramy_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_ramy();"></td>';
	//   #################   kolumna ca cena, ID z cennika = 22    ####################################
	$id_cena_wzmocnienie_do_ramy = 'id_cena_wzmocnienie_do_ramy_'.$x;	
	$nazwa_wzmocnienie_do_ramy_cena = 'nazwa_wzmocnienie_do_ramy_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_ramy_cena[$x].'" id="'.$id_cena_wzmocnienie_do_ramy.'" name="'.$nazwa_wzmocnienie_do_ramy_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_ramy();"></td>';
	//   #################   kolumna cb  wartosc   ####################################
	$id_wzmocnienie_do_ramy_wartosc = 'id_wzmocnienie_do_ramy_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_ramy_wartosc = 'nazwa_wzmocnienie_do_ramy_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_ramy_wartosc.'" value="'.$wzmocnienie_ramy_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_ramy_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  wzmocnienie_do_skrzydla	         ###################################################################
	//   #################   kolumna cc ilość  
	$id_wzmocnienie_do_skrzydla_ilosc_m = 'id_wzmocnienie_do_skrzydla_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_skrzydla_ilosc_m = 'nazwa_wzmocnienie_do_skrzydla_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_skrzydla_ilosc_m.'" value="'.$wzmocnienie_skrzydla_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_skrzydla_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_skrzydla();"></td>';
	//   #################   kolumna cd cena, ID z cennika = 23    ####################################
	$id_cena_wzmocnienie_do_skrzydla = 'id_cena_wzmocnienie_do_skrzydla_'.$x;	
	$nazwa_wzmocnienie_do_skrzydla_cena = 'nazwa_wzmocnienie_do_skrzydla_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_skrzydla_cena[$x].'" id="'.$id_cena_wzmocnienie_do_skrzydla.'" name="'.$nazwa_wzmocnienie_do_skrzydla_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_skrzydla();"></td>';
	//   #################   kolumna ce  wartosc   ####################################
	$id_wzmocnienie_do_skrzydla_wartosc = 'id_wzmocnienie_do_skrzydla_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_skrzydla_wartosc = 'nazwa_wzmocnienie_do_skrzydla_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_skrzydla_wartosc.'" value="'.$wzmocnienie_skrzydla_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_skrzydla_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	// #######################################################################  wzmocnienie_do_slupka	  ###################################################################
	//   #################   kolumna cf ilość  
	$id_wzmocnienie_do_slupka_ilosc_m = 'id_wzmocnienie_do_slupka_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_slupka_ilosc_m = 'nazwa_wzmocnienie_do_slupka_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_slupka_ilosc_m.'" value="'.$wzmocnienie_slupka_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_slupka_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_slupka();"></td>';
	//   #################   kolumna cg cena, ID z cennika = 24    ####################################
	$id_cena_wzmocnienie_do_slupka = 'id_cena_wzmocnienie_do_slupka_'.$x;	
	$nazwa_wzmocnienie_do_slupka_cena = 'nazwa_wzmocnienie_do_slupka_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_slupka_cena[$x].'" id="'.$id_cena_wzmocnienie_do_slupka.'" name="'.$nazwa_wzmocnienie_do_slupka_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_slupka();"></td>';
	//   #################   kolumna ch  wartosc   ####################################
	$id_wzmocnienie_do_slupka_wartosc = 'id_wzmocnienie_do_slupka_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_slupka_wartosc = 'nazwa_wzmocnienie_do_slupka_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_slupka_wartosc.'" value="'.$wzmocnienie_slupka_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_slupka_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  wzmocnienie_do_luku	  ###################################################################
	//   #################   kolumna ci ilość  
	$id_wzmocnienie_do_luku_ilosc_m = 'id_wzmocnienie_do_luku_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_luku_ilosc_m = 'nazwa_wzmocnienie_do_luku_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_luku_ilosc_m.'" value="'.$wzmocnienie_luku_ilosc[$x].'" name="'.$nazwa_wzmocnienie_do_luku_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_luku();"></td>';
	//   #################   kolumna cj cena, ID z cennika = 25    ####################################
	$id_cena_wzmocnienie_do_luku = 'id_cena_wzmocnienie_do_luku_'.$x;	
	$nazwa_wzmocnienie_do_luku_cena = 'nazwa_wzmocnienie_do_luku_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$wzmocnienie_luku_cena[$x].'" id="'.$id_cena_wzmocnienie_do_luku.'" name="'.$nazwa_wzmocnienie_do_luku_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_luku();"></td>';
	//   #################   kolumna ck  wartosc   ####################################
	$id_wzmocnienie_do_luku_wartosc = 'id_wzmocnienie_do_luku_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_luku_wartosc = 'nazwa_wzmocnienie_do_luku_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_luku_wartosc.'" value="'.$wzmocnienie_luku_wartosc[$x].'" name="'.$nazwa_wzmocnienie_do_luku_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	// #######################################################################  okucia	  ###################################################################
	//   #################   kolumna cl ilość  
	$id_okucia_ilosc_m = 'id_okucia_ilosc_m_'.$x;
	$nazwa_okucia_ilosc_m = 'nazwa_okucia_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_okucia_ilosc_m.'" value="'.$okucia_ilosc[$x].'" name="'.$nazwa_okucia_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucia();"></td>';
	//   #################   kolumna cm cena, ID z cennika = 26    ####################################
	$id_cena_okucia = 'id_cena_okucia_'.$x;	
	$nazwa_okucia_cena = 'nazwa_okucia_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$okucia_cena[$x].'" id="'.$id_cena_okucia.'" name="'.$nazwa_okucia_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucia();"></td>';
	//   #################   kolumna cn  wartosc   ####################################
	$id_okucia_wartosc = 'id_okucia_wartosc_'.$x;		
	$nazwa_okucia_wartosc = 'nazwa_okucia_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_okucia_wartosc.'" value="'.$okucia_wartosc[$x].'" name="'.$nazwa_okucia_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  szyby	  ###################################################################
	//   #################   kolumna co ilość  
	$id_szyby_ilosc_m = 'id_szyby_ilosc_m_'.$x;
	$nazwa_szyby_ilosc_m = 'nazwa_szyby_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_szyby_ilosc_m.'" value="'.$szyby_ilosc[$x].'" name="'.$nazwa_szyby_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_szyby();"></td>';
	//   #################   kolumna cp cena, ID z cennika = 27    ####################################
	$id_cena_szyby = 'id_cena_szyby_'.$x;	
	$nazwa_szyby_cena = 'nazwa_szyby_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$szyby_cena[$x].'" id="'.$id_cena_szyby.'" name="'.$nazwa_szyby_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_szyby();"></td>';
	//   #################   kolumna cq  wartosc   ####################################
	$id_szyby_wartosc = 'id_szyby_wartosc_'.$x;		
	$nazwa_szyby_wartosc = 'nazwa_szyby_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_szyby_wartosc.'" value="'.$szyby_wartosc[$x].'" name="'.$nazwa_szyby_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  inny_element	  ###################################################################
	//   #################   kolumna cr ilość  
	$id_inny_element_ilosc_m = 'id_inny_element_ilosc_m_'.$x;
	$nazwa_inny_element_ilosc_m = 'nazwa_inny_element_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_inny_element_ilosc_m.'" value="'.$inny_element_ilosc[$x].'" name="'.$nazwa_inny_element_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_inny_element();"></td>';
	//   #################   kolumna cs cena, ID z cennika = 28    ####################################
	$id_cena_inny_element = 'id_cena_inny_element_'.$x;	
	$nazwa_inny_element_cena = 'nazwa_inny_element_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$inny_element_cena[$x].'" id="'.$id_cena_inny_element.'" name="'.$nazwa_inny_element_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_inny_element();"></td>';
	//   #################   kolumna ct  wartosc   ####################################
	$id_inny_element_wartosc = 'id_inny_element_wartosc_'.$x;		
	$nazwa_inny_element_wartosc = 'nazwa_inny_element_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_inny_element_wartosc.'" value="'.$inny_element_wartosc[$x].'" name="'.$nazwa_inny_element_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	// #####################################################################################################################################################################
	// ######################################################################################################################################################################
	// ###################################################################################################################################################################
	// #######################################################################  Pozostałe wartośći   ###################################################################
	// ####################################################################################################################################################################
	// ######################################################################################################################################################################
	// ######################################################################################################################################################################
	
	//   #################   kolumna cu  okna   ####################################
	$id_okna_wartosc = 'id_okna_wartosc_'.$x;	
	$nazwa_okna_wartosc = 'nazwa_okna_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$okna[$x].'" id="'.$id_okna_wartosc.'" name="'.$nazwa_okna_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_okna();">'.$waluta.'</td>';
	
	//   #################   kolumna cv  Drzwi wewnętrzne   ####################################
	$id_drzwi_wewnetrzne_wartosc = 'id_drzwi_wewnetrzne_wartosc_'.$x;	
	$nazwa_drzwi_wewnetrzne_wartosc = 'nazwa_drzwi_wewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$drzwi_wewnetrzne[$x].'" id="'.$id_drzwi_wewnetrzne_wartosc.'" name="'.$nazwa_drzwi_wewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_drzwi_wewnetrzne();">'.$waluta.'</td>';

	//   #################   kolumna cw  Drzwi zewnętrzne   ####################################
	$id_drzwi_zewnetrzne_wartosc = 'id_drzwi_zewnetrzne_wartosc_'.$x;	
	$nazwa_drzwi_zewnetrzne_wartosc = 'nazwa_drzwi_zewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$drzwi_zewnetrzne[$x].'" id="'.$id_drzwi_zewnetrzne_wartosc.'" name="'.$nazwa_drzwi_zewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_drzwi_zewnetrzne();">'.$waluta.'</td>';
	
	//   #################   kolumna cy  Bramy   ####################################
	$id_bramy_wartosc = 'id_bramy_wartosc_'.$x;	
	$nazwa_bramy_wartosc = 'nazwa_bramy_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$bramy[$x].'" id="'.$id_bramy_wartosc.'" name="'.$nazwa_bramy_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_bramy();">'.$waluta.'</td>';

	//   #################   kolumna cy  Parapety   ####################################
	$id_parapety_wartosc = 'id_parapety_wartosc_'.$x;	
	$nazwa_parapety_wartosc = 'nazwa_parapety_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$parapety[$x].'" id="'.$id_parapety_wartosc.'" name="'.$nazwa_parapety_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_parapety();">'.$waluta.'</td>';
	
	//   #################   kolumna cz  Rolety zewnętrzne   ####################################
	$id_rolety_zewnetrzne_wartosc = 'id_rolety_zewnetrzne_wartosc_'.$x;	
	$nazwa_rolety_zewnetrzne_wartosc = 'nazwa_rolety_zewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$rolety_zewnetrzne[$x].'" id="'.$id_rolety_zewnetrzne_wartosc.'" name="'.$nazwa_rolety_zewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_rolety_zewnetrzne();">'.$waluta.'</td>';
				
	//   #################   kolumna da  Rolety wewnętrzne   ####################################
	$id_rolety_wewnetrzne_wartosc = 'id_rolety_wewnetrzne_wartosc_'.$x;	
	$nazwa_rolety_wewnetrzne_wartosc = 'nazwa_rolety_wewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$rolety_wewnetrzne[$x].'" id="'.$id_rolety_wewnetrzne_wartosc.'" name="'.$nazwa_rolety_wewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_rolety_wewnetrzne();">'.$waluta.'</td>';

	//   #################   kolumna db  Moskitiery   ####################################
	$id_moskitiery_wartosc = 'id_moskitiery_wartosc_'.$x;	
	$nazwa_moskitiery_wartosc = 'nazwa_moskitiery_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$moskitiery[$x].'" id="'.$id_moskitiery_wartosc.'" name="'.$nazwa_moskitiery_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_moskitiery();">'.$waluta.'</td>';

	//   #################   kolumna dc  Montaż   ####################################
	$id_montaz_wartosc = 'id_montaz_wartosc_'.$x;	
	$nazwa_montaz_wartosc = 'nazwa_montaz_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$montaz[$x].'" id="'.$id_montaz_wartosc.'" name="'.$nazwa_montaz_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_montaz();">'.$waluta.'</td>';
	
	//   #################   kolumna dd  Odpady z pvc   ####################################
	$id_odpady_z_pvc_wartosc = 'id_odpady_z_pvc_wartosc_'.$x;	
	$nazwa_odpady_z_pvc_wartosc = 'nazwa_odpady_z_pvc_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$odpady_pvc[$x].'" id="'.$id_odpady_z_pvc_wartosc.'" name="'.$nazwa_odpady_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_odpady_z_pvc();">'.$waluta.'</td>';

	//   #################   kolumna de  Odpady ze stali i alu   ####################################
	$id_odpady_ze_stali_wartosc = 'id_odpady_ze_stali_wartosc_'.$x;	
	$nazwa_odpady_ze_stali_wartosc = 'nazwa_odpady_ze_stali_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$odpady_alu_stal[$x].'" id="'.$id_odpady_ze_stali_wartosc.'" name="'.$nazwa_odpady_ze_stali_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_odpady_ze_stali();">'.$waluta.'</td>';
	
	//   #################   kolumna de  transport   ####################################
	$id_transport_wartosc = 'id_transport_wartosc_'.$x;	
	$nazwa_transport_wartosc = 'nazwa_transport_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$transport[$x].'" id="'.$id_transport_wartosc.'" name="'.$nazwa_transport_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_transport();">'.$waluta.'</td>';
	
	//   #################   kolumna dg  inne   ####################################
	$id_inne_wartosc = 'id_inne_wartosc_'.$x;	
	$nazwa_inne_wartosc = 'nazwa_inne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" value="'.$inne[$x].'" id="'.$id_inne_wartosc.'" name="'.$nazwa_inne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_inne();">'.$waluta.'</td>';
		
	// #####################################################################
	// #################   kolumna DH   nazwa produktu  ################################################
	$ilosc_produktow = 0;
	$produkt_id = [];
	$produkt_opis = [];	
	$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC;");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$ilosc_produktow++;
		$produkt_id[$ilosc_produktow] = $wynik2['id'];
		$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
		}
	$nazwa_nazwa_produktu = 'nazwa_nazwa_produktu['.$x.']';	
	$id_nazwa_produktu = 'id_nazwa_produktu_'.$x;
	echo '<td align="center"><select name="'.$nazwa_nazwa_produktu.'" id="'.$id_nazwa_produktu.'" onchange="CzyMoznaZapisac();" class="'.$styl_select.'" style="width: 200px">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_produktow; $k++) 
	if($nazwa_produktu[$x] == $produkt_opis[$k]) echo '<option selected="selected" value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	else echo '<option value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	echo '</select></td>';
	
	//   #################   kolumna DI    Cena netto za sztuke  ####################################
	$id_cena_netto_za_sztuke = 'id_cena_netto_za_sztuke_'.$x;	
	$nazwa_cena_netto_za_sztuke = 'nazwa_cena_netto_za_sztuke['.$x.']';
	echo '<td align="right" bgcolor="#ccffcc"><input type="text" value="'.$cena_netto_za_sztuke[$x].'" id="'.$id_cena_netto_za_sztuke.'" name="'.$nazwa_cena_netto_za_sztuke.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_zielone_ramka">'.$waluta.'</td>';

	//   #################   kolumna DJ    ilosc sztuk  ####################################
	$id_ilosc_sztuk = 'id_ilosc_sztuk_'.$x;
	$nazwa_ilosc_sztuk = 'nazwa_ilosc_sztuk['.$x.']';	
	echo '<td align="center"><input type="text" TABINDEX="'.$x.'" value="'.$ilosc_sztuk[$x].'" id="'.$id_ilosc_sztuk.'" name="'.$nazwa_ilosc_sztuk.'" onkeyup="ObliczNettoZaSztuke();" size="3" autocomplete="off" class="'.$styl.'"></td>';
	
	//   #################   kolumna DK    wartosc netto  ####################################
	$id_wartosc_netto = 'id_wartosc_netto_'.$x;		
	$nazwa_wartosc_netto = 'nazwa_wartosc_netto['.$x.']';	
	echo '<td align="center" bgcolor="#ffcc99"><input type="text" id="'.$id_wartosc_netto.'" value="'.$wartosc_netto[$x].'" name="'.$nazwa_wartosc_netto.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
	
	//   #################   kolumna DL    VAT  ####################################
	$id_vat = 'id_vat_'.$x;		
	$nazwa_vat = 'nazwa_vat['.$x.']';	
	echo '<td bgcolor="#ffcc99"><select name="'.$nazwa_vat.'" id="'.$id_vat.'" class="pole_select_pomaranczowe_z_ramka" style="width: 50px" onchange="ObliczWartoscBrutto();">';
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
	if($x == 1) echo '<td><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" value="'.$nr_faktury[$x].'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onchange="Skopiuj_nr_faktury();" autocomplete="off" class="'.$styl.'" readonly="readonly"></td>';
	else echo '<td><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" value="'.$nr_faktury[$x].'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onkeyup="Skasuj_date_faktury('.$x.');"  autocomplete="off" class="'.$styl.'" readonly="readonly"></td>';
	
	//   #################   kolumna DO    data faktury  ####################################
	$id_data_faktury = 'id_data_faktury_'.$x;		
	$nazwa_data_faktury = 'nazwa_data_faktury['.$x.']';	
	if($x == 1) echo '<td><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" value="'.$data_faktury[$x].'" size="10" onchange="Skopiuj_date_faktury();" autocomplete="off" class="'.$styl.'" readonly="readonly"></td>';
	else echo '<td><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" value="'.$data_faktury[$x].'" size="10" autocomplete="off" class="'.$styl.'" readonly="readonly"></td>';
	

	//   #################   kolumna DP    uwagi  ####################################
	$nazwa_uwagi = 'nazwa_uwagi['.$x.']';	
	echo '<td><textarea name="'.$nazwa_uwagi.'" TABINDEX="'.$x.'" cols="20" rows="1" class="'.$styl_uwagi.'">'.$uwagi[$x].'</textarea></td></tr>';
	
	include("php/wycena_edycja_korekta_fv_dodatkowe_wiersze.php");

	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)

	//   #########################################################################################################################
	//   #########################################################################################################################
	//    wyswietlanie pozycji transportowej
	//   #########################################################################################################################
	//   #########################################################################################################################
	//$pozycja_transport_juz_jest = 0;
	$temp_ilosc_pozycji = $ilosc_pozycji + 1;
	if($pozycja_transport[$temp_ilosc_pozycji] == 'tak')
		{
		//$pozycja_transport_juz_jest = 1;
		$x = $ilosc_pozycji + 1;
		if($x%2)
			{	
			$wiersz = $kolor_bialy;
			$styl = "pole_input_biale_ramka"; 
			$styl2 = "pole_input_biale_bez_ramki";
			$styl_select = "pole_select_biale_z_ramka"; 
			}
		else 
			{
			$wiersz = $kolor_szary;
			$styl = "pole_input_szare_ramka";
			$styl2 = "pole_input_szare_bez_ramki";
			$styl_select = "pole_select_szare_z_ramka"; 
			}
		
		echo '<tr bgcolor="'.$wiersz.'" align="center" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">'.$x.'/'.$x.'</td>';
		echo '<td align="left" colspan="111" class="text"></td>';

		//   #################   kolumna de  transport   ####################################
		echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="id_pozycja_transport_wartosc" value="'.$transport[$x].'" name="nazwa_pozycja_transport_wartosc" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="ObliczWartoscNettoPozycjaTransport();">'.$waluta.'</td>';
		
		echo '<td align="left" colspan="4" class="text"></td>';
		//   #################   kolumna DK    wartosc netto  ####################################
		echo '<td align="center" bgcolor="#ffcc99"><input type="text" id="id_wartosc_netto_pozycja_transport" value="'.$wartosc_netto[$x].'" name="nazwa_wartosc_netto_pozycja_transport" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
		
		//   #################   kolumna DL    VAT  ####################################
		echo '<td bgcolor="#ffcc99"><select name="nazwa_vat_pozycja_transport" id="id_vat_pozycja_transport" class="pole_select_pomaranczowe_z_ramka" style="width: 50px" onchange="ObliczWartoscNettoPozycjaTransport();">';
		for ($k=1; $k<=$TAB_VAT_DL; $k++) if($vat_baza[$x] == $TAB_VAT[$k]) echo '<option selected="selected" value="'.$vat_baza[$x].'">'.$TAB_VAT[$k].'</option>';
		else echo '<option value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>'; 
		echo '</select></td>';

		//   #################   kolumna DM    wartosc brutto  ####################################
		echo '<td align="center" bgcolor="#ff99cc"><input type="text" id="id_wartosc_brutto_pozycja_transport" value="'.$wartosc_brutto[$x].'" name="nazwa_wartosc_brutto_pozycja_transport" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';

		//   #################   kolumna DN    nr faktury  ####################################
		$id_nr_faktury = 'id_nr_faktury_'.$x;		
		$nazwa_nr_faktury = 'nazwa_nr_faktury['.$x.']';	
		echo '<td><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" id="'.$id_nr_faktury.'" value="'.$nr_faktury[$x].'" size="10" maxlenght="50" autocomplete="off" class="'.$styl.'" readonly="readonly"></td>';
		
		//   #################   kolumna DO    data faktury  ####################################
		$id_data_faktury = 'id_data_faktury_'.$x;		
		$nazwa_data_faktury = 'nazwa_data_faktury['.$x.']';	
		echo '<td><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" value="'.$data_faktury[$x].'" size="10" autocomplete="off" class="'.$styl.'" readonly="readonly"></td>';

		echo '<td align="left" class="text"></td></tr>';
		include("php/wycena_edycja_korekta_fv_dodatkowe_wiersze_poz_transport.php");
		}
	else echo '<input type="hidden" id="id_wartosc_netto_pozycja_transport" name="nazwa_wartosc_netto_pozycja_transport">';	// to musi być bo nie działa sumowanie netto i brutto



	echo '<tr height="'.$wysykosc_wiersza.'"><td style="background-color:#ffffff; border-bottom-color:#ffffff; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>'; //pozycja
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;">';
	echo '</td>';
	
	echo '<td align="center" colspan="95" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.','');
	echo '<td align="center" bgcolor="#ffcc99" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;"><input type="text" id="id_suma_netto" value="'.$SUMA_NETTO.'" name="nazwa_suma_netto" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
	echo '<td align="center" bgcolor="#ff99cc" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;"><input type="text" id="id_suma_brutto" value="'.$SUMA_BRUTTO.'" name="nazwa_suma_brutto" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';
	// echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"></td>';
	echo '<td align="center" colspan="3" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" '.$zapisz_disabled.' id="zapisz4" name="submit" value="Wystaw korektę faktury : '.$nr_faktury[1].'"></td></tr>';
	
	
	// dodatkowe podsumwoanie
	echo '<tr height="'.$wysykosc_wiersza.'"><td style="background-color:#ffffff; border-bottom-color:#ffffff; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>'; //pozycja
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;">';
	echo '</td>';
	
	echo '<td align="center" colspan="95" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	echo '<td align="center" bgcolor="#98f3f0" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;">'.$SUMA_NETTO.' '.$waluta.'</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	echo '<td align="center" bgcolor="#98f3f0" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;">'.$SUMA_BRUTTO.' '.$waluta.'</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"></td>';
	echo '<td align="left" colspan="4" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"></td></tr>';

	
	
	echo '</form>';
echo '</table>'; // koniec tabeli głównej

if($skad == 'zlecenie_transportowe')
	{
	echo '<table border="0" width="100%"><tr align="center">';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zlecenia_transportowego_edycja.'</td>';
	echo '</tr></table>';
	}
else
	{
	echo '<table border="0" width="100%"><tr align="center">';
		echo '<td width="10%">'.$powrot_do_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_zamowienia.'</td>';
		echo '<td width="10%">'.$powrot_do_konkretnego_zamowienia.'</td>';
	echo '</tr></table>';
	}
} // do else

?>