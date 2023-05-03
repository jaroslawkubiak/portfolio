<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

if($submit == 'ZAPISZ') 
	{
	$opis = [];
	$id = [];
	$ilosc = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'produkty' ORDER BY opis ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc++;
		$opis[$ilosc]=$wynik['opis'];
		$id[$ilosc]=$wynik['id'];
		}

	for($x=1; $x<=$ilosc; $x++) $pytanie122 = mysqli_query($conn, "UPDATE suwaki SET grupa = '".$grupa_produktow[$id[$x]]."' WHERE id = ".$id[$x].";");
	echo '<div class="text_duzy_niebieski" align="center">Grupy produktów zapisane.</div>';
	}



if($produkt != '')
	{
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('produkty', '$produkt');");
	echo '<div class="text_duzy_niebieski" align="center">Produkt dodany.</div>';
	}

if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM suwaki WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div class="text_duzy_niebieski" align="center">Produkt usunięty.</div>';
	}

$typ = [];
$opis = [];
$grupa_produktu = [];
$id = [];
$grupa_opis = [];
$grupa_id = [];

$ilosc = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'produkty' ORDER BY opis ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc++;
	$typ[$ilosc]=$wynik['typ'];
	$opis[$ilosc]=$wynik['opis'];
	$grupa_produktu[$ilosc]=$wynik['grupa'];
	$id[$ilosc]=$wynik['id'];
	}

	
$ilosc_grup = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'grupa_produktow' ORDER BY opis ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_grup++;
	$grupa_opis[$ilosc_grup]=$wynik['opis'];
	$grupa_id[$ilosc_grup]=$wynik['id'];
	}

	
echo '<FORM action="index.php?page=ustawienia_dz_produkt" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';

echo '<table align="center" class="tabela" width="800px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td colspan="4" class="text_duzy" align="center" >Dodaj zamówienie - Produkt</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td></td><td>Produkt</td><td>Grupa</td><td></td></tr>';
for($x=1; $x<=$ilosc; $x++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td width="10%" bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';

	echo '<td width="40%" align="left">'.$opis[$x].'</td>';
	
	//grupa produktow
	$grupa_produktow = 'grupa_produktow['.$id[$x].']';	
	echo '<td width="40%" align="left">';
		echo '<select name="'.$grupa_produktow.'" class="pole_input" style="width: 300px">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_grup; $k++) 
		if($grupa_produktu[$x] == $grupa_opis[$k]) echo '<option selected="selected" value="'.$grupa_opis[$k].'">'.$grupa_opis[$k].'</option>';
		else echo '<option value="'.$grupa_opis[$k].'">'.$grupa_opis[$k].'</option>';
	echo '</td>';
	
	
	echo '<td width="10%"><a href="index.php?page=ustawienia_dz_produkt&usun_id='.$id[$x].'&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'">'.$image_delete.'</a></td></tr>';
	}

echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center" colspan="4">';
echo '<INPUT type="submit" name="submit" value="ZAPISZ">';
echo '</td></tr></table>';
echo '</FORM>';


echo '<FORM action="index.php?page=ustawienia_dz_produkt" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';

echo '<br><br><table align="center" class="tabela" width="500px" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowy produkt</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="82" maxlength="150" class="pole_input" title="Produkt" alt="Produkt" id="produkt" name="produkt"></td></tr>';


echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center">';
echo '<INPUT type="submit" name="submit" value="Dodaj">';
echo '</td></tr></table>';
echo '</FORM>';


echo $powrot_do_ustawienia_dodaj_zamowienie;
if($zamowienie_id != '') 
	{
	if($skad == 'zamowienie_dodaj') echo '<div align="center">'.$powrot_do_wystawiania_zamowienia_dodaj.'</div>';
	if($skad == 'zamowienie_edycja') echo '<div align="center">'.$powrot_do_wystawiania_zamowienia_edycja.'</div>';
	if($skad == 'zamowienie_wycena') echo '<div align="center">'.$powrot_do_wystawiania_zamowienia_wycena.'</div>';
	}

	
echo '</td></tr></table>';
?>