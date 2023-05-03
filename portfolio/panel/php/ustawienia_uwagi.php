<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Uwagi</div><br>';

if($zmiana_danych == 1)
	{
	$ins=mysqli_query($conn, "UPDATE ustawienia_uwagi SET uwaga='".$uwaga[1]."' WHERE id = 1;");
	$ins=mysqli_query($conn, "UPDATE ustawienia_uwagi SET uwaga='".$uwaga[2]."' WHERE id = 2;");
	$ins=mysqli_query($conn, "UPDATE ustawienia_uwagi SET uwaga='".$uwaga[3]."' WHERE id = 3;");
	$ins=mysqli_query($conn, "UPDATE ustawienia_uwagi SET uwaga='".$uwaga[4]."' WHERE id = 4;");
	$ins=mysqli_query($conn, "UPDATE ustawienia_uwagi SET uwaga='".$uwaga[5]."' WHERE id = 5;");
	
	echo '<div class="text_duzy_niebieski" align="center">Uwagi zostały zmienione.</div>';
	}
	
	
	
	$uwaga = [];
	$i = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM ustawienia_uwagi ORDER BY id ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$uwaga[$i]=$wynik['uwaga'];
		}


	echo '<FORM action="index.php?page=ustawienia_uwagi&zmiana_danych=1" method="post">';
	echo '<table border="0" align="center" cellpadding="5" cellspacing="5">';


		echo '<tr class="text"><td width="100%" align="left"><input type="text" size="120" maxlength="110" class="pole_input_biale" autocomplete="off" name="uwaga[1]" value="'.$uwaga[1].'"></td></tr>';
		echo '<tr class="text"><td width="100%" align="left"><input type="text" size="120" maxlength="110" class="pole_input_biale" autocomplete="off" name="uwaga[2]" value="'.$uwaga[2].'"></td></tr>';
		echo '<tr class="text"><td width="100%" align="left"><input type="text" size="120" maxlength="110" class="pole_input_biale" autocomplete="off" name="uwaga[3]" value="'.$uwaga[3].'"></td></tr>';
		echo '<tr class="text"><td width="100%" align="left"><input type="text" size="120" maxlength="110" class="pole_input_biale" autocomplete="off" name="uwaga[4]" value="'.$uwaga[4].'"></td></tr>';
		echo '<tr class="text"><td width="100%" align="left"><input type="text" size="120" maxlength="110" class="pole_input_biale" autocomplete="off" name="uwaga[5]" value="'.$uwaga[5].'"></td></tr>';


	echo '<tr><td colspan="2" align="center"><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr>';
	echo '</table>';
	echo '</FORM>';

echo '</td></tr></table>';

?>

