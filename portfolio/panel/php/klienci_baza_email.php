<?php
$ilosc_email = 0;
$TABELA_EMAILI = [];

if($zakres != '')
	{

	$pytanie3 = mysqli_query($conn, "SELECT * FROM klienci WHERE status_firmy = '".$zakres."'");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		if($wynik3['potwierdzenie_pvc_email'] != '') 
			{
			$ilosc_email++;
			$TABELA_EMAILI[$ilosc_email]=$wynik3['potwierdzenie_pvc_email'];
			}
		if($wynik3['potwierdzenie_alu_email'] != '') 
			{
			$ilosc_email++;
			$TABELA_EMAILI[$ilosc_email]=$wynik3['potwierdzenie_alu_email'];
			}
		}
	}
	

echo '<table width="1400px" align="left" border="0" cellpadding="3">';
echo '<FORM action="index.php?page=klienci_baza_email" method="post">';
	
	
	echo '<tr align="center"><td align="right" width="50%" class="text">Wybierz : </td><td align="left" width="50%">';
		$ilosc_status_firmy = 0;
		$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status_firmy' ORDER BY id ASC");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			{
			$ilosc_status_firmy++;
			$status_firmy_id[$ilosc_status_firmy] = $wynik3['id'];
			$status_firmy_opis[$ilosc_status_firmy] = $wynik3['opis'];
			}
		echo '<select name="zakres" class="pole_input" style="width: 250px" onchange="submit();">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_status_firmy; $k++) 
		if($zakres == $status_firmy_opis[$k]) echo '<option selected="selected" value="'.$status_firmy_opis[$k].'">'.$status_firmy_opis[$k].'</option>';
		else echo '<option value="'.$status_firmy_opis[$k].'">'.$status_firmy_opis[$k].'</option>';
	echo '</select></td></tr>';
	
	if($ilosc_email != '')
		{
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" ><td align="center" width="100%" class="text_duzy" colspan="2">';
			echo 'Znaleziono '.$ilosc_email.' adresów email.';
		echo '</td></tr>';
		}
		
	echo '<tr><td align="left" width="100%" class="text" colspan="2">';
		for ($k=1; $k<=$ilosc_email; $k++) echo $TABELA_EMAILI[$k].'; ';
	echo '</td></tr>';

echo '</table>';
echo '</form>';	

?>