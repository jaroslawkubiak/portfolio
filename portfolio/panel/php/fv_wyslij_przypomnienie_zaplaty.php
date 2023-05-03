<html>
	<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
	<META HTTP-EQUIV="Content-Language" CONTENT="pl">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="shortcut icon" href="images/arcus-logo.jpg">
	<link rel="bookmark icon" href="images/arcus-logo.jpg">
		<style type="text/css">@import url(cal/skins/aqua/theme.css);</style>
		<script type="text/javascript" src="cal/calendar.js"></script>
		<script type="text/javascript" src="cal/lang/calendar-en.js"></script>
		<script type="text/javascript" src="cal/calendar-setup.js"></script>	
		<script type="text/javascript" src="php/java/okienka.js"></script>
		<script type="text/javascript" src="php/java/wyceny.js"></script>	
		<script type="text/javascript" src="php/java/wycena_wstepna.js"></script>	
		<script type="text/javascript" src="php/java/sinus.js"></script>	
		<script type="text/javascript" src="php/java/dlugosc_luku.js"></script>
	<title>Arcus - panel</title>
	<style type="text/css">
	body 
		{
		background-image:url(images/tlo.jpg);
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position:center top;
		}
	</style>
	</head>
<body>
<?php


$fv_id = isset($_REQUEST['fv_id']) ? $_REQUEST['fv_id'] : '';
$klient_wyslij_fv = isset($_REQUEST['klient_wyslij_fv']) ? $_REQUEST['klient_wyslij_fv'] : '';
$ktora_fv = isset($_REQUEST['ktora_fv']) ? $_REQUEST['ktora_fv'] : '';
$button = isset($_REQUEST['button']) ? $_REQUEST['button'] : '';
$klient_przypomnienie = isset($_REQUEST['klient_przypomnienie']) ? $_REQUEST['klient_przypomnienie'] : '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';

include ("../php/_connection.php");
include ("../php/_variables.php");
include ("../php/_functions.php");
include ("../style.css");


$pytanie = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$przypomnienie_email_tytul=$wynik['przypomnienie_email_tytul'];
	$przypomnienie_email_nadawca=$wynik['przypomnienie_email_nadawca'];
	$przypomnienie_email_tresc=$wynik['przypomnienie_email_tresc'];
	}
	
$pytanie12 = mysqli_query($conn, "SELECT nabywca_id FROM fv_naglowek WHERE id = ".$fv_id.";");
while($wynik12= mysqli_fetch_assoc($pytanie12))
	{
	$nabywca_id=$wynik12['nabywca_id'];
	}	
	
//szukamy wszystkich niezaplaconych faktur	
$ilosc_zaleglych = 0;
$pytanie2 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE (typ_dok = 'Faktura' OR typ_dok = 'Korekta') AND zaplacona = 'nie' AND termin_platnosci < '".$time."' AND nabywca_id =".$nabywca_id.";");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	
	$typ_dok=$wynik2['typ_dok'];
	$czy_fv_ma_korekte=$wynik2['tytul_korekty'];
	
	if((($typ_dok == 'Faktura') && ($czy_fv_ma_korekte == '')) || ($typ_dok == 'Korekta'))
		{
		$ilosc_zaleglych++;
		$nr_fv[$ilosc_zaleglych]=$wynik2['nr_dok'];
		$typ_dok_baza[$ilosc_zaleglych]=$wynik2['typ_dok'];
		$link_faktura[$ilosc_zaleglych]=$wynik2['nazwa_pliku'];
		$link_folder[$ilosc_zaleglych]=$wynik2['link_folder'];
		$termin_platnosci[$ilosc_zaleglych]=$wynik2['termin_platnosci'];
		$termin_platnosci[$ilosc_zaleglych] = date('d-m-Y', $termin_platnosci[$ilosc_zaleglych]);
		$data_wystawienia[$ilosc_zaleglych]=$wynik2['data_wystawienia'];
		$wartosc_brutto_fv[$ilosc_zaleglych]=$wynik2['wartosc_brutto_fv'];
		$wplacono[$ilosc_zaleglych]=$wynik2['wplacono'];
		$do_zaplaty[$ilosc_zaleglych] = $wartosc_brutto_fv[$ilosc_zaleglych] - $wplacono[$ilosc_zaleglych];
		$do_zaplaty[$ilosc_zaleglych] = number_format($do_zaplaty[$ilosc_zaleglych], 2,'.',' ');
		}
	}
	
	
include ("../php/lista_emaili_windykacja.php");

//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
if($adres_ip == '127.0.0.1') $klient_przypomnienie = $lokalny_adres_email;

	
if($button == 'Wyślij')
	{
	// wysylka fv na email
	$przypomnienie_email_tytul2 = $przypomnienie_email_tytul;
	// $przypomnienie_email_tytul2 = "=?UTF-8?B?".base64_encode($przypomnienie_email_tytul2)."?=";
	$tresc_maila = '<html><head>';
	$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
	$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
	$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
	$tresc_maila .= '<div align="left">';
	$tresc_maila .= $przypomnienie_email_tresc;
	
	$tresc_maila .= '<br><br>Lista niezapłaconych faktur:<br><br>';
	for($x=1; $x<=$ilosc_zaleglych; $x++)
		{
		if($typ_dok_baza[$x] == 'Faktura') $napis_nazwa_dokumentu = 'Faktura'; else  $napis_nazwa_dokumentu = 'Korekta';

		$tresc_maila .= $napis_nazwa_dokumentu.' <b>'.$nr_fv[$x].'</b> z dnia <b>'.$data_wystawienia[$x].'</b>, termin płatności <b>'.$termin_platnosci[$x].'</b>, do zapłaty <b>'.$do_zaplaty[$x].'</b> PLN<br>';
		}
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
	$mail->From = $przypomnienie_email_nadawca;
	$mail->AddAddress($klient_przypomnienie);
	$mail->AddReplyTo($przypomnienie_email_nadawca,"Arcus");
	$mail->Subject = $przypomnienie_email_tytul2;
	$mail->IsHTML(true);
	$mail->Body = $tresc_maila;
	$mail->setLanguage('pl');
		
	//dodajemy pliki z zaległymi fakturami do załącznika
	for($x=1; $x<=$ilosc_zaleglych; $x++)
		{
		$sciezka[$x] = '../../panel_dane/'.$link_folder[$x].'/'.$link_faktura[$x];
		$mail->AddAttachment($sciezka[$x], $link_faktura[$x]);
		}
			

	if(!$mail->Send()) 
		{
		$error_info = $mail->ErrorInfo;
		$strona = 'fv_wyslij_przypomnienie_zaplaty.php';
		$klient_id_faktury = 'klient id='.$nabywca_id;
		//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
		show_mail_send_error_info($error_info, $strona, $klient_id_faktury, $klient_przypomnienie);
		} 	
		else 
		{
		echo '<div align="center" class="text_duzy_zielony"><br>Informacja została wysłana na adres : '.$klient_przypomnienie.'</div>';	
		$pytanie13 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_windykacja = '".$klient_przypomnienie."' WHERE id = ".$nabywca_id.";");
		}
	
	}
else
	{
	echo '<FORM action="fv_wyslij_przypomnienie_zaplaty.php?fv_id='.$fv_id.'" method="post">';
	//echo '<input type="text" name="id_fv_do_wplaty" value="'.$fv_id.'">';
		
	echo '<body background="../images/tlo_male.jpg">';
	
	echo '<INPUT type="hidden" name="nabywca_id" value="'.$nabywca_id.'">';
	
	echo '<table width="100%" align="center" border="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr class="text_duzy"><td width="100%" align="center" bgcolor="#e24139" colspan="2">Wyślij przypomnienie zapłaty.</td><tr>';
	echo '<tr class="text" height="30px"><td width="15%" align="right" bgcolor="#e24139">Temat :&nbsp;&nbsp;</td><td width="85%" align="left" bgcolor="white">&nbsp;&nbsp;'.$przypomnienie_email_tytul.'</td><tr>';
	echo '<tr class="text" height="30px"><td align="right" bgcolor="#e24139">Nadawca :&nbsp;&nbsp;</td><td align="left" bgcolor="white">&nbsp;&nbsp;'.$przypomnienie_email_nadawca.'</td><tr>';
	echo '<tr class="text" height="30px"><td align="right" bgcolor="#e24139">Adresat :&nbsp;&nbsp;</td><td align="left" bgcolor="white">&nbsp;&nbsp;';
		echo '<select name="klient_przypomnienie" class="pole_input_biale" style="width: 200px" >';
		for ($k=1; $k<=$ilosc_email; $k++) 
		if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		elseif($linia_rozdzielajaca == $klient_email[$k]) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
		else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		echo '</select>';
	echo '</td><tr>';
	if($ilosc_zaleglych == 1) $napis_zalaczniki = 'Załącznik'; else $napis_zalaczniki = 'Załączniki';
	echo '<tr class="text" height="30px"><td align="right" bgcolor="#e24139">'.$napis_zalaczniki.' :&nbsp;&nbsp;</td><td align="left" bgcolor="white" valign="middle">';
		echo '<table width="100%" align="left" border="0" class="text" cellpadding="0" cellspacing="0">';
		for($x=1; $x<=$ilosc_zaleglych; $x++)
			{
			if($typ_dok_baza[$x] == 'Faktura') $napis_nazwa_dokumentu[$x] = 'Faktura'; else  $napis_nazwa_dokumentu[$x] = 'Korekta';
			
			echo '<tr valign="middle"><td width="120px" align="left">&nbsp;&nbsp;<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder[$x].'/'.$link_faktura[$x].'" target="_blank"><font color="black">'.$napis_nazwa_dokumentu[$x].' '.$nr_fv[$x].'</font></a></td>';
			echo '<td align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder[$x].'/'.$link_faktura[$x].'" target="_blank">'.$image_pdf_mini.'</a></td></tr>';
			}
		
		echo '</table>';
	echo '</td><tr>';

		$przypomnienie_email_tresc .= '<br><br>Lista niezapłaconych faktur:<br><br>';
		for($x=1; $x<=$ilosc_zaleglych; $x++)
			{
			
			$przypomnienie_email_tresc .= $napis_nazwa_dokumentu[$x].' '.$nr_fv[$x].' z dnia '.$data_wystawienia[$x].', termin płatności '.$termin_platnosci[$x].', do zapłaty '.$do_zaplaty[$x].' PLN<br>';
			}

	echo '<tr class="text"><td align="right" bgcolor="#e24139">Treść :&nbsp;</td><td align="left" bgcolor="white" height="150px" valign="top">';
		echo '<table width="100%" align="left" border="0" class="text" cellpadding="4"><tr valign="middle"><td align="left">';
		echo $przypomnienie_email_tresc;
		echo '</td></tr></table>';
		
	echo '</td><tr>';
	if($ilosc_email != 1) echo '<tr class="text"><td width="100%" align="center" bgcolor="#e24139" colspan="2"><input type="submit" value="Wyślij" name="button"></td><tr>';
	else echo '<tr class="text_duzy_czerwony"><td width="100%" align="center" bgcolor="black" colspan="2">BRAK ADRESU E-MAIL NABYWCY!</td><tr>';
	if(($user_id == 1) && ($adres_ip == '127.0.0.1')) echo '<tr class="text" bgcolor="#ff41f9" align="center"><td colspan="2">Działamy lokalnie. Faktycznie wysyłka nastąpi na : '.$klient_przypomnienie.'</td><tr>';

	echo '</form>';
	echo '</table>';
	echo '</body>';
	}

?>
</body>
</html>