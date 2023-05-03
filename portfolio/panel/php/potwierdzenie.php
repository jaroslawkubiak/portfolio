<?php
$user_id = $_SESSION["USER_ID"];

// szuka zaogowanego usera
$pytanie=mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = $user_id");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$user_imie =$wynik['imie'];
	$user_nazwisko =$wynik['nazwisko'];
	$user_telefon =$wynik['telefon'];
	} 

$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$klient_nazwa=$wynik33['nazwa'];
	$klient_sposob_platnosci=$wynik33['sposob_platnosci'];
	$klient_login=$wynik33['login'];
	$klient_haslo=$wynik33['haslo'];
	}

$pytanie333 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE nr_zamowienia = '".$nr_zamowienia."'");
while($wynik333= mysqli_fetch_assoc($pytanie333))
	{
	$data_przyjecia=$wynik333['data_przyjecia'];
	$zamowienie_id=$wynik333['id'];
	$typ_zamowienia=$wynik333['typ'];
	$sztuki=$wynik333['sztuki'];
	$luki_pvc=$wynik333['luki_pvc'];
	$luki_stal=$wynik333['luki_stal'];
	$luki_alu=$wynik333['luki_alu'];
	$zgrzewy=$wynik333['zgrzewy'];
	$slupki=$wynik333['slupki'];
	$odwodnienia=$wynik333['odwodnienia'];
	$dociecie_listwy=$wynik333['dociecie_listwy'];
	$slupek_ruchomy =$wynik333['slupek_ruchomy'];
	$komplet_listew=$wynik333['komplet_listew'];



	$okuwanie=$wynik333['okuwanie'];
	$szklenie=$wynik333['szklenie'];
	$uwagi_do_email=$wynik333['uwagi_do_email'];
	$uwagi=$wynik333['uwagi'];
	// $wartosc_netto=$wynik333['wartosc_netto'];
	// $wartosc_brutto=$wynik333['wartosc_brutto'];
	}

	//DODATKOWE ZABEZPIECZNIE - sprawdzamy czy wartosci netto i brutto są różne od 0, jeżęli są 0 to pobieramy wartości z wyceny
	$wartosc_netto = pobierz_wartosc_netto($zamowienie_id, $conn);
	$wartosc_brutto = pobierz_wartosc_brutto($zamowienie_id, $conn);
	
	// echo '$wartosc_netto='.$wartosc_netto.'<br>';
	// echo '$wartosc_brutto='.$wartosc_brutto.'<br>';
	$wartosc_netto = number_format($wartosc_netto, 2,'.',' ');
	$wartosc_brutto = number_format($wartosc_brutto, 2,'.',' ');

//sprawdzanie pozostałych zamówień klienta
$k = 0;
$pytanie3 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE klient_id=".$klient." AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane'");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	if($wynik3['nr_zamowienia'] != $nr_zamowienia)
		{
		$k++;
		$inne_nr_zamowienia[$k]=$wynik3['nr_zamowienia'];
		$inne_data_przyjecia[$k]=$wynik3['data_przyjecia'];
		$inne_nr_zamowienia_klienta[$k]=$wynik3['nr_zamowienia_klienta'];
		$inne_sztuki[$k]=$wynik3['sztuki'];
	
		$inne_wartosc_netto[$k]=$wynik3['wartosc_netto'];
		$inne_wartosc_brutto[$k]=$wynik3['wartosc_brutto'];
		$inne_wartosc_netto[$k] = number_format($inne_wartosc_netto[$k], 2,'.',' ');
		$inne_wartosc_brutto[$k] = number_format($inne_wartosc_brutto[$k], 2,'.',' ');
		
		$inne_termin_realizacji[$k]=$wynik3['termin_realizacji'];
		if (preg_match("/T/", $inne_termin_realizacji[$k]))  $inne_termin_realizacji[$k] = zamien_dowolne_znaki($inne_termin_realizacji[$k], 'T', 'Tydzień ');
		$inne_produkt[$k]=$wynik3['zamowiony_produkt'];
		$inne_system[$k]=$wynik3['system_profili'];
		$inne_uwagi[$k]=$wynik3['uwagi'];
		}
	}


// ustawiamy temat emaila
$pokaz_dodatkowy_opis = '';
if($typ_zamowienia == 'zamowienie')
	{
	if($korekta_zamowienia == 'on') 
		{
		$subject = "Potwierdzenie korekty zamówienia ".$nr_zamowienia;
		$pokaz_dodatkowy_opis = 'Korekta zamówienia';
		}
	elseif($status == 'Anulowane') 
		{
		$subject = "Potwierdzenie anulacji zamówienia ".$nr_zamowienia;
		$pokaz_dodatkowy_opis = 'Anulacja zamówienia';
		}
	else 
		{
		$subject = "Potwierdzenie przyjęcia zamówienia ".$nr_zamowienia;
		$status = 'Potwierdzone';
		}
	}
else
	{
	if($korekta_zamowienia == 'on') 
		{
		$subject = "Potwierdzenie korekty reklamacji ".$nr_zamowienia;
		$pokaz_dodatkowy_opis = 'Korekta reklamacji';
		}
	elseif($status == 'Anulowane') 
		{
		$subject = "Potwierdzenie anulacji reklamacji ".$nr_zamowienia;
		$pokaz_dodatkowy_opis = 'Anulacja reklamacji';
		}
	else 
		{
		$subject = "Potwierdzenie przyjęcia reklamacji ".$nr_zamowienia;
		$status = 'Potwierdzone';
		}
	}


//##########################################################################   generowanie potwierdzenia    ##########################################################################

define('FPDF_FONTPATH','php/pdf/font/');  //definiuje katalog z czcionkami komponentu
require_once('pdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF7();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');



//tytul 
$pdf->SetTextColor(0,0,0); // kolor black
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('arial_ce','BU', 12);
$pdf->SetXY(5,35);
$tekst1 = iconv('UTF-8','windows-1250//TRANSLIT', 'Potwierdzenie zamówienia');
$pdf->Multicell(200, 5, $tekst1, 0, 'C' ,1);
$pdf->SetFont('arial_ce','', 10);
$pdf->SetXY(5,41);
$tekst166 = iconv('UTF-8','windows-1250//TRANSLIT', $pokaz_dodatkowy_opis);
$pdf->Multicell(200, 5, $tekst166, 0, 'C' ,1);

//poczatek
/*
Image(string plik, float x, float y, float w [, float h [, string typ [, mixed link]]])

plik - nazwa pliku z obrazkiem. x - współrzędna X lewego górnego rogu obrazka. y - współrzędna Y lewego górnego rogu obrazka. w - szerokość obrazka na stronie. Jeśli równa jest zeru, obliczana jest proporcjonalnie do wysokości oryginalnego obrazka. 
h - wysokość obrazka na stronie. Jeśli nie podana lub równa zeru, obliczana automatycznie, proporcjonalnie do szerokości. typ - format pliku obrazka. Przyjmuje wartości (wielkość liter bez znaczenia): JPG, JPEG, PNG. 
Jeśli nie jest podana, ustalana jest na podstawie rozszerzenia nazwy pliku. link - URL albo identyfikator zwracany przez AddLink(). 14) Obrazek wstawisz na następnej stronie, ale najpierw zrobisz odnośnik do tej strony na pierwszej stronie. Do tego wykorzystasz kilka funkcji: 
*/



//sprawdzamy czy plik LOGO istnieje
$file_headers = @get_headers($logo_do_potwierdzen);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') $exists = false;
else $pdf->Image($logo_do_potwierdzen, 10, 5, -600);



//http://4programmers.net/PHP/Generowanie_plik%C3%B3w_PDF
// rysuje tabele
$pdf->SetFont('arial_ce','', 8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);

$wysokosc_wiersza1 = 7;
$wysokosc_wiersza2 = 15;
$wysokosc_od_gory = 50;
$wysokosc_od_gory_stala = 50;
$szerokosc_kolumna1 = 50;
$szerokosc_kolumna2 = 203 - $szerokosc_kolumna1;
$odleglosc_od_krawedzi = 5 + $szerokosc_kolumna1;

$pdf->SetXY(5,$wysokosc_od_gory); // pierwszy parametr - odległosc od lewej krawedzi, drugi odl od gory
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Klient', 0, 'R' ,0); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane, ostatni parametr to tło
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst_nazwa_klienta = iconv('UTF-8','windows-1250//TRANSLIT', $klient_nazwa);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst_nazwa_klienta, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst_nr_zamowienia_klienta = iconv('UTF-8','windows-1250//TRANSLIT', 'Nr zamówienia arcus | klienta');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst_nr_zamowienia_klienta, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst_numery_zamowien = $nr_zamowienia.'   |   '.$nr_zamowienia_klienta;
$tekst_numery_zamowien = iconv('UTF-8','windows-1250//TRANSLIT', $tekst_numery_zamowien);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst_numery_zamowien, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Produkt', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst11 = iconv('UTF-8','windows-1250//TRANSLIT', $produkt);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst11, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'System', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst12 = iconv('UTF-8','windows-1250//TRANSLIT', $profil);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst12, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Kolor profili', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst13 = iconv('UTF-8','windows-1250//TRANSLIT', $kolor_profili);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst13, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Kolor uszczelek', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst14 = iconv('UTF-8','windows-1250//TRANSLIT', $kolor_uszczelek);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst14, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst_material = iconv('UTF-8','windows-1250//TRANSLIT', 'Materiał');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst_material, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst15 = iconv('UTF-8','windows-1250//TRANSLIT', $magazyn);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst15, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, '', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst4 = $sztuki.' szt. a w tym:';
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst4, 0, 'L' ,0);

$szerokosc_kolumny_ilosc = 24;
$wysokosc_kolumny_ilosc = 5;
$wysokosc_od_gory += $wysokosc_kolumny_ilosc;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst_ilosc = iconv('UTF-8','windows-1250//TRANSLIT', 'Ilość');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_kolumny_ilosc, $tekst_ilosc, 0, 'R' ,1);

//tabelka z ilościami
	//napisy poziom 1
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
	$tekst_luki_pvc = iconv('UTF-8','windows-1250//TRANSLIT', 'Łuki pvc');
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $tekst_luki_pvc, 1, 'C' ,0);
	
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory);
	$tekst_luki_stal = iconv('UTF-8','windows-1250//TRANSLIT', 'Łuki stal');
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $tekst_luki_stal, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory);
	$tekst_luki_alu = iconv('UTF-8','windows-1250//TRANSLIT', 'Łuki alu');
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $tekst_luki_alu, 1, 'C' ,0);
	
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, 'Zgrzewy', 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory);
	$tekst_slupki = iconv('UTF-8','windows-1250//TRANSLIT', 'Słupki');
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $tekst_slupki, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory);
	$tekst_slupki = iconv('UTF-8','windows-1250//TRANSLIT', 'Słupki ruchome');
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $tekst_slupki, 1, 'C' ,0);


	//ilości poziom 1
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi;
	$wysokosc_od_gory1 = $wysokosc_od_gory+$wysokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $luki_pvc, 1, 'C' ,0);
	
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $luki_stal, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $luki_alu, 1, 'C' ,0);
	
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $zgrzewy, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $slupki, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $slupek_ruchomy, 1, 'C' ,0);



	//napisy poziom 2
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi;
	$wysokosc_od_gory1 = $wysokosc_od_gory+$wysokosc_kolumny_ilosc*2;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, 'Odwodnienia', 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$tekst_dociecie_listwy = iconv('UTF-8','windows-1250//TRANSLIT', 'Docięcie listwy');
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $tekst_dociecie_listwy, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$tekst_dociecie_listwy = iconv('UTF-8','windows-1250//TRANSLIT', 'Docięcie kompletu listew');
	$pdf->Multicell($szerokosc_kolumny_ilosc*2, $wysokosc_kolumny_ilosc, $tekst_dociecie_listwy, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc*2;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, 'Okuwanie', 1, 'C' ,0);
	
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, 'Szklenie', 1, 'C' ,0);


	//ilości poziom 2
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi;
	$wysokosc_od_gory1 = $wysokosc_od_gory+$wysokosc_kolumny_ilosc*3;
	// $odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $odwodnienia, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $dociecie_listwy, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc*2, $wysokosc_kolumny_ilosc, $komplet_listew, 1, 'C' ,0);

	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc*2;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $okuwanie, 1, 'C' ,0);
	
	$odleglosc_od_krawedzi2 = $odleglosc_od_krawedzi2+$szerokosc_kolumny_ilosc;
	$pdf->SetXY($odleglosc_od_krawedzi2,$wysokosc_od_gory1);
	$pdf->Multicell($szerokosc_kolumny_ilosc, $wysokosc_kolumny_ilosc, $szklenie, 1, 'C' ,0);



$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->SetFont('arial_ce','', 8);
$waluta = iconv('UTF-8','windows-1250//TRANSLIT', $waluta);
$wartosci_netto_brutto = $wartosc_netto.' '.$waluta.'    |    '.$wartosc_brutto.' '.$waluta.' ';

$wysokosc_od_gory += $wysokosc_wiersza2;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst3 = iconv('UTF-8','windows-1250//TRANSLIT', 'Wartość zamówienia netto | brutto');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst3, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $wartosci_netto_brutto, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst3 = iconv('UTF-8','windows-1250//TRANSLIT', 'Sposób płatności');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst3, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$klient_sposob_platnosci = iconv('UTF-8','windows-1250//TRANSLIT', $klient_sposob_platnosci);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $klient_sposob_platnosci, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst33 = iconv('UTF-8','windows-1250//TRANSLIT', 'Termin realizacji');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst33, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);

if (preg_match("/T/", $termin_realizacji))  $termin_realizacji = zamien_dowolne_znaki($termin_realizacji, 'T', 'Tydzień ');

$termin_realizacji = iconv('UTF-8','windows-1250//TRANSLIT', $termin_realizacji);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $termin_realizacji, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst34 = iconv('UTF-8','windows-1250//TRANSLIT', 'Uwagi');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst34, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);

$ilosc_uwag_stalych = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM ustawienia_uwagi WHERE uwaga <> '' ORDER BY id ASC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_uwag_stalych++;
	$uwaga_stala[$ilosc_uwag_stalych]=$wynik['uwaga'];
	}

if(($uwagi == '') && ($uwaga_1 == '') && ($uwaga_2 == '')) $uwagi = '';
if(($uwagi != '') && ($uwaga_1 != '') && ($uwaga_2 == '')) $uwagi = $uwagi.', '.$uwaga_1;
if(($uwagi != '') && ($uwaga_1 == '') && ($uwaga_2 != '')) $uwagi = $uwagi.', '.$uwaga_2;
if(($uwagi != '') && ($uwaga_1 != '') && ($uwaga_2 != '')) $uwagi = $uwagi.', '.$uwaga_1.', '.$uwaga_2;
if(($uwagi == '') && ($uwaga_1 != '') && ($uwaga_2 == '')) $uwagi = $uwaga_1;
if(($uwagi == '') && ($uwaga_1 == '') && ($uwaga_2 != '')) $uwagi = $uwaga_2;
if(($uwagi == '') && ($uwaga_1 != '') && ($uwaga_2 != '')) $uwagi = $uwaga_1.', '.$uwaga_2;

//uwagi
$dlugosc_uwag = strlen($uwagi);
if($dlugosc_uwag == 0) $wysokosc_od_gory -= 7;
elseif($dlugosc_uwag <= 70) $wysokosc_od_gory += 0;
elseif($dlugosc_uwag <= 140)  $wysokosc_od_gory += 7;
elseif($dlugosc_uwag <= 210)  $wysokosc_od_gory += 14;
else $wysokosc_od_gory += 21;
//$uwagi = $uwagi.', dl='.$dlugosc_uwag;
if(($uwagi == '') && ($ilosc_uwag_stalych == 0)) $wysokosc_od_gory += $wysokosc_wiersza1;
$uwagi = iconv('UTF-8','windows-1250//TRANSLIT', $uwagi);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $uwagi, 0, 'L' ,1);



//uwagi stale
for ($u=1; $u<=5; $u++)
	{
	if($uwaga_stala[$u] != '')
		{
		$wysokosc_od_gory += $wysokosc_wiersza1;
		$pdf->SetXY(5,$wysokosc_od_gory);
		$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, '', 0, 'R' ,0);
		$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
		//$uwagi1 = ltrim($uwagi1);
		$uwaga_stala[$u] = iconv('UTF-8','windows-1250//TRANSLIT', $uwaga_stala[$u]);
		$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $uwaga_stala[$u], 0, 'L' ,0);
		}
	}

///sporządził
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst35 = iconv('UTF-8','windows-1250//TRANSLIT', 'Sporządził');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst35, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$user_imie = iconv('UTF-8','windows-1250//TRANSLIT', $user_imie);
$user_nazwisko = iconv('UTF-8','windows-1250//TRANSLIT', $user_nazwisko);

$data_wysylki_potwierdzenia = date('d-m-Y', $time);
$tekst_sporzadzil = $data_wysylki_potwierdzenia.' | '.$user_imie.' '.$user_nazwisko.' | '.$user_telefon;
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst_sporzadzil, 0, 'L' ,0);


// linia pionowa
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->Line($szerokosc_kolumna1 + 5, $wysokosc_od_gory_stala, $szerokosc_kolumna1 + 5, $wysokosc_od_gory); 



// pozostałe zamówienia klienta
if($k!= 0)
	{
	//nazwy tabel
	$szer_kol_lp = 5; 		//5
	$szer_kol_data = 12; 	//14
	$szer_kol_nr_zam = 40;	//32
	$szer_kol_system = 17; 	//21
	$szer_kol_sztuki = 7;	//7
	$szer_kol_wartosc = 24;	//30
	$szer_kol_termin = 15;	//18
	$szer_kol_uwagi = 54;
	
	$szer_kol_produkt = 208 - $szer_kol_lp - $szer_kol_data - $szer_kol_nr_zam - $szer_kol_system - $szer_kol_sztuki - $szer_kol_wartosc - $szer_kol_termin - $szer_kol_uwagi;
	
	
	$wysokosc_od_gory += $wysokosc_wiersza1;
	$pdf->SetTextColor(0,0,0); // kolor black
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('arial_ce','BU', 12);
	$pdf->SetXY(5,$wysokosc_od_gory);
	$tekst40 = iconv('UTF-8','windows-1250//TRANSLIT', 'Pozostałe zamówienia w realizacji');
	$pdf->Multicell(200, 5, $tekst40, 0, 'C' ,1);

	$pdf->SetFont('arial_ce','', 5);
	$szerokosc_kolumny_zamowienia = 24;
	$wysokosc_kolumny_ilosc = 4;
	$odleglosc_od_krawedzi3 = 1;
	
	$wysokosc_od_gory += $wysokosc_wiersza1;
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$pdf->Multicell($szer_kol_lp, $wysokosc_kolumny_ilosc*3, 'Lp.', 1, 'C' ,0);
	
	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_lp; 
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$tekst404 = iconv('UTF-8','windows-1250//TRANSLIT', 'Data przyjęcia');
	$pdf->Multicell($szer_kol_data, $wysokosc_kolumny_ilosc*1.5, $tekst404, 1, 'C' ,0);

	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_data;
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$tekst_nr_zamowienia = iconv('UTF-8','windows-1250//TRANSLIT', 'Nr zamówienia');
	$pdf->Multicell($szer_kol_nr_zam, $wysokosc_kolumny_ilosc, $tekst_nr_zamowienia, 'RLT', 'C' ,0);
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory+$wysokosc_kolumny_ilosc);
	$pdf->Multicell($szer_kol_nr_zam, $wysokosc_kolumny_ilosc*2, 'arcus    |    klienta', 'RLB', 'C' ,0);

	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_nr_zam; 
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$pdf->Multicell($szer_kol_produkt, $wysokosc_kolumny_ilosc*3, 'Produkt', 1, 'C' ,0);

	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_produkt; 
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$pdf->Multicell($szer_kol_system, $wysokosc_kolumny_ilosc*3, 'System', 1, 'C' ,0);

	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_system; 
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$pdf->Multicell($szer_kol_sztuki, $wysokosc_kolumny_ilosc*3, 'Sztuk', 1, 'C' ,0);

	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_sztuki; 
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$tekst70 = iconv('UTF-8','windows-1250//TRANSLIT', 'Wartość zamówienia');
	$pdf->Multicell($szer_kol_wartosc, $wysokosc_kolumny_ilosc, $tekst70, 'RLT', 'C' ,0);
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory+$wysokosc_kolumny_ilosc);
	$pdf->Multicell($szer_kol_wartosc, $wysokosc_kolumny_ilosc*2, 'netto    |    brutto', 'RLB', 'C' ,0);

	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_wartosc;
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$tekst72 = iconv('UTF-8','windows-1250//TRANSLIT', 'Termin realizacji zamówienia');
	$pdf->Multicell($szer_kol_termin, $wysokosc_kolumny_ilosc*1.5, $tekst72, 1, 'C' ,0);
	
	$odleglosc_od_krawedzi3 = $odleglosc_od_krawedzi3+$szer_kol_termin; 
	$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
	$pdf->Multicell($szer_kol_uwagi, $wysokosc_kolumny_ilosc*3, 'Uwagi', 1, 'C' ,0);
	

	$wysokosc_od_gory += $wysokosc_kolumny_ilosc;
	$wysokosc_kolumny_ilosc2 = $wysokosc_kolumny_ilosc*2;
	for ($x=1; $x<=$k; $x++)
		{
		
			if($wysokosc_od_gory > 240) 
			{
			// info o panelu klienta
			$tekst171 = iconv('UTF-8','windows-1250//TRANSLIT', 'Zapraszamy do logowania się w panelu klienta pod adresem :');
			//$tekst172 = iconv('UTF-8','windows-1250//TRANSLIT', 'http://arcus-luki.pl/panel_klienta');
			//$tekst172 = iconv('UTF-8','windows-1250//TRANSLIT', 'http://arcus-luki.nazwa.pl/panel_klienta');
			$tekst172 = iconv('UTF-8','windows-1250//TRANSLIT', 'klienci.arcus-luki.pl');
			$pdf->SetFont('arial_ce','', 8);
			$wysokosc_poczatkowa_panel_klienta = 260;
			$wysokosc_stala_panel_klienta = 5;
			$pdf->SetXY($wysokosc_stala_panel_klienta, $wysokosc_poczatkowa_panel_klienta);
			
			$pdf->SetDrawColor(255,0,0);
			$pdf->Multicell(120, $wysokosc_stala_panel_klienta, $tekst171, 0, 'R' ,0); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane
			$pdf->SetXY($wysokosc_stala_panel_klienta, $wysokosc_poczatkowa_panel_klienta);
			$pdf->SetTextColor(0,0,255);
			$pdf->SetXY(125,$wysokosc_poczatkowa_panel_klienta);
			$pdf->Multicell(80, $wysokosc_stala_panel_klienta, $tekst172, 0, 'L' ,0); 
			
			$pdf->SetTextColor(0,0,0); // kolor black - 0, 255 to biały
			$pdf->SetFont('arial_ce','B', 8);
			$wysokosc_poczatkowa_panel_klienta += $wysokosc_stala_panel_klienta;
			$pdf->SetXY(5,$wysokosc_poczatkowa_panel_klienta);
			$pdf->Multicell(97, $wysokosc_stala_panel_klienta, 'Login', 0, 'R' ,0); 
			$pdf->SetXY(102, $wysokosc_poczatkowa_panel_klienta);
			$pdf->Multicell(6, $wysokosc_stala_panel_klienta, ':', 0, 'C' ,0); 
			$pdf->SetXY(108, $wysokosc_poczatkowa_panel_klienta);
			$pdf->Multicell(97, $wysokosc_stala_panel_klienta, $klient_login, 0, 'L' ,0);
			 
			$wysokosc_poczatkowa_panel_klienta += $wysokosc_stala_panel_klienta;
			$pdf->SetXY(5,$wysokosc_poczatkowa_panel_klienta);
			$tekst174 = iconv('UTF-8','windows-1250//TRANSLIT', 'Hasło');
			$pdf->Multicell(97, $wysokosc_stala_panel_klienta, $tekst174, 0, 'R' ,0); 
			$pdf->SetXY(102, $wysokosc_poczatkowa_panel_klienta);
			$pdf->Multicell(6, $wysokosc_stala_panel_klienta, ':', 0, 'C' ,0); 
			$pdf->SetXY(108, $wysokosc_poczatkowa_panel_klienta);
			$pdf->Multicell(97, $wysokosc_stala_panel_klienta, $klient_haslo, 0, 'L' ,0); 
			// koniec info o panelu klienta
			
			//stopka
			$pdf->SetFont('arial_ce','', 8);
			$pdf->SetXY(5,275);
			$pdf->SetDrawColor(125,125,125);
			$pdf->Line(5, 282, 205, 282); 
			$pdf->SetTextColor(125,125,125);
			$tekst50 = iconv('UTF-8','windows-1250//TRANSLIT', 'ARCUS S.C., Podwiesk 65D, 86-200 Chełmno');
			$tekst51 = iconv('UTF-8','windows-1250//TRANSLIT', 'Telefon 52/522-22-02, Fax 52/569-10-38, e-mail: biuro@arcus-luki.pl');
			
			$pdf->Text(79,286, $tekst50);
			$pdf->Text(60,290, $tekst51);
			
			$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
			$wysokosc_od_gory = 10;
			} // koniec nowej strony
			
		$pdf->SetFont('arial_ce','', 5);
		$pdf->SetTextColor(0,0,0); // kolor black
		$pdf->SetDrawColor(0,0,0);

		$odleglosc_od_krawedzi3 = 1;
		$wysokosc_od_gory += $wysokosc_kolumny_ilosc2;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$pdf->Multicell($szer_kol_lp, $wysokosc_kolumny_ilosc2, $x, 1, 'C' ,0);
		
		$odleglosc_od_krawedzi3 += $szer_kol_lp;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$pdf->Multicell($szer_kol_data, $wysokosc_kolumny_ilosc2, $inne_data_przyjecia[$x], 1, 'C' ,0);
		
		$szer_kol_nr_zam2 = $szer_kol_nr_zam - 12;
		$odleglosc_od_krawedzi3 += $szer_kol_data;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$pdf->Multicell(12, $wysokosc_kolumny_ilosc2, $inne_nr_zamowienia[$x], 1, 'C' ,0);
		
		$odleglosc_od_krawedzi3 += 12;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$pdf->Multicell($szer_kol_nr_zam2, $wysokosc_kolumny_ilosc2, $inne_nr_zamowienia_klienta[$x], 1, 'C' ,0);
		
		$odleglosc_od_krawedzi3 += $szer_kol_nr_zam2;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$inne_produkt[$x] = iconv('UTF-8','windows-1250//TRANSLIT', $inne_produkt[$x]);
		$pdf->Multicell($szer_kol_produkt, $wysokosc_kolumny_ilosc2, $inne_produkt[$x], 1, 'C' ,0);
		
		$odleglosc_od_krawedzi3 += $szer_kol_produkt;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$inne_system[$x] = iconv('UTF-8','windows-1250//TRANSLIT', $inne_system[$x]);
		$pdf->Multicell($szer_kol_system, $wysokosc_kolumny_ilosc2, $inne_system[$x], 1, 'C' ,0);

		$odleglosc_od_krawedzi3 += $szer_kol_system;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$pdf->Multicell($szer_kol_sztuki, $wysokosc_kolumny_ilosc2, $inne_sztuki[$x], 1, 'C' ,0);

		$szer_kol_wartosc2 = $szer_kol_wartosc/2;
		$odleglosc_od_krawedzi3 += $szer_kol_sztuki;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$tekst67 = $inne_wartosc_netto[$x].$waluta;
		$pdf->Multicell($szer_kol_wartosc2, $wysokosc_kolumny_ilosc2, $tekst67, 1, 'C' ,0);

		$odleglosc_od_krawedzi3 += $szer_kol_wartosc2;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$tekst68 = $inne_wartosc_brutto[$x].$waluta;
		$pdf->Multicell($szer_kol_wartosc2, $wysokosc_kolumny_ilosc2, $tekst68, 1, 'C' ,0);

		$odleglosc_od_krawedzi3 += $szer_kol_wartosc2;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$inne_termin_realizacji[$x] = iconv('UTF-8','windows-1250//TRANSLIT', $inne_termin_realizacji[$x]);
		$pdf->Multicell($szer_kol_termin, $wysokosc_kolumny_ilosc2, $inne_termin_realizacji[$x], 1, 'C' ,0);
		
		$odleglosc_od_krawedzi3 += $szer_kol_termin;
		$pdf->SetXY($odleglosc_od_krawedzi3,$wysokosc_od_gory);
		$tekst71 = iconv('UTF-8','windows-1250//TRANSLIT', $inne_uwagi[$x]);
		$pdf->Multicell($szer_kol_uwagi, $wysokosc_kolumny_ilosc2, $tekst71, 1, 'C' ,0);
		}
	
	}


// info o panelu klienta
$tekst171 = iconv('UTF-8','windows-1250//TRANSLIT', 'Zapraszamy do logowania się w panelu klienta pod adresem :');
//$tekst172 = iconv('UTF-8','windows-1250//TRANSLIT', 'http://arcus-luki.pl/panel_klienta');
$tekst172 = iconv('UTF-8','windows-1250//TRANSLIT', 'http://klienci.arcus-luki.pl');
$pdf->SetFont('arial_ce','', 8);
$wysokosc_poczatkowa_panel_klienta = 260;
$wysokosc_stala_panel_klienta = 5;
$pdf->SetXY($wysokosc_stala_panel_klienta, $wysokosc_poczatkowa_panel_klienta);

$pdf->SetDrawColor(255,0,0);
$pdf->Multicell(120, $wysokosc_stala_panel_klienta, $tekst171, 0, 'R' ,0); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane
$pdf->SetXY($wysokosc_stala_panel_klienta, $wysokosc_poczatkowa_panel_klienta);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(125,$wysokosc_poczatkowa_panel_klienta);
$pdf->Multicell(80, $wysokosc_stala_panel_klienta, $tekst172, 0, 'L' ,0); 

$pdf->SetTextColor(0,0,0); // kolor black - 0, 255 to biały
$pdf->SetFont('arial_ce','B', 8);
$wysokosc_poczatkowa_panel_klienta += $wysokosc_stala_panel_klienta;
$pdf->SetXY(5,$wysokosc_poczatkowa_panel_klienta);
$pdf->Multicell(97, $wysokosc_stala_panel_klienta, 'Login', 0, 'R' ,0); 
$pdf->SetXY(102, $wysokosc_poczatkowa_panel_klienta);
$pdf->Multicell(6, $wysokosc_stala_panel_klienta, ':', 0, 'C' ,0); 
$pdf->SetXY(108, $wysokosc_poczatkowa_panel_klienta);
$pdf->Multicell(97, $wysokosc_stala_panel_klienta, $klient_login, 0, 'L' ,0);
 
$wysokosc_poczatkowa_panel_klienta += $wysokosc_stala_panel_klienta;
$pdf->SetXY(5,$wysokosc_poczatkowa_panel_klienta);
$tekst_haslo = iconv('UTF-8','windows-1250//TRANSLIT', 'Hasło');
$pdf->Multicell(97, $wysokosc_stala_panel_klienta, $tekst_haslo, 0, 'R' ,0); 
$pdf->SetXY(102, $wysokosc_poczatkowa_panel_klienta);
$pdf->Multicell(6, $wysokosc_stala_panel_klienta, ':', 0, 'C' ,0); 
$pdf->SetXY(108, $wysokosc_poczatkowa_panel_klienta);
$pdf->Multicell(97, $wysokosc_stala_panel_klienta, $klient_haslo, 0, 'L' ,0); 
// koniec info o panelu klienta

//stopka
$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY(5,275);
$pdf->SetDrawColor(125,125,125);
$pdf->Line(5, 282, 205, 282); 
$pdf->SetTextColor(125,125,125);
$tekst50 = iconv('UTF-8','windows-1250//TRANSLIT', 'ARCUS S.C., Podwiesk 65D, 86-200 Chełmno');
$tekst51 = iconv('UTF-8','windows-1250//TRANSLIT', 'Telefon 52/522-22-02, Fax 52/569-10-38, e-mail: biuro@arcus-luki.pl');

$pdf->Text(79,286, $tekst50);
$pdf->Text(60,290, $tekst51);


$subject2 = "Zamówienie ".$nr_zamowienia;
$subject2 = iconv('UTF-8','windows-1250//TRANSLIT', $subject2);
$pdf->SetAuthor('ARCUS S. C.');
$pdf->SetTitle($subject2);

// koniec pdf - wysylka na FTP
$nr_zamowienia2 = change_link($nr_zamowienia); // zamieniam / na _
$nazwa_pliku = 'potwierdzenie_zamowienia_'.$nr_zamowienia2.'.pdf';
$pdf->Output("../panel_dane/pdf_potwierdzenia_zamowien/".$nazwa_pliku."", "F");

$potwierdzenie_sciezka = '../panel_dane/pdf_potwierdzenia_zamowien/'.$nazwa_pliku;
$filename = $nazwa_pliku;


$jest = 0;
while($jest < 2) // warunek kontynuacji pętli
{
	$jest++;
	if (file_exists($filename)) $jest = 4; else sleep(6);
} 




// wysylka maila
$to_emailaddress = $klient_potwierdzenie;
$from_emailaddress = "biuro@arcus-luki.pl";


// w przypadku braku adresu email szukamy go na nowo
if($to_emailaddress == "")
{
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
	while($wynik3= mysqli_fetch_assoc($pytanie))
		$to_emailaddress=$wynik3['ostatnio_uzyty_potwierdzenie_zamowienia'];
	
	if($to_emailaddress == "")
	{
		$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$klient." AND dzial = 'Potwierdzenie zamówień';");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			$to_emailaddress=$wynik33['email'];
	}
}

//szukamy czy jest dodana karta produkcyjna
$ilosc_plikow = 0;
$pytanie14 = mysqli_query($conn, "SELECT * FROM karta_produkcyjna_pliki WHERE zamowienie_id = ".$zamowienie_id.";");
while($wynik14= mysqli_fetch_assoc($pytanie14))
	{
	$ilosc_plikow++;
	$nazwa_pliku_karty[$ilosc_plikow]=$wynik14['nazwa_pliku'];
	$karty_produkcyjne_sciezka[$ilosc_plikow] = '../panel_dane/karta_produkcyjna_pliki/'.$nazwa_pliku_karty[$ilosc_plikow];
	}

$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
$tresc_maila .= '<div align="left">Dzień dobry<br><br>';
$tresc_maila .= 'Dziękujemy za zamówienie numer : '.$nr_zamowienia;

if($nr_zamowienia_klienta != '') $tresc_maila .= ' (numer zamówienia klienta : '.$nr_zamowienia_klienta.').<br>'; else $tresc_maila .= '.<br>';
$tresc_maila .= 'W załączniku przesyłamy potwierdzenie przyjęcia zamówienia.<br><br>';

if($uwagi_do_email != '') 
	{
	$uwagi_do_email2 = usun_polskie($uwagi_do_email);
	$tresc_maila .= '<b><font color="red">'.$uwagi_do_email2.'</font></b><br><br>';
	}
if($ilosc_plikow != 0) $tresc_maila .= '<b>Dołączamy również karty produkcyjne i prosimy o ich sprawdzenie.</b><br><br>';

$tresc_maila .= 'ARCUS S. C.<br>Podwiesk 65D<br>86-200 Chełmno<br><br>Telefon 52/522-22-02<br>
Fax 52/569-10-38<br><br>Zapraszamy do logowania się w panelu klienta pod adresem -> http://klienci.arcus-luki.pl<br>
<b>Login : '.$klient_login.'<br>Hasło : '.$klient_haslo.'<br></b></div>';
$tresc_maila .= '</html>';
// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);

//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
if($adres_ip == '127.0.0.1') $to_emailaddress = $lokalny_adres_email;


//new phpmailer v6.16
require 'phpmailer6/src/Exception.php';
require 'phpmailer6/src/PHPMailer.php';
require 'phpmailer6/src/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->CharSet = "UTF-8";
$mail->FromName = 'ARCUS | Biuro';
$mail->From = $from_emailaddress;
$mail->AddAddress($to_emailaddress);
$mail->AddReplyTo($from_emailaddress,"Arcus");
$mail->Subject = $subject;
$mail->IsHTML(true);
$mail->Body = $tresc_maila;
$mail->setLanguage('pl');

$mail->AddAttachment($potwierdzenie_sciezka, $nazwa_pliku);
if($ilosc_plikow != 0)
	{
	for($k=1; $k<=$ilosc_plikow; $k++) 
		$mail->AddAttachment($karty_produkcyjne_sciezka[$k], $nazwa_pliku_karty[$k]);
	}


if($to_emailaddress == "")
{
	$error_info = $mail->ErrorInfo;
	$strona = 'potwierdzenie.php';
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info('pusty adres email klienta', $strona, $nr_zamowienia, $to_emailaddress);

}
else
{

if(!$mail->Send()) 
	{
	$error_info = $mail->ErrorInfo;
	$strona = 'potwierdzenie.php';
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $nr_zamowienia, $to_emailaddress);
	} 	
else 
	{
	if($ilosc_plikow != 0) $napis_karty_produkcyjne = ' i karty produkcyjne zostały'; else $napis_karty_produkcyjne = ' zostało';
	echo '<div align="center" class="text_duzy_zielony"><br>Potwierdzenie'.$napis_karty_produkcyjne.' wysłane na adres : '.$to_emailaddress.'</div><br>';	
	$data_wysylki_potwierdzenia = date('d-m-Y', $time);
	$query100 = mysqli_query($conn, "UPDATE zamowienia SET link_potwierdzenie = '".$nazwa_pliku."' WHERE id = ".$zamowienie_id.";");
	$query101 = mysqli_query($conn, "UPDATE zamowienia SET data_wysylki_potwierdzenia = '".$data_wysylki_potwierdzenia."' WHERE id = ".$zamowienie_id.";");
	}

}
?>