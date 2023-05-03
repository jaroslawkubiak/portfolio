<?php
$nr_zamowienia = dodaj_zamowienie($conn, $klient, $typ_zamowienia, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $bez_potwierdzenia, $rodzaj, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy);

// bo za chwile zerujemy tablice status w deklaracji tablic dla wyceny, a potem update statusu byl pusty
$kopia_status = $status;


//szukamy id zamowienia
$pytanie3 = mysqli_query($conn, "SELECT id FROM zamowienia WHERE nr_zamowienia='".$nr_zamowienia."'");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	$zamowienie_id=$wynik3['id'];
	
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

include("php/wyceny_deklaracja_pustych_tablic.php");

$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' ORDER BY pozycja ASC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_pozycji++;
	$pozycja[$ilosc_pozycji]=$wynik['pozycja'];
	$pozycja_transport[$ilosc_pozycji]=$wynik['pozycja_transport'];

	$wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_ilosc_szt'];
	$wygiecie_ramy_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_ilosc_m'];
	$wygiecie_ramy_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_cena'];
	$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_wartosc'];
	$wygiecie_ramy_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_ramy_pvc_cena[$ilosc_pozycji], 2,'.','');
	$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_ramy_pvc_wartosc[$ilosc_pozycji], 2,'.','');
	
	$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_ilosc_szt'];
	$wygiecie_skrzydla_pvc_ilosc_m[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_ilosc_m'];
	$wygiecie_skrzydla_pvc_cena[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_cena'];
	$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_wartosc'];
	$wygiecie_skrzydla_pvc_cena[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_cena[$ilosc_pozycji], 2,'.','');
	$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji] = number_format($wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji], 2,'.','');

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
	
	$wartosc_brutto[$ilosc_pozycji]=$wynik['wartosc_brutto'];
	$wartosc_brutto[$ilosc_pozycji] = number_format($wartosc_brutto[$ilosc_pozycji], 2,'.','');
	$SUMA_BRUTTO += $wartosc_brutto[$ilosc_pozycji];
	//$uwagi_wycena[$ilosc_pozycji]=$wynik['uwagi'];
	}

for($i = 1; $i <= $ilosc_pozycji; $i++)
	{
	// sumowanie łuków itp do tabeli zamówienia
	$SUMA_sztuki += $ilosc_sztuk[$i];
	$SUMA_zgrzewy += $zgrzanie_ilosc[$i];
	$SUMA_luki_pvc = $SUMA_luki_pvc + $wygiecie_ramy_pvc_ilosc_szt[$i] + $wygiecie_skrzydla_pvc_ilosc_szt[$i] + $wygiecie_innego_pvc_ilosc_szt[$i];
	$SUMA_luki_stal = $SUMA_luki_stal + $wygiecie_wzmocnienia_okiennego_ilosc_szt[$i] + $wygiecie_innego_elementu_ze_stali_ilosc_szt[$i];
	$SUMA_okuwanie += $okucie_ilosc[$i];
	$SUMA_szklenie += $zaszklenie_ilosc[$i];
	$SUMA_slupki += $wstawienie_slupka_ilosc[$i];
	$SUMA_dociecie_listwy += $listwa_przyszybowa_ilosc[$i];
	$SUMA_odwodnienia += $wyfrezowanie_odwodnienia_ilosc[$i];
	$SUMA_luki_alu = $SUMA_luki_alu + $wygiecie_ramy_alu_ilosc_szt[$i] + $wygiecie_skrzydla_alu_ilosc_szt[$i] + $wygiecie_innego_alu_ilosc_szt[$i];
	$SUMA_slupki_ruchome += $wstawienie_slupka_ruchomego_ilosc[$i];
	$SUMA_dociecie_kompletu_listew_przyszybowych += $dociecie_kompletu_listew_przyszybowych_ilosc[$i];

	$SUMA_wartosc_netto += $wartosc_netto[$i];
	$SUMA_wartosc_brutto += $wartosc_brutto[$i];
	}

//uzupelniamy dane zamowienia
$SUMA_wartosc_netto = change($SUMA_wartosc_netto);
$SUMA_wartosc_brutto = change($SUMA_wartosc_brutto);

$SQL = [];
//tresc zapytan
$SQL[1] = "UPDATE zamowienia SET sztuki = ".$SUMA_sztuki." WHERE id = ".$zamowienie_id.";";
$SQL[2] = "UPDATE zamowienia SET luki_pvc = ".$SUMA_luki_pvc." WHERE id = ".$zamowienie_id.";";
$SQL[3] = "UPDATE zamowienia SET luki_stal = ".$SUMA_luki_stal." WHERE id = ".$zamowienie_id.";";
$SQL[4] = "UPDATE zamowienia SET luki_alu = ".$SUMA_luki_alu." WHERE id = ".$zamowienie_id.";";
$SQL[5] = "UPDATE zamowienia SET zgrzewy = ".$SUMA_zgrzewy." WHERE id = ".$zamowienie_id.";";
$SQL[6] = "UPDATE zamowienia SET odwodnienia = ".$SUMA_odwodnienia." WHERE id = ".$zamowienie_id.";";
$SQL[7] = "UPDATE zamowienia SET slupki = ".$SUMA_slupki." WHERE id = ".$zamowienie_id.";";
$SQL[8] = "UPDATE zamowienia SET okuwanie = ".$SUMA_okuwanie." WHERE id = ".$zamowienie_id.";";
$SQL[9] = "UPDATE zamowienia SET szklenie = ".$SUMA_szklenie." WHERE id = ".$zamowienie_id.";";
$SQL[10] = "UPDATE zamowienia SET slupek_ruchomy = ".$SUMA_slupki_ruchome." WHERE id = ".$zamowienie_id.";";
$SQL[11] = "UPDATE zamowienia SET dociecie_listwy = ".$SUMA_dociecie_listwy." WHERE id = ".$zamowienie_id.";";
$SQL[12] = "UPDATE zamowienia SET komplet_listew = ".$SUMA_dociecie_kompletu_listew_przyszybowych." WHERE id = ".$zamowienie_id.";";
$SQL[13] = "UPDATE zamowienia SET wartosc_netto = ".$SUMA_wartosc_netto." WHERE id = ".$zamowienie_id.";";
$SQL[14] = "UPDATE zamowienia SET wartosc_brutto = ".$SUMA_wartosc_brutto." WHERE id = ".$zamowienie_id.";";
$SQL[15] = "UPDATE zamowienia SET status = '".$kopia_status."' WHERE id = ".$zamowienie_id.";";


//wykonanie zapytan
for($s=1; $s<=15; $s++) mysqli_query($conn, $SQL[$s]);



//zmieniamy dane w wycenie wstepnaj
$modyfikuj = mysqli_query($conn, "UPDATE wyceny SET zamowienie_id=".$zamowienie_id." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient.";");
$modyfikuj = mysqli_query($conn, "UPDATE wyceny SET nr_zamowienia='".$nr_zamowienia."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient.";");
$modyfikuj = mysqli_query($conn, "UPDATE wyceny SET status = '".$kopia_status."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient.";");

?>