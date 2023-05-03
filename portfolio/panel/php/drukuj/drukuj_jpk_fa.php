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


if($etap == 2)
	{
	$pytanie = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$sprzedawca_nazwa=$wynik['nazwa'];
		$sprzedawca_ulica=$wynik['ulica'];
		$sprzedawca_miasto=$wynik['miasto'];
		$sprzedawca_kod_pocztowy=$wynik['kod_pocztowy'];
		$sprzedawca_nip=$wynik['nip'];
		}
	
	$id_fv = [];
	$nr_fv = [];
	$nabywca_nazwa = [];
	$nabywca_ulica = [];
	$nabywca_miasto = [];
	$nabywca_kod_pocztowy = [];
	$nabywca_nip = [];
	$nazwa_pliku = [];
	$link_folder = [];
	$pole_jpk_nabywca = [];
	$data_wystawienia = [];
	$data_zakonczenia_dostawy = [];
	$wartosc_netto_fv = [];
	$wartosc_brutto_fv = [];
	$wartosc_vat = [];
	$SUMA = [];
	$pokaz_wartosc_netto_fv = [];
	$pokaz_wartosc_vat = [];
	
	$nr_fv_korygowanej = [];
	$typ_dok = [];
	$data_wystawienia = [];
	$data_zakonczenia_dostawy = [];

	$SUMA_BRUTTO = 0;
	$i = 0;
	$WARUNEK = "data_wystawienia_miesiac >= '".$miesiac_od."' AND data_wystawienia_miesiac <= '".$miesiac_do."' AND data_wystawienia_rok >= '".$rok_od."' AND data_wystawienia_rok <= '".$rok_do."' AND waluta = 'PLN' AND (typ_dok = 'Faktura' OR typ_dok = 'Korekta')";
	// echo $WARUNEK.'<br>';

	$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE $WARUNEK ORDER BY id ASC;");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$i++;
		$id_fv[$i]=$wynik33['id'];
		$nabywca_nazwa[$i]=$wynik33['nabywca_nazwa'];
		$nabywca_ulica[$i]=$wynik33['nabywca_ulica'];
		$nabywca_miasto[$i]=$wynik33['nabywca_miasto'];
		$nabywca_kod_pocztowy[$i]=$wynik33['nabywca_kod_pocztowy'];
		$nabywca_nip[$i]=$wynik33['nabywca_nip'];
		
		$nabywca_nip[$i] = zamien_dowolne_znaki($nabywca_nip[$i], '-', '');
		
		// szukamy kodu kraju
		$pytanie44 = mysqli_query($conn, "SELECT kod_kraju FROM klienci WHERE nip='".$nabywca_nip[$i]."';");
		while($wynik44= mysqli_fetch_assoc($pytanie44))
			{
			$nabywca_kod_kraju[$i]=$wynik44['kod_kraju'];
			}
		
		$nr_fv[$i]=$wynik33['nr_dok'];
		$typ_dok[$i]=$wynik33['typ_dok'];
		if($typ_dok[$i] == 'Korekta')
			{
			$wartosc_netto_korekty[$i]=$wynik33['wartosc_netto_fv'];
			$wartosc_brutto_korekty[$i]=$wynik33['wartosc_brutto_fv'];
			$nr_fv_korygowanej[$i]=$wynik33['nr_fv_korygowanej'];
			$pytanie44 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE nr_dok='".$nr_fv_korygowanej[$i]."';");
			while($wynik44= mysqli_fetch_assoc($pytanie44))
				{
				$wartosc_netto_faktury[$i]=$wynik44['wartosc_netto_fv'];
				$wartosc_brutto_faktury[$i]=$wynik44['wartosc_brutto_fv'];
				}
			$wartosc_netto_fv[$i] = $wartosc_netto_korekty[$i] - $wartosc_netto_faktury[$i];
			$wartosc_brutto_fv[$i] = $wartosc_brutto_korekty[$i] - $wartosc_brutto_faktury[$i];

			//był mega problem z tą korektą, dlatego wartości muszą być recznie
			if($nr_fv[$i] == '3/2020/K') 
			{
				$wartosc_netto_fv[$i] = 0;
				$wartosc_brutto_fv[$i] = 29.52;
			}


			$stawka_vat[$i]=$wynik33['vat'];
			}
		else
			{
			$wartosc_netto_fv[$i]=$wynik33['wartosc_netto_fv'];
			$wartosc_brutto_fv[$i]=$wynik33['wartosc_brutto_fv'];
			$stawka_vat[$i]=$wynik33['vat'];
			}
		$data_wystawienia[$i]=$wynik33['data_wystawienia'];
		$data_zakonczenia_dostawy[$i]=$wynik33['data_zakonczenia_dostawy'];
		$wartosc_vat[$i] = $wartosc_brutto_fv[$i] - $wartosc_netto_fv[$i];
		}



echo '<table border="0"><tr><td>';


	
	
	$atrybut_kolumn = 'align="right" width="80px"';
	echo '<table border="1" cellspacing="1" cellpadding="3" class="text" width="4000px" BORDERCOLOR="black" frame="box" RULES="all">';
		
	for($x=1; $x<=$i; $x++)
		{
		echo '<tr align="left" class="text_mini" bgcolor="white" height="10px">';
		// echo '<td>'.$x.'</td>';
		echo '<td align="center">'.$data_wystawienia[$x].'</td>';
		echo '<td align="center">'.$nr_fv[$x].'</td>';
		echo '<td width="300px">'.$nabywca_nazwa[$x].'</td>';
		echo '<td width="300px">'.$nabywca_kod_pocztowy[$x].' '.$nabywca_miasto[$x].' '.$nabywca_ulica[$x].'</td>';
		echo '<td width="300px">'.$sprzedawca_nazwa.'</td>';
		echo '<td width="300px">'.$sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.' '.$sprzedawca_ulica.'</td>';

		echo '<td '.$atrybut_kolumn.'></td>'; //p 4a
		echo '<td>'.$sprzedawca_nip.'</td>';//p 4b
			if($nabywca_kod_kraju[$x] == 'PL') echo '<td  '.$atrybut_kolumn.'></td>';//p 5a
			else echo '<td  '.$atrybut_kolumn.' align="center">'.$nabywca_kod_kraju[$x].'</td>';//p 5a
		echo '<td align="center">'.$nabywca_nip[$x].'</td>';//p 5b
		echo '<td align="center">'.$data_wystawienia[$x].'</td>'; // p 6
		echo '<td align="center" '.$atrybut_kolumn.'>PLN</td>'; // kod waluty


		//########	P 13 1 - wartosc netto	################
		$wartosc_netto_fv[$x] = number_format($wartosc_netto_fv[$x], 2,',','');
		if($stawka_vat[$x] == 23) echo '<td '.$atrybut_kolumn.'>'.$wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		//########	P 14 1 - wartosc vat	################
		$wartosc_vat[$x] = number_format($wartosc_vat[$x], 2,',','');
		if($stawka_vat[$x] == 23) echo '<td '.$atrybut_kolumn.'>'.$wartosc_vat[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';

		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 1W

		//########	P 13 2 - wartosc netto	################
		if($stawka_vat[$x] == 8) echo '<td '.$atrybut_kolumn.'>'.$wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		//########	P 14 2 - wartosc vat	################
		if($stawka_vat[$x] == 8) echo '<td '.$atrybut_kolumn.'>'.$wartosc_vat[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 2W

		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 3
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 3
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 3W
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 4
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 4
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 4W
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 5
		//########	P 13 6 - wartosc netto	################
		if($stawka_vat[$x] == 0) echo '<td '.$atrybut_kolumn.'>'.$wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';

		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 7
	
		//########	P 15 - wartosc brutto	################
		$wartosc_brutto_fv[$x] = number_format($wartosc_brutto_fv[$x], 2,',','');
		echo '<td '.$atrybut_kolumn.'>'.$wartosc_brutto_fv[$x].'</td>';

		//########	P 16 	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 17	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 18	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 18 A	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 19	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	



		//########	P 19A - P_106E_3A	################
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>'; //P 19A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 19B
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 19C
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 20
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 20A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 20B
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 21
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 21A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 21B
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 21C
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 22
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 22A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 22B
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 22C
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 23
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 106E 2
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 106E 3
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 106E 3A


		//########	Rodzaj faktury	################
		if($typ_dok[$x] == 'Faktura') 
			{
			echo '<td '.$atrybut_kolumn.'>VAT</td>';
			echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
			echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
			echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
			}
		elseif($typ_dok[$x] == 'Korekta') 
			{
			// szukamy szczegw korekty
			$pytanie424 = mysqli_query($conn, "SELECT nr_fv_korygowanej, data_fv_korygowanej, tytul_korekty FROM fv_naglowek WHERE nr_dok ='".$nr_fv[$x]."';");
			while($wynik424= mysqli_fetch_assoc($pytanie424))
				{
				$nr_fv_korygowanej[$x]=$wynik424['nr_fv_korygowanej'];
				$data_fv_korygowanej[$x]=$wynik424['data_fv_korygowanej'];
				$tytul_korekty[$x]=$wynik424['tytul_korekty'];
				}
			echo '<td '.$atrybut_kolumn.'>KOREKTA</td>';
			echo '<td '.$atrybut_kolumn.'>'.$tytul_korekty[$x].'</td>'; //przyczyna korekty
			echo '<td '.$atrybut_kolumn.'>'.$nr_fv_korygowanej[$x].'</td>'; // nr fa korygowanej
			echo '<td '.$atrybut_kolumn.'>'.$data_fv_korygowanej[$x].'</td>'; //okres fa korygowanej
			}
		//########	KONIEC Rodzaj faktury	################


		echo '<td '.$atrybut_kolumn.'>&nbsp;</td></tr>';
		}
	echo '</table>';

echo '</td></tr>';

	
echo '</td></tr></table>';
	
}

?>
</body>
</html>