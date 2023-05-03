<style type="text/css">
	a:link {
		color: #000000;
		font-weight: Bold;
		font-family: arial;
		text-decoration: none;
		font-size: 12px;
	}

	a:visited {
		color: #000000;
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

	input.produkcja_checkbox {
		/* Double-sized Checkboxes */
		-ms-transform: scale(3);
		/* IE */
		-moz-transform: scale(3);
		/* FF */
		-webkit-transform: scale(3);
		/* Safari and Chrome */
		-o-transform: scale(3);
		/* Opera */
		padding: 100px;

	}

	input.button_produkcja {
		width: 300px;
		height: 300px;
		font: Arial, Helvetica, sans-serif;
		font-size: 36px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_maly {
		width: 200px;
		height: 200px;
		font: Arial, Helvetica, sans-serif;
		font-size: 24px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_mniejszy {
		width: 150px;
		height: 50px;
		font: Arial, Helvetica, sans-serif;
		font-size: 30px;
		font-weight: Bold;
		white-space: normal;
	}


	input.button_zapisz_produkcja {
		width: 150px;
		height: 100px;
		font: Arial, Helvetica, sans-serif;
		font-size: 36px;
		font-weight: Bold;
		white-space: normal;
	}

	.pole_input_produkcja {
		width: 100%;
		height: 40px;
		border: #000000 1px solid;
		background-color: #e24139;
		color: #000000;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 22px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}

	.pole_input_produkcja_kalendarz {
		height: 60px;
		border: #000000 1px solid;
		background-color: #e24139;
		color: #000000;
		text-align: center;
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

echo '<FORM action="index.php?page=realizacja_produkcji_zamowienia_wykonane" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';

	echo '<table align="center" cellspacing="5" cellpadding="5" border="0" bgcolor="'.$kolor_tabeli.'"><tr align="center" class="text_duzy">';
	echo '<td>';
		echo 'Data początkowa - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_poczatkowa" id="f_data_poczatkowa" value="'.$data_poczatkowa.'">';
		echo '</td><td>Data końcowa - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_koncowa" id="f_data_koncowa" value="'.$data_koncowa.'">';
	echo '<td align="center"><input type="submit" name="pokaz" value="Pokaż" class="button_produkcja_mniejszy"></td>';
	echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_wykonane"><input type="button" value="Reset" class="button_produkcja_mniejszy"></a></td>';
	echo '</tr></table>';
echo '</form>';

?>
<script type="text/javascript">
Calendar.setup({
    inputField: "f_data_poczatkowa", // id of the input field
    ifFormat: "%d-%m-%Y", // format of the input field
    button: "f_data_poczatkowa", // trigger for the calendar (button ID)
    singleClick: true
});
</script>
<script type="text/javascript">
Calendar.setup({
    inputField: "f_data_koncowa", // id of the input field
    ifFormat: "%d-%m-%Y", // format of the input field
    button: "f_data_koncowa", // trigger for the calendar (button ID)
    singleClick: true
});
</script>
<?php

	
$WARUNEK = '';
$WARUNEK_ZAM = '';
if($data_poczatkowa != '')
	{
	if ($WARUNEK == "") $WARUNEK = 'data_wykonania >= "' . $data_poczatkowa_time . '" AND ';
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
$uzytk_id =[];
$IMIE =[];
$NAZWISKO =[];
$SUMA_PRACOWNIK =[];
$pytanie1 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' AND aktywny = 'on' ORDER BY ID ASC;");
while($wynik1= mysqli_fetch_assoc($pytanie1))
	{
	$ilosc_pracownikow++;
	$uzytk_id[$ilosc_pracownikow]=$wynik1['id'];
	$IMIE[$ilosc_pracownikow]=$wynik1['imie'];
	$NAZWISKO[$ilosc_pracownikow]=$wynik1['nazwisko'];
	}

//echo '<br>Warunek - '.$WARUNEK.'<br>';
for ($a=1; $a<=$ilosc_pracownikow; $a++) 
	{
	$SUMA_PRACOWNIK[$uzytk_id[$a]] = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE ".$WARUNEK." (pracownik_a = ".$uzytk_id[$a]." OR pracownik_b = ".$uzytk_id[$a]." OR pracownik_c = ".$uzytk_id[$a]." OR pracownik_d = ".$uzytk_id[$a].");");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$rodzaj_produktu=$wynik['rodzaj_produktu'];
		$ilosc=$wynik['ilosc'];
		if($rodzaj_produktu == 1) $SUMA_1_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 2) $SUMA_2_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 3) $SUMA_3_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 4) $SUMA_4_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 5) $SUMA_5_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 6) $SUMA_6_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 7) $SUMA_7_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 8) $SUMA_8_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 9) $SUMA_9_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 0) $SUMA_0_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 10) $SUMA_10_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		if($rodzaj_produktu == 11) $SUMA_11_PRACOWNIK[$uzytk_id[$a]] += $ilosc;
		}
	}

echo '<table width="80%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td>Imię i Nazwisko</td>';

//wyswietlanie nazw kolumn
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[0].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[1].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[2].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[3].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[4].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[5].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[6].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[7].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[11].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[8].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[9].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[10].'</td>';


echo '</tr>';
	
for ($x=1; $x<=$ilosc_pracownikow; $x++)
	{
	echo '<tr align="center" class="text_zmienny" bgcolor="'.$kolor_bialy.'">';
	echo '<td align="center">'.$IMIE[$x].' '.$NAZWISKO[$x].'</td>';
	echo '<td align="center">'.$SUMA_0_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_1_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_2_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_3_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_4_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_5_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_6_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_7_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_11_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_8_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_9_PRACOWNIK[$uzytk_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_10_PRACOWNIK[$uzytk_id[$x]].'</td></tr>';
	}
echo '</table><br><br><br>';

//echo 'WARUNEK_ZAM='.$WARUNEK_ZAM.'<br>';
$ilosc_zamowien = 0;
$klient_nazwa = [];
$nr_zamowienia = [];
$zamowienie_id = [];
$pozycja = [];

$pytanie66 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM realizacja_produkcji WHERE ".$WARUNEK_ZAM." ORDER BY id DESC;");
while($wynik66= mysqli_fetch_assoc($pytanie66))
	{
	$ilosc_zamowien++;
	$zamowienie_id_temp = $wynik66['zamowienie_id'];
	$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE ".$WARUNEK_ZAM." AND zamowienie_id=".$zamowienie_id_temp.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$zamowienie_id[$ilosc_zamowien]=$wynik['zamowienie_id'];
		$temp = $wynik['zamowienie_id'];
		$pozycja[$ilosc_zamowien]=$wynik['pozycja'];
		$rodzaj_produktu=$wynik['rodzaj_produktu'];
		$ilosc=$wynik['ilosc'];
		
		if($rodzaj_produktu == 1) $SUMA_1_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 2) $SUMA_2_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 3) $SUMA_3_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 4) $SUMA_4_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 5) $SUMA_5_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 6) $SUMA_6_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 7) $SUMA_7_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 8) $SUMA_8_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 9) $SUMA_9_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 0) $SUMA_0_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 10) $SUMA_10_ZAMOWIENIE[$temp] += $ilosc;
		if($rodzaj_produktu == 11) $SUMA_11_ZAMOWIENIE[$temp] += $ilosc;
		}
	}

echo '<table width="80%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td>Nr / pozycja zamówienia</td>';
echo '<td width="15%">Klient</td>';

//wyswietlanie nazw kolumn
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[0].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[1].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[2].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[3].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[4].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[5].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[6].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[7].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[11].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[8].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[9].'</td>';
echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[10].'</td>';


echo '</tr>';
for ($x=1; $x<=$ilosc_zamowien; $x++)
	{
	echo '<tr align="center" class="text_zmienny" bgcolor="'.$kolor_bialy.'">';
	
	$pytanie77 = mysqli_query($conn, "SELECT nr_zamowienia, klient_nazwa FROM zamowienia WHERE id = ".$zamowienie_id[$x].";");
	while($wynik77= mysqli_fetch_assoc($pytanie77))
		{
		$klient_nazwa[$x]=$wynik77['klient_nazwa'];
		$nr_zamowienia[$x]=$wynik77['nr_zamowienia'];
		}	
	
	echo '<td>'.$nr_zamowienia[$x].'</td>';
	echo '<td>'.$klient_nazwa[$x].'</td>';
	echo '<td align="center">'.$SUMA_0_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_1_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_2_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_3_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_4_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_5_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_6_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_7_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_11_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_8_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_9_ZAMOWIENIE[$zamowienie_id[$x]].'</td>';
	echo '<td align="center">'.$SUMA_10_ZAMOWIENIE[$zamowienie_id[$x]].'</td></tr>';
	
	$SUMA_ZAMOWIENIE[1] += $SUMA_1_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[2] += $SUMA_2_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[3] += $SUMA_3_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[4] += $SUMA_4_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[5] += $SUMA_5_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[6] += $SUMA_6_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[7] += $SUMA_7_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[8] += $SUMA_8_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[9] += $SUMA_9_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[10] += $SUMA_10_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[11] += $SUMA_11_ZAMOWIENIE[$zamowienie_id[$x]];
	$SUMA_ZAMOWIENIE[0] += $SUMA_0_ZAMOWIENIE[$zamowienie_id[$x]];
	}
echo '<tr align="center" class="text" bgcolor="'.$kolor_tabeli.'">';
echo '<td align="right" colspan="2">SUMA >>> </td>';

echo '<td>'.$SUMA_ZAMOWIENIE[0].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[1].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[2].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[3].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[4].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[5].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[6].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[7].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[11].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[8].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[9].'</td>';
echo '<td>'.$SUMA_ZAMOWIENIE[10].'</td>';

echo '</tr></table>';

?>