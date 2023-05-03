<?php
$warunek = "";
$SORTOWANIE_DIV = '';

if($SORT_SYSTEM != "") 
	{
	if($warunek == "") $warunek .= 'WHERE system = "'.$SORT_SYSTEM.'"';
	else $warunek .= ' AND system = "'.$SORT_SYSTEM.'"';
	$SORTOWANIE_DIV .= '&SORT_SYSTEM='.$SORT_SYSTEM;
	}          

if($SORT_ELEMENT != "") 
	{
	if($warunek == "") $warunek .= 'WHERE element = "'.$SORT_ELEMENT.'"';
	else $warunek .= ' AND element = "'.$SORT_ELEMENT.'"';
	$SORTOWANIE_DIV .= '&SORT_ELEMENT='.$SORT_ELEMENT;
	}          
	
if($SORT_KOLOR != "") 
	{
	if($warunek == "") $warunek .= 'WHERE kolor = "'.$SORT_KOLOR.'"';
	else $warunek .= ' AND kolor = "'.$SORT_KOLOR.'"';
	$SORTOWANIE_DIV .= '&SORT_KOLOR='.$SORT_KOLOR;
	}          

if($SORT_KOLOR_USZCZELEK != "") 
	{
	if($warunek == "") $warunek .= 'WHERE uszczelka = "'.$SORT_KOLOR_USZCZELEK.'"';
	else $warunek .= ' AND uszczelka = "'.$SORT_KOLOR_USZCZELEK.'"';
	$SORTOWANIE_DIV .= '&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK;
	}          

if($SORT_SYMBOL_PROFILU != "") 
	{
	if($warunek == "") $warunek .= 'WHERE symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	else $warunek .= ' AND symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	$SORTOWANIE_DIV .= '&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU;
	}          

if($SORT_SYMBOL_KOLORU != "") 
	{
	if($warunek == "") $warunek .= 'WHERE symbol_koloru = "'.$SORT_SYMBOL_KOLORU.'"';
	else $warunek .= ' AND symbol_koloru = "'.$SORT_SYMBOL_KOLORU.'"';
	$SORTOWANIE_DIV .= '&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU;
	}          

$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'kurs_euro'");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$kurs_euro=$wynik['opis'];
	}
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'marza_magazynu'");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$marza_magazynu=$wynik['opis'];
	}
	

	$id = [];
	$system = [];
	$element = [];
	$kolor_profili = [];
	$kolor_uszczelek = [];
	$symbol_profilu = [];
	$symbol_koloru = [];
	$ilosc = [];
	$jednostka = [];
	$cena_netto_zakupu_eu = [];
	$cena_netto_zakupu_zl = [];
	$wartosc_netto_zl = 0;
		
$SUMA_WARTOSC_NETTO = 0;
$i = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM magazyn ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$system[$i]=$wynik['system'];
	$element[$i]=$wynik['element'];
	$kolor_profili[$i]=$wynik['kolor'];
	$kolor_uszczelek[$i]=$wynik['uszczelka'];
	$symbol_profilu[$i]=$wynik['symbol_profilu'];
	$symbol_koloru[$i]=$wynik['symbol_koloru'];
	$ilosc[$i]=$wynik['ilosc'];
	$jednostka[$i]=$wynik['jednostka'];
	$cena_netto_zakupu_eu[$i]=$wynik['cena_netto_zakupu_eu'];
	$cena_netto_zakupu_zl[$i]=$wynik['cena_netto_zakupu_zl'];
	$wartosc_netto_zl[$i] = $cena_netto_zakupu_zl[$i] * $ilosc[$i];
	$SUMA_WARTOSC_NETTO += $wartosc_netto_zl[$i];
	
	$cena_netto_zakupu_eu[$i] = number_format($cena_netto_zakupu_eu[$i], 2,'.','');
	$cena_netto_zakupu_zl[$i] = number_format($cena_netto_zakupu_zl[$i], 2,'.','');
	$wartosc_netto_zl[$i] = number_format($wartosc_netto_zl[$i], 2,'.',' ');
	}

$symbol_koloru2 = array_unique($symbol_koloru);
$symbol_koloru_opis = array_values(array_filter($symbol_koloru2));
sort ($symbol_koloru_opis);
$ilosc_symboli_koloru = count($symbol_koloru_opis);

$system2 = array_unique($system);
$system_opis = array_values(array_filter($system2));
sort ($system_opis);
$ilosc_systemow = count($system_opis);

$element2 = array_unique($element);
$element_opis = array_values(array_filter($element2));
sort ($element_opis);
$ilosc_elementow = count($element_opis);

$kolor_profili2 = array_unique($kolor_profili);
$kolor_opis = array_values(array_filter($kolor_profili2));
sort ($kolor_opis);
$ilosc_kolorow = count($kolor_opis);

$kolor_uszczelek2 = array_unique($kolor_uszczelek);
$kolor_uszczelek_opis = array_values(array_filter($kolor_uszczelek2));
sort ($kolor_uszczelek_opis);
$ilosc_kolor_uszczelek = count($kolor_uszczelek_opis);

$symbol_profilu2 = array_unique($symbol_profilu);
$symbol_profilu_opis = array_values(array_filter($symbol_profilu2));
sort ($symbol_profilu_opis);
$ilosc_symboli_profili = count($symbol_profilu_opis);

/*
$ilosc_systemow = -1;
$result = mysql_query("SELECT DISTINCT system FROM magazyn ORDER BY id ASC");
while ($a_row = mysql_fetch_array ($result) )
	{
	if($a_row[system] != '')
		{
		$ilosc_systemow++;
		$system_opis[$ilosc_systemow] = $a_row[system];
		}
	}
sort ($system_opis);
	
$ilosc_kolorow = -1;
$result = mysql_query("SELECT DISTINCT kolor FROM magazyn ORDER BY id ASC");
while ($a_row = mysql_fetch_array ($result) )
	{
	if($a_row[kolor] != '')
		{
		$ilosc_kolorow++;
		$kolor_opis[$ilosc_kolorow] = $a_row[kolor];
		}
	}
sort ($kolor_opis);

$ilosc_kolor_uszczelek = -1;
$result = mysql_query("SELECT DISTINCT uszczelka FROM magazyn ORDER BY id ASC");
while ($a_row = mysql_fetch_array ($result) )
	{
	if($a_row[uszczelka] != '')
		{
		$ilosc_kolor_uszczelek++;
		$kolor_uszczelek_opis[$ilosc_kolor_uszczelek] = $a_row[uszczelka];
		}
	}
sort ($kolor_uszczelek_opis);

$ilosc_symboli_profili = -1;
$result = mysql_query("SELECT DISTINCT symbol_profilu FROM magazyn ORDER BY id ASC");
while ($a_row = mysql_fetch_array ($result) )
	{
	if($a_row[symbol_profilu] != '')
		{
		$ilosc_symboli_profili++;
		$symbol_profilu_opis[$ilosc_symboli_profili] = $a_row[symbol_profilu];
		}
	}
sort ($symbol_profilu_opis);

$ilosc_symboli_koloru = -1;
$result = mysql_query("SELECT DISTINCT symbol_koloru FROM magazyn ORDER BY id ASC");
while ($a_row = mysql_fetch_array ($result) )
	{
	if($a_row[symbol_koloru] != '')
		{
		$ilosc_symboli_koloru++;
		$symbol_koloru_opis[$ilosc_symboli_koloru] = $a_row[symbol_koloru];
		}
	}
sort ($symbol_koloru_opis);

$ilosc_elementow = -1;
$result = mysql_query("SELECT DISTINCT element FROM magazyn ORDER BY id ASC");
while ($a_row = mysql_fetch_array ($result) )
	{
	if($a_row[element] != '')
		{
		$ilosc_elementow++;
		$element_opis[$ilosc_elementow] = $a_row[element];
		}
	}
sort ($element_opis);
*/

$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'kurs_euro';");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$kurs_euro=$wynik['opis'];
	}
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'marza_magazynu';");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$marza_magazynu=$wynik['opis'];
	}



echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="'.$page.'">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
echo '<input type="hidden" name="pokaz" value="1">';    
echo '<input type="hidden" name="etap" value="'.$etap.'">';                                
echo '<input type="hidden" name="naglowek" value="NIE">';     
echo '<input type="hidden" name="nowy_numer_zamowienia" value="'.$nowy_numer_zamowienia.'">';                                
echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';                                
                           
$SORTOWANIE_DIV .= '&naglowek=NIE&pokaz='.$pokaz.'&etap='.$etap.'&klient='.$klient.'&nowy_numer_zamowienia='.$nowy_numer_zamowienia.'&zamowienie_id='.$zamowienie_id.'';

echo '<table class="tabela" align="left"><tr valign="middle" align="center" bgcolor="'.$kolor_tabeli.'" class="text" >';
if($pokaz == 1) echo '<td '.$rowspan.' width="10px" valign="middle">'.$kol_lp.'<br>'.$i.'<br><a href="index.php?page='.$page.'&jak='.$jak.'&wg_czego='.$wg_czego.'&naglowek=NIE&pokaz='.$pokaz.'&etap='.$etap.'&klient='.$klient.'&nowy_numer_zamowienia='.$nowy_numer_zamowienia.'&zamowienie_id='.$zamowienie_id.'&SORT_SYSTEM&SORT_ELEMENT&SORT_KOLOR&SORT_KOLOR_USZCZELEK&SORT_SYMBOL_PROFILU">'.$image_close.'</a></td>';
else echo '<td '.$rowspan.' width="10px" valign="middle">'.$kol_lp.'<br>'.$i.'</td>';

echo '<td width="150px">'.$kol_system.'<div align="right"><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=system&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=system&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_SYSTEM" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_systemow-1; $k++) 
			if ($system_opis[$k] == $SORT_SYSTEM) echo '<option value="'.$system_opis[$k].'" selected="selected">'.$system_opis[$k].'</option>';
			else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="150px">'.$kol_element.'<div align="right"><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=element&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=element&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_ELEMENT" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_elementow-1; $k++) 
			if ($element_opis[$k] == $SORT_ELEMENT) echo '<option value="'.$element_opis[$k].'" selected="selected">'.$element_opis[$k].'</option>';
			else echo '<option value="'.$element_opis[$k].'">'.$element_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="150px">'.$kol_kolor.'<div align="right"><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=kolor&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=kolor&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_KOLOR" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_kolorow-1; $k++) 
			if ($kolor_opis[$k] == $SORT_KOLOR) echo '<option value="'.$kolor_opis[$k].'" selected="selected">'.$kolor_opis[$k].'</option>';
			else echo '<option value="'.$kolor_opis[$k].'">'.$kolor_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="150px">'.$kol_uszczelka.'<div align="right"><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=uszczelka&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=uszczelka&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_KOLOR_USZCZELEK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_kolor_uszczelek-1; $k++) 
			if ($kolor_uszczelek_opis[$k] == $SORT_KOLOR_USZCZELEK) echo '<option value="'.$kolor_uszczelek_opis[$k].'" selected="selected">'.$kolor_uszczelek_opis[$k].'</option>';
			else echo '<option value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="150px">'.$kol_symbol_profilu.'<div align="right"><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=symbol_profilu&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=symbol_profilu&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_SYMBOL_PROFILU" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_symboli_profili-1; $k++) 
			if ($symbol_profilu_opis[$k] == $SORT_SYMBOL_PROFILU) echo '<option value="'.$symbol_profilu_opis[$k].'" selected="selected">'.$symbol_profilu_opis[$k].'</option>';
			else echo '<option value="'.$symbol_profilu_opis[$k].'">'.$symbol_profilu_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="150px">'.$kol_symbol_koloru.'<div align="right"><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=symbol_koloru&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page='.$page.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=symbol_koloru&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_SYMBOL_KOLORU" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_symboli_koloru-1; $k++) 
			if ($symbol_koloru_opis[$k] == $SORT_SYMBOL_KOLORU) echo '<option value="'.$symbol_koloru_opis[$k].'" selected="selected">'.$symbol_koloru_opis[$k].'</option>';
			else echo '<option value="'.$symbol_koloru_opis[$k].'">'.$symbol_koloru_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="100px">'.$kol_ilosc_na_magazynie.'</td>';
echo '<td width="150px">Ilość do zamówienia</td>';
//echo '<td width="100px">'.$kol_cena_netto_zakupu_eu.'</td>';
echo '<td width="100px">'.$kol_cena_netto_zakupu_zl.'</td>';
//echo '<td width="100px">'.$kol_cena_netto_sprzedazy_eu.'</td>';
//echo '<td width="100px">'.$kol_cena_netto_sprzedazy_zl.'</td>';
echo '<td width="120px">'.$kol_wartosc_netto_zl.'</td>';
echo '</tr>';
echo '</form>';

echo '<FORM action="index.php?page='.$page.'" method="post">';
echo '<input type="hidden" name="SORT_SYSTEM" value="'.$SORT_SYSTEM.'">';
echo '<input type="hidden" name="SORT_ELEMENT" value="'.$SORT_ELEMENT.'">';
echo '<input type="hidden" name="SORT_KOLOR" value="'.$SORT_KOLOR.'">';
echo '<input type="hidden" name="SORT_SYMBOL_KOLORU" value="'.$SORT_SYMBOL_KOLORU.'">';
echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="'.$SORT_SYMBOL_PROFILU.'">';
echo '<input type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';

echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
echo '<input type="hidden" name="klient" value="'.$klient.'">';
echo '<input type="hidden" name="etap" value="'.$etap.'">';
echo '<input type="hidden" name="nowy_numer_zamowienia" value="'.$nowy_numer_zamowienia.'">';

echo '<input type="hidden" name="pokaz" value="'.$pokaz.'">';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td class="text" bgcolor="'.$kolor_tabeli.'">'.$x.'</td>'; 
		if($system[$x] == '') $system[$x] = 'BRAK';
		echo '<td><a href="index.php?page='.$page.'&SORT_SYSTEM='.$system[$x].$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz=1">'.$system[$x].'</a></td>';
		echo '<td><a href="index.php?page='.$page.'&SORT_ELEMENT='.$element[$x].$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz=1">'.$element[$x].'</a></td>';
		echo '<td><a href="index.php?page='.$page.'&SORT_KOLOR='.$kolor_profili[$x].$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz=1">'.$kolor_profili[$x].'</a></td>';
		echo '<td><a href="index.php?page='.$page.'&SORT_KOLOR_USZCZELEK='.$kolor_uszczelek[$x].$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz=1">'.$kolor_uszczelek[$x].'</a></td>';
		echo '<td><a href="index.php?page='.$page.'&SORT_SYMBOL_PROFILU='.$symbol_profilu[$x].$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz=1">'.$symbol_profilu[$x].'</a></td>';
		echo '<td><a href="index.php?page='.$page.'&SORT_SYMBOL_KOLORU='.$symbol_koloru[$x].$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz=1">'.$symbol_koloru[$x].'</a></td>';
		echo '<td align="right">'.$ilosc[$x].' '.$jednostka[$x].'</td>';
		$nazwa_ilosc_do_zamowienia = 'nazwa_ilosc_do_zamowienia['.$id[$x].']';
		echo '<td align="right"><INPUT type="text" size="2" class="pole_input_biale" autocomplete="off" name="'.$nazwa_ilosc_do_zamowienia.'"><INPUT type="submit" name="Dodaj" value="Dodaj"></td>';
		
		//echo '<td align="right">'.$cena_netto_zakupu_eu[$x].'</td>';
		echo '<td align="right">'.$cena_netto_zakupu_zl[$x].'</td>';
		//echo '<td align="right">'.$cena_netto_sprzedazy_eu[$x].'</td>';
		//echo '<td align="right">'.$cena_netto_sprzedazy_zl[$x].'</td>';
		echo '<td align="right">'.$wartosc_netto_zl[$x].'</td>';
		echo '</tr>';
		}
		
echo '</table>';
echo '</form>';
?>