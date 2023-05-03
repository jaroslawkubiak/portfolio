<?php
//tabela do mniejszych stron
echo '<table width="1800px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';


$warunek = "";
$SORTOWANIE_DIV = '';

if($SORT_KLIENT_NAZWA != "") 
	{
	$pytanie4 = mysqli_query($conn, "SELECT id FROM klienci WHERE nazwa = '".$SORT_KLIENT_NAZWA."' ");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$baza_klient_id=$wynik4['id'];
		}
	
	if($warunek == "") $warunek .= 'WHERE klient_id = "'.$baza_klient_id.'"';
	else $warunek .= ' AND klient_id = "'.$baza_klient_id.'"';
	$SORTOWANIE_DIV .= '&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA;
	}          


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
	
if(($dodaj_ilosc_id != '') && ($ilosc_do_dodania != ''))
	{
	$ilosc_do_dodania = change($ilosc_do_dodania);
	$pytanie122 = mysqli_query($conn, "UPDATE magazyn SET ilosc = ".$ilosc_do_dodania." WHERE id = ".$dodaj_ilosc_id.";");
	$dodaj_ilosc_id = '';
	$ilosc_do_dodania = '';
	}


//deklaracja zmiennych
$SUMA_WARTOSC_NETTO = 0;
$klient_nazwa = [];
$kolor_profili = [];
$kolor_uszczelek = [];
$symbol_profilu = [];
$symbol_koloru = [];
$ilosc = [];
$jednostka = [];
$system = [];
$element = [];
$id = [];
$artykul_id = [];
$cena_netto_zakupu_eu = [];
$cena_netto_zakupu_zl = [];
$cena_netto_sprzedazy_eu = [];
$cena_netto_sprzedazy_zl = [];

$i = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM magazyn ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$system[$i]=$wynik['system'];
	$element[$i]=$wynik['element'];
	//$klient_id[$i]=$wynik['klient_id'];
	if($wynik['klient_id'] != '')
		{
		$pytanie4 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$wynik['klient_id'].";");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$klient_nazwa[$i]=$wynik4['nazwa'];
			}
		}
	$kolor_profili[$i]=$wynik['kolor'];
	$kolor_uszczelek[$i]=$wynik['uszczelka'];
	$symbol_profilu[$i]=$wynik['symbol_profilu'];
	$symbol_koloru[$i]=$wynik['symbol_koloru'];
	$ilosc[$i]=$wynik['ilosc'];
	$jednostka[$i]=$wynik['jednostka'];
	$cena_netto_zakupu_eu[$i]=$wynik['cena_netto_zakupu_eu'];
	$cena_netto_zakupu_zl[$i]=$wynik['cena_netto_zakupu_zl'];
	$cena_netto_sprzedazy_eu[$i]=$wynik['cena_netto_sprzedazy_eu'];
	$cena_netto_sprzedazy_zl[$i]=$wynik['cena_netto_sprzedazy_zl'];
	$wartosc_netto_zl[$i] = $cena_netto_zakupu_zl[$i] * $ilosc[$i];
	$SUMA_WARTOSC_NETTO += $wartosc_netto_zl[$i];
	
	$cena_netto_zakupu_eu[$i] = number_format($cena_netto_zakupu_eu[$i], 2,'.','');
	$cena_netto_zakupu_zl[$i] = number_format($cena_netto_zakupu_zl[$i], 2,'.','');
	$cena_netto_sprzedazy_eu[$i] = number_format($cena_netto_sprzedazy_eu[$i], 2,'.','');
	$cena_netto_sprzedazy_eu[$i] = number_format($cena_netto_sprzedazy_eu[$i], 2,'.','');
	$cena_netto_sprzedazy_zl[$i] = number_format($cena_netto_sprzedazy_zl[$i], 2,'.','');
	$wartosc_netto_zl[$i] = number_format($wartosc_netto_zl[$i], 2,'.',' ');
	}



if($i != 0)
	{
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
	}


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


$ilosc_klientow = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC;");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_klientow++;
	$KLIENT_NAZWA[$ilosc_klientow] = $wynik24['nazwa'];
	}





if($user_stanowisko != 'produkcja')
	{
	$SUMA_WARTOSC_NETTO = number_format($SUMA_WARTOSC_NETTO, 2,'.',' ');
	echo '<table class="tabela" width="700px" align="left"><tr valign="middle" align="center" bgcolor="'.$kolor_tabeli.'" class="text" width="25%"><td width="15%">Kurs Euro</td><td width="15%" bgcolor="'.$kolor_bialy.'">'.$kurs_euro.'</td>';
	echo '<td width="15%">Marża magazynu</td><td width="15%" bgcolor="'.$kolor_bialy.'">'.$marza_magazynu.'%</td>';
	echo '<td>'.$wyraz_Wartosc.' magazynu</td><td width="15%" bgcolor="'.$kolor_bialy.'">'.$SUMA_WARTOSC_NETTO.' '.$waluta.'</td></tr></table><br><br>';
	}


	//szukaj
	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="magazyn_szukaj">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">'; 
	echo '<input type="hidden" name="szukaj_symbol_profilu" value="'.$szukaj_symbol_profilu.'">'; 
	echo '<input type="hidden" name="SORT_ELEMENT" value="'.$SORT_ELEMENT.'">';                                
	echo '<input type="hidden" name="SORT_SYSTEM" value="'.$SORT_SYSTEM.'">';
	echo '<input type="hidden" name="SORT_KOLOR" value="'.$SORT_KOLOR.'">';
	echo '<input type="hidden" name="SORT_SYMBOL_KOLORU" value="'.$SORT_SYMBOL_KOLORU.'">';
	echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="'.$SORT_SYMBOL_PROFILU.'">';
	echo '<input type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
	echo '<input type="hidden" name="pokaz" value="'.$pokaz.'">';
	echo '<input type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';
		echo '<table border="0" width="100%" cellspacing="0" cellpadding="0" align="left"><tr><td width="15%">';
			echo '<table border="0" width="700px" cellspacing="0" cellpadding="0" align="left"><tr class="text_ogromny"><td align="right" width="80%">Szukaj symbolu profilu :&nbsp;</td>';
			echo '<td width="10%"><input type="text" id="szukaj" autocomplete="off" size="5" class="pole_input_wzmocnienia" name="szukaj_symbol_profilu" value="'.$szukaj_symbol_profilu.'"></td>';
			echo '<td  width="10%" align="left"><INPUT type="image" name="submit" src="images/lupa.png"></td>';
			echo '</tr></table>';
		echo '</td></tr></table>';
	echo '</form>';



	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="magazyn">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="pokaz" value="1">';    

	echo '<br><br><br><br><br>';

	echo '<table border="0" align="center" width="100%"><tr><td align="right">';
		// guzik dodaj nowe sposob
		echo '<table width="135px" align="right" border="0" cellpadding="3" cellspacing="3"><tr class="text"><td width="25px" align="right" valign="middle">';
			echo '<a href="index.php?page=magazyn_dodaj_pozycje&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_plusik.'</a>';
		echo '</td><td width="110px">';
			echo '<a href="index.php?page=magazyn_dodaj_pozycje&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj pozycję</a>';
		echo '</td></tr></table>';
	echo '</td></tr>';

		echo '<table class="tabela" align="left" width="100%"><tr valign="middle" align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		if($pokaz == 1) echo '<td '.$rowspan.' width="10px" valign="middle">'.$kol_lp.'<br>'.$i.'<br><a href="index.php?page=magazyn&jak=ASC&wg_czego=id">'.$image_close.'</a></td>';
		else echo '<td '.$rowspan.' width="10px" valign="middle">'.$kol_lp.'<br>'.$i.'</td>';
			
		echo '<td width="100px" valign="bottom">'.$kol_klient;
			echo '<br><br><select name="SORT_KLIENT_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_klientow; $k++) 
					if ($KLIENT_NAZWA[$k] == $SORT_KLIENT_NAZWA) echo '<option value="'.$KLIENT_NAZWA[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
					else echo '<option value="'.$KLIENT_NAZWA[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="150px">'.$kol_system.'<div align="right"><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=system&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=system&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_SYSTEM" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_systemow-1; $k++) 
				if ($system_opis[$k] == $SORT_SYSTEM) echo '<option value="'.$system_opis[$k].'" selected="selected">'.$system_opis[$k].'</option>';
				else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="150px">'.$kol_element.'<div align="right"><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=element&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=element&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_ELEMENT" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_elementow-1; $k++) 
					if ($element_opis[$k] == $SORT_ELEMENT) echo '<option value="'.$element_opis[$k].'" selected="selected">'.$element_opis[$k].'</option>';
					else echo '<option value="'.$element_opis[$k].'">'.$element_opis[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="150px">'.$kol_kolor.'<div align="right"><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=kolor&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=kolor&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_KOLOR" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_kolorow-1; $k++) 
					if ($kolor_opis[$k] == $SORT_KOLOR) echo '<option value="'.$kolor_opis[$k].'" selected="selected">'.$kolor_opis[$k].'</option>';
					else echo '<option value="'.$kolor_opis[$k].'">'.$kolor_opis[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="150px">'.$kol_uszczelka.'<div align="right"><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=uszczelka&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=uszczelka&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_KOLOR_USZCZELEK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_kolor_uszczelek-1; $k++) 
					if ($kolor_uszczelek_opis[$k] == $SORT_KOLOR_USZCZELEK) echo '<option value="'.$kolor_uszczelek_opis[$k].'" selected="selected">'.$kolor_uszczelek_opis[$k].'</option>';
					else echo '<option value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="150px">'.$kol_symbol_profilu.'<div align="right"><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=symbol_profilu&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=symbol_profilu&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_SYMBOL_PROFILU" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_symboli_profili-1; $k++) 
					if ($symbol_profilu_opis[$k] == $SORT_SYMBOL_PROFILU) echo '<option value="'.$symbol_profilu_opis[$k].'" selected="selected">'.$symbol_profilu_opis[$k].'</option>';
					else echo '<option value="'.$symbol_profilu_opis[$k].'">'.$symbol_profilu_opis[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="150px">'.$kol_symbol_koloru.'<div align="right"><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=symbol_koloru&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=magazyn'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=symbol_koloru&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_SYMBOL_KOLORU" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=0; $k<=$ilosc_symboli_koloru-1; $k++) 
					if ($symbol_koloru_opis[$k] == $SORT_SYMBOL_KOLORU) echo '<option value="'.$symbol_koloru_opis[$k].'" selected="selected">'.$symbol_koloru_opis[$k].'</option>';
					else echo '<option value="'.$symbol_koloru_opis[$k].'">'.$symbol_koloru_opis[$k].'</option>';
			echo '</select>';
		echo '</td>';

		echo '<td width="100px">'.$kol_ilosc_na_magazynie.'</td>';

		if($user_stanowisko != 'produkcja') 
			{
			echo '<td width="100px">'.$kol_cena_netto_zakupu_eu.'</td>';
			echo '<td width="100px">'.$kol_cena_netto_zakupu_zl.'</td>';
			echo '<td width="100px">'.$kol_cena_netto_sprzedazy_eu.'</td>';
			echo '<td width="100px">'.$kol_cena_netto_sprzedazy_zl.'</td>';
			echo '<td width="120px">'.$kol_wartosc_netto_zl.'</td>';
			}
		echo '</tr>';
		echo '</form>';

		echo '<FORM action="index.php?page=magazyn" method="post">';
		echo '<input type="hidden" name="SORT_SYSTEM" value="'.$SORT_SYSTEM.'">';
		echo '<input type="hidden" name="SORT_ELEMENT" value="'.$SORT_ELEMENT.'">';
		echo '<input type="hidden" name="SORT_KOLOR" value="'.$SORT_KOLOR.'">';
		echo '<input type="hidden" name="SORT_SYMBOL_KOLORU" value="'.$SORT_SYMBOL_KOLORU.'">';
		echo '<input type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';
		echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="'.$SORT_SYMBOL_PROFILU.'">';
		echo '<input type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
		echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<input type="hidden" name="jak" value="'.$jak.'">';
		echo '<input type="hidden" name="dodaj_ilosc_id" value="'.$dodaj_ilosc_id.'">';
		echo '<input type="hidden" name="pokaz" value="'.$pokaz.'">';

			for ($x=1; $x<=$i; $x++)
				{
				echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td class="text" bgcolor="'.$kolor_tabeli.'">'.$x.'</td>'; 
				if($system[$x] == '') $system[$x] = 'BRAK';
				echo '<td>'.$klient_nazwa[$x].'</td>';
				echo '<td><a href="index.php?page=magazyn_edytuj_pozycje&id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'">'.$system[$x].'</a></td>';
				echo '<td>'.$element[$x].'</td>';
				echo '<td>'.$kolor_profili[$x].'</td>';
				echo '<td>'.$kolor_uszczelek[$x].'</td>';
				
				//szukamy symbolu profilu w artykulach
				$pytanie44 = mysqli_query($conn, "SELECT id FROM magazyn_artykuly WHERE symbol_profilu = '".$symbol_profilu[$x]."'");
				while($wynik44= mysqli_fetch_assoc($pytanie44))
					{
					$artykul_id[$x]=$wynik44['id'];
					}

				if($artykul_id[$x]) echo '<td><a href="index.php?page=magazyn_szukaj&artykul_id='.$artykul_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'"><font color="blue">'.$symbol_profilu[$x].'</font></a></td>';
				else echo '<td><a href="index.php?page=magazyn_szukaj&system='.$system[$x].'&artykul='.$element[$x].'&symbol_profilu='.$symbol_profilu[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'">'.$symbol_profilu[$x].'</a></td>';
				
				echo '<td>'.$symbol_koloru[$x].'</td>';
				if($dodaj_ilosc_id == $id[$x]) $kolor_czcionki_ilosc = 'red'; else $kolor_czcionki_ilosc = 'black';
				echo '<td align="right"><a href="index.php?page=magazyn&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&dodaj_ilosc_id='.$id[$x].'"><font color="'.$kolor_czcionki_ilosc.'"><div>'.$ilosc[$x].' '.$jednostka[$x].'</div></font></a></td>';
				if($user_stanowisko != 'produkcja') 
					{
					echo '<td align="right">'.$cena_netto_zakupu_eu[$x].'</td>';
					echo '<td align="right">'.$cena_netto_zakupu_zl[$x].'</td>';
					echo '<td align="right">'.$cena_netto_sprzedazy_eu[$x].'</td>';
					echo '<td align="right">'.$cena_netto_sprzedazy_zl[$x].'</td>';
					echo '<td align="right">'.$wartosc_netto_zl[$x].'</td>';
					}
				echo '</tr>';
				
				if($dodaj_ilosc_id == $id[$x])
					{
					echo '<tr align="center" bgcolor="#32964d">';
					echo '<td colspan="8" align="right">';
					echo 'Dodaj ilość : &nbsp;&nbsp;';
					echo '<td align="right"><input type="text" size="2" maxlenght="10" name="ilosc_do_dodania" autocomplete="off" align="right" class="pole_input_biale"><input type="submit" name="submit" value="->"></td>';
					if($user_stanowisko != 'produkcja') echo '<td colspan="5"></td>';
					echo '</tr>';	
					}
				}

				echo '<tr class="text" bgcolor="'.$kolor_tabeli.'"><td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
				if($user_stanowisko != 'produkcja') 
					{
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
					echo '<td align="right" colspan="2">Wartość magazynu : '.$SUMA_WARTOSC_NETTO.' '.$waluta.'</td>';
					}
				echo '</tr>';
				
				
		echo '</table>';
		echo '</form>';
	echo '</td></tr></table>';
echo '</td></tr></table>';

?>