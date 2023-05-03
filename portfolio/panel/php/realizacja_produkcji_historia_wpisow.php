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

	input.produkcja_checkbox
	{
		/* Double-sized Checkboxes */
		-ms-transform: scale(3); /* IE */
		-moz-transform: scale(3); /* FF */
		-webkit-transform: scale(3); /* Safari and Chrome */
		-o-transform: scale(3); /* Opera */
		padding: 100px;

	}
	input.button_produkcja 
	{
		width: 300px;  
		height: 300px;
		font:Arial, Helvetica, sans-serif;
		font-size:36px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_maly
	{
		width: 200px;  
		height: 200px;
		font:Arial, Helvetica, sans-serif;
		font-size:24px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_mniejszy
	{
		width: 150px;  
		height: 50px;
		font:Arial, Helvetica, sans-serif;
		font-size:30px;
		font-weight: Bold;
		white-space: normal;
	}


	input.button_zapisz_produkcja 
	{
		width: 150px;  
		height: 100px;
		font:Arial, Helvetica, sans-serif;
		font-size:36px;
		font-weight: Bold;
		white-space: normal;
	}

	.pole_input_produkcja
	{
		width: 100%; 
		height: 40px;
		border: #000000 1px solid;
		background-color:#e24139;
		color: #000000;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 22px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}

	.pole_input_produkcja_kalendarz
	{
		height: 60px;
		border: #000000 1px solid;
		background-color:#e24139;
		color: #000000;
		text-align:center;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 24px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}
</style>

<?php	
echo '<table align="left" width="100%" border="0"><tr align="center" class="text"><td>';

if(($data_poczatkowa == '') && ($data_koncowa == ''))
	{
	$data_poczatkowa = date('d-m-Y', $time);
	$data_koncowa = date('d-m-Y', $time);
	}

	$data_poczatkowa_pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$data_poczatkowa_pieces[1], $data_poczatkowa_pieces[0], $data_poczatkowa_pieces[2]);
	$data_koncowa_pieces = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$data_koncowa_pieces[1], $data_koncowa_pieces[0], $data_koncowa_pieces[2]);
	
	//zpisujemy poszczególne składowe z daty
	$data_poczatkowa_dzien = $data_poczatkowa_pieces[0];
	$data_poczatkowa_dzien = $data_poczatkowa_dzien * 1;
	$data_poczatkowa_miesiac = $data_poczatkowa_pieces[1];
	$data_poczatkowa_miesiac = $data_poczatkowa_miesiac * 1; // mnożąc przez 1 pozbywamy się zera przy np wrześniu 09 - nie wyszukuje w bazie
	
	$data_poczatkowa_rok = $data_poczatkowa_pieces[2];
	$data_koncowa_dzien = $data_koncowa_pieces[0];
	$data_koncowa_dzien = $data_koncowa_dzien * 1;
	$data_koncowa_miesiac = $data_koncowa_pieces[1];
	$data_koncowa_miesiac = $data_koncowa_miesiac * 1;
	$data_koncowa_rok = $data_koncowa_pieces[2];



$uzytk_id = [];
$imie = [];
$nazwisko = [];
$IMIE = [];
$NAZWISKO = [];
$lista_zamowien_nr = [];
$ilosc_pracownikow=0;
$pytanie1 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' ORDER BY ID ASC;");
while($wynik1= mysqli_fetch_assoc($pytanie1))
	{
	$ilosc_pracownikow++;
	$user_id1=$wynik1['id'];
	$uzytk_id[$ilosc_pracownikow]=$wynik1['id'];
	$imie[$user_id1]=$wynik1['imie'];
	$nazwisko[$user_id1]=$wynik1['nazwisko'];
	$IMIE[$ilosc_pracownikow]=$wynik1['imie'];
	$NAZWISKO[$ilosc_pracownikow]=$wynik1['nazwisko'];
	}


if($usun != '')
	{
	mysqli_query($conn, "DELETE FROM realizacja_produkcji WHERE id = ".$usun." LIMIT 1");
	echo '<div align="center" class="text_duzy_niebieski">Wpis został usunięty.</div>';
	}
	
$WARUNEK = '';
if($data_poczatkowa != '')
	{
	if($WARUNEK == "") $WARUNEK = ' WHERE  data_wykonania_rok >= "'.$data_poczatkowa_rok.'" AND data_wykonania_miesiac >= "'.$data_poczatkowa_miesiac.'" AND data_wykonania_dzien >= "'.$data_poczatkowa_dzien.'"';
	else $WARUNEK .= ' AND  data_wykonania_rok >= "'.$data_poczatkowa_rok.'" AND data_wykonania_miesiac >= "'.$data_poczatkowa_miesiac.'" AND data_wykonania_dzien >= "'.$data_poczatkowa_dzien.'"';
	}   
	
	       
if($data_koncowa != '')
	{
	if($WARUNEK == "") $WARUNEK = ' WHERE data_wykonania_rok <= "'.$data_koncowa_rok.'" AND data_wykonania_miesiac <= "'.$data_koncowa_miesiac.'" AND data_wykonania_dzien <= "'.$data_koncowa_dzien.'"';
	else $WARUNEK .= ' AND data_wykonania_rok <= "'.$data_koncowa_rok.'" AND data_wykonania_miesiac <= "'.$data_koncowa_miesiac.'" AND data_wykonania_dzien <= "'.$data_koncowa_dzien.'"';
	}          

if($sprawdzany_pracownik != '')
	{
	if($WARUNEK == "") $WARUNEK = ' WHERE (pracownik_a = '.$sprawdzany_pracownik.' OR pracownik_b = '.$sprawdzany_pracownik.' OR pracownik_c = '.$sprawdzany_pracownik.' OR pracownik_d = '.$sprawdzany_pracownik.')';
	else $WARUNEK .= ' AND (pracownik_a = '.$sprawdzany_pracownik.' OR pracownik_b = '.$sprawdzany_pracownik.' OR pracownik_c = '.$sprawdzany_pracownik.' OR pracownik_d = '.$sprawdzany_pracownik.')';
	}          

if($sprawdzane_zamowienie != '')
	{
	if($WARUNEK == "") $WARUNEK = ' WHERE nr_zamowienia = "'.$sprawdzane_zamowienie.'"';
	else $WARUNEK .= ' AND nr_zamowienia = "'.$sprawdzane_zamowienie.'"';
	}   
	       
if($szukane_zamowienie != '')
	{
	$WARUNEK = " WHERE nr_zamowienia LIKE '%".$szukane_zamowienie."%'";
	}  


$i=0;
$akord_id = [];
$zamowienie_id = [];
$data_wykonania = [];
$pozycja = [];
$rodzaj_produktu = [];
$ilosc = [];
$pracownik_a = [];
$pracownik_b = [];
$pracownik_c = [];
$pracownik_d = [];
$nr_zamowienia = [];
$klient_nazwa = [];
$zamowic_profile = [];
$wartosc_produkcji = [];
$wartosc_profili = [];
$SUMA_WARTOSC_PRODUKCJI = 0;
$SUMA_WARTOSC_PROFILI = 0;
$ilosc_zamowien = 0;

// echo 'war='.$WARUNEK.'<br>';

$pytanie = mysqli_query($conn, "SELECT id, zamowienie_id, data_wykonania, pozycja, rodzaj_produktu, ilosc, pracownik_a, pracownik_b, pracownik_c, pracownik_d, nr_zamowienia, zamowic_profile, wartosc_realizacji, wartosc_profili FROM realizacja_produkcji ".$WARUNEK." ORDER BY ID DESC;");

while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$akord_id[$i]=$wynik['id'];
	$zamowienie_id[$i]=$wynik['zamowienie_id'];
	$data_wykonania[$i]=$wynik['data_wykonania'];
	$pozycja[$i]=$wynik['pozycja'];	
	$rodzaj_produktu[$i]=$wynik['rodzaj_produktu'];
	$ilosc[$i]=$wynik['ilosc'];
	$pracownik_a[$i]=$wynik['pracownik_a'];
	$pracownik_b[$i]=$wynik['pracownik_b'];
	$pracownik_c[$i]=$wynik['pracownik_c'];
	$pracownik_d[$i]=$wynik['pracownik_d'];
	$nr_zamowienia[$i]=$wynik['nr_zamowienia'];
	$wartosc_produkcji[$i]=number_format($wynik['wartosc_realizacji'], 2,'.','');
	$wartosc_profili[$i]=number_format($wynik['wartosc_profili'], 2,'.','');

	$SUMA_WARTOSC_PRODUKCJI += $wartosc_produkcji[$i];
	$SUMA_WARTOSC_PROFILI += $wartosc_profili[$i];
	$zamowic_profile[$i]=$wynik['zamowic_profile'];
	if($zamowic_profile[$i] == 'on') $zamowic_profile[$i] = 'TAK';
	}
  
//echo 'i='.$i.'<br>';
$SUMA_WARTOSC_PRODUKCJI = number_format($SUMA_WARTOSC_PRODUKCJI, 2,'.',' ');
$SUMA_WARTOSC_PROFILI = number_format($SUMA_WARTOSC_PROFILI, 2,'.',' ');


//tworze liste nr zamowien do sortowania
$result = array_unique($nr_zamowienia);
sort($result);
for ($a=0; $a<=$i; $a++) 
{
	if($result[$a] != '')
	{
		$ilosc_zamowien++;
		$lista_zamowien_nr[$ilosc_zamowien]=$result[$a];
	}
}


echo '<FORM action="index.php?page=realizacja_produkcji_historia_wpisow" method="post">';

echo '<INPUT type="hidden" name="page" value="realizacja_produkcji_historia_wpisow">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';

	echo '<table width="100%" align="center" cellspacing="5" cellpadding="5" border="0" bgcolor="'.$kolor_tabeli.'"><tr align="center" class="text_duzy">';
	echo '<td align="center">';
		echo 'Data początkowa - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_poczatkowa" id="f_data_poczatkowa" value="'.$data_poczatkowa.'">';
		echo '</td><td>Data końcowa - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_koncowa" id="f_data_koncowa" value="'.$data_koncowa.'">';
	
	echo '<td align="center">Pracownik<br>';
		echo '<select name="sprawdzany_pracownik" class="pole_input_produkcja">';
		echo '<option></option>';
		for ($a=1; $a<=$ilosc_pracownikow; $a++) 
		if($sprawdzany_pracownik == $uzytk_id[$a]) echo '<option value="'.$uzytk_id[$a].'" selected="selected">'.$IMIE[$a].' '.$NAZWISKO[$a].'</option>';
		else echo '<option value="'.$uzytk_id[$a].'">'.$IMIE[$a].' '.$NAZWISKO[$a].'</option>';
		echo '</select>';
	echo '</td>';
	
	echo '<td>Nr zamówienia<br>';
		echo '<select name="sprawdzane_zamowienie" class="pole_input_produkcja">';
		echo '<option></option>';
		for ($a=1; $a<=$ilosc_zamowien; $a++) 
		if($sprawdzane_zamowienie == $lista_zamowien_nr[$a]) echo '<option value="'.$lista_zamowien_nr[$a].'" selected="selected">'.$lista_zamowien_nr[$a].'</option>';
		else echo '<option value="'.$lista_zamowien_nr[$a].'">'.$lista_zamowien_nr[$a].'</option>';
		echo '</select>';
	echo '</td>';
	
	echo '<td>Szukane zamówienie<br>';
		echo '<input type="text" size="5" maxlenght="10" name="szukane_zamowienie" class="pole_input_produkcja" value="'.$szukane_zamowienie.'">';
	echo '</td>';

	echo '<td align="center"><input type="submit" name="pokaz" value="Pokaż" class="button_produkcja_mniejszy"></td>';
	echo '<td align="center"><a href="index.php?page=realizacja_produkcji_historia_wpisow"><input type="button" value="Reset" class="button_produkcja_mniejszy"></a></td>';
	echo '</tr></table>';
echo '</form>';
	?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_data_poczatkowa",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_data_poczatkowa",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_data_koncowa",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_data_koncowa",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
<?php
/*
echo 'data_poczatkowa_dzien='.$data_poczatkowa_dzien.'<br>';
echo 'data_poczatkowa_miesiac='.$data_poczatkowa_miesiac.'<br>';
echo 'data_poczatkowa_rok='.$data_poczatkowa_rok.'<br>';
echo 'data_koncowa_dzien='.$data_koncowa_dzien.'<br>';
echo 'data_koncowa_miesiac='.$data_koncowa_miesiac.'<br>';
echo 'data_koncowa_rok='.$data_koncowa_rok.'<br>';
*/




$szer_kol_data_wykonania = 200;
$szer_kol_klient = 270;
$szer_kol_nr_zamowienia = 170;
$szer_kol_pozycja = 120;
$szer_kol_rodzaj_produktu = 320;
$szer_kol_ilosc = 80;
$szer_kol_zamowic_profile = 100;
$szer_kol_pracownik = 700;
$szer_kol_wartosc_produkcji = 200;
$szer_kol_edycja = 50;
$szer_tabela = $szer_kol_data_wykonania + $szer_kol_klient + $szer_kol_nr_zamowienia + $szer_kol_pozycja + $szer_kol_rodzaj_produktu + $szer_kol_ilosc + $szer_kol_zamowic_profile + $szer_kol_pracownik + $szer_kol_wartosc_produkcji + $szer_kol_wartosc_produkcji + $szer_kol_edycja + $szer_kol_edycja;

echo '<table width="'.$szer_tabela.'px" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td width="'.$szer_kol_data_wykonania.'px">'.$kol_data_wykonania.'</td>';
echo '<td width="'.$szer_kol_klient.'px">'.$kol_klient.'</td>';
echo '<td width="'.$szer_kol_nr_zamowienia.'px">'.$kol_nr_zamowienia.'</td>';
echo '<td width="'.$szer_kol_pozycja.'px">'.$kol_pozycja.'</td>';
echo '<td width="'.$szer_kol_rodzaj_produktu.'px">'.$kol_rodzaj_produktu.'</td>';
echo '<td width="'.$szer_kol_ilosc.'px">'.$kol_ilosc.'</td>';
echo '<td width="'.$szer_kol_zamowic_profile.'px">'.$kol_zamowic_profile.'</td>';
echo '<td width="'.$szer_kol_pracownik.'px">'.$kol_pracownik.'</td>';
if($user_stanowisko == 'administrator') 
{
	echo '<td width="'.$szer_kol_wartosc_produkcji.'px">Wartość realizacji<br>'.$SUMA_WARTOSC_PRODUKCJI.' zł</td>';
	echo '<td width="'.$szer_kol_wartosc_produkcji.'px">'.$kol_wartosc_profili.'<br>'.$SUMA_WARTOSC_PROFILI.' zł</td>';
	echo '<td width="'.$szer_kol_edycja.'px">Edycja</td>';
	echo '<td width="'.$szer_kol_edycja.'px">Usuń</td>';
}
echo '</tr>';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'">';
		$data = date("d-m-Y, H:m:s", $data_wykonania[$x]);
		echo '<td>'.$data.'</td>';
		// $query = mysqli_query($conn, );
		// $klient_nazwa[$x] = mysql_result($query, 0, 0);
		
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT klient_nazwa FROM zamowienia WHERE id = ".$zamowienie_id[$x].";"));
		$klient_nazwa[$x] = $sql['klient_nazwa'];
		

		echo '<td>'.$klient_nazwa[$x].'</td>';
		echo '<td>'.$nr_zamowienia[$x].'</td>';
		if($pozycja[$x] == 'on') echo '<td>Wszystkie</td>';
		else echo '<td>'.$pozycja[$x].'</td>';
		echo '<td>'.$TABELA_LISTA_PRODUKTOW[$rodzaj_produktu[$x]].'</td>';
		echo '<td>'.$ilosc[$x].'</td>';
		echo '<td>'.$zamowic_profile[$x].'</td>';
		echo '<td>'.$imie[$pracownik_a[$x]].' '.$nazwisko[$pracownik_a[$x]].' ';
		if($pracownik_b[$x] != 0) echo '('.$imie[$pracownik_b[$x]].' '.$nazwisko[$pracownik_b[$x]];
		if($pracownik_c[$x] != 0) echo ', '.$imie[$pracownik_c[$x]].' '.$nazwisko[$pracownik_c[$x]];
		if($pracownik_d[$x] != 0) echo ', '.$imie[$pracownik_d[$x]].' '.$nazwisko[$pracownik_d[$x]];
		if($pracownik_b[$x] != 0) echo ')';
		echo '</td>';
		if($user_stanowisko == 'administrator') 
		{

			if($wartosc_produkcji[$x] != 0) echo '<td width="5%">'.$wartosc_produkcji[$x].$waluta.'</td>';
			else echo '<td width="5%"></td>';

			if($wartosc_profili[$x] != 0) echo '<td width="5%">'.$wartosc_profili[$x].$waluta.'</td>';
			else echo '<td width="5%"></td>';

			echo '<td width="5%"><a href="index.php?page=realizacja_produkcji_edycja_akordu&jak=DESC&wg_czego=id&akord_do_edycji='.$akord_id[$x].'&data_poczatkowa='.$data_poczatkowa.'&data_koncowa='.$data_koncowa.'&sprawdzany_pracownik='.$sprawdzany_pracownik.'&sprawdzane_zamowienie='.$sprawdzane_zamowienie.'">'.$image_edit.'</a></td>';
			
			echo '<td width="5%"><a href="index.php?page=realizacja_produkcji_historia_wpisow&jak=DESC&wg_czego=id&usun='.$akord_id[$x].'&data_poczatkowa='.$data_poczatkowa.'&data_koncowa='.$data_koncowa.'&sprawdzany_pracownik='.$sprawdzany_pracownik.'&sprawdzane_zamowienie='.$sprawdzane_zamowienie.'">'.$image_trash_mini.'</a></td>';
		}

		echo '</tr>';
		}
		
echo '</table>';

echo '</td></tr></table>';

?>