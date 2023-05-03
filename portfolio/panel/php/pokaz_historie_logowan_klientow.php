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
include ("../php/_connection.php");
include ("../php/_variables.php");
include ("../style.css");

	$i = 0;
	$klient_id = [];
	$klient_nazwa = [];
	$godzina_logowania = [];
	$czas_log = [];
	$godzina_wylogowania = [];
	$data_logowania = [];
	$godzina_zal = [];
	$godzina_wyl = [];
	$ile_minut = [];
	$ile_minut_round = [];
	$ile_sekund = [];

	$pytanie1 = mysqli_query($conn, "SELECT * FROM logowania_klientow ORDER BY id DESC;");
	while($wynik= mysqli_fetch_assoc($pytanie1))
		{
		$i++;
		$klient_id[$i]=$wynik['klient_id'];
		$godzina_logowania[$i]=$wynik['godzina_logowania'];
		$godzina_wylogowania[$i]=$wynik['godzina_wylogowania'];
		$czas_log[$i]=$wynik['czas_log'];
			//szukamy nazwy klienta
			$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$klient_id[$i].";"));
			$klient_nazwa[$i] = $sql['nazwa'];
		}

	
	echo '<body background="../images/tlo_male.jpg">';
	echo '<table width="100%" align="center" border="1" class="text" rules="all" frame="box" cellpadding="2"><tr bgcolor="#e24139" class="text">';
	echo '<td width="3%" align="center">LP</td>';
	echo '<td width="20%" align="center">Klient</td>';
	echo '<td width="10%" align="center">Data logowania</td>';
	echo '<td width="10%" align="center">Godzina zalogowania</td>';
	echo '<td width="10%" align="center">Godzina wylogowania</td>';
	echo '<td width="10%" align="center">Czas logowania</td></tr>';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text"><td align="center" bgcolor="#e24139">'.$x.'</td>';
		echo '<td align="center">'.$klient_nazwa[$x].'</td>';
		$data_logowania[$x] = date('d-m-Y', $godzina_logowania[$x]);
		echo '<td align="center">'.$data_logowania[$x].'</td>';
		$godzina_zal[$x] = date('G:i:s', $godzina_logowania[$x]);
		echo '<td align="center">'.$godzina_zal[$x].'</td>';
		$godzina_wyl[$x] = date('G:i:s', $godzina_wylogowania[$x]);
		echo '<td align="center">'.$godzina_wyl[$x].'</td>';
		if($czas_log[$x] >= 60) 
			{
			$ile_minut[$x] = $czas_log[$x]/60;
			$ile_minut_round[$x] = floor($ile_minut[$x]);
			$ile_sekund[$x] = $czas_log[$x] - ($ile_minut_round[$x] * 60);
			echo '<td align="center">'.$ile_minut_round[$x].'m '.$ile_sekund[$x].'s</td>';
			}
		elseif($godzina_wylogowania[$x] == 0) echo '<td align="center"><font color="green">ZALOGOWANY</font></td>';
		else echo '<td align="center">'.$czas_log[$x].'s</td>';
		echo '</tr>';
		}
	echo '</td></tr></table>';
echo '</body>';

?>

</body>
</html>