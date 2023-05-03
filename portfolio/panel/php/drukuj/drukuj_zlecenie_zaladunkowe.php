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


//deklaruje tablice
$klient_id = [];
$data_dostawy = [];
$uwagi = [];
$odbior_material = [];
$odbior_szablon = [];
$zwrot_material = [];
$zwrot_szablon = [];
$zwrot_uszczelki = [];
$ilosc_pozycji_w_zleceniu_transportowym = [];
$tabela_z_pozycjami_wyceny = [];
$tabela_z_pozycjami_wyceny_status = [];
$informacja_o_ilosci_pozycji = [];
$suma_pokaz = [];
$zamowienie_id = [];
$nr_zamowienia = [];
$nr_zamowienia_klienta = [];
$zamowienie_data_wysylki_potwierdzenia_dostawy = [];
$zamowienie_link_dostawa = [];
$nr_faktury = [];
$ilosc_pozycji_zamowienia = [];


$pytanie3 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE id=".$id.";");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	$nr_zlecenia_transportowego=$wynik3['nr_zlecenia_transportowego'];
	$typ=$wynik3['typ'];
	$data_zaladunku=$wynik3['data_zaladunku'];
	$data_wyjazdu=$wynik3['data_wyjazdu'];
	$kierowca=$wynik3['kierowca'];
	$sposob_dostawy=$wynik3['sposob_dostawy'];
	$status=$wynik3['status'];
	}
	
// kierowca
$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id=".$kierowca.";");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	$kierowca_opis = $wynik2['imie'].' '.$wynik2['telefon'];

$SUMA_GOTOWKA = 0;
$szer_kol_lp = 10;
$szer_kol_klient = 220;
$szer_kol_adres = 250;
$szer_kol_nr_zam = 280;
$szer_kol_pozycje = 150;
$szer_kol_status = 180;
$szer_kol_uwagi = 230;
$szer_kol_odbior = 100;
$szer_kol_liczba = 70;
$szer_kol_zwrot = 240;
$szer_kol_pod_zwrotami = 60;

$szerokosc_tabeli = $szer_kol_lp + $szer_kol_klient + $szer_kol_adres + $szer_kol_nr_zam + $szer_kol_pozycje + $szer_kol_status +  $szer_kol_uwagi + $szer_kol_odbior + $szer_kol_zwrot + $szer_kol_liczba;

//tabela 1
echo '<table width="'.$szerokosc_tabeli.'px" align="center" border="0" cellpadding="0"><tr><td width="100%" align="center" valign="top">';
	echo '<div class="text_duzy" align="center">Zlecenie załadunkowe '.$nr_zlecenia_transportowego.'</div><br>';
	if(($nr_zlecenia_transportowego != 'Kurier') && ($nr_zlecenia_transportowego != 'Odbiór własny'))
	{
		echo '<table width="100%"  BORDERCOLOR="black" frame="box" RULES="all" cellpadding="5" border="0"><tr class="text">';
		echo '<td align="right" width="12%" bgcolor="'.$kolor_szary.'">'.$kol_sposob_dostawy.'</td><td align="left" width="12%" bgcolor="'.$kolor_bialy.'">'.$sposob_dostawy.'</td>';
		echo '<td align="right" width="12%" bgcolor="'.$kolor_szary.'">'.$kol_kierowca.'</td><td align="left" width="12%" bgcolor="'.$kolor_bialy.'">'.$kierowca_opis.'</td>';
		echo '<td align="right" width="12%" bgcolor="'.$kolor_szary.'">'.$kol_data_zaladunku.'</td><td align="left" width="12%" bgcolor="'.$kolor_bialy.'">'.$data_zaladunku.'</td>';
		echo '<td align="right" width="12%" bgcolor="'.$kolor_szary.'">'.$kol_data_wyjazdu.'</td><td align="left" width="12%" bgcolor="'.$kolor_bialy.'">'.$data_wyjazdu.'</td>';
		echo '</tr></table><br>';
	}

$ilosc_klientow = 0;
$pytanie37 = mysqli_query($conn, "SELECT DISTINCT klient_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' ORDER BY kolejnosc ASC;");
while($wynik37= mysqli_fetch_assoc($pytanie37))
	{
	//tylko w przypadku zleceń kurier i odbiór własny
	if(($nr_zlecenia_transportowego == 'Kurier') || ($nr_zlecenia_transportowego == 'Odbiór własny'))
		{
		//sprawdzamy czy dany klient ma jakieś zamówienie któego status jest inny niż dostarczone.
		$temp_klient_id=$wynik37['klient_id'];
		$ilosc_zamowien_niedostarczonych[$temp_klient_id] = 0;
		$pytanie15 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$temp_klient_id.";");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
			{
			$temp_zamowienie_id=$wynik15['zamowienie_id'];
			$pytanie125 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id=".$temp_zamowienie_id." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane';");
			while($wynik125= mysqli_fetch_assoc($pytanie125))
				$ilosc_zamowien_niedostarczonych[$temp_klient_id] += 1;
			}
		//jak ilość zamówień ze statusem innym niż dostarczone jest większa niż 0 to dodajemy klienta do listy w zleceniu transportowym
		if($ilosc_zamowien_niedostarczonych[$temp_klient_id] != 0)
			{
			$ilosc_klientow++;
			$klient_id[$ilosc_klientow]=$wynik37['klient_id'];
			}
		}
	else
		{
		$ilosc_klientow++;
		$klient_id[$ilosc_klientow]=$wynik37['klient_id'];
		}

	}

for ($x=1; $x<=$ilosc_klientow; $x++)
	{
	$pytanie343 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$x].";");
	while($wynik343= mysqli_fetch_assoc($pytanie343))
		{
		$data_dostawy[$x]=$wynik343['data_dostawy'];
		$uwagi[$x]=$wynik343['uwagi'];
		$liczba_paczek_wyrobow[$x]=$wynik343['liczba_paczek_wyrobow'];
		$odbior_material[$x] = $wynik343['odbior_material'];
		$odbior_szablon[$x] = $wynik343['odbior_szablon'];
		$zwrot_material[$x] = $wynik343['zwrot_material'];
		$zwrot_szablon[$x] = $wynik343['zwrot_szablon'];
		$zwrot_uszczelki[$x] = $wynik343['zwrot_uszczelki'];
		}
	}

echo '<table width="'.$szerokosc_tabeli.'px" align="center" BORDERCOLOR="black" frame="box" RULES="all"><tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
echo '<td width="'.$szer_kol_lp.'px" rowspan="2">'.$kol_lp.'</td>';
echo '<td width="'.$szer_kol_klient.'px" rowspan="2">'.$kol_klient.'</td>';
echo '<td width="'.$szer_kol_adres.'px" rowspan="2">'.$kol_adres_dostawy.'</td>';
echo '<td width="'.$szer_kol_nr_zam.'px" rowspan="2">';
	echo '<table width="100%" align="center" border="0" cellpadding="3" class="text">';
	echo '<tr align="center"><td width="32%" height="30px">Nr zam ARCUS</td>';
	echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
	echo '<td width="32%" height="30px">Nr zam klienta</td></tr>';
	echo '</table>';		
echo '</td>';
echo '<td width="'.$szer_kol_pozycje.'px" rowspan="2">'.$kol_pozycje_zamowienia.'</td>';
echo '<td width="'.$szer_kol_status.'px" rowspan="2">'.$kol_status.'</td>';
echo '<td width="'.$szer_kol_uwagi.'px" rowspan="2">'.$kol_uwagi.'</td>';
echo '<td width="'.$szer_kol_odbior.'px" colspan="4">'.$kol_zwrot.'</td>';
echo '<td width="'.$szer_kol_liczba.'px" rowspan="2">'.$kol_liczba_paczek.'</td></tr>';
	
echo '<tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_szablony_przy_wyrobach.'</td>';
echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_szablony_luzem.'</td>';
echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_profile.'</td>';
echo '<td width="'.$szer_kol_pod_zwrotami.'px" align="center">'.$kol_uszczelki.'</td>';
echo '</tr>';

for ($k=1; $k<=$ilosc_klientow; $k++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_szary.'" class="text">'.$k.'</td>';
	$pytanie14 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id[$k].";");
	while($wynik14= mysqli_fetch_assoc($pytanie14))
		{
		$klient_nazwa=$wynik14['nazwa'];
		$klient_ulica=$wynik14['dostawy_ulica'];
		$klient_miasto=$wynik14['dostawy_miasto'];
		$klient_kod_pocztowy=$wynik14['dostawy_kod_pocztowy'];
		}
	echo '<td>'.$klient_nazwa.'</td>';
	echo '<td>'.$klient_ulica.'<br>'.$klient_kod_pocztowy.' '.$klient_miasto.'</td>';
		
	//ilosc zamowien
	$ilosc_zamowien = 0;
	$liczba_paczek_realizacja_produkcji = 0;
	$pytanie15 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."' AND klient_id=".$klient_id[$k]." ORDER BY zamowienie_id ASC;");
	while($wynik15= mysqli_fetch_assoc($pytanie15))
		{
		//tylko w przypadku zleceń kurier i odbiór własny
		if(($nr_zlecenia_transportowego == 'Kurier') || ($nr_zlecenia_transportowego == 'Odbiór własny'))
			{
			$temp_zamowienie_id=$wynik15['zamowienie_id'];
			//sprawdzamy status zamówienia - jak Dostarczone, to nie wyświetlamy na liście.
			$pytanie125 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id=".$temp_zamowienie_id.";");
			while($wynik125= mysqli_fetch_assoc($pytanie125))
				{
					$temp_status=$wynik125['status'];
				}
			}
		else $temp_status = '';

		if(($temp_status != 'Dostarczone') && ($temp_status != 'Odebrane') && ($temp_status != 'Anulowane'))
			{
			$ilosc_zamowien++;
			$zamowienie_id[$ilosc_zamowien]=$wynik15['zamowienie_id'];
			$pytanie152 = mysqli_query($conn, "SELECT kwota_brutto FROM zlecenia_transportowe_tresc WHERE zamowienie_id='".$zamowienie_id[$ilosc_zamowien]."' AND klient_id=".$klient_id[$k]." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
			while($wynik152= mysqli_fetch_assoc($pytanie152))
				$SUMA_BRUTTO_KLIENT += $wynik152['kwota_brutto'];
			//szukamy iloci paczek z realizacji produkcji
			$pytanie = mysqli_query($conn, "SELECT DISTINCT data_wykonania FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id[$ilosc_zamowien]." AND rodzaj_produktu = 10;");
			while($wynik= mysqli_fetch_assoc($pytanie))
				{
				$data_wykonania = $wynik['data_wykonania'];
				$pytanie21 = mysqli_query($conn, "SELECT ilosc_paczek FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id[$ilosc_zamowien]." AND data_wykonania = '".$data_wykonania."' LIMIT 1;");
				while($wynik21= mysqli_fetch_assoc($pytanie21))
					{
					$liczba_paczek_realizacja_produkcji += $wynik21['ilosc_paczek'];
					}
				}
			}
		}
		//##################################################################################### lista zamowien #####################################################################################
		echo '<td>';
		$wysokosc_wiersza = 30;
			echo '<table width="100%" align="center" border="0" cellpadding="3" class="text">';
			for ($z=1; $z<=$ilosc_zamowien; $z++)
				{
				if($zamowienie_id[$z] != 0)
					{
					$pytanie12 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id=".$zamowienie_id[$z].";");
					while($wynik12= mysqli_fetch_assoc($pytanie12))
						{
						$nr_zamowienia[$z]=$wynik12['nr_zamowienia'];
						$nr_zamowienia_klienta[$z]=$wynik12['nr_zamowienia_klienta'];
						$zamowienie_data_wysylki_potwierdzenia_dostawy[$z]=$wynik12['data_wysylki_potwierdzenia_dostawy'];
						$zamowienie_link_dostawa[$z]=$wynik12['link_dostawa'];
						$status_zamowienia[$zamowienie_id[$z]]=$wynik12['status'];
						}
					echo '<tr align="center"><td width="32%" height="'.$wysokosc_wiersza.'px">'.$nr_zamowienia[$z].'</td>';
					echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
					echo '<td width="32%">'.$nr_zamowienia_klienta[$z].'</td></tr>';
					// sprawdzamy nr faktur
					$temp = 0;
					$przynajmniej_jedna_faktura_wpisana = 0;
					$przynajmniej_jedna_faktura_pusta = 0;
					$pytanie123 = mysqli_query($conn, "SELECT nr_faktury, pozycja FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$z]." ORDER BY pozycja ASC;");
					while($wynik123= mysqli_fetch_assoc($pytanie123))
						{
						$temp++;
						$nr_faktury[$temp] = '';
						$pozycja=$wynik123['pozycja'];
						$pytanie1273 = mysqli_query($conn, "SELECT pozycja_wyceny FROM zlecenia_transportowe_tresc WHERE zamowienie_id=".$zamowienie_id[$z]." AND pozycja_wyceny = ".$pozycja." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
						while($wynik1273= mysqli_fetch_assoc($pytanie1273))
							{
							$nr_faktury[$pozycja]=$wynik123['nr_faktury'];
							if($nr_faktury[$pozycja] != '') $przynajmniej_jedna_faktura_wpisana = 1;
							else $przynajmniej_jedna_faktura_pusta = 1;
							}
						}
					$ilosc_pozycji_zamowienia[$z] = $temp;
					}
				else // Odbior profilu
					{
					echo '<tr align="center"><td width="32%" height="'.$wysokosc_wiersza.'px">---</td>';
					echo '<td width="2%"><b>&nbsp;|&nbsp;</b></td>';
					echo '<td width="32%">---</td></tr>';
					}
				}
			echo '</table>';
		echo '</td>';
		//###############################################################################################################################################################
		
	//###################################################### pozycje zamowienia  ########################################################################
	echo '<td>';
	echo '<table width="100%" align="center" border="0" cellpadding="3" class="text">';
	for ($z=1; $z<=$ilosc_zamowien; $z++)
		{
		if($zamowienie_id[$z] != 0)
			{
			$ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id[$z]] = 0;
			//sprawdzamy ile pozycji jest w zleceniu transportowym
			for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++)
				{
				$tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] = 0;
				$pytanie1273 = mysqli_query($conn, "SELECT pozycja_wyceny FROM zlecenia_transportowe_tresc WHERE zamowienie_id=".$zamowienie_id[$z]." AND pozycja_wyceny = ".$y." AND nr_zlecenia_transportowego='".$nr_zlecenia_transportowego."';");
				while($wynik1273= mysqli_fetch_assoc($pytanie1273))
					{
					$ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id[$z]]++;
					$tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] = 1; // jezeli 1 to pozycja jest w wycenie
					}
				///sprawdzamy status kadej z pozycji
				$pytanie73 = mysqli_query($conn, "SELECT status FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$z]." AND pozycja = ".$y.";");
				while($wynik73= mysqli_fetch_assoc($pytanie73))
					{
					$tabela_z_pozycjami_wyceny_status[$zamowienie_id[$z]][$y] = $wynik73['status'];
					}
				}
			$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = '';
			if($ilosc_pozycji_zamowienia[$z] == $ilosc_pozycji_w_zleceniu_transportowym[$zamowienie_id[$z]]) $informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = "Wszystkie pozycje.  ";
			else
				{
				// sprawdzamy ktore pozycje dokadnie nie znajduj sie w zleceniu transportowym
				$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = 'Bez pozycji : ';
				for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++)
					{
					if($tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] == 0) if($tabela_z_pozycjami_wyceny_status[$zamowienie_id[$z]][$y] != 'Dostarczone') $informacja_o_ilosci_pozycji[$zamowienie_id[$z]] .= $y.', ';
					}
				if($informacja_o_ilosci_pozycji[$zamowienie_id[$z]] == 'Bez pozycji : ') 
					{
					$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = 'Pozycje : ';
					for ($y=1; $y<=$ilosc_pozycji_zamowienia[$z]; $y++) if($tabela_z_pozycjami_wyceny[$zamowienie_id[$z]][$y] == 1) $informacja_o_ilosci_pozycji[$zamowienie_id[$z]] .= $y.', ';
					}
				}

			//$informacja_o_ilosci_pozycji[$zamowienie_id[$z]] = mb_substr($informacja_o_ilosci_pozycji[$zamowienie_id[$z]], 0, -2); //uwuwamy dw ostatnie znaki ze stringa
			echo '<tr class="text" align="center" height="'.$wysokosc_wiersza.'px"><td>'.$informacja_o_ilosci_pozycji[$zamowienie_id[$z]].'</td></tr>';
			} // if($zamowienie_id[$z] != 0)
		} //for ($z=1; $z<=$ilosc_zamowien; $z++)
	echo '</table>';
	echo '</td>';
	//############################################################################################################################################################################################################ 
	
	// #####################################  status ########################################################################
	echo '<td>';
		echo '<table width="100%" align="center" border="0" cellpadding="1" class="text">';
		for ($z=1; $z<=$ilosc_zamowien; $z++) echo '<tr align="center"><td width="100%" height="'.$wysokosc_wiersza.'px">'.$status_zamowienia[$zamowienie_id[$z]].'</td></tr>';
		echo '</table>';
	echo '</td>';
	// ##############################################################################################################################################

	echo '<td width="220px">'.$uwagi[$k].'</td>';
	
	// #####################################   zwrot
	$suma_szablony_przy_wyrobach_ilosc = 0;
	$suma_szablony_luzem_ilosc = 0;
	$suma_profile_ilosc = 0;
	$suma_uszczelki_ilosc = 0;
	for ($z=1; $z<=$ilosc_zamowien; $z++)
		{
		$sql1 = "SELECT * FROM realizacja_produkcji_szablony WHERE zamowienie_id = ".$zamowienie_id[$z].";";
		$result = mysqli_query($conn, $sql1);
		if(mysqli_num_rows($result) > 0) 
			{
				while ($wynik = mysqli_fetch_assoc($result)) 
				{
					$szablony_przy_wyrobach_on = $wynik['szablony_przy_wyrobach_on'];
					$szablony_przy_wyrobach_ilosc = $wynik['szablony_przy_wyrobach_ilosc'];
					if($szablony_przy_wyrobach_on == 'on') $suma_szablony_przy_wyrobach_ilosc += $szablony_przy_wyrobach_ilosc;
		
					$szablony_luzem_on = $wynik['szablony_luzem_on'];
					$szablony_luzem_ilosc = $wynik['szablony_luzem_ilosc'];
					if($szablony_luzem_on == 'on') $suma_szablony_luzem_ilosc += $szablony_luzem_ilosc;
		
					$profile_on = $wynik['profile_on'];
					$profile_ilosc = $wynik['profile_ilosc'];
					if($profile_on == 'on') $suma_profile_ilosc += $profile_ilosc;
		
					$profile_on = $wynik['uszczelki_on'];
					$uszczelki_ilosc = $wynik['uszczelki_ilosc'];
					if($profile_on == 'on') $suma_uszczelki_ilosc += $uszczelki_ilosc;

				}
			}
		}
	
	echo '<td align="center" class="text_duzy">';
	if($suma_szablony_przy_wyrobach_ilosc != 0) echo $suma_szablony_przy_wyrobach_ilosc;
	echo '</td>';
	echo '<td align="center" class="text_duzy">';
	if($suma_szablony_luzem_ilosc != 0) echo $suma_szablony_luzem_ilosc;
	echo '</td>';
	echo '<td align="center" class="text_duzy">';
	if($suma_profile_ilosc != 0) echo $suma_profile_ilosc;
	echo '</td>';
	echo '<td align="center" class="text_duzy">';
	if($suma_uszczelki_ilosc != 0) echo $suma_uszczelki_ilosc;
	echo '</td>';

	echo '<td class="text_duzy">'.$liczba_paczek_realizacja_produkcji.'</td></tr>';
	}	
echo '</table>';


echo '<table width="100%" align="center" border="0" cellpadding="0"><tr><td width="100%">';
	echo '<br><br><div align="right" class="text_sredni">....................................................................</div>';
	echo '<br><div align="right" class="text_sredni">Podpis kierowcy</div>';
	echo '<br><div align="right" class="text">Przyjmuję zlecenie do realizacji, potwierdzam odbiór towaru oraz zobowiązuje się do zwrotu gotówki wg w/w specyfikacji</div>';
echo '</td></tr></table>';
		
	


?>
</body>
</html>
