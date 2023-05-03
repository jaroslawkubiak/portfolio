<?php
//szukam iniciałów usera
$pytanie2 = mysqli_query($conn, "SELECT imie, nazwisko FROM uzytkownicy WHERE id = ".$user_id.";");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$imie=$wynik2['imie'];
	$nazwisko=$wynik2['nazwisko'];
	}

// pobieram kolejny numer wyceny wstepnej
$pytanie333 = mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'wycena_wstepna_nr';");
while($wynik333= mysqli_fetch_assoc($pytanie333))
	$kolejny_nr_wyceny=$wynik333['opis'];

if(($nazwisko != '') && ($imie != '') && ($imie[0] != '') && ($nazwisko[0] != '')) $wycena_wstepna_nr = $kolejny_nr_wyceny."/".$aktualny_rok."/".$imie[0].$nazwisko[0];
else $wycena_wstepna_nr = $kolejny_nr_wyceny."/".$aktualny_rok;

//szukam klientow
$ilosc_klientow = 0;
$klient_id = [];
$klient_nazwa = [];

$pytanie1 = mysqli_query($conn, "SELECT id, nazwa FROM klienci WHERE aktywny = 'on' ORDER BY nazwa ASC;");
while($wynik1= mysqli_fetch_assoc($pytanie1))
	{
	$ilosc_klientow++;
	$klient_id[$ilosc_klientow] = $wynik1['id'];
	$klient_nazwa[$ilosc_klientow]=$wynik1['nazwa'];
	}


// pobieram listę daty ważności
$ilosc_dat = 0;
$opis = [];
$pytanie = mysqli_query($conn, "SELECT opis FROM suwaki WHERE typ = 'wycena_wstepna_data_waznosci' ORDER BY id ASC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_dat++;
	$opis[$ilosc_dat]=$wynik['opis'];
	}

if($klient == '') $page = 'wycena_wstepna_dodaj'; else $page = 'wycena_dodaj';

echo '<FORM action="index.php?page='.$page.'&etap=2" method="post" id="szukaj">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
echo '<INPUT type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	
echo '<table align="left" width="500px" border="0">';
echo '<tr><td colspan="2">';
	echo '<div class="text_duzy" align="center">Nowa wycena wstępna</div>';
echo '</td></tr>';


if($klient == '')
	{
	echo '<tr align="center" class="text"><td align="right" width="50%" class="text">'.$kol_klient.' : </td><td align="left" width="50%">';
		echo '<select name="klient" class="pole_input" style="width: 100%" onchange="submit();">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_klientow; $k++) 
		if($klient == $klient_id[$k]) echo '<option selected="selected" value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
		else echo '<option value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';
	}
else
	{


	echo '<tr align="center" class="text"><td align="right" width="50%" class="text">'.$kol_klient.' : </td><td align="left" width="50%">';
		$pytanie12 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
		while($wynik12= mysqli_fetch_assoc($pytanie12))
			echo $klient_nazwa=$wynik12['nazwa'];
	echo '</td></tr>';
	
	//szukamy email klienta
	include("php/lista_emaili_wycena.php");
	echo '<tr align="center" class="text"><td align="right" width="50%" class="text">'.$kol_email.' : </td><td align="left" width="50%">';
		echo '<select name="email" class="pole_input" style="width: 100%">';
		for ($k=1; $k<=$ilosc_email; $k++) 
		if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		elseif($linia_rozdzielajaca == $klient_email[$k]) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
		else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';
	
	echo '<tr align="center" class="text"><td align="right" width="50%" class="text">Nr wyceny : </td><td align="left" width="50%">'.$wycena_wstepna_nr.'</td></tr>';
	
	echo '<tr align="center" class="text"><td align="right" width="50%" class="text">Data ważności : </td><td align="left" width="50%">';
		echo '<select name="data_waznosci" class="pole_input" style="width: 100px">';
		for ($k=1; $k<=$ilosc_dat; $k++) 
		echo '<option value="'.$opis[$k].'">'.$opis[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';
	
	echo '<tr align="center" class="text"><td align="right">Wycena ilość pozycji : </td><td align="left">';
	echo '<select name="ilosc_pozycji" class="pole_input" style="width: 100px">';
	for ($k=1; $k<=20; $k++) echo '<option value="'.$k.'">'.$k.'</option>';
	echo '</select>';
	echo '</td></tr>';

	echo '<tr align="center"><td width="100%" class="text" colspan="2"><INPUT type="submit" name="submit" value="Dalej"></td></tr>';
	}

echo '</table>';
echo '</form>';

?>