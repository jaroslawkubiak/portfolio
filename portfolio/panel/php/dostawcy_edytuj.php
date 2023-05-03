<?php
if($submit)
	{
	if($usun == 'on')
		{
		mysqli_query($conn, "DELETE FROM dostawcy WHERE id = ".$dostawca_id." LIMIT 1;");
		echo '<div class="text_duzy_niebieski" align="center">Dostawca został usunięty.</div>';
		echo $powrot_do_dostawcow;
		exit;
		}
	if($dostawca_nazwa == '') echo '<div class="text_red" align="center">Wpisz nazwę dostawcy.</div>';
	else
		{
		$taka_nazwa_istnieje = 0;
		//spawdzamy czy taka nazwa istnieje
		$pytanie224 = mysqli_query($conn, "SELECT dostawca_nazwa FROM dostawcy WHERE dostawca_nazwa = '".$dostawca_nazwa."' AND id <> ".$dostawca_id.";");
			while($wynik224= mysqli_fetch_assoc($pytanie224))
			{
			$taka_nazwa_istnieje = 1;
			}		
		if($taka_nazwa_istnieje == 1) echo '<div class="text_red" align="center">Dostawca o takiej nazwie już istnieje.</div>';
		else
			{
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET zamawiany_towar = '".$zamawiany_towar."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET ulica = '".$ulica."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET miasto = '".$miasto."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET kod_pocztowy = '".$kod_pocztowy."' WHERE id = ".$dostawca_id.";");

			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET dostawca_nazwa = '".$dostawca_nazwa."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET osoba_1 = '".$osoba_1."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET stanowisko_1 = '".$stanowisko_1."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET dzial_1 = '".$dzial_1."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET telefon_1 = '".$telefon_1."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET email_1 = '".$email_1."' WHERE id = ".$dostawca_id.";");
			
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET osoba_2 = '".$osoba_2."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET stanowisko_2 = '".$stanowisko_2."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET dzial_2 = '".$dzial_2."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET telefon_2 = '".$telefon_2."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET email_2 = '".$email_2."' WHERE id = ".$dostawca_id.";");
			
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET osoba_3 = '".$osoba_3."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET stanowisko_3 = '".$stanowisko_3."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET dzial_3 = '".$dzial_3."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET telefon_3 = '".$telefon_3."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET email_3 = '".$email_3."' WHERE id = ".$dostawca_id.";");
			
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET osoba_4 = '".$osoba_4."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET stanowisko_4 = '".$stanowisko_4."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET telefon_4 = '".$telefon_4."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET dzial_4 = '".$dzial_4."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET email_4 = '".$email_4."' WHERE id = ".$dostawca_id.";");
			
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET osoba_5 = '".$osoba_5."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET stanowisko_5 = '".$stanowisko_5."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET telefon_5 = '".$telefon_5."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET dzial_5 = '".$dzial_5."' WHERE id = ".$dostawca_id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET email_5 = '".$email_5."' WHERE id = ".$dostawca_id.";");
			
			$pytanie122 = mysqli_query($conn, "UPDATE dostawcy SET uwagi = '".$uwagi."' WHERE id = ".$dostawca_id.";");

			echo '<div class="text_duzy_niebieski" align="center">Dane dostawcy zostały zmienione.</div>';
			echo $powrot_do_dostawcow;
			exit;
			}
		}
		
	}
if(!$submit)
	{
	$ilosc_dzialow = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'dzial' ORDER BY opis ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_dzialow++;
		$dzial_opis[$ilosc_dzialow]=$wynik['opis'];
		}
	$ilosc_stanowisk = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'stanowisko' ORDER BY opis ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_stanowisk++;
		$stanowisko_opis[$ilosc_stanowisk]=$wynik['opis'];
		}

	$pytanie = mysqli_query($conn, "SELECT * FROM dostawcy WHERE id = ".$dostawca_id.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$dostawca_nazwa=$wynik['dostawca_nazwa'];
		$ulica=$wynik['ulica'];
		$miasto=$wynik['miasto'];
		$kod_pocztowy=$wynik['kod_pocztowy'];
		$zamawiany_towar=$wynik['zamawiany_towar'];
		$uwagi=$wynik['uwagi'];
		
		$osoba_1=$wynik['osoba_1'];
		$stanowisko_1=$wynik['stanowisko_1'];
		$telefon_1=$wynik['telefon_1'];
		$email_1=$wynik['email_1'];
		$dzial_1=$wynik['dzial_1'];
		
		$osoba_2=$wynik['osoba_2'];
		$stanowisko_2=$wynik['stanowisko_2'];
		$telefon_2=$wynik['telefon_2'];
		$email_2=$wynik['email_2'];
		$dzial_2=$wynik['dzial_2'];
		
		$osoba_3=$wynik['osoba_3'];
		$stanowisko_3=$wynik['stanowisko_3'];
		$telefon_3=$wynik['telefon_3'];
		$email_3=$wynik['email_3'];
		$dzial_3=$wynik['dzial_3'];
		
		$osoba_4=$wynik['osoba_4'];
		$stanowisko_4=$wynik['stanowisko_4'];
		$telefon_4=$wynik['telefon_4'];
		$email_4=$wynik['email_4'];
		$dzial_4=$wynik['dzial_4'];
		
		$osoba_5=$wynik['osoba_5'];
		$stanowisko_5=$wynik['stanowisko_5'];
		$telefon_5=$wynik['telefon_5'];
		$email_5=$wynik['email_5'];
		$dzial_5=$wynik['dzial_5'];
		}
		
	echo '<div class="text_duzy" align="center">Edytuj dostawcę</div>';
	
	echo '<table width="800px" align="center" border="0" cellpadding="3" align="left"><tr><td width="90%" align="center" valign="top">';
	echo '<FORM action="index.php?page=dostawcy_edytuj" method="post">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<INPUT type="hidden" name="dostawca_id" value="'.$dostawca_id.'">';
	
		echo '<table width=100% align="center" border="0" cellpadding="5" cellspacing="5">';
		
		// dostawca nazwa
		echo '<tr align="center" class="text"><td align="right" width="45%" colspan="2">Nazwa dostawcy : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="60" maxlength="120" class="pole_input" name="dostawca_nazwa" value="'.$dostawca_nazwa.'"></td></tr>';
		echo '<tr align="center" class="text"><td align="right" colspan="2">Ulica : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="60" maxlength="60" class="pole_input" name="ulica" value="'.$ulica.'"></td></tr>';
		echo '<tr align="center" class="text"><td align="right" colspan="2">Miasto : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="60" maxlength="40" class="pole_input" name="miasto" value="'.$miasto.'"></td></tr>';
		echo '<tr align="center" class="text"><td align="right" colspan="2">Kod pocztowy : </td><td align="left" colspan="3"><input autocomplete="off" type="text" size="60" maxlength="20" class="pole_input" name="kod_pocztowy" value="'.$kod_pocztowy.'"></td></tr>';
		
		echo '<tr align="center" class="text"><td height="100px" align="center" width="100%" colspan="5">Zamawiany towar:<br><textarea name="zamawiany_towar" cols="89" rows="4" class="pole_input_szare_ramka_uwagi">'.$zamawiany_towar.'</textarea></td></tr>';
		
		echo '<tr align="center" class="text"><td height="100px" align="center" width="100%" colspan="5">Uwagi:<br><textarea name="uwagi" cols="89" rows="4" class="pole_input_szare_ramka_uwagi">'.$uwagi.'</textarea></td></tr>';
		
		
		// osoby do kontaktu
		echo '<tr align="center" class="text"><td align="center" width="100%" colspan="5">Osoby do kontaktu</td></tr>';
		echo '<tr align="center" class="text">';
		echo '<td width="20%">Osoba do kontaktu</td>';
		echo '<td width="20%">Stanowisko</td>';
		echo '<td width="20%">Dział</td>';
		echo '<td width="20%">Telefon</td>';
		echo '<td width="20%">E-mail</td></tr>';
		
		echo '<tr align="center" class="text">';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="osoba_1" value="'.$osoba_1.'"></td>';
		echo '<td width="20%"><select name="stanowisko_1" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_stanowisk; $k++) 
		if($stanowisko_1 == $stanowisko_opis[$k]) echo '<option selected="selected" value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		else echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><select name="dzial_1" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_dzialow; $k++) 
		if($dzial_1 == $dzial_opis[$k]) echo '<option selected="selected" value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		else echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="telefon_1" value="'.$telefon_1.'"></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="email_1" value="'.$email_1.'"></td></tr>';
		
		echo '<tr align="center" class="text">';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="osoba_2" value="'.$osoba_2.'"></td>';
		echo '<td width="20%"><select name="stanowisko_2" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_stanowisk; $k++) 
		if($stanowisko_2 == $stanowisko_opis[$k]) echo '<option selected="selected" value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		else echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><select name="dzial_2" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_dzialow; $k++) 
		if($dzial_2 == $dzial_opis[$k]) echo '<option selected="selected" value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		else echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="telefon_2" value="'.$telefon_2.'"></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="email_2" value="'.$email_2.'"></td></tr>';
		
		echo '<tr align="center" class="text">';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="osoba_3" value="'.$osoba_3.'"></td>';
		echo '<td width="20%"><select name="stanowisko_3" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_stanowisk; $k++) 
		if($stanowisko_3 == $stanowisko_opis[$k]) echo '<option selected="selected" value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		else echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><select name="dzial_3" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_dzialow; $k++) 
		if($dzial_3 == $dzial_opis[$k]) echo '<option selected="selected" value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		else echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="telefon_3" value="'.$telefon_3.'"></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="email_3" value="'.$email_3.'"></td></tr>';
		
		echo '<tr align="center" class="text">';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="osoba_4" value="'.$osoba_4.'"></td>';
		echo '<td width="20%"><select name="stanowisko_4" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_stanowisk; $k++) 
		if($stanowisko_4 == $stanowisko_opis[$k]) echo '<option selected="selected" value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		else echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><select name="dzial_4" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_dzialow; $k++) 
		if($dzial_4 == $dzial_opis[$k]) echo '<option selected="selected" value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		else echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="telefon_4" value="'.$telefon_4.'"></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="email_4" value="'.$email_4.'"></td></tr>';
		
		echo '<tr align="center" class="text">';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="osoba_5" value="'.$osoba_5.'"></td>';
		echo '<td width="20%"><select name="stanowisko_5" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_stanowisk; $k++) 
		if($stanowisko_5 == $stanowisko_opis[$k]) echo '<option selected="selected" value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		else echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><select name="dzial_5" class="pole_input_szare_ramka_left" style="width: 200px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_dzialow; $k++) 
		if($dzial_5 == $dzial_opis[$k]) echo '<option selected="selected" value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		else echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
		echo '</select></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="telefon_5" value="'.$telefon_5.'"></td>';
		echo '<td width="20%"><input autocomplete="off" type="text" size="30" maxlength="200" class="pole_input" name="email_5" value="'.$email_5.'"></td></tr>';
		
		echo '<tr class="Text"><td align="center" colspan="5">';
		echo '<div class="text_red">Zaznacz, aby usunąć dostawcę &nbsp;<INPUT type="checkbox" name="usun"></div>';
		echo '</td></tr>';
		
		
		
		echo '<tr class="Text"><td align="center" colspan="5">';
		echo '<INPUT type="submit" name="submit" value="Zapisz">';
		echo '</td></tr></table>';
		echo '</FORM>';
	
		echo '</table>';
	echo '</td></tr></table>';
	}
echo $powrot_do_dostawcow;
?>