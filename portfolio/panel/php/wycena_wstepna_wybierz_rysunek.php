<?php
$szerokosc_tabeli_glowej = 1200;
$sciezka = '../panel_dane/wycena_wstepna_rysunki';
//$sciezka = 'wzmocnienia';
echo '<table width="'.$szerokosc_tabeli_glowej.'px" align="left" border="0" cellspacing="5" cellpadding="5">';
echo '<tr><td>';

$ilosc_rysunkow = 0;
$id = [];
$kolejnosc = [];
$rysunek_opis = [];
$link = [];
$pytanie = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_rysunkow++;
	$id[$ilosc_rysunkow]=$wynik['id'];
	$kolejnosc[$ilosc_rysunkow]=$wynik['kolejnosc'];
	$rysunek_opis[$ilosc_rysunkow]=$wynik['opis'];
	$link[$ilosc_rysunkow]=$wynik['link'];
	}
echo '</td></tr><tr><td>';


	echo '<table width="'.$szerokosc_tabeli_glowej.'px" align="left" border="0" cellspacing="5" cellpadding="5">';
		$ilosc_kolumn = 6;
		$szerokosc_kolumny = 100/$ilosc_kolumn;
		$szerokosc_obrazkow = $szerokosc_tabeli_glowej/$ilosc_kolumn;
		
		// wiersz z sortowaniem
		echo '<tr class="text" bgcolor="'.$kolor_tabeli.'"><td colspan="'.$ilosc_kolumn.'">';
			echo '<table border="0" class="text" cellpadding="3" cellspacing="3">';
			echo '<tr><td>Kolejność</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=ASC&wg_czego=kolejnosc&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=DESC&wg_czego=kolejnosc&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_up.'</a></td>';
			echo '<td>&nbsp;</td><td>Opis</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=ASC&wg_czego=opis&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=DESC&wg_czego=opis&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_up.'</a></td>';
			echo '<td>&nbsp;</td><td>Nazwa pliku</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=ASC&wg_czego=link&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=DESC&wg_czego=link&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_up.'</a></td>';
			echo '<td>&nbsp;</td><td>Data dodania</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=ASC&wg_czego=id&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_wybierz_rysunek&jak=DESC&wg_czego=id&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&skad='.$skad.'">'.$image_arrow_up.'</a></td>';
			echo '</tr></table>';
		echo '</td></tr>';
		
		
		//wybrany rysunek dla wszyzstkich pozycji
		echo '<tr align="center"><td colspan="'.$ilosc_kolumn.'">';
			echo '<FORM action="index.php?page=wycena_wstepna_wybierz_rysunek" method="post">';
			echo '<input type="hidden" name="rysunek_dla_pozycji" value="'.$rysunek_dla_pozycji.'">';
			echo '<input type="hidden" name="jak" value="'.$jak.'">';
			echo '<input type="hidden" name="skad" value="'.$skad.'">';
			echo '<input type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
			echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
			if($wszystkie_pozycje == 'on') $checked = ' checked'; else $checked = '';
			echo '<div class="text_duzy_niebieski">Zaznacz, aby wybrać rysunek dla wszystkich pozycji wyceny wstępnej <input type="checkbox" name="wszystkie_pozycje" onchange="submit();" '.$checked.'></div>';
			echo '</form>';
		echo '</td></tr>';


		$licz = 0;
		for($x=1; $x<=$ilosc_rysunkow; $x++) 
			{
			if($licz == 0) echo '<tr>';	
			if($licz < $ilosc_kolumn)
				{
				$licz++;
				echo '<td class="text_duzy" width="'.$szerokosc_kolumny.'%" valign="top">';
					echo '<table align="center" border="0" width="100%" class="tabela">';
					echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td class="text">'.$rysunek_opis[$x].'</td></tr>';
					echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="center">';
					echo '<a href="index.php?page='.$skad.'&jak='.$jak.'&wg_czego='.$wg_czego.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&rysunek_dla_pozycji='.$rysunek_dla_pozycji.'&rysunek['.$rysunek_dla_pozycji.']='.$id[$x].'&wszystkie_pozycje='.$wszystkie_pozycje.'">';
					echo '<img src="http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$link[$x].'" width="'.$szerokosc_obrazkow.'px"></a>';
					echo '</td></tr></table>';
				echo '</td>';
				}
		if($licz == $ilosc_kolumn) 
			{
			echo '</tr>';	
			$licz=0;
			}
		}
	echo '</table>';
echo '</td></tr></table>';

?>