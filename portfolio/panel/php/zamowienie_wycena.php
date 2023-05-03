<?php

$napis_guzika_dodaj_liste = 'Dodaj listę materiałów';
$napis_guzika_edytuj_liste = 'Edytuj listę materiałów';
$napis_guzika_dodaj_karte_produkcyjna = 'Dodaj kartę produkcyjną';

if($zapisz == $napis_guzika_dodaj_karte_produkcyjna)
	{
	if($wycena_wstepna_nr ==  '') $nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	else include("php/wycena_wstepna_przyjmowanie_zamowienia.php");

	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=karta_produkcyjna_dodaj&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&jak='.$jak.'&wg_czego='.$wg_czego.'"></head>';
	}

if($zapisz == $napis_guzika_dodaj_liste)
	{
	if($wycena_wstepna_nr ==  '') $nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	else include("php/wycena_wstepna_przyjmowanie_zamowienia.php");
	
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=lista_materialow_dodaj&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&jak='.$jak.'&wg_czego='.$wg_czego.'"></head>';
	}

	$SUMA_wartosc_netto = 0;
	$SUMA_wartosc_brutto = 0;

if($etap == 3)
	{
	//  echo 'etap3<br>';
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
	$SUMA_slupki_ruchome = 0;
	$SUMA_dociecie_kompletu_listew_przyszybowych = 0;
	
	//#######################     zmieniam cennik klienta 		 ######################
	if($zmienic_cennik_klienta == 'on')
		{
		echo '<div class="text_green" align="center">Cennik klienta został zmieniony.</div>';

		$nazwa_wygiecie_ramy_z_pvc_cena[1] = change($nazwa_wygiecie_ramy_z_pvc_cena[1]);
		$nazwa_wygiecie_skrzydla_z_pvc_cena[1] = change($nazwa_wygiecie_skrzydla_z_pvc_cena[1]);
		$nazwa_wygiecie_listwy_z_pvc_cena[1] = change($nazwa_wygiecie_listwy_z_pvc_cena[1]);
		$nazwa_wygiecie_innego_elementu_z_pvc_cena[1] = change($nazwa_wygiecie_innego_elementu_z_pvc_cena[1]);
		$nazwa_wygiecie_skrzydla_z_alu_cena[1] = change($nazwa_wygiecie_skrzydla_z_alu_cena[1]);
		$nazwa_wygiecie_skrzydla_z_alu_cena[1] = change($nazwa_wygiecie_skrzydla_z_alu_cena[1]);
		$nazwa_wygiecie_listwy_z_alu_cena[1] = change($nazwa_wygiecie_listwy_z_alu_cena[1]);
		$nazwa_wygiecie_innego_elementu_z_alu_cena[1] = change($nazwa_wygiecie_innego_elementu_z_alu_cena[1]);
		$nazwa_wygiecie_wzmocnienia_okiennego_cena[1] = change($nazwa_wygiecie_wzmocnienia_okiennego_cena[1]);
		$nazwa_wygiecie_innego_elementu_ze_stali_cena[1] = change($nazwa_wygiecie_innego_elementu_ze_stali_cena[1]);
		$nazwa_zgrzanie_cena[1] = change($nazwa_zgrzanie_cena[1]);
		$nazwa_wyfrezowanie_odwodnienia_cena[1] = change($nazwa_wyfrezowanie_odwodnienia_cena[1]);

		$nazwa_wstawienie_slupka_cena[1] = change($nazwa_wstawienie_slupka_cena[1]);
		$nazwa_dociecie_listwy_przyszybowej_cena[1] = change($nazwa_dociecie_listwy_przyszybowej_cena[1]);
		$nazwa_wstawienie_slupka_ruchomego_cena[1] = change($nazwa_wstawienie_slupka_ruchomego_cena[1]);
		$nazwa_dociecie_kompletu_listew_przyszybowych_cena[1] = change($nazwa_dociecie_kompletu_listew_przyszybowych_cena[1]);

		$nazwa_okucie_cena[1] = change($nazwa_okucie_cena[1]);
		$nazwa_zaszklenie_cena[1] = change($nazwa_zaszklenie_cena[1]);
		$nazwa_wykonanie_innej_uslugi_cena[1] = change($nazwa_wykonanie_innej_uslugi_cena[1]);
		$nazwa_oscieznica_cena[1] = change($nazwa_oscieznica_cena[1]);
		$nazwa_skrzydlo_cena[1] = change($nazwa_skrzydlo_cena[1]);
		$nazwa_listwa_cena[1] = change($nazwa_listwa_cena[1]);
		$nazwa_slupek_cena[1] = change($nazwa_slupek_cena[1]);
		$nazwa_wzmocnienie_do_ramy_cena[1] = change($nazwa_wzmocnienie_do_ramy_cena[1]);
		$nazwa_wzmocnienie_do_skrzydla_cena[1] = change($nazwa_wzmocnienie_do_skrzydla_cena[1]);
		$nazwa_wzmocnienie_do_slupka_cena[1] = change($nazwa_wzmocnienie_do_slupka_cena[1]);
		$nazwa_wzmocnienie_do_luku_cena[1] = change($nazwa_wzmocnienie_do_luku_cena[1]);
		$nazwa_okucia_cena[1] = change($nazwa_okucia_cena[1]);
		$nazwa_szyby_cena[1] = change($nazwa_szyby_cena[1]);
		$nazwa_inny_element_cena[1] = change($nazwa_inny_element_cena[1]);


		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_ramy_z_pvc=".$nazwa_wygiecie_ramy_z_pvc_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_skrzydla_z_pvc=".$nazwa_wygiecie_skrzydla_z_pvc_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_listwy_z_pvc=".$nazwa_wygiecie_listwy_z_pvc_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_innego_elementu_z_pvc=".$nazwa_wygiecie_innego_elementu_z_pvc_cena[1]." WHERE id=".$klient.";");
		
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_ramy_z_alu=".$nazwa_wygiecie_ramy_z_alu_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_skrzydla_z_alu=".$nazwa_wygiecie_skrzydla_z_alu_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_listwy_z_alu=".$nazwa_wygiecie_listwy_z_alu_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_innego_elementu_z_alu=".$nazwa_wygiecie_innego_elementu_z_alu_cena[1]." WHERE id=".$klient.";");

		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_wzmocnienia_okiennego=".$nazwa_wygiecie_wzmocnienia_okiennego_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wygiecie_innego_elementu_ze_stali=".$nazwa_wygiecie_innego_elementu_ze_stali_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET zgrzanie=".$nazwa_zgrzanie_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wyfrezowanie_odwodnienia=".$nazwa_wyfrezowanie_odwodnienia_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wstawienie_slupka=".$nazwa_wstawienie_slupka_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET dociecie_listwy_przyszybowej=".$nazwa_dociecie_listwy_przyszybowej_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wstawienie_slupka_ruchomego=".$nazwa_wstawienie_slupka_ruchomego_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET dociecie_kompletu_listew_przyszybowych=".$nazwa_dociecie_kompletu_listew_przyszybowych_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET okucie=".$nazwa_okucie_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET zaszklenie=".$nazwa_zaszklenie_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wykonanie_innej_usługi=".$nazwa_wykonanie_innej_uslugi_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET oscieznica=".$nazwa_oscieznica_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET skrzydlo=".$nazwa_skrzydlo_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET listwa=".$nazwa_listwa_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET slupek=".$nazwa_slupek_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wzmocnienie_do_ramy=".$nazwa_wzmocnienie_do_ramy_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wzmocnienie_do_skrzydla=".$nazwa_wzmocnienie_do_skrzydla_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wzmocnienie_do_slupka=".$nazwa_wzmocnienie_do_slupka_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET wzmocnienie_do_luku=".$nazwa_wzmocnienie_do_luku_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET okucia=".$nazwa_okucia_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET szyby=".$nazwa_szyby_cena[1]." WHERE id=".$klient.";");
		$modyfikuj=mysqli_query($conn, "UPDATE klienci SET inny_element=".$nazwa_inny_element_cena[1]." WHERE id=".$klient.";");		
		}
	
	//echo 'ilosc pozycji = '.$ilosc_pozycji.'<br>';
	

	// zapis danych do bazy
	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		//zapisuje ostatnie ustawienie checkboxa od wzmocnienia okiennego dla tego klienta
		if($i == 1)	mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_checkbox_wygiecie_wzmocnienia = '".$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]."' WHERE id = ".$klient.";");

		// rozbicie daty faktury na time
		if($nazwa_data_faktury[$i] != '') 
			{
			$pieces = explode("-", $nazwa_data_faktury[$i]);		
			$data_faktury_time[$i] = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
			$data_faktury_miesiac = $pieces[1];
			$data_faktury_rok = $pieces[2];
			if($data_faktury_miesiac != 10) $data_faktury_miesiac = zamien_dowolne_znaki($data_faktury_miesiac, '0', '');
			}
	
	
		// zamiana ewentualnych przecinków na kropki
		include ("php/wycena_dodatkowe_zabezpieczenie.php");
		include ("php/wycena_zamiana_przecinkow_na_kropki.php");

		// BRAK DANYCH!! uzupełniamy dane
		if($zamowienie_id)
			{
			$pytanie22 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
			while($wynik22= mysqli_fetch_assoc($pytanie22))
				{
				$klient=$wynik22['klient_id'];
				$nr_zamowienia=$wynik22['nr_zamowienia'];
				$klient_nazwa=$wynik22['klient_nazwa'];
				}
			}
		
		if($pozycja_transport == 'tak') $nowa_ilosc_pozycji = $ilosc_pozycji + 1; 
		else $nowa_ilosc_pozycji = $ilosc_pozycji;//jezeli jest pozycja transportowa to zwiekszamy ilosc pozycji

		//insert do bazy
			$sql = "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`
			, `wygiecie_ramy_pvc_ilosc_szt`, `wygiecie_ramy_pvc_ilosc_m`, `wygiecie_ramy_pvc_cena`, `wygiecie_ramy_pvc_wartosc`
			, `wygiecie_skrzydla_pvc_ilosc_szt`, `wygiecie_skrzydla_pvc_ilosc_m`, `wygiecie_skrzydla_pvc_cena`, `wygiecie_skrzydla_pvc_wartosc`
			, `wygiecie_listwy_pvc_ilosc_szt`, `wygiecie_listwy_pvc_ilosc_m`, `wygiecie_listwy_pvc_cena`, `wygiecie_listwy_pvc_wartosc`
			, `wygiecie_innego_pvc_ilosc_szt`, `wygiecie_innego_pvc_ilosc_m`, `wygiecie_innego_pvc_cena`, `wygiecie_innego_pvc_wartosc`
			 
			, `wygiecie_ramy_alu_ilosc_szt`, `wygiecie_ramy_alu_ilosc_m`, `wygiecie_ramy_alu_cena`, `wygiecie_ramy_alu_wartosc`
			, `wygiecie_skrzydla_alu_ilosc_szt`, `wygiecie_skrzydla_alu_ilosc_m`, `wygiecie_skrzydla_alu_cena`, `wygiecie_skrzydla_alu_wartosc`
			, `wygiecie_listwy_alu_ilosc_szt`, `wygiecie_listwy_alu_ilosc_m`, `wygiecie_listwy_alu_cena`, `wygiecie_listwy_alu_wartosc`
			, `wygiecie_innego_alu_ilosc_szt`, `wygiecie_innego_alu_ilosc_m`, `wygiecie_innego_alu_cena`, `wygiecie_innego_alu_wartosc`
			 
			, `wygiecie_wzmocnienia_okiennego_ilosc_szt`, `wygiecie_wzmocnienia_okiennego_ilosc_m`, `wygiecie_wzmocnienia_okiennego_cena`, `wygiecie_wzmocnienia_okiennego_wartosc`
			, `wygiecie_innego_ilosc_szt`, `wygiecie_innego_ilosc_m`, `wygiecie_innego_cena`, `wygiecie_innego_wartosc`
			 
			, `zgrzanie_ilosc`, `zgrzanie_cena`, `zgrzanie_wartosc`
			, `wyfrezowanie_odwodnienia_ilosc`, `wyfrezowanie_odwodnienia_cena`, `wyfrezowanie_odwodnienia_wartosc`
			, `wstawienie_slupka_ilosc`, `wstawienie_slupka_cena`, `wstawienie_slupka_wartosc`
			, `listwa_przyszybowa_ilosc`, `listwa_przyszybowa_cena`, `listwa_przyszybowa_wartosc`
			, `okucie_ilosc`, `okucie_cena`, `okucie_wartosc`
			, `zaszklenie_ilosc`, `zaszklenie_cena`, `zaszklenie_wartosc`
			, `innej_uslugi_ilosc`, `innej_uslugi_cena`, `innej_uslugi_wartosc`
			 
			, `oscieznica_ilosc`, `oscieznica_cena`, `oscieznica_wartosc`
			, `skrzydlo_ilosc`, `skrzydlo_cena`, `skrzydlo_wartosc`
			, `listwa_ilosc`, `listwa_cena`, `listwa_wartosc`
			, `slupek_ilosc`, `slupek_cena`, `slupek_wartosc`
			, `wzmocnienie_ramy_ilosc`, `wzmocnienie_ramy_cena`, `wzmocnienie_ramy_wartosc`
			, `wzmocnienie_skrzydla_ilosc`, `wzmocnienie_skrzydla_cena`, `wzmocnienie_skrzydla_wartosc`
			, `wzmocnienie_slupka_ilosc`, `wzmocnienie_slupka_cena`, `wzmocnienie_slupka_wartosc`
			, `wzmocnienie_luku_ilosc`, `wzmocnienie_luku_cena`, `wzmocnienie_luku_wartosc`
			, `okucia_ilosc`, `okucia_cena`, `okucia_wartosc`
			, `szyby_ilosc`, `szyby_cena`, `szyby_wartosc`
			, `inny_element_ilosc`, `inny_element_cena`, `inny_element_wartosc`
			
			, `okna`, `drzwi_wewnetrzne`, `drzwi_zewnetrzne` ,`bramy`, `parapety`, `rolety_zewnetrzne`
			, `rolety_wewnetrzne`, `moskitiery`, `montaz` ,`odpady_pvc`, `odpady_alu_stal`, `transport`, `inne`
			, `nazwa_produktu`, `cena_netto_za_sztuke`

			, `ilosc_sztuk`, `wartosc_netto`, `vat` ,`wartosc_brutto`, `nr_faktury`, `data_faktury`
			, `uwagi`, `korekta_fv`, `data_dodania_pozycji`, `dodal_user_id`

			, `checkbox_wygiecie_wzmocnienia`, `checkbox_wygiecie_skrzydla`, `checkbox_wygiecie_listwy`
			, `wstawienie_slupka_ruchomego_ilosc`, `wstawienie_slupka_ruchomego_cena`, `wstawienie_slupka_ruchomego_wartosc`
			
			, `dociecie_kompletu_listew_przyszybowych_ilosc`, `dociecie_kompletu_listew_przyszybowych_cena`, `dociecie_kompletu_listew_przyszybowych_wartosc`, `stopien_trudnosci`
			)


			values ('$klient', '$klient_nazwa', '$zamowienie_id', '$nr_zamowienia', '$nowa_ilosc_pozycji', '$i', 'nie'
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
			, '$nazwa_listwa_ilosc_m[$i]', '$nazwa_listwa_cena[$i]', '$nazwa_listwa_wartosc[$i]'
			, '$nazwa_slupek_ilosc_m[$i]', '$nazwa_slupek_cena[$i]', '$nazwa_slupek_wartosc[$i]'
			, '$nazwa_wzmocnienie_do_ramy_ilosc_m[$i]', '$nazwa_wzmocnienie_do_ramy_cena[$i]', '$nazwa_wzmocnienie_do_ramy_wartosc[$i]'
			, '$nazwa_wzmocnienie_do_skrzydla_ilosc_m[$i]', '$nazwa_wzmocnienie_do_skrzydla_cena[$i]', '$nazwa_wzmocnienie_do_skrzydla_wartosc[$i]'
			, '$nazwa_wzmocnienie_do_slupka_ilosc_m[$i]', '$nazwa_wzmocnienie_do_slupka_cena[$i]', '$nazwa_wzmocnienie_do_slupka_wartosc[$i]'
			, '$nazwa_wzmocnienie_do_luku_ilosc_m[$i]', '$nazwa_wzmocnienie_do_luku_cena[$i]', '$nazwa_wzmocnienie_do_luku_wartosc[$i]'
			, '$nazwa_okucia_ilosc_m[$i]', '$nazwa_okucia_cena[$i]', '$nazwa_okucia_wartosc[$i]'
			, '$nazwa_szyby_ilosc_m[$i]', '$nazwa_szyby_cena[$i]', '$nazwa_szyby_wartosc[$i]'
			, '$nazwa_inny_element_ilosc_m[$i]', '$nazwa_inny_element_cena[$i]', '$nazwa_inny_element_wartosc[$i]'

			, '$nazwa_okna_wartosc[$i]', '$nazwa_drzwi_wewnetrzne_wartosc[$i]', '$nazwa_drzwi_zewnetrzne_wartosc[$i]'
			, '$nazwa_bramy_wartosc[$i]', '$nazwa_parapety_wartosc[$i]', '$nazwa_rolety_zewnetrzne_wartosc[$i]'
			, '$nazwa_rolety_wewnetrzne_wartosc[$i]', '$nazwa_moskitiery_wartosc[$i]', '$nazwa_montaz_wartosc[$i]'
			, '$nazwa_odpady_z_pvc_wartosc[$i]', '$nazwa_odpady_ze_stali_wartosc[$i]', '$nazwa_transport_wartosc[$i]', '$nazwa_inne_wartosc[$i]' 
			, '$nazwa_produktu[$i]', '$nazwa_cena_netto_za_sztuke[$i]'

			, '$nazwa_ilosc_sztuk[$i]', '$nazwa_wartosc_netto[$i]', '$nazwa_vat[$i]', '$nazwa_wartosc_brutto[$i]', '$nazwa_nr_faktury[$i]', '$nazwa_data_faktury[$i]', '$nazwa_uwagi[$i]', 'NIE', '$time', '$user_id'
			
			, '$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]'
			, '$nazwa_wygiecie_skrzydla_ptaszek[$i]'
			, '$nazwa_wygiecie_listwy_ptaszek[$i]'
			, '$nazwa_wstawienie_slupka_ruchomego_ilosc_m[$i]'
			, '$nazwa_wstawienie_slupka_ruchomego_cena[$i]'
			, '$nazwa_wstawienie_slupka_ruchomego_wartosc[$i]'
			, '$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m[$i]', '$nazwa_dociecie_kompletu_listew_przyszybowych_cena[$i]', '$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc[$i]', '$nazwa_stopien_trudnosci[$i]'
			);";

		mysqli_query($conn, $sql);

//sumowanie łukóww itp do tabeli zamowienia
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
		} //for($i = 1; $i <= $ilosc_pozycji; $i++)
	

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
			// if((eregi('\0', $data_faktury_miesiac)) && ($data_faktury_miesiac != 10)) $data_faktury_miesiac = str_replace("0", ";", $data_faktury_miesiac);
			}
		$SUMA_wartosc_netto += $nazwa_wartosc_netto_pozycja_transport;
		$SUMA_wartosc_brutto += $nazwa_wartosc_brutto_pozycja_transport;
		
		$nazwa_wartosc_netto_pozycja_transport = change($nazwa_wartosc_netto_pozycja_transport);
		$nazwa_wartosc_brutto_pozycja_transport = change($nazwa_wartosc_brutto_pozycja_transport);
		$pytanie1 = mysqli_query($conn, "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `status`, `transport`, `nazwa_produktu`, `wartosc_netto`, `vat` ,`wartosc_brutto`, `nr_faktury`, `data_faktury`, `data_faktury_time`, `data_faktury_miesiac`, `data_faktury_rok`, `korekta_fv`)
		values ('$klient', '$klient_nazwa', '$zamowienie_id', '$nr_zamowienia', '$nowa_ilosc_pozycji', '$nowa_ilosc_pozycji', 'tak', '$status', '$nazwa_pozycja_transport_wartosc', 'Transport', '$nazwa_wartosc_netto_pozycja_transport', '$nazwa_vat_pozycja_transport', '$nazwa_wartosc_brutto_pozycja_transport', '$nazwa_nr_faktury[$nowa_ilosc_pozycji]', '$nazwa_data_faktury[$nowa_ilosc_pozycji]', '$data_faktury_time[$nowa_ilosc_pozycji]', '$data_faktury_miesiac', '$data_faktury_rok', 'NIE');");
		}
//koniec if($pozycja_transport == 'tak')

	
//zmiana w tabeli zamowienia
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
	$pytanie106 = mysqli_query($conn, "UPDATE zamowienia SET slupek_ruchomy = ".$SUMA_slupki_ruchome." WHERE id = ".$zamowienie_id.";");
	$pytanie106 = mysqli_query($conn, "UPDATE zamowienia SET komplet_listew = ".$SUMA_dociecie_kompletu_listew_przyszybowych." WHERE id = ".$zamowienie_id.";");
	
	
	$SUMA_wartosc_netto = change($SUMA_wartosc_netto);
	$SUMA_wartosc_brutto = change($SUMA_wartosc_brutto);

	$pytanie11 = "UPDATE zamowienia SET wartosc_netto = ".$SUMA_wartosc_netto." WHERE id = ".$zamowienie_id.";";
	mysqli_query($conn, $pytanie11);

	$pytanie111 = mysqli_query($conn, "UPDATE zamowienia SET wartosc_brutto = ".$SUMA_wartosc_brutto." WHERE id = ".$zamowienie_id.";");
	
} // do if etap == 3

if($zapisz == '+')
	{
	$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $SUMA_wartosc_netto, $SUMA_wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=ustawienia_dz_lista&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"> </head>';
	}


if($zapisz == 'Zapisz')
	{
	if($wycena_wstepna_nr != '') include("php/wycena_wstepna_przyjmowanie_zamowienia.php");
	else 
	{
		$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $SUMA_wartosc_netto, $SUMA_wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	}
	
	
	//dodajemy date ostatniego zamowienia dla klienta
	$data_ostatniego_zamowienia = date('d-m-Y', $time);
	$pytanie133 = mysqli_query($conn, "UPDATE ".$tabela_klientow." SET data_ostatniego_zamowienia = '".$data_ostatniego_zamowienia."' WHERE id = ".$klient.";");
		
	// dodajemy zamowienie do zlecen transportowych
	if($nr_zlecenia_transportowego != '')
		{
		//pobieram sposob_platnosci ze zlecenia transportowego
		$pytanie154 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient.";");
		while($wynik154= mysqli_fetch_assoc($pytanie154))
			{
			$sposob_platnosci_zlecenie_transp = $wynik154['sposob_platnosci'];
			}

		//pobieram sposob_platnosci z bazy klienta
		$pytanie14 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
		while($wynik14= mysqli_fetch_assoc($pytanie14))
			{
			$klient_sposob_platnosci=$wynik14['sposob_platnosci'];
			}
		if($sposob_platnosci_zlecenie_transp != '') $klient_sposob_platnosci = $sposob_platnosci_zlecenie_transp;
		
		
		//echo 'zamowienie id='.$zamowienie_id.'<br>';
		$ilosc_pozycji_wycena = 0;
		$pytanie33 = mysqli_query($conn, "SELECT wartosc_brutto FROM wyceny WHERE zamowienie_id=".$zamowienie_id.";");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$ilosc_pozycji_wycena++;
			$wartosc_brutto_wycena[$ilosc_pozycji_wycena]=$wynik33['wartosc_brutto'];
			}
		//$query = mysqli_query($conn, "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `kwota_brutto`) values ('$nr_zlecenia_transportowego', '$klient', '$zamowienie_id', '$wartosc_brutto_wycena');");
		//echo 'ilosc_pozycji_wycena='.$ilosc_pozycji_wycena.'<br>';
		for ($k=1; $k<=$ilosc_pozycji_wycena; $k++)
			{
			$query = mysqli_query($conn, "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `kwota_brutto`, `pozycja_wyceny`, `sposob_platnosci`) 
			values ('$nr_zlecenia_transportowego', '$klient', '$zamowienie_id', '$wartosc_brutto_wycena[$k]', '$k', '$klient_sposob_platnosci');");
			}
		
		}
	
	
	// to trzeba pobrac z bazy
	//echo '<b>klient_email_potwierdzenie_pvc='.$klient_email_potwierdzenie_pvc.'<br>';
	//echo 'klient_email_potwierdzenie_alu</b>='.$klient_email_potwierdzenie_alu.'<br>';
	
		$wyslij = 0;
		$pytanie333 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			{
			$klient_email_potwierdzenie_pvc=$wynik333['potwierdzenie_pvc_email'];
			$klient_email_potwierdzenie_alu=$wynik333['potwierdzenie_alu_email'];
			}
	
		//echo 'bez_potwierdzenia='.$bez_potwierdzenia.'<br>';
	
	
		if($bez_potwierdzenia == '') //wyslij potwierdzenie
			{
			//echo '1 wysylam<br>';
			$pytanie13 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_potwierdzenie_zamowienia = '".$klient_potwierdzenie."' WHERE id = ".$klient.";");
			
			include('php/potwierdzenie.php'); //jezeli puste wyslij potwierdzenie, jezeli 1 nie wysylaj
			
			$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = 'Potwierdzone' WHERE id = ".$zamowienie_id.";");
			echo '<div class="text_duzy_niebieski" align="center">Status zamówienia został zmieniony na : Potwierdzone.</div>';
			}
	
	echo '<div class="text_duzy_niebieski" align="center">Zamówienie zostało dopisane.</div>';
	echo $powrot_do_zamowienia;
	} // do if zapisz


if($zapisz != 'Zapisz')
{
	// echo 'etap4<br>';
	if($wycena_wstepna_nr != '')
		{
		$napis_tytulowy = 'Przyjmij zamówienie z wyceny wstępnej nr : '.$wycena_wstepna_nr;
		$status = 'Nie potwierdzone';
		//wybralismy miasto dostawy
		$pytanie188 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
		while($wynik188= mysqli_fetch_assoc($pytanie188))
			{
			$klient_dostawy_miasto=$wynik188['dostawy_miasto'];
			$klient_pomocniczy_miasto=$wynik188['dostawy_pomocniczy_miasto'];
			}

		if($adres_dostawy != '')
			{
			if($adres_dostawy == 'glowny') $miasto_dostawy = $klient_dostawy_miasto;
			if($adres_dostawy == 'pomocniczy') $miasto_dostawy = $klient_pomocniczy_miasto;
			}
		else $miasto_dostawy = $klient_dostawy_miasto;
		
		//przyjmuje zamowienie z wyceny wstepnej
		$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = 1;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$klient=$wynik['klient_id'];
			$klient_nazwa=$wynik['klient_nazwa'];
			$typ_zamowienia = 'Zamówienie';
			
			$pytanie33 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_zamowienia';");
			while($wynik33= mysqli_fetch_assoc($pytanie33))
				{
				$kolejny_nr_zamowienia=$wynik33['opis'];
				}
			$nr_zamowienia = $kolejny_nr_zamowienia."/".$AKTUALNY_MIESIAC."/".$aktualny_rok;

			$data_przyjecia = date('d-m-Y', $time);
			$produkt=$wynik['nazwa_produktu'];
			$kolor_profili=$wynik['kolor'];
			$ilosc_pozycji=$wynik['ilosc_pozycji'];
			}		
		}
	else
		{
		$napis_tytulowy = 'Kontynuuj dodawanie zamówienia';
		// kontynuuje dodwanie zamowienia
		if($zamowienie_id)
			{
			$pytanie = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id=$zamowienie_id;");
			while($wynik= mysqli_fetch_assoc($pytanie))
				{
				$klient = $wynik['klient_id'];
				$typ_zamowienia = $wynik['typ'];
				$data_przyjecia=$wynik['data_przyjecia'];
				$nr_zamowienia=$wynik['nr_zamowienia'];
				$nr_zamowienia_klienta=$wynik['nr_zamowienia_klienta'];
				$produkt=$wynik['zamowiony_produkt'];
				$profil=$wynik['system_profili'];
				$strefa=$wynik['strefa'];
				$rodzaj_okuc=$wynik['rodzaj_okuc'];
				$rodzaj_szyb=$wynik['rodzaj_szyb'];
				$kolor_profili=$wynik['kolor_profili'];
				$kolor_uszczelek=$wynik['kolor_uszczelek'];
				$magazyn=$wynik['magazyn'];
				$stan=$wynik['stan'];
				$termin_realizacji=$wynik['termin_realizacji'];
				$data_dostawy=$wynik['data_dostawy'];
				$nr_zlecenia_transportowego=$wynik['nr_zlecenia_transportowego'];
				$status=$wynik['status'];
				$uwagi=$wynik['uwagi'];
				$uwaga_1=$wynik['uwaga_1'];
				$uwaga_2=$wynik['uwaga_2'];
				$uwagi_do_email=$wynik['uwagi_do_email'];
				$miasto_dostawy=$wynik['miasto_dostawy'];
				$odbior_materialu_od_klienta=$wynik['odbior_materialu'];
				}
			}
		}


echo '<div class="text_duzy" align="center">'.$napis_tytulowy.'</div>';

echo '<table width="1400px" align="center" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
echo '<FORM action="index.php?page=zamowienie_wycena" method="post">';
echo '<INPUT type="hidden" name="zamowienie_wycena" value="zamowienie_wycena">';
echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
echo '<INPUT type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
echo '<INPUT type="hidden" name="jak" value="DESC">';
echo '<INPUT type="hidden" name="skad" value="zamowienie_wycena">';
echo '<INPUT type="hidden" name="wg_czego" value="id">';
echo '<INPUT type="hidden" name="strefa" value="'.$strefa.'">';
echo '<INPUT type="hidden" name="SORT_STAN" value="'.$SORT_STAN.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZLECENIA_TRANSPORTOWEGO" value="'.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'">';
echo '<INPUT type="hidden" name="SORT_PROFIL" value="'.$SORT_PROFIL.'">';
echo '<INPUT type="hidden" name="SORT_RODZAJ_SZYB" value="'.$SORT_RODZAJ_SZYB.'">';
echo '<INPUT type="hidden" name="SORT_RODZAJ_OKUC" value="'.$SORT_RODZAJ_OKUC.'">';
echo '<INPUT type="hidden" name="pokaz" value="'.$pokaz.'">';
echo '<INPUT type="hidden" name="SORT_MAGAZYN" value="'.$SORT_MAGAZYN.'">';
echo '<INPUT type="hidden" name="SORT_KOLOR_PROFILI" value="'.$SORT_KOLOR_PROFILI.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA" value="'.$SORT_NR_ZAMOWIENIA.'">';
echo '<INPUT type="hidden" name="SORT_STREFA" value="'.$SORT_STREFA.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA_KLIENTA" value="'.$SORT_NR_ZAMOWIENIA_KLIENTA.'">';
echo '<INPUT type="hidden" name="SORT_ZAMOWIONY_PRODUKT" value="'.$SORT_ZAMOWIONY_PRODUKT.'">';
echo '<INPUT type="hidden" name="SORT_TERMIN_REALIZACJI" value="'.$SORT_TERMIN_REALIZACJI.'">';
echo '<INPUT type="hidden" name="miasto_dostawy" value="'.$miasto_dostawy.'">';

echo '<INPUT type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
echo '<INPUT type="hidden" name="SORT_DATA_PRZYJECIA" value="'.$SORT_DATA_PRZYJECIA.'">';
echo '<INPUT type="hidden" name="SORT_DATA_DOSTAWY" value="'.$SORT_DATA_DOSTAWY.'">';
echo '<INPUT type="hidden" name="SORT_NR_WYCENY" value="'.$SORT_NR_WYCENY.'">';
echo '<INPUT type="hidden" name="SORT_STATUS" value="'.$SORT_STATUS.'">';
echo '<INPUT type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';

echo '<INPUT type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
echo '<INPUT type="hidden" name="pierwsza_data_przyjecia" value="'.$data_przyjecia.'">';

echo '<INPUT type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
echo '<INPUT type="hidden" name="typ_zamowienia" value="zamowienie">';


	$szerokosc_kolumna1 = '40%';
	$szerokosc_kolumna2 = '20%';
	$szerokosc_kolumna3 = '40%';
	$szerokosc_pola_input = 'size="52"';

	echo '<table width="100%" align="center" border="0" cellpadding="3" cellpadding="3">';
	$pytanie3 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$klient_nazwa=$wynik3['nazwa'];
		$klient_email_potwierdzenie_pvc=$wynik3['potwierdzenie_pvc_email'];
		$klient_email_potwierdzenie_alu=$wynik3['potwierdzenie_alu_email'];
		$strefa_klient=$wynik3['strefa'];
		}
	
	//if(($status != 'Dostarczone') && ($status != 'Odebrane') && ($status != 'Anulowane')) $styl = 'pole_input_edycja';
	//else $styl = 'pole_input';
	
	$styl = 'pole_input';

	echo '<tr align="center" class="text"><td align="right" width="'.$szerokosc_kolumna1.'" class="text">'.$kol_klient.' : </td><td align="left" width="'.$szerokosc_kolumna2.'">'.$klient_nazwa.' ('.$miasto_dostawy.')</td><td width="'.$szerokosc_kolumna3.'"></td></tr>';
	
	// TYLKO JAK Z WYCENY WSTEPNEJ
	if($wycena_wstepna_nr != '')
		{
		// ##############################    adresy dostawy
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
					}
				else $checked_adres_dostawy_glowny = '';
				
				if($adres_dostawy == 'pomocniczy') 
					{
					$checked_adres_dostawy_pomocniczy = 'checked'; 
					$miasto_dostawy = $klient_pomocniczy_miasto;
					}
				else $checked_adres_dostawy_pomocniczy = '';
				if($adres_dostawy == '') $checked_adres_dostawy_glowny = 'checked';	
				
				
				echo '<tr align="center"><td width="50%">Adres główny&nbsp;<input type="radio" name="adres_dostawy" value="glowny" onchange="submit();" '.$checked_adres_dostawy_glowny.'></td><td width="50%">Adres pomocniczy&nbsp;<input type="radio" name="adres_dostawy" onchange="submit();" value="pomocniczy" '.$checked_adres_dostawy_pomocniczy.'></td></tr>';
			
				echo '<tr align="center"><td>';
					echo $klient_dostawy_ulica.'<br>';
					echo $klient_dostawy_kod_pocztowy.' '.$klient_dostawy_miasto;
				echo '</td><td width="50%">';
					echo $klient_pomocniczy_ulica.'<br>';
					echo $klient_pomocniczy_kod_pocztowy.' '.$klient_pomocniczy_miasto;
				echo '</td></tr>';
				echo '</table>';
			echo '</td></tr>';
			}
		else 
			{
			$miasto_dostawy = $klient_dostawy_miasto;
			}
		echo '<INPUT type="hidden" name="miasto_dostawy" value="'.$miasto_dostawy.'">';
		// ############################## KONIEC  adresy dostawy
		}
	
	
	echo '<tr align="center" class="text"><td align="right">'.$kol_nr_zamowienia.' : </td><td align="left">'.$nr_zamowienia.'</td><td></td></tr>';
	echo '<tr align="center" class="text"><td align="right">'.$kol_nr_zamowienia_klienta2.' : </td><td align="left"><input autocomplete="off" type="text" '.$szerokosc_pola_input.' maxlength="20" class="'.$styl.'" name="nr_zamowienia_klienta" value="'.$nr_zamowienia_klienta.'"></td><td></td></tr>';


	// produkty
	$ilosc_produktow = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	// system profile
	$ilosc_profili = 0;
	$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='profil' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// kolor profili
	$ilosc_kolor_profili = 0;
	$pytanie6 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_profili' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';



	// magazyn
	$ilosc_magazyn = 0;
	$pytanie8 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='magazyn' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	// stan
	$ilosc_stan = 0;
	$pytanie9 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='stan' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';
	
	// odbiór materialu od klienta
	echo '<tr align="center" class="text"><td align="right">Odbiór materiału od klienta : </td><td align="left">';
		if($odbior_materialu_od_klienta == 'on') echo '<input type="checkbox" checked name="odbior_materialu">';
		else echo '<input type="checkbox" name="odbior_materialu">';
	echo '</td><td align="left"></td></tr>';

	// kolor uszczelek
	$ilosc_kolor_uszczelek = 0;
	$pytanie7 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_uszczelek' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// rodzaj okuc
	$ilosc_rodzaj_okuc = 0;
	$pytanie4 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_okuc' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	// rodzaj szyb
	$ilosc_rodzaj_szyb = 0;
	$pytanie5 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_szyb' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';
	




// usunięte bo nie ma zam id, jest puste i generowało błędy wczytywania strony.

if($wycena_wstepna_nr == '')
{
	//#########################################   KARTA PRODUKCYJNA  #####################################
	echo '<tr align="center" class="text"><td align="right">Karta produkcyjna : </td><td align="left">';


		echo '<INPUT type="submit" name="zapisz" value="'.$napis_guzika_dodaj_karte_produkcyjna.'">';
		//sprawdzamy czy pliki s dodane do zamwienia
		$ilosc_plikow = 0;
		$pytanie14 = mysqli_query($conn, "SELECT * FROM karta_produkcyjna_pliki WHERE zamowienie_id = ".$zamowienie_id.";");
		while($wynik14= mysqli_fetch_assoc($pytanie14))
			{
			$ilosc_plikow++;
			$nazwa_pliku[$ilosc_plikow]=$wynik14['nazwa_pliku'];
			}

	// echo 'ilosc_plikow='.$ilosc_plikow.'<br>';

	if($ilosc_plikow != 0)
		{
		$szerokosc_tabeli = 400;
		$sciezka = '../panel_dane/karta_produkcyjna_pliki';
		echo '<br><table width="'.$szerokosc_tabeli.'px" align="left" border="1" cellspacing="1" cellpadding="1" BORDERCOLOR="black" frame="box" RULES="all" bgcolor="'.$kolor_bialy.'">';
		$ilosc_kolumn = 3;
		$szerokosc_kolumny = 100/$ilosc_kolumn;
		$szerokosc_obrazkow = $szerokosc_tabeli/$ilosc_kolumn;
		
		$licz = 0;
		for($x=1; $x<=$ilosc_plikow; $x++) 
			{
			if($licz == 0) echo '<tr bgcolor="'.$kolor_bialy.'">';	
			// if($licz < $ilosc_kolumn)
				{
				$licz++;
				echo '<td class="text_duzy" width="'.$szerokosc_kolumny.'%" valign="middle" align="center" bgcolor="'.$kolor_bialy.'">';
				echo '<center><a href="http://'.$adres_serwera_do_faktur.'/'.$znaczek_tylda.'panel_dane/karta_produkcyjna_pliki/'.$nazwa_pliku[$x].'" data-lightbox="roadtrip" data-title="'.$nazwa_pliku[$x].'">';
				echo '<img src="http://'.$adres_serwera_do_faktur.'/'.$znaczek_tylda.'panel_dane/karta_produkcyjna_pliki/'.$nazwa_pliku[$x].'" width="'.$szerokosc_obrazkow.'px">';
				echo '</a></center>';
				echo '</td>';
				}
			if($licz == $ilosc_kolumn) 
				{
				echo '</tr>';	
				$licz=0;
				}
			}
		echo '</table>';
		}

	
	echo '</td></tr>';
	##########################################################################################################################
}

	//#########################################   LISTA MATERIALOW  #####################################
	echo '<tr align="center" class="text"><td align="right">Lista materialow : </td><td align="left">';

		// if($lista_materialow_nr == '')
		// 	{
			echo '<INPUT type="submit" name="zapisz" value="'.$napis_guzika_dodaj_liste.'">';
		// 	}
		// else
		// 	{
		// 	echo '<INPUT type="submit" name="zapisz" value="'.$napis_guzika_edytuj_liste.'">';
		// 	echo '<table border="0" width="100%" class="text">';
		// 	echo '<tr><td width="25%" align="left">';
		// 		echo $lista_materialow_status;
		// 	echo '</td><td width="50%" align="center">';
		// 		echo $lista_materialow_email;
		// 	echo '</td><td width="25%" align="right">';
		// 		if($lista_materialow_data != '') echo date('d-m-Y', $lista_materialow_data);
		// 	echo '</td></tr></table>';
			
		// 	echo '</td><td align="left" valign="middle">';
		// 	echo '<a href="index.php?page=lista_materialow_wyslij&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_email.'</a>';
		// 	// echo $nbsp;
		// 	if($lista_materialow_link != '') echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_lista_materialow/'.$lista_materialow_link.'" target="_blank">'.$image_pdf_icon2.'</a>';
		// 	}
	echo '</td></tr>';

	// strefa
	echo '<tr align="center" class="text"><td align="right">Strefa : </td><td align="left">';
		echo '<select name="strefa" class="pole_input">';
		if($strefa_klient == '') echo '<option></option>';
		if($strefa_klient == 1) echo '<option selected="selected">1</option>'; else echo '<option>1</option>';
		if($strefa_klient == 2) echo '<option selected="selected">2</option>'; else echo '<option>2</option>';
		if($strefa_klient == 3) echo '<option selected="selected">3</option>'; else echo '<option>3</option>';
		if($strefa_klient == 4) echo '<option selected="selected">4</option>'; else echo '<option>4</option>';
		if($strefa_klient == 'Inna') echo '<option selected="selected">Inna</option>'; else echo '<option>Inna</option>';
		echo '</select>';
	echo '</td></tr>';

	// termin realizacji zamwienia
	echo '<tr align="center"><td align="right" class="text">'.$kol_termin_realizacji.' : </td><td align="left">';         
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
	<td><input type="text" '.$szerokosc_pola_input.' maxlength="20" class="'.$styl.'" autocomplete="off"  name="termin_realizacji" id="f_date_c" value="'.$termin_realizacji.'"/></td>
	<td></td></tr></table>';
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
	
	
	//szukamy wszystkich terminw realizacji z aktywnych zamówienia
	require("php/termin_realizacji_tabela.php");

	
	if($pozycja_transport == 'tak') $temp = $ilosc_pozycji + 1; else $temp = $ilosc_pozycji;
	echo '<tr align="center" class="text"><td align="right" class="text">'.$kol_wycena.' : </td><td align="left">Wycena dodana, ilość dodanych pozycji : '.$temp.'</td><td></td></tr>';

	// kurs euro
	echo '<tr align="center"><td align="right" class="text">'.$kol_kurs_euro.' : </td><td align="left"><input autocomplete="off" type="text" '.$szerokosc_pola_input.' maxlength="5" class="'.$styl.'" name="kurs_euro"></td><td></td></tr>';

	// data dostawy
	echo '<tr align="center"><td align="right" class="text">'.$kol_data_dostawy.' : </td><td align="left">';         
	
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
	<td><input type="text" '.$szerokosc_pola_input.' maxlength="20" readonly="readonly" class="'.$styl.'" autocomplete="off" name="data_dostawy" id="f_date_d" value="'.$data_dostawy.'"/></td>
	<td></td></tr></table>';
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
	
	// lista zlecen transportowych
	$ilosc_zlecen_transportowych = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE status <> 'Dostarczone' ORDER BY id DESC;");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
		{
		$ilosc_zlecen_transportowych++;
		$nr_zlecenia_transportowego_baza[$ilosc_zlecen_transportowych] = $wynik91['nr_zlecenia_transportowego'];
		}
	
	echo '<INPUT type="hidden" name="poprzedni_nr_zlecenia_transportowego" value="'.$nr_zlecenia_transportowego.'">';

	echo '<tr align="center"><td align="right" class="text">'.$kol_nr_zlecenia_transportowego.' : </td><td align="left">';
	echo '<select name="nr_zlecenia_transportowego" class="'.$styl.'" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_zlecen_transportowych; $k++) 
	if($nr_zlecenia_transportowego == $nr_zlecenia_transportowego_baza[$k]) echo '<option selected="selected" value="'.$nr_zlecenia_transportowego_baza[$k].'">'.$nr_zlecenia_transportowego_baza[$k].'</option>';
	else echo '<option value="'.$nr_zlecenia_transportowego_baza[$k].'">'.$nr_zlecenia_transportowego_baza[$k].'</option>';
	echo '</select></td><td></td></tr>';

	// status zamowienia
	$ilosc_status = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status' AND opis <> 'Dostarczone' AND opis <> 'Odebrane' AND opis <> 'Anulowane' ORDER BY opis ASC;");
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
	else echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';


	// uwagi 1 zamówienia
	$ilosc_uwaga_1 = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';
	
	// uwagi 2 zamówienia
	$ilosc_uwaga_2 = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
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
	echo '<td align="left"><INPUT type="submit" name="zapisz" value="+">';
	echo '</td></tr>';

	echo '<tr align="center"><td align="right" class="text">'.$kol_uwagi_pdf.' : </td><td align="left">';
	echo '<textarea name="uwagi" cols="49" rows="4" class="pole_input_szare_ramka_uwagi">'.$uwagi.'</textarea></td><td></td></tr>';
	
	echo '<tr align="center"><td align="right" class="text">'.$kol_uwagi_email.' : </td><td align="left">';
	echo '<textarea name="uwagi_do_email" cols="49" rows="4" class="pole_input_szare_ramka_uwagi">'.$uwagi_do_email.'</textarea></td><td></td></tr>';

	//####################################################################################  guziki od wysylania potwierdzen  ####################################################################################################################################
	include("php/lista_emaili_potwierdzenie_zamowienia.php");
		
	echo '<tr><td colspan="3" align="center" class="text_duzy_niebieski">Wybierz, aby wysłać potwierdzenie</td></tr>';
		
	echo '<tr align="center" class="text"><td></td><td>';
		echo '<select name="klient_potwierdzenie" class="pole_input" style="width: 100%" >';
		for ($k=1; $k<=$ilosc_email; $k++) 
		if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		elseif($klient_email[$k] == $linia_rozdzielajaca) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
		else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		echo '</select>';
	echo '</td><td></td></tr>';
			
	echo '<tr class="text_duzy_niebieski"><td align="center" colspan="3">BEZ POTWIERDZENIA <input type="checkbox" name="bez_potwierdzenia" value="1" checked="checked"><br></td></tr>';		
	
	echo '<tr class="text"><td align="center" colspan="3">Korekta zamówienia? <input type="checkbox" name="korekta_zamowienia"><br></td></tr>';		

	echo '<tr class="text"><td align="center" colspan="3"><INPUT type="submit" name="zapisz" value="Zapisz"></td></tr>';
	echo '</table>';

echo '</td></tr></table>';
	echo '</FORM>';
}

?>