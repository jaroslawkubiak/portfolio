<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Fakturowanie</div><br>';


if($zmiana_danych == 1)
	{
	$ins=mysqli_query($conn, "update fv_ustawienia set nazwa='".$nazwa."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set ulica='".$ulica."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set miasto='".$miasto."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set kod_pocztowy='".$kod_pocztowy."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set nip='".$nip."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set miejsce_wystawienia='".$miejsce_wystawienia."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set konto_opis='".$konto_opis."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set konto='".$konto."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set konto_euro='".$konto_euro."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set opis='".$opis."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set email='".$email."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set telefon='".$telefon."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set www='".$www."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tytul='".$wysylka_fv_email_tytul."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_nadawca='".$wysylka_fv_email_nadawca."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tresc='".$wysylka_fv_email_tresc."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set przypomnienie_email_tytul='".$przypomnienie_email_tytul."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set przypomnienie_email_nadawca='".$przypomnienie_email_nadawca."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set przypomnienie_email_tresc='".$przypomnienie_email_tresc."';");
	
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tytul_korekta='".$wysylka_fv_email_tytul_korekta."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tytul_duplikat='".$wysylka_fv_email_tytul_duplikat."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tytul_proforma='".$wysylka_fv_email_tytul_proforma."';");
	
	
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_ksiegowosc_tytul='".$wysylka_fv_ksiegowosc_tytul."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_ksiegowosc_adresat='".$wysylka_fv_ksiegowosc_adresat."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_ksiegowosc_tresc='".$wysylka_fv_ksiegowosc_tresc."';");
	
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tresc_korekta='".$wysylka_fv_email_tresc_korekta."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tresc_duplikat='".$wysylka_fv_email_tresc_duplikat."';");
	$ins=mysqli_query($conn, "update fv_ustawienia set wysylka_fv_email_tresc_proforma='".$wysylka_fv_email_tresc_proforma."';");
	
	$ins=mysqli_query($conn, "update rozne set opis=".$nr_fv." WHERE typ = 'nr_fv';");
	$ins=mysqli_query($conn, "update rozne set opis=".$wysokosc_okna." WHERE typ = 'wysokosc_okna';");
	echo '<div class="text_duzy_niebieski" align="center">Dane zostały zmienione.</div>';
	}
	
if(($skad == 'wystaw_fv') && ($zmiana_danych == 1)) echo $powrot_do_wystawiania_faktury;
else
	{

	$pytanie = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$nazwa=$wynik['nazwa'];
		$ulica=$wynik['ulica'];
		$miasto=$wynik['miasto'];
		$kod_pocztowy=$wynik['kod_pocztowy'];
		$nip=$wynik['nip'];
		$miejsce_wystawienia=$wynik['miejsce_wystawienia'];
		$konto_opis=$wynik['konto_opis'];
		$konto=$wynik['konto'];
		$konto_euro=$wynik['konto_euro'];
		
		$opis=$wynik['opis'];
		$email=$wynik['email'];
		$telefon=$wynik['telefon'];
		$www=$wynik['www'];
		
		$wysylka_fv_email_tytul=$wynik['wysylka_fv_email_tytul'];
		$wysylka_fv_email_nadawca=$wynik['wysylka_fv_email_nadawca'];
		$wysylka_fv_email_tresc=$wynik['wysylka_fv_email_tresc'];
		
		$wysylka_fv_ksiegowosc_tytul=$wynik['wysylka_fv_ksiegowosc_tytul'];
		$wysylka_fv_ksiegowosc_adresat=$wynik['wysylka_fv_ksiegowosc_adresat'];
		$wysylka_fv_ksiegowosc_tresc=$wynik['wysylka_fv_ksiegowosc_tresc'];
		
		$wysylka_fv_email_tytul_korekta=$wynik['wysylka_fv_email_tytul_korekta'];
		$wysylka_fv_email_tytul_duplikat=$wynik['wysylka_fv_email_tytul_duplikat'];
		$wysylka_fv_email_tytul_proforma=$wynik['wysylka_fv_email_tytul_proforma'];
		$wysylka_fv_email_tresc_korekta=$wynik['wysylka_fv_email_tresc_korekta'];
		$wysylka_fv_email_tresc_duplikat=$wynik['wysylka_fv_email_tresc_duplikat'];
		$wysylka_fv_email_tresc_proforma=$wynik['wysylka_fv_email_tresc_proforma'];
		
		$przypomnienie_email_tytul=$wynik['przypomnienie_email_tytul'];
		$przypomnienie_email_nadawca=$wynik['przypomnienie_email_nadawca'];
		$przypomnienie_email_tresc=$wynik['przypomnienie_email_tresc'];
		}
	
	$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_fv';");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$nr_fv=$wynik3['opis'];
		}	
		
	$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='wysokosc_okna';");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$wysokosc_okna=$wynik3['opis'];
		}	
		
	echo '<FORM action="index.php?page=fv_ustawienia&zmiana_danych=1" method="post">';
	echo '<table border="0" align="left" width="100%">';
	
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	
		echo '<tr class="text" align="right"><td width="30%">Sprzedawca nazwa :</td><td align="left" width="70%"><input type="text" size="80" maxlength="200" class="pole_input" autocomplete="off" name="nazwa" value="'.$nazwa.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Ulica:</td><td align="left"><input type="text" size="50" maxlength="60" class="pole_input" autocomplete="off" name="ulica" value="'.$ulica.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Miasto:</td><td align="left"><input type="text" size="50" maxlength="60" class="pole_input" autocomplete="off" name="miasto" value="'.$miasto.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Kod pocztowy:</td><td align="left"><input type="text" size="6" maxlength="6" class="pole_input" autocomplete="off" name="kod_pocztowy" value="'.$kod_pocztowy.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Sprzedawca NIP:</td><td align="left"><input type="text" size="10" maxlength="10" class="pole_input" autocomplete="off" name="nip" value="'.$nip.'"></td></tr>';
		
		echo '<tr class="text" align="right"><td>Miejsce wystawienia:</td><td align="left"><input type="text" size="50" maxlength="60" class="pole_input" autocomplete="off" name="miejsce_wystawienia" value="'.$miejsce_wystawienia.'"></td></tr>';
		echo '<tr align="center"><td align="right" class="text">Opis do konta: </td><td align="left" colspan="3">';
		echo '<textarea name="konto_opis" cols="50" rows="2" class="pole_input">'.$konto_opis.'</textarea></td></tr>';
		
		echo '<tr class="text" align="right"><td>Nr konta:</td><td align="left"><input type="text" size="80" maxlength="26" class="pole_input" autocomplete="off" name="konto" value="'.$konto.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Nr konta EURO:</td><td align="left"><input type="text" size="80" maxlength="100" class="pole_input" autocomplete="off" name="konto_euro" value="'.$konto_euro.'"></td></tr>';
		
		echo '<tr align="center"><td align="right" class="text">Uwagi do fv: </td><td align="left" colspan="3">';
		echo '<textarea name="opis" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$opis.'</textarea></td></tr>';
	
	
		echo '<tr class="text" align="right"><td>Email:</td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="email" value="'.$email.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Telefon:</td><td align="left"><input type="text" size="50" maxlength="30" class="pole_input" autocomplete="off" name="telefon" value="'.$telefon.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres www:</td><td align="left"><input type="text" size="50" maxlength="50" class="pole_input" autocomplete="off" name="www" value="'.$www.'"></td></tr>';
		
		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr class="text" align="right"><td>Nr faktury:</td><td align="left"><input type="text" size="5" maxlength="10" class="pole_input" autocomplete="off" name="nr_fv" value="'.$nr_fv.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Wysokość okna w zestawieniu faktur:</td><td align="left"><input type="text" size="5" maxlength="10" class="pole_input" autocomplete="off" name="wysokosc_okna" value="'.$wysokosc_okna.'"></td></tr>';
	
		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr><td colspan="2"><div align="center" class="text_duzy_niebieski">Wysyłka faktury przez e-mail : </div></td></tr>';
		echo '<tr class="text" align="right"><td>Tytuł e-maila: </td><td align="left"><input type="text" size="50" maxlength="80" class="pole_input" autocomplete="off" name="wysylka_fv_email_tytul" value="'.$wysylka_fv_email_tytul.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres e-mail nadawcy: </td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="wysylka_fv_email_nadawca" value="'.$wysylka_fv_email_nadawca.'"></td></tr>';
		echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3">';
		echo '<textarea name="wysylka_fv_email_tresc" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$wysylka_fv_email_tresc.'</textarea></td></tr>';
		
		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr><td colspan="2"><div align="center" class="text_duzy_niebieski">Wysyłka faktury do księgowości : </div></td></tr>';
		echo '<tr class="text" align="right"><td>Tytuł e-maila: </td><td align="left"><input type="text" size="50" maxlength="80" class="pole_input" autocomplete="off" name="wysylka_fv_ksiegowosc_tytul" value="'.$wysylka_fv_ksiegowosc_tytul.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres e-mail odbiorcy: </td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="wysylka_fv_ksiegowosc_adresat" value="'.$wysylka_fv_ksiegowosc_adresat.'"></td></tr>';
		echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3">';
		echo '<textarea name="wysylka_fv_ksiegowosc_tresc" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$wysylka_fv_ksiegowosc_tresc.'</textarea></td></tr>';

		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr><td colspan="2"><div align="center" class="text_duzy_niebieski">Wysyłka korekty przez e-mail : </div></td></tr>';
		
		echo '<tr class="text" align="right"><td>Tytuł e-maila: </td><td align="left"><input type="text" size="50" maxlength="80" class="pole_input" autocomplete="off" name="wysylka_fv_email_tytul_korekta" value="'.$wysylka_fv_email_tytul_korekta.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres e-mail nadawcy: </td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="wysylka_fv_email_nadawca" value="'.$wysylka_fv_email_nadawca.'"></td></tr>';
		echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3">';
		echo '<textarea name="wysylka_fv_email_tresc_korekta" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$wysylka_fv_email_tresc_korekta.'</textarea></td></tr>';
		
		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr><td colspan="2"><div align="center" class="text_duzy_niebieski">Wysyłka duplikatu przez e-mail : </div></td></tr>';
		
		echo '<tr class="text" align="right"><td>Tytuł e-maila: </td><td align="left"><input type="text" size="50" maxlength="80" class="pole_input" autocomplete="off" name="wysylka_fv_email_tytul_duplikat" value="'.$wysylka_fv_email_tytul_duplikat.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres e-mail nadawcy: </td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="wysylka_fv_email_nadawca" value="'.$wysylka_fv_email_nadawca.'"></td></tr>';
		echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3">';
		echo '<textarea name="wysylka_fv_email_tresc_duplikat" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$wysylka_fv_email_tresc_duplikat.'</textarea></td></tr>';
		
		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr><td colspan="2"><div align="center" class="text_duzy_niebieski">Wysyłka faktury proformy przez e-mail : </div></td></tr>';
		
		echo '<tr class="text" align="right"><td>Tytuł e-maila: </td><td align="left"><input type="text" size="50" maxlength="80" class="pole_input" autocomplete="off" name="wysylka_fv_email_tytul_proforma" value="'.$wysylka_fv_email_tytul_proforma.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres e-mail nadawcy: </td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="wysylka_fv_email_nadawca" value="'.$wysylka_fv_email_nadawca.'"></td></tr>';
		echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3">';
		echo '<textarea name="wysylka_fv_email_tresc_proforma" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$wysylka_fv_email_tresc_proforma.'</textarea></td></tr>';
		
		
		
		
		echo '<tr><td colspan="2"><hr width="800px"></td></tr>';
		echo '<tr><td colspan="2"><div align="center" class="text_duzy_niebieski">Wysyłka przypomnienia o płatności : </div></td></tr>';
		
		echo '<tr class="text" align="right"><td>Tytuł e-maila: </td><td align="left"><input type="text" size="50" maxlength="80" class="pole_input" autocomplete="off" name="przypomnienie_email_tytul" value="'.$przypomnienie_email_tytul.'"></td></tr>';
		echo '<tr class="text" align="right"><td>Adres e-mail nadawcy: </td><td align="left"><input type="text" size="50" maxlength="120" class="pole_input" autocomplete="off" name="przypomnienie_email_nadawca" value="'.$przypomnienie_email_nadawca.'"></td></tr>';
		
		echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3">';
		echo '<textarea name="przypomnienie_email_tresc" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$przypomnienie_email_tresc.'</textarea></td></tr>';
		
		echo '<tr><td></td><td class="text" bgcolor="white"><font color="red">+ opis z danymi faktury:</font><br>Faktura 81/2016 z dnia 12.12.2016, termin płatności 24.12.2016, do zapłaty 500 PLN</td></tr>';
	echo '<tr><td colspan="2" align="center"><br><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr>';
	echo '</table>';
	echo '</FORM>';
	} // do else
echo '</td></tr></table>';
?>