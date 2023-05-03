<?php
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="'.$page.'">';

$wartosc_netto_fv = [];
$klient_id = [];
$nazwa = [];
$wartosc_netto_fv = [];

if($SPRAWDZANY_ROK == '')  $SPRAWDZANY_ROK = $AKTUALNY_ROK;

if($wszyscy == 'wszyscy') 
	{
	$limit = ''; 
	}
else 
	{
	$i = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$klient_id[$i] = $wynik['id'];
		$nazwa[$klient_id[$i]]=$wynik['nazwa'];
		$wartosc_netto_fv[$klient_id[$i]] = 0;
		}
	
	for($x=1; $x<=$i; $x++)
		{
		//pobieram dane dotyczące faktur - bez tych do których był wystawiona korekta
		$pytanie16 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE nabywca_id = ".$klient_id[$x]." AND typ_dok = 'Faktura' AND data_wystawienia_rok = '".$SPRAWDZANY_ROK."' AND tytul_korekty IS NULL;");
		while($wynik16 = mysqli_fetch_assoc($pytanie16))
			{
			$wartosc_netto_fv[$klient_id[$x]] += $wynik16['wartosc_netto_fv'];
			}
		
		//pobieram dane dotyczące korekt
		$pytanie1 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE nabywca_id = ".$klient_id[$x]." AND typ_dok = 'Korekta' AND data_wystawienia_rok = '".$SPRAWDZANY_ROK."';");
		while($wynik1 = mysqli_fetch_assoc($pytanie1))
			{
			$wartosc_netto_fv[$klient_id[$x]] += $wynik1['wartosc_netto_fv'];
			}
		
		}

	// zapisywanie danych do bazy klientów
	for($x=1; $x<=$i; $x++)
		{
		$wartosc_netto_fv[$klient_id[$x]] = number_format($wartosc_netto_fv[$klient_id[$x]], 2,'.','');
		// echo $nazwa[$klient_id[$x]].' = '.$wartosc_netto_fv[$klient_id[$x]].'<br>';

		$pytanie122 = "UPDATE klienci SET wartosc_zamowien = ".$wartosc_netto_fv[$klient_id[$x]]." WHERE id = ".$klient_id[$x].";";
		mysqli_query($conn, $pytanie122);
		}
	
	$limit = ' LIMIT 20';
	}

echo '<table valign="top" align="center" border="1" cellspacing="10" cellpadding="10" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td width="50%">Wybierz rok : ';
echo '<select name="SPRAWDZANY_ROK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
for($x= 1; $x<= $DLUGOSC_TABELA_LISTA_LAT_WYCENA_DANE; $x++) 
	{
	if ($TABELA_LISTA_LAT_WYCENA_DANE[$x] == $SPRAWDZANY_ROK) echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'" selected="selected">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
	else echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
	}
echo '</select>';
echo '</td>';

echo '<td width="50%">Wyszukaj klienta : <br>';
	echo '<table border="0" cellspacing="0" cellpadding="0" valign="bottom"><tr valign="bottom"><td align="center" valign="bottom">';
	echo '<input type="text" id="szukaj" autocomplete="off" size="25" class="pole_input_sortowanie" name="szukaj_klienta" value="'.$szukaj_klienta.'"></td>';
	echo '<td><INPUT type="image" name="submit" src="images/search_black.png"></td></tr></table>';
echo '</td></tr></table><br>';


// teraz pobieramy już tylko dane z tabeli klientów - nie liczymy na nowo z fakturowania
$i = 0;
$warunek = '';
if($szukaj_klienta != '') $warunek = " WHERE nazwa LIKE '%".$szukaj_klienta."%'";
if($strefa != '')
	{
	if($warunek == '') $warunek = " WHERE strefa = '".$strefa."'";
	else $warunek .= " AND strefa = '".$strefa."'";
	}

$wartosc_zamowien = [];
$klient_strefa = [];

$pytanie = mysqli_query($conn, "SELECT nazwa, wartosc_zamowien, strefa FROM klienci ".$warunek." ORDER BY wartosc_zamowien DESC ".$limit.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$wartosc_zamowien[$i] = $wynik['wartosc_zamowien'];
	$nazwa[$i]=$wynik['nazwa'];
	$klient_strefa[$i] = $wynik['strefa'];
	}

if($wszyscy == 'wszyscy') echo '<div align="center"><a href="index.php?page=analiza_sprzedaz_klienci">Ukryj</a></div>';
else echo '<div align="center"><a href="index.php?page=analiza_sprzedaz_klienci&wszyscy=wszyscy&SPRAWDZANY_ROK='.$SPRAWDZANY_ROK.'&strefa='.$strefa.'&szukaj_klienta=">Pokaż wszystkich</a></div>';

echo '<table width="700px" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td width="10%">LP</a></td>';
echo '<td width="55%">'.$kol_nazwa.'</td>';
echo '<td width="10%">'.$kol_strefa.'<br>';
	echo '<select name="strefa" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	for($k=1; $k<=$DL_TABELA_STREFY; $k++)
		if($strefa == $TABELA_STREFY[$k]) echo '<option selected="selected" value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
		else echo '<option value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td width="35%">'.$wyraz_Sprzedaz.' netto</td></tr>';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'">';
		echo '<td bgcolor="'.$kolor_tabeli.'">'.$x.'</td>';
		echo '<td>'.$nazwa[$x].'</td>';
		echo '<td>'.$klient_strefa[$x].'</td>';
		$wartosc_zamowien[$x] = number_format($wartosc_zamowien[$x], 2,'.',' ');
		echo '<td>'.$wartosc_zamowien[$x].' zł</td></tr>';
		}
echo '</table>';

echo '</form>';
?>