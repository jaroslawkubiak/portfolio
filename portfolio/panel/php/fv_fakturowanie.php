<?php
$szerokosc_calej_tabeli = '1700px';

// wysyłka fv do biura
if($wyslij_fv_do_biura)
{
	$fv_id = $wyslij_fv_do_biura;

	$klient_wyslij_fv = isset($_REQUEST['klient_wyslij_fv']) ? $_REQUEST['klient_wyslij_fv'] : '';
	$button = isset($_REQUEST['button']) ? $_REQUEST['button'] : '';
	$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
	
	
	$sql ="SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";";
	$pytanie2 = mysqli_query($conn, $sql);
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$nr_fv=$wynik2['nr_dok'];
		$link_faktura=$wynik2['nazwa_pliku'];
		$link_folder=$wynik2['link_folder'];
		$nabywca_id=$wynik2['nabywca_id'];
		$typ_dok_baza=$wynik2['typ_dok'];
		}
	
		if($typ_dok_baza == 'Faktura') $napis_nazwa_dokumentu = 'Faktura'; 
		if($typ_dok_baza == 'Korekta') $napis_nazwa_dokumentu = 'Korekta';
		if($typ_dok_baza == 'Proforma') $napis_nazwa_dokumentu = 'Proforma';
		if($typ_dok_baza == 'Duplikat') $napis_nazwa_dokumentu = 'Duplikat';
	
		$wysylka_fv_tytul = $napis_nazwa_dokumentu.' nr '.$nr_fv.' z panelu.';
		$wysylka_fv_tresc = $napis_nazwa_dokumentu.' nr '.$nr_fv.' z panelu.';
		// $wysylka_fv_adresat = 'jaroslawkubiak82@gmail.com';
		// $wysylka_fv_email_nadawca='jaroslawkubiak82@gmail.com';
		$wysylka_fv_adresat = 'biuro@arcus-luki.pl';
		$wysylka_fv_email_nadawca='biuro@arcus-luki.pl';
	
	//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
	if($adres_ip == '127.0.0.1') $wysylka_fv_adresat = $lokalny_adres_email;
	
	// wysyłka fv na email
	$sciezka = '../panel_dane/'.$link_folder.'/'.$link_faktura;
	
	//usuwanie polskich znakow z tresci:
	$wysylka_fv_tresc = usun_polskie($wysylka_fv_tresc);

	$wysylka_fv_email_tytul2 = $wysylka_fv_tytul;
	// $wysylka_fv_email_tytul2 = "=?UTF-8?B?".base64_encode($wysylka_fv_email_tytul2)."?=";
	$tresc_maila = '<html><head>';
	$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
	$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
	$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
	$tresc_maila .= '<div align="left">';
	$tresc_maila .= $wysylka_fv_tresc;
	$tresc_maila .= '</div>';
	$tresc_maila .= '</html>';
	// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);
	
	//new phpmailer v6.16
	require 'phpmailer6/src/Exception.php';
	require 'phpmailer6/src/PHPMailer.php';
	require 'phpmailer6/src/SMTP.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->FromName = 'ARCUS | Biuro';
	$mail->From = $wysylka_fv_email_nadawca;
	$mail->AddAddress($wysylka_fv_adresat);
	// $mail->AddAddress('braniewska7@gmail.com');
	$mail->AddReplyTo($wysylka_fv_email_nadawca,"Arcus");
	$mail->Subject = $wysylka_fv_email_tytul2;
	$mail->IsHTML(true);
	$mail->Body = $tresc_maila;
	$mail->AddAttachment($sciezka, $link_faktura);
	$mail->setLanguage('pl');
	
	if(!$mail->Send()) 
		{
		$error_info = $mail->ErrorInfo;
		$strona = 'fv_wyslij_fakture_do_biura.php';
		$klient_id_faktury = 'klient id='.$nabywca_id;
		//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
		show_mail_send_error_info($error_info, $strona, $klient_id_faktury, $wysylka_fv_adresat);
		} 	
	else echo '<table border="0" width="'.$szerokosc_calej_tabeli.'"><tr><td><div align="center" class="text_duzy_zielony"><br>Faktura '.$nr_fv.' została wysłana na adres : '.$wysylka_fv_adresat.'</div></td></tr></table>';	

}



if($usun_fv_euro != '')
	{
	$ins=mysqli_query($conn, "update fv_naglowek set faktura_euro = '' WHERE id = ".$usun_fv_euro.";");
	echo '<table border="0" width="'.$szerokosc_calej_tabeli.'" class="text" align="left"><tr valign="middle" width="100%" >';
	echo '<td class="text_duzy_niebieski" align="center" width="100%">Faktura EURO została usunięta</td>';
	echo '</tr></table><br><br><br>';
	}


if($wystaw_duplikat != '')
	{
	$fv_id = $wystaw_duplikat;
	include('php/generuj_duplikat.php');
	echo '<table border="0" width="'.$szerokosc_calej_tabeli.'" class="text" align="left"><tr valign="middle" width="100%" >';
	echo '<td class="text_duzy_niebieski" align="right" width="70%">Wydrukuj nowo wygenerowany duplikat faktury '.$nr_fv_oryginalny.'</td>';
	// adres_serwera_do_faktur zapisane jest w connection.php
	echo '<td align="left" width="30%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_duplikat/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a></td>';
	echo '</tr></table><br><br><br>';
	
	$data = date('d-m-Y', $time);
	$data_rok = date('Y', $time);
	$data_miesiac = date('m', $time);
	if($data_miesiac != 10) $data_miesiac = zamien_dowolne_znaki($data_miesiac, '0', '');
	$pytanie2 = mysqli_query($conn, "SELECT waluta FROM fv_naglowek WHERE id = ".$fv_id.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		$waluta=$wynik2['waluta'];		

	$query = mysqli_query($conn, "INSERT INTO fv_naglowek (`nr_dok`, `typ_dok`, `waluta`, `pole_jpk`, `zamowienie_id`, `nabywca_id`, `nabywca_nazwa_skrocona`, `data_wystawienia`, `wartosc_netto_fv`, `vat`, `wartosc_brutto_fv`, `wplacono`, `zaplacona`, `link_folder`, `nazwa_pliku`, `data_wygenerowania_dokumentu`, `nabywca_nazwa`, `nabywca_ulica`, `nabywca_miasto`, `nabywca_kod_pocztowy`, `nabywca_nip`, `nabywca_sposob_platnosci`, `termin_platnosci`, `termin_platnosci_dni`, `data_wystawienia_time`, `data_wystawienia_miesiac`, `data_wystawienia_rok`, `data_zakonczenia_dostawy`, `user_id`, `user_imie`, `user_nazwisko`,`informacja_o_fakturze`) values ('$nr_fv_oryginalny', 'Duplikat', '$waluta', '', '$zamowienie_id', '$nabywca_id', '$nabywca_nazwa_skrocona', '$data_wystawienia', '$wartosc_netto_fv_do_duplikatu', '$vat_faktura_do_duplikatu', '$wartosc_brutto_fv_do_duplikatu', '0', 'nie', 'faktury_duplikat', '$nazwa_pliku', '$data', '$nabywca_nazwa', '$nabywca_ulica', '$nabywca_miasto', '$nabywca_kod_pocztowy', '$nabywca_nip', '$nabywca_sposob_platnosci', '$termin_platnosci_do_duplikatu', '$termin_platnosci_dni2', '$time', '$data_miesiac', '$data_rok', '$data', '$user_id', '$user_imie', '$user_nazwisko', '$informacja_o_fakturze');");

	//pobieramy id wystawionego duplikatu
	$duplikat_do_faktury = mysqli_insert_id($conn);

	$pytanie122 = mysqli_query($conn, "UPDATE fv_naglowek SET duplikat_do_faktury = '".$duplikat_do_faktury."' WHERE id = ".$fv_id.";");
}


// #################################################### PRZETWORZ DOKUMENT #################################################
if($przetworz != '')
	{
	$fv_id = $przetworz;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$zamowienie_id2=$wynik2['zamowienie_id'];		
		$numer_fv=$wynik2['nr_dok'];
		$link_faktura=$wynik2['nazwa_pliku'];
		$waluta=$wynik2['waluta'];
		$link_folder = $wynik2['link_folder'];
		$typ_dok=$wynik2['typ_dok'];
		$duplikat_do_faktury=$wynik2['duplikat_do_faktury'];
		}

	if($typ_dok == 'Faktura')
		{
		$typ_dokumentu = 'nowo wygenerowaną fakturę';
		//echo 'gen Faktura<br>';
		include('php/generuj_fakture.php');
		}
	elseif($typ_dok == 'Proforma')
		{
		include('php/generuj_fakture_proforme.php');
		$typ_dokumentu = 'nowo wygenerowaną fakturę proformę';
		//echo 'gen proforma<br>';
		}
	elseif($typ_dok == 'Korekta')
		{
		// echo 'gen korekta<br>';
		include('php/generuj_fakture_korekte.php');
		$typ_dokumentu = 'nowo wygenerowaną korektę';
		}
	elseif($typ_dok == 'Duplikat')
		{
		//echo 'gen duplikat<br>';
		include('php/generuj_duplikat.php');
		$typ_dokumentu = 'nowo wygenerowany duplikat';
		}
	
	if(($typ_dok == 'Proforma') && ($waluta == 'EURO'))
		{
		//echo 'gen proforma euro<br>';
		include('php/generuj_fakture_proforme_euro.php');
		$typ_dokumentu = 'nowo wygenerowaną fakturę proformę EURO';
		}
	// #################################################### PRZETWORZ DOKUMENT #################################################

	echo '<table border="0" width="'.$szerokosc_calej_tabeli.'" class="text" align="left"><tr valign="middle" width="100%" >';
	echo '<td class="text_duzy_niebieski" align="right" width="70%">Wydrukuj '.$typ_dokumentu.' '.$nr_fv_oryginalny.'</td>';
	// adres_serwera_do_faktur zapisane jest w connection.php
	echo '<td align="left" width="30%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a></td>';
	echo '</tr></table><br>';
	} // koniec przetworz
	
	

if($wystaw_fv_euro != '')
	{
	//echo 'wystawiam fv euro';
	$fv_id = $wystaw_fv_euro;
	include('php/generuj_fakture_euro.php');
	$ins=mysqli_query($conn, "update fv_naglowek set faktura_euro = 'TAK' WHERE id = ".$fv_id.";");
	echo '<table border="0" width="'.$szerokosc_calej_tabeli.'" class="text" align="left"><tr valign="middle" width="100%" >';
	echo '<td class="text_duzy_niebieski" align="right" width="70%">Wydrukuj nowo wygenerowaną fakturę EURO '.$nr_fv_oryginalny.'</td>';
	echo '<td align="left" width="30%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_euro/'.$nazwa_pliku.'" target="_blank">'.$image_pdf_icon2.'</a></td>';
	echo '</tr></table><br>';
	}	



$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='wysokosc_okna';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	$wysokosc_okna=$wynik3['opis'];
	
if($rozliczenie == '') $radio_zaplacone = ''; //kasowanie zaznaczenia 
if($terminowosc == '') $radio_terminowosc = ''; //kasowanie zaznaczenia 
if($klient == '') $klient_nazwa = ''; //kasowanie zaznaczenia 

if(($data_poczatkowa == '') && ($data_koncowa == '') && ($termin_wystawienia == 'on'))
	{
	$data_poczatkowa = date('d-m-Y', $time);
	$data_koncowa = date('d-m-Y', $time);
	}

if($data_poczatkowa != '') 
	{
	$pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	}
if($data_koncowa != '') 
	{
	$pieces2 = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
	}

if($termin_wystawienia == '')
	{
	$szukany_miesiac = '';
	$sprawdzany_rok = '';
	$data_poczatkowa = '';
	$data_koncowa = '';
	}

$WARUNEK = "";
if($szukany_miesiac != "") 
	{
	if(($AKTUALNY_MIESIAC == 1) && ($szukany_miesiac == 12)) $AKTUALNY_ROK--;
	$data_poczatkowa = '01-'.$szukany_miesiac.'-'.$AKTUALNY_ROK;
	$szukany_miesiac2 = mktime(0,0,0, $szukany_miesiac, 1, $AKTUALNY_ROK);
	$ilosc_dni = date('t', $szukany_miesiac2);
	$data_koncowa = $ilosc_dni.'-'.$szukany_miesiac.'-'.$AKTUALNY_ROK;
	$pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	$pieces2 = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
	}   

if($sprawdzany_rok != "") 
	{
	$data_poczatkowa = '01-01-'.$AKTUALNY_ROK;
	$data_koncowa = '31-12-'.$AKTUALNY_ROK;
	$pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	$pieces2 = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
	}   

if($rodzaj_dokumentu != '')
	{
	if($rodzaj_dokumentu != 'WSZYSTKIE') 
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE typ_dok = "'.$rodzaj_dokumentu.'"';
		else $WARUNEK .= ' AND typ_dok = "'.$rodzaj_dokumentu.'"';
		}
	}  
	
if($data_poczatkowa != '')
	{
	if($WARUNEK == "") $WARUNEK = 'WHERE data_wystawienia_time >= "'.$data_poczatkowa_time.'"';
	else $WARUNEK .= ' AND data_wystawienia_time >= "'.$data_poczatkowa_time.'"';
	}  
	 	
if($data_koncowa != '')
	{
	if($WARUNEK == "") $WARUNEK = 'WHERE data_wystawienia_time <= "'.$data_koncowa_time.'"';
	else $WARUNEK .= ' AND data_wystawienia_time <= "'.$data_koncowa_time.'"';
	}          
	 
if($radio_zaplacone != '')
	{
	if($radio_zaplacone == 'zaplacone')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "tak"';
		else $WARUNEK .= ' AND zaplacona = "tak"';
		}
	if($radio_zaplacone == 'niezaplacone')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "nie"';
		else $WARUNEK .= ' AND zaplacona = "nie"';
		}
	}  

if($radio_terminowosc != '')
	{
	if($radio_terminowosc == 'w_terminie')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "nie" AND termin_platnosci > "'.$time.'"';
		else $WARUNEK .= ' AND zaplacona = "nie" AND termin_platnosci > "'.$time.'"';
		}
	if($radio_terminowosc == 'po_terminie')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "nie" AND termin_platnosci < "'.$time.'"';
		else $WARUNEK .= ' AND zaplacona = "nie" AND termin_platnosci < "'.$time.'"';
		}
	}  
	
if($klient_nazwa != '')
	{
	if($WARUNEK == "") $WARUNEK = "WHERE nabywca_nazwa_skrocona LIKE '%".$klient_nazwa."%'";
	else $WARUNEK .= " AND nabywca_nazwa_skrocona LIKE '%".$klient_nazwa."%'";
	}  

$SORTOWANIE_DIV = '&rodzaj_dokumentu='.$rodzaj_dokumentu.'&termin_wystawienia='.$termin_wystawienia.'&data_koncowa='.$data_koncowa.'&data_poczatkowa='.$data_poczatkowa.'&rozliczenie='.$rozliczenie.'&radio_zaplacone='.$radio_zaplacone.'&terminowosc='.$terminowosc.'&klient='.$klient.'&klient_nazwa='.$klient_nazwa.'&radio_terminowosc='.$radio_terminowosc;

// echo 'sort='.$SORTOWANIE_DIV;

echo '<table border="0" class="text" width="'.$szerokosc_calej_tabeli.'" align="left"><tr><td width="250px" valign="top">';

echo '<table border="0" class="text" width="100%" align="center">';
$link_zestawienie_fv = "php/drukuj/drukuj_zestawienie_fv.php?jak=".$jak."&wg_czego=".$wg_czego."&SORTOWANIE_DIV=".$SORTOWANIE_DIV;

$napis_wyslij_fv_przez_email = 'Wyślij fakturę przez e-mail';
$napis_wyslij_korekte_przez_email = 'Wyślij korektę przez e-mail';
$napis_wyslij_proforme_przez_email = 'Wyślij proformę przez e-mail';
$napis_wyslij_proforme_euro_przez_email = 'Wyślij proformę EURO przez e-mail';
$napis_wyslij_duplikat_przez_email = 'Wyślij duplikat przez e-mail';
$napis_wyslij_przypomnienie_zaplaty = 'Wyślij przypomnienie zapłaty';						
$napis_wystaw_fv_euro = 'Wystaw fakturę EURO : ';						

if($drukuj_fv != '') 
	{
	// aktywne
	$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$drukuj_fv.";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$numer_fv=$wynik2['nr_dok'];
		$link_faktura=$wynik2['nazwa_pliku'];
		$zamowienie_id=$wynik2['zamowienie_id'];
		$link_folder = $wynik2['link_folder'];
		$waluta = $wynik2['waluta'];
		$termin_platnosci_test = $wynik2['termin_platnosci'];
		$typ_dok=$wynik2['typ_dok'];
		$duplikat_do_faktury=$wynik2['duplikat_do_faktury'];
		$czy_fv_ma_korekte=$wynik2['tytul_korekty'];
		$faktura_euro=$wynik2['faktura_euro'];  //jezeli bedzie id to bedzie mozna drukowac te fv
  		}
	
	$pytanie28 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
	while($wynik28= mysqli_fetch_assoc($pytanie28))
		$kurs_euro=$wynik28['kurs_euro'];
	
	if($typ_dok == 'Faktura') 
		{
		$napis_drukuj_dokument = 'Drukuj fakturę';
		$napis_typ_dok = 'fakturę';
		$napis_wystaw_duplikat = 'Wystaw duplikat : ';
		}
	if($typ_dok == 'Korekta') 
		{
		$napis_drukuj_dokument = 'Drukuj korektę';
		$napis_wyslij_fv_przez_email = $napis_wyslij_korekte_przez_email;
		$napis_typ_dok = 'korektę';
		}
	if($typ_dok == 'Proforma') 
		{
		$napis_drukuj_dokument = 'Drukuj proformę';
		$napis_wyslij_fv_przez_email = $napis_wyslij_proforme_przez_email;
		$napis_typ_dok = 'proformę';
		}
	if($typ_dok == 'Duplikat') 
		{
		$napis_drukuj_dokument = 'Drukuj duplikat';
		$napis_wyslij_fv_przez_email = $napis_wyslij_duplikat_przez_email;
		$napis_typ_dok = 'duplikat';
		}
	if(($typ_dok == 'Proforma') && ($waluta == 'EURO'))
		{
		$napis_drukuj_dokument = 'Drukuj proformę EURO';
		$napis_wyslij_fv_przez_email = $napis_wyslij_proforme_euro_przez_email;
		$napis_typ_dok = 'proformę EURO';
		}

	//#####################       DRUKUJ   ##################### 
	echo '<tr><td align="left">';
		echo '<table border="0" class="text" width="100%" align="center"><tr>';
		echo '<td width="40px" align="center"><a href="http:/'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$link_faktura.'" target="_blank"><font color="black">'.$image_printer_mini.'</font></a></td>';
		echo '<td width="100%" align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$link_faktura.'" target="_blank"><font color="black">'.$napis_drukuj_dokument.' nr: '.$numer_fv.'</font></a></td></tr>';
		echo '</table>';
	echo '</td></tr>';
		
	//#####################       DRUKUJ FAKTURE EURO    #####################
	if(($typ_dok == 'Faktura') && ($faktura_euro == 'TAK'))
		{
		echo '<tr><td align="left">'; 
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="http:/'.$adres_serwera_do_faktur.'/panel_dane/faktury_euro/'.$link_faktura.'" target="_blank"><font color="black">'.$image_printer_mini.'</font></a></td>';
			echo '<td width="100%" align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_euro/'.$link_faktura.'" target="_blank"><font color="black">'.$napis_drukuj_fakture.' fakturę EURO : '.$numer_fv.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';	
		}
		

	//#####################       DRUKUJ DUPLIKAT    #####################
	if(($typ_dok == 'Faktura') && ($duplikat_do_faktury != ''))
		{
		echo '<tr><td align="left">'; 
			$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$duplikat_do_faktury.";");
			while($wynik2= mysqli_fetch_assoc($pytanie2))
				{
				$numer_duplikatu=$wynik2['nr_dok'];
				$duplikat_link=$wynik2['nazwa_pliku'];
				$link_folder = $wynik2['link_folder'];
				}
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="http:/'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$duplikat_link.'" target="_blank"><font color="black">'.$image_printer_mini.'</font></a></td>';
			echo '<td width="100%" align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$duplikat_link.'" target="_blank"><font color="black">'.$napis_drukuj_fakture.' DUPLIKAT nr: '.$numer_duplikatu.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';	
		}
		
	//#####################       DRUKUJ KOREKTE    #####################
	if(($typ_dok == 'Faktura') && ($czy_fv_ma_korekte != ''))
		{
		echo '<tr><td align="left">'; 
			$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$czy_fv_ma_korekte.";");
			while($wynik2= mysqli_fetch_assoc($pytanie2))
				{
				$numer_korekty=$wynik2['nr_dok'];
				$korekta_link=$wynik2['nazwa_pliku'];
				$link_folder = $wynik2['link_folder'];
				}
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="http:/'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$korekta_link.'" target="_blank"><font color="black">'.$image_printer_mini.'</font></a></td>';
			echo '<td width="100%" align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$korekta_link.'" target="_blank"><font color="black">'.$napis_drukuj_fakture.' Korektę nr: '.$numer_korekty.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';	
		}
	//#####################       WYSLIJ FV DO BIURA    #####################
	if($user_stanowisko != 'księgowość')
		{
		echo '<tr><td align="left">'; // WYSLIJ FV DO BIURA
			echo '<table border="0" class="text" width="100%" align="center"><tr>';


			echo '<td width="40px" align="center"><a href="index.php?page=fv_fakturowanie&wyslij_fv_do_biura='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_send_mail.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_fakturowanie&wyslij_fv_do_biura='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Wyślij plik PDF do biura</a></td></tr>';
	
			// echo '<td width="40px" align="center"><a href="javascript: fv_wyslij_fakture_do_biura(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$image_send_mail.'</font></a></td>';
			// echo '<td width="100%" align="left"><a href="javascript: fv_wyslij_fakture_do_biura(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">Wyślij plik PDF do biura</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
			
	//#####################       DRUKUJ ZESTAWIENIE FAKTUR    #####################
	echo '<tr><td align="left">'; 
		echo '<table border="0" class="text" width="100%" align="center"><tr>';
		echo '<td width="40px" align="center"><a href="'.$link_zestawienie_fv.'" target="_blank"><font color="black">'.$image_printer_mini.'</font></a></td>';
		echo '<td width="100%" align="left"><a href="'.$link_zestawienie_fv.'" target="_blank"><font color="black">'.$napis_drukuj_zestawienie_faktur.'</font></a></td></tr>';
		echo '</table>';
	echo '</td></tr>';


	//#####################     WYSYLKA PRZEZ EMAIL I PRZYPOMNIENIE zapłatY  #####################
	if($user_stanowisko != 'księgowość')
		{
		echo '<tr><td align="left">'; // WYSLIJ FV PRZEZ EMAIL
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="javascript: fv_wyslij_fakture_przez_email(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$image_send_mail.'</font></a></td>';
			echo '<td width="100%" align="left"><a href="javascript: fv_wyslij_fakture_przez_email(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$napis_wyslij_fv_przez_email.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		
		echo '<tr><td align="left">'; // WYSLIJ FV PRZEZ EMAIL do KSIęGOWOśCI
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="javascript: fv_wyslij_fakture_do_ksiegowosci(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$image_send_mail.'</font></a></td>';
			echo '<td width="100%" align="left"><a href="javascript: fv_wyslij_fakture_do_ksiegowosci(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$napis_wyslij_fv_do_ksiegowosci.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';

		$pytanie222 = mysqli_query($conn, "SELECT zaplacona FROM fv_naglowek WHERE id = ".$drukuj_fv.";");
		while($wynik222= mysqli_fetch_assoc($pytanie222))
			$czy_zaplacona=$wynik222['zaplacona'];
		
		if((($czy_zaplacona == 'nie') && ($termin_platnosci_test < $time)) &&(($typ_dok == 'Faktura') || ($typ_dok == 'Korekta')))
			{
			echo '<tr><td align="left">'; //WYSLIJ PRZYPOMNIENIE ZAPLATY
				echo '<table border="0" class="text" width="100%" align="center"><tr>';
				echo '<td width="40px" align="center"><a href="javascript: fv_wyslij_przypomnienie_zaplaty(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$image_send_mail.'</font></a></td>';
				echo '<td width="100%" align="left"><a href="javascript: fv_wyslij_przypomnienie_zaplaty(\''.$drukuj_fv.'\',\''.$user_id.'\')"><font color="black">'.$napis_wyslij_przypomnienie_zaplaty.'</font></a></td></tr>';
				echo '</table>';
			echo '</td></tr>';
			}
		else
			{
			echo '<tr><td align="left">';
				echo '<table border="0" class="text" width="100%" align="center"><tr>';
				echo '<td width="40px" align="center">'.$image_send_mail_gray.'</td>';
				echo '<td width="100%" align="left"><font color="gray">'.$napis_wyslij_przypomnienie_zaplaty.'</font></td></tr>';
				echo '</table>';
			echo '</td></tr>';
			}
		} // do if($user_stanowisko != 'księgowość')
	//##############################################################################################################
	
	
	//#####################     LISTA WPłAT  #############################################################################
	if($user_stanowisko == 'administrator')
		{
		echo '<tr><td align="left">';
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="index.php?page=fv_lista_wplat&jak=DESC&wg_czego=id&LIMIT=100">'.$image_lista.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_lista_wplat&jak=DESC&wg_czego=id&LIMIT=100"><font color="black">Lista wpłat</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	//##############################################################################################################
				
				
	//#####################     PRZETWORZ DOKUMENTY I EDYCJA FV  #############################################################################
	if($user_stanowisko != 'księgowość')
		{
		echo '<tr><td align="left">'; 
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="index.php?page=fv_fakturowanie&przetworz='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_pdf_mini2.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_fakturowanie&przetworz='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">Przetwórz '.$napis_typ_dok.' nr: '.$numer_fv.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		
		if($typ_dok == 'Faktura') 
			{
			echo '<tr><td align="left">'; 
				echo '<table border="0" class="text" width="100%" align="center"><tr>';
				echo '<td width="40px" align="center"><a href="index.php?page=fv_edycja&edytuj_id='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_pdf_mini_edit.'</a></td>';
				echo '<td width="100%" align="left"><a href="index.php?page=fv_edycja&edytuj_id='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">Edytuj fakturę nr: '.$numer_fv.'</font></a></td></tr>';
				echo '</table>';
			echo '</td></tr>';
			}
	}
	//##############################################################################################################
	

	//#####################     WYSTAW DUPLIKAT  #############################################################
	if(($typ_dok == 'Faktura') && ($duplikat_do_faktury == '') && ($czy_fv_ma_korekte == ''))
		{
		echo '<tr><td align="left">'; 
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="index.php?page=fv_fakturowanie&wystaw_duplikat='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_pdf_mini2.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_fakturowanie&wystaw_duplikat='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">'.$napis_wystaw_duplikat.$numer_fv.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	//##############################################################################################################
	
	
	//#####################     WYSTAW FV EURO  #############################################################
	if(($typ_dok == 'Faktura') && ($kurs_euro != '') && ($faktura_euro != 'TAK'))
		{
		echo '<tr><td align="left">'; 
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="index.php?page=fv_fakturowanie&wystaw_fv_euro='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_pdf_mini2.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_fakturowanie&wystaw_fv_euro='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">'.$napis_wystaw_fv_euro.$numer_fv.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	//##############################################################################################################
	
	
	//#####################     USUN FV EURO  #############################################################
	if(($kurs_euro != '') && ($faktura_euro == 'TAK'))
		{
		echo '<tr><td align="left">'; 
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="index.php?page=fv_fakturowanie&usun_fv_euro='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_pdf_usun.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_fakturowanie&usun_fv_euro='.$drukuj_fv.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">Usuń fakturę EURO nr: '.$numer_fv.'</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	//##############################################################################################################
	
	} // do if($drukuj_fv != '') 
else
	{
	//#####################       drukuj_fv jest puste - nie wybrano zadnego dokumentu    #####################

	//#####################       DRUKUJ    #####################
	echo '<tr><td align="left">';
		echo '<table border="0" class="text" width="100%" align="center"><tr>';
		echo '<td width="40px" align="center">'.$image_printer_mini_gray.'</td>';
		echo '<td width="100%" align="left"><font color="gray">'.$napis_drukuj_fakture.'</font></td></tr>';
		echo '</table>';
	echo '</td></tr>';
	//##############################################################################################################
	
	
	//#####################       DRUKUJ ZESTAWIENIE FAKTUR    #####################
	echo '<tr><td align="left">'; 
		echo '<table border="0" class="text" width="100%" align="center"><tr>';
		echo '<td width="40px" align="center"><a href="'.$link_zestawienie_fv.'" target="_blank"><font color="black">'.$image_printer_mini.'</font></a></td>';
		echo '<td width="100%" align="left"><a href="'.$link_zestawienie_fv.'" target="_blank"><font color="black">'.$napis_drukuj_zestawienie_faktur.'</font></a></td></tr>';
		echo '</table>';
	echo '</td></tr>';
	//##############################################################################################################

	
	//#####################     WYSYLKA PRZEZ EMAIL I PRZYPOMNIENIE ZAPLATY  ###################################
	if($user_stanowisko != 'księgowość')
		{
		echo '<tr><td align="left">';
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center">'.$image_send_mail_gray.'</td>';
			echo '<td width="100%" align="left"><font color="gray">'.$napis_wyslij_fv_przez_email.'</font></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		echo '<tr><td align="left">';
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center">'.$image_send_mail_gray.'</td>';
			echo '<td width="100%" align="left"><font color="gray">'.$napis_wyslij_przypomnienie_zaplaty.'</font></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	//##############################################################################################################

	//#####################     LISTA WPLAT  #############################################################################
	if($user_stanowisko == 'administrator')
		{
		echo '<tr><td align="left">';
			echo '<table border="0" class="text" width="100%" align="center"><tr>';
			echo '<td width="40px" align="center"><a href="index.php?page=fv_lista_wplat&jak=DESC&wg_czego=id&LIMIT=100">'.$image_lista.'</a></td>';
			echo '<td width="100%" align="left"><a href="index.php?page=fv_lista_wplat&jak=DESC&wg_czego=id&LIMIT=100"><font color="black">Lista wpłat</font></a></td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	//##############################################################################################################
	} // do else
echo '</table>';
	// LEGENDA
	echo '<br><br><br><table align="center" class="text" border="3" width="80%" cellspacinf="5" cellpadding="5" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr><td bgcolor="'.$kolor_szary.'">KOLORY NR DOKUMENTÓW</td></tr>';
	echo '<tr><td bgcolor="'.$kolor_typ_dok['Faktura'].'">Faktura</td></tr>';
	echo '<tr><td bgcolor="'.$kolor_typ_dok['Duplikat'].'">Duplikat</td></tr>';
	echo '<tr><td bgcolor="'.$kolor_typ_dok['Proforma'].'">Proforma</td></tr>';
	echo '<tr><td bgcolor="'.$kolor_typ_dok['Korekta'].'">Korekta</td></tr>';
	echo '</table>';
	
echo '</td>';

echo '<td width="1200px" height="'.$wysokosc_okna.'px" SCROLLING="yes">';
	echo '<div style="height: '.$wysokosc_okna.'; width: 1200; overflow-y: auto;">';
	include("php/fv_zestawienie.php");
	echo '</div>';
echo '</td>';
echo '<td width="220px" valign="top">';
	echo '<FORM action="index.php?page=fv_fakturowanie&jak='.$jak.'&wg_czego='.$wg_czego.'" method="post">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<INPUT type="hidden" name="page" value="'.$page.'">';
	//echo '<INPUT type="text" name="termin_wystawienia" value="'.$termin_wystawienia.'">';

//if($user_stanowisko == 'administrator')
	//{
	// tabelka z sortowaniem po datach, ten miesiac itp
	echo '<table border="0" class="text" width="100%" align="center" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center"><td>';
	// rozliczenie
		echo '<table border="0" class="text" width="100%" align="center" cellpadding="0" cellspacing="0">';
		echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="center"><td align="left" width="100%">Rodzaj dokumentu</td></tr>';
		echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td>';
			echo '<select name="rodzaj_dokumentu" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			if($rodzaj_dokumentu == '') $rodzaj_dokumentu = 'WSZYSTKIE';
			if($rodzaj_dokumentu == 'WSZYSTKIE') echo '<option selected="selected">WSZYSTKIE</option>'; else echo '<option>WSZYSTKIE</option>';
			if($rodzaj_dokumentu == 'Faktura') echo '<option selected="selected">Faktura</option>'; else echo '<option>Faktura</option>';
			if($rodzaj_dokumentu == 'Duplikat') echo '<option selected="selected">Duplikat</option>'; else echo '<option>Duplikat</option>';
			if($rodzaj_dokumentu == 'Korekta') echo '<option selected="selected">Korekta</option>'; else echo '<option>Korekta</option>';
			if($rodzaj_dokumentu == 'Proforma') echo '<option selected="selected">Proforma</option>'; else echo '<option>Proforma</option>';
			echo '</select>';
		echo '</td></tr></table><br>';
		
		echo '<table border="0" class="text" width="100%" align="center" cellpadding="0" cellspacing="0"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center">';
		if($termin_wystawienia == 'on') $checked_termin_wystawienia = ' checked '; else $checked_termin_wystawienia = ' ';
		echo '<td align="center"><input type="checkbox" id="termin_wystawienia" '.$checked_termin_wystawienia.' name="termin_wystawienia" onchange="submit();"></td>';
		echo '<td align="left" width="100%">Termin wystawienia</td></tr>';
		
		if($termin_wystawienia == 'on')
			{
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">';
				echo '<table align="left" cellspacing="0" cellpadding="0" border="0" bgcolor="'.$kolor_tabeli.'"><tr align="left" class="text"><td>'.$tabulator;
					echo '<input type="text" size="8" class="pole_input_czerwone" autocomplete="off" name="data_poczatkowa" id="f_data_poczatkowa" value="'.$data_poczatkowa.'">';
					echo '<input type="text" size="8" class="pole_input_czerwone" autocomplete="off" name="data_koncowa" id="f_data_koncowa" value="'.$data_koncowa.'">';
					echo '<input type="submit" value="->">';
				echo '</td></tr></table>';
				?>
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "f_data_poczatkowa",     // id of the input field
						ifFormat       :    "%d-%m-%Y",      // format of the input field
						button         :    "f_data_poczatkowa",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script>
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "f_data_koncowa",     // id of the input field
						ifFormat       :    "%d-%m-%Y",      // format of the input field
						button         :    "f_data_koncowa",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script>
				<?php
			echo '</td></tr>';
			if($AKTUALNY_MIESIAC > 1) $poprzedni =  $AKTUALNY_MIESIAC-1;
			if($AKTUALNY_MIESIAC == 1) $poprzedni = 12; 
			if(($poprzedni >=1) && ($poprzedni <=9)) $poprzedni = '0'.$poprzedni;
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukany_miesiac='.$poprzedni.'"><font color="black">W zeszłym miesiącu</font></a></td></tr>';
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukany_miesiac='.$AKTUALNY_MIESIAC.'"><font color="black">W tym miesiącu</font></a></td></tr>';
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<a href="index.php?page=fv_fakturowanie'.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&sprawdzany_rok='.$AKTUALNY_ROK.'"><font color="black">W tym roku</font></a></td></tr>';
			}
		echo '</td></tr></table>';
	echo '</table><br>';
	
	// rozliczenie
	echo '<table border="0" class="text" width="100%" align="center" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center"><td>';
		echo '<table border="0" class="text" width="100%" align="center" cellpadding="0" cellspacing="0"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center">';
		if($rozliczenie == 'on') $checked_rozliczenie = ' checked '; else $checked_rozliczenie = ' ';
		echo '<td align="center"><input type="checkbox" id="rozliczenie" '.$checked_rozliczenie.' name="rozliczenie" onchange="submit();"></td>';
		echo '<td align="left" width="100%">Rozliczenie</td></tr>';
		if($rozliczenie == 'on')
			{
			if($radio_zaplacone == 'zaplacone') $checked_zaplacone = ' checked="checked" '; else $checked_zaplacone = ' ';
			if($radio_zaplacone == 'niezaplacone') $checked_niezaplacone = ' checked="checked" '; else $checked_niezaplacone = ' ';
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<input type="radio" '.$checked_zaplacone.' name="radio_zaplacone" value="zaplacone" onchange="submit();">zapłacone</td></tr>';
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<input type="radio" '.$checked_niezaplacone.' name="radio_zaplacone" value="niezaplacone" onchange="submit();">niezapłacone</td></tr>';
			}
		echo '</td></tr></table>';
	echo '</table><br>';

	// terminowosc
	echo '<table border="0" class="text" width="100%" align="center" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center"><td>';
		echo '<table border="0" class="text" width="100%" align="center" cellpadding="0" cellspacing="0"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center">';
		if($terminowosc == 'on') $checked_terminowosc = ' checked '; else $checked_terminowosc = ' ';
		echo '<td align="center"><input type="checkbox" id="terminowosc" '.$checked_terminowosc.' name="terminowosc" onchange="submit();"></td>';
		echo '<td align="left" width="100%">Terminowość</td></tr>';
		if($terminowosc == 'on')
			{
			if($radio_terminowosc == 'w_terminie') $checked_w_terminie = ' checked="checked" '; else $checked_w_terminie = ' ';
			if($radio_terminowosc == 'po_terminie') $checked_po_terminie = ' checked="checked" '; else $checked_po_terminie = ' ';
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<input type="radio" '.$checked_w_terminie.' name="radio_terminowosc" value="w_terminie" onchange="submit();">W terminie</td></tr>';
			echo '<tr bgcolor="'.$kolor_tabeli.'" class="text" align="left"><td colspan="2">'.$tabulator.'<input type="radio" '.$checked_po_terminie.' name="radio_terminowosc" value="po_terminie" onchange="submit();">Po terminie</td></tr>';
			}
		echo '</td></tr></table>';
	echo '</table><br>';

	// klient
	echo '<table border="0" class="text" width="100%" align="center" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center"><td>';
		echo '<table border="0" class="text" width="100%" align="center" cellpadding="0" cellspacing="0"><tr bgcolor="'.$kolor_tabeli.'" class="text" align="center">';
		if($klient == 'on') $checked_klient = ' checked '; else $checked_klient = ' ';
		echo '<td align="center"><input type="checkbox" id="klient" '.$checked_klient.' name="klient" onchange="submit();"></td>';
		echo '<td align="left" width="100%">Klient</td></tr>';
		if($klient == 'on')
			{
			echo '<tr class="text" align="left"><td colspan="2">'.$tabulator.'<input class="pole_input_czerwone" size="20" maxlenght="15 type="text" name="klient_nazwa" value="'.$klient_nazwa.'" id="klient_nazwa" autocomplete="off">';
			echo '<input type="submit" value="->">';
			echo '</td></tr>';
			}
		echo '</td></tr></table>';
	echo '</table><br>';

echo '</form>';
echo '</td></tr></table>';
?>