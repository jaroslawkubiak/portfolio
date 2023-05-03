<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Numeracja</div><br>';


if($zmiana_danych == 1)
	{
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_numer_zamowienia." WHERE typ = 'nr_zamowienia';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_numer_wyceny_wstepnej." WHERE typ = 'wycena_wstepna_nr';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_numer_reklamacji." WHERE typ = 'nr_reklamacji';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_numer_zlecenia_transportowego." WHERE typ = 'nr_zlecenia_transportowego';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_fv." WHERE typ = 'nr_fv';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_nr_korekty_fv." WHERE typ = 'nr_korekty_fv';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_nr_proformy." WHERE typ = 'nr_proformy';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_numer_magazyn." WHERE typ = 'magazyn';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowa_lista_materialow." WHERE typ = 'lista_materialow';");
	$ins=mysqli_query($conn, "UPDATE rozne SET opis=".$nowy_numer_wz." WHERE typ = 'numer_wz';");
	echo '<div class="text_duzy_niebieski" align="center">Numery zostały zmienione.</div><br>';
	}



$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_zamowienia';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$numer_zamowienia=$wynik['opis'];
		
$pytanie2 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_reklamacji';");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	$numer_reklamacji=$wynik2['opis'];

$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_zlecenia_transportowego';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	$numer_zlecenia_transportowego=$wynik3['opis'];
	
$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_fv';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	$numer_fv=$wynik3['opis'];
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'magazyn';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$numer_magazyn=$wynik['opis'];
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_korekty_fv';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$nr_korekty_fv=$wynik['opis'];

$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'nr_proformy';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$nr_proformy=$wynik['opis'];
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'wycena_wstepna_nr';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$wycena_wstepna_nr=$wynik['opis'];
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'lista_materialow';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$lista_materialow=$wynik['opis'];
	
$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'numer_wz';");
while($wynik= mysqli_fetch_assoc($pytanie))
	$numer_wz=$wynik['opis'];

	
echo '<table border="0" align="center" width="50%">';
	echo '<FORM action="index.php?page=ustawienia_numeracji&zmiana_danych=1" method="post">';
		echo '<tr class="text" align="right"><td width="50%">'.$kol_nr_zamowienia.' :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_numer_zamowienia" value="'.$numer_zamowienia.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">'.$kol_nr_reklamacji.' :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_numer_reklamacji" value="'.$numer_reklamacji.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">Lista materiałów :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowa_lista_materialow" value="'.$lista_materialow.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">Numer wyceny wstępnej :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_numer_wyceny_wstepnej" value="'.$wycena_wstepna_nr.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">'.$kol_nr_zlecenia_transportowego.' :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_numer_zlecenia_transportowego" value="'.$numer_zlecenia_transportowego.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">'.$kol_nr_fv.' :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_fv" value="'.$numer_fv.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">Korekta do FV :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_nr_korekty_fv" value="'.$nr_korekty_fv.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">Proforma :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_nr_proformy" value="'.$nr_proformy.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">Numer zamówienia magazyn :</td><td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="nowy_numer_magazyn" value="'.$numer_magazyn.'"></td></tr>';
		echo '<tr class="text" align="right"><td width="50%">Wydanie zewnętrzne WZ:</td><td width="50%" align="left"><input type="text" size="6" maxlength="50" class="pole_input" autocomplete="off" name="nowy_numer_wz" value="'.$numer_wz.'"></td></tr>';
	echo '<tr><td colspan="2" align="center"><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr>';
	echo '</table>';
	echo '</FORM>';

echo '</td></tr></table>';
?>