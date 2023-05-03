<?php
define("SESID", SESSION_NAME() . "=" . SESSION_ID());

// ################## sprawdza czy zalogowany 
function auth()
	{
	$_SESSION["USER_AUTH"] = isset($_SESSION["USER_AUTH"]) ? $_SESSION["USER_AUTH"] : '';
	return ($_SESSION["USER_AUTH"] == True);
	}

// ################## pokazuje blad zapytania 
function show_mysqli_query($conn, $query)
	{
	//do funkcji musi trafic samo zapytanie np: SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";
	$result = mysqli_query($conn, $query);
	$zalogowany_user = isset($_SESSION["USER_ID"]) ? $_SESSION["USER_ID"] : '';

	//tylko dla roota pokazuje błędy zapytań.
	if(($zalogowany_user == 1) && (!$result)) echo'<div class="text"><font color="red">' .mysqli_error($conn). ' : </font><font color="blue">'.$query.'</font></div>';

	//tylko dla roota pokazuje że zapytanie się wykonało poprawnie
	if(($zalogowany_user == 1) && ($result)) echo'<div class="text"><font color="blue">OK : </font><font color="blue">'.$query.'</font></div>';
	}



// ################## pobiera dane o przegladarce 
function getBrowser() 
	{ 
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$version= "";


	// Next get the name of the useragent yes seperately and for good reason
	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	}elseif(preg_match('/Firefox/i',$u_agent)){
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	}elseif(preg_match('/OPR/i',$u_agent)){
		$bname = 'Opera';
		$ub = "Opera";
	}elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
		$bname = 'Google Chrome';
		$ub = "Chrome";
	}elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
		$bname = 'Apple Safari';
		$ub = "Safari";
	}elseif(preg_match('/Netscape/i',$u_agent)){
		$bname = 'Netscape';
		$ub = "Netscape";
	}elseif(preg_match('/Edge/i',$u_agent)){
		$bname = 'Edge';
		$ub = "Edge";
	}elseif(preg_match('/Trident/i',$u_agent)){
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	}

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
	')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
		// we have no matching number just continue
	}
	// see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
		//we will have two since we are not using 'other' argument yet
		//see if version is before or after the name
		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			$version= $matches['version'][0];
		}else {
			$version= $matches['version'][1];
		}
	}else {
		$version= $matches['version'][0];
	}

	// check if we have a number
	if ($version==null || $version=="") {$version="?";}

	return array(
		'name'      => $bname,
		'pattern'    => $pattern
	);
	} 


	$_POST["login"] = isset($_POST["login"]) ? $_POST["login"] : '';
	$_POST["passwd"] = isset($_POST["passwd"]) ? $_POST["passwd"] : '';
	$login  = htmlentities(substr($_POST["login"], 0, 255));
	$passwd = htmlentities(substr($_POST["passwd"], 0, 255));

// ############################# generuje i uaktualniam nowy numer wz ######################
function generuj_numer_wz($conn)
	{
		$time = time();
		$AKTUALNY_MIESIAC = date('m', $time);  
		$AKTUALNY_ROK = date('Y', $time);

		$pytanie333 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'numer_wz';");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			$numer_wz=$wynik333['opis'];
		
		//tworze numer wz
		$nowy_numer_wz = 'WZ/'.$numer_wz."/".$AKTUALNY_MIESIAC."/".$AKTUALNY_ROK;
		
		//uaktualniam numer wz
		$numer_wz++;
		mysqli_query($conn, "UPDATE rozne SET opis = '".$numer_wz."' WHERE typ = 'numer_wz';");
		return($nowy_numer_wz);
		// $nowy_numer_wz = generuj_numer_wz($conn);
	}


// ############################# Pobierz wartosc netto z wyceny ######################
function pobierz_wartosc_netto($zamowienie_id, $conn)
	{
	$wartosc_netto = 0;
	$pytanie33 = mysqli_query($conn, "SELECT wartosc_netto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE';");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		$wartosc_netto += $wynik33['wartosc_netto'];

	// echo 'pobralem z wycen netto:'.$wartosc_netto.' dla zam id:'.$zamowienie_id.'<br>';
	return($wartosc_netto);
	}

// ############################# Pobierz wartosc brutto z wyceny ######################
function pobierz_wartosc_brutto($zamowienie_id, $conn)
	{
	$wartosc_brutto = 0;
	$pytanie33 = mysqli_query($conn, "SELECT  wartosc_brutto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE';");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		$wartosc_brutto += $wynik33['wartosc_brutto'];

	// echo 'pobralem z wycen brutto<br>';
	return($wartosc_brutto);
	}


// ########## zaloguj user-a ##########
function login($login, $passwd, $conn)
	{
	//pobieram dane o przeglądarce
	$ua=getBrowser();
	$przegladarka = $ua['name'];

	//pobieram dane o systemie operacyjnym
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$os_platform  = "Unknown OS Platform";
    $os_array = array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
		);
    foreach ($os_array as $regex => $value) if (preg_match($regex, $user_agent)) $os_platform = $value;
	
	
	if(isset($_SERVER['HTTP_CLIENT_IP'])) $twoje_ip = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $twoje_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else $twoje_ip = $_SERVER['REMOTE_ADDR'];
	$host = gethostbyaddr($twoje_ip);
	$time = time();
	$user_istnieje = 0;

	if(($login != "") && ($passwd != ""))
		{
		$sql = "SELECT id, nazwa, haslo, aktywny FROM uzytkownicy where nazwa = '".$login."';";
		$result = mysqli_query($conn,  $sql);

		$result_check = mysqli_num_rows($result);

		if($result_check > 0) 
			{
			while ($row = mysqli_fetch_assoc($result)) 
				{
				$user_istnieje = 1;
				$user_name=$row['nazwa'];
				$user_password=$row['haslo'];
				$user_id=$row['id'];
				$aktywny=$row['aktywny'];
				}

			if(($aktywny == 'on') && ($user_istnieje == 1))
				{	
				if (($login == $user_name) && ($passwd == $user_password) && ($login != "") && ($passwd != ""))
					{
					//echo '<br>zalogowany!!';
					$_SESSION["USER_AUTH"]  = True;
					$_SESSION["USER_LOGIN"] = $_POST["login"];
					$_SESSION["USER_ID"] = $user_id;

					//zapisuje dane logowania uzytkownikow
					$godzina_logowania = time();
					$sess_id = session_id();
					$sql = "INSERT INTO logowania_uzytkownikow2 (`session_id`, `user_id`, `godzina_logowania`) VALUES ('$sess_id', '$user_id', '$godzina_logowania');";
					$result = mysqli_query($conn, $sql);

					if($user_name != 'root') $query = mysqli_query($conn, "INSERT INTO logowania_uzytkownikow (`data`, `login`, `haslo`, `adres_ip`, `przegladarka`, `system_operacyjny`, `host`, `user_agent`, `status_logowania`) values ('$time', '$login', '$passwd', '$twoje_ip', '$przegladarka', '$os_platform', '$host', '$user_agent', 'true');");
					//$login = htmlentities($login);
					return True;
					}
				else
					{
					if($user_name != 'root') $query = mysqli_query($conn, "INSERT INTO logowania_uzytkownikow (`data`, `login`, `haslo`, `adres_ip`, `przegladarka`, `system_operacyjny`, `host`, `user_agent`, `status_logowania`) values ('$time', '$login', '$passwd', '$twoje_ip', '$przegladarka', '$os_platform', '$host', '$user_agent', 'false');");
					echo '<br><br><br><div align="center" class="text_ogromny_czerwony">Błąd logowania - Niewłaściwy login lub hasło.</div>';
					}
				}
			else
				{
				// login NIEAKTYWNY
				if($user_name != 'root') $query = mysqli_query($conn, "INSERT INTO logowania_uzytkownikow (`data`, `login`, `haslo`, `adres_ip`, `przegladarka`, `system_operacyjny`, `host`, `user_agent`, `status_logowania`) values ('$time', '$login', '$passwd', '$twoje_ip', '$przegladarka', '$os_platform', '$host', '$user_agent', 'false');");
				echo '<br><br><br><div align="center" class="text_ogromny_czerwony">Błąd logowania - Twoje konto wygasło.</div>';
				}
			}
		if($user_istnieje == 0) echo '<br><br><br><div align="center" class="text_ogromny_czerwony">Błąd logowania - Taki użytkownik nie istnieje.</div>';
		}
	else
		{
		if(($login == "") && ($passwd == "")) echo '<br><br><br><div align="center" class="text_ogromny_czerwony">Błąd logowania - Proszę wpisać login i hasło.</div>';
		elseif(($login == "") && ($passwd != "")) echo '<br><br><br><div align="center" class="text_ogromny_czerwony">Błąd logowania - Proszę wpisać login.</div>';
		elseif(($login != "") && ($passwd == "")) echo '<br><br><br><div align="center" class="text_ogromny_czerwony">Błąd logowania - Proszę wpisać hasło.</div>';
		}

	return False;
	}

// ######## wyloguj user-a ##########
function logout($user_id, $conn)
	{
	//zapisuje czas logowania userów
	$godzina_wylogowania = time();
	$sess_id = session_id();

	$sql = "SELECT id, godzina_logowania, user_id FROM logowania_uzytkownikow2 WHERE session_id = '".$sess_id."' ORDER BY id DESC LIMIT 1;";
	$result = mysqli_query($conn,  $sql);
	$i = mysqli_num_rows($result);
	if($i > 0) 
		while ($wynik5 = mysqli_fetch_assoc($result)) 
			{
			$godzina_logowania=$wynik5['godzina_logowania'];
			$id = $wynik5['id'];
			$user_id = $wynik5['user_id'];
			}

	$czas_log = $godzina_wylogowania - $godzina_logowania;
	$sql = "update logowania_uzytkownikow2 set godzina_wylogowania='".$godzina_wylogowania."' WHERE session_id = '".$sess_id."' AND id = ".$id.";";
	$result = mysqli_query($conn,  $sql);
	$sql = "update logowania_uzytkownikow2 set czas_log='".$czas_log."' WHERE session_id = '".$sess_id."' AND id = ".$id.";";
	$result = mysqli_query($conn,  $sql);

	$adres_strony_serwera = $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']; 
	include ("php/generuj_raport.php");	

	$_SESSION["USER_AUTH"]  = False;
	$_SESSION["USER_LOGIN"] = Null;
	$_SESSION = array();
	session_destroy();
	}

// #############################  zamien polskie znaki i spacje ###############################################
function change_znaki($string)
	{
	$patterns = array();
	$patterns[0] = '/Ó/';
	$patterns[1] = '/Ą/';
	$patterns[2] = '/Ż/';
	$patterns[3] = '/Ź/';
	$patterns[4] = '/Ć/';
	$patterns[5] = '/Ń/';
	$patterns[6] = '/Ś/';
	$patterns[7] = '/Ł/';
	$patterns[8] = '/Ę/';
	$patterns[9] = '/ó/';
	$patterns[10] = '/ą/';
	$patterns[11] = '/ż/';
	$patterns[12] = '/ź/';
	$patterns[13] = '/ć/';
	$patterns[14] = '/ń/';
	$patterns[15] = '/ś/';
	$patterns[16] = '/ł/';
	$patterns[17] = '/ę/';
	$patterns[18] = '/ /';

	$replacements = array();
	$replacements[0] = 'O';
	$replacements[1] = 'A';
	$replacements[2] = 'Z';
	$replacements[3] = 'Z';
	$replacements[4] = 'C';
	$replacements[5] = 'N';
	$replacements[6] = 'S';
	$replacements[7] = 'L';
	$replacements[8] = 'E';
	$replacements[9] = 'o';
	$replacements[10] = 'a';
	$replacements[11] = 'z';
	$replacements[12] = 'z';
	$replacements[13] = 'c';
	$replacements[14] = 'n';
	$replacements[15] = 's';
	$replacements[16] = 'l';
	$replacements[17] = 'e';
	$replacements[18] = '';
	$string = preg_replace($patterns, $replacements, $string);

	return $string;
	} 
// ######################  zamien polskie znaki bez spacji ###############################################
function usun_polskie($string)
	{
	// echo 'usuwam polskie<br>';
	$patterns = array();
	$patterns[0] = '/Ó/';
	$patterns[1] = '/Ą/';
	$patterns[2] = '/Ż/';
	$patterns[3] = '/Ź/';
	$patterns[4] = '/Ć/';
	$patterns[5] = '/Ń/';
	$patterns[6] = '/Ś/';
	$patterns[7] = '/Ł/';
	$patterns[8] = '/Ę/';
	$patterns[9] = '/ó/';
	$patterns[10] = '/ą/';
	$patterns[11] = '/ż/';
	$patterns[12] = '/ź/';
	$patterns[13] = '/ć/';
	$patterns[14] = '/ń/';
	$patterns[15] = '/ś/';
	$patterns[16] = '/ł/';
	$patterns[17] = '/ę/';

	$replacements = array();
	$replacements[0] = 'O';
	$replacements[1] = 'A';
	$replacements[2] = 'Z';
	$replacements[3] = 'Z';
	$replacements[4] = 'C';
	$replacements[5] = 'N';
	$replacements[6] = 'S';
	$replacements[7] = 'L';
	$replacements[8] = 'E';
	$replacements[9] = 'o';
	$replacements[10] = 'a';
	$replacements[11] = 'z';
	$replacements[12] = 'z';
	$replacements[13] = 'c';
	$replacements[14] = 'n';
	$replacements[15] = 's';
	$replacements[16] = 'l';
	$replacements[17] = 'e';
	$string = preg_replace($patterns, $replacements, $string);

	return $string;
	} 
// #####################  pokazuje info przy probie wysylki email ###############################################
function show_mail_send_error_info($error_info, $page, $fak_zam_inne, $odbiorca)
	{
	echo '<font color="black" size=+1">Email nie został wysłany!<br></font>';
	echo '<font color="red" size=+2">'.$error_info.'</font><br>';
	echo '<font color="black" size=+1">Proszę spróbować ponownie później.<br></font>';

	$tresc_maila = '<html><head>';
	$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
	$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
	$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
	$tresc_maila .= '<div align="left">';
	$tresc_maila .= 'Wystapil blad przy wysylce emaila. <br>';
	$tresc_maila .= 'Opis bledu: <br><font color="red">'.$error_info.'</font><br>';
	$tresc_maila .= 'Strona z ktorej byl wyslany email: <font color="red">'.$page.'</font><br>';
	$tresc_maila .= 'Faktura, zamowienie, itp: <font color="red">'.$fak_zam_inne.'</font><br>';
	$tresc_maila .= 'Odbiorca emaila: <font color="red">'.$odbiorca.'</font><br>';
	$tresc_maila .= '</div>';
	$tresc_maila .= '</html>';
	// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);

	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->FromName = 'Panel Arcus';
	$mail->From = 'falconintheairpl@gmail.com';
	$mail->AddAddress('jarekkubiak@icloud.com');
	$mail->AddReplyTo('falconintheairpl@gmail.com',"Panel Arcus");
	$mail->Subject = 'Blad przy wysylce email.';
	$mail->IsHTML(true);
	$mail->Body = $tresc_maila;
	$mail->setLanguage('pl');
	if(!$mail->Send()) 	echo '<br><br><font color="red" size=+2">Nie udało się wysłać opisu błędu do mnie. Proszę o zrzut ekranu i wysyłkę go na mój email.</font><br>';
	else echo '<br><font color="blue" size=+1"><b>Info o tym błędzie dostałem na email.</b></font><br>';

	}
// #################  funkcja ktora liczy klikniecia na stronach panelu   ###############################################
function page_visit_counter($conn, $page)
	{
	//szukamy czy dana strona byla juz odwiedzona
	$sql = "SELECT * FROM page_visit_counter WHERE page = '".$page."';";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) 
		{
		while ($wynik = mysqli_fetch_assoc($result)) 
			$counter=$wynik['visit_count'];
			// byly odwiedziny, mam licznik, zwiekszamy i updatujemy
			$counter = $counter + 1;
			$result = mysqli_query($conn, "update page_visit_counter SET visit_count = ".$counter." WHERE page = '".$page."';");
		}
	else $result = mysqli_query($conn, "INSERT INTO page_visit_counter (`page`, `visit_count`) VALUES ('$page', 1);");  //brak odwiedzin - dodajemy nowy wpis
	}
// ########## nowy klient  ##########
function dodaj_klienta($conn, $nazwa, $ulica, $miasto, $kod_pocztowy, $nip, $status_firmy, $pelna_nazwa, $kraj)
	{
	$data_dodania = time();
	// generujemy nowy login i hasło
	$nowy_login = change_znaki($nazwa);
	$nowy_login = substr($nowy_login, 0, 8);
	$nowe_haslo1 = generate_password();


	for ($m=1; $m <= 10; $m++)
		{
		//szukamy takiego loginu w bazie
		$taki_login_istnieje = 0;
		$pytanie224 = mysqli_query($conn, "SELECT login FROM klienci WHERE login = '".$nowy_login."';");
		while($wynik224= mysqli_fetch_assoc($pytanie224))
			$taki_login_istnieje = 1;
	
		if($taki_login_istnieje == 1) $nowy_login = $nowy_login.$m;
		else $m = 10;
		}


	$query = mysqli_query($conn, "INSERT INTO klienci (`nazwa`, `ulica`, `miasto`, `kod_pocztowy`, `nip`, `login`, `haslo`, `data_dodania`, `status_firmy`, `pelna_nazwa`, `kraj`, `aktywny`) 
	values ('$nazwa', '$ulica', '$miasto', '$kod_pocztowy', '$nip', '$nowy_login', '$nowe_haslo1', '$data_dodania', '$status_firmy', '$pelna_nazwa', '$kraj', 'on');");

	$klient_id = mysqli_insert_id($conn);
	return $klient_id;
	}
// ########## dodaj zamowienie  ##########
function dodaj_zamowienie($conn, $klient, $typ_zamowienia ,$nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $bez_potwierdzenia, $rodzaj, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy)
	{
	$time = time();
	$AKTUALNY_MIESIAC = date('m', $time);
	$aktualny_rok = date('y', $time);
	$zalogowany_user=$_SESSION["USER_ID"];

	//sprawdzamy czy to nie zdublowane zamówienie
	$szukany_czas = $time - 60;
	$dubel=0;
	$pytanie313 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE data_time > '".$szukany_czas."' AND user_id = ".$zalogowany_user." AND klient_id = ".$klient." ORDER BY id DESC LIMIT 10;");
	while($wynik313= mysqli_fetch_assoc($pytanie313))
		{
		$dubel++;
		}


	if($dubel == 0)
		{
		// pobieram dane z bazy
		if($typ_zamowienia == 'zamowienie')
			{
			$pytanie33 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_zamowienia';");
			while($wynik33= mysqli_fetch_assoc($pytanie33))
				$kolejny_nr_zamowienia=$wynik33['opis'];
			
			$nowy_numer_zamowienia = $kolejny_nr_zamowienia."/".$AKTUALNY_MIESIAC."/".$aktualny_rok;
			$kolejny_nr_zamowienia++;
			$pytanie122 = mysqli_query($conn, "UPDATE rozne SET opis = '".$kolejny_nr_zamowienia."' WHERE typ = 'nr_zamowienia' ;");
			}
			
		if($typ_zamowienia == 'reklamacja')
			{
			$pytanie333 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_reklamacji'");
			while($wynik333= mysqli_fetch_assoc($pytanie333))
				$kolejny_nr_reklamacji=$wynik333['opis'];
			
			$nowy_numer_zamowienia = $kolejny_nr_reklamacji."/".$aktualny_rok.'/RK';
			$kolejny_nr_reklamacji++;
			$pytanie122 = mysqli_query($conn, "UPDATE rozne SET opis = '".$kolejny_nr_reklamacji."' WHERE typ = 'nr_reklamacji' ;");
			}
		
		$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			$klient_nazwa=$wynik33['nazwa'];
		
		$data_przyjecia = date('d-m-Y', $time);
		
		$pytanie133 = mysqli_query($conn, "UPDATE klienci SET strefa = '".$strefa."' WHERE id = ".$klient.";");
		$pytanie133 = mysqli_query($conn, "UPDATE klienci SET data_ostatniego_zamowienia = '".$data_przyjecia."' WHERE id = ".$klient.";");
		
		$query = "INSERT INTO zamowienia (`klient_id`, `klient_nazwa`, `typ`, `data_przyjecia`, `nr_zamowienia`, `nr_zamowienia_klienta`, `zamowiony_produkt`, `system_profili`, `rodzaj_okuc`, `rodzaj_szyb`, `kolor_profili`, `kolor_uszczelek`, `magazyn`, `stan`, `termin_realizacji`, `data_dostawy`, `status`, `uwagi`, `rodzaj`, `uwaga_1`, `uwaga_2`, `miasto_dostawy`, `kod_pocztowy_dostawy`, `ulica_dostawy`, `strefa`, `uwagi_do_email`, `odbior_materialu`, `data_time`, `user_id`, `data_przyjecia_time`) 
		values ('$klient', '$klient_nazwa', '$typ_zamowienia', '$data_przyjecia', '$nowy_numer_zamowienia', '$nr_zamowienia_klienta', '$produkt', '$profil', '$rodzaj_okuc', '$rodzaj_szyb', '$kolor_profili', '$kolor_uszczelek', '$magazyn', '$stan', '$termin_realizacji', '$data_dostawy', '$status', '$uwagi', '$rodzaj', '$uwaga_1', '$uwaga_2', '$miasto_dostawy', '$kod_pocztowy_dostawy', '$ulica_dostawy', '$strefa', '$uwagi_do_email', '$odbior_materialu', '$time', '$zalogowany_user', '$time');";
		mysqli_query($conn, $query);

		$test_zamowienie_id = mysqli_insert_id($conn);
		}
	else
		{
		echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=zamowienia&jak=DESC&wg_czego=id&dubel=tak"></head>';
		}
	return $nowy_numer_zamowienia;
	//return $zamowienie_id;
	}
// ########## edytuj zamowienie  php  7 ok ##########
function edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto_edycja, $wartosc_brutto_edycja, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac)
	{
	// echo 'ZAM ID='.$zamowienie_id.'<br>';
	$time = time();
	$AKTUALNY_MIESIAC = date('m', $time);
	$aktualny_rok = date('y', $time);
	$pytanie33 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$klient.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		$klient_nazwa=$wynik33['nazwa'];
		
	// sprawdzamy czy poprzedni status to dostarczone, wtedy kasujemy zlec transp
	$pytanie33 = mysqli_query($conn, "SELECT status, kurs_euro FROM zamowienia WHERE id = ".$zamowienie_id.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$stary_status=$wynik33['status'];
		$stary_kurs_euro=$wynik33['kurs_euro'];
		}
	if($stary_status == 'Dostarczone') 
		{
		$pytanie130 = mysqli_query($conn, "UPDATE zamowienia SET nr_zlecenia_transportowego = '' WHERE id = ".$zamowienie_id.";");
		$pytanie132 = mysqli_query($conn, "UPDATE zamowienia SET status = '".$status."' WHERE id = ".$zamowienie_id.";");
		$pytanie450 = mysqli_query($conn, "UPDATE wyceny SET status = '".$status."' WHERE zamowienie_id = ".$zamowienie_id.";");
		}
	else
		{
		//szukam i wyliczam wart netto i brutto z wycen
		$SUMA_wartosc_netto = 0;
		$SUMA_wartosc_brutto = 0;
		$pytanie33 = mysqli_query($conn, "SELECT wartosc_netto, wartosc_brutto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id.";");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$SUMA_wartosc_netto += $wynik33['wartosc_netto'];
			$SUMA_wartosc_brutto += $wynik33['wartosc_brutto'];
			}
			
		$SUMA_wartosc_netto = change($SUMA_wartosc_netto);
		$SUMA_wartosc_brutto = change($SUMA_wartosc_brutto);

		$SQL = [];
		//tresc zapytan
		$SQL[1] = "UPDATE zamowienia SET wartosc_netto = ".$SUMA_wartosc_netto." WHERE id = ".$zamowienie_id.";";
		$SQL[2] = "UPDATE zamowienia SET wartosc_brutto = ".$SUMA_wartosc_brutto." WHERE id = ".$zamowienie_id.";";
		$SQL[3] = "UPDATE zamowienia SET klient_id = ".$klient." WHERE id = ".$zamowienie_id.";";
		$SQL[4] = "UPDATE zamowienia SET klient_nazwa = '".$klient_nazwa."' WHERE id = ".$zamowienie_id.";";
		$SQL[5] = "UPDATE zamowienia SET nr_zamowienia = '".$nr_zamowienia."' WHERE id = ".$zamowienie_id.";";
		$SQL[6] = "UPDATE zamowienia SET nr_zamowienia_klienta = '".$nr_zamowienia_klienta."' WHERE id = ".$zamowienie_id.";";
		$SQL[7] = "UPDATE zamowienia SET zamowiony_produkt = '".$produkt."' WHERE id = ".$zamowienie_id.";";
		$SQL[8] = "UPDATE zamowienia SET system_profili = '".$profil."' WHERE id = ".$zamowienie_id.";";
		$SQL[9] = "UPDATE zamowienia SET rodzaj = '".$rodzaj."' WHERE id = ".$zamowienie_id.";";
		$SQL[10] = "UPDATE zamowienia SET rodzaj_okuc = '".$rodzaj_okuc."' WHERE id = ".$zamowienie_id.";";
		$SQL[11] = "UPDATE zamowienia SET rodzaj_szyb = '".$rodzaj_szyb."' WHERE id = ".$zamowienie_id.";";
		$SQL[12] = "UPDATE zamowienia SET kolor_profili = '".$kolor_profili."' WHERE id = ".$zamowienie_id.";";
		$SQL[13] = "UPDATE zamowienia SET kolor_uszczelek = '".$kolor_uszczelek."' WHERE id = ".$zamowienie_id.";";
		$SQL[14] = "UPDATE zamowienia SET magazyn = '".$magazyn."' WHERE id = ".$zamowienie_id.";";
		$SQL[15] = "UPDATE zamowienia SET stan = '".$stan."' WHERE id = ".$zamowienie_id.";";
		$SQL[16] = "UPDATE zamowienia SET miasto_dostawy = '".$miasto_dostawy."' WHERE id = ".$zamowienie_id.";";
		$SQL[17] = "UPDATE zamowienia SET termin_realizacji = '".$termin_realizacji."' WHERE id = ".$zamowienie_id.";";
		$SQL[18] = "UPDATE zamowienia SET data_dostawy = '".$data_dostawy."' WHERE id = ".$zamowienie_id.";";
		$SQL[19] = "UPDATE zamowienia SET nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."' WHERE id = ".$zamowienie_id.";";
		$SQL[20] = "UPDATE zamowienia SET ulica_dostawy = '".$ulica_dostawy."' WHERE id = ".$zamowienie_id.";";
		$SQL[21] = "UPDATE zamowienia SET kod_pocztowy_dostawy = '".$kod_pocztowy_dostawy."' WHERE id = ".$zamowienie_id.";";
		$SQL[22] = "UPDATE zamowienia SET zablokowac = '".$zablokowac."' WHERE id = ".$zamowienie_id.";";

		//wykonanie zapytan
		for($s=1; $s<=22; $s++) mysqli_query($conn, $SQL[$s]);

		//jezeli usunęliśmy nr zlec transp to zerujemy też link dostawy, datę wysyłki potw dostawy i numer wz
		if($nr_zlecenia_transportowego == '')
		{
			$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET numer_wz = '' WHERE id = ".$zamowienie_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET data_wysylki_potwierdzenia_dostawy = '' WHERE id = ".$zamowienie_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET link_dostawa = '' WHERE id = ".$zamowienie_id.";");
		}

		$SQL = [];
		//tresc zapytan
		$SQL[1] = "UPDATE zamowienia SET uwagi = '".$uwagi."' WHERE id = ".$zamowienie_id.";";
		$SQL[2] = "UPDATE zamowienia SET uwaga_1 = '".$uwaga_1."' WHERE id = ".$zamowienie_id.";";
		$SQL[3] = "UPDATE zamowienia SET uwaga_2 = '".$uwaga_2."' WHERE id = ".$zamowienie_id.";";
		$SQL[4] = "UPDATE zamowienia SET uwagi_do_email = '".$uwagi_do_email."' WHERE id = ".$zamowienie_id.";";
		$SQL[5] = "UPDATE zamowienia SET odbior_materialu = '".$odbior_materialu."' WHERE id = ".$zamowienie_id.";";
		$SQL[6] = "UPDATE zamowienia SET strefa = '".$strefa."' WHERE id = ".$zamowienie_id.";";
		$SQL[7] = "UPDATE klienci SET strefa = '".$strefa."' WHERE id = ".$klient.";";
		
		//wykonanie zapytan
		for($s=1; $s<=7; $s++) mysqli_query($conn, $SQL[$s]);


		if($kurs_euro != '') 
			{
			$kurs_euro = change($kurs_euro);
			$pytanie133 = mysqli_query($conn, "UPDATE zamowienia SET kurs_euro = ".$kurs_euro." WHERE id = ".$zamowienie_id.";");
			}
		elseif($kurs_euro == '') $pytanie133 = mysqli_query($conn, "UPDATE zamowienia SET kurs_euro = NULL WHERE id = ".$zamowienie_id.";");
			
		// ######################################################## sprawdzamy czy jet wystawiona fv w PLN i dodalismy kurs euro ##############################################################
		if(($kurs_euro != 0) && ($kurs_euro != ''))
			{
			//jak wpisujemy kurs euro to generujemy fv w EUR
			//spr nr fv
			$ilosc_nr_fv = 0;
			$pytanie323 = mysqli_query($conn, "SELECT DISTINCT nr_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND typ_dok = 'Faktura';");
			while($wynik323= mysqli_fetch_assoc($pytanie323))
				{
				$ilosc_nr_fv++;
				$nr_fv_z_wyceny[$ilosc_nr_fv]=$wynik323['nr_faktury'];
				}
			
			// przetwarzanie pdf faktur
			for($m = 1; $m<=$ilosc_nr_fv; $m++)
				{
				$pytanie1323 = mysqli_query($conn, "SELECT id FROM fv_naglowek WHERE nr_dok = '".$nr_fv_z_wyceny[$m]."' AND typ_dok = 'Faktura';");
				while($wynik1323= mysqli_fetch_assoc($pytanie1323))
					{
					$fv_id_wiecej_pozycji[$m]=$wynik1323['id'];
					}
				$pytanie133 = mysqli_query($conn, "UPDATE fv_naglowek SET kurs_euro = ".$kurs_euro." WHERE id = ".$fv_id_wiecej_pozycji[$m].";");
				$pytanie133 = mysqli_query($conn, "UPDATE fv_naglowek SET waluta = 'EUR' WHERE id = ".$fv_id_wiecej_pozycji[$m].";");

				$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$fv_id_wiecej_pozycji[$m].";");
				while($wynik2= mysqli_fetch_assoc($pytanie2))
					{
					$zamowienie_id2=$wynik2['zamowienie_id'];		
					$numer_fv=$wynik2['nr_dok'];
					$link_faktura=$wynik2['nazwa_pliku'];
					$link_folder = $wynik2['link_folder'];
					$typ_dok=$wynik2['typ_dok'];
					$waluta_dokumentu=$wynik2['waluta'];
					$duplikat_do_faktury=$wynik2['duplikat_do_faktury'];
					}
				//wpisujemy kurs euro do faktur i generujemy plik
				$fv_id = $fv_id_wiecej_pozycji[$m];
				include('php/generuj_fakture.php');
				
				echo '<table border="0" width="70%" class="text" align="center"><tr valign="middle" width="100%">';
				echo '<td class="text_duzy_niebieski" align="center" width="100%"><font color="red">ZMIANA WALUTY </font>- Wydrukuj nowo wygenerowaną fakturę '.$nr_fv_oryginalny.'</td></tr>';
				// adres_serwera_do_faktur zapisane jest w connection.php
				echo '<tr valign="middle" width="100%"><td align="center" width="100%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$nazwa_pliku.'" target="_blank"><img src="images/pdf_icon.png" border="0" title="Pokaż" alt="Pokaż"></a></td></tr>';
				echo '</table><br>';
				}				
				
			}
		elseif(($kurs_euro == 0) && ($kurs_euro == '') && ($stary_kurs_euro != 0) && ($stary_kurs_euro != ''))
			{
			//echo 'byl kurs euro, ale zostal usuniety<br>';
			//spr nr fv
			$ilosc_nr_fv = 0;
			$pytanie323 = mysqli_query($conn, "SELECT DISTINCT nr_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND typ_dok = 'Faktura';");
			while($wynik323= mysqli_fetch_assoc($pytanie323))
				{
				$ilosc_nr_fv++;
				$nr_fv_z_wyceny[$ilosc_nr_fv]=$wynik323['nr_faktury'];
				}
			
			// przetwarzanie pdf faktur
			for($m = 1; $m<=$ilosc_nr_fv; $m++)
				{
				$pytanie1323 = mysqli_query($conn, "SELECT id FROM fv_naglowek WHERE nr_dok = '".$nr_fv_z_wyceny[$m]."' AND typ_dok = 'Faktura';");
				while($wynik1323= mysqli_fetch_assoc($pytanie1323))
					{
					$fv_id_wiecej_pozycji[$m]=$wynik1323['id'];
					}
				$pytanie133 = mysqli_query($conn, "UPDATE fv_naglowek SET kurs_euro = NULL WHERE id = ".$fv_id_wiecej_pozycji[$m].";");
				$pytanie133 = mysqli_query($conn, "UPDATE fv_naglowek SET waluta = 'PLN' WHERE id = ".$fv_id_wiecej_pozycji[$m].";");

				$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE id = ".$fv_id_wiecej_pozycji[$m].";");
				while($wynik2= mysqli_fetch_assoc($pytanie2))
					{
					$zamowienie_id2=$wynik2['zamowienie_id'];		
					$numer_fv=$wynik2['nr_dok'];
					$link_faktura=$wynik2['nazwa_pliku'];
					$link_folder = $wynik2['link_folder'];
					$typ_dok=$wynik2['typ_dok'];
					$waluta_dokumentu=$wynik2['waluta'];
					$duplikat_do_faktury=$wynik2['duplikat_do_faktury'];
					}
				//wpisujemy kurs euro do faktur i generujemy plik
				$fv_id = $fv_id_wiecej_pozycji[$m];
				include('php/generuj_fakture.php');
				
				echo '<table border="0" width="70%" class="text" align="center"><tr valign="middle" width="100%">';
				echo '<td class="text_duzy_niebieski" align="center" width="100%"><font color="red">ZMIANA WALUTY </font>- Wydrukuj nowo wygenerowaną fakturę '.$nr_fv_oryginalny.'</td></tr>';
				// adres_serwera_do_faktur zapisane jest w connection.php
				echo '<tr valign="middle" width="100%"><td align="center" width="100%"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$nazwa_pliku.'" target="_blank"><img src="images/pdf_icon.png" border="0" title="Pokaż" alt="Pokaż"></a></td></tr>';
				echo '</table><br>';
				}				
			}
		// #########################################################################################################################################################################################

			
		// dodajemy status do wyceny
		if($status != '') 
			{
			$pytanie450 = mysqli_query($conn, "UPDATE wyceny SET status = '".$status."' WHERE zamowienie_id = ".$zamowienie_id.";");
			$pytanie132 = mysqli_query($conn, "UPDATE zamowienia SET status = '".$status."' WHERE id = ".$zamowienie_id.";");
			}


		if(($status == 'Dostarczone') || ($status == 'Odebrane'))
			{
			if($zamowienie_id >= 1867) 
				{
				$brak = 0;
				$pytanie33 = mysqli_query($conn, "SELECT nr_faktury, data_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id.";");
				while($wynik33= mysqli_fetch_assoc($pytanie33))
					{
					$nr_faktury=$wynik33['nr_faktury'];
					$data_faktury=$wynik33['data_faktury'];
					if($nr_faktury == '') $brak++;
					if($data_faktury == '') $brak++;
					}
				if($brak != 0) echo '<div align="center" class="text_duzy_czerwony"><br>Zamówienie NIE zostało zamknięte. Brak numeru faktury lub daty faktury w pozycji wyceny.</div>';
				else 
					{
					$pytanie132 = mysqli_query($conn, "UPDATE zamowienia SET status = '".$status."' WHERE id = ".$zamowienie_id.";");
					$pytanie450 = mysqli_query($conn, "UPDATE wyceny SET status = '".$status."' WHERE zamowienie_id = ".$zamowienie_id.";");
					}
				}
			else 
				{
				$pytanie132 = mysqli_query($conn, "UPDATE zamowienia SET status = '".$status."' WHERE id = ".$zamowienie_id.";");
				$pytanie450 = mysqli_query($conn, "UPDATE wyceny SET status = '".$status."' WHERE zamowienie_id = ".$zamowienie_id.";");
				}
			} // do if(($status == 'Dostarczone') || ($status == 'Odebrane'))
		}
	return $nr_zamowienia;
	}

// ########## czy user o takiej nazwie juz istnieje ##########
function uzytkownik_istnieje($conn, $nazwa, $id)
	{
	//jak id jst 0 to dodajemy nowego usera, jak ma wartosc to zmieniamy nazwe do istniejacego usera
	if($id == 0) $sql = "SELECT nazwa FROM uzytkownicy;";
	else $sql = "SELECT nazwa FROM uzytkownicy WHERE id <> ".$id.";";

	$pytanie = mysqli_query($conn, $sql);
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		if($wynik['nazwa'] == $nazwa) return True;
		}
	return False;
	}

// ########## czy klient o takiej nazwie juz istnieje   ##########
function klient_nazwa_exists($conn, $nazwa)
	{
	$pytanie = mysqli_query($conn, "SELECT nazwa FROM klienci;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		if($wynik['nazwa'] == $nazwa) return True;
	return False;
	}

// ########## sprawdza poprawnosc adresu email ##########
function spr_email($adres)
	{
	return filter_var($adres, FILTER_VALIDATE_EMAIL);
	}

// ######### zamiana przecinek na kropke ##########
function change($wartosc)
	{
	if($wartosc == '') $wartosc = 0;
	$patterns = array();
	$patterns[0] = '/,/';

	$replacements = array();
	$replacements[0] = '.';
	$wartosc = preg_replace($patterns, $replacements, $wartosc);
	$wartosc = number_format($wartosc, 2,'.','');
	return $wartosc;
	} 

// #############################  formatuje wyświetlanie wartości ze SPACJĄ co 3 miejsce ###############################################
function formatuj_wartosc_spacja($wart) {
	return $wart = number_format($wart, 2,'.',' ');
}
// #############################  formatuje wyświetlanie wartości BEZ SPACJĄ co 3 miejsce ###############################################
function formatuj_wartosc_bez_spacji($wart) {
	return $wart = number_format($wart, 2,'.','');
}
// #############################  wyświetla typ podanej zmiennej ###############################################
function typ_zmiennej($wart) {
	return '<font size="+1" color="green"><b>Typ zmiennej to : '.gettype($wart).'</b></font><br>';
}
// ######## usuwa podwojna ulice z adresu klienta  ##########
function popraw_ulice($klient_ulica)
	{
	$patterns = array( '/ul. /', '/UL. /', '/Ul. /', '/ul./', '/UL./', '/Ul./', '/ul./', '/UL./', '/Ul./', '/ul/', '/UL/', '/Ul/');
	$replacements = array('');
	$klient_ulica = preg_replace($patterns, $replacements, $klient_ulica);
	return $klient_ulica;
	} 

// ######### zamiana jeden znak na inny  ##########
function zamien_dowolne_znaki($string, $szukaj, $zamien_na)
	{
	$patterns = array('/'.$szukaj.'/');
	$replacements = array($zamien_na);
	$string = preg_replace($patterns, $replacements, $string);
	return $string;
	} 

// ######### zamiana / na _    ########## 
function change_link($wartosc)
	{
	$patterns = array('/\//');
	$replacements = array('_');
	$wartosc = preg_replace($patterns, $replacements, $wartosc);
	return $wartosc;
	} 

// ########################### wstawia spacje co 3 miejsca   #################################
function kwota($cena)
	{
	$patterns = array();
	$patterns[0] = '/,/';

	$replacements = array();
	$replacements[0] = '.';
	$cena = preg_replace($patterns, $replacements, $cena);
	$cena = number_format($cena, 2,'.',' ');
	return $cena;
	} 

// ############################################### generator haseł #################################
function generate_password($length = 5, $numbers = true, $lower_case = true, $upper_letters = true)
	{
	$random_symbols = '';
	$letters = 'abcdefghijklmnopqrstuvwxyz';

	// Numbers
	if($numbers) $values = '0123456789';

	// Lower case
	if($lower_case) $values .= $letters;

	// Upper letters
	if($upper_letters) $values .= strtoupper($letters);

	$length_values = strlen($values) - 1;

	if($length_values > 0)
	{
	for($h = 0; $h < $length; ++$h)
		$random_symbols .= substr($values, mt_rand(0, $length_values), 1);

	return $random_symbols;
	}
	}

// ############################################### generator kluczy dla klientow  #################################
function generate_key($length = 20, $numbers = true, $lower_case = true, $upper_letters = true)
	{
	$letters = 'abcdefghijklmnopqrstuvwxyz';
	$random_symbols = '';
	// Numbers
	if($numbers) $values = '0123456789';

	// Lower case
	if($lower_case) $values .= $letters;

	// Upper letters
	if($upper_letters) $values .= strtoupper($letters);

	$length_values = strlen($values) - 1;

	if($length_values > 0)
		{
		for($h = 0; $h < $length; ++$h) 
			$random_symbols .= substr($values, mt_rand(0, $length_values), 1);

		return $random_symbols;
		}
	}

// ################################ zamiana kwoty na slowa  ######################## 
if(!function_exists('str_split')){
	function str_split($string,$len = 1) {
			if ($len < 1) return false;
		for($i=0, $rt = Array();$i<ceil(strlen($string)/$len);$i++)
		$rt[$i] = substr($string, $len*$i, $len);
		return($rt);
	}
	}

	$slowa = Array(
	'minus',

	Array(
		'zero',
		'jeden',
		'dwa',
		'trzy',
		'cztery',
		'pięć',
		'sześć',
		'siedem',
		'osiem',
		'dziewięć'),

	Array(
		'dziesięć',
		'jedenaście',
		'dwanaście',
		'trzynaście',
		'czternaście',
		'pietnaście',
		'szesnaście',
		'siedemnaście',
		'osiemnaście',
		'dziewietnaście'),

	Array(
		'dziesięć',
		'dwadzieścia',
		'trzydzieści',
		'czterdzieści',
		'pięćdziesiąt',
		'sześćdziesiąt',
		'siedemdziesiąt',
		'osiemdziesiąt',
		'dziewięćdziesiąt'),

	Array(
		'sto',
		'dwieście',
		'trzysta',
		'czterysta',
		'pięćset',
		'sześćset',
		'siedemset',
		'osiemset',
		'dzięwiećset'),

	Array(
		'tysiąc',
		'tysiące',
		'tysięcy'),

	Array(
		'milion',
		'miliony',
		'milionów'),

	Array(
		'miliard',
		'miliardy',
		'miliardów')
	);

	function odmiana($odmiany, $int){ // $odmiany = Array('jeden','dwa','piec')
	$txt = $odmiany[2];
	if ($int == 1) $txt = $odmiany[0];
	$jednosci = (int) substr($int,-1);
	$reszta = $int % 100;
	if (($jednosci > 1 && $jednosci < 5) &! ($reszta > 10 && $reszta < 20))
		$txt = $odmiany[1];
	return $txt;
	}

	function liczba($int){ // odmiana dla liczb < 1000
	global $slowa;
	$wynik = '';
	$j = abs((int) $int);

	if ($j == 0) return $slowa[1][0];
	$jednosci = $j % 10;
	$dziesiatki = ($j % 100 - $jednosci) / 10;
	$setki = ($j - $dziesiatki*10 - $jednosci) / 100;

	if ($setki > 0) $wynik .= $slowa[4][$setki-1].' ';

	if ($dziesiatki > 0)
			if ($dziesiatki == 1) $wynik .= $slowa[2][$jednosci].' ';
	else
		$wynik .= $slowa[3][$dziesiatki-1].' ';

	if ($jednosci > 0 && $dziesiatki != 1) $wynik .= $slowa[1][$jednosci].' ';
	return $wynik;
	}

	function slownie($int){

	global $slowa;

	$in = preg_replace('/[^-\d]+/','',$int);
	$out = '';

	if ($in[0] == '-'){
		$in = substr($in, 1);
		$out = $slowa[0].' ';
	}

	$txt = str_split(strrev($in), 3);

	if ($in == 0) $out = $slowa[1][0].' ';

	for ($i = count($txt) - 1; $i >= 0; $i--){
		$liczba = (int) strrev($txt[$i]);
		if ($liczba > 0)
		if ($i == 0)
			$out .= liczba($liczba).' ';
			else
			$out .= ($liczba > 1 ? liczba($liczba).' ' : '')
			.odmiana( $slowa[4 + $i], $liczba).' ';
	}
	return trim($out);
	}


	function kwotaslownie($kwota){
	$kwota = change($kwota);
	$kwota = explode('.', $kwota);

	$zl = preg_replace('/[^-\d]+/','', $kwota[0]);
	$gr = preg_replace('/[^\d]+/','', substr(isset($kwota[1]) ? $kwota[1] : 0, 0, 2));
	while(strlen($gr) < 2) $gr .= '0';

	return slownie($zl) . ' ' . odmiana(Array('złoty', 'złote', 'złotych'), $zl) .
		(intval($gr) == 0 ? '' :
		' ' . slownie($gr) . ' ' . odmiana(Array('grosz', 'grosze', 'groszy'), $gr));
	}

	function kwotaslownieeuro($kwota){
	$kwota = change($kwota);
	$kwota = explode('.', $kwota);

	$zl = preg_replace('/[^-\d]+/','', $kwota[0]);
	$gr = preg_replace('/[^\d]+/','', substr(isset($kwota[1]) ? $kwota[1] : 0, 0, 2));
	while(strlen($gr) < 2) $gr .= '0';

	return slownie($zl) . ' ' . odmiana(Array('EUR', 'EUR', 'EUR'), $zl) .
		(intval($gr) == 0 ? '' :
		' ' . $gr . '/100 ' . odmiana(Array('', '', ''), $gr));	 
		
		
}
?>