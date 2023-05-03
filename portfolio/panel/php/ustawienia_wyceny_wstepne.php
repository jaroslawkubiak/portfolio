<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Wyceny wstępne</div><br>';

if($zmiana_danych == 1)
	{
	$ins=mysqli_query($conn, "update rozne set opis=".$nowy_numer_wyceny_wstepnej." WHERE typ = 'wycena_wstepna_nr';");
	echo '<div class="text_duzy_niebieski" align="center">Numer wyceny został zmieniony.</div>';
	}


if($data_waznosci != '')
	{
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('wycena_wstepna_data_waznosci', '$data_waznosci');");
	echo '<div class="text_duzy_niebieski" align="center">Wpis dodany.</div>';
	}

if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM suwaki WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div class="text_duzy_niebieski" align="center">Wpis usunięty.</div>';
	}
	
	
// numeracja
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'wycena_wstepna_nr';");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$wycena_wstepna_nr=$wynik['opis'];
	}


echo '<FORM action="index.php?page=ustawienia_wyceny_wstepne&zmiana_danych=1" method="post">';
	echo '<table align="center" class="tabela" width="500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text" valign="middle" height="40px"><td class="text_duzy" align="center" width="100%">';
		echo 'Numer wyceny wstępnej : <input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_numer_wyceny_wstepnej" value="'.$wycena_wstepna_nr.'">';
		echo $tabulator.'<INPUT type="submit" class="text" name="submit" value="Zmień">';
	echo '</table>';
echo '</FORM>';
	
	

$typ = [];
$opis = [];
$id = [];
$ilosc = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'wycena_wstepna_data_waznosci' ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc++;
	$typ[$ilosc]=$wynik['typ'];
	$opis[$ilosc]=$wynik['opis'];
	$id[$ilosc]=$wynik['id'];
	}


echo '<table align="center" class="tabela" width="500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td colspan="3" class="text_duzy" align="center" >Wycena wstępna - Data ważności</td></tr>';
for($x=1; $x<=$ilosc; $x++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td width="10%" bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td width="80%" align="left">'.$opis[$x].'</td>';
	echo '<td width="10%"><a href="index.php?page=ustawienia_wyceny_wstepne&usun_id='.$id[$x].'&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'">'.$image_delete.'</a></td></tr>';
	}
echo '</table><br>';


echo '<FORM action="index.php?page=ustawienia_wyceny_wstepne" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';

echo '<table align="center" class="tabela" width="500px" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nową datę ważności</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="82" maxlength="150" class="pole_input" title="Data ważności" alt="Data ważności" id="data_waznosci" name="data_waznosci"></td></tr>';


echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center">';
echo '<INPUT type="submit" name="submit" value="Dodaj">';
echo '</td></tr></table>';
echo '</FORM>';


// termin realizacji
if($termin_realizacji != '')
	{
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('termin_realizacji', '$termin_realizacji');");
	echo '<div class="text_duzy_niebieski" align="center">Wpis dodany.</div>';
	}

$typ = [];
$opis = [];
$id = [];
$ilosc = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'termin_realizacji' ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc++;
	$typ[$ilosc]=$wynik['typ'];
	$opis[$ilosc]=$wynik['opis'];
	$id[$ilosc]=$wynik['id'];
	}


echo '<table align="center" class="tabela" width="500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td colspan="3" class="text_duzy" align="center" >Wycena wstępna - Termin realizacji</td></tr>';
for($x=1; $x<=$ilosc; $x++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td width="10%" bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td width="80%" align="left">'.$opis[$x].'</td>';
	echo '<td width="10%"><a href="index.php?page=ustawienia_wyceny_wstepne&usun_id='.$id[$x].'&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'">'.$image_delete.'</a></td></tr>';
	}
echo '</table>';


echo '<br><FORM action="index.php?page=ustawienia_wyceny_wstepne" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';

echo '<table align="center" class="tabela" width="500px" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowy termin realizacji</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="82" maxlength="150" class="pole_input" title="Termin realizacji" alt="Termin realizacji" id="termin_realizacji" name="termin_realizacji"></td></tr>';

echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center">';
echo '<INPUT type="submit" name="submit" value="Dodaj">';
echo '</td></tr></table>';
echo '</FORM>';


// sposob dostawy
if($sposob_dostawy_wycena_wstepna != '')
	{
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('sposob_dostawy_wycena_wstepna', '$sposob_dostawy_wycena_wstepna');");
	echo '<div class="text_duzy_niebieski" align="center">Wpis dodany.</div>';
	}

$typ = [];
$opis = [];
$id = [];
$ilosc = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'sposob_dostawy_wycena_wstepna' ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc++;
	$typ[$ilosc]=$wynik['typ'];
	$opis[$ilosc]=$wynik['opis'];
	$id[$ilosc]=$wynik['id'];
	}


echo '<table align="center" class="tabela" width="500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td colspan="3" class="text_duzy" align="center" >Wycena wstępna - Sposób dostawy</td></tr>';
for($x=1; $x<=$ilosc; $x++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td width="10%" bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td width="80%" align="left">'.$opis[$x].'</td>';
	echo '<td width="10%"><a href="index.php?page=ustawienia_wyceny_wstepne&usun_id='.$id[$x].'&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'">'.$image_delete.'</a></td></tr>';
	}
echo '</table><br>';


echo '<FORM action="index.php?page=ustawienia_wyceny_wstepne" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';

echo '<table align="center" class="tabela" width="500px" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowy sposób dostawy</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="82" maxlength="150" class="pole_input" title="Sposób dostawy" alt="Sposób dostawy" id="sposob_dostawy_wycena_wstepna" name="sposob_dostawy_wycena_wstepna"></td></tr>';

echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center">';
echo '<INPUT type="submit" name="submit" value="Dodaj">';
echo '</td></tr></table>';
echo '</FORM>';

//echo $powrot_do_wycen_wstepnej;

echo '</td></tr></table>';

?>