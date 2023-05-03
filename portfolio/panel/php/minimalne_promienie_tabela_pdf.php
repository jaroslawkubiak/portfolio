<?php

$warunek = "";

if($SORT_SYSTEM != "") 
	{
	if($warunek == "") $warunek .= 'WHERE system = "'.$SORT_SYSTEM.'"';
	else $warunek .= ' AND system = "'.$SORT_SYSTEM.'"';
	} 
	         
if($SORT_SYMBOL_PROFILU != "") 
	{
	if($warunek == "") $warunek .= 'WHERE symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	else $warunek .= ' AND symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	}          

 
$id = [];
$system = [];
$symbol_profilu = [];
$promien_z_gwa = [];
$promien_bez_gwa = [];
$i=0;
$pytanie = mysqli_query($conn, "SELECT * FROM minimalne_promienie ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$system[$i]=$wynik['system'];
	$symbol_profilu[$i]=$wynik['symbol_profilu'];
	$promien_z_gwa[$i]=$wynik['promien_z_gwa'];
	$promien_bez_gwa[$i]=$wynik['promien_bez_gwa'];
	}

$pytanie1 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$klient.";");
while($wynik1= mysqli_fetch_assoc($pytanie1))
	{
	$klient_nazwa=$wynik1['nazwa'];
	}




//####################################################################################################################################################################################
//##########################################################################   generowanie potwierdzenia    ##########################################################################
//####################################################################################################################################################################################

define('FPDF_FONTPATH','php/pdf/font/');  //definiuje katalog z czcionkami komponentu
require_once('pdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF7();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage('P', 'A4');    //dodaje nowa strone do dokumentu
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');

$aktualna_strona = 1;

//tytul 
$pdf->SetTextColor(0,0,0); // kolor black
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('arial_ce','BU', 12);
$pdf->SetXY(5,10);
$tekst1 = iconv('UTF-8','windows-1250//TRANSLIT', 'Promienie gięcia');
$pdf->Multicell(200, 5, $tekst1, 0, 'L' ,1);


// rysuje tabele
$pdf->SetFont('arial_ce','', 8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220,220,220);
$wys_ramki = 5;
$wys_poczatkowa = 20;
$szer_poczatkowa = 5;
$obramowanie = 1;
$wys_ramki_naglowek = 10;
$szer_ramki_lp = 8;
$szer_ramki = 48;

$pdf->SetFont('arial_ce','', 8);
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki_lp, $wys_ramki_naglowek, 'Lp.', $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki_lp;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki_naglowek, 'System', $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$pdf->Multicell($szer_ramki, $wys_ramki_naglowek, 'Symbol profilu', $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis1 = iconv('UTF-8','windows-1250//TRANSLIT', 'Minimalny R z gwarancją (mm)');
$pdf->Multicell($szer_ramki, $wys_ramki_naglowek, $napis1, $obramowanie, 'C' ,1);

$szer_poczatkowa += $szer_ramki;
$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
$napis2 = iconv('UTF-8','windows-1250//TRANSLIT', 'Minimalny R bez gwarancji (mm)');
$pdf->Multicell($szer_ramki, $wys_ramki_naglowek, $napis2, $obramowanie, 'C' ,1);


$wys_poczatkowa += $wys_ramki_naglowek;
for($x = 1; $x <= $i; $x++)
	{
	$szer_poczatkowa = 5;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$pdf->Multicell($szer_ramki_lp, $wys_ramki, $x, $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki_lp;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$nazwa3 = iconv('UTF-8','windows-1250//TRANSLIT', $system[$x]);
	$pdf->Multicell($szer_ramki, $wys_ramki, $nazwa3, $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$nazwa4 = iconv('UTF-8','windows-1250//TRANSLIT', $symbol_profilu[$x]);
	$pdf->Multicell($szer_ramki, $wys_ramki, $nazwa4, $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$nazwa5 = iconv('UTF-8','windows-1250//TRANSLIT', $promien_z_gwa[$x]);
	$pdf->Multicell($szer_ramki, $wys_ramki, $nazwa5, $obramowanie, 'C' ,0);
	
	$szer_poczatkowa += $szer_ramki;
	$pdf->SetXY($szer_poczatkowa, $wys_poczatkowa);
	$nazwa6 = iconv('UTF-8','windows-1250//TRANSLIT', $promien_bez_gwa[$x]);
	$pdf->Multicell($szer_ramki, $wys_ramki, $nazwa6, $obramowanie, 'C' ,0);
	
	

	$wys_poczatkowa += $wys_ramki;
	if($wys_poczatkowa > 260)
		{
		$ilosc_stron = 2;
		$pdf->SetFont('arial_ce','', 8);

		$napis_strona = 'Strona '.$aktualna_strona;
		$pdf->Text(98,280, $napis_strona);

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
		$pdf->SetTextColor(0,0,0);
		
		$pdf->AddPage('P', 'A4');    //dodaje nowa strone do dokumentu
		$aktualna_strona += 1;
		$ilosc_stron += 1;
		$wys_poczatkowa = 5;
		}
	}


if($ilosc_stron >= 2)
	{
	$pdf->SetFont('arial_ce','', 8);
	$napis_strona = 'Strona '.$aktualna_strona;
	$pdf->Text(98,280, $napis_strona);
	}

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
	
	

$subject = "Promienie gięcia";
$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
$pdf->SetAuthor('ARCUS S. C.');
$pdf->SetTitle($subject);

// koniec pdf - wysylka na FTP
$nazwa_pliku = 'Minimalne_R.pdf';
$pdf->Output("../panel_dane/pdf_minimalne_promienie/".$nazwa_pliku."", "F");

$potwierdzenie_sciezka = '../panel_dane/pdf_minimalne_promienie/'.$nazwa_pliku;
$filename = $nazwa_pliku;


$jest = 0;
while($jest < 2) // warunek kontynuacji petli
{
	$jest++;
	if (file_exists($filename)) $jest = 4; else sleep(3);
} 



// wysylka maila do klienta
$to_emailaddress = $klient_wysylka;
$from_emailaddress = "biuro@arcus-luki.pl";
$nadawca_emailaddress = "biuro@arcus-luki.pl";

//$to_emailaddress = $oferta_klient_email;
$subject = "Minimalne promienie gięcia";
// $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
$tresc_maila .= '<div align="left">W załączniku przesyłamy minimalne promienie gięcia.<br><br>
ARCUS S.C.<br>Podwiesk 65D<br>86-200 Chełmno<br>Telefon 52/522-22-02<br></div>';
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


if(!$mail->Send()) 
	{
	$error_info = $mail->ErrorInfo;
	$strona = 'minimalne_promienie_tabela_pdf.php';
	$napis_klient_id = 'klient id='.$klient;
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $napis_klient_id, $to_emailaddress);
	} 	
else echo '<div align="center" class="text_duzy_zielony"><br>Tabela została wysłana na adres : '.$to_emailaddress.'</div>';	



//###################    mail do nadawcy
$data_wyslania = date('d-m-Y, H:i:s', $time);
$pytanie = mysqli_query($conn, "SELECT imie, nazwisko FROM uzytkownicy where id=".$zalogowany_user.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$user_imie=$wynik['imie'];
	$user_nazwisko=$wynik['nazwisko'];
	}

$tresc_maila_do_nadawcay2 = '<div align="left">To potwierdzenie wysyłki emaila do : '.$klient_nazwa.'<br>Wysłano w dniu : '.$data_wyslania.', przez : '.$user_imie.' '.$user_nazwisko.'<br></div>';
$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
$tresc_maila .= $tresc_maila_do_nadawcay2;
$tresc_maila .= '</html>';

// $tresc_maila_do_nadawcy = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);
$tresc_maila_do_nadawcy = $tresc_maila;

$subject = "Minimalne promienie gięcia dla klienta : ".$klient_nazwa;
// $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
if($adres_ip == '127.0.0.1') $nadawca_emailaddress = $lokalny_adres_email;

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->CharSet = "UTF-8";
$mail->FromName = 'ARCUS | Biuro';
$mail->From = $from_emailaddress;
$mail->AddAddress($nadawca_emailaddress);
$mail->AddReplyTo($from_emailaddress,"Arcus");
$mail->Subject = $subject;
$mail->IsHTML(true);
$mail->Body = $tresc_maila_do_nadawcy;
$mail->setLanguage('pl');
$mail->AddAttachment($potwierdzenie_sciezka, $nazwa_pliku);

if(!$mail->Send()) 
	{
	$error_info = $mail->ErrorInfo;
	$strona = 'minimalne_promienie_tabela_pdf.php';
	$napis_klient_id = 'klient id='.$klient.', to była kopia do nadawcy!';
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $napis_klient_id, $nadawca_emailaddress);
	} 	
else echo '<div align="center" class="text"><br>Kopia została wysłana do nadawcy</div>';	

?>