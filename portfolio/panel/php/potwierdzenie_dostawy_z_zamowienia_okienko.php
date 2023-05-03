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
$id = $_REQUEST['id'];
$klient_id = $_REQUEST['klient_id'];
$klient_email = $_REQUEST['klient_email'];
$zamowienie_id = $_REQUEST['zamowienie_id'];

//include ("../php/session.php");
include ("../php/_connection.php");
include ("../php/_variables.php");
include ("../php/_functions.php");
include ("../style.css");


$button = isset($_REQUEST['button']) ? $_REQUEST['button'] : '';
$user_id = $_REQUEST['user_id'];

	
	
if($button == 'Wyślij')
	{
	include("../php/potwierdzenie_dostawy_z_zamowienia_pdf.php");
	}		
else
	{
	$klient=$klient_id;
	include ("../php/lista_emaili_potwierdzenie_dostawy.php");
	
	$pytanie8 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$id.";");
	while($wynik8= mysqli_fetch_assoc($pytanie8))
		{
		$zamowienie_id_lista=$zamowienie_id;
		$wartosc_netto_zamowienie=$wynik8['wartosc_netto'];
		$nr_zamowienia=$wynik8['nr_zamowienia'];
		$nr_zamowienia_klienta=$wynik8['nr_zamowienia_klienta'];
		$data_dostawy =$wynik8['data_dostawy'];
		$nr_zlecenia_transportowego=$wynik8['nr_zlecenia_transportowego'];
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
			{
			$kierowca = $wynik1323['imie'].' '.$wynik1323['telefon'];
			}
		}

	
	echo '<FORM action="potwierdzenie_dostawy_z_zamowienia_okienko.php?id='.$id.'&klient_id='.$klient_id.'&user_id='.$user_id.'" method="POST">';
	
	echo '<body background="../images/tlo_male.jpg">';
	
	echo '<table width="100%" align="center" border="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr class="text_duzy"><td width="100%" align="center" bgcolor="#e24139" colspan="2">Wyślij potwierdzenie dostawy</td><tr>';
	echo '<tr class="text" height="30px"><td width="30%" align="right" bgcolor="#e24139">Temat :&nbsp;&nbsp;</td><td width="70%" align="left" bgcolor="white">&nbsp;&nbsp;Potwierdzenie dostawy : '.$nr_zlecenia_transportowego.'</td><tr>';
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
		echo '<img src="../images/pdf_icon.png" border="0" title="" alt="">';
		echo '</td></tr></table>';
	echo '</td><tr>';
	if($ilosc_email != 1) echo '<tr class="text"><td width="100%" align="center" bgcolor="#e24139" colspan="2"><input type="submit" value="Wyślij" name="button"></td><tr>';
	else echo '<tr class="text_duzy_czerwony"><td width="100%" align="center" bgcolor="black" colspan="2">BRAK ADRESU E-MAIL NABYWCY!</td><tr>';
	if(($user_id == 1) && ($adres_ip == '127.0.0.1')) echo '<tr class="text" bgcolor="#ff41f9" align="center"><td colspan="2">Działamy lokalnie. Faktycznie wysyłka nastąpi na : '.$lokalny_adres_email.'</td><tr>';

	echo '</form>';
	echo '</table>';
	echo '</body>';
	}

?>

</body>
</html>