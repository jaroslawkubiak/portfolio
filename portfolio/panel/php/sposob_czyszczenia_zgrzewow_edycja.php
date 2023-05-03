<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

if($submit)
	{
	if($usunac == 1)
		{
		//echo 'zam id='.$zamowienie_id;
		mysqli_query($conn, "DELETE FROM sposob_czyszczenia_zgrzewow WHERE id = ".$id." LIMIT 1;");
		echo '<div class="text_duzy_niebieski" align="center">Wpis został usunięty.</div>';
		}
	else
		{
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET wew_bialy = '".$wew_bialy."' WHERE id = ".$id.";");
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET wew_1_kolor = '".$wew_1_kolor."' WHERE id = ".$id.";");
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET wew_2_kolor = '".$wew_2_kolor."' WHERE id = ".$id.";");
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET zew_bialy = '".$zew_bialy."' WHERE id = ".$id.";");
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET zew_1_kolor = '".$zew_1_kolor."' WHERE id = ".$id.";");
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET zew_2_kolor = '".$zew_2_kolor."' WHERE id = ".$id.";");
		$pytanie121 = mysqli_query($conn, "UPDATE sposob_czyszczenia_zgrzewow SET wymiar_fasolki = '".$wymiar_fasolki."' WHERE id = ".$id.";");
		echo '<div class="text_duzy_niebieski" align="center">Wpis został zmieniony.</div>';
		}
	}

else	
{

	echo '<div class="text_duzy" align="center">Edytuj sposób czyszczenia zgrzewów</div><br>';
	$pytanie = mysqli_query($conn, "SELECT * FROM sposob_czyszczenia_zgrzewow WHERE id = ".$id.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$klient_id=$wynik['klient_id'];
		$klient_nazwa=$wynik['klient_nazwa'];
		
		$wew_bialy=$wynik['wew_bialy'];
		$wew_1_kolor=$wynik['wew_1_kolor'];
		$wew_2_kolor=$wynik['wew_2_kolor'];
		$zew_bialy=$wynik['zew_bialy'];
		$zew_1_kolor=$wynik['zew_1_kolor'];
		$zew_2_kolor=$wynik['zew_2_kolor'];
		$wymiar_fasolki=$wynik['wymiar_fasolki'];
		}


	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="sposob_czyszczenia_zgrzewow_edycja">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="id" value="'.$id.'">';                                
	
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
			echo '<td rowspan="2">'.$klient_nazwa.'</td>';
			
			
			echo '<td>Wewnętrzna</td>';
			echo '<td>';
				echo '<select name="wew_bialy" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $wew_bialy) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="wew_1_kolor" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $wew_1_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="wew_2_kolor" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $wew_2_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';

			echo '<td rowspan="2">';
				echo '<select name="wymiar_fasolki" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_FREZOWANIA_ODWODNIEN; $k++) 
					if($TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k] == $wymiar_fasolki) echo '<option value="'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'" selected="selected">'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'">'.$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';
			
			
			//#########################
			echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
			echo '<td>Zewnętrzna</td>';
			echo '<td>';
				echo '<select name="zew_bialy" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $zew_bialy) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="zew_1_kolor" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $zew_1_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td>';
			
			echo '<td>';
				echo '<select name="zew_2_kolor" class="pole_input_edycja" style="width: 100%">';
				echo '<option></option>';
				for ($k=1; $k<=$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW; $k++) 
					if($TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k] == $zew_2_kolor) echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'" selected="selected">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
					else echo '<option value="'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'">'.$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';		
		echo '</table>';
		
	echo '<br><div align="center" class="text_red">';
	echo 'Zaznacz, aby usunąć wpis <input type="checkbox" name="usunac" value="1"><br>';
	echo '</div>';
		
	echo '<br><br><div align="center"><input type="submit" name="submit" value="Zapisz"></div>';
	
	echo '</form>';
	}
echo $powrot_do_sposob_czyszczenia_zgrzewow;
echo '</td></tr></table>';

?>