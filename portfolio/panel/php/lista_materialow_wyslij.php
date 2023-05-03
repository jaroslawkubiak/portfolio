<?php
$pytanie33 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = ".$zamowienie_id.";");
while($wynik33= mysqli_fetch_assoc($pytanie33))
	{
	$nr_zamowienia_klienta=$wynik33['nr_zamowienia_klienta'];
	$nr_zamowienia=$wynik33['nr_zamowienia'];
	$lista_materialow_nr=$wynik33['lista_materialow_nr'];
	$lista_materialow_opis=$wynik33['lista_materialow_opis'];
	}

if($submit)
	{
	include ("php/lista_materialow_pdf.php");
	}
else
	{
	
	
	echo '<FORM action="index.php?page=lista_materialow_wyslij" method="post">';
	echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
	echo '<INPUT type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
	echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	
	echo '<table width="50%" align="center" border="0" bgcolor="white" cellpadding="3"><tr><td width="100%" align="left" valign="top">';
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
		
		echo '<tr><td>';
			echo '<textarea name="uwagi" cols="130" rows="18" class="pole_textarea_lista_materialow" disabled>'.$lista_materialow_opis.'</textarea>';
		echo '</td></tr>';
		
		echo '<tr><td align="center">';
		
		include ("php/lista_emaili_potwierdzenie_zamowienia.php");

		echo '<select name="lista_materialow_email" class="pole_input" style="width: 40%" >';
		for ($k=1; $k<=$ilosc_email; $k++) 
		if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		elseif($linia_rozdzielajaca == $klient_email[$k]) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
		else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		echo '</select>';
		echo '</td></tr>';
		
		echo '<tr class="Text"><td align="center">';
		if($ilosc_email != 0) 	echo '<INPUT type="submit" name="submit" value="Wyślij">';
		else echo 'BRAK ADRESU E-MAIL NABYWCY!';
		echo '</td></tr></table>';
		echo '</FORM>';
	
	echo '</td></tr></table>';
	}
echo $powrot_do_konkretnego_zamowienia;
echo $powrot_do_zamowienia;

?>