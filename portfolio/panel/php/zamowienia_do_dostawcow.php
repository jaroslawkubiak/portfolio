<?php
if($zamowienie_wyslane == 'tak')
		echo '<div align="center" class="text_duzy_niebieski">'.$wyraz_Zamowienie.' wysłane</div><br>';
if($zrealizowac_zamowienie == 'tak')
		echo '<div align="center" class="text_duzy_niebieski">'.$wyraz_Zamowienie.' zrealizowane</div><br>';


$warunek = "";
$SORTOWANIE_DIV = '';

if($SORT_KLIENT_NAZWA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	else $warunek .= ' AND klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	$SORTOWANIE_DIV .= '&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA;
	}          

if($SORT_NUMERY_ZAMOWIEN != "") 
	{
	if($warunek == "") $warunek .= 'WHERE nr_zamowienia = "'.$SORT_NUMERY_ZAMOWIEN.'"';
	else $warunek .= ' AND nr_zamowienia = "'.$SORT_NUMERY_ZAMOWIEN.'"';
	$SORTOWANIE_DIV .= '&SORT_NUMERY_ZAMOWIEN='.$SORT_NUMERY_ZAMOWIEN;
	}          

if($SORT_DATA_ZAMOWIENIA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE data_zamowienia = "'.$SORT_DATA_ZAMOWIENIA.'"';
	else $warunek .= ' AND data_zamowienia = "'.$SORT_DATA_ZAMOWIENIA.'"';
	$SORTOWANIE_DIV .= '&SORT_DATA_ZAMOWIENIA='.$SORT_DATA_ZAMOWIENIA;
	}  
	        
if($SORT_DATA_WYSLANIA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE data_wyslania = "'.$SORT_DATA_WYSLANIA.'"';
	else $warunek .= ' AND data_wyslania = "'.$SORT_DATA_WYSLANIA.'"';
	$SORTOWANIE_DIV .= '&SORT_DATA_WYSLANIA='.$SORT_DATA_WYSLANIA;
	}          

if($SORT_STATUS != "") 
	{
	if($warunek == "") $warunek .= 'WHERE status = "'.$SORT_STATUS.'"';
	else $warunek .= ' AND status = "'.$SORT_STATUS.'"';
	$SORTOWANIE_DIV .= '&SORT_STATUS='.$SORT_STATUS;
	}          


$ilosc_klientow = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_klientow++;
	$KLIENT_NAZWA[$ilosc_klientow] = $wynik24['nazwa'];
	}
	
$ilosc_zamowien = 0;
$pytanie242 = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek ORDER BY data_zamowienia_time DESC;");
while($wynik242= mysqli_fetch_assoc($pytanie242))
	{
	$ilosc_zamowien++;
	$NUMERY_ZAMOWIEN[$ilosc_zamowien] = $wynik242['nr_zamowienia'];
	}

$ilosc_data_zamowienia = 0;
$pytanie242 = mysqli_query($conn, "SELECT DISTINCT data_zamowienia FROM magazyn_zamowienia_naglowek ORDER BY data_zamowienia_time DESC;");
while($wynik242= mysqli_fetch_assoc($pytanie242))
	{
	$ilosc_data_zamowienia++;
	$DATA_ZAMOWIENIA[$ilosc_data_zamowienia] = $wynik242['data_zamowienia'];
	}


	
$ilosc_data_wyslania = 0;
$pytanie242 = mysqli_query($conn, "SELECT DISTINCT data_wyslania FROM magazyn_zamowienia_naglowek WHERE data_wyslania IS NOT NULL ORDER BY data_zamowienia_time DESC;");
while($wynik242= mysqli_fetch_assoc($pytanie242))
	{
	 if($wynik242['data_wyslania'] != '')	
	 {
		$ilosc_data_wyslania++;
		$DATA_WYSLANIA[$ilosc_data_wyslania] = $wynik242['data_wyslania'];
	 }
	}
	


$id = [];
$klient_id = [];
$klient_nazwa = [];
$nr_zamowienia = [];
$data_zamowienia = [];
$data_wyslania = [];
$wartosc_netto = [];
$status = [];
$uwagi = [];

$i=0;
$pytanie = mysqli_query($conn, "SELECT * FROM magazyn_zamowienia_naglowek ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$klient_id[$i]=$wynik['klient_id'];
	$klient_nazwa[$i]=$wynik['klient_nazwa'];
	$nr_zamowienia[$i]=$wynik['nr_zamowienia'];
	$data_zamowienia[$i]=$wynik['data_zamowienia'];
	$data_wyslania[$i]=$wynik['data_wyslania'];
	$wartosc_netto[$i]=$wynik['wartosc_netto'];
	$status[$i]=$wynik['status'];
	$uwagi[$i]=$wynik['uwagi'];
	}	

	
//sortowanie zlecen
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="zamowienia_do_dostawcow">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
echo '<input type="hidden" name="pokaz" value="1">';        

echo '<table width="1200px" align="center" class="tabela" cellpadding="3"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if($pokaz == 1) echo '<td width="5%" valign="middle">'.$kol_lp.'<br>'.$i.'<br><a href="index.php?page=zamowienia_do_dostawcow&jak=DESC&wg_czego=data_zamowienia_time">'.$image_close.'</a></td>';
else echo '<td width="5%" valign="middle">'.$kol_lp.'<br>'.$i.'</td>';

echo '<td width="12%">Data zamówienia<div align="right"><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=data_zamowienia_time&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=data_zamowienia_time&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_DATA_ZAMOWIENIA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_data_zamowienia; $k++) 
			if ($DATA_ZAMOWIENIA[$k] == $SORT_DATA_ZAMOWIENIA) echo '<option value="'.$DATA_ZAMOWIENIA[$k].'" selected="selected">'.$DATA_ZAMOWIENIA[$k].'</option>';
			else echo '<option value="'.$DATA_ZAMOWIENIA[$k].'">'.$DATA_ZAMOWIENIA[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="12%">Data wysłania<div align="right"><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=data_wyslania_time&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=data_wyslania_time&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_DATA_WYSLANIA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_data_wyslania; $k++) 
			if ($DATA_WYSLANIA[$k] == $SORT_DATA_WYSLANIA) echo '<option value="'.$DATA_WYSLANIA[$k].'" selected="selected">'.$DATA_WYSLANIA[$k].'</option>';
			else echo '<option value="'.$DATA_WYSLANIA[$k].'">'.$DATA_WYSLANIA[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="10%">Nr zamówienia<div align="right"><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=nr_zamowienia&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=nr_zamowienia&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_NUMERY_ZAMOWIEN" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_zamowien; $k++) 
			if ($NUMERY_ZAMOWIEN[$k] == $SORT_NUMERY_ZAMOWIEN) echo '<option value="'.$NUMERY_ZAMOWIEN[$k].'" selected="selected">'.$NUMERY_ZAMOWIEN[$k].'</option>';
			else echo '<option value="'.$NUMERY_ZAMOWIEN[$k].'">'.$NUMERY_ZAMOWIEN[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="10%" valign="top">Wartość netto<div align="right"><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=wartosc_netto&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=wartosc_netto&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
echo '</td>';

echo '<td  width="15%">Dostawca<div align="right"><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=klient_nazwa&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=klient_nazwa&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_KLIENT_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_klientow; $k++) 
			if ($KLIENT_NAZWA[$k] == $SORT_KLIENT_NAZWA) echo '<option value="'.$KLIENT_NAZWA[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
			else echo '<option value="'.$KLIENT_NAZWA[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td  width="8%">Status<div align="right"><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=status&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia_do_dostawcow'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=status&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_STATUS" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$DL_TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW; $k++) 
			if ($TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[$k] == $SORT_STATUS) echo '<option value="'.$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[$k].'" selected="selected">'.$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[$k].'</option>';
			else echo '<option value="'.$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[$k].'">'.$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td>'.$kol_uwagi.'</td></tr>';

for ($x=1; $x<=$i; $x++)
	{
	echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td><a href="index.php?page=zamowienia_do_dostawcow_edycja&zamowienie_id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'">'.$data_zamowienia[$x].'</a></td>';
	
	if($data_wyslania[$x] != '')
		{
		$nr_zamowienia2[$x] = change_link($nr_zamowienia[$x]); // zamieniam / na _
		$nazwa_pliku = 'zamowienie_'.$nr_zamowienia2[$x].'.pdf';
		echo '<td><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_zamowienia_do_dostawcow/'.$nazwa_pliku.'" target="_blank">'.$data_wyslania[$x].'</a></td>';
		}
	else echo '<td>&nbsp;</td>';
	echo '<td><a href="index.php?page=zamowienia_do_dostawcow_edycja&zamowienie_id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&SORTOWANIE_DIV='.$SORTOWANIE_DIV.'">'.$nr_zamowienia[$x].'</a></td>';
	$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
	echo '<td align="right">'.$wartosc_netto[$x].' '.$waluta.'&nbsp;&nbsp;&nbsp;</td>';
	echo '<td>'.$klient_nazwa[$x].'</td>';
	echo '<td>'.$status[$x].'</td>';
	echo '<td align="left">'.$uwagi[$x].'</td>';
	echo '</tr>';
	}
echo '</table>';

echo '</form>';

?>