<?php
echo '<FORM action="index.php?page=karty_produkcyjne_szukaj" method="post" id="szukaj">';
	echo '<INPUT type="hidden" name="page" value="'.$page.'">';
	echo '<table border="0" align="center" cellspacing="0" cellpadding="0" class="text"><tr class="text_ogromny"><td align="center" colspan="2">Szukaj karty produkcyjnej :</td></tr><tr align="center"><td>';
	echo '<input type="text" id="szukaj" autocomplete="off" size="10" class="pole_input_wzmocnienia" name="szukaj" value="'.$szukaj.'"></td>';
	echo '<td><INPUT type="image" name="submit" src="images/lupa.png">';
	echo '</tr></table>';
echo '</FORM>';

$i = 0;
if ($handle = opendir('../panel_dane/karta_produkcyjna_pliki')) 
{
   while (false !== ($file = readdir($handle))) 
   {
       if ($file != "." && $file != "..") 
	   {
	   	$i++;
		$file = explode('.', $file);
		$tab_wzmocnienia_nazwa[$i] = $file[0];
		$tab_wzmocnienia_rozszerzenie[$i] = $file[1];
       }
   }
   closedir($handle);
}		


if($szukaj != '')
	{
	$istnieje = 0;
	for($x=1; $x<=$i; $x++) if($szukaj == $tab_wzmocnienia_nazwa[$x]) 
		{
		echo '<center><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/karta_produkcyjna_pliki/'.$szukaj.'.'.$tab_wzmocnienia_rozszerzenie[$x].'" width="1200"></center>';
		$istnieje = 1;
		}
	}

if(($istnieje == 0) && ($szukaj != '')) echo '<div align="center" class="text_duzy_czerwony">Nie ma takiej karty</div>';
?>