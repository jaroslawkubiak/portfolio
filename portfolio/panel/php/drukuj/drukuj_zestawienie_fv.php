<?php



$rodzaj_dokumentu = $_REQUEST['rodzaj_dokumentu'];
$rozliczenie = $_REQUEST['rozliczenie'];
$radio_zaplacone = $_REQUEST['radio_zaplacone'];
$termin_wystawienia = $_REQUEST['termin_wystawienia'];
$sprawdzany_rok = $_REQUEST['sprawdzany_rok'];
$data_poczatkowa = $_REQUEST['data_poczatkowa'];
$data_koncowa = $_REQUEST['data_koncowa'];
$WARUNEK = $_REQUEST['WARUNEK'];
$SORTOWANIE_DIV = $_REQUEST['SORTOWANIE_DIV'];
$jak = $_REQUEST['jak'];
$wg_czego = $_REQUEST['wg_czego'];
$terminowosc = $_REQUEST['terminowosc'];
$radio_terminowosc = $_REQUEST['radio_terminowosc'];
$klient = $_REQUEST['klient'];
$klient_nazwa = $_REQUEST['klient_nazwa'];


?>
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
//include("../../php/session.php");
include("../../php/_connection.php");
include("../../php/_functions.php");
include("../../php/_variables.php");
include("../../style.css");

$image_zaplacona = '<img src="../../images/zaplacona.png" border="0" title="Zapłacona" alt="Zapłacona">';
$image_niezaplacona = '<img src="../../images/niezaplacona.png" border="0" title="NIE zapłacona" alt="NIE zapłacona">';
$image_nadplata = '<img src="../../images/nadplata.png" border="0" title="NADPŁATA" alt="NADPŁATA">';
$image_czesciowo = '<img src="../../images/czesciowo.png" border="0" title="częciowo" alt="częciowo">';



$termin_wystawienia = $_REQUEST['termin_wystawienia'];
$sprawdzany_rok = $_REQUEST['sprawdzany_rok'];
$data_poczatkowa = $_REQUEST['data_poczatkowa'];
$data_koncowa = $_REQUEST['data_koncowa'];
$WARUNEK = $_REQUEST['WARUNEK'];
$id_fv_do_wplaty = $_REQUEST['id_fv_do_wplaty'];
$nr_fv_do_wplaty = $_REQUEST['nr_fv_do_wplaty'];
$szukany_miesiac = $_REQUEST['szukany_miesiac'];
$wplata = $_REQUEST['wplata'];
$wartosc_wplaty = $_REQUEST['wartosc_wplaty'];
$calosc = $_REQUEST['calosc'];
$SORTOWANIE_DIV = $_REQUEST['SORTOWANIE_DIV'];
$jak = $_REQUEST['jak'];
$wg_czego = $_REQUEST['wg_czego'];
$rozliczenie = $_REQUEST['rozliczenie'];
$radio_zaplacone = $_REQUEST['radio_zaplacone'];


if(($data_poczatkowa == '') && ($data_koncowa == '') && ($termin_wystawienia == 'on'))
	{
	$data_poczatkowa = date('d-m-Y', $time);
	$data_koncowa = date('d-m-Y', $time);
	}

if($data_poczatkowa != '') 
	{
	$pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	}
if($data_koncowa != '') 
	{
	$pieces2 = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
	}


$WARUNEK = "";
if($szukany_miesiac != "") 
	{
	$data_poczatkowa = '01-'.$szukany_miesiac.'-'.$AKTUALNY_ROK;
	$szukany_miesiac2 = mktime(0,0,0, $szukany_miesiac, 1, $AKTUALNY_ROK);
	$ilosc_dni = date('t', $szukany_miesiac2);
	$data_koncowa = $ilosc_dni.'-'.$szukany_miesiac.'-'.$AKTUALNY_ROK;
	$pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	$pieces2 = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
	}   


if($sprawdzany_rok != "") 
	{
	$data_poczatkowa = '01-01-'.$AKTUALNY_ROK;
	$data_koncowa = '31-12-'.$AKTUALNY_ROK;
	$pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	$pieces2 = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
	}   

if($rodzaj_dokumentu != '')
	{
	if($rodzaj_dokumentu != 'WSZYSTKIE') 
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE typ_dok = "'.$rodzaj_dokumentu.'"';
		else $WARUNEK .= ' AND typ_dok = "'.$rodzaj_dokumentu.'"';
		}
	}  

if($data_poczatkowa != '')
	{
	if($WARUNEK == "") $WARUNEK = 'WHERE data_wystawienia_time >= "'.$data_poczatkowa_time.'"';
	else $WARUNEK .= ' AND data_wystawienia_time >= "'.$data_poczatkowa_time.'"';
	}   
	       
if($data_koncowa != '')
	{
	if($WARUNEK == "") $WARUNEK = 'WHERE data_wystawienia_time <= "'.$data_koncowa_time.'"';
	else $WARUNEK .= ' AND data_wystawienia_time <= "'.$data_koncowa_time.'"';
	} 
	         
if($radio_zaplacone != '')
	{
	if($radio_zaplacone == 'zaplacone')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "tak"';
		else $WARUNEK .= ' AND zaplacona = "tak"';
		}
	if($radio_zaplacone == 'niezaplacone')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "nie"';
		else $WARUNEK .= ' AND zaplacona = "nie"';
		}
	}  
	
if($radio_terminowosc != '')
	{
	if($radio_terminowosc == 'w_terminie')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "nie" AND termin_platnosci > "'.$time.'"';
		else $WARUNEK .= ' AND zaplacona = "nie" AND termin_platnosci > "'.$time.'"';
		}
	if($radio_terminowosc == 'po_terminie')
		{
		if($WARUNEK == "") $WARUNEK = 'WHERE zaplacona = "nie" AND termin_platnosci < "'.$time.'"';
		else $WARUNEK .= ' AND zaplacona = "nie" AND termin_platnosci < "'.$time.'"';
		}
	}  
	
if($klient_nazwa != '')
	{
	if($WARUNEK == "") $WARUNEK = "WHERE nabywca_nazwa_skrocona LIKE '%".$klient_nazwa."%'";
	else $WARUNEK .= " AND nabywca_nazwa_skrocona LIKE '%".$klient_nazwa."%'";
	}  
	

$SUMA_NETTO = 0;
$SUMA_BRUTTO = 0;
$SUMA_DO_ZAPLATY = 0;
$ilosc_fv = 0;



$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_naglowek ".$WARUNEK." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$ilosc_fv++;
	$fv_id[$ilosc_fv]=$wynik22['id'];
	$nr_fv[$ilosc_fv]=$wynik22['nr_dok'];
	$zest_typ_dok[$ilosc_fv]=$wynik22['typ_dok'];
	$zamowienie_id[$ilosc_fv]=$wynik22['zamowienie_id'];
	$nabywca_nazwa[$ilosc_fv]=$wynik22['nabywca_nazwa'];
	$numer_faktury[$fv_id[$ilosc_fv]] = $nr_fv[$ilosc_fv];
	$waluta_z_bazy[$ilosc_fv]=$wynik22['waluta'];
	$data_wystawienia[$ilosc_fv]=$wynik22['data_wystawienia'];
	$wartosc_netto_fv[$ilosc_fv]=$wynik22['wartosc_netto_fv'];
	$wartosc_brutto_fv[$ilosc_fv]=$wynik22['wartosc_brutto_fv'];
	
	
	//$SUMA_NETTO += $wartosc_netto_fv[$ilosc_fv];
	//$SUMA_BRUTTO += $wartosc_brutto_fv[$ilosc_fv];
	$termin_platnosci[$ilosc_fv]=$wynik22['termin_platnosci'];
	
	$wplacono[$ilosc_fv]=$wynik22['wplacono'];
	$do_zaplaty[$ilosc_fv] = $wartosc_brutto_fv[$ilosc_fv] - $wplacono[$ilosc_fv];
	//$SUMA_DO_ZAPLATY += $do_zaplaty[$ilosc_fv];
	$zaplacona[$ilosc_fv]=$wynik22['zaplacona'];
	
	if($zest_typ_dok[$ilosc_fv] == 'Faktura')
		{
		$SUMA_NETTO += $wartosc_netto_fv[$ilosc_fv];
		$SUMA_BRUTTO += $wartosc_brutto_fv[$ilosc_fv];
		$SUMA_DO_ZAPLATY += $do_zaplaty[$ilosc_fv];
		}
	}



echo '<table border="0" cellpadding="2" cellspacing="2" class="text" BORDERCOLOR="black" frame="box" RULES="all" width="1200px" align="left"><tr bgcolor="'.$kolor_szary.'" class="text" align="center">';
echo '<td width="10%">Numer</td>';
echo '<td>Klient</td>';
echo '<td width="10%">Data wystawienia</td>';
echo '<td width="10%">Termin płatności</td>';
echo '<td width="8%">Netto</td>';
echo '<td width="8%">Brutto</td>';
echo '<td width="8%">Do zapłaty</td>';
echo '<td width="9%">Zapłacona</td></tr>';
	//echo '<input type="text" id="drukuj_fv" value="'.$drukuj_fv.'">';
for($x=1; $x<=$ilosc_fv; $x++)
	{
	echo '<tr class="text" align="center">';
	echo '<td>'.$nr_fv[$x].'</td>';
	echo '<td align="left">'.$nabywca_nazwa[$x].'</td>';
	echo '<td>'.$data_wystawienia[$x].'</td>';
	$termin = date('d-m-Y', $termin_platnosci[$x]);
	echo '<td>'.$termin.'</td>';
	if($waluta_z_bazy[$x] == 'EURO') $waluta_faktury = ' EURO'; else $waluta_faktury = '';
	$wartosc_netto_fv[$x] = number_format($wartosc_netto_fv[$x], 2,'.',' ');
	$wartosc_brutto_fv[$x] = number_format($wartosc_brutto_fv[$x], 2,'.',' ');
	$do_zaplaty[$x] = number_format($do_zaplaty[$x], 2,'.',' ');
	echo '<td align="right">'.$wartosc_netto_fv[$x].' '.$waluta_faktury.'</td>';
	echo '<td align="right">'.$wartosc_brutto_fv[$x].' '.$waluta_faktury.'</td>';
	echo '<td align="right">'.$do_zaplaty[$x].' '.$waluta_faktury.'</td>';
		if($do_zaplaty[$x] == 0) 
			{
			$obrazek = $image_zaplacona; 
			}
		if($do_zaplaty[$x] > 0) 
			{
			$obrazek = $image_niezaplacona;
			}
		if(($do_zaplaty[$x] != $wartosc_brutto_fv[$x]) && ($do_zaplaty[$x] <> 0))
			{
			$obrazek = $image_czesciowo; 
			$zaplacona[$x] = 'częściowo';
			}
		if($do_zaplaty[$x] < 0) 
			{
			$obrazek = $image_nadplata;
			$zaplacona[$x] = 'NADPŁATA';
			}
		echo '<td align="left" valign="middle">';
		echo '<table width="100%" class="text"><tr valign="middle"><td width="30%" align="center">'.$obrazek.'</td><td width="70%" align="left">'.$zaplacona[$x].'</td></tr></table>';
		echo '</td>';		
	echo '</tr>';	
	}
	
echo '<tr class="text" align="center" bgcolor="'.$kolor_szary.'">';
echo '<td colspan="4"></td>';

$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.',' ');
$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
$SUMA_DO_ZAPLATY = number_format($SUMA_DO_ZAPLATY, 2,'.',' ');
echo '<td align="right">'.$SUMA_NETTO.'</td>';
echo '<td align="right">'.$SUMA_BRUTTO.'</td>';
echo '<td align="right">'.$SUMA_DO_ZAPLATY.'</td>';
echo '<td align="right"></td>';

echo '</tr></table>';


?>
</body>
</html>
