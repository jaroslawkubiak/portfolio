<?php

echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Magazyn</div><br>';

if($zmiana_danych == 1)
	{
	$nowy_kurs_euro = change($nowy_kurs_euro);


	$ins=mysqli_query($conn, "update rozne set opis=".$nowy_kurs_euro." WHERE typ = 'kurs_euro';");
	$ins=mysqli_query($conn, "update rozne set opis=".$nowa_marza_magazynu." WHERE typ = 'marza_magazynu';");
	$ins=mysqli_query($conn, "update rozne set opis=".$nowa_numer." WHERE typ = 'magazyn';");
	
	$i = 0;
	$id = [];
	$cena_netto_zakupu_eu = [];
	$cena_netto_zakupu_zl = [];
	$cena_netto_sprzedazy_eu = [];
	$cena_netto_sprzedazy_zl = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM magazyn;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$id[$i]=$wynik['id'];


		$cena_netto_zakupu_eu[$i]=$wynik['cena_netto_zakupu_eu'];
		$cena_netto_zakupu_zl[$i]=$wynik['cena_netto_zakupu_zl'];

		if($cena_netto_zakupu_eu[$i] != 0) 
			{
			$cena_netto_zakupu_zl[$i] = change($cena_netto_zakupu_eu[$i] * $nowy_kurs_euro);

			$sql = "update magazyn set cena_netto_zakupu_zl=".$cena_netto_zakupu_zl[$i]." WHERE id = ".$id[$i].";";
			mysqli_query($conn, $sql);


			$cena_netto_sprzedazy_eu[$i] = change($cena_netto_zakupu_eu[$i] + (($cena_netto_zakupu_eu[$i] * $nowa_marza_magazynu)/100));
			$sql = "update magazyn set cena_netto_sprzedazy_eu=".$cena_netto_sprzedazy_eu[$i]." WHERE id = ".$id[$i].";";
			mysqli_query($conn, $sql);
			}
		$cena_netto_sprzedazy_zl[$i] = change($cena_netto_zakupu_zl[$i] + (($cena_netto_zakupu_zl[$i] * $nowa_marza_magazynu)/100));
		$sql = "update magazyn set cena_netto_sprzedazy_zl=".$cena_netto_sprzedazy_zl[$i]." WHERE id = ".$id[$i].";";
		$ins=mysqli_query($conn, $sql);
		}
	echo '<div class="text_duzy_niebieski" align="center">Dane zostały zmienione.</div><br>';
	}


	$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'kurs_euro';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$kurs_euro=$wynik['opis'];
		}
		
	$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'marza_magazynu';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$marza_magazynu=$wynik['opis'];
		}
			
	$pytanie = mysqli_query($conn, "SELECT * FROM rozne WHERE typ = 'magazyn';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$numer=$wynik['opis'];
		}

	echo '<FORM action="index.php?page=ustawienia_magazyn&zmiana_danych=1" method="post">';
	echo '<table border="0" align="center" width="30%">';

		echo '<tr class="text"><td width="50%" align="right">Kurs Euro : </td>';
		echo '<td width="50%" align="left"><input type="text" size="6" maxlength="6" class="pole_input_right" autocomplete="off" name="nowy_kurs_euro" value="'.$kurs_euro.'"></td></tr>';
		echo '<tr class="text"><td align="right">Marża magazynu : </td>';
		echo '<td align="left"><input type="text" size="6" maxlength="6" class="pole_input_right" autocomplete="off" name="nowa_marza_magazynu" value="'.$marza_magazynu.'"></td></tr>';
		echo '<tr class="text"><td align="right">Numer zamówienia : </td>';
		echo '<td align="left"><input type="text" size="6" maxlength="6" class="pole_input_right" autocomplete="off" name="nowa_numer" value="'.$numer.'"></td></tr>';

	echo '<tr><td colspan="2" align="center"><br><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr>';
	echo '</table>';
	echo '</FORM>';

echo '</td></tr></table>';
?>