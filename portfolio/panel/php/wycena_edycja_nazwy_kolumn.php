<?php
if($page != 'wycena_edycja_korekta_fv')	
{
	$colspan_luki_pvc = 18;
	$colspan_wygiecie_ramy_pvc = 5;
	$colspan_material = 33;
}
else
{
	//jezeli to korekta to mniej pol - bez ptaszkow
	$colspan_luki_pvc = 16;
	$colspan_wygiecie_ramy_pvc = 4;
	$colspan_material = 32;

}
if($zalogowany_user == 1) $root_kolor = ' bgcolor="#44ffdd"'; else $root_kolor = '';

	echo '<tr class="text" align="center" bgcolor="'.$kolor_tabeli.'">';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_ilosc.'px">Pozycja</td>';
	echo '<td colspan="'.$colspan_luki_pvc.'">'.$kol_luki_pvc.'</td>';
	echo '<td colspan="16">'.$kol_luki_aluminium.'</td>';
	echo '<td colspan="9">'.$kol_luki_stal.'</td>';
	echo '<td colspan="27">Konstrukcje okienne z pvc</td>';
	echo '<td colspan="'.$colspan_material.'">'.$kol_material.'</td>';
	
	// pozostałe elementy
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Okna</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_Drzwi_wewnetrzne.'</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_Drzwi_zewnetrzne.'</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Bramy</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Parapety</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_Rolety_wewnetrzne.'</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_Rolety_zewnetrzne.'</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Moskitiery</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_Montaz.'</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Odpady z pvc</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Odpady ze stali i alu</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Transport</td>';
	echo '<td rowspan="2" width="'.$szerokosc_kolumny_wartosc.'px">Inne</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_wartosc.'px">Stopień trudności</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_nazwa_produktu.'px">Nazwa produktu</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_rozne.'px">Cena netto za sztukę</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_ilosc.'px">'.$wyraz_Ilosc.' sztuk</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_rozne.'px">'.$wyraz_Wartosc.' netto</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_ilosc.'px">VAT</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_rozne.'px">'.$wyraz_Wartosc.' brutto</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_rozne.'px">Nr faktury</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_rozne.'px">Data faktury</td>';
	echo '<td rowspan="3" width="'.$szerokosc_kolumny_nazwa_produktu.'px">Uwagi</td>';
	echo '</tr>';
	
	// ################################## POZIOM 2 ##################################
	// łuki z pvc
	echo '<tr bgcolor="'.$kolor_tabeli.'" align="center">';
	echo '<td colspan="4">'.$wyraz_Wygiecie.' ramy z pvc</td>';
	echo '<td colspan="'.$colspan_wygiecie_ramy_pvc.'">'.$wyraz_Wygiecie.' skrzydła z pvc</td>';
	echo '<td colspan="'.$colspan_wygiecie_ramy_pvc.'">'.$wyraz_Wygiecie.' listwy z pvc</td>';
	echo '<td colspan="4">'.$wyraz_Wygiecie.' innego elementu z pvc</td>';
	// łuki z alu
	echo '<td colspan="4">'.$wyraz_Wygiecie.' ramy z alu</td>';
	echo '<td colspan="4">'.$wyraz_Wygiecie.' skrzydła z alu</td>';
	echo '<td colspan="4">'.$wyraz_Wygiecie.' listwy z alu</td>';
	echo '<td colspan="4">'.$wyraz_Wygiecie.' innego elementu z alu</td>';
	// łuki ze stali
	echo '<td colspan="'.$colspan_wygiecie_ramy_pvc.'">'.$wyraz_Wygiecie.' wzmocnienia okiennego</td>';
	echo '<td colspan="4">'.$wyraz_Wygiecie.' innego elementu ze stali</td>';
	
	// Konstrukcje okienne z pvc
	echo '<td colspan="3">Zgrzanie</td>';
	echo '<td colspan="3">Wyfrezowanie odwodnienia</td>';
	echo '<td colspan="3">Wstawienie słupka stałego</td>';
	echo '<td colspan="3">Wstawienie słupka ruchomego</td>';
	echo '<td colspan="3">Docięcie listwy przyszybowej tylko łukowej</td>';
	echo '<td colspan="3">Docięcie kompletu listew przyszybowych</td>';
	echo '<td colspan="3">Okucie</td>';
	echo '<td colspan="3">Zaszklenie</td>';
	echo '<td colspan="3">Wykonanie innej usługi</td>';
	
	// Materia
	echo '<td colspan="3">Ościeżnica</td>';
	echo '<td colspan="3">Skrzydło</td>';
	echo '<td colspan="3">Listwa</td>';
	echo '<td colspan="3">Słupek</td>';
	echo '<td colspan="3">Wzmocnienie do ramy</td>';
	echo '<td colspan="3">Wzmocnienie do skrzydła</td>';
	echo '<td colspan="3">Wzmocnienie do słupka</td>';
	echo '<td colspan="3">Wzmocnienie do łuku</td>';
	echo '<td colspan="3">Okucia</td>';
	echo '<td colspan="3">Szyby</td>';
	echo '<td colspan="3">Inny element</td>';
	echo '</tr>';
	
	// ################################## POZIOM 3 ##################################
	// uki z pvc
	echo '<tr bgcolor="'.$kolor_tabeli.'" align="center">';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	if($page != 'wycena_edycja_korekta_fv')	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">kopiuj</td>'; // ptaszek do zaznaczania
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	if($page != 'wycena_edycja_korekta_fv')	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">kopiuj</td>'; // ptaszek do zaznaczania

	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	
	// luki z alu
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	
	// luki ze stali
	if($page != 'wycena_edycja_korekta_fv')	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">kopiuj</td>'; // ptaszek do zaznaczania

	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_szt.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc_m.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';

	// Konstrukcje okienne z pvc
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';

	// Materiał
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>'; // wzmocnienie do łuku
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_ilosc.'px">'.$kol_ilosc.'</td>';
	echo '<td width="'.$szerokosc_kolumny_cena.'px">'.$kol_cena.'</td>';
	echo '<td width="'.$szerokosc_kolumny_wartosc.'px">'.$kol_wartosc.'</td>';

	// pozostałe elementy
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '<td>'.$kol_wartosc.'</td>';
	echo '</tr>';
?>