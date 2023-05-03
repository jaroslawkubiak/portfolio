<?php	

echo '<br><div align="center" class="text_duzy_zielony">Technologia</div>';

if($zmien == 1)
	{
	$modyfikuj=mysqli_query($conn, "update klienci set technologia_system1='".$technologia_system1."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update klienci set technologia_system2='".$technologia_system2."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update klienci set technologia_system3='".$technologia_system3."' WHERE id=".$id.";");
	echo '<div class="text_blue" align="center">Systemy zostały zmienione.</div>';
	}


if (!$submit)
	{
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$id.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$technologia_system1=$wynik['technologia_system1'];
		$technologia_system2=$wynik['technologia_system2'];
		$technologia_system3=$wynik['technologia_system3'];
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
		
			//#############################################       Technologia - Systemy           ###################################################################################################
			$ilosc_systemow = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='profil' ORDER BY opis ASC");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
					{
					$ilosc_systemow++;
					$system_id[$ilosc_systemow] = $wynik3['id'];
					$system_opis[$ilosc_systemow] = $wynik3['opis'];
					}
			echo '<tr align="center"><td align="right" class="text" width="40%">'.$kol_system.' : </td><td align="left" width="60%">';
				echo '<select name="technologia_system1" class="pole_input" style="width: 200px">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_systemow; $k++) 
				if($technologia_system1 == $system_opis[$k]) echo '<option selected="selected" value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
				else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';
			echo '<tr align="center"><td align="right" class="text">'.$kol_system.' : </td><td align="left">';
				echo '<select name="technologia_system2" class="pole_input" style="width: 200px">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_systemow; $k++) 
				if($technologia_system2 == $system_opis[$k]) echo '<option selected="selected" value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
				else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';
			echo '<tr align="center"><td align="right" class="text">'.$kol_system.' : </td><td align="left">';
				echo '<select name="technologia_system3" class="pole_input" style="width: 200px">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_systemow; $k++) 
				if($technologia_system3 == $system_opis[$k]) echo '<option selected="selected" value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
				else echo '<option value="'.$system_opis[$k].'">'.$system_opis[$k].'</option>';
				echo '</select>';
			echo '</td></tr>';
			//##################################################################################################################################################################################################################################################################################


			echo '<tr><td align="center" colspan="2">';
			echo '<button type="submit" class="text" name="submit">Zmień dane</button></td></tr>';
		echo '</table></FORM>';

	echo '</td></tr></table>';
	}

?>