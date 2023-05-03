<?php

echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

$warunek = "";

if($SORT_KLIENT_NAZWA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	else $warunek .= ' AND klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	}          


$id = [];
$klient_id = [];
$klient_nazwa = [];
$wew_bialy = [];
$wew_1_kolor = [];
$wew_2_kolor = [];
$zew_bialy = [];
$zew_1_kolor = [];
$zew_2_kolor = [];
$wymiar_fasolki = [];
$dodal_user_id = [];
$dodal_klient_id = [];
$data_dodania = [];
$KLIENT_NAZWA = [];
$dodal_user_imie = [];
$dodal_user_nazwisko = [];
$data_dod = [];

$i=0;
$pytanie = mysqli_query($conn, "SELECT * FROM sposob_czyszczenia_zgrzewow ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$klient_id[$i]=$wynik['klient_id'];
	$klient_nazwa[$i]=$wynik['klient_nazwa'];
	
	$wew_bialy[$i]=$wynik['wew_bialy'];
	$wew_1_kolor[$i]=$wynik['wew_1_kolor'];
	$wew_2_kolor[$i]=$wynik['wew_2_kolor'];
	$zew_bialy[$i]=$wynik['zew_bialy'];
	$zew_1_kolor[$i]=$wynik['zew_1_kolor'];
	$zew_2_kolor[$i]=$wynik['zew_2_kolor'];
	$wymiar_fasolki[$i]=$wynik['wymiar_fasolki'];
	$dodal_user_id[$i]=$wynik['dodal_user_id'];
	$dodal_klient_id[$i]=$wynik['dodal_klient_id'];
	$data_dodania[$i]=$wynik['data_dodania'];
	}


$ilosc_klientow = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_klientow++;
	$KLIENT_NAZWA[$ilosc_klientow] = $wynik24['nazwa'];
	}
	
	echo '<table border="0" align="center" width="100%"><tr><td align="right">';
		// guzik dodaj nowe sposob
		echo '<table width="200px" align="right" border="0" cellpadding="1" cellspacing="1"><tr class="text"><td width="100%" align="right" valign="middle">';
			echo '<a href="index.php?page=sposob_czyszczenia_zgrzewow_dodaj&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_plusik.'</a>';
		echo '</td><td>';
			echo '<a href="index.php?page=sposob_czyszczenia_zgrzewow_dodaj&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj</a>';
		echo '</td></tr></table>';
	echo '</td></tr>';

	
	echo '<tr align="center"><td>';
		echo '<FORM name="szukaj" method="post">';
		echo '<input type="hidden" name="page" value="sposob_czyszczenia_zgrzewow">';
		echo '<input type="hidden" name="jak" value="'.$jak.'">';
		echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
		echo '<input type="hidden" name="pokaz" value="1">';        
		
		
		echo '<table width="100%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		if($pokaz == 1) echo '<td width="2%" rowspan="2">'.$kol_lp.'<br><a href="index.php?page=sposob_czyszczenia_zgrzewow&jak=ASC&wg_czego=klient_nazwa">'.$image_close.'</a></td>';
		else echo '<td width="2%" rowspan="2">'.$kol_lp.'</td>';
		echo '<td width="15%" rowspan="2">Klient<div align="right"><a href="index.php?page=sposob_czyszczenia_zgrzewow&jak=DESC&wg_czego=klient_nazwa&pokaz='.$pokaz.'">'.$image_arrow_down.'</a><a href="index.php?page=sposob_czyszczenia_zgrzewow&jak=ASC&wg_czego=klient_nazwa&pokaz='.$pokaz.'">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_KLIENT_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_klientow; $k++) 
				if ($KLIENT_NAZWA[$k] == $SORT_KLIENT_NAZWA) echo '<option value="'.$KLIENT_NAZWA[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
				else echo '<option value="'.$KLIENT_NAZWA[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
			echo '</select>';
		echo '</td>';
		echo '<td colspan="4">Sposób czyszczenia zgrzewów</td>';
		echo '<td width="10%" rowspan="2">Wymiar fasolki</td>';
		echo '<td width="15%" rowspan="2">Wpis dodał</td>';
		echo '</tr>';
		
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="15%">Strona profilu</td>';
		echo '<td width="15%">Biały</td>';
		echo '<td width="15%">1xkolor</td>';
		echo '<td width="15%">2xkolor</td>';
		echo '</tr>';
		for ($x=1; $x<=$i; $x++)
			{
			$temp = $x % 2;
			if($temp == 1) $kolor_tla_tabeli = $kolor_bialy; else $kolor_tla_tabeli = $kolor_szary;
			echo '<tr class="text" align="center" bgcolor="'.$kolor_tla_tabeli.'"><td bgcolor="'.$kolor_tabeli.'" class="text" rowspan="2">'.$x.'</td>';
			echo '<td rowspan="2"><a href="index.php?page=sposob_czyszczenia_zgrzewow_edycja&id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$klient_nazwa[$x].'</a></td>';
			echo '<td>Wewnętrzna</td>';
			echo '<td>'.$wew_bialy[$x].'</td>';
			echo '<td>'.$wew_1_kolor[$x].'</td>';
			echo '<td>'.$wew_2_kolor[$x].'</td>';
			echo '<td rowspan="2">'.$wymiar_fasolki[$x].'</td>';
						
			//wpis dodał
			echo '<td rowspan="2">';
			if($dodal_klient_id[$x] != '') echo '<font color="blue">Klient<br>';
			if($dodal_user_id[$x] != '') 
				{
				$pytanie294 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$dodal_user_id[$x].";");
				while($wynik294= mysqli_fetch_assoc($pytanie294))
					{
					$dodal_user_imie[$x] = $wynik294['imie'];
					$dodal_user_nazwisko[$x] = $wynik294['nazwisko'];
					}
				echo '<font color="#56c451">'.$dodal_user_imie[$x].' '.$dodal_user_nazwisko[$x].'<br>';
				}
			$data_dod[$x] = date('d-m-Y, H:i:s', $data_dodania[$x]);
			echo $data_dod[$x].'</font>';
			echo '</td>';
			echo '</tr>';
			
			echo '<tr class="text" align="center" bgcolor="'.$kolor_tla_tabeli.'">';
			echo '<td>Zewnętrzna</td>';
			echo '<td>'.$zew_bialy[$x].'</td>';
			echo '<td>'.$zew_1_kolor[$x].'</td>';
			echo '<td>'.$zew_2_kolor[$x].'</td>';
			echo '</tr>';
			}
			echo '</table>';
		echo '</form>';
	echo '</td></tr><table>';

echo '</td></tr></table>';

?>