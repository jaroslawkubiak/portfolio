<style type="text/css">
	a:link {
	color : #000000; 
	font-weight: Bold;
	font-family: arial; 
	text-decoration: none; 
	font-size: 12px;
	}

	a:visited {
	color : #000000; 
	font-weight: Bold;
	font-family: arial; 
	text-decoration: none;
	font-size: 12px;
	} 

	a:active {
	color: #000000;
	font-weight: Bold; 
	font-family: arial; 
	text-decoration: none; 
	font-size: 12px;
	} 

	a:hover {
	color: #000000;
	font-weight: Bold; 
	font-family: arial; 
	text-decoration: underline; 
	font-size: 12px;
	}

	input.produkcja_checkbox
	{
		/* Double-sized Checkboxes */
		-ms-transform: scale(3); /* IE */
		-moz-transform: scale(3); /* FF */
		-webkit-transform: scale(3); /* Safari and Chrome */
		-o-transform: scale(3); /* Opera */
		padding: 100px;

	}
	input.button_produkcja 
	{
		width: 300px;  
		height: 300px;
		font:Arial, Helvetica, sans-serif;
		font-size:36px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_maly
	{
		width: 200px;  
		height: 200px;
		font:Arial, Helvetica, sans-serif;
		font-size:24px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_mniejszy
	{
		width: 150px;  
		height: 50px;
		font:Arial, Helvetica, sans-serif;
		font-size:30px;
		font-weight: Bold;
		white-space: normal;
	}


	input.button_zapisz_produkcja 
	{
		width: 150px;  
		height: 100px;
		font:Arial, Helvetica, sans-serif;
		font-size:36px;
		font-weight: Bold;
		white-space: normal;
	}

	.pole_input_produkcja
	{
		width: 100%; 
		height: 40px;
		border: #000000 1px solid;
		background-color:#e24139;
		color: #000000;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 22px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}

	.pole_input_produkcja_kalendarz
	{
		height: 60px;
		border: #000000 1px solid;
		background-color:#e24139;
		color: #000000;
		text-align:center;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 24px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
}
</style>

<?php
if(($data_poczatkowa == '') && ($data_koncowa == ''))
	{
	$temp = '01-01-'.$AKTUALNY_ROK;
	$data_poczatkowa = date($temp, $time);
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

echo '<FORM action="index.php?page=analiza_wydajnosc_pracownikow" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';

	echo '<table align="center" cellspacing="5" cellpadding="5" border="0" bgcolor="'.$kolor_tabeli.'"><tr align="center" class="text_duzy">';
	echo '<td>';
		echo 'Data '.$wyraz_poczatkowa.' - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_poczatkowa" id="f_data_poczatkowa" value="'.$data_poczatkowa.'">';
		echo '</td><td>Data '.$wyraz_koncowa.' - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_koncowa" id="f_data_koncowa" value="'.$data_koncowa.'">';
	echo '<td align="center"><input type="submit" name="pokaz" value="Pokaż" class="button_produkcja_mniejszy"></td>';
	echo '<td align="center"><a href="index.php?page=analiza_wydajnosc_produkcji"><input type="button" value="Reset" class="button_produkcja_mniejszy"></a></td>';
	echo '</tr></table>';
echo '</form>';

?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_data_poczatkowa",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_data_poczatkowa",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_data_koncowa",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_data_koncowa",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
<?php


$WARUNEK = '';
$WARUNEK_ZAM = '';
if($data_poczatkowa != '')
	{
	if($WARUNEK == "") $WARUNEK = 'data_wykonania >= "'.$data_poczatkowa_time.'" AND ';
	else $WARUNEK .= ' data_wykonania >= "'.$data_poczatkowa_time.'" AND ';
	if($WARUNEK_ZAM == "") $WARUNEK_ZAM = 'data_wykonania >= "'.$data_poczatkowa_time.'" AND ';
	else $WARUNEK_ZAM .= ' data_wykonania >= "'.$data_poczatkowa_time.'" AND ';
	}   
	       
if($data_koncowa != '')
	{
	if($WARUNEK == "") $WARUNEK = 'data_wykonania <= "'.$data_koncowa_time.'" AND ';
	else $WARUNEK .= ' data_wykonania <= "'.$data_koncowa_time.'" AND ';
	if($WARUNEK_ZAM == "") $WARUNEK_ZAM = 'data_wykonania <= "'.$data_koncowa_time.'"';
	else $WARUNEK_ZAM .= ' data_wykonania <= "'.$data_koncowa_time.'"';
	}          


$ilosc_pracownikow=0;
$pytanie1 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' AND aktywny = 'on' ORDER BY ID ASC");
while($wynik1= mysqli_fetch_assoc($pytanie1))
	{
	$ilosc_pracownikow++;
	$uzytk_id[$ilosc_pracownikow]=$wynik1['id'];
	$IMIE[$ilosc_pracownikow]=$wynik1['imie'];
	$NAZWISKO[$ilosc_pracownikow]=$wynik1['nazwisko'];
	$ilosc_dni_roboczych[$uzytk_id[$ilosc_pracownikow]] = 0;
	}

//zerujemy wszystkie dni kalendarzowe dla kazdego pracownika
for ($a=1; $a<=$ilosc_pracownikow; $a++) 
	for ($r=2016; $r<=$AKTUALNY_ROK; $r++)
		for ($m=1; $m<=12; $m++)
			for ($d=1; $d<=31; $d++) $TABELA_DNI_ROBOCZYCH[$uzytk_id[$a]][$d][$m][$r] = 0;

$SUMA_0_PRACOWNIK = [];
$SUMA_1_PRACOWNIK = [];
$SUMA_2_PRACOWNIK = [];
$SUMA_3_PRACOWNIK = [];
$SUMA_4_PRACOWNIK = [];
$SUMA_5_PRACOWNIK = [];
$SUMA_6_PRACOWNIK = [];
$SUMA_7_PRACOWNIK = [];
$SUMA_8_PRACOWNIK = [];
$SUMA_9_PRACOWNIK = [];
$SUMA_10_PRACOWNIK = [];

for ($a=1; $a<=$ilosc_pracownikow; $a++) 
	{
	$SUMA_PRACOWNIK[$uzytk_id[$a]] = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE ".$WARUNEK." (pracownik_a = ".$uzytk_id[$a]." OR pracownik_b = ".$uzytk_id[$a]." OR pracownik_c = ".$uzytk_id[$a]." OR pracownik_d = ".$uzytk_id[$a].");");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$rodzaj_produktu=$wynik['rodzaj_produktu'];
		
		//sprawdzamy w ktore dni pracownik dokonal wpisu
		$dzien = $wynik['data_wykonania_dzien'];
		$miesiac = $wynik['data_wykonania_miesiac'];
		$rok = $wynik['data_wykonania_rok'];
		$TABELA_DNI_ROBOCZYCH[$uzytk_id[$a]][$dzien][$miesiac][$rok] = 1;
		$ilosc=$wynik['ilosc'];
		if($rodzaj_produktu == 0) $SUMA_0_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 1) $SUMA_1_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 2) $SUMA_2_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 3) $SUMA_3_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 4) $SUMA_4_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 5) $SUMA_5_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 6) $SUMA_6_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 7) $SUMA_7_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 8) $SUMA_8_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 9) $SUMA_9_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 10) $SUMA_10_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 11) $SUMA_11_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		}

	
	}
//liczmy dla pracownikow dni robocze w miesiacu
for ($a=1; $a<=$ilosc_pracownikow; $a++) 
	for ($r=2016; $r<=$AKTUALNY_ROK; $r++)
		for ($m=1; $m<=12; $m++)
			for ($d=1; $d<=31; $d++) if($TABELA_DNI_ROBOCZYCH[$uzytk_id[$a]][$d][$m][$r] == 1) $ilosc_dni_roboczych[$uzytk_id[$a]]++;
	
	
	

echo '<table width="80%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td>'.$wyraz_Imie.' i Nazwisko</td>';
echo '<td>'.$wyraz_Ilosc.' dni roboczych</td>';
for ($x=0; $x<=$dl_lista_produktow; $x++) echo '<td width="7%">'.$TABELA_LISTA_PRODUKTOW[$x].'</td>';
echo '</tr>';
	
for ($x=1; $x<=$ilosc_pracownikow; $x++)
	{
	if($ilosc_dni_roboczych[$uzytk_id[$x]] != 0) 
		{
		if(isset($SUMA_0_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_0_PRACOWNIK[$uzytk_id[$x]] = $SUMA_0_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_0_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_0_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_0_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_0_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_0_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_0_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}

		if(isset($SUMA_1_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_1_PRACOWNIK[$uzytk_id[$x]] = $SUMA_1_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_1_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_1_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_1_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_1_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_1_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_1_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}
		if(isset($SUMA_3_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_3_PRACOWNIK[$uzytk_id[$x]] = $SUMA_3_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_3_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_3_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_3_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_3_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_3_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_3_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}
		
		if(isset($SUMA_4_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_4_PRACOWNIK[$uzytk_id[$x]] = $SUMA_4_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_4_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_4_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_4_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_4_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_4_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_4_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}
			
		if(isset($SUMA_5_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_5_PRACOWNIK[$uzytk_id[$x]] = $SUMA_5_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_5_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_5_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_5_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_5_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_5_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_5_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}

		if(isset($SUMA_10_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_10_PRACOWNIK[$uzytk_id[$x]] = $SUMA_10_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_10_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_10_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_10_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_10_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_10_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_10_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}

		if(isset($SUMA_11_PRACOWNIK[$uzytk_id[$x]])) 
			{
			$SREDNIA_11_PRACOWNIK[$uzytk_id[$x]] = $SUMA_11_PRACOWNIK[$uzytk_id[$x]]/$ilosc_dni_roboczych[$uzytk_id[$x]];
			$SREDNIA_11_PRACOWNIK[$uzytk_id[$x]] = number_format($SREDNIA_11_PRACOWNIK[$uzytk_id[$x]], 2,'.','');
			if($SUMA_11_PRACOWNIK[$uzytk_id[$x]] != '') $SREDNIA_11_PRACOWNIK_OPIS[$uzytk_id[$x]] = ' ('.$SREDNIA_11_PRACOWNIK[$uzytk_id[$x]].')'; else $SREDNIA_11_PRACOWNIK_OPIS[$uzytk_id[$x]] = '';
			}
		}
		
	echo '<tr align="center" class="text_zmienny" bgcolor="'.$kolor_bialy.'" height="50px">';
	echo '<td align="center">'.$IMIE[$x].' '.$NAZWISKO[$x].'</td>';
	echo '<td align="center">'.$ilosc_dni_roboczych[$uzytk_id[$x]].'</td>';
	echo '<td align="center">';
	if(isset($SUMA_0_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_0_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_0_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_0_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_1_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_1_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_1_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_1_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_2_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_2_PRACOWNIK[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_3_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_3_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_3_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_3_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_4_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_4_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_4_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_4_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_5_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_5_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_5_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_5_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_6_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_6_PRACOWNIK[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_7_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_7_PRACOWNIK[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_8_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_8_PRACOWNIK[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_9_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_9_PRACOWNIK[$uzytk_id[$x]];
	echo '</td>';
	echo '<td align="center">';
	if(isset($SUMA_10_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_10_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_10_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_10_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td>';	
	echo '<td align="center">';
	if(isset($SUMA_11_PRACOWNIK[$uzytk_id[$x]])) echo $SUMA_11_PRACOWNIK[$uzytk_id[$x]];
	if(isset($SREDNIA_11_PRACOWNIK_OPIS[$uzytk_id[$x]])) echo $SREDNIA_11_PRACOWNIK_OPIS[$uzytk_id[$x]];
	echo '</td></tr>';
	}
echo '</table><br><br><br>';


?>