<?php

if($submit)
	{
	$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET lista_materialow_opis = '".$uwagi."' WHERE id = ".$zamowienie_id.";");
	echo '<div class="text_duzy_niebieski" align="center">Lista materiałów została zapisana.</div>';
	echo $powrot_do_konkretnego_zamowienia;
	echo $powrot_do_zamowienia;
	}
else
	{
	$pytanie33 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$nr_zamowienia_klienta=$wynik33['nr_zamowienia_klienta'];
		$lista_materialow_nr=$wynik33['lista_materialow_nr'];
		$lista_materialow_opis=$wynik33['lista_materialow_opis'];
		}
	
	
	echo '<FORM action="index.php?page=lista_materialow_edycja" method="post">';
	echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
	echo '<INPUT type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
	echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	
	echo '<table width="50%" align="center" border="0" cellpadding="3"><tr><td width="100%" align="left" valign="top">';
		echo $image_logo_mini;
	echo '</td></tr>';
	echo '<tr><td width="100%" align="center" valign="top">';
	
		echo '<table width="100%" align="center" border="0" cellpadding="3">';
		echo '<tr><td>';
		
			echo '<div class="text_duzy" align="center">Lista materiałów nr: '.$lista_materialow_nr.'</div>';
			echo '<div class="text_duzy" align="left">Do zamówienia nr: '.$nr_zamowienia;
			if($nr_zamowienia_klienta != '') echo ' ('.$nr_zamowienia_klienta.')';
			echo '</div>';
		echo '</td></tr>';
		
		echo '<tr><td height="200px">';
			echo '<textarea name="uwagi" cols="130" rows="18" class="pole_textarea_lista_materialow">'.$lista_materialow_opis.'</textarea>';
			
		echo '</td></tr>';


		echo '<tr><td class="text">';
		$ilosc = 0;
		$opis = [];
		$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'uwagi_lista_materialow' ORDER BY opis ASC");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc++;
			$opis[$ilosc]=$wynik['opis'];
			}
//https://www.w3schools.com/howto/howto_js_copy_clipboard.asp


			
		echo 'Uwagi:<br><br>';
		for($x=1; $x<=$ilosc; $x++)
			{
			echo '<font size="+2">'.$opis[$x].'</font><br>';
			
			
			
			}
		echo '</td></tr>';

		echo '<tr class="Text"><td align="center">';
		echo '<INPUT type="submit" name="submit" value="Zapisz">';
		echo '</td></tr></table>';
		echo '</FORM>';
	
	echo '</td></tr></table>';
	}
?>