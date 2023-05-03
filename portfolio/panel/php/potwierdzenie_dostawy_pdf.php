<?php

// szuka zaogowanego usera
$pytanie=mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$user_imie =$wynik['imie'];
	$user_nazwisko =$wynik['nazwisko'];
	$user_telefon =$wynik['telefon'];
	} 

$pytanie323 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE id = ".$id.";");
while($wynik323= mysqli_fetch_assoc($pytanie323))
	{
	$kierowca=$wynik323['kierowca'];
	$typ=$wynik323['typ'];
	$data_zaladunku=$wynik323['data_zaladunku'];
	$data_wyjazdu=$wynik323['data_wyjazdu'];
	$sposob_dostawy=$wynik323['sposob_dostawy'];
	$nr_zlecenia_transportowego=$wynik323['nr_zlecenia_transportowego'];
	
	$pytanie1323 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$kierowca.";");
	while($wynik1323= mysqli_fetch_assoc($pytanie1323))
		$kierowca = $wynik1323['imie'].' '.$wynik1323['telefon'];
	}

//$SUMA_BRUTTO = 0;
$ilosc_zamowien = 0;
$pytanie323 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."' AND klient_id = ".$klient_id.";");
while($wynik323= mysqli_fetch_assoc($pytanie323))
	{
	$ilosc_zamowien++;
	$zamowienie_id[$ilosc_zamowien]=$wynik323['zamowienie_id'];
	$suma_pobran_brutto=$wynik323['suma_pobran_brutto'];
	$data_dostawy=$wynik323['data_dostawy'];
	$uwagi=$wynik323['uwagi'];
	}

// wyrzucanie powtarzajacych sie zamowien
$nowa_ilosc_zamowien=0;
$zamowienie_id_lista_sort = array_unique($zamowienie_id);
for($m = 1; $m <= $ilosc_zamowien; $m++)
	if($zamowienie_id_lista_sort[$m] != '') 
		{
		$nowa_ilosc_zamowien++;
		$TAB_ZAMOWIENIA[$nowa_ilosc_zamowien] = $zamowienie_id_lista_sort[$m];
		}
	
$ogolny_numer_wz = '';
for($m = 1; $m <= $nowa_ilosc_zamowien; $m++)
	{
	$pytanie8 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$TAB_ZAMOWIENIA[$m].";");
	while($wynik8= mysqli_fetch_assoc($pytanie8))
		{
		$zamowienie_id_lista[$m]=$zamowienie_id;
		$nr_zamowienia[$m]=$wynik8['nr_zamowienia'];
		$id_zamowienia[$m]=$wynik8['id'];
		$nr_zamowienia_klienta[$m]=$wynik8['nr_zamowienia_klienta'];

		$klient_ulica=$wynik8['ulica_dostawy'];
		$klient_miasto=$wynik8['miasto_dostawy'];
		$klient_kod_pocztowy=$wynik8['kod_pocztowy_dostawy'];
	
		if($wynik8['numer_wz'] != '') $ogolny_numer_wz = $wynik8['numer_wz'];
		}
	}


$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$klient_nazwa=$wynik33['nazwa'];
	$klient_login=$wynik33['login'];
	$klient_haslo=$wynik33['haslo'];
	$klient_sposob_platnosci=$wynik33['sposob_platnosci'];	

	if(($klient_ulica =='') && ($klient_kod_pocztowy == ''))
		{
		$klient_ulica=$wynik33['dostawy_ulica'];
		$klient_miasto=$wynik33['dostawy_miasto'];
		$klient_kod_pocztowy=$wynik33['dostawy_kod_pocztowy'];
		}
	}

//##########################################################################   generowanie potwierdzenia    ##########################################################################


define('FPDF_FONTPATH','../php/pdf/font/');  //definiuje katalog z czcionkami komponentu
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
$pdf->SetXY(5,40);
$tekst1 = iconv('UTF-8','windows-1250//TRANSLIT', 'Potwierdzenie dostawy');
$pdf->Multicell(200, 5, $tekst1, 0, 'C' ,1);

//numer wz - jeżeli jeszcze nie był generowany
if($ogolny_numer_wz == '') $ogolny_numer_wz = generuj_numer_wz($conn);

$pdf->SetTextColor(0,0,0); // kolor black
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('arial_ce','B', 10);
$pdf->SetXY(5,48);
$tekst12 = iconv('UTF-8','windows-1250//TRANSLIT', $ogolny_numer_wz);
$pdf->Multicell(200, 5, $tekst12, 0, 'C' ,1);


//poczatek
//sprawdzamy czy plik istnieje
$file_headers = @get_headers($logo_do_potwierdzen);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') 
    $exists = false;
else 
    $pdf->Image($logo_do_potwierdzen, 10, 5, -600);


//http://4programmers.net/PHP/Generowanie_plik%C3%B3w_PDF
// rysuje tabele
$pdf->SetFont('arial_ce','', 10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);

$wysokosc_wiersza1 = 10;
$wysokosc_wiersza2 = 15;
$wysokosc_od_gory = 55;
$wysokosc_od_gory_stala = 55;
$szerokosc_kolumna1 = 80;
$szerokosc_kolumna2 = 200 - $szerokosc_kolumna1;
$odleglosc_od_krawedzi = 9 + $szerokosc_kolumna1;

$pdf->SetXY(5,$wysokosc_od_gory); // pierwszy parametr - odległosc od lewej krawedzi, drugi odl od gory
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Klient', 0, 'R' ,0); // piewszy parametr - szerokosc, drugi wysokosc, trzeci teskt, czwarty czy ma byc ramka, 0 - brak, 1  -ramka. C - wyśrodkowane
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$klient_nazwa = iconv('UTF-8','windows-1250//TRANSLIT', $klient_nazwa);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $klient_nazwa, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Adres dostawy', 0, 'R' ,0);
$klient_ulica = iconv('UTF-8','windows-1250//TRANSLIT', $klient_ulica);
$klient_kod_pocztowy = iconv('UTF-8','windows-1250//TRANSLIT', $klient_kod_pocztowy);
$klient_miasto = iconv('UTF-8','windows-1250//TRANSLIT', $klient_miasto);
$adres_klienta = $klient_ulica.', '.$klient_kod_pocztowy.' '.$klient_miasto;
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $adres_klienta, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst_nr_zam_klienta = iconv('UTF-8','windows-1250//TRANSLIT', 'Nr zamówienia arcus | klienta');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst_nr_zam_klienta, 0, 'R' ,0);

for($x=1; $x<=$nowa_ilosc_zamowien; $x++)
	{
	if($x>1) $wysokosc_od_gory += $wysokosc_wiersza1;
	$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
	if($nr_zamowienia_klienta[$x] != '') $tekst_numery_zamowien = $nr_zamowienia[$x].'   |   '.$nr_zamowienia_klienta[$x];
	else $tekst_numery_zamowien = $nr_zamowienia[$x];
	$tekst_numery_zamowien = iconv('UTF-8','windows-1250//TRANSLIT', $tekst_numery_zamowien);
	$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst_numery_zamowien, 0, 'L' ,0);
	}


$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);

$tekst_suma_pobran_brutto = iconv('UTF-8','windows-1250//TRANSLIT', 'Suma pobrań brutto');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst_suma_pobran_brutto, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);

	$suma_pobran_brutto = change($suma_pobran_brutto);
	$suma_pobran_brutto = number_format($suma_pobran_brutto, 2,'.',' ');

	
$tekst_kwoty = $suma_pobran_brutto.$waluta;
$tekst_numery_zamowien = iconv('UTF-8','windows-1250//TRANSLIT', $tekst_kwoty);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst_numery_zamowien, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst_sposob_platnosci = iconv('UTF-8','windows-1250//TRANSLIT', 'Sposób płatności');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst_sposob_platnosci, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$klient_sposob_platnosci = iconv('UTF-8','windows-1250//TRANSLIT', $klient_sposob_platnosci);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $klient_sposob_platnosci, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Data dostawy', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $data_dostawy, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst_sposob_dostawy = iconv('UTF-8','windows-1250//TRANSLIT', 'Sposób dostawy');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst_sposob_dostawy, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$sposob_dostawy = iconv('UTF-8','windows-1250//TRANSLIT', $sposob_dostawy);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $sposob_dostawy, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Kierowca', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$kierowca = iconv('UTF-8','windows-1250//TRANSLIT', $kierowca);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $kierowca, 0, 'L' ,0);

$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
if($typ == 'list') $opis_nr_zlecenia = 'Nr listu przewozowego'; else $opis_nr_zlecenia = 'Nr zlecenia transportowego';
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $opis_nr_zlecenia, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$nr_zlecenia_transportowego = iconv('UTF-8','windows-1250//TRANSLIT', $nr_zlecenia_transportowego);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $nr_zlecenia_transportowego, 0, 'L' ,0);

$dlugosc_uwag = strlen($uwagi);
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, 'Uwagi', 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$uwagi = iconv('UTF-8','windows-1250//TRANSLIT', $uwagi);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $uwagi, 0, 'L' ,0);

if($dlugosc_uwag < 70) $wysokosc_od_gory += $wysokosc_wiersza1;
elseif($dlugosc_uwag < 140)  $wysokosc_od_gory += $wysokosc_wiersza1*2;
else $wysokosc_od_gory += $wysokosc_wiersza1*3;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst35 = iconv('UTF-8','windows-1250//TRANSLIT', 'Sporządził');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst35, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$user_imie = iconv('UTF-8','windows-1250//TRANSLIT', $user_imie);
$user_nazwisko = iconv('UTF-8','windows-1250//TRANSLIT', $user_nazwisko);
$data_wysylki_potwierdzenia = date('d-m-Y', $time);
$tekst_sporzadzil = $data_wysylki_potwierdzenia.' | '.$user_imie.' '.$user_nazwisko.' | '.$user_telefon;
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, $tekst_sporzadzil, 0, 'L' ,0);


$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->SetXY(5,$wysokosc_od_gory);
$tekst35 = iconv('UTF-8','windows-1250//TRANSLIT', 'Odebrał');
$pdf->Multicell($szerokosc_kolumna1, $wysokosc_wiersza1, $tekst35, 0, 'R' ,0);
$pdf->SetXY($odleglosc_od_krawedzi,$wysokosc_od_gory);
$pdf->Multicell($szerokosc_kolumna2, $wysokosc_wiersza1, '', 0, 'L' ,0);

// linia pionowa
$wysokosc_od_gory += $wysokosc_wiersza1;
$pdf->Line($szerokosc_kolumna1 + 7, $wysokosc_od_gory_stala, $szerokosc_kolumna1 + 7, $wysokosc_od_gory); 

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

if($wysokosc_od_gory > 260) 
	{
	$pdf->AddPage('P', 'A4');    //dodaje nową stronę do dokumentu
	$wysokosc_od_gory = 10;
	}

$subject = "Potwierdzenie dostawy ";
$pdf->SetAuthor('ARCUS S. C.');
$pdf->SetTitle($subject);

//koniec pdf - wysylka na FTP
$nr_zamowienia2 = change_link($nr_zamowienia[1]); // zamieniam / na _
$nazwa_pliku = 'potwierdzenie_dostawy_'.$nr_zamowienia2.'.pdf';
$pdf->Output("../../panel_dane/pdf_dostawy/".$nazwa_pliku."", "F");
$potwierdzenie_sciezka = '../../panel_dane/pdf_dostawy/'.$nazwa_pliku;
$filename = $nazwa_pliku;


$jest = 0;
while($jest < 2) // warunek kontynuacji pętli
{
	$jest++;
	if (file_exists($filename)) $jest = 3; else sleep(2);
} 


// wysylka maila
$to_emailaddress = $klient_email;
$from_emailaddress = "biuro@arcus-luki.pl";
$subject = "Potwierdzenie dostawy";
// $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

$tresc_maila = '<html><head>';
$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
$tresc_maila .= '<center>ARCUS S. C.<br>Podwiesk 65D<br>86-200 Chełmno<br><br>Telefon 52/522-22-02<br>
Fax 52/569-10-38<br><br>Zapraszamy do logowania się w panelu klienta pod adresem -> http://klienci.arcus-luki.pl<br>
<b>Login : '.$klient_login.'<br>Hasło : '.$klient_haslo.'<br></b></center>';
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
	$strona = 'potwierdzenie_dostawy_pdf.php';
	$napis_klient_id = 'klient_id='.$klient_id;
	//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
	show_mail_send_error_info($error_info, $strona, $napis_klient_id, $to_emailaddress);
	} 	
else
	{
	$data_wysylki_potwierdzenia = date('d-m-Y', $time);
	$pytanie323 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."' AND klient_id = ".$klient_id.";");
	while($wynik323= mysqli_fetch_assoc($pytanie323))
		{
		$zamowienie_id=$wynik323['zamowienie_id'];
		$pytanie135 = mysqli_query($conn, "UPDATE zamowienia SET link_dostawa = '".$nazwa_pliku."' WHERE id = ".$zamowienie_id.";");
		$pytanie145 = mysqli_query($conn, "UPDATE zamowienia SET data_wysylki_potwierdzenia_dostawy = '".$data_wysylki_potwierdzenia."' WHERE id = ".$zamowienie_id.";");
		$pytanie13 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_potwierdzenie_dostawy= '".$to_emailaddress."' WHERE id = ".$klient_id.";");
		// zmieniamy numer wz
		$result = mysqli_query($conn, "UPDATE zamowienia SET numer_wz = '".$ogolny_numer_wz."' WHERE id = ".$zamowienie_id.";");
		$result = mysqli_query($conn, "UPDATE zlecenia_transportowe_tresc SET numer_wz = '".$ogolny_numer_wz."' WHERE zamowienie_id = ".$zamowienie_id.";");
		}
	echo '<div align="center" class="text_duzy_zielony"><br>Potwierdzenie dostawy zostało wysłane.</div>';	
	echo '<br><div align="center"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_dostawy/'.$nazwa_pliku.'">'.$image_pdf_icon.'<br><font size="+1">'.$nazwa_pliku.'</font></a></div>';
	}
?>