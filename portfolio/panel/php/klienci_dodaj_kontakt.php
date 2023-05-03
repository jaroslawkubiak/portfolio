<?php	
echo '<br><div align="center" class="text_duzy_zielony">Kontakt</div>';
if($zmien == 1)
	{
	for($x=1; $x<=$i; $x++)
		{
		if(($nazwa_osoba[$x] != '') || ($nazwa_dzial[$x] != '') || ($nazwa_stanowisko[$x] != '') || ($nazwa_telefon[$x] != '') || ($nazwa_email[$x] != ''))
			{
			if(($nazwa_email[$x] !="") && (!spr_email($nazwa_email[$x])))  echo '<div class="text_red" align="center">Błędny adres email : '.$nazwa_email[$x].'</div>';
			else $query = mysqli_query($conn, "INSERT INTO klienci_kontakt (`klient_id`, `osoba`, `dzial`, `stanowisko`, `telefon`, `email`) values ('$id', '$nazwa_osoba[$x]', '$nazwa_dzial[$x]', '$nazwa_stanowisko[$x]', '$nazwa_telefon[$x]', '$nazwa_email[$x]');");
			}
		}
	echo '<div class="text_blue" align="center">Kontakty zostały zmienione.</div>';
	echo '<meta http-equiv="refresh" content="'.$czas_przeladowania.'; URL=index.php?page=klienci&jak=DESC&wg_czego=id">';
	}


if (!$submit)
	{
	$ilosc_dzialow = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'dzial' ORDER BY opis ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_dzialow++;
		$dzial_opis[$ilosc_dzialow]=$wynik['opis'];
		}
	$ilosc_stanowisk = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'stanowisko' ORDER BY opis ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_stanowisk++;
		$stanowisko_opis[$ilosc_stanowisk]=$wynik['opis'];
		}

	$klient_kontakt_id = [];
	$klient_osoba = [];
	$klient_dzial = [];
	$klient_stanowisko = [];
	$klient_telefon = [];
	$klient_email = [];

	$i = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$id." ORDER BY id ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$klient_kontakt_id[$i]=$wynik['id'];
		$klient_osoba[$i]=$wynik['osoba'];
		$klient_dzial[$i]=$wynik['dzial'];
		$klient_stanowisko[$i]=$wynik['stanowisko'];
		$klient_telefon[$i]=$wynik['telefon'];
		$klient_email[$i]=$wynik['email'];
		}
		
if($i == 0) $i = 10;

	echo '<br><table border="0" width="100%" align="left"><tr align=center valign="top"><td>';
		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="i" value="'.$i.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
		
		echo '<table width="100%" align="center" border="0"  bgcolor="'.$kolor_bialy.'" cellpadding="5" BORDERCOLOR="black" frame="box" RULES="all">';
		
			echo '<tr align="center" class="text" bgcolor="'.$kolor_tabeli.'">';
			echo '<td width="20%">Imię i nazwisko</td>';
			echo '<td width="20%">Stanowisko</td>';
			echo '<td width="20%">Dział</td>';
			echo '<td width="15%">Telefon</td>';
			echo '<td width="20%">E-mail</td></tr>';
			
			for($x=1; $x<=$i; $x++)
				{
				echo '<tr align="center" class="text">';
				$nazwa_osoba = 'nazwa_osoba['.$x.']';
				echo '<td><input autocomplete="off" type="text" size="40" maxlength="120" class="pole_input" name="'.$nazwa_osoba.'" value="'.$klient_osoba[$x].'"></td>';
				
				$nazwa_stanowisko = 'nazwa_stanowisko['.$x.']';
				echo '<td><select name="'.$nazwa_stanowisko.'" class="pole_input_szare_ramka_left" style="width: 200px">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_stanowisk; $k++) 
				if($klient_stanowisko[$x] == $stanowisko_opis[$k]) echo '<option selected="selected" value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
				else echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
				echo '</select></td>';
				
				$nazwa_dzial = 'nazwa_dzial['.$x.']';
				echo '<td><select name="'.$nazwa_dzial.'" class="pole_input_szare_ramka_left" style="width: 200px">';
				echo '<option></option>';
				for ($k=1; $k<=$ilosc_dzialow; $k++) 
				if($klient_dzial[$x] == $dzial_opis[$k]) echo '<option selected="selected" value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
				else echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
				echo '</select></td>';
				
				$nazwa_telefon = 'nazwa_telefon['.$x.']';
				echo '<td><input autocomplete="off" type="text" size="25" maxlength="60" class="pole_input" name="'.$nazwa_telefon.'" value="'.$klient_telefon[$x].'"></td>';
				
				$nazwa_email = 'nazwa_email['.$x.']';
				echo '<td><input autocomplete="off" type="text" size="40" maxlength="60" class="pole_input" name="'.$nazwa_email.'" value="'.$klient_email[$x].'"></td></tr>';
				
				}
			
		echo '<tr><td align="center" colspan="5">';
		echo '<button type="submit" class="text" name="submit">Dodaj</button></td></tr>';
		echo '</table></FORM>';
		
	echo '</td></tr></table>';
	}

?>