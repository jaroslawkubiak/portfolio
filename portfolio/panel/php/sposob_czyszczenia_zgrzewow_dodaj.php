<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';


$baza_klient_id = [];
$baza_klient_nazwa = [];

$ilosc_klientow=0;
$pytanie = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_klientow++;
	$baza_klient_id[$ilosc_klientow]=$wynik['id'];
	$baza_klient_nazwa[$ilosc_klientow]=$wynik['nazwa'];
	}
  
if($submit)
	{
	$pytanie6 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id.";");
	while($wynik6= mysqli_fetch_assoc($pytanie6))
		{
		$temp_klient_nazwa=$wynik6['nazwa'];
		}
	
	$query = mysqli_query($conn, "INSERT INTO sposob_czyszczenia_zgrzewow (`klient_id`, `klient_nazwa`, `wew_bialy`, `wew_1_kolor`, `wew_2_kolor`, `zew_bialy`, `zew_1_kolor`, `zew_2_kolor`, `dodal_user_id`, `data_dodania`, `wymiar_fasolki`) values ('$klient_id', '$temp_klient_nazwa', '$wew_bialy', '$wew_1_kolor', '$wew_2_kolor', '$zew_bialy', '$zew_1_kolor', '$zew_2_kolor', $user_id, '$time', '$wymiar_fasolki');");
	echo '<div class="text_duzy_niebieski" align="center">Wpis został dodany</div>';
	}
else
	{
	echo '<div class="text_duzy" align="center">Dodaj nowy sposób czyszczenia zgrzewów</div><br>';
	echo '<FORM name="szukaj" method="post">';
	echo '<input type="hidden" name="page" value="sposob_czyszczenia_zgrzewow_dodaj">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	
		echo '<table width="100%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="20%" rowspan="2">Klient</td>';
		echo '<td width="18%" colspan="4">Sposób czyszczenia zgrzewów</td>';
		echo '<td width="20%" rowspan="2">Wymiar fasolki</td>';
		echo '</tr>';
		
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="15%">Strona profilu</td>';
		echo '<td width="15%">Biały</td>';
		echo '<td width="15%">1xkolor</td>';
		echo '<td width="15%">2xkolor</td>';
		echo '</tr>';
	
			echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
			echo '<td rowspan="2">';
				echo '<select name="klient_id" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_klientow; $k++) 
					if ($baza_klient_nazwa[$k] == $klient_id) echo '<option value="'.$baza_klient_id[$k].'" selected="selected">'.$baza_klient_nazwa[$k].'</option>';
					else echo '<option value="'.$baza_klient_id[$k].'">'.$baza_klient_nazwa[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			
			echo '<td>Wewnętrzna</td>';
			echo '<td>';
				echo '<select name="wew_bialy" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $wew_bialy) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="wew_1_kolor" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $wew_1_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="wew_2_kolor" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $wew_2_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';

			echo '<td rowspan="2">';
				echo '<select name="wymiar_fasolki" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_FREZOWANIA_ODWODNIEN; $k++) 
					if($TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k] == $wymiar_fasolki) echo '<option value="'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'" selected="selected">'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'">'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'</option>';
				echo '</select>';
			echo '</td>';
	
			echo '</tr>';
			
			
			echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
			echo '<td>Zewnętrzna</td>';
			echo '<td>';
				echo '<select name="zew_bialy" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $zew_bialy) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="zew_1_kolor" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $zew_1_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="zew_2_kolor" class="pole_input_biale" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $zew_2_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';		
	
		echo '</table>';
	echo '<br><br><div align="center"><input type="submit" name="submit" value="Dodaj"></div>';
	
	echo '</form>';
	}
echo $powrot_do_sposob_czyszczenia_zgrzewow;
echo '</td></tr></table>';

?>