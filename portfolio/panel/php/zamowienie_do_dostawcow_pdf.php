<?php
$pytanie = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek  WHERE id = ".$zamowienie_id.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$klient_id=$wynik['klient_id'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$data_zamowienia=$wynik['data_zamowienia'];
	$data_wyslania=$wynik['data_wyslania'];
	$wartosc_netto=$wynik['wartosc_netto'];
	$status=$wynik['status'];
	$uwagi=$wynik['uwagi'];
	$korekta=$wynik['korekta'];
	$data_wyslania_korekta=$wynik['data_wyslania_korekta'];
	}	
	
$pytanie=mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = $user_id;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$user_imie =$wynik['imie'];
	$user_nazwisko =$wynik['nazwisko'];
	$user_telefon =$wynik['telefon'];
	} 

	
$pytanie32 = mysqli_query($conn, "SELECT * FROM dostawcy WHERE id='".$klient_id."'");
while($wynik32= mysqli_fetch_assoc($pytanie32))
	{
	$klient_nazwa = $wynik32['dostawca_nazwa'];
	$klient_ulica = $wynik32['ulica'];
	$klient_miasto = $wynik32['miasto'];
	$klient_kod_pocztowy = $wynik32['kod_pocztowy'];
	}

$ilosc_pozycji = 0;
$pytanie373 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_pozycje WHERE nr_zamowienia ='".$nr_zamowienia."' ORDER BY id ASC");
while($wynik373= mysqli_fetch_assoc($pytanie373))
	{
	$ilosc_pozycji++;
	$zamowienie_id = $wynik373['zamowienie_id'];
	$system_zamowienie[$ilosc_pozycji]=$wynik373['system'];
	$element_zamowienie[$ilosc_pozycji]=$wynik373['element'];
	$kolor_zamowienie[$ilosc_pozycji]=$wynik373['kolor'];
	$uszczelka_zamowienie[$ilosc_pozycji]=$wynik373['uszczelka'];
	$jednostka_zamowienie[$ilosc_pozycji]=$wynik373['jednostka'];
	$symbol_profilu_zamowienie[$ilosc_pozycji]=$wynik373['symbol_profilu'];
	$symbol_koloru_zamowienie[$ilosc_pozycji]=$wynik373['symbol_koloru'];
	$ilosc_zamowienie[$ilosc_pozycji]=$wynik373['ilosc'];
	}

//##########################################################################   generowanie potwierdzenia    ##########################################################################

define('FPDF_FONTPATH','php/pdf/font/');  //definiuje katalog z czcionkami komponentu
require_once('pdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF7();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage('L', 'A4');    //dodaje nową stronę do dokumentu
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');

//tytul 
$pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0); // 0 0 0 kolor black
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('arial_ce','B', 12);
$pdf->SetXY(200,10);
$tekst1 = iconv('UTF-8','windows-1250//TRANSLIT', $klient_nazwa);
$pdf->Multicell(95, 5, $tekst1, 0, 'C' ,1);

$pdf->SetXY(200,15);
$tekst2 = iconv('UTF-8','windows-1250//TRANSLIT', $klient_ulica);
$pdf->Multicell(95, 5, $tekst2, 0, 'C' ,1);

$pdf->SetXY(200,20);
$klient_miasto = iconv('UTF-8','windows-1250//TRANSLIT', $klient_miasto);
$tekst3 =  $klient_kod_pocztowy.' '.$klient_miasto;
$pdf->Multicell(95, 5, $tekst3, 0, 'C' ,1);


//poczatek
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



//http://4programmers.net/PHP/Generowanie_plik%C3%B3w_PDF
// rysuje tabele
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);

$wysokosc_wiersza1 = 7;
$wysokosc_od_gory = 30;
$wysokosc_od_gory_stala = 30;
$szerokosc_kolumna1 = 7;
$szerokosc_kolumna2 = 20;
$szerokosc_kolumna3 = 30;
$szerokosc_kolumna4 = 40;
$szerokosc_kolumna5 = 48;
$szerokosc_kolumna8 = 20;
$odleglosc_od_krawedzi = 5;
$odleglosc_od_krawedzi_stala = 5;

$pdf->SetFont('arial_ce','B', 12);
$pdf->SetXY(0, $wysokosc_od_gory);

if($korekta == '') $teskt4 = 'ZAMÓWIENIE NR :'.$nr_zamowienia;
else $teskt4 = 'KOREKTA ZAMÓWIENIA NR :'.$nr_zamowienia;
$teskt4 = iconv('UTF-8','windows-1250//TRANSLIT', $teskt4);
$pdf->Multicell(297, 5, $teskt4, 0, 'C' ,0);

$wysokosc_od_gory += 10;
$pdf->SetFont('arial_ce','', 7);
$pdf->SetFillColor(220,220,220);
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'LP', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna1;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna3, $wysokosc_wiersza1, 'System', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna3;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, 'Element', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna5;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, 'Kolor', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna5;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, 'Uszczelka', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna5;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, 'System profilu', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna5;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna4, $wysokosc_wiersza1, 'System koloru', 1, 'C' ,1);

$odleglosc_od_krawedzi += $szerokosc_kolumna4;
$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
$tekst5 = iconv('UTF-8','windows-1250//TRANSLIT', 'Ilość');
$pdf->Multicell($szerokosc_kolumna8, $wysokosc_wiersza1, $tekst5, 1, 'C' ,1);


for($x=1; $x<=$ilosc_pozycji; $x++)
	{
	$pdf->SetFillColor(220,220,220);
	$wysokosc_od_gory += $wysokosc_wiersza1;
	$odleglosc_od_krawedzi = $odleglosc_od_krawedzi_stala;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $x, 1, 'C' ,1);
	
	$pdf->SetFillColor(255,255,255);
	$odleglosc_od_krawedzi += $szerokosc_kolumna1;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst6 = iconv('UTF-8','windows-1250//TRANSLIT', $system_zamowienie[$x]);
	$pdf->Multicell($szerokosc_kolumna3, $wysokosc_wiersza1, $tekst6, 1, 'C' ,1);
	
	$odleglosc_od_krawedzi += $szerokosc_kolumna3;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst7 = iconv('UTF-8','windows-1250//TRANSLIT', $element_zamowienie[$x]);
	$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, $tekst7, 1, 'C' ,1);
	
	$odleglosc_od_krawedzi += $szerokosc_kolumna5;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst8 = iconv('UTF-8','windows-1250//TRANSLIT', $kolor_zamowienie[$x]);
	$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, $tekst8, 1, 'C' ,1);
	
	$odleglosc_od_krawedzi += $szerokosc_kolumna5;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst8 = iconv('UTF-8','windows-1250//TRANSLIT', $uszczelka_zamowienie[$x]);
	$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, $tekst8, 1, 'C' ,1);
	
	$odleglosc_od_krawedzi += $szerokosc_kolumna5;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst9 = iconv('UTF-8','windows-1250//TRANSLIT', $symbol_profilu_zamowienie[$x]);
	$pdf->Multicell($szerokosc_kolumna5, $wysokosc_wiersza1, $tekst9, 1, 'C' ,1);
	
	$odleglosc_od_krawedzi += $szerokosc_kolumna5;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst10 = iconv('UTF-8','windows-1250//TRANSLIT', $symbol_koloru_zamowienie[$x]);
	$pdf->Multicell($szerokosc_kolumna4, $wysokosc_wiersza1, $tekst10, 1, 'C' ,1);
	
	$odleglosc_od_krawedzi += $szerokosc_kolumna4;
	$pdf->SetXY($odleglosc_od_krawedzi, $wysokosc_od_gory);
	$tekst100 = $ilosc_zamowienie[$x].' '.$jednostka_zamowienie[$x];
	$pdf->Multicell($szerokosc_kolumna8, $wysokosc_wiersza1, $tekst100, 1, 'C' ,1);
	
	if($wysokosc_od_gory >= 150) 
		{
		//$pdf->SetXY(100, 50);
		//$pdf->Multicell(100, 10, '1 wysokosc_od_gory='.$wysokosc_od_gory, 1, 'C' ,1);
		$pdf->AddPage('L', 'A4');    //dodaje nowa strone do dokumentu
		$wysokosc_od_gory = 2;
		}
		
	}


	if($wysokosc_od_gory >= 150) 
		{
		//$pdf->SetXY(100, 50);
		//$pdf->Multicell(100, 10, '2 wysokosc_od_gory='.$wysokosc_od_gory, 1, 'C' ,1);
		$pdf->AddPage('L', 'A4');    //dodaje nowa strone do dokumentu
		$wysokosc_od_gory = 2;
		}


$pdf->SetFont('arial_ce','', 10);
$wysokosc_od_gory += 2;
$szerokosc_kolumna1 = 50;
$szerokosc_kolumna2 = 290 - $szerokosc_kolumna1;
$odleglosc_od_krawedzi = $odleglosc_od_krawedzi_stala;

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1*2, 'Uwagi', 0, 'R' ,0);
$odleglosc_od_krawedzi += $szerokosc_kolumna1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst11 = iconv('UTF-8','windows-1250//TRANSLIT', $uwagi);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1*2, $tekst11, 0, 'L' ,0);

// linia pionowa
$wysokosc_od_gory_koniec = $wysokosc_od_gory + (5*$wysokosc_wiersza1);
$odleglosc_lini = $szerokosc_kolumna1 + $odleglosc_od_krawedzi_stala;
$pdf->Line($odleglosc_lini, $wysokosc_od_gory, $odleglosc_lini, $wysokosc_od_gory_koniec); 

$wysokosc_od_gory += $wysokosc_wiersza1*2;
$odleglosc_od_krawedzi = $odleglosc_od_krawedzi_stala;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Adres dostawy i faktury', 0, 'R' ,0);
$odleglosc_od_krawedzi += $szerokosc_kolumna1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst12 = iconv('UTF-8','windows-1250//TRANSLIT', 'ARCUS A. GÓRSKI, S. SIKORSKI P. GOLEMO SPÓŁKA CYWILNA');
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst12, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$odleglosc_od_krawedzi = $odleglosc_od_krawedzi_stala;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, '', 0, 'R' ,0);
$odleglosc_od_krawedzi += $szerokosc_kolumna1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst12 = iconv('UTF-8','windows-1250//TRANSLIT', 'Podwiesk 65D, 86-200 Chełmno, NIP: 875-155-50-62');
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst12, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$odleglosc_od_krawedzi = $odleglosc_od_krawedzi_stala;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst14 = iconv('UTF-8','windows-1250//TRANSLIT', 'Sporządził');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst14, 0, 'R' ,0);
$odleglosc_od_krawedzi += $szerokosc_kolumna1;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$tekst12 = $user_imie.' '.$user_nazwisko.' / '.$user_telefon.' / 52 522-22-02';
$tekst12 = iconv('UTF-8','windows-1250//TRANSLIT', $tekst12);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst12, 0, 'L' ,0);

$subject = "Zamówienie ".$nr_zamowienia;
$subject = iconv('UTF-8','windows-1250//TRANSLIT', $subject);
$pdf->SetAuthor('ARCUS S. C.');
$pdf->SetTitle($subject);

// koniec pdf - wysylka na FTP
$nr_zamowienia2 = change_link($nr_zamowienia); // zamieniam / na _
$nazwa_pliku = 'zamowienie_'.$nr_zamowienia2.'.pdf';
$pdf->Output("../panel_dane/pdf_zamowienia_do_dostawcow/".$nazwa_pliku."", "F");
$potwierdzenie_sciezka = '../panel_dane/pdf_zamowienia_do_dostawcow/'.$nazwa_pliku;
$filename = $nazwa_pliku;


$jest = 0;
while($jest < 2)
{
	$jest++;
	if (file_exists($filename)) $jest = 3; else sleep(2);
} 


// wysylka maila
$from_emailaddress = "biuro@arcus-luki.pl";
$subject = "Zamówienie ".$nr_zamowienia;
// $subject = "=?UTF-8?B?".base64_encode($subject)."?=";


$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
//$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
$tresc_maila .= 'ARCUS S. C.<br>Podwiesk 65D<br>86-200 Chełmno<br><br>Telefon 52/522-22-02<br>Fax 52/569-10-38<br><br><br></html>';
// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);


//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
if($adres_ip == '127.0.0.1') $klient_email = $lokalny_adres_email;
	
//new phpmailer v6.16
require 'phpmailer6/src/Exception.php';
require 'phpmailer6/src/PHPMailer.php';
require 'phpmailer6/src/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->CharSet = "UTF-8";
$mail->FromName = 'ARCUS | Biuro';
$mail->From = $from_emailaddress;
$mail->AddAddress($klient_email);
$mail->AddReplyTo($from_emailaddress,"Arcus");
$mail->Subject = $subject;
$mail->IsHTML(true);
$mail->Body = $tresc_maila;
$mail->setLanguage('pl');
$mail->AddAttachment($potwierdzenie_sciezka, $nazwa_pliku);

if(!$mail->Send()) 
	{
	$error_info = $mail->ErrorInfo;
	$strona = 'zamowienie_do_dostawcow_pdf.php';
	$napis_zamowienie = 'Zamówienie : '.$nr_zamowienia;
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $napis_zamowienie, $klient_email);
	} 	
else 
	{
	echo '<div align="center" class="text_duzy_zielony"><br>Zamówienie zostało wysłane na adres : '.$klient_email.'</div>';	
	$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET data_wyslania_time = '".$time."' WHERE id = ".$zamowienie_id.";");
	$data_wyslania = date('d-m-Y', $time);
	$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET data_wyslania = '".$data_wyslania."' WHERE id = ".$zamowienie_id.";");
	$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET status = '".$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[2]."' WHERE id = ".$zamowienie_id.";");
	$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET wyslal = ".$user_id." WHERE id = ".$zamowienie_id.";");
	$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET ostatnio_uzyty_email = '".$klient_email."' WHERE id = ".$dostawca_id.";");
	}

?>