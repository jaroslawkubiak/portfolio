<?php
if($submit)
	{
	if((($system == '') && ($nowy_system == '')) || (($element == '') && ($nowy_element == '')) || (($kolor == '') && ($nowy_kolor == '')) || (($uszczelka == '') && ($nowa_uszczelka == '')) || (($symbol_profilu == '') && ($nowy_symbol_profilu == ''))) 
	{
		echo '<div class="text_red" align="center">Wybierz wszystkie niezbędne opcje!</div>';
		$submit = False;
	}
	elseif(($cena_netto_zakupu_eu == '') && ($cena_netto_zakupu_zl == '')) echo '<div class="text_red" align="center">Podaj cenę!</div>';
	else
		{
		$result = True;
		$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'kurs_euro';");
		while($wynik= mysqli_fetch_assoc($pytanie))
			$kurs_euro=$wynik['opis'];
			
		$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'marza_magazynu';");
		while($wynik= mysqli_fetch_assoc($pytanie))
			$marza_magazynu=$wynik['opis'];

		echo '<div class="text_duzy_niebieski" align="center">Pozycja została dodana</div>';
				
		if($nowy_system != '') $system = $nowy_system;
		if($nowy_element != '') $element = $nowy_element;
		if($nowy_kolor != '') $kolor = $nowy_kolor;
		if($nowa_uszczelka != '') $uszczelka = $nowa_uszczelka;
		if($nowy_symbol_profilu != '') $symbol_profilu = $nowy_symbol_profilu;
		if($nowy_symbol_koloru != '') $symbol_koloru = $nowy_symbol_koloru;
	
	//($system == '') || ($element == '') || ($kolor == '') || ($uszczelka == '') || ($symbol_profilu == '') || ($symbol_koloru == '') || ($symbol_koloru == '')
	
		$ilosc = change($ilosc);
		$cena_netto_zakupu_eu = change($cena_netto_zakupu_eu);
		$cena_netto_zakupu_zl = change($cena_netto_zakupu_zl);
	
		if($cena_netto_zakupu_eu != 0) 
			{
			$cena_netto_zakupu_zl = $cena_netto_zakupu_eu * $kurs_euro;
			$cena_netto_sprzedazy_eu = $cena_netto_zakupu_eu + (($cena_netto_zakupu_eu * $marza_magazynu)/100);

			}
		$cena_netto_sprzedazy_zl = $cena_netto_zakupu_zl + (($cena_netto_zakupu_zl * $marza_magazynu)/100);
		$cena_netto_sprzedazy_zl = change($cena_netto_sprzedazy_zl);
		$cena_netto_sprzedazy_eu = change($cena_netto_sprzedazy_eu);
		$cena_netto_zakupu_eu = change($cena_netto_zakupu_eu);
		$cena_netto_zakupu_zl = change($cena_netto_zakupu_zl);
		
		// echo 'cena_netto_zakupu_zl='.$cena_netto_zakupu_zl.'<br>';
		if($klient == '') $klient = 0;

		$query =  "INSERT INTO magazyn (`system`, `element`, `kolor`, `uszczelka`, `symbol_profilu`, `symbol_koloru`, `ilosc`, `cena_netto_zakupu_eu`, `cena_netto_zakupu_zl`, `cena_netto_sprzedazy_eu`, `cena_netto_sprzedazy_zl`, `jednostka`, `klient_id`) values ('$system', '$element', '$kolor', '$uszczelka', '$symbol_profilu', '$symbol_koloru', '$ilosc', '$cena_netto_zakupu_eu', '$cena_netto_zakupu_zl', '$cena_netto_sprzedazy_eu', '$cena_netto_sprzedazy_zl', '$jednostka', '$klient');";
		mysqli_query($conn, $query);
		echo $powrot_do_magazynu;
		}
	}
	
	
	
	
if(!$submit)
{
$ilosc_systemow = -1;
$result = mysqli_query($conn, "SELECT DISTINCT system FROM magazyn ORDER BY id ASC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_systemow++;
	$system_opis[$ilosc_systemow] = $a_row['system'];
	}
sort ($system_opis);
	
$ilosc_kolorow = -1;
$result = mysqli_query($conn, "SELECT DISTINCT kolor FROM magazyn ORDER BY id ASC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_kolorow++;
	$kolor_opis[$ilosc_kolorow] = $a_row['kolor'];
	}
sort ($kolor_opis);

$ilosc_kolor_uszczelek = -1;
$result = mysqli_query($conn, "SELECT DISTINCT uszczelka FROM magazyn ORDER BY id ASC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_kolor_uszczelek++;
	$kolor_uszczelek_opis[$ilosc_kolor_uszczelek] = $a_row['uszczelka'];
	}
sort ($kolor_uszczelek_opis);

$ilosc_symboli_profili = -1;
$result = mysqli_query($conn, "SELECT DISTINCT symbol_profilu FROM magazyn ORDER BY id ASC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_symboli_profili++;
	$symbol_profilu_opis[$ilosc_symboli_profili] = $a_row['symbol_profilu'];
	}
sort ($symbol_profilu_opis);

$ilosc_symboli_koloru = -1;
$result = mysqli_query($conn, "SELECT DISTINCT symbol_koloru FROM magazyn ORDER BY id ASC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_symboli_koloru++;
	$symbol_koloru_opis[$ilosc_symboli_koloru] = $a_row['symbol_koloru'];
	}
sort ($symbol_koloru_opis);

$ilosc_elementow = -1;
$result = mysqli_query($conn, "SELECT DISTINCT element FROM magazyn ORDER BY id ASC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_elementow++;
	$element_opis[$ilosc_elementow] = $a_row['element'];
	}
sort ($element_opis);

$klient_nazwa =[];
$klient_id =[];
$ilosc_klientow = 0;
$pytanie2 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC;");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$ilosc_klientow++;
	$klient_nazwa[$ilosc_klientow]=$wynik2['nazwa'];
	$klient_id[$ilosc_klientow]=$wynik2['id'];
	}

echo '<div class="text_duzy" align="center">Dodaj nową pozycję magazynową</div>';

echo '<table width="600px" align="center" border="0" cellpadding="3" align="left"><tr><td width="90%" align="center" valign="top">';
echo '<FORM action="index.php?page=magazyn_dodaj_pozycje" method="post">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';

	echo '<table width=100% align="center" border="0" cellpadding=3>';
	
	// system
	echo '<tr align="center" class="text"><td align="right" width="30%">'.$kol_system_prolifi.' : </td><td align="left">';
	echo '<select name="system" class="pole_input" style="width: 200px" required="">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_systemow; $k++) 
	if($system == $system_opis[$k]) echo '<option value="'.$system_opis[$k].'" selected="selected">'.$system_opis[$k].'</option>';
	else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
	echo '</select></td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input" name="nowy_system" value="'.$nowy_system.'"></td></tr>';
	
	// element
	echo '<tr align="center" class="text"><td align="right">'.$kol_element.' : </td><td align="left">';
	echo '<select name="element" class="pole_input" style="width: 200px" required="">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_elementow; $k++) 
	if($element == $element_opis[$k]) echo '<option value="'.$element_opis[$k].'" selected="selected">'.$element_opis[$k].'</option>';
	else echo '<option value="'.$element_opis[$k].'">'.$element_opis[$k].'</option>';
	echo '</select></td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input" name="nowy_element" value="'.$nowy_element.'"></td></tr>';
	
	// kolor
	echo '<tr align="center" class="text"><td align="right">'.$kol_kolor.' : </td><td align="left">';
	echo '<select name="kolor" class="pole_input" style="width: 200px" required="">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_kolorow; $k++) 
	if($kolor == $kolor_opis[$k]) echo '<option value="'.$kolor_opis[$k].'" selected="selected">'.$kolor_opis[$k].'</option>';
	else echo '<option value="'.$kolor_opis[$k].'">'.$kolor_opis[$k].'</option>';
	echo '</select></td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input" name="nowy_kolor" value="'.$nowy_kolor.'"></td></tr>';
	
	// uszczelka
	echo '<tr align="center" class="text"><td align="right">'.$kol_kolor_uszczelek.' : </td><td align="left">';
	echo '<select name="uszczelka" class="pole_input" style="width: 200px" required="">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_kolor_uszczelek; $k++) 
	if($uszczelka == $kolor_uszczelek_opis[$k]) echo '<option value="'.$kolor_uszczelek_opis[$k].'" selected="selected">'.$kolor_uszczelek_opis[$k].'</option>';
	else echo '<option value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
	echo '</select></td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input" name="nowa_uszczelka" value="'.$nowa_uszczelka.'"></td></tr>';
	
	// symbol profilu
	echo '<tr align="center" class="text"><td align="right">'.$kol_symbol_profilu.' : </td><td align="left">';
	echo '<select name="symbol_profilu" class="pole_input" style="width: 200px" required="">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_symboli_profili; $k++) 
	if($symbol_profilu == $symbol_profilu_opis[$k]) echo '<option value="'.$symbol_profilu_opis[$k].'" selected="selected">'.$symbol_profilu_opis[$k].'</option>';
	else echo '<option value="'.$symbol_profilu_opis[$k].'">'.$symbol_profilu_opis[$k].'</option>';
	echo '</select></td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input" name="nowy_symbol_profilu" value="'.$nowy_symbol_profilu.'"></td></tr>';
	
	// symbol koloru
	echo '<tr align="center" class="text"><td align="right">'.$kol_symbol_koloru.' : </td><td align="left">';
	echo '<select name="symbol_koloru" class="pole_input" style="width: 200px">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_symboli_koloru; $k++) 
	if($symbol_koloru == $symbol_koloru_opis[$k]) echo '<option value="'.$symbol_koloru_opis[$k].'" selected="selected">'.$symbol_koloru_opis[$k].'</option>';
	else echo '<option value="'.$symbol_koloru_opis[$k].'">'.$symbol_koloru_opis[$k].'</option>';
	echo '</select></td><td>LUB</td><td align="left"><input autocomplete="off" type="text" size="20" maxlength="25" class="pole_input" name="nowy_symbol_koloru" value="'.$nowy_symbol_koloru.'"></td></tr>';
	
	echo '<tr align="center"><td align="right" class="text">'.$kol_ilosc.' : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="3" maxlength="10" class="pole_input" name="ilosc"></td></tr>';
	
	// jednostka
	echo '<tr align="center" class="text"><td align="right">'.$kol_jednostka.' : </td><td align="left">';
	echo '<select name="jednostka" class="pole_input" style="width: 50px">';
	if($jednostka == '') echo '<option value="m" selected="selected">m</option>';
	else echo '<option value="m">m</option>';
	echo '<option value="szt">szt</option>';
	echo '</select></td><td></td><td></td></tr>';

	// klient
	echo '<tr align="center" class="text"><td align="right">'.$kol_klient.' : </td><td align="left" colspan="3">';
	echo '<select name="klient" class="pole_input" style="width: 200px">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_klientow; $k++) 
	if($klient == $klient_id[$k]) echo '<option value="'.$klient_id[$k].'" selected="selected">'.$klient_nazwa[$k].'</option>';
	else echo '<option value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
	echo '</select></td></tr>';


	echo '<tr align="center"><td align="right" class="text">'.$kol_cena_netto_zakupu_eu2.' : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="6" maxlength="10" class="pole_input" name="cena_netto_zakupu_eu"></td></tr>';
	echo '<tr align="center"><td align="right" class="text">'.$kol_cena_netto_zakupu_zl2.' : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="6" maxlength="10" class="pole_input" name="cena_netto_zakupu_zl"></td></tr>';
	
	echo '<tr class="Text"><td align="center" colspan="4">';
	echo '<INPUT type="submit" name="submit" value="Dodaj">';
	echo '</td></tr></table>';
	echo '</FORM>';

	echo '</table>';
echo '</td></tr></table>';
		echo $powrot_do_magazynu;
}
?>