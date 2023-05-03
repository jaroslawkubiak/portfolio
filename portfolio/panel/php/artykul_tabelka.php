<?php
$kolor_profili = [];
$kolor_uszczelek = [];
$symbol_koloru = [];
$ilosc = [];
$jednostka = [];
$element = [];
$id = [];
$cena_netto_zakupu_eu = [];
$cena_netto_zakupu_zl = [];
$cena_netto_sprzedazy_eu = [];
$cena_netto_sprzedazy_zl = [];
$uszczelka =[];
$kolor =[];

//tabela z produktami z magazynu
$ilosc_magazyn = 0;
$pytanie91 = mysqli_query($conn, "SELECT * FROM magazyn WHERE symbol_profilu='".$symbol_profilu."' AND element='".$artykul."' AND system='".$system."';");
while($wynik91= mysqli_fetch_assoc($pytanie91))
	{
	$ilosc_magazyn++;
	$id[$ilosc_magazyn] = $wynik91['id'];
	$symbol_koloru[$ilosc_magazyn] = $wynik91['symbol_koloru'];
	$kolor[$ilosc_magazyn] = $wynik91['kolor'];
	$ilosc[$ilosc_magazyn] = $wynik91['ilosc'];
	$jednostka[$ilosc_magazyn] = $wynik91['jednostka'];
	$uszczelka[$ilosc_magazyn] = $wynik91['uszczelka'];
	$cena_netto_zakupu_eu[$ilosc_magazyn] = $wynik91['cena_netto_zakupu_eu'];
	$cena_netto_zakupu_zl[$ilosc_magazyn] = $wynik91['cena_netto_zakupu_zl'];
	$cena_netto_sprzedazy_eu[$ilosc_magazyn] = $wynik91['cena_netto_sprzedazy_eu'];
	$cena_netto_sprzedazy_zl[$ilosc_magazyn] = $wynik91['cena_netto_sprzedazy_zl'];
	$cena_netto_zakupu_eu[$ilosc_magazyn] = number_format($cena_netto_zakupu_eu[$ilosc_magazyn], 2,'.','');
	$cena_netto_zakupu_zl[$ilosc_magazyn] = number_format($cena_netto_zakupu_zl[$ilosc_magazyn], 2,'.','');
	$cena_netto_sprzedazy_eu[$ilosc_magazyn] = number_format($cena_netto_sprzedazy_eu[$ilosc_magazyn], 2,'.','');
	$cena_netto_sprzedazy_eu[$ilosc_magazyn] = number_format($cena_netto_sprzedazy_eu[$ilosc_magazyn], 2,'.','');
	$cena_netto_sprzedazy_zl[$ilosc_magazyn] = number_format($cena_netto_sprzedazy_zl[$ilosc_magazyn], 2,'.','');
	$wartosc_netto_zl[$ilosc_magazyn] = $cena_netto_zakupu_zl[$ilosc_magazyn] * $ilosc[$ilosc_magazyn];
	$SUMA_WARTOSC_NETTO += $wartosc_netto_zl[$ilosc_magazyn];
	$wartosc_netto_zl[$ilosc_magazyn] = number_format($wartosc_netto_zl[$ilosc_magazyn], 2,'.',' ');
	}

if($ilosc_magazyn != 0)
	{
	$rowspan='rowspan="2"';
	echo '<table align="center" BORDERCOLOR="black" frame="box" RULES="all" border="1" width="99%" bgcolor="'.$kolor_bialy.'"><tr valign="middle" align="center" bgcolor="'.$kolor_szary.'" class="text">';
	echo '<td '.$rowspan.' width="5%" valign="middle">'.$kol_lp.'</td>';
	echo '<td '.$rowspan.' width="15%" valign="middle">'.$kol_kolor.'</td>';
	echo '<td '.$rowspan.' width="10%" valign="middle">'.$kol_symbol.'</td>';
	echo '<td '.$rowspan.' width="10%" valign="middle">'.$kol_uszczelka.'</td>';
	echo '<td '.$rowspan.' width="5%" valign="middle">'.$kol_ilosc.'</td>';
	echo '<td '.$rowspan.' width="5%" valign="middle">'.$kol_jednostka.'</td>';
	echo '<td width="5%" valign="middle" colspan="2">'.$kol_cena_zakupu_netto.'</td>';
	echo '<td width="5%" valign="middle" colspan="2">'.$kol_cena_sprzedazy_netto.'</td>';
	echo '<td '.$rowspan.' width="15%" valign="middle">'.$kol_wartosc_netto_pln.'</td>';
	echo '<td '.$rowspan.' width="5%" valign="middle">'.$kol_edycja.'</td>';
	echo '<td '.$rowspan.' width="5%" valign="middle">'.$kol_usun.'</td>';
	echo '</tr>';

	
	echo '<tr bgcolor="'.$kolor_szary.'" class="text" align="center">';
	echo '<td width="10%" valign="middle">EUR</td>';
	echo '<td width="10%" valign="middle">PLN</td>';
	echo '<td width="10%" valign="middle">EUR</td>';
	echo '<td width="10%" valign="middle">PLN</td>';
	echo '</tr>';				
	
	for($x=1; $x<=$ilosc_magazyn; $x++)
		{
		echo '<tr class="text" align="center">';
		echo '<td>'.$x.'</td>';
		echo '<td>'.$kolor[$x].'</td>';
		echo '<td>'.$symbol_koloru[$x].'</td>';
		echo '<td>'.$uszczelka[$x].'</td>';
		echo '<td>'.$ilosc[$x].'</td>';
		echo '<td>'.$jednostka[$x].'</td>';
		
		echo '<td>'.$cena_netto_zakupu_eu[$x].'</td>';
		echo '<td>'.$cena_netto_zakupu_zl[$x].'</td>';
		echo '<td>'.$cena_netto_sprzedazy_eu[$x].'</td>';
		echo '<td>'.$cena_netto_sprzedazy_zl[$x].'</td>';
		echo '<td>'.$wartosc_netto_zl[$x].'</td>';
		echo '<td><a href="index.php?page=magazyn_edytuj_pozycje&id='.$id[$x].'&skad='.$skad.'&artykul_id='.$artykul_id.'&szukaj_symbol_profilu='.$szukaj_symbol_profilu.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'">'.$image_edit.'</a></td>';
		echo '<td><a href="index.php?page=magazyn_szukaj&usun_id='.$id[$x].'&skad='.$skad.'&artykul_id='.$artykul_id.'&szukaj_symbol_profilu='.$szukaj_symbol_profilu.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'">'.$image_delete2.'</a></td>';
		echo '</tr>';
		}
	echo '<tr bgcolor="'.$kolor_szary.'" class="text" align="center"><td colspan="10"></td>';
	$SUMA_WARTOSC_NETTO = number_format($SUMA_WARTOSC_NETTO, 2,'.',' ');
	echo '<td>'.$SUMA_WARTOSC_NETTO.'</td><td colspan="2"></td></tr>';
	echo '</table>';
	echo '<div align="right"><br><a href="index.php?page=magazyn_dodaj_pozycje&system='.$system.'&element='.$artykul.'&symbol_profilu='.$symbol_profilu.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'">Dodaj nowy</a></div>';
	}
?>