<?php
if($LIMIT == 'brak') $LIMIT = ''; else $LIMIT = ' LIMIT 100';
$warunek = "";

if($SORT_KLIENT != "") 
	{
	if($warunek == "") $warunek .= 'WHERE nabywca_id = '.$SORT_KLIENT.'';
	else $warunek .= ' AND nabywca_id = '.$SORT_KLIENT.'';
	}
	     
if($SORT_USER != "") 
	{
	if($warunek == "") $warunek .= 'WHERE user_id = '.$SORT_USER.'';
	else $warunek .= ' AND user_id = '.$SORT_USER.'';
	}
	
if($SORT_NR_FV != "") 
	{
	if($warunek == "") $warunek .= 'WHERE fv_id = '.$SORT_NR_FV.'';
	else $warunek .= ' AND fv_id = '.$SORT_NR_FV.'';
	}
	
if($SORT_DATA_WPLATY != "") 
	{
	if($warunek == "") $warunek .= 'WHERE data_wplaty = "'.$SORT_DATA_WPLATY.'"';
	else $warunek .= ' AND data_wplaty = "'.$SORT_DATA_WPLATY.'"';
	}
	
if($SORT_ZAMOWIENIE != "") 
	{
	if($warunek == "") $warunek .= 'WHERE zamowienie_id = '.$SORT_ZAMOWIENIE.'';
	else $warunek .= ' AND zamowienie_id = '.$SORT_ZAMOWIENIE.'';
	}


$nr_fv = [];
$zamowienie_id = [];
$nabywca_id = [];
$data_wplaty = [];
$wartosc_wplaty = [];
$user_id = [];
$user_imie = [];
$user_nazwisko = [];
$nr_zamowienia = [];
$klient_nazwa = [];
$KLIENT_NAZWA = [];
$TAB_USER_ID = [];
$USER_IMIE = [];
$USER_NAZWISKO = [];
$TAB_FV_ID = [];
$TAB_FV_NR = [];
$TAB_ZAMOWIENIE_ID = [];
$TAB_ZAMOWIENIE_NR = [];

$i=0;
$pytanie = mysqli_query($conn, "SELECT * FROM fv_wplaty ".$warunek." ORDER BY ".$wg_czego." ".$jak." ".$LIMIT.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$nr_fv[$i]=$wynik['nr_fv'];
	$zamowienie_id[$i]=$wynik['zamowienie_id'];
	$nabywca_id[$i]=$wynik['nabywca_id'];
	$data_wplaty[$i]=$wynik['data_wplaty'];
	$wartosc_wplaty[$i]=$wynik['wartosc_wplaty'];
	$user_id[$i]=$wynik['user_id'];
	$user_imie[$i]=$wynik['user_imie'];
	$user_nazwisko[$i]=$wynik['user_nazwisko'];
	
	$pytanie2 = mysqli_query($conn, "SELECT nr_zamowienia FROM zamowienia WHERE id = ".$zamowienie_id[$i].";");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$nr_zamowienia[$i]=$wynik2['nr_zamowienia'];
		}
	
	$pytanie3 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$nabywca_id[$i].";");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$klient_nazwa[$i]=$wynik3['nazwa'];
		}
	}

$ilosc_klientow = 0;
$pytanie24 = mysqli_query($conn, "SELECT DISTINCT nabywca_id FROM fv_wplaty ORDER BY nabywca_id ASC;");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_klientow++;
	$KLIENT_ID[$ilosc_klientow] = $wynik24['nabywca_id'];
	$pytanie3 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$KLIENT_ID[$ilosc_klientow].";");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$KLIENT_NAZWA[$ilosc_klientow]=$wynik3['nazwa'];
		}
	}

$ilosc_userow = 0;
$pytanie25 = mysqli_query($conn, "SELECT DISTINCT user_id FROM fv_wplaty ORDER BY user_id ASC;");
while($wynik25= mysqli_fetch_assoc($pytanie25))
	{
	$ilosc_userow++;
	$TAB_USER_ID[$ilosc_userow] = $wynik25['user_id'];
	$pytanie4 = mysqli_query($conn, "SELECT imie, nazwisko FROM uzytkownicy WHERE id = ".$TAB_USER_ID[$ilosc_userow].";");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$USER_IMIE[$ilosc_userow]=$wynik4['imie'];
		$USER_NAZWISKO[$ilosc_userow]=$wynik4['nazwisko'];
		}
	}
			
$ilosc_faktur = 0;
$pytanie26 = mysqli_query($conn, "SELECT DISTINCT fv_id FROM fv_wplaty ORDER BY fv_id DESC;");
while($wynik26= mysqli_fetch_assoc($pytanie26))
	{
	$ilosc_faktur++;
	$TAB_FV_ID[$ilosc_faktur] = $wynik26['fv_id'];
	if(isset($TAB_FV_ID[$ilosc_faktur])) 
		{
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nr_dok FROM fv_naglowek WHERE id = ".$TAB_FV_ID[$ilosc_faktur].";"));
		if(isset($sql['nr_dok'])) $TAB_FV_NR[$ilosc_faktur] = $sql['nr_dok'];
		}
	}


$ilosc_zamowien = 0;
$pytanie27 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM fv_wplaty ORDER BY zamowienie_id ASC;");
while($wynik27= mysqli_fetch_assoc($pytanie27))
	{
	$ilosc_zamowien++;
	$TAB_ZAMOWIENIE_ID[$ilosc_zamowien] = $wynik27['zamowienie_id'];
	$pytanie6 = mysqli_query($conn, "SELECT nr_zamowienia FROM zamowienia WHERE id = ".$TAB_ZAMOWIENIE_ID[$ilosc_zamowien].";");
	while($wynik6= mysqli_fetch_assoc($pytanie6))
		{
		$TAB_ZAMOWIENIE_NR[$ilosc_zamowien]=$wynik6['nr_zamowienia'];
		}
	}

echo '<table align="left" border="0"><tr align="center"><td>';

	if($LIMIT == '') echo '<div class="text" align="center"><a href="index.php?page=fv_lista_wplat&jak=DESC&wg_czego=id&LIMIT=LIMIT 100"><font color="black">Ukryj pozostałe wpłaty</font></a></div>';
	else echo '<div class="text" align="center"><a href="index.php?page=fv_lista_wplat&jak=DESC&wg_czego=id&LIMIT=brak"><font color="black">Pokaż wszystkie wpłaty</font></a></div>';

echo '</td></tr>';

echo '<tr><td>';
	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="fv_lista_wplat">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="pokaz" value="1">';        
							 
	echo '<table align="left" border="0" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text" valign="top">';
	if($pokaz == 1) echo '<td width="40px">'.$kol_lp.'<br><a href="index.php?page=fv_lista_wplat&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_close.'</a>';
	else echo '<td width="40px">'.$kol_lp.'</td>';
	
	echo '<td width="120px">Nr faktury';
		echo '<select name="SORT_NR_FV" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_faktur; $k++) 
				if ($TAB_FV_ID[$k] == $SORT_NR_FV) echo '<option value="'.$TAB_FV_ID[$k].'" selected="selected">'.$TAB_FV_NR[$k].'</option>';
				else echo '<option value="'.$TAB_FV_ID[$k].'">'.$TAB_FV_NR[$k].'</option>';
		echo '</select>';
	echo '</td>';
	
	echo '<td width="150px">Nr zamówienia';
		echo '<select name="SORT_ZAMOWIENIE" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_zamowien; $k++) 
				if ($TAB_ZAMOWIENIE_ID[$k] == $SORT_ZAMOWIENIE) echo '<option value="'.$TAB_ZAMOWIENIE_ID[$k].'" selected="selected">'.$TAB_ZAMOWIENIE_NR[$k].'</option>';
				else echo '<option value="'.$TAB_ZAMOWIENIE_ID[$k].'">'.$TAB_ZAMOWIENIE_NR[$k].'</option>';
		echo '</select>';
	echo '</td>';
	
	
	echo '<td width="180px">Klient';
		echo '<select name="SORT_KLIENT" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_klientow; $k++) 
				if ($KLIENT_ID[$k] == $SORT_KLIENT) echo '<option value="'.$KLIENT_ID[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
				else echo '<option value="'.$KLIENT_ID[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
		echo '</select>';
	echo '</td>';
	
	
	echo '<td width="190px">Data wpłaty<br>';
	echo '<input type="text" size="8" class="pole_input_czerwone" autocomplete="off" name="SORT_DATA_WPLATY" id="f_data_wplaty" value="'.$SORT_DATA_WPLATY.'"><input type="submit" value="->"></td>';
	?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_data_wplaty",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_data_wplaty",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	<?php
	
	
	echo '<td width="120px">Wartość wpłaty</td>';
	echo '<td width="180px">Dodał';
		echo '<select name="SORT_USER" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_userow; $k++) 
				if ($TAB_USER_ID[$k] == $SORT_USER) echo '<option value="'.$TAB_USER_ID[$k].'" selected="selected">'.$USER_IMIE[$k].' '.$USER_NAZWISKO[$k].'</option>';
				else echo '<option value="'.$TAB_USER_ID[$k].'">'.$USER_IMIE[$k].' '.$USER_NAZWISKO[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';
	
		for ($x=1; $x<=$i; $x++)
			{
			echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
			echo '<td>'.$nr_fv[$x].'</td>';
			echo '<td>'.$nr_zamowienia[$x].'</td>';
			echo '<td>'.$klient_nazwa[$x].'</td>';
			echo '<td>'.$data_wplaty[$x].'</td>';
			$wartosc_wplaty[$x] = number_format($wartosc_wplaty[$x], 2,'.',' ');
			echo '<td>'.$wartosc_wplaty[$x].'</td>';
			echo '<td>'.$user_imie[$x].' '.$user_nazwisko[$x].'</td></tr>';
			}
	echo '</table>';
	echo '</form>';
echo '</td></tr></table>';
?>