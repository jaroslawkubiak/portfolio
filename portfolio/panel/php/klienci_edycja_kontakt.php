<?php	
echo '<br><div align="center" class="text_duzy_zielony">Kontakt</div>';
if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM klienci_kontakt WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div class="text_blue" align="center">Kontakt został usunięty.</div>';
	}
	

if($zmien == 1)
	{
	$modyfikuj=mysqli_query($conn, "update klienci set efaktura='".$efaktura."' WHERE id=".$id.";");
		
	for($x=1; $x<=$i; $x++)
		{
		$modyfikuj=mysqli_query($conn, "update klienci_kontakt set osoba='".$nazwa_osoba[$x]."' WHERE id=".$nazwa_klient_kontakt_id[$x].";");
		$modyfikuj=mysqli_query($conn, "update klienci_kontakt set dzial='".$nazwa_dzial[$x]."' WHERE id=".$nazwa_klient_kontakt_id[$x].";");
		$modyfikuj=mysqli_query($conn, "update klienci_kontakt set stanowisko='".$nazwa_stanowisko[$x]."' WHERE id=".$nazwa_klient_kontakt_id[$x].";");
		$modyfikuj=mysqli_query($conn, "update klienci_kontakt set telefon='".$nazwa_telefon[$x]."' WHERE id=".$nazwa_klient_kontakt_id[$x].";");
		
		if(($nazwa_email[$x] !="") && (!spr_email($nazwa_email[$x]))) echo '<div class="text_red" align="center">Błędny adres email : '.$nazwa_email[$x].'</div>';
		else $modyfikuj=mysqli_query($conn, "update klienci_kontakt set email='".$nazwa_email[$x]."' WHERE id=".$nazwa_klient_kontakt_id[$x].";");
		}
	echo '<div class="text_blue" align="center">Kontakty zostały zmienione.</div>';

	if(($nazwa_osoba[$x] != '') || ($nazwa_dzial[$x] != '') || ($nazwa_stanowisko[$x] != '') || ($nazwa_telefon[$x] != '') || ($nazwa_email[$x] != ''))
		if(($nazwa_email[$x] !="") && (!spr_email($nazwa_email[$x])))  echo '<div class="text_red" align="center">Błędny adres email : '.$nazwa_email[$x].'</div>';
		else 
			{
			$query = mysqli_query($conn, "INSERT INTO klienci_kontakt (`klient_id`, `osoba`, `dzial`, `stanowisko`, `telefon`, `email`) values ('$id', '$nazwa_osoba[$x]', '$nazwa_dzial[$x]', '$nazwa_stanowisko[$x]', '$nazwa_telefon[$x]', '$nazwa_email[$x]');");
			echo '<div class="text_blue" align="center">Nowy kontakt został dodany.</div>';
			}
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



	echo '<FORM action="index.php?page='.$page.'" method="post">';
	echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
	echo '<INPUT type="hidden" name="id" value="'.$id.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="i" value="'.$i.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
	echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
	echo '<INPUT type="hidden" name="zmien" value="1">';

	echo '<br><table border="0" width="100%" align="left"><tr class="text" align="center" valign="middle"><td>';

		// e faktura - aby móc zaznaczyć musi być wpisany adres do faktur lub istnieć ostatnio użyty adres do faktur

		//sprawdamy czy efaktura jest możliwa - ostatnio uzyzy
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ostatnio_uzyty_faktury FROM klienci WHERE id = ".$id.";"));
		$ostatnio_uzyty_faktury = $sql['ostatnio_uzyty_faktury'];

		//szukamy czy istnieje adres do faktur
		$istnieje_email_do_faktur = '';
		for($x=1; $x<=$i; $x++)
			if($klient_dzial[$x] == 'Faktury') $istnieje_email_do_faktur = 'tak';

		if(($ostatnio_uzyty_faktury != '') OR ($istnieje_email_do_faktur == 'tak')) $atrybut_efaktura = ''; 
		else
		{
			$atrybut_efaktura = '  disabled="disabled"  ';
			$modyfikuj=mysqli_query($conn, "update klienci set efaktura='' WHERE id=".$id.";");
		}

		//sprawdamy czy efaktura jest wybrana dla klienta
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT efaktura FROM klienci WHERE id = ".$id.";"));
		$efaktura = $sql['efaktura'];

		if($efaktura == 'on') $atrybut_efaktura .= ' checked';
		echo 'efaktura&nbsp;';
		echo '<input type="checkbox" name="efaktura" '.$atrybut_efaktura.'>';

	echo '</td></tr><tralign="center" valign="top"><td>';
		
		echo '<table width="100%" align="center" border="0"  bgcolor="'.$kolor_bialy.'" cellpadding="5" BORDERCOLOR="black" frame="box" RULES="all">';
		
			echo '<tr align="center" class="text" bgcolor="'.$kolor_tabeli.'">';
			echo '<td width="20%">Imie i nazwisko</td>';
			echo '<td width="20%">Stanowisko</td>';
			echo '<td width="20%">Dzial</td>';
			echo '<td width="15%">Telefon</td>';
			echo '<td width="20%">E-mail</td>';
			echo '<td width="5%">Usun</td></tr>';
			
			for($x=1; $x<=$i; $x++)
				{
				echo '<tr align="center" class="text">';
				$nazwa_osoba = 'nazwa_osoba['.$x.']';
				echo '<td>';
					$nazwa_klient_kontakt_id = 'nazwa_klient_kontakt_id['.$x.']';
					echo '<INPUT type="hidden" name="'.$nazwa_klient_kontakt_id.'" value="'.$klient_kontakt_id[$x].'">';
				echo '<input autocomplete="off" type="text" size="40" maxlength="120" class="pole_input" name="'.$nazwa_osoba.'" value="'.$klient_osoba[$x].'"></td>';
				
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
				echo '<td><input autocomplete="off" type="text" size="40" maxlength="60" class="pole_input" name="'.$nazwa_email.'" value="'.$klient_email[$x].'"></td>';
				
				echo '<td><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_kontakt&usun_id='.$klient_kontakt_id[$x].'">'.$image_delete.'</a></td></tr>';
				}
			
			//############################################### dodaj nowy kontakt  ##########################################################################
			echo '<tr align="center" class="text" bgcolor="'.$kolor_tabeli.'"><td colspan="6">Dodaj nowy kontakt</td></tr><tr align="center" class="text" bgcolor="'.$kolor_bialy.'">';
			$nazwa_osoba = 'nazwa_osoba['.$x.']';
			echo '<td width="20%">';
				$nazwa_klient_kontakt_id = 'nazwa_klient_kontakt_id['.$x.']';
				echo '<INPUT type="hidden" name="'.$nazwa_klient_kontakt_id.'" value="'.$klient_kontakt_id[$x].'">';
			echo '<input autocomplete="off" type="text" size="40" maxlength="120" class="pole_input" name="'.$nazwa_osoba.'" value="'.$klient_osoba[$x].'"></td>';
			
			$nazwa_stanowisko = 'nazwa_stanowisko['.$x.']';
			echo '<td width="20%"><select name="'.$nazwa_stanowisko.'" class="pole_input_szare_ramka_left" style="width: 200px">';
			echo '<option></option>';
				for ($k=1; $k<=$ilosc_stanowisk; $k++) echo '<option value="'.$stanowisko_opis[$k].'">'.$stanowisko_opis[$k].'</option>';
			echo '</select></td>';
			
			$nazwa_dzial = 'nazwa_dzial['.$x.']';
			echo '<td width="20%"><select name="'.$nazwa_dzial.'" class="pole_input_szare_ramka_left" style="width: 200px">';
			echo '<option></option>';
				for ($k=1; $k<=$ilosc_dzialow; $k++) 
					if(($dzial_opis[$k] == 'Faktury') && ($istnieje_email_do_faktur != "tak")) echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';
					else if($dzial_opis[$k] != 'Faktury') echo '<option value="'.$dzial_opis[$k].'">'.$dzial_opis[$k].'</option>';

			echo '</select></td>';
			
			$nazwa_telefon = 'nazwa_telefon['.$x.']';
			echo '<td width="20%"><input autocomplete="off" type="text" size="25" maxlength="60" class="pole_input" name="'.$nazwa_telefon.'" value="'.$klient_telefon[$x].'"></td>';
			$nazwa_email = 'nazwa_email['.$x.']';
			echo '<td width="20%"><input autocomplete="off" type="text" size="40" maxlength="60" class="pole_input" name="'.$nazwa_email.'" value="'.$klient_email[$x].'"></td><td></td></tr>';
				
		echo '<tr><td align="center" colspan="6">';
		echo '<button type="submit" class="text" name="submit">Zmień dane</button></td></tr>';
		echo '</table></FORM>';
		
	echo '</td></tr></table>';
	}

?>