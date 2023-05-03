<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Edycja użytkownika</div>';

if($usunac == 1)
	{
	mysqli_query($conn, "DELETE FROM uzytkownicy WHERE id = ".$id." LIMIT 1;");
	echo '<div align="center" class="text_duzy_niebieski"><br>Użytkownik został usunięty z bazy</div>';
	}
elseif($submit)
	{
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set haslo='".$password1."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set imie='".$imie."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set email='".$email."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set telefon='".$telefon."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set nazwisko='".$nazwisko."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set aktywny='".$aktywny."' WHERE id=".$id.";");
	$modyfikuj=mysqli_query($conn, "update uzytkownicy set stanowisko='".$stanowisko."' WHERE id=".$id.";");
	
	echo '<p class="text_duzy_niebieski" align="center">Dane użytkownika zostały zmodyfikowane</p>';
	
	//sprawdzamy czy zmienila si enazwa uzytkownika i czy nie istnieje juz taka dla innego uzytkownika
	$sql44 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nazwa FROM uzytkownicy WHERE id = ".$id.";"));
	$stara_nazwa_uzytkownika = $sql44['nazwa'];
	if($nazwa != $stara_nazwa_uzytkownika)
		{
		$nazwa_juz_istnieje = uzytkownik_istnieje($conn, $nazwa, $id);
		if($nazwa_juz_istnieje == 1) echo '<p class="text_red" align="center">Taka nazwa użytkownika już istnieje!</p>';
		else $modyfikuj=mysqli_query($conn, "update uzytkownicy set nazwa='".$nazwa."' WHERE id=".$id.";");
		
		}

	}

else
{
$pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id=".$id.";");
while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$nazwa=$wynik['nazwa'];
		$haslo=$wynik['haslo'];
		$imie=$wynik['imie'];
		$email=$wynik['email'];
		$telefon=$wynik['telefon'];
		$nazwisko=$wynik['nazwisko'];
		$stanowisko=$wynik['stanowisko'];
		$aktywny=$wynik['aktywny'];
		}

	echo '<FORM action="index.php?page=uzytkownicy_edycja" method="post">';
	echo '<INPUT type="hidden" name="id" value="'.$id.'">';
	


	$wysokosc = '40px';
	$szerokosc = '200px';
	echo '<table width="450px" align="center" border="0" cellpadding="0" cellspacing="5">';
	//nazwa
	echo '<tr align="center" height="'.$wysokosc.'" valign="middle"><td align="right" class="text" width="200px">'.$kol_nazwa.' :&nbsp;</td>';
	echo '<td align="left" width="'.$szerokosc.'"><input autocomplete="off" type="text" size="30" maxlength="20" class="pole_input" title="Nazwa" alt="Nazwa" id="nazwa" name="nazwa" value="'.$nazwa.'" required=""></td>';
	echo '<td width="50px">'.$pole_obowiazkowe.'</td></tr>';

	//haslo
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_haslo.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="password" size="30"  maxlength="20" class="pole_input" name="password1" value="'.$haslo.'" required=""><td>'.$pole_obowiazkowe.'</td></td></tr>';	

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
		if($stanowisko == 'administrator') echo '<option selected="selected">administrator</option>'; else echo '<option>administrator</option>';
		if($stanowisko == 'handel') echo '<option selected="selected">handel</option>'; else echo '<option>handel</option>';
		if($stanowisko == 'kierowca') echo '<option selected="selected">kierowca</option>'; else echo '<option>kierowca</option>';
		if($stanowisko == 'księgowość') echo '<option selected="selected">księgowość</option>'; else echo '<option>księgowość</option>';
		if($stanowisko == 'produkcja') echo '<option selected="selected">produkcja</option>'; else echo '<option>produkcja</option>';
	echo '</select></td><td></td></tr>';

	//email
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_email.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="text" size="30" maxlength="40" title="email" alt="email" class="pole_input" name="email" value="'.$email.'"><td></td></td></tr>';

	//telefon
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">'.$kol_telefon.' :&nbsp;</td>';
	echo '<td align="left"><input autocomplete="off" type="text" size="30" maxlength="20" title="Telefon" alt="Telefon" class="pole_input" name="telefon" value="'.$telefon.'"></td><td></td></tr>';
	
	//aktywny
	if($aktywny == 'on') $atrybut = 'checked="checked"'; else $atrybut = '';
	echo '<tr align="center" height="'.$wysokosc.'"><td align="right" class="text">Aktywny : &nbsp;</td>';
	echo '<td align="left"><input type="checkbox" name="aktywny" '.$atrybut.'></td><td></td></tr>';

	//usun
	echo '<tr class="Text"><td align="center" colspan="3" class="text_duzy_czerwony">';
	echo 'Zaznacz, aby usunąć użytkownika z bazy <input type="checkbox" name="usunac" value="1"><br>';
	echo '</td></tr>';

	//zapisz
	echo '<tr class="Text" height="'.$wysokosc.'"><td align="center" colspan=3>';
	echo '<INPUT type="submit" name="submit" value="Zapisz">';
	echo '</td></tr></table>';
	echo '</FORM>';
}

echo $powrot_do_uzytkownicy;

echo '</td></tr></table>';

?>