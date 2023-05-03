<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';



if($status != '')
	{
	
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('status', '$status');");
	echo '<div class="text_duzy_niebieski" align="center">Status dodany.</div>';
	}



if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM suwaki WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div class="text_duzy_niebieski" align="center">Status usunięty.</div>';
	}


$typ = [];
$opis = [];
$id = [];
$ilosc = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'status' ORDER BY opis ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc++;
	$typ[$ilosc]=$wynik['typ'];
	$opis[$ilosc]=$wynik['opis'];
	$id[$ilosc]=$wynik['id'];
	}


echo '<table align="center" class="tabela" width="500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td colspan="3" class="text_duzy" align="center" >Dodaj zamówienie - status</td></tr>';
for($x=1; $x<=$ilosc; $x++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td width="10%" bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td width="80%" align="left">'.$opis[$x].'</td>';
	if(($opis[$x] != 'Dostarczone') && ($opis[$x] != 'Odebrane') && ($opis[$x] != 'Anulowane')) echo '<td width="10%"><a href="index.php?page=ustawienia_dz_status&usun_id='.$id[$x].'&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'">'.$image_delete.'</a></td></tr>';
	else echo '<td width="10%"></td></tr>';
	}
echo '</table>';





echo '<FORM action="index.php?page=ustawienia_dz_status" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';

echo '<br><br><table align="center" class="tabela" width="500px" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowy status</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="82" maxlength="150" class="pole_input" title="Status" alt="Status" id="status" name="status"></td></tr>';


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