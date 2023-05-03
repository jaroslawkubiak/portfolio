<?php

echo '<div align="center"><a href="index.php?page=uzytkownicy_czas_logowania&LIMIT=ALL">Pokaż wszystkie wpisy</a></div>';


$nazwa = [];
$imie = [];
$nazwisko = [];
$baza_user_id = [];
$baza_godzina_logowania = [];
$baza_godzina_wylogowania = [];
$baza_czas_log = [];

$pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy ORDER BY ID ASC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$uzytkownik_id=$wynik['id'];
	$nazwa[$uzytkownik_id]=$wynik['nazwa'];
	$imie[$uzytkownik_id]=$wynik['imie'];
	$nazwisko[$uzytkownik_id]=$wynik['nazwisko'];
	}


if($szukany_user != '') $WARUNEK = 'WHERE user_id = '.$szukany_user.''; else $WARUNEK = 'WHERE user_id != 1';

if($LIMIT == 'ALL') $sql = "SELECT * FROM logowania_uzytkownikow2 ".$WARUNEK." ORDER BY id DESC;";
else $sql = "SELECT * FROM logowania_uzytkownikow2 ".$WARUNEK." ORDER BY id DESC LIMIT ".$LIMIT.";";
$pytanie2 = mysqli_query($conn, $sql);
$i=0;
while($wynik= mysqli_fetch_assoc($pytanie2))
	{
	$i++;
	$baza_user_id[$i]=$wynik['user_id']; 
	$baza_godzina_logowania[$i]=$wynik['godzina_logowania']; 
	$baza_godzina_wylogowania[$i]=$wynik['godzina_wylogowania']; 
	$baza_czas_log[$i]=$wynik['czas_log']; 
	}

	echo '<table width="80%" align="center" class="tabela"><tr class="text" align="center" bgcolor="'.$kolor_tabeli.'">';
	echo '<td width="5%">LP';
	if($szukany_user != '') echo '<br><a href="index.php?page=uzytkownicy_czas_logowania&LIMIT='.$LIMIT.'">'.$image_close.'</a>';
	echo '</td>';
	echo '<td width="10%">Login</td>';
	echo '<td width="15%">Imię</td>';
	echo '<td width="15%">Nazwisko</td>';
	echo '<td width="10%">Data</td>';
	echo '<td width="15%">Godzina zalogowania</td>';
	echo '<td width="15%">Godzina wylogowania</td>';
	echo '<td width="15%">Czas zalogowania</td>';
	echo '</tr>';
	for ($x=1; $x<=$i; $x++)
	{        
		echo '<tr class="text" align="center" bgcolor="'.$kolor_bialy.'">';
		echo '<td bgcolor="'.$kolor_tabeli.'"><b>'.$x.'</b></td>';
		echo '<td><b><a href="index.php?page=uzytkownicy_czas_logowania&szukany_user='.$baza_user_id[$x].'&LIMIT='.$LIMIT.'">'.$nazwa[$baza_user_id[$x]].'</a></b></td>';
		echo '<td>'.$imie[$baza_user_id[$x]].'</td>';
		echo '<td>'.$nazwisko[$baza_user_id[$x]].'</td>';
		$data_logowania[$x] = date('d-m-Y', $baza_godzina_logowania[$x]);
		echo '<td>'.$data_logowania[$x].'</td>';
		
		$zal_godzina_logowania[$x] = date('G:i:s', $baza_godzina_logowania[$x]);
		echo '<td>'.$zal_godzina_logowania[$x].'</td>';
		
		
		if(($baza_godzina_wylogowania[$x] != 0) && (($baza_czas_log[$x] != 900)))
			{
			$zal_wylogowanie[$x] = date('G:i:s', $baza_godzina_wylogowania[$x]);
			echo '<td>'.$zal_wylogowanie[$x].'</td>';
			
			// obliczamy czas logowania
			$godziny = 0;
			$minuty = 0;
			$sekundy = 0;
			
			$czas_logowan = $baza_czas_log[$x];
			if($czas_logowan >= 3600 ) 
				{
				$godziny = $czas_logowan / 3600;
				$godziny = floor($godziny);
				$godziny_czas = $godziny * 3600;
				$czas_logowan = $czas_logowan - $godziny_czas;
				}
			
			if($czas_logowan >= 60 ) 
				{
				$minuty = $czas_logowan / 60;
				$minuty = floor($minuty);
				$minuty_czas = $minuty * 60;
				$czas_logowan = $czas_logowan - $minuty_czas;
				}
			if(($minuty == 0) && ($godziny == 0)) $sekundy = $czas_logowan;
			elseif(($minuty != 0) && ($godziny == 0)) $sekundy = $czas_logowan;
			else $sekundy = $baza_czas_log[$x] - $minuty_czas - $godziny_czas;
			
			echo '<td>';	
				$szer_kol = '30px';
				$szer_tabeli = 3*$szer_kol+20;
				echo '<table border="0" cellpadding="1" cellspacing="1" width="'.$szer_tabeli.'px" align="center" class="text"><tr align="center" class="text">';
				echo '<td width="'.$szer_kol.'">';
				if($godziny != 0) if($godziny <= 9) echo '0'.$godziny; else echo $godziny;
				echo '</td>';
				if($godziny != 0) echo '<td width="10px" align="center">:</td>'; else echo '<td width="10px" align="center">&nbsp;</td>';
				echo '<td width="'.$szer_kol.'">';
				if($minuty != 0)  if($minuty <= 9) echo '0'.$minuty; else echo $minuty;
				echo '</td>';
				if($minuty != 0) echo '<td width="10px" align="center">:</td>'; else echo '<td width="10px" align="center">&nbsp;</td>';
				echo '<td width="'.$szer_kol.'">';
				if($sekundy <= 9) echo '0'.$sekundy; else echo $sekundy;
				echo 's</td>';
				echo '</tr></table>';
			echo '</td>';		
				
			}
		elseif ($baza_czas_log[$x] == 900)
			{
			echo '<td colspan="2"><font color="red">NIE wylogowany poprawnie</font>';
			}
		else
			{
			echo '<td colspan="2"><font color="blue">ZALOGOWANY</font>';
			}
		echo '</tr>';
	} // do for
	echo '</table>';
?>