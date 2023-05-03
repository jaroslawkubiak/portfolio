<!DOCTYPE HTML>
<html lang="pl">
<html>
	<head>
	<meta http-equiv = "Content-Type" content = "text/html">
	<meta charset = "UTF-8" />
	<meta name="Author" content="Arcus" />
	<meta name="Language" content="pl" />
	<meta http-equiv="Content-Type" content="text/html" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<META HTTP-EQUIV="Content-Language" CONTENT="pl" />

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="shortcut icon" href="images/arcus-logo.jpg">
	<link rel="bookmark icon" href="images/arcus-logo.jpg">
	<title>Wycena</title>
	<style type="text/css">
	body 
		{
		background-image:url(images/tlo.jpg);
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position:center top;
		}
	</style>
	</head>
<body>
<?php
include("../../php/_session.php");
include("../../php/_connection.php");
include("../../php/_functions.php");
include("../../php/_variables.php");
include("../../php/wyceny_deklaracja_pustych_tablic.php");
include("../../style.css");

	$SUMA_NETTO = 0;
	$SUMA_BRUTTO = 0;
	$ilosc_pozycji = 0;
	
	$zamowienie_id = $_REQUEST['zamowienie_id'];
	$wycena_wstepna = $_REQUEST['wycena_wstepna'];
	
	//wycena_wstepna_nr
	if($wycena_wstepna != '') $pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna."' ORDER BY pozycja ASC;");
	else $pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' ORDER BY pozycja ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pozycji++;
		$klient_id=$wynik['klient_id'];
		$klient_nazwa=$wynik['klient_nazwa'];
		$nr_zamowienia=$wynik['nr_zamowienia'];
		$pozycja[$ilosc_pozycji]=$wynik['pozycja'];
		$pozycja_id[$ilosc_pozycji]=$wynik['id'];
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
		$stopien_trudnosci[$ilosc_pozycji]=$wynik['stopien_trudnosci'];

		$nazwa_produktu[$ilosc_pozycji]=$wynik['nazwa_produktu'];
		$cena_netto_za_sztuke[$ilosc_pozycji]=$wynik['cena_netto_za_sztuke'];
		$cena_netto_za_sztuke[$ilosc_pozycji] = number_format($cena_netto_za_sztuke[$ilosc_pozycji], 2,'.','');
		
		$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
		$wartosc_netto[$ilosc_pozycji]=$wynik['wartosc_netto'];
		$SUMA_NETTO += $wartosc_netto[$ilosc_pozycji];
		$wartosc_netto[$ilosc_pozycji] = number_format($wartosc_netto[$ilosc_pozycji], 2,'.',' ');
		$vat_baza[$ilosc_pozycji]=$wynik['vat'];
		
		$SUMA_BRUTTO += $wynik['wartosc_brutto'];
		$wartosc_brutto[$ilosc_pozycji] = number_format($wynik['wartosc_brutto'], 2,'.',' ');
		$nr_faktury[$ilosc_pozycji]=$wynik['nr_faktury'];
		$data_faktury[$ilosc_pozycji]=$wynik['data_faktury'];
		
		$uwagi[$ilosc_pozycji]=$wynik['uwagi'];
		}
				
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
		
	
		
	
echo '<table border="0" width="100%" cellspacing="9"><tr><td>'; //tabela ktra trzyma 4 poziomy

	echo '<table border="0" valign="top" align="left" width="100%"><tr class="text_duzy">';
	echo '<td width="100%" align="center">Wycena : <font color="blue">'.$nr_zamowienia.'</font> dla klienta <font color="blue">'.$klient_nazwa.'</font></td>';
	echo '</tr></table><br>';	


echo '</td></tr><tr><td>';

//##############################################################################################################      TABELA - POZIOM 1             ##########################################################################################################################################
	
	$szer_ilosc = '60px';
	$szer_cena = '70px';
	$szer_wartosc = '85px';
	$szer_rozne = '80px';
	$szerokosc_pola_input_ilosc = '40px';
	$szerokosc_pola_input_cena = '50px';
	$szerokosc_pola_input_wartosc = '50px';
	$szer_inne_wartosc = '100px';
	$szerokosc_tabeli = '2000px';
	$disabled = " disabled"; 
	
	if($pozycja_transport[$ilosc_pozycji] == 'tak') $temp_ilosc_pozycji = $ilosc_pozycji - 1; else $temp_ilosc_pozycji = $ilosc_pozycji; // pozycja musi by o jeden mniej bo nie dziala java i liczenie wartosci 
	//$temp_ilosc_pozycji = $ilosc_pozycji;



	echo '<table valign="top" align="left" width="'.$szerokosc_tabeli.'" border="1" cellspacing="1" cellpadding="2" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	
	// ################################## POZIOM 1 ##################################
	echo '<tr class="text" align="center" bgcolor="'.$kolor_ciemno_szary.'">';
	echo '<td rowspan="3" height="80px">Pozycja</td>';
	echo '<td colspan="16" width="200px">Łuki z pvc</td>';
	echo '<td colspan="16">Łuki z aluminium</td>';
	echo '</tr>';
	
	// ################################## POZIOM 2 ##################################
	// Łuki z pvc
	echo '<tr bgcolor="'.$kolor_ciemno_szary.'" align="center">';
	echo '<td colspan="4">Wygięcie ramy z pvc</td>';
	echo '<td colspan="4">Wygięcie skrzydła z pvc</td>';
	echo '<td colspan="4">Wygięcie listwy z pvc</td>';
	echo '<td colspan="4">Wygięcie innego elementu z pvc</td>';
	// Łuki z alu
	echo '<td colspan="4">Wygięcie ramy z alu</td>';
	echo '<td colspan="4">Wygięcie skrzydła z alu</td>';
	echo '<td colspan="4">Wygięcie listwy z alu</td>';
	echo '<td colspan="4">Wygięcie innego elementu z alu</td>';
	echo '</tr>';
	
	// ################################## POZIOM 3 ##################################
	// Łuki z pvc
	echo '<tr bgcolor="'.$kolor_ciemno_szary.'" align="center">';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	
	// Łuki z alu
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '</tr>';
	
//sprawdzamy czy istnieje pozycja transportowa - jeli tak zmiejszamy ilosc pozycji o 1
if($pozycja_transport[$ilosc_pozycji] == 'tak') $ilosc_pozycji--;

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{

	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		$styl = "pole_input_biale_right_bez_ramki"; 
		}
	else 
		{
		$wiersz = $kolor_jasno_szary;
		$styl = "pole_input_szare_right_bez_ramki"; 
		}

	$wyrownanie = 'right';
	echo '<tr bgcolor="'.$wiersz.'" align="left"><td bgcolor="'.$kolor_ciemno_szary.'" align="center">'.$x.'/'.$ilosc_pozycji.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_pvc_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_pvc_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_pvc_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_pvc_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_pvc_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_pvc_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_pvc_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_pvc_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_pvc_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_pvc_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_pvc_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_pvc_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_alu_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_alu_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_alu_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_ramy_alu_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_alu_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_alu_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_alu_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_skrzydla_alu_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_alu_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_alu_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_alu_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_listwy_alu_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_alu_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_alu_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_alu_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_alu_wartosc[$x].$waluta.'</td>';
	echo '</tr>';
	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)
	
echo '</table>'; // koniec tabeli gwnej


echo '</td></tr><tr><td>';



//###################################################################################################################################################################################
//##############################################################################################################      TABELA - POZIOM 2             ##########################################
//################################################################################################################################################################################

	echo '<table valign="top" align="left" width="'.$szerokosc_tabeli.'" border="1" cellspacing="1" cellpadding="2" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	
	// ################################## POZIOM 1 ##################################
	echo '<tr class="text" align="center" bgcolor="'.$kolor_ciemno_szary.'">';
	echo '<td rowspan="3" height="80px">Pozycja</td>';
	echo '<td colspan="8">Łuki ze stali</td>';
	echo '<td colspan="27">Konstrukcje okienne z pvc</td>';
	echo '</tr>';
	
	// ################################## POZIOM 2 ##################################
	echo '<tr bgcolor="'.$kolor_ciemno_szary.'" align="center">';
	echo '<td colspan="4">Wygięcie wzmocnienia okiennego</td>';
	echo '<td colspan="4">Wygięcie innego elementu ze stali</td>';
	echo '<td colspan="3">Zgrzanie</td>';
	echo '<td colspan="3">Wyfrezowanie odwodnienia</td>';

	echo '<td colspan="3">Wstawienie słupka stałego</td>';
	echo '<td colspan="3">Wstawienie słupka ruchomego</td>';
	echo '<td colspan="3">Docięcie listwy przyszybowej tylko łukowej</td>';
	echo '<td colspan="3">Docięcie kompletu listew przyszybowych</td>';

	echo '<td colspan="3">Okucie</td>';
	echo '<td colspan="3">Zaszklenie</td>';
	echo '<td colspan="3">Wykonanie innej uslugi</td>';
	echo '</tr>';
	
	// ################################## POZIOM 3 ##################################
	echo '<tr bgcolor="'.$kolor_ciemno_szary.'" align="center">';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '</tr>';
	
//sprawdzamy czy istnieje pozycja transportowa - jeli tak zmiejszamy ilosc pozycji o 1
if($pozycja_transport[$ilosc_pozycji] == 'tak') $ilosc_pozycji--;

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{

	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		$styl = "pole_input_biale_right_bez_ramki"; 
		}
	else 
		{
		$wiersz = $kolor_jasno_szary;
		$styl = "pole_input_szare_right_bez_ramki"; 
		}

	$wyrownanie = 'right';
	echo '<tr bgcolor="'.$wiersz.'" align="left"><td bgcolor="'.$kolor_ciemno_szary.'" align="center">'.$x.'/'.$ilosc_pozycji.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_wzmocnienia_okiennego_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_wzmocnienia_okiennego_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_wzmocnienia_okiennego_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_wzmocnienia_okiennego_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_ilosc_szt[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_ilosc_m[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wygiecie_innego_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$zgrzanie_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$zgrzanie_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$zgrzanie_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wyfrezowanie_odwodnienia_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wyfrezowanie_odwodnienia_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wyfrezowanie_odwodnienia_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wstawienie_slupka_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wstawienie_slupka_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wstawienie_slupka_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wstawienie_slupka_ruchomego_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wstawienie_slupka_ruchomego_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wstawienie_slupka_ruchomego_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$listwa_przyszybowa_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$listwa_przyszybowa_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$listwa_przyszybowa_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$dociecie_kompletu_listew_przyszybowych_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$dociecie_kompletu_listew_przyszybowych_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$dociecie_kompletu_listew_przyszybowych_wartosc[$x].$waluta.'</td>';

	echo '<td align="'.$wyrownanie.'">'.$okucie_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$okucie_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$okucie_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$zaszklenie_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$zaszklenie_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$zaszklenie_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$innej_uslugi_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$innej_uslugi_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$innej_uslugi_wartosc[$x].$waluta.'</td>';
	echo '</tr>';
	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)
	
echo '</table>'; // koniec tabeli gwnej





echo '</td></tr><tr><td>';

//############################################################################################################################################################
//##############################################################################################################      TABELA - POZIOM 3             ###########################
//#############################################################################################################################################################################

	echo '<table valign="top" align="left" width="'.$szerokosc_tabeli.'" border="1" cellspacing="1" cellpadding="2" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	
	// ################################## POZIOM 1 ##################################
	echo '<tr class="text" align="center" bgcolor="'.$kolor_ciemno_szary.'">';
	echo '<td rowspan="3" height="80px">Pozycja</td>';
	echo '<td colspan="33">Materiał</td>';
	echo '</tr>';
	
	// ################################## POZIOM 2 ##################################
	echo '<tr bgcolor="'.$kolor_ciemno_szary.'" align="center">';
	echo '<td colspan="3">Oscieżnica</td>';
	echo '<td colspan="3">Skrzydło</td>';
	echo '<td colspan="3">Listwa</td>';
	echo '<td colspan="3">Słupek</td>';
	echo '<td colspan="3">Wzmocnienie do ramy</td>';
	echo '<td colspan="3">Wzmocnienie do skrzydła</td>';
	echo '<td colspan="3">Wzmocnienie do słupka</td>';
	echo '<td colspan="3">Wzmocnienie do łu</td>';
	echo '<td colspan="3">Okucia</td>';
	echo '<td colspan="3">Szyby</td>';
	echo '<td colspan="3">Inny element</td>';
	echo '</tr>';
	
	// ################################## POZIOM 3 ##################################
	echo '<tr bgcolor="'.$kolor_ciemno_szary.'" align="center">';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szer_ilosc.'">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szer_cena.'">'.$kol_cena.'</td>';
	echo '<td width="'.$szer_wartosc.'">'.$kol_wartosc.'</td>';
	echo '</tr>';
	
//sprawdzamy czy istnieje pozycja transportowa - jeli tak zmiejszamy ilosc pozycji o 1
if($pozycja_transport[$ilosc_pozycji] == 'tak') $ilosc_pozycji--;

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{

	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		$styl = "pole_input_biale_right_bez_ramki"; 
		}
	else 
		{
		$wiersz = $kolor_jasno_szary;
		$styl = "pole_input_szare_right_bez_ramki"; 
		}

	$wyrownanie = 'right';
	echo '<tr bgcolor="'.$wiersz.'" align="left"><td bgcolor="'.$kolor_ciemno_szary.'" align="center">'.$x.'/'.$ilosc_pozycji.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$oscieznica_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$oscieznica_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$oscieznica_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$skrzydlo_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$skrzydlo_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$skrzydlo_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$listwa_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$listwa_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$listwa_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$slupek_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$slupek_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$slupek_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_ramy_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_ramy_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_ramy_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_skrzydla_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_skrzydla_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_skrzydla_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_slupka_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_slupka_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_slupka_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_luku_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_luku_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$wzmocnienie_luku_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$okucia_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$okucia_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$okucia_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$szyby_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$szyby_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$szyby_wartosc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$inny_element_ilosc[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$inny_element_cena[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$inny_element_wartosc[$x].$waluta.'</td>';
	echo '</tr>';
	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)
	
echo '</table>'; // koniec tabeli głównej




echo '</td></tr><tr><td>';

//##############################################################################################################      TABELA - POZIOM 3             #######################################################################

	echo '<table valign="top" align="left" width="'.$szerokosc_tabeli.'" border="1" cellspacing="1" cellpadding="2" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	
	// ################################## POZIOM 1 ##################################
	echo '<tr class="text" align="center" bgcolor="'.$kolor_ciemno_szary.'">';
	echo '<td height="80px">Pozycja</td>';
	echo '<td width="'.$szer_rozne.'">Okna</td>';
	echo '<td width="'.$szer_rozne.'">Drzwi wewnętrzne</td>';
	echo '<td width="'.$szer_rozne.'">Drzwi zewnętrzne</td>';
	echo '<td width="'.$szer_rozne.'">Bramy</td>';
	echo '<td width="'.$szer_rozne.'">Parapety</td>';
	echo '<td width="'.$szer_rozne.'">Rolety zewnętrzne</td>';
	echo '<td width="'.$szer_rozne.'">Rolety wewnętrzne</td>';
	echo '<td width="'.$szer_rozne.'">Moskitiery</td>';
	echo '<td width="'.$szer_rozne.'">Montaż</td>';
	echo '<td width="'.$szer_rozne.'">Odpady z pvc</td>';
	echo '<td width="'.$szer_rozne.'">Odpady ze stali i alu</td>';
	echo '<td width="'.$szer_rozne.'">Transport</td>';
	echo '<td width="'.$szer_rozne.'">Inne</td>';
	echo '<td width="'.$szer_rozne.'">Stopień trudności</td>';
	echo '<td width="'.$szer_rozne.'">Nazwa produktu</td>';
	echo '<td width="'.$szer_inne_wartosc.'">Cena netto za sztukę</td>';
	echo '<td>Ilość sztuk</td>';
	echo '<td width="'.$szer_inne_wartosc.'">Wartość netto</td>';
	echo '<td>VAT</td>';
	echo '<td width="'.$szer_inne_wartosc.'">Wartość brutto</td>';
	echo '<td>Nr faktury</td>';
	echo '<td>Data faktury</td>';
	echo '<td>Uwagi</td>';
	echo '</tr>';
	
	
//sprawdzamy czy istnieje pozycja transportowa - jeżli tak zmiejszamy ilosc pozycji o 1
if($pozycja_transport[$ilosc_pozycji] == 'tak') $ilosc_pozycji--;

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{

	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		$styl = "pole_input_biale_right_bez_ramki"; 
		}
	else 
		{
		$wiersz = $kolor_jasno_szary;
		$styl = "pole_input_szare_right_bez_ramki"; 
		}

	$wyrownanie = 'right';
	echo '<tr bgcolor="'.$wiersz.'" align="left"><td bgcolor="'.$kolor_ciemno_szary.'" align="center">'.$x.'/'.$ilosc_pozycji.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$okna[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$drzwi_wewnetrzne[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$drzwi_zewnetrzne[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$bramy[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$parapety[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$rolety_zewnetrzne[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$rolety_wewnetrzne[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$moskitiery[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$montaz[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$odpady_pvc[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$odpady_alu_stal[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$transport[$x].$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'">'.$inne[$x].$waluta.'</td>';
	echo '<td align="center">'.$stopien_trudnosci[$x].'</td>';
	echo '<td align="left" width="300px">'.$nazwa_produktu[$x].'</td>';
	echo '<td align="'.$wyrownanie.'">'.$cena_netto_za_sztuke[$x].$waluta.'</td>';
	echo '<td align="center">'.$ilosc_sztuk[$x].'</td>';
	echo '<td align="'.$wyrownanie.'" width="100px">'.$wartosc_netto[$x].$waluta.'</td>';
	echo '<td align="center">'.$vat_baza[$x].'</td>';
	echo '<td align="'.$wyrownanie.'" width="100px">'.$wartosc_brutto[$x].$waluta.'</td>';
	echo '<td align="center" width="100px">'.$nr_faktury[$x].'</td>';
	echo '<td align="center" width="100px">'.$data_faktury[$x].'</td>';
	echo '<td align="left" width="400px">'.$uwagi[$x].'</td></tr>';
	
	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)

	$temp_ilosc_pozycji = $ilosc_pozycji + 1;
	if($pozycja_transport[$temp_ilosc_pozycji] == 'tak')
		{		
		$wiersz = $kolor_jasno_szary;
		$styl = "pole_input_biale_right_bez_ramki"; 

		echo '<tr bgcolor="'.$wiersz.'" align="center"><td bgcolor="'.$kolor_ciemno_szary.'">'.$x.'/'.$x.'</td>';
		echo '<td align="left" colspan="11" class="text"></td>';
		echo '<td align="'.$wyrownanie.'">'.$transport[$x].''.$waluta.'</td>';
		echo '<td align="left" colspan="4" class="text"></td>';
		echo '<td align="'.$wyrownanie.'">'.$wartosc_netto[$x].$waluta.'</td>';
		echo '<td align="center">'.$vat_baza[$x].'</td>';
		echo '<td align="'.$wyrownanie.'">'.$wartosc_brutto[$x].$waluta.'</td>';
		echo '<td>'.$nr_faktury[$x].'</td>';
		echo '<td>'.$data_faktury[$x].'</td>';
		echo '<td align="left" class="text"></td>';
		echo '</tr>';
		}

	echo '<tr><td style="background-color:#ffffff; border-bottom-color:#ffffff; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>'; //pozycja
	echo '<td align="center" colspan="16" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.',' ');
	echo '<td align="'.$wyrownanie.'" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;" bgcolor="'.$kolor_ciemno_szary.'">'.$SUMA_NETTO.$waluta.'</td>';
	echo '<td align="'.$wyrownanie.'" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
	echo '<td align="'.$wyrownanie.'" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;" bgcolor="'.$kolor_ciemno_szary.'">'.$SUMA_BRUTTO.$waluta.'</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;" colspan="3"></td></tr>';
	
echo '</table>'; // koniec tabeli 




 
echo '</td></tr></table>'; // tabela ktora trzyma wszystkie 4 poziomy



?>

</body>
</html>
