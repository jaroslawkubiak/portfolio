<!DOCTYPE HTML>
<html lang="pl">
<html>
	<head>
	<meta http-equiv = "Content-Type" content = "text/html">
	<meta charset = "UTF-8" />
	<meta name="Author" content="Arcus" />
	<meta name="Language" content="pl" />
	<meta http-equiv="Content-Type" content="text/html" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<META HTTP-EQUIV="Content-Language" CONTENT="pl" />

	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="shortcut icon" href="images/arcus-logo.jpg">
	<link rel="bookmark icon" href="images/arcus-logo.jpg">
		<style type="text/css">@import url(cal/skins/aqua/theme.css);</style>
		<script type="text/javascript" src="php/java/okienka.js"></script>
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

$klient_id = isset($_REQUEST['klient_id']) ? $_REQUEST['klient_id'] : '';
$klient_email = isset($_REQUEST['klient_email']) ? $_REQUEST['klient_email'] : '';
$zamowienie_id = isset($_REQUEST['zamowienie_id']) ? $_REQUEST['zamowienie_id'] : '';
$button = isset($_REQUEST['button']) ? $_REQUEST['button'] : '';

include ("../php/_connection.php");
include ("../php/_variables.php");
include ("../php/_functions.php");
include ("../style.css");

	
if($button == 'Wyślij')
	{
	// wysyłka fv na email
	$pytanie = mysqli_query($conn, "SELECT * FROM ustawienia_zlecenia_transportowe;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$tytul=$wynik['tytul'];
		$opis=$wynik['opis'];
		}
	
	$przypomnienie_email_tytul2 = $tytul;
	$przypomnienie_email_tytul2 = "=?UTF-8?B?".base64_encode($przypomnienie_email_tytul2)."?=";
	$tresc_maila = '<html><head>';
	$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
	$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
	$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
	$tresc_maila .= '<div align="left">';
	$tresc_maila .= $opis;
	
	$tresc_maila .= '</div></html>';
	
	
	require('pdf/phpmailer/class.phpmailer.php');
	require('pdf/phpmailer/class.smtp.php');

	$toaddress = $klient_email;
	//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
	if($adres_ip == '127.0.0.1') $toaddress = $lokalny_adres_email;

	
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->FromName = 'ARCUS | Biuro';
	$mail->From = 'biuro@arcus-luki.pl';
	$mail->AddAddress($toaddress);
	$mail->AddReplyTo('biuro@arcus-luki.pl',"Arcus");
	$mail->Subject = $przypomnienie_email_tytul2;
	$mail->IsHTML(true);
	$mail->Body = $tresc_maila;
	
			
	if(!$mail->Send()) 
		{
			$error_info = $mail->ErrorInfo;
			// show_mail_send_error_info($error_info);
		} 	
		else 
		{
			echo '<div align="center" class="text_duzy_zielony"><br>Informacja została wysłana na adres : '.$klient_email.'</div>';	
			$pytanie13 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_info_zlecenia_transportowe = '".$klient_email."' WHERE id = ".$klient_id.";");
		}
	
	}		
else
	{
	$klient=$klient_id;
	$klient_email = [];
	include ("../php/lista_emaili_info_zlecenie_transportowe.php");
	
	$pytanie = mysqli_query($conn, "SELECT * FROM ustawienia_zlecenia_transportowe;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$tytul=$wynik['tytul'];
		$opis=$wynik['opis'];
		$szerokosc=$wynik['szerokosc'];
		}
	
	echo '<FORM action="zlecenie_transportowe_info_okienko.php?klient_id='.$klient_id.'" method="POST">';
	
	echo '<body background="../images/tlo_male.jpg">';
	
	echo '<table width="100%" align="center" border="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr class="text_duzy"><td width="100%" align="center" bgcolor="#e24139" colspan="2">Informacja - zlecenie transportowe</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Temat :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;'.$tytul.'</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Nadawca :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;biuro@arcus-luki.pl</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Adresat :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;';
		echo '<select name="klient_email" class="pole_input_biale" style="width: 200px" >';
		for ($k=1; $k<=$ilosc_email; $k++) 
		if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		elseif($linia_rozdzielajaca == $klient_email[$k]) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
		else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		echo '</select>';
	echo '</td><tr>';
	
	
	echo '<tr class="text"><td width="30%" align="right" bgcolor="#e24139">Treść :&nbsp;</td><td width="70%" align="left" bgcolor="white" height="150px" valign="top">';
		echo '<table width="100%" align="left" border="0" class="text" cellpadding="4"><tr valign="middle"><td align="left">';
		echo $opis.'<br>';
		echo '<img src="http://arcus-luki.nazwa.pl/panel_dane/foto.jpg" border="0" width="'.$szerokosc.'">';
		
		echo '</td></tr></table>';
	echo '</td><tr>';
	if($ilosc_email != 1) echo '<tr class="text"><td width="100%" align="center" bgcolor="#e24139" colspan="2"><input type="submit" value="Wyślij" name="button"></td><tr>';
	else echo '<tr class="text_duzy_czerwony"><td width="100%" align="center" bgcolor="black" colspan="2">BRAK ADRESU E-MAIL NABYWCY!</td><tr>';
	
	echo '</form>';
	echo '</table>';
	echo '</body>';
	}
?>
</body>
</html>
