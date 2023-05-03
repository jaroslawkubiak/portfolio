<?php
include ("php/_session.php");
include ("php/_variables.php");
include ("php/_connection.php");
include ("php/_functions.php");

# logowanie, wylogowanie itp
switch ($page)
{
case "login"  : 
	  $login  = substr($login, 0, 255);
	  $passwd = substr($passwd, 0, 255);
	  login($login, $passwd, $conn); 
	  break;

case "wyloguj" : logout($user_id, $conn);
	  break;
}

?>
<!DOCTYPE HTML>
<html lang="pl">
<html>
	<head>
	<meta http-equiv = "Content-Type" content = "text/html" />
	<meta charset = "UTF-8" />
	<meta name="Author" content="Arcus" />
	<meta name="Language" content="pl" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<META HTTP-EQUIV="Content-Language" CONTENT="pl" />

	<link rel="stylesheet" type="text/css" href="style2.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="lightbox.css">
	<link rel="shortcut icon" href="images/arcus_icon.png">
	<link rel="bookmark icon" href="images/arcus_icon.png">

	<style type="text/css">@import url(cal/skins/aqua/theme.css);</style>
	<script type="text/javascript" src="cal/calendar.js"></script>
	<script type="text/javascript" src="cal/lang/calendar-en.js"></script>
	<script type="text/javascript" src="cal/calendar-setup.js"></script>	
	<script type="text/javascript" src="php/java/okienka.js"></script>
	<script type="text/javascript" src="php/java/wycena_wstepna.js"></script>	
	<script defer src="php/java/wyceny.js"></script>	
	<script type="text/javascript" src="php/java/sinus.js"></script>	
	<script type="text/javascript" src="php/java/dlugosc_luku.js"></script>
	<script type="text/javascript" src="php/java/przekatna.js"></script>
	<script type="text/javascript" src="php/java/lightbox/lightbox-plus-jquery.js"></script>	

		
	<script>
		lightbox.option({
		'resizeDuration': 100,
		'wrapAround': true,
		'maxWidth': 700,
		'positionFromTop' : 5
		})
	</script>

	<title>Arcus - panel</title>
	<style type="text/css">
	body 
		{
		background-image:url(images/tlo.jpg);
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: center top;
		}
	</style>

	</head>
<body>
<?php
	
if(!auth())
{
?>
	<form action="index.php" method="POST" id="login">
	<input type="hidden" name="page" value="login">
	<input type="hidden" name="<?=SESSION_NAME()?>" value="<?=SESSION_ID()?>">

	<br><br><br><br><br><table border="0" align="center" width="10%" cellpadding="5"><tr><td align="center" width="100%" class="text">
	<civ class="text_duzy_niebieski">Logowanie</div>
	</td></tr><tr><td align="center" class="text">
	Login
	</td></tr><tr><td align="center" class="text">
	<input type="text" name="login" size="10" id="login" tabindex="1" class="pole_input">
	</td></tr><tr><td align="center" class="text">
	Hasło
	</td></tr><tr><td align="center">
	<input type="password" name="passwd" size="10" tabindex="2" class="pole_input">
	</td></tr><tr><td align="center" class="text">
	<input tabindex="3" type="submit"  border="0" value="Zaloguj" ><br><br>
	</td></tr></table>
	</form>
		
<?php
}
else
{

	//sprawdzamy dzial uzytkownika
	$sql = "SELECT stanowisko, id FROM uzytkownicy WHERE id = ".$_SESSION["USER_ID"].";";
	$result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$user_stanowisko=$wynik['stanowisko'];
			$user_id = $wynik['id'];
			}
	
	echo '<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0"><tr><td>';
		if($user_stanowisko != 'produkcja') include("php/_menu.php"); else include("php/realizacja_produkcji.php");
	echo '</td></tr><tr><td>';
	
	echo '<table border="0" width="100%" align="center"><tr><td><br>';
	if ($page == 'login') echo '<div class="text_duzy" align="center">Logowanie udane. Witaj <font color="blue">'.$login.'</font></div>';
			


	//sprawdzam logowania uzytkownikow ktorzy sie nie wylogowali
	$pytanie24 = mysqli_query($conn, "SELECT * FROM logowania_uzytkownikow2 WHERE godzina_wylogowania = 0;");
	while($wynik24 = mysqli_fetch_assoc($pytanie24))
	{
		$idi=$wynik24['id'];

		$godzina_logowania=$wynik24['godzina_logowania'];
		$czas_logowania = $time - $godzina_logowania;
		if($czas_logowania > 28800)  //28800 = 8godzin
		{
			$czas_log = 900;
			$godzina_wylogowania = $godzina_logowania + 900; // 900 sek = 15min
			mysqli_query($conn, "UPDATE logowania_uzytkownikow2 SET godzina_wylogowania='".$godzina_wylogowania."' WHERE id = ".$idi.";");
			mysqli_query($conn, "UPDATE logowania_uzytkownikow2 SET czas_log='".$czas_log."' WHERE id = ".$idi.";");
		}
	}


	//sprawdzam logowania klientow ktorzy sie nie wylogowali
	$pytanie24 = mysqli_query($conn, "SELECT * FROM logowania_klientow WHERE godzina_wylogowania = 0");
	while($wyniwynik5k24 = mysqli_fetch_assoc($pytanie24))
	{
		$idi=$wynik5['id'];
		$godzina_logowania=$wynik5['godzina_logowania'];
		$czas_logowania = $time - $godzina_logowania;
		if($czas_logowania > 28800)  //28800 = 8godzin
			{
			$czas_log = 900;
			$godzina_wylogowania = $godzina_logowania + 900; // 900 sek = 15min
			mysqli_query($conn, "UPDATE logowania_klientow SET godzina_wylogowania='".$godzina_wylogowania."' WHERE id = ".$idi.";");
			mysqli_query($conn, "UPDATE logowania_klientow SET czas_log='".$czas_log."' WHERE id = ".$idi.";");
			}
	}


	if(file_exists("php/".$page.".php")) 
		{

		include_once "php/".$page.".php";
		page_visit_counter($conn, $page);

		echo '<br><br><br><br><br><br><br><br><br><br>&nbsp;';
		}
	elseif ($page != 'login') 
		echo '<div class="text" align="center">Strona nie istnieje</div>';

		// if($zalogowany_user == 1) echo "<b> MENU after: " . memory_get_usage() . "</b><br>";

	echo '</td></tr></table>';
	echo '</td></tr></table>';
} 	

?>

</body>
</html>