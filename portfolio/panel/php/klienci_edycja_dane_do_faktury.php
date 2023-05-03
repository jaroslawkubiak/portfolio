<?php
echo '<br><div align="center" class="text_duzy_zielony">'.$kom_dane_do_faktury.'</div>';

if($usunac == 1)
	{
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=klienci&jak=DESC&wg_czego=id&usunac=1&usun_klienta_id='.$id.'"></head>';
	}

if($zmien == 1)
	{
	$sql = mysqli_query($conn, "update klienci SET nazwa = '".$nazwa."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET nip = '".$nip."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET kraj = '".$kraj."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET pelna_nazwa = '".$pelna_nazwa."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET ulica = '".$ulica."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET miasto = '".$miasto."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET kod_pocztowy = '".$kod_pocztowy."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET status_firmy = '".$status_firmy."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET aktywny = '".$aktywny."' WHERE id = ".$id.";");

	if($nowy_kraj) $sql = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) VALUES ('kraj', '$nowy_kraj');");

	echo '<div class="text_blue" align="center">'.$kom_dane_do_faktury_zostaly_zmienione.'</div>';
	}

if (!$submit)
	{
	$sql = "SELECT * FROM klienci WHERE id = ".$id.";";
	$resultsql = mysqli_query($conn, $sql);
	if(mysqli_num_rows($resultsql) > 0) 
		while ($wynik24 = mysqli_fetch_assoc($resultsql)) 
			{
			$pelna_nazwa = $wynik24['pelna_nazwa'];
			$nazwa = $wynik24['nazwa'];
			$status_firmy = $wynik24['status_firmy'];
			$kraj = $wynik24['kraj'];
			$nip = $wynik24['nip'];
			$ulica = $wynik24['ulica'];
			$miasto = $wynik24['miasto'];
			$kod_pocztowy = $wynik24['kod_pocztowy'];
			$aktywny = $wynik24['aktywny'];
			}
		
	echo '<br><table border="0" width="100%" align="center"><tr align=center valign="top"><td>';

		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
		
		echo '<table width="100%" align="center" border="0" cellpadding="5">';
		$size_input = '80';
		echo '<tr class="text" align="center"><td align="right" width="25%">Nazwa :</td><td align="left" width="75%"><input type="text" autocomplete="off" size="'.$size_input.'" maxlength="120" class="pole_input" name="nazwa" value="'.$nazwa.'"></td></tr>';
?>
	<tr class="text" align="center"><td align="right">Pełna nazwa :</td><td align="left"><input type="text" autocomplete="off" size="80" maxlength="120" class="pole_input" name="pelna_nazwa" value='<?php echo $pelna_nazwa; ?>'></td></tr>
<?php	
	echo '<tr class="text" align="center"><td align="right">Ulica :</td><td align="left"><input type="text" autocomplete="off" size="'.$size_input.'" maxlength="60" class="pole_input" name="ulica" value="'.$ulica.'"></td></tr>';
	echo '<tr class="text" align="center"><td align="right">Miasto :</td><td align="left"><input type="text" autocomplete="off" size="'.$size_input.'" maxlength="40" class="pole_input" name="miasto" value="'.$miasto.'"></td></tr>';
	echo '<tr class="text" align="center"><td align="right">Kod pocztowy :</td><td align="left"><input type="text" autocomplete="off" size="'.$size_input.'" maxlength="6" class="pole_input" name="kod_pocztowy" value="'.$kod_pocztowy.'"></td></tr>';
		
		
	$ilosc_krajow = 0;
	$sql = "SELECT * FROM suwaki WHERE typ='kraj' ORDER BY opis ASC;";
	$resultsql = mysqli_query($conn, $sql);
	if(mysqli_num_rows($resultsql) > 0) 
		while ($wynik2 = mysqli_fetch_assoc($resultsql)) 
			{
			$ilosc_krajow++;
			$lista_krajow[$ilosc_krajow] = $wynik2['opis'];
			}


	echo '<tr align="center" class="text"><td align="right">Kraj : </td><td align="left">';
	echo '<select name="kraj" class="pole_input" style="width: 290px">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_krajow; $k++) 
		if($kraj == $lista_krajow[$k]) echo '<option selected="selected" value="'.$lista_krajow[$k].'">'.$lista_krajow[$k].'</option>';
		else echo '<option value="'.$lista_krajow[$k].'">'.$lista_krajow[$k].'</option>';
	echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;LUB&nbsp;&nbsp;&nbsp;&nbsp;<input autocomplete="off" type="text" size="20" maxlength="55" class="pole_input" name="nowy_kraj"></td></tr>';
	
	echo '<tr class="text" align="center"><td align="right">NIP :</td><td align="left"><input type="text" autocomplete="off" size="'.$size_input.'" maxlength="20" class="pole_input" name="nip" value="'.$nip.'"></td></tr>';
	echo '<tr class="text" align="center"><td align="right">Status firmy :</td><td align="left">';
		$ilosc_status_firmy = 0;
		$sql = "SELECT * FROM suwaki WHERE typ='status_firmy' ORDER BY id ASC;";
		$resultsql = mysqli_query($conn, $sql);
		if(mysqli_num_rows($resultsql) > 0) 
			while ($wynik3 = mysqli_fetch_assoc($resultsql)) 
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

	echo '<tr class="Text"><td align="center" colspan="2" class="text">';
		if($aktywny == 'on') $checked = ' checked="checked" '; else $checked = '';
		echo $kom_klient_aktywny.' <input type="checkbox" name="aktywny" "'.$checked.'"><br>';
	echo '</td></tr>';

	echo '<tr class="Text"><td align="center" colspan="2" class="text_duzy_czerwony">';
		echo $kom_zaznacz_aby_usunac_klienta_z_bazy.' <input type="checkbox" name="usunac" value="1"><br>';
	echo '</td></tr>';
	
	echo '<tr><td align="center" colspan="2">';
		echo '<button type="submit" class="text" name="submit">'.$kom_zmien_dane.'</button></td></tr>';
	echo '</table></FORM>';

	echo '</td></tr></table>';
	}
?>