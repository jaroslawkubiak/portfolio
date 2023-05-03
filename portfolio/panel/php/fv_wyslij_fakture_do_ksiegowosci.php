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
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';

include ("../php/_connection.php");
include ("../php/_variables.php");
include ("../php/_functions.php");
include ("../style.css");

$sql ="SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";";
$pytanie2 = mysqli_query($conn, $sql);
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$nr_fv=$wynik2['nr_dok'];
	$link_faktura=$wynik2['nazwa_pliku'];
	$link_folder=$wynik2['link_folder'];
	$nabywca_id=$wynik2['nabywca_id'];
	$typ_dok_baza=$wynik2['typ_dok'];
	$faktura_euro=$wynik2['faktura_euro'];  //jezeli bedzie TAK to bedzie mozna drukowac te fv
	}

$pytanie = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$wysylka_fv_email_nadawca=$wynik['wysylka_fv_email_nadawca'];
	$wysylka_fv_ksiegowosc_tytul=$wynik['wysylka_fv_ksiegowosc_tytul'];
	$wysylka_fv_ksiegowosc_adresat=$wynik['wysylka_fv_ksiegowosc_adresat'];
	$wysylka_fv_ksiegowosc_tresc=$wynik['wysylka_fv_ksiegowosc_tresc'];
	}



//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
if($adres_ip == '127.0.0.1') $wysylka_fv_ksiegowosc_adresat = $lokalny_adres_email;

	
if($button == 'Wyślij')
	{
	if($ktora_fv == 'EURO') $link_folder = 'faktury_euro';
	// wysyłka fv na email
	$sciezka = '../../panel_dane/'.$link_folder.'/'.$link_faktura;
	
	//usuwanie polskich znakow z tresci:
	$wysylka_fv_ksiegowosc_tresc = usun_polskie($wysylka_fv_ksiegowosc_tresc);

	
	$wysylka_fv_email_tytul2 = $wysylka_fv_ksiegowosc_tytul.' : '.$nr_fv;
	// $wysylka_fv_email_tytul2 = "=?UTF-8?B?".base64_encode($wysylka_fv_email_tytul2)."?=";
	$tresc_maila = '<html><head>';
	$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
	$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
	$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
	$tresc_maila .= '<div align="left">';
	$tresc_maila .= $wysylka_fv_ksiegowosc_tresc;
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
	$mail->AddAddress($wysylka_fv_ksiegowosc_adresat);
	$mail->AddReplyTo($wysylka_fv_email_nadawca,"Arcus");
	$mail->Subject = $wysylka_fv_email_tytul2;
	$mail->IsHTML(true);
	$mail->Body = $tresc_maila;
	$mail->AddAttachment($sciezka, $link_faktura);
	$mail->setLanguage('pl');
	
	if(!$mail->Send()) 
		{
		$error_info = $mail->ErrorInfo;
		$strona = 'fv_wyslij_fakture_do_ksiegowosci.php';
		$klient_id_faktury = 'klient id='.$nabywca_id;
		//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
		show_mail_send_error_info($error_info, $strona, $klient_id_faktury, $wysylka_fv_ksiegowosc_adresat);
		} 	
	else echo '<div align="center" class="text_duzy_zielony"><br>Faktura została wysłana na adres : '.$wysylka_fv_ksiegowosc_adresat.'</div>';	
	}		
else
	{
	echo '<FORM action="fv_wyslij_fakture_do_ksiegowosci.php?fv_id='.$fv_id.'&user_id='.$user_id.'" method="POST">';
	//echo '<input type="text" name="id_fv_do_wplaty" value="'.$fv_id.'">';
	echo '<input type="hidden" name="wysylka_fv_ksiegowosc_adresat" value="'.$wysylka_fv_ksiegowosc_adresat.'">';
	
	if($typ_dok_baza == 'Faktura') $napis_nazwa_dokumentu = 'Faktura'; 
	if($typ_dok_baza == 'Korekta') $napis_nazwa_dokumentu = 'Korekta';
	if($typ_dok_baza == 'Proforma') $napis_nazwa_dokumentu = 'Proforma';
	if($typ_dok_baza == 'Duplikat') $napis_nazwa_dokumentu = 'Duplikat';
	
	echo '<body background="../images/tlo_male.jpg">';
	
	echo '<table width="100%" align="center" border="0" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr class="text_duzy"><td width="100%" align="center" bgcolor="#e24139" colspan="2">'.$napis_wyslij_fv_przez_email.'</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Temat :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;'.$wysylka_fv_ksiegowosc_tytul.' : '.$nr_fv.'</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Nadawca :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;'.$wysylka_fv_email_nadawca.'</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Adresat :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;';
	echo $wysylka_fv_ksiegowosc_adresat;
	echo '</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Załącznik :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white" valign="middle">';

	
		echo '<table width="100%" align="left" border="0" class="text" cellpadding="0" cellspacing="0"><tr valign="middle">';
		if($faktura_euro == 'TAK') echo '<td width="20px"><input type="radio" name="ktora_fv" value="PLN" checked></td>';
		echo '<td width="120px" align="left">&nbsp;&nbsp;<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$link_faktura.'" target="_blank"><font color="black">'.$napis_nazwa_dokumentu.' '.$nr_fv.'</font></a></td>';
		echo '<td align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder.'/'.$link_faktura.'" target="_blank">'.$image_pdf_mini.'</a></td></tr>';
		
		if($faktura_euro == 'TAK') 
			{
			echo '<td width="20px"><input type="radio" name="ktora_fv" value="EURO"></td>';
			echo '<td width="180px" align="left">&nbsp;&nbsp;<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_euro/'.$link_faktura.'" target="_blank"><font color="black">'.$napis_nazwa_dokumentu.' EURO '.$nr_fv.'</font></a></td>';
			echo '<td align="left"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury_euro/'.$link_faktura.'" target="_blank">'.$image_pdf_mini.'</a></td></tr>';	
			}		
		echo '</table>';
	
	echo '</td><tr>';
	
	
	echo '<tr class="text"><td width="30%" align="right" bgcolor="#e24139">Treść :&nbsp;</td><td width="70%" align="left" bgcolor="white" height="150px" valign="top">';
		echo '<table width="100%" align="left" border="0" class="text" cellpadding="4"><tr valign="middle"><td align="left">';
		echo $wysylka_fv_ksiegowosc_tresc;
		echo '</td></tr></table>';
	echo '</td><tr>';
	
	if($wysylka_fv_ksiegowosc_adresat != '') echo '<tr class="text"><td width="100%" align="center" bgcolor="#e24139" colspan="2"><input type="submit" value="Wyślij" name="button"></td><tr>';
	else echo '<tr class="text_duzy_czerwony"><td width="100%" align="center" bgcolor="black" colspan="2">BRAK ADRESU E-MAIL KSIĘGOWOŚCI!</td><tr>';
	if(($user_id == 1) && ($adres_ip == '127.0.0.1')) echo '<tr class="text" bgcolor="#ff41f9" align="center"><td colspan="2">Działamy lokalnie. Faktycznie wysyłka nastąpi na : '.$wysylka_fv_ksiegowosc_adresat.'</td><tr>';
	echo '</form>';
	echo '</table>';
	echo '</body>';
	}

?>
</body>
</html>