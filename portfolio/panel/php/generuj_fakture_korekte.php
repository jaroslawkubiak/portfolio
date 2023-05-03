<?php
// dane po korekcie
$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$zamowienie_id=$wynik33['zamowienie_id'];
	$nabywca_id=$wynik33['nabywca_id'];
	$nabywca_nazwa=$wynik33['nabywca_nazwa'];
	$nabywca_sposob_platnosci=$wynik33['nabywca_sposob_platnosci'];
	$nr_fv=$wynik33['nr_dok'];
	$termin_platnosci2=$wynik33['termin_platnosci'];
	$data_wystawienia=$wynik33['data_wystawienia'];
	$data_zakonczenia_dostawy=$wynik33['data_zakonczenia_dostawy'];
	$SUMA_wartosc_netto_korekty=$wynik33['wartosc_netto_fv'];
	$SUMA_wartosc_brutto_korekty=$wynik33['wartosc_brutto_fv'];
	$vat_faktura=$wynik33['vat'];
	$user_imie=$wynik33['user_imie'];
	$user_nazwisko=$wynik33['user_nazwisko'];
	$tytul=$wynik33['tytul_korekty'];
	$nr_fv_korygowanej=$wynik33['nr_fv_korygowanej'];
	$data_fv_korygowanej=$wynik33['data_fv_korygowanej'];
	$informacja_o_fakturze=$wynik33['informacja_o_fakturze'];
	$sprzedawca_konto=$wynik33['konto'];
	$wplacono=$wynik33['wplacono'];
	}

$ilosc_pozycji = 0;
$pytanie333 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE fv_id = ".$fv_id." ORDER BY pozycja ASC;");
while($wynik333= mysqli_fetch_assoc($pytanie333))
	{
	$ilosc_pozycji++;
	$pozycja[$ilosc_pozycji]=$wynik333['pozycja'];
	$nazwa_produktu_po_korekcie2[$ilosc_pozycji]=$wynik333['nazwa_produktu'];
	$jednostka_po_korekcie2[$ilosc_pozycji]=$wynik333['jednostka'];
	$ilosc_po_korekcie2[$ilosc_pozycji]=$wynik333['ilosc'];
	$cena_netto_po_korekcie2[$ilosc_pozycji]=$wynik333['cena_netto'];
	$VAT_po_korekcie2[$ilosc_pozycji]=$wynik333['vat'];
	$cena_brutto_po_korekcie2[$ilosc_pozycji]=$wynik333['cena_brutto'];
	$wartosc_netto_po_korekcie2[$ilosc_pozycji]=$wynik333['wartosc_netto'];
	$wartosc_brutto_po_korekcie2[$ilosc_pozycji]=$wynik333['wartosc_brutto'];
	}
	
	
// dane przed korekta
$pytanie33 = mysqli_query($conn, "SELECT wartosc_netto_fv, wartosc_brutto_fv FROM fv_naglowek WHERE nr_dok = '".$nr_fv_korygowanej."';");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$wartosc_netto_przed_korekta=$wynik33['wartosc_netto_fv'];
	$wartosc_brutto_przed_korekta=$wynik33['wartosc_brutto_fv'];
	}

$ilosc_pozycji = 0;
$pozycja = [];
$nazwa_produktu = [];
$jednostka = [];
$ilosc = [];
$cena_netto = [];
$VAT = [];
$cena_brutto = [];
$wartosc_netto = [];
$wartosc_brutto = [];
$pytanie333 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE nr_fv = '".$nr_fv_korygowanej."' ORDER BY pozycja ASC;");
while($wynik333= mysqli_fetch_assoc($pytanie333))
	{
	$ilosc_pozycji++;
	$pozycja[$ilosc_pozycji]=$wynik333['pozycja'];
	$nazwa_produktu_przed_korekta2[$ilosc_pozycji]=$wynik333['nazwa_produktu'];
	$jednostka_przed_korekta2[$ilosc_pozycji]=$wynik333['jednostka'];
	$ilosc_przed_korekta2[$ilosc_pozycji]=$wynik333['ilosc'];
	$cena_netto_przed_korekta2[$ilosc_pozycji]=$wynik333['cena_netto'];
	$VAT_przed_korekta2[$ilosc_pozycji]=$wynik333['vat'];
	$cena_brutto_przed_korekta2[$ilosc_pozycji]=$wynik333['cena_brutto'];
	$wartosc_netto_przed_korekta2[$ilosc_pozycji]=$wynik333['wartosc_netto'];
	$wartosc_brutto_przed_korekta2[$ilosc_pozycji]=$wynik333['wartosc_brutto'];
	}
	
$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$nabywca_id.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$nabywca_nazwa=$wynik33['pelna_nazwa'];
	$nabywca_kraj=$wynik33['kraj'];
	$nabywca_ulica=$wynik33['ulica'];
	$nabywca_miasto=$wynik33['miasto'];
	$nabywca_kod_pocztowy=$wynik33['kod_pocztowy'];
	$nabywca_nip=$wynik33['nip'];
	}	
	
$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET nabywca_nazwa = '".$nabywca_nazwa."' WHERE id = ".$fv_id.";");
$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET nabywca_ulica = '".$nabywca_ulica."' WHERE id = ".$fv_id.";");
$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET nabywca_miasto = '".$nabywca_miasto."' WHERE id = ".$fv_id.";");
$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET nabywca_kod_pocztowy = '".$nabywca_kod_pocztowy."' WHERE id = ".$fv_id.";");
$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET nabywca_nip = '".$nabywca_nip."' WHERE id = ".$fv_id.";");


$pytanie633 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
while($wynik633= mysqli_fetch_assoc($pytanie633))
	{
	$nr_zamowienia=$wynik633['nr_zamowienia'];
	$nr_zamowienia_klienta=$wynik633['nr_zamowienia_klienta'];
	}

//pobieramy ustawienia faktur
$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$sprzedawca_nazwa=$wynik22['nazwa'];
	$sprzedawca_ulica=$wynik22['ulica'];
	$sprzedawca_miasto=$wynik22['miasto'];
	$sprzedawca_kod_pocztowy=$wynik22['kod_pocztowy'];
	$sprzedawca_nip=$wynik22['nip'];
	$sprzedawca_miejsce_wystawienia=$wynik22['miejsce_wystawienia'];
	$sprzedawca_konto_opis=$wynik22['konto_opis'];
	$sprzedawca_opis=$wynik22['opis'];
	$sprzedawca_email=$wynik22['email'];
	$sprzedawca_telefon=$wynik22['telefon'];
	$sprzedawca_www=$wynik22['www'];
	}

require_once('pdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf = new FPDF7();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
$ilosc_stron = 1;
$aktualna_strona = 1;
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');

//sprawdzamy czy plik LOGO istnieje
$file_headers = @get_headers($logo_do_potwierdzen);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') 
    $exists = false;
else 
    $pdf->Image($logo_do_potwierdzen, 10, 5, -600);


$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);

// linie poziome
$pdf->Line(5, 40, 205, 40);
$pdf->Line(5, 50, 205, 50);

//nagłowek
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY(150,5);
$napis_sprzedawca_telefon = 'Telefon: '.$sprzedawca_telefon;
$pdf->Multicell(55, 7, $napis_sprzedawca_telefon, 0, 'R' ,0); 
$pdf->SetXY(150,12);
$napis_sprzedawca_email = 'e-mail: '.$sprzedawca_email;
$pdf->Multicell(55, 7, $napis_sprzedawca_email, 0, 'R' ,0); 
$pdf->SetFont('arial_ce','U', 8);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(150,22);
$pdf->Multicell(55, 7, $sprzedawca_www, 0, 'R' ,0); 
$pdf->SetTextColor(0,0,0);

//faktura i numer
$pdf->SetFont('arial_ce','B', 16);
$pdf->SetXY(5,40);
$napis_faktura_korygujaca = iconv('UTF-8','windows-1250//TRANSLIT', 'FAKTURA KORYGUJĄCA');
$pdf->Multicell(80, 10, $napis_faktura_korygujaca, 0, 'L' ,0); //piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane, ostatni parametr to tło
$pdf->SetXY(125,40);
$napis_nr_fv = 'Nr: '.$nr_fv;
$pdf->Multicell(80, 10, $napis_nr_fv, 0, 'R' ,0); 
$pdf->SetFont('arial_ce','', 8);

// tytuł i numer faktury korygowanej
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY(5,50);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$napis_tytul = iconv('UTF-8','windows-1250//TRANSLIT', 'Tytuł:');
$pdf->Multicell(40, 6, $napis_tytul, 0, 'L' ,0); 
$napis_tytul2 = iconv('UTF-8','windows-1250//TRANSLIT', $tytul);
$pdf->SetFont('arial_ce','B', 8);
$pdf->SetXY(45,50);
$pdf->Multicell(80, 6, $napis_tytul2, 0, 'L' ,0); 

$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY(5,55);
$pdf->Multicell(40, 6, 'Faktura korygowana:', 0, 'L' ,0); 
$pdf->SetXY(45,55);
$napis_numer_data_fv = $nr_fv_korygowanej.' z dnia '.$data_fv_korygowanej;
$napis_numer_data_fv = iconv('UTF-8','windows-1250//TRANSLIT', $napis_numer_data_fv);
$pdf->SetFont('arial_ce','B', 8);
$pdf->Multicell(80, 6, $napis_numer_data_fv, 0, 'L' ,0); 

//sprzedawca
$wysokosc_ramki_sprzedawca = 62;
$pdf->SetXY(5,$wysokosc_ramki_sprzedawca);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('arial_ce','B', 10);
$pdf->Multicell(95, 5, 'SPRZEDAWCA', 1, 'C' ,1); 
$wysokosc_ramki_sprzedawca += 5;
$pdf->SetXY(5,$wysokosc_ramki_sprzedawca);
$pdf->Multicell(95, 28, '', 1, 'C' ,0); 
$pdf->SetXY(5,$wysokosc_ramki_sprzedawca);
$pdf->SetFont('arial_ce','B', 8);

$napis_sprzedawca_nazwa = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_nazwa);
$pdf->Multicell(95, 5, $napis_sprzedawca_nazwa, 0, 'L' ,0); 
$wysokosc_ramki_sprzedawca += 12;
$pdf->SetXY(5,$wysokosc_ramki_sprzedawca);
$napis_sprzedawca_ulica = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_ulica);
$pdf->Multicell(95, 5, $napis_sprzedawca_ulica, 0, 'L' ,0); 
$wysokosc_ramki_sprzedawca += 5;
$pdf->SetXY(5,$wysokosc_ramki_sprzedawca);
$napis_sprzedawca_adres = $sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.', Polska';
$napis_sprzedawca_adres = iconv('UTF-8','windows-1250//TRANSLIT', $napis_sprzedawca_adres);
$pdf->Multicell(95, 5, $napis_sprzedawca_adres, 0, 'L' ,0); 
$wysokosc_ramki_sprzedawca += 5;
$pdf->SetXY(5,$wysokosc_ramki_sprzedawca);
$napis_sprzedawca_nip = 'NIP '.$sprzedawca_nip;
$pdf->Multicell(95, 5, $napis_sprzedawca_nip, 0, 'L' ,0); 

//nabywca
$wysokosc_ramki_nabywca = 62;
$pdf->SetXY(110,$wysokosc_ramki_nabywca);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('arial_ce','B', 10);
$pdf->Multicell(95, 5, 'NABYWCA', 1, 'C' ,1); 
$wysokosc_ramki_nabywca += 5;
$pdf->SetXY(110,$wysokosc_ramki_nabywca);
$pdf->Multicell(95, 28, '', 1, 'C' ,0); 
$pdf->SetXY(110,$wysokosc_ramki_nabywca);
$pdf->SetFont('arial_ce','B', 8);
$napis_nabywca_nazwa = iconv('UTF-8','windows-1250//TRANSLIT', $nabywca_nazwa);
$pdf->Multicell(95, 5, $napis_nabywca_nazwa, 0, 'L' ,0); 
$wysokosc_ramki_nabywca += 12;
$pdf->SetXY(110,$wysokosc_ramki_nabywca);
$napis_nabywca_ulica = iconv('UTF-8','windows-1250//TRANSLIT', $nabywca_ulica);
$pdf->Multicell(95, 5, $napis_nabywca_ulica, 0, 'L' ,0); 
$wysokosc_ramki_nabywca += 5;
$pdf->SetXY(110,$wysokosc_ramki_nabywca);
$napis_nabywca_adres = $nabywca_kod_pocztowy.' '.$nabywca_miasto.', '.$nabywca_kraj;
$napis_nabywca_adres = iconv('UTF-8','windows-1250//TRANSLIT', $napis_nabywca_adres);
$pdf->Multicell(95, 5, $napis_nabywca_adres, 0, 'L' ,0); 
$wysokosc_ramki_nabywca += 5;
$pdf->SetXY(110,$wysokosc_ramki_nabywca);
$napis_nabywca_nip = 'NIP '.$nabywca_nip;
$pdf->Multicell(95, 5, $napis_nabywca_nip, 0, 'L' ,0); 

//dane i miejsce wystawienia pod ramkami
$wys_ramki = 5;
$wys_poczatkowa = 98;
$szer_ramki = 35;
$obramowanie = 0;
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY(5, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Miejsce wystawienia:', $obramowanie, 'L' ,0);
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(5, $wys_poczatkowa);
$napis_termin_platnosci = iconv('UTF-8','windows-1250//TRANSLIT', 'Termin płatności:');
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_termin_platnosci, $obramowanie, 'L' ,0); 
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(5, $wys_poczatkowa);
$napis_forma_platnosci = iconv('UTF-8','windows-1250//TRANSLIT', 'Forma płatności:');
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_forma_platnosci, $obramowanie, 'L' ,0); 

$pdf->SetFont('arial_ce','B', 8);
$wys_poczatkowa = 98;
$szer_ramki = 60;
$pdf->SetXY(40, $wys_poczatkowa);
$napis_sprzedawca_miejsce_wystawienia = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_miejsce_wystawienia);
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_sprzedawca_miejsce_wystawienia, $obramowanie, 'L' ,0);
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(40, $wys_poczatkowa);
$termin_platnosci2 = date('d-m-Y', $termin_platnosci2);
$pdf->Multicell($szer_ramki, $wys_ramki, $termin_platnosci2, $obramowanie, 'L' ,0); 
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(40, $wys_poczatkowa);
$napis_nabywca_sposob_platnosci = iconv('UTF-8','windows-1250//TRANSLIT', $nabywca_sposob_platnosci);
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_nabywca_sposob_platnosci, $obramowanie, 'L' ,0); 

$wys_ramki = 5;
$wys_poczatkowa = 98;
$szer_ramki = 65;
$obramowanie = 0;
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY(110, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Data wystawienia:', $obramowanie, 'R' ,0);
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(110, $wys_poczatkowa);
$napis_data_zakonczenia = iconv('UTF-8','windows-1250//TRANSLIT', 'Data zakończenia dostawy/usług:');
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_data_zakonczenia, $obramowanie, 'R' ,0); 

$pdf->SetFont('arial_ce','B', 8);
$wys_poczatkowa = 98;
$szer_ramki = 27;
$pdf->SetXY(178, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $data_wystawienia, $obramowanie, 'R' ,0);
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(178, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $data_zakonczenia_dostawy, $obramowanie, 'R' ,0); 

//############################    dane faktury - nazwy pozycje
$pdf->SetFillColor(220,220,220);
$wys_ramki = 5;
$wys_poczatkowa += 12;
$szer_poczatkowa = 5;
$obramowanie = 1;
$wys_ramki_naglowek = 10;
$szer_ramki_lp = 8;
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki_lp, $wys_ramki_naglowek, 'Lp.', $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki_lp;
$szer_ramki_towar = 64;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis_towar_usluga = iconv('UTF-8','windows-1250//TRANSLIT', 'Towar / Usługa');
$pdf->Multicell($szer_ramki_towar, $wys_ramki_naglowek, $napis_towar_usluga , $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki_towar;
$szer_ramki_jedn = 18;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki_jedn, $wys_ramki_naglowek, 'Jednostka', $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki_jedn;
$szer_ramki = 15;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis_ilosc = iconv('UTF-8','windows-1250//TRANSLIT', 'Ilość');
$pdf->Multicell($szer_ramki, $wys_ramki_naglowek, $napis_ilosc, $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki;
$szer_ramki = 15;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, 10, '', 1, 'C' ,1);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Cena', 0, 'C' ,0);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa+5);
$pdf->Multicell($szer_ramki, $wys_ramki, 'netto', 0, 'C' ,0);

$szer_poczatkowa += $szer_ramki;
$szer_ramki = 15;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki_naglowek, 'VAT', $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki;
$szer_ramki = 15;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, 10, '', 1, 'C' ,1);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Cena', 0, 'C' ,0);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa+5);
$pdf->Multicell($szer_ramki, $wys_ramki, 'brutto', 0, 'C' ,0);

$szer_poczatkowa += $szer_ramki;
$szer_ramki_wart_netto = 25;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis_wart_net = iconv('UTF-8','windows-1250//TRANSLIT', 'Wartość netto');
$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki_naglowek, $napis_wart_net, $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki_wart_netto;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis_wart_bru = iconv('UTF-8','windows-1250//TRANSLIT', 'Wartość brutto');
$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki_naglowek, $napis_wart_bru, $obramowanie, 'C' ,1);

//###############################    pozycje faktury     ########################################
$wys_ramki = 5;
$wys_poczatkowa += 10;
$obramowanie = 0;
$obramowanie2 = 0;
$obramowanie3 = 1;
$SUMA_vat_po_korekcie = 0;
for($x = 1; $x <= $ilosc_pozycji; $x++)
	{
	$cena_netto_korekta[$x] = $cena_netto_po_korekcie2[$x] - $cena_netto_przed_korekta2[$x];
	$cena_brutto_korekta[$x] = $cena_brutto_po_korekcie2[$x] - $cena_brutto_przed_korekta2[$x];
	$wartosc_netto_korekta[$x] = $wartosc_netto_po_korekcie2[$x] - $wartosc_netto_przed_korekta2[$x];
	$wartosc_brutto_korekta[$x] = $wartosc_brutto_po_korekcie2[$x] - $wartosc_brutto_przed_korekta2[$x];
	
	$pdf->SetFont('arial_ce','', 8);
	$szer_poczatkowa = 5;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_lp, $wys_ramki, '', $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_lp;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$nazwa_produktu = iconv('UTF-8','windows-1250//TRANSLIT', $nazwa_produktu_przed_korekta2[$x]);
	$pdf->Multicell($szer_ramki_towar, $wys_ramki, $nazwa_produktu, $obramowanie, 'L' ,0);
	
	$szer_poczatkowa += $szer_ramki_towar;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_jedn, $wys_ramki, $jednostka_przed_korekta2[$x], $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_jedn;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$ilosc_przed_korekta2[$x] = number_format($ilosc_przed_korekta2[$x], 2,'.','');
	$pdf->Multicell($szer_ramki, $wys_ramki, $ilosc_przed_korekta2[$x], $obramowanie, 'R' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_netto_przed_korekta2[$x] = number_format($cena_netto_przed_korekta2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_netto_przed_korekta2[$x], $obramowanie, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	if($VAT_przed_korekta2[$x] == 'NP') $VAT_przed_korekta2[$x] = $VAT_przed_korekta2[$x];
	else $VAT_przed_korekta2[$x] = $VAT_przed_korekta2[$x].'%';
	$pdf->Multicell($szer_ramki, $wys_ramki, $VAT_przed_korekta2[$x], $obramowanie, 'C' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_brutto_przed_korekta2[$x] = number_format($cena_brutto_przed_korekta2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_brutto_przed_korekta2[$x], $obramowanie, 'R' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_netto_przed_korekta2[$x] = number_format($wartosc_netto_przed_korekta2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_netto_przed_korekta2[$x], $obramowanie, 'R' ,0);

	$szer_poczatkowa += $szer_ramki_wart_netto;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_brutto_przed_korekta2[$x] = number_format($wartosc_brutto_przed_korekta2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_brutto_przed_korekta2[$x], $obramowanie, 'R' ,0);
	
	// wiersz korekta
	$pdf->SetFont('arial_ce','', 8);
	$szer_poczatkowa = 5;
	$wys_poczatkowa += $wys_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_lp, $wys_ramki, $x, $obramowanie2, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_lp;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	
	$pdf->SetFont('arial_ce','i', 6);
	$pdf->Multicell($szer_ramki_towar, $wys_ramki, 'korekta', $obramowanie2, 'R' ,0);
	
	$pdf->SetFont('arial_ce','', 8);
	$szer_poczatkowa += $szer_ramki_towar;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_jedn, $wys_ramki, '', $obramowanie2, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_jedn;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$ilosc[$x] = number_format($ilosc[$x], 2,'.','');
	$pdf->Multicell($szer_ramki, $wys_ramki, '', $obramowanie2, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_netto_korekta[$x] = number_format($cena_netto_korekta[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_netto_korekta[$x], $obramowanie2, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	if($VAT[$x] == 'NP') $VAT[$x] = $VAT[$x];
	else $VAT[$x] = $VAT[$x].'%';
	$pdf->Multicell($szer_ramki, $wys_ramki, '', $obramowanie2, 'C' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_brutto_korekta[$x] = number_format($cena_brutto_korekta[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_brutto_korekta[$x], $obramowanie2, 'R' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_netto_korekta[$x] = number_format($wartosc_netto_korekta[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_netto_korekta[$x], $obramowanie2, 'R' ,0);

	$szer_poczatkowa += $szer_ramki_wart_netto;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_brutto_korekta[$x] = number_format($wartosc_brutto_korekta[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_brutto_korekta[$x], $obramowanie2, 'R' ,0);
		
	// wiersz po korekcie
	$pdf->SetFont('arial_ce','', 8);
	$szer_poczatkowa = 5;
	$wys_poczatkowa += $wys_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_lp, $wys_ramki, '', $obramowanie2, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_lp;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	
	$pdf->SetFont('arial_ce','i', 6);
	$pdf->Multicell($szer_ramki_towar, $wys_ramki, 'po korekcie', $obramowanie2, 'R' ,0);
	
	$pdf->SetFont('arial_ce','', 8);
	$szer_poczatkowa += $szer_ramki_towar;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_jedn, $wys_ramki, $jednostka_po_korekcie2[$x], $obramowanie2, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_jedn;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$ilosc_po_korekcie2[$x] = number_format($ilosc_po_korekcie2[$x], 2,'.','');
	$pdf->Multicell($szer_ramki, $wys_ramki, $ilosc_po_korekcie2[$x], $obramowanie2, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_netto_po_korekcie2[$x] = number_format($cena_netto_po_korekcie2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_netto_po_korekcie2[$x], $obramowanie2, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	if($VAT_po_korekcie2[$x] == 'NP') $VAT_po_korekcie2[$x] = $VAT_po_korekcie2[$x];
	else $VAT_po_korekcie2[$x] = $VAT_po_korekcie2[$x].'%';
	
	$pdf->Multicell($szer_ramki, $wys_ramki, $VAT_po_korekcie2[$x], $obramowanie2, 'C' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_brutto_po_korekcie2[$x] = number_format($cena_brutto_po_korekcie2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_brutto_po_korekcie2[$x], $obramowanie2, 'R' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_netto_po_korekcie2[$x] = number_format($wartosc_netto_po_korekcie2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_netto_po_korekcie2[$x], $obramowanie2, 'R' ,0);

	$szer_poczatkowa += $szer_ramki_wart_netto;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_brutto_po_korekcie2[$x] = number_format($wartosc_brutto_po_korekcie2[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_brutto_po_korekcie2[$x], $obramowanie2, 'R' ,0);

	// ##################################       RAMKA DLA 3 wierszy
	$szer_poczatkowa = 5;
	$wys_poczatkowa  = $wys_poczatkowa - $wys_ramki - $wys_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_lp, $wys_ramki*3, '', $obramowanie3, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_lp;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_towar, $wys_ramki*3, '', $obramowanie3, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki_towar;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_jedn, $wys_ramki*3, '', $obramowanie3, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_jedn;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki, $wys_ramki*3, '', $obramowanie3, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki, $wys_ramki*3, '', $obramowanie3, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki, $wys_ramki*3, '', $obramowanie3, 'C' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki, $wys_ramki*3, '', $obramowanie3, 'R' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki*3, '', $obramowanie3, 'R' ,0);

	$szer_poczatkowa += $szer_ramki_wart_netto;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki*3, '', $obramowanie3, 'R' ,0);
	
	$wys_poczatkowa += $wys_ramki;
	$wys_poczatkowa += $wys_ramki;
	$wys_poczatkowa += $wys_ramki;
	if($wys_poczatkowa > 250)
		{
		$ilosc_stron = 2;
		$pdf->SetFont('arial_ce','', 8);
		$napis_strona = 'Strona '.$aktualna_strona.'/'.$ilosc_stron;
		$pdf->Text(98,292, $napis_strona);
		
		$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
		$aktualna_strona = 2;
		$wys_poczatkowa = 5;
		}
		
	}

	if($wys_poczatkowa > 240)
		{
		$ilosc_stron = 2;
		$pdf->SetFont('arial_ce','', 8);
		$napis_strona = 'Strona '.$aktualna_strona.'/'.$ilosc_stron;
		$pdf->Text(98,292, $napis_strona);
		
		$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
		$aktualna_strona = 2;
		$wys_poczatkowa = 5;
		}


// obliczenia
$SUMA_vat_przed_korekta = $wartosc_brutto_przed_korekta - $wartosc_netto_przed_korekta;
$SUMA_vat_po_korekcie = $SUMA_wartosc_brutto_korekty - $SUMA_wartosc_netto_korekty;
$SUMA_netto_korekta = $SUMA_wartosc_netto_korekty - $wartosc_netto_przed_korekta;
$SUMA_brutto_korekta = $SUMA_wartosc_brutto_korekty - $wartosc_brutto_przed_korekta;
$SUMA_vat_korekta = $SUMA_vat_po_korekcie - $SUMA_vat_przed_korekta;

// $DO_ZWROTU = $SUMA_brutto_korekta * (-1);
$DO_ZWROTU = $SUMA_brutto_korekta - $wplacono; //pomniejszamy kwote korekty o wartosc wplaconą.
$DO_ZWROTU = number_format($DO_ZWROTU, 2,'.',' ');

// SUMA WEDŁUG STAWEK VAT
$wys_poczatkowa += $wys_ramki;
$wys_poczatkowa_kopia = $wys_poczatkowa;
$obramowanie = 1;
$szerokosc_tabelki2 = 100;
$szer_ramki = 25;
$szer_poczatkowa = 105;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis_suma_wedlug_stawek_vat = iconv('UTF-8','windows-1250//TRANSLIT', 'SUMA WEDŁUG STAWEK VAT');
$pdf->Multicell($szerokosc_tabelki2, $wys_ramki, $napis_suma_wedlug_stawek_vat, $obramowanie, 'C' ,0); 
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Netto', $obramowanie, 'C' ,1); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Stawka VAT', $obramowanie, 'C' ,1); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Kwota VAT', $obramowanie, 'C' ,1); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Brutto', $obramowanie, 'C' ,1); 

//przed korektą
$SUMA_vat_przed_korekta = number_format($SUMA_vat_przed_korekta, 2,'.',' ');
$wartosc_netto_przed_korekta = number_format($wartosc_netto_przed_korekta, 2,'.',' ');
$wartosc_brutto_przed_korekta = number_format($wartosc_brutto_przed_korekta, 2,'.',' ');
$szer_poczatkowa = 105;
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(60, $wys_poczatkowa);
$pdf->SetFont('arial_ce','i', 6);
$napis_przed_korekta = iconv('UTF-8','windows-1250//TRANSLIT', 'przed korektą:');
$pdf->Multicell(45, $wys_ramki, $napis_przed_korekta, 0, 'R' ,0); 
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $wartosc_netto_przed_korekta, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);

if($vat_faktura == 'NP') $napis_vat_faktura = $vat_faktura;
else $napis_vat_faktura = $vat_faktura.'%';

$pdf->Multicell($szer_ramki, $wys_ramki*3, $napis_vat_faktura, $obramowanie, 'C' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_vat_przed_korekta, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $wartosc_brutto_przed_korekta, $obramowanie, 'R' ,0); 

// korekta
$SUMA_brutto_korekta = number_format($SUMA_brutto_korekta, 2,'.',' ');
$SUMA_netto_korekta = number_format($SUMA_netto_korekta, 2,'.',' ');
$SUMA_vat_korekta = number_format($SUMA_vat_korekta, 2,'.',' ');

$szer_poczatkowa = 105;
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(60, $wys_poczatkowa);
$pdf->SetFont('arial_ce','i', 6);
$pdf->Multicell(45, $wys_ramki, 'korekta:', 0, 'R' ,0); 
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_netto_korekta, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_vat_korekta, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_brutto_korekta, $obramowanie, 'R' ,0); 

// po korekcie
$SUMA_vat_po_korekcie = number_format($SUMA_vat_po_korekcie, 2,'.',' ');
$SUMA_wartosc_netto_korekty = number_format($SUMA_wartosc_netto_korekty, 2,'.',' ');
$SUMA_wartosc_brutto_korekty = number_format($SUMA_wartosc_brutto_korekty, 2,'.',' ');
$szer_poczatkowa = 105;
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(60, $wys_poczatkowa);
$pdf->SetFont('arial_ce','i', 6);
$pdf->Multicell(45, $wys_ramki, 'po korekcie:', 0, 'R' ,0); 
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_wartosc_netto_korekty, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_vat_po_korekcie, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_wartosc_brutto_korekty, $obramowanie, 'R' ,0); 

// RAZEM
$szer_poczatkowa = 105;
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(60, $wys_poczatkowa);
$pdf->SetFont('arial_ce','B', 8);
$pdf->Multicell(45, $wys_ramki, 'RAZEM:', 0, 'R' ,0); 
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_netto_korekta, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_vat_korekta, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $SUMA_brutto_korekta, $obramowanie, 'R' ,0); 


	if($wys_poczatkowa > 259)
		{
		$ilosc_stron = 2;
		$pdf->SetFont('arial_ce','', 8);
		$napis_strona = 'Strona '.$aktualna_strona.'/'.$ilosc_stron;
		$pdf->Text(98,292, $napis_strona);
		
		$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
		$aktualna_strona = 2;
		$wys_poczatkowa = 5;
		}

// do zwrotu
$szerokosc_tabelki2 = 100;
$szer_ramki = 35;
$wys_poczatkowa2 = $wys_poczatkowa + 10;
$szer_poczatkowa = 140;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
//jak SUMA_NETTO_KOREKTA jest > 0 to napis do zapłaty, jak < 0 to do zwrotu.
if($SUMA_brutto_korekta < 0) $napis_do_zaplaty = 'DO ZWROTU';
if($SUMA_brutto_korekta > 0) $napis_do_zaplaty = 'DO ZAPŁATY';
$napis_do_zaplaty = iconv('UTF-8','windows-1250//TRANSLIT', $napis_do_zaplaty);


$pdf->Multicell($szer_ramki, $wys_ramki, $napis_do_zaplaty, $obramowanie, 'C' ,1);
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$pdf->Multicell(30, $wys_ramki, 'WALUTA', $obramowanie, 'C' ,1);

$wys_poczatkowa2 += $wys_ramki;
$szer_poczatkowa = 140;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$pdf->Multicell($szer_ramki, $wys_ramki, $DO_ZWROTU, $obramowanie, 'C' ,0);
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$pdf->Multicell(30, $wys_ramki, 'PLN', $obramowanie, 'C' ,0);



$szer_poczatkowa += 15;
if($wys_poczatkowa > 275)
	{
	$ilosc_stron = 2;
	$pdf->SetFont('arial_ce','', 8);
	$napis_strona = 'Strona '.$aktualna_strona.'/'.$ilosc_stron;
	$pdf->Text(98,292, $napis_strona);
	
	$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
	$aktualna_strona = 2;
	$wys_poczatkowa = -20;
	}


// info o fakturze
$wys_ramki = 5;
$obramowanie = 1;
$szerokosc_tabelki = 80;

if($informacja_o_fakturze != '')
	{
	$wys_poczatkowa += 5;
	$pdf->SetXY(5, $wys_poczatkowa);
	$napis_informacja_o_fakturze = iconv('UTF-8','windows-1250//TRANSLIT', $informacja_o_fakturze);
	$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $napis_informacja_o_fakturze, 0, 'L' ,0);
	}

$pdf->SetFont('arial_ce','', 8);
$wys_poczatkowa = 245;
$pdf->SetXY(5, $wys_poczatkowa);
$napis_sprzedawca_opis = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_opis);
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $napis_sprzedawca_opis, 0, 'L' ,0);




$pdf->SetXY(5, 269);
$napis_wystawil = $user_imie.' '.$user_nazwisko;
$napis_wystawil = iconv('UTF-8','windows-1250//TRANSLIT', $napis_wystawil);
$pdf->Multicell(90, 5, $napis_wystawil, 0, 'C' ,0); 

$pdf->SetFont('arial_ce','', 8);
$wysokosc = 285;
//$pdf->Line(5, $wysokosc, 95, $wysokosc);
//$pdf->Line(115, $wysokosc, 205, $wysokosc);
$napis_fv_wystawil = iconv('UTF-8','windows-1250//TRANSLIT', 'wystawił');
$napis_fv_odebral = iconv('UTF-8','windows-1250//TRANSLIT', 'odebrał');
$pdf->Text(45,288, $napis_fv_wystawil);
$pdf->Text(155,288, $napis_fv_odebral);
$pdf->Text(5,285, '....................................................................................................................');
$pdf->Text(115,285, '....................................................................................................................');

$pdf->SetFont('arial_ce','', 8);
$napis_strona = 'Strona '.$aktualna_strona.'/'.$ilosc_stron;
$pdf->Text(98,292, $napis_strona);

$nr_fv_oryginalny = $nr_fv;
$nr_fv = change_link($nr_fv); // zamieniam / na _
$nazwa_pliku = 'korekta_'.$nr_fv.'.pdf';
$pdf->Output("../panel_dane/faktury_korekty/".$nazwa_pliku."", "F");
?>