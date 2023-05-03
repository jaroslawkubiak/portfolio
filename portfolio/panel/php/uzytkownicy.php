<?php
echo '<div align="center"><a href="index.php?page=uzytkownicy_logowania">Logowania użytkowników</a></div><br>';
echo '<div align="center"><a href="index.php?page=uzytkownicy_czas_logowania&LIMIT=10">Czasy logowania użytkowników.</a></div><br>';
echo '<div align="center"><a href="index.php?page=stawka_podstawowa">Stawka podstawowa pracowników produkcji.</a></div><br>';
$i=0;

$uzytkownik_id = [];
$nazwa = [];
$imie = [];
$nazwisko = [];
$email = [];
$telefon = [];
$stanowisko = [];
$aktywny = [];

$pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy ORDER BY ID ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$uzytkownik_id[$i]=$wynik['id'];
	$nazwa[$i]=$wynik['nazwa'];
	$imie[$i]=$wynik['imie'];
	$nazwisko[$i]=$wynik['nazwisko'];
	$email[$i]=$wynik['email'];
	$telefon[$i]=$wynik['telefon'];
	$stanowisko[$i]=$wynik['stanowisko'];
	$aktywny[$i]=$wynik['aktywny'];
	}

$wybierz_kolor = 0;
echo '<table align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td width="5%">'.$kol_lp.'</td>';
echo '<td width="10%">'.$kol_login.'</td>';
echo '<td width="10%">'.$kol_imie.'</td>';
echo '<td width="10%">'.$kol_nazwisko.'</td>';
echo '<td width="20%">'.$kol_email.'</td>';
echo '<td width="10%">'.$kol_telefon.'</td>';
echo '<td width="10%">'.$kol_stanowisko.'</td>';
echo '<td width="10%">Aktywny</td></tr>';

	for ($x=2; $x<=$i; $x++)
		{
		if($aktywny[$x] == 'on') 
			{
			$aktywny[$x] = 'TAK'; 
			$kolor_tla_uzytkownicy = '#ffffff';
			}
		else 
			{
			$aktywny[$x] = 'NIE';
			$kolor_tla_uzytkownicy = '#cdcdcd';
			}

		echo '<tr class="text" align="center" bgcolor="'.$kolor_tla_uzytkownicy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
		echo '<td><a href="index.php?page=uzytkownicy_edycja&id='.$uzytkownik_id[$x].'"><font color="black">'.$nazwa[$x].'</font></a></td>';
		echo '<td>'.$imie[$x].'</td>';
		echo '<td>'.$nazwisko[$x].'</td>';
		echo '<td>'.$email[$x].'</td>';
		echo '<td>'.$telefon[$x].'</td>';
		echo '<td>'.$stanowisko[$x].'</td>';
		echo '<td>'.$aktywny[$x].'</td></tr>';
		}
echo '</table>';

?>