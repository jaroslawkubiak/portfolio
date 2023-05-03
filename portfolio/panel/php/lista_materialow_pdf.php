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
	


//##########################################################################   generowanie pdf              ##########################################################################

define('FPDF_FONTPATH','php/pdf/font/');  //definiuje katalog z czcionkami komponentu
require_once('pdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF7();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage('P', 'A4');    //dodaje now stron do dokumentu
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');

//zmienne
$obramowanie = 0;
$wysokosc_wiersza1 = 7;
$wysokosc_wiersza2 = 4;
$wysokosc_od_gory = 50;
$wysokosc_od_gory_stala = 50;
$szerokosc_kolumna = 200;
$odleglosc_od_krawedzi = 5 + $szerokosc_kolumna;

//tytul 
$pdf->SetTextColor(0,0,0); // kolor black
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('arial_ce','B', 12);
$pdf->SetXY(5,40);
$tekst1 = 'Lista materiałów nr : '.$lista_materialow_nr;
$tekst1 = iconv('UTF-8','windows-1250//TRANSLIT', $tekst1);
$pdf->Multicell(200, 5, $tekst1, $obramowanie, 'C' ,1);


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

	
$pdf->SetFont('arial_ce','B', 10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
//$pdf->SetFillColor(100,100,100);


$tekst2 = 'Do zamówienia : '.$nr_zamowienia;
if($nr_zamowienia_klienta != '') $tekst2 .= ' ('.$nr_zamowienia_klienta.')';
$tekst2 = iconv('UTF-8','windows-1250//TRANSLIT', $tekst2);
$pdf->SetXY(5,$wysokosc_od_gory); // pierwszy parametr - odlegosc od lewej krawedzi, drugi odl od gory
$pdf->Multicell($szerokosc_kolumna, $wysokosc_wiersza1, $tekst2, $obramowanie, 'L' ,0); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyrodkowane, ostatni parametr to to

$pdf->SetFont('arial_ce','', 7);
$wysokosc_od_gory += 10;
$tekst_opis = iconv('UTF-8','windows-1250//TRANSLIT', $lista_materialow_opis);
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna, $wysokosc_wiersza2, $tekst_opis, $obramowanie, 'L' ,0);


$subject = "Lista materialow nr : ".$lista_materialow_nr;
$subject = iconv('UTF-8','windows-1250//TRANSLIT', $subject);
$pdf->SetAuthor('ARCUS S. C.');
$pdf->SetTitle($subject);

// koniec pdf - wysylka na FTP
$lista_materialow_nr2 = change_link($lista_materialow_nr); // zamieniam / na _
$nazwa_pliku = 'lista_materialow_'.$lista_materialow_nr2.'.pdf';
$pdf->Output("../panel_dane/pdf_lista_materialow/".$nazwa_pliku."", "F");


$lista_sciezka = '../panel_dane/pdf_lista_materialow/'.$nazwa_pliku;
$filename = $nazwa_pliku;


$jest = 0;
while($jest < 2) // warunek kontynuacji pętli
	{
	$jest++;
	if (file_exists($filename)) $jest = 4; else sleep(3);
	} 



// wysylka maila
$to_emailaddress = $lista_materialow_email;
$from_emailaddress = "biuro@arcus-luki.pl";

//$to_emailaddress = $oferta_klient_email;
$subject2 = "Lista materiałów nr : ".$lista_materialow_nr;
// $subject2 = iconv('UTF-8','windows-1250//TRANSLIT', $subject2);
// $subject2 = "=?UTF-8?B?".base64_encode($subject2)."?=";

$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
$tresc_maila .= '<div align="left">';
$tresc_maila .= 'Zestawienie materiałów do zamówienia numer : '.$nr_zamowienia;

if($nr_zamowienia_klienta != '') $tekst2 .= ' ('.$nr_zamowienia_klienta.')';
if($nr_zamowienia_klienta != '') $tresc_maila .= ' (numer zamówienia klienta : '.$nr_zamowienia_klienta.').<br>';
else $tresc_maila .= '.<br>';
$tresc_maila .= 'ARCUS S. C.<br>Podwiesk 65D<br>86-200 Chełmno<br><br>Telefon 52/522-22-02<br>Fax 52/569-10-38<br><br><br>Zapraszamy do logowania się w panelu klienta pod adresem -> http://klienci.arcus-luki.pl<br><b>Login : '.$klient_login.'<br>Hasło : '.$klient_haslo.'<br></b></div>';
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
$mail->Subject = $subject2;
$mail->IsHTML(true);
$mail->Body = $tresc_maila;
$mail->setLanguage('pl');
$mail->AddAttachment($lista_sciezka, $nazwa_pliku);

if(!$mail->Send()) 
	{
	$error_info = $mail->ErrorInfo;
	$strona = 'lista_materialow_pdf.php';
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $nr_zamowienia, $to_emailaddress);
exit;
	} 	
else 
	{
	echo '<div align="center" class="text_duzy_zielony"><br>Lista materiałów została wysłana na adres : '.$lista_materialow_email.'</div>';	
	$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET lista_materialow_email = '".$lista_materialow_email."' WHERE id = ".$zamowienie_id.";");
	$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET lista_materialow_data = '".$time."' WHERE id = ".$zamowienie_id.";");
	$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET lista_materialow_link = '".$nazwa_pliku."' WHERE id = ".$zamowienie_id.";");
	$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET lista_materialow_status = 'Wysłano' WHERE id = ".$zamowienie_id.";");
	$pytanie103 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_email_lista_materialow = '".$lista_materialow_email."' WHERE id = ".$klient.";");
	}
?>