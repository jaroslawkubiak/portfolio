
<?php
/*

Sortowania tak jak w rejestrze zamwie (tak)? moliwo wyboru samego systemu jak i posortowania wg nazw itp (tak)?
Wysyka pdf na email ma by zawsze taka sama? tzn tabela zawsze bdzie taka sama, czy chcesz wysortowan tabel,(tak) np konkretny system wysa do klienta?(tak)
Podaj moe te jakie przykady artykuw i promieni. (za)


W zakadce gwnej Technologia zrb now zakadk pt. Minimalne promienie a w niej tabela z opcj dopisywania, edytowania, usuwania i sortowania. 
Tabela powinna mie kolumny: System, Artyku, Minimalny R z gwarancj (mm), Minimalny R bez gwarancji (mm). 
Kad tabel musz mie moliwo wysyki w pdf do danego klienta (suwak z firm - adres email do wyboru z karty klienta).
 
 */
 
 

if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM minimalne_promienie WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div align="center" class="text_duzy_niebieski">Wpis usunięty</div><br>';
	}
	
	
$warunek = "";
$SORTOWANIE_DIV = '';

if($SORT_SYSTEM != "") 
	{
	if($warunek == "") $warunek .= 'WHERE system = "'.$SORT_SYSTEM.'"';
	else $warunek .= ' AND system = "'.$SORT_SYSTEM.'"';
	$SORTOWANIE_DIV .= '&SORT_SYSTEM='.$SORT_SYSTEM;
	}          

if($SORT_SYMBOL_PROFILU != "") 
	{
	if($warunek == "") $warunek .= 'WHERE symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	else $warunek .= ' AND symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	$SORTOWANIE_DIV .= '&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU;
	}          
 
 
$i=0;
$id = [];
$system = [];
$symbol_profilu = [];
$promien_z_gwa = [];
$promien_bez_gwa = [];

$pytanie = mysqli_query($conn, "SELECT * FROM minimalne_promienie ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$system[$i]=$wynik['system'];
	$symbol_profilu[$i]=$wynik['symbol_profilu'];
	$promien_z_gwa[$i]=$wynik['promien_z_gwa'];
	$promien_bez_gwa[$i]=$wynik['promien_bez_gwa'];
	}

$system2 = array_unique($system);
$system_opis = array_values(array_filter($system2));
sort ($system_opis);
$ilosc_systemow = count($system_opis);

$symbol_profilu2 = array_unique($symbol_profilu);
$symbol_profilu_opis = array_values(array_filter($symbol_profilu2));
sort ($symbol_profilu_opis);
$ilosc_symboli_profili = count($symbol_profilu_opis);

if($i == 0) echo '<div align="center" class="text_duzy_zielony">Wybierz conajmniej jeden wiersz, aby wysłać wysortowaną tabelę do klienta.</div><br>';
else echo '<div align="center"><a href="index.php?page=minimalne_promienie_wyslij_tabele&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><div class="text_duzy_zielony">Wyślij wysortowaną tabelę do klienta</div></a></div><br>';


echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="minimalne_promienie">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                


echo '<table width="50%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if(($SORT_SYSTEM != '') || ($SORT_SYMBOL_PROFILU != '')) $pokaz_guzik_close = '<div><a href="index.php?page=minimalne_promienie&jak=DESC&wg_czego=id">'.$image_close.'</a></div>'; else $pokaz_guzik_close = '';
echo '<td width="5%">'.$kol_lp.''.$pokaz_guzik_close.'</td>';

echo '<td width="20%">System<div align="right"><a href="index.php?page=minimalne_promienie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=system&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=minimalne_promienie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=system&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_SYSTEM" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_systemow-1; $k++) 
			if ($system_opis[$k] == $SORT_SYSTEM) echo '<option value="'.$system_opis[$k].'" selected="selected">'.$system_opis[$k].'</option>';
			else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="20%">Symbol profilu<div align="right"><a href="index.php?page=minimalne_promienie'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=symbol_profilu&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=minimalne_promienie'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=symbol_profilu&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_SYMBOL_PROFILU" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_symboli_profili-1; $k++) 
			if ($symbol_profilu_opis[$k] == $SORT_SYMBOL_PROFILU) echo '<option value="'.$symbol_profilu_opis[$k].'" selected="selected">'.$symbol_profilu_opis[$k].'</option>';
			else echo '<option value="'.$symbol_profilu_opis[$k].'">'.$symbol_profilu_opis[$k].'</option>';
	echo '</select>';
echo '</td>';
echo '<td width="10%">Minimalny R z gwarancją (mm)</td>';
echo '<td width="10%">Minimalny R bez gwarancji (mm)</td>';
echo '<td width="5%">Usuń</td></tr>';

for ($x=1; $x<=$i; $x++)
	{
	echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td><a href="index.php?page=minimalne_promienie_edycja&id='.$id[$x].'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$system[$x].'</a></td>';
	echo '<td>'.$symbol_profilu[$x].'</td>';
	echo '<td>'.$promien_z_gwa[$x].'</td>';
	echo '<td>'.$promien_bez_gwa[$x].'</td>';
	echo '<td><a href="index.php?page=minimalne_promienie&usun_id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_delete.'</a></td>';
	echo '</tr>';
	}
echo '</table>';
echo '</form>';

?>