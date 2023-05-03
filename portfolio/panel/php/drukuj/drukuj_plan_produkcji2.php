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
include("../../php/_session.php");
include("../../php/_connection.php");
include("../../php/_functions.php");
include("../../php/_variables.php");
include("../../style.css");

$klient_nazwa = [];
include("../../php/planowanie_produkcji.php");

?>
</body>
</html>
