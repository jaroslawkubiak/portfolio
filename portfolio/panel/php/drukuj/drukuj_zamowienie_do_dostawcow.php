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
include("../../php/_session.php");
include("../../php/_connection.php");
include("../../php/_functions.php");
include("../../php/_variables.php");
include("../../style.css");
$zamowienie_id = $_REQUEST['zamowienie_id'];


$pytanie = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek  WHERE id = ".$zamowienie_id.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$klient_id=$wynik['klient_id'];
	$klient_nazwa=$wynik['klient_nazwa'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$data_zamowienia=$wynik['data_zamowienia'];
	$utworzyl=$wynik['utworzyl'];
	$data_wyslania=$wynik['data_wyslania'];
	$wyslal=$wynik['wyslal'];
	$wartosc_netto=$wynik['wartosc_netto'];
	$status=$wynik['status'];
	$uwagi=$wynik['uwagi'];
	$korekta=$wynik['korekta'];
	}	

$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy  WHERE id = ".$utworzyl.";");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$telefon=$wynik2['telefon'];
	$imie=$wynik2['imie'];
	$nazwisko=$wynik2['nazwisko'];
	}	

	

echo '<table width="1200px" align="center" class="text" cellpadding="3" border="0"><tr align="center" class="text"><td width="50%" align="left">';
echo '<img src="../../images/arcus_logo_mini.png" height="150px">';
echo '</td>';
		
	echo '<td width="50%" class="text_duzy" align="right" valign="top"><br>';
	$pytanie32 = mysqli_query($conn, "SELECT * FROM dostawcy WHERE id='".$klient_id."';");
	while($wynik32= mysqli_fetch_assoc($pytanie32))
		{
		$klient_nazwa = $wynik32['dostawca_nazwa'];
		$klient_ulica = $wynik32['ulica'];
		$klient_miasto = $wynik32['miasto'];
		$klient_kod_pocztowy = $wynik32['kod_pocztowy'];
		}
	echo $klient_nazwa.'<br>';
	echo $klient_ulica.'<br>';
	echo $klient_kod_pocztowy.' '.$klient_miasto.'<br>';
	echo '</td></tr>';
	
	
	if($korekta == 'tak') echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="2">KOREKTA ZAMÓWIENIA NR : '.$nr_zamowienia.'</td></tr>';
	else echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="2">ZAMÓWIENIE NR : '.$nr_zamowienia.'</td></tr>';
	
	
	echo '<tr align="center" class="text_duzy"><td width="50%" align="center" colspan="2">';
		echo '<table class="tabela" width="100%" align="left"><tr valign="middle" align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="16%" bgcolor="'.$kolor_szary.'">Data zamłwienia</td>';
		echo '<td width="16" bgcolor="'.$kolor_bialy.'">'.$data_zamowienia.'</td>';
		echo '<td width="16%" bgcolor="'.$kolor_szary.'">Data wysłania</td>';
		echo '<td width="16%" bgcolor="'.$kolor_bialy.'">'.$data_wyslania.'</td>';
		echo '<td width="16%" bgcolor="'.$kolor_szary.'">Status</td>';
		echo '<td width="16%" bgcolor="'.$kolor_bialy.'">'.$status.'</td></tr></table>';
	echo '</td></tr>';


	echo '<tr align="center" class="text"><td width="100%" align="center" colspan="2">';
		$ilosc_pozycji = 0;
		$wartosc_zamowienia = 0;
		$pytanie373 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_pozycje WHERE nr_zamowienia ='".$nr_zamowienia."' ORDER BY id ASC");
		while($wynik373= mysqli_fetch_assoc($pytanie373))
			{
			$ilosc_pozycji++;
			$pozycja_id[$ilosc_pozycji] = $wynik373['id'];
			$zamowienie_id = $wynik373['zamowienie_id'];
			$system_zamowienie[$ilosc_pozycji]=$wynik373['system'];
			$element_zamowienie[$ilosc_pozycji]=$wynik373['element'];
			$kolor_zamowienie[$ilosc_pozycji]=$wynik373['kolor'];
			$uszczelka_zamowienie[$ilosc_pozycji]=$wynik373['uszczelka'];
			$jednostka_zamowienie[$ilosc_pozycji]=$wynik373['jednostka'];
			$symbol_profilu_zamowienie[$ilosc_pozycji]=$wynik373['symbol_profilu'];
			$symbol_koloru_zamowienie[$ilosc_pozycji]=$wynik373['symbol_koloru'];
			$cena_netto_zakupu_zl_zamowienie[$ilosc_pozycji]=$wynik373['cena_netto_zakupu_zl'];
			$ilosc_zamowienie[$ilosc_pozycji]=$wynik373['ilosc'];
			$wartosc_netto_zamowienie[$ilosc_pozycji]=$wynik373['wartosc_netto'];
			$wartosc_zamowienia += $wartosc_netto_zamowienie[$ilosc_pozycji];
			$cena_netto_zakupu_zl_zamowienie[$ilosc_pozycji] = number_format($cena_netto_zakupu_zl_zamowienie[$ilosc_pozycji], 2,'.',' ');
			$wartosc_netto_zamowienie[$ilosc_pozycji] = number_format($wartosc_netto_zamowienie[$ilosc_pozycji], 2,'.',' ');
			}
		
			// wyswietlamy juz dodane pozycje
			echo '<table width="1200px" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
			echo '<td width="5%" valign="middle">'.$kol_lp.'</td>';
			echo '<td width="8%">System</td>';
			echo '<td width="8%">Element</td>';
			echo '<td width="8%">Kolor</td>';
			echo '<td width="8%">Uszczelka</td>';
			echo '<td width="8%">Symbol profilu</td>';
			echo '<td width="8%">Symbol koloru</td>';
			echo '<td width="8%">Ilość</td>';
			echo '<td width="8%">Cena netto zakupu zł</td>';
			echo '<td width="8%">Wartość netto</td>';
			echo '</tr>';
			
			for ($x=1; $x<=$ilosc_pozycji; $x++)
				{
				echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_szary.'" class="text">'.$x.'</td>';
				echo '<td>'.$system_zamowienie[$x].'</td>';
				echo '<td>'.$element_zamowienie[$x].'</td>';
				echo '<td>'.$kolor_zamowienie[$x].'</td>';
				echo '<td>'.$uszczelka_zamowienie[$x].'</td>';
				echo '<td>'.$symbol_profilu_zamowienie[$x].'</td>';
				echo '<td>'.$symbol_koloru_zamowienie[$x].'</td>';
				echo '<td>'.$ilosc_zamowienie[$x].' '.$jednostka_zamowienie[$x].'</td>';
				echo '<td align="right">'.$cena_netto_zakupu_zl_zamowienie[$x].' '.$waluta.'</td>';
				echo '<td align="right">'.$wartosc_netto_zamowienie[$x].' '.$waluta.'</td>';
				echo '</tr>';
				}
			echo '<tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
			echo '<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
			$pytanie122 = mysqli_query($conn, "UPDATE magazyn_zamowienia_naglowek SET wartosc_netto = ".$wartosc_zamowienia." WHERE nr_zamowienia ='".$nr_zamowienia."';");
			$wartosc_zamowienia = number_format($wartosc_zamowienia, 2,'.',' ');
			echo '<td colspan="2" align="right" bgcolor="'.$kolor_szary.'">Wartość zamówienia : '.$wartosc_zamowienia.' '.$waluta.'&nbsp;&nbsp;&nbsp;</td>';
			echo '</table>';
	echo '</td></tr>';
	
	echo '<tr align="right" class="text"><td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="0" cellpading="5" cellspacing="5">';
		
			echo '<tr align="right" class="text"><td width="25%">Uwagi : </td>';
			echo '<td width="75%" align="left">'.$uwagi.'</td></tr>';
		
			echo '<tr align="right" class="text"><td width="25%" valign="top">Adres dostawy i faktury : </td>';
			echo '<td width="75%" align="left">ARCUS A. GÓRSKI, S. SIKORSKI P. GOLEMO SPÓŁkA CYWILNA<br>Podwiesk 65D, 86-200 Chełmno, NIP: 875-155-50-62</td></tr>';

			echo '<tr align="right" class="text"><td width="25%">Sporządził : </td>';
			echo '<td width="75%" align="left">'.$imie.' '.$nazwisko.' / '.$telefon.' / 52 522-22-02</td></tr>';

		echo '</table>';
	echo '</td></tr>';

	
	
echo '</table>';
?>
</body>
</html>