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
	background-position: center top;
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


if(($miesiac_od != '') && ($miesiac_do != '') && ($rok_od != '') && ($rok_do != ''))
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

	$SUMA_BRUTTO = 0;
	$i = 0;
	$ilosc_pozycji = 0;
	$liczba_wierszy = 0;

	$id_fv = [];
	$nr_fv = [];
	$nabywca_nazwa = [];
	$nabywca_ulica = [];
	$nabywca_miasto = [];
	$nabywca_nip = [];
	$nabywca_kod_pocztowy = [];

	$nr_fv_korygowanej = [];
	$typ_dok = [];
	$data_wystawienia = [];
	$data_zakonczenia_dostawy = [];

	$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE data_wystawienia_miesiac >= '".$miesiac_od."' AND data_wystawienia_miesiac <= '".$miesiac_do."' AND data_wystawienia_rok >= '".$rok_od."' AND data_wystawienia_rok <= '".$rok_do."' AND waluta = 'PLN' AND (typ_dok = 'Faktura' OR typ_dok = 'Korekta') ORDER BY id ASC;");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$i++;
		$id_fv[$i]=$wynik33['id'];
		$nabywca_nazwa[$i]=$wynik33['nabywca_nazwa'];
		$nabywca_ulica[$i]=$wynik33['nabywca_ulica'];
		$nabywca_miasto[$i]=$wynik33['nabywca_miasto'];
		$nabywca_kod_pocztowy[$i]=$wynik33['nabywca_kod_pocztowy'];
		$nabywca_nip[$i]=$wynik33['nabywca_nip'];
		$nr_fv[$i]=$wynik33['nr_dok'];
		$nr_fv_korygowanej[$i]=$wynik33['nr_fv_korygowanej'];
		$pytanie333 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE nr_fv = '".$nr_fv[$i]."' ORDER BY id ASC;");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			{
			$ilosc_pozycji++;
			//$liczba_wierszy++;
			}
			
		$typ_dok[$i]=$wynik33['typ_dok'];
		$data_wystawienia[$i]=$wynik33['data_wystawienia'];
		$data_zakonczenia_dostawy[$i]=$wynik33['data_zakonczenia_dostawy'];
		
		//tylko do obliczenia sumy brutto przed tabela
		$pytanie333 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE fv_id = ".$id_fv[$i]." ORDER BY pozycja ASC;");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			{
			$pozycja_wartosc_brutto_temp=$wynik333['wartosc_brutto'];
			$liczba_wierszy++;
			if($typ_dok[$i] == 'Korekta')
				{
				$pytanie44 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE nr_fv='".$nr_fv_korygowanej[$i]."';");
				while($wynik44= mysqli_fetch_assoc($pytanie44))
					{
					$wartosc_brutto_faktura_temp=$wynik44['wartosc_brutto'];
					}
				$pozycja_wartosc_brutto_temp = $pozycja_wartosc_brutto_temp - $wartosc_brutto_faktura_temp;
				}
			$SUMA_BRUTTO += $pozycja_wartosc_brutto_temp;
			}
		// KONIEC yylko do obliczenia sumy brutto przed tabela
		}

	
		
		$atrybut_kolumn = 'align="right" width="80px"';

		echo '<table border="1" cellspacing="1" cellpadding="3" class="text" width="1500px" BORDERCOLOR="black" frame="box" RULES="all">';
		// echo '<tr class="text_mini" bgcolor="'.$kolor_szary.'" align="center">';
		// echo '<td>P 2B</td>'; 	//Kolejny numer faktury, nadany w ramach jednej lub wicej serii, ktry w sposb jednoznaczny indentyfikuje faktur
		// echo '<td width="300px" align="left">P 7</td>'; 	//Nazwa (rodzaj) towaru lub usugi. Pole opcjonalne wycznie dla przypadku okrelonego w art 106j ust.3 pkt 2 ustawy (faktura korekta
		// echo '<td>P 8A</td>'; 	//Miara dostarczonych towarw lub zakres wykonanych usug. Pole opcjonalne dla przypadku okrelonego w art 106e ust. 5 pkt 3 ustawy
		// echo '<td>P 8B</td>'; 	//Ilo (liczba) dostarczonych towarw lub zakres wykonanych usug. Pole opcjonalne dla przypadku okrelonego w art 106e ust. 5 pkt 3 ustawy
		// echo '<td>P 9A</td>';	//Cena jednostkowa towaru lub usugi bez kwoty podatku (cena jednostkowa netto). Pole opcjonalne dla przypadkw okrelonych w art. 106e ust.2 i 3 ustawy (gdy przynajmniej jedno z pl P_106E_2 i P_106E_3 przyjmuje warto "true") oraz dla przypadku okrelonego w art 106e ust. 5 pkt 3 ustawy
		// echo '<td>P 9B</td>';	//W przypadku zastosowania art.106e ustawy, cena wraz z kwot podatku (cena jednostkowa brutto)
		// echo '<td>P 10</td>';	//Kwoty wszelkich opustw lub obniek cen, w tym w formie rabatu z tytuu wczeniejszej zapaty, o ile nie zostay one uwzgldnione w cenie jednostkowej netto. Pole opcjonalne dla przypadkw okrelonych w art. 106e ust.2 i 3 ustawy (gdy przynajmniej jedno z pl P_106E_2 i P_106E_3 przyjmuje warto "true") oraz dla przypadku okrelonego w art. 106e ust. 5 pkt 1 ustawy
		// echo '<td>P 11</td>';	//Warto dostarczonych towarw lub wykonanych usug, objtych transakcj, bez kwoty podatku (warto sprzeday netto). Pole opcjonalne dla przypadkw okrelonych w art. 106e ust.2 i 3 ustawy (gdy przynajmniej jedno z pl P_106E_2 i P_106E_3 przyjmuje warto "true") oraz dla przypadku okrelonego w art. 106e ust. 5 pkt 3 ustawy
		// echo '<td>P 11A</td>';	//W przypadku zastosowania art. 106e ust.7 i 8 ustawy, warto sprzeday brutto
		// echo '<td>P 12</td>';	//Stawka podatku. Pole opcjonalne dla przypadkw okrelonych w art. 106e ust.2 i 3 ustawy (gdy przynajmniej jedno z pl P_106E_2 i P_106E_3 przyjmuje warto "true"), a take art. 106e ust.4 pkt 3 i ust. 5 pkt 1-3 ustawy
		// echo '</tr>';
		
		
	for($x=1; $x<=$i; $x++)
		{
		$ilosc_pozycji = 0;
		$pytanie333 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE fv_id = ".$id_fv[$x]." ORDER BY pozycja ASC;");
		while($wynik333= mysqli_fetch_assoc($pytanie333))
			{
			$ilosc_pozycji++;
			$pozycja_nazwa_produktu[$ilosc_pozycji]=$wynik333['nazwa_produktu'];
			$pozycja_jednostka[$ilosc_pozycji]=$wynik333['jednostka'];
			$pozycja_ilosc[$ilosc_pozycji]=$wynik333['ilosc'];
			$pozycja_vat[$ilosc_pozycji]=$wynik333['vat'];
				
			$pozycja_cena_netto[$ilosc_pozycji]=$wynik333['cena_netto'];
			$pozycja_cena_brutto[$ilosc_pozycji]=$wynik333['cena_brutto'];
			$pozycja_wartosc_netto[$ilosc_pozycji]=$wynik333['wartosc_netto'];
			$pozycja_wartosc_brutto[$ilosc_pozycji]=$wynik333['wartosc_brutto'];

			//echo 'typ['.$x.']='.$typ_dok[$x].'<br>';
			if($typ_dok[$x] == 'Korekta')
				{
				$pytanie44 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE nr_fv='".$nr_fv_korygowanej[$x]."';");
				while($wynik44= mysqli_fetch_assoc($pytanie44))
					{
					$cena_netto_faktura[$ilosc_pozycji]=$wynik44['cena_netto'];
					$cena_brutto_faktura[$ilosc_pozycji]=$wynik44['cena_brutto'];
					$wartosc_netto_faktura[$ilosc_pozycji]=$wynik44['wartosc_netto'];
					$wartosc_brutto_faktura[$ilosc_pozycji]=$wynik44['wartosc_brutto'];
					
					}
				$pozycja_cena_netto[$ilosc_pozycji] = $pozycja_cena_netto[$ilosc_pozycji] - $cena_netto_faktura[$ilosc_pozycji];
				$pozycja_cena_brutto[$ilosc_pozycji] = $pozycja_cena_brutto[$ilosc_pozycji] - $cena_brutto_faktura[$ilosc_pozycji];
				$pozycja_wartosc_netto[$ilosc_pozycji] = $pozycja_wartosc_netto[$ilosc_pozycji] - $wartosc_netto_faktura[$ilosc_pozycji];
				$pozycja_wartosc_brutto[$ilosc_pozycji] = $pozycja_wartosc_brutto[$ilosc_pozycji] - $wartosc_brutto_faktura[$ilosc_pozycji];
				}
			
			$stawka_vat[$ilosc_pozycji]=$wynik333['vat'];
			$pozycja_cena_netto[$ilosc_pozycji] = number_format($pozycja_cena_netto[$ilosc_pozycji], 2,',','');
			$pozycja_cena_brutto[$ilosc_pozycji] = number_format($pozycja_cena_brutto[$ilosc_pozycji], 2,',','');
			$pozycja_wartosc_netto[$ilosc_pozycji] = number_format($pozycja_wartosc_netto[$ilosc_pozycji], 2,',','');
			$pozycja_wartosc_brutto[$ilosc_pozycji] = number_format($pozycja_wartosc_brutto[$ilosc_pozycji], 2,',','');
			}

        for($y=1; $y<=$ilosc_pozycji; $y++)
			{
			echo '<tr align="left" class="text_mini" bgcolor="white" height="10px">';
			echo '<td align="center">'.$nr_fv[$x].'</td>';		//P 2B
			echo '<td>'.$pozycja_nazwa_produktu[$y].'</td>';	//P 7
			echo '<td>'.$pozycja_jednostka[$y].'</td>';			//P 8A
			echo '<td>'.$pozycja_ilosc[$y].'</td>';				//P 8B
			echo '<td align="right">'.$pozycja_cena_netto[$y].'</td>';		//P 9A
			echo '<td align="right">'.$pozycja_cena_brutto[$y].'</td>';		//P 9B
			echo '<td></td>';		//P 10
			echo '<td align="right">'.$pozycja_wartosc_netto[$y].'</td>';	//P 11
			echo '<td align="right">'.$pozycja_wartosc_brutto[$y].'</td>';	//P 11A
			echo '<td>'.$pozycja_vat[$y].'</td>';	//P 12
			echo '</tr>';
			}
		
		}
	echo '</table>';
	}
		
?>
