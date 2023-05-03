<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
echo '<div class="text_duzy" align="center">Dodaj użytkownika</div>';

if($submit)
{
	//sprawdzamy nie istnieje juz taka dla innego uzytkownika
	$sql44 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nazwa FROM uzytkownicy WHERE id = ".$id.";"));
	$stara_nazwa_uzytkownika = $sql44['nazwa'];
		
	$id = 0;
	$nazwa_juz_istnieje = uzytkownik_istnieje($conn, $nazwa, $id);
	if($nazwa_juz_istnieje == 1) 
		{
			echo '<p class="text_red" align="center">Użytkownik o takiej nazwie już istnieje!</p>';
			echo $powrot_do_uzytkownicy;
		}
	else 
		{
		//mozemy dziac, nazwa jest ok
		if(($nazwa != '') && ($imie != '') && ($password1 != ''))
			{
			$query = mysqli_query($conn, "INSERT INTO uzytkownicy (`nazwa`, `haslo`, `imie`, `nazwisko`, `stanowisko`, `email`, `telefon`, `aktywny`) values ('$nazwa', '$password1', '$imie', '$nazwisko', '$stanowisko', '$email', '$telefon', 'on');");
			echo '<div class="text_duzy_niebieski" align="center">Użytkownik został dodany</div>';
			echo $powrot_do_uzytkownicy;
			}
		else echo '<meta http-equiv="refresh" content="'.$czas_przeladowania.'; URL=index.php?page=uzytkownicy_dodaj">';


		}

}

else
{

echo '<table width="30%" align="center" border="0" cellpadding="3"><tr><td width="90%" align="center" valign="top">';
echo '<FORM action="index.php?page=uzytkownicy_dodaj" method="post">';
echo '<INPUT type="hidden" name="page" value="uzytkownicy_dodaj">';
	$wysokosc = '40px';
	$szerokosc = '200px';
	echo '<table width=100% align="center" border="0" cellpadding="0" cellspacing="5">';
	//nazwa
	echo '<tr align="center" height="'.$wysokosc.'" valign="middle"><td align="right" class="text" width="200px">'.$kol_nazwa.' :&nbsp;</td>';
	echo '<td align="left" width="'.$szerokosc.'"><input autocomplete="off" type="text" size="30" maxlength="20" class="pole_input" title="Nazwa" alt="Nazwa" id="nazwa" name="nazwa" value="'.$nazwa.'" required=""></td>';
	echo '<td width="50px">'.$pole_obowiazkowe.'</td></tr>';

	//haslo
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_haslo.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="password" size="30"  maxlength="20" class="pole_input" name="password1" value="'.$password1.'" required=""><td>'.$pole_obowiazkowe.'</td></td></tr>';	

	//imie
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_imie.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="text" size="30" maxlength="20" title="imie" alt="imie" class="pole_input" name="imie" value="'.$imie.'" required=""><td>'.$pole_obowiazkowe.'</td></td></tr>';

	//nazwisko
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_nazwisko.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="text" size="30" maxlength="40" title="nazwisko" alt="nazwisko" class="pole_input" name="nazwisko" value="'.$nazwisko.'"><td></td></td></tr>';
	
	//stanowisko
	echo '<tr align="center" class="text" height="'.$wysokosc.'"><td align="right">'.$kol_stanowisko.' :&nbsp;</td><td align="left">';
	echo '<select name="stanowisko" class="pole_input" style="width: 100%">';
		echo '<option></option>';
		echo '<option>administrator</option>';
		echo '<option>handel</option>';
		echo '<option>kierowca</option>';
		echo '<option>księgowość</option>';
		echo '<option>produkcja</option>';
	echo '</select></td><td></td></tr>';

	//email
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_email.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="text" size="30" maxlength="40" title="email" alt="email" class="pole_input" name="email" value="'.$email.'"><td></td></td></tr>';

	//telefon
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_telefon.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="text" size="30" maxlength="20" title="Telefon" alt="Telefon" class="pole_input" name="telefon" value="'.$telefon.'"></td><td></td></tr>';

	//dodaj
	echo '<tr class="Text" height="'.$wysokosc.'"><td align="center" colspan=3>';
	echo '<INPUT type="submit" name="submit" value="Dodaj">';
	echo '</td></tr></table>';
	echo '</FORM>';

echo '</td></tr></table>';
}
echo '</td></tr></table>';
?>