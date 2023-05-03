 <?php
$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$zamowienie_id=$wynik33['zamowienie_id'];
	$nabywca_id=$wynik33['nabywca_id'];
	$nabywca_nazwa=$wynik33['nabywca_nazwa'];
	$nabywca_nip=$wynik33['nabywca_nip'];
	$nabywca_sposob_platnosci=$wynik33['nabywca_sposob_platnosci'];
	$nr_fv=$wynik33['nr_dok'];
	$termin_platnosci2=$wynik33['termin_platnosci'];
	$data_wystawienia=$wynik33['data_wystawienia'];
	$data_zakonczenia_dostawy=$wynik33['data_zakonczenia_dostawy'];
	$wartosc_netto_fv=$wynik33['wartosc_netto_fv'];
	$wartosc_brutto_fv=$wynik33['wartosc_brutto_fv'];
	$vat_faktura=$wynik33['vat'];
	$wplacono=$wynik33['wplacono'];
	$user_imie=$wynik33['user_imie'];
	$user_nazwisko=$wynik33['user_nazwisko'];
	$informacja_o_fakturze=$wynik33['informacja_o_fakturze'];
	$sprzedawca_konto=$wynik33['konto'];
	}

//pobieram zawsze świeżee dane z tabeli klientów
$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$nabywca_id.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$nabywca_kraj=$wynik33['kraj'];
	$nabywca_ulica=$wynik33['ulica'];
	$nabywca_miasto=$wynik33['miasto'];
	$nabywca_kod_pocztowy=$wynik33['kod_pocztowy'];
	$nabywca_nip=$wynik33['nip'];
	}	
	
	
$pytanie633 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
while($wynik633= mysqli_fetch_assoc($pytanie633))
	{
	$nr_zamowienia=$wynik633['nr_zamowienia'];
	$kurs_euro=$wynik633['kurs_euro'];
	$nr_zamowienia_klienta=$wynik633['nr_zamowienia_klienta'];
	}
	
$wartosc_netto_fv=$wartosc_netto_fv/$kurs_euro;
$wartosc_brutto_fv=$wartosc_brutto_fv/$kurs_euro;
$wplacono=$wplacono/$kurs_euro;
$do_zaplaty2 = $wartosc_brutto_fv - $wplacono;
	
	
$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$sprzedawca_nazwa=$wynik22['nazwa'];
	$sprzedawca_ulica=$wynik22['ulica'];
	$sprzedawca_miasto=$wynik22['miasto'];
	$sprzedawca_kod_pocztowy=$wynik22['kod_pocztowy'];
	$sprzedawca_nip=$wynik22['nip'];
	// $sprzedawca_kraj=$wynik22['kraj'];
	$sprzedawca_miejsce_wystawienia=$wynik22['miejsce_wystawienia'];
	$sprzedawca_konto_opis=$wynik22['konto_opis'];
	//$sprzedawca_konto=$wynik22['konto'];
	$sprzedawca_opis=$wynik22['opis'];
	$sprzedawca_email=$wynik22['email'];
	$sprzedawca_telefon=$wynik22['telefon'];
	$sprzedawca_www=$wynik22['www'];
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
$pytanie333 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE fv_id = ".$fv_id." ORDER BY pozycja ASC;");
while($wynik333= mysqli_fetch_assoc($pytanie333))
	{
	$ilosc_pozycji++;
	$pozycja[$ilosc_pozycji]=$wynik333['pozycja'];
	$nazwa_produktu[$ilosc_pozycji]=$wynik333['nazwa_produktu'];
	$jednostka[$ilosc_pozycji]=$wynik333['jednostka'];
	$ilosc[$ilosc_pozycji]=$wynik333['ilosc'];
	$cena_netto[$ilosc_pozycji]=$wynik333['cena_netto'];
	$cena_netto[$ilosc_pozycji]=$cena_netto[$ilosc_pozycji]/$kurs_euro;
	$VAT[$ilosc_pozycji]=$wynik333['vat'];
	$cena_brutto[$ilosc_pozycji]=$wynik333['cena_brutto'];
	$cena_brutto[$ilosc_pozycji]=$cena_brutto[$ilosc_pozycji]/$kurs_euro;
	$wartosc_netto[$ilosc_pozycji]=$wynik333['wartosc_netto'];
	$wartosc_netto[$ilosc_pozycji]=$wartosc_netto[$ilosc_pozycji]/$kurs_euro;
	$wartosc_brutto[$ilosc_pozycji]=$wynik333['wartosc_brutto'];
	$wartosc_brutto[$ilosc_pozycji]=$wartosc_brutto[$ilosc_pozycji]/$kurs_euro;
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
	{
    $exists = false;
	}
else 
	{
    $pdf->Image($logo_do_potwierdzen, 10, 5, -600);
	}


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
$pdf->Multicell(80, 10, 'FAKTURA', 0, 'L' ,0); //piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane, ostatni parametr to tło
$pdf->SetXY(125,40);
$napis_nr_fv = 'Nr: '.$nr_fv;
$pdf->Multicell(80, 10, $napis_nr_fv, 0, 'R' ,0); 
$pdf->SetFont('arial_ce','', 8);

//sprzedawca
$pdf->SetXY(5,55);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('arial_ce','B', 10);
$pdf->Multicell(95, 5, 'SPRZEDAWCA', 1, 'C' ,1); 
$pdf->SetXY(5,60);
$pdf->Multicell(95, 28, '', 1, 'C' ,0); 
$pdf->SetXY(5,60);
$pdf->SetFont('arial_ce','B', 8);


$napis_sprzedawca_nazwa = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_nazwa);
$pdf->Multicell(95, 5, $napis_sprzedawca_nazwa, 0, 'L' ,0); 
$pdf->SetXY(5,72);
$napis_sprzedawca_ulica = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_ulica);
$pdf->Multicell(95, 5, $napis_sprzedawca_ulica, 0, 'L' ,0); 
$pdf->SetXY(5,77);
$napis_sprzedawca_adres = $sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.', Polska';
$napis_sprzedawca_adres = iconv('UTF-8','windows-1250//TRANSLIT', $napis_sprzedawca_adres);
$pdf->Multicell(95, 5, $napis_sprzedawca_adres, 0, 'L' ,0); 
$pdf->SetXY(5,82);
$napis_sprzedawca_nip = 'NIP '.$sprzedawca_nip;
$pdf->Multicell(95, 5, $napis_sprzedawca_nip, 0, 'L' ,0); 

//nabywca
$pdf->SetXY(110,55);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('arial_ce','B', 10);
$pdf->Multicell(95, 5, 'NABYWCA', 1, 'C' ,1); 
$pdf->SetXY(110,60);
$pdf->Multicell(95, 28, '', 1, 'C' ,0); 
$pdf->SetXY(110,60);
$pdf->SetFont('arial_ce','B', 8);
$napis_nabywca_nazwa = iconv('UTF-8','windows-1250//TRANSLIT', $nabywca_nazwa);
$pdf->Multicell(95, 5, $napis_nabywca_nazwa, 0, 'L' ,0); 
$pdf->SetXY(110,72);
$napis_nabywca_ulica = iconv('UTF-8','windows-1250//TRANSLIT', $nabywca_ulica);
$pdf->Multicell(95, 5, $napis_nabywca_ulica, 0, 'L' ,0); 
$pdf->SetXY(110,77);
$napis_nabywca_adres = $nabywca_kod_pocztowy.' '.$nabywca_miasto.', '.$nabywca_kraj;
$napis_nabywca_adres = iconv('UTF-8','windows-1250//TRANSLIT', $napis_nabywca_adres);
$pdf->Multicell(95, 5, $napis_nabywca_adres, 0, 'L' ,0); 
$pdf->SetXY(110,82);
$napis_nabywca_nip = 'NIP '.$nabywca_nip;
$pdf->Multicell(95, 5, $napis_nabywca_nip, 0, 'L' ,0); 



//dane pod ramkami
$wys_ramki = 5;
$wys_poczatkowa = 92;
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
$wys_poczatkowa = 92;
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
$wys_poczatkowa = 92;
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
$wys_poczatkowa = 92;
$szer_ramki = 27;
$pdf->SetXY(178, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $data_wystawienia, $obramowanie, 'R' ,0);
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(178, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $data_zakonczenia_dostawy, $obramowanie, 'R' ,0); 


//dane faktury - nazwy pozycje
$pdf->SetFillColor(220,220,220);
$wys_ramki = 5;
$wys_poczatkowa = 108;
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
$wys_poczatkowa = 118;
$obramowanie = 1;
	
for($x = 1; $x <= $ilosc_pozycji; $x++)
	{
	$szer_poczatkowa = 5;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_lp, $wys_ramki, $x, $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_lp;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$nazwa_produktu_napis = iconv('UTF-8','windows-1250//TRANSLIT', $nazwa_produktu[$x]);
	$pdf->Multicell($szer_ramki_towar, $wys_ramki, $nazwa_produktu_napis, $obramowanie, 'L' ,0);
	
	$szer_poczatkowa += $szer_ramki_towar;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_jedn, $wys_ramki, $jednostka[$x], $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_jedn;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$ilosc[$x] = number_format($ilosc[$x], 2,'.','');
	$pdf->Multicell($szer_ramki, $wys_ramki, $ilosc[$x], $obramowanie, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_netto[$x] = number_format($cena_netto[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_netto[$x], $obramowanie, 'R' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);

	if($VAT[$x] == 'NP') $napis_vat_faktura1 = $VAT[$x];
	else $napis_vat_faktura1 = $VAT[$x].'%';

	$VAT[$x] = $VAT[$x].'%';
	$pdf->Multicell($szer_ramki, $wys_ramki, $napis_vat_faktura1, $obramowanie, 'C' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$cena_brutto[$x] = number_format($cena_brutto[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki, $wys_ramki, $cena_brutto[$x], $obramowanie, 'R' ,0);

	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_netto[$x], $obramowanie, 'R' ,0);

	$szer_poczatkowa += $szer_ramki_wart_netto;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$wartosc_brutto[$x] = number_format($wartosc_brutto[$x], 2,'.',' ');
	$pdf->Multicell($szer_ramki_wart_netto, $wys_ramki, $wartosc_brutto[$x], $obramowanie, 'R' ,0);

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
	

// podsumowanie pozycji
$wys_ramki = 5;
$obramowanie = 1;
$pdf->SetFont('arial_ce','B', 8);
$pdf->SetXY(5, $wys_poczatkowa);
$kwota_brutto_slownie = kwotaslownieeuro($wartosc_brutto_fv);
$kwota_slownie_tekst = 'Razem słownie : '.$kwota_brutto_slownie;
$kwota_slownie_tekst = iconv('UTF-8','windows-1250//TRANSLIT', $kwota_slownie_tekst);
$pdf->Multicell(120, $wys_ramki, $kwota_slownie_tekst, $obramowanie, 'L' ,0);

$pdf->SetXY(125, $wys_poczatkowa);
$pdf->Multicell(30, $wys_ramki, 'Razem w EUR:', 0, 'R' ,0);

$kwota_vat = $wartosc_brutto_fv - $wartosc_netto_fv;
$pdf->SetXY(155, $wys_poczatkowa);
$wartosc_netto_fv = number_format($wartosc_netto_fv, 2,'.',' ');
$pdf->Multicell(25, $wys_ramki, $wartosc_netto_fv, $obramowanie, 'R' ,0);

$pdf->SetXY(180, $wys_poczatkowa);
$wartosc_brutto_fv = number_format($wartosc_brutto_fv, 2,'.',' ');
$pdf->Multicell(25, $wys_ramki, $wartosc_brutto_fv, $obramowanie, 'R' ,0);

// info o wpłacie na konto
$wys_ramki = 5;
$obramowanie = 1;
$wys_poczatkowa += 15;
$szerokosc_tabelki = 80;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('arial_ce','B', 10);
$pdf->SetXY(5, $wys_poczatkowa);
$napis_wplata_na_konto = iconv('UTF-8','windows-1250//TRANSLIT', 'WPŁATA NA KONTO');
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $napis_wplata_na_konto, $obramowanie, 'C' ,1);
$pdf->SetFont('arial_ce','B', 8);
$wys_poczatkowa += 5;
$pdf->SetXY(5, $wys_poczatkowa);
$sprzedawca_konto_opis = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_konto_opis);
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $sprzedawca_konto_opis, 0, 'L' ,0);
$wys_poczatkowa += 5;
$pdf->SetXY(5, $wys_poczatkowa);
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $sprzedawca_konto, 0, 'L' ,0);
$wys_poczatkowa = $wys_poczatkowa - 10;
$pdf->SetXY(5, $wys_poczatkowa);
$pdf->Multicell($szerokosc_tabelki, 25, '', 1, 'L' ,0); //pusta ramka


// SUMA WEDŁUG STAWEK VAT
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
$pdf->Multicell($szer_ramki, $wys_ramki, 'VAT', $obramowanie, 'C' ,1); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Kwota VAT', $obramowanie, 'C' ,1); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, 'Brutto', $obramowanie, 'C' ,1); 

$szer_poczatkowa = 105;
$wys_poczatkowa += $wys_ramki;
$pdf->SetXY(90, $wys_poczatkowa);
$pdf->Multicell(15, $wys_ramki, 'Razem:', 0, 'R' ,0); 
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $wartosc_netto_fv, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);

if($vat_faktura == 'NP') $napis_vat_faktura = $vat_faktura;
else $napis_vat_faktura = $vat_faktura.'%';

$pdf->Multicell($szer_ramki, $wys_ramki, $napis_vat_faktura, $obramowanie, 'C' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$kwota_vat = number_format($kwota_vat, 2,'.',' ');
$pdf->Multicell($szer_ramki, $wys_ramki, $kwota_vat, $obramowanie, 'R' ,0); 
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki, $wartosc_brutto_fv, $obramowanie, 'R' ,0); 


// info o zapłaceniu itp
$obramowanie = 1;
$szerokosc_tabelki2 = 100;
$szer_ramki = 35;
$wys_poczatkowa2 = $wys_poczatkowa + 10;
$szer_poczatkowa = 105;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$napis_zaplacono = iconv('UTF-8','windows-1250//TRANSLIT', 'ZAPŁACONO');
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_zaplacono, $obramowanie, 'C' ,1);
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$napis_do_zaplaty = iconv('UTF-8','windows-1250//TRANSLIT', 'DO ZAPŁATY');
$pdf->Multicell($szer_ramki, $wys_ramki, $napis_do_zaplaty, $obramowanie, 'C' ,1);
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$pdf->Multicell(30, $wys_ramki, 'WALUTA', $obramowanie, 'C' ,1);


$wys_poczatkowa2 += $wys_ramki;
$szer_poczatkowa = 105;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$wplacono = number_format($wplacono, 2,'.',' ');
$pdf->Multicell($szer_ramki, $wys_ramki, $wplacono, $obramowanie, 'C' ,0);
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
if($do_zaplaty2 != 0) $do_zaplaty2 = number_format($do_zaplaty2, 2,'.',' '); else $do_zaplaty = '0.00';
$pdf->Multicell($szer_ramki, $wys_ramki, $do_zaplaty2, $obramowanie, 'C' ,0);
$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa2);
$pdf->Multicell(30, $wys_ramki, 'EUR', $obramowanie, 'C' ,0);



$szer_poczatkowa += 15;
if($wys_poczatkowa > 220)
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
$wys_poczatkowa += 25;
$szerokosc_tabelki = 80;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('arial_ce','B', 10);
$pdf->SetXY(5, $wys_poczatkowa);
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, 'Informacje o fakturze', $obramowanie, 'C' ,1);
$pdf->SetFont('arial_ce','B', 8);

$wys_poczatkowa += 5;
$pdf->SetXY(5, $wys_poczatkowa);
$info_o_zamowieniu = 'Zamówienie : '.$nr_zamowienia.' ('.$nr_zamowienia_klienta.')';
$info_o_zamowieniu = iconv('UTF-8','windows-1250//TRANSLIT', $info_o_zamowieniu);
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $info_o_zamowieniu, 0, 'L' ,0);

if($informacja_o_fakturze != '')
	{
	$wys_poczatkowa += 5;
	$pdf->SetXY(5, $wys_poczatkowa);
	$napis_informacja_o_fakturze = iconv('UTF-8','windows-1250//TRANSLIT', $informacja_o_fakturze);
	$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $napis_informacja_o_fakturze, 0, 'L' ,0);
	}

$wys_poczatkowa += 5;
$pdf->SetXY(5, $wys_poczatkowa);
$napis_sprzedawca_opis = iconv('UTF-8','windows-1250//TRANSLIT', $sprzedawca_opis);
$pdf->Multicell($szerokosc_tabelki, $wys_ramki, $napis_sprzedawca_opis, 0, 'L' ,0);

$wys_poczatkowa = $wys_poczatkowa - 10;
$pdf->SetXY(5, $wys_poczatkowa);
$pdf->Multicell($szerokosc_tabelki, 30, '', 1, 'L' ,0); //pusta ramka



$pdf->SetXY(5, 269);
$napis_wystawil = $user_imie.' '.$user_nazwisko;
$napis_wystawil = iconv('UTF-8','windows-1250//TRANSLIT', $napis_wystawil);
$pdf->Multicell(90, 5, $napis_wystawil, 0, 'C' ,0); 

$pdf->SetFont('arial_ce','', 8);
$wysokosc = 285;
//$pdf->Line(5, $wysokosc, 95, $wysokosc);
//$pdf->Line(115, $wysokosc, 205, $wysokosc);
$napis_fv_wystawil = iconv('UTF-8','windows-1250//TRANSLIT', 'fakturę wystawił');
$napis_fv_odebral = iconv('UTF-8','windows-1250//TRANSLIT', 'fakturę odebrał');
$pdf->Text(40,288, $napis_fv_wystawil);
$pdf->Text(151,288, $napis_fv_odebral);
$pdf->Text(5,285, '....................................................................................................................');
$pdf->Text(115,285, '....................................................................................................................');

$pdf->SetFont('arial_ce','', 8);
$napis_strona = 'Strona '.$aktualna_strona.'/'.$ilosc_stron;
$pdf->Text(98,292, $napis_strona);

$nr_fv_oryginalny = $nr_fv;
$nr_fv = change_link($nr_fv); // zamieniam / na _
$nazwa_pliku = 'faktura_'.$nr_fv.'.pdf';
$pdf->Output("../panel_dane/faktury_euro/".$nazwa_pliku."", "F");


?>