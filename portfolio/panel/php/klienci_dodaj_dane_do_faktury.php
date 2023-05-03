<?php	
echo '<br><div align="center" class="text_duzy_zielony">Dane do faktury</div>';
if($submit)
	{
	if(klient_nazwa_exists($conn, $nazwa)) echo '<div class="text_red" align="center">Klient o takiej nazwie już istnieje!</div>'; 
	elseif($nazwa == '') echo '<div class="text_red" align="center">Wpisz nazwę klienta</div>';
	else
		{
		// dodaj nowe suwaki
		if($nowy_kraj != '')	
			{
			echo '<div class="text_green" align="center">Dodano nowy kraj do bazy</div>';
			$pytanie = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`)  values ('kraj', '$nowy_kraj');");
			$kraj = $nowy_kraj;
			}
		$nowy_klient_id = dodaj_klienta($conn, $nazwa, $ulica, $miasto, $kod_pocztowy, $nip, $status_firmy, $pelna_nazwa, $kraj);

		echo '<div class="text_blue" align="center">Dane klienta zostały zapisane.</div>';

		echo '<meta http-equiv="refresh" content="'.$czas_przeladowania.'; URL=index.php?page=klienci_dodaj&id='.$nowy_klient_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pod_page=klienci_dodaj_warunki_platnosci">';
		}
	}
else
	{
	$autocomplete = 'autocomplete="off"';
	echo '<br><table border="0" width="100%" align="center"><tr align=center valign="top"><td>';

		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		
		echo '<table width="100%" align="center" border="0" cellpadding="5">';
		$size_input = '80';
		echo '<tr class="text" align="center"><td align="right" width="25%">Nazwa :</td><td align="left" width="75%"><input type="text" '.$autocomplete.' size="'.$size_input.'" maxlength="120" class="pole_input" name="nazwa" value="'.$nazwa.'"></td></tr>';

?>
<tr class="text" align="center"><td align="right">Pełna nazwa :</td><td align="left"><input type="text" autocomplete="off" size="80" maxlength="120" class="pole_input" name="pelna_nazwa" value='<?php echo $pelna_nazwa;?>'></td></tr>
<?php
	echo '<tr class="text" align="center"><td align="right">Ulica :</td><td align="left"><input type="text" '.$autocomplete.' size="'.$size_input.'" maxlength="60" class="pole_input" name="ulica" value="'.$ulica.'"></td></tr>';
	echo '<tr class="text" align="center"><td align="right">Miasto :</td><td align="left"><input type="text" '.$autocomplete.' size="'.$size_input.'" maxlength="40" class="pole_input" name="miasto" value="'.$miasto.'"></td></tr>';
	echo '<tr class="text" align="center"><td align="right">Kod pocztowy :</td><td align="left"><input type="text" '.$autocomplete.' size="'.$size_input.'" maxlength="6" class="pole_input" name="kod_pocztowy" value="'.$kod_pocztowy.'"></td></tr>';
		
	
	$ilosc_krajow = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kraj' ORDER BY opis ASC;");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$ilosc_krajow++;
		$lista_krajow[$ilosc_krajow] = $wynik2['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">Kraj : </td><td align="left">';
	echo '<select name="kraj" class="pole_input" style="width: 290px">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_krajow; $k++) 
	if($kraj == $lista_krajow[$k]) echo '<option selected="selected" value="'.$lista_krajow[$k].'">'.$lista_krajow[$k].'</option>';
	elseif(($kraj == '') && ($lista_krajow[$k] == 'Polska')) echo '<option selected="selected" value="'.$lista_krajow[$k].'">'.$lista_krajow[$k].'</option>';
	else echo '<option value="'.$lista_krajow[$k].'">'.$lista_krajow[$k].'</option>';
	echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;LUB&nbsp;&nbsp;&nbsp;&nbsp;<input '.$autocomplete.' type="text" size="20" maxlength="25" class="pole_input" name="nowy_kraj" value="'.$nowy_kraj.'"></td></tr>';
	
	echo '<tr class="text" align="center"><td align="right">NIP :</td><td align="left"><input type="text" '.$autocomplete.' size="'.$size_input.'" maxlength="20" class="pole_input" name="nip" value="'.$nip.'"></td></tr>';
	echo '<tr class="text" align="center"><td align="right">Status firmy :</td><td align="left">';
		$ilosc_status_firmy = 0;
		$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status_firmy' ORDER BY id ASC;");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			{
			$ilosc_status_firmy++;
			$status_firmy_id[$ilosc_status_firmy] = $wynik3['id'];
			$status_firmy_opis[$ilosc_status_firmy] = $wynik3['opis'];
			}
		echo '<select name="status_firmy" class="pole_input" style="width: 290px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_status_firmy; $k++) 
		if($status_firmy == $status_firmy_opis[$k]) echo '<option selected="selected" value="'.$status_firmy_opis[$k].'">'.$status_firmy_opis[$k].'</option>';
		else echo '<option value="'.$status_firmy_opis[$k].'">'.$status_firmy_opis[$k].'</option>';
	echo '</td></tr>';

	
	echo '<tr><td align="center" colspan="2">';
	echo '<INPUT type="submit" name="submit" value="Dodaj"></td></tr>';
	echo '</table></FORM>';

	echo '</td></tr></table>';
	}
?>