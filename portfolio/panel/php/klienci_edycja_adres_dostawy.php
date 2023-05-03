<?php
echo '<br><div align="center" class="text_duzy_zielony">'.$kom_adres_dostawy.'</div>';

if($zmien == 1)
	{

	$sql = mysqli_query($conn, "update klienci SET dostawy_ulica = '".$ulica."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET dostawy_miasto = '".$miasto."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET dostawy_kod_pocztowy = '".$kod_pocztowy."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET dostawy_pomocniczy_ulica = '".$dostawy_pomocniczy_ulica."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET dostawy_pomocniczy_miasto = '".$dostawy_pomocniczy_miasto."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET dostawy_pomocniczy_kod_pocztowy = '".$dostawy_pomocniczy_kod_pocztowy."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET strefa = '".$strefa."' WHERE id = ".$id.";");
	echo '<div class="text_blue" align="center">Dane dostawy zostały zmienione.</div>';
	}


if (!$submit)
	{
	$sql = "SELECT * FROM klienci WHERE id = ".$id.";";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) 
		while ($wynik24 = mysqli_fetch_assoc($result)) 
			{
			$ulica = $wynik24['dostawy_ulica'];
			$miasto = $wynik24['dostawy_miasto'];
			$kod_pocztowy = $wynik24['dostawy_kod_pocztowy'];
			$strefa = $wynik24['strefa'];
			$dostawy_pomocniczy_ulica = $wynik24['dostawy_pomocniczy_ulica'];
			$dostawy_pomocniczy_miasto = $wynik24['dostawy_pomocniczy_miasto'];
			$dostawy_pomocniczy_kod_pocztowy = $wynik24['dostawy_pomocniczy_kod_pocztowy'];
			}

	echo '<br><table border="0" width="80%" align="center"><tr align=center valign="top"><td>';

		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
			
		echo '<table width="100%" align="center" border="0" cellpadding="5">';
		
			echo '<tr><td colspan="2"><div align="center" class="text_duzy_zielony">Główny</div></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Ulica :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="40" maxlength="60" class="pole_input" name="ulica" value="'.$ulica.'"></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Miasto :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="40" maxlength="40" class="pole_input" name="miasto" value="'.$miasto.'"></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Kod pocztowy :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="40" maxlength="6" class="pole_input" name="kod_pocztowy" value="'.$kod_pocztowy.'"></td></tr>';
			
			echo '<tr><td colspan="2"><div align="center" class="text_duzy_zielony">Pomocniczy</div></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Ulica :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="40" maxlength="60" class="pole_input" name="dostawy_pomocniczy_ulica" value="'.$dostawy_pomocniczy_ulica.'"></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Miasto :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="40" maxlength="40" class="pole_input" name="dostawy_pomocniczy_miasto" value="'.$dostawy_pomocniczy_miasto.'"></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Kod pocztowy :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="40" maxlength="6" class="pole_input" name="dostawy_pomocniczy_kod_pocztowy" value="'.$dostawy_pomocniczy_kod_pocztowy.'"></td></tr>';

			echo '<tr><td colspan="2"><div align="center" class="text_duzy_zielony">Strefa</div></td></tr>';
			echo '<tr class="text" align="center"><td align="right" width="50%">Strefa :</td><td align="left" width="50%">';
				echo '<select name="strefa" class="pole_input">';
				for($k=1; $k<=$DL_TABELA_STREFY; $k++)
					if($strefa == $TABELA_STREFY[$k]) echo '<option selected="selected" value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
					else echo '<option value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';

		echo '<tr><td align="center" colspan="2">';
			echo '<button type="submit" class="text" name="submit">'.$kom_zmien_dane.'</button></td></tr>';
		echo '</table></FORM>';

	echo '</td></tr></table>';
	}
?>