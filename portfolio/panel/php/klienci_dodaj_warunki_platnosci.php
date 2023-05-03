<?php	
echo '<br><div align="center" class="text_duzy_zielony">Warunki płatności</div>';
if($zmien == 1)
	{
	$modyfikuj=mysqli_query($conn, "update klienci set sposob_platnosci='".$sposob_platnosci."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update klienci set termin_platnosci_dni='".$termin_platnosci."' WHERE id=".$id.";");
	
	echo '<div class="text_blue" align="center">Dane klienta zostały zapisane.</div>';
	echo '<meta http-equiv="refresh" content="'.$czas_przeladowania.'; URL=index.php?page=klienci_dodaj&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pod_page=klienci_dodaj_adres_dostawy">';
	}


if (!$submit)
	{
	$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$id.";");
	while($wynik24= mysqli_fetch_assoc($pytanie24))
		{
		$sposob_platnosci = $wynik24['sposob_platnosci'];
		$termin_platnosci_dni = $wynik24['termin_platnosci_dni'];
		}		
	
	echo '<br><table border="0" width="70%" align="center"><tr align=center valign="top"><td>';

		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
		
		echo '<table width="100%" align="center" border="0" cellpadding="5">';
		
			echo '<tr align="center"><td align="right" class="text">'.$kol_sposob_platnosci.' : </td><td align="left">';
				// sposob płatności
				$ilosc_sposob_platnosci = 0;
				$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_platnosci' ORDER BY opis ASC");
				while($wynik3= mysqli_fetch_assoc($pytanie3))
					{
					$ilosc_sposob_platnosci++;
					$sposob_platnosci_id[$ilosc_sposob_platnosci] = $wynik3['id'];
					$sposob_platnosci_opis[$ilosc_sposob_platnosci] = $wynik3['opis'];
					}
				echo '<select name="sposob_platnosci" class="pole_input" style="width: 200px">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_sposob_platnosci; $k++) 
				if($sposob_platnosci == $sposob_platnosci_opis[$k]) echo '<option selected="selected" value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
				else echo '<option value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			echo '</td></tr>';

			echo '<tr class="text"><td align="right">Termin płatności:</td><td align="left">';
				echo '<select name="termin_platnosci" class="pole_input" style="width: 200px">';
				if($termin_platnosci == 1) echo '<option selected="selected">1</option>'; else echo '<option>1</option>';
				if($termin_platnosci == 3) echo '<option selected="selected">3</option>'; else echo '<option>3</option>';
				if($termin_platnosci == 7) echo '<option selected="selected">7</option>'; else echo '<option>7</option>';
				if($termin_platnosci == 14) echo '<option selected="selected">14</option>'; else echo '<option>14</option>';
				if($termin_platnosci == 21) echo '<option selected="selected">21</option>'; else echo '<option>21</option>';
				if($termin_platnosci == 28) echo '<option selected="selected">28</option>'; else echo '<option>28</option>';
				echo '</select>';
			echo ' dni</td></tr>';
			
			echo '<tr><td align="center" colspan="2">';
			echo '<button type="submit" class="text" name="submit">Dodaj</button></td></tr>';
		echo '</table></FORM>';

	echo '</td></tr></table>';
	}

?>