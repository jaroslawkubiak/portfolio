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

include("../../php/zap_zamowienia.php");

$j=0;
$id = [];
$opis = [];
$widoczna = [];
$pytanie = mysqli_query($conn, "SELECT * FROM ust_druku WHERE drukuj='lista_zamowien' ORDER BY ID ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$j++;
	$id[$j]=$wynik['id'];
	$opis[$j]=$wynik['opis'];
	$widoczna[$opis[$j]]=$wynik['widoczna'];
	}
		
$ilosc_kolumn_ilosc = 0;
if($widoczna['sztuki2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['luki_pvc2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['luki_stal2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['luki_alu2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['zgrzewy2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['odwodnienia2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['otwory_pod_klamke2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['otwory_odpowietrzajace2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['slupki2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['slupki_ruchome2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['okuwanie2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['szklenie2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['dociecie_listwy2'] == 'on') $ilosc_kolumn_ilosc++;
if($widoczna['dociecie_kompletu_listew2'] == 'on') $ilosc_kolumn_ilosc++;



$ilosc_kolumn_material = 0;
if($widoczna['profil2'] == 'on') $ilosc_kolumn_material++;
if($widoczna['rodzaj_okuc2'] == 'on') $ilosc_kolumn_material++;
if($widoczna['rodzaj_szyb2'] == 'on') $ilosc_kolumn_material++;
if($widoczna['kolor_profili2'] == 'on') $ilosc_kolumn_material++;
if($widoczna['kolor_uszczelek2'] == 'on') $ilosc_kolumn_material++;
if($widoczna['magazyn2'] == 'on') $ilosc_kolumn_material++;
if($widoczna['stan2'] == 'on') $ilosc_kolumn_material++;


echo '<head><title>Zamówienia</title>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
<META HTTP-EQUIV="Content-Language" CONTENT="pl">
</head>';

		   	
//TABELA Z ZAMOWIENIEM


echo '<table width="100%" align="left" border="0" cellpadding="3"><tr><td align="center" valign="top">';

	echo '<p class="text_duzy" align="center">PLAN PRODUKCJI</p>';
	
echo '</tr><td><tr><td align="center" valign="top">';


	$wybierz_kolor = 0;
	echo '<table width="100%" align="center" class="tabela" cellpadding="2" cellspacing="2"><tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
	echo '<td rowspan="2" width="20px">'.$kol_lp.'</td>';
	echo '<td rowspan="2" width="70px">'.$kol_klient.'</td>';
	if($widoczna['data_przyjecia2'] == 'on') echo '<td rowspan="2" width="30px">'.$kol_data_przyjecia_zamowienia.'</td>';
	if($widoczna['nr_zamowienia2'] == 'on') echo '<td rowspan="2" width="30px">'.$kol_nr_zamowienia_arcus.'</td>';
	if($widoczna['nr_zamowienia_klienta2'] == 'on') echo '<td rowspan="2" width="30px">'.$kol_nr_zamowienia_klienta.'</td>';
	if($widoczna['data_wysylki_potwierdzenia'] == 'on') echo '<td rowspan="2" width="30px">'.$kol_data_wysylki_potwierdzenia.'</td>';
	if($widoczna['data_wysylki_potwierdzenia_dostawy'] == 'on') echo '<td rowspan="2" width="30px">'.$kol_data_wysylki_potwierdzenia_dostawy.'</td>';
	if($widoczna['produkt2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_zamowiony_produkt.'</td>';
	if($ilosc_kolumn_material != 0) echo '<td colspan="'.$ilosc_kolumn_material.'">'.$kol_material.'</td>';
	if($ilosc_kolumn_ilosc != 0) echo '<td colspan="'.$ilosc_kolumn_ilosc.'">'.$kol_ilosc.'</td>';
	if($widoczna['nr_wyceny2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_nr_wyceny.'</td>';
	if($widoczna['wartosc_netto2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_wartosc_zamowienia_netto2.'</td>';
	if($widoczna['termin_realizacji2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_termin_realizacji_zamowienia2.'</td>';
	if($widoczna['data_dostawy2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_data_dostawy2.'</td>';
	if($widoczna['nr_zlecenia_transportowego2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_nr_zlecenia_transportowego2.'</td>';
	if($widoczna['nr_faktury2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_nr_faktury.'</td>';
	if($widoczna['status2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_status_zamowienia2.'</td>';
	if($widoczna['uwagi2'] == 'on') echo '<td rowspan="2" width="50px">'.$kol_uwagi.'</td></tr>'; else echo '</tr>';
	
	
	
	//kolumny do materialu
	echo '<tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
	if($widoczna['profil2'] == 'on') echo '<td width="50px">'.$kol_system_prolifi.'</td>';
	if($widoczna['rodzaj_okuc2'] == 'on') echo '<td width="50px">'.$kol_rodzaj_okuc.'</td>';
	if($widoczna['rodzaj_szyb2'] == 'on') echo '<td width="50px">'.$kol_rodzaj_szyb.'</td>';
	if($widoczna['kolor_profili2'] == 'on') echo '<td width="50px">'.$kol_kolor_profili.'</td>';
	if($widoczna['kolor_uszczelek2'] == 'on') echo '<td width="50px">'.$kol_kolor_uszczelek.'</td>';
	if($widoczna['magazyn2'] == 'on') echo '<td width="50px">'.$kol_magazyn.'</td>';
	if($widoczna['stan2'] == 'on') echo '<td width="50px">'.$kol_stan.'</td>';
	

	//kolumny do ilosc
	if($widoczna['sztuki2'] == 'on') echo '<td width="15px">'.$kol_sztuki.'</td>';
	if($widoczna['luki_pvc2'] == 'on') echo '<td width="15px">'.$kol_luki_pvc.'</td>';
	if($widoczna['luki_stal2'] == 'on') echo '<td width="15px">'.$kol_luki_stal.'</td>';
	if($widoczna['luki_alu2'] == 'on') echo '<td width="15px">'.$kol_luki_alu.'</td>';
	if($widoczna['zgrzewy2'] == 'on') echo '<td width="15px">'.$kol_zgrzewy.'</td>';
	if($widoczna['odwodnienia2'] == 'on') echo '<td width="15px">'.$kol_odwodnienia.'</td>';
	if($widoczna['otwory_pod_klamke2'] == 'on') echo '<td width="15px">'.$kol_otwory_pod_klamke.'</td>';
	if($widoczna['otwory_odpowietrzajace2'] == 'on') echo '<td width="15px">'.$kol_otwory_odpowietrzajace.'</td>';
	if($widoczna['slupki2'] == 'on') echo '<td width="15px">'.$kol_slupki.'</td>';
	if($widoczna['slupki_ruchome2'] == 'on') echo '<td width="15px">'.$kol_slupki_ruchome.'</td>';
	if($widoczna['okuwanie2'] == 'on') echo '<td width="15px">'.$kol_okuwanie.'</td>';
	if($widoczna['szklenie2'] == 'on') echo '<td width="15px">'.$kol_szklenie.'</td>';
	if($widoczna['dociecie_listwy2'] == 'on') echo '<td width="15px">'.$kol_dociecie_listwy.'</td>'; 
	if($widoczna['dociecie_kompletu_listew2'] == 'on') echo '<td width="15px">'.$kol_dociecie_kompletu_listew.'</td>'; 
	echo '</tr>';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'"><td class="text" bgcolor="'.$kolor_szary.'">'.$x.'</td>'; 
		echo '<td><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zamowienie_id[$x].'"><font color="black">'.$klient_nazwa[$x].'</font></a></td>';
		//$data[$x] = date('d-m-Y', $data_przyjecia[$x]);
		if($widoczna['data_przyjecia2'] == 'on') echo '<td>'.$data_przyjecia[$x].'</td>';
		if($widoczna['nr_zamowienia2'] == 'on') echo '<td>'.$nr_zamowienia[$x].'</td>';
		if($widoczna['nr_zamowienia_klienta2'] == 'on') echo '<td>'.$nr_zamowienia_klienta[$x].'</td>';
		if($widoczna['data_wysylki_potwierdzenia'] == 'on') echo '<td>'.$data_wysylki_potwierdzenia[$x].'</td>';
		if($widoczna['data_wysylki_potwierdzenia_dostawy'] == 'on') echo '<td>'.$data_wysylki_potwierdzenia_dostawy[$x].'</td>';
		if($widoczna['produkt2'] == 'on') echo '<td>'.$zamowiony_produkt[$x].'</td>';

		// material
		if($widoczna['profil2'] == 'on') echo '<td>'.$system_profili[$x].'</td>';
		if($widoczna['rodzaj_okuc2'] == 'on') echo '<td>'.$rodzaj_okuc[$x].'</td>';
		if($widoczna['rodzaj_szyb2'] == 'on') echo '<td>'.$rodzaj_szyb[$x].'</td>';
		if($widoczna['kolor_profili2'] == 'on') echo '<td>'.$kolor_profili[$x].'</td>';
		if($widoczna['kolor_uszczelek2'] == 'on') echo '<td>'.$kolor_uszczelek[$x].'</td>';
		if($widoczna['magazyn2'] == 'on') echo '<td>'.$magazyn[$x].'</td>';
		if($widoczna['stan2'] == 'on') echo '<td>'.$stan[$x].'</td>';
		
		// ilosc
		if($widoczna['sztuki2'] == 'on') if($sztuki[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$sztuki[$x].'</td>';
		if($widoczna['luki_pvc2'] == 'on') if($luki_pvc[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$luki_pvc[$x].'</td>';
		if($widoczna['luki_stal2'] == 'on') if($luki_stal[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$luki_stal[$x].'</td>';
		if($widoczna['luki_alu2'] == 'on') if($luki_alu[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$luki_alu[$x].'</td>';
		if($widoczna['zgrzewy2'] == 'on') if($zgrzewy[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$zgrzewy[$x].'</td>';
		if($widoczna['odwodnienia2'] == 'on') if($odwodnienia[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$odwodnienia[$x].'</td>';
		if($widoczna['otwory_pod_klamke2'] == 'on') if($otwory_pod_klamke[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$otwory_pod_klamke[$x].'</td>';
		if($widoczna['otwory_odpowietrzajace2'] == 'on') if($otwory_odpowietrzajace[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$otwory_odpowietrzajace[$x].'</td>';
		if($widoczna['slupki2'] == 'on') if($slupki[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$slupki[$x].'</td>';
		if($widoczna['slupki_ruchome2'] == 'on') if($slupki_ruchome[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$slupki_ruchome[$x].'</td>';
		if($widoczna['okuwanie2'] == 'on') if($okuwanie[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$okuwanie[$x].'</td>';
		if($widoczna['szklenie2'] == 'on') if($szklenie[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$szklenie[$x].'</td>';
		if($widoczna['dociecie_listwy2'] == 'on') if($dociecie_listwy[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$dociecie_listwy[$x].'</td>';
		if($widoczna['dociecie_kompletu_listew2'] == 'on') if($komplet_listew[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$komplet_listew[$x].'</td>';

		if($widoczna['nr_wyceny2'] == 'on') echo '<td>'.$nr_wyceny[$x].'</td>';
		if($widoczna['wartosc_netto2'] == 'on') echo '<td>'.$wartosc_netto[$x].$waluta.'</td>';
		if($widoczna['termin_realizacji2'] == 'on') echo '<td>'.$termin_realizacji[$x].'</td>';
		if($widoczna['data_dostawy2'] == 'on') echo '<td>'.$data_dostawy[$x].'</td>';
		if($widoczna['nr_zlecenia_transportowego2'] == 'on') echo '<td>'.$nr_zlecenia_transportowego[$x].'</td>';
		if($widoczna['nr_faktury2'] == 'on') echo '<td>'.$nr_faktury[$x].'</td>';
		if($widoczna['status2'] == 'on') echo '<td>'.$status[$x].'</td>';
		if($widoczna['uwagi2'] == 'on') echo '<td>'.$uwagi[$x].'</td></tr>'; else echo '</tr>';
		}
		echo '<tr valign="bottom" align="center" bgcolor="'.$kolor_szary.'" class="text">';
			echo '<td></td>';
			echo '<td></td>';
			if($widoczna['data_przyjecia2'] == 'on') echo '<td></td>';
			if($widoczna['nr_zamowienia2'] == 'on') echo '<td></td>';
			if($widoczna['nr_zamowienia_klienta2'] == 'on') echo '<td></td>';
			if($widoczna['data_wysylki_potwierdzenia'] == 'on')echo '<td></td>';
			if($widoczna['data_wysylki_potwierdzenia_dostawy'] == 'on')echo '<td></td>';
			if($widoczna['produkt2'] == 'on') echo '<td></td>';
			// magazyn
			if($widoczna['profil2'] == 'on') echo '<td></td>';
			if($widoczna['rodzaj_okuc2'] == 'on') echo '<td></td>';
			if($widoczna['rodzaj_szyb2'] == 'on') echo '<td></td>';		
			if($widoczna['kolor_profili2'] == 'on')echo '<td></td>';
			if($widoczna['kolor_uszczelek2'] == 'on') echo '<td></td>';
			if($widoczna['magazyn2'] == 'on') echo '<td></td>';
			if($widoczna['stan2'] == 'on') echo '<td></td>';
			// ilosc
			if($widoczna['sztuki2'] == 'on') echo '<td>'.$SUMA_SZTUKI.'</td>';
			if($widoczna['luki_pvc2'] == 'on') echo '<td>'.$SUMA_LUKI_PVC.'</td>';
			if($widoczna['luki_stal2'] == 'on') echo '<td>'.$SUMA_LUKI_STAL.'</td>';
			if($widoczna['luki_alu2'] == 'on') echo '<td>'.$SUMA_LUKI_ALU.'</td>';
			if($widoczna['zgrzewy2'] == 'on') echo '<td>'.$SUMA_ZGRZEWY.'</td>';
			if($widoczna['odwodnienia2'] == 'on') echo '<td>'.$SUMA_ODWODNIENIA.'</td>';
			if($widoczna['otwory_pod_klamke2'] == 'on') echo '<td>'.$SUMA_OTWORY_POD_KLAMKE.'</td>';
			if($widoczna['otwory_odpowietrzajace2'] == 'on') echo '<td>'.$SUMA_OTWORY_ODPOWIETRZAJACE.'</td>';
			if($widoczna['slupki2'] == 'on') echo '<td>'.$SUMA_SLUPKI.'</td>';
			if($widoczna['slupki_ruchome2'] == 'on') echo '<td>'.$SUMA_SLUPKI_RUCHOME.'</td>';
			if($widoczna['okuwanie2'] == 'on') echo '<td>'.$SUMA_OKUWANIE.'</td>';
			if($widoczna['szklenie2'] == 'on') echo '<td>'.$SUMA_SZKLENIE.'</td>';
			if($widoczna['dociecie_listwy2'] == 'on') echo '<td>'.$SUMA_DOCIECIE_LISTWY.'</td>';
			if($widoczna['dociecie_kompletu_listew2'] == 'on') echo '<td>'.$SUMA_KOMPLET_LISTEW.'</td>'; 
		

			if($widoczna['nr_wyceny2'] == 'on') echo '<td></td>';
			if($widoczna['wartosc_netto2'] == 'on') echo '<td>'.kwota($SUMA_WARTOSC_NETTO).$waluta.'</td>';
			if($widoczna['termin_realizacji2'] == 'on') echo '<td></td>';
			if($widoczna['data_dostawy2'] == 'on') echo '<td></td>';
			if($widoczna['nr_zlecenia_transportowego2'] == 'on') echo '<td></td>';
			if($widoczna['nr_faktury2'] == 'on')echo '<td></td>';
			if($widoczna['status2'] == 'on') echo '<td></td>';
			if($widoczna['uwagi2'] == 'on') echo '<td></td>';
		
		echo '</tr></table>';

		
echo '</td></tr></table>';
		
?> 

</body>
</html>

