<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

if($sposob_dostawy != '')
	{
	
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('sposob_dostawy', '$sposob_dostawy');");
	echo '<div class="text_duzy_niebieski" align="center">Sposób dostawy dodany.</div>';
	}



if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM suwaki WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div class="text_duzy_niebieski" align="center">Sposób dostawy usunięty.</div>';
	}


$typ = [];
$opis = [];
$id = [];
$ilosc = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'sposob_dostawy' ORDER BY opis ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc++;
	$typ[$ilosc]=$wynik['typ'];
	$opis[$ilosc]=$wynik['opis'];
	$id[$ilosc]=$wynik['id'];
	}


echo '<table align="center" class="tabela" width="500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td colspan="3" class="text_duzy" align="center" >Sposób dostawy</td></tr>';
for($x=1; $x<=$ilosc; $x++)
	{
	echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
	echo '<td width="10%" bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
	echo '<td width="80%" align="left">'.$opis[$x].'</td>';
	if(($opis[$x] != 'Kurier') && ($opis[$x] != 'Odbiór własny')) echo '<td width="10%"><a href="index.php?page=ustawienia_suwaki_sposob_dostawy&usun_id='.$id[$x].'">'.$image_delete.'</a></td></tr>';
	else echo '<td width="10%"></td></tr>';
	}
echo '</table>';





echo '<FORM action="index.php?page=ustawienia_suwaki_sposob_dostawy" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';

echo '<br><br><table align="center" class="tabela" width="500px" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowy sposób dostawy</td></tr>';
echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="82" maxlength="150" class="pole_input" title="Sposób dostawy" alt="Sposób dostawy"  name="sposob_dostawy"></td></tr>';


echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center">';
echo '<INPUT type="submit" name="submit" value="Dodaj">';
echo '</td></tr></table>';
echo '</FORM>';


echo $powrot_do_ustawienia_suwaki_lista;

	
echo '</td></tr></table>';

?>