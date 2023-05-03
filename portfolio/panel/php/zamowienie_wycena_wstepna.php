<?php

if($zapisz == 'Zapisz')
	{
	$SUMA = change($SUMA);
	$SQL = [];
	//tresc zapytan
	$SQL[1] = "UPDATE zapamietaj_ostatnie SET wartosc = '".$termin_realizacji."' WHERE opis = 'wyceny_wstepne_termin_realizacji';";
	$SQL[2] = "UPDATE zapamietaj_ostatnie SET wartosc = '".$sposob_dostawy."' WHERE opis = 'wyceny_wstepne_sposob_dostawy';";
	$SQL[3] = "UPDATE wyceny SET termin_realizacji='".$termin_realizacji."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[4] = "UPDATE wyceny SET sposob_dostawy_wycena_wstepna='".$sposob_dostawy."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[5] = "UPDATE wyceny SET wycena_wstepna_wartosc_netto='".$SUMA."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[6] = "UPDATE wyceny SET status = 'Nie wysłana' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[7] = "UPDATE wyceny SET ww_podsumowanie_uwagi1 ='".$uwaga_1."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[8] = "UPDATE wyceny SET ww_podsumowanie_uwagi2 ='".$uwaga_2."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[9] = "UPDATE wyceny SET ww_podsumowanie_uwagi_reczne ='".$uwagi_reczne."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	//wykonanie zapytan
	for($s=1; $s<=9; $s++) mysqli_query($conn, $SQL[$s]);


	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		//tresc zapytan
		$SQL[1] = "UPDATE wyceny SET ww_pozycja_uwagi1='".$ww_pozycja_uwagi1[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[2] = "UPDATE wyceny SET ww_pozycja_uwagi2='".$ww_pozycja_uwagi2[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[3] = "UPDATE wyceny SET ww_pozycja_uwagi_reczne='".$ww_pozycja_uwagi_reczne[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[4] = "UPDATE wyceny SET dodatki_material='".$dodatki_material[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[5] = "UPDATE wyceny SET wycena_podstawowa_material='".$wycena_podstawowa_material[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[6] = "UPDATE wyceny SET wygiecie_innego_pvc_opis='".$input_wygiecie_innego_pvc[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[7] = "UPDATE wyceny SET wygiecie_innego_ze_stali_opis='".$input_wygiecie_innego_ze_stali[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[8] = "UPDATE wyceny SET kolor='".$nazwa_kolor[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[9] = "UPDATE wyceny SET rysunek='".$ww_rysunek[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[10] = "UPDATE wyceny SET wycena_wstepna_wartosc1='".$nazwa_wartosc1[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		$SQL[11] = "UPDATE wyceny SET wycena_wstepna_wartosc2='".$nazwa_wartosc2[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i."  AND nr_zamowienia = '".$wycena_wstepna_nr."';";
		//wykonanie zapytan
		for($s=1; $s<=11; $s++) mysqli_query($conn, $SQL[$s]);
		}

	echo '<div class="text_green" align="center">Dane wyceny zostały zapisane.</div>';
	
	echo '<br><div align="center">';
	echo '<a href="index.php?page=wyceny_wstepne&wg_czego=id&jak=DESC&wycena_wstepna_wysylka='.$wycena_wstepna_nr.'&klient='.$klient.'&wyslij=TAK"><INPUT type="button" name="wyslij" value="Wyślij"></a>';
	echo $tabulator;
	echo '<a href="index.php?page=wyceny_wstepne&wg_czego=id&jak=DESC"><INPUT type="button" name="powrot_rejestr" value="Powrót - Rejestr wycen"></a>';
	echo '</div>';

	}
elseif($etap == 3)
	{
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

	//szukam iniciałów usera
	$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$imie=$wynik2['imie'];
		$nazwisko=$wynik2['nazwisko'];
		}
	// pobieram kolejny numer wyceny wstepnej
	$pytanie333 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'wycena_wstepna_nr';");
	while($wynik333= mysqli_fetch_assoc($pytanie333))
		$kolejny_nr_wyceny=$wynik333['opis'];
	
	if(($imie[0] != '') && ($nazwisko[0] != '')) $wycena_wstepna_nr = $kolejny_nr_wyceny."/".$aktualny_rok."/".$imie[0].$nazwisko[0];
	else $wycena_wstepna_nr = $kolejny_nr_wyceny."/".$aktualny_rok;

	$nr_zamowienia = $wycena_wstepna_nr;

	$kolejny_nr_wyceny++;
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$kolejny_nr_wyceny." WHERE typ = 'wycena_wstepna_nr';");
	
	
	// zapis danych do bazy
	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		//zapisuje ostatnie ustawienie checkboxa od wzmocnienia okiennego dla tego klienta
		if($i == 1)	mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_checkbox_wygiecie_wzmocnienia = '".$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]."' WHERE id = ".$klient.";");

		//echo 'nr_zamowienia='.$nr_zamowienia.'<br>';
		include ("php/wycena_dodatkowe_zabezpieczenie.php");

		// zamiana ewentualnych przecinków na kropki
		include ("php/wycena_zamiana_przecinkow_na_kropki.php");

		$pytanie13 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_wycena = '".$email."' WHERE id = ".$klient.";");
		
		if($pozycja_transport == 'tak') $nowa_ilosc_pozycji = $ilosc_pozycji + 1; 
		else $nowa_ilosc_pozycji = $ilosc_pozycji;//jezeli jest pozycja transportowa to zwiekszamy ilosc pozycji

			$sql = "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `status` 
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
			
			,`zgrzanie_ilosc`, `zgrzanie_cena`, `zgrzanie_wartosc`
			,`wyfrezowanie_odwodnienia_ilosc`, `wyfrezowanie_odwodnienia_cena`, `wyfrezowanie_odwodnienia_wartosc`
			,`wstawienie_slupka_ilosc`, `wstawienie_slupka_cena`, `wstawienie_slupka_wartosc`
			,`listwa_przyszybowa_ilosc`, `listwa_przyszybowa_cena`, `listwa_przyszybowa_wartosc`
			,`okucie_ilosc`, `okucie_cena`, `okucie_wartosc`
			,`zaszklenie_ilosc`, `zaszklenie_cena`, `zaszklenie_wartosc`
			,`innej_uslugi_ilosc`, `innej_uslugi_cena`, `innej_uslugi_wartosc`
			
			,`oscieznica_ilosc`, `oscieznica_cena`, `oscieznica_wartosc`
			,`skrzydlo_ilosc`, `skrzydlo_cena`, `skrzydlo_wartosc`
			,`listwa_ilosc`, `listwa_cena`, `listwa_wartosc`
			,`slupek_ilosc`, `slupek_cena`, `slupek_wartosc`
			,`wzmocnienie_ramy_ilosc`, `wzmocnienie_ramy_cena`, `wzmocnienie_ramy_wartosc`
			,`wzmocnienie_skrzydla_ilosc`, `wzmocnienie_skrzydla_cena`, `wzmocnienie_skrzydla_wartosc`
			,`wzmocnienie_slupka_ilosc`, `wzmocnienie_slupka_cena`, `wzmocnienie_slupka_wartosc`
			,`wzmocnienie_luku_ilosc`, `wzmocnienie_luku_cena`, `wzmocnienie_luku_wartosc`
			,`okucia_ilosc`, `okucia_cena`, `okucia_wartosc`
			,`szyby_ilosc`, `szyby_cena`, `szyby_wartosc`
			,`inny_element_ilosc`, `inny_element_cena`, `inny_element_wartosc`
			
			,`okna`, `drzwi_wewnetrzne`, `drzwi_zewnetrzne` ,`bramy`, `parapety`, `rolety_zewnetrzne`
			,`rolety_wewnetrzne`, `moskitiery`, `montaz` ,`odpady_pvc`, `odpady_alu_stal`, `transport`, `inne`
			,`nazwa_produktu`, `cena_netto_za_sztuke`
			,`ilosc_sztuk`, `wartosc_netto`, `vat` ,`wartosc_brutto`, `uwagi`, `korekta_fv`
			,`wycena_wstepna_nr`, `data_wyceny`, `user_id`, `data_waznosci_wyceny`, `wycena_wstepna_email`, `data_dodania_pozycji`, `checkbox_wygiecie_wzmocnienia`, `checkbox_wygiecie_skrzydla`, `checkbox_wygiecie_listwy`, `wstawienie_slupka_ruchomego_ilosc`, `wstawienie_slupka_ruchomego_cena`, `wstawienie_slupka_ruchomego_wartosc`, `dociecie_kompletu_listew_przyszybowych_ilosc`, `dociecie_kompletu_listew_przyszybowych_cena`, `dociecie_kompletu_listew_przyszybowych_wartosc`, `stopien_trudnosci`)

			values ('$klient', '$klient_nazwa', '$nr_zamowienia', '$nowa_ilosc_pozycji', '$i', 'nie', '$status'
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
			, '$nazwa_odpady_z_pvc_wartosc[$i]', '$nazwa_odpady_ze_stali_wartosc[$i]', '$nazwa_transport_wartosc[$i]'
			, '$nazwa_inne_wartosc[$i]' 
			

			, '$nazwa_produktu[$i]'
			, '$nazwa_cena_netto_za_sztuke[$i]'
			, '$nazwa_ilosc_sztuk[$i]'
			, '$nazwa_wartosc_netto[$i]'
			, '$nazwa_vat[$i]'
			, '$nazwa_wartosc_brutto[$i]'
			, '$nazwa_uwagi[$i]'
			, 'NIE'
			, '$wycena_wstepna_nr'
			, '$time'
			, '$user_id'
			, '$data_waznosci'
			, '$email'
			, '$time'
			, '$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek[$i]'
			, '$nazwa_wygiecie_skrzydla_ptaszek[$i]'
			, '$nazwa_wygiecie_listwy_ptaszek[$i]'
			, '$nazwa_wstawienie_slupka_ruchomego_ilosc_m[$i]'
			, '$nazwa_wstawienie_slupka_ruchomego_cena[$i]'
			, '$nazwa_wstawienie_slupka_ruchomego_wartosc[$i]'
			, '$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m[$i]'
			, '$nazwa_dociecie_kompletu_listew_przyszybowych_cena[$i]'
			, '$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc[$i]'
			, '$nazwa_stopien_trudnosci[$i]');";
		
		mysqli_query($conn, $sql);
		$wycena_wstepna_id[$i] = mysqli_insert_id($conn);
		} // 	for($i = 1; $i <= $ilosc_pozycji; $i++)
	

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
		
		$pytanie1 = mysqli_query($conn, "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `zamowienie_id`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `status`, `transport`, `nazwa_produktu`, `wartosc_netto`, `vat` ,`wartosc_brutto`, `nr_faktury`, `data_faktury`, `data_faktury_time`, `data_faktury_miesiac`, `data_faktury_rok`, `korekta_fv`, `wycena_wstepna_nr`, `data_wyceny`, `user_id`,`data_waznosci_wyceny`, `wycena_wstepna_email`)
		values ('$klient', '$klient_nazwa', '$zamowienie_id', '$nr_zamowienia', '$nowa_ilosc_pozycji', '$nowa_ilosc_pozycji', 'tak', '$status', '$nazwa_pozycja_transport_wartosc', 'Transport', '$nazwa_wartosc_netto_pozycja_transport', '$nazwa_vat_pozycja_transport', '$nazwa_wartosc_brutto_pozycja_transport', '$nazwa_nr_faktury[$nowa_ilosc_pozycji]', '$nazwa_data_faktury[$nowa_ilosc_pozycji]', '$data_faktury_time[$nowa_ilosc_pozycji]', '$data_faktury_miesiac', '$data_faktury_rok', 'NIE', '$wycena_wstepna_nr', '$time', '$user_id', '$data_waznosci', '$email');");
		}
} // do if etap == 3


if($zapisz != 'Zapisz')
	{
	// zapisuj wybrany rysunek
	if($rysunek_dla_pozycji != '') 
		if($wszystkie_pozycje == 'on') 
			{
			$ilosc = 0;
			$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'NIE' ORDER BY pozycja ASC;");
			while($wynik= mysqli_fetch_assoc($pytanie))
				{
				$ilosc++;
				$pytanie122=mysqli_query($conn, "UPDATE wyceny SET rysunek='".$rysunek[$rysunek_dla_pozycji]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = ".$ilosc.";");
				}
			}
		else $pytanie122=mysqli_query($conn, "UPDATE wyceny SET rysunek='".$rysunek[$rysunek_dla_pozycji]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = ".$rysunek_dla_pozycji.";");


	// ######################################################## szukam wszystkich rysunkow w katalogu ########################################################
	$ilosc_rysunkow = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY kolejnosc ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_rysunkow++;
		$rysunek_id[$ilosc_rysunkow]=$wynik['id'];
		$kolejnosc[$ilosc_rysunkow]=$wynik['kolejnosc'];
		$rysunek_opis[$ilosc_rysunkow]=$wynik['opis'];
		$link_rysunek[$rysunek_id[$ilosc_rysunkow]]=$wynik['link'];
		}
	//############################################################### koniec szukam wszystkich rysunkow w katalogu  ################################################################
	
	$SUMA = change($SUMA);
	$SQL = [];
	//tresc zapytan
	$SQL[1] = "UPDATE wyceny SET termin_realizacji='".$termin_realizacji."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[2] = "UPDATE wyceny SET sposob_dostawy_wycena_wstepna='".$sposob_dostawy."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[3] = "UPDATE wyceny SET wycena_wstepna_wartosc_netto='".$SUMA."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[4] = "UPDATE wyceny SET status = 'Nie wysłana' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[5] = "UPDATE wyceny SET ww_podsumowanie_uwagi1 ='".$uwaga_1."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[6] = "UPDATE wyceny SET ww_podsumowanie_uwagi2 ='".$uwaga_2."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";
	$SQL[7] = "UPDATE wyceny SET ww_podsumowanie_uwagi_reczne ='".$uwagi_reczne."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND nr_zamowienia = '".$wycena_wstepna_nr."';";

	//wykonanie zapytan
	for($s=1; $s<=7; $s++) mysqli_query($conn, $SQL[$s]);


	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		if(isset($ww_pozycja_uwagi1[$i])) mysqli_query($conn, "UPDATE wyceny SET ww_pozycja_uwagi1='".$ww_pozycja_uwagi1[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($ww_pozycja_uwagi2[$i])) mysqli_query($conn, "UPDATE wyceny SET ww_pozycja_uwagi2='".$ww_pozycja_uwagi2[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($ww_pozycja_uwagi_reczne[$i])) mysqli_query($conn, "UPDATE wyceny SET ww_pozycja_uwagi_reczne='".$ww_pozycja_uwagi_reczne[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($dodatki_material[$i])) mysqli_query($conn, "UPDATE wyceny SET dodatki_material='".$dodatki_material[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		
		if(isset($wycena_podstawowa_material[$i])) mysqli_query($conn, "UPDATE wyceny SET wycena_podstawowa_material='".$wycena_podstawowa_material[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($input_wygiecie_innego_pvc[$i])) mysqli_query($conn, "UPDATE wyceny SET wygiecie_innego_pvc_opis='".$input_wygiecie_innego_pvc[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($input_wygiecie_innego_ze_stali[$i])) mysqli_query($conn, "UPDATE wyceny SET wygiecie_innego_ze_stali_opis='".$input_wygiecie_innego_ze_stali[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($ww_rysunek[$i])) mysqli_query($conn, "UPDATE wyceny SET rysunek='".$ww_rysunek[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($nazwa_kolor[$i])) mysqli_query($conn, "UPDATE wyceny SET kolor='".$nazwa_kolor[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($nazwa_wartosc1[$i])) mysqli_query($conn, "UPDATE wyceny SET wycena_wstepna_wartosc1='".$nazwa_wartosc1[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		if(isset($nazwa_wartosc2[$i])) mysqli_query($conn, "UPDATE wyceny SET wycena_wstepna_wartosc2='".$nazwa_wartosc2[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient." AND pozycja = ".$i." AND nr_zamowienia = '".$wycena_wstepna_nr."';");
		}

	$ilosc_pozycji = 0;
	include ("php/wyceny_deklaracja_pustych_tablic.php");
	$produkt = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'NIE' AND nr_zamowienia = '".$wycena_wstepna_nr."'  ORDER BY pozycja ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji++;
		$wartosc_dodatki[$ilosc_pozycji] = 0;
		$klient = $wynik['klient_id'];
		$data_wyceny = $wynik['data_wyceny'];
		$wycena_wstepna_nr = $wynik['wycena_wstepna_nr'];
		$wartosc_netto = $wynik['wartosc_netto'];
		$link_wycena_pdf = $wynik['link_wycena_pdf'];
		$klient_nazwa = $wynik['klient_nazwa'];
		$user_id_wycena = $wynik['user_id'];
		$email = $wynik['wycena_wstepna_email'];
		$data_waznosci = $wynik['data_waznosci_wyceny'];
		$termin_realizacji = $wynik['termin_realizacji'];
		$sposob_dostawy = $wynik['sposob_dostawy_wycena_wstepna'];
		
		$wycena_wstepna_podsumowanie_uwagi1 = $wynik['ww_podsumowanie_uwagi1'];
		$wycena_wstepna_podsumowanie_uwagi2 = $wynik['ww_podsumowanie_uwagi2'];
		$wycena_wstepna_podsumowanie_uwagi_reczne = $wynik['ww_podsumowanie_uwagi_reczne'];
		$wycena_wstepna_pozycja_uwagi1[$ilosc_pozycji] = $wynik['ww_pozycja_uwagi1'];
		$wycena_wstepna_pozycja_uwagi2[$ilosc_pozycji] = $wynik['ww_pozycja_uwagi2'];
		$wycena_wstepna_pozycja_uwagi_reczne[$ilosc_pozycji] = $wynik['ww_pozycja_uwagi_reczne'];
		$nr_zamowienia = $wynik['nr_zamowienia'];
		$zamowienie_id = $wynik['zamowienie_id'];
		$ilosc_sztuk[$ilosc_pozycji] = $wynik['ilosc_sztuk'];
		$produkt[$ilosc_pozycji] = $wynik['nazwa_produktu'];
		if(isset($wynik['wycena_wstepna_wartosc1'])) $wartosc1[$ilosc_pozycji] = $wynik['wycena_wstepna_wartosc1'];
		if(isset($wynik['wycena_wstepna_wartosc2'])) $wartosc2[$ilosc_pozycji] = $wynik['wycena_wstepna_wartosc2'];
		$kolor_baza[$ilosc_pozycji] = $wynik['kolor'];
		if(isset($wynik['rysunek'])) $rysunek[$ilosc_pozycji] = $wynik['rysunek'];
		
		$wygiecie_innego_pvc_opis[$ilosc_pozycji] = $wynik['wygiecie_innego_pvc_opis'];
		$wygiecie_innego_ze_stali_opis[$ilosc_pozycji] = $wynik['wygiecie_innego_ze_stali_opis'];
		
		$wygiecie_innego_ze_stali_wartosc[$ilosc_pozycji] = $wynik['wygiecie_innego_wartosc'];
		$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji] = $wynik['wygiecie_ramy_pvc_wartosc'];
		$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji] = $wynik['wygiecie_skrzydla_pvc_wartosc'];
		$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji] = $wynik['wygiecie_listwy_pvc_wartosc'];
		$wygiecie_innego_pvc_wartosc[$ilosc_pozycji] = $wynik['wygiecie_innego_pvc_wartosc'];
		$zgrzanie_wartosc[$ilosc_pozycji] = $wynik['zgrzanie_wartosc'];
		$oscieznica_wartosc[$ilosc_pozycji] = $wynik['oscieznica_wartosc'];
		$skrzydlo_wartosc[$ilosc_pozycji] = $wynik['skrzydlo_wartosc'];
		$listwa_wartosc[$ilosc_pozycji] = $wynik['listwa_wartosc'];
		$wzmocnienie_ramy_wartosc[$ilosc_pozycji] = $wynik['wzmocnienie_ramy_wartosc'];
		$wzmocnienie_skrzydla_wartosc[$ilosc_pozycji] = $wynik['wzmocnienie_skrzydla_wartosc'];
		$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji] = $wynik['wygiecie_wzmocnienia_okiennego_wartosc'];
	
		$wstawienie_slupka_wartosc[$ilosc_pozycji] = $wynik['wstawienie_slupka_wartosc'];
		$listwa_przyszybowa_wartosc[$ilosc_pozycji] = $wynik['listwa_przyszybowa_wartosc'];
		$wstawienie_slupka_ruchomego_wartosc[$ilosc_pozycji]  =  $wynik['wstawienie_slupka_ruchomego_wartosc'];
		$dociecie_kompletu_listew_przyszybowych_wartosc[$ilosc_pozycji]  =  $wynik['dociecie_kompletu_listew_przyszybowych_wartosc'];


		$okucie_wartosc[$ilosc_pozycji] = $wynik['okucie_wartosc'];
		$zaszklenie_wartosc[$ilosc_pozycji] = $wynik['zaszklenie_wartosc'];
		$innej_uslugi_wartosc[$ilosc_pozycji] = $wynik['innej_uslugi_wartosc'];
		$wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji] = $wynik['wyfrezowanie_odwodnienia_wartosc'];
		$slupek_wartosc[$ilosc_pozycji] = $wynik['slupek_wartosc'];
		$wzmocnienie_slupka_wartosc[$ilosc_pozycji] = $wynik['wzmocnienie_slupka_wartosc'];
		$wzmocnienie_luku_wartosc[$ilosc_pozycji] = $wynik['wzmocnienie_luku_wartosc'];
		$okucia_wartosc[$ilosc_pozycji] = $wynik['okucia_wartosc'];
		$szyby_wartosc[$ilosc_pozycji] = $wynik['szyby_wartosc'];
		$inny_element_wartosc[$ilosc_pozycji] = $wynik['inny_element_wartosc'];	
			
		$wycena_podstawowa_material_baza[$ilosc_pozycji] = $wynik['wycena_podstawowa_material'];		
		$dodatki_material_baza[$ilosc_pozycji] = $wynik['dodatki_material'];		
		
		// wartosci dodawane do dodatkow:
		$wygiecie_ramy_alu_wartosc[$ilosc_pozycji] = $wynik['wygiecie_ramy_alu_wartosc'];
		$wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji] = $wynik['wygiecie_skrzydla_alu_wartosc'];
		$wygiecie_listwy_alu_wartosc[$ilosc_pozycji] = $wynik['wygiecie_listwy_alu_wartosc'];
		$wygiecie_innego_alu_wartosc[$ilosc_pozycji] = $wynik['wygiecie_innego_alu_wartosc'];
		$okna[$ilosc_pozycji] = $wynik['okna'];
		$drzwi_wewnetrzne[$ilosc_pozycji] = $wynik['drzwi_wewnetrzne'];
		$drzwi_zewnetrzne[$ilosc_pozycji] = $wynik['drzwi_zewnetrzne'];
		$bramy[$ilosc_pozycji] = $wynik['bramy'];
		$parapety[$ilosc_pozycji] = $wynik['parapety'];
		$rolety_zewnetrzne[$ilosc_pozycji] = $wynik['rolety_zewnetrzne'];
		$rolety_wewnetrzne[$ilosc_pozycji] = $wynik['rolety_wewnetrzne'];
		$moskitiery[$ilosc_pozycji] = $wynik['moskitiery'];
		$montaz[$ilosc_pozycji] = $wynik['montaz'];
		$odpady_pvc[$ilosc_pozycji] = $wynik['odpady_pvc'];
		$odpady_alu_stal[$ilosc_pozycji] = $wynik['odpady_alu_stal'];
		$inne[$ilosc_pozycji] = $wynik['inne'];
		}
	
	$transport2 = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'TAK' AND nr_zamowienia = '".$wycena_wstepna_nr."';");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		$transport2=$wynik2['transport'];
	
	echo '<div class="text_duzy" align="center">Kontynuuj dodawanie wyceny wstępnej</div>';
	
	echo '<table width="1000px" align="center" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
	echo '<FORM action="index.php?page=zamowienie_wycena_wstepna" method="post">';
	//echo '<INPUT type="hidden" name="etap" value="'.$etap.'">';
	echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
	echo '<INPUT type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
	echo '<INPUT type="hidden" name="ilosc_pozycji" value="'.$ilosc_pozycji.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		
		echo '<table width="100%" align="center" border="0" bordercolor="red" cellpadding="5" cellspacing="5">';
		//komrka z danymi o wycenie
		$pytanie2 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$klient_ulica=$wynik2['ulica'];
			$klient_miasto=$wynik2['miasto'];
			$klient_kod_pocztowy=$wynik2['kod_pocztowy'];
			$klient_sposob_platnosci=$wynik2['sposob_platnosci'];
			}
		
		echo '<tr><td width="60%" align="left" valign="top">';
			echo '<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="text_duzy">';
			echo '<tr><td width="100%" align="left" valign="top">Klient : '.$klient_nazwa.'</td></tr>';
			echo '<tr><td width="100%" align="left" valign="top">email : '.$email.'</td></tr>';
			$klient_ulica = popraw_ulice($klient_ulica);
			echo '<tr><td width="100%" align="left" valign="top">Adres :  ul.'.$klient_ulica.', '.$klient_kod_pocztowy.' '.$klient_miasto.'</td></tr>';
			echo '<tr><td width="100%" align="left" valign="top">Sposób płatności : '.$klient_sposob_platnosci.'</td></tr>';
			echo '<tr><td width="100%" align="left" valign="top">&nbsp;</td></tr>';
			echo '<tr><td width="100%" align="left" valign="top">Nr wyceny : '.$wycena_wstepna_nr.'</td></tr>';
			echo '<tr><td width="100%" align="left" valign="top">Data sporządzenia wyceny : '.$dzis.'</td></tr>';
			echo '<tr><td width="100%" align="left" valign="top">Data ważności : '.$data_waznosci.'</td></tr>';
			echo '</table>';
		echo '</td>';
		
		// komrka z logo i danymi Arcus   
		echo '<td width="40%" align="right">';
			echo '<table align="right" border="0" cellpadding="0" cellspacing="0" class="text_mini">';
			echo '<tr><td width="100%" align="center" valign="top">'.$image_logo_mini.'</td></tr>';
			echo '<tr><td width="100%" align="center" valign="top">Podwiesk 65D, 86-200 Chełmno</td></tr>';
			echo '<tr><td width="100%" align="center" valign="top">Tel. 52/522-22-02</td></tr>';
			echo '<tr><td width="100%" align="center" valign="top">e-mail: biuro@arcus-luki.pl</td></tr>';
			echo '<tr><td width="100%" align="center" valign="top">www.arcus-luki.pl</td></tr>';
			echo '</table>';
		echo '</td>';
		echo '</tr></table>';
	
		$ilosc_kolorow = 0;
		$kolor_profili = [];
		$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'kolor_profili' ORDER BY opis ASC;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc_kolorow++;
			$kolor_profili[$ilosc_kolorow]=$wynik['opis'];
			}
	
	$cellpadding = 1;
	$cellspacing = 1;
	$styl_input2 = 'pole_select_szare_z_ramka';
	
	$SUMA_WYCENA_PODSTAWOWA = 0;
	$SUMA_DODATKI = 0;
	$UWAGI_PODSUMOWANIE = '';
	for($x=1; $x<=$ilosc_pozycji; $x++)
		{
		$wycena_podstawowa[$x] = 0;
		$opisy_wycena_podstawowa[$x] = '';
		$wartosc_dodatki[$x] = 0;
		$opisy_dodatki[$x] = '';
		echo '<table width="100%" align="center" class="tabela" cellpadding="0" cellspacing="1">';
		echo '<tr class="text2" bgcolor="'.$kolor_bialy.'"><td width="10%" align="center" bgcolor="'.$kolor_szary.'"><b>Pozycja '.$x.'/'.$ilosc_pozycji.'</b></td>';
		echo '<td width="25%" align="center">'.$produkt[$x].'</td>';
		
		$nazwa_wartosc1 = 'nazwa_wartosc1['.$x.']';	
		$nazwa_kolor = 'nazwa_kolor['.$x.']';	
		echo '<td width="10%" align="left"><input autocomplete="off" type="text" size="13" maxlength="20" class="'.$styl_input2.'" name="'.$nazwa_wartosc1.'" value="'.$wartosc1[$x].'"></td>';
		echo '<td width="20%" align="left">';
			echo '<select name="'.$nazwa_kolor.'" class="pole_select_szare_z_ramka_kolor_wycena_wstepna" style="width: 100%">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_kolorow; $k++) if($kolor_baza[$x] == $kolor_profili[$k]) echo '<option value="'.$kolor_profili[$k].'" selected="selected">'.$kolor_profili[$k].'</option>';
			else echo '<option value="'.$kolor_profili[$k].'">'.$kolor_profili[$k].'</option>';
			echo '</select>';
		echo '</td>';
		$nazwa_wartosc2 = 'nazwa_wartosc2['.$x.']';	
		echo '<td width="25%" align="left"><input autocomplete="off" type="text" size="46" maxlength="60" class="'.$styl_input2.'" name="'.$nazwa_wartosc2.'" value="'.$wartosc2[$x].'"></td>';
		echo '<td width="10%" align="center">'.$ilosc_sztuk[$x].' szt.</td></tr>';
		
		echo '<tr class="text2" bgcolor="'.$kolor_bialy.'"><td width="100%" colspan="6" align="center" ><br>';

			//##################################################  wycena podstawowa  ##################################################
			if($wygiecie_ramy_pvc_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $wygiecie_ramy_pvc_wartosc[$x];
				$opisy_wycena_podstawowa[$x] .= '<br>- Wygięcie ościeżnicy';
				}
			if($wygiecie_skrzydla_pvc_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $wygiecie_skrzydla_pvc_wartosc[$x];
				$opisy_wycena_podstawowa[$x] .= '<br>- Wygięcie skrzydła';
				}
			if($wygiecie_listwy_pvc_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $wygiecie_listwy_pvc_wartosc[$x];
				$opisy_wycena_podstawowa[$x] .= '<br>- Wygięcie listwy';
				}
			if($zgrzanie_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $zgrzanie_wartosc[$x];
				$opisy_wycena_podstawowa[$x] .= '<br>- Zgrzanie';
				}
			//materiał
			if($oscieznica_wartosc[$x] != 0) 
				$wycena_podstawowa[$x] += $oscieznica_wartosc[$x];
			if($skrzydlo_wartosc[$x] != 0) 
				$wycena_podstawowa[$x] += $skrzydlo_wartosc[$x];
			if($listwa_wartosc[$x] != 0) 
				$wycena_podstawowa[$x] += $listwa_wartosc[$x];
			if($wzmocnienie_ramy_wartosc[$x] != 0) 
				$wycena_podstawowa[$x] += $wzmocnienie_ramy_wartosc[$x];
			if($wzmocnienie_skrzydla_wartosc[$x] != 0) 
				$wycena_podstawowa[$x] += $wzmocnienie_skrzydla_wartosc[$x];

			$SUMA_WYCENA_PODSTAWOWA += $wycena_podstawowa[$x];
			$wycena_podstawowa[$x] = number_format($wycena_podstawowa[$x], 2,'.',' ');

			echo '<table width="100%" align="center" class="text2" border="0">';
			echo '<tr height="250px" valign="top"><td align="center" width="30%"><b>Wycena podstawowa : </b>'.$wycena_podstawowa[$x].$waluta;
			echo '<hr width="100%">';
			
				//opisy 
				echo '<table width="100%" align="left" class="text2" border="0"><tr><td><b>Uwzględniono :</b></td></tr>';
				echo '<tr align="left" class="text2"><td>';
				echo $opisy_wycena_podstawowa[$x];
					
					$wycena_podstawowa_material = 'wycena_podstawowa_material['.$x.']';	
					echo '<br><select name="'.$wycena_podstawowa_material.'" class="'.$styl_input2.'" style="width: 80%" >';
					echo '<option></option>';
					if($wycena_podstawowa_material_baza[$x] == 'Materiał Arcus') echo '<option value="Materiał Arcus" selected="selected">Materiał Arcus</option>';
					else echo '<option value="Materiał Arcus">Materiał Arcus</option>';
					
					if($wycena_podstawowa_material_baza[$x] == 'Materiał klienta') echo '<option value="Materiał klienta" selected="selected">Materiał klienta</option>';
					else echo '<option value="Materiał klienta">Materiał klienta</option>';
					echo '</select>';
				
				echo '</td></tr></table>';
			
			echo '</td>';
			echo '<td width="5%"></td>';

			//##################################################  dodatki  ##################################################
			$input_wygiecie_innego_pvc = 0;
			$input_wygiecie_innego_ze_stali = 0;
			if($wygiecie_innego_pvc_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $wygiecie_innego_pvc_wartosc[$x];
				//$opisy_dodatki[$x] .= '<br>- Wygięcie innego elementu z pvc';
				$input_wygiecie_innego_pvc = 1;
				}
			if($wygiecie_innego_ze_stali_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $wygiecie_innego_ze_stali_wartosc[$x];
				//$opisy_dodatki[$x] .= '<br>- Wygięcie innego elementu ze stali';
				$input_wygiecie_innego_ze_stali = 1;
				}
			if($wygiecie_wzmocnienia_okiennego_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $wygiecie_wzmocnienia_okiennego_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Wygięcie wzmocnienia okiennego';
				}
			if($wyfrezowanie_odwodnienia_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $wyfrezowanie_odwodnienia_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Wyfrezowanie odwodnienia';
				}
			if($wstawienie_slupka_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $wstawienie_slupka_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Wstawienie słupka stałego';
				}
			if($wstawienie_slupka_ruchomego_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $wstawienie_slupka_ruchomego_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Wstawienie słupka ruchomego';
				}
			if($listwa_przyszybowa_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $listwa_przyszybowa_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Docięcie listwy przyszybowej tylko łukowej';
				}
			if($dociecie_kompletu_listew_przyszybowych_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $dociecie_kompletu_listew_przyszybowych_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Docięcie kompletu listew przyszybowych';
				}
			if($okucie_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $okucie_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Okucie';
				}
			if($zaszklenie_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $zaszklenie_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Zaszklenie';
				}
			if($innej_uslugi_wartosc[$x] != 0) 
				{
				$wartosc_dodatki[$x] += $innej_uslugi_wartosc[$x];
				$opisy_dodatki[$x] .= '<br>- Wykonanie innej usługi';
				}
	
			//Materiał
			if($slupek_wartosc[$x] != 0) 
				$wartosc_dodatki[$x] += $slupek_wartosc[$x];
			if($wzmocnienie_slupka_wartosc[$x] != 0) 
				$wartosc_dodatki[$x] += $wzmocnienie_slupka_wartosc[$x];
			if($wzmocnienie_luku_wartosc[$x] != 0) 
				$wartosc_dodatki[$x] += $wzmocnienie_luku_wartosc[$x];
			if($okucia_wartosc[$x] != 0) 
				$wartosc_dodatki[$x] += $okucia_wartosc[$x];
			if($szyby_wartosc[$x] != 0) 
				$wartosc_dodatki[$x] += $szyby_wartosc[$x];
			if($inny_element_wartosc[$x] != 0) 
				$wartosc_dodatki[$x] += $inny_element_wartosc[$x];
			
			// dodajemy ca reszt kolumn z wyceny do dodatkw: 16 kolumn BEZ TRANSPORTU
			$wygiecie_ramy_alu_wartosc[$x] = number_format($wygiecie_ramy_alu_wartosc[$x], 2,'.','');
			$wygiecie_skrzydla_alu_wartosc[$x] = number_format($wygiecie_skrzydla_alu_wartosc[$x], 2,'.','');
			$wygiecie_listwy_alu_wartosc[$x] = number_format($wygiecie_listwy_alu_wartosc[$x], 2,'.','');
			$wygiecie_innego_alu_wartosc[$x] = number_format($wygiecie_innego_alu_wartosc[$x], 2,'.','');
			$okna[$x] = number_format($okna[$x], 2,'.','');
			$drzwi_wewnetrzne[$x] = number_format($drzwi_wewnetrzne[$x], 2,'.','');
			$drzwi_zewnetrzne[$x] = number_format($drzwi_zewnetrzne[$x], 2,'.','');
			$bramy[$x] = number_format($bramy[$x], 2,'.','');
			$parapety[$x] = number_format($parapety[$x], 2,'.','');
			$rolety_zewnetrzne[$x] = number_format($rolety_zewnetrzne[$x], 2,'.','');
			$rolety_wewnetrzne[$x] = number_format($rolety_wewnetrzne[$x], 2,'.','');
			$moskitiery[$x] = number_format($moskitiery[$x], 2,'.','');
			$montaz[$x] = number_format($montaz[$x], 2,'.','');
			$odpady_pvc[$x] = number_format($odpady_pvc[$x], 2,'.','');
			$odpady_alu_stal[$x] = number_format($odpady_alu_stal[$x], 2,'.','');
			$inne[$x] = number_format($inne[$x], 2,'.','');
			
			$wartosc_dodatki[$x] += $wygiecie_ramy_alu_wartosc[$x];
			$wartosc_dodatki[$x] += $wygiecie_skrzydla_alu_wartosc[$x];
			$wartosc_dodatki[$x] += $wygiecie_listwy_alu_wartosc[$x];
			$wartosc_dodatki[$x] += $wygiecie_innego_alu_wartosc[$x];
			$wartosc_dodatki[$x] += $okna[$x];
			$wartosc_dodatki[$x] += $drzwi_wewnetrzne[$x];
			$wartosc_dodatki[$x] += $drzwi_zewnetrzne[$x];
			$wartosc_dodatki[$x] += $bramy[$x];
			$wartosc_dodatki[$x] += $parapety[$x];
			$wartosc_dodatki[$x] += $rolety_zewnetrzne[$x];
			$wartosc_dodatki[$x] += $rolety_wewnetrzne[$x];
			$wartosc_dodatki[$x] += $moskitiery[$x];
			$wartosc_dodatki[$x] += $montaz[$x];
			$wartosc_dodatki[$x] += $odpady_pvc[$x];
			$wartosc_dodatki[$x] += $odpady_alu_stal[$x];
			$wartosc_dodatki[$x] += $inne[$x];
	
			$SUMA_DODATKI += $wartosc_dodatki[$x];
			$wartosc_dodatki[$x] = number_format($wartosc_dodatki[$x], 2,'.',' ');


			echo '<td align="center" width="30%"><b>Dodatki : </b>'.$wartosc_dodatki[$x].$waluta;
			echo '<hr width="100%">';
	
				//opisy 
				echo '<table width="100%" align="left" class="text2" border="0"><tr><td><b>Uwzględniono :</b></td></tr>';
				echo '<tr align="left" class="text2"><td>';
				$nazwa_input_wygiecie_innego_pvc = 'input_wygiecie_innego_pvc['.$x.']';	
				$nazwa_input_wygiecie_innego_ze_stali = 'input_wygiecie_innego_ze_stali['.$x.']';
				
				$wartosc_wygiecie_innego_pvc_opis = 'Wygięcie innego elementu z pvc';
				$wartosc_wygiecie_innego_ze_stali_opis = 'Wygięcie innego elementu ze stali';
				if($wygiecie_innego_pvc_opis[$x] != '') $wartosc_wygiecie_innego_pvc_opis = $wygiecie_innego_pvc_opis[$x];
				if($wygiecie_innego_ze_stali_opis[$x] != '') $wartosc_wygiecie_innego_ze_stali_opis = $wygiecie_innego_ze_stali_opis[$x];
				
				if($input_wygiecie_innego_pvc == 1) echo '<br>- <input autocomplete="off" type="text" size="42" maxlength="80" class="pole_input_biale" name="'.$nazwa_input_wygiecie_innego_pvc.'" value="'.$wartosc_wygiecie_innego_pvc_opis.'">';
				if($input_wygiecie_innego_ze_stali == 1) echo '<br>- <input autocomplete="off" type="text" size="42" maxlength="80" class="pole_input_biale" name="'.$nazwa_input_wygiecie_innego_ze_stali.'" value="'.$wartosc_wygiecie_innego_ze_stali_opis.'">';

				echo $opisy_dodatki[$x];
				
				//select z Materiałem
				$dodatki_material = 'dodatki_material['.$x.']';	
				echo '<br><select name="'.$dodatki_material.'" class="'.$styl_input2.'" style="width: 80%" >';
				echo '<option></option>';
					if($dodatki_material_baza[$x] == 'Materiał Arcus') echo '<option value="Materiał Arcus" selected="selected">Materiał Arcus</option>';
					else echo '<option value="Materiał Arcus">Materiał Arcus</option>';
					
					if($dodatki_material_baza[$x] == 'Materiał klienta') echo '<option value="Materiał klienta" selected="selected">Materiał klienta</option>';
					else echo '<option value="Materiał klienta">Materiał klienta</option>';
				echo '</select>';
				
				echo '</td></tr></table>';
			
			echo '</td>';
			echo '<td width="5%"></td>';
	
			//  ######################################   rysunek pogldowy ########################################################################### 
			echo '<td align="center" width="30%"><b>Rysunek poglądowy</b>';
			echo '<hr width="100%">';

				$ww_rysunek = 'ww_rysunek['.$x.']';	
				echo '<select name="'.$ww_rysunek.'" class="'.$styl_input2.'" style="width: 80%" onchange="submit();">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_rysunkow; $k++) if($rysunek[$x] == $rysunek_id[$k]) echo '<option value="'.$rysunek_id[$k].'" selected="selected">'.$rysunek_opis[$k].'</option>';
				else echo '<option value="'.$rysunek_id[$k].'">'.$rysunek_opis[$k].'</option>';
				echo '</select>';
				
				if($rysunek[$x] != '') echo '<br><br><center><a href="index.php?page=wycena_wstepna_wybierz_rysunek&skad=zamowienie_wycena_wstepna&wycena_wstepna_nr='.$wycena_wstepna_nr.'&rysunek_dla_pozycji='.$x.'&jak=ASC&wg_czego=kolejnosc"><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$link_rysunek[$rysunek[$x]].'" width="270px"></a></center>';
				else echo '<a href="index.php?page=wycena_wstepna_wybierz_rysunek&skad=zamowienie_wycena_wstepna&wycena_wstepna_nr='.$wycena_wstepna_nr.'&rysunek_dla_pozycji='.$x.'&jak=ASC&wg_czego=kolejnosc">'.$image_rysunek.'</a>';
				
			echo '</td></tr></table>';
			//  ######################################   KONIEC rysunek poglądowy ########################################################################### 


			//uwagi pozycja
			echo '<table width="100%" align="center" class="text2" border="0">';
			echo '<tr><td><hr width="100%"></td></tr>';
			echo '<tr><td align="center" width="100%">';
				//TABELA UWAGI dla pozycji
				echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
				echo '<tr><td align="center" width="90px"><b>Uwagi : </b></td>';
				echo '<td width="90%">';
					echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
					echo '<tr><td width="70%">';
						// uwagi 1  pozycja 
						$ilosc_uwaga_1 = 0;
						$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
						while($wynik91= mysqli_fetch_assoc($pytanie91))
							{
							$ilosc_uwaga_1++;
							$uwaga_1_id[$ilosc_uwaga_1] = $wynik91['id'];
							$uwaga_1_opis[$ilosc_uwaga_1] = $wynik91['opis'];
							}
						$ww_pozycja_uwagi1 = 'ww_pozycja_uwagi1['.$x.']';	
						echo '<select name="'.$ww_pozycja_uwagi1.'" class="'.$styl_input2.'" style="width: 80%" >';
						echo '<option></option>';
						for ($k=1; $k<=$ilosc_uwaga_1; $k++) if($wycena_wstepna_pozycja_uwagi1[$x] == $uwaga_1_opis[$k]) echo '<option value="'.$uwaga_1_opis[$k].'" selected="selected">'.$uwaga_1_opis[$k].'</option>';
						else echo '<option value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
						echo '</select>';
						
					echo '</td></tr><tr><td>';
						// uwagi 2 pozycja 
						$ilosc_uwaga_2 = 0;
						$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
						while($wynik91= mysqli_fetch_assoc($pytanie91))
							{
							$ilosc_uwaga_2++;
							$uwaga_2_id[$ilosc_uwaga_2] = $wynik91['id'];
							$uwaga_2_opis[$ilosc_uwaga_2] = $wynik91['opis'];
							}
						$ww_pozycja_uwagi2 = 'ww_pozycja_uwagi2['.$x.']';	
						echo '<select name="'.$ww_pozycja_uwagi2.'" class="'.$styl_input2.'" style="width: 80%">';
						echo '<option></option>';
						for ($k=1; $k<=$ilosc_uwaga_2; $k++) if($wycena_wstepna_pozycja_uwagi2[$x] == $uwaga_2_opis[$k]) echo '<option value="'.$uwaga_2_opis[$k].'" selected="selected">'.$uwaga_2_opis[$k].'</option>';
						else echo '<option value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
						echo '</select>';
					echo '</td></tr><tr><td>';
						//uwagi rczne
						$ww_pozycja_uwagi_reczne = 'ww_pozycja_uwagi_reczne['.$x.']';	
						echo '<textarea name="'.$ww_pozycja_uwagi_reczne.'" cols="103" rows="2" class="'.$styl_input2.'">'.$wycena_wstepna_pozycja_uwagi_reczne[$x].'</textarea>';
					echo '</td></tr>';
					echo '</table>';
				echo '</td></tr>';
				echo '</table>';
				// KONIEC tabeli z uwagami dla pozycji
				
			echo '</td></tr></table>';
		echo '</td></tr>';
		echo '</table>';
		} // do for ilosc pozycji
				
		
		echo '<table name="podsumowanie1" width="100%" align="center" class="tabela" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
		echo '<tr class="text"><td width="100%" align="center" bgcolor="'.$kolor_szary.'">Podsumowanie</td></tr>';
		echo '<tr class="text2" bgcolor="'.$kolor_bialy.'" valign="top"><td width="100%" align="center">';
			echo '<table name="podsumowanie3" border="0" width="100%" align="center" class="text2" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'"><tr valign="top"><td width="40%">';
				echo '<table name="podsumowanie2" width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';

				$SUMA_WYCENA_PODSTAWOWA = formatuj_wartosc_bez_spacji($SUMA_WYCENA_PODSTAWOWA);
				$SUMA_DODATKI = formatuj_wartosc_bez_spacji($transport2);
				$transport2 = formatuj_wartosc_bez_spacji($transport2);
				$SUMA = $SUMA_WYCENA_PODSTAWOWA+$SUMA_DODATKI+$transport2;
				
				echo '<INPUT type="hidden" name="SUMA" value="'.$SUMA.'">';
				// $SUMA_WYCENA_PODSTAWOWA = number_format($SUMA_WYCENA_PODSTAWOWA, 2,'.',' ');
				// $SUMA_DODATKI = number_format($SUMA_DODATKI, 2,'.',' ');
				// $transport2 = number_format($transport2, 2,'.',' ');
				// $SUMA = number_format($SUMA, 2,'.',' ');

				$SUMA_WYCENA_PODSTAWOWA = formatuj_wartosc_spacja($SUMA_WYCENA_PODSTAWOWA);
				$SUMA_DODATKI = formatuj_wartosc_spacja($SUMA_DODATKI);
				$transport2 = formatuj_wartosc_spacja($transport2);
				$SUMA = formatuj_wartosc_spacja($SUMA);
				
				echo '<tr><td align="left" width="100%"><b>Wycena podstawowa : </b>'.$SUMA_WYCENA_PODSTAWOWA.$waluta.'</td></tr>';
				echo '<tr><td align="left"><b>Dodatki : </b>'.$SUMA_DODATKI.$waluta.'</td></tr>';
				echo '<tr><td align="left"><b>Transport : </b>'.$transport2.$waluta.'</td></tr>';
				echo '<tr><td align="left"><b>Suma : </b>'.$SUMA.$waluta.'</td></tr>';
				echo '</table>';
				
				
			echo '</td><td rowspan="2">';
				//pobieram liste terminow realizacji
				$ilosc_terminow = 0;
				$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'termin_realizacji' ORDER BY id ASC;");
				while($wynik= mysqli_fetch_assoc($pytanie))
					{
					$ilosc_terminow++;
					$opis_termin[$ilosc_terminow]=$wynik['opis'];
					}
				//pobieram liste sposobow dostway
				$ilosc_sposobow = 0;
				$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'sposob_dostawy_wycena_wstepna' ORDER BY id ASC;");
				while($wynik= mysqli_fetch_assoc($pytanie))
					{
					$ilosc_sposobow++;
					$opis_sposob_dostawy[$ilosc_sposobow]=$wynik['opis'];
					}
					
				//pobieram ostatnio zapamietany sposob dostawy
				$pytanie = mysqli_query($conn, "SELECT wartosc FROM zapamietaj_ostatnie WHERE opis = 'wyceny_wstepne_sposob_dostawy';");
				while($wynik= mysqli_fetch_assoc($pytanie))
					$ostatnio_zapamietany_sposob_dostawy=$wynik['wartosc'];
				//pobieram ostatnio zapamietany termin realizacji
				$pytanie = mysqli_query($conn, "SELECT wartosc FROM zapamietaj_ostatnie WHERE opis = 'wyceny_wstepne_termin_realizacji';");
				while($wynik= mysqli_fetch_assoc($pytanie))
					$ostatnio_zapamietany_termin_realizacji=$wynik['wartosc'];
					
				//echo 'ostatnio_zapamietany_sposob_dostawy='.$ostatnio_zapamietany_sposob_dostawy.'<br>';
				//echo 'ostatnio_zapamietany_termin_realizacji='.$ostatnio_zapamietany_termin_realizacji.'<br>';
			
				echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
				echo '<tr><td align="left" width="100%">';
					//TABELA termin i sposb
					echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
					echo '<tr><td align="left" width="110px"><b>Termin realizacji : </b></td><td>';
						echo '<select name="termin_realizacji" class="'.$styl_input2.'" style="width: 50%">';
						for ($k=1; $k<=$ilosc_terminow; $k++) if($ostatnio_zapamietany_termin_realizacji == $opis_termin[$k]) echo '<option selected="selected" value="'.$opis_termin[$k].'">'.$opis_termin[$k].'</option>';
						else echo '<option value="'.$opis_termin[$k].'">'.$opis_termin[$k].'</option>';
						echo '</select>';
					echo '</td></tr>';
					echo '<tr><td align="left"><b>Sposób dostawy : </b></td><td>';
						echo '<select name="sposob_dostawy" class="'.$styl_input2.'" style="width: 50%">';
						for ($k=1; $k<=$ilosc_sposobow; $k++) if($ostatnio_zapamietany_sposob_dostawy == $opis_sposob_dostawy[$k]) echo '<option selected="selected" value="'.$opis_sposob_dostawy[$k].'">'.$opis_sposob_dostawy[$k].'</option>';
						else echo '<option value="'.$opis_sposob_dostawy[$k].'">'.$opis_sposob_dostawy[$k].'</option>';
						echo '</select>';
					echo '</td></tr></table>';
					// KONIEC termin i sposób
				echo '</td></tr>';
				echo '<tr><td align="left" valign="top">';
				
					//TABELA UWAGI
					echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
					echo '<tr><td align="left" width="110px"><b>Uwagi : </b></td><td>Wszystkie kwoty netto</td></tr>';
					for($x=1; $x<=$ilosc_pozycji; $x++) if($nazwa_uwagi[$x] != '') echo '<tr><td align="left">&nbsp;</td><td>'.$nazwa_uwagi[$x].'</td></tr>';
					// uwagi 1 
					$ilosc_uwaga_1 = 0;
					$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
					while($wynik91= mysqli_fetch_assoc($pytanie91))
							{
							$ilosc_uwaga_1++;
							$uwaga_1_id[$ilosc_uwaga_1] = $wynik91['id'];
							$uwaga_1_opis[$ilosc_uwaga_1] = $wynik91['opis'];
							}
					echo '<tr align="center" class="text"><td></td><td align="left">';
					echo '<select name="uwaga_1" class="'.$styl_input2.'" style="width: 100%">';
					echo '<option></option>';
					for ($k=1; $k<=$ilosc_uwaga_1; $k++) 
					if($uwaga_1 == $uwaga_1_opis[$k]) echo '<option selected="selected" value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
					else echo '<option value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
					echo '</select></td></tr>';
					
					// uwagi 2 
					$ilosc_uwaga_2 = 0;
					$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
					while($wynik91= mysqli_fetch_assoc($pytanie91))
							{
							$ilosc_uwaga_2++;
							$uwaga_2_id[$ilosc_uwaga_2] = $wynik91['id'];
							$uwaga_2_opis[$ilosc_uwaga_2] = $wynik91['opis'];
							}
					echo '<tr align="center" class="text"><td></td><td align="left">';
					echo '<select name="uwaga_2" class="'.$styl_input2.'" style="width: 100%">';
					echo '<option></option>';
					for ($k=1; $k<=$ilosc_uwaga_2; $k++) 
					if($uwaga_2 == $uwaga_2_opis[$k]) echo '<option selected="selected" value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
					else echo '<option value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
					echo '</select></td></tr>';
				
					//uwagi rczne
					echo '<tr align="center" class="text"><td></td><td align="left">';
					echo '<textarea name="uwagi_reczne" cols="74" rows="2" class="'.$styl_input2.'">'.$uwagi_reczne.'</textarea></td></tr>';
					echo '</table>';
					// KONIEC TABELA UWAGI
				echo '</td></tr></table>'; // do name="podsumowanie2"
			
			
			echo '</td></tr>';
			
			//PODSUMOWANIE SPORZDZI
			$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
			while($wynik2= mysqli_fetch_assoc($pytanie2))
				{
				$imie=$wynik2['imie'];
				$nazwisko=$wynik2['nazwisko'];
				$telefon=$wynik2['telefon'];
				$user_email=$wynik2['email'];
				}
			echo '<tr><td><b>Sporządził : </b><br>'.$imie.' '.$nazwisko.' | '.$telefon.' | '.$user_email.'</td></tr>';
				
			echo '</table>'; // do name="podsumowanie3"
		echo '</td></tr></table>'; // do name="podsumowanie1"
		
		
	echo '</td></tr>';
	
			echo '<tr align="center"><td><br>';
			echo '<INPUT type="submit" name="zapisz" value="Zapisz">';
			echo '</td></tr>';
			
	echo '</table>'; //tabela główna
	echo '</FORM>';
	}
?>