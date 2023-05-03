<?php
$ilosc_pozycji = 0;
$kolor = [];
$wygiecie_innego_pvc_opis = [];
$wygiecie_innego_ze_stali_opis = [];
$ww_pozycja_uwagi1 = [];
$ww_pozycja_uwagi2 = [];
$ww_pozycja_uwagi_reczne = [];
$wycena_podstawowa_material = [];
$dodatki_material = [];
$rysunek = [];
$produkt = [];
$wartosc1 = [];
$wartosc2 = [];
$transport = 0;
include ("php/wyceny_deklaracja_pustych_tablic.php");

$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_wysylka."' AND nr_zamowienia = '".$wycena_wstepna_wysylka."' AND klient_id = ".$klient_id_wycena." AND pozycja_transport = 'NIE' ORDER BY pozycja ASC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_pozycji++;
	$klient_id=$wynik['klient_id'];
	$wycena_wstepna_dodal_klient_id=$wynik['wycena_wstepna_dodal_klient_id'];
	$user_id=$wynik['user_id'];
	$data_wyceny=$wynik['data_wyceny'];
	$wycena_wstepna_nr=$wynik['wycena_wstepna_nr'];
	$wartosc_netto=$wynik['wartosc_netto'];
	$link_wycena_pdf=$wynik['link_wycena_pdf'];
	$klient_nazwa=$wynik['klient_nazwa'];
	$email=$wynik['wycena_wstepna_email'];
	$data_waznosci=$wynik['data_waznosci_wyceny'];
	$termin_realizacji=$wynik['termin_realizacji'];
	$sposob_dostawy=$wynik['sposob_dostawy_wycena_wstepna'];
	
	$wycena_wstepna_podsumowanie_uwagi1=$wynik['ww_podsumowanie_uwagi1'];
	$wycena_wstepna_podsumowanie_uwagi2=$wynik['ww_podsumowanie_uwagi2'];
	$wycena_wstepna_podsumowanie_uwagi_reczne=$wynik['ww_podsumowanie_uwagi_reczne'];
	
	$wycena_wstepna_pozycja_uwagi1[$ilosc_pozycji]=$wynik['ww_pozycja_uwagi1'];
	$wycena_wstepna_pozycja_uwagi2[$ilosc_pozycji]=$wynik['ww_pozycja_uwagi2'];
	$wycena_wstepna_pozycja_uwagi_reczne[$ilosc_pozycji]=$wynik['ww_pozycja_uwagi_reczne'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$zamowienie_id=$wynik['zamowienie_id'];
	$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
	$produkt[$ilosc_pozycji]=$wynik['nazwa_produktu'];
	
	
	$rysunek[$ilosc_pozycji]=$wynik['rysunek'];
	$pytanie555 = mysqli_query($conn, "SELECT * FROM rysunki where id = ".$rysunek[$ilosc_pozycji].";");
	while($wynik555= mysqli_fetch_assoc($pytanie555))
		$rysunek_link[$ilosc_pozycji]=$wynik555['link'];
	
	$wartosc1[$ilosc_pozycji]=$wynik['wycena_wstepna_wartosc1'];
	$wartosc2[$ilosc_pozycji]=$wynik['wycena_wstepna_wartosc2'];
	$kolor[$ilosc_pozycji]=$wynik['kolor'];
	$wygiecie_innego_pvc_opis[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_opis'];
	$wygiecie_innego_ze_stali_opis[$ilosc_pozycji]=$wynik['wygiecie_innego_ze_stali_opis'];
	$wygiecie_innego_ze_stali_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_wartosc'];
	$wygiecie_ramy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_ramy_pvc_wartosc'];
	$wygiecie_skrzydla_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_skrzydla_pvc_wartosc'];
	$wygiecie_listwy_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_listwy_pvc_wartosc'];
	
	$wygiecie_innego_pvc_wartosc[$ilosc_pozycji]=$wynik['wygiecie_innego_pvc_wartosc'];
	$inny_element_wartosc[$ilosc_pozycji]=$wynik['inny_element_wartosc'];		
	$zgrzanie_wartosc[$ilosc_pozycji]=$wynik['zgrzanie_wartosc'];
	$oscieznica_wartosc[$ilosc_pozycji]=$wynik['oscieznica_wartosc'];
	$skrzydlo_wartosc[$ilosc_pozycji]=$wynik['skrzydlo_wartosc'];
	$listwa_wartosc[$ilosc_pozycji]=$wynik['listwa_wartosc'];
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

	
	}

$pytanie2 = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND pozycja_transport = 'TAK';");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	$transport = number_format($wynik2['transport'], 2,'.','');

		
$pytanie2 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id.";");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$klient_ulica=$wynik2['ulica'];
	$klient_miasto=$wynik2['miasto'];
	$klient_kod_pocztowy=$wynik2['kod_pocztowy'];
	$klient_sposob_platnosci=$wynik2['sposob_platnosci'];
	}
	
// usuwamy z uliucy klienta napis ul itp aby się nie powtarzał na wydruku wyceny
$klient_ulica = popraw_ulice($klient_ulica);


//####################################################################################################################################################################################
//##########################################################################   generowanie pdf    ##########################################################################
//####################################################################################################################################################################################

define('FPDF_FONTPATH','php/pdf/font/');  //definiuje katalog z czcionkami komponentu
require_once('pdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF7();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');

$pdf->SetFont('arial_ce','', 10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(200,200,200);

$ilosc_stron = 1;
$licz_segmenty = 0;
$wysokosc_od_gory = 2;
$wysokosc_segmentu = 90;
$szerokosc_segmentu = 206;
$odleglosc_od_krawedzi = 2;
$szerokosc_segmentu_naglowek = 140;

$stopka_wysokosc = 290;
$stopka_szerokosc = 100;

$wysokosc_wiersza1 = 8;
$wysokosc_wiersza2 = 4;

$licz_segmenty++;
// ########################################## nagłówek ######################################
$ramka_dane_wyceny = 0;
$pdf->SetFillColor(255,255,255);

// klient
$szer_kol_klient = 15;
$szer_kol_naglowek_prawa = $szerokosc_segmentu_naglowek - $szer_kol_klient;
$pdf->SetFont('arial_ce','B', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_klient = iconv('UTF-8','windows-1250//TRANSLIT', 'Klient : ');
$pdf->Multicell($szer_kol_klient, $wysokosc_wiersza1, $opis_klient, $ramka_dane_wyceny, 'L' ,1); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane, ostatni parametr to tło

$pdf->SetFont('arial_ce','', 10);
$odleglosc_od_krawedzi += $szer_kol_klient;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$klient_nazwa = iconv('UTF-8','windows-1250//TRANSLIT', $klient_nazwa);
$pdf->Multicell($szer_kol_naglowek_prawa, $wysokosc_wiersza1, $klient_nazwa, $ramka_dane_wyceny, 'L' ,1); 

//email
$odleglosc_od_krawedzi = 2;
$pdf->SetFont('arial_ce','B', 10);
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_email = iconv('UTF-8','windows-1250//TRANSLIT', 'email : ');
$pdf->Multicell($szer_kol_klient, $wysokosc_wiersza1, $opis_email, $ramka_dane_wyceny, 'L' ,1); 

$odleglosc_od_krawedzi += $szer_kol_klient;
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$email = iconv('UTF-8','windows-1250//TRANSLIT', $email);
$pdf->Multicell($szer_kol_naglowek_prawa, $wysokosc_wiersza1, $email, $ramka_dane_wyceny, 'L' ,1); 

//adres
$odleglosc_od_krawedzi = 2;
$pdf->SetFont('arial_ce','B', 10);
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_adres = iconv('UTF-8','windows-1250//TRANSLIT', 'Adres : ul.');
$pdf->Multicell($szer_kol_klient, $wysokosc_wiersza1, $opis_adres, $ramka_dane_wyceny, 'L' ,1); 

$odleglosc_od_krawedzi += $szer_kol_klient;
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_adres2 = $klient_ulica.', '.$klient_kod_pocztowy.' '.$klient_miasto;
$opis_adres2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_adres2);
$pdf->Multicell($szer_kol_naglowek_prawa, $wysokosc_wiersza1, $opis_adres2, $ramka_dane_wyceny, 'L' ,1); 

//sposób płatności
$szer_kol_sposob = 35;
$szer_kol_naglowek_prawa2 = $szerokosc_segmentu_naglowek - $szer_kol_sposob;
$odleglosc_od_krawedzi = 2;
$pdf->SetFont('arial_ce','B', 10);
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_sposob = iconv('UTF-8','windows-1250//TRANSLIT', 'Sposób płatności : ');
$pdf->Multicell($szer_kol_sposob, $wysokosc_wiersza1, $opis_sposob, $ramka_dane_wyceny, 'L' ,1); 

$odleglosc_od_krawedzi += $szer_kol_sposob;
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_sposob2 = $klient_sposob_platnosci;
$opis_sposob2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_sposob2);
$pdf->Multicell($szer_kol_naglowek_prawa2, $wysokosc_wiersza1, $opis_sposob2, $ramka_dane_wyceny, 'L' ,1); 

//pusty wiersz
$odleglosc_od_krawedzi = 2;
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_segmentu_naglowek, $wysokosc_wiersza1, '', $ramka_dane_wyceny, 'L' ,1); 


// nr wyceny
$odleglosc_od_krawedzi = 2;
$szer_kol_nr_wyceny = 24;
$szer_kol_naglowek_prawa3 = $szerokosc_segmentu_naglowek - $szer_kol_nr_wyceny;
$pdf->SetFont('arial_ce','B', 10);
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_nr_wyceny = iconv('UTF-8','windows-1250//TRANSLIT', 'Nr wyceny : ');
$pdf->Multicell($szer_kol_nr_wyceny, $wysokosc_wiersza1, $opis_nr_wyceny, $ramka_dane_wyceny, 'L' ,1); 

$odleglosc_od_krawedzi += $szer_kol_nr_wyceny;
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_nr_wyceny2 = $wycena_wstepna_nr;
$opis_nr_wyceny2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_nr_wyceny2);
$pdf->Multicell($szer_kol_naglowek_prawa3, $wysokosc_wiersza1, $opis_nr_wyceny2, $ramka_dane_wyceny, 'L' ,1); 

//Data sporządzenia wyceny
$szer_kol_data_sporzadzenia = 50;
$szer_kol_naglowek_prawa4 = $szerokosc_segmentu_naglowek - $szer_kol_data_sporzadzenia;
$odleglosc_od_krawedzi = 2;
$pdf->SetFont('arial_ce','B', 10);
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_data_wyceny = 'Data sporządzenia wyceny : ';
$opis_data_wyceny = iconv('UTF-8','windows-1250//TRANSLIT', $opis_data_wyceny);
$pdf->Multicell($szer_kol_data_sporzadzenia, $wysokosc_wiersza1, $opis_data_wyceny, $ramka_dane_wyceny, 'L' ,1); 

$odleglosc_od_krawedzi += $szer_kol_data_sporzadzenia;
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_data_wyceny2 = $dzis;
$opis_data_wyceny2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_data_wyceny2);
$pdf->Multicell($szer_kol_naglowek_prawa4, $wysokosc_wiersza1, $opis_data_wyceny2, $ramka_dane_wyceny, 'L' ,1); 

//Data ważności
$szer_kol_data_waznosci = 30;
$odleglosc_od_krawedzi = 2;
$pdf->SetFont('arial_ce','B', 10);
$szer_kol_naglowek_prawa5 = $szerokosc_segmentu_naglowek - $szer_kol_data_waznosci;
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_data_waznosci = 'Data ważności : ';
$opis_data_waznosci = iconv('UTF-8','windows-1250//TRANSLIT', $opis_data_waznosci);
$pdf->Multicell($szerokosc_segmentu_naglowek, $wysokosc_wiersza1, $opis_data_waznosci, $ramka_dane_wyceny, 'L' ,1); 

$odleglosc_od_krawedzi += $szer_kol_data_waznosci;
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_data_waznosci2 = $data_waznosci;
$opis_data_waznosci2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_data_waznosci2);
$pdf->Multicell($szer_kol_naglowek_prawa5, $wysokosc_wiersza1, $opis_data_waznosci2, $ramka_dane_wyceny, 'L' ,1); 


//logo i dane
$odleglosc_od_krawedzi = 2;
$pdf->SetFillColor(255,255,255);
$wysokosc_od_gory = 2;
//sprawdzamy czy plik LOGO istnieje
$file_headers = @get_headers($logo_do_potwierdzen);
if($file_headers[0] == 'HTTP/1.1 404 Not Found')  $exists = false; else $pdf->Image($logo_do_potwierdzen, 145, 3, -420);


$pdf->SetFont('arial_ce','', 6);
$pdf->SetTextColor(100,100,100);
$wysokosc_od_gory += $wysokosc_wiersza2+39;
$temp_odl = $odleglosc_od_krawedzi+$szerokosc_segmentu_naglowek;
$szerokosc_dane_naglowek = $szerokosc_segmentu - $szerokosc_segmentu_naglowek;

$pdf->SetXY($temp_odl,$wysokosc_od_gory);
$dane1 = iconv('UTF-8','windows-1250//TRANSLIT', 'Podwiesk 65D, 86-200 Chełmno');
$pdf->Multicell($szerokosc_dane_naglowek, $wysokosc_wiersza2, $dane1, $ramka_dane_wyceny, 'C' ,1);

$wysokosc_od_gory += $wysokosc_wiersza2;
$pdf->SetXY($temp_odl,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_dane_naglowek, $wysokosc_wiersza2, 'Tel. 52/522-22-02', $ramka_dane_wyceny, 'C' ,1);

$wysokosc_od_gory += $wysokosc_wiersza2;
$pdf->SetXY($temp_odl,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_dane_naglowek, $wysokosc_wiersza2, 'e-mail: biuro@arcus-luki.pl', $ramka_dane_wyceny, 'C' ,1);

$wysokosc_od_gory += $wysokosc_wiersza2;
$pdf->SetXY($temp_odl,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_dane_naglowek, $wysokosc_wiersza2, 'www.arcus-luki.pl', $ramka_dane_wyceny, 'C' ,1);

// ########################################## KONIEC nagłówek ######################################
$wysokosc_od_gory = 2;
$ramka_pozycja_naglowek = 1;
$szer_kol_pozycja = 18;
$szer_kol_produkt = 40;
$szer_kol_opis1 = 31;
$szer_kol_kolor = 40;
$szer_kol_ilosc = 10;

$szer_kol_opis2 = 206 - $szer_kol_pozycja - $szer_kol_produkt - $szer_kol_opis1 - $szer_kol_kolor - $szer_kol_ilosc;
$SUMA = 0;
$SUMA_WYCENA_PODSTAWOWA = 0;
$SUMA_DODATKI = 0;

$wys_pozycja_naglowek = 4;
$wys_pozycja_wycena_wstepna = 4;

for($x = 1; $x <= $ilosc_pozycji; $x++)
	{
	$licz_segmenty++;
	if($licz_segmenty > 3)
		{
		//stopka
		$pdf->SetFont('arial_ce','', 8);
		$pdf->SetTextColor(125,125,125);
		$opis_strony = 'Strona '.$ilosc_stron;
		$opis_strony = iconv('UTF-8','windows-1250//TRANSLIT', $opis_strony);
		$pdf->Text($stopka_szerokosc, $stopka_wysokosc, $opis_strony);

		$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
		$wysokosc_od_gory = $odleglosc_od_krawedzi-$wysokosc_segmentu;
		$licz_segmenty = 1;
		$ilosc_stron++;
		
		
		$pdf->SetFont('arial_ce','', 10);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFillColor(150,150,150);
		$wysokosc_od_gory = 2;
		$wysokosc_od_gory -= $wysokosc_segmentu;
		}
	$odleglosc_od_krawedzi = 2;
	$wysokosc_od_gory += $wysokosc_segmentu;
	//$ttt = 'Wys='.$wysokosc_od_gory.', licz='.$licz_segmenty;
	$pdf->SetFont('arial_ce','', 7);
	// ########################################## nagłówek pozycji ######################################
	$pdf->SetFillColor(255,255,255);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); // pierwszy parametr - odległosc od lewej krawedzi, drugi odl od gory
	$pdf->Multicell($szerokosc_segmentu, $wysokosc_segmentu, '', 1, 'C' ,1); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane, ostatni parametr to tło
	
	//pozycja
	$pdf->SetFillColor(200,200,200);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); // pierwszy parametr - odległosc od lewej krawedzi, drugi odl od gory
	$opis_pozycja = 'Pozycja '.$x.'/'.$ilosc_pozycji;
	$pdf->Multicell($szer_kol_pozycja, $wys_pozycja_naglowek, $opis_pozycja, $ramka_pozycja_naglowek, 'C' ,1); 
	
	//produkt
	$odleglosc_od_krawedzi = $odleglosc_od_krawedzi + $szer_kol_pozycja;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); 
	$opis_produkt = $produkt[$x];
	$opis_produkt = iconv('UTF-8','windows-1250//TRANSLIT', $opis_produkt);
	$pdf->Multicell($szer_kol_produkt, $wys_pozycja_naglowek, $opis_produkt, $ramka_pozycja_naglowek, 'C' ,1); 
	
	//wartosc1
	$odleglosc_od_krawedzi = $odleglosc_od_krawedzi + $szer_kol_produkt;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); 
	$opis_wartosc1 = $wartosc1[$x];
	$opis_wartosc1 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_wartosc1);
	$pdf->Multicell($szer_kol_opis1, $wys_pozycja_naglowek, $opis_wartosc1, $ramka_pozycja_naglowek, 'C' ,1); 
	
	//kolor
	$odleglosc_od_krawedzi = $odleglosc_od_krawedzi + $szer_kol_opis1;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); 
	$opis_kolor = $kolor[$x];
	$opis_kolor = iconv('UTF-8','windows-1250//TRANSLIT', $opis_kolor);
	$pdf->Multicell($szer_kol_kolor, $wys_pozycja_naglowek, $opis_kolor, $ramka_pozycja_naglowek, 'C' ,1); 
	
	//wartosc2
	$odleglosc_od_krawedzi = $odleglosc_od_krawedzi + $szer_kol_kolor;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); 
	$opis_wartosc2 = $wartosc2[$x];
	$opis_wartosc2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_wartosc2);
	$pdf->Multicell($szer_kol_opis2, $wys_pozycja_naglowek, $opis_wartosc2, $ramka_pozycja_naglowek, 'C' ,1); 
	
	//ilosc
	$odleglosc_od_krawedzi = $odleglosc_od_krawedzi + $szer_kol_opis2;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); 
	$opis_ilosc = $ilosc_sztuk[$x].' szt.';
	$opis_ilosc = iconv('UTF-8','windows-1250//TRANSLIT', $opis_ilosc);
	$pdf->Multicell($szer_kol_ilosc, $wys_pozycja_naglowek, $opis_ilosc, $ramka_pozycja_naglowek, 'C' ,1); 
	// ##########################################  KONIEC nagłówek pozycji ######################################
	
	
	//##################################################  wycena podstawowa  ##################################################
	$ilosc_wpisow_w_tabeli  = 0;
		if($wygiecie_ramy_pvc_wartosc[$x] != 0) 
			{
			$wycena_podstawowa[$x] += $wygiecie_ramy_pvc_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_wycena_podstawowa[$x][$ilosc_wpisow_w_tabeli] = ' - Wygięcie ościeżnicy';
			}
		if($wygiecie_skrzydla_pvc_wartosc[$x] != 0) 
			{
			$wycena_podstawowa[$x] += $wygiecie_skrzydla_pvc_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_wycena_podstawowa[$x][$ilosc_wpisow_w_tabeli] = ' - Wygięcie skrzydła';
			}
		if($wygiecie_listwy_pvc_wartosc[$x] != 0) 
			{
			$wycena_podstawowa[$x] += $wygiecie_listwy_pvc_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_wycena_podstawowa[$x][$ilosc_wpisow_w_tabeli] = ' - Wygięcie listwy';
			}
		if($zgrzanie_wartosc[$x] != 0) 
			{
			$wycena_podstawowa[$x] += $zgrzanie_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_wycena_podstawowa[$x][$ilosc_wpisow_w_tabeli] = ' - Zgrzanie';
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
			

		if($wycena_podstawowa_material_baza[$x] != '') 
			{
			$ilosc_wpisow_w_tabeli++;
			$opisy_wycena_podstawowa[$x][$ilosc_wpisow_w_tabeli] = ' - '.$wycena_podstawowa_material_baza[$x];
			}


	$SUMA_WYCENA_PODSTAWOWA += $wycena_podstawowa[$x];
	$wycena_podstawowa[$x] = number_format($wycena_podstawowa[$x], 2,'.',' ');
	
	$wysokosc_od_gory_temp = $wysokosc_od_gory+3;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$szer_wycena_podstawowa = 69;
	$odleglosc_od_krawedzi = 2;
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek-1;
	$ramka_pozycja_wycena_podstawowa = 0;
	$pdf->SetFont('arial_ce','B', 8);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$opis_wycena_podstawowa2 = 'Wycena podstawowa : '.$wycena_podstawowa[$x].$waluta;
	$opis_wycena_podstawowa2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_wycena_podstawowa2);
	$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_naglowek, $opis_wycena_podstawowa2, $ramka_pozycja_wycena_podstawowa, 'C' ,0); 
	
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek;
	$pdf->SetDrawColor(0,0,0);
	$pdf->Line($odleglosc_od_krawedzi + 2, $wysokosc_od_gory_temp, $szer_wycena_podstawowa, $wysokosc_od_gory_temp); 
	
	$wysokosc_od_gory_temp += 1;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$opis_uwzgledniono = iconv('UTF-8','windows-1250//TRANSLIT', 'Uwzględniono : ');
	$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_naglowek, $opis_uwzgledniono, $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
	
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek;
	$pdf->SetFont('arial_ce','', 8);
	for($y = 1; $y<=$ilosc_wpisow_w_tabeli; $y++)
		{
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
		$opis_wycena_podstawowa = $opisy_wycena_podstawowa[$x][$y];
		$opis_wycena_podstawowa = iconv('UTF-8','windows-1250//TRANSLIT', $opis_wycena_podstawowa);
		$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_wycena_wstepna, $opis_wycena_podstawowa, $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
		$wysokosc_od_gory_temp += $wys_pozycja_wycena_wstepna;
		}
	
	
	//################################################## KONIEC  wycena podstawowa  ##################################################


	//##################################################  dodatki  ##################################################
		$ilosc_wpisow_w_tabeli  = 0;
		if($wygiecie_innego_pvc_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $wygiecie_innego_pvc_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			if($wygiecie_innego_pvc_opis[$x] != '') $opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - '.$wygiecie_innego_pvc_opis[$x]; else $opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Wygięcie innego elementu z pvc';
			}
		if($wygiecie_innego_ze_stali_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $wygiecie_innego_ze_stali_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			if($wygiecie_innego_ze_stali_opis[$x] != '') $opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - '.$wygiecie_innego_ze_stali_opis[$x]; else $opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Wygięcie innego elementu ze stali';
			}
		if($wygiecie_wzmocnienia_okiennego_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $wygiecie_wzmocnienia_okiennego_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Wygięcie wzmocnienia okiennego';
			}
		if($wyfrezowanie_odwodnienia_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $wyfrezowanie_odwodnienia_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Wyfrezowanie odwodnienia';
			}
		if($wstawienie_slupka_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $wstawienie_slupka_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] .= ' - Wstawienie słupka stałego';
			}
		if($wstawienie_slupka_ruchomego_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $wstawienie_slupka_ruchomego_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] .= ' - Wstawienie słupka ruchomego';
			}
		if($listwa_przyszybowa_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $listwa_przyszybowa_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] .= ' - Docięcie listwy przyszybowej tylko łukowej';
			}
		if($dociecie_kompletu_listew_przyszybowych_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $dociecie_kompletu_listew_przyszybowych_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] .= ' - Docięcie kompletu listew przyszybowych';
			}
		if($okucie_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $okucie_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Okucie';
			}
		if($zaszklenie_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $zaszklenie_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Zaszklenie';
			}
		if($innej_uslugi_wartosc[$x] != 0) 
			{
			$wartosc_dodatki[$x] += $innej_uslugi_wartosc[$x];
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - Wykonanie innej usługi';
			}

	//materiał
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

		if($dodatki_material_baza[$x] != '')
			{
			$ilosc_wpisow_w_tabeli++;
			$opisy_dodatkow[$x][$ilosc_wpisow_w_tabeli] = ' - '.$dodatki_material_baza[$x];
			}	
	
	// dodajemy całą resztę kolumn z wyceny do dodatków: 16 kolumn BEZ TRANSPORTU
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
	
	$wysokosc_od_gory_temp = $wysokosc_od_gory+3;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$szer_wycena_podstawowa = 69;
	$odleglosc_od_krawedzi += $szer_wycena_podstawowa;
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek-1;
	$ramka_pozycja_wycena_podstawowa = 0;
	$pdf->SetFont('arial_ce','B', 8);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$opis_dodatki = 'Dodatki : '.$wartosc_dodatki[$x].$waluta;
	$opis_dodatki = iconv('UTF-8','windows-1250//TRANSLIT', $opis_dodatki);
	$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_naglowek, $opis_dodatki, $ramka_pozycja_wycena_podstawowa, 'C' ,0); 
	
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek;
	$pdf->SetDrawColor(0,0,0);
	$pdf->Line($odleglosc_od_krawedzi + 2, $wysokosc_od_gory_temp, $szer_wycena_podstawowa*2, $wysokosc_od_gory_temp); 
	
	$wysokosc_od_gory_temp += 1;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$opis_uwzgledniono = iconv('UTF-8','windows-1250//TRANSLIT', 'Uwzględniono : ');
	$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_naglowek, $opis_uwzgledniono, $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
	
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek;
	$pdf->SetFont('arial_ce','', 8);
	for($y = 1; $y<=$ilosc_wpisow_w_tabeli; $y++)
		{
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
		
		$opisy_dodatkow[$x][$y] = iconv('UTF-8','windows-1250//TRANSLIT', $opisy_dodatkow[$x][$y]);
		$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_wycena_wstepna, $opisy_dodatkow[$x][$y], $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
		$wysokosc_od_gory_temp += $wys_pozycja_wycena_wstepna;
		}
	
	//################################################## KONIEC  dodatki  ##################################################

	//##################################################  rysunek  ##################################################
	
	$wysokosc_od_gory_temp = $wysokosc_od_gory+3;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$szer_wycena_podstawowa = 68;
	$odleglosc_od_krawedzi += $szer_wycena_podstawowa;
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek-1;
	$ramka_pozycja_wycena_podstawowa = 0;
	$pdf->SetFont('arial_ce','B', 8);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$opis_rysunek = 'Rysunek poglądowy';
	$opis_rysunek = iconv('UTF-8','windows-1250//TRANSLIT', $opis_rysunek);
	$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_naglowek, $opis_rysunek, $ramka_pozycja_wycena_podstawowa, 'C' ,0); 
	
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek;
	$pdf->SetDrawColor(0,0,0);
	$pdf->Line($odleglosc_od_krawedzi + 2, $wysokosc_od_gory_temp, $szer_wycena_podstawowa*3+2, $wysokosc_od_gory_temp); 
	
	
	
/*
Image(string plik, float x, float y, float w [, float h [, string typ [, mixed link]]])

plik - nazwa pliku z obrazkiem. x - współrzędna X lewego górnego rogu obrazka. y - współrzędna Y lewego górnego rogu obrazka. w - szerokość obrazka na stronie. Jeśli równa jest zeru, obliczana jest proporcjonalnie do wysokości oryginalnego obrazka. 
h - wysokość obrazka na stronie. Jeśli nie podana lub równa zeru, obliczana automatycznie, proporcjonalnie do szerokości. typ - format pliku obrazka. Przyjmuje wartości (wielkość liter bez znaczenia): JPG, JPEG, PNG. 
Jeśli nie jest podana, ustalana jest na podstawie rozszerzenia nazwy pliku. link - URL albo identyfikator zwracany przez AddLink(). 14) Obrazek wstawisz na następnej stronie, ale najpierw zrobisz odnośnik do tej strony na pierwszej stronie. Do tego wykorzystasz kilka funkcji: 
	
	$wysokosc_od_gory_temp += $wys_pozycja_naglowek;
	$opis_rysunek = 'odl kr='.$odleglosc_od_krawedzi.', wys='.$wysokosc_od_gory_temp;
	$pdf->Multicell($szer_wycena_podstawowa, $wys_pozycja_naglowek, $opis_rysunek, 1, 'C' ,0); 

	//pobieram wymiary obrazka
	$size = getimagesize('http://'.$adres_serwera_do_faktur.'/panel/wycena_wstepna_rysunki/'.$rysunek[$x].'.jpg');
	$szerokosc_rysunku = $size[0];
	$wysokosc_rysunku = $size[1];
*/



	$link_do_rysunku = 'http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$rysunek_link[$x];
	if($rysunek_link[$x] != '') $pdf->Image($link_do_rysunku, $odleglosc_od_krawedzi+9, $wysokosc_od_gory_temp+1, 50);

	//################################################## KONIEC  rysunek  ##################################################
	
	
	
	//##################################################  uwagi  ##################################################
	$wys_pozycja_uwagi = 15;
	$wys_pozycja_uwagi2 = 5;
	$szer_pozycja_uwagi = 20;
	$szer_pozycja_uwagi2 = $szerokosc_segmentu - $szer_pozycja_uwagi;
	$wysokosc_od_gory_temp = $wysokosc_od_gory + $wysokosc_segmentu - $wys_pozycja_uwagi;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$odleglosc_od_krawedzi = 2;
	$ramka_pozycja_wycena_podstawowa = 0;
	//rysowanie obramowania
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$pdf->Multicell($szerokosc_segmentu, $wys_pozycja_uwagi, '', 1, 'C' ,0);
	
	$pdf->SetFont('arial_ce','B', 8);
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
	$opis_uwagi = 'Uwagi :';
	$opis_uwagi = iconv('UTF-8','windows-1250//TRANSLIT', $opis_uwagi);
	$pdf->Multicell($szer_pozycja_uwagi, $wys_pozycja_uwagi, $opis_uwagi, $ramka_pozycja_wycena_podstawowa, 'C' ,0);
	
	$pdf->SetFont('arial_ce','', 8);
	$odleglosc_od_krawedzi += $szer_pozycja_uwagi;
		
	if($wycena_wstepna_pozycja_uwagi1[$x] != '')
		{
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
		$opis_uwaga1 = iconv('UTF-8','windows-1250//TRANSLIT', $wycena_wstepna_pozycja_uwagi1[$x]);
		$pdf->Multicell($szer_pozycja_uwagi2, $wys_pozycja_uwagi2, $opis_uwaga1, $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
		$wysokosc_od_gory_temp += $wys_pozycja_uwagi2;
		}
		
	if($wycena_wstepna_pozycja_uwagi2[$x] != '')
		{
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
		$opis_uwaga2 = iconv('UTF-8','windows-1250//TRANSLIT', $wycena_wstepna_pozycja_uwagi2[$x]);
		$pdf->Multicell($szer_pozycja_uwagi2, $wys_pozycja_uwagi2, $opis_uwaga2, $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
		$wysokosc_od_gory_temp += $wys_pozycja_uwagi2;
		}
		
	if($wycena_wstepna_pozycja_uwagi_reczne[$x] != '')
		{
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory_temp); 
		$opis_uwaga3 = iconv('UTF-8','windows-1250//TRANSLIT', $wycena_wstepna_pozycja_uwagi_reczne[$x]);
		$pdf->Multicell($szer_pozycja_uwagi2, $wys_pozycja_uwagi2, $opis_uwaga3, $ramka_pozycja_wycena_podstawowa, 'L' ,0); 
		}
	//################################################## KONIEC  uwagi  ##################################################
} // do for




// ############################################################################## podsumowanie ###############################################################################################
if($licz_segmenty == 3)
	{
	//stopka
	$pdf->SetFont('arial_ce','', 8);
	$pdf->SetTextColor(125,125,125);
	$opis_strony = 'Strona '.$ilosc_stron;
	$opis_strony = iconv('UTF-8','windows-1250//TRANSLIT', $opis_strony);
	$pdf->Text($stopka_szerokosc, $stopka_wysokosc, $opis_strony);
	$odleglosc_od_krawedzi = 2;
	$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
	$wysokosc_od_gory = $odleglosc_od_krawedzi-$wysokosc_segmentu;
	$licz_segmenty = 1;
	$ilosc_stron++;
	
	$pdf->SetFont('arial_ce','', 9);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(200,200,200);
	}
	
	
$odleglosc_od_krawedzi = 2;
$wys_podsumowanie = 6;
$wys_podsumowanie_opisy = 6;
$szer_podsumowanie_lewa = 32;
$szer_podsumowanie_lewa_wartosc = 20;
$szer_podsumowanie_srodek = 28;
$szer_podsumowanie_prawa = 206 - $szer_podsumowanie_lewa - $szer_podsumowanie_lewa_wartosc - $szer_podsumowanie_srodek;
$ramka_podsumowanie = 0;
$wysokosc_od_gory += $wysokosc_segmentu;
$wysokosc_od_gory_podsumowanie = $wysokosc_od_gory;

//dodaje wsystkie składowe
$transport = number_format($transport, 2,'.','');
$SUMA_DODATKI = number_format($SUMA_DODATKI, 2,'.','');
$SUMA_WYCENA_PODSTAWOWA = number_format($SUMA_WYCENA_PODSTAWOWA, 2,'.','');

$SUMA = $SUMA_WYCENA_PODSTAWOWA+$SUMA_DODATKI+$transport;
$SUMA_WYCENA_PODSTAWOWA = number_format($SUMA_WYCENA_PODSTAWOWA, 2,'.',' ');
$SUMA_DODATKI = number_format($SUMA_DODATKI, 2,'.',' ');
$transport = number_format($transport, 2,'.',' ');
$SUMA = number_format($SUMA, 2,'.',' ');

// rysowanie ramki do podsumowania
$pdf->SetFillColor(255,255,255);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); 
$pdf->Multicell($szerokosc_segmentu, $wysokosc_segmentu, '', 1, 'C' ,1); 

// napis podsumowanie na szarym tle
$pdf->SetFont('arial_ce','B', 8);
$pdf->SetFillColor(200,200,200);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory); // pierwszy parametr - odległosc od lewej krawedzi, drugi odl od gory
$pdf->Multicell($szerokosc_segmentu, $wys_podsumowanie, 'PODSUMOWANIE', 1, 'C' ,1); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane, ostatni parametr to tło

//########################################################    lewa strona podsumowania #################################################
$pdf->SetFont('arial_ce','B', 8);
$pdf->SetFillColor(255,255,255);

//wycena podstawowa
$wysokosc_od_gory += $wys_podsumowanie;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szer_podsumowanie_lewa, $wys_podsumowanie_opisy, 'Wycena podstawowa: ', $ramka_podsumowanie, 'R' ,0); 

//dodatki
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szer_podsumowanie_lewa, $wys_podsumowanie_opisy, 'Dodatki: ', $ramka_podsumowanie, 'R' ,0); 

//transport
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szer_podsumowanie_lewa, $wys_podsumowanie_opisy, 'Transport: ', $ramka_podsumowanie, 'R' ,0); 

//suma
$pdf->SetFont('arial_ce','B', 8);
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szer_podsumowanie_lewa, $wys_podsumowanie_opisy, 'Suma: ', $ramka_podsumowanie, 'R' ,0); 
			
//sporzadzil
	$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$imie=$wynik2['imie'];
		$nazwisko=$wynik2['nazwisko'];
		$telefon=$wynik2['telefon'];
		$user_email=$wynik2['email'];
		}
	$pdf->SetFont('arial_ce','B', 8);
	$wysokosc_od_gory = $wysokosc_od_gory_podsumowanie + $wysokosc_segmentu - $wys_podsumowanie;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);

	if($user_id != '')
		{
		if($telefon != '') $telefon = ' | '.$telefon;
		if($user_email != '') $user_email = ' | '.$user_email;
		$opis_sporzadzil = 'Sporządził : '.$imie.' '.$nazwisko.$telefon.$user_email;
		$opis_sporzadzil = iconv('UTF-8','windows-1250//TRANSLIT', $opis_sporzadzil);
		$pdf->Multicell($szerokosc_segmentu, $wys_podsumowanie_opisy, $opis_sporzadzil, $ramka_podsumowanie, 'L' ,0); 
		}
	elseif($wycena_wstepna_dodal_klient_id != '')
		{
		$opis_sporzadzil = 'Sporządził : Klient';
		$opis_sporzadzil = iconv('UTF-8','windows-1250//TRANSLIT', $opis_sporzadzil);
		$pdf->Multicell($szerokosc_segmentu, $wys_podsumowanie_opisy, $opis_sporzadzil, $ramka_podsumowanie, 'L' ,0); 
		}



//########################################################    lewa wartości strtona podsumowania #################################################
$wysokosc_od_gory = $wysokosc_od_gory_podsumowanie + $wys_podsumowanie;
$odleglosc_od_krawedzi += $szer_podsumowanie_lewa;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->SetFont('arial_ce','', 8);
$pdf->SetFillColor(255,255,255);

//wycena podstawowa
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_wycena_podstawowa2 = $SUMA_WYCENA_PODSTAWOWA.$waluta;
$opis_wycena_podstawowa2 = iconv('UTF-8','windows-1250//TRANSLIT', $opis_wycena_podstawowa2);
$pdf->Multicell($szer_podsumowanie_lewa_wartosc, $wys_podsumowanie_opisy, $opis_wycena_podstawowa2, $ramka_podsumowanie, 'R' ,0); 

//dodatki
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_dodatki = $SUMA_DODATKI.$waluta;
$opis_dodatki = iconv('UTF-8','windows-1250//TRANSLIT', $opis_dodatki);
$pdf->Multicell($szer_podsumowanie_lewa_wartosc, $wys_podsumowanie_opisy, $opis_dodatki, $ramka_podsumowanie, 'R' ,0); 

//transport
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_transport = $transport.$waluta;
$opis_transport = iconv('UTF-8','windows-1250//TRANSLIT', $opis_transport);
$pdf->Multicell($szer_podsumowanie_lewa_wartosc, $wys_podsumowanie_opisy, $opis_transport, $ramka_podsumowanie, 'R' ,0); 

//suma
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_suma = $SUMA.$waluta;
$opis_suma = iconv('UTF-8','windows-1250//TRANSLIT', $opis_suma);
$pdf->Multicell($szer_podsumowanie_lewa_wartosc, $wys_podsumowanie_opisy, $opis_suma, $ramka_podsumowanie, 'R' ,0); 

//########################################################    srodek strtona podsumowania #################################################
//termin realizacji
$pdf->SetFont('arial_ce','B', 8);
$wysokosc_od_gory = $wysokosc_od_gory_podsumowanie + $wys_podsumowanie;
$odleglosc_od_krawedzi += $szer_podsumowanie_lewa_wartosc;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_termin_realizacji = 'Termin realizacji : ';
$opis_termin_realizacji = iconv('UTF-8','windows-1250//TRANSLIT', $opis_termin_realizacji);
$pdf->Multicell($szer_podsumowanie_srodek, $wys_podsumowanie_opisy, $opis_termin_realizacji, $ramka_podsumowanie, 'R' ,0); 

//sposób dostawy
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_sposob_dostawy = 'Sposób dostawy : ';
$opis_sposob_dostawy = iconv('UTF-8','windows-1250//TRANSLIT', $opis_sposob_dostawy);
$pdf->Multicell($szer_podsumowanie_srodek, $wys_podsumowanie_opisy, $opis_sposob_dostawy, $ramka_podsumowanie, 'R' ,0); 

//Uwagi
$wysokosc_od_gory += $wys_podsumowanie_opisy;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$opis_uwagi_stale = 'Uwagi : ';
$opis_uwagi_stale = iconv('UTF-8','windows-1250//TRANSLIT', $opis_uwagi_stale);
$pdf->Multicell($szer_podsumowanie_srodek, $wys_podsumowanie_opisy, $opis_uwagi_stale, $ramka_podsumowanie, 'R' ,0); 


//########################################################    prawa strtona podsumowania #################################################
	$pdf->SetFont('arial_ce','', 8);
	//termin realizacji
	$wysokosc_od_gory = $wysokosc_od_gory_podsumowanie + $wys_podsumowanie;
	$odleglosc_od_krawedzi += $szer_podsumowanie_srodek;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
	$opis_termin_realizacji = $termin_realizacji;
	$opis_termin_realizacji = iconv('UTF-8','windows-1250//TRANSLIT', $opis_termin_realizacji);
	$pdf->Multicell($szer_podsumowanie_prawa, $wys_podsumowanie_opisy, $opis_termin_realizacji, $ramka_podsumowanie, 'L' ,0); 

	//sposób dostawy
	$wysokosc_od_gory += $wys_podsumowanie_opisy;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
	$opis_sposob_dostawy = $sposob_dostawy;
	$opis_sposob_dostawy = iconv('UTF-8','windows-1250//TRANSLIT', $opis_sposob_dostawy);
	$pdf->Multicell($szer_podsumowanie_prawa, $wys_podsumowanie_opisy, $opis_sposob_dostawy, $ramka_podsumowanie, 'L' ,0); 

	//Uwagi
	$wysokosc_od_gory += $wys_podsumowanie_opisy;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
	$opis_uwagi_stale = 'Wszystkie kwoty netto';
	$opis_uwagi_stale = iconv('UTF-8','windows-1250//TRANSLIT', $opis_uwagi_stale);
	$pdf->Multicell($szer_podsumowanie_prawa, $wys_podsumowanie_opisy, $opis_uwagi_stale, $ramka_podsumowanie, 'L' ,0); 

	$pdf->SetFont('arial_ce','', 7);
	if($wycena_wstepna_podsumowanie_uwagi1 != '')
		{
		//Uwagi 1
		$wysokosc_od_gory += $wys_podsumowanie_opisy;
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
		$opis_uwagi1 = iconv('UTF-8','windows-1250//TRANSLIT', $wycena_wstepna_podsumowanie_uwagi1);
		$pdf->Multicell($szer_podsumowanie_prawa, $wys_podsumowanie_opisy, $opis_uwagi1, $ramka_podsumowanie, 'L' ,0); 
		}

	if($wycena_wstepna_podsumowanie_uwagi2 != '')
		{
		//Uwagi 2
		$wysokosc_od_gory += $wys_podsumowanie_opisy;
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
		$opis_uwagi2 = iconv('UTF-8','windows-1250//TRANSLIT', $wycena_wstepna_podsumowanie_uwagi2);
		$pdf->Multicell($szer_podsumowanie_prawa, $wys_podsumowanie_opisy, $opis_uwagi2, $ramka_podsumowanie, 'L' ,0); 
		}


	if($wycena_wstepna_podsumowanie_uwagi_reczne != '')
		{
		//Uwagi reczne
		$wysokosc_od_gory += $wys_podsumowanie_opisy;
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
		$opis_uwagi_reczne = iconv('UTF-8','windows-1250//TRANSLIT', $wycena_wstepna_podsumowanie_uwagi_reczne);
		$pdf->Multicell($szer_podsumowanie_prawa, $wys_podsumowanie_opisy, $opis_uwagi_reczne, $ramka_podsumowanie, 'L' ,0); 
		}



//stopka
$pdf->SetFont('arial_ce','', 8);
$pdf->SetTextColor(125,125,125);
$opis_strony = 'Strona '.$ilosc_stron;
$opis_strony = iconv('UTF-8','windows-1250//TRANSLIT', $opis_strony);
$pdf->Text($stopka_szerokosc, $stopka_wysokosc, $opis_strony);
// ########################################## KONIEC podsumowanie ######################################

$pdf->SetAuthor('ARCUS S. C.');
$pdf->SetTitle($subject);

$wycena_wstepna_wysylka2 = change_link($wycena_wstepna_wysylka); // zamieniam / na _
$nazwa_pliku = 'wycena_wstepna_'.$wycena_wstepna_wysylka2.'.pdf';
$pdf->Output("../panel_dane/pdf_wyceny_wstepne/".$nazwa_pliku."", "F");

$potwierdzenie_sciezka = '../panel_dane/pdf_wyceny_wstepne/'.$nazwa_pliku;
$filename = $nazwa_pliku;


$jest = 0;
while($jest < 2)
{
	$jest++;
	if (file_exists($filename)) $jest = 4; else sleep(2);
} 



//#################################################################################### koniec pdf - wysylka na email ####################################################################################


$subject = "Wycena wstępna ".$wycena_wstepna_wysylka;
// $subject = iconv('UTF-8','windows-1250//TRANSLIT', $subject);

$from_emailaddress = "biuro@arcus-luki.pl";
$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
$tresc_maila .= '<div align="left">ARCUS S. C.<br>Podwiesk 65D<br>86-200 Chełmno<br>Telefon 52/522-22-02<br>Fax 52/569-10-38<br></div></html>';
// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);


//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
if($adres_ip == '127.0.0.1') $email = $lokalny_adres_email;

//new phpmailer v6.16
require 'phpmailer6/src/Exception.php';
require 'phpmailer6/src/PHPMailer.php';
require 'phpmailer6/src/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->CharSet = "UTF-8";
$mail->FromName = 'ARCUS | Biuro';
$mail->From = $from_emailaddress;
$mail->AddAddress($email);
$mail->AddReplyTo($from_emailaddress,"Arcus");
$mail->Subject = $subject;
$mail->IsHTML(true);
$mail->Body = $tresc_maila;
$mail->setLanguage('pl');
$mail->AddAttachment($potwierdzenie_sciezka, $nazwa_pliku);

if(!$mail->Send()) 
	{
	$error_info = $mail->ErrorInfo;
	$strona = 'wycena_wstepna_pdf.php';
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $wycena_wstepna_nr, $email);
	} 	
else 
	{
	echo '<table width="90%" align="center" border="0" cellpadding="3" cellspacing="3"><tr><td width="65%" align="right" class="text_green">';
		echo '<br>Wycenę <font color="blue">'.$wycena_wstepna_wysylka.'</font> dla <font color="blue">'.$klient_nazwa_wycena.'</font> wysłano na adres : <font color="blue">'.$email.'</font>';
	echo '</td><td width="35%" align="left">';
		echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_wyceny_wstepne/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a>';
	echo '</td></tr></table>';
	$modyfikuj=mysqli_query($conn, "UPDATE wyceny SET link_wycena_pdf='".$nazwa_pliku."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_wysylka."' AND klient_id = ".$klient_id_wycena.";");
	}
	

?>