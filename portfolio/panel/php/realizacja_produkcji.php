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

	input.button_produkcja_mniejszy
	{
		white-space: normal;
		width: 200px;  
		height: 70px;
		font-weight: bold;
		font: Times New Roman;
		font-size:16px;
}

</style>

<?php

echo '<table align="left" width="70%" cellspacing="0" cellpadding="0" border="0"><tr align="center" class="text">';
echo '<td><a href="index.php?page=magazyn&jak=ASC&wg_czego=system">'.$image_menu_magazyn.'</a></td>';
echo '<td><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&jak=DESC&wg_czego=id">'.$image_menu_zamowienia_do_wykonania.'</a></td>';
echo '<td><a href="index.php?page=realizacja_produkcji_zamowienia_wykonane&jak=DESC&wg_czego=id">'.$image_menu_zamowienia_wykonane.'</a></td>';
echo '<td><a href="index.php?page=realizacja_produkcji_historia_wpisow&jak=DESC&wg_czego=id">'.$image_menu_historia.'</a></td>';
echo '<td><a href="index.php?page=pokaz_zlecenia_zaladunkowe&jak=DESC&wg_czego=id">'.$image_menu_zlecenia_zaladunkowe.'</a></td>';
echo '<td><a href="index.php?page=wzmocnienia">'.$image_menu_wzmocnienia.'</a></td>';
echo '<td><a href="index.php?page=analiza_wydajnosc_produkcji">'.$image_menu_wydajnosc_produkcji.'</a></td>';
echo '<td><a href="index.php?page=sposob_czyszczenia_zgrzewow&jak=ASC&wg_czego=klient_nazwa">'.$image_menu_sposob_czyszczenia_zgrzewow.'</a></td>';
echo '<td><a href="index.php?page=karty_produkcyjne_szukaj&jak=ASC&wg_czego=klient_nazwa">'.$image_menu_karty_produkcyjne.'</a></td>';
echo '<td><a href="index.php?page=dlugosc_luku">'.$image_menu_dlugosc_luku.'</a></td>';
echo '<td><a href="index.php?page=przekatna">'.$image_menu_przekatna.'</a></td>';
echo '<td><a href="index.php?page=produkcja_premia_akordowa">'.$image_menu_premia_akordowa.'</a></td>';

echo '<td><a href="index.php?page=wyloguj&user_id='.$user_id.'">'.$image_menu_wyloguj.'</a></td>';
echo '</tr></table>';



// rysowanie guzikow w CHROME !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//  echo '<br><br><br><br><br><br><br><br><br>';
// echo '<input type="button" value="Wydajność produkcji" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Magazyn" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Wzmocnienia" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Wyloguj" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Zamówienia wykonane" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Zamówienia do wykonania" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Historia wpisów" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Długość łuku" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Przekątna" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Zlecenia załadunkowe" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Premia akordowa" class="button_produkcja_mniejszy"><br><br>';

// echo '<input type="button" value="Sposób czyszczenia zgrzewów" class="button_produkcja_mniejszy"><br><br>';
// echo '<input type="button" value="Karty produkcyjne" class="button_produkcja_mniejszy"><br><br>';

?>