<?php
echo '<table width="1300px" align="left"><tr><td>';

if($submit)
{
	$result = True;
	if($promien_z_gwa == '') $promien_z_gwa = 0;
	if($promien_bez_gwa == '') $promien_bez_gwa = 0;
	$query = "INSERT INTO minimalne_promienie (`system`, `symbol_profilu`, `promien_z_gwa`, `promien_bez_gwa`) values ('$SYSTEM', '$SYMBOL_PROFILU', '$promien_z_gwa', '$promien_bez_gwa');";
	show_mysqli_query($conn, $query);
	
	echo '<div class="text_duzy_niebieski" align="center">Wpis został dodany</div>';
	echo '<br><div class="text_duzy_niebieski" align="center"><a href="index.php?page=minimalne_promienie_dodaj&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj kolejny</a></div>';
	
	echo $powrot_do_minimalne_promienie;
}
else
{
$i=0;
$system = [];
$symbol_profilu = [];

$pytanie = mysqli_query($conn, "SELECT * FROM magazyn ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$system[$i]=$wynik['system'];
	$symbol_profilu[$i]=$wynik['symbol_profilu'];
	}
	
$system2 = array_unique($system);
$system_opis = array_values(array_filter($system2));
sort ($system_opis);
$ilosc_systemow = count($system_opis);


$symbol_profilu2 = array_unique($symbol_profilu);
$symbol_profilu_opis = array_values(array_filter($symbol_profilu2));
sort ($symbol_profilu_opis);
$ilosc_symboli_profili = count($symbol_profilu_opis);



echo '<div class="text_duzy" align="center">Dodaj pozycję</div>';

echo '<table width="50%" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';
echo '<FORM action="index.php?page=minimalne_promienie_dodaj" method="post">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
echo '<input type="hidden" name="SORT_SYSTEM" value="'.$SORT_SYSTEM.'">';
echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="'.$SORT_SYMBOL_PROFILU.'">';

	echo '<table width="100%" align="center" border="0" cellpadding=3>';
	echo '<tr align="center"><td align="right" class="text" width="50%">System : </td><td align="left" width="50%">';
		echo '<select name="SYSTEM" class="pole_input" style="width: 200px">';
		echo '<option></option>';
		for ($k=0; $k<=$ilosc_systemow-1; $k++) 
			if ($system_opis[$k] == $SYSTEM) echo '<option value="'.$system_opis[$k].'" selected="selected">'.$system_opis[$k].'</option>';
			else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
		echo '</select></td></tr>';
	echo '</td></tr>';
	
	echo '<tr align="center"><td align="right" class="text">Symbol profilu : </td><td align="left">';
		echo '<select name="SYMBOL_PROFILU" class="pole_input" style="width: 200px">';
		echo '<option></option>';
		for ($k=0; $k<=$ilosc_symboli_profili-1; $k++) 
				if ($symbol_profilu_opis[$k] == $SORT_SYMBOL_PROFILU) echo '<option value="'.$symbol_profilu_opis[$k].'" selected="selected">'.$symbol_profilu_opis[$k].'</option>';
				else echo '<option value="'.$symbol_profilu_opis[$k].'">'.$symbol_profilu_opis[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';		
	
	echo '<tr align="center"><td align="right" class="text">Minimalny R z gwarancją (mm) : </td><td align="left"><input autocomplete="off" type="text" size="5" maxlength="10" class="pole_input" name="promien_z_gwa" value="'.$promien_z_gwa.'"></td></tr>';
	
	echo '<tr align="center"><td align="right" class="text">Minimalny R bez gwarancji (mm) : </td><td align="left"><input autocomplete="off" type="text" size="5" maxlength="10" class="pole_input" name="promien_bez_gwa" value="'.$promien_bez_gwa.'"></td></tr>';
	
	echo '<tr class="Text"><td align="center" colspan=2>';
	echo '<INPUT type="submit" name="submit" value="Dodaj">';
	echo '</td></tr></table>';

echo '</FORM>';


echo '</td></tr></table>';
}
echo '</td></tr></table>';
?>