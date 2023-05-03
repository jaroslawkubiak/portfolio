<?php
// raport generuje sie przy wylogowaniu: function logout
//#################################   tworzymy raport na email   ##################################
$adres_ip = $_SERVER['REMOTE_ADDR'];
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';

$sql = "SELECT stanowisko FROM uzytkownicy where id=".$user_id.";";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 0) 
	while ($wynik = mysqli_fetch_assoc($result)) 
		{
		$user_stanowisko=$wynik['stanowisko'];
		}
			
		
//######################################################################################
//######################################################################################

if(($user_stanowisko == 'produkcja') || ($adres_ip == '127.0.0.1') || ($zalogowany_user == 1))
	{
	// robimy początkową godzinę i datę do raportu
	if($page == 'raporty')
		{
		//przetwarzanie z menu raportow
		$AKTUALNY_DZIEN = $przetworz_dzien;
		$AKTUALNY_MIESIAC = $przetworz_miesiac; 
		$AKTUALNY_ROK = $przetworz_rok;
		}
	else
		{
		//generowanie automatyczne dla danego dnia
		$time = time();
		$AKTUALNY_DZIEN = date('d', $time);
		$AKTUALNY_MIESIAC = date('m', $time);  //m  Numeric representation of a month, with leading zeros  	01 through 12
		$AKTUALNY_ROK = date('Y', $time);      //Y  A full numeric representation of a year, 4 digits  	Examples: 1999 or 2003
		}


	$dzisiaj_rano = mktime(0,0,0,$AKTUALNY_MIESIAC, $AKTUALNY_DZIEN, $AKTUALNY_ROK);
	$dzisiaj_wieczor = mktime(23,59,59,$AKTUALNY_MIESIAC, $AKTUALNY_DZIEN, $AKTUALNY_ROK);
	$dzisiaj = date('d-m-Y', $dzisiaj_wieczor);
	

	//wartosci realizacji
	$WARUNEK = ' WHERE data_wykonania >= "'.$dzisiaj_rano.'" AND data_wykonania <= "'.$dzisiaj_wieczor.'"';
	$ilosc_0 = 0;
	$ilosc_1 = 0;
	$ilosc_3 = 0;
	$ilosc_4 = 0;
	$ilosc_10 = 0;
	$wartosc_realizacji = 0;
	$sql = "SELECT * FROM realizacja_produkcji ".$WARUNEK." ORDER BY ID DESC;";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$rodzaj_produktu=$wynik['rodzaj_produktu'];
			if($rodzaj_produktu == 0) $ilosc_0 += $wynik['ilosc'];
			if($rodzaj_produktu == 1) $ilosc_1 += $wynik['ilosc'];
			if($rodzaj_produktu == 3) $ilosc_3 += $wynik['ilosc'];
			if($rodzaj_produktu == 4) $ilosc_4 += $wynik['ilosc'];
			if($rodzaj_produktu == 10) $ilosc_10 += $wynik['ilosc'];
			$wartosc_realizacji += $wynik['wartosc_realizacji'];
			}
	

	//ilosc przyjetych zamowien
	$ilosc_przyjetych_zamowien = 0;
	$wartosc_brutto_przyjetych_zamowien = 0;
	$sql = "SELECT * FROM zamowienia WHERE data_przyjecia = '".$dzisiaj."' AND status <> 'ANULOWANE';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$ilosc_przyjetych_zamowien++;
			$wartosc_brutto_przyjetych_zamowien += $wynik['wartosc_brutto'];	
			}
			

	$ilosc_wszystkich_zamowien = 0;
	$wartosc_brutto_wszystkich_zamowien = 0;
	$sql = "SELECT * FROM zamowienia WHERE status <> 'DOSTARCZONE' AND status <> 'ODEBRANE' AND status <> 'ANULOWANE';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$ilosc_wszystkich_zamowien++;
			$wartosc_brutto_wszystkich_zamowien += $wynik['wartosc_brutto'];	
			}
			

	$wartosc_realizacji = number_format($wartosc_realizacji, 2,'.',' ');
	$wartosc_brutto_przyjetych_zamowien = number_format($wartosc_brutto_przyjetych_zamowien, 2,'.',' ');
	$wartosc_brutto_wszystkich_zamowien = number_format($wartosc_brutto_wszystkich_zamowien, 2,'.',' ');

	//wartosc faktur
	$SUMA_wartosc_brutto_wystawionych = 0;
	$sql = "SELECT * FROM fv_naglowek WHERE data_wystawienia = '".$dzisiaj."' AND typ_dok = 'Faktura' AND waluta = 'PLN';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik22 = mysqli_fetch_assoc($result)) 
			$SUMA_wartosc_brutto_wystawionych +=$wynik22['wartosc_brutto_fv'];
	$SUMA_wartosc_brutto_wystawionych = number_format($SUMA_wartosc_brutto_wystawionych, 2,'.',' ');

	//nie zaplacone faktury
	$SUMA_nie_zaplaconych = 0;
	$sql = "SELECT * FROM fv_naglowek WHERE zaplacona = 'nie' AND typ_dok = 'Faktura'  AND waluta = 'PLN';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik22 = mysqli_fetch_assoc($result)) 
			{
			$SUMA_nie_zaplaconych +=$wynik22['wartosc_brutto_fv'];
			}
	$SUMA_nie_zaplaconych = number_format($SUMA_nie_zaplaconych, 2,'.',' ');

	//przeterminowane faktury
	$SUMA_przeterminowanych = 0;
	$sql = "SELECT * FROM fv_naglowek WHERE zaplacona = 'nie' AND termin_platnosci < '".$time."' AND typ_dok = 'Faktura' AND waluta = 'PLN';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik22 = mysqli_fetch_assoc($result)) 
			{
			$SUMA_przeterminowanych += $wynik22['do_zaplaty'];
			}
	$SUMA_przeterminowanych = number_format($SUMA_przeterminowanych, 2,'.',' ');



	//wyceny wstępne
	$WARUNEK2 = ' WHERE data_wyceny >= "'.$dzisiaj_rano.'" AND pozycja = 1 AND data_wyceny <= "'.$dzisiaj_wieczor.'";';
	$ilosc_wycen_wstepnych=0;
	$wartosc_wycen_wstepnych = 0;
	$sql = "SELECT * FROM wyceny ".$WARUNEK2.";";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$ilosc_wycen_wstepnych++;
			$wartosc_wycen_wstepnych += $wynik['wycena_wstepna_wartosc_netto'];
			}
	$wartosc_wycen_wstepnych = number_format($wartosc_wycen_wstepnych, 2,'.',' ');

	//################################## ilosc aktywnych klientow w oparicu o data ostatniego zamowienia ##################################
	$nieaktywny = 0;
	$czas_miedzy_zamowieniami_2 = 5184000;
	$aktywny = 0;
	$pytanie = mysqli_query($conn, "SELECT data_ostatniego_zamowienia FROM klienci;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$data_ostatniego_zamowienia = $wynik['data_ostatniego_zamowienia'];
		
		if($data_ostatniego_zamowienia != '')
			{
			$rozbite = explode("-", $data_ostatniego_zamowienia);
			$data_ostatniego_zamowienia_time = mktime(0, 0, 0, $rozbite[1], $rozbite[0], $rozbite[2]);
			$odstep = $time - $czas_miedzy_zamowieniami_2 - $data_ostatniego_zamowienia_time;
			if($odstep > 0) $nieaktywny++;
			else $aktywny++;
			}
		}
		
	//################################## Ilość wysłanych ofert indywidualnych ##################################
	$data_dzis = date('d-m-Y', $time);
	$ilosc_ofert_indywidualnych = 0;
	$sql = "SELECT * FROM oferta_indywidualna WHERE data = '".$data_dzis."';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$ilosc_ofert_indywidualnych++;
			}


	//tresc raportu
	$RAPORT = 'Raport z dnia '.$dzisiaj.' : <br>';
	$RAPORT .= '- Wydane profile : '.$ilosc_0.'<br>';
	$RAPORT .= '- Wygięte łuki z pvc : '.$ilosc_1.'<br>';
	$RAPORT .= '- Wygięte łuki z alu : '.$ilosc_3.'<br>';
	$RAPORT .= '- Wykonane zgrzewy : '.$ilosc_4.'<br>';
	$RAPORT .= '- Spakowane wyroby : '.$ilosc_10.'<br>';
	$RAPORT .= '- Wartość produkcji : '.$wartosc_realizacji.' zł<br>';
	$RAPORT .= '---------------------------------------------------------------<br>';
	$RAPORT .= '- Ilość przyjętych zamówień : '.$ilosc_przyjetych_zamowien.' ('.$ilosc_wszystkich_zamowien.')<br>';
	$RAPORT .= '- Wartość brutto przyjętych zamówień : '.$wartosc_brutto_przyjetych_zamowien.' zł ('.$wartosc_brutto_wszystkich_zamowien.' zł)<br>';
	$RAPORT .= '---------------------------------------------------------------<br>';
	$RAPORT .= '- Wartość brutto wystawionych faktur : '.$SUMA_wartosc_brutto_wystawionych.' zł<br>';
	$RAPORT .= '---------------------------------------------------------------<br>';
	$RAPORT .= '- Wartość brutto przeterminowanych należności : '.$SUMA_przeterminowanych.' zł<br>';
	$RAPORT .= '- Wartość brutto nie zapłaconych należności : '.$SUMA_nie_zaplaconych.' zł<br>';
	$RAPORT .= '---------------------------------------------------------------<br>';
	$RAPORT .= '- Ilość wysłanych wycen wstępnych : '.$ilosc_wycen_wstepnych.'<br>';
	$RAPORT .= '- Wartość netto wysłanych wycen wstępnych : '.$wartosc_wycen_wstepnych.' zł<br>';
	$RAPORT .= '---------------------------------------------------------------<br>';
	$RAPORT .= '- Ilość aktywnych klientów : '.$aktywny.'<br>';
	$RAPORT .= '---------------------------------------------------------------<br>';
	$RAPORT .= '- Ilość wysłanych ofert indywidualnych : '.$ilosc_ofert_indywidualnych.'<br>';
	

	$wyslij_do = 'biuro@arcus-luki.pl';
	$nadawca = 'biuro@arcus-luki.pl';
	$adres_ip = $_SERVER['REMOTE_ADDR'];

	//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
	if($adres_ip == '127.0.0.1') $wyslij_do = 'braniewska7@gmail.com';

	if($adres_ip != '127.0.0.1')
		{
		$temat = 'Raport z dnia '.$dzisiaj; 
		//new phpmailer v6.16
		require 'phpmailer6/src/Exception.php';
		require 'phpmailer6/src/PHPMailer.php';
		require 'phpmailer6/src/SMTP.php';

		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->FromName = 'Panel Arcus';
		$mail->From = $nadawca;
		$mail->AddAddress($wyslij_do);
		$mail->AddReplyTo($nadawca,"Arcus");
		$mail->Subject = $temat;
		$mail->IsHTML(true);
		$mail->Body = $RAPORT;
		$mail->setLanguage('pl');
		
		if(!$mail->Send()) 
			{
			$error_info = $mail->ErrorInfo;
			$strona = 'generuj_raport.php';
			$napis_dzisiaj = 'raport z dnia '.$dzisiaj;
			//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
			show_mail_send_error_info($error_info, $strona, $napis_dzisiaj, $wyslij_do);
			} 	
		}

	if($page != 'raporty') $result = mysqli_query($conn, "INSERT INTO raporty (`data`, `data_time`, `tresc`) values ('$dzisiaj', '$time', '$RAPORT');");

	} // do if($user_stanowisko == 'produkcja')
	
		
?>