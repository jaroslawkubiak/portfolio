<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Wartość stawki VAT</div><br>';

if($zmiana_danych == 1)
	{
	for ($x=1; $x<=$ilosc; $x++) 
		{
		$ins=mysqli_query($conn, "update vat set wartosc=".$nowy_vat[$x]." WHERE id = ".$x.";");
		}
	echo '<div class="text_duzy_niebieski" align="center">Vat zostały zmienione.</div><br>';
	}


$i = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM vat ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$wartosc[$i]=$wynik['wartosc'];
	}
		


echo '<FORM action="index.php?page=ustawienia_vat&zmiana_danych=1" method="post">';
echo '<table border="0" align="center" width="100%">';
echo '<INPUT type="hidden" name="ilosc" value="'.$i.'">';
	echo '<tr class="text" align="center"><td width="100%"></td></tr>';
	for ($x=1; $x<=$i; $x++)
		{
		$nowy_vat = 'nowy_vat['.$x.']';		
		echo '<tr class="text" align="center"><td width="100%"><input type="text" size="6" maxlength="6" class="pole_input_right" autocomplete="off" name="'.$nowy_vat.'" value="'.$wartosc[$x].'"></td></tr>';
		}
	
echo '<tr><td colspan="2" align="center"><br><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr>';
echo '</table>';
echo '</FORM>';

echo '</td></tr></table>';
?>