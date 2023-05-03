<?php
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

if($usun_wycene != '')
	{
	echo '<div align="center" class="text_duzy_czerwony">Czy na pewno chcesz usunąć wycenę wstępną nr '.$usun_wycene.'?</div>';
	echo '<div align="center"><br><br>';
	echo $nbsp.$nbsp.'<a href="index.php?page=wyceny_wstepne&wg_czego='.$wg_czego.'&jak='.$jak.'&klient='.$klient_id.'&usun_wycene='.$wycena_wstepna_nr.'&potwierdzam_usuniecie=TAK"><INPUT type="button" name="usun" value="Usuń"></a>';
	echo $nbsp.$nbsp.'<a href="index.php?page=wyceny_wstepne&wg_czego=id&jak=DESC"><INPUT type="button" name="powrot_rejestr" value="Powrót - Rejestr wycen"></a>';
	echo '</div>';
	}
elseif($zapisz == 'Zapisz')
	{
	//zapisuje dane wyceny
	$SUMA = change($SUMA);

	$SQL = [];
	//tresc zapytan
	$SQL[1] = "UPDATE wyceny SET termin_realizacji = '".$termin_realizacji."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[2] = "UPDATE wyceny SET sposob_dostawy_wycena_wstepna = '".$sposob_dostawy."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[3] = "UPDATE wyceny SET wycena_wstepna_wartosc_netto = ".$SUMA." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[4] = "UPDATE wyceny SET wycena_wstepna_email = '".$email."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[5] = "UPDATE klienci SET ostatnio_uzyty_wycena = '".$email."' WHERE id = ".$klient_id.";";

	//wykonanie zapytan
	for($s=1; $s<=5; $s++) mysqli_query($conn, $SQL[$s]);


	
	$pytanie3= mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja = 1;");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$zamowienie_id_baza=$wynik3['zamowienie_id'];
		$nr_zamowienia_baza=$wynik3['nr_zamowienia'];
		$link_wycena_pdf_baza=$wynik3['link_wycena_pdf'];
		}	
	
	if(($link_wycena_pdf_baza == '') && ($zamowienie_id_baza == '')) $modyfikuj=mysqli_query($conn, "UPDATE wyceny SET status = 'Nie wysłana' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";");
	elseif(($link_wycena_pdf_baza != '') && ($zamowienie_id_baza == '')) $modyfikuj=mysqli_query($conn, "UPDATE wyceny SET status = 'Wysłana' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";");
	
	$modyfikuj=mysqli_query($conn, "UPDATE wyceny SET ww_podsumowanie_uwagi1 ='".$uwaga_1."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";");
	$modyfikuj=mysqli_query($conn, "UPDATE wyceny SET ww_podsumowanie_uwagi2 ='".$uwaga_2."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";");
	$modyfikuj=mysqli_query($conn, "UPDATE wyceny SET ww_podsumowanie_uwagi_reczne ='".$uwagi_reczne."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";");
	
	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		$SQL = [];
		//tresc zapytan
		$SQL[1] = "UPDATE wyceny SET ww_pozycja_uwagi1='".$ww_pozycja_uwagi1[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[2] = "UPDATE wyceny SET ww_pozycja_uwagi2='".$ww_pozycja_uwagi2[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[3] = "UPDATE wyceny SET ww_pozycja_uwagi_reczne='".$ww_pozycja_uwagi_reczne[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[4] = "UPDATE wyceny SET dodatki_material='".$dodatki_material[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[5] = "UPDATE wyceny SET wycena_podstawowa_material='".$wycena_podstawowa_material[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[6] = "UPDATE wyceny SET rysunek='".$ww_rysunek[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[7] = "UPDATE wyceny SET wygiecie_innego_pvc_opis='".$input_wygiecie_innego_pvc[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[8] = "UPDATE wyceny SET wygiecie_innego_ze_stali_opis='".$input_wygiecie_innego_ze_stali[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[9] = "UPDATE wyceny SET kolor='".$nazwa_kolor[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[10] = "UPDATE wyceny SET wycena_wstepna_wartosc1 = '".$nazwa_wartosc1[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";
		$SQL[11] = "UPDATE wyceny SET wycena_wstepna_wartosc2 = '".$nazwa_wartosc2[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";";

		//wykonanie zapytan
		for($s=1; $s<=11; $s++) mysqli_query($conn, $SQL[$s]);
		}
	
	
//##############################################################################################

	//tworzymy kopie wyceny z nowym numerem
	include ("php/wyceny_deklaracja_pustych_tablic.php");
	$kolor = [];
	$wygiecie_innego_pvc_opis = [];
	$wygiecie_innego_ze_stali_opis = [];
	$ww_pozycja_uwagi1 = [];
	$ww_pozycja_uwagi2 = [];
	$ww_pozycja_uwagi_reczne = [];
	$wycena_podstawowa_material = [];
	$dodatki_material = [];
	$rysunek = [];
	if($kopia_wyceny == 'on')
		{
		$ilosc_kopia=0;
		$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' ORDER BY pozycja ASC;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc_kopia++;
			$klient_id = $wynik['klient_id'];
			$klient_nazwa = $wynik['klient_nazwa'];
			$zamowienie_id = $wynik['zamowienie_id'];

			$nr_zamowienia = $wynik['nr_zamowienia'];
			$ilosc_pozycji[$ilosc_kopia] = $wynik['ilosc_pozycji'];
			$pozycja[$ilosc_kopia] = $wynik['pozycja'];
			$pozycja_transport[$ilosc_kopia] = $wynik['pozycja_transport'];
			$status[$ilosc_kopia] = $wynik['status'];
			
			$wygiecie_ramy_pvc_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_ramy_pvc_ilosc_szt']);
			$wygiecie_ramy_pvc_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_ramy_pvc_ilosc_m']);
			$wygiecie_ramy_pvc_cena[$ilosc_kopia] = change($wynik['wygiecie_ramy_pvc_cena']);
			$wygiecie_ramy_pvc_wartosc[$ilosc_kopia] = change($wynik['wygiecie_ramy_pvc_wartosc']);
			
			$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_pvc_ilosc_szt']);
			$wygiecie_skrzydla_pvc_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_pvc_ilosc_m']);
			$wygiecie_skrzydla_pvc_cena[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_pvc_cena']);
			$wygiecie_skrzydla_pvc_wartosc[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_pvc_wartosc']);
			$wygiecie_listwy_pvc_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_listwy_pvc_ilosc_szt']);
			$wygiecie_listwy_pvc_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_listwy_pvc_ilosc_m']);
			$wygiecie_listwy_pvc_cena[$ilosc_kopia] = change($wynik['wygiecie_listwy_pvc_cena']);
			$wygiecie_listwy_pvc_wartosc[$ilosc_kopia] = change($wynik['wygiecie_listwy_pvc_wartosc']);
			
			$wygiecie_innego_pvc_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_innego_pvc_ilosc_szt']);
			$wygiecie_innego_pvc_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_innego_pvc_ilosc_m']);
			$wygiecie_innego_pvc_cena[$ilosc_kopia] = change($wynik['wygiecie_innego_pvc_cena']);
			$wygiecie_innego_pvc_wartosc[$ilosc_kopia] = change($wynik['wygiecie_innego_pvc_wartosc']);
			$wygiecie_ramy_alu_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_ramy_alu_ilosc_szt']);
			$wygiecie_ramy_alu_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_ramy_alu_ilosc_m']);
			$wygiecie_ramy_alu_cena[$ilosc_kopia] = change($wynik['wygiecie_ramy_alu_cena']);
			$wygiecie_ramy_alu_wartosc[$ilosc_kopia] = change($wynik['wygiecie_ramy_alu_wartosc']);
			
			$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_alu_ilosc_szt']);
			$wygiecie_skrzydla_alu_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_alu_ilosc_m']);
			$wygiecie_skrzydla_alu_cena[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_alu_cena']);
			$wygiecie_skrzydla_alu_wartosc[$ilosc_kopia] = change($wynik['wygiecie_skrzydla_alu_wartosc']);
			$wygiecie_listwy_alu_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_listwy_alu_ilosc_szt']);
			$wygiecie_listwy_alu_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_listwy_alu_ilosc_m']);
			$wygiecie_listwy_alu_cena[$ilosc_kopia] = change($wynik['wygiecie_listwy_alu_cena']);
			$wygiecie_listwy_alu_wartosc[$ilosc_kopia] = change($wynik['wygiecie_listwy_alu_wartosc']);
			$wygiecie_innego_alu_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_innego_alu_ilosc_szt']);
			$wygiecie_innego_alu_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_innego_alu_ilosc_m']);
			$wygiecie_innego_alu_cena[$ilosc_kopia] = change($wynik['wygiecie_innego_alu_cena']);
			$wygiecie_innego_alu_wartosc[$ilosc_kopia] = change($wynik['wygiecie_innego_alu_wartosc']);
			
			$wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_wzmocnienia_okiennego_ilosc_szt']);
			$wygiecie_wzmocnienia_okiennego_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_wzmocnienia_okiennego_ilosc_m']);
			$wygiecie_wzmocnienia_okiennego_cena[$ilosc_kopia] = change($wynik['wygiecie_wzmocnienia_okiennego_cena']);
			$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_kopia] = change($wynik['wygiecie_wzmocnienia_okiennego_wartosc']);
			$wygiecie_innego_ilosc_szt[$ilosc_kopia] = change($wynik['wygiecie_innego_ilosc_szt']);
			$wygiecie_innego_ilosc_m[$ilosc_kopia] = change($wynik['wygiecie_innego_ilosc_m']);
			$wygiecie_innego_cena[$ilosc_kopia] = change($wynik['wygiecie_innego_cena']);
			$wygiecie_innego_wartosc[$ilosc_kopia] = change($wynik['wygiecie_innego_wartosc']);
			
			$zgrzanie_ilosc[$ilosc_kopia] = change($wynik['zgrzanie_ilosc']);
			$zgrzanie_cena[$ilosc_kopia] = change($wynik['zgrzanie_cena']);
			$zgrzanie_wartosc[$ilosc_kopia] = change($wynik['zgrzanie_wartosc']);
			$wyfrezowanie_odwodnienia_ilosc[$ilosc_kopia] = change($wynik['wyfrezowanie_odwodnienia_ilosc']);
			$wyfrezowanie_odwodnienia_cena[$ilosc_kopia] = change($wynik['wyfrezowanie_odwodnienia_cena']);
			$wyfrezowanie_odwodnienia_wartosc[$ilosc_kopia] = change($wynik['wyfrezowanie_odwodnienia_wartosc']);
			$wstawienie_slupka_ilosc[$ilosc_kopia] = change($wynik['wstawienie_slupka_ilosc']);
			$wstawienie_slupka_cena[$ilosc_kopia] = change($wynik['wstawienie_slupka_cena']);
			$wstawienie_slupka_wartosc[$ilosc_kopia] = change($wynik['wstawienie_slupka_wartosc']);
			$listwa_przyszybowa_ilosc[$ilosc_kopia] = change($wynik['listwa_przyszybowa_ilosc']);
			$listwa_przyszybowa_cena[$ilosc_kopia] = change($wynik['listwa_przyszybowa_cena']);
			$listwa_przyszybowa_wartosc[$ilosc_kopia] = change($wynik['listwa_przyszybowa_wartosc']);
			$wstawienie_slupka_ruchomego_ilosc[$ilosc_kopia] = change($wynik['wstawienie_slupka_ruchomego_ilosc']);
			$wstawienie_slupka_ruchomego_cena[$ilosc_kopia] = change($wynik['wstawienie_slupka_ruchomego_cena']);
			$wstawienie_slupka_ruchomego_wartosc[$ilosc_kopia] = change($wynik['wstawienie_slupka_ruchomego_wartosc']);
			$dociecie_kompletu_listew_przyszybowych_ilosc[$ilosc_kopia] = change($wynik['dociecie_kompletu_listew_przyszybowych_ilosc']);
			$dociecie_kompletu_listew_przyszybowych_cena[$ilosc_kopia] = change($wynik['dociecie_kompletu_listew_przyszybowych_cena']);
			$dociecie_kompletu_listew_przyszybowych_wartosc[$ilosc_kopia] = change($wynik['dociecie_kompletu_listew_przyszybowych_wartosc']);
	
			$okucie_ilosc[$ilosc_kopia] = change($wynik['okucie_ilosc']);
			$okucie_cena[$ilosc_kopia] = change($wynik['okucie_cena']);
			$okucie_wartosc[$ilosc_kopia] = change($wynik['okucie_wartosc']);
			$zaszklenie_ilosc[$ilosc_kopia] = change($wynik['zaszklenie_ilosc']);
			$zaszklenie_cena[$ilosc_kopia] = change($wynik['zaszklenie_cena']);
			$zaszklenie_wartosc[$ilosc_kopia] = change($wynik['zaszklenie_wartosc']);
			$innej_uslugi_ilosc[$ilosc_kopia] = change($wynik['innej_uslugi_ilosc']);
			$innej_uslugi_cena[$ilosc_kopia] = change($wynik['innej_uslugi_cena']);
			$innej_uslugi_wartosc[$ilosc_kopia] = change($wynik['innej_uslugi_wartosc']);
			
			$oscieznica_ilosc[$ilosc_kopia] = change($wynik['oscieznica_ilosc']);
			$oscieznica_cena[$ilosc_kopia] = change($wynik['oscieznica_cena']);
			$oscieznica_wartosc[$ilosc_kopia] = change($wynik['oscieznica_wartosc']);
			$skrzydlo_ilosc[$ilosc_kopia] = change($wynik['skrzydlo_ilosc']);
			$skrzydlo_cena[$ilosc_kopia] = change($wynik['skrzydlo_cena']);
			$skrzydlo_wartosc[$ilosc_kopia] = change($wynik['skrzydlo_wartosc']);
			$listwa_ilosc[$ilosc_kopia] = change($wynik['listwa_ilosc']);
			$listwa_cena[$ilosc_kopia] = change($wynik['listwa_cena']);
			$listwa_wartosc[$ilosc_kopia] = change($wynik['listwa_wartosc']);
			$slupek_ilosc[$ilosc_kopia] = change($wynik['slupek_ilosc']);
			$slupek_cena[$ilosc_kopia] = change($wynik['slupek_cena']);
			$slupek_wartosc[$ilosc_kopia] = change($wynik['slupek_wartosc']);
			
			$wzmocnienie_ramy_ilosc[$ilosc_kopia] = change($wynik['wzmocnienie_ramy_ilosc']);
			$wzmocnienie_ramy_cena[$ilosc_kopia] = change($wynik['wzmocnienie_ramy_cena']);
			$wzmocnienie_ramy_wartosc[$ilosc_kopia] = change($wynik['wzmocnienie_ramy_wartosc']);
			$wzmocnienie_skrzydla_ilosc[$ilosc_kopia] = change($wynik['wzmocnienie_skrzydla_ilosc']);
			$wzmocnienie_skrzydla_cena[$ilosc_kopia] = change($wynik['wzmocnienie_skrzydla_cena']);
			$wzmocnienie_skrzydla_wartosc[$ilosc_kopia] = change($wynik['wzmocnienie_skrzydla_wartosc']);
			$wzmocnienie_slupka_ilosc[$ilosc_kopia] = change($wynik['wzmocnienie_slupka_ilosc']);
			$wzmocnienie_slupka_cena[$ilosc_kopia] = change($wynik['wzmocnienie_slupka_cena']);
			$wzmocnienie_slupka_wartosc[$ilosc_kopia] = change($wynik['wzmocnienie_slupka_wartosc']);
			$wzmocnienie_luku_ilosc[$ilosc_kopia] = change($wynik['wzmocnienie_luku_ilosc']);
			$wzmocnienie_luku_cena[$ilosc_kopia] = change($wynik['wzmocnienie_luku_cena']);
			$wzmocnienie_luku_wartosc[$ilosc_kopia] = change($wynik['wzmocnienie_luku_wartosc']);
			$okucia_ilosc[$ilosc_kopia] = change($wynik['okucia_ilosc']);
			$okucia_cena[$ilosc_kopia] = change($wynik['okucia_cena']);
			$okucia_wartosc[$ilosc_kopia] = change($wynik['okucia_wartosc']);
			$szyby_ilosc[$ilosc_kopia] = change($wynik['szyby_ilosc']);
			$szyby_cena[$ilosc_kopia] = change($wynik['szyby_cena']);
			$szyby_wartosc[$ilosc_kopia] = change($wynik['szyby_wartosc']);
			$inny_element_ilosc[$ilosc_kopia] = change($wynik['inny_element_ilosc']);
			$inny_element_cena[$ilosc_kopia] = change($wynik['inny_element_cena']);
			$inny_element_wartosc[$ilosc_kopia] = change($wynik['inny_element_wartosc']);
			
			$okna[$ilosc_kopia] = change($wynik['okna']);
			$drzwi_wewnetrzne[$ilosc_kopia] = change($wynik['drzwi_wewnetrzne']);
			$drzwi_zewnetrzne[$ilosc_kopia] = change($wynik['drzwi_zewnetrzne']);
			$bramy[$ilosc_kopia] = change($wynik['bramy']);
			$parapety[$ilosc_kopia] = change($wynik['parapety']);
			$rolety_zewnetrzne[$ilosc_kopia] = change($wynik['rolety_zewnetrzne']);
			$rolety_wewnetrzne[$ilosc_kopia] = change($wynik['rolety_wewnetrzne']);
			$moskitiery[$ilosc_kopia] = change($wynik['moskitiery']);
			$montaz[$ilosc_kopia] = change($wynik['montaz']);
			$odpady_pvc[$ilosc_kopia] = change($wynik['odpady_pvc']);

			$odpady_alu_stal[$ilosc_kopia] = change($wynik['odpady_alu_stal']);
			$transport[$ilosc_kopia] = change($wynik['transport']);
			$inne[$ilosc_kopia] = change($wynik['inne']);

			$stopien_trudnosci[$ilosc_kopia]=$wynik['stopien_trudnosci'];
			$nazwa_produktu[$ilosc_kopia]=$wynik['nazwa_produktu'];
			
			$cena_netto_za_sztuke[$ilosc_kopia]=change($wynik['cena_netto_za_sztuke']);
			$ilosc_sztuk[$ilosc_kopia]=$wynik['ilosc_sztuk'];
			$wartosc_netto[$ilosc_kopia]=change($wynik['wartosc_netto']);
			$vat_baza[$ilosc_kopia]=$wynik['vat'];
			$wartosc_brutto[$ilosc_kopia]=change($wynik['wartosc_brutto']);

			$uwagi[$ilosc_kopia]=$wynik['uwagi'];
			$user_id_wycena=$wynik['user_id'];
			$data_waznosci_wyceny=$wynik['data_waznosci_wyceny'];
			$wycena_wstepna_email=$wynik['wycena_wstepna_email'];
			$wycena_wstepna_wartosc1[$ilosc_kopia]=$wynik['wycena_wstepna_wartosc1'];
			$wycena_wstepna_wartosc2[$ilosc_kopia]=$wynik['wycena_wstepna_wartosc2'];
			$kolor[$ilosc_kopia]=$wynik['kolor'];
			$wycena_wstepna_wartosc_netto=change($wynik['wycena_wstepna_wartosc_netto']);
			$wygiecie_innego_pvc_opis[$ilosc_kopia]=$wynik['wygiecie_innego_pvc_opis'];
			$wygiecie_innego_ze_stali_opis[$ilosc_kopia]=$wynik['wygiecie_innego_ze_stali_opis'];
			$ww_pozycja_uwagi1[$ilosc_kopia]=$wynik['ww_pozycja_uwagi1'];
			$ww_pozycja_uwagi2[$ilosc_kopia]=$wynik['ww_pozycja_uwagi2'];
			$ww_pozycja_uwagi_reczne[$ilosc_kopia]=$wynik['ww_pozycja_uwagi_reczne'];
			$wycena_podstawowa_material[$ilosc_kopia]=$wynik['wycena_podstawowa_material'];
			$dodatki_material[$ilosc_kopia]=$wynik['dodatki_material'];
			$rysunek[$ilosc_kopia]=$wynik['rysunek'];

			$checkbox_wygiecie_wzmocnienia[$ilosc_pozycji] = $wynik['checkbox_wygiecie_wzmocnienia'];
			$checkbox_wygiecie_skrzydla[$ilosc_pozycji] = $wynik['checkbox_wygiecie_skrzydla'];
			$checkbox_wygiecie_listwy[$ilosc_pozycji] = $wynik['checkbox_wygiecie_listwy'];


			// tylko do pierwszej pozycji
			if($ilosc_kopia == 1)
				{
				$termin_realizacji=$wynik['termin_realizacji'];
				$sposob_dostawy=$wynik['sposob_dostawy_wycena_wstepna'];
				$ww_podsumowanie_uwagi1=$wynik['ww_podsumowanie_uwagi1'];
				$ww_podsumowanie_uwagi2=$wynik['ww_podsumowanie_uwagi2'];
				$ww_podsumowanie_uwagi_reczne=$wynik['ww_podsumowanie_uwagi_reczne'];
				}

			}
		//szukam iniciałów usera
		$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$zalogowany_user.";");
		while($wynik2= mysqli_fetch_assoc($pytanie2))
			{
			$imie=$wynik2['imie'];
			$nazwisko=$wynik2['nazwisko'];
			}

		// pobieram kolejny numer wyceny wstepnej
		$pytanie333 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'wycena_wstepna_nr';");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			$kolejny_nr_wyceny=$wynik333['opis'];
		
		if(($imie[0] != '') && ($nazwisko[0] != '')) $wycena_wstepna_nr_kopia = $kolejny_nr_wyceny."/".$aktualny_rok."/".$imie[0].$nazwisko[0];
		else $wycena_wstepna_nr_kopia = $kolejny_nr_wyceny."/".$aktualny_rok;
	
		$kolejny_nr_wyceny++;
		$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$kolejny_nr_wyceny." WHERE typ = 'wycena_wstepna_nr';");

		for($i=1; $i<=$ilosc_kopia; $i++)
			{
				//zerujemy wartosci dla pozycji transportowej
				if($pozycja_transport[$i] == 'tak')
				{
					$ilosc_sztuk[$i] = 0;
					$stopien_trudnosci[$i] = 1;
				}

			$pytanie1 = "INSERT INTO wyceny (`klient_id`, `klient_nazwa`, `nr_zamowienia`, `ilosc_pozycji`, `pozycja`, `pozycja_transport`, `status` 
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
			,`wycena_wstepna_nr`, `data_wyceny`, `user_id`, `data_waznosci_wyceny`, `wycena_wstepna_email`
			,`wycena_wstepna_wartosc1`, `wycena_wstepna_wartosc2`, `termin_realizacji`, `sposob_dostawy_wycena_wstepna`, `kolor`, `wycena_wstepna_wartosc_netto`, `wygiecie_innego_pvc_opis`, `wygiecie_innego_ze_stali_opis`, `ww_pozycja_uwagi1`, `ww_pozycja_uwagi2`, `ww_pozycja_uwagi_reczne`
			,`ww_podsumowanie_uwagi1`, `ww_podsumowanie_uwagi2`, `ww_podsumowanie_uwagi_reczne`, `wycena_podstawowa_material`, `dodatki_material`, `rysunek`
			,`checkbox_wygiecie_wzmocnienia`, `checkbox_wygiecie_skrzydla`, `checkbox_wygiecie_listwy`
			, `wstawienie_slupka_ruchomego_ilosc`, `wstawienie_slupka_ruchomego_cena`, `wstawienie_slupka_ruchomego_wartosc`
			, `dociecie_kompletu_listew_przyszybowych_ilosc`, `dociecie_kompletu_listew_przyszybowych_cena`, `dociecie_kompletu_listew_przyszybowych_wartosc`, `stopien_trudnosci`)
			
			values ('$klient_id', '$klient_nazwa', '$wycena_wstepna_nr_kopia', '$ilosc_kopia', '$i', '$pozycja_transport[$i]', 'Nie wysłana'
			, '$wygiecie_ramy_pvc_ilosc_szt[$i]', '$wygiecie_ramy_pvc_ilosc_m[$i]', '$wygiecie_ramy_pvc_cena[$i]', '$wygiecie_ramy_pvc_wartosc[$i]'
			, '$wygiecie_skrzydla_pvc_ilosc_szt[$i]', '$wygiecie_skrzydla_pvc_ilosc_m[$i]', '$wygiecie_skrzydla_pvc_cena[$i]', '$wygiecie_skrzydla_pvc_wartosc[$i]'
			, '$wygiecie_listwy_pvc_ilosc_szt[$i]', '$wygiecie_listwy_pvc_ilosc_m[$i]', '$wygiecie_listwy_pvc_cena[$i]', '$wygiecie_listwy_pvc_wartosc[$i]'
			, '$wygiecie_innego_pvc_ilosc_szt[$i]', '$wygiecie_innego_pvc_ilosc_m[$i]', '$wygiecie_innego_pvc_cena[$i]', '$wygiecie_innego_pvc_wartosc[$i]'
			
			, '$wygiecie_ramy_alu_ilosc_szt[$i]', '$wygiecie_ramy_alu_ilosc_m[$i]', '$wygiecie_ramy_alu_cena[$i]', '$wygiecie_ramy_alu_wartosc[$i]'
			, '$wygiecie_skrzydla_alu_ilosc_szt[$i]', '$wygiecie_skrzydla_alu_ilosc_m[$i]', '$wygiecie_skrzydla_alu_cena[$i]', '$wygiecie_skrzydla_alu_wartosc[$i]'
			, '$wygiecie_listwy_alu_ilosc_szt[$i]', '$wygiecie_listwy_alu_ilosc_m[$i]', '$wygiecie_listwy_alu_cena[$i]', '$wygiecie_listwy_alu_wartosc[$i]'
			, '$wygiecie_innego_alu_ilosc_szt[$i]', '$wygiecie_innego_alu_ilosc_m[$i]', '$wygiecie_innego_alu_cena[$i]', '$wygiecie_innego_alu_wartosc[$i]'
			
			, '$wygiecie_wzmocnienia_okiennego_ilosc_szt[$i]', '$wygiecie_wzmocnienia_okiennego_ilosc_m[$i]', '$wygiecie_wzmocnienia_okiennego_cena[$i]', '$wygiecie_wzmocnienia_okiennego_wartosc[$i]'
			, '$wygiecie_innego_ilosc_szt[$i]', '$wygiecie_innego_ilosc_m[$i]', '$wygiecie_innego_cena[$i]', '$wygiecie_innego_wartosc[$i]'
			
			, '$zgrzanie_ilosc[$i]', '$zgrzanie_cena[$i]', '$zgrzanie_wartosc[$i]'
			, '$wyfrezowanie_odwodnienia_ilosc[$i]', '$wyfrezowanie_odwodnienia_cena[$i]', '$wyfrezowanie_odwodnienia_wartosc[$i]'
			, '$wstawienie_slupka_ilosc[$i]', '$wstawienie_slupka_cena[$i]', '$wstawienie_slupka_wartosc[$i]'
			, '$listwa_przyszybowa_ilosc[$i]', '$listwa_przyszybowa_cena[$i]', '$listwa_przyszybowa_wartosc[$i]'
			, '$okucie_ilosc[$i]', '$okucie_cena[$i]', '$okucie_wartosc[$i]'
			, '$zaszklenie_ilosc[$i]', '$zaszklenie_cena[$i]', '$zaszklenie_wartosc[$i]'
			, '$innej_uslugi_ilosc[$i]', '$innej_uslugi_cena[$i]', '$innej_uslugi_wartosc[$i]'
			
			, '$oscieznica_ilosc[$i]', '$oscieznica_cena[$i]', '$oscieznica_wartosc[$i]'
			, '$skrzydlo_ilosc[$i]', '$skrzydlo_cena[$i]', '$skrzydlo_wartosc[$i]'
			, '$listwa_ilosc[$i]', '$listwa_cena[$i]', '$listwa_wartosc[$i]'
			, '$slupek_ilosc[$i]', '$slupek_cena[$i]', '$slupek_wartosc[$i]'
			, '$wzmocnienie_ramy_ilosc[$i]', '$wzmocnienie_ramy_cena[$i]', '$wzmocnienie_ramy_wartosc[$i]'
			, '$wzmocnienie_skrzydla_ilosc[$i]', '$wzmocnienie_skrzydla_cena[$i]', '$wzmocnienie_skrzydla_wartosc[$i]'
			, '$wzmocnienie_slupka_ilosc[$i]', '$wzmocnienie_slupka_cena[$i]', '$wzmocnienie_slupka_wartosc[$i]'
			, '$wzmocnienie_luku_ilosc[$i]', '$wzmocnienie_luku_cena[$i]', '$wzmocnienie_luku_wartosc[$i]'
			, '$okucia_ilosc[$i]', '$okucia_cena[$i]', '$okucia_wartosc[$i]'
			, '$szyby_ilosc[$i]', '$szyby_cena[$i]', '$szyby_wartosc[$i]'
			, '$inny_element_ilosc[$i]', '$inny_element_cena[$i]', '$inny_element_wartosc[$i]'
			
			, '$okna[$i]', '$drzwi_wewnetrzne[$i]', '$drzwi_zewnetrzne[$i]'
			, '$bramy[$i]', '$parapety[$i]', '$rolety_zewnetrzne[$i]'
			, '$rolety_wewnetrzne[$i]', '$moskitiery[$i]', '$montaz[$i]'
			, '$odpady_pvc[$i]', '$odpady_alu_stal[$i]', '$transport[$i]', '$inne[$i]' 
			
			, '$nazwa_produktu[$i]', '$cena_netto_za_sztuke[$i]', '$ilosc_sztuk[$i]', '$wartosc_netto[$i]', '$vat_baza[$i]'
			, '$wartosc_brutto[$i]', '$uwagi[$i]', 'NIE'
			, '$wycena_wstepna_nr_kopia', '$time', '$user_id_wycena', '$data_waznosci_wyceny', '$wycena_wstepna_email'
			, '$wycena_wstepna_wartosc1[$i]', '$wycena_wstepna_wartosc2[$i]', '$termin_realizacji', '$sposob_dostawy', '$kolor[$i]', '$wycena_wstepna_wartosc_netto'
			, '$wygiecie_innego_pvc_opis[$i]', '$wygiecie_innego_ze_stali_opis[$i]', '$ww_pozycja_uwagi1[$i]', '$ww_pozycja_uwagi2[$i]', '$ww_pozycja_uwagi_reczne[$i]', '$ww_podsumowanie_uwagi1'
			, '$ww_podsumowanie_uwagi2', '$ww_podsumowanie_uwagi_reczne', '$wycena_podstawowa_material[$i]', '$dodatki_material[$i]', '$rysunek[$i]'
			, '$checkbox_wygiecie_wzmocnienia[$i]', '$checkbox_wygiecie_skrzydla[$i]', '$checkbox_wygiecie_listwy[$i]'
			, '$wstawienie_slupka_ruchomego_ilosc[$i]', '$wstawienie_slupka_ruchomego_cena[$i]', '$wstawienie_slupka_ruchomego_wartosc[$i]'
			, '$dociecie_kompletu_listew_przyszybowych_ilosc[$i]', '$dociecie_kompletu_listew_przyszybowych_cena[$i]', '$dociecie_kompletu_listew_przyszybowych_wartosc[$i]', '$stopien_trudnosci[$i]');";

			mysqli_query($conn, $pytanie1);

			} // do for
		echo '<div class="text_green" align="center">Kopia wyceny z nowym numerem '.$wycena_wstepna_nr_kopia.' została utworzona.</div>';
		} // do if($kopia_wyceny == 'on')
	
	
	echo '<div class="text_green" align="center">Dane wyceny zostały zmienione.</div>';
	echo '<br><div align="center">';
	if($email != '') echo '<a href="index.php?page=wyceny_wstepne&wg_czego=id&jak=DESC&wycena_wstepna_wysylka='.$wycena_wstepna_nr.'&klient='.$klient_id.'&wyslij=TAK"><INPUT type="button" name="wyslij" value="Wyślij"></a>'.$tabulator;
	else echo '<div class="text_red" align="center">Nie można wysłać - brak adresu email.</div><br>';
	echo '<a href="index.php?page=wyceny_wstepne&wg_czego=id&jak=DESC"><INPUT type="button" name="powrot_rejestr" value="Powrót - Rejestr wycen"></a>';
	echo '</div>';
	}
else
	{
	for($i = 1; $i <= $ilosc_pozycji; $i++)
		{
		$modyfikuj=mysqli_query($conn, "UPDATE wyceny SET rysunek='".$ww_rysunek[$i]."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id." AND pozycja = ".$i.";");
		}
		
		$ilosc_pozycji = 0;
		$wycena_wstepna_pozycja_uwagi1 = [];
		$wycena_wstepna_pozycja_uwagi2 = [];
		$wycena_wstepna_pozycja_uwagi_reczne = [];
		$ilosc_sztuk = [];
		$produkt = [];
		$wartosc1 = [];
		$wartosc2 = [];
		$kolor = [];
		$rysunek = [];
		$wygiecie_innego_pvc_opis = [];
		$wygiecie_innego_ze_stali_opis = [];
		$wygiecie_innego_ze_stali_wartosc = [];
		$wygiecie_ramy_pvc_wartosc = [];
		$wygiecie_skrzydla_pvc_wartosc = [];
		$wygiecie_listwy_pvc_wartosc = [];
		$wygiecie_innego_pvc_wartosc = [];
		$zgrzanie_wartosc = [];
		$oscieznica_wartosc = [];
		$skrzydlo_wartosc = [];
		$listwa_wartosc = [];
		$wzmocnienie_ramy_wartosc = [];
		$wzmocnienie_skrzydla_wartosc = [];
		$wygiecie_wzmocnienia_okiennego_wartosc = [];

		$wstawienie_slupka_wartosc = [];
		$listwa_przyszybowa_wartosc = [];
		$wstawienie_slupka_ruchomego_wartosc = [];
		$dociecie_kompletu_listew_przyszybowych_wartosc= [];

		$okucie_wartosc = [];
		$zaszklenie_wartosc = [];
		$innej_uslugi_wartosc = [];
		$wyfrezowanie_odwodnienia_wartosc = [];
		$slupek_wartosc = [];
		$wzmocnienie_slupka_wartosc = [];
		$wzmocnienie_luku_wartosc = [];
		$okucia_wartosc = [];
		$szyby_wartosc = [];
		$inny_element_wartosc = [];
		$wycena_podstawowa_material_baza = [];
		$dodatki_material_baza = [];
		$wygiecie_ramy_alu_wartosc = [];
		$wygiecie_skrzydla_alu_wartosc = [];
		$wygiecie_listwy_alu_wartosc = [];
		$wygiecie_innego_alu_wartosc = [];
		$okna = [];
		$drzwi_wewnetrzne = [];
		$drzwi_zewnetrzne = [];
		$bramy = [];
		$parapety = [];
		$rolety_zewnetrzne = [];
		$rolety_wewnetrzne = [];
		$moskitiery = [];
		$montaz = [];
		$odpady_pvc = [];
		$odpady_alu_stal = [];
		$inne = [];

	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'NIE' ORDER BY pozycja ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji++;
		$wycena_wstepna_dodal_klient_id=$wynik['wycena_wstepna_dodal_klient_id'];		
		$wycena_id=$wynik['id'];
		$klient_id=$wynik['klient_id'];
		$data_wyceny=$wynik['data_wyceny'];
		$wycena_wstepna_nr=$wynik['wycena_wstepna_nr'];
		$wartosc_netto=$wynik['wartosc_netto'];
		$link_wycena_pdf=$wynik['link_wycena_pdf'];
		$klient_nazwa=$wynik['klient_nazwa'];
		$user_id_wycena=$wynik['user_id'];
		$email=$wynik['wycena_wstepna_email'];
		$data_waznosci=$wynik['data_waznosci_wyceny'];
		$wycena_wstepna_pozycja_uwagi1[$ilosc_pozycji]=$wynik['ww_pozycja_uwagi1'];
		$wycena_wstepna_pozycja_uwagi2[$ilosc_pozycji]=$wynik['ww_pozycja_uwagi2'];
		$wycena_wstepna_pozycja_uwagi_reczne[$ilosc_pozycji]=$wynik['ww_pozycja_uwagi_reczne'];
		$nr_zamowienia=$wynik['nr_zamowienia'];
		$zamowienie_id=$wynik['zamowienie_id'];
		$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
		$produkt[$ilosc_pozycji]=$wynik['nazwa_produktu'];
		$wartosc1[$ilosc_pozycji]=$wynik['wycena_wstepna_wartosc1'];
		$wartosc2[$ilosc_pozycji]=$wynik['wycena_wstepna_wartosc2'];
		$kolor[$ilosc_pozycji]=$wynik['kolor'];
		$rysunek[$ilosc_pozycji]=$wynik['rysunek'];

		$wygiecie_innego_pvc_opis[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_opis'];
		$wygiecie_innego_ze_stali_opis[$ilosc_pozycji]=$wynik['wygiecie_innego_ze_stali_opis'];
		$wygiecie_innego_ze_stali_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_wartosc'];
		$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_wartosc'];
		$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_wartosc'];
		$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_wartosc'];
		$wygiecie_innego_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_wartosc'];
		$zgrzanie_wartosc[$ilosc_pozycji]=$wynik['zgrzanie_wartosc'];
		$oscieznica_wartosc[$ilosc_pozycji]=$wynik['oscieznica_wartosc'];
		$skrzydlo_wartosc[$ilosc_pozycji]=$wynik['skrzydlo_wartosc'];
		$listwa_wartosc[$ilosc_pozycji]=$wynik['listwa_wartosc'];

		$wstawienie_slupka_ruchomego_wartosc[$ilosc_pozycji] = $wynik['wstawienie_slupka_ruchomego_wartosc'];
		$dociecie_kompletu_listew_przyszybowych_wartosc[$ilosc_pozycji] = $wynik['dociecie_kompletu_listew_przyszybowych_wartosc'];
		
		$wzmocnienie_ramy_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_ramy_wartosc'];
		$wzmocnienie_skrzydla_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_skrzydla_wartosc'];
		$wygiecie_wzmocnienia_okiennego_wartosc[$ilosc_pozycji]=$wynik['wygiecie_wzmocnienia_okiennego_wartosc'];
		$wstawienie_slupka_wartosc[$ilosc_pozycji]=$wynik['wstawienie_slupka_wartosc'];
		$listwa_przyszybowa_wartosc[$ilosc_pozycji]=$wynik['listwa_przyszybowa_wartosc'];
		$wstawienie_slupka_ruchomego_wartosc[$ilosc_pozycji] = $wynik['wstawienie_slupka_ruchomego_wartosc'];
		$dociecie_kompletu_listew_przyszybowych_wartosc[$ilosc_pozycji] = $wynik['dociecie_kompletu_listew_przyszybowych_wartosc'];

		$okucie_wartosc[$ilosc_pozycji]=$wynik['okucie_wartosc'];
		$zaszklenie_wartosc[$ilosc_pozycji]=$wynik['zaszklenie_wartosc'];
		$innej_uslugi_wartosc[$ilosc_pozycji]=$wynik['innej_uslugi_wartosc'];
		$wyfrezowanie_odwodnienia_wartosc[$ilosc_pozycji]=$wynik['wyfrezowanie_odwodnienia_wartosc'];
		$slupek_wartosc[$ilosc_pozycji]=$wynik['slupek_wartosc'];
		$wzmocnienie_slupka_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_slupka_wartosc'];
		$wzmocnienie_luku_wartosc[$ilosc_pozycji]=$wynik['wzmocnienie_luku_wartosc'];
		$okucia_wartosc[$ilosc_pozycji]=$wynik['okucia_wartosc'];
		$szyby_wartosc[$ilosc_pozycji]=$wynik['szyby_wartosc'];
		$inny_element_wartosc[$ilosc_pozycji]=$wynik['inny_element_wartosc'];		
		$wycena_podstawowa_material_baza[$ilosc_pozycji]=$wynik['wycena_podstawowa_material'];		
		$dodatki_material_baza[$ilosc_pozycji]=$wynik['dodatki_material'];		

		// wartosci dodawane do dodatkow:
		$wygiecie_ramy_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_alu_wartosc'];
		$wygiecie_skrzydla_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_alu_wartosc'];
		$wygiecie_listwy_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_alu_wartosc'];
		$wygiecie_innego_alu_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_alu_wartosc'];
		$okna[$ilosc_pozycji]=$wynik['okna'];
		$drzwi_wewnetrzne[$ilosc_pozycji]=$wynik['drzwi_wewnetrzne'];
		$drzwi_zewnetrzne[$ilosc_pozycji]=$wynik['drzwi_zewnetrzne'];
		$bramy[$ilosc_pozycji]=$wynik['bramy'];
		$parapety[$ilosc_pozycji]=$wynik['parapety'];
		$rolety_zewnetrzne[$ilosc_pozycji]=$wynik['rolety_zewnetrzne'];
		$rolety_wewnetrzne[$ilosc_pozycji]=$wynik['rolety_wewnetrzne'];
		$moskitiery[$ilosc_pozycji]=$wynik['moskitiery'];
		$montaz[$ilosc_pozycji]=$wynik['montaz'];
		$odpady_pvc[$ilosc_pozycji]=$wynik['odpady_pvc'];
		$odpady_alu_stal[$ilosc_pozycji]=$wynik['odpady_alu_stal'];
		$inne[$ilosc_pozycji]=$wynik['inne'];

		// tylko do pierwszej pozycji
		if($ilosc_pozycji == 1)
		{
			$termin_realizacji=$wynik['termin_realizacji'];
			$sposob_dostawy=$wynik['sposob_dostawy_wycena_wstepna'];
			$wycena_wstepna_podsumowanie_uwagi1=$wynik['ww_podsumowanie_uwagi1'];
			$wycena_wstepna_podsumowanie_uwagi2=$wynik['ww_podsumowanie_uwagi2'];
			$wycena_wstepna_podsumowanie_uwagi_reczne=$wynik['ww_podsumowanie_uwagi_reczne'];
		}
	
		}
	

	
	echo '<table width="1000px" align="center" border="0" cellpadding="3" bgcolor="white"><tr><td width="100%" align="center" valign="top">';
	if($zamowienie_id == '') echo '<div class="text_duzy" align="center">Edycja wyceny wstępnej</div></td></tr>';
	else echo '<div class="text_duzy_czerwony" align="center">Edycja wyceny wstępnej niemożliwa - przyjęte zamówienie nr '.$nr_zamowienia.'.</div></td></tr>';
		
	echo '<tr><td width="100%" align="center" valign="top">';
	echo '<FORM action="index.php?page=wycena_wstepna_edycja" method="post">';
	echo '<INPUT type="hidden" name="klient_id" value="'.$klient_id.'">';
	echo '<INPUT type="hidden" name="wycena_id" value="'.$wycena_id.'">';
	echo '<INPUT type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
	echo '<INPUT type="hidden" name="ilosc_pozycji" value="'.$ilosc_pozycji.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	$transport2 = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'TAK';");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		$transport2=$wynik2['transport'];
	
	echo '<table width="100%" align="center" border="0" bordercolor="red" cellpadding="5" cellspacing="5">';
	//komrka z danymi o wycenie
	$pytanie2 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$klient_ulica=$wynik2['ulica'];
		$klient_miasto=$wynik2['miasto'];
		$klient_kod_pocztowy=$wynik2['kod_pocztowy'];
		$klient_sposob_platnosci=$wynik2['sposob_platnosci'];
		}

	// usuwamy z uliucy klienta napis ul itp aby si nie powtarza na wydruku wyceny
	$klient_ulica = popraw_ulice($klient_ulica);


	//sprawdzamy czy istnieje wygenerowane zamówienie na podstawie wyceny wstępnej
	if($zamowienie_id == '')
		{
		// zamowienie nie wygenerowane
		$disabled = '';
		$styl_input = 'pole_input_edycja_center';
		$styl_input2 = 'pole_input_edycja';
		$link_do_pozycji = '<a href="index.php?page=wycena_edycja&jak='.$jak.'&wg_czego='.$wg_czego.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'"><font color="red">';
		$link_do_pozycji2 = '</font></a>';
		}
	else
		{
		//zamowienie przyjete
		$disabled = ' disabled="disabled"';
		$styl_input = 'pole_input_szare_bez_ramki_center';
		$styl_input2 = 'pole_input_szare_bez_ramki_left';
		$link_do_pozycji = '';
		$link_do_pozycji2 = '';
		}

	echo '<tr><td width="60%" align="left" valign="top">';
		echo '<table width="100%" align="center" border="0" cellpadding="2" cellspacing="2" class="text_duzy">';
		echo '<tr valign="middle"><td width="100%" align="left" valign="top">Klient : '.$klient_nazwa.'</td></tr>';
		//szukamy email klienta
		$klient = $klient_id;
		$klient_email = [];
		include("php/lista_emaili_wycena.php");

		echo '<tr valign="middle"><td width="100%" align="left" valign="top">email : ';
			echo '<select name="email" class="pole_input" style="width: 50%" '.$disabled.'>';
			for ($k=1; $k<=$ilosc_email; $k++) 
			if($klient_email[$k] == $email)  echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			elseif($klient_email[$k] == $linia_rozdzielajaca) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
			else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			echo '</select>';
		echo '</td></tr>';
		
		echo '<tr><td width="100%" align="left" valign="top">Adres :  ul. '.$klient_ulica.', '.$klient_kod_pocztowy.' '.$klient_miasto.'</td></tr>';
		echo '<tr><td width="100%" align="left" valign="top">Sposób płatności : '.$klient_sposob_platnosci.'</td></tr>';
		echo '<tr><td width="100%" align="left" valign="top">&nbsp;</td></tr>';
		echo '<tr><td width="100%" align="left" valign="top">Nr wyceny : '.$wycena_wstepna_nr.'</td></tr>';
		$data_wyceny = date('d-m-Y', $data_wyceny);
		echo '<tr><td width="100%" align="left" valign="top">Data sporządzenia wyceny : '.$data_wyceny.'</td></tr>';
		echo '<tr><td width="100%" align="left" valign="top">Data ważności : '.$data_waznosci.'</td></tr>';
		echo '</table>';
	echo '</td>';
	
	// komorka z logo i danymi Arcus   
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
	
	
	// ######################################################## szukam wszystkich rysunkow w katalogu ########################################################
	$ilosc_rysunkow = 0;
	$rysunek_id = [];
	$rysunek_opis = [];
	$link_rysunek = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY kolejnosc ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_rysunkow++;
		$rysunek_id[$ilosc_rysunkow]=$wynik['id'];
		$rysunek_opis[$ilosc_rysunkow]=$wynik['opis'];
		$link_rysunek[$rysunek_id[$ilosc_rysunkow]]=$wynik['link'];
		}
	//############################################################### koniec szukam wszystkich rysunkow w katalogu  ################################################################

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
		echo '<tr class="text2" bgcolor="'.$kolor_bialy.'"><td width="10%" align="center" bgcolor="'.$kolor_szary.'">'.$link_do_pozycji.'Pozycja '.$x.'/'.$ilosc_pozycji.''.$link_do_pozycji.'</td>';
		echo '<td width="25%" align="center">'.$produkt[$x].'</td>';
		
		$nazwa_wartosc1 = 'nazwa_wartosc1['.$x.']';	
		$nazwa_kolor = 'nazwa_kolor['.$x.']';	
		echo '<td width="10%" align="left"><input autocomplete="off" type="text" size="13" maxlength="20" class="'.$styl_input.'" '.$disabled.' name="'.$nazwa_wartosc1.'" value="'.$wartosc1[$x].'";"></td>';
		echo '<td width="20%" align="left">';
			echo '<select name="'.$nazwa_kolor.'" class="'.$styl_input.'" '.$disabled.' style="width: 100%">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_kolorow; $k++) if($kolor[$x] == $kolor_profili[$k]) echo '<option selected="selected" value="'.$kolor_profili[$k].'">'.$kolor_profili[$k].'</option>';
			else echo '<option value="'.$kolor_profili[$k].'">'.$kolor_profili[$k].'</option>';
			echo '</select>';
		echo '</td>';
		$nazwa_wartosc2 = 'nazwa_wartosc2['.$x.']';	
		echo '<td width="25%" align="left"><input autocomplete="off" type="text" size="46" maxlength="60" class="'.$styl_input.'" '.$disabled.' name="'.$nazwa_wartosc2.'" value="'.$wartosc2[$x].'";"></td>';
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
				{
				$wycena_podstawowa[$x] += $oscieznica_wartosc[$x];
				}
			if($skrzydlo_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $skrzydlo_wartosc[$x];
				}
			if($listwa_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $listwa_wartosc[$x];
				}
			if($wzmocnienie_ramy_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $wzmocnienie_ramy_wartosc[$x];
				}
			if($wzmocnienie_skrzydla_wartosc[$x] != 0) 
				{
				$wycena_podstawowa[$x] += $wzmocnienie_skrzydla_wartosc[$x];
				}

			
			$SUMA_WYCENA_PODSTAWOWA += $wycena_podstawowa[$x];
			$wycena_podstawowa[$x] = number_format($wycena_podstawowa[$x], 2,'.',' ');
			echo '<table width="100%" align="center" class="text2" border="0">';
			echo '<tr height="250px" valign="top"><td align="center" width="30%"><b>Wycena podstawowa : </b>'.$wycena_podstawowa[$x].$waluta;
			echo '<hr width="100%">';
				//opisy 
				echo '<table width="100%" align="left" class="text2" border="0"><tr><td><b>Uwzględniono :</b></td></tr>';
				echo '<tr align="left" class="text2"><td>';
				echo $opisy_wycena_podstawowa[$x];
				
				//select z Materiałem
				$wycena_podstawowa_material = 'wycena_podstawowa_material['.$x.']';	
				echo '<br><select name="'.$wycena_podstawowa_material.'" class="'.$styl_input2.'";"'.$disabled.'" style="width: 80%" >';
				echo '<option></option>';
				if($wycena_podstawowa_material_baza[$x] == 'Materiał Arcus') echo '<option selected="selected" value="Materiał Arcus">Materiał Arcus</option>'; else  echo '<option value="Materiał Arcus">Materiał Arcus</option>'; 
				if($wycena_podstawowa_material_baza[$x] == 'Materiał klienta') echo '<option selected="selected" value="Materiał klienta">Materiał klienta</option>'; else  echo '<option value="Materiał klienta">Materiał klienta</option>'; 
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
					$input_wygiecie_innego_pvc = 1;
					}
				if($wygiecie_innego_ze_stali_wartosc[$x] != 0) 
					{
					$wartosc_dodatki[$x] += $wygiecie_innego_ze_stali_wartosc[$x];
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
			if($slupek_wartosc[$x] != 0) $wartosc_dodatki[$x] += $slupek_wartosc[$x];
			if($wzmocnienie_slupka_wartosc[$x] != 0) $wartosc_dodatki[$x] += $wzmocnienie_slupka_wartosc[$x];
			if($wzmocnienie_luku_wartosc[$x] != 0) $wartosc_dodatki[$x] += $wzmocnienie_luku_wartosc[$x];
			if($okucia_wartosc[$x] != 0) $wartosc_dodatki[$x] += $okucia_wartosc[$x];
			if($szyby_wartosc[$x] != 0) $wartosc_dodatki[$x] += $szyby_wartosc[$x];
			if($inny_element_wartosc[$x] != 0) $wartosc_dodatki[$x] += $inny_element_wartosc[$x];
				
			// dodajemy całą resztę kolumn z wyceny do dodatkw: 16 kolumn BEZ TRANSPORTU
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
				if($wygiecie_innego_pvc_opis[$x] != '') $wartosc_wygiecie_innego_pvc_opis = $wygiecie_innego_pvc_opis[$x]; else $wartosc_wygiecie_innego_pvc_opis = 'Wygięcie innego elementu z pvc';
				if($wygiecie_innego_ze_stali_opis[$x] != '') $wartosc_wygiecie_innego_ze_stali_opis = $wygiecie_innego_ze_stali_opis[$x]; else $wartosc_wygiecie_innego_ze_stali_opis = 'Wygięcie innego elementu ze stali';
				if($input_wygiecie_innego_pvc == 1) echo '<br>- <input autocomplete="off" type="text" size="35" maxlength="80" class="'.$styl_input2.'" '.$disabled.' name="'.$nazwa_input_wygiecie_innego_pvc.'" value="'.$wartosc_wygiecie_innego_pvc_opis.'">';
				if($input_wygiecie_innego_ze_stali == 1) echo '<br>- <input autocomplete="off" type="text" size="35" maxlength="80" class="'.$styl_input2.'" '.$disabled.' name="'.$nazwa_input_wygiecie_innego_ze_stali.'" value="'.$wartosc_wygiecie_innego_ze_stali_opis.'">';
				echo $opisy_dodatki[$x];
				
				//select z Materiałem
				$dodatki_material = 'dodatki_material['.$x.']';	
				echo '<br><select name="'.$dodatki_material.'" class="'.$styl_input2.'";"'.$disabled.'" style="width: 80%" >';
				echo '<option></option>';
				if($dodatki_material_baza[$x] == 'Materiał Arcus') echo '<option selected="selected" value="Materiał Arcus">Materiał Arcus</option>'; else  echo '<option value="Materiał Arcus">Materiał Arcus</option>'; 
				if($dodatki_material_baza[$x] == 'Materiał klienta') echo '<option selected="selected" value="Materiał klienta">Materiał klienta</option>'; else  echo '<option value="Materiał klienta">Materiał klienta</option>'; 
				echo '</select>';
				echo '</td></tr></table>';
			
			echo '</td>';
			echo '<td width="5%"></td>';
	
			// ############################################# rysunek pogldowy ########################################################################################################################
			echo '<td align="center" width="30%"><b>Rysunek poglądowy</b>';
			echo '<hr width="100%">';
			
				$ww_rysunek = 'ww_rysunek['.$x.']';	
				echo '<select name="'.$ww_rysunek.'" class="'.$styl_input2.'";"'.$disabled.'" style="width: 80%" onchange="submit();">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_rysunkow; $k++) if($rysunek[$x] == $rysunek_id[$k]) echo '<option value="'.$rysunek_id[$k].'" selected="selected">'.$rysunek_opis[$k].'</option>';
				else echo '<option value="'.$rysunek_id[$k].'">'.$rysunek_opis[$k].'</option>';
				echo '</select>';
				
				if($disabled == '')
					{
					if($rysunek[$x] != '') echo '<br><br><center><a href="index.php?page=wycena_wstepna_wybierz_rysunek&skad=wycena_wstepna_edycja&wycena_wstepna_nr='.$wycena_wstepna_nr.'&rysunek_dla_pozycji='.$x.'&jak=ASC&wg_czego=kolejnosc"><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$link_rysunek[$rysunek[$x]].'" width="270px"></a></center>';
					else echo '<a href="index.php?page=wycena_wstepna_wybierz_rysunek&skad=wycena_wstepna_edycja&wycena_wstepna_nr='.$wycena_wstepna_nr.'&rysunek_dla_pozycji='.$x.'&jak=ASC&wg_czego=kolejnosc">'.$image_rysunek.'</a>';
					}
				else
					{
					if($rysunek[$x] != '') echo '<br><br><center><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$link_rysunek[$rysunek[$x]].'" width="270px"></center>';
					else echo $image_rysunek;
					}

					
			echo '</td></tr></table>';
			// ############################################# KONIEC rysunek pogldowy ########################################################################################################################
			
			$cellpadding = 1;
			$cellspacing = 1;
	
			//uwagi pozycja
			echo '<table width="100%" align="center" class="text2" border="0">';
			echo '<tr><td><hr width="100%"></td></tr>';
			echo '<tr><td align="center" width="100%">';
			
				//TABELA UWAGI dla pozycji
				echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
				echo '<tr><td align="center" width="90px"><b>Uwagi : </b></td>';
				echo '<td width="90%">';
					echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
					echo '<tr><td width="100%">';
						// uwagi 1  pozycja 
						$ilosc_uwaga_1 = 0;
						$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
						while($wynik91= mysqli_fetch_assoc($pytanie91))
							{
							$ilosc_uwaga_1++;
							$uwaga_1_opis[$ilosc_uwaga_1] = $wynik91['opis'];
							}
						$ww_pozycja_uwagi1 = 'ww_pozycja_uwagi1['.$x.']';	
						echo '<select name="'.$ww_pozycja_uwagi1.'" class="'.$styl_input2.'"  "'.$disabled.'" style="width: 80%" >';
						echo '<option></option>';
						for ($k=1; $k<=$ilosc_uwaga_1; $k++) if($uwaga_1_opis[$k] == $wycena_wstepna_pozycja_uwagi1[$x]) echo '<option selected="selected" value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
						else echo '<option value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
						echo '</select>';
					echo '</td></tr><tr><td>';
						// uwagi 2 pozycja 
						$ilosc_uwaga_2 = 0;
						$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
						while($wynik91= mysqli_fetch_assoc($pytanie91))
							{
							$ilosc_uwaga_2++;
							$uwaga_2_opis[$ilosc_uwaga_2] = $wynik91['opis'];
							}
						$ww_pozycja_uwagi2 = 'ww_pozycja_uwagi2['.$x.']';	
						echo '<select name="'.$ww_pozycja_uwagi2.'" class="'.$styl_input2.'"  "'.$disabled.'" style="width: 80%">';
						echo '<option></option>';
						for ($k=1; $k<=$ilosc_uwaga_2; $k++) if($uwaga_2_opis[$k] == $wycena_wstepna_pozycja_uwagi2[$x]) echo '<option selected="selected" value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
						else echo '<option value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
						echo '</select>';
					echo '</td></tr><tr><td>';
						//uwagi rczne
						$ww_pozycja_uwagi_reczne = 'ww_pozycja_uwagi_reczne['.$x.']';	
						echo '<textarea name="'.$ww_pozycja_uwagi_reczne.'" cols="102" rows="2" class="'.$styl_input2.'">'.$wycena_wstepna_pozycja_uwagi_reczne[$x].'</textarea>';
					echo '</td></tr>';
					echo '</table>';
					
					
				echo '</td></tr>';
				echo '</table>';
				// KONIEC tabela uwagi dla pozycji
			echo '</td></tr></table>';
		echo '</td></tr>';
		echo '</table>';
		}
		
		
		// $cellpadding = 1;
		// $cellspacing = 1;
		echo '<table name="podsumowanie1" width="100%" align="center" class="tabela" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
		echo '<tr class="text"><td width="100%" align="center" bgcolor="'.$kolor_szary.'">Podsumowanie</td></tr>';
		echo '<tr class="text2" bgcolor="'.$kolor_bialy.'" valign="top"><td width="100%" align="center">';
			echo '<table name="podsumowanie3" border="0" width="100%" align="center" class="text2" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'"><tr valign="top"><td width="35%">';
			
				echo '<table name="podsumowanie2" width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
				$SUMA = $SUMA_WYCENA_PODSTAWOWA+$SUMA_DODATKI+$transport2;

				echo '<INPUT type="hidden" name="SUMA" value="'.$SUMA.'">';

				// $SUMA_WYCENA_PODSTAWOWA = number_format($SUMA_WYCENA_PODSTAWOWA, 2,'.',' ');
				// $SUMA_DODATKI = number_format($SUMA_DODATKI, 2,'.',' ');
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
			
				echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
				echo '<tr><td align="left" width="100%">';
					//TABELA termin i sposb
					echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
					echo '<tr><td align="left" width="110px"><b>Termin realizacji : </b></td><td>';
						echo '<select name="termin_realizacji" class="'.$styl_input2.'" '.$disabled.' style="width: 50%">';
						for ($k=1; $k<=$ilosc_terminow; $k++) if($termin_realizacji == $opis_termin[$k]) echo '<option selected="selected" value="'.$opis_termin[$k].'">'.$opis_termin[$k].'</option>';
						else echo '<option value="'.$opis_termin[$k].'">'.$opis_termin[$k].'</option>';
						echo '</select>';
					echo '</td></tr>';
					echo '<tr><td align="left"><b>Sposób dostawy : </b></td><td>';
						echo '<select name="sposob_dostawy" class="'.$styl_input2.'" '.$disabled.' style="width: 50%">';
						for ($k=1; $k<=$ilosc_sposobow; $k++) if($sposob_dostawy == $opis_sposob_dostawy[$k]) echo '<option selected="selected" value="'.$opis_sposob_dostawy[$k].'">'.$opis_sposob_dostawy[$k].'</option>';
						else echo '<option value="'.$opis_sposob_dostawy[$k].'">'.$opis_sposob_dostawy[$k].'</option>';
						echo '</select>';
					echo '</td></tr></table>';
					// KONIEC termin i sposb
				echo '</td></tr>';
				echo '<tr><td align="left" valign="top">';


					//TABELA UWAGI
					echo '<table width="100%" align="center" class="text2" border="0" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">';
					echo '<tr><td align="left" width="110px"><b>Uwagi : </b></td><td>Wszystkie kwoty netto</td></tr>';
					for($x=1; $x<=$ilosc_pozycji; $x++) if(isset($uwagi[$x])) echo '<tr><td align="left">&nbsp;</td><td>'.$uwagi[$x].'</td></tr>';
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
					echo '<select name="uwaga_1" class="'.$styl_input2.'"  "'.$disabled.'" style="width: 100%">';
					echo '<option></option>';
					for ($k=1; $k<=$ilosc_uwaga_1; $k++) 
					if($wycena_wstepna_podsumowanie_uwagi1 == $uwaga_1_opis[$k]) echo '<option selected="selected" value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
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
					echo '<select name="uwaga_2" class="'.$styl_input2.'"  "'.$disabled.'" style="width: 100%" >';
					echo '<option></option>';
					for ($k=1; $k<=$ilosc_uwaga_2; $k++) 
					if($wycena_wstepna_podsumowanie_uwagi2 == $uwaga_2_opis[$k]) echo '<option selected="selected" value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
					else echo '<option value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
					echo '</select></td></tr>';
				
					//uwagi rczne
					echo '<tr align="center" class="text"><td></td><td align="left">';
					echo '<textarea name="uwagi_reczne" cols="83" rows="2" class="'.$styl_input2.'";"'.$disabled.'">'.$wycena_wstepna_podsumowanie_uwagi_reczne.'</textarea></td></tr>';
					echo '</table>';
					// KONIEC TABELA UWAGI
				echo '</td></tr></table>'; // do name="podsumowanie2"
			
			
			echo '</td></tr>';
			if($user_id_wycena != '')
				{
				//PODSUMOWANIE SPORZądził
				$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id_wycena.";");
				while($wynik2= mysqli_fetch_assoc($pytanie2))
					{
					$imie=$wynik2['imie'];
					$nazwisko=$wynik2['nazwisko'];
					$telefon=$wynik2['telefon'];
					$user_email=$wynik2['email'];
					}
				if($telefon != '') $telefon = ' | '.$telefon;
				if($user_email != '') $user_email = ' | '.$user_email;
				echo '<tr><td><b>Sporządził : </b><br>'.$imie.' '.$nazwisko.$telefon.$user_email.'</td></tr>';
				}
			elseif($wycena_wstepna_dodal_klient_id != '') echo '<tr><td class="text2"><b>Sporządził : </b>Klient</td></tr>';
				
			echo '</table>'; // do name="podsumowanie3"
		echo '</td></tr></table>'; // do name="podsumowanie1"
		
	echo '</td></tr>';
	
	if($zamowienie_id == '')
		{
		//checkbox od kopii wyceny jako nowej
		echo '<tr><td class="text_blue" align="center">Zaznacz, aby stworzyć kopię wyceny z nowym numerem&nbsp;<input type="checkbox" name="kopia_wyceny"></td></tr>';

		echo '<tr align="center"><td><br>';
		echo '<INPUT type="submit" name="zapisz" value="Zapisz">';
		echo $tabulator;
		//echo '<a href="index.php?page=wyceny_wstepne&wg_czego='.$wg_czego.'&jak='.$jak.'&wycena_wstepna_wysylka='.$wycena_wstepna_nr.'&klient='.$klient_id.'&wyslij=TAK"><INPUT type="button" name="wyslij" value="Wyślij - bez zapisu"></a>';
		//echo $tabulator;
		echo '<a href="index.php?page=wyceny_wstepne&wg_czego=id&jak=DESC"><INPUT type="button" name="powrot_rejestr" value="Powrót - Rejestr wycen"></a>';
		echo $tabulator;
		echo '<a href="index.php?page=wycena_wstepna_edycja&wg_czego='.$wg_czego.'&jak='.$jak.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&klient='.$klient_id.'&usun_wycene='.$wycena_wstepna_nr.'"><INPUT type="button" name="usun" value="Usuń"></a>';
		echo $tabulator;
		echo '<a href="index.php?page=ustawienia_wyceny_wstepne&wycena_wstepna_nr='.$wycena_wstepna_nr.'&wg_czego='.$wg_czego.'&jak='.$jak.'"><INPUT type="button" name="Ustawienia" value="Ustawienia"></a>';
		if($link_wycena_pdf != '')
			{
			echo $tabulator;
			echo '<a href="index.php?page=zamowienie_wycena&jak=DESC&wg_czego=id&wycena_wstepna_nr='.$wycena_wstepna_nr.'&klient='.$klient_id.'"><INPUT type="button" name="przyjmij_zamowienie" value="Przyjmij zamówienie"></a>';
			}
		echo '</td></tr>';
		}
	
	echo '</table>'; //tabela glowna
	echo '</FORM>';
	}
	if($zamowienie_id != '') echo $powrot_do_wycen_wstepnych;
?>